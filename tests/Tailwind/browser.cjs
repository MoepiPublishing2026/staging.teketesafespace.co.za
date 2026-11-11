// Run against tests/Tailwind/router.php, never the running application.
const { chromium } = require(process.env.PLAYWRIGHT_MODULE_PATH || 'playwright');
const fs = require('node:fs');
const path = require('node:path');
const assert = require('node:assert/strict');
const origin = process.env.PR234_ORIGIN || 'http://127.0.0.1:8794';
assert.match(origin, /^http:\/\/127\.0\.0\.1:\d+$/);
const evidence = process.env.PR234_EVIDENCE || '/evidence';
const baseline = process.env.PR234_BASELINE === '1';
const label = process.env.PR234_LABEL || (baseline ? 'before-alpine-fix' : 'final');
fs.mkdirSync(evidence, { recursive: true });
(async () => {
 const browser = await chromium.launch({headless:true});
 const report = {origin, label, testedCommit:process.env.PR234_COMMIT || 'working-tree', browser:browser.version(), checks:[], events:[]};
 let current = {};
 async function check(name, fn) {
  try { const detail = await fn(); report.checks.push({name,ok:true,detail}); console.log('PASS '+name); }
  catch(e) { report.checks.push({name,ok:false,error:e.message}); console.log('FAIL '+name+': '+e.message.split('\n')[0]); }
 }
 try {
 for (const [device, viewport] of [['desktop',{width:1440,height:1000}], ['mobile',{width:390,height:844}]]) {
  const context=await browser.newContext({viewport, isMobile:device==='mobile', deviceScaleFactor:1, hasTouch:device==='mobile'});
  const page=await context.newPage();
  page.setDefaultTimeout(12000);
  page.on('console',m=>report.events.push({...current,event:'console',level:m.type(),text:m.text()}));
  page.on('pageerror',e=>report.events.push({...current,event:'pageerror',text:e.message}));
  page.on('request',r=>{if(/tailwindcss|alpinejs/.test(r.url())) report.events.push({...current,event:'cdn-request',url:r.url()});});
  page.on('requestfailed',r=>report.events.push({...current,event:'requestfailed',url:r.url(),error:r.failure()?.errorText}));
  page.on('response',r=>{if(r.status()>=400 || /\/build\/|\/livewire\//.test(r.url())) report.events.push({...current,event:'response',url:r.url(),status:r.status(),contentType:r.headers()['content-type']});});
  async function visit(path) {
   current={device,path};
   const response=await page.goto(origin+path,{waitUntil:'domcontentloaded',timeout:30000});
   await page.waitForTimeout(1200);
   const state=await page.evaluate(()=>({
    title:document.title, hasLivewire:!!window.Livewire, hasAlpine:!!window.Alpine,
    fromLivewire:window.Alpine?.__fromLivewire === true,
    assets:[...document.querySelectorAll('link[rel="stylesheet"],script[src]')].map(e=>e.href||e.src),
    width:innerWidth,scrollWidth:document.documentElement.scrollWidth,
    error:document.body.innerText.slice(0,450),
   }));
   const unrelated = ['/__pr234/view/faq','/__pr234/view/admin.subscribe'].includes(path);
   report.checks.push({name:`${device} GET ${path}`,ok:response.status()===(unrelated?500:200),expectedUnrelatedFailure:unrelated,status:response.status(),state});
   return response;
  }
  for (const path of ['/', '/about-us','/secure-portal-auth-9x7/login','/check-status','/contact-us','/password/reset']) {
   await check(`${device} visit ${path}`,async()=>{ await visit(path); });
  }
  if (baseline) { await context.close(); continue; }
  await check(`${device} production asset HTTP responses`, async()=>{
   const manifest=JSON.parse(fs.readFileSync(path.resolve(__dirname,'../../public/build/manifest.json'),'utf8'));
   for(const [entry,chunk] of Object.entries(manifest)){
    const response=await context.request.get(origin+'/build/'+chunk.file);
    assert.equal(response.status(),200);
    assert.match(response.headers()['content-type'],entry.endsWith('.css')?/text\/css/:/(?:application|text)\/javascript/);
    assert.ok((await response.body()).length>1000);
   }
  });
  await check(`${device} Alpine mobile menu`,async()=>{
   await visit('/');
   await page.waitForFunction(()=>!!window.Alpine && !!document.querySelector('#main-landing-container')?._x_dataStack);
   if(device==='mobile') {
    await page.locator('button[\\@click="menuOpen = !menuOpen"]').click();
    await page.waitForFunction(()=>Alpine.$data(document.querySelector('#main-landing-container')).menuOpen===true);
    await page.locator('button[\\@click="menuOpen = false"]').click();
    await page.waitForFunction(()=>Alpine.$data(document.querySelector('#main-landing-container')).menuOpen===false);
   }
   await page.screenshot({path:`${evidence}/${device}-landing.png`,fullPage:true});
   const state = await page.evaluate(()=>({livewireAlpine:Alpine.__fromLivewire,flex:getComputedStyle(document.querySelector('#main-landing-container')).display}));
   assert.equal(state.livewireAlpine,true); assert.equal(state.flex,'flex'); return state;
  });
  await check(`${device} Livewire landing redirect`,async()=>{
   await visit('/');
   await page.locator('[wire\\:click="redirectToStatusCheck"]').click();
   await page.waitForURL('**/check-status');
   assert.ok(await page.locator('#caseNumber').isVisible());
  });
  await check(`${device} Livewire status validation and Alpine dismiss`,async()=>{
   await visit('/check-status');
   await page.locator('#caseNumber').fill('PR234-NO-SUCH-CASE');
   const response=page.waitForResponse(r=>r.url().includes('/livewire/update')&&r.request().method()==='POST');
   await page.locator('form[wire\\:submit\\.prevent="checkStatus"] button[type="submit"]').click();
   assert.equal((await response).status(),200);
   await page.getByText('No report found with the provided case number.',{exact:false}).waitFor();
   const popup=page.locator('[x-data="{ open: true }"]');
   await popup.locator('button').click();
   await popup.waitFor({state:'hidden'});
  });
  await check(`${device} Livewire login validation`,async()=>{
   await visit('/secure-portal-auth-9x7/login');
   // Bypass native required-field validation, not the server's Livewire validation.
   await page.locator('form[wire\\:submit\\.prevent="login"]').evaluate(f=>{f.noValidate=true;f.requestSubmit();});
   await page.getByText('The username field is required.',{exact:false}).waitFor();
  });
  await check(`${device} authenticated OTP verification`,async()=>{
   await visit('/__pr234/session');
   for(let i=0;i<6;i++) await page.locator(`#otp-${i}`).fill(String(i+1));
   await page.locator('form[wire\\:submit\\.prevent="login"] button[type="submit"]').click();
   await page.waitForURL('**/admin/dashboard');
   await page.screenshot({path:`${evidence}/${device}-admin-dashboard.png`,fullPage:true});
  });
  for(const path of ['/admin/dashboard','/admin/settings','/admin/reports']) {
   await check(`${device} authenticated ${path}`,async()=>{
    const r=await visit(path); assert.equal(r.status(),200); assert.ok(!page.url().includes('login'));
   });
  }
  await check(`${device} authenticated Livewire settings validation`,async()=>{
   await visit('/admin/settings');
   await page.getByPlaceholder('Your full name').fill('');
   await page.locator('form[wire\\:submit\\.prevent="updateSettings"]').evaluate(f=>{f.noValidate=true;f.requestSubmit();});
   await page.getByText(/full name field is required/i).waitFor();
   await page.screenshot({path:`${evidence}/${device}-admin-settings.png`,fullPage:true});
  });
  await check(`${device} authenticated Livewire profile save`,async()=>{
   await visit('/admin/settings');
   const name = device==='desktop' ? 'Fictional Desktop Admin' : 'Fictional Mobile Admin';
   await page.getByPlaceholder('Your full name').fill(name);
   const response=page.waitForResponse(r=>r.url().includes('/livewire/update')&&r.request().method()==='POST');
   await page.locator('form[wire\\:submit\\.prevent="updateSettings"] button[type="submit"]').click();
   assert.equal((await response).status(),200);
   await page.getByText('Settings updated successfully!',{exact:false}).first().waitFor();
   await page.reload({waitUntil:'domcontentloaded'});
   assert.equal(await page.getByPlaceholder('Your full name').inputValue(),name);
  });
  await check(`${device} authenticated Livewire report filters`,async()=>{
   await visit('/admin/reports');
   await page.locator('[wire\\:model\\.live\\.debounce\\.350ms="search"]').fill('Fictional');
   await page.waitForResponse(r=>r.url().includes('/livewire/update')&&r.request().method()==='POST');
   await page.locator('#refreshBtn').click();
   await page.waitForFunction(()=>document.querySelector('[wire\\:model\\.live\\.debounce\\.350ms="search"]').value==='');
  });
  for(const view of ['auth.passwords.email','admin.settings','faq','admin.subscribe','admin.checkout']) {
   await check(`${device} unrouted template probe ${view}`,async()=>{ await visit('/__pr234/view/'+view); });
  }
  await page.screenshot({path:`${evidence}/${device}-last-page.png`,fullPage:true});
  await context.close();
 }
 } finally {
  await browser.close();
  report.summary={checks:report.checks.length,failedChecks:report.checks.filter(c=>!c.ok).map(c=>c.name),cdnRequests:report.events.filter(e=>e.event==='cdn-request').length,pageErrors:report.events.filter(e=>e.event==='pageerror').length,duplicateAlpine:report.events.filter(e=>/multiple instances of Alpine|already been initialized/.test(e.text||'')).length};
  const badAssets=report.events.filter(e=>e.event==='response'&&e.url.includes('/build/')&&e.status!==200);
  const unexpectedErrors=report.events.filter(e=>e.event==='pageerror'&&e.text!=='isMobile is not defined');
  report.summary.unexpectedPageErrors=unexpectedErrors.length; report.summary.badAssetResponses=badAssets.length;
  if(report.summary.failedChecks.length||report.summary.cdnRequests||report.summary.duplicateAlpine||badAssets.length||unexpectedErrors.length) process.exitCode=1;
  fs.writeFileSync(`${evidence}/${label}.json`,JSON.stringify(report,null,2));
  console.log(JSON.stringify(report.summary,null,2));
 }
})().catch(e=>{console.error(e);process.exitCode=1;});

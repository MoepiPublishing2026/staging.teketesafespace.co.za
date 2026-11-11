// Run only against a read-only checkout of the PR base with its own fixture runtime.
const {chromium}=require(process.env.PLAYWRIGHT_MODULE_PATH || 'playwright');
const fs=require('node:fs');
const assert=require('node:assert/strict');
const origin=process.env.PR234_ORIGIN || 'http://127.0.0.1:8795';
assert.match(origin,/^http:\/\/127\.0\.0\.1:\d+$/);
(async()=>{
 const browser=await chromium.launch();
 const report={commit:process.env.PR234_COMMIT,events:[],probes:[]};
 try {
  for(const device of ['desktop','mobile']) {
   const context=await browser.newContext({viewport:device==='desktop'?{width:1440,height:1000}:{width:390,height:844}});
   const page=await context.newPage(); let path='';
   page.on('pageerror',e=>report.events.push({device,path,type:'pageerror',text:e.message}));
   page.on('response',r=>{if(r.status()>=400)report.events.push({device,path,type:'response',url:r.url(),status:r.status()});});
   path='/__pr234/session'; await page.goto(origin+path,{waitUntil:'domcontentloaded'});
   for(let i=0;i<6;i++)await page.locator(`#otp-${i}`).fill(String(i+1));
   await page.locator('form[wire\\:submit\\.prevent="login"] button[type="submit"]').click();
   await page.waitForURL('**/admin/dashboard'); await page.waitForTimeout(1500);
   await page.goto(origin+'/about-us',{waitUntil:'domcontentloaded'}); await page.waitForTimeout(1000);
   for(const view of ['faq','auth.passwords.email','admin.subscribe']) {
    path='/__pr234/view/'+view;
    const response=await page.goto(origin+path,{waitUntil:'domcontentloaded'});
    report.probes.push({device,path,status:response.status()});
   }
   await context.close();
  }
 }finally{
  await browser.close();
  fs.writeFileSync('/evidence/base-comparison.json',JSON.stringify(report,null,2));
  console.log(JSON.stringify(report,null,2));
 }
})().catch(e=>{console.error(e);process.exitCode=1;});

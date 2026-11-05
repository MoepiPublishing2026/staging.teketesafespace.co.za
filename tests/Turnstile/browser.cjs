// Real Edge/Chromium, Blade, Livewire/Alpine and Cloudflare script; no Siteverify.
// Requires an already installed Playwright module; no dependency installation here.
const { chromium } = require(process.env.PLAYWRIGHT_MODULE_PATH || 'playwright');
const { spawn } = require('node:child_process');
const net = require('node:net');
const path = require('node:path');
const assert = require('node:assert/strict');
const root = path.resolve(__dirname, '../..');
const selector = '[wire\\:key="report-turnstile"]';
const sitekey = process.env.REPORT_WIDGET_BROWSER_SITE_KEY || '1x00000000000000000000AA';
const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));

(async () => {
    const reservation = net.createServer();
    await new Promise(resolve => reservation.listen(0, '127.0.0.1', resolve));
    const port = reservation.address().port;
    await new Promise(resolve => reservation.close(resolve));
    const origin = `http://127.0.0.1:${port}`;
    const server = spawn(process.env.PHP_BINARY || 'php', ['-S', `127.0.0.1:${port}`, 'tests/turnstile-browser-router.php'], {
        cwd: root, windowsHide: true, stdio: 'ignore',
        env: { ...process.env, REPORT_WIDGET_BROWSER_TEST: '1', REPORT_WIDGET_BROWSER_SITE_KEY: sitekey },
    });
    let browser, page, stage = 'startup';
    const network = { apiRequests: 0, apiResponses: 0, apiFailures: 0 };
    try {
        let available = false;
        for (let i = 0; i < 50; i++) {
            try { available = (await fetch(origin + '/report-form/1/anonymous')).ok; } catch {}
            if (available) break;
            await sleep(100);
        }
        assert.ok(available, 'Isolated browser fixture failed to start');
        browser = await chromium.launch({ headless: true,
            ...(process.env.BROWSER_EXECUTABLE ? { executablePath: process.env.BROWSER_EXECUTABLE } : {}),
        });
        page = await browser.newPage();
        const failures = [];
        let scriptResponses = 0, iframeResponses = 0, blockedRequests = 0, blockScript = false;
        page.on('console', message => {
            if (/turnstile\.ready\(\)|Invalid type for parameter sitekey/.test(message.text())) failures.push('provider initialization error');
        });
        page.on('pageerror', () => failures.push('browser JavaScript error'));
        page.on('request', request => {
            if (request.resourceType() === 'script' && new URL(request.url()).hostname === 'challenges.cloudflare.com') network.apiRequests++;
        });
        page.on('requestfailed', request => {
            if (request.resourceType() === 'script' && new URL(request.url()).hostname === 'challenges.cloudflare.com') network.apiFailures++;
        });
        page.on('response', response => {
            const request = response.request();
            if (new URL(response.url()).hostname !== 'challenges.cloudflare.com' || response.status() !== 200) return;
            if (request.resourceType() === 'script') { scriptResponses++; network.apiResponses++; }
            if (request.resourceType() === 'document') iframeResponses++;
        });
        // Abort only the initial API download for the failure/retry scenario.
        // Successful requests always reach Cloudflare; no provider response mocks.
        await page.route('https://challenges.cloudflare.com/turnstile/v0/api.js*', route => {
            if (blockScript) { blockedRequests++; return route.abort(); }
            return route.continue();
        });
        async function widgetLoaded() {
            await page.waitForFunction(selector => {
                const element = document.querySelector(selector);
                const data = element && window.Alpine?.$data(element);
                return data && data.widget !== null && !data.loading && !data.failed;
            }, selector, { timeout: 30000 });
            await page.waitForFunction(selector => {
                const host = document.querySelector(selector)?.querySelector('[data-turnstile-host]');
                return host && host.getBoundingClientRect().height >= 65;
            }, selector, { timeout: 30000 });
            const state = await page.evaluate(({ selector, sitekey }) => {
                const element = document.querySelector(selector);
                const scripts = [...document.scripts].filter(script => script.src.includes('challenges.cloudflare.com/turnstile/'));
                const submit = document.querySelector('button[type="submit"]');
                return {
                    keyMatches: element.dataset.sitekey === sitekey,
                    explicitOnly: document.querySelectorAll('.cf-turnstile').length === 0
                        && scripts.length === 1 && scripts[0].src.includes('render=explicit')
                        && scripts[0].src.includes('onload=reportTurnstileOnload'),
                    aboveSubmit: element.getBoundingClientRect().bottom <= submit.getBoundingClientRect().top,
                };
            }, { selector, sitekey });
            assert.ok(state.keyMatches, 'DOM site key must match the configured public key');
            assert.ok(state.explicitOnly, 'Only one explicit provider script must be present');
            assert.ok(state.aboveSubmit, 'Widget must be immediately above Submit');
            assert.equal(failures.length, 0, 'No readiness, site-key or JavaScript errors');
        }
        stage = 'initial';
        await page.goto(origin + '/report-form/1/anonymous', { waitUntil: 'domcontentloaded' });
        await widgetLoaded();
        console.log('Real browser: initial load, root key transfer and explicit widget placement passed.');
        stage = 'reload';
        await page.reload({ waitUntil: 'domcontentloaded' });
        await widgetLoaded();
        console.log('Real browser: reload passed.');
        stage = 'blocked script retry';
        blockScript = true;
        await page.reload({ waitUntil: 'domcontentloaded' });
        const retry = page.getByRole('button', { name: 'Retry verification' });
        await retry.waitFor({ state: 'visible', timeout: 20000 });
        await page.evaluate(selector => {
            const element = document.querySelector(selector);
            window.Alpine.$data(element).$wire.set('description', 'Fictional browser draft', false);
        }, selector);
        blockScript = false;
        await retry.click();
        await widgetLoaded();
        const preserved = await page.evaluate(selector => window.Alpine.$data(document.querySelector(selector)).$wire.get('description') === 'Fictional browser draft', selector);
        assert.ok(preserved, 'Retry must preserve the deferred draft');
        assert.equal(blockedRequests, 1, 'One deliberately blocked download must exercise real Retry');
        console.log('Real browser: blocked script, visible Retry click, real provider recovery and draft preservation passed.');
        stage = 'mobile';
        await page.setViewportSize({ width: 375, height: 812 });
        await sleep(500);
        await widgetLoaded();
        const frame = page.frames().find(frame => {
            try { return new URL(frame.url()).hostname === 'challenges.cloudflare.com'; } catch { return false; }
        });
        assert.ok(frame, 'Cloudflare iframe must have navigated');
        await frame.waitForLoadState('domcontentloaded', { timeout: 30000 });
        // Cloudflare owns opaque/shadow DOM. Inspect the captured screenshot,
        // rather than asserting undocumented provider body text/selectors.
        await sleep(1500);
        await widgetLoaded();
        await page.locator(selector).screenshot({ path: path.join(root, 'tests/.runtime/widget-mobile.png') });
        assert.ok(scriptResponses >= 3, 'Real Cloudflare API responses must be observed');
        assert.ok(iframeResponses > 0, 'Real Cloudflare iframe responses must be observed');
        console.log(`Real browser: mobile passed; Cloudflare HTTP 200 scripts=${scriptResponses}, iframe documents=${iframeResponses}. No Siteverify or report submissions.`);
    } catch (error) {
        const state = page && await page.evaluate(selector => {
            const element = document.querySelector(selector);
            const data = element && window.Alpine?.$data(element);
            const host = element?.querySelector('[data-turnstile-host]');
            return { rootPresent: !!element, keyPresent: !!element?.dataset.sitekey,
                widgetPresent: !!data && data.widget !== null, failed: data?.failed, loading: data?.loading,
                hostWidth: host?.getBoundingClientRect().width, hostHeight: host?.getBoundingClientRect().height };
        }, selector).catch(() => null);
        console.error(JSON.stringify({ stage, state, network }));
        throw error;
    } finally {
        if (browser) await browser.close();
        server.kill();
    }
})().catch(error => {
    // Avoid dumping browser HTML, keys, tokens or form contents on failure.
    console.error('Browser widget check failed: ' + error.name + (error.code ? ' (' + error.code + ')' : ''));
    process.exitCode = 1;
});

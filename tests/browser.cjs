// Uses temporary Playwright tooling under the ignored runtime directory.
// The actual application/Blade/Livewire/Alpine code runs; Cloudflare is stubbed
// for deterministic lifecycle testing, not represented as a real challenge.
const { chromium } = require(process.env.REPORT_TEST_PLAYWRIGHT || './.runtime/browser/node_modules/playwright');
const assert = require('node:assert/strict');

(async () => {
    const browser = await chromium.launch({
        executablePath: process.env.REPORT_TEST_CHROMIUM,
        headless: true,
    });
    try {
        for (const width of [1280, 320]) {
            const page = await browser.newPage({ viewport: { width, height: 900 } });
            const errors = [];
            page.on('pageerror', error => errors.push(error.message));
            if (process.env.REPORT_TEST_REAL_TURNSTILE === '1') {
                await page.goto('http://127.0.0.1:8871/report-form/1/anonymous', { waitUntil: 'domcontentloaded', timeout: 60000 });
                await page.waitForFunction(() => {
                    const submit = document.querySelector('button[type="submit"]');
                    return window.turnstile && window.turnstile.getResponse() && submit && !submit.disabled;
                }, { timeout: 30000 });
                await page.waitForTimeout(1500);
                await page.screenshot({ path: `tests/.runtime/real-turnstile-${width}.png`, fullPage: true });
                console.log(`Official dummy Turnstile ${width}px: real widget rendered and verification callback enabled Submit.`);
                await page.close();
                continue;
            }
            await page.route('https://challenges.cloudflare.com/turnstile/v0/api.js*', route => route.fulfill({
                contentType: 'application/javascript', body: `
                window.widgetTest = { renders: 0, resets: 0, removes: 0 };
                window.turnstile = {
                    render(container, options) {
                        if (window.widgetTest.failNextRender) { window.widgetTest.failNextRender = false; throw new Error('test render failure'); }
                        window.widgetTest.renders++;
                        window.widgetTest.options = options;
                        window.widgetTest.size = options.size;
                        const button = document.createElement('button');
                        button.type = 'button'; button.textContent = 'Test verification';
                        button.onclick = () => options.callback('browser-token');
                        container.append(button); window.widgetTest.container = container;
                        return 0;
                    },
                    reset() { window.widgetTest.resets++; },
                    remove() { window.widgetTest.removes++; window.widgetTest.container.replaceChildren(); }
                };`,
            }));
            await page.goto('http://127.0.0.1:8871/report-form/1/anonymous', { waitUntil: 'domcontentloaded', timeout: 60000 });
            const challenge = page.getByRole('button', { name: 'Test verification' });
            await challenge.waitFor();
            const submit = page.getByRole('button', { name: 'Submit', exact: true });
            assert.equal(await submit.isDisabled(), true);
            const challengeBox = await challenge.boundingBox();
            const submitBox = await submit.boundingBox();
            assert(challengeBox.y + challengeBox.height <= submitBox.y, 'Widget must be above Submit');
            assert(submitBox.x >= 0 && submitBox.x + submitBox.width <= width, 'Submit must fit mobile viewport');
            await page.locator('#reporterEmail').fill('preserved@example.com');
            await challenge.click();
            assert.equal(await submit.isDisabled(), false);
            await page.locator('#subtypeID').selectOption('1');
            await page.waitForTimeout(750);
            assert.equal(await page.evaluate(() => window.widgetTest.renders), 1, 'No duplicate widget after Livewire morph');
            await page.evaluate(() => window.widgetTest.options['expired-callback']());
            assert.equal(await submit.isDisabled(), true);
            assert.equal(await page.locator('#reporterEmail').inputValue(), 'preserved@example.com');
            assert.equal(await page.evaluate(() => window.widgetTest.resets), 1);
            await challenge.click();
            await submit.click();
            await page.waitForTimeout(750);
            assert.equal(await page.locator('#reporterEmail').inputValue(), 'preserved@example.com');
            assert.equal(await page.evaluate(() => window.widgetTest.renders), 1);
            await page.evaluate(() => window.widgetTest.options['error-callback']());
            assert.equal(await submit.isDisabled(), true);
            await page.getByRole('button', { name: 'Retry verification' }).click();
            assert.equal(await page.evaluate(() => window.widgetTest.resets), 2);
            if (width === 320) assert.equal(await page.evaluate(() => window.widgetTest.size), 'compact');
            assert.deepEqual(errors, [], 'Browser must have no JavaScript errors');
            await page.screenshot({ path: `tests/.runtime/report-form-${width}.png`, fullPage: true });
            if (width === 1280) {
                await page.setViewportSize({ width: 320, height: 900 });
                await page.waitForFunction(() => window.widgetTest.size === 'compact');
                assert.equal(await page.evaluate(() => window.widgetTest.renders), 2);
                assert.equal(await page.locator('#reporterEmail').inputValue(), 'preserved@example.com');
                assert.equal(await submit.isDisabled(), true);
                await page.evaluate(() => { window.widgetTest.failNextRender = true; });
                await page.setViewportSize({ width: 1280, height: 900 });
                await page.getByRole('button', { name: 'Retry verification' }).waitFor({ state: 'visible' });
                await page.getByRole('button', { name: 'Retry verification' }).click();
                await challenge.waitFor();
                assert.equal(await page.locator('#reporterEmail').inputValue(), 'preserved@example.com');
                assert.deepEqual(errors, [], 'Render failure must be recoverable without JavaScript errors');
            }
            console.log(`Browser ${width}px: placement, mobile fit, morph, expiry, error/reset, responsive resize and input preservation passed.`);
            await page.close();
        }
    } finally {
        await browser.close();
    }
})().catch(error => { console.error(error); process.exit(1); });

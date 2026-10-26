// Provider/DOM stubs only. Real-browser checks are separate.
const vm = require('node:vm');
const fs = require('node:fs');
const assert = require('node:assert/strict');
const source = fs.readFileSync('public/js/report-turnstile.js', 'utf8');
const tick = () => new Promise(resolve => setImmediate(resolve));

function environment(provider) {
    const scripts = [], timers = new Map();
    let sequence = 0;
    const context = {
        window: provider ? { turnstile: provider } : {},
        document: {
            createElement() { return { remove() { this.removed = true; } }; },
            head: { append(script) { scripts.push(script); } },
        },
        setTimeout(callback) { timers.set(++sequence, callback); return sequence; },
        clearTimeout(id) { timers.delete(id); },
    };
    vm.createContext(context);
    vm.runInContext(source, context);
    function widget(sitekey = 'fixture-site') {
        const changes = [], host = {};
        const root = { dataset: { sitekey }, clientWidth: 600, querySelector: () => host };
        const data = context.window.reportTurnstile({ set(...args) { changes.push(args); } }, root);
        // Emulate Alpine's button context: it has no site key/refs.
        data.$el = { dataset: {}, clientWidth: 0 };
        return { data, root, host, changes };
    }
    return { context, scripts, timers, widget };
}

(async () => {
    let options, renders = 0, resets = 0, removes = 0, failRender = false;
    const provider = {
        ready() { assert.fail('Async provider must use its onload callback, never ready()'); },
        render(host, settings) {
            if (failRender) throw Error('render');
            assert.equal(typeof settings.sitekey, 'string');
            assert.equal(settings.sitekey, 'fixture-site');
            options = settings; renders++; return 'widget-' + renders;
        },
        reset() { resets++; },
        remove() { removes++; },
    };
    const loaded = environment(provider);
    const { data, root, changes } = loaded.widget();
    await data.init();
    assert.equal(renders, 1);
    assert.equal(options.action, 'report_submit');
    options.callback('fixture-token');
    assert.deepEqual(changes.at(-1), ['turnstileToken', 'fixture-token', false]);
    await data.retry();
    assert.equal(renders, 1, 'Retained Alpine instance must not duplicate the widget');
    assert.equal(resets, 1);
    options['expired-callback']();
    options['timeout-callback']();
    assert.equal(resets, 3);
    options['error-callback']();
    assert.equal(data.failed, true);
    await data.retry();
    assert.equal(data.failed, false);
    root.clientWidth = 260;
    data.resize(); await tick();
    assert.equal(options.size, 'compact');
    assert.equal(renders, 2);
    assert.equal(removes, 1);
    failRender = true;
    root.clientWidth = 600;
    data.resize(); await tick();
    assert.equal(data.failed, true);
    failRender = false;
    await data.retry();
    assert.equal(data.failed, false);
    data.destroy();
    const previous = renders, writes = changes.length;
    options.callback('late-fixture-token'); options['error-callback'](); options['expired-callback']();
    await data.retry();
    assert.equal(changes.length, writes);
    assert.equal(renders, previous);

    const delayed = environment();
    const first = delayed.widget(), removed = delayed.widget();
    const firstInit = first.data.init(), removedInit = removed.data.init();
    await first.data.retry();
    assert.equal(delayed.scripts.length, 1, 'Share pending script loading across instances/retries');
    assert.match(delayed.scripts[0].src, /render=explicit&onload=reportTurnstileOnload/);
    assert.equal(delayed.scripts[0].async, true);
    delayed.context.window.turnstile = provider;
    assert.equal(renders, previous, 'API existence alone must not bypass a pending onload callback');
    removed.data.destroy();
    delayed.context.window.reportTurnstileOnload();
    await Promise.all([firstInit, removedInit]);
    assert.equal(renders, previous + 1);
    assert.equal(delayed.timers.size, 0);
    first.data.destroy();

    const failure = environment();
    const retry = failure.widget();
    const failedInit = retry.data.init();
    failure.scripts[0].onerror();
    await failedInit;
    assert.equal(retry.data.failed, true);
    assert.equal(failure.scripts[0].removed, true);
    const retryInit = retry.data.retry();
    assert.equal(failure.scripts.length, 2);
    failure.context.window.turnstile = provider;
    failure.context.window.reportTurnstileOnload();
    await retryInit;
    assert.equal(retry.data.failed, false, 'Retry from a button must use the captured root site key');
    retry.data.destroy();

    const stalled = environment();
    const unavailable = stalled.widget();
    const waiting = unavailable.data.init();
    [...stalled.timers.values()][0]();
    await waiting;
    assert.equal(unavailable.data.failed, true);
    assert.equal(unavailable.data.loading, false);
    assert.deepEqual(unavailable.changes.at(-1), ['turnstileToken', '', false]);
    for (const invalid of ['', null, 123]) {
        const broken = loaded.widget(invalid);
        await broken.data.init();
        assert.equal(broken.data.failed, true, 'Do not pass a missing/non-string key to Cloudflare');
    }
    console.log('Widget lifecycle passed: callback loader, root key capture, concurrent loading, error/retry, timeout, expiry, mobile resize and disposal. Provider/DOM mocked.');
})().catch(error => { console.error(error); process.exitCode = 1; });

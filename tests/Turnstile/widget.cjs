// Provider/DOM stubs only: no server, browser, network or real CAPTCHA tokens.
const vm = require('node:vm');
const fs = require('node:fs');
const assert = require('node:assert/strict');
const context = { window: {}, setTimeout, clearTimeout };
vm.createContext(context);
vm.runInContext(fs.readFileSync('public/js/report-turnstile.js', 'utf8'), context);
(async () => {
    let options, renders = 0, resets = 0, removes = 0, failRender = false;
    context.window.turnstile = {
        ready(callback) { callback(); },
        render(container, settings) { if (failRender) throw Error('render'); options = settings; renders++; return 0; },
        reset() { resets++; },
        remove() { removes++; },
    };
    const changes = [];
    const widget = context.window.reportTurnstile({ set(...args) { changes.push(args); } });
    widget.$el = { dataset: { sitekey: 'test-site' }, clientWidth: 600 };
    widget.$refs = { challenge: {} };
    await widget.init();
    assert.equal(renders, 1);
    assert.equal(options.action, 'report_submit');
    options.callback('stub-token');
    assert.deepEqual(changes.at(-1), ['turnstileToken', 'stub-token', false]);
    // A morph retains the same Alpine instance and wire:ignore host.
    await widget.retry();
    assert.equal(renders, 1);
    assert.equal(resets, 1);
    options['expired-callback']();
    options['timeout-callback']();
    assert.equal(resets, 3);
    assert.equal(changes.at(-1)[1], '');
    options['error-callback']();
    assert.equal(widget.failed, true);
    await widget.retry();
    assert.equal(widget.failed, false);
    widget.$el.clientWidth = 260;
    widget.resize();
    await new Promise(resolve => setImmediate(resolve));
    assert.equal(options.size, 'compact');
    assert.equal(renders, 2);
    assert.equal(removes, 1);
    failRender = true;
    widget.$el.clientWidth = 600;
    widget.resize();
    await new Promise(resolve => setImmediate(resolve));
    assert.equal(widget.failed, true);
    failRender = false;
    await widget.retry();
    assert.equal(widget.failed, false);
    widget.destroy();
    const previous = renders;
    const writes = changes.length;
    options.callback('late-stub-token');
    options['error-callback']();
    options['expired-callback']();
    assert.equal(changes.length, writes, 'Disposed widget callbacks must not change Livewire state');
    await widget.retry();
    assert.equal(renders, previous);
    // A pending provider must not render early or duplicate on repeated Retry clicks.
    let ready;
    context.window.turnstile.ready = callback => { ready = callback; };
    const pending = context.window.reportTurnstile({ set() {} });
    pending.$el = widget.$el;
    pending.$refs = widget.$refs;
    const initialization = pending.init();
    await pending.retry();
    assert.equal(renders, previous);
    ready();
    await initialization;
    assert.equal(renders, previous + 1);
    pending.destroy();
    const removed = context.window.reportTurnstile({ set() { assert.fail('Destroyed widget changed Livewire state'); } });
    removed.$el = widget.$el;
    removed.$refs = widget.$refs;
    const waiting = removed.init();
    removed.destroy();
    ready();
    await waiting;
    assert.equal(renders, previous + 1, 'Destroyed widget must not render after provider becomes ready');
    // A provider that never becomes ready must offer recovery and clear the token.
    let timeout;
    const timeoutChanges = [];
    const stalled = {
        window: { turnstile: { ready() {} } },
        setTimeout(callback) { timeout = callback; return 1; },
        clearTimeout() {},
    };
    vm.createContext(stalled);
    vm.runInContext(fs.readFileSync('public/js/report-turnstile.js', 'utf8'), stalled);
    const unavailable = stalled.window.reportTurnstile({ set(...args) { timeoutChanges.push(args); } });
    unavailable.$el = widget.$el;
    unavailable.$refs = widget.$refs;
    const loading = unavailable.init();
    timeout();
    await loading;
    assert.equal(unavailable.failed, true);
    assert.equal(unavailable.loading, false);
    assert.deepEqual(timeoutChanges.at(-1), ['turnstileToken', '', false]);
    console.log('Widget lifecycle passed: expiry, timeout, error/retry, retained instance, mobile resizing, render failure, delayed readiness, overlapping retries and disposal. Provider/DOM mocked; no browser or server started.');
})().catch(error => { console.error(error); process.exitCode = 1; });

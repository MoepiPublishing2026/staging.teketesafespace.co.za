// Livewire owns Alpine. Explicit rendering has one shared provider-script loader.
(() => {
let loading;
function loadProvider() {
    if (loading) return loading;
    if (typeof window.turnstile?.render === 'function') return Promise.resolve(window.turnstile);
    loading = new Promise((resolve, reject) => {
        const script = document.createElement('script');
        let finished = false;
        const fail = () => {
            if (finished) return;
            finished = true;
            clearTimeout(timer);
            script.remove();
            reject(new Error('Verification unavailable'));
        };
        const timer = setTimeout(fail, 12000);
        // Cloudflare calls this after initialization. ready() rejects async scripts.
        window.reportTurnstileOnload = () => {
            if (finished) return;
            if (typeof window.turnstile?.render !== 'function') { fail(); return; }
            finished = true;
            clearTimeout(timer);
            resolve(window.turnstile);
        };
        script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=reportTurnstileOnload';
        script.async = true;
        script.onerror = fail;
        document.head.append(script);
    }).catch(error => { loading = null; throw error; });
    return loading;
}

window.reportTurnstile = function (wire, root) {
    // Capture the root once: Alpine's $el is the Retry button in click handlers.
    const sitekey = root.dataset.sitekey;
    const action = root.dataset.action || 'report_submit';
    const challenge = root.querySelector('[data-turnstile-host]');
    return {
        widget: null, failed: false, size: null, disposed: false, loading: false,
        async init() { await this.retry(); },
        async retry() {
            if (this.disposed || this.loading) return;
            this.loading = true;
            this.failed = false;
            try {
                if (typeof sitekey !== 'string' || !sitekey.trim() || !challenge) {
                    throw new Error('Verification configuration unavailable');
                }
                const provider = await loadProvider();
                if (this.disposed) return;
                if (this.widget !== null) { this.reset(); return; }
                this.size = root.clientWidth < 300 ? 'compact' : 'flexible';
                this.widget = provider.render(challenge, {
                    sitekey, action, size: this.size,
                    callback: token => { if (this.disposed) return; this.failed = false; wire.set('turnstileToken', token, false); },
                    'expired-callback': () => this.reset(),
                    'timeout-callback': () => this.reset(),
                    'error-callback': () => { if (this.disposed) return; wire.set('turnstileToken', '', false); this.failed = true; },
                });
            } catch { if (!this.disposed) { this.failed = true; wire.set('turnstileToken', '', false); } }
            finally { this.loading = false; }
        },
        reset() {
            if (this.disposed) return;
            wire.set('turnstileToken', '', false);
            try { if (this.widget !== null && window.turnstile) window.turnstile.reset(this.widget); }
            catch { this.failed = true; }
        },
        resize() {
            const size = root.clientWidth < 300 ? 'compact' : 'flexible';
            if (this.widget !== null && size !== this.size) {
                wire.set('turnstileToken', '', false);
                try { window.turnstile.remove(this.widget); this.widget = null; this.retry(); }
                catch { this.failed = true; }
            }
        },
        destroy() {
            this.disposed = true;
            if (this.widget !== null && window.turnstile) window.turnstile.remove(this.widget);
            this.widget = null;
        },
    };
};
})();

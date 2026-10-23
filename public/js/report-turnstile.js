// Livewire owns Alpine. Keep the provider iframe outside DOM morphing.
window.reportTurnstile = function (wire) {
    return {
        widget: null, failed: false, size: null, disposed: false, loading: false,
        async init() { await this.retry(); },
        async retry() {
            if (this.disposed || this.loading) return;
            this.loading = true;
            this.failed = false;
            try {
                if (!this.$el.dataset.sitekey) return;
                if (!window.turnstile) {
                    if (!window.reportTurnstileLoading) {
                        window.reportTurnstileLoading = new Promise((resolve, reject) => {
                            const script = document.createElement('script');
                            script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit';
                            script.async = true;
                            const timer = setTimeout(() => { script.remove(); reject(new Error('timeout')); }, 12000);
                            script.onload = () => { clearTimeout(timer); resolve(); };
                            script.onerror = () => { clearTimeout(timer); script.remove(); reject(new Error('load')); };
                            document.head.append(script);
                        }).catch(error => { window.reportTurnstileLoading = null; throw error; });
                    }
                    await window.reportTurnstileLoading;
                }
                // Script download completion alone does not guarantee API readiness.
                await new Promise((resolve, reject) => {
                    const timer = setTimeout(() => reject(new Error('ready timeout')), 12000);
                    window.turnstile.ready(() => { clearTimeout(timer); resolve(); });
                });
                if (this.disposed) return;
                if (this.widget !== null) { this.reset(); return; }
                this.size = this.$el.clientWidth < 300 ? 'compact' : 'flexible';
                this.widget = window.turnstile.render(this.$refs.challenge, {
                    sitekey: this.$el.dataset.sitekey, action: 'report_submit', size: this.size,
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
            const size = this.$el.clientWidth < 300 ? 'compact' : 'flexible';
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

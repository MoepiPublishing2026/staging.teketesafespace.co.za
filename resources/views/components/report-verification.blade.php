<div class="mt-7 text-center" x-data="{
    token: '', widget: null, failed: false,
    mount() {
        if (this.widget !== null || !window.turnstile || !this.$refs.challenge.dataset.sitekey) return;
        this.failed = false;
        this.widget = window.turnstile.render(this.$refs.challenge, {
            sitekey: this.$refs.challenge.dataset.sitekey,
            action: 'report_submit',
            size: this.$el.clientWidth &lt; 300 ? 'compact' : 'flexible',
            callback: token => { this.token = token; this.failed = false; this.$wire.set('turnstileToken', token, false); },
            'expired-callback': () => this.reset(),
            'timeout-callback': () => this.reset(),
            'error-callback': () => { this.clear(); this.failed = true; }
        });
    },
    clear() { this.token = ''; this.$wire.set('turnstileToken', '', false); },
    reset() { this.clear(); if (this.widget !== null &amp;&amp; window.turnstile) window.turnstile.reset(this.widget); },
    retry() {
        this.failed = false;
        if (window.turnstile) { this.reset(); this.mount(); }
        else { document.getElementById('report-turnstile-script')?.remove(); this.init(); }
    },
    init() {
        this.$nextTick(() => this.mount());
        if (!document.getElementById('report-turnstile-script')) {
            const script = document.createElement('script');
            script.id = 'report-turnstile-script';
            script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit';
            script.async = true;
            script.onload = () => window.dispatchEvent(new Event('report-turnstile-ready'));
            script.onerror = () => window.dispatchEvent(new Event('report-turnstile-unavailable'));
            document.head.append(script);
        }
    },
    destroy() { if (this.widget !== null &amp;&amp; window.turnstile) window.turnstile.remove(this.widget); }
}" @report-turnstile-ready.window="mount()"
    @report-turnstile-unavailable.window="failed = true"
    @report-verification-reset.window="reset()">
    <div wire:ignore>
        <div x-ref="challenge" data-sitekey="{{ config('report_protection.site_key') }}"
            class="mb-3" aria-label="Human verification"></div>
    </div>
    <p x-show="failed" x-cloak role="status" class="text-red-700 text-sm mb-3">
        Verification is unavailable. Your entries are preserved. Check your connection and retry.
        <button type="button" @click="retry()" class="underline">Retry verification</button>
    </p>
    @unless(config('report_protection.site_key'))
        <p role="status" class="text-red-700 text-sm mb-3">Verification is temporarily unavailable. Please try again later.</p>
    @endunless
    @error('turnstileToken') <p role="alert" class="text-red-700 text-sm mb-3">{{ $message }}</p> @enderror
    @error('reportSubmission') <p role="alert" class="text-red-700 text-sm mb-3">{{ $message }}</p> @enderror
    <button type="submit" wire:loading.attr="disabled" wire:target="submitReport"
        :disabled="!token" aria-describedby="report-verification-help"
        class="w-full h-[50px] sm:h-[52px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-[15px] font-medium cursor-pointer transition duration-200 hover:opacity-80 shadow-md disabled:opacity-50">
        <span wire:loading.remove wire:target="submitReport">Submit</span>
        <span wire:loading wire:target="submitReport">Submitting...</span>
    </button>
    <p id="report-verification-help" role="status" class="text-sm mt-2" x-show="!token">Complete verification above to submit your report.</p>
</div>

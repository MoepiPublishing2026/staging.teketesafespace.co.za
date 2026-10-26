<div class="mt-7 text-center" wire:key="report-turnstile" x-data="reportTurnstile($wire, $el)"
     data-sitekey="{{ config('turnstile.site_key') }}"
     @report-verification-reset.window="reset()" @resize.window.debounce.200ms="resize()">
    <p class="text-sm mb-2">Human verification</p>
    @if (config('turnstile.site_key'))
        <div wire:ignore class="flex justify-center" data-turnstile-host></div>
        <p x-cloak x-show="failed" role="status" aria-live="polite" class="text-sm text-red-700">
            Verification could not load. Your entries are preserved.
        </p>
        <button type="button" x-cloak x-show="failed" @click="retry()" class="underline text-sm">Retry verification</button>
        <noscript><p>JavaScript is required for verification. Your report has not been submitted.</p></noscript>
    @else
        <p role="status" class="text-sm text-red-700">Verification is temporarily unavailable.</p>
    @endif
    @error('turnstileToken')
        <p role="alert" class="text-sm text-red-700 mt-2">{{ $message }}</p>
    @enderror
</div>

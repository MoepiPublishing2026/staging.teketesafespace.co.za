{{-- Cloudflare Turnstile widget for Livewire forms. Renders nothing until both keys are configured.
     Usage: <x-turnstile /> inside the form, with `public $turnstileToken = '';` on the component. --}}
@if (\App\Support\Turnstile::enabled())
    @once
        <script>
            window.onTurnstileLoad = function () { window.dispatchEvent(new Event('turnstile-loaded')); };
        </script>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=onTurnstileLoad" async defer></script>
    @endonce

    <div wire:ignore
         data-sitekey="{{ config('services.turnstile.site_key') }}"
         x-data="{ widgetId: null }"
         x-init="
            const draw = () => {
                widgetId = turnstile.render($refs.box, {
                    sitekey: $el.dataset.sitekey,
                    'refresh-expired': 'auto',
                    callback: (token) => $wire.set('turnstileToken', token, false),
                    'expired-callback': () => $wire.set('turnstileToken', '', false),
                    'error-callback': () => $wire.set('turnstileToken', '', false),
                });
            };
            window.turnstile ? draw() : window.addEventListener('turnstile-loaded', draw, { once: true });
         "
         x-on:turnstile-reset.window="if (window.turnstile && widgetId !== null) { turnstile.reset(widgetId); }"
         class="flex justify-center my-4">
        <div x-ref="box"></div>
    </div>

    @error('turnstileToken')
        <p class="text-center text-sm text-red-600 mb-2">{{ $message }}</p>
    @enderror
@endif

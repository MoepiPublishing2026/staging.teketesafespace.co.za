# Report-form Turnstile

Required environment settings (configure privately; no values are supplied here):

- `TURNSTILE_SITE_KEY`: public widget site key.
- `TURNSTILE_SECRET`: server-only matching secret; never expose in Blade or logs.
- `TURNSTILE_EXPECTED_HOSTNAMES`: comma-separated exact hostnames, without scheme, port or path.

For local development at `127.0.0.1`/`localhost`, the local hostname allowlist must contain the actual address used in the browser (for example, `127.0.0.1,localhost`). `example.com` from an earlier dummy-key setup is not a valid expectation for real local tokens. Authorize the same local hostnames on a dedicated development widget in Cloudflare; keep staging/production hostname lists separate.

The widget and server require action `report_submit`. Verification uses TLS-verified Siteverify with 3-second connection/8-second total timeouts. Missing configuration and provider/network failures fail closed. Fields and temporary uploads remain available; every submission attempt clears/resets verification, including validation failures. No Turnstile-specific migration or package is needed. Submission rate limits and their existing cache-table prerequisites are documented in [report-limits.md](report-limits.md). Durable report idempotency is not included. Existing report-save/email behavior is otherwise unchanged.

The client loads one explicit-render API script with Cloudflare's `onload` callback, bounds loading waits, and prevents overlapping Retry initialization. Do not call `turnstile.ready()` with this async script: the real provider rejects that combination. The Blade component passes its root element into the factory; the site key and host are captured once, so Retry's Alpine button context cannot replace them with an undefined key. Livewire retains the ignored widget host across rerenders; removal disposes the widget and ignores late callbacks. Expiry, timeout and recoverable submission errors clear verification without clearing the draft or temporary uploads. The local script URL includes a content hash to invalidate stale cached JavaScript.

After setting environment values, clear/rebuild any existing configuration cache using your normal process, then run `php artisan serve`. No environment or database settings are changed by this implementation.

Use environment-specific real widget keys for full hostname/action integration testing. Official dummy keys may return fixed hostname/action metadata rather than the configured `report_submit`; strict verification intentionally rejects mismatched metadata. There is no production or local verification bypass. Never put a real secret in source, issues or chat.

Tests: `php vendor/bin/phpunit -c phpunit.turnstile.xml`; `node tests/Turnstile/widget.cjs`. PHP tests use in-memory SQLite fixtures, isolated runtime/environment paths, blocked stray HTTP, mocked Siteverify and non-sending mail. They do not use the checkout's `.env` or database. Browser layout and real hosted Siteverify checks require separate manual validation and are not claimed by these tests.

Optional real-browser regression: `node tests/Turnstile/browser.cjs` with an already installed Playwright module (or its absolute path in `PLAYWRIGHT_MODULE_PATH`) and optional `BROWSER_EXECUTABLE`. It starts/stops its own loopback PHP fixture using the real Blade and Livewire/Alpine code, an in-memory database and non-sending mail; all non-GET requests are rejected. No packages are installed. It uses the official public always-pass site key by default, or `REPORT_WIDGET_BROWSER_SITE_KEY` supplied privately for a real development widget. It checks actual Cloudflare script/iframe requests, reload, a deliberately aborted API download followed by a real Retry click, deferred draft preservation and mobile placement. Successful provider responses are not mocked. It does not submit reports or call Siteverify, so it does not establish hostname/action verification or full challenge success with real keys. Screenshots stay under ignored `tests/.runtime`.

After updating a local checkout: confirm you are on `captcha` and preserve any local changes before pulling with `git pull --ff-only origin captcha`. Restart your own `php artisan serve` process if needed and hard-refresh the form (Ctrl+Shift+R). If Blade views were precompiled, run `php artisan view:clear` locally. Do not clear unrelated application cache or change `.env` for this frontend fix. In Network, the local script URL should include `?v=`, and the Cloudflare API URL should include both `render=explicit` and `onload=reportTurnstileOnload`. Do not share key values, tokens, form contents or unredacted HAR files.

Official documentation: https://developers.cloudflare.com/turnstile/get-started/server-side-validation/

Explicit rendering and the supported onload callback: https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/

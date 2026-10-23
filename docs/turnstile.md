# Report-form Turnstile

Required environment settings (configure privately; no values are supplied here):

- `TURNSTILE_SITE_KEY`: public widget site key.
- `TURNSTILE_SECRET`: server-only matching secret; never expose in Blade or logs.
- `TURNSTILE_EXPECTED_HOSTNAMES`: comma-separated exact hostnames, without scheme, port or path.

For local development at `127.0.0.1`/`localhost`, the local hostname allowlist must contain the actual address used in the browser (for example, `127.0.0.1,localhost`). `example.com` from an earlier dummy-key setup is not a valid expectation for real local tokens. Authorize the same local hostnames on a dedicated development widget in Cloudflare; keep staging/production hostname lists separate.

The widget and server require action `report_submit`. Verification uses TLS-verified Siteverify with 3-second connection/8-second total timeouts. Missing configuration and provider/network failures fail closed. Fields and temporary uploads remain available; every submission attempt clears/resets verification, including validation failures. No Turnstile-specific migration or package is needed. Submission rate limits and their existing cache-table prerequisites are documented in [report-limits.md](report-limits.md). Durable report idempotency is not included. Existing report-save/email behavior is otherwise unchanged.

The client waits for Cloudflare API readiness before rendering, bounds loading/readiness waits, and prevents overlapping Retry initialization. Livewire retains the ignored widget host across rerenders; removal disposes the widget and ignores late callbacks. Expiry, timeout and recoverable submission errors clear verification without clearing the draft or temporary uploads. The mocked JavaScript lifecycle checks cover delayed readiness and removal during initialization; they do not replace hosted browser testing.

After setting environment values, clear/rebuild any existing configuration cache using your normal process, then run `php artisan serve`. No environment or database settings are changed by this implementation.

Use environment-specific real widget keys for full hostname/action integration testing. Official dummy keys may return fixed hostname/action metadata rather than the configured `report_submit`; strict verification intentionally rejects mismatched metadata. There is no production or local verification bypass. Never put a real secret in source, issues or chat.

Tests: `php vendor/bin/phpunit -c phpunit.turnstile.xml`; `node tests/Turnstile/widget.cjs`. PHP tests use in-memory SQLite fixtures, isolated runtime/environment paths, blocked stray HTTP, mocked Siteverify and non-sending mail. They do not use the checkout's `.env` or database. Browser layout and real hosted Siteverify checks require separate manual validation and are not claimed by these tests.

Official documentation: https://developers.cloudflare.com/turnstile/get-started/server-side-validation/

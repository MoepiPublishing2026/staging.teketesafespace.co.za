# PR #234 isolated browser validation

The harness boots the real Laravel HTTP kernel and serves `public/build` production
assets. It never reads the checkout's `.env`, uses a separate SQLite fixture and
storage directory, and binds the server to loopback. It does not migrate or seed
an existing database. `seed.php` refuses to overwrite its fixture database.

The fixture uses the application's user, cache and audit migrations plus the
existing report fixture and fields needed by the school-admin pages. This tests
frontend behavior; it does not certify the full production migration history or
existing production data. No provider responses or Livewire requests are mocked.

Authentication uses a fictional school account and a harness-only endpoint that
provisions an authenticated session and pending OTP. Chromium enters the six OTP
digits through the actual UI and exercises the normal OTP middleware and Livewire
component. Login validation is exercised separately. CAPTCHA success, SMTP
delivery and username/password authentication success are not claimed.

## Running

From a separate checkout of `l2-tailwind` integrated with `developers`, build with `npm ci && npm run build`.
Install Playwright/Chromium in a separate tools directory or disposable container;
do not add them to the application's dependencies. Supply its module path via
`PLAYWRIGHT_MODULE_PATH`.

With PHP 8.2+ and SQLite enabled, set `PR234_BROWSER_TEST=1` and
`PR234_RUNTIME` to a new absolute directory, then run:

```sh
php tests/Tailwind/seed.php
php -S 127.0.0.1:8794 -t public tests/Tailwind/router.php
```

From another terminal, set `PR234_EVIDENCE` to a writable artifact directory and
`PR234_COMMIT` to `git rev-parse HEAD`, then run:

```sh
node tests/Tailwind/browser.cjs
```

`PR234_ORIGIN` defaults to `http://127.0.0.1:8794`; only loopback URLs are accepted.
The browser writes JSON with console messages, page errors, failed requests,
non-success HTTP responses, local asset status/content types and interaction
results, plus desktop/mobile screenshots. Its exit status fails on unexpected
checks, CDN loads, duplicate Alpine warnings, page errors or build asset failures.
Known base defects below are reported explicitly rather than treated as new
regressions. The script does not claim that the console is error-free.

For base comparison, use a separate read-only checkout of `developers` at
`4dd058ef9368fd9f7ac1fd265b1108cb60d723b6`, mount/copy this harness into it, and
seed a different runtime. Serve that checkout on loopback port 8795 with
`PR234_ORIGIN=http://127.0.0.1:8795`, then run `compare-base.cjs` against that URL.
That script writes `base-comparison.json` under `/evidence` (the container artifact
mount). Never point these harnesses at the running app.

## Observed results, 11 November 2026

- Before the Alpine fixes, Chromium captured eight duplicate-Alpine warnings and
  six Alpine CDN requests across the desktop/mobile public/auth checks.
- After the fixes, public pages, authenticated dashboard/settings/reports and real
  Livewire/Alpine interactions passed on 1440×1000 and 390×844 viewports. Local
  CSS/JS loaded successfully, with no Tailwind/Alpine CDN requests or duplicate
  Alpine warnings. Final commit-specific evidence is reported in the PR.
- Livewire checks cover landing redirects, status lookup/validation, dismissal of
  the Alpine error dialog, login validation, OTP verification settings
  validation, profile saving and report filtering. The fixture database contains only fictional account/school data.
- `npm ci && npm run build`, security lint, and Blade compilation passed.

## Existing defects reproduced on the PR base

| Observation | Base comparison |
| --- | --- |
| FAQ render: missing `admin.subscribe` route | Same template reference and missing route on `developers`; HTTP 500 in both view probes. |
| Subscription render: missing `faq` route | Same failure on `developers`; HTTP 500 in both view probes. |
| Dashboard: `isMobile is not defined` | Chromium reproduces the same error on `developers`, desktop and mobile; dashboard template unchanged. |
| Missing `/images/linkedin.png` | Same missing file and footer reference on `developers`; 404, or 500 through the authenticated admin error wrapper. |
| Font Awesome kit request | Actual `https://kit.fontawesome.com/2c36e9b7b9.js` response is HTTP 403 on both branches. |

On the developers integration, `/password/reset` and the password-email template
return HTTP 200 on both viewports. The browser suite checks the real route and
the template probe; neither belongs to the expected HTTP-500 list.

FAQ, subscription, checkout and legacy settings templates have no
corresponding production routes in this snapshot. Harness-only view probes are
identified separately from real production-route tests. Checkout and legacy
settings render successfully with supplied fictional fixture values. No named
routes are invented to hide the two missing-route errors. Navigation-aborted
requests are retained in the raw capture as `net::ERR_ABORTED`.

These defects are outside the Tailwind migration and are intentionally not fixed
in this PR. No merge or deployment is part of this validation.

# Report submission protection

The public Livewire report action requires Cloudflare Turnstile before any report
or permanent attachment is created. The visible widget sits immediately above
Submit. This change targets main's conventional form and does not import the
separate role-stepper work.

## Configuration and rollout prerequisites

Merge the names in `.env.report-protection.example` into secure hosting
configuration. The site key is public; the secret key must remain server-only.
Set an exact comma-separated `TURNSTILE_EXPECTED_HOSTNAMES` allowlist for each
environment and configure those hostnames in Cloudflare. The expected action is
`report_submit`. Missing configuration fails closed. No paid service is required
or activated by this change.

Verify the cPanel document root serves this application's `public/index.php`, and
confirm the deployed Blade views are the root `resources/views` copies. Verify
the database cache uses shared transactional tables with `cache` and `cache_locks`
(or configured names) and appropriate permissions. All workers must share those
tables and the application key. This limiter explicitly uses the database store.

Run `2026_10_21_000001_create_report_submissions_table.php` before serving the new
code. The existing deployment script does not run migrations. This PR does not
change that script or perform rollout. Rebuild configuration caches through the
normal approved rollout procedure after provisioning the settings.

Confirm the trusted proxy chain and host-level client-IP restoration. The code
uses Laravel `request()->ip()` and does not read untrusted forwarded/Cloudflare
headers itself. Until proxies are configured correctly, an IP quota may represent
a proxy rather than a visitor. Do not enable blanket proxy trust. Network rules
and trusted proxy configuration are deliberately outside this PR.

## Limits and failure behavior

Provisional session limits are 10 attempts/10 minutes and 30/hour. IP backstops
are 300/10 minutes and 1000/hour to accommodate shared school and carrier NAT.
These are starting assumptions, not approved production policy. A submission
attempt includes field validation failures and failed verification; typing,
navigation, lookups and completed retries do not consume allowances. Fixed windows
can permit boundary bursts. No school/contact-wide quotas are imposed.

Database cache locks cover counter admission only, with a five-second lease and
one-second wait. Sorted counter row locks (through supported database-cache
increment operations inside one transaction) protect multi-window admission even
if a worker outlives that lease. No external HTTP, attachments or mail occur in
this critical section. Lock/store failures fail closed and preserve the draft.

## Durable retries and email

An encrypted identity contains a UUID and session HMAC. Livewire locks that
property, and the server checks the session binding on every action. The current
identity is also retained in the server session for the same report type/anonymity
route, permitting reload recovery. The success dialog's OK action starts a new
identity explicitly; a second tab on the same route shares the current identity
until a new report is explicitly started.

After verification, a unique `report_submissions` row and `SELECT FOR UPDATE`
serialize report creation. The claim, report and completed association commit in
one transaction; a failed transaction rolls all three back. A keyed fingerprint
binds report fields and attachment content. Completed replays return the original
case number without another CAPTCHA, allowance or email. Keep completed ledger
rows for the lifetime of the report: deleting them would remove the duplicate
guarantee. Session expiry prevents recovery in a different session. The ledger
contains no report content, contact details, raw session IDs or CAPTCHA tokens.

Report persistence and email errors are handled separately. Email failure leaves
success and the case number visible with a secondary delivery warning. Sending is
best effort, without an automatic retry/outbox guarantee. A process crash after
commit but before email may result in no confirmation email; retries still recover
the case number and do not send again.

Filesystem writes are not transactional. Attachment visibility and anonymous-report
contact requirements are unchanged and remain separate follow-ups.

## Focused validation

Run `php vendor/phpunit/phpunit/phpunit -c phpunit.report-protection.xml`.
For an isolated worktree borrowing installed dependencies, set `REPORT_TEST_VENDOR`
to that vendor directory. The test bootstrap overrides application class maps so
the worktree code is exercised. Tests force an in-memory SQLite database and do
not load a production database. Small fixtures isolate this feature from unrelated
legacy migrations. The older `public/phpunit.xml` and `storage/tests` are untouched.

MySQL concurrency checks use `tests/concurrency.php`. Set
`REPORT_CONCURRENCY_ENABLE=1` only with a disposable local MySQL/MariaDB server on
127.0.0.1:33317. The harness creates and drops a randomly named test database and
spawns eight workers for each of quota admission and duplicate persistence.
Ordinary SQLite tests do not establish MySQL row-lock correctness.

For browser checks, the feature suite generates an ignored SQLite fixture. Run
`php -S 127.0.0.1:8871 tests/browser-router.php` locally with
`REPORT_BROWSER_ENABLE=1`, install Playwright only
under ignored `tests/.runtime/browser`, set `REPORT_TEST_CHROMIUM` to a compatible
browser executable, and run `node tests/browser.cjs`. The default mode stubs the
provider script but exercises actual Blade, Livewire and Alpine. Set
`REPORT_TEST_REAL_TURNSTILE=1` for a real-provider smoke test with Cloudflare's
official public dummy site key. Server verification and mail remain faked in
this isolated harness. No production keys or database are used.

Official references:
- https://developers.cloudflare.com/turnstile/get-started/server-side-validation/
- https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/widget-configurations/
- https://developers.cloudflare.com/turnstile/troubleshooting/testing/

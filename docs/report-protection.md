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
until a new report is explicitly started. A stale identity is replaced when the
session changes. If a completed identity is used with changed entries, the server
rejects it as a conflict instead of pretending those entries were saved. The
conflict UI can start a separate report while keeping the draft and temporary
uploads. Identical and cleared-form retries still return the original case number
without CAPTCHA. Starting a fresh report also clears dependent school context.

After verification, a unique `report_submissions` row and `SELECT FOR UPDATE`
serialize report creation. The claim, report and completed association commit in
one transaction; a failed transaction rolls all three back. A keyed fingerprint
binds report fields and server-assigned temporary upload identifiers. It is a
request identity check, not a content checksum; completed retries can recover
even after the temporary file contents have expired. Completed replays return the original
case number without another CAPTCHA, allowance or email. Keep completed ledger
rows for the lifetime of the report: deleting them would remove the duplicate
guarantee. Session expiry prevents recovery in a different session. The ledger
contains no report content, contact details, raw session IDs or CAPTCHA tokens.

Report persistence and email errors are handled separately. Email failure leaves
success and the case number visible with a secondary delivery warning. Sending is
best effort, without an automatic retry/outbox guarantee. A process crash after
commit but before email may result in no confirmation email; retries still recover
the case number and do not send again. Notification handling is outside the save
failure handler; even a logging failure after an email error cannot report that a
committed report failed.

Filesystem writes are not transactional. Attachment visibility and anonymous-report
contact requirements are unchanged and remain separate follow-ups.

## Focused validation

Run `php vendor/phpunit/phpunit/phpunit -c phpunit.report-protection.xml`.
For an isolated worktree borrowing installed dependencies, set `REPORT_TEST_VENDOR`
to that vendor directory. The test bootstrap overrides application class maps so
the worktree code is exercised. Tests force an in-memory SQLite database and do
not load the checkout's `.env`, cached configuration, sessions or compiled views,
and route public-file writes into the isolated test runtime.
An empty environment directory and runtime paths under `tests/.runtime` enforce
that isolation. Outbound HTTP is blocked unless a test explicitly fakes it.
Small fixtures isolate this feature from unrelated
legacy migrations. The older `public/phpunit.xml` and `storage/tests` are untouched.

MySQL concurrency checks use `tests/concurrency.php`. Set
`REPORT_CONCURRENCY_ENABLE=1` only with a disposable local MySQL/MariaDB server on
127.0.0.1:33317. The harness creates and drops a randomly named test database and
spawns eight workers for quota admission, duplicate persistence and conflicting
payload retries. It uses the actual database-cache driver and database locks,
without cache mocks.
Ordinary SQLite tests do not establish MySQL row-lock correctness.

For browser checks, the feature suite generates an ignored SQLite fixture. Run
`php -S 127.0.0.1:8871 tests/browser-router.php` locally with
`REPORT_BROWSER_ENABLE=1`, install Playwright only
under ignored `tests/.runtime/browser` (or set `REPORT_TEST_PLAYWRIGHT` to an
existing installation), set `REPORT_TEST_CHROMIUM` to a compatible
browser executable, and run `node tests/browser.cjs`. The default mode stubs the
provider script but exercises actual Blade, Livewire and Alpine. Set
`REPORT_TEST_REAL_TURNSTILE=1` for a real-provider smoke test with Cloudflare's
official public dummy site key. Server verification and mail remain faked in
this isolated harness. No production keys or database are used.

| Check | Database/cache | Cloudflare behavior |
| --- | --- | --- |
| PHPUnit feature/service suite | Actual DatabaseStore/DatabaseLock on isolated in-memory SQLite; row locks are not equivalent to MySQL | Laravel HTTP fakes, including expired/reused responses and transport/retry cases |
| Concurrent PHP worker harness | Actual MySQL driver and database cache/locks on disposable local MySQL/MariaDB | No Cloudflare calls; persistence/limiter services tested directly |
| Controlled browser checks | Actual app with isolated file SQLite and database cache; real Blade/Livewire/Alpine | Provider JavaScript stub; server Siteverify and mail faked |
| Real-widget browser smoke | Same isolated app/database | Real provider script and official public dummy site key, generating dummy responses; server Siteverify still faked |

The smoke test is not an end-to-end test of real Siteverify or production keys.
It does not establish production hostname configuration, proxy correctness, or
delivery guarantees. Screenshots may have missing static images in the isolated
router; the router exists to exercise form behavior, not hosting asset delivery.

## CI and review access

Neither main nor this feature branch contains `.github/workflows` definitions.
GitHub Actions is enabled, but the only API-listed workflow is GitHub's generated
`dynamic/dependabot/dependabot-updates`; it does not test pushes to this feature
branch. Therefore no application CI was triggered by this PR. Local checks are
not equivalent to required CI. This change does not disable checks or alter
branch protections. GitHub's branch endpoint reports `main.protected=false`.
Protection/rules APIs return HTTP 403 with a plan-availability message (GitHub
suggests an upgrade or making the repository public); this is not evidence of a
missing token permission. No upgrade, visibility change or protection change was
made. A maintainer must confirm intended CI/review policy and any external checks.
At review time the PR has no submitted reviews.

Official references:
- https://developers.cloudflare.com/turnstile/get-started/server-side-validation/
- https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/widget-configurations/
- https://developers.cloudflare.com/turnstile/troubleshooting/testing/

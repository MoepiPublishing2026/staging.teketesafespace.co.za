# Notification foreign-key migration regression

Run only against a newly created disposable MySQL 8 database. This suite drops and
recreates `notifications`, `incidents` and `reports` in that database. It requires
explicit opt-in, a host and a database name starting with `pr232_`; the bootstrap
uses Illuminate Database directly and never boots Laravel or loads `.env`,
application configuration, storage or existing data. Use isolated MySQL and PHP
containers rather than an existing application database/server.

Set `PR232_MYSQL_TEST=1`, `PR232_MYSQL_HOST`, `PR232_MYSQL_DATABASE`,
`PR232_MYSQL_USERNAME`, and `PR232_MYSQL_PASSWORD` (optional port defaults to 3306).
Then, from an isolated checkout with the locked Composer dependencies:

```sh
php vendor/bin/phpunit --no-configuration \
  --bootstrap tests/MySQL/bootstrap.php tests/MySQL/NotificationForeignKeyMigrationTest.php
```

The matrix covers forward and reverse migration with renamed, absent and already
correct constraints; refusal on orphaned IDs, different case identities, missing
case columns and blank/null identities; a safe round trip; and unsafe rollback
after new report-only notifications are added. Refusal assertions compare all
fixture rows, complete `SHOW CREATE TABLE` definitions and foreign-key metadata.
The suite does not certify mapping of any production legacy data or concurrent
writes during schema migration. Run real schema changes with writers quiesced.

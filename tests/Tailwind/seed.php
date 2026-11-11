<?php
$app = require __DIR__.'/bootstrap.php';
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

if (file_exists(config('database.connections.sqlite.database'))) {
    throw new RuntimeException('Refusing to overwrite an existing fixture database.');
}
touch(config('database.connections.sqlite.database'));
(require database_path('migrations/0001_01_01_000000_create_users_table.php'))->up();
Schema::table('users', function (Blueprint $table) {
    foreach (['username', 'role', 'school_name', 'phone_number', 'phone'] as $field) $table->string($field)->nullable();
});
(require dirname(__DIR__).'/report-fixture.php')();
foreach (['2026_10_29_012715_create_audit_logs_table.php', '2026_10_30_063644_create_audit_chain_heads_table.php'] as $migration) {
    (require database_path('migrations/'.$migration))->up();
}
Schema::table('schools', function (Blueprint $table) {
    foreach (['emis_no', 'district', 'towncity', 'address', 'telephone'] as $field) $table->string($field)->nullable();
    $table->timestamps();
});
Schema::table('reports', function (Blueprint $table) {
    foreach (['latest_status_reason', 'clarification', 'blocking_reason'] as $field) $table->text($field)->nullable();
});
DB::table('schools')->where('school_id', 1)->update(['school_name' => 'Fictional PR234 School']);
DB::table('users')->insert([
    'id' => 1, 'name' => 'Fictional PR234 Admin', 'email' => 'pr234@example.invalid',
    'username' => 'pr234-fictional', 'role' => 'school', 'school_name' => 'Fictional PR234 School',
    'password' => password_hash('Fictional-PR234-Only!', PASSWORD_BCRYPT),
    'created_at' => now(), 'updated_at' => now(),
]);
echo "Isolated SQLite fixture created; fictional account only.\n";

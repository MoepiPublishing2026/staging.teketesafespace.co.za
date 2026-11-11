<?php

// This harness never boots the application or reads its .env/config/storage.
require dirname(__DIR__, 2).'/vendor/autoload.php';

$database = getenv('PR232_MYSQL_DATABASE');
$host = getenv('PR232_MYSQL_HOST');
if (getenv('PR232_MYSQL_TEST') !== '1' || ! $host || ! $database || ! str_starts_with($database, 'pr232_')) {
    throw new RuntimeException('Explicit disposable MySQL host and pr232_ database required.');
}

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $host,
    'port' => getenv('PR232_MYSQL_PORT') ?: 3306,
    'database' => $database,
    'username' => getenv('PR232_MYSQL_USERNAME') ?: 'root',
    'password' => getenv('PR232_MYSQL_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$container = $capsule->getContainer();
$container->instance('db', $capsule->getDatabaseManager());
$container->bind('db.schema', fn () => $capsule->getConnection()->getSchemaBuilder());
Illuminate\Support\Facades\Facade::setFacadeApplication($container);

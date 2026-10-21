<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class ReportTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    public function createApplication()
    {
        $app = createReportTestApplication();
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
        if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            throw new \RuntimeException('Report tests require isolated in-memory SQLite.');
        }
        config(['report_protection.site_key' => 'test-site', 'report_protection.secret_key' => 'test-secret',
            'report_protection.hostnames' => ['reports.test']]);
        \Illuminate\Support\Facades\Http::preventStrayRequests();
        (require database_path('migrations/0001_01_01_000001_create_cache_table.php'))->up();
        (require database_path('migrations/2023_01_01_000000_create_reports_table.php'))->up();
        (require database_path('migrations/2026_10_21_000001_create_report_submissions_table.php'))->up();
        Schema::table('reports', function (Blueprint $table) {
            foreach (['case_number', 'school_name', 'full_name', 'age', 'location', 'grade', 'school_id', 'province_id', 'district_id', 'status', 'suspended_until'] as $column) {
                $table->string($column)->nullable();
            }
            $table->boolean('is_anonymous')->default(false);
            $table->unique('case_number');
        });
        Schema::create('abuse_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->timestamps();
        });
        Schema::create('subtypes', function (Blueprint $table) {
            $table->id();
            $table->integer('abuse_type_id');
            $table->string('sub_type_name');
            $table->timestamps();
        });
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('school_id');
            $table->string('school_name');
            $table->string('phase_ped')->nullable();
            $table->string('province')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
        });
        DB::table('abuse_types')->insert(['id' => 1, 'type_name' => 'Bullying']);
        DB::table('subtypes')->insert(['id' => 1, 'abuse_type_id' => 1, 'sub_type_name' => 'Physical']);
        DB::table('schools')->insert(['school_id' => 1, 'school_name' => 'Test School', 'phase_ped' => 'PRIMARY SCHOOL']);
    }
}

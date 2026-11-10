<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\Report;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

class NotificationRelationshipTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'mail.default' => 'array',
        ]);

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('reports');

        parent::tearDown();
    }

    public function createApplication()
    {
        $app = require dirname(__DIR__, 2) . '/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function test_notification_incident_relation_targets_report_model(): void
    {
        $report = Report::create([
            'case_number' => 'ABC-123',
        ]);

        $notification = Notification::create([
            'report_id' => $report->id,
            'message' => 'Legacy notification row',
        ]);

        $this->assertSame($report->id, $notification->incident->id);
        $this->assertInstanceOf(Report::class, $notification->incident);
    }
}

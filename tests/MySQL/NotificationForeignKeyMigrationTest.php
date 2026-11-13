<?php

namespace Tests\MySQL;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class NotificationForeignKeyMigrationTest extends TestCase
{
    protected function tearDown(): void
    {
        $this->dropFixture();
        parent::tearDown();
    }

    private function dropFixture(): void
    {
        DB::statement('DROP TABLE IF EXISTS notifications');
        DB::statement('DROP TABLE IF EXISTS incidents');
        DB::statement('DROP TABLE IF EXISTS reports');
    }

    private function migration(): object
    {
        return require dirname(__DIR__, 2).'/database/migrations/2026_11_10_000001_fix_notifications_report_foreign_key.php';
    }

    private function fixture(string $direction, string $condition = 'matching', string $constraint = 'source'): void
    {
        $this->dropFixture();
        $source = $direction === 'up' ? 'incidents' : 'reports';
        $target = $direction === 'up' ? 'reports' : 'incidents';
        foreach (['incidents', 'reports'] as $table) {
            $caseColumn = $condition === 'missing-column' && $table === $source ? '' : ', case_number varchar(50) NULL';
            DB::statement("CREATE TABLE $table (id bigint unsigned PRIMARY KEY$caseColumn) ENGINE=InnoDB");
            if ($condition === 'orphan' && $table === $target) {
                continue;
            }
            $row = ['id' => 1];
            if ($caseColumn !== '') {
                $row['case_number'] = match ($condition) {
                    'blank' => '   ',
                    'null' => null,
                    'ambiguous' => $table === $source ? 'CASE-A' : 'CASE-B',
                    default => 'CASE-1',
                };
            }
            DB::table($table)->insert($row);
        }
        $parent = $constraint === 'target' ? $target : $source;
        $fk = $constraint === 'absent' ? '' : ", CONSTRAINT renamed_notification_fk FOREIGN KEY (report_id) REFERENCES $parent(id) ON DELETE CASCADE";
        DB::statement("CREATE TABLE notifications (id bigint unsigned PRIMARY KEY, report_id bigint unsigned, message text$fk) ENGINE=InnoDB");
        DB::table('notifications')->insert(['id' => 1, 'report_id' => 1, 'message' => 'Fictional migration fixture']);
    }

    private function snapshot(): array
    {
        $snapshot = [];
        foreach (['incidents', 'reports', 'notifications'] as $table) {
            $snapshot[$table] = [
                'schema' => DB::select("SHOW CREATE TABLE $table"),
                'rows' => DB::table($table)->orderBy('id')->get()->all(),
            ];
        }
        $snapshot['constraints'] = DB::select("SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'notifications' AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY CONSTRAINT_NAME, ORDINAL_POSITION");

        return json_decode(json_encode($snapshot), true);
    }

    public static function refusalCases(): iterable
    {
        foreach (['up', 'down'] as $direction) {
            foreach (['ambiguous', 'orphan', 'blank', 'null', 'missing-column'] as $condition) {
                yield "$direction $condition" => [$direction, $condition];
            }
        }
    }

    #[DataProvider('refusalCases')]
    public function test_refusal_preserves_all_rows_schema_and_constraints(string $direction, string $condition): void
    {
        $this->fixture($direction, $condition);
        $before = $this->snapshot();
        try {
            $this->migration()->$direction();
            $this->fail('Unsafe migration must refuse before changing any schema.');
        } catch (RuntimeException $error) {
            $this->assertStringContainsString($condition === 'orphan' ? ($direction === 'up' ? 'orphaned' : 'non-existent') : 'Mapping is not provable', $error->getMessage());
        }
        $this->assertSame($before, $this->snapshot(), 'Refusal must preserve rows, SHOW CREATE TABLE and FK metadata.');
    }

    public static function successCases(): iterable
    {
        foreach (['up', 'down'] as $direction) {
            foreach (['source', 'absent', 'target'] as $constraint) {
                yield "$direction $constraint" => [$direction, $constraint];
            }
        }
    }

    #[DataProvider('successCases')]
    public function test_success_preserves_rows_and_targets_the_correct_parent(string $direction, string $constraint): void
    {
        $this->fixture($direction, 'matching', $constraint);
        $before = $this->snapshot();
        $this->migration()->$direction();
        $after = $this->snapshot();
        foreach (['incidents', 'reports', 'notifications'] as $table) {
            $this->assertSame($before[$table]['rows'], $after[$table]['rows']);
        }
        $this->assertCount(1, $after['constraints']);
        $this->assertSame($direction === 'up' ? 'reports' : 'incidents', $after['constraints'][0]['REFERENCED_TABLE_NAME']);
        if ($constraint === 'target') {
            $this->assertSame($before, $after, 'Already-correct constraints must be unchanged.');
        }
    }

    public function test_safe_round_trip_and_rollback_with_new_report_only_data(): void
    {
        $this->fixture('up');
        $rows = $this->snapshot()['notifications']['rows'];
        $this->migration()->up();
        $this->migration()->down();
        $this->assertSame('incidents', $this->snapshot()['constraints'][0]['REFERENCED_TABLE_NAME']);
        $this->assertSame($rows, $this->snapshot()['notifications']['rows']);

        $this->migration()->up();
        DB::table('reports')->insert(['id' => 2, 'case_number' => 'REPORT-ONLY']);
        DB::table('notifications')->insert(['id' => 2, 'report_id' => 2, 'message' => 'Fictional new report notification']);
        $before = $this->snapshot();
        try {
            $this->migration()->down();
            $this->fail('Rollback must refuse report-only data.');
        } catch (RuntimeException $error) {
            $this->assertStringContainsString('non-existent incident rows', $error->getMessage());
        }
        $this->assertSame($before, $this->snapshot());
    }
}

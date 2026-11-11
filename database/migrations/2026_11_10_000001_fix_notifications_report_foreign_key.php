<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('notifications') || DB::getDriverName() !== 'mysql') {
            return;
        }

        if ($this->hasOrphanedRows('notifications', 'report_id', 'reports')) {
            throw new RuntimeException('Cannot switch notifications.report_id to reports without orphaned notification rows. This migration intentionally does not delete or relink data.');
        }

        if ($this->hasAmbiguousLegacyMapping()) {
            throw new RuntimeException('Cannot switch notifications.report_id to reports because legacy incident IDs and report IDs overlap for different cases. Mapping is not provable, so this migration refuses to reinterpret the data.');
        }

        // MySQL DDL commits implicitly: complete every data check before changing constraints.
        $legacyConstraintNames = $this->foreignKeyNamesFor('notifications', 'incidents');

        foreach ($legacyConstraintNames as $constraintName) {
            DB::statement(sprintf('ALTER TABLE notifications DROP FOREIGN KEY `%s`', $constraintName));
        }

        if (empty($this->foreignKeyNamesFor('notifications', 'reports'))) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->foreign('report_id')
                    ->references('id')
                    ->on('reports')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('notifications') || DB::getDriverName() !== 'mysql') {
            return;
        }

        if ($this->hasOrphanedRows('notifications', 'report_id', 'incidents')) {
            throw new RuntimeException('Cannot restore notifications.report_id to incidents because some notification rows point to non-existent incident rows. This migration intentionally does not delete or relink data.');
        }

        if ($this->hasAmbiguousLegacyMapping()) {
            throw new RuntimeException('Cannot restore notifications.report_id to incidents because legacy incident IDs and report IDs overlap for different cases. Mapping is not provable, so this migration refuses to reinterpret the data.');
        }

        // MySQL DDL commits implicitly: complete every data check before changing constraints.
        $reportConstraintNames = $this->foreignKeyNamesFor('notifications', 'reports');

        foreach ($reportConstraintNames as $constraintName) {
            DB::statement(sprintf('ALTER TABLE notifications DROP FOREIGN KEY `%s`', $constraintName));
        }

        if (empty($this->foreignKeyNamesFor('notifications', 'incidents'))) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->foreign('report_id')
                    ->references('id')
                    ->on('incidents')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Look up the actual foreign-key constraints for the table and target table.
     *
     * @return array<int, string>
     */
    protected function foreignKeyNamesFor(string $table, string $referencedTable): array
    {
        $rows = DB::select(
            'SELECT CONSTRAINT_NAME FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = ? AND REFERENCED_TABLE_NAME = ?',
            [$table, $referencedTable]
        );

        return array_map(fn ($row) => $row->CONSTRAINT_NAME, $rows);
    }

    /**
     * Check whether any rows are orphaned relative to the parent table.
     */
    protected function hasOrphanedRows(string $table, string $column, string $parentTable): bool
    {
        $count = DB::table($table)
            ->whereNotNull($column)
            ->whereRaw(sprintf('%s NOT IN (SELECT id FROM %s)', $column, $parentTable))
            ->count();

        return $count > 0;
    }

    /**
     * A legacy notification cannot be reassigned safely unless the same numeric ID
     * represents the same case in both tables. If rows overlap with different case
     * identities, mapping is ambiguous and the migration refuses to reinterpret data.
     */
    protected function hasAmbiguousLegacyMapping(): bool
    {
        if (! Schema::hasTable('incidents') || ! Schema::hasTable('reports')) {
            return false;
        }

        if (! Schema::hasColumn('incidents', 'case_number') || ! Schema::hasColumn('reports', 'case_number')) {
            return true;
        }

        $count = DB::table('notifications')
            ->join('incidents', 'incidents.id', '=', 'notifications.report_id')
            ->join('reports', 'reports.id', '=', 'notifications.report_id')
            ->where(function ($query) {
                $query->whereRaw('TRIM(COALESCE(incidents.case_number, "")) = ""')
                    ->orWhereRaw('TRIM(COALESCE(reports.case_number, "")) = ""')
                    ->orWhereRaw('TRIM(incidents.case_number) <> TRIM(reports.case_number)');
            })
            ->count();

        return $count > 0;
    }
};

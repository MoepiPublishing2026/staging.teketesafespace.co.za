<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Support\AttachmentStore;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * One-off: move report attachments uploaded BEFORE the private-storage change
 * (storage/app/public/reports + the copy in public/storage/reports) onto the
 * private "attachments" disk, under generated names, and point reports.image_path
 * at the new files. The old public copies are deleted only after the database
 * row has been updated.
 *
 *   php artisan attachments:migrate-legacy --dry-run   (look first)
 *   php artisan attachments:migrate-legacy
 */
class MigrateLegacyAttachments extends Command
{
    protected $signature = 'attachments:migrate-legacy
                            {--dry-run : Report what would happen without writing or deleting anything}
                            {--keep-originals : Migrate but leave the old public copies in place}';

    protected $description = 'Move legacy publicly-served report attachments to private storage';

    public function handle(AttachmentStore $store): int
    {
        $dry  = (bool) $this->option('dry-run');
        $keep = (bool) $this->option('keep-originals');
        $disk = Storage::disk(config('attachments.disk'));

        $tally = ['migrated' => 0, 'already_private' => 0, 'missing' => 0, 'blocked' => 0, 'kept_unsupported' => 0];

        $this->info($dry ? 'DRY RUN - nothing will be changed.' : 'Migrating legacy attachments...');

        Report::whereNotNull('image_path')->where('image_path', '!=', '')
            ->chunkById(100, function ($reports) use ($store, $disk, $dry, $keep, &$tally) {
                foreach ($reports as $report) {
                    $entries = $this->entries($report->image_path);
                    $result  = [];
                    $delete  = [];
                    $changed = false;

                    foreach ($entries as $entry) {
                        $clean = ltrim(str_replace('\\', '/', $entry), '/');

                        if (str_contains($clean, '..')) {
                            $this->warn("  report {$report->id}: suspicious path skipped ({$entry})");
                            $result[] = $entry;
                            $tally['blocked']++;
                            continue;
                        }

                        $sources = $this->legacySources($clean);

                        if (! $sources) {
                            $disk->exists($clean) ? $tally['already_private']++ : $tally['missing']++;
                            if (! $disk->exists($clean)) {
                                $this->warn("  report {$report->id}: file not found on disk ({$entry})");
                            }
                            $result[] = $entry;
                            continue;
                        }

                        if ($dry) {
                            $this->line("  report {$report->id}: would move {$clean}");
                            $result[] = $entry;
                            $tally['migrated']++;
                            continue;
                        }

                        try {
                            $new = $store->storeFromPath($sources[0], lenient: true, legacyName: basename($clean));
                        } catch (ValidationException $e) {
                            $this->error("  report {$report->id}: BLOCKED {$clean} - " . collect($e->errors())->flatten()->first());
                            $result[] = $entry;     // leave as-is for manual review
                            $tally['blocked']++;
                            continue;
                        } catch (\Throwable $e) {
                            $this->error("  report {$report->id}: FAILED {$clean} - " . $e->getMessage());
                            $result[] = $entry;
                            $tally['blocked']++;
                            continue;
                        }

                        if (str_ends_with($new, '.bin') || ! isset(config('attachments.types')[$this->mimeOf($new)])) {
                            $tally['kept_unsupported']++;
                            $this->warn("  report {$report->id}: {$clean} is not an allowed type; kept, but download-only");
                        }

                        $result[] = $new;
                        $delete   = array_merge($delete, $sources);
                        $changed  = true;
                        $tally['migrated']++;
                    }

                    if ($changed && ! $dry) {
                        // Query builder on purpose: don't bump updated_at on the report.
                        DB::table('reports')->where('id', $report->id)->update(['image_path' => json_encode($result)]);

                        if (! $keep) {
                            foreach ($delete as $old) {
                                @unlink($old);
                            }
                        }
                    }
                }
            });

        $this->newLine();
        $this->table(array_keys($tally), [array_values($tally)]);

        if (! $dry && ! $this->option('keep-originals')) {
            $this->info('Old public copies of migrated files were deleted.');
        }

        return self::SUCCESS;
    }

    /** image_path is normally a JSON list; tolerate a legacy bare string. */
    private function entries(?string $raw): array
    {
        $decoded = json_decode((string) $raw, true);

        if (is_array($decoded)) {
            return array_values(array_filter($decoded, 'is_string'));
        }

        return filled($raw) ? [(string) $raw] : [];
    }

    /** Existing legacy copies of a relative path (storage/app/public and the public/storage copy). */
    private function legacySources(string $relative): array
    {
        $found = [];

        foreach ([storage_path('app/public'), public_path('storage')] as $root) {
            $rootReal = realpath($root);
            $real     = $rootReal ? realpath($rootReal . '/' . $relative) : false;

            if ($real !== false && is_file($real) && str_starts_with($real, $rootReal . DIRECTORY_SEPARATOR)) {
                $found[] = $real;
            }
        }

        return array_values(array_unique($found));
    }

    private function mimeOf(string $storedPath): string
    {
        $full = Storage::disk(config('attachments.disk'))->path($storedPath);

        return (new \finfo(FILEINFO_MIME_TYPE))->file($full) ?: 'application/octet-stream';
    }
}

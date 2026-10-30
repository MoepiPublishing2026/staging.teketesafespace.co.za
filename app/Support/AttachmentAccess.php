<?php

namespace App\Support;

use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\URL;

/**
 * Who may open a report's attachments, and how links to them are built.
 * Scoping mirrors the report-list controllers: school = own school,
 * provincial = own province, district = own district, national = all.
 * Any other role is denied.
 */
class AttachmentAccess
{
    public static function canView(?User $user, Report $report): bool
    {
        if (! $user) {
            return false;
        }

        return match ($user->role) {
            'national'    => true,
            'provincial'  => filled($user->province_id) && (int) $user->province_id === (int) $report->province_id,
            'district'    => filled($user->district_id) && (int) $user->district_id === (int) $report->district_id,
            'school'      => filled($user->school_name) && $user->school_name === $report->school_name,
            default       => false,
        };
    }

    /** The decoded list of stored paths on a report */
    public static function paths(Report $report): array
    {
        $raw = $report->image_path;

        if (blank($raw)) {
            return [];
        }

        $decoded = json_decode($raw, true);

        if (is_array($decoded)) {
            return array_values(array_filter($decoded, 'is_string'));
        }

        return is_string($raw) ? [$raw] : [];
    }

    /** Authenticated link for administrators*/
    public static function adminUrl(int $reportId, string $path): string
    {
        return route('attachments.show', ['report' => $reportId, 'file' => basename($path)]);
    }

    /** All admin links for a report, in the same order as its stored paths. */
    public static function adminUrls(Report $report): array
    {
        return array_map(fn ($p) => self::adminUrl($report->id, $p), self::paths($report));
    }

    /** Short-lived signed link for the reporter (check-status / edit-report). */
    public static function reporterUrl(string $caseNumber, string $path): string
    {
        return URL::temporarySignedRoute(
            'attachments.reporter',
            now()->addMinutes((int) config('attachments.reporter_link_minutes', 30)),
            ['caseNumber' => $caseNumber, 'file' => basename($path)]
        );
    }
}

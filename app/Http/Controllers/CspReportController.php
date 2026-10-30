<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Receives Content-Security-Policy violation reports from browsers (report-uri) so the
 * policy can be tuned in report-only mode before it is enforced.
 *
 * Public endpoint by design, therefore: throttled (route), body capped, input treated as
 * untrusted (clipped, query strings stripped so case numbers / tokens never reach the log),
 * and it never echoes anything back.
 */
class CspReportController extends Controller
{
    private const MAX_BODY = 8192;

    /** Blocked URIs that are just browser extensions / noise, not our pages. */
    private const IGNORE = ['chrome-extension', 'moz-extension', 'safari-extension', 'safari-web-extension', 'webkit-masked-url'];

    public function __invoke(Request $request): Response
    {
        $raw = $request->getContent();

        if (strlen($raw) > self::MAX_BODY) {
            return response('', 413);
        }

        $data = json_decode($raw, true);

        // Legacy format {"csp-report": {...}} or Reporting API format [ {"type":"csp-violation","body":{...}} ]
        $report = is_array($data) ? ($data['csp-report'] ?? ($data[0]['body'] ?? null)) : null;

        if (! is_array($report)) {
            return response('', 204);
        }

        $blocked = $this->uri($report['blocked-uri'] ?? $report['blockedURL'] ?? $report['blockedURI'] ?? '');

        foreach (self::IGNORE as $noise) {
            if (str_starts_with($blocked, $noise)) {
                return response('', 204);
            }
        }

        Log::channel('csp')->warning('csp.violation', [
            'directive'   => $this->text($report['effective-directive'] ?? $report['effectiveDirective'] ?? $report['violated-directive'] ?? ''),
            'blocked'     => $blocked,
            'page'        => $this->uri($report['document-uri'] ?? $report['documentURL'] ?? ''),
            'source_file' => $this->uri($report['source-file'] ?? $report['sourceFile'] ?? ''),
            'line'        => (int) ($report['line-number'] ?? $report['lineNumber'] ?? 0),
            'disposition' => $this->text($report['disposition'] ?? ''),
            'ip'          => $request->ip(),
        ]);

        return response('', 204);
    }

    /** URL without query string or fragment, clipped. */
    private function uri(mixed $value): string
    {
        $value = is_string($value) ? $value : '';

        return $this->text(strtok($value, '?#') ?: '');
    }

    private function text(mixed $value): string
    {
        $value = is_string($value) ? $value : '';

        return mb_substr(preg_replace('/[^\P{C}]/u', '', $value) ?? '', 0, 200);
    }
}

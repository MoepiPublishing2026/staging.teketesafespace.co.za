<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Support\AttachmentAccess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * The ONLY way report attachments leave the server.
 *
 *  - admin  : GET /attachments/{report}/{file}              (auth + role/ownership check)
 *  - reporter: GET /report-attachments/{caseNumber}/{file}  (signed, short-lived link)
 *
 * Files live outside the web root. The response type comes from the file
 * content, never from the stored name, and anything outside the allow-list
 * is forced to download.
 */
class AttachmentController extends Controller
{
    public function show(Request $request, int $report, string $file): BaseResponse
    {
        // Explicit status codes (not abort()): the app's global admin exception handler would
        // otherwise turn a 403/404 into a generic 500 page and log it as an admin failure.
        $user = $request->user();
        if (! $user) {
            return $this->deny(401);
        }

        $model = Report::find($report);
        if (! $model) {
            return $this->deny(404);
        }

        if (! AttachmentAccess::canView($user, $model)) {
            Log::warning('attachment.denied', ['user_id' => $user->id, 'role' => $user->role, 'report' => $model->id, 'ip' => $request->ip()]);
            return $this->deny(403);
        }

        Log::info('attachment.viewed', [
            'user_id' => $user->id,
            'role'    => $user->role,
            'report'  => $model->id,
            'file'    => $file,
            'ip'      => $request->ip(),
        ]);

        return $this->respond($model, $file);
    }

    public function showForReporter(Request $request, string $caseNumber, string $file): BaseResponse
    {
        // Authenticity comes from the 'signed' middleware on the route.
        $model = Report::where('case_number', $caseNumber)->first();

        return $model ? $this->respond($model, $file) : $this->deny(404);
    }

    private function deny(int $status): Response
    {
        return response('', $status, ['Cache-Control' => 'no-store', 'X-Content-Type-Options' => 'nosniff']);
    }

    private function respond(Report $report, string $file): BaseResponse
    {
        $absolute = $this->locate($report, $file);
        if (! $absolute) {
            return $this->deny(404);
        }

        $mime    = (new \finfo(FILEINFO_MIME_TYPE))->file($absolute) ?: 'application/octet-stream';
        $allowed = isset(config('attachments.types', [])[$mime]);

        $response = response()->file($absolute, [
            'Content-Type'           => $allowed ? $mime : 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control'          => 'private, no-store, max-age=0',
            'Referrer-Policy'        => 'no-referrer',
        ]);

        $fallback = preg_replace('/[^A-Za-z0-9._-]/', '_', $file);
        $response->setContentDisposition($allowed ? 'inline' : 'attachment', $file, $fallback);

        return $response;
    }

    /**
     * Resolve {file} to a real path, but only if it is one of THIS report's
     * stored attachments and sits inside an expected storage root.
     */
    private function locate(Report $report, string $file): ?string
    {
        $roots = array_filter([
            'attachments' => realpath((string) config('filesystems.disks.attachments.root')),
            'legacy'      => realpath(storage_path('app/public')),
            'legacy-pub'  => realpath(public_path('storage')),
        ]);

        foreach (AttachmentAccess::paths($report) as $entry) {
            $entry = ltrim(str_replace('\\', '/', $entry), '/');

            if (str_contains($entry, '..') || basename($entry) !== $file) {
                continue;
            }

            foreach ($roots as $root) {
                $real = realpath($root . '/' . $entry);

                if ($real !== false && is_file($real) && str_starts_with($real, $root . DIRECTORY_SEPARATOR)) {
                    return $real;
                }
            }
        }

        return null;
    }
}

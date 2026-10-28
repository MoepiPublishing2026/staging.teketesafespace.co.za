<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Single entry point for putting a report attachment on disk.
 *
 *  - type is decided from file CONTENT against config('attachments.types')
 *  - per-kind size limit, image pixel limit and memory guard
 *  - optional ClamAV scan (config('attachments.antivirus'))
 *  - JPEG/PNG/WebP are re-encoded (strips EXIF/GPS/XMP and polyglot payloads),
 *    keeping EXIF orientation and PNG/WebP transparency
 *  - stored on the private disk under a generated name, never the client's
 */
class AttachmentStore
{
    public const DIR = 'reports';

    // ---------------------------------------------------------------- rules

    /** @return array<string,string> mime => extension */
    public static function types(): array
    {
        return config('attachments.types', []);
    }

    /** Validation rules for ONE uploaded file (used for image.* / newUploads.*). */
    public static function fileRules(): array
    {
        return [
            'file',
            'max:' . (int) config('attachments.max_kb', 102400),
            'mimetypes:' . implode(',', array_keys(self::types())),
            function ($attribute, $value, $fail) {
                if ($value instanceof UploadedFile && ($error = app(self::class)->validate($value))) {
                    $fail($error);
                }
            },
        ];
    }

    /** Returns null when acceptable, otherwise a message safe to show the reporter. */
    public function validate(UploadedFile $file): ?string
    {
        $meta = $this->describe((string) $file->getRealPath());

        return is_string($meta) ? $meta : null;
    }

    // ------------------------------------------------------------- inspection

    /**
     * @return array{mime:string,ext:string,kind:string}|string  metadata, or an error message
     */
    public function describe(string $path): array|string
    {
        if ($path === '' || ! is_file($path) || ! is_readable($path)) {
            return 'The file could not be read.';
        }

        $mime  = (new \finfo(FILEINFO_MIME_TYPE))->file($path) ?: '';
        $types = self::types();

        if (! isset($types[$mime])) {
            return 'This file type is not allowed. Please upload a photo (JPG, PNG, WebP or GIF), a PDF, or an audio/video recording.';
        }

        $kind  = self::kind($mime);
        $limit = (int) config("attachments.max_bytes.$kind", 0);
        $size  = (int) filesize($path);

        if ($limit > 0 && $size > $limit) {
            return sprintf('This file is too large. The limit for %s files is %s.', $kind === 'pdf' ? 'PDF' : $kind, self::human($limit));
        }

        if (str_starts_with($mime, 'image/')) {
            $info = @getimagesize($path);
            if ($info === false) {
                return 'This image looks damaged or is not a valid image.';
            }
            if ($info[0] * $info[1] > (int) config('attachments.max_pixels', 50_000_000)) {
                return 'This image has too many pixels. Please upload a smaller version.';
            }
        }

        return ['mime' => $mime, 'ext' => $types[$mime], 'kind' => $kind];
    }

    public static function kind(string $mime): string
    {
        return match (true) {
            str_starts_with($mime, 'image/') => 'image',
            $mime === 'application/pdf'      => 'pdf',
            str_starts_with($mime, 'video/') => 'video',
            default                          => 'audio',
        };
    }

    // --------------------------------------------------------------- storing

    /**
     * Store several uploads; if any one is rejected, remove the ones already
     * written so a failed submit leaves nothing behind.
     *
     * @param  iterable<UploadedFile> $files
     * @return string[] relative paths (e.g. reports/01j....jpg)
     */
    public function storeMany(iterable $files): array
    {
        $stored = [];

        try {
            foreach ($files as $file) {
                $stored[] = $this->store($file);
            }
        } catch (\Throwable $e) {
            foreach ($stored as $path) {
                Storage::disk(config('attachments.disk'))->delete($path);
            }
            throw $e;
        }

        return $stored;
    }

    /** Returns the relative path to save in reports.image_path. */
    public function store(UploadedFile $file): string
    {
        return $this->storeFromPath((string) $file->getRealPath());
    }

    /**
     * @param string      $source     file on local disk
     * @param bool        $lenient    legacy migration: keep files that fail the allow-list
     *                                (stored under a safe name, never served inline)
     * @param string|null $legacyName original file name, used only in lenient mode
     */
    public function storeFromPath(string $source, bool $lenient = false, ?string $legacyName = null): string
    {
        $meta = $this->describe($source);

        if (is_string($meta)) {
            if (! $lenient) {
                $this->reject($meta);
            }
            $meta = ['mime' => 'application/octet-stream', 'ext' => self::legacyExtension($legacyName), 'kind' => 'other'];
        }

        $this->scan($source);

        $path = self::DIR . '/' . strtolower((string) Str::ulid()) . '.' . $meta['ext'];
        $disk = Storage::disk(config('attachments.disk'));

        $data = $this->reencode($source, $meta['mime'], $lenient);

        if ($data !== null) {
            $disk->put($path, $data);
        } else {
            $handle = fopen($source, 'rb');
            try {
                $disk->put($path, $handle);   // streamed: large videos are never loaded into memory
            } finally {
                if (is_resource($handle)) {
                    fclose($handle);
                }
            }
        }

        return $path;
    }

    // -------------------------------------------------------------- internals

    private function scan(string $source): void
    {
        $scanner = app(VirusScanner::class);

        if (! $scanner->enabled()) {
            return;
        }

        try {
            $signature = $scanner->scan($source);
        } catch (\Throwable $e) {
            Log::error('Attachment antivirus scan failed: ' . $e->getMessage());

            if (config('attachments.antivirus.fail_open')) {
                return;
            }
            $this->reject('We could not safely check this file right now. Please try again later, or submit your report without the attachment.');
        }

        if ($signature !== null) {
            Log::warning('Attachment blocked by antivirus', ['signature' => $signature]);
            $this->reject('This file was blocked by our security scan and was not uploaded.');
        }
    }

    /** @return string|null re-encoded bytes, or null when the file should be stored unchanged */
    private function reencode(string $source, string $mime, bool $lenient): ?string
    {
        if (! in_array($mime, (array) config('attachments.reencode'), true)) {
            return null;
        }

        $this->assertMemory($source, $lenient);

        $img = @imagecreatefromstring((string) file_get_contents($source));
        if ($img === false) {
            if ($lenient) {
                return null;
            }
            $this->reject('This image looks damaged or is not a valid image.');
        }

        if ($mime === 'image/jpeg') {
            $img = $this->applyExifOrientation($img, $source);
        } else {
            imagealphablending($img, false);   // keep transparency through the re-encode
            imagesavealpha($img, true);
        }

        ob_start();
        match ($mime) {
            'image/png'  => imagepng($img),
            'image/webp' => imagewebp($img, null, 85),
            default      => imagejpeg($img, null, 85),
        };
        $data = (string) ob_get_clean();
        imagedestroy($img);

        if ($data === '') {
            if ($lenient) {
                return null;
            }
            $this->reject('This image could not be processed. Please try a different one.');
        }

        return $data;
    }

    /** Re-encoding drops EXIF, so bake the orientation in first or phone photos end up sideways. */
    private function applyExifOrientation(\GdImage $img, string $source): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $img;
        }

        $exif        = @exif_read_data($source);
        $orientation = (int) ($exif['Orientation'] ?? 1);

        $rotated = match ($orientation) {
            3       => imagerotate($img, 180, 0),
            6       => imagerotate($img, -90, 0),
            8       => imagerotate($img, 90, 0),
            default => null,
        };

        if ($rotated instanceof \GdImage) {
            imagedestroy($img);
            return $rotated;
        }

        if ($orientation === 2) {
            imageflip($img, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 4) {
            imageflip($img, IMG_FLIP_VERTICAL);
        }

        return $img;
    }

    /** GD holds ~4 bytes per pixel (twice while rotating). Refuse instead of dying with a fatal. */
    private function assertMemory(string $source, bool $lenient): void
    {
        $limit = self::bytes((string) ini_get('memory_limit'));
        $info  = @getimagesize($source);

        if ($limit <= 0 || $info === false) {
            return;
        }

        $needed = ($info[0] * $info[1] * 4 * 2) + (filesize($source) * 2);

        if (memory_get_usage(true) + $needed > $limit * 0.9) {
            if ($lenient) {
                throw new \RuntimeException('Not enough memory to re-encode ' . basename($source));
            }
            $this->reject('This photo is too large to process. Please upload a smaller version.');
        }
    }

    private function reject(string $message): never
    {
        throw ValidationException::withMessages(['image' => $message]);
    }

    private static function legacyExtension(?string $name): string
    {
        $ext = strtolower(preg_replace('/[^a-z0-9]/i', '', pathinfo((string) $name, PATHINFO_EXTENSION)));
        $blocked = ['php', 'phtml', 'phar', 'html', 'htm', 'shtml', 'svg', 'js', 'exe', 'sh', 'bat', 'cgi', 'pl', 'py', 'asp', 'aspx', 'jsp', 'htaccess'];

        return ($ext === '' || strlen($ext) > 5 || in_array($ext, $blocked, true)) ? 'bin' : $ext;
    }

    private static function human(int $bytes): string
    {
        return $bytes >= 1048576 ? round($bytes / 1048576) . ' MB' : round($bytes / 1024) . ' KB';
    }

    private static function bytes(string $value): int
    {
        $value = trim($value);
        if ($value === '' || $value === '-1') {
            return -1;
        }
        $unit = strtolower(substr($value, -1));
        $num  = (int) $value;

        return match ($unit) {
            'g'     => $num * 1073741824,
            'm'     => $num * 1048576,
            'k'     => $num * 1024,
            default => $num,
        };
    }
}

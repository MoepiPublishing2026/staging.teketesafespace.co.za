<?php

/*
|--------------------------------------------------------------------------
| Report attachment policy (task #10)
|--------------------------------------------------------------------------
| Single source of truth for what may be uploaded. config/livewire.php reads
| the "types" list from here so the temporary-upload gate and the permanent
| store can never disagree.
*/

return [

    // Private disk (config/filesystems.php) - NOT reachable from the web root.
    "disk" => "attachments",

    // Allow-list, keyed by the MIME type detected from the file CONTENT.
    // The client-supplied extension / MIME type is never trusted.
    "types" => [
        "image/jpeg"      => "jpg",
        "image/png"       => "png",
        "image/gif"       => "gif",
        "image/webp"      => "webp",
        "application/pdf" => "pdf",
        "text/plain"      => "txt",
        "video/mp4"       => "mp4",
        "video/quicktime" => "mov",
        "video/webm"      => "webm",
        "video/3gpp"      => "3gp",
        "audio/mpeg"      => "mp3",
        "audio/mp4"       => "m4a",
        "audio/x-m4a"     => "m4a",
        "audio/aac"       => "aac",
        "audio/wav"       => "wav",
        "audio/x-wav"     => "wav",
        "audio/ogg"       => "ogg",
        "application/ogg" => "ogg",
        "audio/webm"      => "webm",
        "audio/3gpp"      => "3gp",
        "audio/amr"       => "amr",
    ],

    // Images in these formats are decoded and re-encoded, which drops EXIF
    // (incl. GPS), XMP, IPTC and any appended/polyglot payload. GIF is
    // validated but stored as-is so animation survives (GIF carries no EXIF/GPS).
    "reencode" => ["image/jpeg", "image/png", "image/webp"],

    // Outer ceiling used by the Livewire temporary-upload endpoint (KB).
    "max_kb" => 102400,

    // Per-kind ceilings, in bytes, enforced on the sniffed type.
    "max_bytes" => [
        "image" => 10 * 1024 * 1024,
        "pdf"   => 20 * 1024 * 1024,
        "text"  => 1 * 1024 * 1024,
        "audio" => 50 * 1024 * 1024,
        "video" => 100 * 1024 * 1024,
    ],

    // Decompression-bomb guard for images (width x height).
    "max_pixels" => (int) env("ATTACHMENT_MAX_PIXELS", 50_000_000),

    // Number of attachments.
    "max_per_report" => 5,   // new report / new uploads in one edit
    "max_total"      => 10,  // existing + new on one report

    // Seconds a reporter's signed attachment link stays valid.
    "reporter_link_minutes" => 30,

    // ClamAV (clamd). Off until you install/configure it.
    "antivirus" => [
        "enabled"   => (bool) env("CLAMAV_ENABLED", false),
        "socket"    => env("CLAMAV_SOCKET"),            // e.g. /var/run/clamav/clamd.ctl
        "host"      => env("CLAMAV_HOST", "127.0.0.1"),
        "port"      => (int) env("CLAMAV_PORT", 3310),
        "timeout"   => (int) env("CLAMAV_TIMEOUT", 30),
        // false = if the scanner is down, REJECT the attachment (safe default).
        "fail_open" => (bool) env("CLAMAV_FAIL_OPEN", false),
    ],
];

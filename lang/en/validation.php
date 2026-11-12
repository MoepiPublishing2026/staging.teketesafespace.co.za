<?php

$types  = 'You can attach photos (JPG, PNG, GIF or WebP), PDFs, text (.txt) documents, or audio and video recordings.';
$tooBig = 'That attachment is too large. Limits: photos 10 MB, PDFs 20 MB, text 1 MB, audio 50 MB, video 100 MB.';
$failed = 'The upload did not go through. The attachment may be too large, or your connection may have dropped. '
        . 'Please try again, or choose a smaller one. If you added several in a row, wait a minute first.';

$messages = [
    'file'      => 'That does not look like a valid attachment. Please choose another one.',
    'mimetypes' => "That type of document cannot be attached. $types",
    'max'       => $tooBig,
    'uploaded'  => $failed,
];

return [
    // Used when the upload request itself fails (server limit, rate limit, dropped connection).
    'uploaded' => $failed,

    'custom' => [
        'files.*'      => $messages,  // Livewire's temporary-upload step (shown as newUploads.*)
        'newUploads.*' => $messages,  // re-check on submit
        'image.*'      => $messages,
    ],
];
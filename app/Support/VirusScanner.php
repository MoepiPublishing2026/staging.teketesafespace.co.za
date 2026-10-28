<?php

namespace App\Support;

/**
 * Minimal ClamAV (clamd) client using the INSTREAM protocol, so the file is
 * streamed to the daemon and no path needs to be readable by the clamav user.
 *
 * Needs clamd running locally or reachable over TCP. For files above 25 MB
 * raise StreamMaxLength in clamd.conf (e.g. StreamMaxLength 110M), otherwise
 * clamd answers "INSTREAM size limit exceeded" and the upload is rejected.
 */
class VirusScanner
{
    public function enabled(): bool
    {
        return (bool) config('attachments.antivirus.enabled');
    }

    /**
     * @return string|null  signature name when infected, null when clean
     * @throws \RuntimeException when the scanner cannot give a verdict
     */
    public function scan(string $path): ?string
    {
        $cfg     = (array) config('attachments.antivirus');
        $timeout = max(1, (int) ($cfg['timeout'] ?? 30));
        $target  = filled($cfg['socket'] ?? null)
            ? 'unix://' . $cfg['socket']
            : 'tcp://' . ($cfg['host'] ?? '127.0.0.1') . ':' . ($cfg['port'] ?? 3310);

        $sock = @stream_socket_client($target, $errno, $errstr, min($timeout, 10));
        if (! $sock) {
            throw new \RuntimeException("ClamAV unreachable at {$target}: {$errstr}");
        }
        stream_set_timeout($sock, $timeout);

        $file = @fopen($path, 'rb');
        if (! $file) {
            fclose($sock);
            throw new \RuntimeException('Cannot open file for scanning.');
        }

        try {
            $this->write($sock, "zINSTREAM\0");

            while (! feof($file)) {
                $chunk = fread($file, 8192);
                if ($chunk === false) {
                    throw new \RuntimeException('Read error while streaming to ClamAV.');
                }
                if ($chunk === '') {
                    break;
                }
                $this->write($sock, pack('N', strlen($chunk)) . $chunk);
            }

            $this->write($sock, pack('N', 0));

            $response = trim((string) stream_get_contents($sock), "\0 \n\r\t");
            if ((stream_get_meta_data($sock)['timed_out'] ?? false) || $response === '') {
                throw new \RuntimeException('ClamAV did not answer in time.');
            }
        } finally {
            fclose($file);
            fclose($sock);
        }

        if (preg_match('/^stream:\s*(.+?)\s+FOUND$/s', $response, $m)) {
            return $m[1];
        }
        if (preg_match('/^stream:\s*OK$/', $response)) {
            return null;
        }

        throw new \RuntimeException('Unexpected ClamAV response: ' . $response);
    }

    private function write($sock, string $data): void
    {
        $length = strlen($data);
        $offset = 0;

        while ($offset < $length) {
            $written = @fwrite($sock, substr($data, $offset));
            if ($written === false || $written === 0) {
                throw new \RuntimeException('Write to ClamAV failed.');
            }
            $offset += $written;
        }
    }
}

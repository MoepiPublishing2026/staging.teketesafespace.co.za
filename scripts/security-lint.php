<?php
/**
 * Static security lint. Run:  php scripts/security-lint.php
 *
 * Fails (exit 1) when it finds a pattern that caused, or could cause, injection / XSS:
 *   - unescaped Blade output  {!! ... !!}
 *   - JSON written into a page with json_encode()/toJson() instead of @json
 *   - @json([ ... ]) literals (Blade splits @json arguments on commas and silently truncates)
 *   - '{{ value }}' string literals inside wire:click / onclick / x-on / @click handlers
 *   - addslashes() used as an escaper
 *   - innerHTML / insertAdjacentHTML / document.write built from data without escapeHtml()
 *   - raw SQL fragments that interpolate a variable
 *   - eval/exec-style functions and unserialize() on variables
 *
 * A line that is reviewed and genuinely safe can carry the marker  security-lint:ignore  plus a reason.
 * Dependency-free on purpose, so CI needs no composer install and no database.
 */

$root = dirname(__DIR__);
$problems = [];

function files(string $dir, array $exts, array $skip = []): Generator
{
    if (! is_dir($dir)) {
        return;
    }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        $p = str_replace('\\', '/', (string) $f);
        foreach ($skip as $s) {
            if (str_contains($p, $s)) {
                continue 2;
            }
        }
        foreach ($exts as $e) {
            if (str_ends_with($p, $e)) {
                yield $p;
                break;
            }
        }
    }
}

function flag(array &$problems, string $root, string $file, int $line, string $rule, string $text): void
{
    $problems[] = sprintf('%s:%d  [%s]  %s', ltrim(str_replace($root, '', $file), '/'), $line, $rule, trim(mb_substr($text, 0, 140)));
}

$viewSkip = ['/vendor/', '/node_modules/'];

//  Blade views
foreach (files("$root/resources/views", ['.blade.php'], $viewSkip) as $file) {
    foreach (preg_split('/\R/', (string) file_get_contents($file)) as $i => $line) {
        $n = $i + 1;
        if (str_contains($line, 'security-lint:ignore')) {
            continue;
        }
        if (str_contains($line, '{!!')) {
            flag($problems, $root, $file, $n, 'unescaped-output', $line);
        }
        if (preg_match('/json_encode\(|->toJson\(\)/', $line) && preg_match('/<script|\{\{|\{!!|JSON\.parse/', $line)) {
            flag($problems, $root, $file, $n, 'json-in-page', $line);
        }
        if (preg_match('/@json\(\s*\[/', $line)) {
            flag($problems, $root, $file, $n, 'json-literal', $line);
        }
        if (preg_match('/(wire:click|onclick|onchange|onsubmit|x-on:[\w.:-]+|@click|@change)(\.\w+)*="[^"]*[\'"`]\{\{/', $line)) {
            flag($problems, $root, $file, $n, 'quoted-value-in-handler', $line);
        }
        if (str_contains($line, 'addslashes(')) {
            flag($problems, $root, $file, $n, 'addslashes-as-escaper', $line);
        }
    }
}

//  JavaScript sinks (views + public/js)
$jsSources = array_merge(
    iterator_to_array(files("$root/resources/views", ['.blade.php'], $viewSkip), false),
    iterator_to_array(files("$root/public/js", ['.js'], ['.min.js', '/vendor/']), false),
    iterator_to_array(files("$root/resources/js", ['.js'], []), false)
);
foreach ($jsSources as $file) {
    foreach (preg_split('/\R/', (string) file_get_contents($file)) as $i => $line) {
        if (str_contains($line, 'security-lint:ignore')) {
            continue;
        }
        if (preg_match('/\.(innerHTML|outerHTML)\s*\+?=|insertAdjacentHTML\(|document\.write(ln)?\(/', $line)) {
            $dynamic = preg_match('/\$\{|[\'"`]\s*\+\s*[A-Za-z_(]|[A-Za-z_)\]]\s*\+\s*[\'"`]/', $line);
            if ($dynamic && ! str_contains($line, 'escapeHtml(')) {
                flag($problems, $root, $file, $i + 1, 'html-sink-without-escapeHtml', $line);
            }
        }
        if (preg_match('/\beval\s*\(|new Function\s*\(/', $line) && ! str_contains($line, '//')) {
            flag($problems, $root, $file, $i + 1, 'js-eval', $line);
        }
    }
}

//  PHP
foreach (array_merge(
    iterator_to_array(files("$root/app", ['.php']), false),
    iterator_to_array(files("$root/routes", ['.php']), false)
) as $file) {
    $src = (string) file_get_contents($file);
    foreach (preg_split('/\R/', $src) as $i => $line) {
        if (str_contains($line, 'security-lint:ignore')) {
            continue;
        }
        // raw SQL fragment that interpolates ("...$x...", "..{$x}.." or '...' . $x)
        if (preg_match('/(whereRaw|orderByRaw|selectRaw|havingRaw|groupByRaw|DB::raw|DB::select|DB::statement|DB::unprepared)\s*\(\s*("[^"]*\$|\'[^\']*\'\s*\.\s*\$)/', $line)) {
            flag($problems, $root, $file, $i + 1, 'raw-sql-interpolation', $line);
        }
        if (preg_match('/\b(shell_exec|passthru|proc_open|popen|system|exec)\s*\(/', $line) && ! preg_match('/->exec\(|::exec\(|function\s+exec/', $line)) {
            flag($problems, $root, $file, $i + 1, 'command-execution', $line);
        }
        if (preg_match('/\beval\s*\(|unserialize\s*\(\s*\$/', $line)) {
            flag($problems, $root, $file, $i + 1, 'eval-or-unserialize', $line);
        }
    }
}

//  result
if ($problems) {
    fwrite(STDERR, "Security lint found " . count($problems) . " problem(s):\n\n");
    foreach ($problems as $p) {
        fwrite(STDERR, "  $p\n");
    }
    fwrite(STDERR, "\nFix them, or - only if reviewed and safe - add 'security-lint:ignore <reason>' to the line.\n");
    exit(1);
}

echo "Security lint: OK (views, JS sinks and PHP checked)\n";
exit(0);

<?php
function ensureDir(string $path): void
{
    if (!is_dir($path)) {
        mkdir($path, 0775, true);
    }
}

function appendLine(string $file, string $line): void
{
    ensureDir(dirname($file));
    $fh = fopen($file, 'a');
    if ($fh === false) {
        throw new RuntimeException('Unable to open file for writing: ' . $file);
    }
    fwrite($fh, $line . PHP_EOL);
    fclose($fh);
}

function readLines(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }
    return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
}

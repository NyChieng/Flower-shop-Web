<?php
function ensureDir(string $directory): void
{
    if ($directory === '' || is_dir($directory)) {
        return;
    }
    mkdir($directory, 0775, true);
}

function appendLine(string $filePath, string $line): void
{
    ensureDir(dirname($filePath));
    $handle = fopen($filePath, 'a');
    if ($handle === false) {
        throw new RuntimeException('Unable to open file for writing: ' . $filePath);
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            throw new RuntimeException('Unable to obtain file lock: ' . $filePath);
        }
        fwrite($handle, $line . PHP_EOL);
        fflush($handle);
        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }
}

function readLines(string $filePath): array
{
    if (!file_exists($filePath)) {
        return [];
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES);
    return $lines === false ? [] : $lines;
}

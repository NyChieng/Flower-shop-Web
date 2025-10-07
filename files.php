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

function parseDelimitedRecord(string $line, string $pairDelimiter = '|'): array
{
    $record = [];
    foreach (explode($pairDelimiter, $line) as $segment) {
        $segment = trim($segment);
        if ($segment === '') {
            continue;
        }

        [$key, $value] = array_pad(explode(':', $segment, 2), 2, '');
        $key = trim($key);
        if ($key === '') {
            continue;
        }
        $record[$key] = trim($value);
    }

    return $record;
}

function findRecordByField(string $filePath, string $field, string $value, bool $caseInsensitive = true): ?array
{
    if (!file_exists($filePath)) {
        return null;
    }

    foreach (readLines($filePath) as $line) {
        $record = parseDelimitedRecord($line);
        if (!array_key_exists($field, $record)) {
            continue;
        }

        $storedValue = $record[$field];
        if ($caseInsensitive) {
            if (strcasecmp($storedValue, $value) === 0) {
                return $record;
            }
        } elseif ($storedValue === $value) {
            return $record;
        }
    }

    return null;
}

function readDelimitedRecords(string $filePath, string $pairDelimiter = '|'): array
{
    $records = [];
    foreach (readLines($filePath) as $line) {
        if (trim($line) === '') {
            continue;
        }
        $records[] = parseDelimitedRecord($line, $pairDelimiter);
    }

    return $records;
}

<?php
function req($value): bool
{
    return isset($value) && trim($value) !== '';
}

function alphaSpace(string $value): bool
{
    return (bool)preg_match('/^[a-zA-Z ]+$/', $value);
}

function validEmailFormat(string $email): bool
{
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function strongPwd(string $password): bool
{
    return strlen($password) >= 8 && preg_match('/\d/', $password) && preg_match('/[^A-Za-z0-9]/', $password);
}

function matchValue($a, $b): bool
{
    return $a === $b;
}

function uniqueEmail(string $email, string $pathToUserFile): bool
{
    if (!file_exists($pathToUserFile)) {
        return true;
    }

    $lines = file($pathToUserFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) {
        return true;
    }

    foreach ($lines as $line) {
        if (preg_match('/\bEmail:([^|]+)/', $line, $m)) {
            if (strcasecmp(trim($m[1]), $email) === 0) {
                return false;
            }
        }
    }

    return true;
}

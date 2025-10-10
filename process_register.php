<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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

function valuesMatch($a, $b): bool
{
    return $a === $b;
}

function userDataDirectory(): string
{
    $xamppRoot = dirname(__DIR__, 3);
    $directory = $xamppRoot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'User';
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
    return $directory;
}

function userDataPath(): string
{
    return userDataDirectory() . DIRECTORY_SEPARATOR . 'user.txt';
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
        $record = parseDelimitedRecord($line);
        if (!array_key_exists('Email', $record)) {
            continue;
        }
        if (strcasecmp($record['Email'], $email) === 0) {
            return false;
        }
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registration.php');
    exit;
}

$userFile = userDataPath();

$values = [
    'first_name'       => trim($_POST['first_name'] ?? ''),
    'last_name'        => trim($_POST['last_name'] ?? ''),
    'dob'              => trim($_POST['dob'] ?? ''),
    'gender'           => $_POST['gender'] ?? 'Female',
    'email'            => trim($_POST['email'] ?? ''),
    'hometown'         => trim($_POST['hometown'] ?? ''),
    'password'         => trim($_POST['password'] ?? ''),
    'confirm_password' => trim($_POST['confirm_password'] ?? ''),
];

$errors = [];
$addError = function(string $key, string $message) use (&$errors) {
    $errors[$key][] = $message;
};

if (!req($values['first_name'])) {
    $addError('first_name', 'First name is required.');
} elseif (!alphaSpace($values['first_name'])) {
    $addError('first_name', 'Only letters and white space allowed.');
}

if (!req($values['last_name'])) {
    $addError('last_name', 'Last name is required.');
} elseif (!alphaSpace($values['last_name'])) {
    $addError('last_name', 'Only letters and white space allowed.');
}

if (!req($values['dob'])) {
    $addError('dob', 'Date of birth is required.');
}

if (!req($values['gender'])) {
    $addError('gender', 'Please select a gender.');
}

if (!req($values['email'])) {
    $addError('email', 'Email is required.');
} elseif (!validEmailFormat($values['email'])) {
    $addError('email', 'Invalid email format.');
}

if (!req($values['hometown'])) {
    $addError('hometown', 'Hometown is required.');
}

if (!req($values['password'])) {
    $addError('password', 'Password is required.');
} elseif (!strongPwd($values['password'])) {
    $addError('password', 'Password must contain at least 8 characters with a number and a symbol.');
}

if (!req($values['confirm_password'])) {
    $addError('confirm_password', 'Please confirm your password.');
} elseif (!valuesMatch($values['password'], $values['confirm_password'])) {
    $addError('confirm_password', 'Password and confirm password do not match.');
}

if (!isset($errors['email']) && !uniqueEmail($values['email'], $userFile)) {
    $addError('email', 'This email is already registered.');
}

if (!empty($errors)) {
    $values['password'] = '';
    $values['confirm_password'] = '';
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_values'] = $values;
    header('Location: registration.php');
    exit;
}

ensureDir(dirname($userFile));

$dobFormatted = $values['dob'];
if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dobFormatted)) {
    $dobFormatted = date('d-m-Y', strtotime($dobFormatted));
}

$record = 'First Name:' . $values['first_name']
        . '|Last Name:' . $values['last_name']
        . '|DOB:' . $dobFormatted
        . '|Gender:' . $values['gender']
        . '|Email:' . $values['email']
        . '|Hometown:' . $values['hometown']
        . '|Password:' . $values['password'];

appendLine($userFile, $record);

unset($_SESSION['register_errors'], $_SESSION['register_values']);

header('Location: login.php?registered=1');
exit;


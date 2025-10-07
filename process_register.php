<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/files.php';

startSessionIfNeeded();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registration.php');
    exit;
}

$userFile = __DIR__ . '/data/User/user.txt';

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


<?php
session_start();

require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/lib/files.php';

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

if (!req($values['first_name'])) {
    $errors['first_name'][] = 'First name is required.';
} elseif (!alphaSpace($values['first_name'])) {
    $errors['first_name'][] = 'Only letters and spaces allowed.';
}

if (!req($values['last_name'])) {
    $errors['last_name'][] = 'Last name is required.';
} elseif (!alphaSpace($values['last_name'])) {
    $errors['last_name'][] = 'Only letters and spaces allowed.';
}

if (!req($values['dob'])) {
    $errors['dob'][] = 'Date of birth is required.';
}

if (!req($values['gender'])) {
    $errors['gender'][] = 'Please choose a gender option.';
}

if (!req($values['email'])) {
    $errors['email'][] = 'Email is required.';
} elseif (!validEmailFormat($values['email'])) {
    $errors['email'][] = 'Invalid email format.';
}

if (!req($values['hometown'])) {
    $errors['hometown'][] = 'Hometown is required.';
}

if (!req($values['password'])) {
    $errors['password'][] = 'Password is required.';
} elseif (!strongPwd($values['password'])) {
    $errors['password'][] = 'Password must be =8 characters with a number and a symbol.';
}

if (!req($values['confirm_password'])) {
    $errors['confirm_password'][] = 'Please confirm your password.';
} elseif (!matchValue($values['password'], $values['confirm_password'])) {
    $errors['confirm_password'][] = 'Password and confirm password do not match.';
}

if (!isset($errors['email']) && !uniqueEmail($values['email'], $userFile)) {
    $errors['email'][] = 'Email is already registered.';
}

if (!empty($errors)) {
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

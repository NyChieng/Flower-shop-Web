<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

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

function uniqueEmailDB(string $email): bool
{
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT email FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return !$exists;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registration.php');
    exit;
}

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

if (!isset($errors['email']) && !uniqueEmailDB($values['email'])) {
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

// Save to database
try {
    $conn = getDBConnection();
    
    // Start transaction
    $conn->begin_transaction();
    
    // Insert into user_table
    $stmt = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) VALUES (?, ?, ?, ?, ?, ?, NULL)");
    $stmt->bind_param("ssssss", $values['email'], $values['first_name'], $values['last_name'], $values['dob'], $values['gender'], $values['hometown']);
    $stmt->execute();
    $stmt->close();
    
    // Hash password and insert into account_table
    $hashedPassword = password_hash($values['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $values['email'], $hashedPassword);
    $stmt->execute();
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    $conn->close();
    
    unset($_SESSION['register_errors'], $_SESSION['register_values']);
    
    header('Location: login.php?registered=1');
    exit;
    
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
        $conn->close();
    }
    $addError('general', 'Registration failed. Please try again.');
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_values'] = $values;
    header('Location: registration.php');
    exit;
}


<?php
const SESSION_USER_KEY = 'user_email';

function startSessionIfNeeded(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function currentUser(): ?string
{
    startSessionIfNeeded();
    $email = $_SESSION[SESSION_USER_KEY] ?? null;
    return $email !== null && $email !== '' ? $email : null;
}

function loginUser(string $email): void
{
    startSessionIfNeeded();
    session_regenerate_id(true);
    $_SESSION[SESSION_USER_KEY] = $email;
}

function requireLogin(string $target): void
{
    startSessionIfNeeded();
    if (currentUser() !== null) {
        return;
    }

    $redirectTarget = trim($target) === '' ? 'main_menu.php' : $target;
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode($redirectTarget));
    exit;
}

function logoutUser(string $redirect = 'index.php'): void
{
    startSessionIfNeeded();

    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();

    header('Location: ' . $redirect);
    exit;
}

function ensureLoggedInFlash(string $message): void
{
    startSessionIfNeeded();
    $_SESSION['flash'] = $message;
}

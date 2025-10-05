<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login(?string $redirectTarget = null): void
{
    if (!isset($_SESSION['user_email'])) {
        $target = $redirectTarget;
        if ($target === null) {
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $target = $requestUri !== '' ? ltrim($requestUri, '/') : basename($_SERVER['PHP_SELF']);
        }
        $_SESSION['flash'] = 'Please log in to continue.';
        header('Location: login.php?redirect=' . urlencode($target));
        exit;
    }
}

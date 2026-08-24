<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    // start session
    session_start();
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function require_role($role, $loginPath = '../View/login.php')
{
    // check user role
    if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== $role) {
        header('Location: ' . $loginPath);
        exit;
    }
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_input()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function require_valid_csrf()
{
    // check csrf token
    $submittedToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (!$sessionToken || !hash_equals($sessionToken, $submittedToken)) {
        http_response_code(403);
        exit('Invalid CSRF token.');
    }
}

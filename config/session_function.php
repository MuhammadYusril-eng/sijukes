<?php
// config/session_handler.php

function secure_session_start() {
    // Set more aggressive garbage collection
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);
    ini_set('session.gc_maxlifetime', 1440); // 24 minutes

    // Use stricter session settings
    ini_set('session.use_strict_mode', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1); // Enable if using HTTPS

    session_start();
}

function secure_session_destroy() {
    // Clear session data
    $_SESSION = [];

    // Delete session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Destroy session
    session_destroy();
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
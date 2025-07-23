<?php
// File: /sijukes/login/logout.php

// Aktifkan error reporting untuk development (matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Security Headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Pastikan tidak ada output sebelum session_start()
if (ob_get_length()) ob_end_clean();

// Konfigurasi session yang secure
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.cookie_secure', 1);  // Hanya aktif jika menggunakan HTTPS

// Mulai session dengan validasi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Catat aktivitas logout sebelum menghancurkan session
if (isset($_SESSION['user_id'])) {
    $log_message = sprintf(
        "[%s] User %s (ID: %d) logged out from %s",
        date('Y-m-d H:i:s'),
        $_SESSION['username'] ?? 'unknown',
        $_SESSION['user_id'] ?? 0,
        $_SERVER['REMOTE_ADDR']
    );
    file_put_contents(__DIR__.'/../logs/auth.log', $log_message.PHP_EOL, FILE_APPEND);
}

// Hancurkan session secara komprehensif
$_SESSION = [];

// Hapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Regenerasi session ID untuk mencegah session fixation
session_destroy();
session_write_close();

// Generate CSRF token baru untuk session berikutnya
if (function_exists('random_bytes')) {
    $csrf_token = bin2hex(random_bytes(32));
} else {
    $csrf_token = bin2hex(openssl_random_pseudo_bytes(32));
}

// Redirect ke halaman login dengan status logout
$redirect_url = '/sijukes/?status=logged_out';
header("Location: $redirect_url", true, 303); // HTTP 303 See Other

// Pastikan tidak ada eksekusi kode setelah redirect
exit;
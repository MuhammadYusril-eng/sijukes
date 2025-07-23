<?php
// config/cek-sessions.php

// Start with minimal memory usage
ini_set('memory_limit', '128M');

// Load dependencies
require 'koneksi.php';
require 'session_function.php';

// Initialize secure session
ini_set('session.cookie_path', '/sijukes');
secure_session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Session validation
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    secure_session_destroy();
    header('Location: ../../index.php?pesan=session_expired');
    exit();
}

// Role validation
$allowed_roles = ['admin', 'guru', 'siswa'];
if (empty($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    error_log("Unauthorized access attempt from IP: ".$_SERVER['REMOTE_ADDR']);
    secure_session_destroy();
    header('Location: ../../404.php');
    exit();
}

// Database user verification
if (!empty($_SESSION['user_id'])) {
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE id = ? AND role = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$_SESSION['user_id'], $_SESSION['role']]);
        
        if (!$stmt->fetch()) {
            secure_session_destroy();
            header('Location: ../../index.php?pesan=invalid_session');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Database error: ".$e->getMessage());
        secure_session_destroy();
        header('Location: ../../index.php?pesan=server_error');
        exit();
    }
}

// Generate CSRF token for forms
generate_csrf_token();
<?php
// Konfigurasi session HARUS sebelum session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

session_start();

require_once __DIR__.'/../../../config/koneksi.php';

// Fungsi validasi session
function validate_session() {
    // 1. Cek status login dasar
    if (empty($_SESSION['status']) || $_SESSION['status'] !== 'login') {
        session_destroy();
        header('Location: /sijukes/index.php?pesan=belum_login');
        exit;
    }

    // 2. Validasi fingerprint
    $current_fingerprint = hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'], '@acil#$%');
    if (empty($_SESSION['fingerprint']) || !hash_equals($_SESSION['fingerprint'], $current_fingerprint)) {
        session_destroy();
        header('Location: /sijukes/index.php?pesan=belum_login');
        exit;
    }

    // 3. Cek timeout (30 menit)
    if (time() - $_SESSION['last_activity'] > 1800) {
        session_destroy();
        header('Location: /sijukes/index.php?pesan=belum_login');
        exit;
    }

    // 4. Update aktivitas terakhir
    $_SESSION['last_activity'] = time();

    // 5. Verifikasi ke database (opsional)
    try {
        $conn = Database::getInstance()->getConnection();
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE id = :id AND role = :role LIMIT 1");
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':role', $_SESSION['role'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            session_destroy();
            header('Location: /sijukes/index.php?pesan=belum_login');
            exit;
        }
    } catch (PDOException $e) {
        error_log("Session validation error: " . $e->getMessage());
    }
}

// Jalankan validasi
validate_session();
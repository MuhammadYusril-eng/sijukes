<?php
// Konfigurasi session HARUS sebelum session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');
// ini_set('session.cookie_secure', 1);  // Aktifkan di production (HTTPS)

session_start();

require_once __DIR__.'/../config/koneksi.php';

header('Content-Type: application/json');

// Validasi input
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Username dan password harus diisi']);
    exit;
}

try {
    // Gunakan koneksi PDO dari class Database
    $conn = Database::getInstance()->getConnection();
    
    // Query dengan prepared statement
    $stmt = $conn->prepare("SELECT id, nama, username, password, role FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Username atau password salah']);
        exit;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Username atau password salah']);
        exit;
    }

    // Regenerasi session ID
    session_regenerate_id(true);

    // Set session data
    $_SESSION = [
        'user_id'       => $user['id'],
        'nama'          => $user['nama'],
        'username'      => $user['username'],
        'role'          => $user['role'],
        'status'        => 'login',
        'ip_address'    => $_SERVER['REMOTE_ADDR'],
        'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
        'created'       => time(),
        'last_activity' => time(),
        'fingerprint'   => hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'], '@acil#$%')
    ];

    // Tentukan redirect
    $redirectMap = [
        'admin' => './login/admin/index.php',
        'guru'  => './login/guru/index.php',
        'siswa' => './login/user/index.php'
    ];

    echo json_encode([
        'success'  => true,
        'message'  => 'Login berhasil',
        'redirect' => $redirectMap[$user['role']],
        'user'     => [
            'nama' => $user['nama'],
            'role' => $user['role']
        ]
    ]);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem']);
}
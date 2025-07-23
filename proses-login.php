<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Untuk session
header("P3P: CP='IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT'");
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None'
]);
session_start();
require_once './config/koneksi.php';

// Tangkap data dari form
$username = trim($_POST['username']);
$password = $_POST['password'];

// Validasi input
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username dan password harus diisi']);
    exit;
}

// Query ke database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
    exit;
}

$user = $result->fetch_assoc();

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Password salah']);
    exit;
}

// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
$_SESSION['status'] = 'login';

// Tentukan redirect berdasarkan role
$redirect = ($user['role'] == 'admin') ? './login/admin/index.php' : 
            (($user['role'] == 'guru') ? './login/guru/index.php' : './login/user/index.php');

echo json_encode([
    'success' => true,
    'message' => 'Login berhasil',
    'redirect' => $redirect
]);
<?php

include 'config/koneksi.php';

$perPage = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Ambil data kegiatan sesuai paginasi
$query = mysqli_query($conn, "SELECT * FROM kegiatan LIMIT $offset, $perPage");

// Hitung total kegiatan
$totalKegiatanQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM kegiatan");
$totalKegiatanData = mysqli_fetch_assoc($totalKegiatanQuery);
$totalKegiatan = $totalKegiatanData['total'];
$totalPages = ceil($totalKegiatan / $perPage);

// Simpan data kegiatan
$kegiatans = [];
while ($data = mysqli_fetch_assoc($query)) {
    $kegiatans[] = $data;
}

// Buat response JSON
$response = [
    'data' => $kegiatans,
    'current_page' => $page,
    'last_page' => $totalPages,
    'total' => $totalKegiatan,
    'to' => min($page * $perPage, $totalKegiatan) // Menangani halaman terakhir
];

header('Content-Type: application/json');
echo json_encode($response);
?>

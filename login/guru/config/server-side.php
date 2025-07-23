<?php
// ... (konfigurasi database dan koneksi)

// Parameter dari permintaan DataTables
$start = $_POST['start'];
$length = $_POST['length'];
$search = $_POST['search']['value'];

// Query data dari database berdasarkan parameter
$query = "SELECT * FROM tbl_penduduk WHERE nik LIKE '%$search%' LIMIT $start, $length";

// Eksekusi query, ambil data, dan hitung total data
// ...

// Format data sebagai JSON
$response = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFilteredRecords,
    "data" => $data,
);

echo json_encode($response);
?>
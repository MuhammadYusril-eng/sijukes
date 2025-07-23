<?php
session_start();
include "../config/koneksi.php";

// Verify authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../index.php");
    exit();
}

// Verify the requested user matches logged in user
if (isset($_GET['user_id']) && $_GET['user_id'] != $_SESSION['user_id']) {
    header("Location: ../../unauthorized.php");
    exit();
}

// Get student data
$user_id = $_SESSION['user_id'];
$siswa_query = mysqli_query($conn, 
    "SELECT s.*, k.nama_kelas 
     FROM siswa s
     LEFT JOIN kelas k ON s.kelas_id = k.id_kelas
     WHERE s.user_id = '$user_id'");
$siswa = mysqli_fetch_assoc($siswa_query);

if (!$siswa || !$siswa['kelas_id']) {
    die("Siswa belum terdaftar di kelas manapun");
}

$kelas_id = $siswa['kelas_id'];
$nama_kelas = $siswa['nama_kelas'];

// Query exam schedule
$sql = "SELECT j.*, m.nama_mapel, u.nama AS nama_guru, r.nama_ruangan 
        FROM jadwal_ujian j
        JOIN mapel m ON j.mapel_id = m.id_mapel
        JOIN guru g ON j.guru_pengawas_id = g.id
        JOIN users u ON g.user_id = u.id
        JOIN ruangan r ON j.ruangan_id = r.id_ruangan
        WHERE j.kelas_id = $kelas_id
        ORDER BY j.tanggal_ujian ASC, j.jam_mulai ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Error: " . mysqli_error($conn));
}

// HTML for PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadwal Ujian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f2f2f2; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>JADWAL UJIAN</h2>
        <h3>Kelas: '.htmlspecialchars($nama_kelas).'</h3>
    </div>';

// Student info
$html .= '<div class="student-info">
    <p><strong>Nama Siswa:</strong> '.htmlspecialchars($_SESSION['username']).'</p>
    <p><strong>NIS:</strong> '.htmlspecialchars($siswa['nis']).'</p>
</div>';

// Exam schedule table
$html .= '<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Ujian</th>
            <th>Mata Pelajaran</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Ruangan</th>
            <th>Pengawas</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $html .= '<tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($row['nama_ujian']).'</td>
        <td>'.htmlspecialchars($row['nama_mapel']).'</td>
        <td>'.date('d-m-Y', strtotime($row['tanggal_ujian'])).'</td>
        <td>'.date('H:i', strtotime($row['jam_mulai'])).' - '.date('H:i', strtotime($row['jam_selesai'])).'</td>
        <td>'.htmlspecialchars($row['nama_ruangan']).'</td>
        <td>'.htmlspecialchars($row['nama_guru']).'</td>
    </tr>';
}

$html .= '</tbody></table>';

// Footer
$html .= '<div class="footer">
    Dicetak pada: '.date('d-m-Y H:i').'
</div>
</body>
</html>';

// Generate PDF
require_once '../../vendor/autoload.php';
$dompdf = new Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF
$dompdf->stream('Jadwal_Ujian_'.htmlspecialchars($nama_kelas).'.pdf', [
    'Attachment' => false
]);
exit;
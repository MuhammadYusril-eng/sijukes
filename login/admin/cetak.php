<?php
require_once '../../vendor/autoload.php';
require_once '../../config/koneksi.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();


if (isset($_GET['cetak_kegiatan'])) {
    // Cetak PDF kegiatan
    $html = '<h3 style="text-align:center;">Daftar Jadwal Kegiatan</h3>';
    $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';
    $html .= '<tr><th>No</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Jam</th><th>Lokasi</th><th>Untuk</th></tr>';

    $query = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal DESC");
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $html .= '<tr>';
        $html .= '<td>' . $no++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row['judul']) . '</td>';
        $html .= '<td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>';
        $html .= '<td>' . $row['jam'] . '</td>';
        $html .= '<td>' . htmlspecialchars($row['lokasi']) . '</td>';
        $html .= '<td>' . $row['ditujukan_untuk'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("jadwal_kegiatan.pdf", array("Attachment" => false));
    exit;

} 
elseif (isset($_GET['cetak_ujian'])) {
    // Ambil kelas_id jika ada
    $kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;

    $sql = "
        SELECT j.*, m.nama_mapel, k.nama_kelas, u.nama AS nama_guru, r.nama_ruangan 
        FROM jadwal_ujian j
        JOIN mapel m ON j.mapel_id = m.id_mapel
        JOIN kelas k ON j.kelas_id = k.id_kelas
        JOIN guru g ON j.guru_pengawas_id = g.id
        JOIN users u ON g.user_id = u.id
        JOIN ruangan r ON j.ruangan_id = r.id_ruangan
    ";

    if ($kelas_id > 0) {
        $sql .= " WHERE j.kelas_id = $kelas_id ";
    }

    $sql .= " ORDER BY j.tanggal_ujian DESC, j.jam_mulai DESC";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Query Error: " . mysqli_error($conn));
    }

    // Buat HTML untuk PDF
    $html = '<h3 style="text-align:center;">Jadwal Ujian</h3>';
    if ($kelas_id > 0) {
        // Dapatkan nama kelas untuk header
        $kelas_res = mysqli_query($conn, "SELECT nama_kelas FROM kelas WHERE id_kelas = $kelas_id");
        $kelas_data = mysqli_fetch_assoc($kelas_res);
        $html .= '<h4 style="text-align:center;">Kelas: ' . htmlspecialchars($kelas_data['nama_kelas']) . '</h4>';
    } else {
        $html .= '<h4 style="text-align:center;">Semua Kelas</h4>';
    }

    $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';
    $html .= '<tr>
                <th>No</th>
                <th>Nama Ujian</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Ruangan</th>
                <th>Pengawas</th>
              </tr>';

    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $html .= '<tr>';
        $html .= '<td>' . $no++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_ujian']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_mapel']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_kelas']) . '</td>';
        $html .= '<td>' . date('d-m-Y', strtotime($row['tanggal_ujian'])) . '</td>';
        $html .= '<td>' . date('H:i', strtotime($row['jam_mulai'])) . '</td>';
        $html .= '<td>' . date('H:i', strtotime($row['jam_selesai'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_ruangan']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_guru']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Load HTML ke dompdf
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // Format landscape agar muat tabel lebar
    $dompdf->render();
    $dompdf->stream("jadwal_ujian.pdf", array("Attachment" => false));
    exit;
}


elseif (isset($_GET['cetakSiswa'])) {


    $html = '<h3 style="text-align:center;">Daftar Siswa</h3>';
    $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';
    $html .= '<tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIS</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Kelas</th>
              </tr>';

    $query = mysqli_query($conn, "
        SELECT siswa.*, users.nama, users.email, kelas.nama_kelas 
        FROM siswa 
        JOIN users ON siswa.user_id = users.id 
        JOIN kelas ON siswa.kelas_id = kelas.id_kelas 
        ORDER BY users.nama ASC
    ");

    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $html .= '<tr>';
        $html .= '<td>' . $no++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nis']) . '</td>';
        $html .= '<td>' . htmlspecialchars(ucfirst($row['jenis_kelamin'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['alamat']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['no_telp']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_kelas']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // Lebih cocok agar muat
    $dompdf->render();
    $dompdf->stream("daftar_siswa.pdf", array("Attachment" => false));
    exit;
}

elseif (isset($_GET['cetakGuru'])) {
    require_once '../../vendor/autoload.php';


    $html = '<h3 style="text-align:center;">Daftar Guru</h3>';
    $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';
    $html .= '<tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIP</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No Telepon</th>
              </tr>';

    $query = mysqli_query($conn, "
        SELECT guru.*, users.nama, users.email 
        FROM guru 
        JOIN users ON guru.user_id = users.id 
        ORDER BY users.nama ASC
    ");

    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $html .= '<tr>';
        $html .= '<td>' . $no++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nip']) . '</td>';
        $html .= '<td>' . htmlspecialchars(ucfirst($row['jenis_kelamin'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['alamat']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['no_telp']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("daftar_guru.pdf", array("Attachment" => false));
    exit;
}

?>

<?php
session_start();

include "../config/koneksi.php";
require_once '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['download_wrong']) && $_GET['download_wrong'] == 1) {
    if (!isset($_SESSION['rows_wrong']) || empty($_SESSION['rows_wrong'])) {
        echo "<script>alert('Tidak ada file error untuk di-download.'); window.location.href='dataSiswa.php';</script>";
        exit;
    }

    $rows_wrong = $_SESSION['rows_wrong'];
    unset($_SESSION['rows_wrong']);

    $spreadsheet_wrong = new Spreadsheet();
    $sheet_wrong = $spreadsheet_wrong->getActiveSheet();
    $sheet_wrong->fromArray($rows_wrong, NULL, 'A1');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="siswa_error_import_' . date('YmdHis') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet_wrong);
    $writer->save('php://output');
    exit;
}

if (isset($_POST['import'])) {
    $file = $_FILES['file_excel']['tmp_name'];

    if ($file) {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $sukses = 0;
        $gagal = 0;
        $rows_wrong = [];
        $kelas_cache = []; // Cache untuk menyimpan data kelas

        // Header + kolom Error
        $header = $rows[0];
        $header[] = 'Error';
        $rows_wrong[] = $header;

        // Ambil semua kelas sekaligus untuk optimasi
        $kelas_result = mysqli_query($conn, "SELECT id_kelas, nama_kelas FROM kelas");
        while ($kelas = mysqli_fetch_assoc($kelas_result)) {
            $kelas_cache[strtolower($kelas['nama_kelas'])] = $kelas['id_kelas'];
        }

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $error_msg = [];
            
            // Validasi row kosong
            if (empty(array_filter($row))) {
                continue;
            }

            $nama = mysqli_real_escape_string($conn, $row[0] ?? '');
            $email = mysqli_real_escape_string($conn, $row[1] ?? '');
            $nis = mysqli_real_escape_string($conn, $row[2] ?? '');
            $jenis_kelamin = strtolower(trim($row[3] ?? ''));
            $alamat = mysqli_real_escape_string($conn, $row[4] ?? '');
            $no_telp = mysqli_real_escape_string($conn, $row[5] ?? '');
            $kelas_nama = mysqli_real_escape_string($conn, $row[6] ?? '');

            // Validasi data wajib
            if (empty($nama)) $error_msg[] = "Nama tidak boleh kosong";
            if (empty($email)) $error_msg[] = "Email tidak boleh kosong";
            if (empty($nis)) $error_msg[] = "NIS tidak boleh kosong";
            if (empty($kelas_nama)) $error_msg[] = "Kelas tidak boleh kosong";

            // Validasi format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg[] = "Format email tidak valid";
            }

            // Cari kelas_id berdasarkan nama kelas dari cache
            $kelas_id = null;
            if (empty($error_msg)) {
                $kelas_key = strtolower(trim($kelas_nama));
                $kelas_id = $kelas_cache[$kelas_key] ?? null;
                
                if (!$kelas_id) {
                    $error_msg[] = "Kelas '$kelas_nama' tidak ditemukan";
                }
            }
            // Tambahkan setelah validasi wajib
                if (empty($error_msg)) {
                    $check_duplikat = mysqli_query($conn, 
                        "SELECT u.id 
                        FROM users u
                        JOIN siswa s ON u.id = s.user_id
                        WHERE u.nama = '$nama' OR s.nis = '$nis'");
                    
                    if (mysqli_num_rows($check_duplikat) > 0) {
                        $error_msg[] = "Siswa dengan nama/NIS yang sama sudah terdaftar";
                    }
                }

            if (count($error_msg) > 0) {
                $row_with_error = $row;
                $row_with_error[] = implode("; ", $error_msg);
                $rows_wrong[] = $row_with_error;
                $gagal++;
                continue;
            }

            // Generate username unik
            $nama_depan = strtolower(explode(" ", trim($nama))[0]); // Ambil nama depan tanpa filter huruf
            $nama_depan = preg_replace('/[^a-z]/', '', $nama_depan); // Hapus karakter non-alphabet (case-insensitive)
            $username = $nama_depan;
            $suffix = 1;

            do {
                $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
                if (mysqli_num_rows($check) > 0) {
                    $username = $nama_depan . $suffix;
                    $suffix++;
                } else {
                    break;
                }
            } while (true);

            $password_plain = $nama_depan . "_" . $nis;
            $password = password_hash($password_plain, PASSWORD_DEFAULT);

            // Mulai transaksi
            mysqli_begin_transaction($conn);

            try {
                // Insert ke tabel users
                $query_user = "INSERT INTO users (nama, username, password, email, role, created_at)
                               VALUES ('$nama', '$username', '$password', '$email', 'siswa', NOW())";

                if (!mysqli_query($conn, $query_user)) {
                    throw new Exception("Gagal menyimpan data user: " . mysqli_error($conn));
                }

                $user_id = mysqli_insert_id($conn);

                // Insert ke tabel siswa
                $query_siswa = "INSERT INTO siswa (user_id, nis, kelas_id, jenis_kelamin, alamat, no_telp, created_at)
                                VALUES ('$user_id', '$nis', '$kelas_id', '$jenis_kelamin', '$alamat', '$no_telp', NOW())";

                if (!mysqli_query($conn, $query_siswa)) {
                    throw new Exception("Gagal menyimpan data siswa: " . mysqli_error($conn));
                }

                mysqli_commit($conn);
                $sukses++;
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $row_with_error = $row;
                $row_with_error[] = $e->getMessage();
                $rows_wrong[] = $row_with_error;
                $gagal++;
            }
        }

        // Simpan data error ke session hanya jika ada error
        if ($gagal > 0) {
            $_SESSION['rows_wrong'] = $rows_wrong;
        }

        // Output hasil import
        echo "<script>
            alert('Proses import selesai.\\nBerhasil: $sukses\\nGagal: $gagal');
        ";

        if ($gagal > 0) {
            echo "
                if (confirm('Ada $gagal data yang gagal diimport. Download file error?')) {
                    window.location.href = '?download_wrong=1';
                } else {
                    window.location.href = 'dataSiswa.php';
                }
            ";
        } else {
            echo "window.location.href = 'dataSiswa.php';";
        }
        echo "</script>";
        exit;

    } else {
        echo "<script>alert('File tidak valid atau kosong.'); window.location.href='dataSiswa.php';</script>";
    }
}
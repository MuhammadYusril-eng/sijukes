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
    unset($_SESSION['rows_wrong']); // hapus agar tidak di-download lagi

    $spreadsheet_wrong = new Spreadsheet();
    $sheet_wrong = $spreadsheet_wrong->getActiveSheet();
    $sheet_wrong->fromArray($rows_wrong, NULL, 'A1');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="file_wrong.xlsx"');
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

        // Header + kolom Error
        $header = $rows[0];
        $header[] = 'Error';
        $rows_wrong[] = $header;

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $nama = mysqli_real_escape_string($conn, $row[0]);
            $email = mysqli_real_escape_string($conn, $row[1]);
            $nis = mysqli_real_escape_string($conn, $row[2]);
            $jenis_kelamin = strtolower(trim($row[3]));
            $alamat = mysqli_real_escape_string($conn, $row[4]);
            $no_telp = mysqli_real_escape_string($conn, $row[5]);
            $kelas = mysqli_real_escape_string($conn, $row[6]);
            $tingkat = mysqli_real_escape_string($conn, $row[7]);


            $error_msg = [];

            if (!in_array($jenis_kelamin, ['laki-laki', 'perempuan'])) {
                $error_msg[] = "Jenis kelamin invalid";
            }

           
            $email_check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
            if (mysqli_num_rows($email_check) > 0) {
                $error_msg[] = "Duplicate email";
            }

            if (count($error_msg) > 0) {
                $row_with_error = $row;
                $row_with_error[] = implode("; ", $error_msg);
                $rows_wrong[] = $row_with_error;
                $gagal++;
                continue;
            }

            $nama_depan = strtolower(explode(" ", trim($nama))[0]);
            $username = $nama_depan;

            $suffix = 1;
            while (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'")) > 0) {
                $username = $nama_depan . $suffix;
                $suffix++;
            }

            $password_plain = $nama_depan . $nis;
            $password = password_hash($password_plain, PASSWORD_DEFAULT);

            $query_user = "INSERT INTO users (nama, username, password, email, role, created_at)
                           VALUES ('$nama', '$username', '$password', '$email', 'siswa', NOW())";


            if (mysqli_query($conn, $query_user)) {
                $user_id = mysqli_insert_id($conn);

                $query_siswa = "INSERT INTO siswa (user_id, nis, kelas, tingkat, jenis_kelamin, alamat, no_telp, created_at)
                                VALUES ('$user_id', '$nis','$kelas','$tingkat', '$jenis_kelamin', '$alamat', '$no_telp', NOW())";

                if (mysqli_query($conn, $query_siswa)) {
                    $sukses++;
                } else {
                    mysqli_query($conn, "DELETE FROM users WHERE id='$user_id'");
                    $error_msg = ["Gagal simpan data siswa"];
                    $row_with_error = $row;
                    $row_with_error[] = implode("; ", $error_msg);
                    $rows_wrong[] = $row_with_error;
                    $gagal++;
                }
            } else {
                $error_msg = ["Gagal simpan data user"];
                $row_with_error = $row;
                $row_with_error[] = implode("; ", $error_msg);
                $rows_wrong[] = $row_with_error;
                $gagal++;
            }
        }

        // Simpan data error ke session
        $_SESSION['rows_wrong'] = $rows_wrong;

        // Output alert + confirm via JS
        echo "<script>
            alert('Import selesai.\\nSukses: $sukses\\nGagal: $gagal');
        ";

     if ($gagal > 0) {
    echo "
        if (confirm('Ada data yang gagal diimport. Apakah Anda ingin mendownload file error?')) {
            // buat form dinamis untuk download
           window.location.href = '?download_wrong=1';
setTimeout(function() {
    window.location.href = 'dataSiswa.php';
}, 2000);

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
        echo "<script>alert('File tidak ditemukan.'); window.location.href='dataSiswa.php';</script>";
    }
}
?>

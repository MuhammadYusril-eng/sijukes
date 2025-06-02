<script type="text/javascript" src="../../assets/sweetalert1/sweetalert.min.js"></script>
<?php 
include "./config/cek-sesi.php";
include "../../config/koneksi.php";
if(isset($_POST['upUser'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idUser = $_GET['id'];
    
    // Validasi input
    if (empty($username) || empty($password)) {
        echo "Username dan Password harus diisi.";
    } else {
        // Periksa apakah ID user valid (tersedia dalam tabel)
        $checkUserQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE id='$idUser'");
        $userData = mysqli_fetch_assoc($checkUserQuery);
        
        if ($userData) {
            // Update password dengan password_hash
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Perbarui data user
            $queryUpdate = mysqli_query($conn, "UPDATE `users` SET username='$username', password='$hashedPassword' WHERE id='$idUser'");
            
            if (!$queryUpdate) {
                die("Query gagal dijalankan: " . mysqli_error($conn));
            } else {
                   $_SESSION['update_message'] = "Berhasil Update pengguna.";
                    // Redirect kembali ke halaman data pengguna
                    header("Location: data-user.php");
                    exit();
            }
        } else {
            echo "ID User tidak valid.";
        }
    }
}elseif(isset($_POST['delUser'])) {
            
          $id = $_POST['delUser'];
            $queryDelete = mysqli_query($conn,"DELETE FROM `users` WHERE level='pengguna' AND id='$id'");
              $result = ($queryDelete);
              // periska query apakah ada error
              if(!$result){
                  die ("Query gagal dijalankan: ".mysqli_errno($conn).
                       " - ".mysqli_error($conn));
              } else {
                //tampil alert dan akan redirect ke halaman index.php
                //silahkan ganti index.php sesuai halaman yang akan dituju
                 $_SESSION['delete_message'] = "Berhasil Delete Akun pengguna.";
                    // Redirect kembali ke halaman data pengguna
                    header("Location: data-user.php");
                    exit();
                  }
                }

 ?>
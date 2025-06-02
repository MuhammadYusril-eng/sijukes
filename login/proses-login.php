<script type="text/javascript" src="../assets/sweetalert1/sweetalert.min.js"></script>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// menghubungkan dengan koneksi
include './config/koneksi.php';

// menangkap data yang dikirim dari form
// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Cek Nilai Variabel

$sql = "SELECT * FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Kesalahan query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['status'] = "login";
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        $successMessage = "Berhasil Login";
        $redirectURL = '';

        if ($user['role'] == 'admin') {
            $successMessage = "Berhasil Login";
            $redirectURL = "admin/index.php";
        } else {
            $successMessage = "Berhasil Login";
            $redirectURL = "user/index.php";
        }

        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    icon: 'success',
                    closeOnClickOutside: false,
                    dangerMode: true,
                    closeOnEsc: false,
                    className: 'red-bg',
                    title: 'Good',
                    text:  '" . $successMessage . "',
                    type: 'success',
                    customClass: 'swal-wide',
                    timer: 3000,
                });
            }, 10);
            window.setTimeout(function(){
                window.location.replace('" . $redirectURL . "');
            }, 3000);
        </script>";
    } else {
        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    icon: 'error',
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    dangerMode: true,
                    className: '#ff006a',
                    title: 'Oopss',
                    text:  'Username atau Password salah',
                    type: 'error',
                    timer: 3000,
                });
            }, 10);
            window.setTimeout(function(){
                window.location.replace('index.php');
            }, 2500);
        </script>";
    }
} else {
    echo "Tidak ada hasil dari query.";
}











// // Menangkap data yang dikirim dari form
// $username = $_POST['username'];
// $password = $_POST['password'];

// // Mendapatkan koneksi database
// $conn = getDatabaseConnection();

// if ($conn) {
//     // Menyiapkan query menggunakan prepared statements
//     $sql = "SELECT * FROM users WHERE username = :username";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute(['username' => $username]);
//     $user = $stmt->fetch();

//     if ($user) {
//         // Memeriksa password dengan password_verify
//         if (password_verify($password, $user['password'])) {
//             // Menyimpan data user ke dalam session
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['status'] = "login";
//             $_SESSION['username'] = $user['username'];
//             $_SESSION['role'] = $user['role'];

//             // Pesan berhasil login dan pengalihan halaman
//             $successMessage = "Berhasil Login";
//             $redirectURL = '';

//             if ($user['role'] == 'admin') {
//                 $redirectURL = "admin/index.php";
//             } else {
//                 $redirectURL = "user/index.php";
//             }

//             echo "<script type='text/javascript'>
//                 setTimeout(function () {
//                     swal({
//                         icon: 'success',
//                         closeOnClickOutside: false,
//                         dangerMode: true,
//                         closeOnEsc: false,
//                         className: 'red-bg',
//                         title: 'Good',
//                         text:  '" . $successMessage . "',
//                         type: 'success',
//                         customClass: 'swal-wide',
//                         timer: 3000,
//                     });
//                 }, 10);
//                 window.setTimeout(function(){
//                     window.location.href = '" . $redirectURL . "';
//                 }, 3000);
//             </script>";
//             exit; // Keluar dari skrip setelah pengalihan halaman
//         } else {
//             // Jika password salah
//             echo "<script type='text/javascript'>
//                 setTimeout(function () {
//                     swal({
//                         icon: 'error',
//                         closeOnClickOutside: false,
//                         closeOnEsc: false,
//                         dangerMode: true,
//                         className: '#ff006a',
//                         title: 'Oopss',
//                         text:  'Username atau Password salah',
//                         type: 'error',
//                         timer: 3000,
//                     });
//                 }, 10);
//                 window.setTimeout(function(){
//                     window.location.href = 'index.php';
//                 }, 2500);
//             </script>";
//         }
//     } else {
//         // Jika username tidak ditemukan
//         echo "<script type='text/javascript'>
//             setTimeout(function () {
//                 swal({
//                     icon: 'error',
//                     closeOnClickOutside: false,
//                     closeOnEsc: false,
//                     dangerMode: true,
//                     className: '#ff006a',
//                     title: 'Oopss',
//                     text:  'Username tidak ditemukan',
//                     type: 'error',
//                     timer: 3000,
//                 });
//             }, 10);
//             window.setTimeout(function(){
//                 window.location.href = 'index.php';
//             }, 2500);
//         </script>";
//     }
// } else {
//     // Jika koneksi ke database gagal
//     echo "Koneksi ke database gagal.";
// }





// // menyeleksi data user dengan username dan password yang sesuai
// $sql = mysqli_query($conn,"SELECT * from users where username='$username'");
// // menghitung jumlah data yang ditemukan
// $cek = mysqli_num_rows($sql);
 
// // cek apakah username dan password di temukan pada database
// if($cek > 0){
//   // password_hash($_POST['password'])
//     $data = mysqli_fetch_assoc($sql);

//  if($data['role']=="admin"){
 
//     // buat session login dan username
//     $_SESSION['id'] = $id;
//     $_SESSION['status'] = "login";
//     $_SESSION['id'] = $data['id'];
//     $_SESSION['role'] = "admin";
//     // alihkan ke halaman dashboard admin
//     header("location:./admin/index");
    

// // cek jika user login sebagai pegawai
// }else if($data['role']=="pengguna"){
//     // buat session login dan username
//     $_SESSION['id'] = $id;
//     $_SESSION['username'] = $username;
//     $_SESSION['username'] = $data['username'];
//     $_SESSION['status'] = "login";
//     $_SESSION['id'] = $data['id'];
//     $_SESSION['role'] = "pengguna";
//     // alihkan ke halaman dashboard pegawai
//     header("location:./user/index");

// // cek jika user login sebagai pengurus
// }else{

//     // alihkan ke halaman login kembali
//     header("location:index.php?pesan=gagal");
// }	
// }else{
// header("location:index.php?pesan=gagal");
// }



?>

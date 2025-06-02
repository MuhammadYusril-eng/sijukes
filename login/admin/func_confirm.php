<script type="text/javascript" src="../../assets/sweetalert1/sweetalert.min.js"></script>

<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
 $data = mysqli_fetch_assoc($query);
while ($row = mysqli_fetch_assoc($query)){
    $id = $row['id']; //user id value set to verify_id variable
}
// ADD

if(isset($_POST['konfirmasi'])){

  $status_project     = 'konfirmasi';

//cek dulu jika ada gambar jalankan coding ini
$id = $_GET['id'];

$query = mysqli_query($conn,"UPDATE tbl_project SET status_project='$status_project' WHERE id='$id'");
$result = ($query);

if(!$result){
  die ("Query gagal dijalankan: ".mysqli_errno($conn)." - ".mysqli_error($conn));
} else {
  $id = $_GET['id'];
//tampil alert dan akan redirect ke halaman index.php
//silahkan ganti index.php sesuai halaman yang akan dituju
echo "<script type='text/javascript'>
setTimeout(function () {  
    swal({
        icon: 'success',
        closeOnClickOutside: false,
        closeOnEsc: false,
        dangerMode: true,
        className: 'red-bg',
        title: 'Berhasil',
        text:  'Data anda berhasil dikirim ',
        type: 'success',
        timer: 3000,
        showConfirmButton: false
        });  
        },10); 
        window.setTimeout(function(){ 
         window.location.replace('index.php');
         } ,1000); 
 </script>";}

}elseif(isset($_POST['delKarya'])) {
            
          $id = $_POST['delKarya'];
            $queryDelete = mysqli_query($conn,"DELETE FROM `tbl_project` WHERE id='$id'");
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
                    header("Location: konfirmasi_project.php");
                    exit();
                  }
                }

    
  # code...










?>
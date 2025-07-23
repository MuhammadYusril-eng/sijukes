<?php 
include "../../config/koneksi.php";
$sessionKodeUser = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users  WHERE role='guru' AND id = '$sessionKodeUser'");
while ($row = mysqli_fetch_assoc($query)){
    $id = $row['id']; //user id value set to verify_id variable
}
if(isset($_POST['c_pwd'])){

    $password     = $_POST['password'];
    $c_password     = $_POST['c_password'];

    if (empty($_POST['password']) || empty($_POST['c_password'])) {
    echo "<h3><font color=red>Ganti Password Gagal! Data Tidak Boleh Kosong.</font></h3>";    

    }elseif (($_POST['password'])!= ($_POST['c_password'])) {
     echo "<h3><font color=red>Ganti Password Gagal! Password Tidak Sama.</font></h3>";    

    }else{
       $query = mysqli_query($conn,"UPDATE users SET password='".password_hash($password, PASSWORD_DEFAULT)."' WHERE id='$id'");
          $result = ($query);
    //setelah berhasil update
    if(!$result){
        die ("Query gagal dijalankan: ".mysqli_errno($conn).
             " - ".mysqli_error($conn));
    } else {
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
              text:  'Berhasil Update Password',
              type: 'success',
              timer: 3000,
              showConfirmButton: false
              });  
              },10); 
              window.setTimeout(function(){ 
               window.location.replace('index.php');
               } ,2000); 
       </script>";                 
       }

}
}
?>
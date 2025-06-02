<?php 

include '../config/koneksi.php';

if($_GET['act']== 'tambah_akun'){
  $nama     = $_POST['nama'];
  $email  = $_POST['email'];
  $password = $_POST['password'];




                  // jalankan query INSERT untuk menambah data ke database pastikan sesuai urutan (id tidak perlu karena dibikin otomatis)
                  $query = mysqli_query($conn,"INSERT INTO `users` (`nama`, `email`, `password`,`level`) VALUES
                ('$nama', '$email', '$password', 'admin')");
                  $result = ($query);
                  // periska query apakah ada error
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
                            text:  'Berhasil Tambah Akun user',
                            type: 'success',
                            timer: 3000,
                            showConfirmButton: false
                            });  
                            },10); 
                            window.setTimeout(function(){ 
                             window.location.replace('index.php');
                             } ,2000); 
                     </script>";                  }

            } 
 
exit();




 ?>
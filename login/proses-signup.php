<script type="text/javascript" src="../assets/sweetalert1/sweetalert.min.js"></script>

<?php 
// menghubungkan dengan conn
include '../config/koneksi.php';
//  error_reporting(E_ALL);
// ini_set('display_errors', 1);

   // removes backslashes
	$username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($conn,$username); 
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($conn,$password);

//buat token
 // $token=hash('sha256', md5(date('Y-m-d'))) ;

//query tambah
 $sql = mysqli_query($conn,"INSERT INTO `users` (`username`, `password`,`level`) VALUES
('$username','".password_hash($password, PASSWORD_DEFAULT)."','admin')");

if ($sql) {
 # credirect ke page login
 echo "<script type='text/javascript'>
 setTimeout(function () {  
	 swal({
		 icon: 'success',
		 closeOnClickOutside: false,
		 closeOnEsc: false,
		 dangerMode: true,
		 className: 'red-bg',
		 title: 'Berhasil Buat Akun',
		 text:  'Silahkan Login ',
		 type: 'success',
		 timer: 3000,
		 showConfirmButton: false
		 });  
		 },10); 
		 window.setTimeout(function(){ 
		 window.location.replace('./index.php');
		 } ,2000); 
 </script>";
}else{
	echo "<script type='text/javascript'>
        setTimeout(function () {  
            swal({
                icon: 'error',
                closeOnClickOutside: false,
                closeOnEsc: false,
                dangerMode: true,
                className: 'red-bg',
                title: 'Gagal',
                text:  'Gagal Membuat Akun',
                type: 'error',
                timer: 3000,
                showConfirmButton: false
                });  
                },10); 
                window.setTimeout(function(){ 
                window.location.replace('./index.php');
                } ,2000); 
        </script>";
 // echo "ERROR, data gagal ditambah". mysqli_error($conn);
}


 ?>
	<!-- cek apakah sudah login -->
	<?php
	session_start();
	require 'koneksi.php';
	if($_SESSION['status']!="login"){
		header("location: ../dash/index.php?pesan=belum_login");
	}

	if($_SESSION['role']!="admin"){
header("location:login.php");
}elseif ($_SESSION['role']!="admin") {
		// session_destroy();
		header("location: ../dash/login.php");
	}elseif($_SESSION['role']!="pengguna"){
		session_destroy();
		header("location: ../dash/login.php");
	}
	
	?>

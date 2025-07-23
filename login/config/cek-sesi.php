	<!-- cek apakah sudah login -->
	<?php
	session_start();
	require 'koneksi.php';
	if($_SESSION['status']!="login"){
		header("location: ../login/index.php?pesan=belum_login");
	}

	if($_SESSION['role']!="admin"){
header("location:login.php");
}elseif ($_SESSION['role']!="admin") {
		// session_destroy();
		header("location: ../login/login.php");
	}elseif($_SESSION['role']!="user"){
		session_destroy();
		header("location: ../login/login.php");
	}
	
	?>

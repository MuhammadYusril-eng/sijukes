	<!-- cek apakah sudah login -->
	<?php
	session_start();
	require '../config/koneksi.php';
	if($_SESSION['status']!="login"){
	header("location: ../index.php?pesan=belum_login");
	}elseif ($_SESSION['role'] !== "admin") {
		 header("location:../../404.php"); 
	}
	
	?>
<?php
// session_start(); // Mulai sesi

// function isUserLoggedIn() {
//     return isset($_SESSION['user_id']);
// }

// function redirectIfNotLoggedIn() {
//     if (!isUserLoggedIn()) {
//         header("Location: login.php");
//         exit();
//     }
// }

// function getUsername() {
//     return isUserLoggedIn() ? $_SESSION['username'] : "";
// }

// function getUserRole() {
//     return isUserLoggedIn() ? $_SESSION['user_role'] : "";
// }
?>

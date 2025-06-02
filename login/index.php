<?php
// session_start();
// include "../config/cek-sesi.php";
include "../config/koneksi.php";
// session_unset(); // Memulai sesi
?>
<script type="text/javascript" src="../assets/sweetalert1/sweetalert.min.js"></script>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=0.8, minimum-scale=0.8, maximum-scale=0.8">
  <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
  <title>Dashboard - Follow Up Your Progress</title>
  <!-- ========== All CSS files linkup ========= -->
  <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/LineIcons.css">
  <link rel="stylesheet" href="assets/css/quill/bubble.css">
  <link rel="stylesheet" href="assets/css/quill/snow.css">
  <link rel="stylesheet" href="assets/css/fullcalendar.css">
  <link rel="stylesheet" href="assets/css/morris.css">
  <link rel="stylesheet" href="assets/css/datatable.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <!-- <link rel="stylesheet" href="assets\toastr\toastr.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
</head>
<body class="">
   
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<form action="proses-login.php" method="post" class="login100-form validate-form">
    <div class="logo-container">
        <img src="../assets/img/logo/itgCoffea.png" alt="Logo" class="login-logo">
    </div>
    <span class="login100-form-title p-b-56 p-t-27 mb-4">
        Log in
    </span>

    <div class="wrap-input100 validate-input" data-validate="Enter username">
        <input class="input100" type="text" name="username" id="username" placeholder="Username">
        <span class="focus-input100" data-placeholder="&#xf207;"></span>
    </div>

    <div class="wrap-input100 validate-input" data-validate="Enter password">
        <input class="input100" type="password" name="password" id="password" placeholder="Password">
        <span class="focus-input100" data-placeholder="&#xf191;"></span>
    </div>

    <div class="container-login100-form-btn">

        <button type="submit" name="submit" class="login100-form-btn">
            Login
        </button>
    </div>
</form>

			</div>
		</div>
	</div>
	


 <!-- CHANGE THEME -->

      <!-- ============ Theme Option End ============= -->

      <!-- ========= All Javascript files linkup ======== -->
      <!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
      <script src="assets/js/login.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


      

      
      

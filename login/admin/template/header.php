  <!-- ========== header start ========== -->
<?php
require_once __DIR__.'/../config/cek-sesi.php';
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
 $data = mysqli_fetch_assoc($query);
?>


    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../assets/images/logo/tidoreKota.png" type="image/x-icon">
        <title>Dashboard - Administrator</title>

        <!-- ========== All CSS files linkup ========= -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">


        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous">

        
        <link rel="stylesheet" href="../../css/LineIcons.2.0.css">
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

        <!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../assets/css/fullcalendar.css">
        <link rel="stylesheet" href="../assets/css/morris.css">
        <link rel="stylesheet" href="../assets/css/datatable.css">
        <link rel="stylesheet" href="../assets/css/main.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- CSS DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- JavaScript DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- Pastikan jQuery dimuat SEBELUM DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>




        <body>
            

             
            <!-- ======== main-wrapper start =========== -->
            <main class="main-wrapper">

                <header class="header">
                                  <!-- <div id="loading-area"></div> -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-6">
                                <div class="header-left d-flex align-items-center">
                                    <div class="menu-toggle-btn mr-20">
                                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                            <i class="lni lni-chevron-left me-2"></i>
                                            Menu
                                        </button>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-6">
                                <div class="header-right">
                                    <div class="profile-box ml-15">
                                        <button
                                            class="dropdown-toggle bg-transparent border-0"
                                            type="button"
                                            id="profile"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <div class="profile-info">
                                                <div class="info">
                                                    <h6><?php echo $data['username'];?></h6>
                                                    <div class="image">
                                                        <img src="../../assets/img/user.png" alt=""/>
                                                        <span class="status"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <i class="lni lni-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                            <!-- <li>
                                                <a href="myProfile.php?edit_profile=<?= $data['id'];?>">
                                                    <i class="lni lni-user"></i>
                                                   My Profile
                                                </a>
                                            </li> -->
                                         <!--    <li>
                                                <a href="notification.html">
                                                    <i class="lni lni-alarm"></i>
                                                    Notifications
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chat.html">
                                                    <i class="lni lni-inbox"></i>
                                                    Messages
                                                </a>
                                            </li> -->
                                        <!--     <li>
                                                <a href="settings.html">
                                                    <i class="lni lni-cog"></i>
                                                    Settings
                                                </a>
                                            </li> -->
                                            <li>
                                                <a href="../logout.php">
                                                    <i class="lni lni-exit"></i>
                                                    Sign Out
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- profile end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- ========== header end ========== -->
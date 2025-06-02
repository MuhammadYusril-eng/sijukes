<?php
include "./config/cek-sesi.php";
include "../../config/koneksi.php";
include "modal-akun/modal.php";
    ?>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../assets/images/favicon.svg" type="image/x-icon">
        <title>Dashboard - Follow up your progress</title>

        <!-- ========== All CSS files linkup ========= -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">


        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous">

        
        <link rel="stylesheet" href="../../assets/css/LineIcons.2.0.css">
        <!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../assets/css/fullcalendar.css">
        <link rel="stylesheet" href="../assets/css/morris.css">
        <link rel="stylesheet" href="../assets/css/datatable.css">
        <link rel="stylesheet" href="../assets/css/main.css">

        <body>
          
            <!-- ======== main-wrapper start =========== -->
            <main class="main-wrapper">
                  <!-- ========== header start ========== -->
<!--               <div id="loading-area"></div>
 -->                <header class="header">
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
                                    <!-- profile start -->
                                    <div class="profile-box ml-15">
                                        <button
                                            class="dropdown-toggle bg-transparent border-0"
                                            type="button"
                                            id="profile"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <div class="profile-info">
                                                <div class="info">
                                                    <h6><?=$_SESSION['nama']?></h6>
                                                    <div class="image">
                                                        <img src="../../assets/images/favicon.svg" alt=""/>
                                                        <span class="status"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <i class="lni lni-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                            <li>
                                                <a href="profile.php">
                                                    <i class="lni lni-user"></i>
                                                    View Profile
                                                </a>
                                            </li>
                                           <!--  <li>
                                                <a href="#0">
                                                    <i class="lni lni-alarm"></i>
                                                    Notifications
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#0">
                                                    <i class="lni lni-inbox"></i>
                                                    Messages
                                                </a>
                                            </li> -->
                                            <li>
                                                <a href="#0">
                                                    <i class="lni lni-cog"></i>
                                                    Settings
                                                </a>
                                            </li>
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
<?php include ('./template/sidebar.php');?>


                <!-- ========== section start ========== -->
                <section class="section">
                    <div class="container-fluid">
                        <!-- ========== title-wrapper start ========== -->
                        <div class="title-wrapper pt-30">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="title d-flex align-items-center flex-wrap mb-30">
                                        <h2 class="mr-40">Settings Account</h2>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-md-6">
                                    <div class="breadcrumb-wrapper mb-30">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item active">
                                                    <a href="#0">Daftar Admin</a>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- ========== title-wrapper end ========== -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-style mb-30">
                                    <!-- <h6 class="mb-10">Daftar Admin</h6>
                                    <p class="text-sm mb-20">
                                        Daftar Tim mahasiswa Akademi Ilmu Komputer
                                    </p> -->
                                    <div class="btn-toolbar mb-2 mb-md-0">
                                    <button class="main-btn primary-btn btn-hover" title="Tambah data!" data-bs-toggle="modal" data-bs-target="#tambah_akun">
                                      <i class="bi bi-clipboard-plus"></i>Tambah
                                    </button>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="table-wrapper table-responsive">
                                        <table id="tabletim" class="table clients-table data">

                                            <thead>
                                 
                                                <tr>
                                                    <th>No</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                <!-- end table row-->
                                            </thead>
                                            <tbody>
                                     <?php
                                    $query = mysqli_query($conn,"SELECT * FROM users WHERE level='admin' ");
                                    $no = 1;
                                    foreach($query as  $data ): 
                                    ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td class="min-width">
                                                        <a href="#">
                                                            <?= $data['nama']; ?>
                                                        </a>
                                                    </td>
                                                     <td class="min-width">
                                                        <a href="#">
                                                            <?= $data['email']; ?>
                                                        </a>
                                                    </td>
                                                     <!-- <td class="min-width">
                                                        <style type="text/css">
                                                            input {border:0;outline:0;}
                                                            input:focus {outline:none!important;}</style>
                                                        <input type="password" value="<?= password_verify($pass, $data['password'])?>" id="myInput" disabled><br><br>                                       
                                                        <input type="checkbox" onclick="myFunction()"> Show Password
                                                    </div>
                                                        
                                                    </td> -->
                                                    <td>
                                                        <div class="action mt-2">
                                                          <button class="text-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $data['id_user'];?>">
                                                            <i class="lni lni-pencil"></i>
                                                          </button>
                                                          <button class="text-danger">
                                                            <i class="lni lni-trash"></i>
                                                          </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach ?>
                                                <!-- end table row-->
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                

                                <!-- end card -->
                            </div>
                        </div>
                        <!-- end row -->
          
                    </div>
                    <!-- end container -->
                </section>
                <!-- ========== section end ========== -->
            </main>
            <!-- ======== main-wrapper end =========== -->


            <!-- ============ Theme Option Start ============= -->
           <?php include './template/theme-option.php' ?>
            <!-- ============ Theme Option End ============= -->

      <?php include './template/footer.php' ?>
 <?php include "modalAkun.php";?>
 <!-- ======== sidebar-nav start =========== -->
            <aside class="sidebar-nav-wrapper">
                <div class="navbar-logo">
                    <a href="index.html">
                        <img src="../assets/images/logo.png" alt="logo">
                    <h6 class="mt-2">SMK Negeri 5 Tidore Kepulauan</h6>
                </div>
                <nav class="sidebar-nav">
                    <ul>
                        <li class="nav-item active">
                            <a href="index.php">
                                <span class="icon">
                                    <i class="lni lni-grid-alt"></i>
                                </span>
                              <span class="text">
                                Dashboard
                              </span>
                            </a>
                        </li>
                     

                      <span class="divider"><hr></span>   
            

                    <!-- Manajemen Jadwal -->
                    <li class="nav-item nav-item-has-children">
                        <a href="#0"
                            data-bs-toggle="collapse"
                            data-bs-target="#ddmenu_jadwal"
                            aria-controls="ddmenu_jadwal"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                            class="collapsed">
                            <span class="icon">
                                <i class="lni lni-calendar"></i>
                            </span>
                            <span class="text">Jadwal</span>
                        </a>
                        <ul id="ddmenu_jadwal" class="dropdown-nav collapse">
                            <li class="nav-item"><a href="jadwalUjian.php"><span class="text">Jadwal Ujian</span></a></li>
                            <li class="nav-item"><a href="jadwalKegiatan.php"><span class="text">Jadwal Kegiatan</span></a></li>
                        </ul>
                    </li>

                


                        <span class="divider"><hr></span>
                       <li class="nav-item nav-item-has-children">
                            <a
                                href="#0"
                                data-bs-toggle="collapse"
                                data-bs-target="#ddmenu_2"
                                aria-controls="ddmenu_2"
                                aria-expanded="false"
                                aria-label="Toggle navigation"
                                class="collapsed">
                                <span class="icon">
                                    <i class="lni lni-cog"></i>
                                </span>
                                <span class="text">Settings</span>
                            </a>
                            <ul id="ddmenu_2" class="dropdown-nav collapse">
                                <!-- <li class="nav-item">
                                    <a href="dataSambutan.php">
                                        <span class="text">
                                            Sambutan Lurah
                                            </span>
                                        </span>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#upAkun<?= $data['id'];?>">
                                        <span class="text">
                                            Akun
                                            </span>
                                        </span>
                                    </a>
                                </li>
                              
</ul>
                      
                </nav>
               
            </aside>
            <div class="overlay"></div>
            <!-- ======== sidebar-nav end =========== -->
<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
 $data = mysqli_fetch_assoc($query);
?>



<?php require_once 'template/header.php';?>
<!-- ========== header end ========== -->
<?php require_once 'template/sidebar.php';?>

<style>
    .welcome-message {
    background-color: #b8b8eb;
    border-radius: 10px;
    padding: 20px 40px; /* Menambahkan padding 20px atas/bawah dan 40px kiri/kanan */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 800px; /* Menambahkan lebar maksimum untuk mencegah latar belakang terlalu panjang */
    margin: 0 auto; /* Untuk memusatkan elemen di tengah */
}

.username {
    color: red;
    font-weight: bold;
}
</style>

<section class="section mt-5">
<div class="container-sm welcome-message">
    <h2>Selamat datang di Dashboard Administrator, <span class="username"><?php echo $_SESSION['username'] ?></span></h2>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</div>

</section>

<?php
// Fungsi untuk menghitung total baris dari sebuah tabel
function getTotalData($conn, $tableName) {
    $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM $tableName");
    $data = mysqli_fetch_assoc($query);
    return $data['total'];
}

// Fungsi untuk hitung persentase (dummy contoh berdasarkan total maksimum 100)
function getPersentase($total, $max = 100) {
    if ($max <= 0) return 0;
    $persen = ($total / $max) * 100;
    return ($persen > 100) ? 100 : round($persen, 2);
}

// Total Pengguna (contoh: tabel users)
$totalPengguna = getTotalData($conn, 'users');
$persenPengguna = getPersentase($totalPengguna, 100); // atau sesuaikan

// Total Jadwal Ujian
$totalJadwalUjian = getTotalData($conn, 'jadwal_ujian');
$persenJadwalUjian = getPersentase($totalJadwalUjian, 50); // misal maksimal 50 jadwal

// Total Kegiatan Sekolah
$totalKegiatan = getTotalData($conn, 'kegiatan');
$persenKegiatan = getPersentase($totalKegiatan, 30); // misal target 30 kegiatan


                                ?>
<!-- ========== section start ========== -->
<section class="section mt-5">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 mb-30">
    <div class="row">
        <!-- Kartu Jumlah Pengguna -->
        <div class="col-xxl-4 col-lg-4 col-md-8 col-sm-4 col-12">
            <div class="icon-card icon-card-2 mb-30">
                <div class="d-flex align-items-center mb-20">
                    <div class="icon purple">
                        <i class="lni lni-users"></i>
                    </div>
                    <div class="content">
                        <h6 class="">Total Pengguna</h6>
                        <h3 class="text-bold"><?php echo $totalPengguna; ?></h3>
                    </div>
                </div>
                <div class="progress bg-purple-100">
                    <div class="progress-bar purple-bg" role="progressbar" style="width: <?php echo $persenPengguna; ?>%" aria-valuenow="<?php echo $persenPengguna; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Kartu Jadwal Ujian -->
        <div class="col-xxl-4 col-lg-4 col-md-8 col-sm-4 col-12">
            <div class="icon-card icon-card-2 mb-30">
                <div class="d-flex align-items-center mb-20">
                    <div class="icon red">
                        <i class="lni lni-calendar"></i>
                    </div>
                    <div class="content">
                        <h6 class="">Jadwal Ujian</h6>
                        <h3 class="text-bold"><?php echo $totalJadwalUjian; ?></h3>
                    </div>
                </div>
                <div class="progress bg-red-100">
                    <div class="progress-bar red-bg" role="progressbar" style="width: <?php echo $persenJadwalUjian; ?>%" aria-valuenow="<?php echo $persenJadwalUjian; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Kartu Kegiatan -->
        <div class="col-xxl-4 col-lg-4 col-md-8 col-sm-4 col-12">
            <div class="icon-card icon-card-2 mb-30">
                <div class="d-flex align-items-center mb-20">
                    <div class="icon success">
                        <i class="lni lni-bullhorn"></i>
                    </div>
                    <div class="content">
                        <h6 class="">Kegiatan Sekolah</h6>
                        <h3 class="text-bold"><?php echo $totalKegiatan; ?></h3>
                    </div>
                </div>
                <div class="progress bg-green-100">
                    <div class="progress-bar success-bg" role="progressbar" style="width: <?php echo $persenKegiatan; ?>%" aria-valuenow="<?php echo $persenKegiatan; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Kartu Artikel -->
        <!-- <div class="col-xxl-3 col-lg-4 col-md-8 col-sm-4 col-12">
            <div class="icon-card icon-card-2 mb-30">
                <div class="d-flex align-items-center mb-20">
                    <div class="icon secondary">
                        <i class="lni lni-pencil"></i>
                    </div>
                    <div class="content">
                        <h6 class="">Artikel</h6>
                        <h3 class="text-bold"><?php echo $totalArtikel; ?></h3>
                    </div>
                </div>
                <div class="progress bg-secondary-100">
                    <div class="progress-bar secondary-bg" role="progressbar" style="width: <?php echo $persenArtikel; ?>%" aria-valuenow="<?php echo $persenArtikel; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div> -->
    </div>
</div>

        <!-- end col -->
    </div>
    </div>
    <!-- end container -->
</section>
</main>
<!-- ========== section end ========== -->
<!-- ======== main-wrapper end =========== -->
<!-- CHANGE THEME -->

<?php include './template/footer.php' ?>
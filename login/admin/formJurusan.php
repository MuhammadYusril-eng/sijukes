<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);

$edit = isset($_GET['edit']) ? $_GET['edit'] : false;
$hapus = isset($_GET['hapus']) ? $_GET['hapus'] : false;
$tambah = isset($_GET['tambah']) ? $_GET['tambah'] : false;

if ($hapus) {
    // Cek apakah jurusan digunakan di tabel kelas
    $cek = mysqli_query($conn, "SELECT COUNT(*) as total FROM kelas WHERE jurusan_id = '$hapus'");
    $data_cek = mysqli_fetch_assoc($cek);
    
    if ($data_cek['total'] > 0) {
        $_SESSION['error'] = "Jurusan tidak dapat dihapus karena masih digunakan di beberapa kelas";
        header("Location: dataJurusan.php");
        exit();
    }
    
    // Hapus jurusan
    $delete = mysqli_query($conn, "DELETE FROM jurusan WHERE id_jurusan = '$hapus'");
    if ($delete) {
        $_SESSION['success'] = "Data jurusan berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal menghapus data jurusan";
    }
    header("Location: dataJurusan.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_jurusan = mysqli_real_escape_string($conn, $_POST['kode_jurusan']);
    $nama_jurusan = mysqli_real_escape_string($conn, $_POST['nama_jurusan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    if ($edit) {
        // Update data
        $query = "UPDATE jurusan SET 
                  kode_jurusan = '$kode_jurusan',
                  nama_jurusan = '$nama_jurusan',
                  deskripsi = '$deskripsi'
                  WHERE id_jurusan = '$edit'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $_SESSION['success'] = "Data jurusan berhasil diperbarui";
        } else {
            $_SESSION['error'] = "Gagal memperbarui data jurusan";
        }
    } else {
        // Tambah data baru
        $query = "INSERT INTO jurusan (kode_jurusan, nama_jurusan, deskripsi)
                  VALUES ('$kode_jurusan', '$nama_jurusan', '$deskripsi')";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $_SESSION['success'] = "Data jurusan berhasil ditambahkan";
        } else {
            $_SESSION['error'] = "Gagal menambahkan data jurusan";
        }
    }
    
    header("Location: dataJurusan.php");
    exit();
}

$jurusan = [];
if ($edit) {
    $query = mysqli_query($conn, "SELECT * FROM jurusan WHERE id_jurusan = '$edit'");
    $jurusan = mysqli_fetch_assoc($query);
    if (!$jurusan) {
        $_SESSION['error'] = "Data jurusan tidak ditemukan";
        header("Location: dataJurusan.php");
        exit();
    }
}
?>

<!-- ========== header start ========== -->
<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title d-flex align-items-center flex-wrap mb-30">
                        <h2 class="mr-40"><?= $edit ? 'Edit' : 'Tambah' ?> Jurusan</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="jurusan.php">Data Jurusan</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= $edit ? 'Edit' : 'Tambah' ?> Jurusan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="kode_jurusan">Kode Jurusan</label>
                                    <input type="text" id="kode_jurusan" name="kode_jurusan" 
                                           value="<?= isset($jurusan['kode_jurusan']) ? htmlspecialchars($jurusan['kode_jurusan']) : '' ?>" 
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="nama_jurusan">Nama Jurusan</label>
                                    <input type="text" id="nama_jurusan" name="nama_jurusan" 
                                           value="<?= isset($jurusan['nama_jurusan']) ? htmlspecialchars($jurusan['nama_jurusan']) : '' ?>" 
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="4"><?= isset($jurusan['deskripsi']) ? htmlspecialchars($jurusan['deskripsi']) : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="button-group d-flex justify-content-end">
                                    <a href="dataJurusan.php" class="main-btn danger-btn btn-hover mx-2">Batal</a>
                                    <button type="submit" class="main-btn primary-btn btn-hover">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include './template/footer.php'; ?>
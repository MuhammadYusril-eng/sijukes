<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$queryUser = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($queryUser);
// Proses simpan data
if (isset($_POST['simpan'])) {
    $nama_mapel = mysqli_real_escape_string($conn, $_POST['nama_mapel']);
    $kode_mapel = mysqli_real_escape_string($conn, $_POST['kode_mapel']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

 // Cek duplikat nama_mapel dan kode_mapel saat simpan (insert)
$cekDuplikat = mysqli_query($conn, "
    SELECT * FROM mapel 
    WHERE nama_mapel = '$nama_mapel' OR kode_mapel = '$kode_mapel'
");
if (mysqli_num_rows($cekDuplikat) > 0) {
    echo "<script>alert('Nama Mapel atau Kode Mapel sudah digunakan!'); window.history.back();</script>";
    exit;
}

// Cek duplikat nama_mapel dan kode_mapel saat update (kecuali data yang sedang diedit)
$cekDuplikat = mysqli_query($conn, "
    SELECT * FROM mapel 
    WHERE (nama_mapel = '$nama_mapel' OR kode_mapel = '$kode_mapel') AND id_mapel != $id_mapel
");
if (mysqli_num_rows($cekDuplikat) > 0) {
    echo "<script>alert('Nama Mapel atau Kode Mapel sudah digunakan oleh data lain!'); window.history.back();</script>";
    exit;
}

    $query = "INSERT INTO mapel (nama_mapel, kode_mapel, deskripsi, created_at) 
              VALUES ('$nama_mapel', '$kode_mapel', '$deskripsi', NOW())";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Mapel berhasil disimpan!'); window.location.href='dataMapel.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data Mapel.');</script>";
    }
}

// Proses update data
if (isset($_POST['update'])) {
    $id_mapel = intval($_POST['id_mapel']);
    $nama_mapel = mysqli_real_escape_string($conn, $_POST['nama_mapel']);
    $kode_mapel = mysqli_real_escape_string($conn, $_POST['kode_mapel']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Cek duplikat kode_mapel selain dirinya sendiri
    $cekKode = mysqli_query($conn, "SELECT * FROM mapel WHERE kode_mapel = '$kode_mapel' AND id_mapel != $id_mapel");
    if (mysqli_num_rows($cekKode) > 0) {
        echo "<script>alert('Kode Mapel sudah digunakan oleh data lain!'); window.history.back();</script>";
        exit;
    }

    $query = "UPDATE mapel 
              SET nama_mapel = '$nama_mapel', kode_mapel = '$kode_mapel', deskripsi = '$deskripsi' 
              WHERE id_mapel = $id_mapel";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Mapel berhasil diperbarui!'); window.location.href='dataMapel.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data Mapel.');</script>";
    }
}

// Proses hapus data
if (isset($_GET['hapus'])) {
   $id = $_GET['hapus'];

// Cek apakah mapel masih dipakai di jadwal_ujian
$cek = mysqli_query($conn, "SELECT * FROM jadwal_ujian WHERE mapel_id = $id");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Mapel tidak bisa dihapus karena masih digunakan di jadwal ujian.'); window.location.href='dataMapel.php';</script>";
    exit;
}

// Jika tidak ada, hapus mapel
$query = mysqli_query($conn, "DELETE FROM mapel WHERE id_mapel = $id");
if ($query) {
    echo "<script>alert('Data mapel berhasil dihapus!'); window.location.href='dataMapel.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data mapel.');</script>";
}

}

// Ambil data untuk edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM mapel WHERE id_mapel = $id");
    $editData = mysqli_fetch_assoc($result);
}
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-30"><?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Mata Pelajaran</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style settings-card-1 mb-30">
                    <div class="profile-info">
                        <form method="POST" action="">
                            <?php if (isset($editData)): ?>
                                <input type="hidden" name="id_mapel" value="<?= $editData['id_mapel'] ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                    <label>Nama Mapel <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mapel" class="form-control" required value="<?= htmlspecialchars($editData['nama_mapel'] ?? '') ?>">
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                    <label>Kode Mapel <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_mapel" class="form-control" required value="<?= htmlspecialchars($editData['kode_mapel'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($editData['deskripsi'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>" 
                                            class="main-btn primary-btn btn-hover mt-3">
                                        <?= isset($editData) ? 'Update' : 'Simpan' ?> Data Guru
                                    </button>
                                    <a href="dataMapel.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'template/footer.php'; ?>

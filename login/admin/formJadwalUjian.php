<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);    
$tanggal_ujian = $_POST['tanggal_ujian'] ?? '';
$jam_mulai = $_POST['jam_mulai'] ?? '';
$jam_selesai = $_POST['jam_selesai'] ?? '';
$guru_pengawas_id = $_POST['guru_pengawas_id'] ?? '';
$ruangan_id = $_POST['ruangan_id'] ?? '';


// Proses simpan data
if (isset($_POST['simpan'])) {
    $nama_ujian = mysqli_real_escape_string($conn, $_POST['nama_ujian']);
    $mapel_id = mysqli_real_escape_string($conn, $_POST['mapel_id']);
    $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas_id']);
    $guru_pengawas_id = mysqli_real_escape_string($conn, $_POST['guru_pengawas_id']);
    $tanggal_ujian = $_POST['tanggal_ujian'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan_id = mysqli_real_escape_string($conn, $_POST['ruangan_id']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
// Cek apakah ada jadwal bentrok (pengawas dan ruangan pada waktu yang sama)
$cekBentrok = mysqli_query($conn, "
    SELECT * FROM jadwal_ujian 
    WHERE 
        tanggal_ujian = '$tanggal_ujian' 
        AND (
            (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_mulai')
        )
        AND (
            guru_pengawas_id = '$guru_pengawas_id' 
            OR ruangan_id = '$ruangan_id'
        )
");

if (mysqli_num_rows($cekBentrok) > 0) {
    echo "<script>alert('Jadwal bentrok dengan pengawas atau ruangan lain. Silakan pilih waktu lain.'); window.history.back();</script>";
    exit;
}

    $query = "INSERT INTO jadwal_ujian (nama_ujian, mapel_id, kelas_id, guru_pengawas_id, tanggal_ujian, jam_mulai, jam_selesai, ruangan_id, keterangan) 
              VALUES ('$nama_ujian', '$mapel_id', '$kelas_id', '$guru_pengawas_id', '$tanggal_ujian', '$jam_mulai', '$jam_selesai', '$ruangan_id', '$keterangan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='jadwalUjian.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data.');</script>";
    }
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_ujian = mysqli_real_escape_string($conn, $_POST['nama_ujian']);
    $mapel_id = mysqli_real_escape_string($conn, $_POST['mapel_id']);
    $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas_id']);
    $guru_pengawas_id = mysqli_real_escape_string($conn, $_POST['guru_pengawas_id']);
    $tanggal_ujian = $_POST['tanggal_ujian'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan_id = mysqli_real_escape_string($conn, $_POST['ruangan_id']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
// Cek apakah ada jadwal bentrok saat update (kecuali dirinya sendiri)
$cekBentrok = mysqli_query($conn, "
    SELECT * FROM jadwal_ujian 
    WHERE 
        id != '$id'
        AND tanggal_ujian = '$tanggal_ujian' 
        AND (
            (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_mulai')
        )
        AND (
            guru_pengawas_id = '$guru_pengawas_id' 
            OR ruangan_id = '$ruangan_id'
        )
");

if (mysqli_num_rows($cekBentrok) > 0) {
    echo "<script>alert('Jadwal bentrok dengan pengawas atau ruangan lain. Silakan pilih waktu lain.'); window.history.back();</script>";
    exit;
}

    $query = "UPDATE jadwal_ujian SET 
                nama_ujian='$nama_ujian', 
                mapel_id='$mapel_id', 
                kelas_id='$kelas_id', 
                guru_pengawas_id='$guru_pengawas_id', 
                tanggal_ujian='$tanggal_ujian', 
                jam_mulai='$jam_mulai', 
                jam_selesai='$jam_selesai', 
                ruangan_id='$ruangan_id', 
                keterangan='$keterangan' 
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='jadwalUjian.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM jadwal_ujian WHERE id=$id";
    mysqli_query($conn, $query);
    echo "<script>alert('Data berhasil dihapus!'); window.location.href='jadwalUjian.php';</script>";
}

// Ambil data jika edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM jadwal_ujian WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Ambil data untuk dropdown
$mapel_options = mysqli_query($conn, "SELECT * FROM mapel ORDER BY nama_mapel");
$jurusan_options = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY kode_jurusan");
$kelas_options = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas");
$guru_options = mysqli_query($conn, "SELECT g.*, u.nama FROM guru g JOIN users u ON g.user_id = u.id ORDER BY u.nama");
$ruangan_options = mysqli_query($conn, "SELECT * FROM ruangan ORDER BY nama_ruangan");
?>
<?php require_once 'template/header.php';?>
<?php require_once 'template/sidebar.php';?>

<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- Title content here -->
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#0">Pages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style settings-card-1 mb-30">
                            <div class="profile-info">
                                <form method="POST" action="">
                                    <?php if ($editData): ?>
                                        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Nama Ujian</label>
                                                <input type="text" name="nama_ujian" class="form-control" required value="<?= htmlspecialchars($editData['nama_ujian'] ?? '') ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Mata Pelajaran</label>
                                                <select name="mapel_id" class="form-control" required>
                                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                                    <?php while ($mapel = mysqli_fetch_assoc($mapel_options)): ?>
                                                        <option value="<?= $mapel['id_mapel'] ?>" 
                                                            <?= ($editData && $editData['mapel_id'] == $mapel['id_mapel']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($mapel['nama_mapel']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>

                                          <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Jurusan</label>
                                                <select name="jurusan_id" class="form-control" required>
                                                    <option value="">-- Pilih Jurusan --</option>
                                                    <?php while ($jurusan = mysqli_fetch_assoc($jurusan_options)): ?>
                                                        <option value="<?= $jurusan['id_jurusan'] ?>" 
                                                            <?= ($editData && $editData == $jurusan['id_jurusan']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($jurusan['kode_jurusan']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Kelas</label>
                                                <select name="kelas_id" class="form-control" required>
                                                    <option value="">-- Pilih Kelas --</option>
                                                    <?php while ($kelas = mysqli_fetch_assoc($kelas_options)): ?>
                                                        <option value="<?= $kelas['id_kelas'] ?>" 
                                                            <?= ($editData && $editData['kelas_id'] == $kelas['id_kelas']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($kelas['nama_kelas']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Pengawas</label>
                                                <select name="guru_pengawas_id" class="form-control" required>
                                                    <option value="">-- Pilih Guru Pengawas --</option>
                                                    <?php while ($guru = mysqli_fetch_assoc($guru_options)): ?>
                                                        <option value="<?= $guru['id'] ?>" 
                                                            <?= ($editData && $editData['guru_pengawas_id'] == $guru['id']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($guru['nama']) ?> (NIP: <?= $guru['nip'] ?>)
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Tanggal Ujian</label>
                                                <input type="date" name="tanggal_ujian" class="form-control" required value="<?= $editData['tanggal_ujian'] ?? date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="input-style-1">
                                                <label>Jam Mulai</label>
                                                <input type="time" name="jam_mulai" class="form-control" required value="<?= $editData['jam_mulai'] ?? '08:00' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="input-style-1">
                                                <label>Jam Selesai</label>
                                                <input type="time" name="jam_selesai" class="form-control" required value="<?= $editData['jam_selesai'] ?? '10:00' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="input-style-1">
                                                <label>Ruangan</label>
                                                <select name="ruangan_id" class="form-control" required>
                                                    <option value="">-- Pilih Ruangan --</option>
                                                    <?php while ($ruangan = mysqli_fetch_assoc($ruangan_options)): ?>
                                                        <option value="<?= $ruangan['id_ruangan'] ?>" 
                                                            <?= ($editData && $editData['ruangan_id'] == $ruangan['id_ruangan']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($ruangan['nama_ruangan']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="input-style-1">
                                                <label>Keterangan (Opsional)</label>
                                                <textarea name="keterangan" class="form-control"><?= htmlspecialchars($editData['keterangan'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" name="<?= $editData ? 'update' : 'simpan' ?>" class="main-btn primary-btn btn-hover mt-3">
                                                <?= $editData ? 'Update' : 'Tambah' ?> Jadwal
                                            </button>
                                            <a href="jadwalUjian.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<?php include './template/footer.php'; ?>
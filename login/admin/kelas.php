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

<main>
       <section class="section">
                    <div class="container-fluid">
                        <!-- ========== title-wrapper start ========== -->
                        <div class="title-wrapper pt-80">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <!-- <div class="title d-flex align-items-center flex-wrap mb-30">
                                        <h2 class="mr-40">Daftar Tim</h2>
                                    </div> -->
                                </div>
                                <!-- end col -->
                                <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="#0">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#0">Pages</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Settings
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>

    
<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Kelas</h6>
                        <div>
                        <a href="formJadwalKegiatan.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                            <a href="cetakJadwal.php?cetak_kegiatan" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                               Cetak <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Lokasi</th>
                                    <th>Untuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal DESC");
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                    <td><?= $row['jam'] ?></td>
                                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                    <td><?= $row['ditujukan_untuk'] ?></td>
                                    <td>
                                    <a href="formJadwalKegiatan.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="lni lni-pencil"></i>
                                            </a>
                                            <a href="formJadwalKegiatan.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($query) == 0): ?>
                                    <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['tambah']) || isset($_GET['edit'])): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style settings-card-1 mb-30">
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($editData): ?>
                        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $editData['gambar'] ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control" required value="<?= htmlspecialchars($editData['judul'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required value="<?= $editData['tanggal'] ?? '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Jam</label>
                                <input type="time" name="jam" class="form-control" required value="<?= $editData['jam'] ?? '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" required value="<?= htmlspecialchars($editData['lokasi'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Untuk</label>
                                <select name="ditujukan_untuk" class="form-control">
                                    <option value="siswa" <?= (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                                    <option value="guru" <?= (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'guru') ? 'selected' : '' ?>>Guru</option>
                                    <option value="semua" <?= (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'semua') ? 'selected' : '' ?>>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Gambar (optional)</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                            <div class="col-12">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($editData['deskripsi'] ?? '') ?></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" name="<?= $editData ? 'update' : 'simpan' ?>" class="main-btn primary-btn btn-hover">
                                    <?= $editData ? 'Update' : 'Tambah' ?> Kegiatan
                                </button>
                                <a href="formJadwalKegiatan.php" class="main-btn light-btn btn-hover">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
</div>
</section>
</main>
<?php include './template/footer.php'; ?>

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
                        <div class="title d-flex align-items-center flex-wrap mb-30">
                            <h2 class="mr-40">Manajemen Kegiatan</h2>
                        </div>
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
                                        <a href="#0">Kegiatan</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Daftar Kegiatan
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>

            <section class="section">
                <div class="container-fluid">
                    <!-- Tabel Data Kegiatan -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-style mb-30">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Daftar Kegiatan Sekolah</h6>
                                    <div>
                                        <a href="formJadwalKegiatan.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                                        <a href="cetakKegiatan.php" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                                           Cetak <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Lokasi</th>
                                                <th>Untuk</th>
                                                <th>Penanggung Jawab</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query = mysqli_query($conn, "
                                                SELECT k.*, u.nama AS nama_penanggung_jawab 
                                                FROM kegiatan k
                                                LEFT JOIN guru g ON k.penanggung_jawab_id = g.id
                                                LEFT JOIN users u ON g.user_id = u.id
                                                ORDER BY k.tanggal_mulai DESC, k.jam_mulai DESC
                                            ");
                                            
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                // Format tanggal
                                                $tanggal_mulai = date('d M Y', strtotime($row['tanggal_mulai']));
                                                $tanggal_selesai = $row['tanggal_selesai'] ? date('d M Y', strtotime($row['tanggal_selesai'])) : '';
                                                $tanggal = $tanggal_mulai;
                                                if ($tanggal_selesai && $tanggal_selesai != $tanggal_mulai) {
                                                    $tanggal .= " s/d " . $tanggal_selesai;
                                                }
                                                
                                                // Format jam
                                                $jam_mulai = $row['jam_mulai'] ? date('H:i', strtotime($row['jam_mulai'])) : '';
                                                $jam_selesai = $row['jam_selesai'] ? date('H:i', strtotime($row['jam_selesai'])) : '';
                                                $jam = $jam_mulai;
                                                if ($jam_selesai) {
                                                    $jam .= " - " . $jam_selesai;
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($row['judul']) ?></strong>
                                                        <?php if ($row['gambar']): ?>
                                                            <span class="badge bg-info">Ada Gambar</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $tanggal ?></td>
                                                    <td><?= $jam ?></td>
                                                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                                    <td><?= ucfirst($row['ditujukan_untuk']) ?></td>
                                                    <td><?= $row['nama_penanggung_jawab'] ? htmlspecialchars($row['nama_penanggung_jawab']) : '-' ?></td>
                                                    <td>
                                                        <!-- <a href="detailKegiatan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a> -->
                                                        <a href="formJadwalKegiatan.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="lni lni-pencil"></i>
                                                        </a>
                                                        <a href="prosesKegiatan.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php if (mysqli_num_rows($query) == 0): ?>
                                                <tr><td colspan="8" class="text-center">Belum ada kegiatan.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Tambah/Edit Kegiatan -->
                    <?php if (isset($_GET['tambah']) || isset($_GET['edit'])): 
                        $editData = null;
                        if (isset($_GET['edit'])) {
                            $id = mysqli_real_escape_string($conn, $_GET['edit']);
                            $query = mysqli_query($conn, "
                                SELECT k.*, g.id AS guru_id 
                                FROM kegiatan k
                                LEFT JOIN guru g ON k.penanggung_jawab_id = g.id
                                WHERE k.id = '$id'
                            ");
                            $editData = mysqli_fetch_assoc($query);
                        }
                        
                        // Ambil data untuk dropdown penanggung jawab
                        $penanggung_jawab_options = mysqli_query($conn, "
                            SELECT g.id, u.nama 
                            FROM guru g
                            JOIN users u ON g.user_id = u.id
                            ORDER BY u.nama
                        ");
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style settings-card-1 mb-30">
                                <div class="title">
                                    <h6><?= isset($editData) ? 'Edit' : 'Tambah' ?> Kegiatan</h6>
                                </div>
                                <div class="profile-info">
                                    <form method="POST" action="prosesKegiatan.php" enctype="multipart/form-data">
                                        <?php if (isset($editData)): ?>
                                            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                                        <?php endif; ?>
                                        
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-style-1">
                                                    <label>Judul Kegiatan *</label>
                                                    <input type="text" name="judul" class="form-control" required 
                                                           value="<?= htmlspecialchars($editData['judul'] ?? '') ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="input-style-1">
                                                    <label>Ditujukan Untuk *</label>
                                                    <select name="ditujukan_untuk" class="form-control" required>
                                                        <option value="semua" <?= (isset($editData) && $editData['ditujukan_untuk'] == 'semua') ? 'selected' : '' ?>>Semua</option>
                                                        <option value="siswa" <?= (isset($editData) && $editData['ditujukan_untuk'] == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                                                        <option value="guru" <?= (isset($editData) && $editData['ditujukan_untuk'] == 'guru') ? 'selected' : '' ?>>Guru</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="input-style-1">
                                                    <label>Deskripsi Kegiatan</label>
                                                    <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($editData['deskripsi'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="input-style-1">
                                                    <label>Tanggal Mulai *</label>
                                                    <input type="date" name="tanggal_mulai" class="form-control" required 
                                                           value="<?= $editData['tanggal_mulai'] ?? date('Y-m-d') ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="input-style-1">
                                                    <label>Tanggal Selesai (Opsional)</label>
                                                    <input type="date" name="tanggal_selesai" class="form-control" 
                                                           value="<?= $editData['tanggal_selesai'] ?? '' ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="input-style-1">
                                                    <label>Jam Mulai (Opsional)</label>
                                                    <input type="time" name="jam_mulai" class="form-control" 
                                                           value="<?= $editData['jam_mulai'] ?? '' ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="input-style-1">
                                                    <label>Jam Selesai (Opsional)</label>
                                                    <input type="time" name="jam_selesai" class="form-control" 
                                                           value="<?= $editData['jam_selesai'] ?? '' ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8">
                                                <div class="input-style-1">
                                                    <label>Lokasi Kegiatan</label>
                                                    <input type="text" name="lokasi" class="form-control" 
                                                           value="<?= htmlspecialchars($editData['lokasi'] ?? '') ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="input-style-1">
                                                    <label>Penanggung Jawab</label>
                                                    <select name="penanggung_jawab_id" class="form-control">
                                                        <option value="">-- Pilih Penanggung Jawab --</option>
                                                        <?php while ($guru = mysqli_fetch_assoc($penanggung_jawab_options)): ?>
                                                            <option value="<?= $guru['id'] ?>" 
                                                                <?= (isset($editData) && $editData['penanggung_jawab_id'] == $guru['id']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($guru['nama']) ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="input-style-1">
                                                    <label>Gambar Kegiatan (Opsional)</label>
                                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                                    <?php if (isset($editData) && !empty($editData['gambar'])): ?>
                                                        <div class="mt-2">
                                                            <small>Gambar saat ini:</small><br>
                                                            <a href="<?= $editData['gambar'] ?>" target="_blank" class="btn btn-sm btn-light">
                                                                Lihat Gambar
                                                            </a>
                                                            <label class="checkbox-inline mt-2">
                                                                <input type="checkbox" name="hapus_gambar" value="1"> Hapus gambar ini
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>" class="main-btn primary-btn btn-hover mt-3">
                                                    <?= isset($editData) ? 'Update' : 'Simpan' ?> Kegiatan
                                                </button>
                                                <a href="kegiatan.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
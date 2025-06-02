<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);
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
                        <h2 class="mr-40">Daftar Siswa</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== table start ========== -->
        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Siswa</h6>
                        <div>
                            <a href="formSiswa.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                            <a href="cetak.php?cetakSiswa=true" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                                Cetak <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                          <tbody>
                            <?php
                            $no = 1;
                        $query = "SELECT s.*, u.nama AS nama_siswa, u.email 
                                FROM siswa s
                                JOIN users u ON s.user_id = u.id
                                ORDER BY u.nama ASC";
                        $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $jenis_kelamin = ($row['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan';
                            ?>
                                <tr>
                                    <td><p><?= $no++; ?></p></td>
                                    <td><p><?= htmlspecialchars($row['nama_siswa']); ?></p></td>
                                    <td><p><?= htmlspecialchars($row['nis']); ?></p></td>
                                    <td><p><?= $jenis_kelamin; ?></p></td>
                                    <td><p><?= htmlspecialchars($row['email']); ?></p></td>
                                    <td><p><?= htmlspecialchars($row['no_telp']); ?></p></td>
                                    <td><p><?= htmlspecialchars($row['kelas']); ?></p></td>
                                    <td><p><?= htmlspecialchars($row['tingkat']); ?></p></td>


                                    <td>
                                        <a href="formSiswa.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="lni lni-pencil"></i>
                                        </a>
                                        <a href="formSiswa.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p>Tidak ada data siswa.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== table end ========== -->
    </div>
</section>

<?php include './template/footer.php'; ?>

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
                        <h2 class="mr-40">Daftar Kelas</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
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
                        <h6 class="mb-0">Daftar Kelas</h6>
                        <div>
                            <a href="formKelas.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Kompetensi Keahlian</th>
                                    <th>Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = "SELECT k.*, u.nama AS wali_kelas
                                FROM kelas k
                                LEFT JOIN guru g ON k.wali_kelas_id = g.id
                                LEFT JOIN users u ON g.user_id = u.id
                                ORDER BY k.nama_kelas ASC;
";

                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><p><?= $no++; ?></p></td>
                                        <td><p><?= htmlspecialchars($row['nama_kelas']); ?></p></td>
                                        <td><p><?= htmlspecialchars($row['tingkat']); ?></p></td>
                                        <td><p><?= htmlspecialchars($row['kompetensi_keahlian']); ?></p></td>
                                        <td><p><?= $row['wali_kelas'] ? htmlspecialchars($row['wali_kelas']) : '-'; ?></p></td>
                                        <td>
                                            <a href="formKelas.php?edit=<?= $row['id_kelas'] ?>" class="btn btn-sm btn-warning">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                           <a href="formKelas.php?hapus=<?= htmlspecialchars($row['id_kelas']) ?>" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirmDelete(event, this)">
                                            <i class="fas fa-trash"></i>
                                            </a>

                                            <script>
                                            function confirmDelete(e, element) {
                                                e.preventDefault();
                                                if (confirm('Yakin ingin menghapus data ini?')) {
                                                    window.location.href = element.href;
                                                }
                                                return false;
                                            }
                                            </script>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($result) == 0): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p>Tidak ada data kelas.</p>
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

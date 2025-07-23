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
                        <h2 class="mr-40">Daftar Jurusan</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Jurusan</li>
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
                        <h6 class="mb-0">Daftar Jurusan</h6>
                        <div>
                            <a href="formJurusan.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Jurusan</th>
                                    <th>Nama Jurusan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = "SELECT * FROM jurusan ORDER BY nama_jurusan ASC";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><p><?= $no++; ?></p></td>
                                        <td><p><?= htmlspecialchars($row['kode_jurusan']); ?></p></td>
                                        <td><p><?= htmlspecialchars($row['nama_jurusan']); ?></p></td>
                                        <td><p><?= htmlspecialchars($row['deskripsi']); ?></p></td>
                                        <td>
                                            <a href="formJurusan.php?edit=<?= $row['id_jurusan'] ?>" class="btn btn-sm btn-warning">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <a href="formJurusan.php?hapus=<?= htmlspecialchars($row['id_jurusan']) ?>" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirmDelete(event, this)">
                                            <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($result) == 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p>Tidak ada data jurusan.</p>
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

<script>
function confirmDelete(e, element) {
    e.preventDefault();
    if (confirm('Yakin ingin menghapus data ini?')) {
        window.location.href = element.href;
    }
    return false;
}
</script>

<?php include './template/footer.php'; ?>
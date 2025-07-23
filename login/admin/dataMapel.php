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
                        <h2 class="mr-40">Daftar Mata Pelajaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Mapel</li>
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
                        <h6 class="mb-0">Daftar Mata Pelajaran</h6>
                        <div>
                            <a href="formMapel.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                        </div>
                    </div>
                  <div class="table-wrapper table-responsive">
    <table id="dataMapel" class="table stripe-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Deskripsi</th>
                <th>Dibuat Pada</th>
                <th width="120px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = "SELECT * FROM mapel ORDER BY nama_mapel ASC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['kode_mapel']); ?></td>
                    <td><?= htmlspecialchars($row['nama_mapel']); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                    <td><?= date("d-m-Y H:i", strtotime($row['created_at'])); ?></td>
                    <td class="pb-1">
                        <div class="d-flex">
                            <a href="formMapel.php?edit=<?= $row['id_mapel'] ?>" class="btn btn-sm btn-warning mr-2">
                                <i class="lni lni-pencil"></i>
                            </a>
                            <a href="formMapel.php?hapus=<?= $row['id_mapel'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!-- JavaScript DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataMapel').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json"
        },
        "columnDefs": [
            { 
                "orderable": false, 
                "targets": [5] // Kolom aksi tidak bisa di-sort
            },
            { 
                "searchable": false, 
                "targets": [0, 5] // Kolom No dan Aksi tidak bisa dicari
            },
            { 
                "width": "10%", 
                "targets": [5] // Lebar kolom aksi
            },
            {
                "type": "date-dd-mm-yyyy", 
                "targets": [4] // Format tanggal untuk kolom 'Dibuat Pada'
            }
        ],
        
        "responsive": true
    });
});
</script>

<!-- Tambahkan style untuk tombol aksi -->
<style>
.d-flex {
    display: flex;
    gap: 5px;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
                    
                </div>
            </div>
        </div>
         
        <!-- ========== table end ========== -->
    </div>
</section>

<?php include './template/footer.php'; ?>

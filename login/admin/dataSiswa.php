
<?php
if (isset($_SESSION['import_message'])) {
    $msg = $_SESSION['import_message'];
    echo "<script>
        alert('{$msg['text']}');
        ".(isset($msg['has_error']) ? "
        if (confirm('Download file data error?')) {
            window.open('?download_error=1', '_blank');
        }
        " : "")."
    </script>";
    unset($_SESSION['import_message']);
}
?>
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
                    <button id="deleteSelected" class="main-btn btn-hover btn-sm me-2" disabled>
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                    <a href="formSiswa.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                    <a href="cetak.php?cetakSiswa=true" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                        Cetak <i class="fas fa-print"></i>
                    </a>
                </div>
            </div>
           <div class="table-wrapper table-responsive">
    <form id="multiDeleteForm" action="formSiswa.php" method="post">
        <table id="siswaTable" class="table striped-table">
            <thead>
                <tr>
                    <th width="50px">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = "SELECT s.*, u.nama AS nama_siswa, u.email, k.nama_kelas, j.nama_jurusan 
                          FROM siswa s
                          JOIN users u ON s.user_id = u.id
                          LEFT JOIN kelas k ON s.kelas_id = k.id_kelas
                          LEFT JOIN jurusan j ON s.jurusan_id = j.id_jurusan
                          ORDER BY u.nama ASC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $jenis_kelamin = ($row['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan';
                    $kelas = $row['nama_kelas'] ?? 'Belum ada kelas';
                    $jurusan = $row['nama_jurusan'] ?? 'Belum ada jurusan';
                ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="rowCheckbox" name="selected_ids[]" value="<?= $row['id'] ?>">
                        </td>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><?= htmlspecialchars($row['nis']); ?></td>
                        <td><?= htmlspecialchars($kelas) ?></td>
                        <td><?= htmlspecialchars($jurusan); ?></td>
                        <td><?= $jenis_kelamin; ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['no_telp']); ?></td>
                        <td class="pb-1">
                            <a href="formSiswa.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="lni lni-pencil"></i>
                            </a>
                            <a href="formSiswa.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#siswaTable').DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(disaring dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [0, 9] } // Non-aktifkan sorting untuk kolom checkbox dan aksi
        ]
    });
    
    // Handle select all checkbox
    $('#selectAll').click(function() {
        $('.rowCheckbox').prop('checked', this.checked);
    });
});
</script>
        </div>
    </div>
</div>

<!-- JavaScript untuk fungsi multi-select -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select/Deselect all checkbox
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    const deleteBtn = document.getElementById('deleteSelected');
    
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        toggleDeleteButton();
    });
    
    // Toggle delete button based on checked boxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleDeleteButton);
    });
    
    function toggleDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
        deleteBtn.disabled = checkedBoxes.length === 0;
    }
    
    // Delete selected rows
    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
        
        if (checkedBoxes.length > 0) {
            if (confirm(`Yakin ingin menghapus ${checkedBoxes.length} data siswa terpilih?`)) {
                document.getElementById('multiDeleteForm').submit();
            }
        }
    });
});
</script>
        <!-- ========== table end ========== -->
    </div>
</section>

<?php include './template/footer.php'; ?>

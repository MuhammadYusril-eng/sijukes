<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);

// Pastikan hanya siswa yang bisa mengakses
if ($_SESSION['role'] != 'siswa') {
    header("Location: unauthorized.php");
    exit();
}

// Ambil data siswa beserta kelas_id
$siswa_query = mysqli_query($conn, 
    "SELECT s.*, k.nama_kelas 
     FROM siswa s 
     LEFT JOIN kelas k ON s.kelas_id = k.id_kelas 
     WHERE s.user_id = '$user_id'");
$siswa = mysqli_fetch_assoc($siswa_query);
$kelas_id = $siswa['kelas_id'] ?? null;

// Parameter filter
$filter_mapel = isset($_GET['mapel']) ? $_GET['mapel'] : '';
$filter_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// Query dasar
$query = "SELECT ju.*, m.nama_mapel, m.kode_mapel, r.nama_ruangan, 
          g.nip, u.nama AS nama_pengawas
          FROM jadwal_ujian ju
          JOIN mapel m ON ju.mapel_id = m.id_mapel
          JOIN ruangan r ON ju.ruangan_id = r.id_ruangan
          JOIN guru g ON ju.guru_pengawas_id = g.id
          JOIN users u ON g.user_id = u.id
          WHERE ju.kelas_id = '$kelas_id'";

// Tambahkan filter
if (!empty($filter_mapel)) {
    $query .= " AND m.nama_mapel LIKE '%$filter_mapel%'";
}

if (!empty($filter_tanggal)) {
    $query .= " AND ju.tanggal_ujian = '$filter_tanggal'";
}

// Dapatkan daftar mapel untuk dropdown filter
$mapel_query = mysqli_query($conn, 
    "SELECT DISTINCT m.id_mapel, m.nama_mapel 
     FROM jadwal_ujian ju
     JOIN mapel m ON ju.mapel_id = m.id_mapel
     WHERE ju.kelas_id = '$kelas_id'
     ORDER BY m.nama_mapel");

// Urutkan dan eksekusi query utama
$query .= " ORDER BY ju.tanggal_ujian ASC, ju.jam_mulai ASC";
$result = mysqli_query($conn, $query);
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<style>
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .filter-group {
        margin-bottom: 15px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .badge-primary {
        background-color: #4e73df;
    }
    .badge-success {
        background-color: #1cc88a;
    }
    .badge-warning {
        background-color: #f6c23e;
    }
    .badge-secondary {
        background-color: #858796;
    }
    .reset-filter {
        margin-top: 24px;
    }
</style>

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title d-flex align-items-center flex-wrap mb-30">
                        <h2 class="mr-40">Jadwal Ujian</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-siswa.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Jadwal Ujian</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row">
            <div class="col-12">
                <div class="filter-card">
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="filter-group">
                                    <label for="mapel">Mata Pelajaran</label>
                                    <select class="form-control" id="mapel" name="mapel">
                                        <option value="">Semua Mapel</option>
                                        <?php while ($mapel = mysqli_fetch_assoc($mapel_query)): ?>
                                            <option value="<?= htmlspecialchars($mapel['nama_mapel']) ?>" 
                                                <?= ($filter_mapel == $mapel['nama_mapel']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($mapel['nama_mapel']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-group">
                                    <label for="tanggal">Tanggal Ujian</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                           value="<?= htmlspecialchars($filter_tanggal) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="akan_datang" <?= ($filter_status == 'akan_datang') ? 'selected' : '' ?>>Akan Datang</option>
                                        <option value="hari_ini" <?= ($filter_status == 'hari_ini') ? 'selected' : '' ?>>Hari Ini</option>
                                        <option value="selesai" <?= ($filter_status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="main-btn primary-btn btn-hover flex-grow-1">Filter</button>
                                <a href="jadwalUjian.php" class="main-btn light-btn btn-hover reset-filter flex-grow-1">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Jadwal Ujian <?= $kelas_id ? 'Kelas ' . htmlspecialchars($siswa['nama_kelas']) : 'Anda belum memiliki kelas' ?></h6>
                        <div>
                        <a href="cetak.php?cetak_ujian=1&user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                            <i class="lni lni-printer"></i> Cetak Jadwal
                        </a>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Ruangan</th>
                                    <th>Pengawas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($kelas_id && mysqli_num_rows($result) > 0): ?>
                                    <?php 
                                    $no = 1; 
                                    $today = date('Y-m-d');
                                    while ($row = mysqli_fetch_assoc($result)): 
                                        // Tentukan status
                                        $status = '';
                                        $badge_class = '';
                                        
                                        if ($row['tanggal_ujian'] > $today) {
                                            $status = 'Akan Datang';
                                            $badge_class = 'badge-primary';
                                        } elseif ($row['tanggal_ujian'] == $today) {
                                            $status = 'Hari Ini';
                                            $badge_class = 'badge-success';
                                        } else {
                                            $status = 'Selesai';
                                            $badge_class = 'badge-secondary';
                                        }
                                        
                                        // Filter berdasarkan status jika dipilih
                                        $show_row = true;
                                        if (!empty($filter_status)) {
                                            if ($filter_status == 'akan_datang' && $row['tanggal_ujian'] <= $today) {
                                                $show_row = false;
                                            } elseif ($filter_status == 'hari_ini' && $row['tanggal_ujian'] != $today) {
                                                $show_row = false;
                                            } elseif ($filter_status == 'selesai' && $row['tanggal_ujian'] >= $today) {
                                                $show_row = false;
                                            }
                                        }
                                        
                                        if ($show_row):
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_ujian']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                            <td><?= date('d M Y', strtotime($row['tanggal_ujian'])) ?></td>
                                            <td><?= date('H:i', strtotime($row['jam_mulai'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                                            <td><?= htmlspecialchars($row['nama_ruangan']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_pengawas']) ?> (<?= htmlspecialchars($row['nip']) ?>)</td>
                                            <td><span class="badge <?= $badge_class ?>"><?= $status ?></span></td>
                                        </tr>
                                    <?php 
                                        endif;
                                    endwhile; 
                                    ?>
                                <?php elseif (!$kelas_id): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Anda belum terdaftar di kelas manapun</td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada jadwal ujian yang sesuai dengan filter</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Set tanggal hari ini sebagai default di input tanggal
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').setAttribute('max', today);
    
    // Jika filter status "Hari Ini" dipilih, set tanggal ke hari ini
    const statusFilter = document.getElementById('status');
    const tanggalFilter = document.getElementById('tanggal');
    
    statusFilter.addEventListener('change', function() {
        if (this.value === 'hari_ini') {
            tanggalFilter.value = today;
        }
    });
});
</script>

<?php include './template/footer.php'; ?>
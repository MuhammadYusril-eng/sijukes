<?php
require_once 'template/header.php';

// Ambil data siswa beserta informasi kelas
$siswa_query = mysqli_query($conn, 
    "SELECT s.*, u.nama, k.nama_kelas, j.nama_jurusan 
     FROM siswa s
     JOIN users u ON s.user_id = u.id
     LEFT JOIN kelas k ON s.kelas_id = k.id_kelas
     LEFT JOIN jurusan j ON s.jurusan_id = j.id_jurusan
     WHERE s.user_id = '$user_id'");
$siswa = mysqli_fetch_assoc($siswa_query);

// Ambil jadwal ujian untuk siswa ini berdasarkan kelas_id
$jadwal_ujian_query = mysqli_query($conn, 
    "SELECT ju.*, m.nama_mapel, r.nama_ruangan 
     FROM jadwal_ujian ju
     JOIN mapel m ON ju.mapel_id = m.id_mapel
     JOIN ruangan r ON ju.ruangan_id = r.id_ruangan
     WHERE ju.kelas_id = '".$siswa['kelas_id']."'
     ORDER BY ju.tanggal_ujian ASC, ju.jam_mulai ASC
     LIMIT 3");

// Ambil kegiatan terbaru
$kegiatan_query = mysqli_query($conn, 
    "SELECT * FROM kegiatan 
     WHERE ditujukan_untuk IN ('siswa', 'semua')
     ORDER BY tanggal_mulai DESC 
     LIMIT 3");
?>

<?php require_once 'template/sidebar.php'; ?>

<style>
    .welcome-message {
        background-color: #b8b8eb;
        border-radius: 10px;
        padding: 20px 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    .username {
        color: red;
        font-weight: bold;
    }
    .info-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .info-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
        color: #343a40;
    }
    .info-item {
        margin-bottom: 10px;
    }
    .info-label {
        font-weight: bold;
        color: #6c757d;
    }
    .info-value {
        color: #495057;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>

<section class="section mt-5">
    <div class="container-sm welcome-message">
        <h2>Selamat datang, <span class="username"><?php echo htmlspecialchars($_SESSION['username']) ?></span></h2>
        <p>Anda login sebagai siswa <?php echo htmlspecialchars($siswa['nama_kelas'] ?? 'Belum ada kelas') ?></p>
    </div>
</section>
<style>
    /* CSS Modern untuk Dashboard Siswa */
    .dashboard-section {
        padding: 2rem 0;
    }
    
    .card-student {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .card-student:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    
    .card-header-student {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem;
        border-bottom: none;
    }
    
    .card-title-student {
        font-weight: 600;
        margin-bottom: 0;
        font-size: 1.25rem;
    }
    
    .info-item {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .info-label {
        font-weight: 600;
        color: #6c757d;
        min-width: 120px;
    }
    
    .info-value {
        color: #495057;
    }
    
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 0.75rem;
    }
    
    .table-modern td {
        padding: 0.75rem;
        border-top: 1px solid #f1f1f1;
    }
    
    .table-modern tr:hover td {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .btn-view-all {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .no-data {
        color: #6c757d;
        text-align: center;
        padding: 1.5rem;
        font-style: italic;
    }
    
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .card-student {
            margin-bottom: 1.5rem;
        }
        
        .info-item {
            flex-direction: column;
        }
        
        .info-label {
            margin-bottom: 0.25rem;
            min-width: auto;
        }
    }
    
    @media (max-width: 768px) {
        .card-header-student {
            padding: 1rem;
        }
        
        .table-modern th, 
        .table-modern td {
            padding: 0.5rem;
        }
    }
</style>

<!-- ========== Dashboard Siswa Modern ========== -->
<section class="dashboard-section">
    <div class="container-fluid">
        <div class="row">
            <!-- Kolom Informasi Siswa -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-student">
                    <div class="card-header card-header-student">
                        <h5 class="card-title-student mb-0">
                            <i class="fas fa-user-graduate mr-2"></i> Profil Siswa
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <!-- <img src="assets/img/default-avatar.jpg" alt="Foto Profil" class="student-avatar"> -->
                        <h5 class="mb-3"><?php echo htmlspecialchars($siswa['nama']) ?></h5>
                        
                        <div class="text-left">
                            <div class="info-item">
                                <span class="info-label">NIS/NISN:</span>
                                <span class="info-value">
                                    <?php echo htmlspecialchars($siswa['nis']) ?> / <?php echo htmlspecialchars($siswa['nisn'] ?? '-') ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kelas/Jurusan:</span>
                                <span class="info-value">
                                    <?php echo htmlspecialchars($siswa['nama_kelas'] ?? 'Belum ada kelas') ?> / <?php echo htmlspecialchars($siswa['nama_jurusan'] ?? 'Belum ada jurusan') ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kontak:</span>
                                <span class="info-value">
                                    <?php echo htmlspecialchars($siswa['no_telp'] ?? '-') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Jadwal Ujian -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-student">
                    <div class="card-header card-header-student">
                        <h5 class="card-title-student mb-0">
                            <i class="fas fa-calendar-alt mr-2"></i> Jadwal Ujian
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($jadwal_ujian_query) > 0): ?>
                            <div class="table-responsive">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($ujian = mysqli_fetch_assoc($jadwal_ujian_query)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($ujian['nama_mapel']) ?></td>
                                                <td><?php echo date('d M', strtotime($ujian['tanggal_ujian'])) ?></td>
                                                <td><?php echo date('H:i', strtotime($ujian['jam_mulai'])) ?>-<?php echo date('H:i', strtotime($ujian['jam_selesai'])) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a href="JadwalUjian.php" class="btn btn-view-all">
                                    <i class="fas fa-list mr-1"></i> Lihat Semua
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="no-data">
                                <i class="far fa-calendar-times fa-2x mb-2"></i>
                                <p>Tidak ada jadwal ujian mendatang</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kolom Kegiatan Terbaru -->
            <div class="col-lg-4 col-md-12">
                <div class="card card-student">
                    <div class="card-header card-header-student">
                        <h5 class="card-title-student mb-0">
                            <i class="fas fa-bullhorn mr-2"></i> Kegiatan Sekolah
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($kegiatan_query) > 0): ?>
                            <div class="table-responsive">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($kegiatan = mysqli_fetch_assoc($kegiatan_query)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($kegiatan['judul']) ?></td>
                                                <td><?php echo date('d M', strtotime($kegiatan['tanggal_mulai'])) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a href="jadwalKegiatan.php" class="btn btn-view-all">
                                    <i class="fas fa-list mr-1"></i> Lihat Semua
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="no-data">
                                <i class="far fa-calendar-times fa-2x mb-2"></i>
                                <p>Tidak ada kegiatan terbaru</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include './template/footer.php'; ?>
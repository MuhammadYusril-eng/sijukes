
<?php
 require_once 'template/header.php'; 
// Ambil data guru
$guru_query = mysqli_query($conn, "SELECT g.*, u.nama FROM guru g JOIN users u ON g.user_id = u.id WHERE g.user_id = '$user_id'");
$guru = mysqli_fetch_assoc($guru_query);

// Ambil jadwal mengawas ujian (3 terdekat)
$jadwal_pengawas_query = mysqli_query($conn, 
    "SELECT ju.*, m.nama_mapel, k.nama_kelas, r.nama_ruangan
     FROM jadwal_ujian ju
     JOIN mapel m ON ju.mapel_id = m.id_mapel
     JOIN kelas k ON ju.kelas_id = k.id_kelas
     JOIN ruangan r ON ju.ruangan_id = r.id_ruangan
     WHERE ju.guru_pengawas_id = '{$guru['id']}'
     AND (ju.tanggal_ujian >= CURDATE())
     ORDER BY ju.tanggal_ujian ASC, ju.jam_mulai ASC
     LIMIT 3");

// Hitung total ujian yang diawasi
$total_pengawas_query = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM jadwal_ujian 
     WHERE guru_pengawas_id = '{$guru['id']}'");
$total_pengawas = mysqli_fetch_assoc($total_pengawas_query);

// Ambil daftar mapel yang diajar
$mapel_diajar_query = mysqli_query($conn,
    "SELECT m.nama_mapel 
     FROM guru_mapel gm
     JOIN mapel m ON gm.mapel_id = m.id_mapel
     WHERE gm.guru_id = '{$guru['id']}'
     ORDER BY m.nama_mapel");

// Ambil kegiatan terbaru untuk guru
$kegiatan_query = mysqli_query($conn, 
    "SELECT * FROM kegiatan 
     WHERE ditujukan_untuk IN ('guru', 'semua')
     ORDER BY tanggal_mulai DESC 
     LIMIT 3");
?>


<?php require_once 'template/sidebar.php'; ?>

<style>
    .welcome-message {
        background-color: #4e73df;
        color: white;
        border-radius: 10px;
        padding: 20px 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    .username {
        color: #f8f9fa;
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
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 8px;
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
    .badge-primary {
        background-color: #4e73df;
        color: white;
    }
    .badge-success {
        background-color: #1cc88a;
        color: white;
    }
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<section class="section mt-5">
    <div class="container-sm welcome-message">
        <h2>Selamat datang, <span class="username"><?php echo htmlspecialchars($guru['nama']) ?></span></h2>
        <p>Anda login sebagai guru dengan NIP <?php echo htmlspecialchars($guru['nip']) ?></p>
    </div>
</section>

<!-- ========== section start ========== -->
<section class="teacher-dashboard py-5">
    <div class="container-xl">
        <div class="row g-4">
            <!-- Teacher Information Column -->
            <div class="col-md-6 col-lg-4">
                <!-- Profile Card -->
                <div class="card profile-card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Informasi Guru</h5>
                    </div>
                    <div class="card-body">
                        <div class="teacher-info">
                            <div class="info-item d-flex align-items-center mb-3">
                                <i class="fas fa-id-card info-icon me-3"></i>
                                <div>
                                    <div class="info-label small text-muted">NIP</div>
                                    <div class="info-value fw-bold"><?php echo htmlspecialchars($guru['nip']) ?></div>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center mb-3">
                                <i class="fas fa-envelope info-icon me-3"></i>
                                <div>
                                    <div class="info-label small text-muted">Email</div>
                                    <div class="info-value fw-bold"><?php echo htmlspecialchars($_SESSION['email'] ?? '-') ?></div>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center mb-3">
                                <i class="fas fa-phone info-icon me-3"></i>
                                <div>
                                    <div class="info-label small text-muted">No. Telepon</div>
                                    <div class="info-value fw-bold"><?php echo htmlspecialchars($guru['no_telp'] ?? '-') ?></div>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center">
                                <i class="fas fa-clipboard-check info-icon me-3"></i>
                                <div>
                                    <div class="info-label small text-muted">Total Mengawas</div>
                                    <div class="info-value">
                                        <span class="badge bg-primary rounded-pill"><?php echo $total_pengawas['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Subjects Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Mata Pelajaran</h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($mapel_diajar_query) > 0): ?>
                            <div class="subject-list">
                                <?php 
                                mysqli_data_seek($mapel_diajar_query, 0);
                                while ($mapel = mysqli_fetch_assoc($mapel_diajar_query)): ?>
                                    <div class="subject-item d-flex align-items-center mb-2">
                                        <i class="fas fa-book me-2 text-muted"></i>
                                        <span><?php echo htmlspecialchars($mapel['nama_mapel']) ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">
                                Anda belum memiliki mata pelajaran yang diajar.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Exam Schedule Column -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Jadwal Mengawas Ujian</h5>
                        <a href="jadwalMengawas.php" class="btn btn-sm btn-light">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($jadwal_pengawas_query) > 0): ?>
                            <div class="schedule-list">
                                <?php while ($jadwal = mysqli_fetch_assoc($jadwal_pengawas_query)): ?>
                                    <div class="schedule-item mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between mb-1">
                                            <strong class="text-truncate"><?php echo htmlspecialchars($jadwal['nama_ujian']) ?></strong>
                                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($jadwal['nama_kelas']) ?></span>
                                        </div>
                                        <div class="text-muted small mb-1">
                                            <i class="fas fa-book me-1"></i>
                                            <?php echo htmlspecialchars($jadwal['nama_mapel']) ?>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="fas fa-calendar-day me-1"></i>
                                                <?php echo date('d M Y', strtotime($jadwal['tanggal_ujian'])) ?>
                                            </div>
                                            <div>
                                                <i class="fas fa-clock me-1"></i>
                                                <?php echo date('H:i', strtotime($jadwal['jam_mulai'])) ?>-<?php echo date('H:i', strtotime($jadwal['jam_selesai'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">
                                Tidak ada jadwal mengawas ujian mendatang.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Column -->
            <div class="col-md-12 col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Kegiatan Terbaru</h5>
                        <a href="jadwal-kegiatan.php" class="btn btn-sm btn-dark">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($kegiatan_query) > 0): ?>
                            <div class="activity-timeline">
                                <?php while ($kegiatan = mysqli_fetch_assoc($kegiatan_query)): ?>
                                    <div class="timeline-item mb-3">
                                        <div class="timeline-badge"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-date small text-muted">
                                                <?php echo date('d M Y', strtotime($kegiatan['tanggal_mulai'])) ?>
                                            </div>
                                            <h6 class="timeline-title"><?php echo htmlspecialchars($kegiatan['judul']) ?></h6>
                                            <div class="timeline-location small">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo htmlspecialchars($kegiatan['lokasi'] ?? 'Lokasi belum ditentukan') ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">
                                Tidak ada kegiatan terbaru.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.teacher-dashboard {
    background-color: #f8f9fa;
}

.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.card-header {
    padding: 1rem 1.25rem;
}

.info-icon {
    width: 24px;
    text-align: center;
    color: var(--bs-primary);
}

.subject-item {
    padding: 8px 0;
}

.schedule-item {
    padding: 10px 0;
}

.activity-timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
}

.timeline-badge {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--bs-warning);
}

.timeline-content {
    padding-bottom: 15px;
}

.timeline-title {
    font-size: 0.95rem;
    margin: 5px 0;
}

.timeline-date, .timeline-location {
    font-size: 0.85rem;
}

@media (max-width: 767.98px) {
    .card {
        margin-bottom: 1.5rem;
    }
}
</style>

<?php include './template/footer.php'; ?>
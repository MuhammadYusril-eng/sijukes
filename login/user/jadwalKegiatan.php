<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);

if ($_SESSION['role'] != 'siswa') {
    header("Location: unauthorized.php");
    exit();
}

// Parameter filter
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$filter_judul = isset($_GET['judul']) ? $_GET['judul'] : '';

// Query dasar
$query = "SELECT k.*, u.nama AS penanggung_jawab 
          FROM kegiatan k
          LEFT JOIN guru g ON k.penanggung_jawab_id = g.id
          LEFT JOIN users u ON g.user_id = u.id
          WHERE k.ditujukan_untuk IN ('siswa', 'semua')";

// Tambahkan filter
if (!empty($filter_judul)) {
    $query .= " AND k.judul LIKE '%$filter_judul%'";
}

// Urutkan dan eksekusi query utama
$query .= " ORDER BY k.tanggal_mulai DESC";
$result = mysqli_query($conn, $query);
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<!-- Tambahkan CSS dan JS Animasi -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --danger: #f72585;
        --warning: #f8961e;
        --info: #4895ef;
        --light: #f8f9fa;
        --dark: #212529;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fa;
    }
    
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .filter-card:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .card-kegiatan {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-bottom: 30px;
        background: white;
    }
    
    .card-kegiatan:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    
    .card-header {
        padding: 20px;
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }
    
    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    }
    
    .status-badge {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .badge-akan-datang {
        background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
        color: white;
    }
    
    .badge-berlangsung {
        background: linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%);
        color: white;
    }
    
    .badge-selesai {
        background: linear-gradient(135deg, #adb5bd 0%, #6c757d 100%);
        color: white;
    }
    
    .img-kegiatan {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .img-kegiatan:hover {
        transform: scale(1.02);
    }
    
    .kegiatan-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 15px 0;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .meta-item i {
        margin-right: 8px;
        color: var(--primary);
        font-size: 1.1rem;
    }
    
    .card-body {
        padding: 25px;
    }
    
    .card-title {
        font-weight: 700;
        color: white;
        position: relative;
        z-index: 2;
    }
    
    .alert-live {
        animation: pulse 2s infinite;
        border-left: 5px solid var(--success);
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(28, 200, 138, 0); }
        100% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0); }
    }
    
    .floating {
        animation: floating 6s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .btn-hover {
        transition: all 0.3s ease;
    }
    
    .btn-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 15px rgba(0,0,0,0.1);
    }
    
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-state img {
        max-width: 300px;
        margin-bottom: 20px;
    }
</style>

<!-- Tambahkan Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<section class="section animate__animated animate__fadeIn">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title d-flex align-items-center flex-wrap mb-30">
                        <h2 class="mr-40">Jadwal Kegiatan</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-siswa.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Kegiatan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row animate__animated animate__fadeInDown">
            <div class="col-12">
                <div class="filter-card">
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="filter-group">
                                    <label for="judul" class="form-label">Judul Kegiatan</label>
                                    <input type="text" class="form-control" id="judul" name="judul" 
                                           value="<?= htmlspecialchars($filter_judul) ?>" 
                                           placeholder="Cari judul kegiatan...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="filter-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="akan_datang" <?= ($filter_status == 'akan_datang') ? 'selected' : '' ?>>Akan Datang</option>
                                        <option value="berlangsung" <?= ($filter_status == 'berlangsung') ? 'selected' : '' ?>>Sedang Berlangsung</option>
                                        <option value="selesai" <?= ($filter_status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group-filter">
                                    <button type="submit" class="main-btn primary-btn btn-hover">
                                        <i class="lni lni-filter"></i> Filter
                                    </button>
                                    <a href="jadwalKegiatan.php" class="main-btn light-btn btn-hover reset-filter">
                                        <i class="lni lni-close"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row">
            <?php 
            $today = date('Y-m-d');
            $now = date('H:i:s');
            $has_data = false;
            
            if (mysqli_num_rows($result) > 0): 
                while ($kegiatan = mysqli_fetch_assoc($result)): 
                    // Tentukan status kegiatan
                    $status = '';
                    $badge_class = '';
                    $show_row = true;
                    
                    // Cek status kegiatan
                    if ($kegiatan['tanggal_mulai'] > $today) {
                        $status = 'Akan Datang';
                        $badge_class = 'badge-akan-datang';
                        $header_bg = 'linear-gradient(135deg, #4361ee 0%, #3f37c9 100%)';
                    } 
                    elseif ($kegiatan['tanggal_mulai'] <= $today && $kegiatan['tanggal_selesai'] >= $today) {
                        if ($kegiatan['jam_mulai'] <= $now && $kegiatan['jam_selesai'] >= $now) {
                            $status = 'Sedang Berlangsung';
                            $badge_class = 'badge-berlangsung';
                            $header_bg = 'linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%)';
                        } else {
                            $status = 'Berlangsung (Hari Ini)';
                            $badge_class = 'badge-berlangsung';
                            $header_bg = 'linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%)';
                        }
                    } 
                    else {
                        $status = 'Selesai';
                        $badge_class = 'badge-selesai';
                        $header_bg = 'linear-gradient(135deg, #adb5bd 0%, #6c757d 100%)';
                    }
                    
                    // Filter berdasarkan status jika dipilih
                    if (!empty($filter_status)) {
                        if ($filter_status == 'akan_datang' && !($kegiatan['tanggal_mulai'] > $today)) {
                            $show_row = false;
                        } 
                        elseif ($filter_status == 'berlangsung' && !($kegiatan['tanggal_mulai'] <= $today && $kegiatan['tanggal_selesai'] >= $today)) {
                            $show_row = false;
                        } 
                        elseif ($filter_status == 'selesai' && !($kegiatan['tanggal_selesai'] < $today)) {
                            $show_row = false;
                        }
                    }
                    
                    if ($show_row):
                        $has_data = true;
                        $animation_class = $has_data ? 'animate__animated animate__fadeInUp' : '';
            ?>
                <div class="col-lg-6">
                    <div class="card card-kegiatan <?php echo $animation_class; ?>" style="animation-delay: <?php echo ($has_data ? '0.' . (($has_data % 5) + 1) : '0'); ?>s">
                        <div class="card-header" style="background: <?php echo $header_bg; ?>">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($kegiatan['judul']) ?></h5>
                            <span class="status-badge <?= $badge_class ?>"><?= $status ?></span>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($kegiatan['gambar'])): ?>
                                <img src="<?= htmlspecialchars($kegiatan['gambar']) ?>" class="img-kegiatan mb-3" alt="Gambar Kegiatan">
                            <?php endif; ?>
                            
                            <div class="kegiatan-meta">
                                <div class="meta-item">
                                    <i class="lni lni-calendar"></i>
                                    <span>
                                        <?= date('d M Y', strtotime($kegiatan['tanggal_mulai'])) ?>
                                        <?php if ($kegiatan['tanggal_selesai'] && $kegiatan['tanggal_selesai'] != $kegiatan['tanggal_mulai']): ?>
                                            - <?= date('d M Y', strtotime($kegiatan['tanggal_selesai'])) ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <i class="lni lni-alarm-clock"></i>
                                    <span><?= date('H:i', strtotime($kegiatan['jam_mulai'])) ?> - <?= date('H:i', strtotime($kegiatan['jam_selesai'])) ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="lni lni-map-marker"></i>
                                    <span><?= htmlspecialchars($kegiatan['lokasi']) ?></span>
                                </div>
                                <?php if ($kegiatan['penanggung_jawab']): ?>
                                    <div class="meta-item">
                                        <i class="lni lni-user"></i>
                                        <span>Penanggung Jawab: <?= htmlspecialchars($kegiatan['penanggung_jawab']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <p class="card-text"><?= htmlspecialchars($kegiatan['deskripsi']) ?></p>
                            
                            <?php if ($status == 'Sedang Berlangsung'): ?>
                                <div class="alert alert-success alert-live mt-3">
                                    <i class="lni lni-alarm"></i> <strong>Live Sekarang!</strong> Kegiatan sedang berlangsung.
                                </div>
                            <?php elseif ($status == 'Berlangsung (Hari Ini)'): ?>
                                <div class="alert alert-info mt-3">
                                    <i class="lni lni-alarm"></i> Kegiatan berlangsung hari ini!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                    endif;
                endwhile; 
                
                if (!$has_data):
            ?>
                <div class="col-12">
                    <div class="empty-state animate__animated animate__fadeIn">
                        <img src="../assets/img/empty-state.svg" alt="No data" class="floating">
                        <h3>Tidak ada kegiatan yang sesuai dengan filter</h3>
                        <p>Coba gunakan filter yang berbeda atau hubungi admin</p>
                        <a href="jadwalKegiatan.php" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-reload"></i> Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state animate__animated animate__fadeIn">
                        <img src="../assets/img/empty-state.svg" alt="No data" class="floating">
                        <h3>Belum ada kegiatan yang tersedia</h3>
                        <p>Silakan kembali lagi nanti atau hubungi admin</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Tambahkan GSAP untuk animasi lebih smooth -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animasi hover card dengan GSAP
    const cards = document.querySelectorAll('.card-kegiatan');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                y: -10,
                duration: 0.3,
                ease: "power2.out"
            });
        });
        
        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                y: 0,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });
    
    // Animasi filter card saat load
    gsap.from('.filter-card', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        ease: "back.out(1.7)"
    });
});
</script>

<?php include './template/footer.php'; ?>
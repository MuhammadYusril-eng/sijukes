<?php
require_once 'template/header.php'; 
?>
<?php require_once 'template/sidebar.php'; ?>

<style>
    /* Modern Gradient Background */
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
    }
    
    .welcome-card:hover {
        transform: translateY(-5px);
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
        transform: rotate(30deg);
    }
    
    .username-highlight {
        color: #ffd700;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    /* Stat Cards */
    .stat-card {
        border-radius: 12px;
        padding: 25px 20px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-right: 15px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-title {
        font-size: 14px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    
    /* Progress Bar */
    .progress-container {
        height: 8px;
        border-radius: 4px;
        background: #f1f1f1;
        margin-top: 15px;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 4px;
    }
    
    /* Responsive Grid */
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 15px;
        }
    }
</style>

<section class="section">
    <div class="container-fluid">
        
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2 class="mb-3">Selamat Datang, <span class="username-highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span></h2>
            <p class="mb-0">Anda login sebagai <strong><?php echo ucfirst($_SESSION['role']); ?></strong>. Terakhir diupdate: <?php echo date('d F Y H:i'); ?></p>
        </div>

        <!-- Statistics Row -->
        <div class="row">
            <?php
            // Fungsi untuk mendapatkan data dinamis dari database

// Fungsi untuk mendapatkan statistik dashboard (MySQLi version)
function getDashboardStats($conn) {
    $stats = [];
    
    // Total Pengguna
    $result = $conn->query("SELECT COUNT(*) as total FROM users");
    $stats['users'] = $result->fetch_assoc()['total'];
    
    // Total Guru
    $result = $conn->query("SELECT COUNT(*) as total FROM guru");
    $stats['teachers'] = $result->fetch_assoc()['total'];
    
    // Total Siswa
    $result = $conn->query("SELECT COUNT(*) as total FROM siswa");
    $stats['students'] = $result->fetch_assoc()['total'];
    
    // Total Jadwal Ujian
    $result = $conn->query("SELECT COUNT(*) as total FROM jadwal_ujian");
    $stats['exams'] = $result->fetch_assoc()['total'];
    
    // Total Kegiatan
    $result = $conn->query("SELECT COUNT(*) as total FROM kegiatan");
    $stats['activities'] = $result->fetch_assoc()['total'];
    
    // Total Mapel
    $result = $conn->query("SELECT COUNT(*) as total FROM mapel");
    $stats['subjects'] = $result->fetch_assoc()['total'];
    
    return $stats;
}

// Dapatkan statistik
$stats = getDashboardStats($conn);
?>

  
            
            <!-- User Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['users']; ?></div>
                            <div class="stat-title">Total Pengguna</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['users']/50)*100); ?>%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    </div>
                </div>
            </div>
            
            <!-- Teacher Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['teachers']; ?></div>
                            <div class="stat-title">Guru</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['teachers']/30)*100); ?>%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                    </div>
                </div>
            </div>
            
            <!-- Student Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['students']; ?></div>
                            <div class="stat-title">Siswa</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['students']/200)*100); ?>%; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);"></div>
                    </div>
                </div>
            </div>
            
            <!-- Exam Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['exams']; ?></div>
                            <div class="stat-title">Jadwal Ujian</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['exams']/20)*100); ?>%; background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['activities']; ?></div>
                            <div class="stat-title">Kegiatan</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['activities']/15)*100); ?>%; background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);"></div>
                    </div>
                </div>
            </div>
            
            <!-- Subject Card -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #ffc3a0 0%, #ffafbd 100%);">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?php echo $stats['subjects']; ?></div>
                            <div class="stat-title">Mata Pelajaran</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo min(100, ($stats['subjects']/20)*100); ?>%; background: linear-gradient(135deg, #ffc3a0 0%, #ffafbd 100%);"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities Section -->
        <!-- Recent Activities Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Kegiatan Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $result = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal_mulai DESC LIMIT 5");
                        
                        if ($result->num_rows > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-hover">';
                            echo '<thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Untuk</th>
                                    </tr>
                                  </thead>';
                            echo '<tbody>';
                            
                            while($activity = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>'.htmlspecialchars($activity['judul']).'</td>
                                        <td>'.date('d M Y', strtotime($activity['tanggal_mulai']));
                                if ($activity['tanggal_selesai'] && $activity['tanggal_selesai'] != $activity['tanggal_mulai']) {
                                    echo ' - '.date('d M Y', strtotime($activity['tanggal_selesai']));
                                }
                                echo '</td>
                                        <td>'.htmlspecialchars($activity['lokasi']).'</td>
                                        <td><span class="badge bg-'.($activity['ditujukan_untuk'] == 'semua' ? 'primary' : ($activity['ditujukan_untuk'] == 'guru' ? 'info' : 'success')).'">'.ucfirst($activity['ditujukan_untuk']).'</span></td>
                                      </tr>';
                            }
                            
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                        } else {
                            echo '<div class="alert alert-info">Tidak ada kegiatan terbaru</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>

<?php include './template/footer.php'; ?>
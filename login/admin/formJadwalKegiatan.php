<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";

// Set default timezone
date_default_timezone_set('Asia/Jakarta');

// Initialize variables
$user_id = $_SESSION['user_id'];
$editData = null;
$guruOptions = [];
$error = '';
$success = '';

// Get user data
$user_query = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($user_query, "i", $user_id);
mysqli_stmt_execute($user_query);
$user_result = mysqli_stmt_get_result($user_query);
$data = mysqli_fetch_assoc($user_result);
mysqli_stmt_close($user_query);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['simpan'])) {
        handleAddKegiatan($conn);
    } elseif (isset($_POST['update'])) {
        handleUpdateKegiatan($conn);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hapus'])) {
    handleDeleteKegiatan($conn);
}

// Get edit data if requested
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $edit_query = mysqli_prepare($conn, "SELECT * FROM kegiatan WHERE id = ?");
    mysqli_stmt_bind_param($edit_query, "i", $id);
    mysqli_stmt_execute($edit_query);
    $edit_result = mysqli_stmt_get_result($edit_query);
    $editData = mysqli_fetch_assoc($edit_result);
    mysqli_stmt_close($edit_query);
}

// Get guru options for dropdown
$guru_query = mysqli_query($conn, "SELECT g.id, u.nama 
                                  FROM guru g 
                                  JOIN users u ON g.user_id = u.id 
                                  ORDER BY u.nama");
$guruOptions = [];
while ($guru = mysqli_fetch_assoc($guru_query)) {
    $guruOptions[] = $guru;
}

// Function to handle adding kegiatan
function handleAddKegiatan($conn) {
    global $error, $success;
    
    // Validate required fields
    $required = ['judul', 'deskripsi', 'tanggal_mulai', 'jam_mulai', 'lokasi', 'ditujukan_untuk'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $error = "Field $field harus diisi!";
            return;
        }
    }
    
    // Process image upload
    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['gambar']['tmp_name']);
        
        if (in_array($file_type, $allowed_types)) {
            $upload_dir = 'file/images/kegiatan/';
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            $gambar = $upload_dir . $filename;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], './' . $gambar)) {
                $error = "Gagal mengunggah gambar.";
                return;
            }
        } else {
            $error = "Format file tidak didukung. Hanya JPEG, PNG, JPG.";
            return;
        }
    }

    // Prepare data
    $judul = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? mysqli_real_escape_string($conn, $_POST['tanggal_selesai']) : null;
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $jam_selesai = !empty($_POST['jam_selesai']) ? mysqli_real_escape_string($conn, $_POST['jam_selesai']) : null;
    $lokasi = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $penanggung_jawab_id = !empty($_POST['penanggung_jawab_id']) ? (int)$_POST['penanggung_jawab_id'] : null;
    $ditujukan_untuk = mysqli_real_escape_string($conn, $_POST['ditujukan_untuk']);
    
    // Prepare SQL query with prepared statement
    $query = "INSERT INTO kegiatan (judul, deskripsi, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, lokasi, penanggung_jawab_id, ditujukan_untuk, gambar) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssiss", 
        $judul, $deskripsi, $tanggal_mulai, $tanggal_selesai, $jam_mulai, 
        $jam_selesai, $lokasi, $penanggung_jawab_id, $ditujukan_untuk, $gambar
    );
    
    if (mysqli_stmt_execute($stmt)) {
        $success = "Data berhasil disimpan!";
        header("Location: jadwalKegiatan.php");
        exit();
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
}

// Function to handle updating kegiatan
function handleUpdateKegiatan($conn) {
    global $error, $success;
    
    if (empty($_POST['id'])) {
        $error = "ID kegiatan tidak valid!";
        return;
    }
    
    $id = (int)$_POST['id'];
    $gambar = $_POST['gambar_lama'] ?? '';
    
    // Process new image upload if exists
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['gambar']['tmp_name']);
        
        if (in_array($file_type, $allowed_types)) {
            $upload_dir = 'file/images/kegiatan/';
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            $gambar_baru = $upload_dir . $filename;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], './' . $gambar_baru)) {
                // Delete old image if exists
                if (!empty($gambar) && file_exists('./' . $gambar)) {
                    unlink('./' . $gambar);
                }
                $gambar = $gambar_baru;
            } else {
                $error = "Gagal mengunggah gambar baru.";
                return;
            }
        } else {
            $error = "Format file tidak didukung. Hanya JPEG, PNG, JPG.";
            return;
        }
    }

    // Prepare data
    $judul = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? mysqli_real_escape_string($conn, $_POST['tanggal_selesai']) : null;
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $jam_selesai = !empty($_POST['jam_selesai']) ? mysqli_real_escape_string($conn, $_POST['jam_selesai']) : null;
    $lokasi = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $penanggung_jawab_id = !empty($_POST['penanggung_jawab_id']) ? (int)$_POST['penanggung_jawab_id'] : null;
    $ditujukan_untuk = mysqli_real_escape_string($conn, $_POST['ditujukan_untuk']);
    
    // Prepare SQL query with prepared statement
    $query = "UPDATE kegiatan SET 
              judul=?, 
              deskripsi=?, 
              tanggal_mulai=?, 
              tanggal_selesai=?, 
              jam_mulai=?, 
              jam_selesai=?, 
              lokasi=?, 
              penanggung_jawab_id=?, 
              ditujukan_untuk=?, 
              gambar=? 
              WHERE id=?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssissi", 
        $judul, $deskripsi, $tanggal_mulai, $tanggal_selesai, $jam_mulai, 
        $jam_selesai, $lokasi, $penanggung_jawab_id, $ditujukan_untuk, $gambar, $id
    );
    
    if (mysqli_stmt_execute($stmt)) {
        $success = "Data berhasil diperbarui!";
        header("Location: jadwalKegiatan.php");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
}

// Function to handle deleting kegiatan
function handleDeleteKegiatan($conn) {
    global $error, $success;
    
    $id = (int)$_GET['hapus'];
    
    // Get image path first
    $stmt = mysqli_prepare($conn, "SELECT gambar FROM kegiatan WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    // Delete image if exists
    if ($row && !empty($row['gambar']) && file_exists('./' . $row['gambar'])) {
        unlink('./' . $row['gambar']);
    }
    
    // Delete record
    $delete_stmt = mysqli_prepare($conn, "DELETE FROM kegiatan WHERE id = ?");
    mysqli_stmt_bind_param($delete_stmt, "i", $id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        $success = "Data berhasil dihapus!";
        header("Location: jadwalKegiatan.php");
        exit();
    } else {
        $error = "Gagal menghapus data: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($delete_stmt);
}
?>

<?php require_once 'template/header.php';?>
<!-- ========== header end ========== -->
<?php require_once 'template/sidebar.php';?>

<!-- HTML Form -->


<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- Title content here -->
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#0">Pages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
<section class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
<div class="card-style settings-card-1 mb-30">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <?php if (isset($editData)): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($editData['id']); ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($editData['gambar'] ?? ''); ?>">
        <?php endif; ?>
        
        <div class="row">
            <!-- Form fields -->
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required 
                           value="<?php echo htmlspecialchars($editData['judul'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Penanggung Jawab</label>
                    <select name="penanggung_jawab_id" class="form-control">
                        <option value="">-- Pilih Penanggung Jawab --</option>
                        <?php foreach ($guruOptions as $guru): ?>
                        <option value="<?php echo $guru['id']; ?>"
                            <?php echo (isset($editData['penanggung_jawab_id']) && $editData['penanggung_jawab_id'] == $guru['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($guru['nama']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Date and Time Fields -->
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required 
                           value="<?php echo htmlspecialchars($editData['tanggal_mulai'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" class="form-control" 
                           value="<?php echo htmlspecialchars($editData['tanggal_selesai'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required
                           value="<?php echo htmlspecialchars($editData['jam_mulai'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Jam Selesai (Opsional)</label>
                    <input type="time" name="jam_selesai" class="form-control" 
                           value="<?php echo htmlspecialchars($editData['jam_selesai'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" required
                           value="<?php echo htmlspecialchars($editData['lokasi'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Ditujukan Untuk</label>
                    <select name="ditujukan_untuk" class="form-control" required>
                        <option value="semua" <?php echo (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'semua') ? 'selected' : ''; ?>>Semua</option>
                        <option value="guru" <?php echo (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'guru') ? 'selected' : ''; ?>>Guru</option>
                        <option value="siswa" <?php echo (isset($editData['ditujukan_untuk']) && $editData['ditujukan_untuk'] == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="input-style-1">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <?php if (!empty($editData['gambar'])): ?>
                    <br>
                    <img id="preview" src="<?php echo htmlspecialchars($editData['gambar']); ?>" style="max-height: 200px;">
                    <?php else: ?>
                    <br><img id="preview" style="max-height: 200px; display:none;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-12">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="form-control" required><?php echo htmlspecialchars($editData['deskripsi'] ?? ''); ?></textarea>
            </div>
            
            <div class="col-md-12 mt-3">
                <button type="submit" name="<?php echo isset($editData) ? 'update' : 'simpan'; ?>" class="main-btn primary-btn btn-hover">
                    <?php echo isset($editData) ? 'Update' : 'Tambah'; ?> Kegiatan
                </button>
                <a href="jadwalKegiatan.php" class="main-btn light-btn btn-hover">Kembali</a>
            </div>
        </div>
    </form>
</div>
                </div>
                </div>
            </div>
        </section>
    </div>
</section>
<script>
function previewImage(event) {
    const reader = new FileReader();
    const imageField = document.getElementById("preview");

    reader.onload = function() {
        if (reader.readyState == 2) {
            imageField.src = reader.result;
            imageField.style.display = "block";
        }
    }
    
    if (event.target.files && event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
<?php require_once 'template/footer.php';?>

<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);

// Initialize variables
$editData = null;
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_ruangan = mysqli_real_escape_string($conn, $_POST['nama_ruangan']);
    $kapasitas = (int)$_POST['kapasitas'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);

    if (empty($nama_ruangan)) {
        $error = "Nama ruangan harus diisi!";
    } else {
        if (isset($_POST['simpan'])) {
            // Add new room
            $query = "INSERT INTO ruangan (nama_ruangan, kapasitas, lokasi) VALUES ('$nama_ruangan', $kapasitas, '$lokasi')";
            if (mysqli_query($conn, $query)) {
                $success = "Ruangan berhasil ditambahkan!";
                header("Location: dataRuangan.php?success=".urlencode($success));
                exit();
            } else {
                $error = "Gagal menambahkan ruangan: " . mysqli_error($conn);
            }
        } elseif (isset($_POST['update']) && isset($_POST['id_ruangan'])) {
            // Update room
            $id_ruangan = (int)$_POST['id_ruangan'];
            $query = "UPDATE ruangan SET nama_ruangan='$nama_ruangan', kapasitas=$kapasitas, lokasi='$lokasi' WHERE id_ruangan=$id_ruangan";
            if (mysqli_query($conn, $query)) {
                $success = "Ruangan berhasil diperbarui!";
                header("Location: dataRuangan.php?success=".urlencode($success));
                exit();
            } else {
                $error = "Gagal memperbarui ruangan: " . mysqli_error($conn);
            }
        }
    }
}

// Handle delete
if (isset($_GET['hapus'])) {
    $id_ruangan = (int)$_GET['hapus'];
    $query = "DELETE FROM ruangan WHERE id_ruangan=$id_ruangan";
    if (mysqli_query($conn, $query)) {
        $success = "Ruangan berhasil dihapus!";
        header("Location: dataRuangan.php?success=".urlencode($success));
        exit();
    } else {
        $error = "Gagal menghapus ruangan: " . mysqli_error($conn);
    }
}

// Get edit data
if (isset($_GET['edit'])) {
    $id_ruangan = (int)$_GET['edit'];
    $query = "SELECT * FROM ruangan WHERE id_ruangan=$id_ruangan";
    $result = mysqli_query($conn, $query);
    $editData = mysqli_fetch_assoc($result);
}
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
                        <h2 class="mr-40"><?= isset($editData) ? 'Edit Ruangan' : 'Tambah Ruangan' ?></h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dataRuangan.php">Data Ruangan</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= isset($editData) ? 'Edit' : 'Tambah' ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <?php if (isset($editData)): ?>
                            <input type="hidden" name="id_ruangan" value="<?= $editData['id_ruangan'] ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label>Nama Ruangan <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ruangan" required 
                                           value="<?= isset($editData) ? htmlspecialchars($editData['nama_ruangan']) : '' ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label>Kapasitas</label>
                                    <input type="number" name="kapasitas" min="1" 
                                           value="<?= isset($editData) ? htmlspecialchars($editData['kapasitas']) : '' ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="input-style-1">
                                    <label>Lokasi</label>
                                    <Textarea name="lokasi" class="form-control">
                                        <?= htmlspecialchars($editData['keterangan'] ?? '') ?>
                                </Textarea>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="button-group d-flex justify-content-end">
                                    <a href="dataRuangan.php" class="main-btn light-btn btn-hover">Kembali</a>
                                    <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>" 
                                            class="main-btn primary-btn btn-hover ms-3">
                                        <?= isset($editData) ? 'Update' : 'Simpan' ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include './template/footer.php'; ?>
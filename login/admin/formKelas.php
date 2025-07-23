

<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Ambil data user (opsional, jika diperlukan)
$user_id = $_SESSION['user_id'];
$queryUser = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($queryUser);

// Proses simpan data
if (isset($_POST['simpan'])) {
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
    $kompetensi_keahlian = mysqli_real_escape_string($conn, $_POST['kompetensi_keahlian']);
    $wali_kelas_id = $_POST['wali_kelas_id'] !== '' ? intval($_POST['wali_kelas_id']) : "NULL";

    // Cek duplikat
    $cekDuplikat = mysqli_query($conn, "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas'");
    if (mysqli_num_rows($cekDuplikat) > 0) {
        echo "<script>alert('Nama Kelas sudah ada!'); window.history.back();</script>";
        exit;
    }

    // Insert ke tabel kelas
    $query = "INSERT INTO kelas (nama_kelas, kompetensi_keahlian, wali_kelas_id, created_at) 
              VALUES ('$nama_kelas', '$kompetensi_keahlian', $wali_kelas_id, NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data kelas berhasil disimpan!'); window.location.href='dataKelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data kelas.');</script>";
    }
}

// Proses update data
if (isset($_POST['update'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
    $kompetensi_keahlian = mysqli_real_escape_string($conn, $_POST['kompetensi_keahlian']);
    $wali_kelas_id = $_POST['wali_kelas_id'] !== '' ? intval($_POST['wali_kelas_id']) : "NULL";

    // Cek duplikat selain dirinya sendiri
    $cekDuplikat = mysqli_query($conn, "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas' AND id_kelas != $id_kelas");
    if (mysqli_num_rows($cekDuplikat) > 0) {
        echo "<script>alert('Nama Kelas sudah digunakan oleh kelas lain!'); window.history.back();</script>";
        exit;
    }

    $query = "UPDATE kelas 
              SET nama_kelas = '$nama_kelas', kompetensi_keahlian = '$kompetensi_keahlian', wali_kelas_id = $wali_kelas_id 
              WHERE id_kelas = $id_kelas";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data kelas berhasil diperbarui!'); window.location.href='dataKelas.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data kelas.');</script>";
    }
}



if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // 1. Cek relasi dengan prepared statement
    $stmt = $conn->prepare("SELECT 
        (SELECT COUNT(*) FROM siswa WHERE kelas_id = ?) as siswa_count,
        (SELECT COUNT(*) FROM jadwal_ujian WHERE kelas_id = ?) as jadwal_count");
    
    // Bind parameter yang benar - dua integer ('ii')
    $stmt->bind_param("ii", $id, $id);
    
    if (!$stmt->execute()) {
        die("Error checking relations: " . $conn->error);
    }
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['siswa_count'] > 0 || $row['jadwal_count'] > 0) {
        echo "<script>
                alert('Kelas tidak dapat dihapus karena terkait dengan ".$row['siswa_count']." siswa dan ".$row['jadwal_count']." jadwal ujian');
                window.location.href='dataKelas.php';
              </script>";
        exit;
    }
    
    // 2. Proses penghapusan
    $conn->begin_transaction();
    
    try {
        // Hapus data terkait terlebih dahulu jika perlu
        // Contoh: $conn->query("DELETE FROM tabel_terkait WHERE kelas_id = $id");
        
        // Hapus kelas utama
        $delete_stmt = $conn->prepare("DELETE FROM kelas WHERE id_kelas = ?");
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
        
        if ($delete_stmt->affected_rows > 0) {
            $conn->commit();
            echo "<script>
                    alert('Data berhasil dihapus');
                    window.location.href='dataKelas.php';
                  </script>";
        } else {
            $conn->rollback();
            echo "<script>
                    alert('Data tidak ditemukan');
                    window.location.href='dataKelas.php';
                  </script>";
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
                alert('Error: ".addslashes($e->getMessage())."');
                window.location.href='dataKelas.php';
              </script>";
    }
    exit;
}




// Ambil data jika edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kelas WHERE id_kelas = $id");
    $editData = mysqli_fetch_assoc($result);
}

// Ambil data guru untuk dropdown wali kelas
$guruList = mysqli_query($conn, "
    SELECT guru.id, users.nama 
    FROM guru 
    JOIN users ON guru.user_id = users.id 
    ORDER BY users.nama ASC
");
?>

<!-- Form HTML -->
<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-30"><?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Kelas</h2>
                </div>
            </div>
        </div>
  <div class="row">
            <div class="col-lg-12">
                <div class="card-style settings-card-1 mb-30">
                    <div class="profile-info">
        <form method="POST" action="">
            <?php if (isset($editData)): ?>
                <input type="hidden" name="id_kelas" value="<?= $editData['id_kelas'] ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 ">
                <div class="input-style-1">
                <label>Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kelas" class="form-control" required value="<?= htmlspecialchars($editData['nama_kelas'] ?? '') ?>">
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-style-1">
                <label>Kompetensi Keahlian <span class="text-danger">*</span></label>
                    <input type="text" name="kompetensi_keahlian" class="form-control" required value="<?= htmlspecialchars($editData['kompetensi_keahlian'] ?? '') ?>">
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-style-1">
                <label>Wali Kelas</label>
                    <select name="wali_kelas_id" class="form-control">
                        <option value="">-- Pilih Wali Kelas --</option>
                        <?php while ($guru = mysqli_fetch_assoc($guruList)): ?>
                            <option value="<?= $guru['id'] ?>" <?= (isset($editData['wali_kelas_id']) && $editData['wali_kelas_id'] == $guru['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($guru['nama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                   <div class="col-12">
                                    <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>" 
                                            class="main-btn primary-btn btn-hover mt-3">
                                        <?= isset($editData) ? 'Update' : 'Simpan' ?>
                                    </button>
                                    <a href="dataKelas.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                                </div>
                </div>
            </div>
        </form>
        </div>
        </div>
        </div>
        </div>
    </div>
</section>

<?php require_once 'template/footer.php'; ?>

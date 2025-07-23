<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);    
// Proses simpan data siswa


// Proses simpan data siswa baru
if (isset($_POST['simpan'])) {
    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $nis = mysqli_real_escape_string($conn, $_POST['nis']);
        $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
        $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas']);
        $jurusan_id = mysqli_real_escape_string($conn, $_POST['jurusan']);

        // Cek username sudah ada atau belum
        $cek_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND role='siswa'");
        if (mysqli_num_rows($cek_username) > 0) {
            throw new Exception("Username \"$username\" sudah ada, silakan gunakan username lain!");
        }

        // Insert ke tabel users
        $query_user = "INSERT INTO users (nama, username, password, email, role, created_at) 
                      VALUES ('$nama', '$username', '$password', '$email', 'siswa', NOW())";
        
        if (!mysqli_query($conn, $query_user)) {
            throw new Exception("Gagal menyimpan data user.");
        }
        
        $user_id = mysqli_insert_id($conn);
        
        // Insert ke tabel siswa dengan kelas_id dan tanpa kolom tingkat
        $query_siswa = "INSERT INTO siswa (user_id, nis, jenis_kelamin, alamat, no_telp, kelas_id, jurusan_id, created_at) 
                        VALUES ('$user_id', '$nis', '$jenis_kelamin', '$alamat', '$no_telp', '$kelas_id', '$jurusan_id', NOW())";
        
        if (!mysqli_query($conn, $query_siswa)) {
            throw new Exception("Gagal menyimpan data siswa.");
        }
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($conn);
        $_SESSION['success'] = 'Data siswa berhasil disimpan!';
        header('Location: dataSiswa.php');
        exit();
        
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($conn);
        $_SESSION['error'] = $e->getMessage();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// Proses update data siswa
if (isset($_POST['update'])) {
    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        $id = $_POST['id']; // id siswa
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $nis = mysqli_real_escape_string($conn, $_POST['nis']);
        $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
        $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas']);
        $jurusan_id = mysqli_real_escape_string($conn, $_POST['jurusan']);

            // Ambil user_id siswa yang sedang diupdate
        $result_userid = mysqli_query($conn, "SELECT user_id FROM siswa WHERE id='$id'");
        if (!$result_userid || mysqli_num_rows($result_userid) == 0) {
            throw new Exception("Data siswa tidak ditemukan!");
        }

        $user_data = mysqli_fetch_assoc($result_userid);
        $user_id = $user_data['user_id'];

        // Cek username sudah ada di user lain selain yang sedang diupdate dengan role siswa
        $cek_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND id != '$user_id' AND role = 'siswa'");
        if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username sudah digunakan oleh pengguna lain!'); window.history.back();</script>";
        exit;
    }

        // Update password jika diisi
        $password_update = "";
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password_update = ", password='$password'";
        }

        // Update tabel users
        $query_user = "UPDATE users SET 
                      nama='$nama', 
                      username='$username', 
                      email='$email' 
                      $password_update 
                      WHERE id='$user_id'";
        
        if (!mysqli_query($conn, $query_user)) {
            throw new Exception("Gagal memperbarui data user.");
        }
        
        // Update tabel siswa dengan kelas_id dan tanpa kolom tingkat
        $query_siswa = "UPDATE siswa SET 
                        nis='$nis', 
                        jenis_kelamin='$jenis_kelamin', 
                        alamat='$alamat', 
                        no_telp='$no_telp', 
                        kelas_id='$kelas_id', 
                        jurusan_id='$jurusan_id',
                        updated_at=NOW() 
                        WHERE id='$id'";
        
        if (!mysqli_query($conn, $query_siswa)) {
            throw new Exception("Gagal memperbarui data siswa.");
        }
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($conn);
        $_SESSION['success'] = 'Data siswa berhasil diperbarui!';
        header('Location: dataSiswa.php');
        exit();
        
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($conn);
        $_SESSION['error'] = $e->getMessage();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// Proses hapus multiple data siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $selected_ids = $_POST['selected_ids'];
    
    // Pastikan ada data yang dipilih
    if (!empty($selected_ids)) {
        // Konversi array ke string untuk query
        $ids = implode(',', array_map('intval', $selected_ids));
        
        // Mulai transaksi
        mysqli_begin_transaction($conn);
        
        try {
            // 1. Dapatkan semua user_id yang akan dihapus
            $query_get_user_ids = "SELECT user_id FROM siswa WHERE id IN ($ids)";
            $result_user_ids = mysqli_query($conn, $query_get_user_ids);
            
            if (!$result_user_ids) {
                throw new Exception("Gagal mendapatkan data user terkait.");
            }
            
            $user_ids = array();
            while ($row = mysqli_fetch_assoc($result_user_ids)) {
                $user_ids[] = $row['user_id'];
            }
            
            if (empty($user_ids)) {
                throw new Exception("Tidak ada data user terkait yang ditemukan.");
            }
            
            $user_ids_str = implode(',', $user_ids);
            
            // 2. Hapus data dari tabel siswa
            $query_delete_siswa = "DELETE FROM siswa WHERE id IN ($ids)";
            if (!mysqli_query($conn, $query_delete_siswa)) {
                throw new Exception("Gagal menghapus data siswa.");
            }
            
            // 3. Hapus data user terkait
            $query_delete_users = "DELETE FROM users WHERE id IN ($user_ids_str)";
            if (!mysqli_query($conn, $query_delete_users)) {
                throw new Exception("Gagal menghapus data user.");
            }
            
            // Commit transaksi jika semua query berhasil
            mysqli_commit($conn);
            $_SESSION['success'] = count($selected_ids) . " data siswa berhasil dihapus";
        } catch (Exception $e) {
            // Rollback jika terjadi error
            mysqli_rollback($conn);
            $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Tidak ada data yang dipilih";
    }
    
    header('Location: dataSiswa.php');
    exit();
}

// Proses hapus single data siswa
if (isset($_GET['hapus'])) {
    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        $id = $_GET['hapus'];
        // Dapatkan user_id terlebih dahulu
        $result = mysqli_query($conn, "SELECT user_id FROM siswa WHERE id='$id'");
        if (!$result || mysqli_num_rows($result) == 0) {
            throw new Exception("Data siswa tidak ditemukan!");
        }
        
        $data = mysqli_fetch_assoc($result);
        $user_id = $data['user_id'];
        
        // Hapus dari tabel siswa
        if (!mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'")) {
            throw new Exception("Gagal menghapus data siswa.");
        }
        
        // Hapus dari tabel users
        if (!mysqli_query($conn, "DELETE FROM users WHERE id='$user_id'")) {
            throw new Exception("Gagal menghapus data user.");
        }
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($conn);
        $_SESSION['success'] = 'Data siswa berhasil dihapus!';
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($conn);
        $_SESSION['error'] = $e->getMessage();
    }
    
    header('Location: dataSiswa.php');
    exit();
}

// Ambil data jika edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT s.*, u.nama, u.username, u.email FROM siswa s JOIN users u ON s.user_id = u.id WHERE s.id='$id'");
    if ($result && mysqli_num_rows($result) > 0) {
        $editData = mysqli_fetch_assoc($result);
    }
}

// Ambil data jurusan untuk dropdown
$jurusan_options = mysqli_query($conn, "SELECT id_jurusan, kode_jurusan, nama_jurusan FROM jurusan ORDER BY nama_jurusan");

// Ambil data kelas untuk dropdown (tanpa tingkat)
$kelas_options = mysqli_query($conn, "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas");
?>
<!-- Bagian HTML tetap sama seperti sebelumnya -->
<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<section class="section">
    <?php  error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
    <div class="container-fluid">
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title d-flex align-items-center flex-wrap mb-30">
                        <h2 class="mr-40"><?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Siswa</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dataSiswa.php">Data Siswa</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= isset($editData) ? 'Edit' : 'Tambah' ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            <div class="flex justify-end items-start mb-4">
                <form method="POST" action="proses_import_siswa.php" enctype="multipart/form-data" class="flex items-center space-x-2">
                    <label class="text-sm font-medium">Upload Data Siswa (.xlsx)</label>
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="" required>
                    <button type="submit" name="import" class="main-btn primary-btn btn-hover btn-sm">Import Excel</button>
                </form>
            </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card-style settings-card-1 mb-30">
                    <div class="profile-info">
                        <form method="POST" action="">
                            <?php if (isset($editData)): ?>
                                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                            <?php endif; ?>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" class="form-control" required
                                               value="<?= htmlspecialchars($editData['nama'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>NIS <span class="text-danger">*</span></label>
                                        <input type="text" name="nis" class="form-control" required
                                               value="<?= htmlspecialchars($editData['nis'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" class="form-control" required
                                               value="<?= htmlspecialchars($editData['username'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Password <?= !isset($editData) ? '<span class="text-danger">*</span>' : '(Kosongkan jika tidak diubah)' ?></label>
                                        <input type="password" name="password" class="form-control" <?= !isset($editData) ? 'required' : '' ?>>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                               value="<?= htmlspecialchars($editData['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jenis_kelamin" class="form-control" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" <?= (isset($editData) && $editData['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= (isset($editData) && $editData['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                              <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Kelas <span class="text-danger">*</span></label>
                                        <select name="kelas" class="form-control" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            <?php 
                                            // Reset pointer and fetch kelas options again
                                            mysqli_data_seek($kelas_options, 0);
                                            while ($kelas = mysqli_fetch_assoc($kelas_options)): 
                                                $selected = (isset($editData) && $editData['kelas_id'] == $kelas['id_kelas']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $kelas['id_kelas'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($kelas['nama_kelas']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                  <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Jurusan <span class="text-danger">*</span></label>
                                        <select name="jurusan" class="form-control" required>
                                            <option value="">-- Pilih Jurusan --</option>
                                            <?php 
                                            mysqli_data_seek($jurusan_options, 0);
                                            while ($jurusan = mysqli_fetch_assoc($jurusan_options)): 
                                                $selected = (isset($editData) && $editData['jurusan_id'] == $jurusan['id_jurusan']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $jurusan['id_jurusan'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($jurusan['kode_jurusan']) ?> - <?= htmlspecialchars($jurusan['nama_jurusan']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
    
                               
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>No. Telepon</label>
                                        <input type="text" name="no_telp" class="form-control"
                                               value="<?= htmlspecialchars($editData['no_telp'] ?? '') ?>">
                                    </div>
                                </div>

                                 <div class="col-md-12">
                                    <div class="input-style-1">
                                        <label>Alamat</label>
                                        <textarea name="alamat" rows="3" class="form-control"><?= htmlspecialchars($editData['alamat'] ?? '') ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <button type="submit" name="<?= $editData ? 'update' : 'simpan' ?>" class="main-btn primary-btn btn-hover mt-3">
                                    <?= $editData ? 'Update' : 'Tambah' ?>
                                </button>
                                <a href="jadwalUjian.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'template/footer.php'; ?>

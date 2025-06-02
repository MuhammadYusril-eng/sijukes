<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);    

// Proses simpan data siswa
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas_id']);

    // Cek username sudah ada atau belum
    $cek_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username \"$username\" sudah ada, silakan gunakan username lain!'); window.history.back();</script>";
        exit;
    }

    // Insert ke tabel users
    $query_user = "INSERT INTO users (nama, username, password, email, role, created_at) 
                  VALUES ('$nama', '$username', '$password', '$email', 'siswa', NOW())";
    
    if (mysqli_query($conn, $query_user)) {
        $user_id = mysqli_insert_id($conn);
        
        // Insert ke tabel siswa
        $query_siswa = "INSERT INTO siswa (user_id, nis, jenis_kelamin, alamat, no_telp, kelas_id, created_at) 
                        VALUES ('$user_id', '$nis', '$jenis_kelamin', '$alamat', '$no_telp', '$kelas_id', NOW())";
        
        if (mysqli_query($conn, $query_siswa)) {
            echo "<script>alert('Data siswa berhasil disimpan!'); window.location.href='dataSiswa.php';</script>";
        } else {
            // Jika gagal insert siswa, hapus user yang sudah dibuat
            mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
            echo "<script>alert('Gagal menyimpan data siswa.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyimpan data user.');</script>";
    }
}

// Proses update data siswa
if (isset($_POST['update'])) {
    $id = $_POST['id']; // id siswa
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $kelas_id = mysqli_real_escape_string($conn, $_POST['kelas_id']);

    // Ambil user_id siswa yang sedang diupdate
    $result_userid = mysqli_query($conn, "SELECT user_id FROM siswa WHERE id='$id'");
    $user_data = mysqli_fetch_assoc($result_userid);
    $user_id = $user_data['user_id'];

    // Cek username sudah ada di user lain selain yang sedang diupdate
    $cek_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND id != '$user_id'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username \"$username\" sudah ada, silakan gunakan username lain!'); window.history.back();</script>";
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
    
    // Update tabel siswa
    $query_siswa = "UPDATE siswa SET 
                    nis='$nis', 
                    jenis_kelamin='$jenis_kelamin', 
                    alamat='$alamat', 
                    no_telp='$no_telp', 
                    kelas_id='$kelas_id', 
                    updated_at=NOW() 
                    WHERE id=$id";
    
    if (mysqli_query($conn, $query_user) && mysqli_query($conn, $query_siswa)) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location.href='dataSiswa.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data siswa.');</script>";
    }
}


// Proses hapus data siswa
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Dapatkan user_id terlebih dahulu
    $result = mysqli_query($conn, "SELECT user_id FROM siswa WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
    $user_id = $data['user_id'];
    
    // Hapus dari tabel siswa
    mysqli_query($conn, "DELETE FROM siswa WHERE id=$id");
    
    // Hapus dari tabel users
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
    
    echo "<script>alert('Data siswa berhasil dihapus!'); window.location.href='dataSiswa.php';</script>";
}

// Ambil data jika edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT s.*, u.nama, u.username, u.email FROM siswa s JOIN users u ON s.user_id = u.id WHERE s.id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Ambil data kelas untuk dropdown
$kelas_options = mysqli_query($conn, "SELECT id_kelas, nama_kelas, tingkat FROM kelas ORDER BY tingkat, nama_kelas");
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/sidebar.php'; ?>

<section class="section">
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
                                        <select name="kelas_id" class="form-control" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            <?php while ($kelas = mysqli_fetch_assoc($kelas_options)): ?>
                                                <option value="<?= $kelas['id_kelas'] ?>"
                                                    <?= (isset($editData) && $editData['kelas_id'] == $kelas['id_kelas']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($kelas['nama_kelas']) ?> - <?= htmlspecialchars($kelas['tingkat']) ?>
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

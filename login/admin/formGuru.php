<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);    

// Proses simpan data
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // Cek duplikat username, email, atau nip
    $cekDuplikat = mysqli_query($conn, "SELECT u.username, u.email, g.nip 
        FROM users u 
        LEFT JOIN guru g ON u.id = g.user_id 
        WHERE u.username = '$username' OR u.email = '$email' OR g.nip = '$nip'");
    
    if (mysqli_num_rows($cekDuplikat) > 0) {
        echo "<script>alert('Username, Email, atau NIP sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Insert ke tabel users
    $query_user = "INSERT INTO users (nama, username, password, email, role, created_at) 
                  VALUES ('$nama', '$username', '$password', '$email', 'guru', NOW())";
    
    if (mysqli_query($conn, $query_user)) {
        $user_id = mysqli_insert_id($conn);
        
        // Insert ke tabel guru
        $query_guru = "INSERT INTO guru (user_id, nip, jenis_kelamin, alamat, no_telp, created_at) 
                      VALUES ('$user_id', '$nip', '$jenis_kelamin', '$alamat', '$no_telp', NOW())";
        
        if (mysqli_query($conn, $query_guru)) {
            // Proses mata pelajaran yang diajarkan
            if (isset($_POST['mapel_id'])) {
                $guru_id = mysqli_insert_id($conn);
                foreach ($_POST['mapel_id'] as $mapel_id) {
                    $mapel_id = mysqli_real_escape_string($conn, $mapel_id);
                    mysqli_query($conn, "INSERT INTO guru_mapel (guru_id, mapel_id, created_at) VALUES ('$guru_id', '$mapel_id', NOW())");
                }
            }
            
            echo "<script>alert('Data guru berhasil disimpan!'); window.location.href='dataGuru.php';</script>";
        } else {
            // Jika gagal insert guru, hapus user yang sudah dibuat
            mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
            echo "<script>alert('Gagal menyimpan data guru.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyimpan data user.');</script>";
    }
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // Cek user_id dari guru
    $res_user = mysqli_query($conn, "SELECT user_id FROM guru WHERE id = $id");
    $row_user = mysqli_fetch_assoc($res_user);
    $current_user_id = $row_user['user_id'];

    // Cek duplikat selain dari data ini sendiri
    $cekDuplikat = mysqli_query($conn, "SELECT u.id AS uid, g.id AS gid FROM users u 
        LEFT JOIN guru g ON u.id = g.user_id 
        WHERE (u.username = '$username' OR u.email = '$email' OR g.nip = '$nip') 
        AND u.id != $current_user_id");
    
    if (mysqli_num_rows($cekDuplikat) > 0) {
        echo "<script>alert('Username, Email, atau NIP sudah digunakan oleh pengguna lain!'); window.history.back();</script>";
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
                  WHERE id=$current_user_id";
    
    // Update tabel guru
    $query_guru = "UPDATE guru SET 
                  nip='$nip', 
                  jenis_kelamin='$jenis_kelamin', 
                  alamat='$alamat', 
                  no_telp='$no_telp', 
                  updated_at=NOW() 
                  WHERE id=$id";
    
    if (mysqli_query($conn, $query_user) && mysqli_query($conn, $query_guru)) {
        // Update mata pelajaran yang diajarkan
        if (isset($_POST['mapel_id'])) {
            // Hapus dulu semua relasi mapel yang ada
            mysqli_query($conn, "DELETE FROM guru_mapel WHERE guru_id = $id");
            
            // Tambahkan yang baru
            foreach ($_POST['mapel_id'] as $mapel_id) {
                $mapel_id = mysqli_real_escape_string($conn, $mapel_id);
                mysqli_query($conn, "INSERT INTO guru_mapel (guru_id, mapel_id, created_at) VALUES ('$id', '$mapel_id', NOW())");
            }
        }
        
        echo "<script>alert('Data guru berhasil diperbarui!'); window.location.href='dataGuru.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data guru.');</script>";
    }
}


// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Dapatkan user_id terlebih dahulu
    $result = mysqli_query($conn, "SELECT user_id FROM guru WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
    $user_id = $data['user_id'];
    
    // Hapus dari tabel guru_mapel dulu
    mysqli_query($conn, "DELETE FROM guru_mapel WHERE guru_id=$id");
    
    // Hapus dari tabel guru
    mysqli_query($conn, "DELETE FROM guru WHERE id=$id");
    
    // Hapus dari tabel users
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
    
    echo "<script>alert('Data guru berhasil dihapus!'); window.location.href='dataGuru.php';</script>";
}

// Ambil data jika edit
$editData = null;
$editMapel = [];
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT g.*, u.nama, u.username, u.email FROM guru g JOIN users u ON g.user_id = u.id WHERE g.id=$id");
    $editData = mysqli_fetch_assoc($result);
    
    // Ambil mapel yang diajarkan guru ini
    $result_mapel = mysqli_query($conn, "SELECT mapel_id FROM guru_mapel WHERE guru_id=$id");
    while ($row = mysqli_fetch_assoc($result_mapel)) {
        $editMapel[] = $row['mapel_id'];
    }
}

// Ambil data untuk dropdown
$mapel_options = mysqli_query($conn, "SELECT * FROM mapel ORDER BY nama_mapel");
?>

<?php require_once 'template/header.php';?>
<?php require_once 'template/sidebar.php';?>

<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-80">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title d-flex align-items-center flex-wrap mb-30">
                        <h2 class="mr-40"><?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Guru</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dataGuru.php">Data Guru</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= isset($editData) ? 'Edit' : 'Tambah' ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
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
                                        <label>NIP <span class="text-danger">*</span></label>
                                        <input type="text" name="nip" class="form-control" required 
                                               value="<?= htmlspecialchars($editData['nip'] ?? '') ?>">
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
                                        <label>No. Telepon</label>
                                        <input type="text" name="no_telp" class="form-control" 
                                               value="<?= htmlspecialchars($editData['no_telp'] ?? '') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control"><?= htmlspecialchars($editData['alamat'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                             <div class="col-md-6">
                            <div class="input-style-1">
                                <label>Mata Pelajaran yang Diajarkan</label>
                                <select name="mapel_id" class="form-control" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php 
                                    mysqli_data_seek($mapel_options, 0);
                                    while ($mapel = mysqli_fetch_assoc($mapel_options)): 
                                        $selected = ($mapel['id_mapel'] == $editMapel[0]) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $mapel['id_mapel'] ?>" <?= $selected ?>>
                                            <?= htmlspecialchars($mapel['nama_mapel']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            </div>
                                
                                <div class="col-12">
                                    <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>" 
                                            class="main-btn primary-btn btn-hover mt-3">
                                        <?= isset($editData) ? 'Update' : 'Simpan' ?> Data Guru
                                    </button>
                                    <a href="dataGuru.php" class="main-btn light-btn btn-hover mt-3">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include './template/footer.php'; ?>
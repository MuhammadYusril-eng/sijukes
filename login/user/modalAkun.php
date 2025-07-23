<!-- MODAL UPDATE -->
<?php
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);
?>
<div id="upAkun<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-purple"><i class="lni lni-pencil"></i> Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="c_password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="c_pwd" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- end modal update -->

<?php 
if(isset($_POST['c_pwd'])){
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    // Validasi input
    if(empty($password) || empty($c_password)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Password tidak boleh kosong',
                timer: 3000,
                showConfirmButton: false
            });
        </script>";
    } elseif($password != $c_password) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Password dan konfirmasi password tidak sama',
                timer: 3000,
                showConfirmButton: false
            });
        </script>";
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password
        $query = mysqli_query($conn, "UPDATE users SET password='$hashed_password' WHERE id='$user_id'");
        
        if($query) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Password berhasil diupdate',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan: ".mysqli_error($conn)."',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>";
        }
    }
}
?>
<script type="text/javascript" src="../../assets/sweetalert1/sweetalert.min.js"></script>

<?php
include "./config/cek-sesi.php";
include "../../config/koneksi.php";

$sessionKodeUser = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users  WHERE level='admin' AND id = '$sessionKodeUser'");
while ($row = mysqli_fetch_assoc($query)){
    $id = $row['id']; //user id value set to verify_id variable
}
// ADD
// var_dump($_FILES);
if(isset($_POST['user_info'])){

  $username     = $_POST['username'];
  $no_hp     = $_POST['no_hp'];
  $bio     = $_POST['bio'];
  $url_ig     = $_POST['url_ig'];
  $url_fb     = $_POST['url_fb'];
  $url_tw     = $_POST['url_tw'];
  $url_tl     = $_POST['url_tl'];
  $foto    = $_FILES['foto']['name'];


//cek dulu jika ada gambar jalankan coding ini
if($foto != "") {
  $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg'); //ekstensi file gambar yang bisa diupload 
  $x = explode('.', $foto); //memisahkan nama file dengan ekstensi yang diupload
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['foto']['tmp_name'];   
  $angka_acak     = rand(1,999);
  $nama_gambar_baru = $angka_acak.'-'.$foto; //menggabungkan angka acak dengan nama file sebenarnya
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
                move_uploaded_file($file_tmp, 'file/'.$nama_gambar_baru); //memindah file gambar ke folder gambar
                  // jalankan query INSERT untuk menambah data ke database pastikan sesuai urutan (id tidak perlu karena dibikin otomatis)
                  $query = mysqli_query($conn,"UPDATE users SET username='$username', no_hp='$no_hp', bio='$bio', url_ig='$url_ig', url_fb='$url_fb', url_tw='$url_tw' , url_tl='$url_tl', foto='$nama_gambar_baru' WHERE id='$id'");
                  $result = ($query);
                  // periska query apakah ada error
                  if(!$result){
                      die ("Query gagal dijalankan: ".mysqli_errno($conn).
                           " - ".mysqli_error($conn));
                  } else {
                    // die;
                    //tampil alert dan akan redirect ke halaman index.php
                    //silahkan ganti index.php sesuai halaman yang akan dituju
                    $_SESSION['successProfile'] = "Berhasil Update Profile.";
                    // Redirect kembali ke halaman data pengguna
                    header("Location: data-user.php");
                    exit();
                  }

            } else {     
             //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
                echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='myProfile.php';</script>";
            }

}else{

$query = mysqli_query($conn,"UPDATE users SET username='$username', no_hp='$no_hp', bio='$bio', url_ig='$url_ig', url_fb='$url_fb', url_tw='$url_tw', url_tl='$url_tl' WHERE id='$id'");
$result = ($query);

if(!$result){
  die ("Query gagal dijalankan: ".mysqli_errno($conn)." - ".mysqli_error($conn));
} else {
//tampil alert dan akan redirect ke halaman index.php
//silahkan ganti index.php sesuai halaman yang akan dituju
$_SESSION['successProfile'] = "Berhasil Update Profile.";
                    // Redirect kembali ke halaman data pengguna
                    header("Location:myProfile.php");
                    exit();
}

}}elseif(isset($_POST['c_pwd'])){

    $password     = $_POST['password'];
    $c_password     = $_POST['c_password'];

    if (empty($_POST['password']) || empty($_POST['c_password'])) {
    echo "<h3><font color=red>Ganti Password Gagal! Data Tidak Boleh Kosong.</font></h3>";    

    }elseif (($_POST['password'])!= ($_POST['c_password'])) {
     echo "<h3><font color=red>Ganti Password Gagal! Password Tidak Sama.</font></h3>";    

    }else{
       $query = mysqli_query($conn,"UPDATE users SET password='".password_hash($password, PASSWORD_DEFAULT)."' WHERE id='$id'");
          $result = ($query);
    //setelah berhasil update
    if(!$result){
        die ("Query gagal dijalankan: ".mysqli_errno($conn).
             " - ".mysqli_error($conn));
    } else {
      //tampil alert dan akan redirect ke halaman index.php
      //silahkan ganti index.php sesuai halaman yang akan dituju
      echo "<script type='text/javascript'>
      setTimeout(function () {  
          swal({
              icon: 'success',
              closeOnClickOutside: false,
              closeOnEsc: false,
              dangerMode: true,
              className: 'red-bg',
              title: 'Berhasil',
              text:  'Berhasil Update Password',
              type: 'success',
              timer: 3000,
              showConfirmButton: false
              });  
              },10); 
              window.setTimeout(function(){ 
               window.location.replace('index.php');
               } ,2000); 
       </script>";                 
       }

}
    
// CRUD Penduduk
 
 } elseif (isset($_POST['addpen'])) {
    $nama     = $_POST['nama'];
    $jenis_kelamin     = $_POST['jenis_kelamin'];
    $pekerjaan     = $_POST['pekerjaan'];
    $umur     = $_POST['umur'];
    $status_perkawinan     = $_POST['status_perkawinan'];
    $nik     = $_POST['nik'];
    $agama     = $_POST['agama'];
    $pendidikan     = $_POST['pendidikan'];


    $query = mysqli_query($conn,"INSERT INTO `tbl_penduduk` (`nama`,`jenis_kelamin`,`pekerjaan`,`umur`,`status_perkawinan`, `nik`, `agama`, `pendidikan`) VALUES
    ('$nama', '$jenis_kelamin', '$pekerjaan', '$umur', '$status_perkawinan', '$nik', '$agama', '$pendidikan')");
      $result = ($query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($conn).
               " - ".mysqli_error($conn));
      } else {
        //tampil alert dan akan redirect ke halaman index.php
        //silahkan ganti index.php sesuai halaman yang akan dituju
        echo "<script type='text/javascript'>
        setTimeout(function () {  
            swal({
                icon: 'success',
                closeOnClickOutside: false,
                closeOnEsc: false,
                dangerMode: true,
                className: 'red-bg',
                title: 'Berhasil',
                text:  'Berhasil Tambah Penduduk',
                type: 'success',
                timer: 3000,
                showConfirmButton: false
                });  
                },10); 
                window.setTimeout(function(){ 
                 window.location.replace('dataPenduduk.php');
                 } ,2000); 
         </script>";                 
         }
         die();
        }elseif(isset($_POST['delPen'])) {
            
          $id = $_POST['delPen'];
            $queryDelete = mysqli_query($conn,"DELETE FROM `tbl_penduduk` WHERE id='$id'");
              $result = ($queryDelete);
              // periska query apakah ada error
              if(!$result){
                  die ("Query gagal dijalankan: ".mysqli_errno($conn).
                       " - ".mysqli_error($conn));
              } else {
                //tampil alert dan akan redirect ke halaman index.php
                //silahkan ganti index.php sesuai halaman yang akan dituju
                echo "<script type='text/javascript'>
                setTimeout(function () {  
                    swal({
                        icon: 'success',
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        dangerMode: true,
                        className: 'red-bg',
                        title: 'Berhasil',
                        text:  'Berhasil Hapus',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: false
                        });  
                        },10);
                        window.setTimeout(function(){ 
                          window.location.replace('dataPenduduk.php');
                          } ,2000); 
                      
                 </script>";
                  }
                }elseif(isset($_POST['upPen'])) {
                  $id = $_GET['id'];
                  $nama     = $_POST['nama'];
                  $jenis_kelamin     = $_POST['jenis_kelamin'];
                  $pekerjaan     = $_POST['pekerjaan'];
                  $pendidikan     = $_POST['pendidikan'];
                  $umur     = $_POST['umur'];
                  $status_perkawinan     = $_POST['status_perkawinan'];
                  $nik     = $_POST['nik'];
                  $agama     = $_POST['agama'];

                  $queryUpdate = mysqli_query($conn, "UPDATE `tbl_penduduk` SET nama='$nama', jenis_kelamin='$jenis_kelamin', pekerjaan='$pekerjaan', umur='$umur', status_perkawinan='$status_perkawinan', nik='$nik', agama='$agama', pendidikan='$pendidikan' WHERE id='$id'  ");
                    $result = ($queryUpdate);
                    // periska query apakah ada error
                    if(!$result){
                        die ("Query gagal dijalankan: ".mysqli_errno($conn).
                             " - ".mysqli_error($conn));
                    } else {
                      //tampil alert dan akan redirect ke halaman index.php
                      //silahkan ganti index.php sesuai halaman yang akan dituju
                      echo "<script type='text/javascript'>
                      setTimeout(function () {  
                          swal({
                              icon: 'success',
                              closeOnClickOutside: false,
                              closeOnEsc: false,
                              dangerMode: true,
                              className: 'red-bg',
                              title: 'Berhasil',
                              text:  'Berhasil Update',
                              type: 'success',
                              timer: 3000,
                              showConfirmButton: false
                              });  
                              },10); 
                              window.setTimeout(function(){ 
                               window.location.replace('dataPenduduk.php');
                               } ,2000); 
                       </script>";                 
                       }
                      }elseif(isset($_POST['addArtikel'])) {
                        // Pastikan ada file yang diunggah
                        if (isset($_FILES['foto'])) {
                            $judul = $_POST['judul'];
                            $deskripsi = $_POST['deskripsi'];
                            $waktu_upload_input = $_POST['waktu_upload']; // Format "m-d-Y"
                    
                            // Ubah format tanggal ke "Y-m-d"
                            $waktu_upload = date('Y-m-d', strtotime($waktu_upload_input));
                    
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/berita/';
                    
                            // Generate nama file unik untuk menghindari tumpang tindih
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Cek apakah file telah diunggah dengan benar
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Persiapan query INSERT dengan parameter binding
                                $query = $conn->prepare("INSERT INTO tbl_berita (judul, deskripsi, foto, waktu_upload) VALUES (?, ?, ?, ?)");
                                $query->bind_param("ssss", $judul, $deskripsi, $namaFile, $waktu_upload);
                    
                                // Eksekusi query INSERT
                                $result = $query->execute();
                    
                                // Periksa hasil eksekusi query
                                if ($result) {
                                    // Berhasil disimpan, arahkan ke halaman yang sesuai
                                    header("Location: dataArtikel.php");
                                    exit();
                                } else {
                                    // Gagal menyimpan data, tampilkan pesan kesalahan
                                    echo "Gagal menyimpan data.";
                                }
                    
                                // Tutup statement
                                $query->close();
                            } else {
                                // Gagal mengunggah gambar, tampilkan pesan kesalahan
                                echo "Gagal mengunggah gambar.";
                            }
                        }
                    }elseif (isset($_POST['upArtikel'])) {
                        // Pastikan ada file yang diunggah
                        if (isset($_FILES['foto'])) {
                            $id = $_GET['id'];
                            $judul = $_POST['judul'];
                            $deskripsi = $_POST['deskripsi'];
                            $waktu_upload_input = $_POST['waktu_upload']; // Format "m-d-Y"
                        
                            // Ubah format tanggal ke "Y-m-d"
                            $waktu_upload = date('Y-m-d', strtotime($waktu_upload_input));
                        
                            if ($_FILES['foto']['name'] != '') {
                                // Lokasi folder untuk menyimpan gambar
                                $uploadDir = 'file/images/berita/';
                        
                                // Generate nama file unik
                                $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                                $targetPath = $uploadDir . $namaFile;
                        
                                // Pindahkan file gambar yang diunggah
                                if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                    // Persiapan query UPDATE dengan parameter binding
                                    $queryUpdate = $conn->prepare("UPDATE tbl_berita SET judul=?, deskripsi=?, foto=?, waktu_upload=? WHERE id=?");
                                    $queryUpdate->bind_param("ssssi", $judul, $deskripsi, $namaFile, $waktu_upload, $id);
                                    
                                    // Eksekusi query UPDATE
                                    $result = $queryUpdate->execute();
                        
                                    // Periksa hasil eksekusi query
                                    if ($result) {
                                        // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                        header("Location: dataArtikel.php");
                                        exit();
                                    } else {
                                        // Gagal menyimpan data, tampilkan pesan kesalahan
                                        echo "Gagal mengupdate data: " . $queryUpdate->error;
                                    }
                        
                                    // Tutup statement
                                    $queryUpdate->close();
                                } else {
                                    echo "Gagal mengunggah gambar.";
                                }
                            } else {
                                // Update data berita tanpa mengubah gambar
                                // Persiapan query UPDATE dengan parameter binding
                                $queryUpdate = $conn->prepare("UPDATE tbl_berita SET judul=?, deskripsi=?, waktu_upload=? WHERE id=?");
                                $queryUpdate->bind_param("sssi", $judul, $deskripsi, $waktu_upload, $id);
                                
                                // Eksekusi query UPDATE
                                $result = $queryUpdate->execute();
                        
                                // Periksa hasil eksekusi query
                                if ($result) {
                                    // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                    header("Location: dataArtikel.php");
                                    exit();
                                } else {
                                    // Gagal menyimpan data, tampilkan pesan kesalahan
                                    echo "Gagal mengupdate data: " . $queryUpdate->error;
                                }
                        
                                // Tutup statement
                                $queryUpdate->close();
                            }
                        }
                    }elseif(isset($_POST['delArtikel'])) {
                    $id = $_POST['delArtikel'];
                
                    // Query untuk mengambil nama file foto berita yang akan dihapus
                    $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_berita WHERE id='$id'");
                    $dataFoto = mysqli_fetch_assoc($queryFoto);
                
                    // Hapus berita dari database
                    $queryDelete = mysqli_query($conn, "DELETE FROM tbl_berita WHERE id='$id'");
                
                    if ($queryDelete) {
                        // Hapus juga file gambar dari server jika ada
                        if (!empty($dataFoto['foto'])) {
                            $fileToDelete = 'file/images/berita/' . $dataFoto['foto'];
                            if (file_exists($fileToDelete)) {
                                unlink($fileToDelete);
                            }
                        }
                
                        // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                        header("Location: dataArtikel.php");
                        exit();
                    } else {
                        echo "Gagal menghapus data.";
                    }
                }elseif(isset($_POST['addVisiMisi'])) {
                  $visi = mysqli_real_escape_string($conn, $_POST['visi']); 
                  $misi = mysqli_real_escape_string($conn, $_POST['misi']);
              
                  // Insert data into the database
                  $queryInsert = mysqli_query($conn, "INSERT INTO tbl_visi_misi (visi, misi) VALUES ('$visi', '$misi')");
                  if ($queryInsert) {
                      // Data inserted successfully, redirect to the appropriate page
                      header("Location: dataVisiMisi.php");
                      exit();
                  } else {
                      echo "Failed to insert data.";
                  }
              }elseif (isset($_POST['delVisiMisi'])) {
                $id = $_POST['delVisiMisi'];
            
                // Delete data from the database
                $queryDelete = mysqli_query($conn, "DELETE FROM tbl_visi_misi WHERE id = $id");
            
                if ($queryDelete) {
                    // Data deleted successfully, redirect to the appropriate page
                    header("Location: dataVisiMisi.php");
                    exit();
                } else {
                    echo "Failed to delete data.";
                }
            }elseif(isset($_POST['addSambutan'])) {
                        // Pastikan ada file yang diunggah
                        if (isset($_FILES['foto'])) {
                            $nama_lurah = $_POST['nama_lurah'];
                            $sambutan = $_POST['sambutan'];
                            
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/fotoLurah/';
                    
                            // Generate nama file unik untuk menghindari tumpang tindih
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Cek apakah file telah diunggah dengan benar
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Lakukan query untuk menyimpan data ke dalam tabel berita
                                $query = mysqli_query($conn, "INSERT INTO tbl_sambutan (nama_lurah, sambutan, foto) VALUES ('$nama_lurah', '$sambutan', '$namaFile')");
                    
                                if ($query) {
                                    // Berhasil disimpan, arahkan ke halaman yang sesuai
                                    header("Location: dataSambutan.php");
                                    exit();
                                } else {
                                    // Gagal menyimpan data, tampilkan pesan kesalahan
                                    echo "Gagal menyimpan data.";
                                }
                            } else {
                                // Gagal mengunggah gambar, tampilkan pesan kesalahan
                                echo "Gagal mengunggah gambar.";
                            }
                        }
                    }elseif(isset($_POST['upSambutan'])) {
                        $id = $_GET['id'];
                        $nama_lurah = $_POST['nama_lurah'];
                        $sambutan = $_POST['sambutan'];
                    
                        // Cek apakah ada file gambar yang diunggah
                        if ($_FILES['foto']['name'] != '') {
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/fotoLurah/';
                    
                            // Generate nama file unik
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Pindahkan file gambar yang diunggah
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Update data berita dengan gambar baru
                                $queryUpdate = mysqli_query($conn, "UPDATE tbl_sambutan SET nama_lurah='$nama_lurah', foto='$namaFile', sambutan='$sambutan' WHERE id='$id'");
                    
                                if ($queryUpdate) {
                                    // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                    header("Location: dataSambutan.php");
                                    exit();
                                } else {
                                    echo "Gagal mengupdate data.";
                                }
                            } else {
                                echo "Gagal mengunggah gambar.";
                            }
                        } else {
                            // Update data berita tanpa mengubah gambar
                            $queryUpdate = mysqli_query($conn, "UPDATE tbl_berita SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'");
                    
                            if ($queryUpdate) {
                                // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                header("Location: dataSambutan.php");
                                exit();
                            } else {
                                echo "Gagal mengupdate data.";
                            }
                        }
                    }elseif(isset($_POST['delSambutan'])) {
                        $id = $_POST['delSambutan'];
                    
                        // Query untuk mengambil nama file foto berita yang akan dihapus
                        $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_sambutan WHERE id='$id'");
                        $dataFoto = mysqli_fetch_assoc($queryFoto);
                    
                        // Hapus berita dari database
                        $queryDelete = mysqli_query($conn, "DELETE FROM tbl_sambutan WHERE id='$id'");
                    
                        if ($queryDelete) {
                            // Hapus juga file gambar dari server jika ada
                            if (!empty($dataFoto['foto'])) {
                                $fileToDelete = 'file/images/fotoLurah/' . $dataFoto['foto'];
                                if (file_exists($fileToDelete)) {
                                    unlink($fileToDelete);
                                }
                            }
                    
                            // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                            header("Location: dataSambutan.php");
                            exit();
                        } else {
                            echo "Gagal menghapus data.";
                        }
                    }elseif(isset($_POST['addKuliner'])) {
                        // Pastikan ada file yang diunggah
                        if (isset($_FILES['foto'])) {
                            $judul = $_POST['judul'];
                            $deskripsi = $_POST['deskripsi'];
                            $noWa = $_POST['noWa'];
                            $usernameIG = $_POST['usernameIG'];
                            $waktu_upload_input = $_POST['waktu_upload']; // Format "m-d-Y"
                    
                            // Ubah format tanggal ke "Y-m-d"
                            $waktu_upload = date('Y-m-d', strtotime($waktu_upload_input));
                    
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/galeri/';
                    
                            // Generate nama file unik untuk menghindari tumpang tindih
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Cek apakah file telah diunggah dengan benar
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Persiapan query INSERT dengan parameter binding
                                $query = $conn->prepare("INSERT INTO tbl_kuliner (foto, judul, deskripsi, noWa, usernameIG, waktu_upload) VALUES (?, ?, ?, ?, ?, ?)");
                                $query->bind_param("ssssss", $namaFile, $judul, $deskripsi, $noWa, $usernameIG, $waktu_upload);
                    
                                // Eksekusi query INSERT
                                $result = $query->execute();
                    
                                // Periksa hasil eksekusi query
                                if ($result) {
                                    // Berhasil disimpan, arahkan ke halaman yang sesuai
                                    header("Location: dataKuliner.php");
                                    exit();
                                } else {
                                    // Gagal menyimpan data, tampilkan pesan kesalahan
                                    echo "Gagal menyimpan data.";
                                }
                    
                                // Tutup statement
                                $query->close();
                            } else {
                                // Gagal mengunggah gambar, tampilkan pesan kesalahan
                                echo "Gagal mengunggah gambar.";
                            }
                        }
                    }elseif(isset($_POST['upKuliner'])) {
                        $id = $_GET['id'];
                        $judul = $_POST['judul'];
                        $deskripsi = $_POST['deskripsi'];
                        $noWa = $_POST['noWa'];
                        $usernameIG = $_POST['usernameIG'];
                        $waktu_upload_input = $_POST['waktu_upload']; // Format "m-d-Y"
                    
                        // Ubah format tanggal ke "Y-m-d"
                        $waktu_upload = date('Y-m-d', strtotime($waktu_upload_input));
                    
                        // Persiapan query UPDATE dengan parameter binding
                        $queryUpdate = $conn->prepare("UPDATE tbl_kuliner SET judul=?, deskripsi=?, noWa=?, usernameIG=?, waktu_upload=? WHERE id=?");
                        $queryUpdate->bind_param("sssssi", $judul, $deskripsi, $noWa, $usernameIG, $waktu_upload, $id);
                    
                        if ($_FILES['foto']['name'] != '') {
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/galeri/';
                    
                            // Generate nama file unik
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Pindahkan file gambar yang diunggah
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Jika berhasil mengunggah gambar, tambahkan nama file ke query UPDATE
                                $queryUpdate->bind_param("s", $namaFile);
                            } else {
                                echo "Gagal mengunggah gambar.";
                                exit(); // Hentikan eksekusi script
                            }
                        }
                    
                        // Eksekusi query UPDATE
                        $result = $queryUpdate->execute();
                    
                        // Periksa hasil eksekusi query
                        if ($result) {
                            // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                            header("Location: dataKuliner.php");
                            exit();
                        } else {
                            echo "Gagal mengupdate data.";
                        }
                    
                        // Tutup statement
                        $queryUpdate->close();
                    }elseif(isset($_POST['delKuliner'])) {
                        $id = $_POST['delKuliner'];
                    
                        // Query untuk mengambil nama file foto berita yang akan dihapus
                        $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_kuliner WHERE id='$id'");
                        $dataFoto = mysqli_fetch_assoc($queryFoto);
                    
                        // Hapus berita dari database
                        $queryDelete = mysqli_query($conn, "DELETE FROM tbl_kuliner WHERE id='$id'");
                    
                        if ($queryDelete) {
                            // Hapus juga file gambar dari server jika ada
                            if (!empty($dataFoto['foto'])) {
                                $fileToDelete = 'file/images/galeri/' . $dataFoto['foto'];
                                if (file_exists($fileToDelete)) {
                                    unlink($fileToDelete);
                                }
                            }
                    
                            // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                            header("Location: dataKuliner.php");
                            exit();
                        } else {
                            echo "Gagal menghapus data.";
                        }
                    }
                    elseif(isset($_POST['addSP'])) {
                        // Pastikan ada file yang diunggah
                        if (isset($_FILES['foto'])) {
                            $deskripsi = $_POST['deskripsi'];
                            
                            // Lokasi folder untuk menyimpan gambar
                            $uploadDir = 'file/images/strukturPemerintahan/';
                    
                            // Generate nama file unik untuk menghindari tumpang tindih
                            $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                            $targetPath = $uploadDir . $namaFile;
                    
                            // Cek apakah file telah diunggah dengan benar
                            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                                // Lakukan query untuk menyimpan data ke dalam tabel berita
                                $query = mysqli_query($conn, "INSERT INTO tbl_SP (deskripsi, foto) VALUES ('$deskripsi', '$namaFile')");
                    
                                if ($query) {
                                    // Berhasil disimpan, arahkan ke halaman yang sesuai
                                    header("Location: dataSP.php");
                                    exit();
                                } else {
                                    // Gagal menyimpan data, tampilkan pesan kesalahan
                                    echo "Gagal menyimpan data.";
                                }
                            } else {
                                // Gagal mengunggah gambar, tampilkan pesan kesalahan
                                echo "Gagal mengunggah gambar.";
                            }
                        }
                    }elseif(isset($_POST['upSP'])) {
                      $id = $_GET['id'];
                      $deskripsi = $_POST['deskripsi'];
    
                      // Ubah format tanggal ke "Y-m-d"
                     if ($_FILES['foto']['name'] != '') {
                          // Lokasi folder untuk menyimpan gambar
                          $uploadDir = 'file/images/strukturPemerintahan/';
                  
                          // Generate nama file unik
                          $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                          $targetPath = $uploadDir . $namaFile;
                  
                          // Pindahkan file gambar yang diunggah
                          if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                              // Update data berita dengan gambar baru
                              $queryUpdate = mysqli_query($conn, "UPDATE tbl_SP SET deskripsi='$deskripsi', foto='$namaFile' WHERE id='$id'");
                  
                              if ($queryUpdate) {
                                  // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                  header("Location: dataSP.php");
                                  exit();
                              } else {
                                  echo "Gagal mengupdate data.";
                              }
                          } else {
                              echo "Gagal mengunggah gambar.";
                          }
                      } else {
                          // Update data berita tanpa mengubah gambar
                          $queryUpdate = mysqli_query($conn, "UPDATE tbl_berita SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'");
                  
                          if ($queryUpdate) {
                              // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                              header("Location: dataSP.php");
                              exit();
                          } else {
                              echo "Gagal mengupdate data.";
                          }
                      }
                  }elseif(isset($_POST['delSP'])) {
                    $id = $_POST['delSP'];
                
                    // Query untuk mengambil nama file foto berita yang akan dihapus
                    $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_SP WHERE id='$id'");
                    $dataFoto = mysqli_fetch_assoc($queryFoto);
                
                    // Hapus berita dari database
                    $queryDelete = mysqli_query($conn, "DELETE FROM tbl_SP WHERE id='$id'");
                
                    if ($queryDelete) {
                        // Hapus juga file gambar dari server jika ada
                        if (!empty($dataFoto['foto'])) {
                            $fileToDelete = 'file/images/strukturPemerintahan/' . $dataFoto['foto'];
                            if (file_exists($fileToDelete)) {
                                unlink($fileToDelete);
                            }
                        }
                
                        // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                        header("Location: dataSP.php");
                        exit();
                    } else {
                        echo "Gagal menghapus data.";
                    }
                }elseif(isset($_POST['addPengumuman'])) {
                    // Pastikan ada file yang diunggah
                    if (isset($_FILES['foto'])) {
                        $judul = $_POST['judul'];
                        $deskripsi = $_POST['deskripsi'];
                        $waktu_upload = $_POST['waktu_upload'];
                        $kategori = $_POST['kategori'];
                        $alamat = $_POST['alamat'];
                        $kontak = $_POST['kontak'];
                        
                        // Lokasi folder untuk menyimpan gambar
                        $uploadDir = 'file/images/pengumuman/';
                        
                        // Generate nama file unik untuk menghindari tumpang tindih
                        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                        $targetPath = $uploadDir . $namaFile;
                        
                        // Cek apakah file telah diunggah dengan benar
                        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                            // Persiapan query INSERT
                            $query = $conn->prepare("INSERT INTO tbl_destinasi (judul, deskripsi, foto, waktu_upload, kategori, alamat, kontak) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            // Binding parameter
                            $query->bind_param("sssssss", $judul, $deskripsi, $namaFile, $waktu_upload, $kategori, $alamat, $kontak);
                            // Eksekusi query
                            $result = $query->execute();
                            
                            // Periksa hasil eksekusi query
                            if ($result) {
                                // Berhasil disimpan, arahkan ke halaman yang sesuai
                                header("Location: dataDestinasi.php");
                                exit();
                            } else {
                                // Gagal menyimpan data, tampilkan pesan kesalahan
                                echo "Gagal menyimpan data: " . $query->error;
                            }
                            
                            // Tutup statement
                            $query->close();
                        } else {
                            // Gagal mengunggah gambar, tampilkan pesan kesalahan
                            echo "Gagal mengunggah gambar.";
                        }
                    }
                }elseif(isset($_POST['upPengumuman'])) {
                    $id = $_GET['id'];
                    $judul = $_POST['judul'];
                    $deskripsi = $_POST['deskripsi'];
                    $waktu_upload_input = $_POST['waktu_upload'];
                    $kategori = $_POST['kategori'];
                    $alamat = $_POST['alamat'];
                    $kontak = $_POST['kontak'];
                    
                    // Ubah format tanggal ke "Y-m-d"
                    $waktu_upload = date('Y-m-d', strtotime($waktu_upload_input));
                    
                    if ($_FILES['foto']['name'] != '') {
                        // Lokasi folder untuk menyimpan gambar
                        $uploadDir = 'file/images/pengumuman/';
                        
                        // Generate nama file unik
                        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                        $targetPath = $uploadDir . $namaFile;
                        
                        // Pindahkan file gambar yang diunggah
                        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                            // Persiapan query UPDATE
                            $queryUpdate = $conn->prepare("UPDATE tbl_destinasi SET judul=?, deskripsi=?, foto=?, waktu_upload=?, kategori=?, alamat=?, kontak=? WHERE id=?");
                            // Binding parameter
                            $queryUpdate->bind_param("sssssssi", $judul, $deskripsi, $namaFile, $waktu_upload, $kategori, $alamat, $kontak, $id);
                            // Eksekusi query
                            $result = $queryUpdate->execute();
                            
                            // Periksa hasil eksekusi query
                            if ($result) {
                                // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                                header("Location: dataDestinasi.php");
                                exit();
                            } else {
                                echo "Gagal mengupdate data: " . $queryUpdate->error;
                            }
                            
                            // Tutup statement
                            $queryUpdate->close();
                        } else {
                            echo "Gagal mengunggah gambar.";
                        }
                    } else {
                        // Update data pengumuman tanpa mengubah gambar
                        $queryUpdate = $conn->prepare("UPDATE tbl_destinasi SET judul=?, deskripsi=?, waktu_upload=?, kategori=?, alamat=?, kontak=? WHERE id=?");
                        // Binding parameter
                        $queryUpdate->bind_param("ssssssi", $judul, $deskripsi, $waktu_upload, $kategori, $alamat, $kontak, $id);
                        // Eksekusi query
                        $result = $queryUpdate->execute();
                        
                        // Periksa hasil eksekusi query
                        if ($result) {
                            // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                            header("Location: dataDestinasi.php");
                            exit();
                        } else {
                            echo "Gagal mengupdate data: " . $queryUpdate->error;
                        }
                        
                        // Tutup statement
                        $queryUpdate->close();
                    }
                }elseif(isset($_POST['delPengumuman'])) {
                $id = $_POST['delPengumuman'];
            
                // Query untuk mengambil nama file foto berita yang akan dihapus
                $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_destinasi WHERE id='$id'");
                $dataFoto = mysqli_fetch_assoc($queryFoto);
            
                // Hapus berita dari database
                $queryDelete = mysqli_query($conn, "DELETE FROM tbl_destinasi WHERE id='$id'");
            
                if ($queryDelete) {
                    // Hapus juga file gambar dari server jika ada
                    if (!empty($dataFoto['foto'])) {
                        $fileToDelete = 'file/images/pengumuman/' . $dataFoto['foto'];
                        if (file_exists($fileToDelete)) {
                            unlink($fileToDelete);
                        }
                    }
            
                    // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                    header("Location: dataDestinasi.php");
                    exit();
                } else {
                    echo "Gagal menghapus data.";
                }
            }elseif(isset($_POST['addPD'])) {
                // Pastikan ada file yang diunggah
                if (isset($_FILES['foto'])) {
                    $nama = $_POST['nama'];
                    $jabatan = $_POST['jabatan'];

                    
                    // Lokasi folder untuk menyimpan gambar
                    $uploadDir = 'file/images/perangkatDesa/';
            
                    // Generate nama file unik untuk menghindari tumpang tindih
                    $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                    $targetPath = $uploadDir . $namaFile;
            
                    // Cek apakah file telah diunggah dengan benar
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                        // Lakukan query untuk menyimpan data ke dalam tabel berita
                        $query = mysqli_query($conn, "INSERT INTO tbl_perangkat_desa (nama, jabatan, foto) VALUES ('$nama', '$jabatan', '$namaFile')");
            
                        if ($query) {
                            // Berhasil disimpan, arahkan ke halaman yang sesuai
                            header("Location: dataPD.php");
                            exit();
                        } else {
                            // Gagal menyimpan data, tampilkan pesan kesalahan
                            echo "Gagal menyimpan data.";
                        }
                    } else {
                        // Gagal mengunggah gambar, tampilkan pesan kesalahan
                        echo "Gagal mengunggah gambar.";
                    }
                }
            }elseif(isset($_POST['upPD'])) {
                $id = $_GET['id'];
                $nama = $_POST['nama'];
                $jabatan = $_POST['jabatan'];

                // Ubah format tanggal ke "Y-m-d"
               if ($_FILES['foto']['name'] != '') {
                    // Lokasi folder untuk menyimpan gambar
                    $uploadDir = 'file/images/perangkatDesa/';
            
                    // Generate nama file unik
                    $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
                    $targetPath = $uploadDir . $namaFile;
            
                    // Pindahkan file gambar yang diunggah
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                        // Update data berita dengan gambar baru
                        $queryUpdate = mysqli_query($conn, "UPDATE tbl_perangkat_desa SET nama='$nama', jabatan='$jabatan', foto='$namaFile' WHERE id='$id'");
            
                        if ($queryUpdate) {
                            // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                            header("Location: dataPD.php");
                            exit();
                        } else {
                            echo "Gagal mengupdate data.";
                        }
                    } else {
                        echo "Gagal mengunggah gambar.";
                    }
                } else {
                    // Update data berita tanpa mengubah gambar
                    $queryUpdate = mysqli_query($conn, "UPDATE tbl_perangkat_desa SET nama='$nama', jabatan='$jabatan' WHERE id='$id'");
            
                    if ($queryUpdate) {
                        // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                        header("Location: dataPD.php");
                        exit();
                    } else {
                        echo "Gagal mengupdate data.";
                    }
                }
            }elseif(isset($_POST['delPD'])) {
              $id = $_POST['delPD'];
          
              // Query untuk mengambil nama file foto berita yang akan dihapus
              $queryFoto = mysqli_query($conn, "SELECT foto FROM tbl_perangkat_desa WHERE id='$id'");
              $dataFoto = mysqli_fetch_assoc($queryFoto);
          
              // Hapus berita dari database
              $queryDelete = mysqli_query($conn, "DELETE FROM tbl_perangkat_desa WHERE id='$id'");
          
              if ($queryDelete) {
                  // Hapus juga file gambar dari server jika ada
                  if (!empty($dataFoto['foto'])) {
                      $fileToDelete = 'file/images/perangkatDesa/' . $dataFoto['foto'];
                      if (file_exists($fileToDelete)) {
                          unlink($fileToDelete);
                      }
                  }
          
                  // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
                  header("Location: dataPD.php");
                  exit();
              } else {
                  echo "Gagal menghapus data.";
              }
          }

// ---------------------------------------------------------------- FUNCTION WEB BUDAYA TTE----------------------------------------------------------------
elseif(isset($_POST['addFF'])) {
    // Pastikan ada file yang diunggah
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];
    $habitat = $_POST['habitat'];
    
    // Lokasi folder untuk menyimpan gambar
    $uploadDir = 'file/images/flora_fauna/';
    
    // Generate nama file unik untuk menghindari tumpang tindih
    $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
    $targetPath = $uploadDir . $namaFile;
    
    // Cek apakah file telah diunggah dengan benar
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
        // Persiapan query INSERT
        $query = $conn->prepare("INSERT INTO flora_fauna (nama, jenis, deskripsi, habitat, gambar) VALUES (?, ?, ?, ?, ?)");
        
        // Binding parameter
        $query->bind_param("sssss", $nama, $jenis, $deskripsi, $habitat, $namaFile);
        
        // Eksekusi query
        $result = $query->execute();
        
        // Periksa hasil eksekusi query
        if ($result) {
            // Berhasil disimpan, arahkan ke halaman yang sesuai
            header("Location: flora_fauna.php");
            exit();
        } else {
            // Gagal menyimpan data, tampilkan pesan kesalahan
            echo "Gagal menyimpan data: " . $query->error;
        }
        
        // Tutup statement
        $query->close();
    } else {
        // Gagal mengunggah gambar, tampilkan pesan kesalahan
        echo "Gagal mengunggah gambar.";
    }
}elseif(isset($_POST['upFF'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];
    $habitat = $_POST['habitat'];

    if ($_FILES['foto']['name'] != '') {
        // Lokasi folder untuk menyimpan gambar
        $uploadDir = 'file/images/flora_fauna/';

        // Generate nama file unik
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        // Pindahkan file gambar yang diunggah
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Persiapan query UPDATE
            $queryUpdate = $conn->prepare("UPDATE flora_fauna SET nama=?, jenis=?, deskripsi=?, habitat=?, gambar=? WHERE id=?");
            // Binding parameter
            $queryUpdate->bind_param("sssssi", $nama, $jenis, $deskripsi, $habitat, $namaFile, $id);
            // Eksekusi query
            $result = $queryUpdate->execute();

            // Periksa hasil eksekusi query
            if ($result) {
                // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
                header("Location: flora_fauna.php");
                exit();
            } else {
                echo "Gagal mengupdate data: " . $queryUpdate->error;
            }

            // Tutup statement
            $queryUpdate->close();
        } else {
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Update data flora/fauna tanpa mengubah gambar
        $queryUpdate = $conn->prepare("UPDATE flora_fauna SET nama=?, jenis=?, deskripsi=?, habitat=? WHERE id=?");
        // Binding parameter
        $queryUpdate->bind_param("ssssi", $nama, $jenis, $deskripsi, $habitat, $id);
        // Eksekusi query
        $result = $queryUpdate->execute();

        // Periksa hasil eksekusi query
        if ($result) {
            // Berhasil disimpan, arahkan kembali ke halaman yang sesuai
            header("Location: flora_fauna.php");
            exit();
        } else {
            echo "Gagal mengupdate data: " . $queryUpdate->error;
        }

        // Tutup statement
        $queryUpdate->close();
    }
}elseif(isset($_POST['delFF'])) {
$id = $_POST['delFF'];

// Query untuk mengambil nama file foto berita yang akan dihapus
$queryFoto = mysqli_query($conn, "SELECT gambar FROM flora_fauna WHERE id='$id'");
$dataFoto = mysqli_fetch_assoc($queryFoto);

// Hapus berita dari database
$queryDelete = mysqli_query($conn, "DELETE FROM flora_fauna WHERE id='$id'");

if ($queryDelete) {
    // Hapus juga file gambar dari server jika ada
    if (!empty($dataFoto['gambar'])) {
        $fileToDelete = 'file/images/flora_fauna/' . $dataFoto['gambar'];
        if (file_exists($fileToDelete)) {
            unlink($fileToDelete);
        }
    }

    // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
    header("Location: flora_fauna.php");
    exit();
} else {
    echo "Gagal menghapus data.";
}
}

// GEOGRAFI
elseif(isset($_POST['addGeografi'])) {
    // Pastikan ada file yang diunggah
    $nama_tempat = $_POST['nama_tempat'];
    $jenis_tempat = $_POST['jenis_tempat'];
    $deskripsi = $_POST['deskripsi'];
    $koordinat = $_POST['koordinat'];
    $luas = $_POST['luas'];
    $tinggi = $_POST['tinggi'];
    $populasi = $_POST['populasi'];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['foto']['name'] != '') {
        // Lokasi folder untuk menyimpan gambar
        $uploadDir = 'file/images/geografi/';

        // Generate nama file unik untuk menghindari tumpang tindih
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        // Pindahkan file gambar yang diunggah
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Persiapan query INSERT
            $query = $conn->prepare("INSERT INTO geografi (nama_tempat, jenis_tempat, deskripsi, koordinat, gambar, luas, tinggi, populasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            // Binding parameter
            $query->bind_param("sssssdid", $nama_tempat, $jenis_tempat, $deskripsi, $koordinat, $namaFile, $luas, $tinggi, $populasi);

            // Eksekusi query
            $result = $query->execute();

            // Periksa hasil eksekusi query
            if ($result) {
                // Berhasil disimpan, arahkan ke halaman yang sesuai
                header("Location: geografi.php");
                exit();
            } else {
                // Gagal menyimpan data, tampilkan pesan kesalahan
                echo "Gagal menyimpan data: " . $query->error;
            }

            // Tutup statement
            $query->close();
        } else {
            // Gagal mengunggah gambar, tampilkan pesan kesalahan
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Gagal mengunggah gambar, tampilkan pesan kesalahan
        echo "Gambar tidak ditemukan.";
    }
}elseif(isset($_POST['upGeografi'])) {
    $id = $_GET['id'];
    $nama_tempat = $_POST['nama_tempat'];
    $jenis_tempat = $_POST['jenis_tempat'];
    $deskripsi = $_POST['deskripsi'];
    $koordinat = $_POST['koordinat'];
    $luas = $_POST['luas'];
    $tinggi = $_POST['tinggi'];
    $populasi = $_POST['populasi'];

    if ($_FILES['foto']['name'] != '') {
        $uploadDir = 'file/images/geografi/';
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            $queryUpdate = $conn->prepare("UPDATE geografi SET nama_tempat=?, jenis_tempat=?, deskripsi=?, koordinat=?, gambar=?, luas=?, tinggi=?, populasi=? WHERE id=?");
            $queryUpdate->bind_param("sssssdidi", $nama_tempat, $jenis_tempat, $deskripsi, $koordinat, $namaFile, $luas, $tinggi, $populasi, $id);
            $result = $queryUpdate->execute();

            if ($result) {
                header("Location: geografi.php");
                exit();
            } else {
                echo "Gagal mengupdate data: " . $queryUpdate->error;
            }

            $queryUpdate->close();
        } else {
            echo "Gagal mengunggah gambar.";
        }
    } else {
        $queryUpdate = $conn->prepare("UPDATE geografi SET nama_tempat=?, jenis_tempat=?, deskripsi=?, koordinat=?, luas=?, tinggi=?, populasi=? WHERE id=?");
        $queryUpdate->bind_param("sssssdii", $nama_tempat, $jenis_tempat, $deskripsi, $koordinat, $luas, $tinggi, $populasi, $id);
        $result = $queryUpdate->execute();

        if ($result) {
            header("Location: geografi.php");
            exit();
        } else {
            echo "Gagal mengupdate data: " . $queryUpdate->error;
        }

        $queryUpdate->close();
    }
}elseif(isset($_POST['delGeografi'])) {
$id = $_POST['delGeografi'];

// Query untuk mengambil nama file foto berita yang akan dihapus
$queryFoto = mysqli_query($conn, "SELECT gambar FROM geografi WHERE id='$id'");
$dataFoto = mysqli_fetch_assoc($queryFoto);

// Hapus berita dari database
$queryDelete = mysqli_query($conn, "DELETE FROM geografi WHERE id='$id'");

if ($queryDelete) {
    // Hapus juga file gambar dari server jika ada
    if (!empty($dataFoto['gambar'])) {
        $fileToDelete = 'file/images/geografi/' . $dataFoto['gambar'];
        if (file_exists($fileToDelete)) {
            unlink($fileToDelete);
        }
    }

    // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
    header("Location: geografi.php");
    exit();
} else {
    echo "Gagal menghapus data.";
}
}


// TRADISI

if (isset($_POST['addTradisi'])) {
    $nama_tradisi = $_POST['nama_tradisi'];
    $deskripsi = $_POST['deskripsi'];
    $asal_daerah = $_POST['asal_daerah'];
    $waktu_pelaksanaan = $_POST['waktu_pelaksanaan'];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['foto']['name'] != '') {
        // Lokasi folder untuk menyimpan gambar
        $uploadDir = 'file/images/tradisi/';

        // Generate nama file unik untuk menghindari tumpang tindih
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        // Pindahkan file gambar yang diunggah
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Persiapan query INSERT
            $query = $conn->prepare("INSERT INTO tradisi (nama_tradisi, deskripsi, asal_daerah, waktu_pelaksanaan, gambar) VALUES (?, ?, ?, ?, ?)");

            // Binding parameter
            $query->bind_param("sssss", $nama_tradisi, $deskripsi, $asal_daerah, $waktu_pelaksanaan, $namaFile);

            // Eksekusi query
            $result = $query->execute();

            // Periksa hasil eksekusi query
            if ($result) {
                // Berhasil disimpan, arahkan ke halaman yang sesuai
                header("Location: tradisi.php");
                exit();
            } else {
                // Gagal menyimpan data, tampilkan pesan kesalahan
                echo "Gagal menyimpan data: " . $query->error;
            }

            // Tutup statement
            $query->close();
        } else {
            // Gagal mengunggah gambar, tampilkan pesan kesalahan
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Gambar tidak ditemukan, tampilkan pesan kesalahan
        echo "Gambar tidak ditemukan.";
    }
} elseif (isset($_POST['upTradisi'])) {
    $id = $_GET['id'];
    $nama_tradisi = $_POST['nama_tradisi'];
    $deskripsi = $_POST['deskripsi'];
    $asal_daerah = $_POST['asal_daerah'];
    $waktu_pelaksanaan = $_POST['waktu_pelaksanaan'];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['gambar']['name'] != '') {
        $uploadDir = 'file/images/tradisi/';
        $namaFile = uniqid() . '_' . $_FILES['gambar']['name'];
        $targetPath = $uploadDir . $namaFile;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            $queryUpdate = $conn->prepare("UPDATE tradisi SET nama_tradisi=?, deskripsi=?, asal_daerah=?, waktu_pelaksanaan=?, gambar=? WHERE id=?");
            $queryUpdate->bind_param("sssssi", $nama_tradisi, $deskripsi, $asal_daerah, $waktu_pelaksanaan, $namaFile, $id);
            $result = $queryUpdate->execute();

            if ($result) {
                header("Location: tradisi.php");
                exit();
            } else {
                echo "Gagal mengupdate data: " . $queryUpdate->error;
            }

            $queryUpdate->close();
        } else {
            echo "Gagal mengunggah gambar.";
        }
    } else {
        $queryUpdate = $conn->prepare("UPDATE tradisi SET nama_tradisi=?, deskripsi=?, asal_daerah=?, waktu_pelaksanaan=? WHERE id=?");
        $queryUpdate->bind_param("ssssi", $nama_tradisi, $deskripsi, $asal_daerah, $waktu_pelaksanaan, $id);
        $result = $queryUpdate->execute();

        if ($result) {
            header("Location: tradisi.php");
            exit();
        } else {
            echo "Gagal mengupdate data: " . $queryUpdate->error;
        }

        $queryUpdate->close();
    }
} elseif (isset($_POST['delTradisi'])) {
    $id = $_POST['delTradisi'];

    // Query untuk mengambil nama file gambar tradisi yang akan dihapus
    $queryFoto = mysqli_query($conn, "SELECT gambar FROM tradisi WHERE id='$id'");
    $dataFoto = mysqli_fetch_assoc($queryFoto);

    // Hapus tradisi dari database
    $queryDelete = mysqli_query($conn, "DELETE FROM tradisi WHERE id='$id'");

    if ($queryDelete) {
        // Hapus juga file gambar dari server jika ada
        if (!empty($dataFoto['gambar'])) {
            $fileToDelete = 'file/images/tradisi/' . $dataFoto['gambar'];
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }

        // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
        header("Location: tradisi.php");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
}

if (isset($_POST['addEvents'])) {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $description = $_POST['description'];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['foto']['name'] != '') {
        // Lokasi folder untuk menyimpan gambar
        $uploadDir = 'file/images/events/';

        // Generate nama file unik untuk menghindari tumpang tindih
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        // Pindahkan file gambar yang diunggah
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Persiapan query INSERT
            $query = $conn->prepare("INSERT INTO events (title, start, end, description, gambar) VALUES (?, ?, ?, ?, ?)");

            // Binding parameter
            $query->bind_param("sssss", $title, $start, $end, $description, $namaFile);

            // Eksekusi query
            $result = $query->execute();

            // Periksa hasil eksekusi query
            if ($result) {
                // Berhasil disimpan, arahkan ke halaman yang sesuai
                header("Location: events.php");
                exit();
            } else {
                // Gagal menyimpan data, tampilkan pesan kesalahan
                echo "Gagal menyimpan data: " . $query->error;
            }

            // Tutup statement
            $query->close();
        } else {
            // Gagal mengunggah gambar, tampilkan pesan kesalahan
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Gambar tidak ditemukan, tampilkan pesan kesalahan
        echo "Gambar tidak ditemukan.";
    }
}

if (isset($_POST['upEvents'])) {
    $id = $_GET['id']; // Mendapatkan ID event dari form

    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $description = $_POST['description'];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['foto']['name'] != '') {
        $uploadDir = 'file/images/events/';
        $namaFile = uniqid() . '_' . $_FILES['foto']['name'];
        $targetPath = $uploadDir . $namaFile;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Update dengan gambar baru
            $queryUpdate = $conn->prepare("UPDATE events SET title=?, start=?, end=?, description=?, gambar=? WHERE id=?");
            $queryUpdate->bind_param("sssssi", $title, $start, $end, $description, $namaFile, $id);
        } else {
            echo "Gagal mengunggah gambar.";
            exit(); // Hentikan proses jika gagal mengunggah gambar
        }
    } else {
        // Update tanpa mengubah gambar
        $queryUpdate = $conn->prepare("UPDATE events SET title=?, start=?, end=?, description=? WHERE id=?");
        $queryUpdate->bind_param("ssssi", $title, $start, $end, $description, $id);
    }

    // Eksekusi query update
    $result = $queryUpdate->execute();

    // Periksa hasil eksekusi query
    if ($result) {
        // Berhasil diupdate, arahkan ke halaman yang sesuai
        header("Location: events.php");
        exit();
    } else {
        // Gagal mengupdate data, tampilkan pesan kesalahan
        echo "Gagal mengupdate data: " . $queryUpdate->error;
    }

    // Tutup statement
    $queryUpdate->close();
}

if (isset($_POST['delEvent'])) {
    $id = $_POST['id']; // Mendapatkan ID event dari form

    // Query untuk mengambil nama file gambar event yang akan dihapus
    $queryFoto = mysqli_query($conn, "SELECT gambar FROM events WHERE id='$id'");
    $dataFoto = mysqli_fetch_assoc($queryFoto);

    // Hapus event dari database
    $queryDelete = mysqli_query($conn, "DELETE FROM events WHERE id='$id'");

    if ($queryDelete) {
        // Hapus juga file gambar dari server jika ada
        if (!empty($dataFoto['gambar'])) {
            $fileToDelete = 'file/images/events/' . $dataFoto['gambar'];
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }

        // Berhasil dihapus, arahkan kembali ke halaman yang sesuai
        header("Location: events.php");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
}


?>
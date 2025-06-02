<?php
include "./config/cek-sesi.php";
include "../config/koneksi.php";
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query);

// Tangkap kelas_id dari GET jika ada
$kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;

// Ambil data kelas untuk dropdown
$kelas_result = mysqli_query($conn, "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas");

// Query jadwal ujian, filter kalau kelas_id dipilih
$sql = "SELECT j.*, k.nama_kelas, m.nama_mapel, u.nama AS nama_guru, r.nama_ruangan 
        FROM jadwal_ujian j
        JOIN kelas k ON j.kelas_id = k.id_kelas
        JOIN mapel m ON j.mapel_id = m.id_mapel
        JOIN guru g ON j.guru_pengawas_id = g.id
        JOIN users u ON g.user_id = u.id
        JOIN ruangan r ON j.ruangan_id = r.id_ruangan";

if ($kelas_id > 0) {
    $sql .= " WHERE j.kelas_id = $kelas_id";
}

$sql .= " ORDER BY j.tanggal_ujian DESC, j.jam_mulai DESC";

$jadwal_result = mysqli_query($conn, $sql);
?>
<?php require_once 'template/header.php';?>
<?php require_once 'template/sidebar.php';?>

<main>
    <section class="section">
        <div class="container-fluid">

            <div class="title-wrapper pt-80">
                <!-- ... breadcrumb dll ... -->
            </div>

            <section class="section">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card-style mb-30">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Daftar Jadwal Ujian</h6>
                                    <div>
                                        <a href="formJadwalUjian.php?tambah=true" class="main-btn primary-btn btn-hover btn-sm">+ Tambah Baru</a>
                                        <a href="cetak.php?cetak_ujian=true&kelas_id=<?= $kelas_id ?>" class="btn btn-sm btn-secondary" target="_blank" title="Cetak PDF">
                                           Cetak <i class="fas fa-print"></i>
                                        </a>

                                        <form method="GET" style="display:inline-block; margin-left: 10px;">
                                            <select name="kelas_id" onchange="this.form.submit()">
                                                <option value="0">-- Pilih Kelas --</option>
                                                <?php while ($k = mysqli_fetch_assoc($kelas_result)) : ?>
                                                    <option value="<?= $k['id_kelas'] ?>" <?= ($kelas_id == $k['id_kelas']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($k['nama_kelas']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </form>

                                    </div>
                                </div>
                                <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Ujian</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Kelas</th>
                                                <th>Tanggal</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Selesai</th>
                                                <th>Ruangan</th>
                                                <th>Pengawas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            if (mysqli_num_rows($jadwal_result) > 0):
                                                while ($row = mysqli_fetch_assoc($jadwal_result)):
                                            ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= htmlspecialchars($row['nama_ujian']) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                                        <td><?= date('d-m-Y', strtotime($row['tanggal_ujian'])) ?></td>
                                                        <td><?= date('H:i', strtotime($row['jam_mulai'])) ?></td>
                                                        <td><?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_ruangan']) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                                                        <td>
                                                            <a href="formJadwalUjian.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                                                <i class="lni lni-pencil"></i>
                                                            </a>
                                                            <a href="formJadwalUjian.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                endwhile;
                                            else:
                                            ?>
                                                <tr><td colspan="10" class="text-center">Belum ada data.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Form Tambah/Edit Jadwal Ujian tetap seperti kode kamu -->

                </div>
            </section>
        </div>
    </section>
</main>

<?php include './template/footer.php'; ?>

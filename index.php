<?php
include 'config/koneksi.php';
include 'partials/header.php';


// Ambil data kegiatan terbaru
$querySemuaKegiatan = mysqli_query($conn, "SELECT * FROM kegiatan");

// Mendapatkan tiga berita terbaru untuk carousel
$kegiatanCarousel = [];
$counter = 0;

while ($dataKegiatan = mysqli_fetch_assoc($querySemuaKegiatan)) {
    $kegiatanCarousel[] = $dataKegiatan;
    $counter++;

    if ($counter === 3) {
        break; // Keluar dari loop setelah mendapatkan 3 berita terbaru
    }
}

// Mengambil sisa berita yang akan ditampilkan di berita lainnya
$kegiatanLainnya = [];

while ($dataKegiatan = mysqli_fetch_assoc($querySemuaKegiatan)) {
    $kegiatanLainnya[] = $dataKegiatan;
}
// Ambil data ujian terbaru
$ujian = mysqli_query($conn, "SELECT * FROM jadwal_ujian ORDER BY tanggal_ujian DESC LIMIT 5");
?>

<?php
include 'partials/slider.php';
?>

<section id="ternate" class="wow animate__fadeInUp">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 col-md-6 sm-margin-30px-bottom wow animate__fadeIn" data-wow-delay="0.2s">
                <img class="w-100" src="assets/img/discover.jpg" alt="" data-no-retina="">
            </div>
            <div class="col-12 col-lg-6 col-md-6 text-center text-md-start md-padding-six-half-left sm-padding-15px-left wow animate__fadeIn" data-wow-delay="0.4s">
                <h4 class="text-uppercase alt-font text-extra-dark-gray margin w-95 d-inline-block md-d-block mb-0 lg-w-90 md-w-50 xs-w-100">SI-JUKES</h4>
                <span class="separator-line-horrizontal-medium-light2 idep-bg-hitam d-table w-100px text-left margin-20px-tb sm-margin-20px-tb"></span>
                <p>
                (Sistem Informasi Jadwal Ujian dan Kegiatan Sekolah) merupakan platform digital resmi milik 
                <strong>SMK Negeri 5 Tikep</strong> yang dibangun untuk meningkatkan efisiensi dalam penyampaian informasi akademik dan non-akademik. 
                Sistem ini hadir sebagai solusi modern untuk mempermudah siswa, guru, dan seluruh civitas sekolah dalam mengakses informasi terkait 
                <em>jadwal ujian</em>, <em>kegiatan sekolah</em>, serta agenda penting lainnya secara cepat, akurat, dan real-time.</p>
            
            </div>
        </div>
    </div>
</section>


        <!-- <section class="section">
        <div class="container">
        <div class="row text-center mb-4">
            <div class="col-md-6">
                <h5>Total Ujian</h5>
                <div class="display-6 text-primary">
                    <?php
                    $hitung_ujian = mysqli_query($conn, "SELECT COUNT(*) as total FROM jadwal_ujian");
                    $data_ujian = mysqli_fetch_assoc($hitung_ujian);
                    echo $data_ujian['total'];
                    ?>
                </div>
            </div>

            <div class="col-md-6">
                <h5>Total Kegiatan</h5>
                <div class="display-6 text-success">
                    <?php
                    $hitung_kegiatan = mysqli_query($conn, "SELECT COUNT(*) as total FROM kegiatan");
                    $data_kegiatan = mysqli_fetch_assoc($hitung_kegiatan);
                    echo $data_kegiatan['total'];
                    ?>
                </div>
            </div>
        </div>
        </div>
        </section> -->


        <section class="wow animate__fadeIn mt-5">
            <div class="container">
       

                <div class="row justify-content-center">
                        <div class="col-12 col-xl-5 col-md-6 margin-five-bottom md-margin-40px-bottom sm-margin-30px-bottom text-center">
                            <h5 class="alt-font text-extra-dark-gray font-weight-600 text-uppercase m-0">Jadwal Ujian</h5>
                            <span class="separator-line-horrizontal-medium-light2 idep-bg-hitam d-table w-100px mx-auto margin-20px-top sm-margin-20px-tb"></span>
                        </div>
                    </div>   
                                 
                    <div class="search-box row justify-content-left">
                        <div class="col-md-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        
                    </div>
                <table class="table table-striped margin-20px-top" id="tableUjian">
                    <thead>
                        <tr>
                            <th>Nama Ujian</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($ujian)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_ujian']) ?></td>
                                <td><?= htmlspecialchars($row['kelas']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_ujian'])) ?></td>
                                <td><?= $row['jam_ujian'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
                </section>


            <!-- start blog section -->
         <!-- Tambahkan ini di dalam file HTML kamu --><!-- Tambahkan ini di HTML kamu -->
         <section class="bg-light wow animate__fadeInUp padding-top-100px padding-bottom-100px">
<div id="app" class="bg-light mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-5 col-md-6 text-center mb-5">
                <h5 class="alt-font text-extra-dark-gray font-weight-600 text-uppercase m-0">Kegiatan Terbaru</h5>
                <span class="separator-line-horrizontal-medium-light2 idep-bg-hitam d-table w-100px mx-auto mt-3"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-12 blog-content">
                <ul class="row">
                    <li class="col-lg-4 col-md-6 col-sm-12 mb-4"
                        v-for="(kegiatan, index) in kegiatans"
                        :key="kegiatan.id">
                        <div class="blog-post bg-light-gray">
                            <div class="blog-post-images overflow-hidden position-relative">
                                <a :href="'detailArtikel.php?id=' + kegiatan.id">
                                    <img :src="'./login/admin/' + kegiatan.gambar" class="img-fluid" :alt="kegiatan.judul">
                                    <!-- <div class="blog-hover-icon"><span class="text-extra-large font-weight-300">+</span></div> -->
                                </a>
                            </div>
                            <div class="bg-white post-details p-4">
                                <a :href="'detailArtikel.php?id=' + kegiatan.id"
                                   class="alt-font post-title text-medium text-extra-dark-gray d-block mb-3">
                                    {{ kegiatan.judul.length > 150 ? kegiatan.judul.slice(0, 150) + '...' : kegiatan.judul }}
                                </a>
                                <div class="separator-line-horrizontal-full bg-dark-gray my-3"></div>
                                <div class="author text-uppercase text-extra-small text-medium-gray">
                                    by <a :href="'detailArtikel.php?id=' + kegiatan.id" class="text-medium-gray">Admin</a>
                                    &nbsp;&nbsp;|&nbsp;&nbsp;{{ kegiatan.created_at }}
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-12 text-center" v-if="currentPage < lastPage">
                <button class="theme-btn mt-3" @click="loadMore">
                    <i class="la la-refresh mr-1"></i>Load More
                </button>
                <p class="font-size-13 pt-2">Showing {{ kegiatans.length }} of {{ total }} kegiatan</p>
            </div>
        </div>
    </div>
</div>
</section>

<!-- Tambahkan Vue & Axios -->
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
new Vue({
    el: '#app',
    data: {
        kegiatans: [],
        currentPage: 1,
        lastPage: 1,
        total: 0,
    },
    mounted() {
        this.fetchKegiatan();
    },
    methods: {
        fetchKegiatan() {
            axios.get(`api.php?page=${this.currentPage}`)
                .then(response => {
                    const res = response.data;
                    this.kegiatans = this.kegiatans.concat(res.data);
                    this.currentPage = res.current_page;
                    this.lastPage = res.last_page;
                    this.total = res.total;
                })
                .catch(error => {
                    console.error('Gagal mengambil data:', error);
                });
        },
        loadMore() {
            this.currentPage++;
            this.fetchKegiatan();
        }
    }
});
</script>


            <!-- end blog section -->


    <script>
        // Filter tabel berdasarkan input
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rowsUjian = document.querySelectorAll('#tableUjian tbody tr');
            const rowsKegiatan = document.querySelectorAll('#tableKegiatan tbody tr');

            [rowsUjian, rowsKegiatan].forEach(rows => {
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        });


    </script>
</body>
</html>




       <?php include 'partials/footer.php'; ?>
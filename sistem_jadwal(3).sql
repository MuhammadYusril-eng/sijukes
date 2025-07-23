-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 23 Jul 2025 pada 13.11
-- Versi server: 5.7.39
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_jadwal`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_log_aktivitas` (IN `p_user_id` INT, IN `p_aktivitas` TEXT, IN `p_ip_address` VARCHAR(50), IN `p_user_agent` TEXT)   BEGIN
    INSERT INTO log_aktivitas (user_id, aktivitas, ip_address, user_agent)
    VALUES (p_user_id, p_aktivitas, p_ip_address, p_user_agent);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `jenis_kelamin`, `alamat`, `no_telp`, `created_at`, `updated_at`) VALUES
(6, 31, '123', 'L', '', '138109', '2025-06-23 04:32:42', '2025-07-18 12:46:54'),
(9, 141, '1234', 'P', '', '', '2025-07-18 13:18:24', '2025-07-18 14:59:26'),
(10, 145, '12345', 'P', '', '', '2025-07-18 14:14:29', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `guru_mapel`
--

INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`, `created_at`) VALUES
(18, 6, 3, '2025-07-18 12:46:54'),
(21, 10, 2, '2025-07-18 14:14:29'),
(22, 9, 5, '2025-07-18 14:59:26'),
(23, 9, 2, '2025-07-18 14:59:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `id` int(11) NOT NULL,
  `nama_ujian` varchar(100) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_pengawas_id` int(11) NOT NULL,
  `tanggal_ujian` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan_id` int(11) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jadwal_ujian`
--

INSERT INTO `jadwal_ujian` (`id`, `nama_ujian`, `mapel_id`, `kelas_id`, `guru_pengawas_id`, `tanggal_ujian`, `jam_mulai`, `jam_selesai`, `ruangan_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, 'UTS', 5, 10, 9, '2025-07-18', '08:00:00', '10:00:00', 1, '', '2025-07-18 13:06:00', '2025-07-18 13:22:00'),
(8, 'uas', 5, 8, 6, '2025-07-21', '08:00:00', '10:00:00', 1, '', '2025-07-18 13:12:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `kode_jurusan` varchar(20) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `kode_jurusan`, `nama_jurusan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'IPS', 'Ilmu Pengetahuan Sosial', 'Jurusan untuk bidang ilmu sosial', '2025-06-18 01:00:00', '2025-06-23 05:26:38'),
(2, 'IPA', 'Ilmu Pengetahuan Alam', 'Jurusan untuk bidang ilmu alam', '2025-06-18 01:00:00', NULL),
(3, 'TKJT', 'Teknik Komputer dan Jaringan', 'Jurusan untuk bidang teknologi komputer', '2025-06-18 01:00:00', '2025-06-23 05:25:20'),
(4, 'TKJ', 'Teknik Konputer dan Jaringan', 'dvef', '2025-07-18 12:35:20', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `penanggung_jawab_id` int(11) DEFAULT NULL,
  `ditujukan_untuk` enum('siswa','guru','semua') NOT NULL DEFAULT 'semua',
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `judul`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `jam_mulai`, `jam_selesai`, `lokasi`, `penanggung_jawab_id`, `ditujukan_untuk`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Bakti. sosial', 'kajjke', '2025-05-30', '2025-05-30', '01:00:00', '20:00:00', 'Sekolah', NULL, 'semua', 'file/images/kegiatan/1748693161_Photo on 20-06-24 at 15.08.jpg', '2025-05-31 12:06:01', '2025-06-09 09:32:46'),
(2, 'ESKUL', 'ajdikhd', '2025-06-17', '2025-06-24', '09:00:00', '13:00:00', 'SEKOLAH', 6, 'siswa', 'file/images/kegiatan/1751193798_WhatsApp Image 2025-05-18 at 11.11.07.jpeg', '2025-06-17 12:17:15', '2025-06-29 10:43:53'),
(3, 'Rohis', 'jshdcjhs', '2025-07-18', '2025-07-21', '08:00:00', '10:00:00', 'Sekolah', 6, 'semua', 'file/images/kegiatan/1752842254_photo_2025-03-03 19.44.49.jpeg', '2025-07-18 12:37:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `kompetensi_keahlian` varchar(100) NOT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`, `jurusan_id`, `wali_kelas_id`, `created_at`) VALUES
(8, 'TKJT X', 'Keamanan Jaringan', NULL, 6, '2025-06-23 05:37:39'),
(9, 'TKJT XI', 'Dasar komputer', NULL, 6, '2025-06-23 05:53:41'),
(10, 'TKJ XI', 'Teknik komputer dan Jaringan', NULL, 6, '2025-07-18 12:27:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `aktivitas` text NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `aktivitas`, `ip_address`, `user_agent`, `waktu`) VALUES
(1, 1, 'Test aktivitas', '127.0.0.1', 'Test Agent', '2025-05-31 12:23:14'),
(2, 31, 'Login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:139.0) Gecko/20100101 Firefox/139.0', '2025-06-23 04:50:33'),
(3, 1, 'Login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:139.0) Gecko/20100101 Firefox/139.0', '2025-06-23 04:56:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`, `kode_mapel`, `deskripsi`, `created_at`) VALUES
(1, 'Matematika', 'M1', 'bsjfhbhjf', '2025-05-30 12:37:34'),
(2, 'Bahasa indonesia', 'B2', 'bsjfhbhjf', '2025-05-30 12:37:34'),
(3, 'Biologi', 'BI1', 'kadjkab', '2025-05-30 15:52:18'),
(5, 'Agama', 'A1', 'dsbvkj', '2025-07-18 12:33:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas`, `lokasi`, `created_at`) VALUES
(1, 'Ruangan 1', 24, 'sekolah', '2025-05-30 12:55:45'),
(2, 'Ruangan 2', 25, 'sekolah                                                                        ', '2025-06-18 12:42:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(20) DEFAULT NULL,
  `nama_ortu` varchar(100) DEFAULT NULL,
  `no_telp_ortu` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nisn`, `jurusan_id`, `kelas_id`, `jenis_kelamin`, `alamat`, `no_telp`, `nama_ortu`, `no_telp_ortu`, `created_at`, `updated_at`) VALUES
(83, 138, '123123', NULL, NULL, 8, 'laki-laki', 'Jl. Merdeka', '8123456789', NULL, NULL, '2025-07-18 12:59:01', NULL),
(84, 139, '12124234', NULL, 4, 8, 'L', 'Jl. Kartini', '8223456789', NULL, NULL, '2025-07-18 12:59:01', '2025-07-18 15:09:42'),
(85, 140, '213132', NULL, 4, 8, 'P', 'ad', '23423', NULL, NULL, '2025-07-18 13:01:54', '2025-07-18 15:07:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `login_attempts` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `email`, `role`, `is_active`, `login_attempts`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$h.mdQjZmP6mLKP7/.JPIu.9tNv1vpVOnl9nSY3N5D6AsvdrndpESi', 'admin@gmail.com', 'admin', 1, 0, '2025-05-30 12:08:06', '2025-06-29 11:58:22'),
(31, 'Muhammad Yusril', 'Muhammad', '$2y$10$wpqUh5cAFwXts2E7EhfeM.Ykv/a/lfuB42hGWpEKySuAY99v9zpBG', 'acil@gmail.com', 'guru', 0, 0, '2025-06-23 04:32:42', '2025-07-18 12:46:54'),
(138, 'Rahman', 'rahman', '$2y$10$cXKdgwNySHhNS/n3gSQVYeC2yrWNJevo9VN7DEyFyiCshfCfZ.XhW', 'rahman@gmail.com', 'siswa', 1, 1, '2025-07-18 12:59:01', NULL),
(139, 'Sesar', 'sesar', '$2y$10$F/LOvtWU.nTQEZETkAxgoe/qJFpsK3..smwCxgj5OXX/O6S4Of3RK', 'sesar@gmail.com', 'siswa', 1, 1, '2025-07-18 12:59:01', '2025-07-18 15:09:42'),
(140, 'Suriyani Takaredassss', 'uli', '$2y$10$f4jLkqc7wOf3Vu9oFRmw1e7BTOWnAJt0RpEb9cpjy1uL5iNNLP7se', 'uli@gmail.com', 'siswa', 1, 1, '2025-07-18 13:01:54', '2025-07-18 15:01:38'),
(141, 'Uli', 'acil', '$2y$10$/GFvoO35hQI0ObtMZyX/muiOGhJIqgUtBuhLfUu4y37tix7wprJdy', 'uli01@gmil.com', 'guru', 1, 1, '2025-07-18 13:18:24', '2025-07-18 14:59:26'),
(145, 'Suriyani Takaredas', 'uli01', '$2y$10$R6htZXT8C6YZq.3agm5vH.Q8qy86Bd07VmxDLpRr7MbtodA4lqaEu', 'uli01@gmil.com', 'guru', 1, 1, '2025-07-18 14:14:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_pengawas_id` (`guru_pengawas_id`),
  ADD KEY `ruangan_id` (`ruangan_id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`),
  ADD UNIQUE KEY `kode_jurusan` (`kode_jurusan`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penanggung_jawab_id` (`penanggung_jawab_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`),
  ADD KEY `wali_kelas_id` (`wali_kelas_id`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD UNIQUE KEY `nama_ruangan` (`nama_ruangan`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `fk_siswa_jurusan` (`jurusan_id`),
  ADD KEY `fk_siswa_kelas` (`kelas_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD CONSTRAINT `guru_mapel_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapel_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id_mapel`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_3` FOREIGN KEY (`guru_pengawas_id`) REFERENCES `guru` (`id`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_4` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id_ruangan`);

--
-- Ketidakleluasaan untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`penanggung_jawab_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_jurusan` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`),
  ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

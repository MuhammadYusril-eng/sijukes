-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 18 Jun 2025 pada 10.27
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
(1, 2, '123', 'L', 'kjbdjh', '081723', '2025-05-30 12:44:16', '2025-05-30 12:49:45'),
(2, 3, '92198', 'L', 'sjhbfhj', '01274891', '2025-05-30 12:50:32', '2025-05-30 15:08:18'),
(3, 23, '1231', 'P', 'Sango', '08989', '2025-06-09 09:31:47', NULL);

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
(2, 1, 2, '2025-05-30 12:49:45'),
(4, 2, 2, '2025-05-30 15:08:18');

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
(1, 'Matematika', 2, 6, 2, '2025-06-18', '08:00:00', '10:00:00', 1, '', '2025-06-17 12:15:48', NULL);

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
(1, 'Bakti. sosial', 'kajjke', '2025-05-30', '2025-05-30', '01:00:00', '20:00:00', 'Sekolah', 1, 'semua', 'file/images/kegiatan/1748693161_Photo on 20-06-24 at 15.08.jpg', '2025-05-31 12:06:01', '2025-06-09 09:32:46'),
(2, 'ESKUL', 'ajdikhd', '2025-06-17', '2025-06-24', '09:00:00', '13:00:00', 'SEKOLAH', 1, 'semua', '', '2025-06-17 12:17:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kompetensi_keahlian` varchar(100) NOT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkat`, `kompetensi_keahlian`, `wali_kelas_id`, `created_at`) VALUES
(6, 'IPS 1', 'X', 'ajknbdk', 1, '2025-05-31 14:31:11');

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
(1, 1, 'Test aktivitas', '127.0.0.1', 'Test Agent', '2025-05-31 12:23:14');

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
(1, 'Matematika', '1', 'bsjfhbhjf', '2025-05-30 12:37:34'),
(2, 'Bahasa indonesia', '2', 'bsjfhbhjf', '2025-05-30 12:37:34'),
(3, 'Biologi', 'BI1', 'kadjkab', '2025-05-30 15:52:18');

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
(1, 'Ruangan 1', 24, '                                                                        cekolah', '2025-05-30 12:55:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `kelas` varchar(35) NOT NULL,
  `tingkat` varchar(20) NOT NULL,
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

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nisn`, `kelas`, `tingkat`, `jenis_kelamin`, `alamat`, `no_telp`, `nama_ortu`, `no_telp_ortu`, `created_at`, `updated_at`) VALUES
(13, 28, '123', NULL, 'IPS 1', 'X', 'L', 'kajbd', '1231', NULL, NULL, '2025-06-17 13:22:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$F/oR0yMr62/hYRUSmADgT.02Z5CCJ7QZwrx.DuIFBI3zAGmQ7sgIW', 'admin@gmail.com', 'admin', '2025-05-30 12:08:06', NULL),
(2, 'Muhammad Yusril', 'acil', '$2y$10$inuZyrawo2UjHx2Efd./juij9xeTlP8GFsuPmGaUSUVvDZ6SDRE6.', 'acil@gmail.com', 'guru', '2025-05-30 12:44:16', NULL),
(3, 'Muhammad Raffi', 'afi', '$2y$10$lyOK3Jy7J8CvXOSKWTmuXu5tfIry2fMBZWbXR9/Gr9uwViBjDZg6.', 'afi@gmail.com', 'guru', '2025-05-30 12:50:32', '2025-05-30 15:08:18'),
(23, 'Yusrinaini Udin', 'aini', '$2y$10$3UxiW23W.RjzJc59GQUtl.ZTkPNXUsgCPEZnjsI7Gb8Rn28rCM6Je', 'aini@gmail.com', 'guru', '2025-06-09 09:31:47', NULL),
(28, 'man', 'man', '$2y$10$dzHw5bbRATgEMWsPqMINe.aul00A.1SU0ElErlYAx.cjOmLFGS5Lq', 'man@gmail.com', 'siswa', '2025-06-17 13:22:00', NULL);

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
  ADD KEY `wali_kelas_id` (`wali_kelas_id`);

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
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nisn` (`nisn`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

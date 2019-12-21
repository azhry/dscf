-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Des 2019 pada 06.53
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dscf`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id` int(11) NOT NULL,
  `kode` char(2) NOT NULL,
  `nama_gejala` text NOT NULL,
  `belief` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id`, `kode`, `nama_gejala`, `belief`, `created_at`, `updated_at`) VALUES
(1, '', 'Gatal', 0.2, '2019-12-20 15:40:45', '2019-12-20 15:40:45'),
(2, '', 'Kulit Kering', 0.7, '2019-12-20 15:43:37', '2019-12-20 15:43:37'),
(3, '', 'Luka Berair', 0.7, '2019-12-20 15:46:01', '2019-12-20 15:46:01'),
(4, '', 'Kemerahan', 0.3, '2019-12-20 15:46:28', '2019-12-20 15:46:28'),
(5, '', 'Demam', 0.5, '2019-12-20 15:48:48', '2019-12-20 15:48:48'),
(6, '', 'Pecah-pecah', 0.8, '2019-12-20 15:49:14', '2019-12-20 15:49:14'),
(7, '', 'Lapisan Kulit Bengkak', 0.7, '2019-12-20 15:49:33', '2019-12-20 15:49:33'),
(8, '', 'Nyeri', 0.8, '2019-12-20 15:51:30', '2019-12-20 15:51:30'),
(9, '', 'Sakit Saat Disentuh', 0.8, '2019-12-20 15:51:55', '2019-12-20 15:51:55'),
(10, '', 'Bernanah', 0.9, '2019-12-20 15:59:14', '2019-12-20 15:59:14'),
(11, '', 'Bintik Besar Berair', 0.8, '2019-12-20 16:00:17', '2019-12-20 16:00:17'),
(12, '', 'Sakit Kepala', 0.5, '2019-12-20 16:02:37', '2019-12-20 16:02:37'),
(13, '', 'Bintik Kecil Jumlah Banyak', 0.8, '2019-12-20 16:03:08', '2019-12-20 16:03:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala_penyakit`
--

CREATE TABLE `gejala_penyakit` (
  `id` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala_penyakit`
--

INSERT INTO `gejala_penyakit` (`id`, `id_penyakit`, `id_gejala`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019-12-20 15:40:45', '2019-12-20 15:40:45'),
(2, 1, 2, '2019-12-20 15:43:37', '2019-12-20 15:43:37'),
(3, 4, 2, '2019-12-20 15:43:37', '2019-12-20 15:43:37'),
(4, 2, 3, '2019-12-20 15:46:01', '2019-12-20 15:46:01'),
(5, 1, 4, '2019-12-20 15:46:28', '2019-12-20 15:46:28'),
(6, 2, 4, '2019-12-20 15:46:28', '2019-12-20 15:46:28'),
(7, 4, 4, '2019-12-20 15:46:28', '2019-12-20 15:46:28'),
(8, 5, 5, '2019-12-20 15:48:48', '2019-12-20 15:48:48'),
(9, 1, 6, '2019-12-20 15:49:14', '2019-12-20 15:49:14'),
(10, 4, 7, '2019-12-20 15:49:33', '2019-12-20 15:49:33'),
(11, 2, 8, '2019-12-20 15:51:30', '2019-12-20 15:51:30'),
(12, 3, 8, '2019-12-20 15:51:30', '2019-12-20 15:51:30'),
(13, 5, 8, '2019-12-20 15:51:30', '2019-12-20 15:51:30'),
(14, 4, 9, '2019-12-20 15:51:55', '2019-12-20 15:51:55'),
(15, 3, 10, '2019-12-20 15:59:14', '2019-12-20 15:59:14'),
(16, 5, 11, '2019-12-20 16:00:17', '2019-12-20 16:00:17'),
(17, 5, 12, '2019-12-20 16:02:37', '2019-12-20 16:02:37'),
(18, 3, 13, '2019-12-20 16:03:08', '2019-12-20 16:03:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id` int(11) NOT NULL,
  `kode` char(2) NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `saran_penanganan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id`, `kode`, `nama_penyakit`, `saran_penanganan`, `created_at`, `updated_at`) VALUES
(1, 'DA', 'Dermatitis Atopic', '-', '2019-12-20 15:33:43', '2019-12-20 15:33:43'),
(2, 'DN', 'Dermatitis Numularis', '-', '2019-12-20 15:34:30', '2019-12-20 15:34:30'),
(3, 'P', 'Pompholyx', '-', '2019-12-20 15:35:05', '2019-12-20 15:35:05'),
(4, 'DH', 'Dermatitis Hyperkeratosis', '-', '2019-12-20 15:35:44', '2019-12-20 15:35:44'),
(5, 'C', 'Infeksi Cacar', '-', '2019-12-20 15:36:06', '2019-12-20 15:36:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gejala_penyakit`
--
ALTER TABLE `gejala_penyakit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `gejala_penyakit`
--
ALTER TABLE `gejala_penyakit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

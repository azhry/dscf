-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2019 pada 07.48
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
-- Database: `db_spk_vikor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `criteria`
--

CREATE TABLE `criteria` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `weight` float NOT NULL,
  `key` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `criteria`
--

INSERT INTO `criteria` (`id`, `title`, `description`, `weight`, `key`, `type`, `category`, `details`, `created_at`, `updated_at`) VALUES
(1, 'Usia', '', 0.42, 'C1', 'range', 'Cost', '[{\"label\":\"19 - 20\",\"max\":\"20\",\"min\":\"19\",\"value\":\"90\"},{\"label\":\"21 - 22\",\"max\":\"22\",\"min\":\"21\",\"value\":\"70\"},{\"label\":\"23 - 24\",\"max\":\"24\",\"min\":\"23\",\"value\":\"50\"},{\"label\":\">24\",\"max\":null,\"min\":\"24\",\"value\":\"20\"}]', '2019-10-20 11:14:26', '2019-12-05 14:53:48'),
(2, 'Penampilan', '', 3.14, 'C2', 'option', 'Benefit', '[{\"label\":\"Berpenampilan Rapi\",\"value\":\"80\"},{\"label\":\"Cukup Rapi\",\"value\":\"60\"},{\"label\":\"Kurang Rapi\",\"value\":\"40\"},{\"label\":\"Tidak Rapi\",\"value\":\"20\"}]', '2019-10-20 11:18:34', '2019-12-05 14:35:40'),
(3, 'Komunikasi', '', 2, 'C3', 'option', 'Benefit', '[{\"label\": \"Berkomunikasi dengan baik dan jelas\", \"value\": 80}, {\"label\": \"Cukup Jelas\", \"value\": 60}, {\"label\": \"Kurang Jelas\", \"value\": 40}, {\"label\": \"Tidak Jelas\", \"value\": 20}]', '2019-10-20 11:21:05', '2019-10-23 07:27:52'),
(4, 'Teamwork', '', 1, 'C4', 'option', 'Benefit', '[{\"label\": \"Mempunyai jiwa solidaritas dalam tim yang tinggi\", \"value\": 80}, {\"label\": \"Mempunyai jiwa solidaritas yang cukup dalam tim\", \"value\": 60}, {\"label\": \"Kurang mempunyai jiwa solidaritas tim\", \"value\": 40}, {\"label\": \"Tidak ada jiwa dalam bekerjasama tim yang baik\", \"value\": 20}]', '2019-10-20 11:22:40', '2019-10-23 07:27:56'),
(5, 'Audio Visual', '', 3, 'C5', 'criteria', 'Benefit', '[\r\n {\r\n \"title\": \"Kelancaran\",\r\n \"key\": \"kelancaran\",\r\n \"weight\": 0.25,\r\n \"type\": \"option\",\r\n \"details\": [\r\n {\r\n \"label\": \"Sangat lancar dalam menyampaikan berita\",\r\n \"value\": 80\r\n },\r\n {\r\n \"label\": \"Cukup lancar dalam menayampaikan berita\",\r\n \"value\": 60\r\n },\r\n {\r\n \"label\": \"Kurang lancar dalam menyampaikan berita\",\r\n \"value\": 40\r\n },\r\n {\r\n \"label\": \"Tidak lancar dalam menyampaikan berita\",\r\n \"value\": 20\r\n }\r\n ]\r\n },\r\n {\r\n \"title\": \"Penguasaan Materi\",\r\n \"key\": \"penguasaan_materi\",\r\n \"weight\": 0.35,\r\n \"type\": \"option\",\r\n \"details\": [\r\n {\r\n \"label\": \"Penguasaan materi sangat baik\",\r\n \"value\": 80\r\n },\r\n {\r\n \"label\": \"Cukup dalam penguasaan materi\",\r\n \"value\": 60\r\n },\r\n {\r\n \"label\": \"Kurang dalam penguasaan materi\",\r\n \"value\": 40\r\n },\r\n {\r\n \"label\": \"Tidak menguasai materi\",\r\n \"value\": 20\r\n }\r\n ]\r\n },\r\n {\r\n \"title\": \"Ekspresi Wajah\",\r\n \"key\": \"ekspresi_wajah\",\r\n \"weight\": 0.2,\r\n \"type\": \"option\",\r\n \"details\": [\r\n {\r\n \"label\": \"Ekspresi wajah yang sangat baik\",\r\n \"value\": 80\r\n },\r\n {\r\n \"label\": \"Cukup dalam mengekspresikan wajah\",\r\n \"value\": 50\r\n },\r\n {\r\n \"label\": \"Buruk dalam mengeskpresikan wajah\",\r\n \"value\": 20\r\n }\r\n ]\r\n },\r\n {\r\n \"title\": \"Gerak Tubuh\",\r\n \"key\": \"gerak_tubuh\",\r\n \"weight\": 0.2,\r\n \"type\": \"option\",\r\n \"details\": [\r\n {\r\n \"label\": \"Tidak banyak bergerak pada saat menyampaikan berita\",\r\n \"value\": 80\r\n },\r\n {\r\n \"label\": \"Bergerak seadanya pada saat menyampaikan berita\",\r\n \"value\": 50\r\n },\r\n {\r\n \"label\": \"Terlalu banyak Gerakan pada saat menyampaikan berita\",\r\n \"value\": 20\r\n } \r\n ]\r\n }\r\n]', '2019-10-20 11:25:28', '2019-10-23 07:28:05'),
(8, 'adasdE', 'TRET', 3.14, 'erwer', 'range', 'Cost', '[{\"label\":\"werwerew\",\"max\":\"2\",\"min\":\"12\",\"value\":\"123\"}]', '2019-12-18 00:23:49', '2019-12-18 00:23:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `educational_background` text NOT NULL,
  `address` text NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `submitted` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT -1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data`
--

INSERT INTO `data` (`id`, `user_id`, `name`, `birthdate`, `birthplace`, `educational_background`, `address`, `hobby`, `reason`, `submitted`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 0, 'Azhary Arliansyah', '1996-08-05', 'Palembang', '{\"elementary\":\"aa\",\"junior\":\"bbb\",\"senior\":\"cc\",\"university\":\"dd\"}', 'Komplek Bougenville KM. 7 Palembang', '[\"qwedwqa\"]', 'dqwadw', 0, -1, '2019-11-04 03:17:25', '2019-11-24 03:27:44', '2019-11-04 07:12:08'),
(14, 0, 'Azhary Arliansyah', '1996-08-05', 'Palembang', '{\"elementary\":\"asdsa\",\"junior\":\"ewrwe\",\"senior\":\"edfw\",\"university\":\"werw\"}', 'Komplek Bougenville KM. 7 Palembang', '[\"ewewr\"]', 'werwe', 0, -1, '2019-11-04 03:18:51', '2019-11-24 03:27:50', '2019-11-04 07:12:04'),
(15, 3, 'test', '1212-12-12', 'Palembang', '{\"elementary\":\"12\",\"junior\":\"324\",\"senior\":\"34\",\"university\":\"43\"}', 'Komplek Bougenville KM. 7 Palembang', '[\"hhhhhh\",\"Food\"]', 'wrwe', 1, 1, '2019-11-23 14:45:19', '2019-12-12 13:47:44', NULL),
(16, 4, 'jewhrjwekhr', '1212-03-24', 'ekwjrhwejkhr', '{\"elementary\":\"jhwejkrhjk\",\"junior\":\"qhrjk\",\"senior\":\"whrjkewhrjk\",\"university\":\"hrjk\"}', 'hjkwehr', '[\"kjwejkhr\"]', 'rjewhrkwje', 0, 1, '2019-11-24 03:29:56', '2019-12-12 03:10:48', NULL),
(17, 7, 'Azhary Arliansyah', '1212-12-12', 'Palembang', '{\"elementary\":\"asd\",\"junior\":\"wew\",\"senior\":\"wer\",\"university\":\"qrwe\"}', 'Komplek Bougenville KM. 7 Palembang', '[\"were\"]', 'werwe', 0, 0, '2019-11-29 03:28:30', '2019-12-12 03:11:42', NULL),
(18, 9, 'test', '1212-12-12', 'Palembang', '{\"elementary\":\"sd\",\"junior\":\"smp\",\"senior\":\"sma\",\"university\":\"univ\"}', 'Komplek Bougenville KM. 7 Palembang', '[\"hobbby\"]', 'h3h3h3', 0, 1, '2019-12-12 14:16:01', '2019-12-12 14:19:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_value`
--

CREATE TABLE `data_value` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `data_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_value`
--

INSERT INTO `data_value` (`id`, `criteria_id`, `data_id`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(62, 1, 16, '23', '2019-11-24 15:33:15', '2019-11-24 15:33:15', NULL),
(63, 2, 16, 'Berpenampilan Rapi', '2019-11-24 15:33:15', '2019-11-24 15:33:15', NULL),
(64, 3, 16, 'Berkomunikasi dengan baik dan jelas', '2019-11-24 15:33:15', '2019-11-24 15:33:15', NULL),
(65, 4, 16, 'Mempunyai jiwa solidaritas dalam tim yang tinggi', '2019-11-24 15:33:15', '2019-11-24 15:33:15', NULL),
(66, 5, 16, '{\"kelancaran\":\"Sangat lancar dalam menyampaikan berita\",\"penguasaan_materi\":\"Penguasaan materi sangat baik\",\"ekspresi_wajah\":\"Ekspresi wajah yang sangat baik\",\"gerak_tubuh\":\"Tidak banyak bergerak pada saat menyampaikan berita\"}', '2019-11-24 15:33:15', '2019-11-24 15:33:15', NULL),
(67, 1, 15, '99', '2019-11-24 15:33:30', '2019-11-24 15:33:30', NULL),
(68, 2, 15, 'Cukup Rapi', '2019-11-24 15:33:30', '2019-11-24 15:33:30', NULL),
(69, 3, 15, 'Cukup Jelas', '2019-11-24 15:33:30', '2019-11-24 15:33:30', NULL),
(70, 4, 15, 'Mempunyai jiwa solidaritas yang cukup dalam tim', '2019-11-24 15:33:30', '2019-11-24 15:33:30', NULL),
(71, 5, 15, '{\"kelancaran\":\"Cukup lancar dalam menayampaikan berita\",\"penguasaan_materi\":\"Penguasaan materi sangat baik\",\"ekspresi_wajah\":\"Cukup dalam mengekspresikan wajah\",\"gerak_tubuh\":\"Bergerak seadanya pada saat menyampaikan berita\"}', '2019-11-24 15:33:30', '2019-11-24 15:33:30', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '2019-11-03 04:43:04', '2019-11-03 04:43:04', NULL),
(2, 'Juri', '2019-11-03 04:43:04', '2019-11-03 04:43:04', NULL),
(3, 'Pelamar', '2019-11-23 14:34:02', '2019-11-23 14:34:02', NULL),
(4, 'Pimpinan', '2019-12-03 16:18:17', '2019-12-03 16:18:17', NULL),
(5, 'System', '2019-12-13 12:12:13', '2019-12-13 12:12:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'FINAL_RESULT', 1, '2019-12-18 06:05:35', '2019-12-18 06:06:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `reset_password_token` char(32) DEFAULT NULL,
  `create_criteria_allowed` int(11) NOT NULL DEFAULT 0,
  `valid` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `reset_password_token`, `create_criteria_allowed`, `valid`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'administrasi', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-11-03 04:44:12', '2019-12-14 08:08:59', NULL),
(2, 2, 'penilai', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-11-03 04:44:12', '2019-12-13 11:50:16', NULL),
(3, 3, 'arliansyah_azhary@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '1f518b0b6ecf1a097e3949dcd43afe39', 0, 0, '2019-11-23 14:45:19', '2019-12-18 05:54:51', NULL),
(4, 3, 'test@testcom', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-11-24 03:29:56', '2019-11-24 03:29:56', NULL),
(7, 3, 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-11-29 03:28:30', '2019-11-29 03:28:30', NULL),
(8, 4, 'pimpinan', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-12-04 00:17:48', '2019-12-04 00:17:48', NULL),
(9, 3, 'vikor@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-12-12 14:16:01', '2019-12-12 14:16:01', NULL),
(10, 5, 'admin_sistem', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, '2019-12-13 12:13:14', '2019-12-13 12:13:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_value`
--
ALTER TABLE `data_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dv_criteria` (`criteria_id`),
  ADD KEY `fk_dv_data` (`data_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `data_value`
--
ALTER TABLE `data_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_value`
--
ALTER TABLE `data_value`
  ADD CONSTRAINT `fk_dv_criteria` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dv_data` FOREIGN KEY (`data_id`) REFERENCES `data` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

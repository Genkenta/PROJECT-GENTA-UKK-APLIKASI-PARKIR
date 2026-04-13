-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2026 at 02:18 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_02_15_154826_create_tarif_parkirs_table', 1),
(3, '2026_02_15_160032_create_log_aktivitas_table', 1),
(4, '2026_02_15_161142_create_area_parkirs_table', 1),
(5, '2026_02_15_161216_create_kendaraans_table', 1),
(6, '2026_02_15_161233_create_transaksi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir`
--

CREATE TABLE `tb_area_parkir` (
  `id_area` int UNSIGNED NOT NULL,
  `nama_area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `terisi` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_area_parkir`
--

INSERT INTO `tb_area_parkir` (`id_area`, `nama_area`, `kapasitas`, `terisi`, `created_at`, `updated_at`) VALUES
(1, 'Area A', 100, 0, '2026-04-10 02:47:57', '2026-04-10 08:31:23'),
(2, 'Area B', 50, 0, '2026-04-10 04:30:07', '2026-04-10 05:02:08'),
(3, 'Area C', 100, 0, '2026-04-10 04:47:26', '2026-04-10 04:55:46'),
(4, 'Area E', 60, 0, '2026-04-10 08:27:07', '2026-04-10 08:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` int UNSIGNED NOT NULL,
  `plat_nomor` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemilik` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id_kendaraan`, `plat_nomor`, `jenis_kendaraan`, `warna`, `pemilik`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'B 1234 AB', 'motor', 'biru', 'Ahmadi', NULL, '2026-04-10 02:51:05', '2026-04-10 02:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id_log` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `aktivitas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_aktivitas` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu_aktivitas`, `created_at`, `updated_at`) VALUES
(1, 1, 'ADMIN - Logout dari sistem', '2026-04-09 22:07:22', '2026-04-09 15:07:22', '2026-04-09 15:07:22'),
(2, 1, 'ADMIN - Login sebagai admin', '2026-04-09 22:07:23', '2026-04-09 15:07:23', '2026-04-09 15:07:23'),
(3, 1, 'ADMIN - Menambahkan user: Petugas (petugas)', '2026-04-09 22:08:23', '2026-04-09 15:08:23', '2026-04-09 15:08:23'),
(4, 1, 'ADMIN - Menambahkan user: Owner (owner)', '2026-04-09 22:08:57', '2026-04-09 15:08:57', '2026-04-09 15:08:57'),
(5, 1, 'ADMIN - Logout dari sistem', '2026-04-09 22:09:19', '2026-04-09 15:09:19', '2026-04-09 15:09:19'),
(6, 1, 'ADMIN - Logout dari sistem', '2026-04-10 05:17:29', '2026-04-09 22:17:29', '2026-04-09 22:17:29'),
(7, 1, 'ADMIN - Login sebagai admin', '2026-04-10 05:17:30', '2026-04-09 22:17:30', '2026-04-09 22:17:30'),
(8, 1, 'ADMIN - Logout dari sistem', '2026-04-10 06:25:17', '2026-04-09 23:25:17', '2026-04-09 23:25:17'),
(9, 1, 'ADMIN - Logout dari sistem', '2026-04-10 06:26:21', '2026-04-09 23:26:21', '2026-04-09 23:26:21'),
(10, 1, 'ADMIN - Login sebagai admin', '2026-04-10 06:26:21', '2026-04-09 23:26:21', '2026-04-09 23:26:21'),
(11, 1, 'ADMIN - Logout dari sistem', '2026-04-10 06:26:34', '2026-04-09 23:26:34', '2026-04-09 23:26:34'),
(12, 1, 'ADMIN - Logout dari sistem', '2026-04-10 09:45:24', '2026-04-10 02:45:24', '2026-04-10 02:45:24'),
(13, 1, 'ADMIN - Logout dari sistem', '2026-04-10 09:46:47', '2026-04-10 02:46:48', '2026-04-10 02:46:48'),
(14, 1, 'ADMIN - Login sebagai admin', '2026-04-10 09:46:48', '2026-04-10 02:46:48', '2026-04-10 02:46:48'),
(15, 1, 'ADMIN - Menambahkan area parkir: Area A', '2026-04-10 09:47:57', '2026-04-10 02:47:57', '2026-04-10 02:47:57'),
(16, 1, 'ADMIN - Mengedit area parkir: Area A', '2026-04-10 09:48:53', '2026-04-10 02:48:53', '2026-04-10 02:48:53'),
(17, 1, 'ADMIN - Mengedit area parkir: Area A', '2026-04-10 09:50:26', '2026-04-10 02:50:26', '2026-04-10 02:50:26'),
(18, 1, 'ADMIN - Menambahkan kendaraan B 1234 AB (motor)', '2026-04-10 09:51:05', '2026-04-10 02:51:05', '2026-04-10 02:51:05'),
(19, 1, 'ADMIN - Mengedit kendaraan B 1234 AB (motor)', '2026-04-10 09:51:54', '2026-04-10 02:51:54', '2026-04-10 02:51:54'),
(20, 1, 'ADMIN - Menambahkan tarif motor (Rp1000/jam)', '2026-04-10 09:52:42', '2026-04-10 02:52:42', '2026-04-10 02:52:42'),
(21, 1, 'ADMIN - Menambahkan tarif motor (Rp3000/jam)', '2026-04-10 09:53:02', '2026-04-10 02:53:02', '2026-04-10 02:53:02'),
(22, 1, 'ADMIN - Logout dari sistem', '2026-04-10 09:56:27', '2026-04-10 02:56:27', '2026-04-10 02:56:27'),
(23, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 09:56:54', '2026-04-10 02:56:54', '2026-04-10 02:56:54'),
(24, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 09:56:55', '2026-04-10 02:56:55', '2026-04-10 02:56:55'),
(25, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 09:57:44', '2026-04-10 02:57:44', '2026-04-10 02:57:44'),
(26, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 09:57:44', '2026-04-10 02:57:44', '2026-04-10 02:57:44'),
(27, 1, 'ADMIN - Logout dari sistem', '2026-04-10 09:59:09', '2026-04-10 02:59:09', '2026-04-10 02:59:09'),
(28, 1, 'ADMIN - Login sebagai admin', '2026-04-10 09:59:09', '2026-04-10 02:59:09', '2026-04-10 02:59:09'),
(29, 1, 'ADMIN - Mengedit user: Petugas', '2026-04-10 09:59:44', '2026-04-10 02:59:44', '2026-04-10 02:59:44'),
(30, 1, 'ADMIN - Logout dari sistem', '2026-04-10 09:59:53', '2026-04-10 02:59:53', '2026-04-10 02:59:53'),
(31, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 10:00:41', '2026-04-10 03:00:41', '2026-04-10 03:00:41'),
(32, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 10:00:42', '2026-04-10 03:00:42', '2026-04-10 03:00:42'),
(33, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 10:01:48', '2026-04-10 03:01:48', '2026-04-10 03:01:48'),
(34, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 10:01:48', '2026-04-10 03:01:48', '2026-04-10 03:01:48'),
(35, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 10:19:50', '2026-04-10 03:19:50', '2026-04-10 03:19:50'),
(36, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 10:19:50', '2026-04-10 03:19:50', '2026-04-10 03:19:50'),
(37, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 10:22:59', '2026-04-10 03:22:59', '2026-04-10 03:22:59'),
(38, 1, 'ADMIN - Logout dari sistem', '2026-04-10 10:26:48', '2026-04-10 03:26:48', '2026-04-10 03:26:48'),
(39, 1, 'ADMIN - Login sebagai admin', '2026-04-10 10:32:24', '2026-04-10 03:32:24', '2026-04-10 03:32:24'),
(40, 1, 'ADMIN - Logout dari sistem', '2026-04-10 10:32:37', '2026-04-10 03:32:37', '2026-04-10 03:32:37'),
(41, 3, 'OWNER - Login sebagai owner', '2026-04-10 10:36:22', '2026-04-10 03:36:22', '2026-04-10 03:36:22'),
(42, 3, 'OWNER - Logout dari sistem', '2026-04-10 11:02:14', '2026-04-10 04:02:14', '2026-04-10 04:02:14'),
(43, 1, 'ADMIN - Login sebagai admin', '2026-04-10 11:02:50', '2026-04-10 04:02:50', '2026-04-10 04:02:50'),
(44, 1, 'ADMIN - Mengedit tarif mobil', '2026-04-10 11:06:40', '2026-04-10 04:06:40', '2026-04-10 04:06:40'),
(45, 1, 'ADMIN - Menambahkan area parkir: AreaA', '2026-04-10 11:30:07', '2026-04-10 04:30:07', '2026-04-10 04:30:07'),
(46, 1, 'ADMIN - Logout dari sistem', '2026-04-10 11:31:58', '2026-04-10 04:31:58', '2026-04-10 04:31:58'),
(47, 1, 'ADMIN - Login sebagai admin', '2026-04-10 11:34:45', '2026-04-10 04:34:45', '2026-04-10 04:34:45'),
(48, 1, 'ADMIN - Mengedit area parkir: Area B', '2026-04-10 11:47:06', '2026-04-10 04:47:06', '2026-04-10 04:47:06'),
(49, 1, 'ADMIN - Menambahkan area parkir: Area A', '2026-04-10 11:47:26', '2026-04-10 04:47:26', '2026-04-10 04:47:26'),
(50, 1, 'ADMIN - Mengedit area parkir: Area C', '2026-04-10 11:55:46', '2026-04-10 04:55:46', '2026-04-10 04:55:46'),
(51, 1, 'ADMIN - Logout dari sistem', '2026-04-10 11:56:05', '2026-04-10 04:56:05', '2026-04-10 04:56:05'),
(52, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 11:56:21', '2026-04-10 04:56:21', '2026-04-10 04:56:21'),
(53, 2, 'PETUGAS - Menambahkan transaksi:  - B 1234 AB masuk', '2026-04-10 11:56:51', '2026-04-10 04:56:51', '2026-04-10 04:56:51'),
(54, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 12:00:42', '2026-04-10 05:00:42', '2026-04-10 05:00:42'),
(55, 1, 'ADMIN - Login sebagai admin', '2026-04-10 12:00:55', '2026-04-10 05:00:55', '2026-04-10 05:00:55'),
(56, 1, 'ADMIN - Mengedit area parkir: Area A', '2026-04-10 12:01:28', '2026-04-10 05:01:28', '2026-04-10 05:01:28'),
(57, 1, 'ADMIN - Mengedit area parkir: Area B', '2026-04-10 12:02:08', '2026-04-10 05:02:08', '2026-04-10 05:02:08'),
(58, 1, 'ADMIN - Menambahkan tarif lainnya (Rp3000/jam)', '2026-04-10 12:13:18', '2026-04-10 05:13:18', '2026-04-10 05:13:18'),
(59, 1, 'ADMIN - Logout dari sistem', '2026-04-10 12:32:45', '2026-04-10 05:32:45', '2026-04-10 05:32:45'),
(60, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 12:32:58', '2026-04-10 05:32:58', '2026-04-10 05:32:58'),
(61, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 13:25:30', '2026-04-10 06:25:30', '2026-04-10 06:25:30'),
(62, 2, 'PETUGAS - Menambahkan transaksi:  - B 1234 AB masuk', '2026-04-10 13:41:29', '2026-04-10 06:41:29', '2026-04-10 06:41:29'),
(63, 2, 'PETUGAS - Mengedit transaksi:  - B 1234 AB', '2026-04-10 13:52:44', '2026-04-10 06:52:44', '2026-04-10 06:52:44'),
(64, 2, 'PETUGAS - Mengedit transaksi:  - B 1234 AB', '2026-04-10 13:52:59', '2026-04-10 06:52:59', '2026-04-10 06:52:59'),
(65, 1, 'ADMIN - Login sebagai admin', '2026-04-10 14:06:16', '2026-04-10 07:06:16', '2026-04-10 07:06:16'),
(66, 1, 'ADMIN - Login sebagai admin', '2026-04-10 14:06:34', '2026-04-10 07:06:34', '2026-04-10 07:06:34'),
(67, 1, 'ADMIN - Logout dari sistem', '2026-04-10 14:07:29', '2026-04-10 07:07:29', '2026-04-10 07:07:29'),
(68, 3, 'OWNER - Login sebagai owner', '2026-04-10 14:07:46', '2026-04-10 07:07:46', '2026-04-10 07:07:46'),
(69, 3, 'OWNER - Logout dari sistem', '2026-04-10 14:14:42', '2026-04-10 07:14:42', '2026-04-10 07:14:42'),
(70, 3, 'OWNER - Login sebagai owner', '2026-04-10 14:15:46', '2026-04-10 07:15:46', '2026-04-10 07:15:46'),
(71, 3, 'OWNER - Logout dari sistem', '2026-04-10 14:22:06', '2026-04-10 07:22:06', '2026-04-10 07:22:06'),
(72, 1, 'ADMIN - Login sebagai admin', '2026-04-10 14:22:20', '2026-04-10 07:22:20', '2026-04-10 07:22:20'),
(73, 1, 'ADMIN - Logout dari sistem', '2026-04-10 14:23:48', '2026-04-10 07:23:48', '2026-04-10 07:23:48'),
(74, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 14:24:04', '2026-04-10 07:24:04', '2026-04-10 07:24:04'),
(75, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 14:48:39', '2026-04-10 07:48:39', '2026-04-10 07:48:39'),
(76, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 14:49:06', '2026-04-10 07:49:06', '2026-04-10 07:49:06'),
(77, 2, 'PETUGAS - Logout dari sistem', '2026-04-10 14:49:15', '2026-04-10 07:49:15', '2026-04-10 07:49:15'),
(78, 1, 'ADMIN - Login sebagai admin', '2026-04-10 14:49:46', '2026-04-10 07:49:46', '2026-04-10 07:49:46'),
(79, 1, 'ADMIN - Menambahkan area parkir: Area E', '2026-04-10 15:27:07', '2026-04-10 08:27:07', '2026-04-10 08:27:07'),
(80, 1, 'ADMIN - Logout dari sistem', '2026-04-10 15:27:53', '2026-04-10 08:27:53', '2026-04-10 08:27:53'),
(81, 2, 'PETUGAS - Login sebagai petugas', '2026-04-10 15:28:11', '2026-04-10 08:28:11', '2026-04-10 08:28:11'),
(82, 2, 'PETUGAS - Menambahkan transaksi:  - B 1234 AB masuk', '2026-04-10 15:29:17', '2026-04-10 08:29:17', '2026-04-10 08:29:17'),
(83, 2, 'PETUGAS - Login sebagai petugas', '2026-04-13 07:46:40', '2026-04-13 00:46:40', '2026-04-13 00:46:40'),
(84, 2, 'PETUGAS - Logout dari sistem', '2026-04-13 07:52:57', '2026-04-13 00:52:57', '2026-04-13 00:52:57'),
(85, 3, 'OWNER - Login sebagai owner', '2026-04-13 07:53:12', '2026-04-13 00:53:12', '2026-04-13 00:53:12'),
(86, 3, 'OWNER - Login sebagai owner', '2026-04-13 07:57:05', '2026-04-13 00:57:05', '2026-04-13 00:57:05'),
(87, 3, 'OWNER - Login sebagai owner', '2026-04-13 08:17:41', '2026-04-13 01:17:41', '2026-04-13 01:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int UNSIGNED NOT NULL,
  `jenis_kendaraan` enum('motor','mobil','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_per_jam` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `jenis_kendaraan`, `tarif_per_jam`, `created_at`, `updated_at`) VALUES
(1, 'motor', 1000, '2026-04-10 02:52:42', '2026-04-10 02:52:42'),
(2, 'mobil', 3000, '2026-04-10 02:53:02', '2026-04-10 04:06:40'),
(3, 'lainnya', 3000, '2026-04-10 05:13:18', '2026-04-10 05:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_parkir` int UNSIGNED NOT NULL,
  `id_kendaraan` int UNSIGNED NOT NULL,
  `id_tarif` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_area` int UNSIGNED NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `durasi_jam` int DEFAULT NULL,
  `biaya_total` decimal(10,0) DEFAULT NULL,
  `status` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'masuk',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_parkir`, `id_kendaraan`, `id_tarif`, `id_user`, `id_area`, `waktu_masuk`, `waktu_keluar`, `durasi_jam`, `biaya_total`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 2, 1, '2026-04-09 15:29:17', '2026-04-10 15:31:23', 25, 25000, 'keluar', '2026-04-10 08:29:17', '2026-04-10 08:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int UNSIGNED NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','owner') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '$2y$12$dMnCeTpz9H8ipfTnlJZ8fuK26TIKhlF/21CGx/.OHX/9MvShDHK0m', 'admin', 1, '2026-04-09 15:06:27', '2026-04-09 15:06:27'),
(2, 'Petugas', 'petugas', '$2y$12$eJamaMe4FYpQHsnqv7o8oeqzL9d1br9XQUe8N2bu/6senH.TVdOrK', 'petugas', 1, '2026-04-09 15:08:23', '2026-04-10 02:59:44'),
(3, 'Owner', 'owner', '$2y$12$AgPpiQnltMSiueTAllyDgOAUEdeEjuo49K.XIsehxg/TcI0UYa2MG', 'owner', 1, '2026-04-09 15:08:57', '2026-04-09 15:08:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_id_user_foreign` (`id_user`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_parkir`),
  ADD KEY `tb_transaksi_id_kendaraan_foreign` (`id_kendaraan`),
  ADD KEY `tb_transaksi_id_tarif_foreign` (`id_tarif`),
  ADD KEY `tb_transaksi_id_user_foreign` (`id_user`),
  ADD KEY `tb_transaksi_id_area_foreign` (`id_area`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `tb_user_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  MODIFY `id_area` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id_log` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_parkir` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `tb_area_parkir` (`id_area`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_id_kendaraan_foreign` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id_kendaraan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_id_tarif_foreign` FOREIGN KEY (`id_tarif`) REFERENCES `tb_tarif` (`id_tarif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

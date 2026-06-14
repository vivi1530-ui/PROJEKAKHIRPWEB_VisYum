-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2026 at 01:27 PM
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
-- Database: `visyum_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'kue basah', NULL, NULL),
(2, 'kue kering', NULL, NULL),
(3, 'gorengan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `kode_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tersedia` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `kode_menu`, `nama_menu`, `harga`, `stok`, `foto`, `tersedia`, `created_at`, `updated_at`) VALUES
(1, 3, 'VIS001', 'Donat Gula Manis', 3000, 5, '1781075030_donat.jpg', 1, '2026-06-10 00:03:50', '2026-06-14 11:29:40'),
(2, 1, 'VIS002', 'Lemper Ayam', 2500, 15, '1781096554_633.jpg', 1, '2026-06-10 06:02:34', '2026-06-14 12:29:52'),
(3, 3, 'VIS003', 'Lumpia', 2500, 17, '1781163111_888.webp', 1, '2026-06-11 00:31:51', '2026-06-14 11:56:25'),
(4, 3, 'VIS004', 'Pastel Ayam', 3000, 24, '1781270295_937.jpg', 1, '2026-06-12 13:18:15', '2026-06-14 11:29:40'),
(5, 1, 'VIS005', 'Kue Kukus', 2000, 20, '1781270403_357.jpg', 1, '2026-06-12 13:19:51', '2026-06-12 13:20:03'),
(6, 2, 'VIS006', 'Basreng Pedas', 5000, 20, '1781437775_465.jpg', 1, '2026-06-14 11:49:35', '2026-06-14 11:59:13');

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
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_05_130000_create_categories_table', 1),
(5, '2026_05_05_134548_create_menus_table', 1),
(6, '2026_06_10_055010_create_pesanans_table', 1),
(7, '2026_06_10_055016_create_pesanan_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int NOT NULL,
  `status` enum('keranjang','menunggu_pembayaran','lunas','proses','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'keranjang',
  `tanggal_ambil` date DEFAULT NULL,
  `jam_ambil` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanans`
--

INSERT INTO `pesanans` (`id`, `user_id`, `kode_transaksi`, `total_harga`, `status`, `tanggal_ambil`, `jam_ambil`, `created_at`, `updated_at`) VALUES
(1, 2, 'VY-178107520099', 6000, '', '2026-06-11', '22:20:00', '2026-06-10 00:06:40', '2026-06-10 02:28:09'),
(2, 2, 'VY-178107556389', 3000, 'selesai', NULL, NULL, '2026-06-10 00:12:43', '2026-06-10 00:12:50'),
(3, 2, 'VY-178107558082', 6000, 'selesai', NULL, NULL, '2026-06-10 00:13:00', '2026-06-10 00:13:10'),
(4, 2, 'VY-178107567956', 3000, 'selesai', NULL, NULL, '2026-06-10 00:14:39', '2026-06-10 00:18:38'),
(5, 2, 'VY-178108415933', 3000, '', '2026-06-11', '20:38:00', '2026-06-10 02:35:59', '2026-06-11 14:20:32'),
(6, 2, 'VY-178108464756', 3000, 'selesai', '2026-06-11', '18:45:00', '2026-06-10 02:44:07', '2026-06-10 09:44:38'),
(7, 3, 'VY-178108566474', 3000, 'selesai', '2026-06-11', '19:00:00', '2026-06-10 03:01:04', '2026-06-10 10:12:58'),
(8, 3, 'VY-178109182717', 3000, 'selesai', '2026-06-11', '19:43:00', '2026-06-10 04:43:47', '2026-06-10 11:47:13'),
(9, 3, 'VY-178109539717', 5500, 'selesai', '2026-06-11', '21:05:00', '2026-06-10 05:43:17', '2026-06-10 13:42:44'),
(10, 3, 'VY-178109720846', 3000, 'menunggu_pembayaran', '2026-06-11', '23:20:00', '2026-06-10 06:13:28', '2026-06-10 06:19:02'),
(11, 3, 'VY-178109778410', 8000, 'selesai', '2026-06-11', '22:40:00', '2026-06-10 06:23:04', '2026-06-10 13:42:48'),
(12, 3, 'VY-178109901173', 5500, 'lunas', '2026-06-11', '08:00:00', '2026-06-10 06:43:31', '2026-06-11 08:29:29'),
(13, 3, 'VY-178116719364', 5500, '', '2026-06-11', '08:00:00', '2026-06-11 01:39:53', '2026-06-11 08:44:33'),
(14, 4, 'VY-178116754190', 3000, '', '2026-06-11', '12:10:00', '2026-06-11 01:45:41', '2026-06-11 08:46:02'),
(15, 4, 'VY-178116822610', 2500, '', '2026-06-11', '20:00:00', '2026-06-11 01:57:06', '2026-06-11 08:57:22'),
(16, 4, 'VY-178116831853', 2500, '', '2026-06-11', '20:00:00', '2026-06-11 01:58:38', '2026-06-11 08:58:47'),
(17, 4, 'VY-178116930398', 5000, '', '2026-06-11', '22:00:00', '2026-06-11 02:15:03', '2026-06-11 09:15:13'),
(18, 4, 'VY-178116951345', 2500, '', '2026-06-11', '21:00:00', '2026-06-11 02:18:33', '2026-06-11 09:18:48'),
(19, 4, 'VY-178116980941', 3000, '', '2026-06-11', '20:00:00', '2026-06-11 02:23:29', '2026-06-11 09:23:42'),
(20, 4, 'VY-178118484291', 2500, '', '2026-06-11', '08:00:00', '2026-06-11 06:34:02', '2026-06-11 13:55:57'),
(21, 2, 'VY-178118620941', 2500, '', '2026-06-11', '08:00:00', '2026-06-11 06:56:49', '2026-06-11 14:22:25'),
(22, 4, 'VY-178118689071', 6000, '', '2026-06-11', '08:00:00', '2026-06-11 07:08:10', '2026-06-11 14:22:21'),
(23, 3, 'VY-178118810359', 2500, 'selesai', '2026-06-11', '08:00:00', '2026-06-11 07:28:23', '2026-06-11 14:28:45'),
(24, 2, 'VY-178118821522', 3000, 'selesai', '2026-06-11', '08:00:00', '2026-06-11 07:30:15', '2026-06-11 14:32:03'),
(25, 4, 'VY-178118893995', 3000, 'selesai', '2026-06-11', '08:00:00', '2026-06-11 07:42:19', '2026-06-11 14:43:15'),
(26, 4, 'VY-178119037561', 3000, 'selesai', '2026-06-11', '08:00:00', '2026-06-11 08:06:15', '2026-06-11 15:07:20'),
(27, 2, 'VY-178119176738', 7500, 'selesai', '2026-06-11', '08:00:00', '2026-06-11 08:29:27', '2026-06-12 05:27:30'),
(28, 4, 'VY-178125046961', 2500, 'selesai', '2026-06-13', '12:00:00', '2026-06-12 00:47:49', '2026-06-12 09:35:09'),
(29, 4, 'VY-178125717833', 5000, '', '2026-06-12', '15:00:00', '2026-06-12 02:39:38', '2026-06-12 09:40:32'),
(30, 2, 'VY-178125733189', 3000, 'lunas', '2026-06-12', '12:00:00', '2026-06-12 02:42:11', '2026-06-12 09:42:23'),
(31, 2, 'VY-178125749010', 2500, 'selesai', '2026-06-12', '09:00:00', '2026-06-12 09:44:50', '2026-06-12 09:45:56'),
(32, 3, 'VY-178125792833', 3000, '', '2026-06-13', '12:00:00', '2026-06-12 09:52:08', '2026-06-13 05:45:03'),
(33, 2, 'VY-178126970050', 0, 'keranjang', NULL, NULL, '2026-06-12 13:08:20', '2026-06-12 13:59:38'),
(34, 5, 'VY-178133022677', 5000, 'menunggu_pembayaran', '2026-06-13', '15:00:00', '2026-06-13 05:57:06', '2026-06-13 05:57:19'),
(35, 5, 'VY-178133060543', 5500, 'selesai', '2026-06-13', '15:00:00', '2026-06-13 06:03:25', '2026-06-13 06:06:46'),
(36, 4, 'VY-178141948084', 3000, 'keranjang', '2026-06-14', '15:00:00', '2026-06-14 06:44:40', '2026-06-14 06:47:37'),
(37, 6, 'VY-178143651085', 6000, 'selesai', '2026-06-15', '09:00:00', '2026-06-14 11:28:30', '2026-06-14 11:50:22'),
(38, 6, 'VY-178143811435', 5000, 'selesai', '2026-06-15', '09:00:00', '2026-06-14 11:55:14', '2026-06-14 11:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_details`
--

CREATE TABLE `pesanan_details` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `harga_saat_ini` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan_details`
--

INSERT INTO `pesanan_details` (`id`, `pesanan_id`, `menu_id`, `jumlah`, `harga_saat_ini`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 3000, 6000, '2026-06-10 00:09:30', '2026-06-10 02:20:11'),
(2, 2, 1, 1, 3000, 3000, '2026-06-10 00:12:43', '2026-06-10 00:12:43'),
(3, 3, 1, 2, 3000, 6000, '2026-06-10 00:13:00', '2026-06-10 00:13:04'),
(4, 4, 1, 1, 3000, 3000, '2026-06-10 00:14:39', '2026-06-10 00:14:39'),
(5, 5, 1, 1, 3000, 3000, '2026-06-10 02:35:59', '2026-06-10 02:35:59'),
(6, 6, 1, 1, 3000, 3000, '2026-06-10 02:44:07', '2026-06-10 02:44:07'),
(7, 7, 1, 1, 3000, 3000, '2026-06-10 03:01:04', '2026-06-10 03:01:04'),
(8, 8, 1, 1, 3000, 3000, '2026-06-10 04:43:47', '2026-06-10 04:43:47'),
(10, 9, 1, 1, 3000, 3000, '2026-06-10 05:56:22', '2026-06-10 05:56:22'),
(11, 9, 2, 1, 2500, 2500, '2026-06-10 06:02:56', '2026-06-10 06:02:56'),
(14, 10, 1, 1, 3000, 3000, '2026-06-10 06:18:49', '2026-06-10 06:18:49'),
(16, 11, 2, 2, 2500, 5000, '2026-06-10 06:38:36', '2026-06-10 06:40:14'),
(17, 11, 1, 1, 3000, 3000, '2026-06-10 06:41:15', '2026-06-10 06:41:15'),
(20, 12, 1, 1, 3000, 3000, '2026-06-11 01:22:29', '2026-06-11 01:22:29'),
(21, 12, 2, 1, 2500, 2500, '2026-06-11 01:22:32', '2026-06-11 01:22:32'),
(22, 13, 1, 1, 3000, 3000, '2026-06-11 01:39:53', '2026-06-11 01:39:53'),
(23, 13, 2, 1, 2500, 2500, '2026-06-11 01:39:56', '2026-06-11 01:39:56'),
(24, 14, 1, 1, 3000, 3000, '2026-06-11 01:45:41', '2026-06-11 01:45:41'),
(26, 15, 3, 1, 2500, 2500, '2026-06-11 01:57:11', '2026-06-11 01:57:11'),
(27, 16, 2, 1, 2500, 2500, '2026-06-11 01:58:38', '2026-06-11 01:58:38'),
(28, 17, 3, 2, 2500, 5000, '2026-06-11 02:15:03', '2026-06-11 02:15:04'),
(29, 18, 3, 1, 2500, 2500, '2026-06-11 02:18:33', '2026-06-11 02:18:33'),
(30, 19, 1, 1, 3000, 3000, '2026-06-11 02:23:29', '2026-06-11 02:23:29'),
(31, 20, 2, 1, 2500, 2500, '2026-06-11 06:34:02', '2026-06-11 06:34:02'),
(32, 21, 2, 1, 2500, 2500, '2026-06-11 06:56:49', '2026-06-11 06:56:49'),
(33, 22, 1, 2, 3000, 6000, '2026-06-11 07:08:10', '2026-06-11 07:08:16'),
(34, 23, 3, 1, 2500, 2500, '2026-06-11 07:28:23', '2026-06-11 07:28:23'),
(35, 24, 1, 1, 3000, 3000, '2026-06-11 07:30:15', '2026-06-11 07:30:15'),
(36, 25, 1, 1, 3000, 3000, '2026-06-11 07:42:19', '2026-06-11 07:42:19'),
(37, 26, 1, 1, 3000, 3000, '2026-06-11 08:06:15', '2026-06-11 08:06:15'),
(38, 27, 2, 3, 2500, 7500, '2026-06-11 08:29:27', '2026-06-11 08:29:48'),
(40, 28, 3, 1, 2500, 2500, '2026-06-12 02:23:00', '2026-06-12 02:23:00'),
(41, 29, 2, 2, 2500, 5000, '2026-06-12 02:39:38', '2026-06-12 02:39:40'),
(42, 30, 1, 1, 3000, 3000, '2026-06-12 02:42:11', '2026-06-12 02:42:11'),
(43, 31, 2, 1, 2500, 2500, '2026-06-12 09:44:50', '2026-06-12 09:44:50'),
(44, 32, 1, 1, 3000, 3000, '2026-06-12 09:52:08', '2026-06-12 09:52:08'),
(49, 34, 5, 1, 2000, 2000, '2026-06-13 05:57:06', '2026-06-13 05:57:06'),
(50, 34, 4, 1, 3000, 3000, '2026-06-13 05:57:09', '2026-06-13 05:57:09'),
(51, 35, 1, 1, 3000, 3000, '2026-06-13 06:03:25', '2026-06-13 06:03:25'),
(52, 35, 3, 1, 2500, 2500, '2026-06-13 06:03:29', '2026-06-13 06:03:29'),
(54, 36, 1, 1, 3000, 3000, '2026-06-14 06:45:52', '2026-06-14 06:45:52'),
(55, 37, 1, 1, 3000, 3000, '2026-06-14 11:28:30', '2026-06-14 11:28:30'),
(56, 37, 4, 1, 3000, 3000, '2026-06-14 11:28:34', '2026-06-14 11:28:34'),
(57, 38, 3, 2, 2500, 5000, '2026-06-14 11:55:14', '2026-06-14 11:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Efuys12ViSFfPMq9VD3QZ2PpLfVWErk0pj16XgPp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidFp3ZkVhSzlZSmFDTWlndHI2OW1qdkR2Tkdoak1ZQTBMVDRMUmRCciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNjoianVtbGFoX2t1bmp1bmdhbiI7aToxMjUzO3M6MTc6Imt1bmp1bmdhbl9wZXJ0YW1hIjtzOjE5OiIyMDI2LTA2LTE0IDE5OjMwOjE0IjtzOjE4OiJrdW5qdW5nYW5fdGVyYWtoaXIiO3M6MTk6IjIwMjYtMDYtMTQgMjA6MjI6NTciO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6Nzoid2VsY29tZSI7fX0=', 1781443377);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'via', 'via@owner.com', NULL, '$2y$12$FhU.Jn.7MARl1Xy6rcIh2uuenOM.MwSb5v11jdz6VePoHUjow38Pq', NULL, '2026-06-10 00:02:24', '2026-06-10 00:02:24'),
(2, 'rian', 'rian@gmail.com', NULL, '$2y$12$kYhwaCXKS2K1LLPd/qnYnuIRe/xDz2qQEMriSgsXqvDu.XQnjG/nq', NULL, '2026-06-10 00:04:12', '2026-06-10 00:04:12'),
(3, 'dini', 'dini@gmail.com', NULL, '$2y$12$CbRJjE24H9uMw7dy3BwAeO35O8NLdEj4MhnwuEOrcL/s1cxDXMm22', NULL, '2026-06-10 03:00:40', '2026-06-10 03:00:40'),
(4, 'sinta', 'sinta@gmail.com', NULL, '$2y$12$LoQH0EYrR2akA0N/lkhHBOAH9cvZths0UIBynN.3e27ivt9iUok2i', NULL, '2026-06-11 01:45:29', '2026-06-11 01:45:29'),
(5, 'jojo', 'jojo@gmail.com', NULL, '$2y$12$vD7vlVBlnVcYa8kZyG1A6uXSZl2/deakBVCR4qkq9bcd4QGRwIx.e', NULL, '2026-06-13 05:56:53', '2026-06-13 05:56:53'),
(6, 'Justin', 'justin@gmail.com', NULL, '$2y$12$iolM9zMh0DmynGsCfK.M..aKuOR89k1SofNvcfnPORCQX.p/icQ0C', NULL, '2026-06-14 11:27:54', '2026-06-14 11:27:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_kode_menu_unique` (`kode_menu`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesanans_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `pesanans_user_id_foreign` (`user_id`);

--
-- Indexes for table `pesanan_details`
--
ALTER TABLE `pesanan_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_details_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `pesanan_details_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pesanan_details`
--
ALTER TABLE `pesanan_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan_details`
--
ALTER TABLE `pesanan_details`
  ADD CONSTRAINT `pesanan_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_details_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

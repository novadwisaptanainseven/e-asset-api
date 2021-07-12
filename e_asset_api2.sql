-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2021 at 07:03 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_asset_api2`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_barang` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_barang` enum('tetap','tidak-tetap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_register` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_pabrik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pembelian` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `satuan` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_baik` int(11) NOT NULL DEFAULT 0,
  `jumlah_rusak` int(11) NOT NULL DEFAULT 0,
  `jumlah_barang` int(11) NOT NULL DEFAULT 0,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user_created` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_updated` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `kode_barang`, `nama_barang`, `jenis_barang`, `no_register`, `merk`, `no_pabrik`, `ukuran`, `bahan`, `tahun_pembelian`, `harga`, `satuan`, `jumlah_baik`, `jumlah_rusak`, `jumlah_barang`, `keterangan`, `foto`, `created_at`, `updated_at`, `deleted`, `user_created`, `user_updated`, `file`, `deleted_at`) VALUES
(1, 6, '', 'Laptop', 'tetap', '', 'MSI', '10-ab-10-cd', '10x10', 'Karbon', 2021, 8600900, '', 0, 0, 0, 'MSI MODERN 14 B10MW - 466ID I3-10110U SSD 256GB CARBON GRAY', 'public\\uploads\\barang\\1621667317118-laptop1.png', '2021-05-21 23:08:37', '2021-07-12 09:00:16', 0, '0', NULL, 'public\\uploads\\barang\\1621667317113-Ini file pdf.pdf', NULL),
(2, 6, '', 'Laptop', 'tetap', '', 'Dell XPS', '10-ab-10-cd', '10x10', 'Alumunium', 2021, 47225000, '', 0, 0, 0, 'DELL XPS 15 (Core i7-10750H)', 'public\\uploads\\barang\\1621667619467-laptop2.jpg', '2021-05-21 23:13:39', '2021-07-12 09:00:16', 0, '0', NULL, 'public\\uploads\\barang\\1621667619463-Ini file pdf.pdf', NULL),
(3, 7, '', 'Laptop', 'tetap', '', 'Lenovo', '10-ab-10-cd', '10x10', 'Alumunium', 2021, 27026998, '', 0, 0, 0, 'LENOVO LEGION 5P 15IMH05H - 6KID I7-10870H SSD 512GB RTX2060 144HZ\n', 'public\\uploads\\barang\\1621667774152-laptop3.png', '2021-05-21 23:16:14', '2021-07-12 09:00:16', 0, '0', NULL, 'public\\uploads\\barang\\1621667774149-Ini file pdf.pdf', NULL),
(4, 6, '12312321', 'Laptop Edit', 'tetap', NULL, 'Lenovo', '123123', '123', 'Polikarbonat', 2021, 3000000, 'Unit', 20, 0, 20, 'Lorem ipsum dolor sit amet', '', '2021-07-12 07:31:49', '2021-07-12 09:00:16', 0, NULL, 'Administrator', '', NULL),
(6, 6, '123', 'Test hapus', 'tetap', NULL, 'Lenovo', '123123', '123', 'Polikarbonat', 2021, 3000000, 'Unit', 20, 0, 20, 'Lorem ipsum dolor sit amet', '', '2021-07-12 08:34:42', '2021-07-12 09:00:16', 0, 'Administrator', 'Administrator', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_detail`
--

CREATE TABLE `barang_detail` (
  `id_barang_detail` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_baik` int(11) NOT NULL,
  `jumlah_rusak` int(11) NOT NULL,
  `createdAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updatedAt` datetime(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_detail`
--

INSERT INTO `barang_detail` (`id_barang_detail`, `id_barang`, `jumlah_baik`, `jumlah_rusak`, `createdAt`, `updatedAt`, `deleted`, `user`, `jumlah_total`) VALUES
(1, 1, 20, 20, '2021-05-22 07:08:37.411', '2021-05-22 07:08:37.412', 0, NULL, 60),
(2, 1, 20, 20, '2021-05-22 07:08:37.411', '2021-05-22 07:08:37.412', 0, NULL, 60),
(3, 1, 20, 20, '2021-05-22 07:08:37.411', '2021-05-22 07:08:37.412', 0, NULL, 60),
(4, 1, 20, 20, '2021-05-22 07:08:37.411', '2021-05-22 07:08:37.412', 0, NULL, 60),
(5, 2, 20, 20, '2021-05-22 07:13:39.559', '2021-05-22 08:16:36.604', 1, NULL, 60),
(6, 2, 20, 20, '2021-05-22 07:13:39.559', '2021-05-22 07:13:39.559', 0, NULL, 60),
(7, 2, 20, 20, '2021-05-22 07:13:39.559', '2021-05-22 07:13:39.559', 0, NULL, 60),
(8, 2, 20, 20, '2021-05-22 07:13:39.559', '2021-05-22 07:13:39.559', 0, NULL, 60),
(9, 3, 20, 20, '2021-05-22 07:16:14.318', '2021-05-22 07:16:14.318', 0, NULL, 60),
(10, 3, 20, 20, '2021-05-22 07:16:14.318', '2021-05-22 07:16:14.318', 0, NULL, 60),
(11, 3, 20, 20, '2021-05-22 07:16:14.318', '2021-05-22 08:13:31.902', 1, NULL, 60),
(12, 3, 20, 20, '2021-05-22 07:16:14.318', '2021-05-22 08:04:18.247', 1, NULL, 60),
(13, 3, 10, 10, '2021-05-22 08:06:48.037', '2021-05-22 08:06:48.037', 0, NULL, 30),
(14, 3, 10, 10, '2021-05-22 08:13:47.489', '2021-05-22 08:16:13.324', 1, NULL, 30),
(15, 3, 10, 10, '2021-05-22 08:16:22.855', '2021-05-22 08:16:22.856', 0, NULL, 30),
(16, 2, 20, 20, '2021-05-22 08:17:02.704', '2021-05-22 08:17:02.705', 0, NULL, 60);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `asal_usul` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_barang_masuk` date NOT NULL,
  `createdAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updatedAt` datetime(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_mutasi`
--

CREATE TABLE `barang_mutasi` (
  `id_barang_mutasi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `pemegang_lama` int(11) NOT NULL,
  `pemegang_baru` int(11) DEFAULT NULL,
  `foto_serah_terima` varchar(255) NOT NULL,
  `file_serah_terima` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang_pengguna`
--

CREATE TABLE `barang_pengguna` (
  `id_barang_pengguna` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `user_created` varchar(100) NOT NULL,
  `user_updated` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_pengguna`
--

INSERT INTO `barang_pengguna` (`id_barang_pengguna`, `id_barang`, `id_pegawai`, `jumlah`, `keterangan`, `user_created`, `user_updated`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'dfdfd', 'admin', 'admin', '2021-07-12 14:33:19', '2021-07-12 14:33:19'),
(2, 1, 2, 1, 'dfdfd', 'admin', 'admin', '2021-07-12 14:33:19', '2021-07-12 14:33:19'),
(3, 2, 3, 1, 'dfdfdf', 'Nova', 'Nova', '2021-07-12 14:33:19', '2021-07-12 14:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `user_created` varchar(100) NOT NULL,
  `user_updated` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `user_created`, `user_updated`, `created_at`, `updated_at`) VALUES
(6, 'Teknologi Informasi', 'Administrator', 'Administrator', '2021-07-11 04:02:16', '2021-07-11 04:02:16'),
(7, 'Meubel', 'Administrator', 'Administrator', '2021-07-11 04:05:13', '2021-07-11 04:23:56'),
(8, 'Elektronik', 'Administrator', 'Administrator', '2021-07-11 04:05:25', '2021-07-11 04:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `kode_kendaraan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `jenis_kendaraan` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahan` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rangka` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pabrik` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_mesin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pembuatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pembelian` int(11) NOT NULL,
  `no_polisi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bpkb` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stnk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `kondisi` enum('baik','rusak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_stnk` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updatedAt` datetime(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan_pemegang`
--

CREATE TABLE `kendaraan_pemegang` (
  `id` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan_pindah`
--

CREATE TABLE `kendaraan_pindah` (
  `id_kendaraan_pindah` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dari` int(11) NOT NULL,
  `ke` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updatedAt` datetime(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_07_12_163309_add_deleted_at_column', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'admin', '4d753a75ec6e38f6f8ec51a2827e8feed42a4a9d3339f68b27dfe3a5b5095389', '[\"*\"]', '2021-07-11 05:56:21', '2021-07-10 21:48:33', '2021-07-11 05:56:21'),
(3, 'App\\Models\\User', 1, 'admin', '88b6db463fab7fb69fc835f05ab97cd6ce5271efa50f9f5d57305f6d7531d332', '[\"*\"]', '2021-07-10 22:38:01', '2021-07-10 22:37:59', '2021-07-10 22:38:01'),
(4, 'App\\Models\\User', 1, 'admin', '3115d1a18266a9dd6177d83cbacb1464aa4985ffd9029fa15a558b01075e102b', '[\"*\"]', '2021-07-10 22:39:59', '2021-07-10 22:39:57', '2021-07-10 22:39:59'),
(5, 'App\\Models\\User', 1, 'admin', '3c047140ca3f1b24f43eb05c2c6d6105c611d582c8d6bb1d6e1f98cdb70ee43c', '[\"*\"]', '2021-07-10 22:42:02', '2021-07-10 22:41:53', '2021-07-10 22:42:02'),
(6, 'App\\Models\\User', 1, 'admin', '452a50d4a1eead730744db02446774a51f7a7b09692529bb0e6f907d01da0455', '[\"*\"]', '2021-07-11 00:02:02', '2021-07-10 22:51:07', '2021-07-11 00:02:02'),
(7, 'App\\Models\\User', 1, 'admin', '81d1e546dde5d17decb7e726e0a3bee40e32a7f4842f149dd9d4d9dba8ca8896', '[\"*\"]', '2021-07-11 04:25:23', '2021-07-11 03:24:32', '2021-07-11 04:25:23'),
(8, 'App\\Models\\User', 1, 'admin', '26ffe4f8b6dd8125526673835f8ea0b0f128e0ce46a42dba17adcc9b1b4e8354', '[\"*\"]', '2021-07-11 05:57:11', '2021-07-11 04:01:20', '2021-07-11 05:57:11'),
(10, 'App\\Models\\User', 1, 'admin', '4eb59edabaf4524fcf9d167b7aeec5cc03d41801d7cb807abe27c9ac564f409c', '[\"*\"]', '2021-07-11 06:38:12', '2021-07-11 06:02:00', '2021-07-11 06:38:12'),
(11, 'App\\Models\\User', 1, 'admin', 'f6eec9e21e13667564fce72d3da07aaaf2c35abed33600db2e63ac8faa60201a', '[\"*\"]', '2021-07-12 09:00:22', '2021-07-12 06:19:26', '2021-07-12 09:00:22'),
(12, 'App\\Models\\User', 1, 'admin', '832b6abbd459d3f872007651821d275f129f44692bf5b1ae7a98320370f1aa2f', '[\"*\"]', '2021-07-12 06:49:23', '2021-07-12 06:48:57', '2021-07-12 06:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `user_created` varchar(100) NOT NULL,
  `user_updated` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `user_created`, `user_updated`, `created_at`, `updated_at`) VALUES
(2, 'Ruang TI Programmer', 'Administrator', 'Administrator', '2021-07-11 05:51:04', '2021-07-11 05:52:54'),
(3, 'Ruang Kepala Dinas', 'Administrator', 'Administrator', '2021-07-11 05:51:17', '2021-07-11 06:37:57'),
(5, 'Ruang Umum', 'Administrator', 'Administrator', '2021-07-11 06:02:22', '2021-07-11 06:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updatedAt` datetime(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `createdAt`, `updatedAt`, `deleted`) VALUES
(1, 'admin', '$2b$10$Tna36.vxoIxz3XB91TLOV.SYP8i9IHlr9anAMMUc2DwHwaZPzF1di', '2021-05-22 06:58:37.553', '2021-05-22 06:58:37.553', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `level`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'administrator', NULL, NULL, '$2y$10$dGRpS9ie2McG1l3AIJ25kuNkl9U0hSzi1AgLT8TzaEmvA2xk9OJhS', NULL, '2021-07-10 21:48:19', '2021-07-10 21:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `_prisma_migrations`
--

CREATE TABLE `_prisma_migrations` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checksum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `finished_at` datetime(3) DEFAULT NULL,
  `migration_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rolled_back_at` datetime(3) DEFAULT NULL,
  `started_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `applied_steps_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `_prisma_migrations`
--

INSERT INTO `_prisma_migrations` (`id`, `checksum`, `finished_at`, `migration_name`, `logs`, `rolled_back_at`, `started_at`, `applied_steps_count`) VALUES
('14c7f6f2-861b-4a8c-8cc0-789c7d946ea0', '23cb841914cd8bb144b72cf28729c791a86699b9a3dcac94f674bc7834d8bda7', '2021-05-22 06:24:10.732', '20210408080809_edit_relation_barang_pindah_mark2', NULL, NULL, '2021-05-22 06:24:10.499', 1),
('1e994787-7aa1-434c-b644-6ae1f381dbbe', 'd567ac87015d6a4609943e5351c15dfbbc14ef35df52f28d54eb8dacf7b9cf', '2021-05-22 06:24:10.418', '20210408075228_edit_relation_barang_pindah', NULL, NULL, '2021-05-22 06:24:08.235', 1),
('2b8512cb-be92-4e99-b797-333423dc4de6', 'b4ba22cf462e3968ff8821e3f5bc2744847ca117ac7c02dd83df55564181d24', '2021-05-22 06:24:12.235', '20210408083442_edit_relation_barang_pindah_mk_iii', NULL, NULL, '2021-05-22 06:24:10.787', 1),
('2dd898ed-fb67-4259-9324-c8f6045bac65', '5e6e50bf2081d6c992ddbd3c2a2fc91a2469cd1a7165b8189819e8b3efbe', '2021-05-22 06:24:07.821', '20210407063536_rename_barang_pindah_dari_ke', NULL, NULL, '2021-05-22 06:24:07.509', 1),
('340f5df3-d7c3-4b55-b804-f8dae5b804eb', 'c5e89cd8b83857db185c917534937f64d8591d3a5a8af96377c2c6e2be9699f', '2021-05-22 06:24:13.350', '20210421034243_add_jumlah_barang_detail', NULL, NULL, '2021-05-22 06:24:13.157', 1),
('387d11d6-b363-4d44-847d-17dfc1849005', '682455807439a4cf5ac1daebacdb695a8ac219d16294551416288f7779cdb5f', '2021-05-22 06:24:04.889', '20210323025529_add_user', NULL, NULL, '2021-05-22 06:23:59.915', 1),
('43a8d139-67e3-4d18-a1cb-618f6e8c7864', '75367e737f59ba2095de75cefb56a9d64b1a1ca185b2a6ddd4afe5e5940946f', '2021-05-22 06:24:07.463', '20210407041118_add_keadaan_barang_on_barang_pindah', NULL, NULL, '2021-05-22 06:24:06.866', 1),
('5525f4c4-f89a-4bfd-8119-7747ab64f7c4', 'e2b69beb442f87885cf3940f15c4f1a437a5ac357617b7c41c3cc1f45a2914', '2021-05-22 06:23:59.856', '20210322043416_init', NULL, NULL, '2021-05-22 06:23:55.200', 1),
('5f6282d1-7a5f-4722-b78f-5d8bf295133f', 'bc648da48e5736775be718fe340bf601a1b9a1c9a69b8aa5b46be4b97ea7168', '2021-05-22 06:24:17.150', '20210423085833_change_keterangan_barang_masuk', NULL, NULL, '2021-05-22 06:24:16.952', 1),
('65148185-68d0-4ec9-af1b-d7dddd9dffed', 'bb27d75963b653a137e6c4e8d2639d8013e40f44a397ea885a33d7de01c', '2021-05-22 06:24:08.155', '20210407071006_redesign_pindah_barang_schema', NULL, NULL, '2021-05-22 06:24:07.885', 1),
('7124b10f-097b-4383-a6ff-30391b0753e3', 'adf04bc2de93f99ed8042faaeaaec727c52d0ae71d0ee98f04488cf8b9bec9', '2021-05-22 06:24:05.994', '20210323032554_username_uniqued', NULL, NULL, '2021-05-22 06:24:04.909', 1),
('bd8a2b52-db33-4653-b96d-6df50c658bdd', '6b2c876c9b3bad08914dc84fcd5ee5f2881af2bc16913027e96f065a0cf', '2021-05-22 06:24:15.197', '20210423080844_add_barang_masuk_and_change_barang', NULL, NULL, '2021-05-22 06:24:13.406', 1),
('bdb1a30e-f8e9-40da-9349-63b59759a54f', '7f6dc013933b5af8a21182776abff8a4b8821667b6f679853903ef079eb61f1', '2021-05-22 06:24:06.813', '20210325060122_non_required_field_added', NULL, NULL, '2021-05-22 06:24:06.006', 1),
('e05617c4-106f-4ceb-8bd5-fc211a738d6d', '3e2add2ce2394232fdc5c0a0616a59a171a7ccf9853bbe677c1984845ed394', '2021-05-22 06:24:16.931', '20210423081235_add_relation_barang_masuk', NULL, NULL, '2021-05-22 06:24:15.240', 1),
('ea086d63-18b4-405d-b394-009d8ed3920f', '8b7675b9fdf85325f913969aa792b010bc9a6e66886356bcb06cd8918a3cd6', '2021-05-22 06:24:13.093', '20210413063620_kendaraan_pindah_re_schema', NULL, NULL, '2021-05-22 06:24:12.265', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `barang_detail`
--
ALTER TABLE `barang_detail`
  ADD PRIMARY KEY (`id_barang_detail`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_mutasi`
--
ALTER TABLE `barang_mutasi`
  ADD PRIMARY KEY (`id_barang_mutasi`,`pemegang_lama`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `barang_pengguna`
--
ALTER TABLE `barang_pengguna`
  ADD PRIMARY KEY (`id_barang_pengguna`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_user` (`user_created`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `kendaraan_pemegang`
--
ALTER TABLE `kendaraan_pemegang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kendaraan` (`id_kendaraan`);

--
-- Indexes for table `kendaraan_pindah`
--
ALTER TABLE `kendaraan_pindah`
  ADD PRIMARY KEY (`id_kendaraan_pindah`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user.username_unique` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `_prisma_migrations`
--
ALTER TABLE `_prisma_migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `barang_detail`
--
ALTER TABLE `barang_detail`
  MODIFY `id_barang_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_mutasi`
--
ALTER TABLE `barang_mutasi`
  MODIFY `id_barang_mutasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_pengguna`
--
ALTER TABLE `barang_pengguna`
  MODIFY `id_barang_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan_pemegang`
--
ALTER TABLE `kendaraan_pemegang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan_pindah`
--
ALTER TABLE `kendaraan_pindah`
  MODIFY `id_kendaraan_pindah` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `barang_detail`
--
ALTER TABLE `barang_detail`
  ADD CONSTRAINT `barang_detail_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_pengguna`
--
ALTER TABLE `barang_pengguna`
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kendaraan_pindah`
--
ALTER TABLE `kendaraan_pindah`
  ADD CONSTRAINT `kendaraan_pindah_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

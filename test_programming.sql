-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2024 at 06:50 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_programming`
--

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(21, '2014_10_12_100000_create_password_resets_table', 1),
(22, '2019_08_19_000000_create_failed_jobs_table', 1),
(23, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(24, '2024_08_05_044519_create_m_barangs_table', 1),
(25, '2024_08_05_044534_create_m_customers_table', 1),
(26, '2024_08_05_044606_create_t_sales_table', 1),
(27, '2024_08_05_044622_create_t_sales_dets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_barangs`
--

CREATE TABLE `m_barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_barangs`
--

INSERT INTO `m_barangs` (`id`, `kode`, `nama`, `harga`, `created_at`, `updated_at`) VALUES
(1, 'A001', 'Barang A', '200000.00', NULL, NULL),
(2, 'C025', 'Barang B', '350000.00', NULL, NULL),
(3, 'A102', 'Barang C', '125000.00', NULL, NULL),
(4, 'A301', 'Barang D', '300000.00', NULL, NULL),
(5, 'B221', 'Barang E', '300000.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_customers`
--

CREATE TABLE `m_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_customers`
--

INSERT INTO `m_customers` (`id`, `kode`, `name`, `telp`, `created_at`, `updated_at`) VALUES
(1, 'c1', 'Customer A', '081521941914', NULL, NULL),
(2, 'c2', 'Customer B', '089696562258', NULL, NULL),
(3, 'c3', 'Customer C', '087855248513', NULL, NULL),
(4, 'c4', 'Customer D', '087855248513', NULL, NULL),
(5, 'Cust SA', 'Sabi Ardana', '215498554', '2024-08-08 11:18:22', '2024-08-08 11:18:22');

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_sales`
--

CREATE TABLE `t_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl` datetime NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `diskon` decimal(15,2) DEFAULT NULL,
  `ongkir` decimal(15,2) DEFAULT NULL,
  `total_bayar` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_sales`
--

INSERT INTO `t_sales` (`id`, `kode`, `tgl`, `cust_id`, `subtotal`, `diskon`, `ongkir`, `total_bayar`, `created_at`, `updated_at`) VALUES
(1, '202101-0005', '2021-01-03 00:00:00', 4, '560000.00', NULL, NULL, '560000.00', NULL, NULL),
(2, '202101-0004', '2021-01-02 00:00:00', 3, '320000.00', NULL, NULL, '320000.00', NULL, NULL),
(3, '202101-0003', '2021-01-02 00:00:00', 1, '125000.00', NULL, NULL, '125000.00', NULL, NULL),
(4, '202101-0002', '2021-01-01 00:00:00', 2, '600000.00', NULL, '15000.00', '615000.00', NULL, NULL),
(5, '202101-0001', '2021-01-01 00:00:00', 1, '250000.00', '5000.00', NULL, '245000.00', NULL, NULL),
(7, '202408-0001', '2024-08-09 01:32:00', 1, '2495000.00', '5000.00', '11000.00', '2501000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales_dets`
--

CREATE TABLE `t_sales_dets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `harga_bandrol` decimal(15,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `diskon_pct` decimal(15,2) NOT NULL,
  `diskon_nilai` decimal(15,2) NOT NULL,
  `harga_diskon` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_sales_dets`
--

INSERT INTO `t_sales_dets` (`id`, `sales_id`, `barang_id`, `harga_bandrol`, `qty`, `diskon_pct`, `diskon_nilai`, `harga_diskon`, `total`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '200000.00', 1, '0.00', '0.00', '200000.00', '200000.00', NULL, NULL),
(2, 4, 2, '350000.00', 2, '0.15', '52500.00', '297500.00', '595000.00', NULL, NULL),
(3, 4, 3, '125000.00', 2, '0.20', '25000.00', '100000.00', '200000.00', NULL, NULL),
(4, 4, 4, '300000.00', 3, '0.00', '0.00', '300000.00', '900000.00', NULL, NULL),
(5, 4, 5, '300000.00', 2, '0.00', '0.00', '300000.00', '600000.00', NULL, NULL),
(6, 1, 4, '300000.00', 3, '0.00', '0.00', '300000.00', '900000.00', NULL, NULL),
(7, 1, 5, '300000.00', 2, '0.00', '0.00', '300000.00', '600000.00', NULL, NULL),
(8, 2, 1, '200000.00', 1, '0.00', '0.00', '200000.00', '200000.00', NULL, NULL),
(9, 2, 2, '350000.00', 2, '0.15', '52500.00', '297500.00', '595000.00', NULL, NULL),
(10, 2, 3, '125000.00', 2, '0.20', '25000.00', '100000.00', '200000.00', NULL, NULL),
(11, 3, 5, '300000.00', 2, '0.00', '0.00', '300000.00', '600000.00', NULL, NULL),
(12, 5, 3, '125000.00', 2, '0.20', '25000.00', '100000.00', '200000.00', NULL, NULL),
(13, 5, 4, '300000.00', 3, '0.00', '0.00', '300000.00', '900000.00', NULL, NULL),
(19, 7, 1, '200000.00', 1, '0.00', '0.00', '200000.00', '200000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52'),
(20, 7, 2, '350000.00', 2, '15.00', '52500.00', '297500.00', '595000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52'),
(21, 7, 3, '125000.00', 2, '20.00', '25000.00', '100000.00', '200000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52'),
(22, 7, 4, '300000.00', 3, '0.00', '0.00', '300000.00', '900000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52'),
(23, 7, 5, '300000.00', 2, '0.00', '0.00', '300000.00', '600000.00', '2024-08-08 11:32:52', '2024-08-08 11:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$dU/5pYgwB0XwtIyxrdRWZuqAm.97gJu6rxyCdV3la8A8aORaQDR.u', NULL, NULL, NULL),
(2, 'Hendra Ahmadillah', 'hendrayna55@gmail.com', NULL, '$2y$10$Kxr7nZ9/oYBsinK85UQa0uiL0p93/tIlPntlV2N//PfTQzvpH94kO', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_barangs`
--
ALTER TABLE `m_barangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_customers`
--
ALTER TABLE `m_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_sales_cust_id_foreign` (`cust_id`);

--
-- Indexes for table `t_sales_dets`
--
ALTER TABLE `t_sales_dets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_sales_dets_sales_id_foreign` (`sales_id`),
  ADD KEY `t_sales_dets_barang_id_foreign` (`barang_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `m_barangs`
--
ALTER TABLE `m_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_customers`
--
ALTER TABLE `m_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_sales_dets`
--
ALTER TABLE `t_sales_dets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD CONSTRAINT `t_sales_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `m_customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_sales_dets`
--
ALTER TABLE `t_sales_dets`
  ADD CONSTRAINT `t_sales_dets_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `m_barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_sales_dets_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `t_sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

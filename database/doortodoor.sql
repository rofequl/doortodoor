-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2020 at 05:30 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doortodoor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$B7OJdpMIBiHgBFKjRrsj0O94getKvaDTMGrf6/GSXAMpizl2JUwau', 'NHLvbiYPlgtIwIQ5Wylzpoy26NNY02L3XYeCsHkhyuGeTAXXWWwAgqV021Vn', '2020-11-10 01:29:04', '2020-11-10 01:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` int(11) NOT NULL,
  `hub_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `zone_id`, `hub_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aman', 1, 1, 1, '2020-11-12 06:16:15', '2020-11-12 06:21:18'),
(2, 'Pollani', 1, 1, 1, '2020-11-14 09:46:35', '2020-11-14 09:46:35'),
(3, 'Monipuripara', 1, 3, 1, '2020-11-15 00:24:34', '2020-11-15 00:24:34'),
(4, 'Farmgate', 1, 3, 1, '2020-11-15 00:24:52', '2020-11-15 00:24:52'),
(5, 'Elenbari', 1, 3, 1, '2020-11-15 00:25:09', '2020-11-15 00:25:09'),
(6, 'Lalkuth', 1, 4, 1, '2020-11-15 00:25:41', '2020-11-15 00:25:41'),
(7, 'Harirampur', 1, 4, 1, '2020-11-15 00:25:56', '2020-11-15 00:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `basic_information`
--

CREATE TABLE `basic_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meet_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number_one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number_two` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twiter_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_plus_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_information`
--

INSERT INTO `basic_information` (`id`, `website_title`, `company_name`, `meet_time`, `phone_number_one`, `phone_number_two`, `email`, `website_link`, `facebook_link`, `twiter_link`, `google_plus_link`, `linkedin_link`, `footer_text`, `address`, `company_logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Door to Door Express Delivery', 'Door to Door Express Delivery', 'MON-SAT,9AM-6PM', '8801971335588', '8801902137956', 'doortodoor@gmail.com', 'http://doortodoorexpressdelivery.com', 'https://www.facebook.com/doortodoorexpressedelivery', 'http://fe.ki', 'http://du.cf', 'https://www.linkedin.com/company/69354321/admin/', 'Copyright © 2019 Door to Door Express. All Rights Reserved by', 'Mirpur 6, road no- 8,block- d,house no- 18,postal code - 1216,Dhaka', '951605127025.png', 0, '2020-11-10 15:29:49', '2020-11-11 14:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubs`
--

CREATE TABLE `hubs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubs`
--

INSERT INTO `hubs` (`id`, `name`, `zone_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mirpur 10', 1, 1, '2020-11-12 05:33:26', '2020-11-12 05:49:31'),
(2, 'Agargao', 2, 1, '2020-11-12 05:40:11', '2020-11-12 05:56:14'),
(3, 'Tejgaon', 1, 1, '2020-11-15 00:22:54', '2020-11-15 00:22:54'),
(4, 'Gabtoli', 1, 1, '2020-11-15 00:23:07', '2020-11-15 00:23:07'),
(5, 'Gulshan', 1, 1, '2020-11-15 00:23:21', '2020-11-15 00:23:21'),
(6, 'Narayanganj', 3, 1, '2020-11-15 00:23:40', '2020-11-15 00:23:40'),
(7, 'Keraniganj', 3, 1, '2020-11-15 00:24:01', '2020-11-15 00:24:01');

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
(2, '2020_11_09_165748_create_admins_table', 1),
(5, '2020_11_10_112406_create_basic_information_table', 2),
(6, '2014_10_12_000000_create_users_table', 3),
(7, '2020_11_12_084058_create_zones_table', 4),
(8, '2020_11_12_110902_create_hubs_table', 5),
(9, '2020_11_12_111150_create_areas_table', 5),
(10, '2020_11_13_122823_create_shipping_prices_table', 6),
(12, '2020_11_14_083148_create_shipments_table', 7),
(13, '2020_11_09_165803_create_drivers_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `added_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'merchant',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parcel_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `user_id`, `zone_id`, `area_id`, `added_by`, `name`, `phone`, `address`, `zip_code`, `parcel_value`, `invoice_id`, `merchant_note`, `weight`, `delivery_type`, `cod`, `cod_amount`, `price`, `tracking_code`, `total_price`, `shipping_status`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 2, 'merchant', 'Orpon', '01946547568', '9/1 Kolalampur', NULL, '1000', '5475685678', NULL, '6', '1', '0', '0', '75', '18773404001', '1075', '0', '1', '2020-11-15 14:50:04', '2020-11-15 14:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_prices`
--

CREATE TABLE `shipping_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_id` int(11) NOT NULL,
  `cod` tinyint(1) NOT NULL DEFAULT 0,
  `cod_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_type` tinyint(1) NOT NULL,
  `max_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_prices`
--

INSERT INTO `shipping_prices` (`id`, `zone_id`, `cod`, `cod_value`, `delivery_type`, `max_weight`, `max_price`, `per_weight`, `price`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '1', 1, '1', '60', '1', '10', '2020-11-13 07:32:55', '2020-11-13 07:32:55'),
(2, 2, 1, '1', 2, '1', '100', '1', '20', '2020-11-15 00:32:06', '2020-11-15 00:32:06'),
(3, 1, 0, NULL, 1, '1', '50', '1', '5', '2020-11-15 00:33:06', '2020-11-15 00:33:06'),
(4, 1, 0, NULL, 2, '1', '60', '1', '8', '2020-11-15 00:33:24', '2020-11-15 00:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `first_name`, `last_name`, `shop_name`, `email`, `phone`, `password`, `address`, `website_link`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'UR9341605119421', 'Nayem', 'Islam', 'Nayem Ltd', 'nayem@gmail.com', '01966634890', '$2y$10$wX0Z5mrYxBLaWiH8MCSJUuG0PONq1jS9zhuwtVGXPPxCYcYHtr/EK', 'Narayanganj', NULL, '641605164031.jpg', 'wOIbK9BdMI4cvdwihsJw9f8XQwkA3HGmIU1i8yCNZ8sHOnFHdND3qJ4zExNp', '2020-11-11 12:30:21', '2020-11-12 00:53:51'),
(2, 'UR6451605188156', 'Md.', 'Ali', 'Ali express', 'ali@gmail.com', '01923456789', '$2y$10$LQIqtJMJqdXXN5P1qAl64uJ5EGo91Cncz0Vn153e9gkZjNo7aETlu', 'Chaina', 'www.aliexpress.com', NULL, NULL, '2020-11-12 07:35:56', '2020-11-12 07:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'In Side Dhaka', 1, '2020-11-12 02:54:20', '2020-11-12 05:05:59'),
(2, 'Out Side Dhaka', 1, '2020-11-12 05:07:06', '2020-11-12 05:49:01'),
(3, 'Sub Dhaka', 1, '2020-11-15 00:22:10', '2020-11-15 00:22:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_information`
--
ALTER TABLE `basic_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubs`
--
ALTER TABLE `hubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_prices`
--
ALTER TABLE `shipping_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `basic_information`
--
ALTER TABLE `basic_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hubs`
--
ALTER TABLE `hubs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping_prices`
--
ALTER TABLE `shipping_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

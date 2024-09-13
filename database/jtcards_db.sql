-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 01:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gift-bit`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_crypto`
--

CREATE TABLE `add_crypto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `add_giftcard`
--

CREATE TABLE `add_giftcard` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `min_amount` decimal(10,2) DEFAULT NULL,
  `max_amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(191) NOT NULL DEFAULT 'USD',
  `exchange_rate` decimal(10,2) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `type` enum('physical','e-code') NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cryptocurrencies`
--

CREATE TABLE `cryptocurrencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `crypto_price` decimal(20,2) DEFAULT NULL,
  `exchange_rate` decimal(10,2) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `listed_by` bigint(20) UNSIGNED NOT NULL,
  `v_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_prices`
--

CREATE TABLE `crypto_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crypto_name` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `price` decimal(20,8) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_rates`
--

CREATE TABLE `crypto_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crypto` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `exchange_rate` decimal(20,2) NOT NULL,
  `exchange_crypto` varchar(191) NOT NULL,
  `exchange_symbol` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_transactions`
--

CREATE TABLE `crypto_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(191) NOT NULL,
  `crypto_price` decimal(20,8) NOT NULL,
  `transaction_type` enum('buy','sell','transfer') NOT NULL DEFAULT 'buy',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `crypto_name` varchar(191) NOT NULL,
  `wallet_address` varchar(191) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_wallet_addresses`
--

CREATE TABLE `crypto_wallet_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crypto_name` varchar(191) NOT NULL,
  `wallet_address` varchar(191) NOT NULL,
  `wallet_provider` varchar(191) DEFAULT NULL,
  `crypto_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency_rates`
--

CREATE TABLE `currency_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `exchange_rate` decimal(10,2) NOT NULL,
  `exchange_currency` varchar(191) NOT NULL,
  `exchange_symbol` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `giftcard_images`
--

CREATE TABLE `giftcard_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `gift_card_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_in_naira` decimal(10,2) NOT NULL,
  `pin` varchar(191) DEFAULT NULL,
  `type` enum('physical','e-code') NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `photo` varchar(191) DEFAULT NULL,
  `exchange_rate` decimal(10,2) NOT NULL,
  `listed_by` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('available','sold','expired') NOT NULL DEFAULT 'available',
  `v_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_05_28_061622_create_cryptocurrencies_table', 1),
(7, '2024_05_28_061624_create_categories_table', 1),
(8, '2024_05_28_061638_create_gift_cards_table', 1),
(9, '2024_06_17_145230_create_crypto_transactions_table', 1),
(10, '2024_06_17_145316_create_wallets_table', 1),
(11, '2024_06_17_150430_create_orders_table', 1),
(12, '2024_06_17_150528_create_transactions_table', 1),
(13, '2024_06_17_150816_create_settings_table', 1),
(14, '2024_06_17_150834_create_crypto_prices_table', 1),
(15, '2024_07_18_210252_support_ticket', 1),
(16, '2024_07_18_211438_currency_rates', 1),
(17, '2024_07_18_211453_crypto_rates', 1),
(18, '2024_07_23_052702_create_email_verification_column_to_users_table', 1),
(19, '2024_07_26_064907_add_giftcard', 1),
(20, '2024_07_26_064917_add_crypto', 1),
(21, '2024_07_27_082721_giftcard_images', 1),
(22, '2024_08_02_182812_create_crypto_wallet_addresses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) NOT NULL,
  `buyer` bigint(20) UNSIGNED NOT NULL,
  `seller` bigint(20) UNSIGNED NOT NULL,
  `crypto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `giftcard_id` bigint(20) UNSIGNED DEFAULT NULL,
  `wallet_address` varchar(191) NOT NULL,
  `network` varchar(191) NOT NULL,
  `order_type` enum('crypto','giftcard') NOT NULL,
  `amount_in_usd` decimal(20,2) NOT NULL,
  `exchange_rate` decimal(20,2) NOT NULL,
  `amount_in_naira` decimal(20,2) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `status` enum('answered','pending','closed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(191) NOT NULL,
  `exchange_rate` decimal(10,2) NOT NULL,
  `transaction_type` enum('buy','sell','transfer') NOT NULL DEFAULT 'buy',
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `date_of_birth` date NOT NULL DEFAULT '1970-01-01',
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`address`)),
  `gender` enum('male','female') DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `verification_status` enum('Pending','Verified','Rejected') NOT NULL DEFAULT 'Pending',
  `photo` varchar(191) DEFAULT NULL,
  `role` varchar(191) NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `bank_name` varchar(191) DEFAULT NULL,
  `account_number` varchar(191) DEFAULT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `2fa_enabled` varchar(191) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(191) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_of_birth`, `address`, `gender`, `email`, `email_verified_at`, `password`, `phone`, `verification_status`, `photo`, `role`, `is_active`, `bank_name`, `account_number`, `account_name`, `2fa_enabled`, `remember_token`, `created_at`, `updated_at`, `verification_token`, `is_verified`) VALUES
(1, 'Marilou', 'Hermiston', '1981-07-10', '{\"country\":\"Philippines\",\"state\":\"Wyoming\",\"street\":\"9959 Amara Wall\"}', 'female', 'cordia.gutmann@example.com', '2024-08-23 22:11:41', '$2y$12$ZEFz3bBrDZdNAEujBOoVY.QxYbUkyop0D5wQuJdLxai2pPz/AYsHu', '(440) 374-1327', 'Rejected', 'https://via.placeholder.com/640x480.png/00ffaa?text=unde', 'admin', 1, NULL, NULL, NULL, '0', 'GDmG6NduSg', '2024-08-23 22:11:43', '2024-08-23 22:11:43', NULL, 0),
(2, 'Bette', 'Hermiston', '1987-02-06', '{\"country\":\"Tonga\",\"state\":\"New York\",\"street\":\"795 Hessel Mountain Apt. 474\"}', 'female', 'nklocko@example.net', '2024-08-23 22:11:41', '$2y$12$2BtcgVvQZjUn1v3bQ3L/f.MjQPLSwt13wqeG/khX4uFWq.jU00HQK', '863-893-2070', 'Verified', 'https://via.placeholder.com/640x480.png/00dd88?text=nemo', 'admin', 1, NULL, NULL, NULL, '0', '6VKqobe7Co', '2024-08-23 22:11:43', '2024-08-23 22:11:43', NULL, 0),
(3, 'Erna', 'Schuster', '1970-08-26', '{\"country\":\"Vanuatu\",\"state\":\"Oklahoma\",\"street\":\"9835 Runolfsdottir Forest Suite 467\"}', 'female', 'gcrooks@example.net', '2024-08-23 22:11:42', '$2y$12$fQkq7YTf2bqqC.Jn1hZ1kuz.rfAUBwu8WFaQnEqY1RO94nDepGXtC', '934-615-0058', 'Pending', 'https://via.placeholder.com/640x480.png/006666?text=error', 'admin', 1, NULL, NULL, NULL, '0', '1WYe7V2Ecp', '2024-08-23 22:11:43', '2024-08-23 22:11:43', NULL, 0),
(4, 'Clyde', 'Bartell', '1970-09-15', '{\"country\":\"Northern Mariana Islands\",\"state\":\"Louisiana\",\"street\":\"64289 Judson Creek\"}', 'male', 'larue31@example.net', '2024-08-23 22:11:42', '$2y$12$jOV4hGmeG5Udby0u9WrLm.cw36VApPmYB07StFgZWUzaynI3PmVga', '+1.929.579.2075', 'Pending', 'https://via.placeholder.com/640x480.png/009955?text=ea', 'admin', 1, NULL, NULL, NULL, '0', 'G7JyvSWWKs', '2024-08-23 22:11:43', '2024-08-23 22:11:43', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `crypto_type` varchar(191) DEFAULT NULL,
  `wallet_address` varchar(191) DEFAULT NULL,
  `crypto_balance` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `fiat_currency` varchar(3) DEFAULT NULL,
  `fiat_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_crypto`
--
ALTER TABLE `add_crypto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `add_crypto_name_unique` (`name`),
  ADD UNIQUE KEY `add_crypto_symbol_unique` (`symbol`);

--
-- Indexes for table `add_giftcard`
--
ALTER TABLE `add_giftcard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_giftcard_category_id_foreign` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cryptocurrencies`
--
ALTER TABLE `cryptocurrencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cryptocurrencies_listed_by_foreign` (`listed_by`);

--
-- Indexes for table `crypto_prices`
--
ALTER TABLE `crypto_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_rates`
--
ALTER TABLE `crypto_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_transactions`
--
ALTER TABLE `crypto_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crypto_transactions_transaction_number_unique` (`transaction_number`),
  ADD KEY `crypto_transactions_user_id_foreign` (`user_id`),
  ADD KEY `crypto_transactions_product_id_foreign` (`product_id`);

--
-- Indexes for table `crypto_wallet_addresses`
--
ALTER TABLE `crypto_wallet_addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crypto_wallet_addresses_wallet_address_unique` (`wallet_address`),
  ADD KEY `crypto_wallet_addresses_crypto_id_foreign` (`crypto_id`),
  ADD KEY `crypto_wallet_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `currency_rates`
--
ALTER TABLE `currency_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `giftcard_images`
--
ALTER TABLE `giftcard_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `giftcard_images_gift_card_id_foreign` (`gift_card_id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gift_cards_listed_by_foreign` (`listed_by`),
  ADD KEY `gift_cards_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_buyer_foreign` (`buyer`),
  ADD KEY `orders_seller_foreign` (`seller`),
  ADD KEY `orders_giftcard_id_foreign` (`giftcard_id`),
  ADD KEY `orders_crypto_id_foreign` (`crypto_id`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_number_unique` (`transaction_number`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_wallet_address_unique` (`wallet_address`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_crypto`
--
ALTER TABLE `add_crypto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `add_giftcard`
--
ALTER TABLE `add_giftcard`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cryptocurrencies`
--
ALTER TABLE `cryptocurrencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crypto_prices`
--
ALTER TABLE `crypto_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crypto_rates`
--
ALTER TABLE `crypto_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crypto_transactions`
--
ALTER TABLE `crypto_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crypto_wallet_addresses`
--
ALTER TABLE `crypto_wallet_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency_rates`
--
ALTER TABLE `currency_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giftcard_images`
--
ALTER TABLE `giftcard_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_giftcard`
--
ALTER TABLE `add_giftcard`
  ADD CONSTRAINT `add_giftcard_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cryptocurrencies`
--
ALTER TABLE `cryptocurrencies`
  ADD CONSTRAINT `cryptocurrencies_listed_by_foreign` FOREIGN KEY (`listed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crypto_transactions`
--
ALTER TABLE `crypto_transactions`
  ADD CONSTRAINT `crypto_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `cryptocurrencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crypto_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crypto_wallet_addresses`
--
ALTER TABLE `crypto_wallet_addresses`
  ADD CONSTRAINT `crypto_wallet_addresses_crypto_id_foreign` FOREIGN KEY (`crypto_id`) REFERENCES `add_crypto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crypto_wallet_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `giftcard_images`
--
ALTER TABLE `giftcard_images`
  ADD CONSTRAINT `giftcard_images_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD CONSTRAINT `gift_cards_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gift_cards_listed_by_foreign` FOREIGN KEY (`listed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_buyer_foreign` FOREIGN KEY (`buyer`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_crypto_id_foreign` FOREIGN KEY (`crypto_id`) REFERENCES `cryptocurrencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_giftcard_id_foreign` FOREIGN KEY (`giftcard_id`) REFERENCES `gift_cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_seller_foreign` FOREIGN KEY (`seller`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `gift_cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

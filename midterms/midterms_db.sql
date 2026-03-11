-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2026 at 05:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midterms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `quantity`) VALUES
(1, 'cookie', 9),
(2, 'brownie', 9);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_history`
--

CREATE TABLE `inventory_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_history`
--

INSERT INTO `inventory_history` (`id`, `item_id`, `quantity`, `date`) VALUES
(1, 1, 2, '2026-02-21 15:58:30'),
(2, 2, 9, '2026-02-21 16:40:05'),
(3, 1, 9, '2026-02-21 16:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user`, `action`, `date`) VALUES
(1, 'julian', 'Added cookie', '2026-02-21 15:58:30'),
(2, 'admin', 'Created user julian', '2026-02-21 16:13:46'),
(3, 'admin', 'Deleted julian', '2026-02-21 16:24:11'),
(4, 'admin', 'Deleted ', '2026-02-21 16:24:17'),
(5, 'admin', 'Created user julian', '2026-02-21 16:30:43'),
(6, 'admin', 'Deleted julian', '2026-02-21 16:33:45'),
(7, 'admin', 'Created user julian', '2026-02-21 16:33:52'),
(8, 'admin', 'Deleted ', '2026-02-21 16:33:52'),
(9, 'admin', 'Deleted ', '2026-02-21 16:35:23'),
(10, 'admin', 'Deleted julian', '2026-02-21 16:35:36'),
(11, 'admin', 'Created user julian', '2026-02-21 16:35:40'),
(12, 'admin', 'Deleted ', '2026-02-21 16:35:40'),
(13, 'admin', 'Deleted julian', '2026-02-21 16:39:03'),
(14, 'admin', 'Created user mentosjulian', '2026-02-21 16:39:09'),
(15, 'admin', 'Deleted ', '2026-02-21 16:39:09'),
(16, 'mentosjulian', 'Added item brownie', '2026-02-21 16:40:05'),
(17, 'admin', 'Elevated mentosjulian', '2026-02-21 16:40:52'),
(18, 'admin', 'Created user julian', '2026-02-21 16:40:58'),
(19, 'admin', 'Elevated mentosjulian', '2026-02-21 16:40:58'),
(20, 'mentosjulian', 'Deleted mentosjulian', '2026-02-21 16:41:08'),
(21, 'julian', 'Updated item ID 1', '2026-02-21 16:41:48'),
(22, 'admin', 'Elevated julian', '2026-02-21 16:42:36'),
(23, 'admin', 'Created user mentosjulian', '2026-02-21 16:43:26'),
(24, 'admin', 'Deleted julian', '2026-02-21 16:51:40'),
(25, 'admin', 'Deleted mentosjulian', '2026-02-21 16:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `is_main_admin` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `is_main_admin`) VALUES
(1, 'admin', '3fc0a7acf087f549ac2b266baf94b8b1', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_history`
--
ALTER TABLE `inventory_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

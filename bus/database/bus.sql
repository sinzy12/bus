-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 20, 2025 at 03:39 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$....hashed_password....'),
(2, 'admin2', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `booking_report`
--

CREATE TABLE `booking_report` (
  `report_id` int NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `seats` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_n` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Slip` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_report`
--

INSERT INTO `booking_report` (`report_id`, `route`, `date`, `time`, `seats`, `user_n`, `booking_time`, `Slip`) VALUES
(189, 'รอบสอง', '2025-02-23', '07:30-08:30', '5', 'บิ๊ก22123', '2025-02-13 10:06:06', 'uploads/pack_icon.png'),
(190, 'รอบแรก', '2025-02-19', '09:00-10:00', '16', 'wqe', '2025-02-17 07:26:04', 'uploads/image_2025-02-17_142603672.png'),
(191, 'อุตรดิตถ์ - พิชัย', '2025-02-18', '18:00-19:00', '1', 'ถถถ', '2025-02-17 07:43:01', 'uploads/41fcb1c0-b2c1-4ff1-9103-6b41497e9756.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_n` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `seats` int NOT NULL,
  `Slip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `route`, `date`, `time`, `user_n`, `seats`, `Slip`) VALUES
(205, 'รอบสอง', '2025-02-23', '07:30-08:30', 'บิ๊ก22123', 5, NULL),
(206, 'รอบแรก', '2025-02-19', '09:00-10:00', 'wqe', 16, NULL),
(207, 'อุตรดิตถ์ - พิชัย', '2025-02-18', '18:00-19:00', 'ถถถ', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `email`, `password`) VALUES
(1, 'phisitsad', 'phisit@gmail.com', '1234qweasd'),
(2, 'gg', 'gG@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(15) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `tel`) VALUES
(1, 'admin_user', '$2y$10$jKSZ45yKU3dP0s428LHiHuElQnkOm8KAp.h8bPMz2xhW2cHdMRaz.', '', ''),
(4, 'big55', '$2y$10$wC7yJLa0ErY8RVmbtmrULuSVwYC/BvBfX7NgpCTs0qW52hfiw1IC.', 'phis33it29x@gmail.com', '0123456789'),
(5, 'ad5555', '$2y$10$pyZoOBYkXqrD9WqxbMm3r.ieBUW.64xsifynrtLKikudOLnPj1ldu', 'phisitssr55529@gmail.com', '555'),
(6, 'gg', '$2y$10$QVEw9x8TVk7W4Zz9qz/2fOSWaODuSVj68LiEsnkjp3eF3CJku6bLu', 'gg@gmail.com', '000'),
(7, 'หฟก', '$2y$10$wxKZIRIqr3rMmZuL7Yz0nemzmYYPMCKlL8SsAszd44N1WuOjYgDxO', 'asda@sad.com', 'ฟหก'),
(8, 'gg2', '$2y$10$jusEn8Cev8lo1Yq805yUk.H96.NrC9Ay3jlPsReAbyQx6Ax9mBZaO', '1234@h.vom', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_report`
--
ALTER TABLE `booking_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_report`
--
ALTER TABLE `booking_report`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

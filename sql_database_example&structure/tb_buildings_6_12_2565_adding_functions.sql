-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2022 at 05:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dormitory_kmutnb_pri`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_buildings`
--

CREATE TABLE `tb_buildings` (
  `building_id` int(255) NOT NULL,
  `building_name` varchar(100) NOT NULL,
  `building_gender` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_buildings`
--

INSERT INTO `tb_buildings` (`building_id`, `building_name`, `building_gender`, `created_at`, `updated_at`) VALUES
(1, 'หอพักชาย', 0, '2021-06-23 16:47:30', '2022-03-07 03:41:31'),
(2, 'หอพักหญิง 1', 1, '2021-06-23 16:47:30', '2021-11-19 18:30:28'),
(3, 'หอพักหญิง 2', 1, '2021-06-23 16:47:30', '2021-11-19 18:30:22'),
(9, 'หอพักใจ', 2, '2022-12-06 07:24:52', '2022-12-06 07:24:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_buildings`
--
ALTER TABLE `tb_buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_buildings`
--
ALTER TABLE `tb_buildings`
  MODIFY `building_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

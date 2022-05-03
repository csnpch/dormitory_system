-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2022 at 12:12 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

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
-- Table structure for table `tb_admins`
--

CREATE TABLE `tb_admins` (
  `adm_id` int(255) NOT NULL,
  `adm_username` varchar(50) NOT NULL,
  `adm_password` varchar(255) NOT NULL,
  `adm_salt` varchar(30) NOT NULL,
  `adm_fullname` varchar(80) NOT NULL,
  `adm_description` varchar(40) DEFAULT NULL,
  `adm_status` smallint(2) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admins`
--

INSERT INTO `tb_admins` (`adm_id`, `adm_username`, `adm_password`, `adm_salt`, `adm_fullname`, `adm_description`, `adm_status`, `created_at`, `updated_at`) VALUES
(5, 'gartoon', '290cf825d5b7133ee5002a09177d1adfd4efa4002fd48b243142926f7c6d9272', 'bkuUzt%%CTwk)LjfnKaS#%4uCgaMX', 'Oranong Boonpipat', '', 0, '2022-03-05 14:39:59', '2022-03-05 14:40:08'),
(6, 'admin', '2a5b26993eb253e4c2921898e9ca155d8badab1fdfb32d6b51dfc78fabd81743', '(92x6K7jD226k4Ng)a3)Ent', 'administrator', '', 0, '2022-04-30 10:10:50', '2022-04-30 10:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_books`
--

CREATE TABLE `tb_books` (
  `book_id` int(255) NOT NULL,
  `branch_id` int(255) DEFAULT NULL,
  `room_id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_books`
--

INSERT INTO `tb_books` (`book_id`, `branch_id`, `room_id`, `created_at`, `updated_at`) VALUES
(5, 1, 13, '2022-03-06 06:46:16', '2022-03-06 06:46:16'),
(6, 1, 14, '2022-03-06 06:46:16', '2022-03-06 06:46:16'),
(7, 1, 15, '2022-03-06 06:46:16', '2022-03-06 06:46:16'),
(8, 1, 16, '2022-03-06 06:46:16', '2022-03-06 06:46:16'),
(9, 1, 17, '2022-03-06 06:46:16', '2022-03-06 06:46:16'),
(10, 2, 18, '2022-03-06 06:46:16', '2022-03-06 06:56:03'),
(11, 2, 19, '2022-03-06 06:46:16', '2022-03-06 06:56:03'),
(12, 2, 20, '2022-03-06 06:46:16', '2022-03-06 06:56:03'),
(13, 2, 21, '2022-03-06 06:46:45', '2022-03-06 06:56:03'),
(14, 2, 22, '2022-03-06 06:46:45', '2022-03-06 06:56:03'),
(15, 3, 23, '2022-03-06 06:46:45', '2022-03-06 06:56:16'),
(16, 3, 24, '2022-03-06 06:46:45', '2022-03-06 06:56:16'),
(17, 3, 25, '2022-03-06 06:46:45', '2022-03-06 06:56:16'),
(18, 3, 26, '2022-03-06 06:46:45', '2022-03-06 06:56:16'),
(19, 3, 27, '2022-03-06 06:46:45', '2022-03-06 06:56:16'),
(20, 4, 28, '2022-03-06 06:46:45', '2022-03-06 06:56:31'),
(21, 4, 29, '2022-03-06 06:47:04', '2022-03-06 06:56:31'),
(22, 4, 30, '2022-03-06 06:47:04', '2022-03-06 06:56:31'),
(23, 4, 31, '2022-03-06 06:47:04', '2022-03-06 06:56:31'),
(24, 4, 32, '2022-03-06 06:47:04', '2022-03-06 06:56:31'),
(25, 5, 33, '2022-03-06 06:47:04', '2022-03-06 06:56:48'),
(26, 5, 34, '2022-03-06 06:47:04', '2022-03-06 06:56:48'),
(27, 5, 35, '2022-03-06 06:47:04', '2022-03-06 06:56:48'),
(28, 5, 36, '2022-03-06 06:47:04', '2022-03-06 06:56:48'),
(29, 5, 37, '2022-03-06 06:47:34', '2022-03-06 06:56:48'),
(30, 6, 38, '2022-03-06 06:47:34', '2022-03-06 06:57:48'),
(31, 6, 39, '2022-03-06 06:47:34', '2022-03-06 06:57:48'),
(32, 6, 40, '2022-03-06 06:47:34', '2022-03-06 06:57:48'),
(33, 6, 41, '2022-03-06 06:47:34', '2022-03-06 06:57:48'),
(34, 6, 42, '2022-03-06 06:47:34', '2022-03-06 06:57:48'),
(35, NULL, 43, '2022-03-06 06:47:34', '2022-03-06 07:18:44'),
(36, NULL, 44, '2022-03-06 06:47:34', '2022-03-06 07:18:44'),
(40, 7, 45, '2022-03-06 07:02:14', '2022-03-06 07:02:14'),
(41, 7, 46, '2022-03-06 07:02:14', '2022-03-06 07:02:14'),
(42, 7, 47, '2022-03-06 07:02:14', '2022-03-06 07:02:14'),
(43, 7, 48, '2022-03-06 07:02:14', '2022-03-06 07:02:14'),
(44, 7, 49, '2022-03-06 07:02:14', '2022-03-06 07:02:14'),
(45, 8, 50, '2022-03-06 07:02:26', '2022-03-06 07:02:26'),
(46, 8, 51, '2022-03-06 07:02:26', '2022-03-06 07:02:26'),
(47, 8, 52, '2022-03-06 07:02:26', '2022-03-06 07:02:26'),
(48, 8, 53, '2022-03-06 07:02:26', '2022-03-06 07:02:26'),
(49, 8, 54, '2022-03-06 07:02:26', '2022-03-06 07:02:26'),
(50, 9, 55, '2022-03-06 07:02:37', '2022-03-06 07:02:37'),
(51, 9, 56, '2022-03-06 07:02:37', '2022-03-06 07:02:37'),
(52, 9, 57, '2022-03-06 07:02:37', '2022-03-06 07:02:37'),
(53, 9, 58, '2022-03-06 07:02:37', '2022-03-06 07:02:37'),
(54, 9, 59, '2022-03-06 07:02:37', '2022-03-06 07:02:37'),
(55, 10, 60, '2022-03-06 07:02:47', '2022-03-06 07:02:47'),
(56, 10, 61, '2022-03-06 07:02:47', '2022-03-06 07:02:47'),
(57, 10, 62, '2022-03-06 07:02:47', '2022-03-06 07:02:47'),
(58, 10, 63, '2022-03-06 07:02:47', '2022-03-06 07:02:47'),
(59, 10, 64, '2022-03-06 07:02:47', '2022-03-06 07:02:47'),
(60, 11, 65, '2022-03-06 07:03:01', '2022-03-06 07:03:01'),
(61, 11, 66, '2022-03-06 07:03:01', '2022-03-06 07:03:01'),
(62, 11, 67, '2022-03-06 07:03:01', '2022-03-06 07:03:01'),
(63, 11, 68, '2022-03-06 07:03:01', '2022-03-06 07:03:01'),
(64, 11, 69, '2022-03-06 07:03:01', '2022-03-06 07:03:01'),
(65, 12, 70, '2022-03-06 07:03:14', '2022-03-06 07:03:14'),
(66, 12, 71, '2022-03-06 07:03:14', '2022-03-06 07:03:14'),
(67, 12, 72, '2022-03-06 07:03:14', '2022-03-06 07:03:14'),
(68, 12, 73, '2022-03-06 07:03:14', '2022-03-06 07:03:14'),
(69, 12, 74, '2022-03-06 07:03:14', '2022-03-06 07:03:14'),
(70, NULL, 75, '2022-03-06 07:03:27', '2022-03-06 07:03:27'),
(71, NULL, 76, '2022-03-06 07:03:27', '2022-03-06 07:03:27'),
(72, 13, 77, '2022-03-06 07:03:56', '2022-03-06 07:03:56'),
(73, 13, 78, '2022-03-06 07:03:56', '2022-03-06 07:03:56'),
(74, 13, 79, '2022-03-06 07:03:56', '2022-03-06 07:03:56'),
(75, 13, 80, '2022-03-06 07:03:56', '2022-03-06 07:03:56'),
(76, 13, 81, '2022-03-06 07:03:56', '2022-03-06 07:03:56'),
(77, 14, 82, '2022-03-06 07:04:23', '2022-03-06 07:19:37'),
(78, 14, 84, '2022-03-06 07:04:23', '2022-03-06 07:19:37'),
(79, 14, 85, '2022-03-06 07:04:23', '2022-03-06 07:19:37'),
(80, 14, 86, '2022-03-06 07:04:23', '2022-03-06 07:19:37'),
(81, 14, 87, '2022-03-06 07:04:23', '2022-03-06 07:19:37'),
(82, 15, 88, '2022-03-06 07:05:00', '2022-03-06 07:19:48'),
(83, 15, 89, '2022-03-06 07:05:00', '2022-03-06 07:19:48'),
(84, 15, 90, '2022-03-06 07:05:00', '2022-03-06 07:19:48'),
(85, 15, 91, '2022-03-06 07:05:00', '2022-03-06 07:19:48'),
(86, 15, 92, '2022-03-06 07:05:00', '2022-03-06 07:19:48'),
(87, 16, 94, '2022-03-06 07:05:19', '2022-03-06 07:20:10'),
(88, 16, 93, '2022-03-06 07:05:19', '2022-03-06 07:20:10'),
(89, 16, 83, '2022-03-06 07:05:19', '2022-03-06 07:20:10'),
(90, 16, 95, '2022-03-06 07:05:19', '2022-03-06 07:20:10'),
(91, 16, 96, '2022-03-06 07:05:19', '2022-03-06 07:20:10'),
(92, 17, 97, '2022-03-06 07:06:59', '2022-03-06 07:20:24'),
(93, 17, 98, '2022-03-06 07:06:59', '2022-03-06 07:20:24'),
(94, 17, 99, '2022-03-06 07:06:59', '2022-03-06 07:20:24'),
(95, 17, 100, '2022-03-06 07:06:59', '2022-03-06 07:20:24'),
(96, 18, 101, '2022-03-06 07:07:14', '2022-03-06 07:20:45'),
(97, 18, 102, '2022-03-06 07:07:14', '2022-03-06 07:20:45'),
(98, 18, 103, '2022-03-06 07:07:14', '2022-03-06 07:20:45'),
(99, 18, 104, '2022-03-06 07:07:14', '2022-03-06 07:20:45'),
(100, 18, 105, '2022-03-06 07:07:14', '2022-03-06 07:20:45'),
(101, 19, 106, '2022-03-06 07:07:14', '2022-03-06 07:20:59'),
(102, 19, 107, '2022-03-06 07:07:28', '2022-03-06 07:20:59'),
(103, 19, 108, '2022-03-06 07:07:28', '2022-03-06 07:20:59'),
(104, 19, 109, '2022-03-06 07:07:28', '2022-03-06 07:20:59'),
(105, 19, 110, '2022-03-06 07:07:28', '2022-03-06 07:20:59'),
(106, 20, 111, '2022-03-06 07:07:28', '2022-03-06 07:21:11'),
(107, 20, 112, '2022-03-06 07:07:28', '2022-03-06 07:21:11'),
(108, 20, 113, '2022-03-06 07:07:42', '2022-03-06 07:21:11'),
(109, 20, 114, '2022-03-06 07:07:42', '2022-03-06 07:21:11'),
(110, 20, 115, '2022-03-06 07:07:42', '2022-03-06 07:21:11'),
(111, 21, 116, '2022-03-06 07:07:42', '2022-03-06 07:21:22'),
(112, 21, 118, '2022-03-06 07:07:42', '2022-03-06 07:21:22'),
(113, 21, 117, '2022-03-06 07:07:42', '2022-03-06 07:21:22'),
(114, 21, 119, '2022-03-06 07:08:05', '2022-03-06 07:21:22'),
(115, 21, 120, '2022-03-06 07:08:05', '2022-03-06 07:21:22'),
(116, NULL, 121, '2022-03-06 07:08:05', '2022-03-06 07:21:35'),
(117, NULL, 122, '2022-03-06 07:08:05', '2022-03-06 07:21:35'),
(118, NULL, 123, '2022-03-06 07:08:05', '2022-03-06 07:21:35'),
(119, NULL, 124, '2022-03-06 07:08:05', '2022-03-06 07:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `tb_branchs`
--

CREATE TABLE `tb_branchs` (
  `branch_id` int(255) NOT NULL,
  `fac_id` int(255) DEFAULT NULL,
  `branch_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_branchs`
--

INSERT INTO `tb_branchs` (`branch_id`, `fac_id`, `branch_name`, `created_at`, `updated_at`) VALUES
(0, NULL, '-', '2021-11-25 08:41:28', '2021-11-25 08:41:28'),
(1, 1, 'วิศวกรรมระบบเครื่องมือวัด (InSE)', '2021-06-23 16:47:57', '2022-03-05 14:11:31'),
(2, 2, 'วิทยาศาสตร์การอาหารและโภชนาการ (FSN)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(3, 2, 'เทคโนโลยีอุตสาหกรรมเกษตรและการจัดการ (FSM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(4, 2, 'พัฒนาผลิตภัณฑ์อุตสาหกรรมเกษตร (APD)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(5, 2, 'นวัตกรรมและเทคโนโลยีการพัฒนาผลิตภัณฑ์ (IPD)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(6, 3, 'การจัดการอุตสาหกรรม (IMT)', '2021-06-23 16:47:57', '2021-11-26 12:27:12'),
(7, 3, 'การจัดการอุตสาหกรรม (SMIM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(8, 3, 'เทคโนโลยีสารสนเทศ (IT)', '2021-06-23 16:47:57', '2021-11-24 17:39:07'),
(9, 3, 'เทคโนโลยีสารสนเทศ (ITI)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(10, 3, 'วิศวกรรมสารสนเทศและเครือข่าย (INE)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(11, 3, 'วิทยาการสารสนเทศประยุกต์ (MITM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(12, 3, 'วิทยาการสารสนเทศประยุกต์ (SMITM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(13, 3, 'คอมพิวเตอร์ช่วยออกแบบและบริหารงานก่อสร้าง (CA)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(14, 3, 'คอมพิวเตอร์ช่วยออกแบบและบริหารงานก่อสร้าง (CDM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(15, 3, 'เทคโนโลยีเครื่องจักรกลเกษตร (ATM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(16, 3, 'เทคโนโลยีเครื่องจักรกลเกษตร (TAM)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(17, 3, 'เทคโนโลยีเครื่องจักรกลเกษตร (TAT)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(18, 4, 'บริหารธุรกิจอุตสาหกรรมและการค้า (IBT)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(19, 4, 'บริหารธุรกิจอุตสาหกรรมและการค้า (IBTT)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(20, 4, 'บริหารธุรกิจอุตสาหกรรมและการค้า (MIBT)', '2021-06-23 16:47:57', '2021-06-23 16:47:57'),
(21, 4, 'บริหารธุรกิจอุตสาหกรรมและการค้า (SMIBT)', '2021-06-23 16:47:57', '2021-06-23 16:47:57');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_buildings`
--

INSERT INTO `tb_buildings` (`building_id`, `building_name`, `building_gender`, `created_at`, `updated_at`) VALUES
(1, 'หอพักชาย', 2, '2021-06-23 16:47:30', '2022-03-03 10:26:06'),
(2, 'หอพักหญิง 1', 1, '2021-06-23 16:47:30', '2021-11-19 18:30:28'),
(3, 'หอพักหญิง 2', 1, '2021-06-23 16:47:30', '2021-11-19 18:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_facultys`
--

CREATE TABLE `tb_facultys` (
  `fac_id` int(255) NOT NULL,
  `fac_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_facultys`
--

INSERT INTO `tb_facultys` (`fac_id`, `fac_name`, `created_at`, `updated_at`) VALUES
(1, 'วิศวกรรมศาสตร์', '2021-06-23 16:47:51', '2021-06-23 16:47:51'),
(2, 'อุตสาหกรรมเกษตร', '2021-06-23 16:47:51', '2021-11-24 14:38:07'),
(3, 'เทคโนโลยีและการจัดการอุตสาหกรรม', '2021-06-23 16:47:51', '2021-12-01 09:22:56'),
(4, 'บริหารธุรกิจและอุตสาหกรรมบริการ', '2021-06-23 16:47:51', '2021-06-23 16:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_familys`
--

CREATE TABLE `tb_familys` (
  `fam_id` int(255) NOT NULL,
  `std_id` int(255) NOT NULL,
  `fam_sex` smallint(2) NOT NULL,
  `fam_firstname` varchar(35) NOT NULL,
  `fam_lastname` varchar(35) NOT NULL,
  `fam_tel` varchar(15) NOT NULL,
  `fam_career` varchar(40) DEFAULT NULL,
  `fam_work_at` varchar(200) DEFAULT NULL,
  `fam_status` smallint(2) NOT NULL DEFAULT 1,
  `person_status` smallint(2) NOT NULL,
  `person_is` smallint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_familys`
--

INSERT INTO `tb_familys` (`fam_id`, `std_id`, `fam_sex`, `fam_firstname`, `fam_lastname`, `fam_tel`, `fam_career`, `fam_work_at`, `fam_status`, `person_status`, `person_is`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'สมชาย1', 'ยิ่งยศ', '0987654312', 'พนักงานบริษัท', 'สำนักงานพัฒนาชุมชน อำเภอโนนสูง จังหวัดนครราชสีมา', 1, 1, 1, '2021-08-13 11:13:12', '2021-12-19 15:45:16'),
(2, 1, 2, 'สมหญิง', 'มิ้งหมาย', '0912345672', 'ข้าราชการ', 'ทิปโก้แอลฟัลท์ นครราชสีมา', 1, 2, 2, '2021-08-13 11:13:12', '2021-12-19 15:45:16'),
(11, 6, 0, 'อติชาติ', 'สันตุน', '0915038969', 'พนักงานบริษัท', 'บริษัทเอสอาร์ จำกัด ชลบุรี', 1, 1, 1, '2022-03-05 15:09:46', '2022-03-05 15:09:46'),
(12, 6, 2, 'ดวงเดือน', 'สันตุน', '0952647340', 'พนักงานบริษัท', 'บริษัทเอสอาร์ จำกัด ชลบุรี', 1, 2, 2, '2022-03-05 15:09:46', '2022-03-05 15:09:46'),
(13, 7, 0, 'วิษณุ', 'ยมน้อย', '0863554032', 'พนักงานบริษัท', 'บริษัทอินเดลจำกัด มุกดาหาร', 1, 1, 1, '2022-03-05 15:49:52', '2022-03-05 15:49:52'),
(14, 7, 2, 'บุญจันทร์', 'บมน้อย', '0984457890', 'พนักงานบริษัท', 'บริษัทอินเดลจำกัด มุกดาหาร', 1, 2, 2, '2022-03-05 15:49:52', '2022-03-05 15:49:52'),
(15, 8, 0, 'asdasd123', 'asdasd123', 'asdasd123', 'asdasd123', 'asdasd123', 1, 1, 1, '2022-03-10 10:16:33', '2022-03-10 10:16:33'),
(16, 8, 2, 'asdasd123', 'asdasd123', 'asdasd123', 'asdasd123', 'asdasd123', 1, 2, 2, '2022-03-10 10:16:33', '2022-03-10 10:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fixs`
--

CREATE TABLE `tb_fixs` (
  `fix_id` int(11) NOT NULL,
  `std_id` int(11) DEFAULT NULL,
  `fix_detail` text NOT NULL,
  `fix_area` varchar(256) DEFAULT NULL,
  `fix_status` smallint(2) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_fixs`
--

INSERT INTO `tb_fixs` (`fix_id`, `std_id`, `fix_detail`, `fix_area`, `fix_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'โต๊ะยาวขาหัก', 'ใต้หอชาย', 0, '2022-03-01 16:41:30', '2022-03-01 16:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_floors`
--

CREATE TABLE `tb_floors` (
  `floor_id` int(255) NOT NULL,
  `building_id` int(255) NOT NULL,
  `floor_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_floors`
--

INSERT INTO `tb_floors` (`floor_id`, `building_id`, `floor_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'ชั้น 1', '2021-06-23 16:47:42', '2021-10-07 10:58:45'),
(2, 1, 'ชั้น 2', '2021-06-23 16:47:42', '2021-10-07 11:01:01'),
(3, 1, 'ชั้น 3', '2021-06-23 16:47:42', '2021-10-06 19:07:26'),
(4, 1, 'ชั้น 4', '2021-06-23 16:47:42', '2021-10-06 20:42:00'),
(5, 1, 'ชั้น 5', '2021-06-23 16:47:42', '2021-10-07 11:01:22'),
(6, 2, 'ชั้น 1', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(7, 2, 'ชั้น 2', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(8, 2, 'ชั้น 3', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(9, 2, 'ชั้น 4', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(10, 2, 'ชั้น 5', '2021-06-23 16:47:42', '2021-10-06 19:08:26'),
(11, 3, 'ชั้น 1', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(12, 3, 'ชั้น 2', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(13, 3, 'ชั้น 3', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(14, 3, 'ชั้น 4', '2021-06-23 16:47:42', '2021-06-23 16:47:42'),
(15, 3, 'ชั้น 5', '2021-06-23 16:47:42', '2021-10-06 19:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_news`
--

CREATE TABLE `tb_news` (
  `news_id` int(255) NOT NULL,
  `news_header` varchar(200) NOT NULL,
  `news_link_img` text DEFAULT NULL,
  `news_link_main` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_news`
--

INSERT INTO `tb_news` (`news_id`, `news_header`, `news_link_img`, `news_link_main`, `created_at`, `updated_at`) VALUES
(1, 'แจ้งรายชื่อคืนค่าธรรมเนียมหอพัก เทอม 2/2563', 'https://scontent.fnak3-1.fna.fbcdn.net/v/t39.30808-6/230416470_4445025982194625_2209175313587516729_n.jpg?_nc_cat=103&ccb=1-5&_nc_sid=0debeb&_nc_ohc=V9sulIV9ZZIAX9HI7ar&_nc_ht=scontent.fnak3-1.fna&oh=7ce1599a515eb7c6b5075b3e9f7f4907&oe=619BC7F6', 'https://www.facebook.com/media/set?vanity=225226107507988&set=a.4445028878861002', '2021-11-18 10:38:47', '2021-12-19 15:39:36'),
(2, 'ข้อปฏิบัติสำหรับนักศึกษาที่จะเข้าพักอาศัยหอพัก มจพ.ปราจีนบุรี', 'https://scontent.fnak3-1.fna.fbcdn.net/v/t39.30808-6/201648458_4439730502724173_6790846650173252622_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=0debeb&_nc_ohc=FTYCuWbARnMAX_ZlP4a&tn=s415-R5my2YCHhei&_nc_ht=scontent.fnak3-1.fna&oh=fe7ef2a374cc4a4206ecd5633f3428e9&oe=619BFB23', 'https://www.facebook.com/media/set?vanity=225226107507988&set=a.4439731072724116', '2021-11-18 10:39:10', '2021-12-19 15:39:28'),
(3, 'แบบฟอร์มจ่ายค่าธรรมเนียมหอพักภาคเรียน 1/2564', 'https://scontent.fnak3-1.fna.fbcdn.net/v/t1.6435-9/187033751_4238704356160123_1927512122548820499_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=0debeb&_nc_ohc=PruhZNNxwRQAX-cTcql&tn=s415-R5my2YCHhei&_nc_ht=scontent.fnak3-1.fna&oh=71ce8ada51f2f2dd20c22c5c2cd5e5d3&oe=61BB2715', 'https://www.facebook.com/media/set/?vanity=225226107507988&set=a.4238849449478947', '2021-11-18 10:41:32', '2021-11-28 16:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rooms`
--

CREATE TABLE `tb_rooms` (
  `room_id` int(255) NOT NULL,
  `floor_id` int(255) NOT NULL,
  `room_name` varchar(10) NOT NULL,
  `room_member` smallint(2) NOT NULL,
  `room_status` smallint(2) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_rooms`
--

INSERT INTO `tb_rooms` (`room_id`, `floor_id`, `room_name`, `room_member`, `room_status`, `created_at`, `updated_at`) VALUES
(6, 1, 'E103', 5, 1, '2022-03-06 06:02:09', '2022-03-06 06:02:09'),
(7, 1, 'E104', 5, 1, '2022-03-06 06:02:19', '2022-03-06 06:02:19'),
(8, 1, 'E105', 5, 1, '2022-03-06 06:02:29', '2022-03-06 06:02:29'),
(9, 1, 'E106', 5, 1, '2022-03-06 06:02:37', '2022-03-06 06:02:37'),
(10, 1, 'E107', 5, 1, '2022-03-06 06:02:46', '2022-03-06 06:02:46'),
(11, 1, 'E108', 5, 1, '2022-03-06 06:02:59', '2022-03-06 06:02:59'),
(12, 1, 'E109', 5, 1, '2022-03-06 06:03:06', '2022-03-06 06:03:06'),
(13, 2, 'E202', 5, 1, '2022-03-06 06:03:49', '2022-03-06 06:03:49'),
(14, 2, 'E203', 5, 1, '2022-03-06 06:03:59', '2022-03-06 06:03:59'),
(15, 2, 'E204', 5, 1, '2022-03-06 06:04:13', '2022-03-06 06:04:44'),
(16, 2, 'E205', 5, 1, '2022-03-06 06:04:25', '2022-03-06 06:04:52'),
(17, 2, 'E206', 5, 1, '2022-03-06 06:04:33', '2022-03-06 06:04:33'),
(18, 2, 'E207', 5, 1, '2022-03-06 06:05:11', '2022-03-06 06:05:11'),
(19, 2, 'E208', 5, 1, '2022-03-06 06:05:22', '2022-03-06 06:05:22'),
(20, 2, 'E209', 5, 1, '2022-03-06 06:05:32', '2022-03-06 06:05:32'),
(21, 2, 'E211', 5, 1, '2022-03-06 06:05:55', '2022-03-06 06:05:55'),
(22, 2, 'E212', 5, 1, '2022-03-06 06:06:06', '2022-03-06 06:06:06'),
(23, 2, 'E213', 5, 1, '2022-03-06 06:06:14', '2022-03-06 06:06:14'),
(24, 2, 'E214', 5, 1, '2022-03-06 06:06:26', '2022-03-06 06:06:26'),
(25, 2, 'E215', 5, 1, '2022-03-06 06:06:37', '2022-03-06 06:06:37'),
(26, 2, 'E216', 5, 1, '2022-03-06 06:06:46', '2022-03-06 06:06:46'),
(27, 2, 'E217', 5, 1, '2022-03-06 06:06:57', '2022-03-06 06:06:57'),
(28, 2, 'E218', 5, 1, '2022-03-06 06:07:07', '2022-03-06 06:07:07'),
(29, 2, 'E220', 5, 1, '2022-03-06 06:07:29', '2022-03-06 06:07:29'),
(30, 2, 'E221', 5, 1, '2022-03-06 06:07:39', '2022-03-06 06:07:39'),
(31, 2, 'E222', 5, 1, '2022-03-06 06:07:50', '2022-03-06 06:07:50'),
(32, 2, 'E223', 5, 1, '2022-03-06 06:07:58', '2022-03-06 06:07:58'),
(33, 2, 'E224', 5, 1, '2022-03-06 06:08:08', '2022-03-06 06:08:08'),
(34, 2, 'E225', 5, 1, '2022-03-06 06:08:21', '2022-03-06 06:08:21'),
(35, 2, 'E226', 5, 1, '2022-03-06 06:08:29', '2022-03-06 06:08:29'),
(36, 2, 'E227', 5, 1, '2022-03-06 06:08:37', '2022-03-06 06:08:37'),
(37, 2, 'E229', 5, 1, '2022-03-06 06:08:48', '2022-03-06 06:08:48'),
(38, 2, 'E230', 5, 1, '2022-03-06 06:08:58', '2022-03-06 06:08:58'),
(39, 2, 'E231', 5, 1, '2022-03-06 06:09:07', '2022-03-06 06:09:07'),
(40, 2, 'E232', 5, 1, '2022-03-06 06:09:19', '2022-03-06 06:09:19'),
(41, 2, 'E233', 5, 1, '2022-03-06 06:09:30', '2022-03-06 06:09:30'),
(42, 2, 'E234', 5, 1, '2022-03-06 06:09:38', '2022-03-06 06:09:38'),
(43, 2, 'E235', 5, 1, '2022-03-06 06:09:45', '2022-03-06 06:09:45'),
(44, 2, 'E236', 5, 1, '2022-03-06 06:09:54', '2022-03-06 06:09:54'),
(45, 3, 'E302', 5, 1, '2022-03-06 06:11:04', '2022-03-06 06:11:04'),
(46, 3, 'E303', 5, 1, '2022-03-06 06:11:12', '2022-03-06 06:11:12'),
(47, 3, 'E304', 5, 1, '2022-03-06 06:14:39', '2022-03-06 06:14:39'),
(48, 3, 'E305', 5, 1, '2022-03-06 06:14:55', '2022-03-06 06:14:55'),
(49, 3, 'E306', 5, 1, '2022-03-06 06:17:16', '2022-03-06 06:17:16'),
(50, 3, 'E307', 5, 1, '2022-03-06 06:17:53', '2022-03-06 06:17:53'),
(51, 3, 'E308', 5, 1, '2022-03-06 06:19:38', '2022-03-06 06:19:38'),
(52, 3, 'E309', 5, 1, '2022-03-06 06:19:48', '2022-03-06 06:19:48'),
(53, 3, 'E311', 5, 1, '2022-03-06 06:20:36', '2022-03-06 06:21:54'),
(54, 3, 'E312', 5, 1, '2022-03-06 06:22:09', '2022-03-06 06:22:09'),
(55, 3, 'E313', 5, 1, '2022-03-06 06:22:20', '2022-03-06 06:22:20'),
(56, 3, 'E314', 5, 1, '2022-03-06 06:22:34', '2022-03-06 06:22:34'),
(57, 3, 'E315', 5, 1, '2022-03-06 06:22:45', '2022-03-06 06:22:45'),
(58, 3, 'E316', 5, 1, '2022-03-06 06:22:54', '2022-03-06 06:22:54'),
(59, 3, 'E317', 5, 1, '2022-03-06 06:23:04', '2022-03-06 06:23:04'),
(60, 3, 'E318', 5, 1, '2022-03-06 06:23:13', '2022-03-06 06:23:13'),
(61, 3, 'E320', 5, 1, '2022-03-06 06:23:22', '2022-03-06 06:23:22'),
(62, 3, 'E321', 5, 1, '2022-03-06 06:23:31', '2022-03-06 06:23:31'),
(63, 3, 'E322', 5, 1, '2022-03-06 06:23:49', '2022-03-06 06:23:49'),
(64, 3, 'E323', 5, 1, '2022-03-06 06:24:07', '2022-03-06 06:24:07'),
(65, 3, 'E324', 5, 1, '2022-03-06 06:24:24', '2022-03-06 06:24:24'),
(66, 3, 'E325', 5, 1, '2022-03-06 06:24:36', '2022-03-06 06:24:36'),
(67, 3, 'E326', 5, 1, '2022-03-06 06:24:50', '2022-03-06 06:24:50'),
(68, 3, 'E327', 5, 1, '2022-03-06 06:25:01', '2022-03-06 06:25:01'),
(69, 3, 'E329', 5, 1, '2022-03-06 06:25:12', '2022-03-06 06:25:12'),
(70, 3, 'E330', 5, 1, '2022-03-06 06:25:21', '2022-03-06 06:25:21'),
(71, 3, 'E331', 5, 1, '2022-03-06 06:25:32', '2022-03-06 06:25:32'),
(72, 3, 'E332', 5, 1, '2022-03-06 06:25:44', '2022-03-06 06:25:44'),
(73, 3, 'E333', 5, 1, '2022-03-06 06:25:52', '2022-03-06 06:25:52'),
(74, 3, 'E334', 5, 1, '2022-03-06 06:26:06', '2022-03-06 06:26:06'),
(75, 3, 'E335', 5, 1, '2022-03-06 06:26:13', '2022-03-06 06:26:13'),
(76, 3, 'E336', 5, 1, '2022-03-06 06:26:21', '2022-03-06 06:26:21'),
(77, 4, 'E402', 5, 1, '2022-03-06 06:27:24', '2022-03-06 06:27:24'),
(78, 4, 'E403', 5, 1, '2022-03-06 06:27:33', '2022-03-06 06:27:33'),
(79, 4, 'E404', 5, 1, '2022-03-06 06:27:42', '2022-03-06 06:27:42'),
(80, 4, 'E405', 5, 1, '2022-03-06 06:27:53', '2022-03-06 06:27:53'),
(81, 4, 'E406', 5, 1, '2022-03-06 06:28:01', '2022-03-06 06:28:01'),
(82, 4, 'E407', 5, 1, '2022-03-06 06:28:10', '2022-03-06 06:28:10'),
(83, 4, 'E421', 5, 1, '2022-03-06 06:28:19', '2022-03-06 06:30:52'),
(84, 4, 'E408', 5, 1, '2022-03-06 06:28:30', '2022-03-06 06:28:30'),
(85, 4, 'E409', 5, 1, '2022-03-06 06:28:38', '2022-03-06 06:28:38'),
(86, 4, 'E411', 5, 1, '2022-03-06 06:28:47', '2022-03-06 06:28:47'),
(87, 4, 'E412', 5, 1, '2022-03-06 06:28:56', '2022-03-06 06:28:56'),
(88, 4, 'E413', 5, 1, '2022-03-06 06:29:05', '2022-03-06 06:29:05'),
(89, 4, 'E414', 5, 1, '2022-03-06 06:29:13', '2022-03-06 06:29:13'),
(90, 4, 'E415', 5, 1, '2022-03-06 06:29:21', '2022-03-06 06:29:21'),
(91, 4, 'E416', 5, 1, '2022-03-06 06:29:30', '2022-03-06 06:29:30'),
(92, 4, 'E417', 5, 1, '2022-03-06 06:29:40', '2022-03-06 06:29:40'),
(93, 4, 'E420', 5, 1, '2022-03-06 06:29:51', '2022-03-06 06:30:34'),
(94, 4, 'E418', 5, 1, '2022-03-06 06:30:01', '2022-03-06 06:30:01'),
(95, 4, 'E422', 5, 1, '2022-03-06 06:31:09', '2022-03-06 06:31:09'),
(96, 4, 'E423', 5, 1, '2022-03-06 06:31:21', '2022-03-06 06:31:21'),
(97, 4, 'E424', 5, 1, '2022-03-06 06:31:29', '2022-03-06 06:31:29'),
(98, 4, 'E425', 5, 1, '2022-03-06 06:31:38', '2022-03-06 06:31:38'),
(99, 4, 'E426', 5, 1, '2022-03-06 06:31:46', '2022-03-06 06:31:46'),
(100, 4, 'E427', 5, 1, '2022-03-06 06:31:54', '2022-03-06 06:31:54'),
(101, 5, 'E502', 5, 1, '2022-03-06 06:32:53', '2022-03-06 06:32:53'),
(102, 5, 'E503', 5, 1, '2022-03-06 06:33:02', '2022-03-06 06:33:02'),
(103, 5, 'E504', 5, 1, '2022-03-06 06:33:10', '2022-03-06 06:33:10'),
(104, 5, 'E505', 5, 1, '2022-03-06 06:33:17', '2022-03-06 06:33:17'),
(105, 5, 'E506', 5, 1, '2022-03-06 06:33:29', '2022-03-06 06:33:29'),
(106, 5, 'E507', 5, 1, '2022-03-06 06:33:39', '2022-03-06 06:33:39'),
(107, 5, 'E508', 5, 1, '2022-03-06 06:33:48', '2022-03-06 06:33:48'),
(108, 5, 'E509', 5, 1, '2022-03-06 06:33:59', '2022-03-06 06:33:59'),
(109, 5, 'E511', 5, 1, '2022-03-06 06:34:17', '2022-03-06 06:34:17'),
(110, 5, 'E512', 5, 1, '2022-03-06 06:34:26', '2022-03-06 06:34:26'),
(111, 5, 'E513', 5, 1, '2022-03-06 06:34:35', '2022-03-06 06:34:35'),
(112, 5, 'E514', 5, 1, '2022-03-06 06:34:43', '2022-03-06 06:34:43'),
(113, 5, 'E515', 5, 1, '2022-03-06 06:34:51', '2022-03-06 06:34:51'),
(114, 5, 'E516', 5, 1, '2022-03-06 06:35:01', '2022-03-06 06:35:01'),
(115, 5, 'E517', 5, 1, '2022-03-06 06:35:09', '2022-03-06 06:35:09'),
(116, 5, 'E518', 5, 1, '2022-03-06 06:35:26', '2022-03-06 06:35:26'),
(117, 5, 'E521', 5, 1, '2022-03-06 06:35:39', '2022-03-06 06:36:18'),
(118, 5, 'E520', 5, 1, '2022-03-06 06:35:58', '2022-03-06 06:35:58'),
(119, 5, 'E522', 5, 1, '2022-03-06 06:36:27', '2022-03-06 06:36:27'),
(120, 5, 'E523', 5, 1, '2022-03-06 06:36:34', '2022-03-06 06:36:34'),
(121, 5, 'E524', 5, 1, '2022-03-06 06:36:42', '2022-03-06 06:36:42'),
(122, 5, 'E525', 5, 1, '2022-03-06 06:36:50', '2022-03-06 06:36:50'),
(123, 5, 'E526', 5, 1, '2022-03-06 06:37:01', '2022-03-06 06:37:01'),
(124, 5, 'E527', 5, 1, '2022-03-06 06:37:09', '2022-03-06 06:37:09'),
(125, 1, 'E102', 5, 1, '2022-03-06 06:40:41', '2022-03-06 06:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL,
  `status_date_start` varchar(20) DEFAULT NULL,
  `status_date_stop` varchar(20) DEFAULT NULL,
  `status_switch` smallint(2) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`status_id`, `status_name`, `status_date_start`, `status_date_stop`, `status_switch`, `created_at`, `update_at`) VALUES
(1, 'system_book', '03/07/2022', '03/08/2022', 1, '2021-07-31 16:43:43', '2022-03-03 10:33:00'),
(2, 'system_register', NULL, NULL, 1, '2021-11-30 13:30:48', '2022-03-01 16:45:31'),
(3, 'system_main', NULL, NULL, 0, '2021-11-30 13:30:48', '2022-03-03 10:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_students`
--

CREATE TABLE `tb_students` (
  `std_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `std_status` smallint(2) NOT NULL,
  `std_username` varchar(25) NOT NULL,
  `std_password` varchar(255) NOT NULL,
  `std_salt` varchar(30) NOT NULL,
  `std_sex` smallint(2) NOT NULL,
  `std_firstname` varchar(35) NOT NULL,
  `std_lastname` varchar(35) NOT NULL,
  `std_nickname` varchar(20) NOT NULL,
  `std_address` text NOT NULL,
  `std_idcard` varchar(15) NOT NULL,
  `std_blood` smallint(2) NOT NULL,
  `std_religion` smallint(2) NOT NULL,
  `std_birthday` date NOT NULL,
  `std_id_student` varchar(15) DEFAULT NULL,
  `std_tel` varchar(15) NOT NULL,
  `std_email` varchar(50) NOT NULL,
  `std_edu_academy` varchar(50) NOT NULL,
  `std_edu_degree` smallint(2) NOT NULL,
  `std_edu_comple` varchar(50) NOT NULL,
  `std_sponsor` smallint(2) NOT NULL,
  `std_howmuch` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_students`
--

INSERT INTO `tb_students` (`std_id`, `branch_id`, `room_id`, `std_status`, `std_username`, `std_password`, `std_salt`, `std_sex`, `std_firstname`, `std_lastname`, `std_nickname`, `std_address`, `std_idcard`, `std_blood`, `std_religion`, `std_birthday`, `std_id_student`, `std_tel`, `std_email`, `std_edu_academy`, `std_edu_degree`, `std_edu_comple`, `std_sponsor`, `std_howmuch`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 0, 'ChitsanuphongChaihong', '5a32f36a08b27efa1146df151e278c6bc819f92c64acfced344625bc21dea755', '-gSrFyE1(#79#Rr@)A#G', 0, 'ชิษณุพงศ์', 'ไชยหงษ์', 'หมูแฮม', '684/1  ม.1 ต.สุรนารี อ.เมืองนครราชสีมา จ.นครราชสีมา 30000', '1309902912822', 3, 5, '2001-11-02', '6306021621138', '0999773491', 'Inwza111@email.com', 'วิทยาลัยเทคนิคนครราชสีมา', 2, '2562', 10, 3800, '2031-12-23 15:41:33', '2022-03-06 07:33:27'),
(6, 6, NULL, 1, 'Suphatsara', '1784bedbd559019e796b4d1c032e4e80b42f7de203b9f6b513c6f3f5b3f37615', 'js7L3Z3FvW9Umm1f56A39i-', 1, 'สุภัสสรา', 'สันตุน', 'เฟิร์น', '79/2 หมู่บ้านป่าซอง ม.9 ต.ตาพระยา อ.ตาพระยา จ.สระแก้ว 27180', '1209000031587', 2, 0, '2003-09-07', '1209000031587', '0803015210', 'suphatsara@gmail.com', 'โรงเรียนทัพราชวิทยา', 2, '2564', 10, 7800, '2022-03-05 15:09:46', '2022-03-05 15:09:46'),
(7, 18, NULL, 0, 'fasai', '98c66c9bb4aae0762def4c46b2cae87548c8055cb595ff4a90b811b55830da02', 'T8nhe-)Dd2Fr-8ViwnvT+-WNzmm', 1, 'ฟ้าใส', 'ยมน้อย', 'ฟ้า', '900/4 หมู่บ้านกุดเวียน ม.5 ต.โคกไทย อ.ศรีมโหสถ จ.ปราจีนบุรี 25190', '1208028383451', 0, 0, '2002-10-10', '6306021021542', '0986723310', 'Fasai@gmail.com', 'โรงเรียนศรีมโหสถ', 1, '2562', 10, 6500, '2022-03-05 15:49:52', '2022-03-05 15:49:52'),
(8, 19, NULL, 1, 'asdasd123', '879287abab19aeee64305e982fc8f0df6cad12c0ee2f8ab9d8fa59d79c8bd797', 'u#BWM5JQKes(a6QM7nP4BkyjE5gB', 0, 'asdasd123', 'asdasd123', 'asdasd123', 'asdasd123 ม.asdasd123 ต.asdasd123 อ.asdasd123 จ.asdasd123 asdasd123', 'asdasd123', 0, 0, '2022-03-11', 'asdasd123', 'asdasd123', 'asdasd123@asfaf.com', 'asdasd123', 2, 'asda', 10, 0, '2022-03-10 10:16:33', '2022-03-10 10:16:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admins`
--
ALTER TABLE `tb_admins`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `tb_books`
--
ALTER TABLE `tb_books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `rom_id` (`room_id`);

--
-- Indexes for table `tb_branchs`
--
ALTER TABLE `tb_branchs`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `tb_branchs_ibfk_1` (`fac_id`);

--
-- Indexes for table `tb_buildings`
--
ALTER TABLE `tb_buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `tb_facultys`
--
ALTER TABLE `tb_facultys`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indexes for table `tb_familys`
--
ALTER TABLE `tb_familys`
  ADD PRIMARY KEY (`fam_id`),
  ADD KEY `std_id` (`std_id`) USING BTREE;

--
-- Indexes for table `tb_fixs`
--
ALTER TABLE `tb_fixs`
  ADD PRIMARY KEY (`fix_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `tb_floors`
--
ALTER TABLE `tb_floors`
  ADD PRIMARY KEY (`floor_id`),
  ADD KEY `building_id` (`building_id`);

--
-- Indexes for table `tb_news`
--
ALTER TABLE `tb_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tb_students`
--
ALTER TABLE `tb_students`
  ADD PRIMARY KEY (`std_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `rom_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admins`
--
ALTER TABLE `tb_admins`
  MODIFY `adm_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_books`
--
ALTER TABLE `tb_books`
  MODIFY `book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `tb_branchs`
--
ALTER TABLE `tb_branchs`
  MODIFY `branch_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_buildings`
--
ALTER TABLE `tb_buildings`
  MODIFY `building_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_facultys`
--
ALTER TABLE `tb_facultys`
  MODIFY `fac_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_familys`
--
ALTER TABLE `tb_familys`
  MODIFY `fam_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_fixs`
--
ALTER TABLE `tb_fixs`
  MODIFY `fix_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_floors`
--
ALTER TABLE `tb_floors`
  MODIFY `floor_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_news`
--
ALTER TABLE `tb_news`
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  MODIFY `room_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `tb_status`
--
ALTER TABLE `tb_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_students`
--
ALTER TABLE `tb_students`
  MODIFY `std_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_books`
--
ALTER TABLE `tb_books`
  ADD CONSTRAINT `tb_books_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `tb_branchs` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_books_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `tb_rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_branchs`
--
ALTER TABLE `tb_branchs`
  ADD CONSTRAINT `fac_id` FOREIGN KEY (`fac_id`) REFERENCES `tb_facultys` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_familys`
--
ALTER TABLE `tb_familys`
  ADD CONSTRAINT `tb_familys_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `tb_students` (`std_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_fixs`
--
ALTER TABLE `tb_fixs`
  ADD CONSTRAINT `std_id` FOREIGN KEY (`std_id`) REFERENCES `tb_students` (`std_id`) ON DELETE SET NULL;

--
-- Constraints for table `tb_floors`
--
ALTER TABLE `tb_floors`
  ADD CONSTRAINT `tb_floors_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `tb_buildings` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  ADD CONSTRAINT `tb_rooms_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `tb_floors` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_students`
--
ALTER TABLE `tb_students`
  ADD CONSTRAINT `tb_students_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `tb_branchs` (`branch_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_students_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `tb_rooms` (`room_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

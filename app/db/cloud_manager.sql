-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 05:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloud_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_profile` varchar(255) DEFAULT NULL,
  `user_pathid` varchar(255) DEFAULT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_pass_key` varchar(255) DEFAULT NULL,
  `user_attempt` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facebook_users`
--

INSERT INTO `facebook_users` (`user_id`, `user_email`, `user_name`, `user_profile`, `user_pathid`, `user_timestamp`, `user_pass_key`, `user_attempt`) VALUES
(4, NULL, 'AX Buero', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=1598033444448039&height=50&width=50&ext=1727951981&hash=Abb3tBj9ofw-y-DB3BFQzYlK', NULL, '2024-09-03 10:39:47', NULL, NULL),
(5, 'patelzaid721@gmail.com', 'AX Buero', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=1598033444448039&height=50&width=50&ext=1727964306&hash=AbZAHmGYvQ6eFNN-vI1bE9Uf', NULL, '2024-09-03 14:05:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `fid` int(11) NOT NULL,
  `file_uploader_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(15) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_id` text DEFAULT NULL,
  `file_last_viewed` timestamp NULL DEFAULT NULL,
  `file_visibility` varchar(255) NOT NULL DEFAULT '0',
  `file_perms` varchar(10) DEFAULT 'rw',
  `file_timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`fid`, `file_uploader_id`, `file_name`, `file_size`, `file_type`, `file_id`, `file_last_viewed`, `file_visibility`, `file_perms`, `file_timestamp`) VALUES
(188, 4, 'images-removebg-preview.png', 31322, 'image/png', '4_z47baf7917997390d92130812_f10417dd4d333d04a_d20240909_m070119_c002_v0001127_t0022_u01725865279570', NULL, '0', 'rw', '2024-09-09 07:01:34'),
(189, 4, 'file-management-administration-data-filing-concept-folder-gallery-records-database-flat-illustration-vector-template_128772-1923.webp', 6799, 'image/webp', '4_z47baf7917997390d92130812_f1183bef3a5b7590a_d20240909_m070125_c002_v0001124_t0009_u01725865285028', '2024-09-09 07:01:41', '0', 'rw', '2024-09-09 07:01:41'),
(190, 4, 'fetch_err.png', 36262, 'image/png', '4_z47baf7917997390d92130812_f1040facd94742250_d20240909_m070134_c002_v0001133_t0046_u01725865294951', NULL, '0', 'rw', '2024-09-09 07:01:48'),
(191, 4, 'default.png', 29226, 'image/png', '4_z47baf7917997390d92130812_f104b7004d8b6e28b_d20240909_m070142_c002_v0001126_t0043_u01725865302269', NULL, '0', 'rw', '2024-09-09 07:01:55'),
(192, 4, '3d-illustration-of-file-management-folder-upload-png.webp', 16300, 'image/webp', '4_z47baf7917997390d92130812_f11018e0f1f5f9edb_d20240909_m160245_c002_v0203010_t0011_u01725897765330', NULL, '0', 'rw', '2024-09-09 16:02:57'),
(193, 3, 'brand_logo - Copy.png', 2804, 'image/png', '4_z47baf7917997390d92130812_f111bf2e8c014a1a0_d20240910_m113003_c002_v0203001_t0018_u01725967803022', NULL, '0', 'rw', '2024-09-10 11:30:13'),
(194, 3, 'nofiles.png', 80495, 'image/png', '4_z47baf7917997390d92130812_f111f2d9f05e0808f_d20240911_m151420_c002_v0203004_t0049_u01726067660661', NULL, '0', 'rw', '2024-09-11 15:14:34'),
(195, 3, 'nofiles (2).png', 130851, 'image/png', '4_z47baf7917997390d92130812_f106c009abcf71710_d20240911_m151425_c002_v0203008_t0027_u01726067665039', NULL, '0', 'rw', '2024-09-11 15:14:37'),
(196, 3, 'no-data-concept-illustration_86047-486.png', 5973, 'image/png', '4_z47baf7917997390d92130812_f1094dbfef0e137b6_d20240911_m151429_c002_v0001162_t0020_u01726067669811', NULL, '0', 'rw', '2024-09-11 15:14:41'),
(197, 3, 'images-removebg-preview.png', 31322, 'image/png', '4_z47baf7917997390d92130812_f119af1adc879f211_d20240911_m151433_c002_v0203010_t0040_u01726067673709', NULL, '0', 'rw', '2024-09-11 15:14:45'),
(198, 3, 'file-management-administration-data-filing-concept-folder-gallery-records-database-flat-illustration-vector-template_128772-1923.webp', 6799, 'image/webp', '4_z47baf7917997390d92130812_f11495fc70de04fe9_d20240911_m151437_c002_v0001159_t0040_u01726067677718', NULL, '0', 'rw', '2024-09-11 15:14:49'),
(199, 3, 'fetch_err.png', 36262, 'image/png', '4_z47baf7917997390d92130812_f112608a68cfa9cea_d20240911_m151441_c002_v0203009_t0021_u01726067681629', NULL, '0', 'rw', '2024-09-11 15:14:53'),
(200, 3, 'default.png', 29226, 'image/png', '4_z47baf7917997390d92130812_f1054930f20e69de5_d20240911_m151445_c002_v0203010_t0014_u01726067685676', NULL, '0', 'rw', '2024-09-11 15:14:57'),
(201, 3, 'brand_logo.webp', 2804, 'image/webp', '4_z47baf7917997390d92130812_f1046db534f4db2b7_d20240911_m151449_c002_v0203009_t0038_u01726067689588', NULL, '0', 'rw', '2024-09-11 15:15:00'),
(202, 3, 'brand_logo - Copy.png', 2804, 'image/png', '4_z47baf7917997390d92130812_f1009a6cb8157dbdb_d20240911_m151453_c002_v0001141_t0039_u01726067693267', NULL, '0', 'rw', '2024-09-11 15:15:06'),
(203, 3, '3d-illustration-of-file-management-folder-upload-png.webp', 16300, 'image/webp', '4_z47baf7917997390d92130812_f107997259436fe8c_d20240911_m151458_c002_v0001160_t0034_u01726067698940', NULL, '0', 'rw', '2024-09-11 15:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_profile` varchar(255) DEFAULT NULL,
  `user_pathid` varchar(255) DEFAULT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_pass_key` varchar(255) DEFAULT NULL,
  `user_attempt` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `google_users`
--

INSERT INTO `google_users` (`user_id`, `user_email`, `user_name`, `user_profile`, `user_pathid`, `user_timestamp`, `user_pass_key`, `user_attempt`) VALUES
(3, 'patelzaid721@gmail.com', 'ZAID PATEL', 'https://lh3.googleusercontent.com/a/ACg8ocJsg1aqNXwmAbKITmds2jRnhdoVyzH2dEJWRkRBL_jHcCoGE2Y0=s96-c', NULL, '2024-09-03 09:59:42', NULL, NULL),
(4, 'marshallzaid721@gmail.com', 'zaid deve', 'https://lh3.googleusercontent.com/a/ACg8ocJk6-LvVAzfHAwBF3F75nvLY6B489ALVkZfnBtIJYgc0yXh5A=s96-c', NULL, '2024-09-03 17:04:14', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facebook_users`
--
ALTER TABLE `facebook_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_pathid` (`user_pathid`);

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `google_users`
--
ALTER TABLE `google_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_pathid` (`user_pathid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

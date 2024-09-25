-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 05:33 AM
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
(5, 'patelzaid721@gmail.com', 'AX Buero 5', 'https://localhost/cfs/app/profiles/profile_66ed82ba166ef7.89948942.png', NULL, '2024-09-03 14:05:12', '$2y$10$el0mPc3831CWE.JzFKWMNesmq35nOk.HkMmBR/SJAvRoRXA1DMMky', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `fid` int(11) NOT NULL,
  `file_uploader_id` varchar(50) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `x_bz_name` varchar(255) DEFAULT NULL,
  `file_size` int(15) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_id` text DEFAULT NULL,
  `file_last_viewed` timestamp NULL DEFAULT NULL,
  `file_visibility` varchar(255) NOT NULL DEFAULT '0',
  `file_perms` varchar(10) DEFAULT 'r',
  `file_timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`fid`, `file_uploader_id`, `file_name`, `x_bz_name`, `file_size`, `file_type`, `file_id`, `file_last_viewed`, `file_visibility`, `file_perms`, `file_timestamp`) VALUES
(12, 'facebook_5', 'Zaid patel.pdf', 'Zaidpatel.pdf_407472_1727186948677_752', 407472, 'application/pdf', '4_z47baf7917997390d92130812_f1060e3ce669ff749_d20240924_m140851_c002_v0001142_t0037_u01727186931949', NULL, '0', 'r', '2024-09-24 14:09:15'),
(13, 'facebook_5', 'WhatsApp Image 2023-11-10 at 11.56.00 AM.jpeg', 'WhatsAppImage2023-11-10at11.56.00AM.jpeg_110424_1727186948674_802', 110424, 'image/jpeg', '4_z47baf7917997390d92130812_f103f5823a3593d8c_d20240924_m140858_c002_v0001143_t0000_u01727186938670', NULL, '0', 'r', '2024-09-24 14:09:22'),
(14, 'facebook_5', 'StudentVoterCard202205344820240507121245172.jpg', 'StudentVoterCard202205344820240507121245172.jpg_170037_1727186948672_988', 170037, 'image/jpeg', '4_z47baf7917997390d92130812_f115483aa4f047052_d20240924_m140905_c002_v0203010_t0012_u01727186945879', NULL, '0', 'r', '2024-09-24 14:09:27'),
(15, 'facebook_5', 'phone_ring.mp3', 'phone_ring.mp3_288618_1727186948360_620', 288618, 'audio/mpeg', '4_z47baf7917997390d92130812_f1092f71a03d8563c_d20240924_m140911_c002_v0001164_t0004_u01727186951176', NULL, '0', 'r', '2024-09-24 14:09:34'),
(16, 'facebook_5', 'pexels-pixabay-33045.jpg', 'pexels-pixabay-33045.jpg_313209_1727186948359_90', 313209, 'image/jpeg', '4_z47baf7917997390d92130812_f1099d1419a999b7f_d20240924_m140919_c002_v0203008_t0028_u01727186959082', NULL, '0', 'r', '2024-09-24 14:09:42'),
(17, 'facebook_5', 'pexels-photo-771742 (1).webp', 'pexels-photo-771742(1).webp_11156_1727186948358_967', 11156, 'image/webp', '4_z47baf7917997390d92130812_f113d18e9baa5c47d_d20240924_m140925_c002_v0001143_t0052_u01727186965915', NULL, '0', 'r', '2024-09-24 14:09:46'),
(18, 'facebook_5', 'Mobile user-amico.png', 'Mobileuser-amico.png_517125_1727186948356_984', 517125, 'image/png', '4_z47baf7917997390d92130812_f112ba3e1777979f4_d20240924_m140941_c002_v0203011_t0011_u01727186981603', NULL, '0', 'r', '2024-09-24 14:10:06'),
(19, 'facebook_5', 'Jadriya jini re jini Ringtone.mp3', 'JadriyajinirejiniRingtone.mp3_475452_1727186948355_272', 475452, 'audio/mpeg', '4_z47baf7917997390d92130812_f11923e81279ed6ae_d20240924_m140949_c002_v0203009_t0013_u01727186989967', NULL, '0', 'r', '2024-09-24 14:10:14'),
(20, 'facebook_5', 'Fantasy-Wolf-Dark-High-Definition-Wallpaper-112160.jpg', 'Fantasy-Wolf-Dark-High-Definition-Wallpaper-112160.jpg_236185_1727186948352_63', 236185, 'image/jpeg', '4_z47baf7917997390d92130812_f108ba608c306ffc4_d20240924_m140958_c002_v0203011_t0016_u01727186998285', NULL, '0', 'r', '2024-09-24 14:10:21'),
(21, 'facebook_5', 'caller_ring.mp3', 'caller_ring.mp3_112449_1727186948348_406', 112449, 'audio/mpeg', '4_z47baf7917997390d92130812_f11591015446d9177_d20240924_m141012_c002_v0001164_t0056_u01727187012369', NULL, '0', 'r', '2024-09-24 14:10:34');

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
(4, 'marshallzaid721@gmail.com', 'zaid deve', 'https://lh3.googleusercontent.com/a/ACg8ocJk6-LvVAzfHAwBF3F75nvLY6B489ALVkZfnBtIJYgc0yXh5A=s96-c', NULL, '2024-09-03 17:04:14', NULL, NULL),
(5, 'yuo.tuber2019@gmail.com', 'ZAID PATEL', 'https://lh3.googleusercontent.com/a/ACg8ocKgovZCqYNpevFSXgh3XIIhyEbJjkMCnIhkWbcL45EjlFKq0Fw=s96-c', NULL, '2024-09-20 14:34:52', NULL, NULL);

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

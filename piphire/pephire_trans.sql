-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2020 at 07:42 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pephire_trans`
--
CREATE DATABASE IF NOT EXISTS `pephire_trans` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pephire_trans`;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_interview_links`
--

CREATE TABLE `candidate_interview_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `candidateName` text COLLATE utf8mb4_unicode_ci,
  `candidatePhone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `webLink` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `whatsappMsgCount` bigint(11) NOT NULL DEFAULT '0',
  `whatsappLastDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_profile_links`
--

CREATE TABLE `candidate_profile_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) NOT NULL,
  `candidateName` text COLLATE utf8mb4_unicode_ci,
  `candidatePhone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `webLink` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `whatsappMsgCount` bigint(11) NOT NULL DEFAULT '0',
  `whatsappLastDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_interview_links`
--
ALTER TABLE `candidate_interview_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_profile_links`
--
ALTER TABLE `candidate_profile_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_interview_links`
--
ALTER TABLE `candidate_interview_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_profile_links`
--
ALTER TABLE `candidate_profile_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

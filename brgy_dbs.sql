-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 10:03 AM
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
-- Database: `brgy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `user_id`, `is_active`, `is_deleted`) VALUES
(1, 'Susan', 'Cruz', '2009-10-03', 'Pampanga', 3, 0, 0),
(3, 'asd', 'imgsrconerroralert1', '2024-01-11', 'asd', 13, 0, 0),
(4, 'as', 'as', '2024-04-19', 'as', 21, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `description` varchar(2555) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `subjective` varchar(255) DEFAULT NULL,
  `objective` varchar(50) NOT NULL,
  `assessment` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `medicine` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `not_approved` int(11) NOT NULL DEFAULT 0,
  `nurse_id` int(11) NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT 'Consultations',
  `checkup_date` date DEFAULT NULL,
  `is_print` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `step` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_plannings`
--

CREATE TABLE `family_plannings` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `checkup_date` date DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `not_approved` int(11) NOT NULL DEFAULT 0,
  `category2` varchar(255) NOT NULL DEFAULT 'Family Planning',
  `category` varchar(255) NOT NULL DEFAULT 'Family Planning',
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_consultation`
--

CREATE TABLE `fp_consultation` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `medicine` varchar(255) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `checkup_date` int(11) DEFAULT NULL,
  `is_print` int(11) DEFAULT 0,
  `fp_information_id` int(11) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_information`
--

CREATE TABLE `fp_information` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `no_of_children` int(11) DEFAULT NULL,
  `income` decimal(10,0) DEFAULT NULL,
  `plan_to_have_more_children` varchar(100) DEFAULT NULL,
  `client_type` varchar(100) DEFAULT NULL,
  `reason_for_fp` varchar(100) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `not_approved` int(11) DEFAULT 0,
  `checkup_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_medical_history`
--

CREATE TABLE `fp_medical_history` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `fp_information_id` int(11) DEFAULT NULL,
  `severe_headaches` varchar(10) DEFAULT NULL,
  `history_stroke_heart_attack_hypertension` varchar(10) DEFAULT NULL,
  `hematoma_bruising_gum_bleeding` varchar(10) DEFAULT NULL,
  `breast_cancer_breast_mass` varchar(10) DEFAULT NULL,
  `severe_chest_pain` varchar(10) DEFAULT NULL,
  `cough_more_than_14_days` varchar(10) DEFAULT NULL,
  `vaginal_bleeding` varchar(10) DEFAULT NULL,
  `vaginal_discharge` varchar(10) DEFAULT NULL,
  `phenobarbital_rifampicin` varchar(10) DEFAULT NULL,
  `smoker` varchar(10) DEFAULT NULL,
  `with_disability` varchar(10) DEFAULT NULL,
  `jaundice` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `consultation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_obstetrical_history`
--

CREATE TABLE `fp_obstetrical_history` (
  `id` int(11) NOT NULL,
  `last_period` date DEFAULT NULL,
  `no_of_pregnancies` int(11) DEFAULT NULL,
  `date_of_last_delivery` date DEFAULT NULL,
  `type_of_last_delivery` varchar(255) DEFAULT NULL,
  `mens_type` varchar(255) DEFAULT NULL,
  `fp_information_id` int(11) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_physical_examination`
--

CREATE TABLE `fp_physical_examination` (
  `id` int(11) NOT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `pulse` varchar(10) DEFAULT NULL,
  `skin` varchar(255) DEFAULT NULL,
  `extremities` varchar(255) DEFAULT NULL,
  `conjunctiva` varchar(255) DEFAULT NULL,
  `neck` varchar(255) DEFAULT NULL,
  `breast` varchar(255) DEFAULT NULL,
  `abdomen` varchar(255) DEFAULT NULL,
  `fp_information_id` int(11) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `consultation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_risk_for_sexuality`
--

CREATE TABLE `fp_risk_for_sexuality` (
  `id` int(11) NOT NULL,
  `fp_information_id` int(11) DEFAULT NULL,
  `abnormal_discharge` varchar(10) DEFAULT NULL,
  `genital_sores_ulcers` varchar(10) DEFAULT NULL,
  `genital_pain_burning_sensation` varchar(10) DEFAULT NULL,
  `treatment_for_sti` varchar(10) DEFAULT NULL,
  `hiv_aids_pid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_risk_for_violence_against_women`
--

CREATE TABLE `fp_risk_for_violence_against_women` (
  `id` int(11) NOT NULL,
  `fp_information_id` int(11) DEFAULT NULL,
  `unpleasant_relationship` varchar(10) DEFAULT NULL,
  `partner_does_not_approve` varchar(10) DEFAULT NULL,
  `domestic_violence` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `immunization`
--

CREATE TABLE `immunization` (
  `id` int(11) NOT NULL,
  `bgc_date` date DEFAULT NULL,
  `bgc_remarks` varchar(255) DEFAULT NULL,
  `hepa_date` date DEFAULT NULL,
  `hepa_remarks` varchar(255) DEFAULT NULL,
  `pentavalent_date1` date DEFAULT NULL,
  `pentavalent_date2` date DEFAULT NULL,
  `pentavalent_date3` date DEFAULT NULL,
  `pentavalent_remarks` varchar(255) DEFAULT NULL,
  `oral_date1` date DEFAULT NULL,
  `oral_date2` date DEFAULT NULL,
  `oral_date3` date DEFAULT NULL,
  `oral_remarks` varchar(255) DEFAULT NULL,
  `ipv_date1` date DEFAULT NULL,
  `ipv_date2` date DEFAULT NULL,
  `ipv_remarks` varchar(255) DEFAULT NULL,
  `pcv_date1` date DEFAULT NULL,
  `pcv_date2` date DEFAULT NULL,
  `pcv_date3` date DEFAULT NULL,
  `pcv_remarks` varchar(255) DEFAULT NULL,
  `mmr_date1` date DEFAULT NULL,
  `mmr_date2` date DEFAULT NULL,
  `mmr_remarks` varchar(255) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `checkup_date` date DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `type`, `date`, `time`, `user_id`) VALUES
(1, 'login', '2024-03-13', '05:15:34', 2),
(2, 'logout', '2024-03-13', '05:17:14', 2),
(3, 'login', '2024-03-13', '05:17:19', 3),
(4, 'logout', '2024-03-13', '05:17:51', 3),
(5, 'login', '2024-04-25', '06:45:17', 8),
(6, 'logout', '2024-04-25', '06:45:21', 8),
(7, 'login', '2024-04-25', '06:45:25', 2),
(8, 'logout', '2024-04-25', '06:46:03', 2),
(9, 'login', '2024-04-25', '06:46:09', 8),
(10, 'logout', '2024-04-25', '06:49:12', 8),
(11, 'login', '2024-04-25', '06:49:17', 2),
(12, 'logout', '2024-04-25', '06:56:13', 2),
(13, 'login', '2024-04-25', '06:59:16', 8),
(14, 'logout', '2024-04-25', '07:00:53', 8),
(15, 'login', '2024-04-25', '07:00:58', 2),
(16, 'logout', '2024-04-25', '07:02:07', 2),
(17, 'login', '2024-04-25', '07:02:19', 8),
(18, 'login', '2024-04-25', '07:02:30', 3),
(19, 'logout', '2024-04-25', '07:02:43', 3),
(20, 'login', '2024-04-25', '07:02:57', 2),
(21, 'logout', '2024-04-25', '07:27:35', 8),
(22, 'login', '2024-04-25', '07:38:44', 8),
(23, 'logout', '2024-04-25', '07:38:47', 8),
(24, 'login', '2024-04-25', '07:39:02', 3),
(25, 'login', '2024-04-25', '07:40:02', 2),
(26, 'logout', '2024-04-25', '07:40:06', 2),
(27, 'login', '2024-04-26', '05:37:57', 3),
(28, 'logout', '2024-04-26', '05:38:40', 3),
(29, 'login', '2024-04-26', '05:39:45', 3),
(30, 'logout', '2024-04-26', '05:47:08', 3),
(31, 'login', '2024-04-26', '05:47:23', 3),
(32, 'logout', '2024-04-26', '05:52:15', 3),
(33, 'login', '2024-04-26', '05:54:31', 18),
(34, 'logout', '2024-04-26', '05:54:36', 18),
(35, 'login', '2024-04-26', '05:55:05', 3),
(36, 'logout', '2024-04-26', '06:00:06', 3),
(37, 'login', '2024-04-26', '06:00:10', 2),
(38, 'logout', '2024-04-26', '06:02:40', 2),
(39, 'login', '2024-04-26', '06:02:46', 8),
(40, 'logout', '2024-04-26', '06:02:56', 8),
(41, 'login', '2024-04-26', '06:03:00', 3),
(42, 'logout', '2024-04-26', '06:12:27', 3),
(43, 'login', '2024-04-26', '06:12:32', 2),
(44, 'logout', '2024-04-26', '06:14:21', 2),
(45, 'login', '2024-04-26', '06:14:25', 3),
(46, 'logout', '2024-04-26', '06:14:31', 3),
(47, 'login', '2024-04-26', '06:14:36', 8),
(48, 'logout', '2024-04-26', '06:14:39', 8),
(49, 'login', '2024-04-26', '06:14:43', 2),
(50, 'logout', '2024-04-26', '06:15:01', 2),
(51, 'login', '2024-04-26', '06:15:08', 1),
(52, 'logout', '2024-04-26', '07:00:30', 1),
(53, 'login', '2024-04-26', '07:04:00', 1),
(54, 'logout', '2024-04-26', '07:08:33', 1),
(55, 'login', '2024-04-26', '07:08:39', 5),
(56, 'logout', '2024-04-26', '07:08:47', 5),
(57, 'login', '2024-04-26', '07:09:50', 5),
(58, 'logout', '2024-04-26', '07:10:25', 5),
(59, 'login', '2024-04-26', '07:10:32', 1),
(60, 'logout', '2024-04-26', '07:11:07', 1),
(61, 'login', '2024-04-26', '07:17:41', 8),
(62, 'logout', '2024-04-26', '07:17:44', 8),
(63, 'login', '2024-04-27', '05:06:28', 3),
(64, 'logout', '2024-04-27', '05:37:54', 2),
(65, 'logout', '2024-04-27', '05:46:30', 3),
(66, 'login', '2024-04-27', '05:46:35', 2),
(67, 'logout', '2024-04-27', '05:47:35', 2),
(68, 'login', '2024-04-27', '05:47:42', 8),
(69, 'logout', '2024-04-27', '05:47:46', 8),
(70, 'login', '2024-04-27', '06:56:19', 2),
(71, 'logout', '2024-04-27', '07:07:04', 2),
(72, 'login', '2024-04-27', '07:17:36', 2),
(73, 'logout', '2024-04-27', '07:26:02', 2),
(74, 'login', '2024-04-27', '07:36:59', 2),
(75, 'logout', '2024-04-27', '07:43:27', 2),
(76, 'login', '2024-04-27', '07:59:46', 2),
(77, 'logout', '2024-04-27', '08:04:46', 2),
(78, 'login', '2024-04-27', '08:04:52', 1),
(79, 'logout', '2024-04-27', '08:05:15', 1),
(80, 'login', '2024-04-27', '08:05:20', 2),
(81, 'logout', '2024-04-27', '08:11:25', 2),
(82, 'login', '2024-04-28', '05:32:09', 2),
(83, 'logout', '2024-04-28', '05:40:45', 2),
(84, 'login', '2024-04-28', '05:43:47', 2),
(85, 'logout', '2024-04-28', '05:58:58', 2),
(86, 'login', '2024-04-28', '05:59:05', 8),
(87, 'logout', '2024-04-28', '05:59:09', 8),
(88, 'login', '2024-04-28', '05:59:13', 2),
(89, 'logout', '2024-04-28', '06:17:19', 2),
(90, 'login', '2024-04-28', '06:17:24', 1),
(91, 'logout', '2024-04-28', '06:17:39', 1),
(92, 'login', '2024-04-28', '06:17:53', 8),
(93, 'logout', '2024-04-28', '06:17:57', 8),
(94, 'login', '2024-04-28', '06:18:01', 2),
(95, 'logout', '2024-04-28', '06:18:11', 2),
(96, 'login', '2024-04-28', '06:18:16', 8),
(97, 'logout', '2024-04-28', '06:45:49', 8),
(98, 'login', '2024-04-28', '06:45:58', 5),
(99, 'logout', '2024-04-28', '06:46:02', 5),
(100, 'login', '2024-04-28', '06:46:09', 3),
(101, 'logout', '2024-04-28', '06:51:48', 3),
(102, 'login', '2024-04-28', '06:51:53', 5),
(103, 'logout', '2024-04-28', '06:56:40', 5),
(104, 'login', '2024-04-28', '06:56:45', 3),
(105, 'logout', '2024-04-28', '06:56:48', 3),
(106, 'login', '2024-04-28', '06:57:05', 5),
(107, 'logout', '2024-04-28', '06:57:43', 5),
(108, 'login', '2024-04-28', '06:57:54', 3),
(109, 'logout', '2024-04-28', '06:58:14', 3),
(110, 'login', '2024-04-28', '06:58:22', 5),
(111, 'logout', '2024-04-28', '07:01:25', 5),
(112, 'login', '2024-04-28', '07:01:29', 3),
(113, 'logout', '2024-04-28', '07:01:35', 3),
(114, 'login', '2024-04-28', '07:01:50', 5),
(115, 'logout', '2024-04-28', '07:03:51', 5),
(116, 'login', '2024-04-28', '07:04:00', 3),
(117, 'logout', '2024-04-28', '07:04:05', 3),
(118, 'login', '2024-04-28', '07:04:11', 5),
(119, 'logout', '2024-04-28', '07:25:55', 5),
(120, 'login', '2024-04-28', '06:40:06', 2),
(121, 'logout', '2024-04-28', '06:51:22', 2),
(122, 'login', '2024-04-28', '06:51:36', 8),
(123, 'logout', '2024-04-28', '06:52:06', 8),
(124, 'login', '2024-04-28', '06:52:11', 2),
(125, 'logout', '2024-04-28', '06:53:22', 2),
(126, 'login', '2024-04-28', '06:53:28', 8),
(127, 'logout', '2024-04-28', '06:55:42', 8),
(128, 'login', '2024-04-28', '06:55:46', 3),
(129, 'logout', '2024-04-28', '06:57:52', 3),
(130, 'login', '2024-04-28', '06:57:56', 2),
(131, 'logout', '2024-04-28', '07:09:46', 2),
(132, 'login', '2024-04-28', '07:09:51', 3),
(133, 'logout', '2024-04-28', '07:14:21', 3),
(134, 'login', '2024-04-28', '07:14:27', 8),
(135, 'logout', '2024-04-28', '07:28:52', 8),
(136, 'login', '2024-04-28', '07:29:41', 5),
(137, 'logout', '2024-04-28', '07:29:56', 5),
(138, 'login', '2024-04-28', '07:31:25', 8),
(139, 'logout', '2024-04-28', '07:42:14', 8),
(140, 'login', '2024-04-28', '07:42:19', 5),
(141, 'login', '2024-04-29', '06:21:42', 5),
(142, 'logout', '2024-04-29', '06:28:11', 5),
(143, 'login', '2024-04-29', '06:29:07', 5),
(144, 'logout', '2024-04-29', '06:29:40', 5),
(145, 'login', '2024-04-29', '06:29:44', 2),
(146, 'logout', '2024-04-29', '06:34:46', 2),
(147, 'login', '2024-04-29', '06:35:00', 5),
(148, 'logout', '2024-04-29', '06:36:33', 5),
(149, 'login', '2024-04-29', '06:36:37', 2),
(150, 'logout', '2024-04-29', '06:50:03', 2),
(151, 'login', '2024-04-29', '06:50:08', 5),
(152, 'logout', '2024-04-29', '06:52:19', 5),
(153, 'login', '2024-04-29', '06:52:24', 2),
(154, 'logout', '2024-04-29', '06:52:53', 2),
(155, 'login', '2024-04-29', '06:53:04', 5),
(156, 'logout', '2024-04-29', '06:56:55', 5),
(157, 'login', '2024-04-29', '06:56:59', 2),
(158, 'logout', '2024-04-29', '06:57:27', 2),
(159, 'login', '2024-04-29', '06:57:32', 5),
(160, 'logout', '2024-04-29', '06:57:37', 5),
(161, 'login', '2024-04-29', '06:57:43', 3),
(162, 'logout', '2024-04-29', '06:57:48', 3),
(163, 'login', '2024-04-29', '06:57:53', 5),
(164, 'logout', '2024-04-29', '07:05:08', 5),
(165, 'login', '2024-04-29', '07:24:21', 5),
(166, 'logout', '2024-04-29', '07:39:55', 5),
(167, 'login', '2024-04-29', '07:44:20', 5),
(168, 'logout', '2024-04-29', '07:48:12', 5),
(169, 'login', '2024-04-29', '07:48:16', 2),
(170, 'logout', '2024-04-29', '07:49:10', 2),
(171, 'login', '2024-04-29', '07:49:15', 3),
(172, 'logout', '2024-04-29', '07:49:54', 3),
(173, 'login', '2024-04-29', '07:50:01', 1),
(174, 'logout', '2024-04-29', '07:50:09', 1),
(175, 'login', '2024-04-29', '07:50:27', 2),
(176, 'logout', '2024-04-29', '07:55:18', 2),
(177, 'login', '2024-04-29', '07:55:27', 3),
(178, 'logout', '2024-04-29', '08:09:50', 3),
(179, 'login', '2024-04-29', '08:09:55', 3),
(180, 'logout', '2024-04-29', '08:10:38', 3),
(181, 'login', '2024-04-29', '08:10:42', 2),
(182, 'logout', '2024-04-29', '08:11:30', 2),
(183, 'login', '2024-04-29', '08:12:37', 3),
(184, 'logout', '2024-04-29', '08:12:50', 3),
(185, 'login', '2024-04-29', '08:13:00', 19),
(186, 'logout', '2024-04-29', '08:14:20', 19),
(187, 'login', '2024-04-29', '08:14:28', 3),
(188, 'logout', '2024-04-29', '08:20:33', 3),
(189, 'login', '2024-04-29', '08:37:08', 3),
(190, 'logout', '2024-04-29', '08:37:45', 3),
(191, 'login', '2024-04-29', '08:37:50', 5),
(192, 'logout', '2024-04-29', '08:41:58', 5),
(193, 'login', '2024-04-29', '08:42:04', 8),
(194, 'logout', '2024-04-29', '08:44:36', 8),
(195, 'login', '2024-04-29', '08:44:43', 3),
(196, 'logout', '2024-04-29', '08:45:02', 3),
(197, 'login', '2024-04-29', '08:45:08', 8),
(198, 'logout', '2024-04-29', '08:46:25', 8),
(199, 'login', '2024-04-29', '08:46:29', 3),
(200, 'logout', '2024-04-29', '08:47:05', 3),
(201, 'login', '2024-04-29', '08:47:10', 2),
(202, 'logout', '2024-04-29', '08:47:42', 2),
(203, 'login', '2024-04-29', '08:48:06', 3),
(204, 'logout', '2024-04-29', '08:48:20', 3),
(205, 'login', '2024-04-29', '08:48:25', 20),
(206, 'logout', '2024-04-29', '08:49:35', 20),
(207, 'login', '2024-04-29', '08:49:42', 8),
(208, 'logout', '2024-04-29', '09:11:58', 8),
(209, 'login', '2024-04-29', '09:12:04', 3),
(210, 'logout', '2024-04-29', '09:12:06', 3),
(211, 'login', '2024-04-29', '09:12:12', 5),
(212, 'logout', '2024-04-29', '09:16:45', 5),
(213, 'login', '2024-04-29', '09:16:49', 3),
(214, 'logout', '2024-04-29', '09:17:05', 3),
(215, 'login', '2024-04-29', '09:17:23', 1),
(216, 'logout', '2024-04-29', '09:22:10', 1),
(217, 'login', '2024-04-29', '09:22:14', 2),
(218, 'logout', '2024-04-29', '09:22:36', 2),
(219, 'login', '2024-04-29', '09:22:42', 1),
(220, 'login', '2024-04-29', '04:29:21', 1),
(221, 'logout', '2024-04-29', '04:36:24', 1),
(222, 'login', '2024-04-29', '04:36:28', 3),
(223, 'logout', '2024-04-29', '04:52:17', 3),
(224, 'login', '2024-04-29', '04:52:56', 3),
(225, 'logout', '2024-04-29', '05:04:11', 3),
(226, 'login', '2024-04-29', '05:04:22', 3),
(227, 'logout', '2024-04-29', '05:17:26', 3),
(228, 'login', '2024-04-29', '05:58:04', 3),
(229, 'logout', '2024-04-29', '05:58:18', 3),
(230, 'login', '2024-04-29', '05:58:32', 3),
(231, 'logout', '2024-04-29', '05:58:35', 3),
(232, 'login', '2024-04-30', '02:37:42', 2),
(233, 'logout', '2024-04-30', '02:37:50', 2),
(234, 'login', '2024-04-30', '02:37:59', 1),
(235, 'logout', '2024-04-30', '02:43:22', 1),
(236, 'login', '2024-04-30', '02:43:31', 1),
(237, 'logout', '2024-04-30', '02:59:49', 1),
(238, 'login', '2024-04-30', '03:05:23', 1),
(239, 'logout', '2024-04-30', '03:30:37', 1),
(240, 'login', '2024-04-30', '03:32:34', 1),
(241, 'logout', '2024-04-30', '03:33:09', 1),
(242, 'login', '2024-04-30', '03:37:39', 3);

-- --------------------------------------------------------

--
-- Table structure for table `midwife`
--

CREATE TABLE `midwife` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `midwife`
--

INSERT INTO `midwife` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `user_id`, `is_active`, `is_deleted`) VALUES
(1, 'Diane', 'Santos', '1992-10-02', 'Pasig', 8, 0, 1),
(4, 'qwe', 'qwe', '2024-05-03', 'qwe', 20, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `user_id`, `is_active`, `is_deleted`) VALUES
(1, 'Abigail', 'Martinez', '2023-10-11', 'Laguna', 5, 0, 0),
(4, 'meow', 'aw', '2024-04-16', 'qwe', 18, 0, 0),
(5, 'test', 'test', '2024-04-27', 'test', 19, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `serial_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal`
--

CREATE TABLE `prenatal` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `family_serial_no` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) DEFAULT NULL,
  `pr` varchar(255) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `menarche` varchar(255) DEFAULT NULL,
  `lmp` varchar(255) DEFAULT NULL,
  `gravida` varchar(255) DEFAULT NULL,
  `para` varchar(255) DEFAULT NULL,
  `fullterm` varchar(255) DEFAULT NULL,
  `preterm` varchar(255) DEFAULT NULL,
  `abortion` varchar(255) DEFAULT NULL,
  `stillbirth` varchar(255) DEFAULT NULL,
  `alive` varchar(255) DEFAULT NULL,
  `hgb` varchar(255) DEFAULT NULL,
  `ua` varchar(255) DEFAULT NULL,
  `vdrl` varchar(255) DEFAULT NULL,
  `edc` varchar(255) DEFAULT NULL,
  `aog` varchar(255) DEFAULT NULL,
  `date_of_last_delivery` date DEFAULT NULL,
  `place_of_last_delivery` date DEFAULT NULL,
  `tt1` varchar(255) DEFAULT NULL,
  `tt2` varchar(255) DEFAULT NULL,
  `tt3` varchar(255) DEFAULT NULL,
  `tt4` varchar(255) DEFAULT NULL,
  `tt5` varchar(255) DEFAULT NULL,
  `checkup_date` date NOT NULL DEFAULT current_timestamp(),
  `nurse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_consultation`
--

CREATE TABLE `prenatal_consultation` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `medicine` varchar(255) DEFAULT NULL,
  `midwife_id` int(11) DEFAULT NULL,
  `checkup_date` date NOT NULL DEFAULT current_timestamp(),
  `is_print` int(11) NOT NULL DEFAULT 0,
  `prenatal_subjective_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_diagnosis`
--

CREATE TABLE `prenatal_diagnosis` (
  `id` int(11) NOT NULL,
  `edc` varchar(255) DEFAULT NULL,
  `aog` varchar(255) DEFAULT NULL,
  `date_of_last_delivery` date DEFAULT NULL,
  `place_of_last_delivery` varchar(255) DEFAULT NULL,
  `tt1` varchar(255) DEFAULT NULL,
  `tt2` varchar(255) DEFAULT NULL,
  `tt3` varchar(255) DEFAULT NULL,
  `tt4` varchar(255) DEFAULT NULL,
  `tt5` varchar(255) DEFAULT NULL,
  `multiple_sex_partners` varchar(10) DEFAULT NULL,
  `unusual_discharges` varchar(10) DEFAULT NULL,
  `itching_sores_around_vagina` varchar(10) DEFAULT NULL,
  `tx_for_stis_in_the_past` varchar(10) DEFAULT NULL,
  `pain_burning_sensation` varchar(10) DEFAULT NULL,
  `ovarian_cyst` varchar(10) DEFAULT NULL,
  `myoma_uteri` varchar(10) DEFAULT NULL,
  `placenta_previa` varchar(10) DEFAULT NULL,
  `still_birth` varchar(10) DEFAULT NULL,
  `pre_eclampsia` varchar(10) DEFAULT NULL,
  `eclampsia` varchar(10) DEFAULT NULL,
  `premature_contraction` varchar(10) DEFAULT NULL,
  `hpn` varchar(10) DEFAULT NULL,
  `uterine_myomectomy` varchar(10) DEFAULT NULL,
  `thyroid_disorder` varchar(10) DEFAULT NULL,
  `epilepsy` varchar(10) DEFAULT NULL,
  `height_less_than_145cm` varchar(10) DEFAULT NULL,
  `family_history_gt_36cm` varchar(10) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `prenatal_subjective_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_subjective`
--

CREATE TABLE `prenatal_subjective` (
  `id` int(11) NOT NULL,
  `height` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) DEFAULT NULL,
  `pr` varchar(255) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `menarche` varchar(255) DEFAULT NULL,
  `lmp` varchar(255) DEFAULT NULL,
  `gravida` varchar(255) DEFAULT NULL,
  `para` varchar(255) DEFAULT NULL,
  `fullterm` varchar(255) DEFAULT NULL,
  `preterm` varchar(255) DEFAULT NULL,
  `abortion` varchar(255) DEFAULT NULL,
  `stillbirth` varchar(255) DEFAULT NULL,
  `alive` varchar(255) DEFAULT NULL,
  `hgb` varchar(255) DEFAULT NULL,
  `ua` varchar(255) DEFAULT NULL,
  `vdrl` varchar(255) DEFAULT NULL,
  `forceps_delivery` varchar(255) DEFAULT NULL,
  `smoking` varchar(255) DEFAULT NULL,
  `allergy_alcohol_intake` varchar(255) DEFAULT NULL,
  `previous_cs` varchar(255) DEFAULT NULL,
  `consecutive_miscarriage` varchar(255) DEFAULT NULL,
  `ectopic_pregnancy_h_mole` varchar(255) DEFAULT NULL,
  `pp_bleeding` varchar(255) DEFAULT NULL,
  `baby_weight_gt_4kgs` varchar(255) DEFAULT NULL,
  `asthma` varchar(255) DEFAULT NULL,
  `goiter` varchar(255) DEFAULT NULL,
  `premature_contraction` varchar(255) DEFAULT NULL,
  `obesity` varchar(255) DEFAULT NULL,
  `heart_disease` varchar(255) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `checkup_date` date DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `dm` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `user_id`, `is_active`, `is_deleted`) VALUES
(1, 'Richard', 'Gomez', '2000-08-08', 'Pasig', 2, 0, 0),
(3, 'James Matthew', 'Uba', '2002-10-21', 'CDO', 15, 0, 0),
(4, 'Joemari', 'Obrial', '2002-01-02', 'USA', 16, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `superadmins`
--

CREATE TABLE `superadmins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmins`
--

INSERT INTO `superadmins` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `user_id`, `is_active`, `is_deleted`) VALUES
(1, 'Gary', 'Punzalan', '2023-10-02', 'superadmin', 1, 0, 0),
(2, 'Joemari', 'Obrial', '2024-03-06', 'Cdo', 14, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff','nurse','superadmin','midwife') NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `is_active`, `is_deleted`, `email`) VALUES
(1, 'superadmin', '$2y$10$5cHBud369AJA1EgGcRVsxuJH5eNUxzxokeOyN07X0ZONOysXjgUU2', 'superadmin', 0, 0, ''),
(2, 'staff', '$2y$10$VT9uPNhpb7Yqym3UokBxPOVtIkomIbee7NUFoUuALXQdKeC9hUn1e', 'staff', 0, 0, ''),
(3, 'admin', '$2y$10$/ECAxe./Yu8tvLqASD7gXeVB/hRzIWKjJlP2bCNvHX2L1oiIs248a', 'admin', 0, 0, 'joemariobrial54@gmail.com'),
(5, 'nurse', '$2y$10$UEg98xlisBhOCHdsUxVd.uVLyRJW4qtHDN5CmbXU56fXvE0l.RD9G', 'nurse', 0, 0, ''),
(8, 'midwife', '$2y$10$AK/y2mQqwNSbiTHcoY/nEe.OE4g4N1c/c5s6i25P4eafzutlQ8dWK', 'midwife', 0, 0, ''),
(13, 'asd', '$2y$10$CiRbk.Zj.QhgkYLXTuu8cuvYOvPb4B2hlyt3q0MBZ6MhZJm1XmgD6', 'admin', 0, 0, 'joemariobrial54@gmail.com'),
(14, 'joemari', '$2y$10$dFJ2WM9cKs4OnyJ9p720EeuG3NT5n6pTT/4EZDbpYZ9HHC6v/GXHC', 'superadmin', 0, 0, ''),
(15, 'James', '$2y$10$9.VNQyywUOB5zZxVICNx4eKrQHdqOOyJYlheNu15GkEP/ydoT3DDO', 'staff', 0, 0, ''),
(16, 'Joemar', '$2y$10$jM8lJG7JWZKXquhGNDZZ1ONBKZABOG3LqjO0PfdphECU/MtLd6Jm.', 'staff', 0, 0, ''),
(17, 'Secretss', '$2y$10$KLzK0extdI2WaBH2gSmQ1OJXLKhWKQQ7lW4ly1vHLnbAar9KFocgS', 'staff', 0, 0, ''),
(18, 'aswd', '$2y$10$xX6e3ssILaH//o65dC1zreDAq.k43GhPu4OJkWbkLDMiKbKjsBD26', 'nurse', 0, 0, 'joemariobrial54@gmail.com'),
(19, 'test', '$2y$10$pDG0WEint1LKwKZKv44SV.LTgQonUYgLTsYwcyUsO1l.PCfFyVBMG', 'nurse', 0, 0, 'joemariobrial54@gmail.com'),
(20, 'qwe', '$2y$10$e0chII02YuskmAAP40.UGuwsCOXbtlDMje0XIdHLgVMXCljBLUY36', 'midwife', 0, 0, 'jamesmatthewobrial@gmail.com'),
(21, 'as', '$2y$10$knqfSJk5YWfUzqjWHioFPORUucVYaKmxRi676U/MVmmMDzhmDNsRq', 'admin', 0, 0, 'as');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_plannings`
--
ALTER TABLE `family_plannings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_consultation`
--
ALTER TABLE `fp_consultation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_information`
--
ALTER TABLE `fp_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_medical_history`
--
ALTER TABLE `fp_medical_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_obstetrical_history`
--
ALTER TABLE `fp_obstetrical_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_physical_examination`
--
ALTER TABLE `fp_physical_examination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_risk_for_sexuality`
--
ALTER TABLE `fp_risk_for_sexuality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_risk_for_violence_against_women`
--
ALTER TABLE `fp_risk_for_violence_against_women`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `immunization`
--
ALTER TABLE `immunization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `midwife`
--
ALTER TABLE `midwife`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prenatal`
--
ALTER TABLE `prenatal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prenatal_consultation`
--
ALTER TABLE `prenatal_consultation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prenatal_diagnosis`
--
ALTER TABLE `prenatal_diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `superadmins`
--
ALTER TABLE `superadmins`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_plannings`
--
ALTER TABLE `family_plannings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_consultation`
--
ALTER TABLE `fp_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_information`
--
ALTER TABLE `fp_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_medical_history`
--
ALTER TABLE `fp_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_obstetrical_history`
--
ALTER TABLE `fp_obstetrical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_physical_examination`
--
ALTER TABLE `fp_physical_examination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_risk_for_sexuality`
--
ALTER TABLE `fp_risk_for_sexuality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_risk_for_violence_against_women`
--
ALTER TABLE `fp_risk_for_violence_against_women`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `immunization`
--
ALTER TABLE `immunization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `midwife`
--
ALTER TABLE `midwife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal`
--
ALTER TABLE `prenatal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_consultation`
--
ALTER TABLE `prenatal_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_diagnosis`
--
ALTER TABLE `prenatal_diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `superadmins`
--
ALTER TABLE `superadmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

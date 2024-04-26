-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 08:10 AM
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
-- Database: `brgy2s`
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
(3, 'asd', 'asd', '2024-01-11', 'asd', 13, 0, 0);

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
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `subjective`, `objective`, `assessment`, `plan`, `diagnosis`, `medicine`, `doctor_id`, `is_active`, `not_approved`, `nurse_id`, `category`, `checkup_date`, `is_print`, `is_deleted`) VALUES
(1, 1, '1', '1', '11', '1', '1', '', 1, 0, 0, 0, 'Consultations', '2024-04-26', 0, 0);

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

--
-- Dumping data for table `fp_consultation`
--

INSERT INTO `fp_consultation` (`id`, `patient_id`, `description`, `diagnosis`, `medicine`, `nurse_id`, `checkup_date`, `is_print`, `fp_information_id`, `method`, `is_deleted`, `status`) VALUES
(1, 2, NULL, NULL, NULL, 1, 2024, 0, 2, NULL, 0, 'Pending');

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

--
-- Dumping data for table `fp_information`
--

INSERT INTO `fp_information` (`id`, `patient_id`, `no_of_children`, `income`, `plan_to_have_more_children`, `client_type`, `reason_for_fp`, `nurse_id`, `method`, `serial`, `doctor_id`, `not_approved`, `checkup_date`, `is_deleted`) VALUES
(1, 2, 1, 1, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 2, 0, '2024-04-26', 0),
(2, 2, 1, 1, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 2, 0, '2024-04-26', 0);

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

--
-- Dumping data for table `fp_medical_history`
--

INSERT INTO `fp_medical_history` (`id`, `patient_id`, `fp_information_id`, `severe_headaches`, `history_stroke_heart_attack_hypertension`, `hematoma_bruising_gum_bleeding`, `breast_cancer_breast_mass`, `severe_chest_pain`, `cough_more_than_14_days`, `vaginal_bleeding`, `vaginal_discharge`, `phenobarbital_rifampicin`, `smoker`, `with_disability`, `jaundice`, `is_deleted`, `consultation_id`) VALUES
(1, 2, 2, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(2, 1, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 1);

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

--
-- Dumping data for table `fp_obstetrical_history`
--

INSERT INTO `fp_obstetrical_history` (`id`, `last_period`, `no_of_pregnancies`, `date_of_last_delivery`, `type_of_last_delivery`, `mens_type`, `fp_information_id`, `is_deleted`) VALUES
(1, '2024-04-16', 1, '2024-04-18', 'Vaginal', 'Scanty', 2, 0);

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

--
-- Dumping data for table `fp_physical_examination`
--

INSERT INTO `fp_physical_examination` (`id`, `weight`, `bp`, `height`, `pulse`, `skin`, `extremities`, `conjunctiva`, `neck`, `breast`, `abdomen`, `fp_information_id`, `is_deleted`, `consultation_id`) VALUES
(1, '1', '1', '1', '1', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 2, 0, NULL),
(2, '1', '1', '1', '1', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 1);

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

--
-- Dumping data for table `fp_risk_for_sexuality`
--

INSERT INTO `fp_risk_for_sexuality` (`id`, `fp_information_id`, `abnormal_discharge`, `genital_sores_ulcers`, `genital_pain_burning_sensation`, `treatment_for_sti`, `hiv_aids_pid`) VALUES
(1, 2, 'Yes', 'No', 'No', 'No', 'No');

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

--
-- Dumping data for table `fp_risk_for_violence_against_women`
--

INSERT INTO `fp_risk_for_violence_against_women` (`id`, `fp_information_id`, `unpleasant_relationship`, `partner_does_not_approve`, `domestic_violence`) VALUES
(1, 2, 'Yes', 'No', 'No');

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
  `is_deleted` int(11) NOT NULL DEFAULT 0
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
(63, 'login', '2024-04-25', '01:10:51', 3),
(64, 'logout', '2024-04-25', '01:11:28', 3),
(65, 'login', '2024-04-25', '01:11:35', 8),
(66, 'logout', '2024-04-25', '01:11:45', 8),
(67, 'login', '2024-04-25', '01:11:50', 2),
(68, 'logout', '2024-04-25', '01:12:10', 2),
(69, 'login', '2024-04-25', '01:12:15', 2),
(70, 'logout', '2024-04-25', '01:14:55', 2),
(71, 'login', '2024-04-25', '01:15:16', 3),
(72, 'logout', '2024-04-25', '01:15:53', 3),
(73, 'login', '2024-04-25', '01:28:56', 2),
(74, 'logout', '2024-04-25', '01:42:43', 2),
(75, 'login', '2024-04-25', '01:42:52', 3),
(76, 'logout', '2024-04-25', '01:43:06', 3),
(77, 'login', '2024-04-25', '01:43:12', 1),
(78, 'logout', '2024-04-25', '01:52:13', 1),
(79, 'login', '2024-04-25', '01:55:06', 1),
(80, 'logout', '2024-04-25', '02:05:55', 1);

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
(1, 'Diane', 'Santos', '1992-10-02', 'Pasig', 8, 0, 1);

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
(4, 'meow', 'aw', '2024-04-16', 'qwe', 18, 0, 0);

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

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `is_active`, `middle_name`, `suffix`, `gender`, `age`, `contact_no`, `civil_status`, `religion`, `is_deleted`, `serial_no`) VALUES
(1, '&lt;h1&gt;Joemari&lt;/h1&gt;', 'Obrial', '2002-10-21', 'CDO', 0, 'Uba', 'None', 'Male', '21', '09268175389', 'Single', 'Other or Non-religious', 0, '240001'),
(2, 'Lana', 'Lore', '2002-04-18', 'CDO', 0, 'zer', 'none', 'Female', '22', '123', 'Married', 'Roman Catholic', 0, '240002');

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

--
-- Dumping data for table `prenatal_consultation`
--

INSERT INTO `prenatal_consultation` (`id`, `patient_id`, `description`, `diagnosis`, `medicine`, `midwife_id`, `checkup_date`, `is_print`, `prenatal_subjective_id`) VALUES
(1, 1, NULL, NULL, NULL, 1, '2024-04-25', 0, 1),
(2, 2, NULL, NULL, NULL, 1, '2024-04-26', 0, 2);

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

--
-- Dumping data for table `prenatal_diagnosis`
--

INSERT INTO `prenatal_diagnosis` (`id`, `edc`, `aog`, `date_of_last_delivery`, `place_of_last_delivery`, `tt1`, `tt2`, `tt3`, `tt4`, `tt5`, `multiple_sex_partners`, `unusual_discharges`, `itching_sores_around_vagina`, `tx_for_stis_in_the_past`, `pain_burning_sensation`, `ovarian_cyst`, `myoma_uteri`, `placenta_previa`, `still_birth`, `pre_eclampsia`, `eclampsia`, `premature_contraction`, `hpn`, `uterine_myomectomy`, `thyroid_disorder`, `epilepsy`, `height_less_than_145cm`, `family_history_gt_36cm`, `patient_id`, `prenatal_subjective_id`) VALUES
(1, '1', '1', '2024-04-30', '1', '1', '1', '1', '1', '1', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 1, 1),
(2, '1', '1', '2024-04-24', '1', '1', '1', '1', '1', '1', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 2, 2);

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
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_subjective`
--

INSERT INTO `prenatal_subjective` (`id`, `height`, `weight`, `temperature`, `pr`, `rr`, `bp`, `menarche`, `lmp`, `gravida`, `para`, `fullterm`, `preterm`, `abortion`, `stillbirth`, `alive`, `hgb`, `ua`, `vdrl`, `forceps_delivery`, `smoking`, `allergy_alcohol_intake`, `previous_cs`, `consecutive_miscarriage`, `ectopic_pregnancy_h_mole`, `pp_bleeding`, `baby_weight_gt_4kgs`, `asthma`, `goiter`, `premature_contraction`, `obesity`, `heart_disease`, `patient_id`, `checkup_date`, `doctor_id`, `nurse_id`, `dm`, `is_deleted`) VALUES
(1, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 1, '2024-04-25', NULL, 1, 'No', 0),
(2, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 2, '2024-04-26', NULL, 1, 'No', 0);

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
(3, 'admin', '$2y$10$Qi3vOEl4XActaFuCMgM4G.bAIZVNeXhcqKeEifMoL062mJ1rUhh3S', 'admin', 0, 0, ''),
(5, 'nurse', '$2y$10$UEg98xlisBhOCHdsUxVd.uVLyRJW4qtHDN5CmbXU56fXvE0l.RD9G', 'nurse', 0, 0, ''),
(8, 'midwife', '$2y$10$AK/y2mQqwNSbiTHcoY/nEe.OE4g4N1c/c5s6i25P4eafzutlQ8dWK', 'midwife', 0, 0, ''),
(13, 'asd', '$2y$10$JJxJCVunmki2L05Az/.YaufcQaWvVJGUX5IJi3q7jlumEsHlVKUUe', 'admin', 0, 0, 'joemariobrial54@gmail.com'),
(14, 'joemari', '$2y$10$W2tpyBzFzCK0v0F/.F2YqOngiOL.QdzgNX/p96trDtVcaTpaMi0pO', 'superadmin', 0, 0, ''),
(15, 'James', '$2y$10$9.VNQyywUOB5zZxVICNx4eKrQHdqOOyJYlheNu15GkEP/ydoT3DDO', 'staff', 0, 0, ''),
(16, 'Joemar', '$2y$10$jM8lJG7JWZKXquhGNDZZ1ONBKZABOG3LqjO0PfdphECU/MtLd6Jm.', 'staff', 0, 0, ''),
(17, 'Secretss', '$2y$10$KLzK0extdI2WaBH2gSmQ1OJXLKhWKQQ7lW4ly1vHLnbAar9KFocgS', 'staff', 0, 0, ''),
(18, 'aswd', '$2y$10$3KD8n.wkyUaoY96RfMeop.wEcQcbMa.Ls7FHej7WdH.G5.iurAcsq', 'nurse', 0, 0, 'joemariobrial54@gmail.com');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `family_plannings`
--
ALTER TABLE `family_plannings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_consultation`
--
ALTER TABLE `fp_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fp_information`
--
ALTER TABLE `fp_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fp_medical_history`
--
ALTER TABLE `fp_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fp_obstetrical_history`
--
ALTER TABLE `fp_obstetrical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fp_physical_examination`
--
ALTER TABLE `fp_physical_examination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fp_risk_for_sexuality`
--
ALTER TABLE `fp_risk_for_sexuality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fp_risk_for_violence_against_women`
--
ALTER TABLE `fp_risk_for_violence_against_women`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `immunization`
--
ALTER TABLE `immunization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `midwife`
--
ALTER TABLE `midwife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prenatal`
--
ALTER TABLE `prenatal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_consultation`
--
ALTER TABLE `prenatal_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prenatal_diagnosis`
--
ALTER TABLE `prenatal_diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

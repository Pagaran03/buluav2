-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 07:15 AM
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
(1, 'Susan', 'Cruz', '2009-10-03', 'Pampanga', 3, 0, 0);

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

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `is_active`, `is_deleted`, `description`, `title`, `date`, `time`) VALUES
(1, 0, 0, 'next week nalang ang defense', 'Good News', '2024-05-25', '14:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `first_name_child` varchar(255) NOT NULL,
  `last_name_child` varchar(255) NOT NULL,
  `middle_name_child` varchar(255) NOT NULL,
  `suffix_child` varchar(10) NOT NULL,
  `gender_child` enum('Male','Female') NOT NULL,
  `birthdate_child` date NOT NULL,
  `birth_weight_child` decimal(5,2) NOT NULL,
  `birth_height_child` decimal(5,2) NOT NULL,
  `place_of_birth_child` text NOT NULL,
  `children_id` int(255) NOT NULL
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
  `steps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `subjective`, `objective`, `assessment`, `plan`, `diagnosis`, `medicine`, `doctor_id`, `is_active`, `not_approved`, `nurse_id`, `category`, `checkup_date`, `is_print`, `is_deleted`, `status`, `steps`) VALUES
(1, 2, 'Cough', '38C1208070', 'ViralInfections', 'Antipyretics', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(2, 14, 'Headache', '38C1208070', 'TensionHeadache', 'Acetaminophen', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(3, 26, 'Stomachpain', '38C1208070', 'Indigestion', 'Gelusil', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(4, 29, 'Cough', '38C1208070', 'AcuteBronchitis', 'Salbutamol', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(5, 30, 'Cough', '38C1208070', 'ChronicBronchitis', 'Antibiotics', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(6, 31, 'Headache', '38C1208070', 'Migraineheadache', 'Paracetamol', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(7, 33, 'Cough', '38C1208070', 'Pneumonia', 'Amoxicillin', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(8, 36, 'Stomachpain', '38C1208070', 'Gastritis', 'Omeprazole', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(9, 37, 'Cough', '38C1208070', 'Asthma', 'Terbutaline', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(10, 38, 'Headache', '38C1208070', 'ClusterHeadache', 'Melatonin', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(11, 41, 'Headache', '38C1208070', 'SinusHeadache', 'Naproxen', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(12, 44, 'Stomachpain', '38C1208070', 'Appendicitis', 'Metronidazole', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(13, 47, 'Cough', '38C1208070', 'AllergicRhinitis', 'Cetirizine', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(14, 48, 'Stomachpain', '38C1208070', 'Constipation', 'Bisacodyl', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 1, 0, 'Pending', 'Consultation'),
(15, 50, 'Headache', '38C1208070', 'Reboundheadache', 'Aspirin', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(16, 52, 'Cough', '38C1208070', 'Tuberculosis', 'Rifampin', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(17, 54, 'Stomachpain', '38C1208070', 'Kidneystones', 'ThiazideDiuretics', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(18, 56, 'Headache', '38C1208070', 'SinusHeadache', 'Fluticasone', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(19, 58, 'Cough', '38C1208070', 'PostnasalDrip', 'Loratadine', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(20, 60, 'Headache', '38C1208070', 'ThunderclapHeadache', 'Antiemetics', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-25', 0, 0, 'Pending', 'Consultation'),
(21, 65, 'StomachAche', 'Test', 'Test', 'Test', 'Tinood', 'Tinood Gyud diay', 1, 0, 0, 0, 'Consultations', '2024-05-25', 1, 0, 'Complete', 'Step 4 Prescription'),
(22, 65, 'headache', 'test', 'Sakit', '', 'GG', 'goodgame', 1, 0, 0, 0, 'Consultations', '2024-05-25', 1, 0, 'Complete', ''),
(23, 148, 'Stomach', '90C', 'stomachache', 'Biogesic', 'test', 'test', 1, 0, 0, 0, 'Consultations', '2024-05-27', 1, 0, 'Pending', 'Step 4 Prescription'),
(24, 179, 'Stomache', 'NormalBPHinokamiKaguraBreathingform', '121155555asdsadas111111', '12', '112121111111', '112', 1, 0, 0, 0, 'Consultations', '2024-05-28', 1, 0, 'Complete', 'Prescription'),
(25, 248, 'Sakit ulo', 'High blood', '', '', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-30', 0, 0, 'Pending', 'Consultation'),
(26, 247, 'Headache', '38C1208070', '', '', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-30', 0, 0, 'Pending', 'Consultation'),
(27, 246, 'Stomach pain', '30C1208090', '', '', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-30', 0, 0, 'Pending', 'Consultation'),
(28, 245, 'Stomach', '35C1209080', '', '', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-30', 0, 0, 'Pending', 'Consultation'),
(29, 242, 'Stomach', '30C1208070', '', '', NULL, NULL, 1, 0, 0, 0, 'Consultations', '2024-05-30', 0, 0, '', '');

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
  `checkup_date` date DEFAULT NULL,
  `is_print` int(11) DEFAULT 0,
  `fp_information_id` int(11) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `steps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_consultation`
--

INSERT INTO `fp_consultation` (`id`, `patient_id`, `description`, `diagnosis`, `medicine`, `nurse_id`, `checkup_date`, `is_print`, `fp_information_id`, `method`, `is_deleted`, `status`, `steps`) VALUES
(1, 5, '', '', '', 1, '2024-06-27', 0, 1, 'IUD', 0, 'Complete', 'Family Planning'),
(2, 17, '', '', '', 1, '2024-06-27', 0, 2, 'Pills-COC', 0, 'Complete', 'Already Nurse'),
(3, 23, '', '', '', 1, '2024-06-27', 0, 3, 'Condom', 0, 'Complete', 'Already Nurse'),
(4, 1, '', '', '', 1, '2024-06-27', 0, 4, 'NSV', 0, 'Complete', 'Already Nurse'),
(5, 22, '', '', '', 1, '2024-06-27', 0, 5, 'Pills', 0, 'Complete', 'Family Planning'),
(6, 28, '', '', '', 1, '2024-06-27', 0, 6, 'Implant', 0, 'Complete', 'Already Nurse'),
(7, 20, NULL, NULL, NULL, 0, '2024-06-27', 0, 7, NULL, 0, '', ''),
(8, 7, '', '', '', 1, '2024-07-27', 0, 8, 'Pills', 0, 'Complete', 'Family Planning'),
(9, 19, '', '', '', 1, '2024-07-05', 0, 9, 'BTL', 0, 'Complete', 'Already Nurse'),
(10, 25, '', '', '', 1, '2024-07-27', 0, 10, 'Condom', 0, 'Complete', ''),
(11, 10, '', '', '', 1, '2024-07-27', 0, 11, 'Birth control ring', 0, 'Complete', 'Family Planning'),
(12, 16, '', '', '', 1, '2024-07-27', 0, 12, 'Pills-POP', 0, 'Complete', ''),
(13, 15, '', '', '', 1, '2024-07-27', 0, 13, 'Condom', 0, 'Complete', 'Already Nurse'),
(16, 9, '', '', '', 1, '2024-07-27', 0, 16, 'Cervical cap', 0, 'Complete', 'Already Nurse'),
(17, 3, '', '', '', 1, '2024-07-12', 0, 17, 'Pills-POP', 0, 'Complete', 'Already Nurse'),
(18, 4, '', '', '', 1, '2024-07-27', 0, 18, 'Condom', 0, 'Complete', 'Already Nurse'),
(19, 6, '', '', '', 1, '2024-07-27', 0, 19, 'Pills-COC', 0, 'Complete', 'Already Nurse'),
(20, 11, '', '', '', 1, '2024-07-27', 0, 20, 'Hormonal IUD', 0, 'Complete', 'Already Nurse'),
(21, 12, '', '', '', 1, '2024-07-27', 0, 21, 'BTL', 0, 'Complete', ''),
(22, 13, '', '', '', 1, '2024-07-27', 0, 22, 'Cervical cap', 0, 'Complete', 'Already Nurse'),
(23, 18, '', '', '', 1, '2024-07-27', 0, 23, 'Implant', 0, 'Complete', ''),
(24, 21, '', '', '', 1, '2024-07-27', 0, 24, 'Pills-POP', 0, 'Complete', ''),
(25, 20, '', '', '', 1, '2024-07-27', 0, 25, 'Condom', 0, 'Complete', ''),
(26, 24, '', '', '', 1, '2024-07-27', 0, 26, 'BTL', 0, 'Complete', 'Already Nurse'),
(27, 32, '', '', '', 1, '2024-07-27', 0, 27, 'Sterilization', 0, 'Complete', 'Family Planning'),
(28, 34, NULL, NULL, NULL, 0, '2024-07-27', 0, 28, NULL, 0, 'Pending', 'Family Planning'),
(29, 34, '', '', '', 1, '2024-07-27', 0, 29, 'Injectables (DMPA/POI)', 0, 'Complete', 'Already Nurse'),
(30, 34, NULL, NULL, NULL, 1, '2024-07-28', 0, 30, NULL, 0, 'Pending', 'FamilyPlanning'),
(31, 35, '', '', '', 1, '2024-07-28', 0, 31, 'Pills-POP', 0, 'Complete', 'Family Planning'),
(32, 39, '', '', '', 1, '2024-07-28', 0, 32, 'Cervical cap', 0, 'Complete', 'Already Nurse'),
(33, 40, '', '', '', 1, '2024-07-28', 0, 33, 'Birth control ring', 0, 'Complete', 'Already Nurse'),
(34, 42, '', '', '', 1, '2024-07-28', 0, 34, 'BTL', 0, 'Complete', 'Family Planning'),
(35, 45, '', '', '', 1, '2024-07-29', 0, 35, 'BTL', 0, 'Complete', 'Already Nurse'),
(36, 46, '', '', '', 1, '2024-07-29', 0, 36, 'Pills-POP', 0, 'Complete', 'Family Planning'),
(37, 49, '', '', '', 1, '2024-07-29', 0, 37, 'Implant', 0, 'Complete', 'Already Nurse'),
(38, 51, '', '', '', 1, '2024-07-29', 0, 38, 'Cervical cap', 0, 'Complete', 'Family Planning'),
(39, 53, '', '', '', 1, '2024-07-29', 0, 39, 'Pills-POP', 0, 'Complete', 'Family Planning'),
(40, 55, '', '', '', 1, '2024-07-29', 0, 40, 'Injectables (DMPA/POI)', 0, 'Complete', 'Already Nurse'),
(41, 57, '', '', '', 1, '2024-07-29', 0, 41, 'BTL', 0, 'Complete', 'Already Nurse'),
(42, 59, '', '', '', 1, '2024-07-29', 0, 42, 'Implant', 0, 'Complete', 'Family Planning'),
(43, 61, '', '', '', 1, '2024-07-29', 0, 43, 'IUD', 0, 'Complete', 'Family Planning'),
(44, 62, '', '', '', 1, '2024-07-29', 0, 44, 'BTL', 0, 'Complete', 'Family Planning'),
(45, 63, NULL, NULL, NULL, 1, '2024-07-29', 0, 45, NULL, 0, 'Pending', 'Family Planning'),
(46, 64, NULL, NULL, NULL, 1, '2024-07-29', 0, 46, NULL, 0, '', ''),
(47, 67, 'test', 'test', 'test', 1, '2024-07-29', 0, 47, 'BTL', 0, 'Complete', 'Already Nurse'),
(48, 65, NULL, NULL, NULL, 1, '2024-07-29', 0, 48, NULL, 0, 'Pending', 'Family Planning'),
(49, 65, NULL, NULL, NULL, 2, '2024-07-29', 0, 49, NULL, 0, 'Pending', 'Family Planning'),
(50, 65, 'test', 'test', 'test', 1, '2024-07-29', 0, 50, 'BTL', 0, 'Complete', 'Already Nurse'),
(51, 72, NULL, NULL, NULL, 1, '2024-07-29', 0, 51, NULL, 0, 'Pending', 'Family Planning'),
(52, 71, NULL, NULL, NULL, 1, '2024-07-29', 0, 52, NULL, 0, 'Pending', 'FamilyPlanning'),
(53, 69, NULL, NULL, NULL, 1, '2024-07-29', 0, 53, NULL, 0, 'Pending', 'Family Planning'),
(54, 70, NULL, NULL, NULL, 1, '2024-07-29', 0, 54, NULL, 0, '', ''),
(55, 73, NULL, NULL, NULL, 1, '2024-07-29', 0, 55, NULL, 0, 'Pending', 'Family Planning'),
(56, 75, NULL, NULL, NULL, 1, '2024-07-29', 0, 56, NULL, 0, 'Pending', 'Family Planning'),
(57, 76, NULL, NULL, NULL, 1, '2024-07-29', 0, 57, NULL, 0, 'Pending', 'Family Planning'),
(58, 77, NULL, NULL, NULL, 1, '2024-07-29', 0, 58, NULL, 0, 'Pending', 'Family Planning'),
(59, 74, NULL, NULL, NULL, 1, '2024-07-29', 0, 59, NULL, 0, 'Pending', 'Family Planning'),
(60, 78, NULL, NULL, NULL, 1, '2024-07-30', 0, 60, NULL, 0, 'Pending', 'Family Planning'),
(61, 79, NULL, NULL, NULL, 0, '2024-07-30', 0, 61, NULL, 0, 'Pending', 'Family Planning'),
(62, 79, NULL, NULL, NULL, 1, '2024-07-30', 0, 62, NULL, 0, 'Pending', 'Family Planning'),
(63, 80, NULL, NULL, NULL, 1, '2024-07-30', 0, 63, NULL, 0, 'Pending', 'FamilyPlanning'),
(64, 81, NULL, NULL, NULL, 1, '2024-07-30', 0, 64, NULL, 0, 'Pending', 'Family Planning'),
(65, 82, NULL, NULL, NULL, 1, '2024-07-30', 0, 65, NULL, 0, 'Pending', 'Family Planning'),
(66, 83, NULL, NULL, NULL, 1, '2024-07-30', 0, 66, NULL, 0, 'Pending', 'Family Planning'),
(67, 84, NULL, NULL, NULL, 1, '2024-07-30', 0, 67, NULL, 0, 'Pending', 'Family Planning'),
(68, 85, NULL, NULL, NULL, 1, '2024-07-30', 0, 68, NULL, 0, 'Pending', 'Family Planning'),
(69, 86, NULL, NULL, NULL, 1, '2024-07-30', 0, 69, NULL, 0, 'Pending', 'Family Planning'),
(70, 87, NULL, NULL, NULL, 1, '2024-07-30', 0, 70, NULL, 0, 'Pending', 'FamilyPlanning'),
(71, 88, NULL, NULL, NULL, 1, '2024-07-30', 0, 71, NULL, 0, 'Pending', 'FamilyPlanning'),
(72, 89, NULL, NULL, NULL, 1, '2024-07-30', 0, 72, NULL, 0, 'Pending', 'Family Planning'),
(73, 94, NULL, NULL, NULL, 1, '2024-07-30', 0, 73, NULL, 0, 'Pending', 'Family Planning'),
(74, 94, NULL, NULL, NULL, 1, '2024-07-30', 0, 74, NULL, 0, 'Pending', 'Family Planning'),
(75, 90, NULL, NULL, NULL, 1, '2024-07-30', 0, 75, NULL, 0, 'Pending', 'Family Planning'),
(76, 91, NULL, NULL, NULL, 1, '2024-07-30', 0, 76, NULL, 0, 'Pending', 'Family Planning'),
(77, 92, NULL, NULL, NULL, 1, '2024-07-30', 0, 77, NULL, 0, 'Pending', 'Family Planning'),
(78, 93, NULL, NULL, NULL, 1, '2024-07-30', 0, 78, NULL, 0, 'Pending', 'Family Planning'),
(79, 100, NULL, NULL, NULL, 1, '2024-07-30', 0, 79, NULL, 0, 'Pending', 'Family Planning'),
(80, 94, NULL, NULL, NULL, 1, '2024-07-30', 0, 80, NULL, 0, 'Pending', 'Family Planning'),
(81, 95, NULL, NULL, NULL, 1, '2024-07-30', 0, 81, NULL, 0, 'Pending', 'Family Planning'),
(82, 96, NULL, NULL, NULL, 2, '2024-07-30', 0, 82, NULL, 0, 'Pending', 'Family Planning'),
(83, 103, NULL, NULL, NULL, 1, '2024-07-30', 0, 83, NULL, 0, 'Pending', 'Family Planning'),
(84, 97, NULL, NULL, NULL, 1, '2024-07-30', 0, 84, NULL, 0, 'Pending', 'FamilyPlanning'),
(85, 98, NULL, NULL, NULL, 2, '2024-07-30', 0, 85, NULL, 0, 'Pending', 'Family Planning'),
(86, 104, NULL, NULL, NULL, 1, '2024-07-30', 0, 86, NULL, 0, 'Pending', 'Family Planning'),
(87, 99, NULL, NULL, NULL, 1, '2024-07-30', 0, 87, NULL, 0, 'Pending', 'Family Planning'),
(88, 101, NULL, NULL, NULL, 1, '2024-07-30', 0, 88, NULL, 0, 'Pending', 'Family Planning'),
(89, 102, NULL, NULL, NULL, 1, '2024-07-30', 0, 89, NULL, 0, 'Pending', 'Family Planning'),
(90, 105, NULL, NULL, NULL, 1, '2024-07-30', 0, 90, NULL, 0, 'Pending', 'Family Planning'),
(91, 106, NULL, NULL, NULL, 1, '2024-07-30', 0, 91, NULL, 0, 'Pending', 'Family Planning'),
(92, 107, NULL, NULL, NULL, 1, '2024-07-30', 0, 92, NULL, 0, 'Pending', 'Family Planning'),
(93, 109, NULL, NULL, NULL, 1, '2024-07-30', 0, 93, NULL, 0, 'Pending', 'Family Planning'),
(94, 109, NULL, NULL, NULL, 1, '2024-07-30', 0, 94, NULL, 0, 'Pending', 'Family Planning'),
(95, 110, NULL, NULL, NULL, 1, '2024-07-30', 0, 95, NULL, 0, 'Pending', 'Family Planning'),
(96, 111, NULL, NULL, NULL, 1, '2024-07-30', 0, 96, NULL, 0, 'Pending', 'Family Planning'),
(97, 112, NULL, NULL, NULL, 1, '2024-07-30', 0, 97, NULL, 0, 'Pending', 'Family Planning'),
(98, 113, NULL, NULL, NULL, 1, '2024-07-30', 0, 98, NULL, 0, 'Pending', 'Family Planning'),
(99, 114, NULL, NULL, NULL, 1, '2024-07-31', 0, 99, NULL, 0, 'Pending', 'Family Planning'),
(100, 115, NULL, NULL, NULL, 1, '2024-07-31', 0, 100, NULL, 0, 'Pending', 'Family Planning'),
(101, 116, NULL, NULL, NULL, 1, '2024-07-31', 0, 101, NULL, 0, 'Pending', 'Family Planning'),
(102, 117, NULL, NULL, NULL, 1, '2024-07-31', 0, 102, NULL, 0, 'Pending', 'Family Planning'),
(103, 119, NULL, NULL, NULL, 1, '2024-07-31', 0, 103, NULL, 0, 'Pending', 'Family Planning'),
(104, 118, NULL, NULL, NULL, 1, '2024-07-31', 0, 104, NULL, 0, 'Pending', 'Family Planning'),
(105, 121, NULL, NULL, NULL, 1, '2024-07-31', 0, 105, NULL, 0, 'Pending', 'Family Planning'),
(106, 124, NULL, NULL, NULL, 1, '2024-07-31', 0, 106, NULL, 0, 'Pending', 'Family Planning'),
(107, 146, NULL, NULL, NULL, 2, '2024-07-31', 0, 107, NULL, 0, 'Pending', 'Family Planning'),
(108, 182, NULL, NULL, NULL, 1, '2024-07-31', 0, 108, NULL, 0, 'Pending', 'Family Planning'),
(109, 183, NULL, NULL, NULL, 1, '2024-07-31', 0, 109, NULL, 0, 'Pending', 'Family Planning'),
(110, 186, NULL, NULL, NULL, 1, '2024-07-31', 0, 110, NULL, 0, 'Pending', 'Family Planning'),
(111, 190, NULL, NULL, NULL, 1, '2024-07-31', 0, 111, NULL, 0, 'Pending', 'Family Planning'),
(112, 191, NULL, NULL, NULL, 1, '2024-07-31', 0, 112, NULL, 0, 'Pending', 'Family Planning'),
(113, 192, NULL, NULL, NULL, 1, '2024-05-30', 0, 113, NULL, 0, 'Pending', 'Family Planning'),
(114, 193, NULL, NULL, NULL, 1, '2024-05-30', 0, 114, NULL, 0, 'Pending', 'Family Planning'),
(115, 194, NULL, NULL, NULL, 1, '2024-05-30', 0, 115, NULL, 0, 'Pending', 'Family Planning'),
(116, 195, NULL, NULL, NULL, 1, '2024-05-30', 0, 116, NULL, 0, 'Pending', 'Family Planning'),
(117, 196, NULL, NULL, NULL, 1, '2024-05-30', 0, 117, NULL, 0, 'Pending', 'Family Planning'),
(118, 198, NULL, NULL, NULL, 1, '2024-05-30', 0, 118, NULL, 0, 'Pending', 'Family Planning'),
(119, 199, NULL, NULL, NULL, 1, '2024-05-30', 0, 119, NULL, 0, 'Pending', 'Family Planning'),
(120, 200, NULL, NULL, NULL, 1, '2024-05-30', 0, 120, NULL, 0, 'Pending', 'Family Planning'),
(121, 202, NULL, NULL, NULL, 1, '2024-05-31', 0, 121, NULL, 0, 'Pending', 'Family Planning'),
(122, 203, NULL, NULL, NULL, 1, '2024-05-31', 0, 122, NULL, 0, 'Pending', 'Family Planning'),
(123, 205, NULL, NULL, NULL, 1, '2024-05-31', 0, 123, NULL, 0, 'Pending', 'Family Planning'),
(124, 207, NULL, NULL, NULL, 1, '2024-05-31', 0, 124, NULL, 0, 'Pending', 'Family Planning'),
(125, 209, NULL, NULL, NULL, 1, '2024-05-31', 0, 125, NULL, 0, 'Pending', 'Family Planning'),
(126, 210, NULL, NULL, NULL, 0, '2024-05-31', 0, 126, NULL, 0, 'Pending', 'Family Planning'),
(127, 210, NULL, NULL, NULL, 1, '2024-05-31', 0, 127, NULL, 0, 'Pending', 'Family Planning'),
(128, 212, NULL, NULL, NULL, 1, '2024-05-31', 0, 128, NULL, 0, 'Pending', 'Family Planning'),
(129, 215, NULL, NULL, NULL, 1, '2024-05-31', 0, 129, NULL, 0, 'Pending', 'Family Planning'),
(130, 216, NULL, NULL, NULL, 1, '2024-05-31', 0, 130, NULL, 0, 'Pending', 'Family Planning'),
(131, 217, NULL, NULL, NULL, 1, '2024-05-31', 0, 131, NULL, 0, 'Pending', 'Family Planning'),
(132, 218, NULL, NULL, NULL, 1, '2024-05-31', 0, 132, NULL, 0, 'Pending', 'Family Planning'),
(133, 220, NULL, NULL, NULL, 1, '2024-05-31', 0, 133, NULL, 0, 'Pending', 'Family Planning'),
(134, 224, NULL, NULL, NULL, 1, '2024-05-31', 0, 134, NULL, 0, 'Pending', 'Family Planning'),
(135, 225, NULL, NULL, NULL, 1, '2024-05-31', 0, 135, NULL, 0, 'Pending', 'Family Planning'),
(136, 227, NULL, NULL, NULL, 1, '2024-05-31', 0, 136, NULL, 0, 'Pending', 'Family Planning'),
(137, 234, NULL, NULL, NULL, 1, '2024-05-31', 0, 137, NULL, 0, 'Pending', 'FamilyPlanning');

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
(1, 5, 4, 45000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(2, 17, 3, 51000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(3, 23, 1, 39000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(4, 1, 3, 46000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(5, 22, 4, 68000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(6, 28, 3, 42000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(7, 20, 5, 60000, '', '', '', 0, '1', '123', 46, 0, '2024-05-27', 0),
(8, 7, 1, 47000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(9, 19, 6, 74000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(10, 25, 4, 58100, 'No', 'NewAcceptor', 'limiting', 1, '1', '123', 46, 0, '2024-05-27', 0),
(11, 10, 3, 48000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(12, 16, 3, 42000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(13, 15, 7, 53000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(14, 8, 4, 54000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(15, 8, 4, 54000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 1),
(16, 9, 3, 38000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(17, 3, 5, 67000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(18, 4, 1, 28000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(19, 6, 3, 36000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(20, 11, 5, 78000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(21, 12, 2, 28000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(22, 13, 3, 38000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(23, 18, 1, 41000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(24, 21, 5, 61000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(25, 20, 4, 38000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(26, 24, 1, 58000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(27, 32, 3, 47000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(28, 34, 3, 41000, 'Yes', 'New Acceptor', 'spacing', 0, '1', '123', 46, 0, '2024-05-27', 0),
(29, 34, 1, 48000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-27', 0),
(30, 34, 6, 47000, 'No', 'NewAcceptor', 'limiting', 1, '1', '123', 46, 0, '2024-05-27', 1),
(31, 35, 6, 52000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(32, 39, 3, 38000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(33, 40, 2, 40000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(34, 42, 5, 57000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(35, 45, 3, 67000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(36, 46, 4, 43000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(37, 49, 3, 39000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(38, 51, 2, 35000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(39, 53, 3, 36000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(40, 55, 4, 65000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(41, 57, 2, 58000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(42, 59, 3, 41000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(43, 61, 4, 45000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(44, 62, 3, 50000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(45, 63, 2, 38000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(46, 64, 1, 29000, '', '', '', 1, '1', '123', 46, 0, '2024-05-28', 0),
(47, 67, 4, 38000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(48, 65, 1, 2500, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 41, 0, '2024-05-28', 0),
(49, 65, 1, 2500, 'Yes', 'New Acceptor', 'spacing', 2, '1', '123', 41, 0, '2024-05-28', 0),
(50, 65, 2, 37000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(51, 72, 2, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 41, 0, '2024-05-28', 0),
(52, 71, 2, 20000, '', '', '', 1, '1', '123', 41, 0, '2024-05-28', 0),
(53, 69, 2, 48000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(54, 70, 1, 15000, '', '', '', 1, '1', '123', 41, 0, '2024-05-28', 0),
(55, 73, 4, 57000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(56, 75, 3, 39000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(57, 76, 2, 28000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(58, 77, 5, 67000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(59, 74, 2, 20500, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 41, 0, '2024-05-28', 0),
(60, 78, 2, 45000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-28', 0),
(61, 79, 4, 53000, 'Yes', 'New Acceptor', 'spacing', 0, '1', '123', 46, 0, '2024-05-29', 0),
(62, 79, 2, 47000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(63, 80, 4, 58000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(64, 81, 4, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(65, 82, 2, 29000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(66, 83, 3, 37000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(67, 84, 4, 35000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(68, 85, 6, 58000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(69, 86, 2, 43000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(70, 87, 1, 39000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(71, 88, 4, 39000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(72, 89, 1, 31000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(73, 94, 5, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(74, 94, 5, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(75, 90, 4, 45000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(76, 91, 4, 39000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(77, 92, 2, 34000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(78, 93, 5, 57000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(79, 100, 3, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(80, 94, 3, 37000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(81, 95, 2, 27800, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(82, 96, 2, 57000, 'Yes', 'New Acceptor', 'spacing', 2, '1', '123', 46, 0, '2024-05-29', 0),
(83, 103, 1, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(84, 97, 3, 71000, 'Yes', 'NewAcceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(85, 98, 4, 34000, 'Yes', 'New Acceptor', 'spacing', 2, '1', '123', 46, 0, '2024-05-29', 0),
(86, 104, 3, 50000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(87, 99, 7, 59000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(88, 101, 4, 68000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(89, 102, 3, 40000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-29', 0),
(90, 105, 1, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-29', 0),
(91, 106, 5, 47000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(92, 107, 3, 50000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(93, 109, 5, 80000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(94, 109, 1, 44000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(95, 110, 5, 49000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(96, 111, 5, 61000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(97, 112, 2, 37000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(98, 113, 5, 37000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(99, 114, 2, 45000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(100, 115, 2, 27000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(101, 116, 3, 25000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(102, 117, 6, 57000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(103, 119, 5, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(104, 118, 3, 29000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(105, 121, 5, 39000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 46, 0, '2024-05-30', 0),
(106, 124, 2, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(107, 146, 4, 38000, 'Yes', 'New Acceptor', 'spacing', 2, '1', '123', 41, 0, '2024-05-30', 0),
(108, 182, 2, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(109, 183, 1, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(110, 186, 3, 40000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(111, 190, 3, 50000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(112, 191, 4, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(113, 192, 2, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(114, 193, 3, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(115, 194, 4, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(116, 195, 4, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(117, 196, 5, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(118, 198, 4, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(119, 199, 3, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(120, 200, 2, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-30', 0),
(121, 202, 2, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(122, 203, 4, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(123, 205, 2, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(124, 207, 3, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(125, 209, 2, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(126, 210, 3, 20000, 'Yes', 'New Acceptor', 'spacing', 0, '1', '123', 45, 0, '2024-05-31', 0),
(127, 210, 2, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(128, 212, 3, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(129, 215, 5, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(130, 216, 4, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(131, 217, 5, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(132, 218, 4, 30000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(133, 220, 1, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(134, 224, 1, 10000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(135, 225, 3, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(136, 227, 2, 20000, 'Yes', 'New Acceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0),
(137, 234, 4, 20000, 'No', 'NewAcceptor', 'spacing', 1, '1', '123', 45, 0, '2024-05-31', 0);

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
(1, 2, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 0, 1),
(2, 14, NULL, 'No', 'No', 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 0, 2),
(3, 26, NULL, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 0, 3),
(4, 29, NULL, 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 0, 4),
(5, 5, 1, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(6, 17, 2, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(7, 30, NULL, 'Yes', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 0, 5),
(8, 23, 3, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(9, 1, 4, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(10, 22, 5, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(11, 28, 6, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(12, 20, 7, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(13, 7, 8, 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(14, 19, 9, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(15, 25, 10, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(16, 10, 11, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(17, 16, 12, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(18, 15, 13, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(19, 8, 14, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(20, 8, 15, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(21, 9, 16, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(22, 3, 17, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(23, 4, 18, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(24, 6, 19, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(25, 11, 20, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(26, 12, 21, 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(27, 13, 22, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(28, 18, 23, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(29, 21, 24, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(30, 20, 25, 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(31, 24, 26, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(32, 31, NULL, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'No', 'No', 0, 6),
(33, 33, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 0, 7),
(34, 32, 27, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(35, 34, 28, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(36, 34, 29, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(37, 34, 30, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(38, 35, 31, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(39, 36, NULL, 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 0, 8),
(40, 37, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 0, 9),
(41, 39, 32, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(42, 38, NULL, 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 0, 10),
(43, 40, 33, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(44, 41, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'Yes', 0, 11),
(45, 42, 34, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(46, 45, 35, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(47, 44, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 0, 12),
(48, 47, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, 13),
(49, 46, 36, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(50, 48, NULL, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, 14),
(51, 49, 37, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(52, 50, NULL, 'No', 'Yes', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 0, 15),
(53, 51, 38, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(54, 52, NULL, 'Yes', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 0, 16),
(55, 53, 39, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(56, 54, NULL, 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 0, 17),
(57, 55, 40, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(58, 56, NULL, 'No', 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 0, 18),
(59, 57, 41, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(60, 58, NULL, 'Yes', 'No', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 0, 19),
(61, 59, 42, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(62, 60, NULL, 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'No', 'No', 0, 20),
(63, 61, 43, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(64, 62, 44, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(65, 63, 45, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(66, 64, 46, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(67, 65, NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 0, 21),
(68, 67, 47, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(69, 65, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 22),
(70, 65, 48, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(71, 65, 49, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(72, 65, 50, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(73, 72, 51, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(74, 71, 52, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(75, 69, 53, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(76, 70, 54, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(77, 73, 55, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(78, 75, 56, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(79, 76, 57, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(80, 77, 58, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(81, 74, 59, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(82, 78, 60, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(83, 79, 61, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(84, 79, 62, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(85, 80, 63, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(86, 81, 64, 'Yes', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'Yes', 'No', 'Yes', 0, NULL),
(87, 82, 65, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(88, 83, 66, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(89, 84, 67, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 0, NULL),
(90, 85, 68, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(91, 86, 69, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(92, 87, 70, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(93, 88, 71, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(94, 89, 72, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 0, NULL),
(95, 94, 73, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(96, 94, 74, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(97, 90, 75, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(98, 91, 76, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(99, 92, 77, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(100, 93, 78, 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(101, 100, 79, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(102, 94, 80, 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(103, 95, 81, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(104, 96, 82, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(105, 103, 83, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 0, NULL),
(106, 97, 84, 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(107, 98, 85, 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(108, 104, 86, 'Yes', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(109, 99, 87, 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(110, 101, 88, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(111, 102, 89, 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(112, 105, 90, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(113, 106, 91, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(114, 107, 92, 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(115, 109, 93, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(116, 109, 94, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(117, 110, 95, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(118, 111, 96, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(119, 112, 97, 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(120, 113, 98, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(121, 114, 99, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(122, 115, 100, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(123, 116, 101, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(124, 117, 102, 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(125, 119, 103, 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(126, 118, 104, 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(127, 121, 105, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(128, 124, 106, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(129, 148, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 23),
(130, 146, 107, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(131, 179, NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 0, 24),
(132, 182, 108, 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 0, NULL),
(133, 183, 109, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 0, NULL),
(134, 186, 110, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(135, 190, 111, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 0, NULL),
(136, 191, 112, 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(137, 192, 113, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(138, 193, 114, 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(139, 194, 115, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(140, 195, 116, 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 0, NULL),
(141, 196, 117, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(142, 198, 118, 'Yes', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(143, 199, 119, 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(144, 200, 120, 'Yes', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(145, 202, 121, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(146, 203, 122, 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(147, 205, 123, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(148, 207, 124, 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(149, 209, 125, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(150, 210, 126, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 0, NULL),
(151, 210, 127, 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 0, NULL),
(152, 212, 128, 'Yes', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 0, NULL),
(153, 215, 129, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(154, 216, 130, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 0, NULL),
(155, 217, 131, 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(156, 218, 132, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 0, NULL),
(157, 220, 133, 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(158, 224, 134, 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 0, NULL),
(159, 225, 135, 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(160, 227, 136, 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(161, 234, 137, 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, NULL),
(162, 248, NULL, 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 25),
(163, 247, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 26),
(164, 246, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 27),
(165, 245, NULL, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 28),
(166, 242, NULL, 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 0, 29);

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
(1, '2024-05-08', 4, '2022-09-22', 'Vaginal', 'Scanty', 1, 0),
(2, '2024-05-02', 3, '2021-11-05', 'Vaginal', 'Scanty', 2, 0),
(3, '2024-05-28', 1, '2022-11-30', 'Vaginal', 'Scanty', 3, 0),
(4, '2024-05-17', 3, '2021-12-20', 'Vaginal', 'Scanty', 4, 0),
(5, '2024-03-29', 4, '2023-06-18', 'Vaginal', 'Scanty', 5, 0),
(6, '2024-05-05', 3, '2021-10-15', 'Vaginal', 'Scanty', 6, 0),
(7, '2024-04-25', 5, '2022-07-30', 'Vaginal', 'Scanty', 7, 0),
(8, '2024-05-01', 1, '2023-10-11', 'Vaginal', 'Scanty', 8, 0),
(9, '2024-04-20', 6, '2023-08-12', 'Vaginal', 'Scanty', 9, 0),
(10, '2024-05-01', 4, '2021-11-23', 'Vaginal', 'Scanty', 10, 0),
(11, '2024-05-15', 3, '2021-09-14', 'Vaginal', 'Scanty', 11, 0),
(12, '2024-05-15', 3, '2021-09-14', 'Vaginal', 'Scanty', 12, 0),
(13, '2024-05-15', 7, '2021-09-14', 'Vaginal', 'Scanty', 13, 0),
(14, '2024-04-01', 4, '2023-08-04', 'Vaginal', 'Scanty', 14, 0),
(15, '2024-04-01', 4, '2023-08-04', 'Vaginal', 'Scanty', 15, 0),
(16, '2024-04-01', 3, '2023-08-04', 'Vaginal', 'Scanty', 16, 0),
(17, '2024-05-03', 5, '2022-06-10', 'Vaginal', 'Scanty', 17, 0),
(18, '2024-05-03', 1, '2022-06-10', 'Vaginal', 'Scanty', 18, 0),
(19, '2024-05-04', 3, '2022-06-11', 'Vaginal', 'Scanty', 19, 0),
(20, '2024-05-04', 5, '2023-06-11', 'Vaginal', 'Scanty', 20, 0),
(21, '2024-05-04', 2, '2023-06-11', 'Vaginal', 'Scanty', 21, 0),
(22, '2024-04-28', 3, '2021-10-17', 'Vaginal', 'Scanty', 22, 0),
(23, '2024-04-28', 1, '2021-10-17', 'Vaginal', 'Scanty', 23, 0),
(24, '2024-05-25', 5, '2022-11-16', 'Vaginal', 'Scanty', 24, 0),
(25, '2024-04-30', 4, '2022-09-18', 'Vaginal', 'Scanty', 25, 0),
(26, '2024-05-10', 1, '2023-02-19', 'Vaginal', 'Scanty', 26, 0),
(27, '2024-04-15', 3, '2022-07-28', 'Vaginal', 'Scanty', 27, 0),
(28, '2024-05-01', 3, '2022-12-31', 'Vaginal', 'Scanty', 28, 0),
(29, '2024-04-30', 1, '2023-07-27', 'Vaginal', 'Scanty', 29, 0),
(30, '2024-05-07', 6, '2023-09-13', 'Vaginal', 'Scanty', 30, 0),
(31, '2024-05-22', 6, '2023-11-13', 'Vaginal', 'Scanty', 31, 0),
(32, '2024-05-15', 3, '2022-07-31', 'Vaginal', 'Scanty', 32, 0),
(33, '2024-05-15', 2, '2023-04-15', 'Vaginal', 'Scanty', 33, 0),
(34, '2024-05-15', 5, '2023-06-10', 'Vaginal', 'Scanty', 34, 0),
(35, '2024-05-10', 3, '2022-08-15', 'Vaginal', 'Scanty', 35, 0),
(36, '2024-05-21', 4, '2022-03-07', 'Vaginal', 'Scanty', 36, 0),
(37, '2024-05-02', 3, '2023-01-30', 'Vaginal', 'Scanty', 37, 0),
(38, '2024-04-30', 2, '2022-12-01', 'Vaginal', 'Scanty', 38, 0),
(39, '2024-05-18', 3, '2023-07-02', 'Vaginal', 'Scanty', 39, 0),
(40, '2024-05-20', 4, '2023-02-17', 'Vaginal', 'Scanty', 40, 0),
(41, '2024-05-12', 2, '2022-10-31', 'Vaginal', 'Scanty', 41, 0),
(42, '2024-05-21', 3, '2023-02-01', 'Vaginal', 'Scanty', 42, 0),
(43, '2024-05-15', 4, '2022-05-30', 'Vaginal', 'Scanty', 43, 0),
(44, '2024-04-30', 5, '2021-12-31', 'Vaginal', 'Scanty', 44, 0),
(45, '2024-05-01', 2, '2022-02-14', 'Vaginal', 'Scanty', 45, 0),
(46, '2024-04-30', 1, '2021-06-30', 'Vaginal', 'Scanty', 46, 0),
(47, '2024-04-30', 4, '0000-00-00', 'Vaginal', 'Scanty', 47, 0),
(48, '2024-05-02', 1, '2023-05-05', 'Vaginal', 'Scanty', 48, 0),
(49, '2024-05-01', 1, '2023-06-09', 'Vaginal', 'Scanty', 49, 0),
(50, '2024-05-15', 2, '2023-07-31', 'Vaginal', 'Scanty', 50, 0),
(51, '2024-05-17', 2, '2022-05-26', 'Vaginal', 'Scanty', 51, 0),
(52, '2024-05-17', 2, '2021-05-26', 'Vaginal', 'Scanty', 52, 0),
(53, '2024-05-25', 2, '2022-01-01', 'Vaginal', 'Scanty', 53, 0),
(54, '2024-05-17', 2, '2021-05-26', 'Vaginal', 'Scanty', 54, 0),
(55, '2024-05-01', 4, '2023-05-12', 'Vaginal', 'Scanty', 55, 0),
(56, '2024-05-15', 3, '2023-01-01', 'Vaginal', 'Scanty', 56, 0),
(57, '2024-05-11', 2, '2023-05-20', 'Vaginal', 'Scanty', 57, 0),
(58, '2024-05-21', 5, '2023-04-06', 'Vaginal', 'Scanty', 58, 0),
(59, '2024-05-08', 2, '2019-05-26', 'Vaginal', 'Scanty', 59, 0),
(60, '2024-05-24', 2, '2022-05-30', 'Vaginal', 'Scanty', 60, 0),
(61, '2024-05-10', 4, '2023-01-17', 'Vaginal', 'Scanty', 61, 0),
(62, '2024-05-21', 2, '2023-12-30', 'Vaginal', 'Scanty', 62, 0),
(63, '2024-05-01', 4, '2024-03-21', 'Vaginal', 'Scanty', 63, 0),
(64, '2024-05-05', 4, '2024-02-01', 'Vaginal', 'Scanty', 64, 0),
(65, '2024-05-14', 2, '2023-08-14', 'Vaginal', 'Scanty', 65, 0),
(66, '2024-05-08', 3, '2021-01-24', 'Vaginal', 'Scanty', 66, 0),
(67, '2024-05-15', 4, '2023-07-17', 'Vaginal', 'Scanty', 67, 0),
(68, '2024-05-14', 6, '2023-03-01', 'Vaginal', 'Scanty', 68, 0),
(69, '2024-05-25', 2, '2022-08-22', 'Vaginal', 'Scanty', 69, 0),
(70, '2024-05-14', 1, '2022-08-16', 'Vaginal', 'Scanty', 70, 0),
(71, '2024-04-30', 4, '2022-09-15', 'Vaginal', 'Scanty', 71, 0),
(72, '2024-05-23', 1, '2023-08-08', 'Vaginal', 'Scanty', 72, 0),
(73, '2024-04-02', 5, '2023-05-01', 'Vaginal', 'Scanty', 73, 0),
(74, '2024-04-02', 5, '2023-05-01', 'Vaginal', 'Scanty', 74, 0),
(75, '2024-05-10', 4, '2022-03-06', 'Vaginal', 'Scanty', 75, 0),
(76, '2024-05-16', 4, '2023-11-16', 'Vaginal', 'Scanty', 76, 0),
(77, '2024-05-22', 2, '2023-10-24', 'Vaginal', 'Scanty', 77, 0),
(78, '2024-05-15', 5, '2023-12-31', 'Vaginal', 'Scanty', 78, 0),
(79, '2024-03-05', 3, '2024-01-02', 'Vaginal', 'Scanty', 79, 0),
(80, '2024-05-21', 3, '2023-03-14', 'Vaginal', 'Scanty', 80, 0),
(81, '2024-05-01', 2, '2023-08-30', 'Vaginal', 'Scanty', 81, 0),
(82, '2024-05-07', 2, '2023-12-06', 'Vaginal', 'Scanty', 82, 0),
(83, '2024-03-04', 1, '2023-12-03', 'Vaginal', 'Scanty', 83, 0),
(84, '2024-05-24', 3, '2018-05-26', 'Vaginal', 'Scanty', 84, 0),
(85, '2024-05-09', 4, '2023-08-16', 'Vaginal', 'Scanty', 85, 0),
(86, '2024-04-08', 3, '2023-03-07', 'Vaginal', 'Scanty', 86, 0),
(87, '2024-05-11', 7, '2023-05-11', 'Vaginal', 'Scanty', 87, 0),
(88, '2024-05-12', 4, '2022-05-17', 'Vaginal', 'Scanty', 88, 0),
(89, '2024-05-18', 3, '2022-12-15', 'Vaginal', 'Scanty', 89, 0),
(90, '2024-05-05', 1, '2023-02-01', 'Vaginal', 'Scanty', 90, 0),
(91, '2024-05-09', 5, '2023-05-31', 'Vaginal', 'Scanty', 91, 0),
(92, '2024-05-12', 3, '2023-02-08', 'Vaginal', 'Scanty', 92, 0),
(93, '2024-05-17', 5, '2023-04-04', 'Vaginal', 'Scanty', 93, 0),
(94, '2024-05-15', 1, '2021-10-21', 'Vaginal', 'Scanty', 94, 0),
(95, '2024-05-17', 5, '2022-05-16', 'Vaginal', 'Scanty', 95, 0),
(96, '2024-05-20', 5, '2023-03-22', 'Vaginal', 'Scanty', 96, 0),
(97, '2024-05-24', 2, '2021-09-15', 'Vaginal', 'Scanty', 97, 0),
(98, '2024-05-15', 5, '2021-02-28', 'Vaginal', 'Scanty', 98, 0),
(99, '2024-05-07', 2, '2020-05-08', 'Vaginal', 'Scanty', 99, 0),
(100, '2024-05-01', 2, '2022-05-16', 'Vaginal', 'Scanty', 100, 0),
(101, '2024-05-06', 3, '2022-12-31', 'Vaginal', 'Scanty', 101, 0),
(102, '2024-05-15', 6, '2020-10-18', 'Vaginal', 'Scanty', 102, 0),
(103, '2024-04-10', 5, '2022-04-06', 'Vaginal', 'Scanty', 103, 0),
(104, '2024-04-30', 3, '0000-00-00', 'Vaginal', 'Scanty', 104, 0),
(105, '2024-05-07', 5, '2019-03-15', 'Vaginal', 'Scanty', 105, 0),
(106, '2024-05-01', 2, '2022-04-04', 'Vaginal', 'Scanty', 106, 0),
(107, '2024-05-25', 4, '2023-04-26', 'Vaginal', 'Scanty', 107, 0),
(108, '2024-05-21', 2, '2022-05-28', 'Vaginal', 'Scanty', 108, 0),
(109, '2024-05-22', 1, '2023-05-17', 'Vaginal', 'Scanty', 109, 0),
(110, '2024-05-15', 3, '2022-04-05', 'Vaginal', 'Scanty', 110, 0),
(111, '2024-05-22', 3, '2023-03-07', 'Vaginal', 'Scanty', 111, 0),
(112, '2024-05-23', 4, '2023-02-08', 'Vaginal', 'Scanty', 112, 0),
(113, '2024-05-16', 2, '2023-04-04', 'Vaginal', 'Scanty', 113, 0),
(114, '2024-05-07', 3, '2022-02-17', 'Vaginal', 'Scanty', 114, 0),
(115, '2024-05-21', 4, '2023-02-06', 'Vaginal', 'Scanty', 115, 0),
(116, '2024-05-25', 4, '2023-05-08', 'Vaginal', 'Scanty', 116, 0),
(117, '2024-05-23', 5, '2023-05-28', 'Vaginal', 'Scanty', 117, 0),
(118, '2024-05-21', 4, '2023-03-15', 'Vaginal', 'Scanty', 118, 0),
(119, '2024-05-15', 3, '2023-04-09', 'Vaginal', 'Scanty', 119, 0),
(120, '2024-05-23', 2, '2023-01-18', 'Vaginal', 'Scanty', 120, 0),
(121, '2024-05-27', 2, '2023-02-15', 'Vaginal', 'Scanty', 121, 0),
(122, '2024-05-25', 4, '2022-12-15', 'Vaginal', 'Scanty', 122, 0),
(123, '2024-05-27', 2, '2023-03-08', 'Vaginal', 'Scanty', 123, 0),
(124, '2024-05-26', 3, '2023-01-16', 'Vaginal', 'Scanty', 124, 0),
(125, '2024-05-27', 2, '2022-12-06', 'Vaginal', 'Scanty', 125, 0),
(126, '2024-05-25', 3, '2022-11-08', 'Vaginal', 'Scanty', 126, 0),
(127, '2024-05-21', 2, '2023-03-16', 'Vaginal', 'Scanty', 127, 0),
(128, '2024-05-27', 3, '2023-05-28', 'Vaginal', 'Scanty', 128, 0),
(129, '2024-05-26', 5, '2023-02-07', 'Vaginal', 'Scanty', 129, 0),
(130, '2024-05-24', 4, '2023-03-14', 'Vaginal', 'Scanty', 130, 0),
(131, '2024-05-08', 5, '2024-01-16', 'Vaginal', 'Scanty', 131, 0),
(132, '2024-05-25', 4, '2023-11-14', 'Vaginal', 'Scanty', 132, 0),
(133, '2024-05-23', 1, '2023-11-14', 'Vaginal', 'Scanty', 133, 0),
(134, '2024-05-26', 1, '2024-02-12', 'Vaginal', 'Scanty', 134, 0),
(135, '2024-05-25', 3, '2023-02-13', 'Vaginal', 'Scanty', 135, 0),
(136, '2024-05-24', 2, '2024-02-13', 'Vaginal', 'Scanty', 136, 0),
(137, '2024-05-27', 4, '2023-02-14', 'Vaginal', 'Scanty', 137, 0);

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
(1, '55', '12080', '150', '70', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 1),
(2, '68', '12080', '145', '70', 'Hematoma', 'Edema', 'Yellowish', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 2),
(3, '60', '12080', '150', '70', 'Yellowish', 'Normal', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 3),
(4, '70', '12080', '160', '70', 'Hematoma', 'Normal', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 4),
(5, '68', '117', '170', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 1, 0, NULL),
(6, '60', '113', '163', '93', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 2, 0, NULL),
(7, '67', '12080', '155', '70', 'Normal', 'Edema', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 5),
(8, '69', '120', '171', '97', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 3, 0, NULL),
(9, '60', '113', '165', '95', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 4, 0, NULL),
(10, '58', '119', '160', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 5, 0, NULL),
(11, '65', '114', '167', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 6, 0, NULL),
(12, '60', '114', '163', '92', '', '', '', '', '', '', 7, 0, NULL),
(13, '68', '106', '170', '91', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 8, 0, NULL),
(14, '61', '116', '157', '87', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 9, 0, NULL),
(15, '64', '120', '169', '100', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 10, 0, NULL),
(16, '65', '108', '169', '97', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 11, 0, NULL),
(17, '73', '120', '170', '100', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 12, 0, NULL),
(18, '72', '119', '167', '94', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 13, 0, NULL),
(19, '75', '117', '170', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 14, 0, NULL),
(20, '75', '117', '170', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 15, 0, NULL),
(21, '65', '113', '159', '98', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 16, 0, NULL),
(22, '75', '113', '173', '100', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 17, 0, NULL),
(23, '58', '109', '163', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 18, 0, NULL),
(24, '67', '118', '163', '94', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 19, 0, NULL),
(25, '61', '107', '168', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 20, 0, NULL),
(26, '67', '118', '169', '98', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 21, 0, NULL),
(27, '64', '111', '161', '92', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 22, 0, NULL),
(28, '61', '115', '159', '90', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 23, 0, NULL),
(29, '70', '113', '172', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 24, 0, NULL),
(30, '60', '119', '159', '98', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 25, 0, NULL),
(31, '61', '107', '161', '87', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 26, 0, NULL),
(32, '60', '12080', '145', '70', 'Normal', 'Varicosities', 'Yellowish', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 6),
(33, '75', '12080', '150', '70', 'Normal', 'Edema', 'Normal', 'Normal', NULL, NULL, NULL, 0, 7),
(34, '67', '110', '160', '84', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 27, 0, NULL),
(35, '58', '120', '157', '100', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 28, 0, NULL),
(36, '67', '118', '164', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 29, 0, NULL),
(37, '56', '103', '159', '85', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 30, 0, NULL),
(38, '64', '120', '169', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 31, 0, NULL),
(39, '58', '12080', '145', '70', 'Normal', 'Edema', 'Normal', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 8),
(40, '65', '12080', '160', '70', 'Normal', 'Edema', 'Normal', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 9),
(41, '62', '113', '159', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 32, 0, NULL),
(42, '60', '12080', '150', '70', 'Normal', 'Edema', 'Normal', 'Normal', NULL, NULL, NULL, 0, 10),
(43, '61', '120', '159', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 33, 0, NULL),
(44, '67', '12080', '140', '70', 'Normal', 'Edema', 'Normal', 'Normal', NULL, NULL, NULL, 0, 11),
(45, '57', '120', '', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 34, 0, NULL),
(46, '60', '108', '165', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 35, 0, NULL),
(47, '50', '12080', '150', '70', 'Normal', 'Edema', 'Normal', 'Normal', NULL, NULL, NULL, 0, 12),
(48, '60', '12080', '158', '70', 'Normal', 'Varicosities', 'Normal', 'Normal', NULL, NULL, NULL, 0, 13),
(49, '58', '107', '160', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 36, 0, NULL),
(50, '50', '12080', '150', '70', 'Yellowish', 'Edema', 'Normal', 'Normal', NULL, NULL, NULL, 0, 14),
(51, '61', '112', '159', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 37, 0, NULL),
(52, '60', '12080', '157', '70', 'Hematoma', 'Normal', 'Yellowish', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 15),
(53, '59', '111', '162', '97', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 38, 0, NULL),
(54, '60', '12090', '140', '70', 'Normal', 'Varicosities', 'Normal', 'EnlargeLymphNodes', NULL, NULL, NULL, 0, 16),
(55, '65', '116', '167', '94', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 39, 0, NULL),
(56, '60', '12080', '140', '70', 'Normal', 'Edema', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 17),
(57, '56', '105', '160', '99', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 40, 0, NULL),
(58, '60', '12080', '158', '70', 'Normal', 'Edema', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 18),
(59, '57', '110', '160', '90', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 41, 0, NULL),
(60, '70', '12080', '150', '70', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 19),
(61, '59', '120', '161', '92', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 42, 0, NULL),
(62, '50', '12080', '150', '70', 'Normal', 'Edema', 'Yellowish', 'Normal', NULL, NULL, NULL, 0, 20),
(63, '59', '113', '161', '87', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 43, 0, NULL),
(64, '64', '109', '160', '97', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 44, 0, NULL),
(65, '60', '117', '159', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 45, 0, NULL),
(66, '63', '103', '165', '91', '', '', '', '', '', '', 46, 0, NULL),
(67, '70', '118', '173', '93', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 21),
(68, '60', '117', '161', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 47, 0, NULL),
(69, '70', '117', '173', '96', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 22),
(70, '50', '120', '55', '180/90', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 48, 0, NULL),
(71, '50', '120', '55', '180/90', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 49, 0, NULL),
(72, '68', '113', '163', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 50, 0, NULL),
(73, '73', '120/90', '167', '90/60', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 51, 0, NULL),
(74, '75', '12090', '168', '9060', '', '', '', '', '', '', 52, 0, NULL),
(75, '63', '118', '167', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 53, 0, NULL),
(76, '65', '120/90', '168', '90/60', '', '', '', '', '', '', 54, 0, NULL),
(77, '67', '113', '165', '91', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 55, 0, NULL),
(78, '59', '111', '160', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 56, 0, NULL),
(79, '56', '113', '158', '87', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 57, 0, NULL),
(80, '57', '118', '160', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 58, 0, NULL),
(81, '65', '120/90', '167', '90/60', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 59, 0, NULL),
(82, '63', '113', '159', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 60, 0, NULL),
(83, '65', '118', '173', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 61, 0, NULL),
(84, '57', '113', '158', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 62, 0, NULL),
(85, '61', '113', '163', '87', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 63, 0, NULL),
(86, '55', '120', '140', '70', 'Hematoma', 'Normal', 'Normal', 'Normal', 'Normal', 'Varicosities', 64, 0, NULL),
(87, '58', '113', '161', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 65, 0, NULL),
(88, '57', '118', '158', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 66, 0, NULL),
(89, '56', '113', '158', '85', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 67, 0, NULL),
(90, '58', '117', '157', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 68, 0, NULL),
(91, '67', '113', '170', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 69, 0, NULL),
(92, '59', '113', '156', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 70, 0, NULL),
(93, '63', '118', '169', '100', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 71, 0, NULL),
(94, '57', '113', '159', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 72, 0, NULL),
(95, '60', '120', '150', '80', 'Normal', 'Varicosities', 'Yellowish', '', 'Mass', 'Normal', 73, 0, NULL),
(96, '60', '120', '150', '80', 'Normal', 'Varicosities', 'Yellowish', 'Normal', 'Mass', 'Normal', 74, 0, NULL),
(97, '59', '113', '161', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 75, 0, NULL),
(98, '67', '113', '173', '87', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 76, 0, NULL),
(99, '58', '109', '156', '86', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 77, 0, NULL),
(100, '58', '113', '157', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 78, 0, NULL),
(101, '70', '115', '150', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 79, 0, NULL),
(102, '60', '113', '165', '91', 'Pale', 'Normal', 'Pale', 'Normal', 'Normal', 'Normal', 80, 0, NULL),
(103, '67', '118', '173', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Varicosities', 81, 0, NULL),
(104, '55', '113', '157', '95', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 82, 0, NULL),
(105, '60', '115', '157', '79', 'Normal', 'Normal', 'Yellowish', 'Normal', 'Normal', 'Normal', 83, 0, NULL),
(106, '61', '113', '163', '98', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 84, 0, NULL),
(107, '68', '113', '169', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 85, 0, NULL),
(108, '60', '120', '145', '80', 'Hematoma', 'Normal', 'Yellowish', 'Normal', 'Normal', 'Normal', 86, 0, NULL),
(109, '57', '113', '156', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 87, 0, NULL),
(110, '58', '112', '160', '98', 'Normal', 'Varicosities', 'Normal', 'Normal', 'Normal', 'Varicosities', 88, 0, NULL),
(111, '64', '118', '159', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 89, 0, NULL),
(112, '60', '115', '140', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 90, 0, NULL),
(113, '59', '118', '154', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 91, 0, NULL),
(114, '60', '120', '150', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 92, 0, NULL),
(115, '75', '116', '156', '78', 'Hematoma', 'Normal', 'Normal', 'Enlarge Lymph Nodes', 'Normal', 'Abdominal Mass', 93, 0, NULL),
(116, '59', '113', '156', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 94, 0, NULL),
(117, '62', '117', '163', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 95, 0, NULL),
(118, '58', '109', '161', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 96, 0, NULL),
(119, '54', '113', '155', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 97, 0, NULL),
(120, '59', '118', '157', '93', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 98, 0, NULL),
(121, '61', '118', '157', '96', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 99, 0, NULL),
(122, '64', '113', '160', '85', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 100, 0, NULL),
(123, '67', '101', '163', '84', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 101, 0, NULL),
(124, '68', '109', '169', '89', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 102, 0, NULL),
(125, '60', '129', '150', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 103, 0, NULL),
(126, '67', '113', '160', '93', 'Pale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 104, 0, NULL),
(127, '63', '118', '159', '', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 105, 0, NULL),
(128, '60', '120', '150', '80', 'Normal', 'Normal', 'Normal', 'Enlarge Lymph Nodes', 'Normal', 'Normal', 106, 0, NULL),
(129, '55', '10080', '55', '18090', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 23),
(130, '55', '120/80', '55', '180/90', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 107, 0, NULL),
(131, '69', '10080', '165', '90', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 24),
(132, '60', '120', '150', '80', 'Normal', 'Normal', 'Yellowish', 'Enlarge Lymph Nodes', 'Normal', 'Normal', 108, 0, NULL),
(133, '58', '120', '150', '70', 'Yellowish', 'Normal', 'Yellowish', 'Normal', 'Normal', 'Normal', 109, 0, NULL),
(134, '70', '120', '156', '80', 'Yellowish', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 110, 0, NULL),
(135, '60', '120', '145', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Mass', 'Normal', 111, 0, NULL),
(136, '60', '125', '154', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 112, 0, NULL),
(137, '70', '120', '150', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 113, 0, NULL),
(138, '55', '115', '153', '76', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 114, 0, NULL),
(139, '70', '117', '156', '76', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 115, 0, NULL),
(140, '60', '118', '147', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 116, 0, NULL),
(141, '72', '119', '158', '81', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 117, 0, NULL),
(142, '68', '119', '150', '78', 'Yellowish', 'Normal', 'Normal', 'Enlarge Lymph Nodes', 'Normal', 'Normal', 118, 0, NULL),
(143, '65', '120', '146', '79', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 119, 0, NULL),
(144, '69', '120', '158', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 120, 0, NULL),
(145, '68', '120', '156', '70', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 121, 0, NULL),
(146, '58', '118', '148', '78', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 122, 0, NULL),
(147, '60', '117', '149', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 123, 0, NULL),
(148, '69', '117', '150', '78', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 124, 0, NULL),
(149, '60', '119', '148', '79', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 125, 0, NULL),
(150, '60', '120', '150', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 126, 0, NULL),
(151, '67', '117', '158', '75', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 127, 0, NULL),
(152, '60', '120', '140', '70', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 128, 0, NULL),
(153, '69', '120', '149', '78', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 129, 0, NULL),
(154, '50', '120', '150', '70', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 130, 0, NULL),
(155, '60', '116', '158', '74', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 131, 0, NULL),
(156, '70', '116', '157', '71', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 132, 0, NULL),
(157, '48', '115', '135', '70', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 133, 0, NULL),
(158, '60', '120', '140', '70', 'Normal', 'Normal', 'Yellowish', 'Normal', 'Normal', 'Normal', 134, 0, NULL),
(159, '68', '120', '140', '70', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 135, 0, NULL),
(160, '60', '119', '150', '78', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 136, 0, NULL),
(161, '70', '120', '150', '80', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 137, 0, NULL),
(162, '75', '12090', '167', '9060', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 25),
(163, '50', '12080', '150', '70', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 26),
(164, '55', '12080', '165', '70', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 27),
(165, '60', '13080', '165', '78', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 28),
(166, '55', '12080', '165', '70', 'Normal', 'Normal', 'Normal', 'Normal', NULL, NULL, NULL, 0, 29);

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
(1, 1, 'No', 'No', 'No', 'No', 'No'),
(2, 2, 'Yes', 'No', 'No', 'No', 'No'),
(3, 3, 'No', 'No', 'No', 'No', 'No'),
(4, 4, 'No', 'No', 'No', 'No', 'No'),
(5, 5, 'No', 'No', 'No', 'No', 'No'),
(6, 6, 'Yes', 'No', 'No', 'No', 'No'),
(7, 7, 'No', 'No', 'No', 'No', 'No'),
(8, 8, 'Yes', 'No', 'No', 'No', 'No'),
(9, 9, 'No', 'No', 'No', 'No', 'No'),
(10, 10, 'No', 'No', 'No', 'No', 'No'),
(11, 11, 'No', 'No', 'No', 'No', 'No'),
(12, 12, 'No', 'No', 'No', 'No', 'No'),
(13, 13, 'Yes', 'No', 'No', 'No', 'No'),
(14, 14, 'No', 'No', 'No', 'No', 'No'),
(15, 15, 'No', 'No', 'No', 'No', 'No'),
(16, 16, 'No', 'No', 'No', 'No', 'No'),
(17, 17, 'No', 'No', 'No', 'No', 'No'),
(18, 18, 'No', 'No', 'No', 'No', 'No'),
(19, 19, 'No', 'No', 'No', 'No', 'No'),
(20, 20, 'No', 'No', 'No', 'No', 'No'),
(21, 21, 'Yes', 'No', 'No', 'No', 'No'),
(22, 22, 'No', 'No', 'No', 'No', 'No'),
(23, 23, 'No', 'No', 'No', 'No', 'No'),
(24, 24, 'Yes', 'No', 'No', 'No', 'No'),
(25, 25, 'No', 'No', 'No', 'No', 'No'),
(26, 26, 'No', 'No', 'No', 'No', 'No'),
(27, 27, 'No', 'No', 'No', 'No', 'No'),
(28, 28, 'No', 'No', 'No', 'No', 'No'),
(29, 29, 'No', 'No', 'No', 'No', 'No'),
(30, 30, 'No', 'No', 'No', 'No', 'No'),
(31, 31, 'No', 'No', 'No', 'No', 'No'),
(32, 32, 'No', 'No', 'No', 'No', 'No'),
(33, 33, 'No', 'No', 'No', 'No', 'No'),
(34, 34, 'No', 'No', 'No', 'No', 'No'),
(35, 35, 'No', 'No', 'No', 'No', 'No'),
(36, 36, 'No', 'No', 'No', 'No', 'No'),
(37, 37, 'No', 'No', 'No', 'No', 'No'),
(38, 38, 'No', 'No', 'No', 'No', 'No'),
(39, 39, 'No', 'No', 'No', 'No', 'No'),
(40, 40, 'No', 'No', 'No', 'No', 'No'),
(41, 41, 'No', 'No', 'No', 'No', 'No'),
(42, 42, 'No', 'No', 'No', 'No', 'No'),
(43, 43, 'No', 'No', 'No', 'No', 'No'),
(44, 44, 'No', 'No', 'No', 'No', 'No'),
(45, 45, 'No', 'No', 'No', 'No', 'No'),
(46, 46, 'No', 'No', 'No', 'No', 'No'),
(47, 47, 'No', 'No', 'No', 'No', 'No'),
(48, 48, 'Yes', 'No', 'No', 'No', 'No'),
(49, 49, 'Yes', 'No', 'No', 'No', 'No'),
(50, 50, 'No', 'No', 'No', 'No', 'No'),
(51, 51, 'Yes', 'No', 'No', 'No', 'No'),
(52, 52, 'Yes', 'No', 'No', 'No', 'No'),
(53, 53, 'No', 'No', 'No', 'No', 'No'),
(54, 54, 'No', 'No', 'No', 'No', 'No'),
(55, 55, 'No', 'No', 'No', 'No', 'No'),
(56, 56, 'No', 'No', 'No', 'No', 'No'),
(57, 57, 'No', 'No', 'No', 'No', 'No'),
(58, 58, 'No', 'No', 'No', 'No', 'No'),
(59, 59, 'No', 'No', 'No', 'No', 'No'),
(60, 60, 'No', 'No', 'No', 'No', 'No'),
(61, 61, 'No', 'No', 'No', 'No', 'No'),
(62, 62, 'No', 'No', 'No', 'No', 'No'),
(63, 63, 'No', 'No', 'No', 'No', 'No'),
(64, 64, 'No', 'Yes', 'Yes', 'Yes', 'No'),
(65, 65, 'No', 'No', 'No', 'No', 'No'),
(66, 66, 'No', 'No', 'No', 'No', 'No'),
(67, 67, 'Yes', 'No', 'No', 'No', 'No'),
(68, 68, 'No', 'No', 'No', 'No', 'No'),
(69, 69, 'No', 'No', 'No', 'No', 'No'),
(70, 70, 'No', 'No', 'No', 'No', 'No'),
(71, 71, 'Yes', 'No', 'No', 'No', 'No'),
(72, 72, 'No', 'No', 'No', 'No', 'No'),
(73, 73, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(74, 74, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(75, 75, 'No', 'No', 'No', 'No', 'No'),
(76, 76, 'No', 'No', 'No', 'No', 'No'),
(77, 77, 'Yes', 'No', 'No', 'No', 'No'),
(78, 78, 'No', 'No', 'No', 'No', 'No'),
(79, 79, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(80, 80, 'No', 'No', 'No', 'No', 'No'),
(81, 81, 'No', 'No', 'No', 'No', 'No'),
(82, 82, 'No', 'No', 'No', 'No', 'No'),
(83, 83, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(84, 84, 'No', 'No', 'No', 'No', 'No'),
(85, 85, 'No', 'No', 'No', 'No', 'No'),
(86, 86, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(87, 87, 'No', 'No', 'No', 'No', 'No'),
(88, 88, 'No', 'No', 'No', 'No', 'No'),
(89, 89, 'No', 'No', 'No', 'No', 'No'),
(90, 90, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(91, 91, 'No', 'No', 'No', 'No', 'No'),
(92, 92, 'No', 'Yes', 'No', 'Yes', 'No'),
(93, 93, 'No', 'No', 'Yes', 'Yes', 'No'),
(94, 94, 'No', 'No', 'No', 'No', 'No'),
(95, 95, 'No', 'No', 'No', 'No', 'No'),
(96, 96, 'No', 'No', 'No', 'No', 'No'),
(97, 97, 'No', 'No', 'No', 'No', 'No'),
(98, 98, 'No', 'No', 'No', 'No', 'No'),
(99, 99, 'Yes', 'No', 'No', 'No', 'No'),
(100, 100, 'No', 'No', 'No', 'No', 'No'),
(101, 101, 'No', 'No', 'No', 'No', 'No'),
(102, 102, 'No', 'No', 'No', 'No', 'No'),
(103, 103, 'No', 'Yes', 'No', 'Yes', 'No'),
(104, 104, 'No', 'No', 'No', 'No', 'No'),
(105, 105, 'No', 'No', 'No', 'No', 'No'),
(106, 106, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(107, 107, 'No', 'No', 'Yes', 'No', 'No'),
(108, 108, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(109, 109, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(110, 110, 'Yes', 'No', 'Yes', 'No', 'No'),
(111, 111, 'No', 'No', 'Yes', 'Yes', 'No'),
(112, 112, 'Yes', 'No', 'No', 'No', 'Yes'),
(113, 113, 'Yes', 'No', 'No', 'No', 'Yes'),
(114, 114, 'Yes', 'No', 'No', 'No', 'Yes'),
(115, 115, 'No', 'No', 'Yes', 'Yes', 'No'),
(116, 116, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(117, 117, 'No', 'Yes', 'No', 'Yes', 'No'),
(118, 118, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(119, 119, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(120, 120, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(121, 121, 'Yes', 'No', 'No', 'No', 'Yes'),
(122, 122, 'No', 'Yes', 'No', 'Yes', 'No'),
(123, 123, 'Yes', 'Yes', 'No', 'No', 'Yes'),
(124, 124, 'Yes', 'No', 'Yes', 'No', 'Yes'),
(125, 125, 'Yes', 'Yes', 'No', 'No', 'No'),
(126, 126, 'Yes', 'Yes', 'No', 'No', 'No'),
(127, 127, 'Yes', 'No', 'Yes', 'Yes', 'No'),
(128, 128, 'Yes', 'No', 'No', 'No', 'No'),
(129, 129, 'No', 'No', 'Yes', 'Yes', 'No'),
(130, 130, 'Yes', 'No', 'No', 'No', 'No'),
(131, 131, 'Yes', 'No', 'No', 'No', 'No'),
(132, 132, 'Yes', 'No', 'No', 'No', 'No'),
(133, 133, 'Yes', 'No', 'No', 'No', 'No'),
(134, 134, 'Yes', 'No', 'No', 'No', 'No'),
(135, 135, 'No', 'No', 'No', 'Yes', 'No'),
(136, 136, 'Yes', 'No', 'No', 'No', 'No'),
(137, 137, 'Yes', 'No', 'No', 'No', 'No');

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
(1, 1, 'No', 'No', 'No'),
(2, 2, 'No', 'No', 'No'),
(3, 3, 'No', 'No', 'No'),
(4, 4, 'No', 'No', 'No'),
(5, 5, 'No', 'No', 'No'),
(6, 6, 'No', 'No', 'No'),
(7, 7, 'No', 'No', 'No'),
(8, 8, 'No', 'No', 'No'),
(9, 9, 'No', 'No', 'No'),
(10, 10, 'No', 'No', 'No'),
(11, 11, 'No', 'No', 'No'),
(12, 12, 'No', 'No', 'No'),
(13, 13, 'No', 'No', 'No'),
(14, 14, 'No', 'No', 'No'),
(15, 15, 'No', 'No', 'No'),
(16, 16, 'No', 'No', 'No'),
(17, 17, 'No', 'No', 'No'),
(18, 18, 'No', 'No', 'No'),
(19, 19, 'No', 'No', 'No'),
(20, 20, 'No', 'No', 'No'),
(21, 21, 'No', 'No', 'No'),
(22, 22, 'No', 'No', 'No'),
(23, 23, 'No', 'No', 'No'),
(24, 24, 'No', 'No', 'No'),
(25, 25, 'No', 'No', 'No'),
(26, 26, 'No', 'No', 'No'),
(27, 27, 'No', 'No', 'No'),
(28, 28, 'No', 'No', 'No'),
(29, 29, 'No', 'No', 'No'),
(30, 30, 'No', 'No', 'No'),
(31, 31, 'No', 'No', 'No'),
(32, 32, 'No', 'No', 'No'),
(33, 33, 'No', 'No', 'No'),
(34, 34, 'No', 'No', 'No'),
(35, 35, 'No', 'No', 'No'),
(36, 36, 'No', 'No', 'No'),
(37, 37, 'No', 'No', 'No'),
(38, 38, 'No', 'No', 'No'),
(39, 39, 'No', 'No', 'No'),
(40, 40, 'No', 'No', 'No'),
(41, 41, 'No', 'No', 'No'),
(42, 42, 'No', 'No', 'No'),
(43, 43, 'No', 'No', 'No'),
(44, 44, 'No', 'No', 'No'),
(45, 45, 'No', 'No', 'No'),
(46, 46, 'No', 'No', 'No'),
(47, 47, 'No', 'No', 'No'),
(48, 48, 'Yes', 'No', 'No'),
(49, 49, 'Yes', 'No', 'No'),
(50, 50, 'No', 'No', 'No'),
(51, 51, 'Yes', 'No', 'No'),
(52, 52, 'Yes', 'No', 'No'),
(53, 53, 'No', 'No', 'No'),
(54, 54, 'No', 'No', 'No'),
(55, 55, 'No', 'No', 'No'),
(56, 56, 'No', 'No', 'No'),
(57, 57, 'No', 'No', 'No'),
(58, 58, 'No', 'No', 'No'),
(59, 59, 'No', 'No', 'No'),
(60, 60, 'No', 'No', 'No'),
(61, 61, 'No', 'No', 'No'),
(62, 62, 'No', 'No', 'No'),
(63, 63, 'No', 'No', 'No'),
(64, 64, 'Yes', 'No', 'No'),
(65, 65, 'No', 'No', 'No'),
(66, 66, 'No', 'No', 'No'),
(67, 67, 'No', 'No', 'No'),
(68, 68, 'No', 'No', 'No'),
(69, 69, 'No', 'No', 'No'),
(70, 70, 'No', 'No', 'No'),
(71, 71, 'No', 'No', 'No'),
(72, 72, 'No', 'No', 'No'),
(73, 73, 'Yes', 'Yes', 'Yes'),
(74, 74, 'Yes', 'Yes', 'Yes'),
(75, 75, 'No', 'No', 'No'),
(76, 76, 'No', 'No', 'No'),
(77, 77, 'No', 'No', 'No'),
(78, 78, 'No', 'No', 'No'),
(79, 79, 'No', 'No', 'Yes'),
(80, 80, 'No', 'No', 'No'),
(81, 81, 'No', 'No', 'No'),
(82, 82, 'No', 'No', 'No'),
(83, 83, 'Yes', 'Yes', 'No'),
(84, 84, 'No', 'No', 'No'),
(85, 85, 'No', 'No', 'No'),
(86, 86, 'Yes', 'No', 'No'),
(87, 87, 'No', 'No', 'No'),
(88, 88, 'No', 'No', 'No'),
(89, 89, 'No', 'No', 'No'),
(90, 90, 'No', 'No', 'Yes'),
(91, 91, 'No', 'No', 'No'),
(92, 92, 'Yes', 'No', 'No'),
(93, 93, 'Yes', 'No', 'No'),
(94, 94, 'No', 'No', 'No'),
(95, 95, 'No', 'No', 'No'),
(96, 96, 'No', 'No', 'No'),
(97, 97, 'No', 'No', 'No'),
(98, 98, 'No', 'No', 'No'),
(99, 99, 'No', 'No', 'No'),
(100, 100, 'No', 'No', 'No'),
(101, 101, 'No', 'No', 'No'),
(102, 102, 'No', 'No', 'No'),
(103, 103, 'Yes', 'No', 'No'),
(104, 104, 'No', 'No', 'No'),
(105, 105, 'No', 'No', 'No'),
(106, 106, 'Yes', 'No', 'No'),
(107, 107, 'Yes', 'No', 'No'),
(108, 108, 'No', 'Yes', 'Yes'),
(109, 109, 'Yes', 'No', 'No'),
(110, 110, 'Yes', 'No', 'No'),
(111, 111, 'Yes', 'No', 'No'),
(112, 112, 'Yes', 'No', 'No'),
(113, 113, 'Yes', 'Yes', 'No'),
(114, 114, 'Yes', 'No', 'No'),
(115, 115, 'No', 'Yes', 'No'),
(116, 116, 'Yes', 'No', 'No'),
(117, 117, 'No', 'No', 'Yes'),
(118, 118, 'No', 'Yes', 'No'),
(119, 119, 'Yes', 'No', 'No'),
(120, 120, 'Yes', 'No', 'No'),
(121, 121, 'Yes', 'No', 'No'),
(122, 122, 'Yes', 'No', 'No'),
(123, 123, 'Yes', 'Yes', 'No'),
(124, 124, 'Yes', 'No', 'No'),
(125, 125, 'Yes', 'Yes', 'No'),
(126, 126, 'Yes', 'No', 'No'),
(127, 127, 'Yes', 'No', 'No'),
(128, 128, 'Yes', 'No', 'No'),
(129, 129, 'Yes', 'No', 'No'),
(130, 130, 'Yes', 'No', 'No'),
(131, 131, 'Yes', 'No', 'No'),
(132, 132, 'Yes', 'No', 'No'),
(133, 133, 'Yes', 'No', 'No'),
(134, 134, 'Yes', 'No', 'No'),
(135, 135, 'Yes', 'No', 'No'),
(136, 136, 'Yes', 'No', 'No'),
(137, 137, 'Yes', 'No', 'No');

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
  `mcv_1` date DEFAULT NULL,
  `mcv_2` date DEFAULT NULL,
  `mcv_remarks` varchar(255) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `checkup_date` date DEFAULT current_timestamp(),
  `doctor_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `steps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `immunization`
--

INSERT INTO `immunization` (`id`, `bgc_date`, `bgc_remarks`, `hepa_date`, `hepa_remarks`, `pentavalent_date1`, `pentavalent_date2`, `pentavalent_date3`, `pentavalent_remarks`, `oral_date1`, `oral_date2`, `oral_date3`, `oral_remarks`, `ipv_date1`, `ipv_date2`, `ipv_remarks`, `pcv_date1`, `pcv_date2`, `pcv_date3`, `pcv_remarks`, `mmr_date1`, `mmr_date2`, `mmr_remarks`, `mcv_1`, `mcv_2`, `mcv_remarks`, `patient_id`, `checkup_date`, `doctor_id`, `nurse_id`, `description`, `is_deleted`, `status`, `steps`) VALUES
(1, '2024-05-29', 'Done ', '2024-04-17', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-01-17', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '', '2024-02-21', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 66, '2024-05-29', NULL, 1, 'Pentavalent Vaccine Dose 1', 0, 'Progress', 'Already Nurse'),
(2, '0000-00-00', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '2024-04-03', '2024-05-08', '0000-00-00', '2/3', '2024-02-14', '2024-03-13', 'Done ', '0000-00-00', '0000-00-00', '', 135, '2024-05-29', NULL, 1, 'BCG Vaccine', 0, 'Progress', 'Immunization'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 141, '2024-05-29', NULL, 2, 'BCG Vaccine', 0, 'Pending', 'Immunization'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 141, '0000-00-00', NULL, 0, '', 1, '', ''),
(5, '2024-05-29', 'Done', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 147, '2024-05-29', NULL, 1, 'Pentavalent Vaccine Dose 1', 0, 'Progress', 'Already Nurse'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 150, '2024-05-29', NULL, 2, 'BCG Vaccine', 0, 'Pending', 'Immunization'),
(7, '0000-00-00', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '2024-01-03', '2024-03-06', 'Done ', 151, '2024-05-29', NULL, 1, 'BCG Vaccine', 0, 'Progress', 'Immunization'),
(8, '0000-00-00', '', '2024-04-10', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-03-13', '0000-00-00', '1/2', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 152, '2024-05-29', NULL, 1, '', 0, 'Progress', 'Immunization'),
(9, '2024-03-27', 'Done ', '2024-04-24', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-01-24', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 153, '2024-05-29', NULL, 1, 'Pentavalent Vaccine', 0, 'Progress', 'Immunization'),
(10, '2024-03-27', 'Done ', '0000-00-00', '', '2024-01-24', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 154, '2024-05-29', NULL, 1, 'Oral Polio Vaccine', 0, 'Progress', 'Immunization'),
(11, '2024-04-24', 'Done ', '2024-03-27', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '2024-01-24', '0000-00-00', '1/2', 154, '2024-05-29', NULL, 1, 'Inactived Polio Vaccine', 0, 'Progress', 'Immunization'),
(12, '0000-00-00', '', '2024-04-24', 'Done ', '2024-02-28', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 155, '0000-00-00', NULL, 1, 'Inactived Polio Vaccine', 0, 'Progress', 'Immunization'),
(13, '2024-03-20', 'Done ', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-01-24', '0000-00-00', '1/2', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 156, '2024-05-29', NULL, 1, 'Pneumococcal Conjugate Vaccine', 0, 'Progress', 'Immunization'),
(14, '2024-04-10', 'Done ', '0000-00-00', '', '2024-03-13', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-02-14', '0000-00-00', '1/2', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 157, '2024-05-29', NULL, 1, 'Measles Mumps Rubella Vaccine', 0, 'Progress', 'Immunization'),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 158, '2024-05-29', NULL, 2, 'Measles Mumps Rubella Vaccine', 0, 'Pending', 'Immunization'),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 159, '2024-05-29', NULL, 2, 'Measles Containing Vaccine', 0, 'Pending', 'Immunization'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2024-05-29', NULL, 2, 'Measles Mumps Rubella Vaccine', 0, 'Pending', 'Immunization'),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 161, '2024-05-29', NULL, 2, 'Oral Polio Vaccine', 0, 'Pending', 'Immunization'),
(19, '0000-00-00', '', '2024-04-17', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-03-20', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 162, '2024-05-29', NULL, 1, 'BCG Vaccine', 0, 'Progress', 'Immunization'),
(20, '2024-04-03', 'Done ', '0000-00-00', '', '2024-03-20', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 163, '2024-05-29', NULL, 1, 'BCG Vaccine', 0, 'Progress', 'Immunization'),
(21, '2024-04-03', 'Done ', '2024-01-17', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 164, '2024-05-29', NULL, 1, 'Pentavalent Vaccine', 0, 'Progress', 'Immunization'),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 165, '2024-05-29', NULL, 2, 'Hepatitis B Vaccine', 0, 'Pending', 'Immunization'),
(23, '0000-00-00', '', '2024-01-10', 'Done ', '2024-03-06', '2024-04-10', '0000-00-00', '2/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 166, '2024-05-29', NULL, 1, 'Oral Polio Vaccine', 0, 'Progress', 'Immunization'),
(24, '2024-04-10', 'Done', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-03-06', '0000-00-00', '1/2', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-05-28', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 167, '2024-05-29', NULL, 1, 'Inactived Polio Vaccine', 0, 'Progress', 'Immunization'),
(25, '0000-00-00', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '2024-05-30', '', '0000-00-00', '0000-00-00', '2024-05-31', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-05-30', '0000-00-00', '', NULL, NULL, NULL, 168, '2024-05-29', NULL, 2, 'Inactived Polio Vaccine', 0, 'Pending', 'Immunization'),
(26, '0000-00-00', '', '2024-04-17', 'Done', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-01-10', '2024-02-07', '0000-00-00', '2/3', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '2024-05-28', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 169, '2024-06-05', NULL, 1, 'Pneumococcal Conjugate Vaccine', 0, 'Progress', 'Immunization'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 170, '2024-06-05', NULL, 2, 'Inactived Polio Vaccine', 0, 'Pending', 'Immunization'),
(28, '2024-03-06', 'Done ', '0000-00-00', '', '2024-01-10', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 171, '2024-06-05', NULL, 1, 'BCG Vaccine', 0, 'Progress', 'Immunization'),
(29, '0000-00-00', '', '0000-00-00', '', '2024-05-28', '0000-00-00', '0000-00-00', '1/3', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', NULL, NULL, NULL, 172, '2024-06-05', NULL, 2, 'Oral Polio Vaccine', 0, 'Pending', 'Immunization'),
(30, '0000-00-00', '', '2024-03-13', 'Done ', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 174, '2024-06-05', NULL, 1, 'Pneumococcal Conjugate Vaccine', 0, 'Progress', 'Immunization'),
(31, '0000-00-00', '', '2024-05-28', 'Done', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '2024-05-31', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', NULL, NULL, NULL, 175, '2024-06-05', NULL, 2, 'Pneumococcal Conjugate Vaccine', 0, 'Pending', 'Immunization'),
(32, '2024-04-03', 'Done ', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 176, '2024-06-05', NULL, 1, 'Pneumococcal Conjugate Vaccine', 0, 'Progress', 'Already Nurse'),
(33, '2024-05-28', 'Done', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', NULL, NULL, NULL, 178, '2024-06-05', NULL, 2, 'Measles Mumps Rubella Vaccine', 0, 'Pending', 'Immunization'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 236, '2024-05-29', NULL, 2, 'Hepatitis B Vaccine', 0, 'Pending', 'Immunization'),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 237, '2024-05-29', NULL, 1, 'Hepatitis B Vaccine', 0, 'Pending', 'Immunization'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 238, '2024-05-29', NULL, 2, 'BCG Vaccine', 0, 'Pending', 'Immunization'),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 177, '2024-05-29', NULL, 2, 'Hepatitis B Vaccine', 0, 'Pending', 'Immunization'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 231, '2024-05-29', NULL, 2, 'BCG Vaccine', 0, 'Pending', 'Immunization'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 173, '2024-05-29', NULL, 2, 'Measles Containing Vaccine', 0, 'Pending', 'Immunization'),
(40, '0000-00-00', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', '', 233, '2024-05-29', NULL, 1, 'Hepatitis B Vaccine', 0, 'Pending', 'Already Nurse'),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 240, '2024-06-05', NULL, 1, '', 0, 'Pending', 'Immunization'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 241, '2024-06-05', NULL, 1, 'Hepatitis B Vaccine', 0, 'Pending', 'Immunization'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 247, '2024-06-12', NULL, 1, 'BCG Vaccine', 0, 'Pending', 'Immunization'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 248, '2024-06-05', NULL, 1, 'BCG Vaccine', 0, 'Pending', 'Immunization');

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
(1, 'logout', '2024-05-26', '08:21:25', 8),
(2, 'login', '2024-05-26', '08:21:42', 3),
(3, 'logout', '2024-05-26', '08:23:08', 3),
(4, 'login', '2024-05-26', '08:23:43', 3),
(5, 'login', '2024-05-25', '01:46:59', 3),
(6, 'logout', '2024-05-25', '01:53:22', 3),
(7, 'login', '2024-05-25', '02:04:00', 3),
(8, 'login', '2024-05-25', '02:05:17', 41),
(9, 'logout', '2024-05-25', '02:06:14', 41),
(10, 'logout', '2024-05-25', '02:09:01', 3),
(11, 'login', '2024-05-25', '02:10:48', 3),
(12, 'login', '2024-05-25', '02:13:20', 45),
(13, 'logout', '2024-05-25', '02:13:30', 3),
(14, 'login', '2024-05-25', '02:14:21', 46),
(15, 'logout', '2024-05-25', '02:32:20', 45),
(16, 'login', '2024-05-25', '02:33:11', 45),
(17, 'logout', '2024-05-25', '03:35:43', 46),
(18, 'login', '2024-05-25', '03:36:06', 46),
(19, 'logout', '2024-05-25', '03:42:15', 46),
(20, 'login', '2024-05-25', '03:44:18', 46),
(21, 'logout', '2024-05-25', '04:05:50', 45),
(22, 'logout', '2024-05-25', '04:07:13', 46),
(23, 'login', '2024-05-25', '04:08:02', 46),
(24, 'login', '2024-05-25', '04:16:14', 45),
(25, 'logout', '2024-05-25', '04:39:04', 45),
(26, 'login', '2024-05-25', '04:39:49', 45),
(27, 'logout', '2024-05-25', '05:04:06', 46),
(28, 'login', '2024-05-25', '05:04:28', 46),
(29, 'logout', '2024-05-25', '05:16:39', 45),
(30, 'login', '2024-05-25', '05:18:14', 45),
(31, 'login', '2024-05-25', '05:31:31', 3),
(32, 'logout', '2024-05-25', '05:43:30', 3),
(33, 'logout', '2024-05-25', '05:44:24', 46),
(34, 'login', '2024-05-25', '05:46:12', 46),
(35, 'logout', '2024-05-25', '05:49:02', 46),
(36, 'login', '2024-05-25', '05:52:11', 46),
(37, 'logout', '2024-05-25', '06:02:20', 46),
(38, 'login', '2024-05-25', '06:05:03', 41),
(39, 'logout', '2024-05-25', '06:06:51', 41),
(40, 'login', '2024-05-25', '06:08:14', 3),
(41, 'logout', '2024-05-25', '06:10:54', 3),
(42, 'login', '2024-05-25', '06:13:22', 3),
(43, 'logout', '2024-05-25', '06:15:17', 3),
(44, 'login', '2024-05-25', '06:15:22', 43),
(45, 'logout', '2024-05-25', '06:49:55', 43),
(46, 'login', '2024-05-25', '06:50:13', 46),
(47, 'logout', '2024-05-25', '06:52:22', 46),
(48, 'login', '2024-05-25', '06:52:48', 43),
(49, 'logout', '2024-05-25', '07:02:50', 43),
(50, 'login', '2024-05-25', '07:04:04', 41),
(51, 'logout', '2024-05-25', '07:10:18', 41),
(52, 'login', '2024-05-25', '07:10:47', 46),
(53, 'logout', '2024-05-25', '07:22:18', 46),
(54, 'login', '2024-05-25', '07:22:59', 43),
(55, 'logout', '2024-05-25', '07:30:18', 43),
(56, 'login', '2024-05-25', '08:12:32', 43),
(57, 'logout', '2024-05-25', '08:12:37', 43),
(58, 'login', '2024-05-25', '08:13:43', 46),
(59, 'logout', '2024-05-25', '08:16:28', 45),
(60, 'login', '2024-05-25', '08:17:43', 41),
(61, 'logout', '2024-05-25', '08:17:49', 41),
(62, 'login', '2024-05-25', '08:37:05', 3),
(63, 'logout', '2024-05-25', '08:37:43', 3),
(64, 'login', '2024-05-25', '08:38:02', 42),
(65, 'logout', '2024-05-25', '08:38:06', 42),
(66, 'login', '2024-05-25', '08:38:45', 42),
(67, 'logout', '2024-05-25', '08:49:35', 42),
(68, 'logout', '2024-05-25', '08:51:02', 46),
(69, 'login', '2024-05-25', '08:52:23', 43),
(70, 'logout', '2024-05-25', '08:58:01', 43),
(71, 'login', '2024-05-25', '08:58:28', 46),
(72, 'login', '2024-05-25', '08:59:46', 41),
(73, 'logout', '2024-05-25', '08:59:54', 41),
(74, 'login', '2024-05-25', '09:03:15', 3),
(75, 'logout', '2024-05-25', '09:10:54', 3),
(76, 'logout', '2024-05-25', '09:11:40', 46),
(77, 'login', '2024-05-25', '09:12:12', 43),
(78, 'logout', '2024-05-25', '09:25:11', 43),
(79, 'login', '2024-05-25', '09:25:59', 46),
(80, 'login', '2024-05-25', '09:27:21', 41),
(81, 'logout', '2024-05-25', '09:39:18', 46),
(82, 'login', '2024-05-25', '09:42:39', 3),
(83, 'login', '2024-05-25', '09:44:12', 44),
(84, 'logout', '2024-05-25', '09:48:20', 44),
(85, 'login', '2024-05-25', '09:48:52', 46),
(86, 'login', '2024-05-25', '09:48:58', 41),
(87, 'logout', '2024-05-25', '09:52:24', 3),
(88, 'logout', '2024-05-25', '09:52:31', 41),
(89, 'login', '2024-05-25', '09:52:50', 41),
(90, 'logout', '2024-05-25', '09:53:40', 41),
(91, 'login', '2024-05-25', '09:54:02', 43),
(92, 'logout', '2024-05-25', '09:54:09', 43),
(93, 'login', '2024-05-25', '09:54:27', 42),
(94, 'login', '2024-05-25', '09:55:08', 41),
(95, 'logout', '2024-05-25', '09:55:47', 42),
(96, 'login', '2024-05-25', '09:56:02', 41),
(97, 'logout', '2024-05-25', '09:57:44', 41),
(98, 'login', '2024-05-25', '09:58:06', 41),
(99, 'logout', '2024-05-25', '09:59:21', 41),
(100, 'login', '2024-05-25', '10:09:13', 41),
(101, 'logout', '2024-05-25', '10:10:19', 41),
(102, 'login', '2024-05-25', '10:15:06', 41),
(103, 'logout', '2024-05-25', '10:19:28', 41),
(104, 'login', '2024-05-25', '10:21:50', 41),
(105, 'logout', '2024-05-25', '10:22:30', 46),
(106, 'login', '2024-05-25', '10:23:18', 43),
(107, 'logout', '2024-05-25', '10:25:40', 43),
(108, 'login', '2024-05-25', '10:25:59', 46),
(109, 'logout', '2024-05-25', '10:27:44', 41),
(110, 'login', '2024-05-25', '10:30:21', 41),
(111, 'logout', '2024-05-25', '10:32:31', 41),
(112, 'logout', '2024-05-25', '10:32:45', 41),
(113, 'logout', '2024-05-25', '10:37:49', 46),
(114, 'login', '2024-05-26', '11:49:23', 41),
(115, 'logout', '2024-05-26', '11:56:06', 41),
(116, 'login', '2024-05-26', '01:04:48', 41),
(117, 'login', '2024-05-26', '01:06:32', 41),
(118, 'login', '2024-05-26', '01:13:34', 43),
(119, 'login', '2024-05-26', '01:16:31', 46),
(120, 'logout', '2024-05-26', '01:19:44', 43),
(121, 'login', '2024-05-26', '01:25:48', 41),
(122, 'logout', '2024-05-26', '01:26:44', 41),
(123, 'login', '2024-05-26', '01:27:10', 41),
(124, 'logout', '2024-05-26', '01:32:56', 41),
(125, 'logout', '2024-05-26', '01:36:53', 41),
(126, 'login', '2024-05-26', '01:40:29', 41),
(127, 'login', '2024-05-26', '01:41:42', 45),
(128, 'login', '2024-05-26', '02:36:59', 41),
(129, 'logout', '2024-05-26', '02:44:56', 45),
(130, 'login', '2024-05-26', '02:45:34', 45),
(131, 'login', '2024-05-26', '02:58:25', 41),
(132, 'logout', '2024-05-26', '03:07:28', 46),
(133, 'login', '2024-05-26', '03:27:35', 46),
(134, 'login', '2024-05-27', '11:31:41', 41),
(135, 'logout', '2024-05-27', '11:50:26', 41),
(136, 'login', '2024-05-27', '11:51:58', 3),
(137, 'logout', '2024-05-27', '11:54:51', 3),
(138, 'login', '2024-05-27', '11:57:46', 3),
(139, 'logout', '2024-05-27', '11:59:14', 3),
(140, 'login', '2024-05-27', '12:00:10', 3),
(141, 'logout', '2024-05-27', '12:01:24', 3),
(142, 'login', '2024-05-27', '12:01:49', 41),
(143, 'logout', '2024-05-27', '12:09:16', 41),
(144, 'login', '2024-05-27', '12:09:52', 48),
(145, 'logout', '2024-05-27', '12:10:30', 48),
(146, 'login', '2024-05-27', '12:13:52', 41),
(147, 'logout', '2024-05-27', '12:31:05', 41),
(148, 'login', '2024-05-27', '01:11:16', 3),
(149, 'logout', '2024-05-27', '01:17:05', 3),
(150, 'login', '2024-05-27', '01:17:24', 41),
(151, 'logout', '2024-05-27', '01:20:57', 41),
(152, 'login', '2024-05-27', '01:25:42', 41),
(153, 'logout', '2024-05-27', '01:28:50', 41),
(154, 'login', '2024-05-27', '01:29:56', 3),
(155, 'logout', '2024-05-27', '01:30:13', 3),
(156, 'login', '2024-05-27', '01:30:37', 42),
(157, 'logout', '2024-05-27', '01:31:23', 42),
(158, 'login', '2024-05-27', '02:08:31', 46),
(159, 'login', '2024-05-27', '02:09:44', 41),
(160, 'logout', '2024-05-27', '02:13:41', 41),
(161, 'login', '2024-05-27', '02:14:15', 42),
(162, 'logout', '2024-05-27', '02:14:47', 46),
(163, 'login', '2024-05-27', '02:16:16', 46),
(164, 'logout', '2024-05-27', '02:19:20', 42),
(165, 'login', '2024-05-27', '02:19:52', 3),
(166, 'logout', '2024-05-27', '02:20:18', 3),
(167, 'login', '2024-05-27', '02:20:52', 43),
(168, 'logout', '2024-05-27', '02:21:31', 43),
(169, 'login', '2024-05-27', '02:22:01', 44),
(170, 'logout', '2024-05-27', '02:23:02', 44),
(171, 'logout', '2024-05-27', '02:25:12', 46),
(172, 'login', '2024-05-27', '02:26:31', 46),
(173, 'logout', '2024-05-27', '02:32:42', 46),
(174, 'login', '2024-05-27', '02:32:50', 41),
(175, 'login', '2024-05-27', '02:33:21', 46),
(176, 'logout', '2024-05-27', '02:38:56', 41),
(177, 'logout', '2024-05-27', '03:30:00', 46),
(178, 'login', '2024-05-27', '03:49:31', 41),
(179, 'login', '2024-05-27', '04:06:24', 42),
(180, 'login', '2024-05-27', '04:10:41', 46),
(181, 'logout', '2024-05-27', '04:16:44', 42),
(182, 'login', '2024-05-27', '04:32:11', 42),
(183, 'logout', '2024-05-27', '04:32:40', 46),
(184, 'login', '2024-05-27', '04:33:08', 43),
(185, 'logout', '2024-05-27', '04:35:00', 42),
(186, 'login', '2024-05-27', '04:35:21', 43),
(187, 'logout', '2024-05-27', '04:37:47', 41),
(188, 'login', '2024-05-27', '04:38:43', 41),
(189, 'logout', '2024-05-27', '04:42:27', 43),
(190, 'login', '2024-05-27', '04:42:56', 44),
(191, 'logout', '2024-05-27', '04:43:20', 44),
(192, 'login', '2024-05-27', '04:43:45', 41),
(193, 'logout', '2024-05-27', '04:48:21', 41),
(194, 'login', '2024-05-27', '04:50:08', 44),
(195, 'logout', '2024-05-27', '04:53:16', 44),
(196, 'login', '2024-05-27', '08:29:33', 45),
(197, 'logout', '2024-05-27', '08:37:08', 45),
(198, 'login', '2024-05-27', '08:37:47', 45),
(199, 'login', '2024-05-27', '08:37:48', 41),
(200, 'logout', '2024-05-27', '08:57:23', 45),
(201, 'login', '2024-05-27', '09:02:53', 45),
(202, 'logout', '2024-05-27', '09:15:27', 41),
(203, 'login', '2024-05-27', '09:25:11', 3),
(204, 'logout', '2024-05-27', '09:42:35', 3),
(205, 'login', '2024-05-27', '10:02:11', 43),
(206, 'logout', '2024-05-27', '10:10:45', 43),
(207, 'login', '2024-05-27', '10:18:52', 44),
(208, 'logout', '2024-05-27', '10:24:59', 44),
(209, 'login', '2024-05-27', '10:36:26', 41),
(210, 'logout', '2024-05-27', '10:56:37', 41),
(211, 'login', '2024-05-27', '11:02:13', 42),
(212, 'logout', '2024-05-27', '11:07:34', 42),
(213, 'login', '2024-05-27', '11:07:54', 41),
(214, 'logout', '2024-05-27', '11:16:19', 41),
(215, 'login', '2024-05-27', '11:30:18', 41),
(216, 'logout', '2024-05-27', '11:34:47', 41),
(217, 'login', '2024-05-28', '05:55:00', 41),
(218, 'logout', '2024-05-28', '06:16:25', 41),
(219, 'login', '2024-05-28', '10:48:25', 41),
(220, 'logout', '2024-05-28', '10:54:39', 41),
(221, 'login', '2024-05-28', '10:56:16', 41),
(222, 'logout', '2024-05-28', '11:03:12', 41),
(223, 'login', '2024-05-28', '11:04:13', 41),
(224, 'login', '2024-05-28', '11:08:10', 41),
(225, 'logout', '2024-05-28', '11:12:34', 41),
(226, 'login', '2024-05-28', '11:15:47', 45),
(227, 'login', '2024-05-28', '11:16:48', 3),
(228, 'logout', '2024-05-28', '11:17:21', 3),
(229, 'login', '2024-05-28', '11:17:55', 41),
(230, 'login', '2024-05-28', '11:24:57', 3),
(231, 'logout', '2024-05-28', '11:35:18', 45),
(232, 'login', '2024-05-28', '11:37:42', 46),
(233, 'logout', '2024-05-28', '11:41:41', 41),
(234, 'login', '2024-05-28', '11:42:47', 3),
(235, 'login', '2024-05-28', '11:44:24', 41),
(236, 'logout', '2024-05-28', '11:50:03', 3),
(237, 'logout', '2024-05-28', '12:02:03', 3),
(238, 'logout', '2024-05-28', '01:43:08', 41),
(239, 'login', '2024-05-28', '01:46:37', 45),
(240, 'login', '2024-05-28', '02:03:43', 41),
(241, 'logout', '2024-05-28', '02:07:08', 45),
(242, 'login', '2024-05-28', '02:09:47', 45),
(243, 'logout', '2024-05-28', '02:28:17', 45),
(244, 'login', '2024-05-28', '02:29:08', 45),
(245, 'logout', '2024-05-28', '02:37:00', 45),
(246, 'login', '2024-05-28', '02:37:43', 43),
(247, 'logout', '2024-05-28', '02:38:36', 41),
(248, 'login', '2024-05-28', '02:39:01', 3),
(249, 'logout', '2024-05-28', '02:49:42', 3),
(250, 'login', '2024-05-28', '02:51:06', 3),
(251, 'logout', '2024-05-28', '02:53:28', 3),
(252, 'login', '2024-05-28', '02:54:12', 41),
(253, 'logout', '2024-05-28', '03:23:12', 41),
(254, 'login', '2024-05-28', '03:23:55', 3),
(255, 'login', '2024-05-28', '03:29:59', 3),
(256, 'logout', '2024-05-28', '03:30:50', 3),
(257, 'login', '2024-05-28', '03:31:21', 43),
(258, 'logout', '2024-05-28', '03:37:34', 43),
(259, 'logout', '2024-05-28', '03:57:34', 3),
(260, 'logout', '2024-05-28', '03:58:21', 41),
(261, 'login', '2024-05-28', '03:58:50', 41),
(262, 'login', '2024-05-28', '09:18:32', 3),
(263, 'login', '2024-05-28', '09:19:34', 41),
(264, 'login', '2024-05-28', '09:19:54', 45),
(265, 'login', '2024-05-28', '09:21:23', 41),
(266, 'login', '2024-05-28', '09:26:58', 41),
(267, 'logout', '2024-05-28', '09:35:25', 3),
(268, 'logout', '2024-05-28', '09:35:36', 41),
(269, 'login', '2024-05-28', '09:36:01', 41),
(270, 'login', '2024-05-28', '09:44:53', 3),
(271, 'logout', '2024-05-28', '09:51:26', 3),
(272, 'login', '2024-05-28', '09:55:55', 3),
(273, 'logout', '2024-05-28', '09:56:16', 3),
(274, 'login', '2024-05-28', '09:56:41', 41),
(275, 'logout', '2024-05-28', '09:58:48', 41),
(276, 'login', '2024-05-28', '09:59:14', 3),
(277, 'logout', '2024-05-28', '10:05:32', 3),
(278, 'login', '2024-05-28', '10:07:21', 3),
(279, 'login', '2024-05-28', '10:12:25', 41),
(280, 'logout', '2024-05-28', '10:14:03', 3),
(281, 'login', '2024-05-28', '10:33:37', 41),
(282, 'login', '2024-05-28', '10:39:58', 41),
(283, 'logout', '2024-05-28', '10:58:44', 45),
(284, 'login', '2024-05-28', '10:59:34', 45),
(285, 'logout', '2024-05-28', '11:35:38', 45),
(286, 'login', '2024-05-28', '11:48:47', 45),
(287, 'login', '2024-05-28', '11:51:05', 46),
(288, 'logout', '2024-05-29', '12:34:08', 46),
(289, 'login', '2024-05-29', '12:40:31', 46),
(290, 'login', '2024-05-29', '12:44:14', 42),
(291, 'logout', '2024-05-29', '12:45:58', 42),
(292, 'login', '2024-05-29', '12:46:15', 41),
(293, 'logout', '2024-05-29', '12:51:27', 45),
(294, 'login', '2024-05-29', '12:52:21', 45),
(295, 'login', '2024-05-29', '12:56:18', 46),
(296, 'logout', '2024-05-29', '01:11:29', 45),
(297, 'logout', '2024-05-29', '01:15:15', 41),
(298, 'logout', '2024-05-29', '01:15:21', 41),
(299, 'login', '2024-05-29', '01:20:56', 42),
(300, 'logout', '2024-05-29', '01:22:58', 42),
(301, 'login', '2024-05-29', '01:23:14', 41),
(302, 'logout', '2024-05-29', '01:38:10', 41),
(303, 'login', '2024-05-29', '01:38:29', 42),
(304, 'logout', '2024-05-29', '01:51:47', 42),
(305, 'login', '2024-05-29', '01:52:14', 41),
(306, 'logout', '2024-05-29', '01:55:16', 41),
(307, 'login', '2024-05-29', '01:55:36', 42),
(308, 'logout', '2024-05-29', '01:57:08', 42),
(309, 'login', '2024-05-29', '01:59:03', 42),
(310, 'logout', '2024-05-29', '01:59:06', 42),
(311, 'login', '2024-05-29', '01:59:28', 42),
(312, 'logout', '2024-05-29', '01:59:31', 42),
(313, 'login', '2024-05-29', '02:00:19', 41),
(314, 'logout', '2024-05-29', '02:04:52', 41),
(315, 'login', '2024-05-29', '02:05:16', 42),
(316, 'login', '2024-05-29', '02:06:20', 41),
(317, 'logout', '2024-05-29', '02:21:22', 42),
(318, 'login', '2024-05-29', '02:21:56', 41),
(319, 'logout', '2024-05-29', '02:41:10', 41),
(320, 'logout', '2024-05-29', '02:50:31', 41),
(321, 'login', '2024-05-29', '05:00:05', 41),
(322, 'logout', '2024-05-29', '05:06:43', 41),
(323, 'login', '2024-05-29', '05:07:08', 3),
(324, 'logout', '2024-05-29', '05:31:31', 46),
(325, 'login', '2024-05-29', '05:32:44', 46),
(326, 'login', '2024-05-29', '05:36:49', 41),
(327, 'logout', '2024-05-29', '05:37:33', 41),
(328, 'login', '2024-05-29', '05:37:54', 3),
(329, 'logout', '2024-05-29', '05:41:53', 46),
(330, 'login', '2024-05-29', '05:43:28', 3),
(331, 'logout', '2024-05-29', '05:44:29', 3),
(332, 'login', '2024-05-29', '05:44:47', 41),
(333, 'logout', '2024-05-29', '05:46:09', 3),
(334, 'login', '2024-05-29', '05:49:12', 3),
(335, 'logout', '2024-05-29', '06:06:02', 3),
(336, 'login', '2024-05-29', '06:06:32', 3),
(337, 'logout', '2024-05-29', '06:18:44', 3),
(338, 'login', '2024-05-29', '06:21:09', 42),
(339, 'logout', '2024-05-29', '06:26:29', 42),
(340, 'login', '2024-05-29', '06:26:55', 43),
(341, 'logout', '2024-05-29', '06:35:22', 43),
(342, 'login', '2024-05-29', '06:37:56', 44),
(343, 'logout', '2024-05-29', '06:46:03', 44),
(344, 'login', '2024-05-29', '06:47:05', 41),
(345, 'logout', '2024-05-29', '06:50:35', 3),
(346, 'login', '2024-05-29', '06:51:42', 41),
(347, 'logout', '2024-05-29', '07:01:56', 41),
(348, 'logout', '2024-05-29', '07:22:07', 41),
(349, 'login', '2024-05-29', '07:22:38', 3),
(350, 'logout', '2024-05-29', '07:34:56', 3),
(351, 'login', '2024-05-29', '07:36:47', 42),
(352, 'logout', '2024-05-29', '07:36:55', 42),
(353, 'login', '2024-05-29', '07:37:30', 3),
(354, 'logout', '2024-05-29', '07:40:51', 3),
(355, 'login', '2024-05-29', '07:41:30', 3),
(356, 'logout', '2024-05-29', '07:41:51', 3),
(357, 'login', '2024-05-29', '07:42:10', 49),
(358, 'logout', '2024-05-29', '07:42:14', 49),
(359, 'login', '2024-05-29', '07:43:18', 45),
(360, 'logout', '2024-05-29', '07:43:23', 45),
(361, 'login', '2024-05-29', '07:44:43', 3),
(362, 'logout', '2024-05-29', '08:09:49', 3),
(363, 'login', '2024-05-29', '08:29:57', 41),
(364, 'login', '2024-05-29', '08:39:27', 41),
(365, 'login', '2024-05-29', '08:48:16', 41),
(366, 'logout', '2024-05-29', '08:50:26', 41),
(367, 'logout', '2024-05-29', '09:17:01', 41),
(368, 'login', '2024-05-29', '09:17:26', 3),
(369, 'logout', '2024-05-29', '09:38:11', 3),
(370, 'login', '2024-05-29', '09:41:37', 3),
(371, 'logout', '2024-05-29', '09:56:53', 3),
(372, 'login', '2024-05-29', '10:02:08', 43),
(373, 'logout', '2024-05-29', '10:03:55', 43),
(374, 'login', '2024-05-29', '10:04:32', 3),
(375, 'logout', '2024-05-29', '10:09:51', 3),
(376, 'login', '2024-05-29', '10:10:18', 43),
(377, 'logout', '2024-05-29', '10:16:31', 43),
(378, 'login', '2024-05-29', '10:24:56', 41),
(379, 'logout', '2024-05-29', '10:37:36', 41),
(380, 'login', '2024-05-29', '10:41:59', 41),
(381, 'logout', '2024-05-29', '10:57:20', 41),
(382, 'login', '2024-05-29', '02:49:20', 41),
(383, 'logout', '2024-05-29', '03:15:54', 41),
(384, 'login', '2024-05-29', '03:25:23', 41),
(385, 'logout', '2024-05-29', '03:35:51', 41),
(386, 'login', '2024-05-29', '03:41:10', 41),
(387, 'login', '2024-05-29', '03:41:13', 46),
(388, 'login', '2024-05-29', '03:41:23', 45),
(389, 'logout', '2024-05-29', '03:41:50', 45),
(390, 'logout', '2024-05-29', '03:48:24', 41),
(391, 'login', '2024-05-29', '03:57:41', 41),
(392, 'login', '2024-05-29', '04:00:06', 45),
(393, 'login', '2024-05-30', '02:50:01', 41),
(394, 'logout', '2024-05-30', '03:08:43', 41),
(395, 'login', '2024-05-30', '03:39:16', 41),
(396, 'logout', '2024-05-30', '03:40:48', 41),
(397, 'login', '2024-05-30', '03:42:40', 41),
(398, 'logout', '2024-05-30', '03:59:21', 41),
(399, 'login', '2024-05-30', '04:08:17', 41),
(400, 'logout', '2024-05-30', '04:44:31', 41),
(401, 'login', '2024-05-30', '08:46:38', 41),
(402, 'login', '2024-05-30', '08:49:13', 46),
(403, 'logout', '2024-05-30', '08:50:02', 41),
(404, 'login', '2024-05-30', '08:51:05', 44),
(405, 'login', '2024-05-30', '09:02:41', 45),
(406, 'logout', '2024-05-30', '09:14:58', 46),
(407, 'login', '2024-05-30', '09:15:20', 46),
(408, 'login', '2024-05-30', '09:19:35', 41),
(409, 'logout', '2024-05-30', '09:20:08', 41),
(410, 'logout', '2024-05-30', '09:21:49', 46),
(411, 'logout', '2024-05-30', '09:23:19', 45),
(412, 'login', '2024-05-30', '09:23:47', 3),
(413, 'login', '2024-05-30', '09:23:52', 45),
(414, 'logout', '2024-05-30', '09:24:50', 3),
(415, 'login', '2024-05-30', '09:25:48', 3),
(416, 'logout', '2024-05-30', '09:31:37', 45),
(417, 'logout', '2024-05-30', '09:32:14', 44),
(418, 'login', '2024-05-30', '09:32:43', 43),
(419, 'logout', '2024-05-30', '09:33:13', 43),
(420, 'login', '2024-05-30', '09:33:29', 41),
(421, 'login', '2024-05-30', '09:40:00', 43),
(422, 'login', '2024-05-30', '09:42:29', 3),
(423, 'logout', '2024-05-30', '09:43:44', 41),
(424, 'logout', '2024-05-30', '09:43:46', 3),
(425, 'login', '2024-05-30', '09:44:13', 42),
(426, 'logout', '2024-05-30', '09:44:55', 42),
(427, 'login', '2024-05-30', '09:45:26', 3),
(428, 'logout', '2024-05-30', '09:45:55', 3),
(429, 'login', '2024-05-30', '09:46:35', 49),
(430, 'logout', '2024-05-30', '09:46:41', 49),
(431, 'login', '2024-05-30', '09:47:41', 44),
(432, 'logout', '2024-05-30', '09:56:35', 43),
(433, 'login', '2024-05-30', '10:04:49', 43),
(434, 'login', '2024-05-30', '10:06:57', 41),
(435, 'login', '2024-05-30', '10:14:12', 41),
(436, 'login', '2024-05-30', '10:24:20', 41),
(437, 'logout', '2024-05-30', '10:26:04', 41),
(438, 'logout', '2024-05-30', '10:27:38', 41),
(439, 'login', '2024-05-30', '10:31:05', 41),
(440, 'logout', '2024-05-30', '10:31:15', 41),
(441, 'logout', '2024-05-30', '10:31:55', 41),
(442, 'logout', '2024-05-30', '10:34:20', 43),
(443, 'login', '2024-05-30', '10:34:29', 41),
(444, 'login', '2024-05-30', '10:35:02', 45),
(445, 'login', '2024-05-30', '10:35:29', 49),
(446, 'logout', '2024-05-30', '10:35:51', 49),
(447, 'logout', '2024-05-30', '10:36:06', 41),
(448, 'login', '2024-05-30', '10:37:14', 44),
(449, 'login', '2024-05-30', '10:39:57', 41),
(450, 'logout', '2024-05-30', '10:43:23', 45),
(451, 'login', '2024-05-30', '10:48:07', 45),
(452, 'login', '2024-05-30', '10:52:15', 41),
(453, 'logout', '2024-05-30', '11:00:47', 41),
(454, 'login', '2024-05-30', '11:08:07', 46),
(455, 'logout', '2024-05-30', '11:09:30', 3),
(456, 'login', '2024-05-30', '11:10:27', 42),
(457, 'login', '2024-05-30', '11:14:32', 41),
(458, 'logout', '2024-05-30', '11:14:37', 45),
(459, 'login', '2024-05-30', '11:16:16', 45),
(460, 'login', '2024-05-30', '11:20:50', 41),
(461, 'login', '2024-05-30', '11:21:03', 41),
(462, 'login', '2024-05-30', '11:28:46', 41),
(463, 'login', '2024-05-30', '11:35:14', 41),
(464, 'logout', '2024-05-30', '11:54:02', 41),
(465, 'logout', '2024-05-30', '01:12:56', 41);

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
(1, 'AthenaMae', 'Fajardo', '2000-08-06', 'CDo', 44, 0, 0),
(2, 'Love', 'DelaCruz', '2002-05-14', 'CDO', 49, 0, 0);

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
(1, 'Jeelyn', 'Reyes', '2001-09-12', 'CDO', 43, 0, 0),
(2, 'Asia', 'Catacutan', '1998-07-25', 'Bulua Cagayande Oro City', 48, 0, 0);

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
  `serial_no` varchar(255) NOT NULL,
  `step` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `birthdate`, `address`, `is_active`, `middle_name`, `suffix`, `gender`, `age`, `contact_no`, `civil_status`, `religion`, `is_deleted`, `serial_no`, `step`) VALUES
(1, 'Paula', 'Santos', '1999-02-01', 'Zone 10', 0, '', '', 'Female', '25', '+639965352411', 'Married', 'Roman Catholic', 0, '240001', 'Walk In'),
(2, 'Julie', 'Patac', '1997-05-25', 'Zone 1', 0, 'Khu', '', 'Female', '27', '+639727381647', 'Single', 'Roman Catholic', 0, '240002', 'Walk In'),
(3, 'Karl', 'Nepumuceno', '2000-02-12', 'Zone 9', 0, '', '', 'Male', '24', '+639965352411', 'Married', 'Roman Catholic', 0, '240003', 'Walk In'),
(4, 'Nael', 'Castillo', '1998-12-31', 'Zone 2', 0, 'Fabiana', '', 'Male', '25', '+639947347811', 'Married', 'Iglesia ni Cristo', 0, '240004', 'Walk In'),
(5, 'Febby', 'Fabiana', '1999-08-27', 'Zone 10', 0, 'Jimenez', '', 'Female', '24', '+639947347811', 'Married', 'Roman Catholic', 0, '240005', 'Walk In'),
(6, 'Oniel', 'Racaza', '2001-04-14', 'Zone 4', 0, '', 'Jr.', 'Male', '23', '+639945345212', 'Single', 'Roman Catholic', 0, '240006', 'Walk In'),
(7, 'Rosie Jane', 'Sirafico', '1998-11-19', 'Zone 12', 0, '', '', 'Female', '25', '+639948483737', 'Married', 'Roman Catholic', 0, '240007', 'Walk In'),
(8, 'Anne', 'Raymundo', '2000-04-07', 'Zone 9', 0, '', '', 'Female', '24', '+639184588459', 'Married', 'Roman Catholic', 0, '240008', 'Walk In'),
(9, 'Ishi', 'Espejo', '2000-01-01', 'Zone 6', 0, '', '', 'Female', '24', '+639985745218', 'Married', 'Roman Catholic', 0, '240009', 'Walk In'),
(10, 'Mirahjane', 'Umali', '1999-07-11', 'Zone 3', 0, '', '', 'Female', '24', '+639524287495', 'Married', 'Roman Catholic', 0, '240010', 'Walk In'),
(11, 'Pia Paula', 'Mendoza', '2000-01-01', 'Zone 11', 0, 'Espejo', '', 'Female', '24', '+639118847309', 'Married', 'Roman Catholic', 0, '240011', 'Walk In'),
(12, 'Ruby', 'Velasquez', '1999-12-12', 'Zone 3', 0, 'Espejo', '', 'Female', '24', '+639977849291', 'Married', 'Roman Catholic', 0, '240012', 'Walk In'),
(13, 'Fiona', 'Estrada', '2000-01-31', 'Zone 1', 0, '', '', 'Female', '24', '+639184712012', 'Married', 'Iglesia ni Cristo', 0, '240013', 'Walk In'),
(14, 'Rica', 'Anggay', '1993-05-25', 'Zone 2', 0, 'Labis', '', 'Female', '31', '+639163783187', 'Married', 'Muslim', 0, '240014', 'Walk In'),
(15, 'Hadassah', 'Sarosong', '2000-01-01', 'Zone 3', 0, '', '', 'Female', '24', '+639125401247', 'Married', 'Muslim', 0, '240015', 'Walk In'),
(16, 'Golden', 'Ygona', '2000-01-31', 'Zone 1', 0, '', '', 'Female', '24', '+639448285671', 'Married', 'Roman Catholic', 0, '240016', 'Walk In'),
(17, 'Althea', 'Ypil', '1999-08-01', 'Zone 1', 0, '', '', 'Female', '24', '+639518492372', 'Married', 'Roman Catholic', 0, '240017', 'Walk In'),
(18, 'Ysabelle', 'Acosta', '2000-01-18', 'Zone 5', 0, '', '', 'Female', '24', '+639518492372', 'Married', 'Roman Catholic', 0, '240018', 'Walk In'),
(19, 'Veronica', 'Castillo', '1995-01-01', 'Zone 12', 0, '', '', 'Female', '29', '+639194781057', 'Married', 'Roman Catholic', 0, '240019', 'Walk In'),
(20, 'Helena', 'Cabrera', '1997-03-31', 'Zone 5', 0, 'Uba', '', 'Female', '27', '+639194759127', 'Married', 'Iglesia ni Cristo', 0, '240020', 'Walk In'),
(21, 'Alina', 'Acosta', '1994-12-31', 'Zone 1', 0, 'Uba', '', 'Female', '29', '+639194759127', 'Married', 'Iglesia ni Cristo', 0, '240021', 'Walk In'),
(22, 'Mae', 'Pascual', '1999-07-17', 'Zone 11', 0, '', '', 'Female', '24', '+639450128742', 'Married', 'Iglesia ni Cristo', 0, '240022', 'Walk In'),
(23, 'Geanne', 'Espejo', '1999-05-05', 'Zone 4', 0, '', '', 'Female', '25', '+639975903118', 'Married', 'Roman Catholic', 0, '240023', 'Walk In'),
(24, 'Alexa', 'Guiang', '2000-10-29', 'Zone 1', 0, '', '', 'Female', '23', '+639184091782', 'Married', 'Roman Catholic', 0, '240024', 'Walk In'),
(25, 'Angela', 'Jimenez', '1999-12-09', 'Zone 5', 0, '', '', 'Female', '24', '+639184091782', 'Married', 'Roman Catholic', 0, '240025', 'Walk In'),
(26, 'Mary', 'Labuan', '1993-05-25', 'Zone 3', 0, 'Teranio', '', 'Female', '31', '+639163737257', 'Single', 'Iglesia ni Cristo', 0, '240026', 'Walk In'),
(27, 'Patricia', 'Arcangel', '1999-07-04', 'Zone 4', 0, '', '', 'Female', '24', '+639478190547', 'Married', 'Iglesia ni Cristo', 0, '240027', 'Walk In'),
(28, 'Julie', 'Unigo', '1999-06-01', 'Zone 4', 0, '', '', 'Female', '24', '+639980484671', 'Married', '', 0, '240028', 'Walk In'),
(29, 'Irish', 'Bete', '1995-05-25', 'Zone 4', 0, 'Labat', '', 'Female', '29', '+639827381876', 'Married', 'Protestantism', 0, '240029', 'Walk In'),
(30, 'Princess', 'Tambeling', '1999-05-25', 'Zone 5', 0, 'Lagbas', '', 'Female', '25', '+639186283873', 'Married', 'Roman Catholic', 0, '240030', 'Walk In'),
(31, 'Trexie', 'Rebiyo', '1995-05-25', 'Zone 7', 0, 'Lapar', '', 'Female', '29', '+639727373824', 'Single', 'Roman Catholic', 0, '240031', 'Walk In'),
(32, 'Chloe', 'Magdangal', '1995-01-01', 'Zone 11', 0, 'Castillo', '', 'Female', '29', '+639109483292', 'Married', 'Roman Catholic', 0, '240032', 'Walk In'),
(33, 'Hannah', 'Talison', '1994-05-25', 'Zone 7', 0, 'Lauman', '', 'Female', '30', '+639163828738', 'Single', 'Muslim', 0, '240033', 'Walk In'),
(34, 'Charice', 'Dingal', '1994-12-01', 'Zone 4', 0, 'Sanchez', 'None', 'Female', '29', '639934952341', 'Married', 'Iglesia ni Cristo', 0, '240034', 'Walk In'),
(35, 'Aubrey', 'Dela Rosa', '1996-12-12', 'Zone 6', 0, '', '', 'Female', '27', '+639942134118', 'Married', 'Roman Catholic', 0, '240035', 'Walk In'),
(36, 'Kianna', 'Dagairag', '1992-05-25', 'Zone 6', 0, 'Limocon', '', 'Female', '32', '+639263772673', 'Married', 'Iglesia ni Cristo', 0, '240036', 'Walk In'),
(37, 'Queeny', 'Libarel', '1994-05-25', 'Zone 7', 0, 'Looc', '', 'Female', '30', '+639273882164', 'Married', 'Roman Catholic', 0, '240037', 'Walk In'),
(38, 'John', 'Lucagbo', '1995-05-25', 'Zone 11', 0, 'Lucero', '', 'Male', '29', '+639274726634', '', 'Roman Catholic', 0, '240038', 'Walk In'),
(39, 'Cassie', 'Cabanes', '1996-05-15', 'Zone 7', 0, '', '', 'Female', '28', '+639946684871', 'Married', 'Iglesia ni Cristo', 0, '240039', 'Walk In'),
(40, 'Kyrua', 'Aragon', '1999-03-12', 'Zone 10', 0, '', '', 'Female', '25', '+639948631197', 'Married', 'Iglesia ni Cristo', 0, '240040', 'Walk In'),
(41, 'Mary', 'Bagongon', '1993-05-25', 'Zone 3', 0, 'Lumain', '', 'Female', '31', '+639827493817', 'Married', 'Iglesia ni Cristo', 0, '240041', 'Walk In'),
(42, 'Jane', 'Fuentes', '1998-07-31', 'Zone 12', 0, '', '', 'Female', '25', '+639841358812', 'Married', 'Iglesia ni Cristo', 0, '240042', 'Walk In'),
(43, 'Herald', 'Ilaminan', '1997-05-25', 'Zone 11', 0, 'Macalaguing', '', 'Male', '27', '+639137173727', 'Married', 'Muslim', 0, '240043', 'Walk In'),
(44, 'Kimberly', 'Libanas', '1995-05-25', 'Zone 5', 0, 'Macapanas', '', 'Female', '29', '+639134627731', 'Married', 'Roman Catholic', 0, '240044', 'Walk In'),
(45, 'Kael', 'Esparcia', '1993-01-01', 'Zone 1', 0, '', '', 'Male', '31', '+639452848211', 'Married', 'Roman Catholic', 0, '240045', 'Walk In'),
(46, 'Kimmy', 'Jimenez', '1994-05-30', 'Zone 6', 0, '', '', 'Female', '29', '+639452848211', 'Married', 'Roman Catholic', 0, '240046', 'Walk In'),
(47, 'Arleigh', 'Tadlos', '1997-05-25', 'Zone 2', 0, 'Maghilum', '', 'Male', '27', '+639162856184', 'Single', 'Muslim', 0, '240047', 'Walk In'),
(48, 'Jean', 'Sumile', '1993-05-25', 'Zone 5', 0, 'Maglangit', '', 'Female', '31', '+639137381738', 'Married', 'Roman Catholic', 0, '240048', 'Walk In'),
(49, 'Leah', 'Sambire', '1995-08-01', 'Zone 9', 0, '', '', 'Female', '28', '+639341784717', 'Married', 'Roman Catholic', 0, '240049', 'Walk In'),
(50, 'Ella', 'Maallo', '1993-05-25', 'Zone 6', 0, 'Maglunsod', '', 'Female', '31', '+639126373817', 'Single', 'Iglesia ni Cristo', 0, '240050', 'Walk In'),
(51, 'Shaina', 'Cabanes', '1998-04-27', 'Zone 10', 0, '', '', 'Female', '26', '+639937859871', 'Married', 'Roman Catholic', 0, '240051', 'Walk In'),
(52, 'Nica', 'Barnido', '1995-05-25', 'Zone 4', 0, 'Manansala', '', 'Female', '29', '+639173838273', 'Married', 'Roman Catholic', 0, '240052', 'Walk In'),
(53, 'Mica', 'Bernardo', '1998-05-11', 'Zone 12', 0, 'Juegos', 'None', 'Female', '26', '639941741785', 'Married', 'Iglesia ni Cristo', 0, '240053', 'Walk In'),
(54, 'Karren', 'Basalo', '1998-05-25', 'Zone 5', 0, 'Mangila', '', 'Female', '26', '+639174728273', 'Married', 'Muslim', 0, '240054', 'Walk In'),
(55, 'Natalie', 'Juegos', '1995-06-19', 'Zone 2', 0, '', '', 'Female', '28', '+639717459181', 'Married', 'Roman Catholic', 0, '240055', 'Walk In'),
(56, 'Laurence', 'Comanda', '1999-05-25', 'Zone 5', 0, 'Manlaran', '', 'Male', '25', '+639173828287', 'Single', 'Iglesia ni Cristo', 0, '240056', 'Walk In'),
(57, 'Karina', 'Aragon', '1997-02-14', 'Zone 8', 0, '', '', 'Female', '27', '+639591058980', 'Married', 'Roman Catholic', 0, '240057', 'Walk In'),
(58, 'Crystal', 'Lahoy', '1998-05-25', 'Zone 6', 0, 'Manlimbana', '', 'Female', '26', '+639183738276', 'Married', 'Roman Catholic', 0, '240058', 'Walk In'),
(59, 'Yvenne', 'Santos', '1995-08-04', 'Zone 3', 0, '', '', 'Female', '28', '+639476015481', 'Married', 'Iglesia ni Cristo', 0, '240059', 'Walk In'),
(60, 'Hannah Mae', 'Galamiton', '1996-05-25', 'Zone 6', 0, 'Manzanal', '', 'Female', '28', '+639173827727', 'Married', 'Muslim', 0, '240060', 'Walk In'),
(61, 'Amara', 'Villareal', '1996-05-11', 'Zone 8', 0, '', '', 'Female', '28', '+639957812972', 'Married', 'Roman Catholic', 0, '240061', 'Walk In'),
(62, 'Een', 'Villasis', '1999-02-24', 'Zone 4', 0, 'Espejo', '', 'Female', '25', '+639472374118', 'Married', 'Iglesia ni Cristo', 0, '240062', 'Walk In'),
(63, 'Gaile', 'Montes', '1999-11-12', 'Zone 1', 0, '', '', 'Female', '24', '+639965358419', 'Married', 'Muslim', 0, '240063', 'Walk In'),
(64, 'Grace', 'Delima', '1997-07-13', 'Zone 8', 0, '', '', 'Female', '26', '+639951734812', 'Married', 'Muslim', 0, '240064', 'Walk In'),
(65, 'Shan', 'Gorra', '2001-01-01', 'Zone 1 ', 0, 'Maghopoy', 'II', 'Male', '23', '+639266666856', 'Single', 'Roman Catholic', 0, '240065', 'Online Register'),
(66, 'Shanessa', 'Gorra', '2020-05-25', 'Zone 5 ', 0, 'Maghopoy', '', 'Female', '4', '+639266666856', 'Single', 'Roman Catholic', 0, '240066', 'Online Register'),
(67, 'Felicia', 'Pagaran', '1998-10-28', 'Zone 11', 0, 'G', 'None', 'Female', '25', '639518092686', 'Married', 'Roman Catholic', 0, '240067', 'Online Register'),
(68, 'Marijoes', 'Obrial', '1996-12-31', 'Zone 1', 0, 'Uba', 'None', 'Female', '27', '639481478112', 'Married', 'Roman Catholic', 0, '240068', 'Walk In'),
(69, 'Sam', 'Sencyi', '1998-05-26', 'Zone 9', 0, 'E', '', 'Male', '26', '+639969456292', 'Single', 'Roman Catholic', 0, '240069', 'Walk In'),
(70, 'Sherilyn', 'Sanforr', '2000-05-26', 'Zone 5', 0, 'P', '', 'Female', '24', '+639969456345', 'Single', 'Roman Catholic', 0, '240070', 'Walk In'),
(71, 'Jorilyn', 'Macsaint', '2002-05-26', 'Zone 9', 0, 'T', '', 'Female', '22', '+639969456345', 'Single', 'Roman Catholic', 0, '240071', 'Walk In'),
(72, 'Josephine', 'Horford', '1998-05-26', 'Zone 6', 0, 'Y', '', 'Female', '26', '+639969456345', 'Single', 'Roman Catholic', 0, '240072', 'Walk In'),
(73, 'Farah', 'Ygona', '1997-12-01', 'Zone 1', 0, '', '', 'Female', '26', '+639942849129', 'Married', 'Roman Catholic', 0, '240073', 'Walk In'),
(74, 'Emma', 'Hernandez', '1998-04-27', 'Zone 4', 0, 'Espejo', '', 'Female', '26', '+639957418131', 'Married', 'Roman Catholic', 0, '240074', 'Walk In'),
(75, 'Isabela', 'Racaza', '1998-07-20', 'Zone 12', 0, '', '', 'Female', '25', '+639489174172', 'Married', 'Iglesia ni Cristo', 0, '240075', 'Walk In'),
(76, 'Juna', 'Tizon', '1996-03-31', 'Zone 11', 0, '', '', 'Female', '28', '+639941741891', 'Married', 'Roman Catholic', 0, '240076', 'Walk In'),
(77, 'Kendra', 'Estabillo', '1998-05-09', 'Zone 3', 0, '', '', 'Female', '26', '+639147147112', 'Married', 'Muslim', 0, '240077', 'Walk In'),
(78, 'Odecy', 'Marcop', '2000-05-26', 'Zone 7', 0, 'Y', '', 'Female', '24', '+639969456876', 'Single', 'Roman Catholic', 0, '240078', 'Walk In'),
(79, 'Cindy', 'Kaypey', '2002-05-12', 'Zone 12', 0, 'O', '', 'Female', '22', '+639969456346', 'Single', 'Roman Catholic', 0, '240079', 'Walk In'),
(80, 'Roxy', 'Manabat', '1999-05-26', 'Zone 2', 0, 'I', '', 'Female', '25', '+639969456341', 'Single', 'Roman Catholic', 0, '240080', 'Walk In'),
(81, 'Well Jay', 'Remaba', '1999-05-26', 'Zone 2', 0, 'Galagar', '', 'Male', '25', '+639273831772', 'Married', 'Roman Catholic', 0, '240081', 'Walk In'),
(82, 'Xyrel', 'Oxford', '1994-05-26', 'Zone 11', 0, 'R', '', 'Female', '30', '+639969456341', 'Single', 'Roman Catholic', 0, '240082', 'Walk In'),
(83, 'Taichi', 'Sydim', '2001-05-01', 'Zone 3', 0, 'R', '', 'Female', '23', '+639969456349', 'Single', 'Roman Catholic', 0, '240083', 'Walk In'),
(84, 'Normy', 'Palen', '1989-05-10', 'Zone 6', 0, 'R', '', 'Female', '35', '+639969456390', 'Single', 'Roman Catholic', 0, '240084', 'Walk In'),
(85, 'Merlyn', 'Jinwoo', '2003-05-26', 'Zone 8', 0, 'T', '', 'Female', '21', '+639969456390', 'Single', 'Roman Catholic', 0, '240085', 'Walk In'),
(86, 'Harry', 'Onde', '1998-05-26', 'Zone 9', 0, 'B', '', 'Male', '26', '+639969456234', 'Single', 'Roman Catholic', 0, '240086', 'Walk In'),
(87, 'Wendy', 'Dragyn', '2002-03-04', 'Zone 10', 0, 'B', '', 'Female', '22', '+639969456123', 'Single', 'Roman Catholic', 0, '240087', 'Walk In'),
(88, 'Jenny', 'Lorr', '2000-05-26', 'Zone 11', 0, 'A', '', 'Female', '24', '+639969456345', 'Single', 'Roman Catholic', 0, '240088', 'Walk In'),
(89, 'Xandra', 'Ford', '2002-10-03', 'Zone 12', 0, 'K', '', 'Female', '21', '+639969456456', 'Single', 'Roman Catholic', 0, '240089', 'Walk In'),
(90, 'Anya', 'Forger', '2003-07-16', 'Zone 12', 0, 'L', '', 'Male', '20', '+639969456456', 'Single', '', 0, '240090', 'Walk In'),
(91, 'Yorr', 'Sander', '1999-05-26', 'Zone 1', 0, 'J', '', 'Male', '25', '+639969456456', 'Single', 'Roman Catholic', 0, '240091', 'Walk In'),
(92, 'Lucy', 'Bonnie', '1997-05-26', 'Zone 2', 0, 'D', '', 'Female', '27', '+639969456567', 'Single', 'Roman Catholic', 0, '240092', 'Walk In'),
(93, 'Lebby', 'Cord', '1998-05-30', 'Zone 3', 0, 'G', '', 'Female', '25', '+639969456678', 'Single', 'Roman Catholic', 0, '240093', 'Walk In'),
(94, 'Zarah', 'Abacahin', '1999-05-26', 'Zone 8', 0, 'Gumatay', '', 'Female', '25', '+639172782728', 'Married', 'Roman Catholic', 0, '240094', 'Walk In'),
(95, 'Delore', 'Conley', '1996-07-10', 'Zone 4', 0, 'K', '', 'Male', '27', '+639969452344', '', 'Roman Catholic', 0, '240095', 'Walk In'),
(96, 'Lenny', 'Roby', '1998-05-26', 'Zone 5', 0, 'X', '', 'Female', '26', '+639969452344', 'Single', 'Roman Catholic', 0, '240096', 'Walk In'),
(97, 'Sarah', 'Labati', '1991-08-15', 'Zone 6', 0, 'N', '', 'Female', '32', '+639969452344', 'Single', 'Roman Catholic', 0, '240097', 'Walk In'),
(98, 'Yanny', 'Gord', '1994-05-28', 'Zone 7', 0, 'Y', '', 'Female', '29', '+639969428164', 'Single', 'Roman Catholic', 0, '240098', 'Walk In'),
(99, 'Angel', 'Finy', '2003-07-19', 'Zone 8', 0, 'Q', '', 'Male', '20', '+63983738273t', 'Single', 'Roman Catholic', 0, '240099', 'Walk In'),
(100, 'Lindsay', 'Kabingue', '1995-05-26', 'Zone 5', 0, 'Ocampo', '', 'Female', '29', '+639387283827', 'Married', 'Roman Catholic', 0, '240100', 'Walk In'),
(101, 'Tina', 'Pornid', '2000-10-12', 'Zone 9', 0, 'I', '', 'Female', '23', '+639837382732', 'Single', 'Roman Catholic', 0, '240101', 'Walk In'),
(102, 'Cinyy', 'Ovri', '2003-02-20', 'Zone 9', 0, 'B', '', 'Male', '21', '+639969456341', '', 'Roman Catholic', 0, '240102', 'Walk In'),
(103, 'Jelliane', 'Arela', '1994-05-26', 'Zone 5', 0, 'Quijano', '', 'Female', '30', '+639163737262', 'Married', 'Muslim', 0, '240103', 'Walk In'),
(104, 'Ellaine', 'Magsalay', '1995-05-26', 'Zone 6', 0, 'Sinontao', 'None ', 'Female', '29', '639273783821', 'Married', 'Iglesia ni Cristo', 0, '240104', 'Walk In'),
(105, 'Justine', 'Visayas', '2000-05-26', 'Zone 2', 0, 'Yu', '', 'Male', '24', '+639796273521', 'Married', 'Muslim', 0, '240105', 'Walk In'),
(106, 'Yuna', 'Villasis', '1999-05-09', 'Zone 7', 0, 'Ababa', '', 'Female', '25', '+639417471412', 'Married', 'Muslim', 0, '240106', 'Walk In'),
(107, 'Cathlea', 'Macote', '1998-05-26', 'Zone 5', 0, 'Echalico', '', 'Female', '26', '+639173818739', 'Married', 'Roman Catholic', 0, '240107', 'Walk In'),
(108, 'Jerrika', 'Canillo', '1998-05-26', 'Zone 6', 0, 'Flores', '', 'Female', '26', '+639183638284', 'Married', 'Muslim', 0, '240108', 'Walk In'),
(109, 'Sheena', 'Rodillas', '1999-01-01', 'Zone 8', 0, '', '', 'Female', '25', '+639941741945', 'Married', 'Roman Catholic', 0, '240109', 'Walk In'),
(110, 'Paula Jane', 'Fernandez', '1999-09-27', 'Zone 3', 0, '', '', 'Female', '24', '+639431736717', 'Married', 'Roman Catholic', 0, '240110', 'Walk In'),
(111, 'Alexandra', 'Castillo', '1995-09-12', 'Zone 10', 0, '', '', 'Female', '28', '+639431736717', 'Married', 'Muslim', 0, '240111', 'Walk In'),
(112, 'Andrew', 'Sanz', '2001-07-08', 'Zone 7', 0, 'O', '', 'Male', '22', '+639969456345', 'Single', 'Roman Catholic', 0, '240112', 'Walk In'),
(113, 'Andy', 'Eigenman', '1994-09-15', 'Zone 10', 0, 'L', '', 'Male', '29', '+639969459876', 'Single', 'Roman Catholic', 0, '240113', 'Walk In'),
(114, 'Lexi', 'Cabrera', '2002-10-17', 'Zone 9', 0, 'L', '', 'Female', '21', '+639969459234', 'Single', 'Roman Catholic', 0, '240114', 'Walk In'),
(115, 'Pauline', 'Egamo', '1998-05-29', 'Zone 10', 0, 'K', '', 'Female', '25', '+639969459123', 'Single', 'Roman Catholic', 0, '240115', 'Walk In'),
(116, 'Shylyn', 'Obtoso', '1999-11-25', 'Zone 2', 0, 'L', '', 'Female', '24', '+639969459123', 'Single', 'Roman Catholic', 0, '240116', 'Walk In'),
(117, 'Sheldy', 'Barbasid', '2000-06-23', 'Zone 5', 0, 'Y', '', 'Male', '23', '+639969452344', 'Single', '', 0, '240117', 'Walk In'),
(118, 'Marlita', 'Alevar', '1996-12-18', 'Zone 1', 0, 'A', '', 'Male', '27', '+639969456341', 'Single', 'Roman Catholic', 0, '240118', 'Walk In'),
(119, 'Antonette', 'Soriano', '1997-05-26', 'Zone 6', 0, 'Gallardo', '', 'Female', '27', '+639112896836', 'Married', 'Roman Catholic', 0, '240119', 'Walk In'),
(120, 'Alex', 'Porzingis', '1994-05-26', 'Zone 7', 0, 'A', '', 'Male', '30', '+639969456341', 'Single', 'Roman Catholic', 0, '240120', 'Walk In'),
(121, 'Jane', 'Mendozi', '2000-05-26', 'Zone 6', 0, 'P', 'None', 'Female', '24', '9361548164', 'Single', 'Roman Catholic', 0, '240121', 'Walk In'),
(122, 'Clareece', 'Sanmol', '1997-05-26', 'Zone 5', 0, 'P', '', 'Female', '27', '+639715182638', 'Single', 'Roman Catholic', 0, '240122', 'Walk In'),
(123, 'Lena', 'Domid', '1997-10-08', 'Zone 7', 0, 'K', '', 'Female', '26', '+639715182638', 'Single', 'Roman Catholic', 0, '240123', 'Walk In'),
(124, 'Nikki', 'Astronomo', '1998-05-26', 'Zone 5', 0, 'Pameron', '', 'Female', '26', '+639187383837', 'Married', 'Roman Catholic', 0, '240124', 'Walk In'),
(125, 'Karina', 'Sanfin', '1993-09-18', 'Zone 8', 0, 'A', '', 'Male', '30', '+639969456345', 'Single', 'Roman Catholic', 0, '240125', 'Walk In'),
(126, 'Kiffy', 'Senz', '2006-05-08', 'Zone 8', 0, 'A', 'None', 'Male', '18', '+639969456345', 'Single', 'Roman Catholic', 0, '240126', 'Walk In'),
(127, 'Charline', 'Epormi', '1989-08-15', 'Zone 5', 0, 'K', '', 'Male', '34', '+639969452344', 'Single', 'Roman Catholic', 0, '240127', 'Walk In'),
(128, 'Pejane', 'Porlim', '1999-05-30', 'Zone 9', 0, 'I', '', 'Female', '24', '+639969452344', 'Single', 'Roman Catholic', 0, '240128', 'Walk In'),
(129, 'Kim', 'Gafon', '2000-05-26', 'Zone 11', 0, 'G', 'None', 'Male', '24', '639969456345', 'Single', 'Roman Catholic', 0, '240129', 'Walk In'),
(130, 'Lesley', 'Snipol', '1997-05-22', 'Zone 4', 0, 'J', '', 'Female', '27', '+639969456345', 'Single', 'Roman Catholic', 0, '240130', 'Walk In'),
(131, 'Onika', 'Kayom', '2001-08-13', 'Zone 9', 0, 'P', '', 'Female', '22', '+639983649262', 'Single', '', 0, '240131', 'Walk In'),
(132, 'Kairi', 'Edusa', '2001-03-20', 'Zone 10', 0, 'O', '', 'Male', '23', '+639983649262', 'Single', 'Roman Catholic', 0, '240132', 'Walk In'),
(133, 'Envi Rose', 'Pahuli', '2003-03-19', 'Zone 10', 0, 'O', '', 'Female', '21', '+639983649262', 'Single', 'Roman Catholic', 0, '240133', 'Walk In'),
(134, 'Rose Mar', 'Tan', '1998-01-21', 'Zone 10', 0, 'I', '', 'Female', '26', '+639983649262', 'Single', 'Roman Catholic', 0, '240134', 'Walk In'),
(135, 'John', 'Quertes', '2024-05-09', 'Zone 4', 0, 'P', '', 'Male', '0', '+639983649262', 'Single', 'Roman Catholic', 0, '240135', 'Walk In'),
(136, 'Coby', 'Wepos', '1997-03-23', 'Zone 1', 0, 'P', '', 'Male', '27', '+639983649262', 'Single', 'Roman Catholic', 0, '240136', 'Walk In'),
(137, 'Paulin', 'Esteliore', '2002-04-26', 'Zone 2', 0, 'P', '', 'Female', '22', '+639983649262', 'Single', 'Roman Catholic', 0, '240137', 'Walk In'),
(138, 'Ajay', 'Galarido', '1993-05-26', 'Zone 3', 0, 'Y', '', 'Female', '31', '+639983649262', 'Single', 'Roman Catholic', 0, '240138', 'Walk In'),
(139, 'Fiona', 'Lugasma', '1998-02-09', 'Zone 4', 0, 'Y', '', 'Female', '26', '+639983649262', 'Single', 'Roman Catholic', 0, '240139', 'Walk In'),
(140, 'Cindi', 'Batastil', '2000-02-18', 'Zone 5', 0, 'K', '', 'Female', '24', '+639983649262', 'Single', 'Roman Catholic', 0, '240140', 'Walk In'),
(141, 'Antoniettte', 'Gallardo', '2023-02-05', 'Zone 1', 0, 'Soriano', 'None', 'Female', '1', '639268175389', 'Single', 'Roman Catholic', 0, '240141', 'Walk In'),
(142, 'Natalie', 'Hermosa', '2001-12-09', 'Zone 8 ', 0, 'Gonzales', 'None', 'Female', '22', '+639569260774', 'Single', 'Roman Catholic', 0, '240142', 'Online Register'),
(143, 'Karen', 'Dizon', '2001-12-09', 'Zone 6', 0, 'Gonzales', 'None', 'Female', '22', '639569260774', 'Single', 'Roman Catholic', 0, '240143', 'Online Register'),
(144, 'Rosalie', 'Gorra', '1990-05-27', 'Zone 12', 0, 'Maghopoy', '', 'Female', '34', '+639266666857', 'Married', 'Roman Catholic', 0, '240144', 'Online Register'),
(145, 'Venz J', 'Cabonegro', '2003-01-01', 'Zone 11', 0, 'Estorba', 'None', 'Male', '21', '+639956695961', 'Single', 'Roman Catholic', 0, '240145', 'Online Register'),
(146, 'Feliciano', 'Pagaran', '2002-09-03', 'Zone 10', 0, 'E', 'None', 'Male', '21', '+639477872803', 'Single', 'Roman Catholic', 0, '240146', 'Online Register'),
(147, 'Venz Jae', 'Cabonegro', '2022-05-25', 'Zone 5 ', 0, 'Estorba', '', 'Male', '2', '+639956695961', 'Single', 'Roman Catholic', 0, '240147', 'Online Register'),
(148, 'Hannah', 'Deliba', '1990-05-27', 'Zone 4', 0, 'Mahayan', '', 'Female', '34', '+639266666856', 'Married', 'Roman Catholic', 0, '240148', 'Online Register'),
(149, 'Dalia', 'Gonzalez', '1999-10-10', 'Zone 8', 0, 'Arcayena', 'None', 'Female', '24', '+639268175389', 'Married', 'Roman Catholic', 0, '240149', 'Walk In'),
(150, 'Dapne', 'Carton', '2020-01-09', 'Zone 12', 0, 'Magallanes', 'None', 'Female', '4', '+639914009429', 'Single', 'Roman Catholic', 0, '240150', 'Walk In'),
(151, 'Juna', 'Zapanta', '2019-05-27', 'Zone 8', 0, 'Absuelo', '', 'Female', '5', '+639173838273', 'Single', 'Muslim', 0, '240151', 'Walk In'),
(152, 'Jesalyn', 'Pelago', '2022-05-27', 'Zone 1', 0, 'Acierto', '', 'Female', '2', '+639272379481', 'Single', 'Muslim', 0, '240152', 'Walk In'),
(153, 'Analyn', 'Rendon', '2021-05-27', 'Zone 8', 0, 'Alamo', '', 'Female', '3', '+639163817381', 'Single', 'Iglesia ni Cristo', 0, '240153', 'Walk In'),
(154, 'Maria', 'Luminarias', '2021-05-27', 'Zone 7', 0, 'Almedilla', '', 'Female', '3', '+639273738173', 'Single', 'Roman Catholic', 0, '240154', 'Walk In'),
(155, 'Ronnie', 'Hermosillia', '2022-05-27', 'Zone 7', 0, 'Balansag', '', 'Male', '2', '+639273489427', 'Single', 'Iglesia ni Cristo', 0, '240155', 'Walk In'),
(156, 'Christia', 'Balatero', '2023-05-27', 'Zone 3', 0, 'Boborol', '', 'Female', '1', '+639277482738', 'Single', 'Roman Catholic', 0, '240156', 'Walk In'),
(157, 'Leonard', 'Galarpe', '2022-05-27', 'Zone 3', 0, 'Budiongan', '', 'Male', '2', '+639273783278', 'Single', 'Roman Catholic', 0, '240157', 'Walk In'),
(158, 'Angel', 'Cabegun', '2020-05-27', 'Zone 5', 0, 'Caamiño', '', 'Female', '4', '+639154166367', 'Single', 'Roman Catholic', 0, '240158', 'Walk In'),
(159, 'Rhea', 'Generalao', '2019-05-27', 'Zone 5', 0, 'Caballero', '', 'Female', '5', '+639263819648', 'Single', 'Muslim', 0, '240159', 'Walk In'),
(160, 'Jamaica', 'Aljas', '2022-05-27', 'Zone 3', 0, 'Cabisay', '', 'Female', '2', '+639163837137', 'Single', 'Buddhism', 0, '240160', 'Walk In'),
(161, 'James', 'Vallejos', '2020-05-27', 'Zone 6', 0, '', '', 'Male', '4', '+639282737381', 'Single', 'Roman Catholic', 0, '240161', 'Walk In'),
(162, 'Mary', 'Nibahan', '2021-05-27', 'Zone 7', 0, 'Democer', '', 'Female', '3', '+639784628411', 'Single', 'Muslim', 0, '240162', 'Walk In'),
(163, 'Ian', 'Mascuñana', '2022-05-27', 'Zone 3', 0, 'Eyas', '', 'Male', '2', '+639273717341', 'Single', 'Iglesia ni Cristo', 0, '240163', 'Walk In'),
(164, 'Christine', 'Paninsuro', '2020-05-27', 'Zone 4', 0, 'Gambuta', '', 'Female', '4', '+639152635882', 'Single', 'Muslim', 0, '240164', 'Walk In'),
(165, 'Riza', 'Nala', '2019-05-27', 'Zone 12', 0, 'Glova', '', 'Female', '5', '+639266271764', 'Single', 'Protestantism', 0, '240165', 'Walk In'),
(166, 'Christian', 'Signapan', '2020-05-27', 'Zone 1', 0, 'Go', '', 'Male', '4', '+639173241516', 'Single', 'Iglesia ni Cristo', 0, '240166', 'Walk In'),
(167, 'Jover', 'Vergara', '2020-05-27', 'Zone 6', 0, 'Guangco', '', 'Male', '4', '+639151738835', 'Single', 'Roman Catholic', 0, '240167', 'Walk In'),
(168, 'Foebe', 'Garcia', '2019-05-27', 'Zone 11', 0, 'Herro', '', 'Female', '5', '+639263878162', 'Single', 'Iglesia ni Cristo', 0, '240168', 'Walk In'),
(169, 'Korina', 'Nacaya', '2021-05-27', 'Zone 6', 0, 'Igtos', '', 'Female', '3', '+639163831742', 'Single', 'Roman Catholic', 0, '240169', 'Walk In'),
(170, 'Marian', 'Enojales', '2021-05-27', 'Zone 5', 0, 'Kionisala', '', 'Female', '3', '+639163737168', 'Single', 'Roman Catholic', 0, '240170', 'Walk In'),
(171, 'Iralyn', 'Edralyn', '2021-05-27', 'Zone 6', 0, 'Laid', '', 'Female', '3', '+639263782162', 'Single', 'Roman Catholic', 0, '240171', 'Walk In'),
(172, 'Sara', 'Sanz', '2022-05-27', 'Zone 5', 0, 'Layan', '', 'Female', '2', '+639263826638', 'Single', 'Iglesia ni Cristo', 0, '240172', 'Walk In'),
(173, 'Ronel', 'Jumamil', '2020-05-27', 'Zone 5', 0, 'Leono', '', 'Male', '4', '+639273827338', 'Single', 'Muslim', 0, '240173', 'Walk In'),
(174, 'Rica', 'Policios', '2022-05-27', 'Zone 1', 0, 'Looc', '', 'Female', '2', '+639273836228', 'Single', 'Aglipayan', 0, '240174', 'Walk In'),
(175, 'Andrei', 'Yañez', '2020-05-27', 'Zone 9', 0, 'Mabalhin', '', 'Male', '4', '+639628371638', 'Single', 'Iglesia ni Cristo', 0, '240175', 'Walk In'),
(176, 'Lovely', 'Macarandan', '2023-05-27', 'Zone 7', 0, '', '', 'Female', '1', '+639173827683', 'Single', 'Roman Catholic', 0, '240176', 'Walk In'),
(177, 'Mariz', 'Gador', '2020-05-27', 'Zone 8', 0, 'Marquez', '', 'Female', '4', '+639173838168', 'Single', 'Roman Catholic', 0, '240177', 'Walk In'),
(178, 'Jevelyn', 'Labrador', '2021-05-27', 'Zone 10', 0, 'Nervar', 'none', 'Female', '3', '639275273836', 'Single', 'Roman Catholic', 0, '240178', 'Walk In'),
(179, 'Joel', 'Obrial', '1978-06-12', 'Zone 12', 0, 'Tenorio', 'None', 'Male', '45', '+639750440880', 'Married', 'Other or Nonreligious', 0, '240179', 'Online Register'),
(180, 'Marilyn', 'Obrial', '1979-04-09', 'Zone 12', 0, 'Uba', 'None', 'Female', '45', '639557451800', 'Married', 'Other or Non-religious', 0, '240180', 'Online Register'),
(181, 'Paul', 'George', '1991-06-05', 'Zone 1', 0, 'Edwards', 'Jr', 'Male', '32', '+639268175389', 'Single', 'Roman Catholic', 0, '240181', 'Online Register'),
(182, 'Samuel', 'Yecyec', '2000-05-28', 'Zone 1', 0, 'Noval', '', 'Male', '24', '+639274882618', 'Married', 'Roman Catholic', 0, '240182', 'Walk In'),
(183, 'Kazuya', 'Nipara', '1998-05-28', 'Zone 4', 0, 'Pañares', '', 'Male', '26', '+639277382638', 'Married', 'Muslim', 0, '240183', 'Walk In'),
(184, 'Jordan', 'Miles', '2000-05-28', 'Zone 2', 0, 'E', '', 'Male', '24', '+639899789045', 'Single', 'Roman Catholic', 0, '240184', 'Walk In'),
(185, 'Oden', 'Momok', '1992-05-29', 'Zone 7', 0, 'E', '', 'Male', '31', '+639899789048', 'Single', 'Roman Catholic', 0, '240185', 'Walk In'),
(186, 'Jerry', 'Doloriel', '1987-05-28', 'Zone 6', 0, 'Pecante', 'None', 'Male', '37', '+639174725163', 'Married', 'Iglesia ni Cristo', 0, '240186', 'Walk In'),
(187, 'Sami', 'Jackson', '2001-05-06', 'Zone 9', 0, 'I', 'None', 'Male', '23', '+639754678208', 'Single', 'Roman Catholic', 0, '240187', 'Walk In'),
(188, 'Pearl', 'Mabao', '1991-05-28', 'Zone 2', 0, 'Pecasis', 'None', 'Female', '33', '+639172839263', 'Married', 'Muslim', 0, '240188', 'Walk In'),
(189, 'Shaina', 'Magdayao', '2000-05-08', 'Zone 6', 0, 'O', 'None', 'Male', '24', '+639899786728', 'Single', 'Roman Catholic', 0, '240189', 'Walk In'),
(190, 'Glecyl', 'Jadman', '1995-05-28', 'Zone 5', 0, 'Pegarido', 'None', 'Female', '29', '+6391738$8151', 'Married', 'Roman Catholic', 0, '240190', 'Walk In'),
(191, 'Joelie', 'Lague', '1985-05-28', 'Zone 6', 0, 'Red', 'None', 'Female', '39', '+639163636281', 'Married', 'Iglesia ni Cristo', 0, '240191', 'Walk In'),
(192, 'Angel', 'Arnilla', '1993-05-28', 'Zone 11', 0, 'Reformado', 'None', 'Female', '31', '+639754871425', 'Married', 'Roman Catholic', 0, '240192', 'Walk In'),
(193, 'Mylene', 'Bucag', '1995-05-28', 'Zone 5', 0, 'Saya', 'None', 'Female', '29', '+639851573221', 'Married', 'Muslim', 0, '240193', 'Walk In'),
(194, 'Marialle', 'Daang', '1998-05-28', 'Zone 10', 0, 'Suico', 'None', 'Female', '26', '+639637427538', 'Married', 'Iglesia ni Cristo', 0, '240194', 'Walk In'),
(195, 'Jurie', 'Gaboy', '1984-05-28', 'Zone 10', 0, 'Sumobay', 'None', 'Male', '40', '+639163817361', 'Married', 'Iglesia ni Cristo', 0, '240195', 'Walk In'),
(196, 'Cheril', 'Lugnasan', '1994-05-28', 'Zone 11', 0, 'Tunda-an', 'None', 'Female', '30', '+639744727842', 'Married', 'Iglesia ni Cristo', 0, '240196', 'Walk In'),
(197, 'Juney', 'Bajade', '1992-05-28', 'Zone 9', 0, 'Abejo', 'None', 'Male', '32', '+639853732156', 'Married', 'Roman Catholic', 0, '240197', 'Walk In'),
(198, 'Danica', 'Sangutan', '1988-05-28', 'Zone 3', 0, 'Abel', 'None', 'Female', '36', '+639177283627', 'Married', 'Muslim', 0, '240198', 'Walk In'),
(199, 'Kentche', 'Jawayon', '1996-05-28', 'Zone 10', 0, 'Abregana', 'None', 'Male', '28', '+639178338831', 'Married', 'Roman Catholic', 0, '240199', 'Walk In'),
(200, 'April', 'Caminos', '1995-05-28', 'Zone 11', 0, 'Abriol', 'None', 'Female', '29', '+639273892174', 'Married', 'Roman Catholic', 0, '240200', 'Walk In'),
(201, 'Sheena', 'Villaranda', '2020-05-03', 'Zone 1', 0, 'Q', 'None', 'Female', '4', '+639268175389', 'Single', 'Other or Non-religious', 0, '240201', 'Walk In'),
(202, 'Eunice', 'Absuelo', '1994-05-28', 'Zone 12', 0, 'Abuhan', 'None', 'Female', '30', '+639272783745', '', 'Roman Catholic', 0, '240202', 'Walk In'),
(203, 'Rey', 'Tigol', '1991-05-28', 'Zone 12', 0, 'Agsinao', 'None', 'Male', '33', '+639277482617', 'Married', 'Muslim', 0, '240203', 'Walk In'),
(204, 'Shekinah', 'Bles', '2012-05-24', 'Zone 2', 0, '', 'None', 'Female', '12', '+639268175389', 'Single', 'Iglesia ni Cristo', 0, '240204', 'Walk In'),
(205, 'Queenie', 'Cababasada', '1994-05-28', 'Zone 12', 0, 'Aguilar', 'None', 'Female', '30', '+639726382618', 'Married', 'Muslim', 0, '240205', 'Walk In'),
(206, 'Phoebe Karyle', 'Pabriga', '2010-04-06', 'Zone 7', 0, 'Uba', 'None', 'Female', '14', '+639268176289', 'Single', 'Buddhism', 0, '240206', 'Walk In'),
(207, 'Ariel', 'Baron', '1987-05-28', 'Zone 1', 0, 'Aguillon', 'None', 'Male', '37', '+639273827296', 'Married', 'Iglesia ni Cristo', 0, '240207', 'Walk In'),
(208, 'Che-ann', 'Echinique', '2011-05-17', 'Zone 5', 0, 'Griffing', 'None', 'Female', '13', '+639268295489', 'Single', 'Sikhism', 0, '240208', 'Walk In'),
(209, 'Anna', 'Rances', '1986-05-28', 'Zone 2', 0, 'Ala-an', 'None', 'Female', '38', '+639727382183', 'Married', 'Iglesia ni Cristo', 0, '240209', 'Walk In'),
(210, 'Clent', 'Lumba', '1995-05-28', 'Zone 3', 0, 'Alaba', 'None', 'Male', '29', '+639274827381', 'Married', 'Roman Catholic', 0, '240210', 'Walk In'),
(211, 'Hazel', 'Jayson', '2014-05-03', 'Zone 11', 0, 'Orencio', 'None', 'Female', '10', '+639268175389', 'Single', 'Protestantism', 0, '240211', 'Walk In'),
(212, 'James', 'Cuenza', '1995-05-28', 'Zone 4', 0, 'Alaban', 'None', 'Male', '29', '+639163721887', 'Married', 'Roman Catholic', 0, '240212', 'Walk In'),
(213, 'John', 'Debara', '1993-05-28', 'Zone 5', 0, 'Ampatin', 'None', 'Male', '31', '639173871638', 'Married', 'Muslim', 0, '240213', 'Walk In'),
(214, 'Ylaiza Joyce', 'De Guzman', '2014-03-12', 'Zone 10', 0, 'Obrial', 'None', 'Female', '10', '+639268295489', 'Single', 'Iglesia ni Cristo', 0, '240213', 'Walk In'),
(215, 'Jaynina', 'Lapita', '1995-05-28', 'Zone 6', 0, 'Ampatin', 'None', 'Female', '29', '+639848288483', 'Married', 'Muslim', 0, '240214', 'Walk In'),
(216, 'Angelica', 'Monsales', '1988-05-28', 'Zone 7', 0, 'Angcos', 'None', 'Female', '36', '+639277382631', 'Married', 'Protestantism', 0, '240215', 'Walk In'),
(217, 'Alimoden', 'Udasan', '1996-05-28', 'Zone 8', 0, 'Anwar', 'None', 'Male', '28', '+639274816177', 'Married', 'Aglipayan', 0, '240216', 'Walk In'),
(218, 'Kissy', 'Bendoy', '1986-05-28', 'Zone 8', 0, 'Apal', 'None', 'Female', '38', '+639272738791', 'Married', 'Buddhism', 0, '240217', 'Walk In'),
(219, 'Jeelyn', 'Malazar', '2015-01-16', 'Zone 8', 0, 'Obrial', 'None', 'Female', '9', '+639268175389', 'Single', 'Roman Catholic', 0, '240218', 'Walk In'),
(220, 'Jannah', 'Morento', '2009-05-28', 'Zone 2', 0, 'Aranas', 'None', 'Female', '15', '+639177272763', 'Married', 'Roman Catholic', 0, '240219', 'Walk In'),
(221, 'Johanna', 'Ebarat', '2019-05-16', 'Zone 3', 0, 'Sigua', 'None', 'Female', '5', '+639268295489', 'Single', 'Aglipayan', 0, '240220', 'Walk In'),
(222, 'Misty', 'McCaw', '2022-05-19', 'Zone 11', 0, 'Uba', 'None', 'Female', '2', '+639268175389', 'Single', 'Muslim', 0, '240221', 'Walk In'),
(223, 'Cyndie', 'Odtojan', '2023-05-06', 'Zone 10', 0, 'Obrial', 'None', 'Female', '1', '+639268295489', 'Single', 'Judaism', 0, '240222', 'Walk In'),
(224, 'Karen', 'Nave', '2008-05-28', 'Zone 2', 0, 'Arbois', 'None', 'Female', '16', '+639263727196', 'Married', 'Muslim', 0, '240223', 'Walk In'),
(225, 'Joshua', 'Bahian', '1994-05-28', 'Zone 4', 0, 'Armamento', 'None', 'Male', '30', '+639716382718', 'Married', 'Iglesia ni Cristo', 0, '240224', 'Walk In'),
(226, 'Jinuel', 'Lagimo', '2021-02-24', 'Zone 1', 0, 'P', 'None', 'Male', '3', '+639737383928', 'Single', 'Roman Catholic', 0, '240225', 'Walk In'),
(227, 'Dave', 'Presores', '1994-05-28', 'Zone 7', 0, 'Ajoro', 'None', 'Male', '30', '+639164816362', 'Married', 'Aglipayan', 0, '240226', 'Walk In'),
(228, 'Samuel', 'Castro', '2022-05-08', 'Zone 2', 0, 'G', 'None', 'Male', '2', '+639737383928', 'Single', 'Roman Catholic', 0, '240227', 'Walk In'),
(229, 'Pablo', 'Caballero', '2021-10-29', 'Zone 4', 0, 'O', 'None', 'Male', '2', '+639737383928', 'Single', 'Roman Catholic', 0, '240228', 'Walk In'),
(230, 'Kobi', 'Paraas', '2020-05-05', 'Zone 5', 0, 'X', 'None', 'Male', '4', '+639737383928', 'Single', 'Roman Catholic', 0, '240229', 'Walk In'),
(231, 'Kairii', 'Deguzman', '2020-11-16', 'Zone 6', 0, 'R', 'None', 'Male', '3', '+639737383928', 'Single', 'Roman Catholic', 0, '240230', 'Walk In'),
(232, 'Binoiii', 'Aquirez', '2021-12-19', 'Zone 5', 0, 'K', 'None', 'Male', '2', '+639737383928', 'Single', 'Roman Catholic', 0, '240231', 'Walk In'),
(233, 'Pedrox', 'Lamborks', '2022-12-25', 'Zone 6', 0, 'W', 'None', 'Male', '1', '+639737383928', 'Single', 'Roman Catholic', 0, '240232', 'Walk In'),
(234, 'Glenn', 'Pena', '1995-05-28', 'Zone 5', 0, 'Astillo', 'None', 'Male', '29', '+639267392748', 'Married', 'Roman Catholic', 0, '240233', 'Walk In'),
(235, 'Obrax', 'Pilod', '2020-01-31', 'Zone 9', 0, 'G', 'None', 'Male', '4', '+639737383928', 'Single', 'Roman Catholic', 0, '240234', 'Walk In'),
(236, 'Maeryl', 'Lagrosas', '2022-05-28', 'Zone 1', 0, 'Baculio', 'None', 'Female', '2', '+639667675756', 'Single', 'Roman Catholic', 0, '240235', 'Walk In'),
(237, 'Vince', 'Estrada', '2021-05-28', 'Zone 8', 0, 'Baculio', 'None', 'Male', '3', '+639273928178', 'Married', 'Muslim', 0, '240236', 'Walk In'),
(238, 'Hanny', 'Tadle', '2019-05-28', 'Zone 9', 0, 'Bagas', 'None', 'Male', '5', '+639372817383', 'Married', 'Aglipayan', 0, '240237', 'Walk In'),
(239, 'Yelyah', 'Sarigumba', '1994-01-01', 'Zone 4', 0, 'Novilla', 'None', 'Female', '30', '+639418467184', 'Married', 'Roman Catholic', 0, '240238', 'Walk In'),
(240, 'Christian', 'Bangquerigo', '2021-05-29', 'Zone 8', 0, 'Bagongon', 'None', 'Male', '2', '+639825174818', 'Single', 'Muslim', 0, '240239', 'Walk In'),
(241, 'Eldon', 'Taryad', '2020-05-29', 'Zone 10', 0, 'Bajuyo', 'None', 'Male', '3', '+639816391942', 'Single', 'Iglesia ni Cristo', 0, '240240', 'Walk In'),
(242, 'Carrie', 'Cabanes', '1994-05-29', 'Zone 3', 0, '', 'None', 'Female', '29', '+639937732872', 'Married', 'Muslim', 0, '240241', 'Walk In'),
(243, 'Christina', 'Desabilla', '1996-05-13', 'Zone 8', 0, 'Ong', 'None', 'Female', '28', '+639964837263', 'Married', 'Roman Catholic', 0, '240242', 'Walk In'),
(244, 'Laizel', 'Omamos', '2020-05-30', 'Zone 12', 0, 'Labis', 'None', 'Female', '29', '639277482638', 'Single', 'Roman Catholic', 0, '240243', 'Walk In'),
(245, 'Zaira', 'Palad', '2021-05-30', 'Zone 8', 0, 'Jaraula', 'None', 'Female', '3', '639272816151', 'Single', 'Roman Catholic', 0, '240244', 'Walk In'),
(246, 'Jinel Hanz', 'Anacite', '2002-05-04', 'Zone 1', 0, 'Arimas', 'None', 'Male', '22', '+639476969963', 'Single', 'Roman Catholic', 0, '240245', 'Online Register'),
(247, 'Dexter', 'Maghanoy', '2023-05-31', 'Zone 1', 0, 'Pagaran', 'None', 'Male', '0', '+639753249697', 'Single', 'Roman Catholic', 0, '240246', 'Online Register'),
(248, 'Dominic', 'Kionisala', '2021-05-30', 'Zone 8', 0, 'c', '', 'Male', '3', '+639207864826', 'Single', 'Judaism', 0, '240247', 'Online Register'),
(249, 'Dale', 'James', '2000-05-11', 'Zone 10', 0, 'Labantog', '', 'Male', '24', '+639656715283', 'Single', 'Muslim', 0, '240248', 'Walk In');

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
  `prenatal_subjective_id` int(11) DEFAULT NULL,
  `fh` varchar(255) NOT NULL,
  `fhb` varchar(255) NOT NULL,
  `pres` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_consultation`
--

INSERT INTO `prenatal_consultation` (`id`, `patient_id`, `description`, `diagnosis`, `medicine`, `midwife_id`, `checkup_date`, `is_print`, `prenatal_subjective_id`, `fh`, `fhb`, `pres`, `plan`) VALUES
(1, 68, NULL, NULL, NULL, 1, '2024-05-25', 0, 1, '2', '3', 'test', 'test'),
(2, 149, NULL, NULL, NULL, 1, '2024-05-27', 0, 2, '10', '10', '10', 'Buros'),
(3, 239, NULL, NULL, NULL, 1, '2024-05-28', 0, 3, '', '', '', ''),
(4, 242, NULL, NULL, NULL, 1, '2024-05-28', 0, 4, '', '', '', ''),
(5, 243, NULL, NULL, NULL, 1, '2024-05-29', 0, 5, '', '', '', ''),
(6, 218, NULL, NULL, NULL, 1, '2024-05-30', 0, 6, '', '', '', '');

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
(1, '40', '3', '2022-05-31', 'Home', '1', '2', '1', '1', '1', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 68, 1),
(2, '10/02/2024', '24', '2024-03-21', 'Hospital', '1', '2', '1', '1', '1', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 149, 2),
(3, '5-14-24', '25', '2022-05-22', 'Home', '', '', '', '', '', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 239, 3),
(4, '', '', '2022-03-03', 'Home', '2017', '', '', '', '', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 242, 4),
(5, '', '17', '2023-04-14', 'Home', '2', '1', '', '', '', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 243, 5),
(6, '5302024', '14', '2024-05-23', 'Hospital', '2', '1', '0', '0', '0', 'Yes', 'No', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 218, 6);

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
  `lmp` date DEFAULT NULL,
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
  `status` varchar(255) NOT NULL,
  `steps` varchar(255) NOT NULL,
  `trimester` varchar(255) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `hbsag` varchar(255) NOT NULL,
  `rbs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_subjective`
--

INSERT INTO `prenatal_subjective` (`id`, `height`, `weight`, `temperature`, `pr`, `rr`, `bp`, `menarche`, `lmp`, `gravida`, `para`, `fullterm`, `preterm`, `abortion`, `stillbirth`, `alive`, `hgb`, `ua`, `vdrl`, `forceps_delivery`, `smoking`, `allergy_alcohol_intake`, `previous_cs`, `consecutive_miscarriage`, `ectopic_pregnancy_h_mole`, `pp_bleeding`, `baby_weight_gt_4kgs`, `asthma`, `goiter`, `premature_contraction`, `obesity`, `heart_disease`, `patient_id`, `checkup_date`, `doctor_id`, `nurse_id`, `dm`, `is_deleted`, `status`, `steps`, `trimester`, `blood_type`, `hbsag`, `rbs`) VALUES
(1, '163', '60', '35', '119', '90', '118', '16', '2024-04-30', '3', '3', '2', '1', '0', '0', '3', '11', '2', '0', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 68, '2024-05-25', NULL, 1, 'Yes', 0, 'Pending', 'Prenatal', '1st Trimister', 'O+', '3', ''),
(2, '55', '55', '90', '180', '90', '180', '12', '2023-10-01', '1', '1', '1', '1', '1', '1', '1', '12', '1', '1:14', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 149, '2024-05-27', NULL, 1, 'No', 0, 'Progress', 'Prenatal', '1st Trimister', 'A+', '8', ''),
(3, '163', '61', '36', '113', '12', '113', '14', '2024-05-20', '4', '4', '4', '0', '0', '0', '4', '12', '10-15', '0', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 239, '2024-05-28', NULL, 1, 'No', 0, 'Pending', 'Prenatal', '', 'O+', '1', ''),
(4, '159', '58', '36', '112', '13', '90/70', '14', '2024-05-18', '7', '6', '6', '0', '1', '0', '6', '12', '10', '1:21', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 242, '2024-05-28', NULL, 1, 'No', 0, 'Pending', 'Abortion', '', 'AB+', '2', ''),
(5, '163', '62', '36', '115', '14', '113', '14', '2024-05-19', '2', '2', '2', '0', '0', '0', '0', '12', '', '111', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 243, '2024-05-29', NULL, 1, 'Yes', 0, 'Pending', 'Prenatal', '', 'AB+', '4', '140'),
(6, '149', '57', '36', '90', '14', '12080', '14', '2024-05-22', '2', '2', '2', '0', '0', '0', '2', '11', '6', '1', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 218, '2024-05-30', NULL, 1, 'Yes', 0, 'Progress', 'Prenatal', '', 'AB+', '2', '120');

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `id` int(11) NOT NULL,
  `step` varchar(255) NOT NULL,
  `patient_id` int(255) NOT NULL
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
(1, 'Joemari', 'Obrial', '2002-10-21', 'Zone 12 Bulua Cagayan De Oro City', 41, 0, 0),
(2, 'Shan', 'Gorra', '2002-05-15', 'CDO', 45, 0, 0),
(3, 'VenzJan', 'Cabonegro', '2003-05-07', 'CDO', 46, 0, 0),
(4, 'ErnestDale', 'Carton', '2002-05-15', 'CDO', 47, 0, 0);

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
(1, 'Gary', 'Punzalan', '1999-05-10', 'CDO', 42, 0, 0);

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
(3, 'admin', '$2y$10$OczSRYyRvk77EFwstCquKu6kowFz7NYN8tg6h04WPIQ8bUYMQSFL2', 'admin', 0, 0, 'joub.obrial.coc@phinmaed.com'),
(41, 'Staff', '$2y$10$6AoQc8yD9BbROucPM4eqeuc98HHc/5YpYKVk1vbR8tcYvZk9aTiq.', 'staff', 0, 0, 'joemariobrial54@gmail.com'),
(42, 'doctor', '$2y$10$zLd14.C4jtxztNPj.kbqneYxyqIUcQzEi2kfsq04l8TyvyzZZgRSa', 'superadmin', 0, 0, 'jamesmatthewobrial@gmail.com'),
(43, 'Nurse', '$2y$10$1iqBl07yzvjG3HCB6FBeIeGQjebAHJ0R1AVoxMRXEYElS1S3kHy3y', 'nurse', 0, 0, 'jobrial90242@liceo.edu.ph'),
(44, 'Midwife', '$2y$10$ptGU30xcDIfaQsLI82G0OuEuz2Wy5dFfSaAZei0IcvDhPj9l7AgKW', 'midwife', 0, 0, 'joda.orencio.coc@phinmaed.com'),
(45, 'Shan', '$2y$10$OPkaODVrZu0x5K4CCZDYUO0T/Y0DKVrbMMkX3P3t0BVwnOkxse.Mq', 'staff', 0, 0, 'shawngorra@gmail.com'),
(46, 'Venz', '$2y$10$6m/xzMupf.ucCSJTYAmvXeec/FC80qPvnF9tT0W4J4fGEBkjua/yq', 'staff', 0, 0, 'veac.cabonegro.coc@phinmaed.com'),
(47, 'Ernest', '$2y$10$MaBE/AxtbQaxItuHAOAi.uGqJS2j5DupEjQDg/Gh58a1ld0ogcl4K', 'staff', 0, 0, 'sample@gmail.com'),
(48, 'asiac240525', '$2y$10$9.GLUt.pgaoDcmke0NFJOOr5mDI3kHZ.kpCvV8YdH9W4Ls3F7vCwq', 'nurse', 0, 0, 'aldousdespair@gmail.com'),
(49, 'Midwife2', '$2y$10$bwVq2XkOxbnMUO3H9fxXR.Cknp93fLHXyHDncf0cH29bywYZTlw1q', 'midwife', 0, 0, 'feeg.pagaran.coc@phinmaed.com');

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
-- Indexes for table `children`
--
ALTER TABLE `children`
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
-- Indexes for table `process`
--
ALTER TABLE `process`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `family_plannings`
--
ALTER TABLE `family_plannings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_consultation`
--
ALTER TABLE `fp_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `fp_information`
--
ALTER TABLE `fp_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `fp_medical_history`
--
ALTER TABLE `fp_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `fp_obstetrical_history`
--
ALTER TABLE `fp_obstetrical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `fp_physical_examination`
--
ALTER TABLE `fp_physical_examination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `fp_risk_for_sexuality`
--
ALTER TABLE `fp_risk_for_sexuality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `fp_risk_for_violence_against_women`
--
ALTER TABLE `fp_risk_for_violence_against_women`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `immunization`
--
ALTER TABLE `immunization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT for table `midwife`
--
ALTER TABLE `midwife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `prenatal`
--
ALTER TABLE `prenatal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_consultation`
--
ALTER TABLE `prenatal_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prenatal_diagnosis`
--
ALTER TABLE `prenatal_diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

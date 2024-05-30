-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 05:17 AM
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
-- Database: `brgy_db`
--

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
  `hbsag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_subjective`
--

INSERT INTO `prenatal_subjective` (`id`, `height`, `weight`, `temperature`, `pr`, `rr`, `bp`, `menarche`, `lmp`, `gravida`, `para`, `fullterm`, `preterm`, `abortion`, `stillbirth`, `alive`, `hgb`, `ua`, `vdrl`, `forceps_delivery`, `smoking`, `allergy_alcohol_intake`, `previous_cs`, `consecutive_miscarriage`, `ectopic_pregnancy_h_mole`, `pp_bleeding`, `baby_weight_gt_4kgs`, `asthma`, `goiter`, `premature_contraction`, `obesity`, `heart_disease`, `patient_id`, `checkup_date`, `doctor_id`, `nurse_id`, `dm`, `is_deleted`, `status`, `steps`, `trimester`, `blood_type`, `hbsag`) VALUES
(1, '163', '60', '35', '119', '90', '118', '16', '2024-04-30', '3', '3', '2', '1', '0', '0', '3', '11', '2', '0', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 68, '2024-05-25', NULL, 1, 'Yes', 0, 'Pending', 'Prenatal', '1st Trimister', 'O+', '3'),
(2, '55', '55', '90', '180', '90', '180', '12', '2023-10-01', '1', '1', '1', '1', '1', '1', '1', '12', '1', '1:14', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 149, '2024-05-27', NULL, 1, 'No', 0, 'Progress', 'Prenatal', '1st Trimister', 'A+', '8'),
(3, '163', '61', '36', '113', '12', '113', '14', '2024-05-20', '4', '4', '4', '0', '0', '0', '4', '12', '10-15', '0', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 239, '2024-05-28', NULL, 1, 'No', 0, 'Pending', 'Prenatal', '', 'O+', '1'),
(4, '159', '58', '36', '112', '13', '90/70', '14', '2024-05-18', '7', '6', '6', '0', '1', '0', '6', '12', '10', '1:21', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 242, '2024-05-28', NULL, 1, 'No', 0, 'Pending', 'Abortion', '', 'AB+', '2'),
(5, '163', '62', '36', '115', '14', '113', '14', '2024-05-19', '2', '2', '2', '0', '0', '0', '0', '12', '', '1:11', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 243, '2024-05-29', NULL, 1, 'No', 0, 'Pending', 'Prenatal', '', 'AB+', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prenatal_subjective`
--
ALTER TABLE `prenatal_subjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

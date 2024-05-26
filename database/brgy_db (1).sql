-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 02:34 AM
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
(4, 'login', '2024-05-26', '08:23:43', 3);

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
(1, 'AthenaMae', 'Fajardo', '2000-08-06', 'CDo', 44, 0, 0);

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
(1, 'Jeelyn', 'Reyes', '2001-09-12', 'CDO', 43, 0, 0);

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
  `blood_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Joemari', 'Obrial', '2002-10-21', 'Zone12BuluaCagayanDeOroCity', 41, 0, 0);

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
(3, 'admin', '$2y$10$OczSRYyRvk77EFwstCquKu6kowFz7NYN8tg6h04WPIQ8bUYMQSFL2', 'admin', 0, 0, 'joemariobrial54@gmail.com'),
(41, 'Staff', '$2y$10$F530/Nc.lzs/53aX8LgPMep11x1bby.77q9h2mwobtQfYeaGa7MUS', 'staff', 0, 0, 'joemariobrial54@gmail.com'),
(42, 'Doctor', '$2y$10$Dn.lZCwAd6JEj6GlAWatquygThRYhakrWKFD6/0AVuO5lqNCzmcI.', 'superadmin', 0, 0, 'joub.obrial.coc@phinmaed.com'),
(43, 'Nurse', '$2y$10$gWqWGCGrVNIuO62Z6w.8DuPlV3W9I5jdsz/hi0kv81p4aLo/aGiJi', 'nurse', 0, 0, 'sample@gmail.com'),
(44, 'Midwife', '$2y$10$.s9miRrMqjRdtVniXUA9J.1l9/3hMrOWv7XP2WHWtfliMsRx9Xjuy', 'midwife', 0, 0, 'sample@gmail.com');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `midwife`
--
ALTER TABLE `midwife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `superadmins`
--
ALTER TABLE `superadmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

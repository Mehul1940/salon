-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 06:28 PM
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
-- Database: `mainclinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `case_type` enum('new','old') NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `status` enum('confirm','pending','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `dept_id`, `schedule_id`, `date`, `time`, `case_type`, `charge`, `status`, `created_at`, `reason`) VALUES
(14, 52, 32, 19, 37, '2025-03-27', '10:00:00', 'new', 1000.00, 'pending', '2025-03-26 19:15:27', ' pain  that makes daily activities difficult.'),
(16, 53, 33, 20, 38, '2025-03-28', '14:15:00', 'new', 1000.00, 'pending', '2025-03-26 19:22:16', 'Ear pain'),
(17, 54, 30, 17, 34, '2025-03-28', '13:25:00', 'new', 1000.00, 'pending', '2025-03-26 19:24:04', '...'),
(18, 55, 31, 18, 36, '2025-03-28', '15:20:00', 'new', 1000.00, 'pending', '2025-03-26 19:25:57', 'my son has a bad stomach '),
(19, 56, 34, 22, 39, '2025-03-29', '15:30:00', 'new', 1000.00, 'pending', '2025-03-26 19:27:28', 'hair loss'),
(20, 52, 30, 17, 34, '2025-03-28', '00:43:00', 'old', 500.00, 'pending', '2025-03-27 05:15:01', 'cold ');

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `bed_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `bed_number` int(11) NOT NULL,
  `status` enum('Available','Occupied') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`bed_id`, `room_id`, `bed_number`, `status`) VALUES
(18, 25, 101, 'Available'),
(19, 26, 102, 'Available'),
(20, 26, 103, 'Available'),
(21, 26, 104, 'Available'),
(22, 26, 105, 'Occupied'),
(23, 26, 106, 'Available'),
(24, 27, 106, 'Available'),
(25, 28, 109, 'Available'),
(26, 28, 110, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `name`) VALUES
(17, 'general surgon '),
(18, 'Genral physician'),
(19, 'Orthopedics'),
(20, 'ENT specialists'),
(21, 'Cardiology'),
(22, 'Dermatology');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `password` varchar(255) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `charge` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `name`, `address`, `phone_no`, `email_id`, `dob`, `gender`, `password`, `qualification`, `dept_id`, `charge`) VALUES
(30, 'masum patel', 'ahmedabad', '8674018524', 'masum12@gmail.com', '1980-06-04', 'Male', '$2y$10$cDUNUSjjafBZ7kd/3MwfleuWSJoppyUunMm2D8GFjpTNkwkIhBs4K', 'BHMS', 17, 1500.00),
(31, 'DR PRIYA SHARMA', ' 401 YOGI VILLA AHMEDABAD', '6335353540', 'priyasharma12@gmail.com', '1981-02-04', 'Female', '$2y$10$dZAS.o4LwSJSYbzJeyIIuOWvNNqY/wlkFgW6XerGTzs0AaVWWbdsm', 'MBBS, DCH', 18, 2499.96),
(32, 'DR RAJESHKUMAR', '14 vedant skyline vastral ahmedabad', '9016437252', 'rajesh0015@gmail.com', '1982-10-26', 'Male', '$2y$10$qrSHFf3NWYUCUTyVlEWfaeNyNgN3pd4wkpK64frll05hRV8FoTZa2', 'MBBS, MS (Orthopedics)', 19, 3000.00),
(33, 'DR NEHA GUPTA', ' 50 puravdeep soc ctm ahmedabad', '9898892889', 'neha420@gmail.com', '1984-05-26', 'Female', '$2y$10$46q0AQpfIslTiAeJ.VVMPu5g3.k4l3tHd3YEXffRrfb4IRL00E8We', 'MBBS ,MS', 20, 4000.00),
(34, 'DR SUMIT REDDY', 'ahmedabad ', '8674018526', 'sumit268@gmail.com', '1990-05-25', 'Male', '$2y$10$MXg1UEGP5xtDVNmoqUSqweYQJ1Rx21wFcXnvniBGdiiE2JKGXnx1q', 'MBBS, DDVL', 22, 2500.00),
(35, 'Dr. Amit Joshi', ' 12 bapasita ram soc ahmedabad', '7508502503', 'amit125@gmail.com', '1981-09-25', 'Male', '$2y$10$RsJdXhEfJd50GswGoHGCAujYj51zyH0tGQnMD/vT13oHYcN1HXnAC', 'MBBS, MD', 21, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `schedule_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `day` varchar(50) NOT NULL,
  `d_ipd_time` time NOT NULL,
  `d_opd_time` time NOT NULL,
  `shift` enum('Morning','Afternoon','Evening','Night') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`schedule_id`, `doctor_id`, `start_time`, `end_time`, `day`, `d_ipd_time`, `d_opd_time`, `shift`) VALUES
(34, 30, '06:00:00', '16:00:00', 'monday to sunday', '06:05:00', '09:00:00', 'Afternoon'),
(35, 31, '10:00:00', '18:00:00', 'monday to wednesday', '10:05:00', '12:05:00', 'Evening'),
(36, 31, '12:05:00', '22:00:00', 'thusday to sunday', '12:05:00', '13:01:00', 'Night'),
(37, 32, '08:00:00', '20:00:00', 'monday to sunday', '08:10:00', '10:10:00', 'Night'),
(38, 33, '12:00:00', '20:15:00', 'monday to saturday', '12:10:00', '14:15:00', 'Night'),
(39, 34, '13:15:00', '22:30:00', 'monday to sunday', '13:20:00', '16:05:00', 'Night'),
(40, 35, '14:00:00', '23:15:00', 'monday to sunday', '14:15:00', '16:15:00', 'Night');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `star` int(11) DEFAULT NULL CHECK (`star` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`f_id`, `name`, `email_id`, `description`, `star`) VALUES
(4, 'Ashwin patel', 'ashwin@gmail.com', 'good service', 5),
(5, 'Nita shah', 'nita@gmail.com', '\\\"The clinic was spotless and well-maintained. The waiting area was comfortable, and all safety protocols were followed. I felt safe and at ease throughout my visit.\\\"', 5),
(6, 'kashyap', 'kp@gmail.com', 'Booking an appointment was quick and easy. I didn’t have to wait long, and the staff ensured a seamless experience. Highly efficient service!\\\"', 4),
(7, 'Mahi patel', 'mh@gmail.com', 'The medical care was excellent, but the waiting time was a bit longer than expected. It would be great if appointment scheduling could be optimized further.', 5),
(8, 'pooja patel', 'pooja@gmail.com', '\\\"While the bed was functional, the mattress felt a bit firm. A softer option would have made resting more comfortable.\\\"', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `treatment_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `room_charge_per_day` decimal(10,2) NOT NULL DEFAULT 0.00,
  `admission_date` date NOT NULL,
  `total_days` int(11) GENERATED ALWAYS AS (to_days(`discharge_date`) - to_days(`admission_date`)) STORED,
  `discharge_date` date NOT NULL,
  `test_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `medicine_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doctor_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `appointment_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `gst` decimal(5,2) NOT NULL DEFAULT 18.00,
  `total_amount` decimal(10,2) GENERATED ALWAYS AS (`room_charge_per_day` * `total_days` + `treatment_charge` + `test_charge` + `medicine_charge` + `doctor_charge` + `appointment_charge`) STORED,
  `final_amount` decimal(10,2) GENERATED ALWAYS AS (`total_amount` + `total_amount` * `gst` / 100 - `total_amount` * `discount` / 100) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipd`
--

CREATE TABLE `ipd` (
  `ipd_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `treatment_id` int(11) NOT NULL,
  `roomtype_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `admission_date` date NOT NULL,
  `status` enum('Admitted','Discharged') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `discharge_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ipd`
--

INSERT INTO `ipd` (`ipd_id`, `patient_id`, `doctor_id`, `treatment_id`, `roomtype_id`, `room_id`, `bed_id`, `test_id`, `medicine_id`, `admission_date`, `status`, `notes`, `discharge_date`) VALUES
(12, 25, 31, 12, 12, 26, 22, 5, 46, '2025-03-30', NULL, 'fssffd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `medicine_type` varchar(100) NOT NULL,
  `advice` text DEFAULT NULL,
  `manufacturing_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `power` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `medicine_name`, `medicine_type`, `advice`, `manufacturing_date`, `expire_date`, `power`, `company_id`) VALUES
(46, 'Paracetamol', 'Tablet', 'Take after meals', '2025-03-27', '2028-06-01', '500mg', 6),
(47, 'Ibuprofen', 'Capsule', 'Avoid on empty stomach', '2023-12-05', '2025-12-05', '400mg', 6),
(48, 'Amoxicillin', 'Tablet', 'Complete full course', '2024-02-20', '2026-02-20', '250mg', 7),
(49, 'Ciprofloxacin', 'Syrup', 'Shake well before use', '2024-03-15', '2026-03-15', '100mg', 8),
(50, 'Metformin', 'Tablet', 'Take before meals', '2024-04-01', '2026-04-01', '850mg', 9),
(51, 'Cetirizine', 'Tablet', 'May cause drowsiness', '2023-11-30', '2025-11-30', '10mg', 10),
(52, 'Aspirin', 'Tablet', 'Take with water', '2024-05-12', '2026-05-12', '325mg', 11),
(53, 'Prednisone', 'Tablet', 'Do not stop suddenly', '2023-10-20', '2025-10-20', '5mg', 12),
(54, 'Omeprazole', 'Capsule', 'Take before breakfast', '2024-06-05', '2026-06-05', '20mg', 13),
(55, 'Losartan', 'Tablet', 'Take at the same time daily', '2023-09-18', '2025-09-18', '50mg', 10),
(56, 'Paracetamol', 'Tablet', 'Take after meals', '2024-01-10', '2026-01-10', '500mg', 6),
(57, 'Ibuprofen', 'Capsule', 'Avoid on empty stomach', '2023-12-05', '2025-12-05', '400mg', 7),
(58, 'Amoxicillin', 'Tablet', 'Complete full course', '2024-02-20', '2026-02-20', '250mg', 8),
(59, 'Ciprofloxacin', 'Syrup', 'Shake well before use', '2024-03-15', '2026-03-15', '100mg', 9),
(60, 'Metformin', 'Tablet', 'Take before meals', '2024-04-01', '2026-04-01', '850mg', 10),
(61, 'Cetirizine', 'Tablet', 'May cause drowsiness', '2023-11-30', '2025-11-30', '10mg', 6),
(62, 'Aspirin', 'Tablet', 'Take with water', '2024-05-12', '2026-05-12', '325mg', 7),
(63, 'Prednisone', 'Tablet', 'Do not stop suddenly', '2023-10-20', '2025-10-20', '5mg', 8),
(64, 'Omeprazole', 'Capsule', 'Take before breakfast', '2024-06-05', '2026-06-05', '20mg', 9),
(65, 'Losartan', 'Tablet', 'Take at the same time daily', '2023-09-18', '2025-09-18', '50mg', 10),
(66, 'Atorvastatin', 'Tablet', 'Take at night', '2024-02-25', '2026-02-25', '10mg', 11),
(67, 'Doxycycline', 'Capsule', 'Avoid sunlight exposure', '2023-11-15', '2025-11-15', '100mg', 12),
(68, 'Ranitidine', 'Tablet', 'Take before meals', '2024-03-20', '2026-03-20', '150mg', 13),
(69, 'Levothyroxine', 'Tablet', 'Take on an empty stomach', '2023-10-30', '2025-10-30', '50mcg', 14),
(70, 'Hydroxychloroquine', 'Tablet', 'Take with food', '2024-05-05', '2026-05-05', '200mg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_companies`
--

CREATE TABLE `medicine_companies` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `established_year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_companies`
--

INSERT INTO `medicine_companies` (`company_id`, `company_name`, `address`, `phone`, `email`, `established_year`) VALUES
(6, 'Gujarat Meditech', '45, Science Park, Ahmedabad', '9087654321', 'contact@gujmeditech.in', '2015'),
(7, 'Zydus Healthcare', 'SG Highway, Ahmedabad', '9123456789', 'info@zydushealth.com', '2003'),
(8, 'Sun Pharma', 'Ashram Road, Ahmedabad', '9012345678', 'support@sunpharma.com', '1995'),
(9, 'Cadila Pharmaceuticals', 'GIDC Estate, Ahmedabad', '9112233445', 'info@cadilapharma.com', '1979'),
(10, 'Torrent Pharma', 'Bhat, Gandhinagar-Ahmedabad', '9223344556', 'support@torrentpharma.com', '1959'),
(11, 'Intas Pharmaceuticals', 'Chacharwadi, Ahmedabad', '9334455667', 'info@intaspharma.com', '1984'),
(12, 'Claris Lifesciences', 'Changodar, Ahmedabad', '9445566778', 'contact@clarislife.com', '2001'),
(13, 'Alembic Pharmaceuticals', 'Alembic Road, Vadodara (Near Ahmedabad)', '9556677889', 'info@alembicpharma.com', '1907'),
(14, 'Lincoln Pharmaceuticals', 'Bavla, Ahmedabad', '9667788990', 'support@lincolnpharma.com', '1979');

-- --------------------------------------------------------

--
-- Table structure for table `opd_registration`
--

CREATE TABLE `opd_registration` (
  `opd_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `consultant_doctor` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `pulse_rate` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `height` float NOT NULL,
  `bp` varchar(10) NOT NULL,
  `weight` float NOT NULL,
  `allergies` text DEFAULT NULL,
  `warnings` text DEFAULT NULL,
  `past_medical_history` text DEFAULT NULL,
  `visit_type` enum('New','Follow-Up') NOT NULL DEFAULT 'New',
  `diagnosis` text DEFAULT NULL,
  `treatment_plan` text DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opd_registration`
--

INSERT INTO `opd_registration` (`opd_id`, `patient_id`, `consultant_doctor`, `dept_id`, `pulse_rate`, `temperature`, `height`, `bp`, `weight`, `allergies`, `warnings`, `past_medical_history`, `visit_type`, `diagnosis`, `treatment_plan`, `registration_date`) VALUES
(16, 23, 30, 17, 70, 36.1, 150, '70/80', 75, 'no', 'no', 'no', 'New', 'Hypertension', 'Lifestyle changes and medication', '2025-03-26 20:15:45'),
(17, 24, 31, 18, 80, 36, 140, '70/80', 55, 'none', 'none', 'Regular health checkups', 'Follow-Up', 'Routine Checkup', 'General advice', '2025-03-26 20:17:08'),
(18, 24, 32, 19, 80, 36, 140, '70/80', 55, 'none', 'none', 'none', 'Follow-Up', 'knee pain', 'General advice', '2025-03-26 20:17:41'),
(19, 25, 32, 19, 80, 36, 140, '70/80', 55, 'none', 'none', 'none', 'Follow-Up', 'leg pain', 'General advice', '2025-03-26 20:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `age` int(11) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `name`, `phone_number`, `email_id`, `dob`, `gender`, `weight`, `age`, `address`, `password`, `blood_group`) VALUES
(23, 'Ashwin patel', '9998897542', 'ashwin@gmail.com', '2000-01-05', 'Male', 65.00, 25, 'b-149 havan plazz nikol road ahmedbad', '$2y$10$vaddxW6z2.2dsGDCOoj73.lR3tKbc7NOMvSzUPOteLZcf2XHSiPKa', 'A+'),
(24, 'Nita shah', '9016437222', 'nita22@gmail.com', '1990-01-29', 'Male', 60.00, 35, '35 shree ram soc krishnager road ahmedbad', '$2y$10$EeYvy/YARrAMqVjFJuCEMO/fl.BH6tNNNT5XtE04ZoJpqZEZ/2oEe', 'A-'),
(25, 'kashyap panchal', '6355436680', 'kashyap420@gmail.com', '2000-01-27', 'Male', 80.00, 25, ' A-1 puspak recidency vastral ahmedbad', '$2y$10$r4LCObqv0bDn0aFEt/jxuuZwcGqFVp.xK/JeDWp8fXxohgvyNa4eS', 'AB-'),
(26, 'Mahi patel', '7415235693', 'mahi07@gmail.com', '2005-11-26', 'Female', 50.00, 21, '  Nand bag banglow  nava naroda ahmedbad', '$2y$10$0EIxq6LHXa9..iD1VUacFOKXkGLnOtbifxiK73qLy9cNrt2neK8sa', 'A+'),
(27, 'pooja patel', '8475854232', 'pooja@gmail.com', '1985-01-24', 'Female', 55.00, 40, 'B-142 Hari darshan park soc  ahmedabad', '$2y$10$ZfENU1gy9RRg0NsQGfXb4O96tajW0OOxyexzaKwIurRukrQWpeXcS', 'AB+');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `prescription_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `roomtype_id` int(11) NOT NULL,
  `room_no` varchar(10) NOT NULL,
  `no_of_beds` int(11) NOT NULL,
  `occupied_beds` int(11) NOT NULL DEFAULT 0,
  `room_charge` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `roomtype_id`, `room_no`, `no_of_beds`, `occupied_beds`, `room_charge`) VALUES
(25, 9, '1', 1, 0, 15000.00),
(26, 11, '2', 5, 1, 2500.00),
(27, 12, '3', 1, 0, 10000.00),
(28, 13, '4', 2, 0, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `roomtype_id` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`roomtype_id`, `room_type`, `description`) VALUES
(9, 'icu room', '24/7 Monitoring: Continuous tracking of vital signs like heart rate, blood pressure, oxygen levels, and respiratory function'),
(11, 'genral', ' shared room with multiple beds, usually divided by curtains.'),
(12, 'Deluxe Room', 'Includes a private bathroom, personal TV, lounge area, and sometimes a personal nurse.\r\n'),
(13, 'Semi-Private Room', 'Shared by two patients, separated by a curtain or partition.bhvgg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `staff_postid` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `password` varchar(255) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `staff_postid`, `address`, `phone`, `email_id`, `dob`, `gender`, `password`, `qualification`, `salary`) VALUES
(7, 'nalin patel', 7, 'vastral', '8585456523', 'nalin123@gmail.com', '1989-05-27', 'Male', '$2y$10$5MJM.RXwUw9GfQXDgeC4VOSU97IJ397b6xFa5TIHZXkNgkRUNiXMm', '12pass', 15000.00),
(8, 'vaishali patel', 6, 'nikol ', '8200252122', 'vaishali1234@gmail.com', '2000-01-26', 'Female', '$2y$10$ZbwDzLdxYJjG4dx2PXaQOOEJiLgFGqfMguDI11pZvaki0OETpJtjW', 'bsc nursing', 20000.00),
(9, 'vaibhav ', 8, 'ctm', '8200250060', 'vp@gmail.com', '1984-01-26', 'Male', '$2y$10$QfN./I.XiDlJnxHtAOsFnuBfMkUszL0M9nQv56euo58lH2wg7jmR.', 'b.com', 21000.00),
(10, 'hani ', 9, 'vastral', '6352525635', 'hani@gmail.com', '1990-09-20', 'Female', '$2y$10$soqTcLelr.zF3E99eeEXSOLmrlmIhDvJzLRSK6ZGEWZYsR0NIe8PS', 'bsc nursing', 25000.00),
(11, 'pooja ', 6, 'wonder point', '8585869885', 'pooja125@gmail.com', '2000-05-26', 'Female', '$2y$10$uwEJ4dsiqf9ZHHUlXuYXdOTPk7fEBxEkD2R1lhGNKakhOIJxdVMoG', 'bsc nursing', 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `staff_posts`
--

CREATE TABLE `staff_posts` (
  `post_id` int(11) NOT NULL,
  `post` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_posts`
--

INSERT INTO `staff_posts` (`post_id`, `post`) VALUES
(6, 'nurse'),
(7, 'compounder'),
(8, 'recipientent'),
(9, 'senior nurse');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `charge` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_name`, `description`, `charge`) VALUES
(5, 'blood', 'blood test', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `treatment_id` int(11) NOT NULL,
  `treatment_name` varchar(255) NOT NULL,
  `treatment_description` text NOT NULL,
  `treatment_charge` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`treatment_id`, `treatment_name`, `treatment_description`, `treatment_charge`) VALUES
(12, 'snik care', 'abc ', 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(43, 'admin', 'admin@gmail.com', 'admin123', 'admin'),
(52, 'Ashwin patel', 'ashwin@gmail.com', '$2y$10$cC/f5zer0AqY5xKn32BeBuCdYWlP8Tiuonfw1dppUxUS3qr3yNrW6', 'patient'),
(53, 'Nita shah', 'nita22@gmail.com', '$2y$10$EeYvy/YARrAMqVjFJuCEMO/fl.BH6tNNNT5XtE04ZoJpqZEZ/2oEe', 'patient'),
(54, 'kashyap panchal', 'kashyap420@gmail.com', '$2y$10$r4LCObqv0bDn0aFEt/jxuuZwcGqFVp.xK/JeDWp8fXxohgvyNa4eS', 'patient'),
(55, 'Mahi patel', 'mahi07@gmail.com', '$2y$10$0EIxq6LHXa9..iD1VUacFOKXkGLnOtbifxiK73qLy9cNrt2neK8sa', 'patient'),
(56, 'pooja patel', 'pooja@gmail.com', '$2y$10$ZfENU1gy9RRg0NsQGfXb4O96tajW0OOxyexzaKwIurRukrQWpeXcS', 'patient'),
(57, 'masum patel', 'masum12@gmail.com', '$2y$10$cDUNUSjjafBZ7kd/3MwfleuWSJoppyUunMm2D8GFjpTNkwkIhBs4K', 'doctor'),
(58, 'DR PRIYA SHARMA', 'priyasharma12@gmail.com', '$2y$10$dZAS.o4LwSJSYbzJeyIIuOWvNNqY/wlkFgW6XerGTzs0AaVWWbdsm', 'doctor'),
(59, 'DR RAJESHKUMAR', 'rajesh0015@gmail.com', '$2y$10$qrSHFf3NWYUCUTyVlEWfaeNyNgN3pd4wkpK64frll05hRV8FoTZa2', 'doctor'),
(60, 'DR NEHA GUPTA', 'neha420@gmail.com', '$2y$10$46q0AQpfIslTiAeJ.VVMPu5g3.k4l3tHd3YEXffRrfb4IRL00E8We', 'doctor'),
(61, 'DR SUMIT REDDY', 'sumit268@gmail.com', '$2y$10$MXg1UEGP5xtDVNmoqUSqweYQJ1Rx21wFcXnvniBGdiiE2JKGXnx1q', 'doctor'),
(62, 'Dr. Amit Joshi', 'amit125@gmail.com', '$2y$10$RsJdXhEfJd50GswGoHGCAujYj51zyH0tGQnMD/vT13oHYcN1HXnAC', 'doctor'),
(63, 'nalin patel', 'nalin123@gmail.com', '$2y$10$5MJM.RXwUw9GfQXDgeC4VOSU97IJ397b6xFa5TIHZXkNgkRUNiXMm', 'staff'),
(64, 'vaishali patel', 'vaishali1234@gmail.com', '$2y$10$ZbwDzLdxYJjG4dx2PXaQOOEJiLgFGqfMguDI11pZvaki0OETpJtjW', 'staff'),
(65, 'vaibhav ', 'vp@gmail.com', '$2y$10$QfN./I.XiDlJnxHtAOsFnuBfMkUszL0M9nQv56euo58lH2wg7jmR.', 'staff'),
(66, 'hani ', 'hani@gmail.com', '$2y$10$soqTcLelr.zF3E99eeEXSOLmrlmIhDvJzLRSK6ZGEWZYsR0NIe8PS', 'staff'),
(67, 'pooja ', 'pooja125@gmail.com', '$2y$10$uwEJ4dsiqf9ZHHUlXuYXdOTPk7fEBxEkD2R1lhGNKakhOIJxdVMoG', 'staff'),
(68, 'Virat  mehta', 'virat78@gmail.com', '$2y$10$0fP4VgyJpST6wO9jvxoY1u7B5k3qqHuZobgS4nhmG1E3DGTp.77Tu', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`bed_id`),
  ADD UNIQUE KEY `room_id` (`room_id`,`bed_number`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `email_id` (`email_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `ipd`
--
ALTER TABLE `ipd`
  ADD PRIMARY KEY (`ipd_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `treatment_id` (`treatment_id`),
  ADD KEY `roomtype_id` (`roomtype_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `bed_id` (`bed_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `medicine_companies`
--
ALTER TABLE `medicine_companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `opd_registration`
--
ALTER TABLE `opd_registration`
  ADD PRIMARY KEY (`opd_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `consultant_doctor` (`consultant_doctor`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_no` (`room_no`),
  ADD KEY `roomtype_id` (`roomtype_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`roomtype_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email_id` (`email_id`),
  ADD KEY `staff_postid` (`staff_postid`);

--
-- Indexes for table `staff_posts`
--
ALTER TABLE `staff_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`treatment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `bed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipd`
--
ALTER TABLE `ipd`
  MODIFY `ipd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `medicine_companies`
--
ALTER TABLE `medicine_companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `opd_registration`
--
ALTER TABLE `opd_registration`
  MODIFY `opd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `roomtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff_posts`
--
ALTER TABLE `staff_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`schedule_id`) REFERENCES `doctor_schedule` (`schedule_id`) ON DELETE CASCADE;

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD CONSTRAINT `doctor_schedule_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `ipd`
--
ALTER TABLE `ipd`
  ADD CONSTRAINT `ipd_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `ipd_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`),
  ADD CONSTRAINT `ipd_ibfk_3` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`treatment_id`),
  ADD CONSTRAINT `ipd_ibfk_4` FOREIGN KEY (`roomtype_id`) REFERENCES `room_types` (`roomtype_id`),
  ADD CONSTRAINT `ipd_ibfk_5` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `ipd_ibfk_6` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`bed_id`),
  ADD CONSTRAINT `ipd_ibfk_7` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`),
  ADD CONSTRAINT `ipd_ibfk_8` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`medicine_id`);

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `medicine_companies` (`company_id`) ON DELETE SET NULL;

--
-- Constraints for table `opd_registration`
--
ALTER TABLE `opd_registration`
  ADD CONSTRAINT `opd_registration_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_registration_ibfk_2` FOREIGN KEY (`consultant_doctor`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_registration_ibfk_3` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`roomtype_id`) REFERENCES `room_types` (`roomtype_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staff_postid`) REFERENCES `staff_posts` (`post_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 06:55 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_index_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$kKvVWpuwxrrM7ioQZDmBFudqZopKwGCWOxmQMP/63f31OpdolIyoe', 'Admin1', 'admin@example.com', '2024-08-30 14:49:12', '2024-09-18 15:14:01'),
(2, 'afroza2002', '$2y$10$ITBYuxou3j.nsDtIk.d8J.qhivSwlsbuxt0z.DyY4irXFH08q4AWy', 'Afroza Asa', 'aaasha2002@gmail.com', '2024-08-30 15:50:01', '2024-08-30 16:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `created_at`, `updated_at`) VALUES
(1, 'CSE', '2024-08-30 16:12:14', '2024-08-30 16:12:14'),
(2, 'EEE', '2024-08-30 16:12:20', '2024-09-18 16:51:18'),
(3, 'TEX', '2024-08-30 16:26:12', '2024-09-18 15:11:28'),
(4, 'ENG', '2024-08-30 19:48:12', '2024-08-30 19:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_code` varchar(40) DEFAULT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_last_donation` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_code`, `full_name`, `date_of_birth`, `date_of_last_donation`, `gender`, `blood_group`, `contact_number`, `email`, `address`, `department_id`, `created_at`, `updated_at`) VALUES
(1, '212010009', 'Afroza Asa', '2002-08-09', '2023-03-25', 'Female', 'AB+', '01770705505', 'aaasha2002@gmail.com', 'Jatrabari, Dhaka', 2, '2024-08-30 16:25:14', '2024-09-18 15:12:44'),
(3, '212010010', 'Zariful Azam', '2001-08-09', '2024-08-09', 'Male', 'O+', '019999999999', 'zariful.azam@gmail.com', 'Donia, Dhaka', 1, '2024-08-30 18:15:03', '2024-08-30 18:55:55'),
(4, '21200000', 'Dipu Moni', '1965-08-09', '2021-08-09', 'Female', 'B-', '01912669325', 'aaasha2002@gmail.com', 'Address2', 1, '2024-08-30 18:48:54', '2024-09-16 15:25:26'),
(5, '2024000000', 'Yeamin Hossen', '2020-09-07', '2020-09-07', 'Male', 'AB-', '019999999999', 'aaasha2002@gmail.com', 'Test Address', 2, '2024-08-30 18:57:05', '2024-08-30 18:57:05'),
(6, '212010090', 'dalia', '2001-08-15', '0000-00-00', 'Female', 'B-', '017000000', 'dalia23@gmail.com', 'mirpur12', 1, '2024-08-30 19:38:57', '2024-08-30 19:38:57'),
(7, '212010025', 'Bidyut', '2005-07-05', '2024-06-06', 'Male', 'A+', '0001234566', 'bidyut@22gmail.com', 'Mohakhali', 1, '2024-09-18 14:46:00', '2024-09-18 14:46:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username_unique` (`username`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `dept_name_unique` (`department_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_code` (`student_code`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

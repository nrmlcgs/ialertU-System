-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 08:27 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ialertu`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `img` text NOT NULL,
  `office` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `lname` text NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `suffix` text NOT NULL,
  `sex` text NOT NULL,
  `birthday` text NOT NULL,
  `province` text NOT NULL,
  `City` text NOT NULL,
  `Barangay` text NOT NULL,
  `mobile_num` text NOT NULL,
  `Zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `email`, `username`, `password`, `img`, `office`, `status`, `lname`, `fname`, `mname`, `suffix`, `sex`, `birthday`, `province`, `City`, `Barangay`, `mobile_num`, `Zip_code`) VALUES
(1, '', 'admin', 'admin', '', 0, 0, '', '', '', '', '', '', '', '', '', '', 0),
(2, '', 'admin2', 'admin2', '', 1, 0, '', '', '', '', '', '', '', '', '', '', 0),
(6, 'castillojohnisaac25@gmail.com', 'Zuck', '2', 'img', 3, 2, 'Castillo', 'John Isaac', 'Fajardo', 'none', 'Male', '12/31/1996', 'Occidental Mindoro', 'Mamburao', 'Payompon', '09759589407', 5106),
(7, 'kagamitaiga871@gmail.com', 'none', '123', 'img', 3, 2, '1', '1', '1', '1', '1', '1 pup', 'sgsv', 'ssss', 'svsvs', '0494975184', 5197);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emergency`
--

CREATE TABLE `tbl_emergency` (
  `id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longtitude` double NOT NULL,
  `location` varchar(500) NOT NULL,
  `name_reporter` varchar(500) NOT NULL,
  `mobile_number` int(11) NOT NULL,
  `accident_type` varchar(500) NOT NULL,
  `num_victims` text NOT NULL,
  `image` longtext NOT NULL,
  `date` text NOT NULL,
  `office` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emergency`
--
ALTER TABLE `tbl_emergency`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_emergency`
--
ALTER TABLE `tbl_emergency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

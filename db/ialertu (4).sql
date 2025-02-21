-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 02:39 PM
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
(10, '', 'zuck', '123', '', 3, 1, '', '', '', '', '', '', '', '', '', '', 0),
(12, 'castillojohnisaac25@gmail.com', 'Hq', 'q', '87944a16a99aecf7f30642820d231cd3.jpg', 3, 0, 'q', 'q', 'q', 'q', 'Male', 'q', 'q', 'q', 'q', '1', 0);

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
-- Dumping data for table `tbl_emergency`
--

INSERT INTO `tbl_emergency` (`id`, `latitude`, `longtitude`, `location`, `name_reporter`, `mobile_number`, `accident_type`, `num_victims`, `image`, `date`, `office`, `status`, `date_updated`) VALUES
(219, 13.268815701845, 120.62120148034, 'Cabiguhan 2, Tangkalan, Mamburao, Occidental Mindoro, Mimaropa, 5103, Philippines', '12', 0, 'House', 'Nearly White', '', '2023-12-08 21:16:49', 1, 1, '2023-12-08 13:25:42'),
(220, 13.221856515525, 120.59735768252, 'San Nicolas Extension, Charot, Payompon, Mamburao, Occidental Mindoro, Mimaropa, 5106, Philippines', '12', 0, 'Restaurant', 'Brown', 'db0f8d4bf58ec7703de4a682ce4cbeac.jpg', '2023-12-08 21:17:25', 1, 0, '2023-12-08 13:17:26'),
(221, 13.221864698356, 120.59736240796, 'San Nicolas Extension, Charot, Payompon, Mamburao, Occidental Mindoro, Mimaropa, 5106, Philippines', '12', 0, 'House', 'Nearly White', '', '2023-12-08 21:28:00', 1, 0, '2023-12-08 13:28:01'),
(222, 13.221860131773, 120.59737752259, 'San Nicolas Extension, Charot, Payompon, Mamburao, Occidental Mindoro, Mimaropa, 5106, Philippines', '12', 0, 'House', 'Nearly White', '', '2023-12-08 21:31:48', 1, 0, '2023-12-08 13:31:49'),
(223, 13.223215605139, 120.59199495856, 'Sambahan Sa Cinco, 14, Villar Street, Barangay 5, Mamburao, Occidental Mindoro, Mimaropa, 5103, Philippines', '12', 0, 'Hospital', 'Nearly White', '', '2023-12-08 21:34:13', 1, 0, '2023-12-08 13:34:14'),
(224, 13.223249895603, 120.5920046873, 'Sambahan Sa Cinco, 14, Villar Street, Barangay 5, Mamburao, Occidental Mindoro, Mimaropa, 5103, Philippines', '12', 0, 'House', 'Nearly White', '', '2023-12-08 21:41:34', 1, 0, '2023-12-08 13:41:35');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_emergency`
--
ALTER TABLE `tbl_emergency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

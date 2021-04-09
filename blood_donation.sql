-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2021 at 08:33 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_donation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `roles` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `roles`) VALUES
(1, 'root'),
(2, 'admin'),
(3, 'supervisor'),
(32, 'helpers'),
(35, 'donators'),
(36, 'first helper');

-- --------------------------------------------------------

--
-- Table structure for table `blood_donors`
--

CREATE TABLE `blood_donors` (
  `id` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `email` char(70) NOT NULL,
  `password` char(50) NOT NULL,
  `phone` int(15) NOT NULL,
  `address` char(70) NOT NULL,
  `image` char(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `roles_id` int(11) NOT NULL,
  `blood_of_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blood_donors`
--

INSERT INTO `blood_donors` (`id`, `name`, `email`, `password`, `phone`, `address`, `image`, `gender`, `roles_id`, `blood_of_type_id`) VALUES
(6, 'Justine Byers', 'likic@mailinator.com', 'Excepteur qui velit', 145646564, 'SU', '1617927159_Img_.png', 'male', 35, 1),
(7, 'Imelda Weeks', 'mudu@mailinator.com', 'Beatae ut quia aut d', 145646780, 'EG', '1617927201_Img_.png', 'male', 35, 2),
(8, 'Madison Lowery', 'lekefi@mailinator.com', 'Inventore ad itaque', 15563111, 'SU', '1617931556_Img_.jpg', 'female', 35, 1),
(9, 'Noble Snider', 'lumu@mailinator.com', 'Deserunt eveniet co', 24564546, 'EG', '1617931696_Img_.jpg', 'female', 35, 2),
(10, 'Christine Hines', 'mela@mailinator.com', 'Non rem eligendi qua', 156456456, 'EG', '1617933210_Img_.jpg', 'female', 35, 2),
(11, 'Uta Morton', 'ciwupibyla@mailinator.com', 'Repellendus Numquam', 456456465, 'SU', '1617935242_Img_.jpg', 'male', 32, 1),
(12, 'Dalton Ashley', 'kehoxipa@mailinator.com', 'Qui culpa nemo id Na', 15645616, 'EG', '1617935415_Img_.jpg', 'female', 36, 2),
(13, 'Herrod Raymond', 'lynufigyx@mailinator.com', 'Commodo est rerum do', 151631563, 'SU', '1617935478_Img_.jpg', 'male', 36, 2),
(14, 'Adham Ahmad', 'adham@gmail.com', 'a123456789', 1280520100, 'EG', '1617983896_Img_.jpg', 'male', 2, 1),
(15, 'Montana Reyes', 'gadapesobo@mailinator.com', '11cc2157b51400ba11af2d006c107db4', 45646565, 'EG', '1617984002_Img_.jpg', 'male', 3, 2),
(16, 'root', 'root@gmail.com', '65a0ec385ca6a0c1e20d1f8270c28303', 1280520100, 'EG', '1617987919_Img_.jpg', 'male', 1, 1),
(17, 'admin', 'admin@gmail.com', '65a0ec385ca6a0c1e20d1f8270c28303', 12345679, 'EG', '1617992082_Img_.jpg', 'male', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `blood_of_types`
--

CREATE TABLE `blood_of_types` (
  `id` int(11) NOT NULL,
  `types` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blood_of_types`
--

INSERT INTO `blood_of_types` (`id`, `types`) VALUES
(1, 'A+'),
(2, 'A-');

-- --------------------------------------------------------

--
-- Table structure for table `donation_date`
--

CREATE TABLE `donation_date` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donor_date`
--

CREATE TABLE `donor_date` (
  `id` int(11) NOT NULL,
  `donation_date_id` int(11) NOT NULL,
  `blood_donor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donor_request`
--

CREATE TABLE `donor_request` (
  `id` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `phone` int(15) NOT NULL,
  `address` char(70) NOT NULL,
  `blood_of_types` char(3) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_blood_donor`
--

CREATE TABLE `request_blood_donor` (
  `id` int(11) NOT NULL,
  `donor_request_id` int(11) NOT NULL,
  `blood_donor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_donors`
--
ALTER TABLE `blood_donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_id` (`roles_id`),
  ADD KEY `blood_of_type_id` (`blood_of_type_id`);

--
-- Indexes for table `blood_of_types`
--
ALTER TABLE `blood_of_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_date`
--
ALTER TABLE `donation_date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donor_date`
--
ALTER TABLE `donor_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_date_id` (`donation_date_id`),
  ADD KEY `blood_donor_id` (`blood_donor_id`);

--
-- Indexes for table `donor_request`
--
ALTER TABLE `donor_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_blood_donor`
--
ALTER TABLE `request_blood_donor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_request_id` (`donor_request_id`),
  ADD KEY `blood_donor_id` (`blood_donor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `blood_donors`
--
ALTER TABLE `blood_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blood_of_types`
--
ALTER TABLE `blood_of_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donation_date`
--
ALTER TABLE `donation_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donor_date`
--
ALTER TABLE `donor_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donor_request`
--
ALTER TABLE `donor_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_blood_donor`
--
ALTER TABLE `request_blood_donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_donors`
--
ALTER TABLE `blood_donors`
  ADD CONSTRAINT `blood_donors_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blood_donors_ibfk_2` FOREIGN KEY (`blood_of_type_id`) REFERENCES `blood_of_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donor_date`
--
ALTER TABLE `donor_date`
  ADD CONSTRAINT `donor_date_ibfk_1` FOREIGN KEY (`donation_date_id`) REFERENCES `donation_date` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donor_date_ibfk_2` FOREIGN KEY (`blood_donor_id`) REFERENCES `blood_donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request_blood_donor`
--
ALTER TABLE `request_blood_donor`
  ADD CONSTRAINT `request_blood_donor_ibfk_1` FOREIGN KEY (`donor_request_id`) REFERENCES `donor_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_blood_donor_ibfk_2` FOREIGN KEY (`blood_donor_id`) REFERENCES `blood_donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

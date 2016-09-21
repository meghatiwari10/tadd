-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 19, 2016 at 06:37 AM
-- Server version: 5.5.48-37.8
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `attendan_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_checkin_record`
--

CREATE TABLE IF NOT EXISTS `employee_checkin_record` (
  `employee_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `employee_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `employee_user_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `employee_time_in` time NOT NULL,
  `employee_time_out` time NOT NULL,
  `entry_type` enum('checkin','checkout','WFH') COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_isHalfday` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `employee_isWfh` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `employee_isDeleted` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_main`
--

CREATE TABLE IF NOT EXISTS `employee_main` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(250) NOT NULL,
  `employee_user_name` varchar(250) NOT NULL,
  `employee_password` varchar(250) NOT NULL,
  `employee_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_notes`
--

CREATE TABLE IF NOT EXISTS `employee_notes` (
  `note_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `employee_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_personal_details`
--

CREATE TABLE IF NOT EXISTS `employee_personal_details` (
  `employee_name` varchar(500) NOT NULL,
  `employee_user_name` varchar(500) NOT NULL,
  `employee_phone_number` bigint(12) DEFAULT '0',
  `employee_address` varchar(5000) NOT NULL,
  `employee_emergency_phone` bigint(12) DEFAULT '0',
  `employee_emergency_address` varchar(5000) NOT NULL,
  `employee_designation` varchar(100) NOT NULL,
  `employee_joining_date` date NOT NULL,
  `employee_personal_email` varchar(200) NOT NULL,
  `employee_machine` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_record_daily`
--

CREATE TABLE IF NOT EXISTS `employee_record_daily` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(250) NOT NULL,
  `employee_user_name` varchar(250) NOT NULL,
  `employee_password` varchar(250) NOT NULL,
  `employee_time_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `employee_time_out` timestamp NULL DEFAULT NULL,
  `entry_type` enum('checkin','checkout') DEFAULT NULL,
  `employee_isHalfday` enum('yes','no') NOT NULL DEFAULT 'no',
  `employee_wfh_date` date NOT NULL DEFAULT '0000-00-00',
  `leave_early_date` date NOT NULL,
  `leave_early_time` time NOT NULL,
  `employee_isWfh` enum('yes','no') NOT NULL DEFAULT 'no',
  `employee_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Triggers `employee_record_daily`
--
DELIMITER $$
CREATE TRIGGER `employee_record_daily_update` BEFORE UPDATE ON `employee_record_daily`
 FOR EACH ROW INSERT INTO employee_record_daily_log (`employee_id`, `employee_name`,`employee_user_name`, `employee_password`, `employee_time_in`, `employee_time_out`,`entry_type`,`employee_isHalfday`,employee_isDeleted,action,timestamp) VALUES (OLD.employee_id,OLD.employee_name,OLD.employee_user_name,OLD.employee_password,OLD.employee_time_in,OLD.employee_time_out,OLD.entry_type,OLD.employee_isHalfday,OLD.employee_isDeleted,'update',CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_record_daily_log`
--

CREATE TABLE IF NOT EXISTS `employee_record_daily_log` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(250) NOT NULL,
  `employee_user_name` varchar(250) NOT NULL,
  `employee_password` varchar(250) NOT NULL,
  `employee_time_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `employee_time_out` timestamp NULL DEFAULT NULL,
  `entry_type` enum('checkin','checkout') DEFAULT NULL,
  `employee_isHalfday` enum('yes','no') NOT NULL DEFAULT 'no',
  `employee_wfh` enum('yes','no') NOT NULL,
  `leave_early_time` time NOT NULL,
  `employee_isWfh` enum('yes','no') NOT NULL,
  `employee_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `action` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_record_leaves`
--

CREATE TABLE IF NOT EXISTS `employee_record_leaves` (
  `employee_id` int(11) NOT NULL,
  `employee_user_name` varchar(250) NOT NULL,
  `employee_remaining_leaves` int(20) NOT NULL DEFAULT '10',
  `employee_extra_leaves` int(20) NOT NULL,
  `employee_PTO` varchar(50) DEFAULT '0',
  `employee_remaining_PTO` int(11) NOT NULL DEFAULT '10',
  `employee_sick_leaves` varchar(50) DEFAULT '0',
  `employee_remaining_sick_leaves` int(11) NOT NULL DEFAULT '5',
  `employee_leave_without_pay` int(11) NOT NULL DEFAULT '0',
  `year` int(50) NOT NULL,
  `employee_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Triggers `employee_record_leaves`
--
DELIMITER $$
CREATE TRIGGER `employee_record_leaves_update` BEFORE UPDATE ON `employee_record_leaves`
 FOR EACH ROW INSERT INTO employee_record_leaves_log (`employee_id`, `employee_user_name`, `employee_remaining_leaves`, `employee_extra_leaves`, `employee_PTO`,`employee_sick_leaves`,`year`,`employee_isDeleted`,action,timestamp) VALUES (OLD.employee_id,OLD.employee_user_name,OLD.employee_remaining_leaves,OLD.employee_extra_leaves,OLD.employee_PTO,OLD.employee_sick_leaves,OLD.year,OLD.employee_isDeleted,'update',CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_record_leaves_log`
--

CREATE TABLE IF NOT EXISTS `employee_record_leaves_log` (
  `employee_id` int(11) NOT NULL,
  `employee_user_name` varchar(250) NOT NULL,
  `employee_remaining_leaves` int(20) NOT NULL DEFAULT '10',
  `employee_extra_leaves` int(20) NOT NULL,
  `employee_PTO` varchar(50) DEFAULT '0',
  `employee_remaining_PTO` int(11) NOT NULL,
  `employee_sick_leaves` varchar(50) DEFAULT '0',
  `employee_remaining_sick_leaves` int(11) NOT NULL,
  `employee_leave_without_pay` int(11) NOT NULL,
  `year` int(50) NOT NULL,
  `employee_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `action` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaves_main`
--

CREATE TABLE IF NOT EXISTS `leaves_main` (
  `leave_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_user_name` varchar(255) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_stop_date` date NOT NULL,
  `leave_type` enum('PTO','SICK') NOT NULL DEFAULT 'PTO',
  `leave_status` enum('granted','denied','pending') DEFAULT 'pending',
  `leave_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

--
-- Triggers `leaves_main`
--
DELIMITER $$
CREATE TRIGGER `leave_main_update` BEFORE UPDATE ON `leaves_main`
 FOR EACH ROW INSERT INTO leaves_main_log (`leave_id`, `employee_name`, `leave_start_date`, `leave_stop_date`, `leave_type`,`leave_status`,`leave_isDeleted`,action,timestamp) VALUES (OLD.leave_id,OLD.employee_name,OLD.leave_start_date,OLD.leave_stop_date,OLD.leave_type,OLD.leave_status,OLD.leave_isDeleted,'update',CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `leaves_main_log`
--

CREATE TABLE IF NOT EXISTS `leaves_main_log` (
  `leave_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_stop_date` date NOT NULL,
  `leave_type` enum('PTO','SICK') NOT NULL DEFAULT 'PTO',
  `leave_status` enum('granted','denied','pending') DEFAULT 'pending',
  `leave_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `action` varchar(225) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_of_holidays`
--

CREATE TABLE IF NOT EXISTS `list_of_holidays` (
  `Date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Holiday` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_record`
--

CREATE TABLE IF NOT EXISTS `meeting_record` (
  `meeting_id` int(11) NOT NULL,
  `meeting_description` varchar(500) NOT NULL,
  `meeting_start_time` time NOT NULL,
  `meeting_end_time` time NOT NULL,
  `meeting_venue` varchar(500) NOT NULL,
  `meeting_date` date NOT NULL,
  `requested_guests` varchar(500) NOT NULL,
  `attendants` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quote_main`
--

CREATE TABLE IF NOT EXISTS `quote_main` (
  `quote_id` int(11) NOT NULL,
  `quote` varchar(767) NOT NULL,
  `quote_author` varchar(500) NOT NULL DEFAULT 'anonymous',
  `quote_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Triggers `quote_main`
--
DELIMITER $$
CREATE TRIGGER `quote_main_log` BEFORE UPDATE ON `quote_main`
 FOR EACH ROW INSERT INTO quote_main_log (`quote_id`, `quote`, `quote_author`,`quote_isDeleted`,action,timestamp) VALUES (OLD.quote_id,OLD.quote,OLD.quote_author,OLD.quote_isDeleted,'update',CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_main_log`
--

CREATE TABLE IF NOT EXISTS `quote_main_log` (
  `quote_id` int(11) NOT NULL,
  `quote` varchar(8000) NOT NULL,
  `quote_author` varchar(500) NOT NULL DEFAULT 'anonymous',
  `quote_isDeleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `superuser`
--

CREATE TABLE IF NOT EXISTS `superuser` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_main`
--
ALTER TABLE `employee_main`
  ADD PRIMARY KEY (`employee_user_name`), ADD UNIQUE KEY `id` (`employee_id`);

--
-- Indexes for table `employee_notes`
--
ALTER TABLE `employee_notes`
  ADD UNIQUE KEY `note_id` (`note_id`);

--
-- Indexes for table `employee_personal_details`
--
ALTER TABLE `employee_personal_details`
  ADD PRIMARY KEY (`employee_user_name`), ADD UNIQUE KEY `employee_user_name` (`employee_user_name`);

--
-- Indexes for table `employee_record_daily`
--
ALTER TABLE `employee_record_daily`
  ADD PRIMARY KEY (`employee_user_name`), ADD UNIQUE KEY `id` (`employee_id`);

--
-- Indexes for table `employee_record_leaves`
--
ALTER TABLE `employee_record_leaves`
  ADD UNIQUE KEY `username` (`employee_user_name`), ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `leaves_main`
--
ALTER TABLE `leaves_main`
  ADD PRIMARY KEY (`leave_id`), ADD UNIQUE KEY `id` (`leave_id`), ADD UNIQUE KEY `leaves_unique` (`employee_name`,`leave_start_date`,`leave_stop_date`);

--
-- Indexes for table `list_of_holidays`
--
ALTER TABLE `list_of_holidays`
  ADD UNIQUE KEY `Holiday` (`Holiday`);

--
-- Indexes for table `meeting_record`
--
ALTER TABLE `meeting_record`
  ADD UNIQUE KEY `meeting_id` (`meeting_id`);

--
-- Indexes for table `quote_main`
--
ALTER TABLE `quote_main`
  ADD UNIQUE KEY `quote_id` (`quote_id`), ADD UNIQUE KEY `quote` (`quote`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_main`
--
ALTER TABLE `employee_main`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `employee_notes`
--
ALTER TABLE `employee_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee_record_daily`
--
ALTER TABLE `employee_record_daily`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `employee_record_leaves`
--
ALTER TABLE `employee_record_leaves`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `leaves_main`
--
ALTER TABLE `leaves_main`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `meeting_record`
--
ALTER TABLE `meeting_record`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `quote_main`
--
ALTER TABLE `quote_main`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

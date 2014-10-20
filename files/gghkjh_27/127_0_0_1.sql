-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2014 at 09:18 AM
-- Server version: 5.5.39
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mybill`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_info`
--

CREATE TABLE IF NOT EXISTS `billing_info` (
  `user_id` int(11) NOT NULL,
  `billing_date` date DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `bill_id` int(15) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  PRIMARY KEY (`bill_id`),
  KEY `user_id` (`user_id`,`group_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `billing_info`
--

INSERT INTO `billing_info` (`user_id`, `billing_date`, `amount`, `description`, `bill_id`, `group_name`) VALUES
(7, '2014-09-02', 100, 'dfd', 43, 'rahul'),
(8, '2014-09-03', 100, 'item1', 47, 'rajnish'),
(8, '2014-09-03', 100, 'item1', 49, 'rajnish'),
(7, '2014-09-03', 50, 'item1', 51, 'rahul'),
(7, '2014-09-03', 50, 'item1', 52, 'rahul'),
(9, '2014-09-03', 100, 'CIGRATE', 57, 'roomie'),
(9, '2014-09-03', 100, 'CIGRATE', 58, 'roomie'),
(9, '2014-09-03', 100, 'CIGRATE', 59, 'roomie'),
(7, '2014-09-03', 1000, 'chutyapa', 60, 'ram'),
(7, '2014-09-03', 1000, 'chutyapa', 61, 'ram'),
(9, '2014-09-03', 1000, 'asfda', 62, 'ram'),
(8, '2014-09-03', 23456, 'hio', 66, 'rajnish'),
(8, '2014-09-03', 4689, 'ghyyyr', 68, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 69, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 70, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 71, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 72, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 73, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 74, 'ram');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`,`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`user_id`, `group_name`) VALUES
(7, 'rahul'),
(7, 'ram'),
(7, 'roomie'),
(8, 'rajnish'),
(8, 'ram'),
(9, 'ram'),
(9, 'roomie'),
(10, 'rajnish'),
(10, 'roomie'),
(11, 'AB'),
(11, 'rajnish'),
(11, 'ram');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`) VALUES
(7, 'rahul', 'lahoria', 'rahul_lahoria@yahoo.com', 'rahul', 'redhat'),
(8, 'rajnish', 'kumar', 'rajnish_pawar90@yahoo.com', 'rajnish', 'red'),
(9, 'anil', 'kumar', 'kumar.anil8892@gmail.com', 'anil', 'redhat'),
(10, 'nitin', 'yadav', 'nitinyadav2013@gmail.com', 'nitin', 'nitin'),
(11, 'abukaf', 'cha', 'abukafq@gmail.com', 'abu', 'abu'),
(12, 'debanshu', 'kumar', 'debanshu@gmail.com', 'debu', 'debu');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_info`
--
ALTER TABLE `billing_info`
  ADD CONSTRAINT `billing_info_ibfk_2` FOREIGN KEY (`user_id`, `group_name`) REFERENCES `groups` (`user_id`, `group_name`),
  ADD CONSTRAINT `billing_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);
--
-- Database: `student_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `Name` varchar(255) DEFAULT NULL,
  `Subject1` int(11) DEFAULT NULL,
  `Subject2` int(11) DEFAULT NULL,
  `subject3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`Name`, `Subject1`, `Subject2`, `subject3`) VALUES
('rajnish', 12, 12, 12),
('raj', 12, 88, 99),
('abcd', 11, 22, 33);

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `PersonID` int(11) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Database: `studnt_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Database: `test`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

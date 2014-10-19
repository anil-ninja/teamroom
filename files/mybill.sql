-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2014 at 12:06 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `billing_info`
--

INSERT INTO `billing_info` (`user_id`, `billing_date`, `amount`, `description`, `bill_id`, `group_name`) VALUES
(8, '2014-09-03', 100, 'item1', 47, 'rajnish'),
(7, '2014-09-03', 50, 'item1', 52, 'rahul'),
(9, '2014-09-03', 100, 'CIGRATE', 57, 'roomie'),
(9, '2014-09-03', 100, 'CIGRATE', 58, 'roomie'),
(9, '2014-09-03', 100, 'CIGRATE', 59, 'roomie'),
(7, '2014-09-03', 1000, 'chutyapa', 60, 'ram'),
(9, '2014-09-03', 1000, 'asfda', 62, 'ram'),
(8, '2014-09-03', 4689, 'ghyyyr', 68, 'ram'),
(8, '2014-09-07', 100, 'gg', 76, 'rajnish'),
(7, '2014-09-07', 231, 'rahul', 77, 'rahul');

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
(7, ''),
(7, 'partytime'),
(7, 'rahul'),
(7, 'ram'),
(8, 'partytime'),
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
-- Table structure for table `likes_info`
--

CREATE TABLE IF NOT EXISTS `likes_info` (
  `suggestion_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`suggestion_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sender_id`, `receiver_id`, `message`, `time`) VALUES
(7, 8, 'neee', '2014-09-07 13:15:04'),
(7, 8, 'hello', '2014-09-07 13:15:09'),
(7, 9, 'helloooooo', '2014-09-07 13:15:55'),
(7, 11, 'hello', '2014-09-07 13:16:54'),
(7, 11, 'hel new ', '2014-09-07 13:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE IF NOT EXISTS `suggestions` (
  `suggestion_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `suggest` text NOT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`suggestion_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`suggestion_id`, `user_id`, `suggest`, `likes`) VALUES
(5, 8, 'HELLOO CGUD', 3),
(6, 8, 'Aja ni darling kit gyi', 8),
(24, 9, 'Ab ke hua', 3),
(25, 10, 'mary kom', 30),
(26, 11, 'pattola', 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`) VALUES
(7, 'rahul', 'lahoria', 'rahul_lahoria@yahoo.com', 'rahul', 'redhat'),
(8, 'rajnish', 'kumar', 'rajnish_pawar90@yahoo.com', 'rajnish', 'red'),
(9, 'anil', 'kumar', 'kumar.anil8892@gmail.com', 'anil', 'redhat'),
(10, 'nitin', 'yadav', 'nitinyadav2013@gmail.com', 'nitin', 'nitin'),
(11, 'abukaf', 'cha', 'abukafq@gmail.com', 'abu', 'abu'),
(12, 'debanshu', 'kumar', 'debanshu@gmail.com', 'debu', 'debu'),
(46, 'WVFVWJFLW', 'cvb', 'agagh@yahoo.com', 'adq1q', 'asdf1234'),
(51, 'WVFVWJFLW', 'dgg', 'abcd@gmail.com', 'dvdsvdv', 'asdf1234'),
(53, 'newuser', 'kumar', 'abcdfgr@gmail.com', 'abcder', 'asdfghj'),
(56, 'rafgj', 'sdfg', 'asdfg@dfgj.com', 'asdfgj', 'qwert'),
(57, 'newuser', 'new', 'new@gnail.com', 'new', 'qwert'),
(58, '', '', '', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_info`
--
ALTER TABLE `billing_info`
  ADD CONSTRAINT `billing_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`),
  ADD CONSTRAINT `billing_info_ibfk_2` FOREIGN KEY (`user_id`, `group_name`) REFERENCES `groups` (`user_id`, `group_name`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `likes_info`
--
ALTER TABLE `likes_info`
  ADD CONSTRAINT `likes_info_ibfk_1` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestions` (`suggestion_id`),
  ADD CONSTRAINT `likes_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2015 at 07:21 PM
-- Server version: 5.5.40
-- PHP Version: 5.3.10-1ubuntu3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nucleus`
--

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(200) DEFAULT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueChannelNameIndex` (`channel_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `channels_data_fields_mappping`
--

CREATE TABLE IF NOT EXISTS `channels_data_fields_mappping` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `channel_id` int(5) NOT NULL,
  `data_field_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIDX_CHANNEL_DATA` (`channel_id`,`data_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_id_mapping`
--

CREATE TABLE IF NOT EXISTS `customer_id_mapping` (
  `identifier` varchar(200) NOT NULL,
  `type` enum('MOBILE','EMAIL','EXTERNAL_ID','FACEBOOK_ID') DEFAULT NULL,
  `uuid` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `data_fields`
--

CREATE TABLE IF NOT EXISTS `data_fields` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `data_field_name` varchar(200) NOT NULL,
  `is_array` int(11) NOT NULL DEFAULT '0',
  `base_type_id` int(5) NOT NULL DEFAULT '-1',
  `complex_type_id` int(5) NOT NULL DEFAULT '-1',
  `parent_type_id` int(5) NOT NULL DEFAULT '-1' COMMENT 'This will be an ID of this same table since the data-field is an assoc''s key',
  `default_value` varchar(100) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueDataFieldNameIndex` (`data_field_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_fields_type`
--

CREATE TABLE IF NOT EXISTS `data_fields_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueTypeIndex` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_field_validator`
--

CREATE TABLE IF NOT EXISTS `data_field_validator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_field_id` int(5) DEFAULT NULL,
  `field_validators_id` int(5) DEFAULT NULL,
  `priority` int(4) unsigned NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `IDX_DATA_FIELD_ID` (`data_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Table structure for table `field_validators`
--

CREATE TABLE IF NOT EXISTS `field_validators` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `validator_name` varchar(200) NOT NULL,
  `namespace` varchar(5) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueValidatorNameIndex` (`validator_name`),
  KEY `UIDX_VALIDATOR_NAME` (`validator_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `org_id` int(5) NOT NULL,
  `org_name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueIntouchOrgNameIndex` (`org_name`),
  UNIQUE KEY `UniqueIntouchOrgIdIndex` (`org_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_data_fields`
--

CREATE TABLE IF NOT EXISTS `org_data_fields` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `org_id` int(7) DEFAULT NULL,
  `typed` tinyint(1) NOT NULL DEFAULT '1',
  `data_field_id` int(5) NOT NULL,
  `org_data_field_name` varchar(200) NOT NULL,
  `channel_id` int(5) NOT NULL,
  `priority` int(4) unsigned NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueODFNameIndex` (`org_data_field_name`),
  KEY `IDX_ORG_CHANNEL` (`org_id`,`channel_id`),
  KEY `IDX_ORG_DATA_FIELD_PRIORITY` (`org_id`,`data_field_id`,`priority`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_data_field_validator`
--

CREATE TABLE IF NOT EXISTS `org_data_field_validator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_data_field_id` int(5) DEFAULT NULL,
  `field_validators_id` int(5) DEFAULT NULL,
  `priority` int(4) unsigned NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `IDX_ORG_DATA_FIELD_ID` (`org_data_field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE IF NOT EXISTS `migration_requests` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `org_id` int(7) DEFAULT NULL,
  `channel_name` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
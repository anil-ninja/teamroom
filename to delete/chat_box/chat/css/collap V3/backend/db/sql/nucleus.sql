-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2015 at 01:35 PM
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

USE `nucleus`;

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

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`id`, `channel_name`, `description`) VALUES
(1, 'intouch', 'Capillary Intouch APIs'),
(2, 'facebook', 'Facebook API Integration'),
(3, 'foursquare', '4sq APIs'),
(4, 'twitter', 'Twitter APIs');

-- --------------------------------------------------------

--
-- Table structure for table `customer_id_mapping`
--

CREATE TABLE IF NOT EXISTS `customer_id_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) NOT NULL,
  `type` enum('mobile','email','external_id','intouch_id','facebook_id') DEFAULT NULL,
  `uuid` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueUuidIdentifierMapping` (`uuid`,`type`,`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_fields`
--

CREATE TABLE IF NOT EXISTS `data_fields` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `data_field_name` varchar(200) NOT NULL,
  `is_array` tinyint(1) NOT NULL DEFAULT '0',
  `base_type_id` int(5) NOT NULL DEFAULT '-1',
  `complex_type_id` int(5) NOT NULL DEFAULT '-1',
  `parent_type_id` int(5) NOT NULL DEFAULT '-1' COMMENT 'This will be an ID of this same table since the data-field is an assoc''s key',
  `default_value` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Soft Deletion Flag',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueDataFieldNameIndex` (`data_field_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=355 ;

--
-- Dumping data for table `data_fields`
--

INSERT INTO `data_fields` (`id`, `data_field_name`, `is_array`, `base_type_id`, `complex_type_id`, `parent_type_id`, `default_value`, `is_active`, `added_on`, `last_update`, `description`) VALUES
(142, 'language', 0, 13, -1, -1, '', 1, '2014-12-19 22:42:11', '2014-12-19 22:42:11', 'Captures the languages known by the user'),
(143, 'birthday', 0, 19, -1, -1, '-', 1, '2014-12-31 09:41:48', '2014-12-31 09:41:48', 'Captures the birthday of the user'),
(152, 'address', 0, 23, -1, -1, '', 1, '2015-01-05 08:50:08', '2015-01-05 08:50:08', 'An assoc object that captures the address of the user'),
(165, 'address.line1', 0, 13, -1, 152, '--', 1, '2015-01-05 09:04:23', '2015-01-29 10:54:50', 'Assoc key in address object that captures the line 1 in address'),
(166, 'facebook_id', 0, 11, -1, -1, '000000000000', 1, '2015-01-05 15:48:33', '2015-01-05 15:48:33', ''),
(168, 'about_me', 0, 13, -1, -1, '-', 1, '2015-01-06 02:55:59', '2015-01-06 02:55:59', ''),
(169, 'qualification', 0, 23, -1, -1, '', 1, '2015-01-06 03:25:37', '2015-01-06 03:30:18', 'Is an assoc object containing qualification details such as school, year, type, etc.'),
(170, 'qualification.school', 0, 23, -1, 169, '', 1, '2015-01-06 03:30:48', '2015-01-06 07:13:40', 'Is a school object containing the id and name of the school'),
(172, 'qualification.school.id', 0, 11, -1, 170, '-', 0, '2015-01-06 03:40:06', '2015-01-06 03:40:06', 'Contains the ID of the school'),
(174, 'qualification.school.name', 0, 11, -1, 170, '-', 1, '2015-01-06 03:48:28', '2015-01-06 03:48:28', 'Contains the name of the school'),
(175, 'qualification.type', 0, 13, -1, 169, '-', 1, '2015-01-06 03:50:12', '2015-01-06 03:50:12', 'Contains the type of the qualification'),
(176, 'qualification.year', 0, 23, -1, 169, '', 1, '2015-01-06 04:06:09', '2015-01-06 04:06:09', 'Contains the start year object of the qualification'),
(177, 'qualification.year.name', 0, 11, -1, 176, '-', 1, '2015-01-06 04:08:29', '2015-01-06 04:08:29', 'Contains the value of the start year of the qualification'),
(178, 'specialization', 0, 23, -1, -1, '', 1, '2015-01-06 04:12:14', '2015-01-06 04:12:14', 'Contains the specialization object [id, name]'),
(179, 'specialization.id', 0, 11, -1, 178, '-', 1, '2015-01-06 04:14:30', '2015-01-06 04:14:30', 'Contains the ID attribute in the specialization object'),
(180, 'specialization.name', 0, 13, -1, 178, '-', 1, '2015-01-06 04:15:49', '2015-01-06 04:15:49', 'Contains the name attribute in the specialization object'),
(181, 'qualification.concentration', 1, -1, 178, 169, '', 1, '2015-01-06 04:18:18', '2015-01-06 04:18:18', 'Contains a list of specialization objects that represent the concentration for that qualification'),
(183, 'qualifications', 1, -1, 169, -1, '', 1, '2015-01-06 06:13:47', '2015-01-06 06:13:47', 'Contains a list of qualification objects'),
(184, 'emails', 1, 13, -1, -1, '-', 1, '2015-01-28 12:03:33', '2015-01-29 13:48:33', 'Captures the email adresses of the customer'),
(185, 'picture_url', 0, 13, -1, -1, '-', 1, '2015-01-29 09:35:59', '2015-01-29 09:35:59', 'Contains a URL to the customer''s image'),
(186, 'name', 0, 23, -1, -1, '', 1, '2015-01-29 09:38:09', '2015-01-29 09:38:09', 'An assoc object that contains the name details of a customer'),
(187, 'name.title', 0, 13, -1, 186, 'Mr./Ms.', 1, '2015-01-29 09:42:59', '2015-01-29 09:42:59', 'Contains the value of the title in the customer''s name'),
(188, 'name.first', 0, 13, -1, 186, '-', 1, '2015-01-29 09:43:43', '2015-01-29 09:43:43', 'Contains the value of the first name in the customer''s name'),
(189, 'name.middle', 0, 13, -1, 186, '-', 1, '2015-01-29 09:44:15', '2015-01-29 09:44:15', 'Contains the value of the middle name in the customer''s name'),
(190, 'name.last', 0, 13, -1, 186, '-', 1, '2015-01-29 09:44:27', '2015-01-29 09:44:27', 'Contains the value of the last name in the customer''s name'),
(191, 'national_identification_number', 0, 13, -1, -1, '-', 1, '2015-01-29 09:47:31', '2015-01-29 09:47:31', 'Contains the SSN/NIN/PIN/Aadhar/etc. number used by the customer''s nation'),
(192, 'gender', 0, 13, -1, -1, 'M/F', 1, '2015-01-29 10:12:06', '2015-01-29 10:12:06', 'Contains the gender of the customer'),
(194, 'age', 0, 11, -1, -1, '-', 1, '2015-01-29 10:44:29', '2015-01-29 10:44:29', 'Contains the age of the customer'),
(195, 'age_range', 0, 23, -1, -1, '', 1, '2015-01-29 10:45:33', '2015-01-29 10:45:33', 'Contains the age-range of the customer'),
(196, 'age_range.unit', 0, 13, -1, 195, 'years', 1, '2015-01-29 10:47:29', '2015-01-29 10:47:29', 'Contains the unit (years/days/months) of age-range of the customer'),
(197, 'age_range.lower', 0, 11, -1, 195, '--', 1, '2015-01-29 10:48:06', '2015-01-29 10:48:06', 'Contains the lower limit of the age-range of the customer'),
(198, 'age_range.upper', 0, 11, -1, 195, '--', 1, '2015-01-29 10:48:19', '2015-01-29 10:48:19', 'Contains the upper limit of the age-range of the customer'),
(199, 'income_range', 0, 23, -1, -1, '', 1, '2015-01-29 10:48:45', '2015-01-29 10:48:45', 'Contains the income-range of the customer'),
(200, 'income_range.unit', 0, 13, -1, 199, 'lacs', 1, '2015-01-29 10:49:25', '2015-01-29 10:49:25', 'Contains the unit (lacs/crores/thousand) of age-range of the customer'),
(201, 'income_range.lower', 0, 11, -1, 199, '--', 1, '2015-01-29 10:49:43', '2015-01-29 10:49:43', 'Contains the lower limit of the income-range of the customer'),
(202, 'income_range.upper', 0, 11, -1, 199, '--', 1, '2015-01-29 10:49:57', '2015-01-29 10:49:57', 'Contains the upper limit of the income-range of the customer'),
(204, 'address.line2', 0, 13, -1, 152, '--', 1, '2015-01-29 10:54:36', '2015-01-29 10:54:36', 'Assoc key in address object that captures the line 2 in address'),
(205, 'address.line3', 0, 13, -1, 152, '--', 1, '2015-01-29 10:55:13', '2015-01-29 10:55:13', 'Assoc key in address object that captures the line 3 in address'),
(206, 'nationality', 0, 13, -1, -1, '--', 1, '2015-01-29 10:56:07', '2015-01-29 10:56:07', 'Captures the nationality of the customer'),
(207, 'occupations', 1, 23, -1, -1, '', 1, '2015-01-29 10:57:01', '2015-01-29 10:57:01', 'Array of assocs that captures the occupations of the customer'),
(208, 'occupations.title', 0, 13, -1, 207, '--', 1, '2015-01-29 10:58:28', '2015-01-29 10:58:28', 'Contains the designation of the ocuupation of the customer'),
(209, 'occupations.organization', 0, 13, -1, 207, '--', 1, '2015-01-29 10:59:17', '2015-01-29 10:59:17', 'Contains the organization of the occupation of the customer'),
(210, 'occupations.location', 0, 13, -1, 207, '--', 1, '2015-01-29 10:59:35', '2015-01-29 10:59:35', 'Contains the location of the organization of the occupation of the customer'),
(211, 'timezone', 0, 13, -1, -1, '--', 1, '2015-01-29 11:00:40', '2015-01-29 11:00:40', 'Contains the timezone in which the customer lies'),
(213, 'languages', 1, 13, -1, -1, '--', 1, '2015-01-29 12:09:55', '2015-01-29 12:22:03', 'Contains the list of languages known by the customer'),
(214, 'hobbies', 1, 13, -1, -1, '--', 1, '2015-01-29 12:21:21', '2015-01-29 12:21:21', 'Contains the list of hobbies of the customer'),
(216, 'anniversary', 0, 19, -1, -1, '--', 1, '2015-01-29 12:56:31', '2015-01-29 12:56:31', 'Contains the anniversary date of the customer'),
(217, 'spouse', 1, 23, -1, -1, '', 1, '2015-01-29 12:57:15', '2015-01-29 12:58:22', 'Araay of assocs that captures the spouse details of the customer'),
(218, 'spouse.name', 0, 13, -1, 217, '--', 1, '2015-01-29 12:59:05', '2015-01-29 12:59:05', 'Contains the name of the spouse of the customer'),
(219, 'spouse.number', 0, 11, -1, 217, '--', 1, '2015-01-29 12:59:22', '2015-01-29 12:59:22', 'Contains the contact number of the spouse of the customer'),
(220, 'friends', 1, 23, -1, -1, '', 1, '2015-01-29 13:12:54', '2015-01-29 13:12:54', 'Array of assocs that captures the details about the friends of the customer'),
(221, 'friends.name', 0, 13, -1, 220, '--', 1, '2015-01-29 13:14:10', '2015-01-29 13:14:10', 'Contains the name of the friend of the customer'),
(223, 'friends.email', 0, 13, -1, 220, '--', 1, '2015-01-29 13:14:55', '2015-01-29 13:14:55', 'Contains the email of the friend of the customer'),
(224, 'friends.phone', 0, 11, -1, 220, '--', 1, '2015-01-29 13:16:12', '2015-01-29 13:16:12', 'Contains the contact number of the friend of the customer'),
(225, 'communications', 0, 23, -1, -1, '', 1, '2015-01-29 13:18:59', '2015-01-29 13:18:59', 'An assoc object that contains the communications details of the customer'),
(226, 'married', 0, 13, -1, -1, '-', 1, '2015-01-29 13:21:28', '2015-02-23 07:16:45', 'Contains the marital status of the customer'),
(227, 'communications.subscribed', 0, 24, -1, -1, '--', 1, '2015-01-29 13:22:43', '2015-01-29 13:22:43', 'Captures if the customer has opted-in for communications'),
(228, 'communications.language', 0, 13, -1, -1, '--', 1, '2015-01-29 13:23:34', '2015-01-29 13:23:34', 'Captures for which language the customer has opted-in for communications'),
(229, 'communications.medium', 1, 13, -1, -1, '--', 1, '2015-01-29 13:25:02', '2015-01-29 13:25:02', 'Captures for which mediums has the customer subscribed to'),
(230, 'communications.newsletter', 0, 24, -1, -1, '--', 1, '2015-01-29 13:25:46', '2015-01-29 13:25:46', 'Captures if the customer has opted-in for receiving the newsletter'),
(231, 'communications.terms_and_conditions', 0, 24, -1, -1, '--', 1, '2015-01-29 13:26:19', '2015-01-29 13:26:19', 'Captures if the customer has accepted the ''terms and conditions'''),
(232, 'visit', 0, 23, -1, -1, '', 1, '2015-01-29 13:27:00', '2015-01-29 13:27:00', 'An assoc object that contains the visit details of the customer'),
(233, 'visit.rate_experience', 0, 11, -1, -1, '--', 1, '2015-01-29 13:28:19', '2015-01-29 13:28:19', 'Captures the customer''s experience rate'),
(234, 'visit.interested_in', 0, 13, -1, -1, '--', 1, '2015-01-29 13:29:18', '2015-01-29 13:29:18', 'Captures the products/services that the customer is interested in'),
(235, 'visit.quantity', 0, 11, -1, -1, '--', 1, '2015-01-29 13:30:08', '2015-01-29 13:30:08', 'Captures the quantity of the products/services that the customer is interested in'),
(236, 'visit.shopping_budget', 0, 23, -1, -1, '', 1, '2015-01-29 13:31:15', '2015-01-29 13:31:15', 'Captures the shopping budget for the customer''s visit'),
(237, 'visit.shopping_budget.unit', 0, 13, -1, 236, '--', 1, '2015-01-29 13:33:40', '2015-01-29 13:33:40', 'Contains the unit (lacs/crores/thousand) of shopping budget of the customer''s visit'),
(238, 'visit.shopping_budget.lower', 0, 11, -1, 236, '--', 1, '2015-01-29 13:34:07', '2015-01-29 13:34:07', 'Contains the lower limit of the shopping budget of the customer''s visit'),
(239, 'visit.shopping_budget.upper', 0, 11, -1, 236, '--', 1, '2015-01-29 13:34:19', '2015-01-29 13:34:19', 'Contains the upper limit of the shopping budget of the customer''s visit'),
(240, 'visit.know_about', 0, 13, -1, 232, '--', 1, '2015-01-29 13:35:35', '2015-01-29 13:35:35', 'Captures how the customer came to know about the brand/store'),
(241, 'visit.feedback', 0, 13, -1, 232, '--', 1, '2015-01-29 13:37:01', '2015-01-29 13:37:01', 'Captures the feedback of the customer on this visit'),
(242, 'preferences', 0, 23, -1, -1, '', 1, '2015-01-29 13:37:46', '2015-01-29 13:37:46', 'An assoc object that contains the preferences of the customer'),
(243, 'preferences.store', 0, 13, -1, 242, '--', 1, '2015-01-29 13:38:13', '2015-01-29 13:38:13', 'Captures the preferred store of the customer'),
(244, 'preferences.cashier', 0, 13, -1, 242, '--', 1, '2015-01-29 13:38:34', '2015-01-29 13:38:34', 'Captures the preferred cashier of the customer'),
(245, 'preferences.favourite_products', 1, 13, -1, 242, '--', 1, '2015-01-29 13:39:21', '2015-01-29 13:39:21', 'Captures the favourite products of the customer'),
(246, 'profile_complete_percentage', 1, 11, -1, -1, '--', 1, '2015-01-29 13:40:55', '2015-01-29 13:40:55', 'Captures the percentage of the customer''s profile completion'),
(247, 'phones', 1, 23, 248, -1, '', 1, '2015-01-29 13:42:24', '2015-01-29 13:44:18', 'Array of phone objects of the customer'),
(248, 'phone', 0, 23, -1, -1, '', 1, '2015-01-29 13:43:35', '2015-01-29 13:43:35', 'Captures the contact number of the customer'),
(249, 'phone.country_code', 0, 11, -1, 248, '--', 1, '2015-01-29 13:45:22', '2015-01-29 13:45:22', 'Captures the country code in the contact number of the customer'),
(250, 'phone.number', 0, 11, -1, 248, '--', 1, '2015-01-29 13:46:01', '2015-01-29 13:46:01', 'Captures the number in the contact number of the customer'),
(268, 'qualification.school.idone', 0, 11, -1, -1, '1', 1, '2015-02-10 12:55:24', '2015-02-11 02:26:05', 'Contains the ID of the school'),
(273, 'qualification.school.idtwo', 0, 11, -1, -1, '1', 1, '2015-02-11 02:38:36', '2015-02-11 02:39:35', 'Contains the ID of the school'),
(275, 'qualification.school.idthree', 0, 11, -1, -1, '1', 1, '2015-02-11 02:40:03', '2015-02-11 03:29:15', 'Contains the ID of the school'),
(276, 'occupation', 0, 23, -1, 170, '', 1, '2015-02-16 03:49:52', '2015-02-16 03:49:52', 'An assoc object containing occupation details of a customer'),
(277, 'occupation.employer', 0, 23, -1, 276, '', 1, '2015-02-16 03:50:49', '2015-02-16 03:50:49', 'An assoc object containing employer details of a customer''s occupation'),
(278, 'occupation.employer.id', 0, 11, -1, 277, '-', 1, '2015-02-16 03:53:00', '2015-02-16 03:53:00', 'ID of the employer in a customer''s occupation'),
(279, 'occupation.employer.name', 0, 13, -1, 277, '-', 1, '2015-02-16 03:53:22', '2015-02-16 03:53:22', 'Name of the employer in a customer''s occupation'),
(280, 'occupation.location', 0, 23, -1, 276, '', 1, '2015-02-16 03:54:10', '2015-02-16 03:54:10', 'An assoc object containing location details of a customer''s occupation'),
(282, 'occupation.location.id', 0, 11, -1, 280, '-', 1, '2015-02-16 03:54:40', '2015-02-16 03:54:40', 'ID of the location in a customer''s occupation'),
(283, 'occupation.location.name', 0, 13, -1, 280, '-', 1, '2015-02-16 03:55:00', '2015-02-16 03:55:00', 'NAme of the location in a customer''s occupation'),
(284, 'occupation.position', 0, 23, -1, 276, '', 1, '2015-02-16 03:56:47', '2015-02-16 03:56:47', 'An assoc object containing designation details of a customer''s occupation'),
(285, 'occupation.position.id', 0, 11, -1, 284, '-', 1, '2015-02-16 03:57:20', '2015-02-16 03:57:20', 'ID of the designation in a customer''s occupation'),
(286, 'occupation.position.name', 0, 13, -1, 284, '-', 1, '2015-02-16 03:57:39', '2015-02-16 03:57:39', 'Name of the designation in a customer''s occupation'),
(287, 'occupation.start_date', 0, 19, -1, 276, '-', 1, '2015-02-16 04:01:03', '2015-02-16 04:01:03', 'Start date of a customer''s occupation'),
(288, 'occupation.end_date', 0, 19, -1, 276, '-', 1, '2015-02-16 04:01:11', '2015-02-16 04:01:11', 'End date of a customer''s occupation'),
(289, 'occupation.description', 0, 13, -1, 276, '-', 1, '2015-02-16 04:32:14', '2015-02-16 04:32:14', 'Description of a customer''s occupation'),
(290, 'project', 0, 23, -1, -1, '', 1, '2015-02-16 04:34:51', '2015-02-16 04:34:51', 'An assoc project that describes a work project'),
(291, 'project.description', 0, 13, -1, 290, '-', 1, '2015-02-16 04:35:31', '2015-02-16 04:35:31', 'Description of a customer''s occupation''s project'),
(292, 'project.start_date', 0, 19, -1, 290, '-', 1, '2015-02-16 04:35:57', '2015-02-16 04:35:57', 'Start date of a customer''s occupation''s project'),
(293, 'project.end_date', 0, 19, -1, 290, '-', 1, '2015-02-16 04:36:30', '2015-02-16 04:36:30', 'End date of a customer''s occupation''s project'),
(294, 'project.id', 0, 11, -1, 290, '-', 1, '2015-02-16 04:38:52', '2015-02-16 04:38:52', 'ID of a customer''s occupation''s project'),
(295, 'project.name', 0, 13, -1, 290, '-', 1, '2015-02-16 04:39:14', '2015-02-16 04:39:14', 'Name of a customer''s occupation''s project'),
(296, 'occupation.projects', 1, -1, 290, 276, '', 1, '2015-02-16 04:40:54', '2015-02-16 04:40:54', 'An array of project objects related to a customer''s occupation'),
(297, 'colleague', 0, 23, -1, -1, '', 1, '2015-02-16 04:42:21', '2015-02-16 04:42:21', 'An assoc object containing a customer''s colleague''s details'),
(298, 'colleague.id', 0, 11, -1, 297, '-', 1, '2015-02-16 04:43:31', '2015-02-16 04:43:31', 'An assoc object containing a customer''s colleague''s details'),
(299, 'colleague.name', 0, 13, -1, 297, '-', 1, '2015-02-16 04:44:02', '2015-02-16 04:44:02', 'Name of a customer''s colleague'),
(300, 'project.with', 1, -1, 297, -1, '', 1, '2015-02-16 04:45:08', '2015-02-16 04:45:08', 'A list of the customer''s colleagues'),
(342, 'occupation.with', 1, -1, 297, -1, '', 1, '2015-02-16 10:59:05', '2015-02-16 10:59:05', 'A list of the customer''s colleagues'),
(343, 'work', 1, -1, 276, -1, '', 1, '2015-02-16 10:59:29', '2015-02-16 10:59:29', 'A list of the customer''s occupations known'),
(345, 'profile_url', 0, 13, -1, -1, '-', 1, '2015-02-23 07:02:11', '2015-02-23 07:02:11', 'Contains a URL to the customer''s profile'),
(346, 'username', 0, 13, -1, -1, '-', 1, '2015-02-23 07:04:44', '2015-02-23 07:04:44', 'Contains a URL to the customer''s profile''s username'),
(347, 'website', 0, 13, -1, -1, '-', 1, '2015-02-23 07:10:54', '2015-02-23 07:10:54', 'Contains a URL to the customer''s website'),
(348, 'religion', 0, 13, -1, -1, '-', 1, '2015-02-23 07:14:01', '2015-02-23 07:14:01', 'Captures the customer''s religion'),
(349, 'locale', 0, 13, -1, -1, '-', 1, '2015-02-23 07:15:14', '2015-02-23 07:15:14', 'Captures the customer''s locale'),
(350, 'name.full', 0, 13, -1, 186, '-', 1, '2015-02-23 07:28:22', '2015-02-23 07:28:22', 'Contains the value of the full name of the customer'),
(351, 'address.city', 0, 13, -1, 152, '-', 1, '2015-02-23 07:38:07', '2015-02-23 07:38:07', 'Assoc key in address object that captures the city of in address'),
(352, 'address.state', 0, 13, -1, 152, '-', 1, '2015-02-23 07:38:30', '2015-02-23 07:38:30', 'Assoc key in address object that captures the state of the customer in address'),
(353, 'address.country', 0, 13, -1, 152, '-', 1, '2015-02-23 07:38:46', '2015-02-23 07:38:46', 'Assoc key in address object that captures the country of the customer in address'),
(354, 'address.zipcode', 0, 13, -1, 152, '-', 1, '2015-02-23 07:39:04', '2015-02-23 07:39:04', 'Assoc key in address object that captures the zipcode of the customer in address'), 
(355, 'dummy', 0, 13, -1, -1, '-- DUMMY DUMMY --', 1, '2015-02-23 10:34:39', '2015-02-23 10:34:39', 'Dummy data-field for the auto-creation of org-data-fields');

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

--
-- Dumping data for table `data_fields_type`
--

INSERT INTO `data_fields_type` (`id`, `type`) VALUES
(24, 'boolean'),
(23, 'complex'),
(19, 'date'),
(11, 'number'),
(13, 'string');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `data_field_validator`
--

INSERT INTO `data_field_validator` (`id`, `data_field_id`, `field_validators_id`, `priority`, `added_on`, `last_update`) VALUES
(2, 166, 30, 1, '2015-01-06 02:53:28', '2015-01-06 02:53:28'),
(3, 166, 27, 2, '2015-01-06 02:53:29', '2015-01-06 02:53:29'),
(4, 166, 28, 3, '2015-01-06 02:53:29', '2015-01-06 02:53:29'),
(5, 168, 32, 1, '2015-01-06 02:55:59', '2015-01-06 02:55:59'),
(6, 143, 19, 1, '2015-01-06 02:56:49', '2015-01-06 02:56:49'),
(7, 171, 30, 1, '2015-01-06 03:36:45', '2015-01-06 03:36:45'),
(8, 171, 27, 2, '2015-01-06 03:36:45', '2015-01-06 03:36:45'),
(9, 171, 28, 3, '2015-01-06 03:36:45', '2015-01-06 03:36:45'),
(10, 172, 30, 1, '2015-01-06 03:40:06', '2015-01-06 03:40:06'),
(11, 172, 27, 2, '2015-01-06 03:40:06', '2015-01-06 03:40:06'),
(12, 172, 28, 3, '2015-01-06 03:40:06', '2015-01-06 03:40:06'),
(13, 174, 32, 1, '2015-01-06 03:48:28', '2015-01-06 03:48:28'),
(14, 174, 15, 2, '2015-01-06 03:48:28', '2015-01-06 03:48:28'),
(15, 175, 22, 1, '2015-01-06 03:50:12', '2015-01-06 03:50:12'),
(16, 177, 30, 1, '2015-01-06 04:08:29', '2015-01-06 04:08:29'),
(17, 177, 27, 2, '2015-01-06 04:08:29', '2015-01-06 04:08:29'),
(18, 177, 28, 3, '2015-01-06 04:08:29', '2015-01-06 04:08:29'),
(19, 179, 30, 1, '2015-01-06 04:14:30', '2015-01-06 04:14:30'),
(20, 179, 28, 2, '2015-01-06 04:14:30', '2015-01-06 04:14:30'),
(21, 180, 32, 1, '2015-01-06 04:15:49', '2015-01-06 04:15:49'),
(22, 180, 15, 2, '2015-01-06 04:15:49', '2015-01-06 04:15:49'),
(24, 185, 33, 1, '2015-01-29 09:35:59', '2015-01-29 09:35:59'),
(25, 187, 32, 1, '2015-01-29 09:42:59', '2015-01-29 09:42:59'),
(26, 188, 32, 1, '2015-01-29 09:43:43', '2015-01-29 09:43:43'),
(27, 189, 32, 1, '2015-01-29 09:44:15', '2015-01-29 09:44:15'),
(28, 190, 32, 1, '2015-01-29 09:44:27', '2015-01-29 09:44:27'),
(29, 191, 32, 1, '2015-01-29 09:47:32', '2015-01-29 09:47:32'),
(30, 192, 32, 1, '2015-01-29 10:12:06', '2015-01-29 10:12:06'),
(31, 194, 30, 1, '2015-01-29 10:44:29', '2015-01-29 10:44:29'),
(32, 196, 32, 1, '2015-01-29 10:47:29', '2015-01-29 10:47:29'),
(33, 197, 30, 1, '2015-01-29 10:48:07', '2015-01-29 10:48:07'),
(34, 198, 30, 1, '2015-01-29 10:48:19', '2015-01-29 10:48:19'),
(35, 200, 32, 1, '2015-01-29 10:49:25', '2015-01-29 10:49:25'),
(36, 201, 30, 1, '2015-01-29 10:49:43', '2015-01-29 10:49:43'),
(37, 202, 30, 1, '2015-01-29 10:49:57', '2015-01-29 10:49:57'),
(39, 204, 32, 1, '2015-01-29 10:54:36', '2015-01-29 10:54:36'),
(40, 165, 32, 1, '2015-01-29 10:54:50', '2015-01-29 10:54:50'),
(41, 205, 32, 1, '2015-01-29 10:55:13', '2015-01-29 10:55:13'),
(42, 206, 32, 1, '2015-01-29 10:56:07', '2015-01-29 10:56:07'),
(43, 208, 32, 1, '2015-01-29 10:58:28', '2015-01-29 10:58:28'),
(44, 209, 32, 1, '2015-01-29 10:59:17', '2015-01-29 10:59:17'),
(45, 210, 32, 1, '2015-01-29 10:59:36', '2015-01-29 10:59:36'),
(46, 211, 32, 1, '2015-01-29 11:00:40', '2015-01-29 11:00:40'),
(48, 214, 32, 1, '2015-01-29 12:21:21', '2015-01-29 12:21:21'),
(49, 213, 32, 1, '2015-01-29 12:22:03', '2015-01-29 12:22:03'),
(51, 216, 19, 1, '2015-01-29 12:56:31', '2015-01-29 12:56:31'),
(52, 216, 24, 2, '2015-01-29 12:56:31', '2015-01-29 12:56:31'),
(53, 218, 32, 1, '2015-01-29 12:59:05', '2015-01-29 12:59:05'),
(54, 219, 32, 1, '2015-01-29 12:59:22', '2015-01-29 12:59:22'),
(55, 221, 32, 1, '2015-01-29 13:14:10', '2015-01-29 13:14:10'),
(56, 223, 21, 1, '2015-01-29 13:14:55', '2015-01-29 13:14:55'),
(57, 224, 30, 1, '2015-01-29 13:16:12', '2015-01-29 13:16:12'),
(59, 227, 17, 1, '2015-01-29 13:22:43', '2015-01-29 13:22:43'),
(60, 228, 32, 1, '2015-01-29 13:23:34', '2015-01-29 13:23:34'),
(61, 229, 32, 1, '2015-01-29 13:25:03', '2015-01-29 13:25:03'),
(62, 230, 17, 1, '2015-01-29 13:25:46', '2015-01-29 13:25:46'),
(63, 231, 17, 1, '2015-01-29 13:26:19', '2015-01-29 13:26:19'),
(64, 233, 30, 1, '2015-01-29 13:28:19', '2015-01-29 13:28:19'),
(65, 234, 32, 1, '2015-01-29 13:29:18', '2015-01-29 13:29:18'),
(66, 235, 30, 1, '2015-01-29 13:30:08', '2015-01-29 13:30:08'),
(67, 237, 32, 1, '2015-01-29 13:33:40', '2015-01-29 13:33:40'),
(68, 238, 30, 1, '2015-01-29 13:34:07', '2015-01-29 13:34:07'),
(69, 239, 30, 1, '2015-01-29 13:34:19', '2015-01-29 13:34:19'),
(70, 240, 32, 1, '2015-01-29 13:35:35', '2015-01-29 13:35:35'),
(71, 241, 32, 1, '2015-01-29 13:37:01', '2015-01-29 13:37:01'),
(72, 243, 32, 1, '2015-01-29 13:38:13', '2015-01-29 13:38:13'),
(73, 244, 32, 1, '2015-01-29 13:38:34', '2015-01-29 13:38:34'),
(74, 245, 32, 1, '2015-01-29 13:39:22', '2015-01-29 13:39:22'),
(75, 246, 30, 1, '2015-01-29 13:40:55', '2015-01-29 13:40:55'),
(76, 249, 30, 1, '2015-01-29 13:45:22', '2015-01-29 13:45:22'),
(77, 250, 30, 1, '2015-01-29 13:46:01', '2015-01-29 13:46:01'),
(78, 184, 21, 1, '2015-01-29 13:48:33', '2015-01-29 13:48:33'),
(79, 251, 30, 1, '2015-02-09 07:13:51', '2015-02-09 07:13:51'),
(80, 251, 27, 2, '2015-02-09 07:13:51', '2015-02-09 07:13:51'),
(81, 251, 28, 3, '2015-02-09 07:13:51', '2015-02-09 07:13:51'),
(82, 262, 30, 0, '2015-02-09 09:54:56', '2015-02-09 09:54:56'),
(83, 262, 27, 1, '2015-02-09 09:54:56', '2015-02-09 09:54:56'),
(84, 262, 28, 2, '2015-02-09 09:54:56', '2015-02-09 09:54:56'),
(85, 264, 30, 0, '2015-02-09 10:24:42', '2015-02-09 10:24:42'),
(86, 264, 27, 1, '2015-02-09 10:24:42', '2015-02-09 10:24:42'),
(87, 264, 28, 2, '2015-02-09 10:24:42', '2015-02-09 10:24:42'),
(88, 266, 30, 0, '2015-02-09 10:25:07', '2015-02-09 10:25:07'),
(89, 266, 27, 1, '2015-02-09 10:25:07', '2015-02-09 10:25:07'),
(90, 266, 28, 2, '2015-02-09 10:25:08', '2015-02-09 10:25:08'),
(94, 267, 19, 0, '2015-02-10 06:28:31', '2015-02-10 06:28:31'),
(95, 267, 19, 1, '2015-02-10 06:28:31', '2015-02-10 06:28:31'),
(96, 267, 19, 2, '2015-02-10 06:28:31', '2015-02-10 06:28:31'),
(97, 267, 30, 3, '2015-02-10 06:28:31', '2015-02-10 06:28:31'),
(98, 267, 30, 4, '2015-02-10 06:28:31', '2015-02-10 06:28:31'),
(120, 275, 30, 0, '2015-02-11 03:29:16', '2015-02-11 03:29:16'),
(121, 275, 27, 1, '2015-02-11 03:29:16', '2015-02-11 03:29:16'),
(122, 275, 28, 2, '2015-02-11 03:29:16', '2015-02-11 03:29:16'),
(123, 278, 30, 0, '2015-02-16 09:23:00', '2015-02-16 09:23:00'),
(124, 278, 27, 1, '2015-02-16 09:23:00', '2015-02-16 09:23:00'),
(125, 278, 28, 2, '2015-02-16 09:23:00', '2015-02-16 09:23:00'),
(126, 279, 32, 0, '2015-02-16 09:23:22', '2015-02-16 09:23:22'),
(127, 282, 30, 0, '2015-02-16 09:24:40', '2015-02-16 09:24:40'),
(128, 282, 27, 1, '2015-02-16 09:24:40', '2015-02-16 09:24:40'),
(129, 282, 28, 2, '2015-02-16 09:24:40', '2015-02-16 09:24:40'),
(130, 283, 32, 0, '2015-02-16 09:25:00', '2015-02-16 09:25:00'),
(131, 285, 30, 0, '2015-02-16 09:27:20', '2015-02-16 09:27:20'),
(132, 285, 27, 1, '2015-02-16 09:27:20', '2015-02-16 09:27:20'),
(133, 285, 28, 2, '2015-02-16 09:27:20', '2015-02-16 09:27:20'),
(134, 286, 32, 0, '2015-02-16 09:27:39', '2015-02-16 09:27:39'),
(135, 287, 19, 0, '2015-02-16 09:31:03', '2015-02-16 09:31:03'),
(136, 288, 19, 0, '2015-02-16 09:31:12', '2015-02-16 09:31:12'),
(137, 289, 32, 0, '2015-02-16 10:02:14', '2015-02-16 10:02:14'),
(138, 291, 32, 0, '2015-02-16 10:05:31', '2015-02-16 10:05:31'),
(139, 292, 19, 0, '2015-02-16 10:05:57', '2015-02-16 10:05:57'),
(140, 293, 19, 0, '2015-02-16 10:06:30', '2015-02-16 10:06:30'),
(141, 294, 30, 0, '2015-02-16 10:08:52', '2015-02-16 10:08:52'),
(142, 294, 27, 1, '2015-02-16 10:08:52', '2015-02-16 10:08:52'),
(143, 294, 28, 2, '2015-02-16 10:08:52', '2015-02-16 10:08:52'),
(144, 295, 32, 0, '2015-02-16 10:09:14', '2015-02-16 10:09:14'),
(145, 298, 30, 0, '2015-02-16 10:13:31', '2015-02-16 10:13:31'),
(146, 298, 27, 1, '2015-02-16 10:13:31', '2015-02-16 10:13:31'),
(147, 298, 28, 2, '2015-02-16 10:13:31', '2015-02-16 10:13:31'),
(148, 299, 32, 0, '2015-02-16 10:14:02', '2015-02-16 10:14:02'),
(149, 345, 33, 0, '2015-02-23 07:02:11', '2015-02-23 07:02:11'),
(150, 346, 32, 0, '2015-02-23 07:04:44', '2015-02-23 07:04:44'),
(152, 347, 33, 0, '2015-02-23 07:10:55', '2015-02-23 07:10:55'),
(153, 348, 32, 0, '2015-02-23 07:14:02', '2015-02-23 07:14:02'),
(154, 349, 32, 0, '2015-02-23 07:15:14', '2015-02-23 07:15:14'),
(155, 226, 32, 0, '2015-02-23 07:16:45', '2015-02-23 07:16:45'),
(156, 350, 32, 0, '2015-02-23 07:28:22', '2015-02-23 07:28:22'),
(157, 351, 32, 0, '2015-02-23 07:38:07', '2015-02-23 07:38:07'),
(158, 352, 32, 0, '2015-02-23 07:38:30', '2015-02-23 07:38:30'),
(159, 353, 32, 0, '2015-02-23 07:38:46', '2015-02-23 07:38:46'),
(160, 354, 32, 0, '2015-02-23 07:39:04', '2015-02-23 07:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `field_validators`
--

CREATE TABLE IF NOT EXISTS `field_validators` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `validator_name` varchar(200) NOT NULL,
  `namespace` varchar(100) NOT NULL DEFAULT 'string',
  `is_active` tinyint(1) DEFAULT '1',
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueValidatorNameIndex` (`validator_name`),
  KEY `UIDX_VALIDATOR_NAME` (`validator_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `field_validators`
--

INSERT INTO `field_validators` (`id`, `validator_name`, `namespace`, `is_active`, `description`) VALUES
(10, 'alphabetic', 'string', 1, 'Must contain only alphabets'),
(11, 'alphanumeric', 'string', 1, 'Includes only characters [A-Z][a-z][0-9]'),
(15, 'alphanumeric_special_char', 'string', 1, 'Ensure each character is either an alphabet, number or a special character'),
(16, 'array_of_string', 'string', 1, 'Ensure if array of string values'),
(17, 'boolean', 'boolean', 1, 'Ensure value is boolean'),
(18, 'country_list', 'string', 1, 'Ensure value lies in the list of countries'),
(19, 'date_format', 'date', 1, 'Ensure value is specified in the correct date format'),
(20, 'domain', 'string', 1, 'Ensure adherence to standard domain format'),
(21, 'email', 'string', 1, 'Ensure value adheres to a valid email address pattern'),
(22, 'enum', 'string', 1, 'Ensure value belong to a predefined ENUM?'),
(23, 'external_id', 'string', 1, 'Ensure adherence to the external_id format'),
(24, 'in_last_100_years', 'date', 1, 'Ensure date value lies in the last 100 years'),
(25, 'marital_status_list', 'string', 1, 'Ensure marital status is one of those mentioned in the list'),
(26, 'mobile_no', 'number', 1, 'Ensure mobile number follows the standard mobile number pattern'),
(27, 'no_space', 'generic', 1, 'Ensure value contains no whitespace'),
(28, 'not_negative', 'number', 1, 'Ensure value is not a negative number'),
(29, 'not_null', 'generic', 1, 'Ensure value is not null'),
(30, 'number', 'number', 1, 'Ensure value is a number'),
(31, 'numeric_range', 'number', 1, 'Ensure value lies within numeric range'),
(32, 'string', 'string', 1, 'Ensure value is a string'),
(33, 'url', 'string', 1, 'Ensure value adheres to a valid URL pattern'),
(34, 'alphabetic1', 'string', 1, 'Must contain only alphabets');

-- --------------------------------------------------------

--
-- Table structure for table `migration_requests`
--

CREATE TABLE IF NOT EXISTS `migration_requests` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `org_id` int(7) DEFAULT NULL,
  `channel_name` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
  `is_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Validator invlidations will not throw an exception, if this set to 0',
  `priority` int(4) unsigned NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueOrgChannelNameIndex` (`org_data_field_name`,`org_id`,`channel_id`),
  KEY `IDX_ORG_CHANNEL` (`org_id`,`channel_id`),
  KEY `IDX_ORG_DATA_FIELD_PRIORITY` (`org_id`,`data_field_id`,`priority`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147 ;

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE IF NOT EXISTS `sources` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(20) NOT NULL,
  `channel_name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIDX_SOURCE_CHANNEL` (`source_name`,`channel_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `source_name`, `channel_name`, `description`) VALUES
(48, 'microsite', 'facebook', 'Adding microsite as a source for facebook data'),
(49, 'ecommerce', 'facebook', 'Adding ecommerce as a source for facebook data'),
(50, 'instore', 'intouch', 'Adding instore as a source for intouch data'),
(51, 'microsite', 'intouch', 'Adding microsite as a source for intouch data'),
(52, 'ecommerce', 'intouch', 'Adding ecommerce as a source for intouch data');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `migration_requests` ADD UNIQUE (
`org_id` ,
`channel_name`
);
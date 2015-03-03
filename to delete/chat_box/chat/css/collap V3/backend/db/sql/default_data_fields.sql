-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2015 at 07:19 PM
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
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Soft Deletion Flag',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueDataFieldNameIndex` (`data_field_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Dumping data for table `data_fields`
--

INSERT INTO `data_fields` (`id`, `data_field_name`, `is_array`, `base_type_id`, `complex_type_id`, `parent_type_id`, `default_value`, `is_active`, `added_on`, `last_update`, `description`) VALUES
(142, 'language', 0, 13, -1, -1, '', 0, '2014-12-19 22:42:11', '2014-12-19 22:42:11', 'Captures the languages known by the user'),
(143, 'birthday', 0, 19, -1, -1, '-', 0, '2014-12-31 09:41:48', '2014-12-31 09:41:48', 'Captures the birthday of the user'),
(152, 'address', 0, 23, -1, -1, '', 0, '2015-01-05 08:50:08', '2015-01-05 08:50:08', 'An assoc object that captures the address of the user'),
(165, 'address.line1', 0, 13, -1, 152, '--', 0, '2015-01-05 09:04:23', '2015-01-29 10:54:50', 'Assoc key in address object that captures the line 1 in address'),
(166, 'facebook_id', 0, 11, -1, -1, '000000000000', 0, '2015-01-05 15:48:33', '2015-01-05 15:48:33', ''),
(168, 'about_me', 0, 13, -1, -1, '-', 0, '2015-01-06 02:55:59', '2015-01-06 02:55:59', ''),
(169, 'qualification', 0, 23, -1, -1, '', 0, '2015-01-06 03:25:37', '2015-01-06 03:30:18', 'Is an assoc object containing qualification details such as school, year, type, etc.'),
(170, 'qualification.school', 0, 23, -1, 169, '', 0, '2015-01-06 03:30:48', '2015-01-06 07:13:40', 'Is a school object containing the id and name of the school'),
(172, 'qualification.school.id', 0, 11, -1, 170, '-', 0, '2015-01-06 03:40:06', '2015-01-06 03:40:06', 'Contains the ID of the school'),
(174, 'qualification.school.name', 0, 11, -1, 170, '-', 0, '2015-01-06 03:48:28', '2015-01-06 03:48:28', 'Contains the name of the school'),
(175, 'qualification.type', 0, 13, -1, 169, '-', 0, '2015-01-06 03:50:12', '2015-01-06 03:50:12', 'Contains the type of the qualification'),
(176, 'qualification.year', 0, 23, -1, 169, '', 0, '2015-01-06 04:06:09', '2015-01-06 04:06:09', 'Contains the start year object of the qualification'),
(177, 'qualification.year.name', 0, 11, -1, 176, '-', 0, '2015-01-06 04:08:29', '2015-01-06 04:08:29', 'Contains the value of the start year of the qualification'),
(178, 'specialization', 0, 23, -1, -1, '', 0, '2015-01-06 04:12:14', '2015-01-06 04:12:14', 'Contains the specialization object [id, name]'),
(179, 'specialization.id', 0, 11, -1, 178, '-', 0, '2015-01-06 04:14:30', '2015-01-06 04:14:30', 'Contains the ID attribute in the specialization object'),
(180, 'specialization.name', 0, 13, -1, 178, '-', 0, '2015-01-06 04:15:49', '2015-01-06 04:15:49', 'Contains the name attribute in the specialization object'),
(181, 'qualification.concentration', 1, -1, 178, 169, '', 0, '2015-01-06 04:18:18', '2015-01-06 04:18:18', 'Contains a list of specialization objects that represent the concentration for that qualification'),
(183, 'qualifications', 1, -1, 169, -1, '', 0, '2015-01-06 06:13:47', '2015-01-06 06:13:47', 'Contains a list of qualification objects'),
(184, 'emails', 1, 13, -1, -1, '-', 0, '2015-01-28 12:03:33', '2015-01-29 13:48:33', 'Captures the email adresses of the customer'),
(185, 'picture_url', 0, 13, -1, -1, '-', 0, '2015-01-29 09:35:59', '2015-01-29 09:35:59', 'Contains a URL to the customer''s image'),
(186, 'name', 0, 23, -1, -1, '', 0, '2015-01-29 09:38:09', '2015-01-29 09:38:09', 'An assoc object that contains the name details of a customer'),
(187, 'name.title', 0, 13, -1, 186, 'Mr./Ms.', 0, '2015-01-29 09:42:59', '2015-01-29 09:42:59', 'Contains the value of the title in the customer''s name'),
(188, 'name.first', 0, 13, -1, 186, '-', 0, '2015-01-29 09:43:43', '2015-01-29 09:43:43', 'Contains the value of the first name in the customer''s name'),
(189, 'name.middle', 0, 13, -1, 186, '-', 0, '2015-01-29 09:44:15', '2015-01-29 09:44:15', 'Contains the value of the middle name in the customer''s name'),
(190, 'name.last', 0, 13, -1, 186, '-', 0, '2015-01-29 09:44:27', '2015-01-29 09:44:27', 'Contains the value of the last name in the customer''s name'),
(191, 'national_identification_number', 0, 13, -1, -1, '-', 0, '2015-01-29 09:47:31', '2015-01-29 09:47:31', 'Contains the SSN/NIN/PIN/Aadhar/etc. number used by the customer''s nation'),
(192, 'gender', 0, 13, -1, -1, 'M/F', 0, '2015-01-29 10:12:06', '2015-01-29 10:12:06', 'Contains the gender of the customer'),
(194, 'age', 0, 11, -1, -1, '-', 0, '2015-01-29 10:44:29', '2015-01-29 10:44:29', 'Contains the age of the customer'),
(195, 'age_range', 0, 23, -1, -1, '', 0, '2015-01-29 10:45:33', '2015-01-29 10:45:33', 'Contains the age-range of the customer'),
(196, 'age_range.unit', 0, 13, -1, 195, 'years', 0, '2015-01-29 10:47:29', '2015-01-29 10:47:29', 'Contains the unit (years/days/months) of age-range of the customer'),
(197, 'age_range.lower', 0, 11, -1, 195, '--', 0, '2015-01-29 10:48:06', '2015-01-29 10:48:06', 'Contains the lower limit of the age-range of the customer'),
(198, 'age_range.upper', 0, 11, -1, 195, '--', 0, '2015-01-29 10:48:19', '2015-01-29 10:48:19', 'Contains the upper limit of the age-range of the customer'),
(199, 'income_range', 0, 23, -1, -1, '', 0, '2015-01-29 10:48:45', '2015-01-29 10:48:45', 'Contains the income-range of the customer'),
(200, 'income_range.unit', 0, 13, -1, 199, 'lacs', 0, '2015-01-29 10:49:25', '2015-01-29 10:49:25', 'Contains the unit (lacs/crores/thousand) of age-range of the customer'),
(201, 'income_range.lower', 0, 11, -1, 199, '--', 0, '2015-01-29 10:49:43', '2015-01-29 10:49:43', 'Contains the lower limit of the income-range of the customer'),
(202, 'income_range.upper', 0, 11, -1, 199, '--', 0, '2015-01-29 10:49:57', '2015-01-29 10:49:57', 'Contains the upper limit of the income-range of the customer'),
(204, 'address.line2', 0, 13, -1, 152, '--', 0, '2015-01-29 10:54:36', '2015-01-29 10:54:36', 'Assoc key in address object that captures the line 2 in address'),
(205, 'address.line3', 0, 13, -1, 152, '--', 0, '2015-01-29 10:55:13', '2015-01-29 10:55:13', 'Assoc key in address object that captures the line 3 in address'),
(206, 'nationality', 0, 13, -1, -1, '--', 0, '2015-01-29 10:56:07', '2015-01-29 10:56:07', 'Captures the nationality of the customer'),
(207, 'occupations', 1, 23, -1, -1, '', 0, '2015-01-29 10:57:01', '2015-01-29 10:57:01', 'Array of assocs that captures the occupations of the customer'),
(208, 'occupations.title', 0, 13, -1, 207, '--', 0, '2015-01-29 10:58:28', '2015-01-29 10:58:28', 'Contains the designation of the ocuupation of the customer'),
(209, 'occupations.organization', 0, 13, -1, 207, '--', 0, '2015-01-29 10:59:17', '2015-01-29 10:59:17', 'Contains the organization of the occupation of the customer'),
(210, 'occupations.location', 0, 13, -1, 207, '--', 0, '2015-01-29 10:59:35', '2015-01-29 10:59:35', 'Contains the location of the organization of the occupation of the customer'),
(211, 'timezone', 0, 13, -1, -1, '--', 0, '2015-01-29 11:00:40', '2015-01-29 11:00:40', 'Contains the timezone in which the customer lies'),
(213, 'languages', 1, 13, -1, -1, '--', 0, '2015-01-29 12:09:55', '2015-01-29 12:22:03', 'Contains the list of languages known by the customer'),
(214, 'hobbies', 1, 13, -1, -1, '--', 0, '2015-01-29 12:21:21', '2015-01-29 12:21:21', 'Contains the list of hobbies of the customer'),
(216, 'anniversary', 0, 19, -1, -1, '--', 0, '2015-01-29 12:56:31', '2015-01-29 12:56:31', 'Contains the anniversary date of the customer'),
(217, 'spouse', 1, 23, -1, -1, '', 0, '2015-01-29 12:57:15', '2015-01-29 12:58:22', 'Araay of assocs that captures the spouse details of the customer'),
(218, 'spouse.name', 0, 13, -1, 217, '--', 0, '2015-01-29 12:59:05', '2015-01-29 12:59:05', 'Contains the name of the spouse of the customer'),
(219, 'spouse.number', 0, 11, -1, 217, '--', 0, '2015-01-29 12:59:22', '2015-01-29 12:59:22', 'Contains the contact number of the spouse of the customer'),
(220, 'friends', 1, 23, -1, -1, '', 0, '2015-01-29 13:12:54', '2015-01-29 13:12:54', 'Array of assocs that captures the details about the friends of the customer'),
(221, 'friends.name', 0, 13, -1, 220, '--', 0, '2015-01-29 13:14:10', '2015-01-29 13:14:10', 'Contains the name of the friend of the customer'),
(223, 'friends.email', 0, 13, -1, 220, '--', 0, '2015-01-29 13:14:55', '2015-01-29 13:14:55', 'Contains the email of the friend of the customer'),
(224, 'friends.phone', 0, 11, -1, 220, '--', 0, '2015-01-29 13:16:12', '2015-01-29 13:16:12', 'Contains the contact number of the friend of the customer'),
(225, 'communications', 0, 23, -1, -1, '', 0, '2015-01-29 13:18:59', '2015-01-29 13:18:59', 'An assoc object that contains the communications details of the customer'),
(226, 'married', 0, 24, -1, -1, '--', 0, '2015-01-29 13:21:28', '2015-01-29 13:21:28', 'Contains the marital status of the customer'),
(227, 'communications.subscribed', 0, 24, -1, -1, '--', 0, '2015-01-29 13:22:43', '2015-01-29 13:22:43', 'Captures if the customer has opted-in for communications'),
(228, 'communications.language', 0, 13, -1, -1, '--', 0, '2015-01-29 13:23:34', '2015-01-29 13:23:34', 'Captures for which language the customer has opted-in for communications'),
(229, 'communications.medium', 1, 13, -1, -1, '--', 0, '2015-01-29 13:25:02', '2015-01-29 13:25:02', 'Captures for which mediums has the customer subscribed to'),
(230, 'communications.newsletter', 0, 24, -1, -1, '--', 0, '2015-01-29 13:25:46', '2015-01-29 13:25:46', 'Captures if the customer has opted-in for receiving the newsletter'),
(231, 'communications.terms_and_conditions', 0, 24, -1, -1, '--', 0, '2015-01-29 13:26:19', '2015-01-29 13:26:19', 'Captures if the customer has accepted the ''terms and conditions'''),
(232, 'visit', 0, 23, -1, -1, '', 0, '2015-01-29 13:27:00', '2015-01-29 13:27:00', 'An assoc object that contains the visit details of the customer'),
(233, 'visit.rate_experience', 0, 11, -1, -1, '--', 0, '2015-01-29 13:28:19', '2015-01-29 13:28:19', 'Captures the customer''s experience rate'),
(234, 'visit.interested_in', 0, 13, -1, -1, '--', 0, '2015-01-29 13:29:18', '2015-01-29 13:29:18', 'Captures the products/services that the customer is interested in'),
(235, 'visit.quantity', 0, 11, -1, -1, '--', 0, '2015-01-29 13:30:08', '2015-01-29 13:30:08', 'Captures the quantity of the products/services that the customer is interested in'),
(236, 'visit.shopping_budget', 0, 23, -1, -1, '', 0, '2015-01-29 13:31:15', '2015-01-29 13:31:15', 'Captures the shopping budget for the customer''s visit'),
(237, 'visit.shopping_budget.unit', 0, 13, -1, 236, '--', 0, '2015-01-29 13:33:40', '2015-01-29 13:33:40', 'Contains the unit (lacs/crores/thousand) of shopping budget of the customer''s visit'),
(238, 'visit.shopping_budget.lower', 0, 11, -1, 236, '--', 0, '2015-01-29 13:34:07', '2015-01-29 13:34:07', 'Contains the lower limit of the shopping budget of the customer''s visit'),
(239, 'visit.shopping_budget.upper', 0, 11, -1, 236, '--', 0, '2015-01-29 13:34:19', '2015-01-29 13:34:19', 'Contains the upper limit of the shopping budget of the customer''s visit'),
(240, 'visit.know_about', 0, 13, -1, 232, '--', 0, '2015-01-29 13:35:35', '2015-01-29 13:35:35', 'Captures how the customer came to know about the brand/store'),
(241, 'visit.feedback', 0, 13, -1, 232, '--', 0, '2015-01-29 13:37:01', '2015-01-29 13:37:01', 'Captures the feedback of the customer on this visit'),
(242, 'preferences', 0, 23, -1, -1, '', 0, '2015-01-29 13:37:46', '2015-01-29 13:37:46', 'An assoc object that contains the preferences of the customer'),
(243, 'preferences.store', 0, 13, -1, 242, '--', 0, '2015-01-29 13:38:13', '2015-01-29 13:38:13', 'Captures the preferred store of the customer'),
(244, 'preferences.cashier', 0, 13, -1, 242, '--', 0, '2015-01-29 13:38:34', '2015-01-29 13:38:34', 'Captures the preferred cashier of the customer'),
(245, 'preferences.favourite_products', 1, 13, -1, 242, '--', 0, '2015-01-29 13:39:21', '2015-01-29 13:39:21', 'Captures the favourite products of the customer'),
(246, 'profile_complete_percentage', 1, 11, -1, -1, '--', 0, '2015-01-29 13:40:55', '2015-01-29 13:40:55', 'Captures the percentage of the customer''s profile completion'),
(247, 'phones', 1, 23, 248, -1, '', 0, '2015-01-29 13:42:24', '2015-01-29 13:44:18', 'Array of phone objects of the customer'),
(248, 'phone', 0, 23, -1, -1, '', 0, '2015-01-29 13:43:35', '2015-01-29 13:43:35', 'Captures the contact number of the customer'),
(249, 'phone.country_code', 0, 11, -1, 248, '--', 0, '2015-01-29 13:45:22', '2015-01-29 13:45:22', 'Captures the country code in the contact number of the customer'),
(250, 'phone.number', 0, 11, -1, 248, '--', 0, '2015-01-29 13:46:01', '2015-01-29 13:46:01', 'Captures the number in the contact number of the customer');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2017 at 11:32 AM
-- Server version: 5.6.34-log
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodne6_villagex`
--

-- --------------------------------------------------------

--
-- Table structure for table `cost_types`
--

CREATE TABLE IF NOT EXISTS `cost_types` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_icon` varchar(50) NOT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_label` varchar(100) NOT NULL,
  `country_latitude` float NOT NULL,
  `country_longitude` float NOT NULL,
  `country_zoom` int(11) NOT NULL,
  `country_url` varchar(100) NOT NULL,
  `country_organization` varchar(300) NOT NULL,
  `country_org_url` varchar(200) NOT NULL,
  `country_code` char(2) NOT NULL,
  `country_bounds_sw_lat` float(10,6) NOT NULL,
  `country_bounds_sw_lng` float(10,6) NOT NULL,
  `country_bounds_ne_lat` float(10,6) NOT NULL,
  `country_bounds_ne_lng` float(10,6) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE IF NOT EXISTS `districts` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(50) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `donation_id` int(11) NOT NULL AUTO_INCREMENT,
  `donation_donor_id` int(11) NOT NULL,
  `donation_amount` float NOT NULL,
  `donation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `donation_project_id` int(11) NOT NULL,
  `donation_is_pending` int(1) NOT NULL DEFAULT '0',
  `donation_subscription_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`donation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE IF NOT EXISTS `donors` (
  `donor_id` int(11) NOT NULL AUTO_INCREMENT,
  `donor_email` varchar(200) NOT NULL,
  `donor_first_name` varchar(50) NOT NULL,
  `donor_last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`donor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE IF NOT EXISTS `editors` (
  `editor_id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_username` int(50) NOT NULL,
  `editor_password` varchar(32) NOT NULL,
  PRIMARY KEY (`editor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `field_officers`
--

CREATE TABLE IF NOT EXISTS `field_officers` (
  `fo_id` int(11) NOT NULL AUTO_INCREMENT,
  `fo_first_name` varchar(50) NOT NULL,
  `fo_last_name` varchar(50) NOT NULL,
  `fo_picture_id` int(11) DEFAULT NULL,
  `fo_bio` text,
  `fo_email` varchar(100) NOT NULL,
  `fo_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`fo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_subject` varchar(500) DEFAULT NULL,
  `mail_body` text,
  `mail_from` varchar(300) DEFAULT NULL,
  `mail_to` varchar(200) DEFAULT NULL,
  `mail_queued` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mail_sent` timestamp NULL DEFAULT NULL,
  `mail_result` varchar(511) DEFAULT NULL,
  `mail_reply` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `mail_sent_index` (`mail_sent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=355543 ;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_filename` varchar(50) NOT NULL,
  PRIMARY KEY (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2232 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_village_id` int(11) NOT NULL,
  `project_profile_image_id` int(11) NOT NULL DEFAULT '0',
  `project_banner_image_id` int(11) NOT NULL,
  `project_similar_image_id` int(11) DEFAULT NULL,
  `project_name` varchar(200) NOT NULL,
  `project_lat` float NOT NULL,
  `project_lng` float NOT NULL,
  `project_summary` text,
  `project_community_problem` varchar(2047) DEFAULT NULL,
  `project_community_solution` varchar(2047) DEFAULT NULL,
  `project_community_partners` varchar(512) DEFAULT NULL,
  `project_impact` varchar(1023) DEFAULT NULL,
  `project_budget` float NOT NULL,
  `project_funded` float NOT NULL DEFAULT '0',
  `project_type` enum('farm','house','library','livestock','nursery','office','school','water') DEFAULT NULL,
  `project_status` enum('proposed','funding','construction','completed','cancelled') DEFAULT NULL,
  `project_staff_id` int(11) NOT NULL,
  `project_date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=137 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_costs`
--

CREATE TABLE IF NOT EXISTS `project_costs` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_project_id` int(11) NOT NULL,
  `pc_label` varchar(255) NOT NULL,
  `pc_amount` int(11) NOT NULL,
  `pc_type` int(11) NOT NULL,
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2407 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_events`
--

CREATE TABLE IF NOT EXISTS `project_events` (
  `pe_id` int(11) NOT NULL AUTO_INCREMENT,
  `pe_date` date NOT NULL,
  `pe_description` varchar(255) NOT NULL,
  `pe_project_id` int(11) NOT NULL,
  PRIMARY KEY (`pe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1513 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_updates`
--

CREATE TABLE IF NOT EXISTS `project_updates` (
  `pu_id` int(11) NOT NULL AUTO_INCREMENT,
  `pu_project_id` int(11) DEFAULT NULL,
  `pu_image_id` int(11) NOT NULL,
  `pu_description` varchar(512) DEFAULT NULL,
  `pu_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pu_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1587 ;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(50) NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `stat_types`
--

CREATE TABLE IF NOT EXISTS `stat_types` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_label` varchar(50) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_disbursals`
--

CREATE TABLE IF NOT EXISTS `subscription_disbursals` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_amount` float NOT NULL,
  `sd_project_id` int(11) NOT NULL,
  `sd_donor_id` int(11) NOT NULL,
  `sd_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE IF NOT EXISTS `villages` (
  `village_id` int(11) NOT NULL AUTO_INCREMENT,
  `village_name` varchar(50) NOT NULL,
  `village_district` int(11) NOT NULL DEFAULT '0',
  `village_region` int(11) NOT NULL DEFAULT '0',
  `village_country` int(11) NOT NULL DEFAULT '0',
  `village_lat` float NOT NULL,
  `village_lng` float NOT NULL,
  `village_thumbnail` int(11) DEFAULT '0',
  `village_summary` text,
  `village_pending` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`village_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Table structure for table `village_stats`
--

CREATE TABLE IF NOT EXISTS `village_stats` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_type_id` int(11) NOT NULL,
  `stat_village_id` int(11) NOT NULL,
  `stat_value` float NOT NULL,
  `stat_year` year(4) NOT NULL,
  PRIMARY KEY (`stat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1631 ;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_events`
--

CREATE TABLE IF NOT EXISTS `webhook_events` (
  `we_id` int(11) NOT NULL AUTO_INCREMENT,
  `we_content` text NOT NULL,
  `we_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`we_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=153 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

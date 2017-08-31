-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 31, 2017 at 09:12 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `villagex`
--

-- --------------------------------------------------------

--
-- Table structure for table `cost_types`
--

CREATE TABLE `cost_types` (
  `ct_id` int(11) NOT NULL,
  `ct_icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
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
  `country_bounds_ne_lng` float(10,6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `donation_donor_id` int(11) NOT NULL,
  `donation_amount` float NOT NULL,
  `donation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `donation_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `donor_id` int(11) NOT NULL,
  `donor_email` varchar(200) NOT NULL,
  `donor_first_name` varchar(50) NOT NULL,
  `donor_last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `field_officers`
--

CREATE TABLE `field_officers` (
  `fo_id` int(11) NOT NULL,
  `fo_first_name` varchar(50) NOT NULL,
  `fo_last_name` varchar(50) NOT NULL,
  `fo_picture_id` int(11) DEFAULT NULL,
  `fo_bio` text,
  `fo_email` varchar(100) NOT NULL,
  `fo_phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `picture_id` int(11) NOT NULL,
  `picture_filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
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
  `project_impact` varchar(1023) NOT NULL,
  `project_budget` float NOT NULL,
  `project_funded` float NOT NULL DEFAULT '0',
  `project_type` enum('farm','house','library','livestock','nursery','office','school','water') DEFAULT NULL,
  `project_status` enum('proposed','funding','construction','completed','cancelled') DEFAULT NULL,
  `project_staff_id` int(11) NOT NULL,
  `project_date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_costs`
--

CREATE TABLE `project_costs` (
  `pc_id` int(11) NOT NULL,
  `pc_project_id` int(11) NOT NULL,
  `pc_label` varchar(255) NOT NULL,
  `pc_amount` int(11) NOT NULL,
  `pc_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_events`
--

CREATE TABLE `project_events` (
  `pe_id` int(11) NOT NULL,
  `pe_date` date NOT NULL,
  `pe_description` varchar(255) NOT NULL,
  `pe_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_updates`
--

CREATE TABLE `project_updates` (
  `pu_id` int(11) NOT NULL,
  `pu_project_id` int(11) DEFAULT NULL,
  `pu_image_id` int(11) NOT NULL,
  `pu_description` varchar(512) DEFAULT NULL,
  `pu_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pu_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stat_types`
--

CREATE TABLE `stat_types` (
  `st_id` int(11) NOT NULL,
  `st_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `village_id` int(11) NOT NULL,
  `village_name` varchar(50) NOT NULL,
  `village_district` int(11) NOT NULL DEFAULT '0',
  `village_region` int(11) NOT NULL DEFAULT '0',
  `village_country` int(11) NOT NULL DEFAULT '0',
  `village_lat` float NOT NULL,
  `village_lng` float NOT NULL,
  `village_thumbnail` int(11) DEFAULT '0',
  `village_summary` text,
  `village_pending` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `village_stats`
--

CREATE TABLE `village_stats` (
  `stat_id` int(11) NOT NULL,
  `stat_type_id` int(11) NOT NULL,
  `stat_village_id` int(11) NOT NULL,
  `stat_value` float NOT NULL,
  `stat_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cost_types`
--
ALTER TABLE `cost_types`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `field_officers`
--
ALTER TABLE `field_officers`
  ADD PRIMARY KEY (`fo_id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`picture_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_costs`
--
ALTER TABLE `project_costs`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `project_events`
--
ALTER TABLE `project_events`
  ADD PRIMARY KEY (`pe_id`);

--
-- Indexes for table `project_updates`
--
ALTER TABLE `project_updates`
  ADD PRIMARY KEY (`pu_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `stat_types`
--
ALTER TABLE `stat_types`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`village_id`);

--
-- Indexes for table `village_stats`
--
ALTER TABLE `village_stats`
  ADD PRIMARY KEY (`stat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cost_types`
--
ALTER TABLE `cost_types`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `field_officers`
--
ALTER TABLE `field_officers`
  MODIFY `fo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2232;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `project_costs`
--
ALTER TABLE `project_costs`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1675;
--
-- AUTO_INCREMENT for table `project_events`
--
ALTER TABLE `project_events`
  MODIFY `pe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1055;
--
-- AUTO_INCREMENT for table `project_updates`
--
ALTER TABLE `project_updates`
  MODIFY `pu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1587;
--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stat_types`
--
ALTER TABLE `stat_types`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `village_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `village_stats`
--
ALTER TABLE `village_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1345;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

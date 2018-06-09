-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2018 at 09:01 AM
-- Server version: 10.2.11-MariaDB-log
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
-- Database: `foodne6_villagex`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `ad_message` varchar(300) NOT NULL,
  `ad_org` int(11) NOT NULL DEFAULT -1,
  `ad_type` int(11) NOT NULL DEFAULT -1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `donation_project_id` int(11) NOT NULL,
  `donation_subscription_id` varchar(100) DEFAULT NULL,
  `donation_remote_id` varchar(100) DEFAULT NULL,
  `donation_code` varchar(10) DEFAULT NULL,
  `donation_honoree_id` int(11) NOT NULL DEFAULT 0,
  `donation_gc_id` int(11) DEFAULT NULL,
  `donation_is_test` int(11) NOT NULL DEFAULT 0,
  `donation_fundraiser_id` int(11) DEFAULT NULL,
  `donation_message` varchar(511) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `donor_id` int(11) NOT NULL,
  `donor_email` varchar(200) NOT NULL,
  `donor_first_name` varchar(50) NOT NULL,
  `donor_last_name` varchar(100) NOT NULL,
  `donor_primary_color` varchar(20) DEFAULT NULL,
  `donor_logo` varchar(200) DEFAULT NULL,
  `donor_location` varchar(100) DEFAULT NULL,
  `donor_password` varchar(32) NOT NULL DEFAULT current_timestamp()
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
  `fo_bio` text DEFAULT NULL,
  `fo_email` varchar(100) NOT NULL,
  `fo_phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fundraisers`
--

CREATE TABLE `fundraisers` (
  `fundraiser_id` int(11) NOT NULL,
  `fundraiser_title` varchar(200) NOT NULL,
  `fundraiser_donor_id` int(11) NOT NULL,
  `fundraiser_project_id` int(11) NOT NULL,
  `fundraiser_deadline` int(11) NOT NULL,
  `fundraiser_amount` int(11) NOT NULL,
  `fundraiser_funded` int(11) NOT NULL,
  `fundraiser_description` varchar(2047) NOT NULL,
  `fundraiser_subject` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gift_certificates`
--

CREATE TABLE `gift_certificates` (
  `gc_id` int(11) NOT NULL,
  `gc_value` float NOT NULL,
  `gc_quantity` int(11) NOT NULL,
  `gc_alert` varchar(511) NOT NULL,
  `gc_code` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL,
  `mail_subject` varchar(500) DEFAULT NULL,
  `mail_body` longtext DEFAULT NULL,
  `mail_from` varchar(300) DEFAULT NULL,
  `mail_to` varchar(200) DEFAULT NULL,
  `mail_queued` timestamp NULL DEFAULT current_timestamp(),
  `mail_sent` timestamp NULL DEFAULT NULL,
  `mail_result` varchar(511) DEFAULT NULL,
  `mail_reply` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message_from` int(11) NOT NULL,
  `message_to` int(11) NOT NULL,
  `message_text` varchar(2047) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `project_profile_image_id` int(11) NOT NULL DEFAULT 0,
  `project_banner_image_id` int(11) NOT NULL,
  `project_similar_image_id` int(11) DEFAULT NULL,
  `project_name` varchar(200) NOT NULL,
  `project_lat` float NOT NULL,
  `project_lng` float NOT NULL,
  `project_summary` text DEFAULT NULL,
  `project_community_problem` varchar(2047) DEFAULT NULL,
  `project_community_solution` varchar(2047) DEFAULT NULL,
  `project_community_partners` varchar(512) DEFAULT NULL,
  `project_impact` varchar(4097) DEFAULT NULL,
  `project_budget` float NOT NULL,
  `project_funded` float NOT NULL DEFAULT 0,
  `project_type` enum('farm','house','library','livestock','nursery','office','school','water','business') DEFAULT NULL,
  `project_status` enum('proposed','funding','construction','completed','cancelled') DEFAULT NULL,
  `project_staff_id` int(11) NOT NULL,
  `project_date_posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `project_elapsed_days` int(11) NOT NULL DEFAULT 0,
  `project_people_reached` int(11) NOT NULL DEFAULT 0,
  `project_matching_donor` int(11) NOT NULL DEFAULT 0,
  `project_completion` text DEFAULT NULL,
  `project_youtube_id` varchar(20) DEFAULT NULL
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
  `pe_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pe_type` int(11) NOT NULL,
  `pe_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_event_types`
--

CREATE TABLE `project_event_types` (
  `pet_id` int(11) NOT NULL,
  `pet_label` varchar(100) NOT NULL
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
  `pu_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `pu_user_id` int(11) DEFAULT NULL,
  `pu_exemplary` int(1) NOT NULL DEFAULT 0
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
-- Table structure for table `subscription_disbursals`
--

CREATE TABLE `subscription_disbursals` (
  `sd_id` int(11) NOT NULL,
  `sd_amount` float NOT NULL,
  `sd_project_id` int(11) NOT NULL,
  `sd_donor_id` int(11) NOT NULL,
  `sd_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_requests`
--

CREATE TABLE `travel_requests` (
  `tr_id` int(11) NOT NULL,
  `tr_first_name` varchar(63) NOT NULL,
  `tr_last_name` varchar(63) NOT NULL,
  `tr_email` varchar(127) NOT NULL,
  `tr_departure_date` date NOT NULL,
  `tr_return_date` date NOT NULL,
  `tr_additional_info` text NOT NULL,
  `tr_group_type` varchar(30) NOT NULL,
  `tr_group_size` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `village_id` int(11) NOT NULL,
  `village_name` varchar(50) NOT NULL,
  `village_district` int(11) NOT NULL DEFAULT 0,
  `village_region` int(11) NOT NULL DEFAULT 0,
  `village_country` int(11) NOT NULL DEFAULT 0,
  `village_lat` float NOT NULL,
  `village_lng` float NOT NULL,
  `village_thumbnail` int(11) DEFAULT 0,
  `village_summary` text DEFAULT NULL,
  `village_pending` int(11) NOT NULL DEFAULT 0
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

-- --------------------------------------------------------

--
-- Table structure for table `webhook_events`
--

CREATE TABLE `webhook_events` (
  `we_id` int(11) NOT NULL,
  `we_content` text NOT NULL,
  `we_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

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
-- Indexes for table `fundraisers`
--
ALTER TABLE `fundraisers`
  ADD PRIMARY KEY (`fundraiser_id`);

--
-- Indexes for table `gift_certificates`
--
ALTER TABLE `gift_certificates`
  ADD PRIMARY KEY (`gc_id`);

--
-- Indexes for table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`mail_id`),
  ADD KEY `mail_sent_index` (`mail_sent`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

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
-- Indexes for table `project_event_types`
--
ALTER TABLE `project_event_types`
  ADD PRIMARY KEY (`pet_id`);

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
-- Indexes for table `subscription_disbursals`
--
ALTER TABLE `subscription_disbursals`
  ADD PRIMARY KEY (`sd_id`);

--
-- Indexes for table `travel_requests`
--
ALTER TABLE `travel_requests`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

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
-- Indexes for table `webhook_events`
--
ALTER TABLE `webhook_events`
  ADD PRIMARY KEY (`we_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=961;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=722;

--
-- AUTO_INCREMENT for table `field_officers`
--
ALTER TABLE `field_officers`
  MODIFY `fo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fundraisers`
--
ALTER TABLE `fundraisers`
  MODIFY `fundraiser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gift_certificates`
--
ALTER TABLE `gift_certificates`
  MODIFY `gc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mail`
--
ALTER TABLE `mail`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=670;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2552;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `project_costs`
--
ALTER TABLE `project_costs`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6433;

--
-- AUTO_INCREMENT for table `project_events`
--
ALTER TABLE `project_events`
  MODIFY `pe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3789;

--
-- AUTO_INCREMENT for table `project_event_types`
--
ALTER TABLE `project_event_types`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_updates`
--
ALTER TABLE `project_updates`
  MODIFY `pu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1805;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stat_types`
--
ALTER TABLE `stat_types`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `subscription_disbursals`
--
ALTER TABLE `subscription_disbursals`
  MODIFY `sd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `travel_requests`
--
ALTER TABLE `travel_requests`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `village_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `village_stats`
--
ALTER TABLE `village_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5283;

--
-- AUTO_INCREMENT for table `webhook_events`
--
ALTER TABLE `webhook_events`
  MODIFY `we_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1121;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

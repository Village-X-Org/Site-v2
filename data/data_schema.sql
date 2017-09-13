-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2017 at 03:16 PM
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

--
-- Dumping data for table `cost_types`
--

INSERT INTO `cost_types` (`ct_id`, `ct_icon`) VALUES
(1, 'directions_run'),
(2, 'domain'),
(3, 'all_inclusive'),
(4, 'directions_bus'),
(5, 'account_balance'),
(6, 'camera_alt');

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

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_label`, `country_latitude`, `country_longitude`, `country_zoom`, `country_url`, `country_organization`, `country_org_url`, `country_code`, `country_bounds_sw_lat`, `country_bounds_sw_lng`, `country_bounds_ne_lat`, `country_bounds_ne_lng`) VALUES
(1, 'Madagascar', -18.7669, 46.8691, 5, 'madagascar.pcvmap.com', '', '', 'mg', -25.383318, 43.410259, -11.874795, 50.363022),
(2, 'Sierra Leone', 8.46056, -11.7799, 8, 'salone.rpcvs.com', 'Friends of Sierra Leone', 'http://www.friendsofsierraleone.org/', 'sl', 0.000000, 0.000000, 0.000000, 0.000000),
(3, 'Mexico', 23.6345, -102.553, 5, 'mexico.pcvmap.com', '', '', 'mx', 0.000000, 0.000000, 0.000000, 0.000000),
(4, 'Guatemala', 15.7835, -90.2308, 6, 'guatemala.pcvmap.com', 'Friends of Guatemala', '', 'gt', 0.000000, 0.000000, 0.000000, 0.000000),
(5, 'Belize', 17.1899, -88.4977, 7, 'belize.pcvmap.com', 'Full Basket Belize', 'http://www.fullbasketbelize.org/', 'bz', 0.000000, 0.000000, 0.000000, 0.000000),
(6, 'Nicaragua', 12.8654, -85.2072, 8, 'nicaragua.pcvmap.com', '', '', 'ni', 0.000000, 0.000000, 0.000000, 0.000000),
(7, 'El Salvador', 13.7942, -88.8965, 9, 'elsalvador.pcvmap.com', '', '', 'sv', 0.000000, 0.000000, 0.000000, 0.000000),
(8, 'Costa Rica', 9.74892, -83.7534, 8, 'costarica.pcvmap.com', 'Friends of Costa Rica', 'http://www.friendsofcostarica.com/', 'cr', 0.000000, 0.000000, 0.000000, 0.000000),
(9, 'Honduras', 15.2, -86.2419, 7, 'honduras.pcvmap.com', 'Amigos de Honduras', '', 'hn', 0.000000, 0.000000, 0.000000, 0.000000),
(10, 'Paraguay', -23.4425, -58.4438, 6, 'paraguay.pcvmap.com', 'Friends of Paraguay', 'http://www.friendsofparaguay.org/', 'py', 0.000000, 0.000000, 0.000000, 0.000000),
(11, 'Uruguay', -32.5228, -55.7658, 6, 'uruguay.pcvmap.com', '', '', 'uy', 0.000000, 0.000000, 0.000000, 0.000000),
(12, 'Argentina', -38.4161, -63.6167, 4, 'argentina.pcvmap.com', '', '', 'ar', 0.000000, 0.000000, 0.000000, 0.000000),
(13, 'Chile', -35.6751, -71.543, 4, 'chile.pcvmap.com', '', '', 'cl', 0.000000, 0.000000, 0.000000, 0.000000),
(14, 'Bolivia', -16.2902, -63.5887, 5, 'bolivia.pcvmap.com', 'Amigos de Bolivia y Peru', 'http://www.amigosdeboliviayperu.org/', 'bo', 0.000000, 0.000000, 0.000000, 0.000000),
(15, 'Peru', -9.18997, -75.0152, 5, 'peru.pcvmap.com', 'Amigos de Bolivia y Peru', 'http://www.amigosdeboliviayperu.org/', 'pe', 0.000000, 0.000000, 0.000000, 0.000000),
(16, 'Brazil', -14.235, -51.9253, 4, 'brazil.pcvmap.com', '', '', 'br', 0.000000, 0.000000, 0.000000, 0.000000),
(17, 'Ecuador', -1.83124, -78.1834, 6, 'ecuador.pcvmap.com', 'Friends of Ecuador', 'http://www.friendsofecuador.org/', 'ec', 0.000000, 0.000000, 0.000000, 0.000000),
(18, 'Suriname', 3.91931, -56.0278, 6, 'suriname.pcvmap.com', '', '', 'sr', 0.000000, 0.000000, 0.000000, 0.000000),
(19, 'Guyana', 4.86042, -58.9302, 6, 'guyana.pcvmap.com', 'Friends and RPCVs of Guyana', 'http://www.guyfrog.org/', 'gy', 0.000000, 0.000000, 0.000000, 0.000000),
(20, 'Colombia', 4.57087, -74.2973, 5, 'colombia.pcvmap.com', 'Friends of Colombia', 'http://www.friendsofcolombia.org/', 'co', 0.000000, 0.000000, 0.000000, 0.000000),
(21, 'Venezuela', 6.42375, -66.5897, 5, 'venezuela.pcvmap.com', '', '', 've', 0.000000, 0.000000, 0.000000, 0.000000),
(22, 'Panama', 8.53798, -80.7821, 7, 'panama.pcvmap.com', 'Peace Corps Panama Friends', 'http://www.panamapcv.net/', 'pa', 0.000000, 0.000000, 0.000000, 0.000000),
(23, 'Jamaica', 18.1096, -77.2975, 8, 'jamaica.pcvmap.com', 'Friends of Jamaica Peace Corps Association', 'http://servejamaica.org/', 'jm', 0.000000, 0.000000, 0.000000, 0.000000),
(24, 'Haiti', 18.9712, -72.2852, 8, 'haiti.pcvmap.com', 'Peace Corps Friends of Haiti', 'http://pcfoh.wildapricot.org/', 'ht', 0.000000, 0.000000, 0.000000, 0.000000),
(25, 'Dominican Republic', 18.7357, -70.1627, 8, 'dr.pcvmap.com', 'Friends of the Dominican Republic', 'http://www.fotdr.org/', 'do', 0.000000, 0.000000, 0.000000, 0.000000),
(26, 'Saints Kitts and Nevis', 17.3578, -62.783, 10, 'skn.pcvmap.com', '', '', 'kn', 0.000000, 0.000000, 0.000000, 0.000000),
(27, 'Antigua and Barbuda', 17.0608, -61.7964, 10, 'ab.pcvmap.com', '', '', 'ag', 0.000000, 0.000000, 0.000000, 0.000000),
(28, 'Dominica', 15.415, -61.371, 10, 'dominica.pcvmap.com', 'Friends of Eastern Caribbean', 'http://friendsofec.org/', 'dm', 0.000000, 0.000000, 0.000000, 0.000000),
(29, 'Saint Lucia', 13.9094, -60.9789, 10, 'saintlucia.pcvmap.com', '', '', 'lc', 0.000000, 0.000000, 0.000000, 0.000000),
(30, 'Saint Vincent and the Grenadines', 13.2528, -61.1972, 8, 'svg.pcvmap.com', '', '', 'vc', 0.000000, 0.000000, 0.000000, 0.000000),
(31, 'Barbados', 13.1939, -59.5432, 11, 'barbados.pcvmap.com', '', '', 'bb', 0.000000, 0.000000, 0.000000, 0.000000),
(32, 'Grenada', 12.1165, -61.679, 11, 'grenada.pcvmap.com', 'Friends of Eastern Caribbean', 'https://sites.google.com/a/friendsofec.org/friendsofec/home', 'gd', 0.000000, 0.000000, 0.000000, 0.000000),
(33, 'Togo', 8.61954, 0.824782, 6, 'togo.pcvmap.com', 'Friends of Togo', '', 'tg', 0.000000, 0.000000, 0.000000, 0.000000),
(34, 'Ghana', 7.94653, -1.02319, 6, 'ghana.pcvmap.com', 'Friends of Ghana', 'http://www.friendsofghana.org/', 'gh', 5.006628, -3.143765, 11.084570, 0.690463),
(35, 'Indonesia', -0.789275, 113.921, 4, 'indonesia.pcvmap.com', '', '', 'id', 0.000000, 0.000000, 0.000000, 0.000000),
(36, 'Zimbabwe', -19.0154, 29.1549, 7, 'zimbabwe.pcvmap.com', '', '', 'zw', 0.000000, 0.000000, 0.000000, 0.000000),
(37, 'Kazakhstan', 48.0196, 66.9237, 4, 'kazakhstan.pcvmap.com', '', '', 'kz', 0.000000, 0.000000, 0.000000, 0.000000),
(38, 'Kyrgyzstan', 41.2044, 74.7661, 6, 'kyrgyzstan.pcvmap.com', 'Friends of Kyrgyzstan', 'http://www.friendsofkyrgyzstan.org/', 'kg', 0.000000, 0.000000, 0.000000, 0.000000),
(39, 'Australia', 0, 0, 0, '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(52, 'World Wise Schools', 131071, 0, -8, 'wws.pcvmap.com', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(41, 'Jordan', 30.5852, 36.2384, 8, 'jordan.pcvmap.com', 'Friends of Jordan Association', 'http://friendsofjordan.org/', 'jo', 0.000000, 0.000000, 0.000000, 0.000000),
(70, 'Afghanistan', 33.8524, 63.209, 6, '', 'Friends of Afghanistan', 'http://afghanconnections.org/', 'af', 0.000000, 0.000000, 0.000000, 0.000000),
(43, 'Morocco', 31.7917, -7.09262, 5, 'morocco.pcvmap.com', 'Friends of Morocco', 'http://friendsofmorocco.org/', 'ma', 0.000000, 0.000000, 0.000000, 0.000000),
(44, 'China', 35.8617, 104.195, 4, 'china.pcvmap.com', 'Returned Peace Corps Volunteers of China', '', 'cn', 0.000000, 0.000000, 0.000000, 0.000000),
(45, 'Vanuatu', -15.3767, 166.959, 6, 'vanuatu.pcvmap.com', '', '', 'vu', 0.000000, 0.000000, 0.000000, 0.000000),
(46, 'Mozambique', -18.6657, 35.5296, 6, 'mozambique.pcvmap.com', 'Friends of Mozambique', '', 'mz', -26.926600, 30.386148, -10.471201, 40.493568),
(47, 'Stomping Out Malaria in Africa', 131071, 0, -6, 'malaria.pcvmap.com', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(48, 'Blog Contest', 131071, 0, -7, 'blogcontest.pcvmap.com', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(49, 'Moldova', 47.4116, 28.3699, 6, 'moldova.pcvmap.com', '', '', 'md', 0.000000, 0.000000, 0.000000, 0.000000),
(50, 'Romania', 45.9432, 24.9668, 7, 'romania.pcvmap.com', '', '', 'ro', 0.000000, 0.000000, 0.000000, 0.000000),
(51, 'Senegal', 14.4974, -14.4524, 7, 'senegal.pcvmap.com', 'Friends of Senegal and the Gambia', 'http://groups.yahoo.com/group/FriendsofSenegalGambia/', 'sn', 12.299466, -17.332460, 16.617489, -11.542665),
(53, 'Cambodia', 12.5657, 104.991, 6, '', '', '', 'kh', 0.000000, 0.000000, 0.000000, 0.000000),
(54, 'Benin', 9.30769, 2.31583, 6, 'benin.pcvmap.com', '', '', 'bj', 0.000000, 0.000000, 0.000000, 0.000000),
(55, 'Cameroon', 7.36972, 12.3547, 5, '', 'Friends of Cameroon', 'http://www.friendsofcameroon.org/', 'cm', 0.000000, 0.000000, 0.000000, 0.000000),
(56, 'South Africa', -30.5595, 22.9375, 5, '', '', '', 'za', 0.000000, 0.000000, 0.000000, 0.000000),
(57, 'Salone 4', 131071, 0, -4, 'salone4.pcvmap.com', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(58, 'Burkina Faso', 12.2383, -1.56159, 6, '', 'Friends of Burkina Faso', 'http://fbf.tamu.edu/', 'bf', 0.000000, 0.000000, 0.000000, 0.000000),
(59, 'Niger', 17.6078, 8.08167, 5, '', 'Friends of Niger', 'http://www.friendsofniger.org/', 'ne', 12.011553, -0.103098, 23.376135, 15.755450),
(60, 'Mali', 17.5707, -3.99617, 5, '', '', '', 'ml', 11.094574, -11.421816, 25.722946, 4.574277),
(61, 'The Gambia', 13.4432, -15.3101, 8, '', 'Friends of Senegal and the Gambia', 'http://groups.yahoo.com/group/FriendsofSenegalGambia/', 'gm', 12.964127, -16.893007, 13.797789, -13.838800),
(62, 'Georgia', 42.303, 42.2484, 7, '', 'The Megobari Foundation', 'http://www.megobari.org/', 'ge', 0.000000, 0.000000, 0.000000, 0.000000),
(63, 'Albania', 41.1533, 20.1683, 7, '', 'Friends of Albania', 'https://www.facebook.com/friendsofalbania', 'al', 0.000000, 0.000000, 0.000000, 0.000000),
(64, 'Azerbaijan', 40.1431, 47.5769, 7, '', 'Friends of Azerbaijan', 'https://www.facebook.com/groups/friends.of.azerbaijan', 'az', 0.000000, 0.000000, 0.000000, 0.000000),
(65, 'Philippines', 12.8797, 121.774, 5, '', 'Peace Corps Alumni Foundation for Philippine Development', 'http://rpcvphilippines.org/', 'ph', 0.000000, 0.000000, 0.000000, 0.000000),
(66, 'Ukraine', 48.3794, 31.1656, 5, '', '', '', 'ua', 0.000000, 0.000000, 0.000000, 0.000000),
(67, 'Liberia', 6.42805, -9.4295, 7, '', 'Friends of Liberia', 'http://www.fol.org/', 'lr', 0.000000, 0.000000, 0.000000, 0.000000),
(68, 'Botswana', -22.3285, 24.6849, 6, '', 'Friends of Botswana', '', 'bw', 0.000000, 0.000000, 0.000000, 0.000000),
(69, 'Guinea', 9.94559, -9.69664, 6, '', 'Friends of Guinea', 'http://friendsofguinea.org/', 'gn', 0.000000, 0.000000, 0.000000, 0.000000),
(71, 'Armenia', 40.0652, 43.9195, 8, '', 'Friends of Armenia', 'http://www.friendsofarmeniaonline.org/', 'am', 0.000000, 0.000000, 0.000000, 0.000000),
(72, 'Democratic Republic of the Congo', -2.80443, 23.318, 5, '', 'Peace Corps Friends of DR Congo', 'http://www.sangonini.org/', 'cd', -13.009740, 12.420144, 4.844854, 30.789284),
(73, 'Cote d\'Ivoire', 7.81167, -5.62765, 6, '', 'Friends of Cote D\'Ivoire', 'https://www.facebook.com/groups/8510168090/', 'ci', 4.673835, -8.071432, 10.248641, -2.524847),
(74, 'Ethiopia', 9.12144, 35.9987, 6, '', 'Ethiopia and Eritrea RPCVs', 'http://eandeherald.com/', 'et', 3.913753, 33.074440, 15.013937, 48.257545),
(75, 'Fiji', -17.4499, 177.013, 7, '', 'Friends of Fiji', 'http://fofiji.org/', 'fj', 0.000000, 0.000000, 0.000000, 0.000000),
(76, 'Gabon', -0.820718, 9.36769, 7, '', 'Friends of Gabon', '', '', 0.000000, 0.000000, 0.000000, 0.000000),
(77, 'India', 20.1457, 64.4357, 4, '', 'Friends of India', 'http://ganga633.squarespace.com/', 'in', 0.000000, 0.000000, 0.000000, 0.000000),
(78, 'Iran', 32.0991, 44.6648, 5, '', 'Peace Corps Iran Association', 'http://www.peacecorpsiran.org/', 'ir', 0.000000, 0.000000, 0.000000, 0.000000),
(79, 'Kenya', 0.176336, 33.4072, 6, '', 'Friends of Kenya', 'https://sites.google.com/site/friendsofkenyarpcv/home', 'ke', -4.800718, 34.063210, 4.571122, 41.929420),
(80, 'South Korea', 36.4313, 128.053, 6, '', 'Friends of Korea', 'http://www.friendsofkorea.net/', 'kr', 0.000000, 0.000000, 0.000000, 0.000000),
(81, 'Lesotho', -29.6185, 28.2239, 6, '', 'Friends of Lesotho', 'http://friendsoflesotho.org/', 'ls', -30.644646, 26.947428, -28.605864, 29.435831),
(82, 'Macedonia', 41.6103, 21.5009, 7, '', 'Friends of Macedonia', 'http://www.friendsofmacedonia.com/', 'mk', 0.000000, 0.000000, 0.000000, 0.000000),
(83, 'Malawi', -13.209, 34.208, 6, '', 'Friends of Malawi', 'http://www.friendsofmalawi.org/', 'mw', -16.931801, 32.807201, -9.493540, 35.662498),
(84, 'Malaysia', 4.08916, 100.559, 5, '', 'Friends of Malaysia', 'http://www.friendsofmalaysia.net/', 'my', 0.000000, 0.000000, 0.000000, 0.000000),
(85, 'Micronesia', 6.88746, 158.075, 11, '', 'Friends of Micronesia', 'http://friendsofmicronesia.wordpress.com/', 'fm', 0.000000, 0.000000, 0.000000, 0.000000),
(86, 'Mongolia', 46.5123, 94.853, 5, '', 'Friends of Mongolia', 'http://www.friendsofmongolia.org/', 'mn', 0.000000, 0.000000, 0.000000, 0.000000),
(87, 'Nepal', 28.3791, 81.8855, 7, '', 'Friends of Nepal', 'http://www.friendsofnepal.com/', 'np', 0.000000, 0.000000, 0.000000, 0.000000),
(88, 'Nigeria', 9.05022, 4.1768, 6, '', 'Friends of Nigeria', 'http://www.friendsofnigeria.org/', 'ng', 4.184520, 2.728575, 13.808458, 14.571836),
(89, 'Pakistan', 30.0825, 60.3295, 5, '', 'Friends of Pakistan', 'http://www.peacecorpsfriendsofpakistan.org/', 'pk', 0.000000, 0.000000, 0.000000, 0.000000),
(90, 'Swaziland', -26.5133, 31.4576, 6, '', 'Friends of Swaziland', 'http://friendsofswaziland.org/', 'sz', -27.329588, 30.762232, -25.705170, 32.102562),
(91, 'Tanzania', -6.35333, 35.6386, 5, '', 'Friends of Tanzania', 'http://fotanzania.org/', 'tz', -11.323696, 29.470924, -0.939115, 40.215553),
(92, 'Thailand', 13.7244, 100.353, 5, '', 'Friends of Thailand', 'http://www.friendsofthailand.org/', 'th', 0.000000, 0.000000, 0.000000, 0.000000),
(93, 'Turkey', 38.6107, 26.2394, 5, '', 'Arkadaslar, Friends of Turkey', 'http://www.arkadaslar.info/', 'tr', 0.000000, 0.000000, 0.000000, 0.000000),
(94, 'Turkmenistan', 38.8776, 55.0851, 6, '', 'Friends of Turkmenistan', 'http://friendsofturkmenistan.blogspot.com/', 'tm', 0.000000, 0.000000, 0.000000, 0.000000),
(95, 'Uganda', 1.36711, 30.0579, 7, '', 'Friends of Uganda', '', 'ug', -1.400444, 29.405006, 4.242507, 34.854225),
(96, 'Rwanda', -1.96289, 29.711, 8, '', 'Peace Corps Rwanda', 'http://rwanda.peacecorps.gov/', 'rw', -2.761818, 28.855692, -1.026993, 30.899149),
(97, 'Kiribati', 1.87088, -157.503, 6, '', '', '', 'ki', 0.000000, 0.000000, 0.000000, 0.000000),
(98, 'Zambia', -13.6944, 27.4301, 6, '', '', '', 'zm', -17.822281, 22.103931, -8.200996, 33.266041),
(99, 'Mauritania', 19.7648, -11.1206, 5, '', '', '', 'mr', 15.625400, -17.310488, 27.139551, -6.587832),
(100, 'Anguilla', 18.2233, -63.1267, 12, '', '', '', 'ai', 0.000000, 0.000000, 0.000000, 0.000000),
(101, 'Bahrain', 26.0152, 50.5194, 9, '', '', '', 'bh', 0.000000, 0.000000, 0.000000, 0.000000),
(102, 'Bangladesh', 23.6741, 90.0607, 7, '', '', '', 'bd', 0.000000, 0.000000, 0.000000, 0.000000),
(103, 'Burundi', -3.38888, 29.8543, 9, '', '', '', 'bi', -4.340761, 28.987528, -2.300843, 30.899149),
(104, 'Cape Verde', 15.12, -23.6227, 8, '', '', '', 'cv', 0.000000, 0.000000, 0.000000, 0.000000),
(105, 'Chad', 15.2629, 17.5301, 6, '', '', '', 'td', 0.000000, 0.000000, 0.000000, 0.000000),
(106, 'Central African Republic', 6.59917, 20.6382, 7, '', '', '', 'cf', 0.000000, 0.000000, 0.000000, 0.000000),
(107, 'Comoros', 11.6518, 43.2325, 10, '', '', '', 'km', 0.000000, 0.000000, 0.000000, 0.000000),
(108, 'Republic of the Congo', -0.632462, 15.2381, 6, '', '', '', 'cg', 0.000000, 0.000000, 0.000000, 0.000000),
(109, 'Cook Islands', -21.2358, -159.78, 13, '', '', '', 'ck', 0.000000, 0.000000, 0.000000, 0.000000),
(110, 'Cyprus', 35.1685, 33.4018, 9, '', '', '', 'cy', 0.000000, 0.000000, 0.000000, 0.000000),
(111, 'Namibia', -22.711, 18.2803, 5, '', '', '', 'na', 0.000000, 0.000000, 0.000000, 0.000000),
(112, 'Tonga', -21.2416, -175.137, 10, '', '', '', 'to', 0.000000, 0.000000, 0.000000, 0.000000),
(113, 'Bulgaria', 41.7034, 25.2008, 6, '', '', '', 'bg', 0.000000, 0.000000, 0.000000, 0.000000),
(114, 'Guinea-Bissau', 12.0963, -14.9316, 8, '', '', '', 'gw', 0.000000, 0.000000, 0.000000, 0.000000),
(115, 'Russia', 62.2146, 94.9065, 3, '', '', '', 'ru', 0.000000, 0.000000, 0.000000, 0.000000),
(116, 'Slovakia', 48.7522, 19.4373, 7, '', '', '', 'sk', 0.000000, 0.000000, 0.000000, 0.000000),
(117, 'Hungary', 47.1393, 19.4687, 7, '', '', '', 'hu', 0.000000, 0.000000, 0.000000, 0.000000),
(118, 'Uzbekistan', 41.2938, 64.4945, 6, '', '', '', 'uz', 0.000000, 0.000000, 0.000000, 0.000000),
(119, 'Eritrea', 15.1914, 39.4918, 7, '', '', '', 'er', 0.000000, 0.000000, 0.000000, 0.000000),
(120, 'Tunisia', 34.3889, 9.6329, 6, '', '', '', 'tn', 0.000000, 0.000000, 0.000000, 0.000000),
(121, 'Papua New Guinea', -6.09114, 144.463, 5, '', '', '', 'pg', 0.000000, 0.000000, 0.000000, 0.000000),
(122, 'Saint Kitts and Nevis', 17.3127, -62.7481, 9, '', '', '', 'kn', 0.000000, 0.000000, 0.000000, 0.000000),
(123, 'Latvia', 56.8144, 24.4638, 7, '', '', '', 'lv', 0.000000, 0.000000, 0.000000, 0.000000),
(124, 'Czech Republic', 49.7821, 15.4031, 7, '', '', '', 'cz', 0.000000, 0.000000, 0.000000, 0.000000),
(125, 'East Timor', -8.7931, 126.101, 9, '', '', '', 'tl', 0.000000, 0.000000, 0.000000, 0.000000),
(126, 'Equatorial Guinea', 1.61944, 10.3, 9, '', '', '', 'gq', 0.000000, 0.000000, 0.000000, 0.000000),
(127, 'Estonia', 58.5852, 24.9511, 7, '', '', '', 'ee', 0.000000, 0.000000, 0.000000, 0.000000),
(128, 'Lithuania', 55.153, 23.7533, 7, '', '', '', 'lt', 0.000000, 0.000000, 0.000000, 0.000000),
(129, 'Libya', 26.0509, 16.9229, 5, '', '', '', 'ly', 0.000000, 0.000000, 0.000000, 0.000000),
(130, 'Malta', 35.9441, 14.3756, 11, '', '', '', 'mt', 0.000000, 0.000000, 0.000000, 0.000000),
(131, 'Marshall Islands', 6.06828, 171.985, 11, '', '', '', 'mh', 0.000000, 0.000000, 0.000000, 0.000000),
(132, 'Mauritius', -20.2031, 57.6659, 10, '', '', '', 'mu', 0.000000, 0.000000, 0.000000, 0.000000),
(133, 'Montserrat', 16.7494, -62.1939, 12, '', '', '', 'ms', 0.000000, 0.000000, 0.000000, 0.000000),
(134, 'Niue', -19.054, -169.932, 11, '', '', '', 'nu', 0.000000, 0.000000, 0.000000, 0.000000),
(135, 'Oman', 21.4676, 55.8864, 6, '', '', '', 'om', 0.000000, 0.000000, 0.000000, 0.000000),
(136, 'Palau', 7.37996, 134.522, 8, '', '', '', 'pw', 0.000000, 0.000000, 0.000000, 0.000000),
(137, 'Poland', 51.8335, 19.0947, 6, '', '', '', 'pl', 0.000000, 0.000000, 0.000000, 0.000000),
(138, 'Samoa', -13.7575, -172.122, 9, '', '', '', 'ws', 0.000000, 0.000000, 0.000000, 0.000000),
(139, 'Sao Tome and Principe', 0.199693, 6.60175, 10, '', '', '', 'st', 0.000000, 0.000000, 0.000000, 0.000000),
(140, 'Seychelles', -4.68379, 55.4451, 11, '', '', '', 'sc', 0.000000, 0.000000, 0.000000, 0.000000),
(141, 'Solomon Islands', -9.21939, 159.148, 7, '', '', '', 'sb', 0.000000, 0.000000, 0.000000, 0.000000),
(142, 'Somalia', 5.09923, 45.8303, 5, '', '', '', 'so', 0.000000, 0.000000, 0.000000, 0.000000),
(143, 'Sri Lanka', 7.87125, 80.5563, 11, '', '', '', 'lk', 0.000000, 0.000000, 0.000000, 0.000000),
(144, 'Sudan', 15.5992, 30.0454, 5, '', '', '', 'sd', 0.000000, 0.000000, 0.000000, 0.000000),
(145, 'Turks and Caicos', 21.8073, -71.7999, 10, '', '', '', 'tc', 0.000000, 0.000000, 0.000000, 0.000000),
(146, 'Tuvalu', -7.47842, 178.68, 14, '', '', '', 'tv', 0.000000, 0.000000, 0.000000, 0.000000),
(147, 'Yemen', 15.5083, 48.0179, 6, '', '', '', 'ye', 0.000000, 0.000000, 0.000000, 0.000000),
(148, 'Serbia', 42.6523, 20.909, 8, '', '', '', 'rs', 0.000000, 0.000000, 0.000000, 0.000000);

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
-- Table structure for table `mail`
--

CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL,
  `mail_subject` varchar(500) DEFAULT NULL,
  `mail_body` text,
  `mail_from` varchar(300) DEFAULT NULL,
  `mail_to` varchar(200) DEFAULT NULL,
  `mail_queued` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mail_sent` timestamp NULL DEFAULT NULL,
  `mail_result` varchar(511) DEFAULT NULL,
  `mail_reply` varchar(200) DEFAULT NULL
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
  `project_impact` varchar(1023) DEFAULT NULL,
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

--
-- Dumping data for table `project_event_types`
--

INSERT INTO `project_event_types` (`pet_id`, `pet_label`) VALUES
(1, 'Village Raises Cash Contribution'),
(2, 'Project Posted'),
(3, 'Project Funded'),
(4, 'Project Completed');

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

--
-- Dumping data for table `stat_types`
--

INSERT INTO `stat_types` (`st_id`, `st_label`) VALUES
(1, 'BNursery'),
(2, 'BPrimary'),
(3, 'BSecondary'),
(4, 'BTertiary'),
(5, 'GNursery'),
(6, 'GPrimary'),
(7, 'GSecondary'),
(8, 'GTertiary'),
(9, 'Maize'),
(10, 'Goats'),
(11, 'Cows'),
(12, 'Waterborne Illness'),
(13, 'Ag Biz'),
(14, 'Other Biz'),
(15, 'Homes with Iron Sheets'),
(16, '# of Motorcycles'),
(17, '# of TVs'),
(18, '# of People'),
(19, '# of HH'),
(20, 'Treated'),
(21, 'Ag'),
(22, 'Livestock'),
(23, 'Edu'),
(24, 'Water'),
(25, 'Time Treated'),
(26, 'Money'),
(27, 'Biz Score'),
(28, 'Ag Score'),
(29, 'Edu Score'),
(30, 'Livestock Score'),
(31, 'Lifestyle Score'),
(32, 'Comp Score');

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
-- Indexes for table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`mail_id`),
  ADD KEY `mail_sent_index` (`mail_sent`);

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
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;
--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=617;
--
-- AUTO_INCREMENT for table `field_officers`
--
ALTER TABLE `field_officers`
  MODIFY `fo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mail`
--
ALTER TABLE `mail`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355543;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2232;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `project_costs`
--
ALTER TABLE `project_costs`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2407;
--
-- AUTO_INCREMENT for table `project_events`
--
ALTER TABLE `project_events`
  MODIFY `pe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1513;
--
-- AUTO_INCREMENT for table `project_event_types`
--
ALTER TABLE `project_event_types`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `village_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `village_stats`
--
ALTER TABLE `village_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1631;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

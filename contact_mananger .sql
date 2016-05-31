-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2016 at 08:52 AM
-- Server version: 5.5.44
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `contact_mananger`
--
CREATE DATABASE IF NOT EXISTS `contact_mananger` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `contact_mananger`;

-- --------------------------------------------------------

--
-- Table structure for table `best_phone`
--

DROP TABLE IF EXISTS `best_phone`;
CREATE TABLE IF NOT EXISTS `best_phone` (
  `id_contacts` int(6) unsigned DEFAULT NULL,
  `best_phone` enum('cell','work','home','') CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 COLLATE=cp1251_ukrainian_ci;

--
-- Dumping data for table `best_phone`
--

INSERT INTO `best_phone` (`id_contacts`, `best_phone`) VALUES
(47, ''),
(49, NULL),
(51, NULL),
(52, NULL),
(53, NULL),
(55, NULL),
(56, NULL),
(57, NULL),
(58, NULL),
(59, NULL),
(60, NULL),
(61, NULL),
(62, ''),
(63, NULL),
(64, NULL),
(65, NULL),
(68, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
`id` int(6) unsigned NOT NULL,
  `first_name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `last_name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `home_phone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `work_phone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `cell_phone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `address1` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `address2` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `state` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `zip` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `country` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `birth_day` date DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 COLLATE=cp1251_ukrainian_ci AUTO_INCREMENT=71 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `email`, `home_phone`, `work_phone`, `cell_phone`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `birth_day`) VALUES
(47, 'Ñ€Ð¾Ð¿Ð½Ð¿Ð¾', 'Ð¾Ñ€ÑŒÑ€Ð¿Ð¾Ð¿Ð¾Ñ€', 'naaa.nazar@gmail.com', '', '', '', '', '', '', '', '', '', '1989-10-18'),
(49, NULL, NULL, 'sdf@sdf.sdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, NULL, NULL, 'dasfsdf@sdf.sdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, NULL, NULL, 'asdasd@sdsad.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, NULL, NULL, 'asdasd@adfsd.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, NULL, NULL, 'asdasd@asd.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, NULL, NULL, 'asasd@asd.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, NULL, NULL, 'naaa.ndazar@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, NULL, NULL, 'ghfvgfhv@gfdgf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, NULL, NULL, 'sfdf@sdf.sdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, NULL, NULL, 'dasffsdf@sdf.sdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, NULL, NULL, 'asdfasd@sdsad.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Ð¾Ð»Ñ€Ð¾Ð»Ñ€', 'Ð»Ð´Ð¾Ð´Ð»Ð¾', 'asfdasd@adfsd.asd', '', '', '', '', '', '', '', '', '', '1989-10-18'),
(63, NULL, NULL, 'afsd@asd.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, NULL, NULL, 'afsdasd@asd.asfd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, NULL, NULL, 'asfasd@asd.asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Ð²Ð°ÑÑ', 'Ð²Ð°ÑÑ', 'ghfvghv@gf.dgf', '98465703', '', '', '', '', '', '', '', '', '1989-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
`id` int(6) unsigned NOT NULL,
  `subject` varchar(60) DEFAULT NULL,
  `event` mediumtext,
  `date_event` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `subject`, `event`, `date_event`) VALUES
(12, 'first event', 'dasasdasdasd', '2016-05-24 13:25:26'),
(13, '222', '222', '2016-05-24 13:26:30'),
(25, '', '', '2016-05-24 23:57:40'),
(26, '', '', '2016-05-24 23:57:50'),
(27, '', '', '2016-05-24 23:58:05'),
(28, '', '', '2016-05-25 00:08:04'),
(29, '', '', '2016-05-25 00:08:06'),
(31, '', '', '2016-05-25 00:29:30'),
(32, '', '', '2016-05-25 00:31:40'),
(33, '', '', '2016-05-25 00:35:46'),
(34, '', '', '2016-05-25 14:30:57'),
(35, '', '', '2016-05-25 17:12:31'),
(36, '', '', '2016-05-25 17:19:38'),
(37, '', '', '2016-05-25 17:32:06'),
(38, '', '', '2016-05-25 17:32:28'),
(39, '', '', '2016-05-25 17:56:18'),
(41, '', '', '2016-05-25 20:20:27'),
(42, '', '', '2016-05-30 21:43:23'),
(43, '', '', '2016-05-30 21:47:10'),
(44, '', '', '2016-05-30 21:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `events_sendmail`
--

DROP TABLE IF EXISTS `events_sendmail`;
CREATE TABLE IF NOT EXISTS `events_sendmail` (
  `id_contacts` int(6) unsigned DEFAULT NULL,
  `id_events` int(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events_sendmail`
--

INSERT INTO `events_sendmail` (`id_contacts`, `id_events`) VALUES
(20, 12),
(21, 12),
(20, 13),
(21, 13),
(26, 27),
(28, 31),
(29, 32),
(30, 33),
(31, 34),
(32, 34),
(33, 34),
(34, 34),
(35, 34),
(36, 34),
(37, 34),
(39, 35),
(40, 35),
(41, 35),
(42, 35),
(43, 35),
(45, 36),
(47, 37),
(48, 37),
(49, 37),
(50, 37),
(51, 38),
(52, 39),
(53, 39),
(54, 39),
(57, 41),
(58, 41),
(59, 41),
(60, 41),
(61, 41),
(62, 41),
(63, 41),
(64, 41),
(65, 41),
(47, 42),
(49, 42),
(51, 42),
(52, 42),
(53, 42),
(54, 42),
(55, 42),
(56, 42),
(57, 42),
(58, 42),
(59, 42),
(60, 42),
(61, 42),
(62, 42),
(63, 42),
(64, 42),
(65, 42),
(68, 42),
(69, 43),
(70, 44);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('aaa', '887afedefdcc15fd919337ee0a41ecf2'),
('na11', 'e10adc3949ba59abbe56e057f20f883e'),
('naaa', '887afedefdcc15fd919337ee0a41ecf2'),
('naaa11', 'e10adc3949ba59abbe56e057f20f883e'),
('zorik', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `users_contacts`
--

DROP TABLE IF EXISTS `users_contacts`;
CREATE TABLE IF NOT EXISTS `users_contacts` (
  `id_contacts` int(6) unsigned DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_contacts`
--

INSERT INTO `users_contacts` (`id_contacts`, `username`) VALUES
(47, 'na11'),
(49, 'na11'),
(51, 'na11'),
(52, 'na11'),
(53, 'na11'),
(55, 'na11'),
(56, 'na11'),
(57, 'na11'),
(58, 'na11'),
(59, 'na11'),
(60, 'na11'),
(61, 'na11'),
(62, 'na11'),
(63, 'na11'),
(64, 'na11'),
(65, 'na11'),
(68, 'na11');

-- --------------------------------------------------------

--
-- Table structure for table `users_events`
--

DROP TABLE IF EXISTS `users_events`;
CREATE TABLE IF NOT EXISTS `users_events` (
  `id_events` int(6) unsigned DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_events`
--

INSERT INTO `users_events` (`id_events`, `username`) VALUES
(12, 'zorik'),
(13, 'zorik'),
(25, 'naaa'),
(26, 'naaa'),
(27, 'naaa'),
(28, 'naaa'),
(29, 'naaa'),
(31, 'naaa'),
(32, 'naaa'),
(33, 'naaa'),
(34, 'naaa'),
(35, 'naaa'),
(36, 'naaa'),
(37, 'na11'),
(38, 'na11'),
(39, 'na11'),
(41, 'na11'),
(42, 'na11'),
(43, 'naaa11'),
(44, 'naaa11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2016 at 01:38 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `best_phone`
--

CREATE TABLE IF NOT EXISTS `best_phone` (
  `id_contacts` int(6) unsigned DEFAULT NULL,
  `best_phone` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `best_phone`
--

INSERT INTO `best_phone` (`id_contacts`, `best_phone`) VALUES
(18, 'cell'),
(19, 'home'),
(20, 'home'),
(21, 'cell');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
`id` int(6) unsigned NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `home_phone` varchar(20) DEFAULT NULL,
  `work_phone` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `birth_day` date DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `email`, `home_phone`, `work_phone`, `cell_phone`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `birth_day`) VALUES
(13, NULL, NULL, '1111@hvjnv.lkj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'nazar', 'nazarow', '111@whywu.wee', '111111', '2222', '333', '', '', '', '', '', '', '1989-10-12'),
(19, 'Ð—Ð¾Ñ€ÑÐ½Ð° ', 'ÐšÐ¾Ñ€Ñ‡ÐµÐ²ÑÑŒÐºÐ°', 'zorik@ukr.net', '095-388-95-85', '', '', '', '', '', '', '', '', '1989-10-13'),
(20, 'ÐÐ°Ð·Ð°Ñ€', 'ÐšÐ¾Ñ€Ñ‡ÐµÐ²ÑÑŒÐºÐ¸Ð¹', 'naaa.nazar@gmail.com', '095-388-95-85', '', '', '', '', '', '', '', '', '1989-10-18'),
(21, 'Ð’Ð°ÑÐ¸Ð»ÑŒ', 'Ð›Ð°Ð²Ñ€Ð¸Ðº', 'naaa@ukr.net', '', '', '095-355-44-54', '', '', '', '', '', '', '1995-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
`id` int(6) unsigned NOT NULL,
  `subject` varchar(60) DEFAULT NULL,
  `event` mediumtext,
  `date_event` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `subject`, `event`, `date_event`) VALUES
(12, 'first event', 'dasasdasdasd', '2016-05-24 13:25:26'),
(13, '222', '222', '2016-05-24 13:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `events_sendmail`
--

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
(21, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('naaa', '887afedefdcc15fd919337ee0a41ecf2'),
('zorik', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `users_contacts`
--

CREATE TABLE IF NOT EXISTS `users_contacts` (
  `id_contacts` int(6) unsigned DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_contacts`
--

INSERT INTO `users_contacts` (`id_contacts`, `username`) VALUES
(18, 'naaa'),
(19, 'naaa'),
(20, 'zorik'),
(21, 'zorik');

-- --------------------------------------------------------

--
-- Table structure for table `users_events`
--

CREATE TABLE IF NOT EXISTS `users_events` (
  `id_events` int(6) unsigned DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_events`
--

INSERT INTO `users_events` (`id_events`, `username`) VALUES
(12, 'zorik'),
(13, 'zorik');

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
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

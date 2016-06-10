-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2016 at 10:19 AM
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
`id_contacts` int(6) NOT NULL,
  `best_phone` varchar(6) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `best_phone`
--

INSERT INTO `best_phone` (`id_contacts`, `best_phone`) VALUES
(1, 'home'),
(7, NULL),
(9, NULL),
(10, 'home'),
(13, NULL),
(14, NULL),
(15, NULL),
(23, 'home'),
(41, NULL),
(49, 'home'),
(50, ''),
(51, ''),
(52, ''),
(53, ''),
(54, 'work'),
(55, 'cell'),
(56, 'home'),
(57, 'work'),
(58, 'cell'),
(59, 'work'),
(60, 'work'),
(61, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
`id` int(6) unsigned NOT NULL,
  `users_id` int(6) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `users_id`, `first_name`, `last_name`, `email`, `home_phone`, `work_phone`, `cell_phone`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `birth_day`) VALUES
(54, 1, 'Назар', 'Корчевський', 'naaa.nazar@gmail.com', '', '0352-22-33-56', '', '', '', '', '', '', '', '1988-12-25'),
(55, 1, 'Олег', 'Ifhbq', 'oleg@ukr1.net', '', '', '33333', '', '', '', '', '', '', '1989-10-18'),
(56, 1, 'Анатолій ', 'Карпенко', 'anatol@dasd.asd', '1111111', '', '', '', '', '', '', '', '', '1989-10-18'),
(57, 1, 'Зоряна', 'Шкільник', 'zor@gma.com', '', '222222', '', '', '', '', '', '', '', '1989-10-18'),
(58, 1, 'Дмитро', 'Кривий', 'naaa@ukr.net', '', '', '23423423423', '', '', '', '', '', '', '1988-12-25'),
(59, 1, 'івауццук', 'Карпвв', '1111111f@aada.asd', '', '345345354', '', '', '', '', '', '', '', '1989-10-12'),
(60, 1, 'ффф', 'ууу', '1111111111111@rtu.rty', '', '22222', '', '', '', '', '', '', '', '1989-10-13'),
(61, 1, '111', '111', 'asdsad@sdf.sdf', '11111', '', '', '', '', '', '', '', '', '1989-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(6) unsigned NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'naaa', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'admin', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `best_phone`
--
ALTER TABLE `best_phone`
 ADD PRIMARY KEY (`id_contacts`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `best_phone`
--
ALTER TABLE `best_phone`
MODIFY `id_contacts` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 01, 2010 at 12:57 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sprred_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile_info`
--

CREATE TABLE IF NOT EXISTS `profile_info` (
  `profile_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`profile_ID`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `profile_info`
--

INSERT INTO `profile_info` (`profile_ID`, `ID`, `sname`, `url`, `name`, `description`, `created`, `modified`) VALUES
(3, 3, 'ram', 'http://ram.sprred.com', 'Untitled', NULL, '2010-07-29 07:41:14', '2010-07-29 07:41:14'),
(1, 1, 'kuldeep', 'http://kuldeep.sprred.com', 'Paper Thin Walls', NULL, '0000-00-00 00:00:00', '2010-07-31 16:30:24'),
(2, 2, 'rohan', 'http://rohan.sprred.com', 'Ramblings', NULL, '2010-08-20 11:46:35', '2010-08-22 10:16:30'),
(4, 4, 'iamalive', 'http://iamalive.sprred.com', 'iamalive', NULL, '2010-08-29 14:31:15', '2010-08-29 14:41:35'),
(5, 5, 'kvrushali', 'http://kvrushali.sprred.com', 'kvrushali', NULL, '2010-08-31 18:14:20', '2010-08-31 18:15:03'),
(6, 6, 'adese', 'http://adese.sprred.com', 'Untitled', NULL, '2010-09-01 05:48:41', '2010-09-01 05:48:41'),
(7, 7, 'hardik', 'http://hardik.sprred.com', 'My Sprred', NULL, '2010-09-01 06:31:18', '2010-09-01 06:41:17'),
(8, 8, 'aalaap', 'http://aalaap.sprred.com', 'Peanut Butter Sprred', NULL, '2010-09-01 07:02:06', '2010-09-01 07:09:20'),
(9, 9, 'hiway', 'http://hiway.sprred.com', 'Wanderlust Ahoy!', NULL, '2010-09-01 07:07:03', '2010-09-01 07:09:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`),
  KEY `fullname` (`fullname`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `fullname`, `password`, `email`, `confirmed`, `created`, `modified`) VALUES
(1, 'Kuldeep Kapade', 'ce8c0aa4762072eeafe937e8ac0acfdb', 'kuldeepkapade@gmail.com', 1, '2010-07-23 19:56:44', '2010-08-07 20:58:21'),
(3, 'Unknown', 'ee7996f4bce1d7e598281dca2276f9a9', 'r.ramprasad@gmail.com', 1, '2010-07-29 07:41:14', '2010-07-29 07:41:14'),
(2, 'Rohan Mahadar', '32a4e059baa673e8983aeab0c9cc61da', 'rohanmahadar@gmail.com', 1, '2010-08-20 11:46:34', '2010-08-22 10:16:35'),
(4, 'Rashi', 'b0c185326cfce8932eb0ec2e79ca6ccc', 'rashi.shukla1@gmail.com', 1, '2010-08-29 14:31:15', '2010-08-29 14:41:38'),
(5, 'vrushali', 'fe21dd99f5ccb0f9d87f86fcadaa69f6', 'vrush.omsai@gmail.com', 1, '2010-08-31 18:14:19', '2010-08-31 18:14:49'),
(6, 'Unknown', 'c378985d629e99a4e86213db0cd5e70d', 'aditi1985@gmail.com', 1, '2010-09-01 05:48:41', '2010-09-01 05:48:41'),
(7, 'Hardik Ruparel', 'ae2b1fca515949e5d54fb22b8ed95575', 'hardik988@gmail.com', 1, '2010-09-01 06:31:18', '2010-09-01 06:31:56'),
(8, 'Aalaap Ghag', 'dc647eb65e6711e155375218212b3964', 'aalaap@gmail.com', 1, '2010-09-01 07:02:05', '2010-09-01 07:02:40'),
(9, 'Harshad Sharma', '66fc1c78bc929fbac80dc695c2d30dae', 'harshad.sharma@gmail.com', 1, '2010-09-01 07:07:03', '2010-09-01 07:08:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

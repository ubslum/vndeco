-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2010 at 04:28 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trungsyn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `PREFIX_poll`
--

CREATE TABLE IF NOT EXISTS `PREFIX_poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `description` text,
  `date_created` date NOT NULL,
  `timestamp_created` int(11) NOT NULL,
  `date_show_result` date NOT NULL,
  `timestamp_show_result` int(11) NOT NULL,
  `date_begin` date NOT NULL,
  `timestamp_begin` int(11) NOT NULL,
  `date_end` date NOT NULL,
  `timestamp_end` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `PREFIX_poll`
--


-- --------------------------------------------------------

--
-- Table structure for table `PREFIX_poll_option`
--

CREATE TABLE IF NOT EXISTS `PREFIX_poll_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `content` varchar(256) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `PREFIX_poll_option`
--


-- --------------------------------------------------------

--
-- Table structure for table `PREFIX_poll_question`
--

CREATE TABLE IF NOT EXISTS `PREFIX_poll_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_poll` int(11) NOT NULL,
  `question` varchar(256) NOT NULL,
  `multiple` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `PREFIX_poll_question`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

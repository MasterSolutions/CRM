-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2013 at 04:42 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE IF NOT EXISTS `utilizatori` (
  `coduser` int(11) NOT NULL AUTO_INCREMENT,
  `codpersoana` int(11) DEFAULT NULL,
  `utilizator` varchar(20) NOT NULL,
  `mailuser` varchar(55) NOT NULL,
  `parola` varchar(20) NOT NULL,
  `permisiuni` int(1) NOT NULL DEFAULT '0',
  `codsocietate` int(11) NOT NULL,
  PRIMARY KEY (`coduser`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`coduser`, `codpersoana`, `utilizator`, `mailuser`, `parola`, `permisiuni`, `codsocietate`) VALUES
(1, 0, 'ovidiu', '', '1234', 1, 26);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

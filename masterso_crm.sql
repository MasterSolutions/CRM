-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2013 at 06:07 PM
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
CREATE DATABASE IF NOT EXISTS `crm` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `crm`;

-- --------------------------------------------------------

--
-- Table structure for table `activitate`
--

CREATE TABLE IF NOT EXISTS `activitate` (
  `cod_client` int(11) NOT NULL,
  `nr_fisa` int(11) NOT NULL,
  `ziua` varchar(2) NOT NULL,
  `lunaan` varchar(20) NOT NULL,
  `explicatii` varchar(60) NOT NULL,
  `ora_inc` varchar(5) NOT NULL,
  `ora_fin` varchar(5) NOT NULL,
  `total_ore` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config_societate`
--

CREATE TABLE IF NOT EXISTS `config_societate` (
  `denumire` varchar(75) NOT NULL,
  `cui` varchar(10) NOT NULL,
  `regcom` varchar(13) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `mailnotificare` varchar(30) NOT NULL,
  `web` varchar(30) NOT NULL,
  `crmclienti` varchar(50) NOT NULL,
  `permitecont` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `denumire` (`denumire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config_societate`
--

INSERT INTO `config_societate` (`denumire`, `cui`, `regcom`, `adresa`, `telefon`, `mail`, `mailnotificare`, `web`, `crmclienti`, `permitecont`) VALUES
('S.C. Master Solutions S.R.L', 'RO18888971', 'J02/1388/2006', 'Calea Aurel Vlaicu, Bloc Z-23, Sc. B, Ap.3', '0744.344.333', 'office@mastersolutions.ro', 'facturare@mastersolutions.ro', 'http://www.mastersolutions.ro', 'http://www.mastersolutions.ro/crm/client/', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documente_emise`
--

CREATE TABLE IF NOT EXISTS `documente_emise` (
  `iddoc` int(5) NOT NULL AUTO_INCREMENT,
  `idsoc` int(4) unsigned NOT NULL,
  `nume_fisier` varchar(200) NOT NULL,
  `dimensiune_fisier` varchar(200) NOT NULL,
  `tip_fisier` varchar(200) NOT NULL,
  `ziua` varchar(2) NOT NULL,
  `lunaan` varchar(20) NOT NULL,
  PRIMARY KEY (`iddoc`),
  FULLTEXT KEY `lunadoc` (`lunaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `documente_emise`
--

INSERT INTO `documente_emise` (`iddoc`, `idsoc`, `nume_fisier`, `dimensiune_fisier`, `tip_fisier`, `ziua`, `lunaan`) VALUES
(1, 26, 'README.md', '28 B', 'application/octet-stream', '28', 'iunie-2013'),
(2, 26, 'crm.sql', '9.25 KB', 'application/octet-stream', '28', 'iunie-2013'),
(3, 26, '1372419964crm.sql', '9.25 KB', 'application/octet-stream', '28', 'iunie-2013'),
(4, 26, '.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(5, 26, '1372420053.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(6, 26, '.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(7, 26, '.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(8, 26, '.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(9, 26, 'index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(10, 26, '1372420565index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(11, 26, '1372420702index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(12, 26, '1372420745index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(13, 26, '1372421002index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(14, 26, '1372421211index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(15, 26, '1372421245index.php', '13.93 KB', 'application/octet-stream', '28', 'august-2013'),
(16, 26, '1372421309index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(17, 26, '1372421349index.php', '13.93 KB', 'application/octet-stream', '28', 'iunie-2013'),
(18, 26, '1372421406index.php', '13.93 KB', 'application/octet-stream', '28', 'iulie-2013'),
(19, 26, '1372421513crm.sql', '9.25 KB', 'application/octet-stream', '28', 'iunie-2013'),
(20, 26, '1372421612crm.sql', '9.25 KB', 'application/octet-stream', '28', 'iunie-2013'),
(21, 26, '1372421655crm.sql', '9.25 KB', 'application/octet-stream', '28', 'iunie-2013'),
(22, 26, '.gitattributes', '505 B', 'application/octet-stream', '28', 'iunie-2013'),
(23, 26, '1372421713.gitattributes', '505 B', 'application/octet-stream', '28', 'iunie-2013'),
(24, 26, '1372421744.gitattributes', '505 B', 'application/octet-stream', '28', 'iunie-2013'),
(25, 26, '1372421759.gitattributes', '505 B', 'application/octet-stream', '28', 'iunie-2013'),
(26, 26, '1372421864.gitattributes', '505 B', 'application/octet-stream', '28', 'iunie-2013'),
(27, 26, '1372421873.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(28, 26, '1372422064.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(29, 26, '1372422076.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(30, 26, '1372422100.gitignore', '2.12 KB', 'application/octet-stream', '28', 'iunie-2013'),
(31, 26, 'animate-custom.css', '72.39 KB', 'text/css', '28', 'iunie-2013'),
(32, 26, 'layout.css', '1.03 KB', 'text/css', '28', 'iunie-2013'),
(33, 26, 'demo.css', '3.52 KB', 'text/css', '28', 'iunie-2013'),
(34, 26, '1372422866demo.css', '3.52 KB', 'text/css', '28', 'iunie-2013'),
(35, 26, '1372422915demo.css', '3.52 KB', 'text/css', '28', 'iunie-2013'),
(36, 26, 'ui_darkness.css', '34.02 KB', 'text/css', '28', 'iunie-2013');

-- --------------------------------------------------------

--
-- Table structure for table `meniu`
--

CREATE TABLE IF NOT EXISTS `meniu` (
  `id_meniu` int(11) NOT NULL AUTO_INCREMENT,
  `modul` varchar(15) NOT NULL,
  `nume_meniu` varchar(25) NOT NULL,
  `ico` varchar(35) NOT NULL,
  `tip` int(11) NOT NULL,
  `parinte` int(11) NOT NULL,
  `ordonare` int(11) NOT NULL,
  `adresa` varchar(30) NOT NULL,
  PRIMARY KEY (`id_meniu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `meniu`
--

INSERT INTO `meniu` (`id_meniu`, `modul`, `nume_meniu`, `ico`, `tip`, `parinte`, `ordonare`, `adresa`) VALUES
(33, 'Contact', 'Contacte', 'Contacte.png', 0, 0, 3, '#'),
(34, '', 'Conf1', 'Contacte.png', 1, 38, 0, '#'),
(35, 'Contact', 'Societati', 'Societati.png', 1, 33, 0, '#'),
(36, 'Contact', 'Persoane', 'Contacte_persoane.png', 1, 33, 0, '#'),
(37, 'Contact', 'Detalii', 'Societati_edit.png', 2, 35, 2, 'societati.php'),
(38, '', 'Configurari', 'Configurari.png', 0, 0, 2, '#'),
(39, '', 'Adauga', 'Contacte_persoane_adauga.png', 2, 36, 0, ''),
(40, 'Contact', 'Adauga', 'Societati_adauga.png', 2, 35, 1, 'societati_adauga.php'),
(41, 'Contact', 'Detalii', 'Contacte_persoane_edit.png', 2, 36, 0, '#'),
(42, '', 'Conf1.1', 'Configurari.png', 2, 34, 0, ''),
(43, '', 'Utilizatori', 'Utilizatori.png', 1, 38, 1, 'sfa.php'),
(44, '', 'SFA', 'SFA.png', 0, 0, 1, '#'),
(45, '', 'Call center', 'Call_center.png', 1, 44, 1, ''),
(46, 'Docman', 'Documente', 'Documente.png', 0, 0, 0, '#'),
(47, 'Docalert', 'Doc Alert', 'Documente_alert.png', 1, 46, 5, 'upload_documente.php'),
(48, 'Docman', 'Manager', 'Documente_manager.png', 1, 46, 0, 'manager_doc.php');

-- --------------------------------------------------------

--
-- Table structure for table `sfa`
--

CREATE TABLE IF NOT EXISTS `sfa` (
  `codsfa` int(11) NOT NULL AUTO_INCREMENT,
  `codsocietate` int(11) DEFAULT NULL,
  `solutie` varchar(30) DEFAULT NULL,
  `valoare` int(6) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `comentariu` varchar(55) DEFAULT NULL,
  `etapa` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`codsfa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfa_etape`
--

CREATE TABLE IF NOT EXISTS `sfa_etape` (
  `codsfae` int(11) NOT NULL AUTO_INCREMENT,
  `denumireetapa` varchar(25) NOT NULL,
  `ordine` int(11) NOT NULL,
  PRIMARY KEY (`codsfae`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `sfa_etape`
--

INSERT INTO `sfa_etape` (`codsfae`, `denumireetapa`, `ordine`) VALUES
(1, 'Intalnire agreata', 1),
(2, 'Discutie la client', 4),
(4, 'Ofertat', 3),
(5, 'Finalizare discutii', 2),
(11, 'Refuzat', 6),
(28, 'De revenit cu telefon', 0);

-- --------------------------------------------------------

--
-- Table structure for table `societati`
--

CREATE TABLE IF NOT EXISTS `societati` (
  `codsocietate` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(30) NOT NULL,
  `adresa` varchar(70) NOT NULL,
  `cui` varchar(11) DEFAULT NULL,
  `regcom` varchar(15) DEFAULT NULL,
  `profil` varchar(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact` varchar(30) DEFAULT NULL,
  `functia` varchar(20) DEFAULT NULL,
  `telefon` varchar(12) DEFAULT NULL,
  `emailcontact` varchar(45) DEFAULT NULL,
  `contactat` varchar(2) DEFAULT NULL,
  `observatii` varchar(250) DEFAULT NULL,
  `client` int(1) NOT NULL DEFAULT '0',
  `utilizator` varchar(55) DEFAULT NULL,
  `parola` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`codsocietate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `societati`
--

INSERT INTO `societati` (`codsocietate`, `denumire`, `adresa`, `cui`, `regcom`, `profil`, `email`, `contact`, `functia`, `telefon`, `emailcontact`, `contactat`, `observatii`, `client`, `utilizator`, `parola`) VALUES
(25, 'Master Solutions', 'Calea Aurel Vlaicu, Bloc Z-23,', 'RO18888971', 'J02/1388/2006', 'IT', 'OFFICE@MASTERSOLUTIONS.RO', 'Preda Ovidiu', 'Consultant IT', '0744.344.333', 'ovidiu@mastersolutions.ro', 'Da', 'Nu raspunde', 0, NULL, NULL),
(26, 'Phabeda', 'Timisoara', '12345', NULL, 'Comert IT', 'predaovidiualin@gmail.com', 'Florin Mates', 'Sef', '0733.122.333', 'florin@phabeda.ro', 'Nu', NULL, 1, NULL, NULL),
(42, 'LIBRARIA CORINA', 'Eminescu', 'RO1254343', 'J02/1888/2001', 'COMERT', 'predaovidiualin@gmail.com', 'Corina Moldovan', NULL, NULL, NULL, 'Nu', NULL, 0, NULL, NULL),
(43, 'Soft Net Consulting', 'Timisoara', 'RO120033', 'J03/1444/2011', 'IT', 'office@softnetconsulting.ro', 'Dorin Andreica', 'Manager', NULL, NULL, 'Nu', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `societati_persoane`
--

CREATE TABLE IF NOT EXISTS `societati_persoane` (
  `cod_pers` int(11) NOT NULL AUTO_INCREMENT,
  `cod_societatep` int(11) NOT NULL,
  `numep` varchar(55) NOT NULL,
  `prenumep` varchar(55) NOT NULL,
  `telefonp` varchar(15) NOT NULL,
  `emailp` varchar(15) NOT NULL,
  PRIMARY KEY (`cod_pers`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `societati_persoane`
--

INSERT INTO `societati_persoane` (`cod_pers`, `cod_societatep`, `numep`, `prenumep`, `telefonp`, `emailp`) VALUES
(13, 26, 'Mates', 'Florin', '0742323211', 'florin@phabeda.'),
(15, 43, 'Andreica', 'Dorin', '2929292929', 'dorin@andreica.');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE IF NOT EXISTS `utilizatori` (
  `coduser` int(11) NOT NULL AUTO_INCREMENT,
  `codpersoana` int(11) DEFAULT NULL,
  `utilizator` varchar(20) NOT NULL,
  `parola` varchar(20) NOT NULL,
  `permisiuni` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`coduser`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`coduser`, `codpersoana`, `utilizator`, `parola`, `permisiuni`) VALUES
(1, 13, 'ovidiu', '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori_config`
--

CREATE TABLE IF NOT EXISTS `utilizatori_config` (
  `id_conf` int(11) NOT NULL,
  `cod_user` int(2) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `rol` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilizatori_config`
--

INSERT INTO `utilizatori_config` (`id_conf`, `cod_user`, `lang`, `rol`) VALUES
(0, 1, 'ro', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

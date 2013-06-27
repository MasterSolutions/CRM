
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE "activitate" (
  "cod_client" int(11) NOT NULL,
  "nr_fisa" int(11) NOT NULL,
  "ziua" varchar(2) NOT NULL,
  "lunaan" varchar(20) NOT NULL,
  "explicatii" varchar(60) NOT NULL,
  "ora_inc" varchar(5) NOT NULL,
  "ora_fin" varchar(5) NOT NULL,
  "total_ore" int(11) NOT NULL
);

INSERT INTO `activitate` (`cod_client`, `nr_fisa`, `ziua`, `lunaan`, `explicatii`, `ora_inc`, `ora_fin`, `total_ore`) VALUES
(26, 1, '09', 'April-2013', 'Verificare functionalitate script', '13:00', '15:00', 2),
(26, 2, '09', 'April-2013', 'test', '1', '2', 1);

CREATE TABLE "config_societate" (
  "denumire" varchar(75) NOT NULL,
  "cui" varchar(10) NOT NULL,
  "regcom" varchar(13) NOT NULL,
  "adresa" varchar(50) NOT NULL,
  "telefon" varchar(15) NOT NULL,
  "mail" varchar(50) NOT NULL,
  "mailnotificare" varchar(30) NOT NULL,
  "web" varchar(30) NOT NULL,
  "crmclienti" varchar(50) NOT NULL,
  "permitecont" int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY "denumire" ("denumire")
);

INSERT INTO `config_societate` (`denumire`, `cui`, `regcom`, `adresa`, `telefon`, `mail`, `mailnotificare`, `web`, `crmclienti`, `permitecont`) VALUES
('S.C. Master Solutions S.R.L', 'RO18888971', 'J02/1388/2006', 'Calea Aurel Vlaicu, Bloc Z-23, Sc. B, Ap.3', '0744.344.333', 'office@mastersolutions.ro', 'facturare@mastersolutions.ro', 'http://www.mastersolutions.ro', 'http://www.mastersolutions.ro/crm/client/', 1);

CREATE TABLE "documente_emise" (
  "iddoc" int(5) NOT NULL AUTO_INCREMENT,
  "idsoc" int(4) unsigned NOT NULL,
  "nume_fisier" varchar(200) NOT NULL,
  "dimensiune_fisier" varchar(200) NOT NULL,
  "tip_fisier" varchar(200) NOT NULL,
  "ziua" varchar(2) NOT NULL,
  "lunaan" varchar(20) NOT NULL,
  PRIMARY KEY ("iddoc"),
  FULLTEXT KEY "lunadoc" ("lunaan")
);

INSERT INTO `documente_emise` (`iddoc`, `idsoc`, `nume_fisier`, `dimensiune_fisier`, `tip_fisier`, `ziua`, `lunaan`) VALUES
(291, 26, 'modifica.png', '1.28 KB', 'image/png', '22', 'March-2013'),
(288, 26, 'InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '22', 'March-2013'),
(289, 26, 'Raport activitate zilnicaPreda Ovidiu 04.02.2013.doc', '75 KB', 'application/msword', '22', 'March-2013'),
(290, 26, '1BORDEROU_SPECIAL_PLATI.pdf', '311.92 KB', 'application/pdf', '22', 'March-2013'),
(292, 26, 'InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(293, 26, 'InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(294, 26, 'InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(295, 26, '1370600199InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(296, 26, '1370600241InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(297, 26, '1370600245InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(298, 26, '1370600310InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(299, 26, '1370600314InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(300, 26, '1370600336InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(301, 26, '1370600339InstalImpex.xlsx', '8.84 KB', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '07', 'June-2013'),
(302, 0, '1372328914', '0 B', '', '27', 'June-2013'),
(303, 26, 'Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(304, 0, 'Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(305, 0, '1372330680Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(306, 26, '1372330771Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(307, 26, '1372330819Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(308, 26, '1372330998Vodafone.xls', '17 KB', 'application/vnd.ms-excel', '27', 'June-2013'),
(309, 26, 'aLKRbE5_700b_v1.jpg', '105.91 KB', 'image/jpeg', '27', 'June-2013');

CREATE TABLE "meniu" (
  "id_meniu" int(11) NOT NULL AUTO_INCREMENT,
  "modul" varchar(15) NOT NULL,
  "nume_meniu" varchar(25) NOT NULL,
  "ico" varchar(35) NOT NULL,
  "tip" int(11) NOT NULL,
  "parinte" int(11) NOT NULL,
  "ordonare" int(11) NOT NULL,
  "adresa" varchar(30) NOT NULL,
  PRIMARY KEY ("id_meniu")
);

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

CREATE TABLE "sfa" (
  "codsfa" int(11) NOT NULL AUTO_INCREMENT,
  "codsocietate" int(11) DEFAULT NULL,
  "solutie" varchar(30) DEFAULT NULL,
  "valoare" int(6) DEFAULT NULL,
  "data" date DEFAULT NULL,
  "comentariu" varchar(55) DEFAULT NULL,
  "etapa" varchar(20) DEFAULT NULL,
  PRIMARY KEY ("codsfa")
);

CREATE TABLE "sfa_etape" (
  "codsfae" int(11) NOT NULL AUTO_INCREMENT,
  "denumireetapa" varchar(25) NOT NULL,
  "ordine" int(11) NOT NULL,
  PRIMARY KEY ("codsfae")
);

INSERT INTO `sfa_etape` (`codsfae`, `denumireetapa`, `ordine`) VALUES
(1, 'Intalnire agreata', 1),
(2, 'Discutie la client', 4),
(4, 'Ofertat', 3),
(5, 'Finalizare discutii', 2),
(11, 'Refuzat', 6),
(28, 'De revenit cu telefon', 0);

CREATE TABLE "societati" (
  "codsocietate" int(11) NOT NULL AUTO_INCREMENT,
  "denumire" varchar(30) NOT NULL,
  "adresa" varchar(70) NOT NULL,
  "cui" varchar(11) DEFAULT NULL,
  "regcom" varchar(15) DEFAULT NULL,
  "profil" varchar(20) DEFAULT NULL,
  "email" varchar(45) DEFAULT NULL,
  "contact" varchar(30) DEFAULT NULL,
  "functia" varchar(20) DEFAULT NULL,
  "telefon" varchar(12) DEFAULT NULL,
  "emailcontact" varchar(45) DEFAULT NULL,
  "contactat" varchar(2) DEFAULT NULL,
  "observatii" varchar(250) DEFAULT NULL,
  "client" int(1) NOT NULL DEFAULT '0',
  "utilizator" varchar(55) DEFAULT NULL,
  "parola" varchar(55) DEFAULT NULL,
  PRIMARY KEY ("codsocietate")
);

INSERT INTO `societati` (`codsocietate`, `denumire`, `adresa`, `cui`, `regcom`, `profil`, `email`, `contact`, `functia`, `telefon`, `emailcontact`, `contactat`, `observatii`, `client`, `utilizator`, `parola`) VALUES
(25, 'Master Solutions', 'Calea Aurel Vlaicu, Bloc Z-23,', 'RO18888971', 'J02/1388/2006', 'IT', 'OFFICE@MASTERSOLUTIONS.RO', 'Preda Ovidiu', 'Consultant IT', '0744.344.333', 'ovidiu@mastersolutions.ro', 'Da', 'Nu raspunde', 0, NULL, NULL),
(26, 'Phabeda', 'Timisoara', '12345', NULL, 'Comert IT', 'predaovidiualin@gmail.com', 'Florin Mates', 'Sef', '0733.122.333', 'florin@phabeda.ro', 'Nu', NULL, 1, NULL, NULL),
(42, 'LIBRARIA CORINA', 'Eminescu', 'RO1254343', 'J02/1888/2001', 'COMERT', 'predaovidiualin@gmail.com', 'Corina Moldovan', NULL, NULL, NULL, 'Nu', NULL, 0, NULL, NULL),
(43, 'Soft Net Consulting', 'Timisoara', 'RO120033', 'J03/1444/2011', 'IT', 'office@softnetconsulting.ro', 'Dorin Andreica', 'Manager', NULL, NULL, 'Nu', NULL, 0, NULL, NULL);

CREATE TABLE "tblfileupload" (
  "file_id" int(11) NOT NULL AUTO_INCREMENT,
  "file_name" varchar(255) NOT NULL,
  "societate" int(11) NOT NULL,
  PRIMARY KEY ("file_id")
);

CREATE TABLE "utilizatori" (
  "coduser" int(11) NOT NULL AUTO_INCREMENT,
  "utilizator" varchar(20) NOT NULL,
  "mailuser" varchar(70) NOT NULL,
  "parola" varchar(20) NOT NULL,
  "permisiuni" int(1) NOT NULL DEFAULT '0',
  "codsocietate" int(11) NOT NULL,
  PRIMARY KEY ("coduser")
);

INSERT INTO `utilizatori` (`coduser`, `utilizator`, `mailuser`, `parola`, `permisiuni`, `codsocietate`) VALUES
(1, 'ovidiu', '', '1234', 1, 26);

CREATE TABLE "utilizatori_config" (
  "id_conf" int(11) NOT NULL,
  "cod_user" int(2) NOT NULL,
  "lang" varchar(2) NOT NULL,
  "rol" int(1) NOT NULL
);

INSERT INTO `utilizatori_config` (`id_conf`, `cod_user`, `lang`, `rol`) VALUES
(0, 1, 'ro', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.28)
# Database: pje40
# Generation Time: 2013-04-24 21:14:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tbl_crunches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_crunches`;

CREATE TABLE `tbl_crunches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_tests_id` int(11) NOT NULL,
  `authkey` varchar(45) DEFAULT NULL COMMENT '	',
  `last_activity` datetime DEFAULT NULL,
  `result` longtext,
  `completed` int(11) DEFAULT '0',
  `crunch_number` int(11) DEFAULT NULL,
  `time_sent` double DEFAULT NULL,
  `time_returned` double DEFAULT NULL,
  `time_processing` double DEFAULT NULL,
  `time_latency` double DEFAULT NULL,
  `fails` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_crunches_tbl_tests1_idx` (`tbl_tests_id`),
  CONSTRAINT `fk_tbl_crunches_tbl_tests1` FOREIGN KEY (`tbl_tests_id`) REFERENCES `tbl_tests` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tbl_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_profiles`;

CREATE TABLE `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tbl_profiles` WRITE;
/*!40000 ALTER TABLE `tbl_profiles` DISABLE KEYS */;

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`)
VALUES
	(1,'Admin','Administrator'),
	(2,'Demo','Demo');

/*!40000 ALTER TABLE `tbl_profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tbl_profiles_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_profiles_fields`;

CREATE TABLE `tbl_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tbl_profiles_fields` WRITE;
/*!40000 ALTER TABLE `tbl_profiles_fields` DISABLE KEYS */;

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`)
VALUES
	(1,'lastname','Last Name','VARCHAR','50','3',1,'','','Incorrect Last Name (length between 3 and 50 characters).','','','','',1,3),
	(2,'firstname','First Name','VARCHAR','50','3',1,'','','Incorrect First Name (length between 3 and 50 characters).','','','','',0,3);

/*!40000 ALTER TABLE `tbl_profiles_fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tbl_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_tests`;

CREATE TABLE `tbl_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `crunch_file` varchar(45) NOT NULL,
  `display_file` varchar(45) DEFAULT NULL,
  `crunches_required` int(11) DEFAULT NULL,
  `last_crunched` datetime DEFAULT NULL,
  `completed` int(11) DEFAULT '0',
  `tbl_users_id` int(11) NOT NULL,
  `description` text,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_tests_tbl_users1_idx` (`tbl_users_id`),
  CONSTRAINT `fk_tbl_tests_tbl_users1` FOREIGN KEY (`tbl_users_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tbl_tests` WRITE;
/*!40000 ALTER TABLE `tbl_tests` DISABLE KEYS */;

INSERT INTO `tbl_tests` (`id`, `name`, `crunch_file`, `display_file`, `crunches_required`, `last_crunched`, `completed`, `tbl_users_id`, `description`, `date_added`)
VALUES
	(1,'Failure Test','/js/fail_test/crunch.js','/js/fail_test/display.js',10,'2013-04-24 03:07:43',2,1,'A test that should fail.','2013-04-24 03:07:43'),
	(2,'Mandelbrot Set (AJAX - 1 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-24 03:09:16',1,1,'Distributed Mandelbrot Set.','2013-04-24 03:07:41'),
	(3,'Mandelbrot Set (AJAX - 2 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:37:39',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:36:42'),
	(4,'Mandelbrot Set (AJAX - 3 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:40:14',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:39:08'),
	(5,'Mandelbrot Set (AJAX - 4 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:43:13',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:41:48'),
	(6,'Mandelbrot Set (AJAX - 5 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:47:30',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:45:53'),
	(7,'Mandelbrot Set (AJAX - 5 Users, 2 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:50:42',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:48:25'),
	(8,'Mandelbrot Set (AJAX - 5 Users, 2 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:50:51',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:48:25'),
	(9,'Mandelbrot Set (AJAX - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:53:46',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:51:14'),
	(10,'Mandelbrot Set (AJAX - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:53:57',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:51:14'),
	(11,'Mandelbrot Set (AJAX - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:53:59',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:51:14'),
	(12,'Mandelbrot Set (AJAX - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:57:14',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:54:28'),
	(13,'Mandelbrot Set (AJAX - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:57:37',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:54:28'),
	(14,'Mandelbrot Set (AJAX - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:57:32',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:54:28'),
	(15,'Mandelbrot Set (AJAX - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 12:57:46',1,1,'Distributed Mandelbrot Set.','2013-04-19 12:54:28'),
	(20,'Mandelbrot Set (Socket - 1 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 13:07:33',1,1,'Distributed Mandelbrot Set.','2013-04-19 13:06:56'),
	(21,'Mandelbrot Set (Socket - 2 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 13:10:51',1,1,'Distributed Mandelbrot Set.','2013-04-19 13:10:16'),
	(22,'Mandelbrot Set (Socket - 3 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 13:15:22',1,1,'Distributed Mandelbrot Set.','2013-04-19 13:14:47'),
	(23,'Mandelbrot Set (Socket - 4 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 13:16:51',1,1,'Distributed Mandelbrot Set.','2013-04-19 13:16:17'),
	(24,'Mandelbrot Set (Socket - 5 Users)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 13:20:38',1,1,'Distributed Mandelbrot Set.','2013-04-19 13:20:04'),
	(25,'Mandelbrot Set (Socket - 5 Users, 2 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:14:54',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:13:42'),
	(26,'Mandelbrot Set (Socket - 5 Users, 2 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:14:56',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:13:42'),
	(29,'Mandelbrot Set (Socket - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:17:05',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:15:12'),
	(30,'Mandelbrot Set (Socket - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:18:51',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:15:12'),
	(31,'Mandelbrot Set (Socket - 5 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:17:05',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:15:12'),
	(32,'Mandelbrot Set (Socket - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:22:20',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:20:02'),
	(33,'Mandelbrot Set (Socket - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:22:06',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:20:02'),
	(34,'Mandelbrot Set (Socket - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:21:48',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:20:02'),
	(35,'Mandelbrot Set (Socket - 5 Users, 4 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:22:16',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:20:02'),
	(36,'Mandelbrot Set (Socket - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:27:18',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:25:35'),
	(37,'Mandelbrot Set (Socket - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:27:08',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:25:35'),
	(38,'Mandelbrot Set (Socket - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:27:58',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:25:35'),
	(39,'Mandelbrot Set (AJAX - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:32:58',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(40,'Mandelbrot Set (AJAX - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:33:17',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(41,'Mandelbrot Set (AJAX - 3 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-19 14:33:08',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(42,'Mandelbrot Set (AJAX - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:08:54',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(43,'Mandelbrot Set (AJAX - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:08:56',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(44,'Mandelbrot Set (AJAX - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:08:58',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(45,'Mandelbrot Set (Socket - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:11:59',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(46,'Mandelbrot Set (Socket - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:11:53',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00'),
	(47,'Mandelbrot Set (Socket - 1 Users, 3 Tests)','/js/mandelbrot/crunch.js','/js/mandelbrot/display.js',10,'2013-04-23 14:11:56',1,1,'Distributed Mandelbrot Set.','2013-04-19 14:31:00');

/*!40000 ALTER TABLE `tbl_tests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tbl_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`)
VALUES
	(1,'admin','21232f297a57a5a743894a0e4a801fc3','webmaster@example.com','9a24eff8c15a6a141ece27eb6947da0f','2013-01-26 18:51:55','2013-04-14 17:02:39',1,1),
	(2,'demo','fe01ce2a7fbac8fafaed7c982a04e229','demo@example.com','099f825543f7850cc038b90aaff39fac','2013-01-26 18:51:55','0000-00-00 00:00:00',0,1);

/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

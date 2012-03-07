-- MySQL dump 10.11
--
-- Host: localhost    Database: sprred_test
-- ------------------------------------------------------
-- Server version	5.0.51a-24+lenny4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `profile_info`
--

DROP TABLE IF EXISTS `profile_info`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `profile_info` (
  `profile_ID` bigint(20) unsigned NOT NULL auto_increment,
  `ID` bigint(20) unsigned NOT NULL default '0',
  `sname` varchar(32) collate utf8_unicode_ci NOT NULL,
  `url` varchar(100) collate utf8_unicode_ci default NULL,
  `name` varchar(32) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`profile_ID`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `profile_info`
--

LOCK TABLES `profile_info` WRITE;
/*!40000 ALTER TABLE `profile_info` DISABLE KEYS */;
INSERT INTO `profile_info` VALUES (3,4,'kuldeepk','http://kuldeepk.sprred.com','Untitled',NULL,'2010-07-25 11:22:47','2010-07-25 11:22:47'),(4,5,'ram','http://ram.sprred.com','Untitled',NULL,'2010-07-29 07:41:14','2010-07-29 07:41:14'),(5,3,'kuldeep','http://kuldeep.sprred.com','Paper Thin Walls',NULL,'0000-00-00 00:00:00','2010-07-31 16:30:24'),(6,6,'kultest','http://kultest.sprred.com','Untitled',NULL,'2010-07-30 16:25:34','2010-07-30 16:25:34'),(7,7,'kuldeepkap','http://kuldeepkap.sprred.com','Untitled',NULL,'2010-07-30 16:27:18','2010-07-30 16:27:18'),(8,8,'kuldeepkapade','http://kuldeepkapade.sprred.com','Untitled',NULL,'2010-08-07 19:55:49','2010-08-07 19:55:49'),(9,9,'rohan','http://rohan.sprred.com','Ramblings',NULL,'2010-08-20 11:46:35','2010-08-22 10:16:30'),(12,12,'threepoint','http://threepoint.sprred.com','Untitled',NULL,'2010-08-20 11:59:42','2010-08-20 11:59:42'),(13,13,'rohanmahadar','http://rohanmahadar.sprred.com','Untitled',NULL,'2010-08-20 15:01:54','2010-08-20 15:01:54'),(14,14,'iamalive','http://iamalive.sprred.com','iamalive',NULL,'2010-08-29 14:31:15','2010-08-29 14:41:35'),(15,15,'kvrushali','http://kvrushali.sprred.com','kvrushali',NULL,'2010-08-31 18:14:20','2010-08-31 18:15:03'),(16,16,'adese','http://adese.sprred.com','Untitled',NULL,'2010-09-01 05:48:41','2010-09-01 05:48:41'),(17,17,'hardik','http://hardik.sprred.com','My Sprred',NULL,'2010-09-01 06:31:18','2010-09-01 06:41:17'),(18,18,'aalaap','http://aalaap.sprred.com','Peanut Butter Sprred',NULL,'2010-09-01 07:02:06','2010-09-01 07:09:20'),(19,19,'hiway','http://hiway.sprred.com','Wanderlust Ahoy!',NULL,'2010-09-01 07:07:03','2010-09-01 07:09:07');
/*!40000 ALTER TABLE `profile_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `fullname` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(64) collate utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `email` (`email`),
  KEY `fullname` (`fullname`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'Kuldeep Kapade','ce8c0aa4762072eeafe937e8ac0acfdb','kuldeepkapade@gmail.com',1,'2010-07-23 19:56:44','2010-08-07 20:58:21'),(4,'Kuldeep Kapade','ce8c0aa4762072eeafe937e8ac0acfdb','kuldeep_kap@yahoo.com',0,'2010-07-25 11:22:46','2010-07-30 15:28:52'),(5,'Unknown','ee7996f4bce1d7e598281dca2276f9a9','r.ramprasad@gmail.com',0,'2010-07-29 07:41:14','2010-07-29 07:41:14'),(6,'Unknown','ce8c0aa4762072eeafe937e8ac0acfdb','kul@test.com',0,'2010-07-30 16:25:33','2010-07-30 16:25:33'),(7,'Unknown','ce8c0aa4762072eeafe937e8ac0acfdb','kul@sprred.com',0,'2010-07-30 16:27:18','2010-07-30 16:27:18'),(8,'Unknown','ce8c0aa4762072eeafe937e8ac0acfdb','kuldeep@redanyway.com',0,'2010-08-07 19:55:48','2010-08-07 19:55:48'),(9,'Rohan Mahadar','32a4e059baa673e8983aeab0c9cc61da','rohanmahadar@gmail.com',0,'2010-08-20 11:46:34','2010-08-22 10:16:35'),(12,'Unknown','ce8c0aa4762072eeafe937e8ac0acfdb','kuldeep@threepoint.in',0,'2010-08-20 11:59:42','2010-08-20 11:59:42'),(13,'Unknown','32a4e059baa673e8983aeab0c9cc61da','rohan@redanyway.com',0,'2010-08-20 15:01:54','2010-08-20 15:01:54'),(14,'Rashi','b0c185326cfce8932eb0ec2e79ca6ccc','rashi.shukla1@gmail.com',0,'2010-08-29 14:31:15','2010-08-29 14:41:38'),(15,'vrushali','fe21dd99f5ccb0f9d87f86fcadaa69f6','vrush.omsai@gmail.com',0,'2010-08-31 18:14:19','2010-08-31 18:14:49'),(16,'Unknown','c378985d629e99a4e86213db0cd5e70d','aditi1985@gmail.com',0,'2010-09-01 05:48:41','2010-09-01 05:48:41'),(17,'Hardik Ruparel','ae2b1fca515949e5d54fb22b8ed95575','hardik988@gmail.com',0,'2010-09-01 06:31:18','2010-09-01 06:31:56'),(18,'Aalaap Ghag','dc647eb65e6711e155375218212b3964','aalaap@gmail.com',0,'2010-09-01 07:02:05','2010-09-01 07:02:40'),(19,'Harshad Sharma','66fc1c78bc929fbac80dc695c2d30dae','harshad.sharma@gmail.com',0,'2010-09-01 07:07:03','2010-09-01 07:08:47');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-09-01  7:11:41

-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: capstone_login
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

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
-- Current Database: `capstone_login`
--

/*!40000 DROP DATABASE IF EXISTS `capstone_login`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `capstone_login` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `capstone_login`;

--
-- Table structure for table `power_load`
--

DROP TABLE IF EXISTS `power_load`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `power_load` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `power_load`
--

LOCK TABLES `power_load` WRITE;
/*!40000 ALTER TABLE `power_load` DISABLE KEYS */;
INSERT INTO `power_load` VALUES (1,'off');
INSERT INTO `power_load` VALUES (2,'off');
INSERT INTO `power_load` VALUES (3,'off');
INSERT INTO `power_load` VALUES (4,'off');
INSERT INTO `power_load` VALUES (5,'off');
INSERT INTO `power_load` VALUES (6,'off');
INSERT INTO `power_load` VALUES (7,'off');
INSERT INTO `power_load` VALUES (8,'off');
INSERT INTO `power_load` VALUES (9,'off');
INSERT INTO `power_load` VALUES (10,'off');
INSERT INTO `power_load` VALUES (11,'off');
INSERT INTO `power_load` VALUES (12,'off');
INSERT INTO `power_load` VALUES (13,'off');
INSERT INTO `power_load` VALUES (14,'off');
INSERT INTO `power_load` VALUES (15,'off');
INSERT INTO `power_load` VALUES (16,'off');
INSERT INTO `power_load` VALUES (17,'off');
INSERT INTO `power_load` VALUES (18,'off');
INSERT INTO `power_load` VALUES (19,'off');
INSERT INTO `power_load` VALUES (20,'off');
INSERT INTO `power_load` VALUES (21,'off');
INSERT INTO `power_load` VALUES (22,'off');
INSERT INTO `power_load` VALUES (23,'off');
INSERT INTO `power_load` VALUES (24,'off');
INSERT INTO `power_load` VALUES (25,'off');
INSERT INTO `power_load` VALUES (26,'off');
INSERT INTO `power_load` VALUES (27,'off');
INSERT INTO `power_load` VALUES (28,'off');
INSERT INTO `power_load` VALUES (29,'off');
INSERT INTO `power_load` VALUES (30,'off');
INSERT INTO `power_load` VALUES (31,'off');
INSERT INTO `power_load` VALUES (32,'off');
INSERT INTO `power_load` VALUES (33,'off');
INSERT INTO `power_load` VALUES (34,'off');
INSERT INTO `power_load` VALUES (35,'off');
INSERT INTO `power_load` VALUES (36,'off');
INSERT INTO `power_load` VALUES (37,'off');
INSERT INTO `power_load` VALUES (38,'off');
INSERT INTO `power_load` VALUES (39,'off');
INSERT INTO `power_load` VALUES (40,'off');
INSERT INTO `power_load` VALUES (41,'off');
INSERT INTO `power_load` VALUES (42,'off');
INSERT INTO `power_load` VALUES (43,'off');
INSERT INTO `power_load` VALUES (44,'off');
INSERT INTO `power_load` VALUES (45,'off');
INSERT INTO `power_load` VALUES (46,'off');
INSERT INTO `power_load` VALUES (47,'off');
INSERT INTO `power_load` VALUES (48,'off');
INSERT INTO `power_load` VALUES (49,'off');
INSERT INTO `power_load` VALUES (50,'off');
INSERT INTO `power_load` VALUES (51,'off');
INSERT INTO `power_load` VALUES (52,'off');
INSERT INTO `power_load` VALUES (53,'off');
INSERT INTO `power_load` VALUES (54,'off');
INSERT INTO `power_load` VALUES (55,'off');
INSERT INTO `power_load` VALUES (56,'off');
INSERT INTO `power_load` VALUES (57,'off');
INSERT INTO `power_load` VALUES (58,'off');
INSERT INTO `power_load` VALUES (59,'off');
INSERT INTO `power_load` VALUES (60,'off');
INSERT INTO `power_load` VALUES (61,'off');
INSERT INTO `power_load` VALUES (62,'off');
INSERT INTO `power_load` VALUES (63,'off');
INSERT INTO `power_load` VALUES (64,'off');
INSERT INTO `power_load` VALUES (65,'off');
INSERT INTO `power_load` VALUES (66,'off');
INSERT INTO `power_load` VALUES (67,'off');
INSERT INTO `power_load` VALUES (68,'off');
INSERT INTO `power_load` VALUES (69,'off');
INSERT INTO `power_load` VALUES (70,'off');
INSERT INTO `power_load` VALUES (71,'off');
INSERT INTO `power_load` VALUES (72,'off');
INSERT INTO `power_load` VALUES (73,'off');
INSERT INTO `power_load` VALUES (74,'off');
INSERT INTO `power_load` VALUES (75,'off');
INSERT INTO `power_load` VALUES (76,'off');
INSERT INTO `power_load` VALUES (77,'off');
INSERT INTO `power_load` VALUES (78,'off');
INSERT INTO `power_load` VALUES (79,'off');
INSERT INTO `power_load` VALUES (80,'off');
INSERT INTO `power_load` VALUES (81,'off');
INSERT INTO `power_load` VALUES (82,'off');
INSERT INTO `power_load` VALUES (83,'off');
INSERT INTO `power_load` VALUES (84,'off');
INSERT INTO `power_load` VALUES (85,'off');
INSERT INTO `power_load` VALUES (86,'off');
INSERT INTO `power_load` VALUES (87,'off');
INSERT INTO `power_load` VALUES (88,'off');
INSERT INTO `power_load` VALUES (89,'off');
INSERT INTO `power_load` VALUES (90,'off');
INSERT INTO `power_load` VALUES (91,'off');
INSERT INTO `power_load` VALUES (92,'off');
INSERT INTO `power_load` VALUES (93,'off');
INSERT INTO `power_load` VALUES (94,'off');
INSERT INTO `power_load` VALUES (95,'off');
INSERT INTO `power_load` VALUES (96,'off');
INSERT INTO `power_load` VALUES (97,'off');
INSERT INTO `power_load` VALUES (98,'off');
INSERT INTO `power_load` VALUES (99,'off');
INSERT INTO `power_load` VALUES (100,'off');
/*!40000 ALTER TABLE `power_load` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-21 12:25:18

-- MySQL dump 10.13  Distrib 5.5.44, for Win32 (x86)
--
-- Host: localhost    Database: contact_mananger
-- ------------------------------------------------------
-- Server version	5.5.44

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
-- Table structure for table `best_phone`
--

DROP TABLE IF EXISTS `best_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best_phone` (
  `id_contacts` int(6) NOT NULL AUTO_INCREMENT,
  `best_phone` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_contacts`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best_phone`
--

LOCK TABLES `best_phone` WRITE;
/*!40000 ALTER TABLE `best_phone` DISABLE KEYS */;
INSERT INTO `best_phone` VALUES (1,'home'),(7,NULL),(9,NULL),(10,'home'),(13,NULL),(14,NULL),(15,NULL),(23,'home'),(41,NULL),(49,'home'),(50,''),(51,''),(52,''),(53,''),(54,'work'),(57,'work'),(72,''),(73,'cell'),(78,'work'),(105,NULL),(106,NULL);
/*!40000 ALTER TABLE `best_phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
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
  `birth_day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (54,1,'Назар','Корчевський','naaa.nazar@gmail.com','','0352-22-33-56','','','','','','','','1988-12-25'),(57,1,'Fоряна','Шкільник','zor@gma.com','','','','','','','','','','1989-10-18'),(64,NULL,'Павло','Корчевський',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-06-15'),(65,NULL,'Паролв','Корчевський',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-06-08'),(66,NULL,'Зореслава','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,NULL,'зарева','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,NULL,'Зореслава','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,NULL,'зарева','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,NULL,'Андрій','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(71,NULL,'Андрій','Шкільник',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(72,1,'Артур','Корчевський','asdasdasd@ere.fsd','','','','','','','','','','1989-10-18'),(73,1,'Назар','Васильвич','asdasdasd@ere.fsd','22222','1111','','','','','','','','1989-10-18'),(78,1,'Зоряна','Шкільник','naaa.nazar@gmail.com','','222222','','','','','','','','1989-10-18'),(105,1,NULL,NULL,'dzsdsd@sdadd.asd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,1,NULL,NULL,'111@sdasd.asd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'naaa','e10adc3949ba59abbe56e057f20f883e'),(2,'admin','0192023a7bbd73250516f069df18b500'),(3,'admin1','e10adc3949ba59abbe56e057f20f883e'),(4,'naaa123','e10adc3949ba59abbe56e057f20f883e');
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

-- Dump completed on 2016-06-14 13:53:55

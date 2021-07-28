-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: parser
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `client_secret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vk_token_expires` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int NOT NULL DEFAULT '0',
  `worked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applications_client_id_unique` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,7753984,'1Z1DEoVW5krvfOpVyZvc','http://92.38.152.201/second','52feaf527bdcdd7137426a8bde7bd3727b6b0833907743deb5d036c6cdb6d5a4f71e28fbe17417b7ef24c','2021-03-13 10:58:51','https://oauth.vk.com/authorize?client_id=7753984&redirect_uri=http%3A%2F%2F92.38.152.201%2Fsecond&display=page&scope=270336&state=secret_state_code&response_type=code&v=5.101',600,0,'2021-02-07 13:25:13','2021-03-12 20:37:11'),(2,7457469,'ARrjAicTsuU7ta4HTOvV','http://92.38.152.201/second','1cbb81c531da91f2aac7d267a68c2dfb6dfe4787e95389184f366b109a5f33370075ea595de208b41e7fa','2021-03-13 10:58:55','https://oauth.vk.com/authorize?client_id=7457469&redirect_uri=http%3A%2F%2F92.38.152.201%2Fsecond&display=page&scope=270336&state=secret_state_code&response_type=code&v=5.101',600,0,'2021-02-07 13:25:45','2021-03-12 20:16:01'),(3,7436120,'WpiQkAdSZvuLhHuPuHvi','http://92.38.152.201/second','a5d4c95b79b02e45f3c35c0a6ff90f71eca8e3e4e40ac197aa9d7286fc1a8c5d638ee31d905a6e4d5bbba','2021-03-13 10:58:58','https://oauth.vk.com/authorize?client_id=7436120&redirect_uri=http%3A%2F%2F92.38.152.201%2Fsecond&display=page&scope=270336&state=secret_state_code&response_type=code&v=5.101',0,0,'2021-02-07 13:26:13','2021-03-12 08:58:58');
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chicken_note`
--

DROP TABLE IF EXISTS `chicken_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chicken_note` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint unsigned NOT NULL,
  `chicken_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chicken_note_note_id_foreign` (`note_id`),
  KEY `chicken_note_chicken_id_foreign` (`chicken_id`),
  CONSTRAINT `chicken_note_chicken_id_foreign` FOREIGN KEY (`chicken_id`) REFERENCES `chickens` (`id`),
  CONSTRAINT `chicken_note_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=447 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chicken_note`
--

LOCK TABLES `chicken_note` WRITE;
/*!40000 ALTER TABLE `chicken_note` DISABLE KEYS */;
INSERT INTO `chicken_note` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,1,4,NULL,NULL),(5,1,5,NULL,NULL),(6,1,6,NULL,NULL),(7,1,7,NULL,NULL),(8,1,8,NULL,NULL),(9,1,9,NULL,NULL),(10,1,10,NULL,NULL),(11,1,11,NULL,NULL),(12,1,12,NULL,NULL),(13,1,13,NULL,NULL),(14,1,14,NULL,NULL),(15,1,15,NULL,NULL),(16,1,16,NULL,NULL),(17,1,17,NULL,NULL),(18,1,18,NULL,NULL),(19,1,19,NULL,NULL),(20,1,20,NULL,NULL),(21,1,21,NULL,NULL),(22,1,22,NULL,NULL),(23,1,23,NULL,NULL),(24,1,24,NULL,NULL),(25,1,25,NULL,NULL),(26,1,26,NULL,NULL),(27,1,27,NULL,NULL),(28,1,28,NULL,NULL),(29,1,29,NULL,NULL),(30,1,30,NULL,NULL),(31,1,31,NULL,NULL),(32,1,32,NULL,NULL),(33,1,33,NULL,NULL),(34,1,34,NULL,NULL),(35,1,35,NULL,NULL),(36,1,36,NULL,NULL),(37,1,37,NULL,NULL),(38,1,38,NULL,NULL),(39,1,39,NULL,NULL),(40,1,40,NULL,NULL),(41,1,41,NULL,NULL),(42,1,42,NULL,NULL),(43,1,43,NULL,NULL),(44,1,44,NULL,NULL),(45,1,45,NULL,NULL),(46,1,46,NULL,NULL),(47,1,47,NULL,NULL),(48,1,48,NULL,NULL),(49,1,49,NULL,NULL),(50,1,50,NULL,NULL),(51,1,51,NULL,NULL),(52,1,52,NULL,NULL),(53,2,53,NULL,NULL),(54,2,54,NULL,NULL),(55,2,55,NULL,NULL),(56,2,56,NULL,NULL),(57,2,57,NULL,NULL),(58,2,58,NULL,NULL),(59,2,59,NULL,NULL),(60,2,60,NULL,NULL),(61,2,3,NULL,NULL),(62,2,61,NULL,NULL),(63,2,62,NULL,NULL),(64,2,63,NULL,NULL),(65,2,64,NULL,NULL),(66,2,65,NULL,NULL),(67,2,6,NULL,NULL),(68,2,66,NULL,NULL),(69,2,7,NULL,NULL),(70,2,67,NULL,NULL),(71,2,68,NULL,NULL),(72,2,69,NULL,NULL),(73,2,10,NULL,NULL),(74,2,70,NULL,NULL),(75,2,71,NULL,NULL),(76,2,72,NULL,NULL),(77,2,14,NULL,NULL),(78,2,73,NULL,NULL),(79,2,74,NULL,NULL),(80,2,75,NULL,NULL),(81,2,76,NULL,NULL),(82,2,77,NULL,NULL),(83,2,78,NULL,NULL),(84,2,79,NULL,NULL),(85,2,17,NULL,NULL),(86,2,80,NULL,NULL),(87,2,81,NULL,NULL),(88,2,18,NULL,NULL),(89,2,82,NULL,NULL),(90,2,19,NULL,NULL),(91,2,83,NULL,NULL),(92,2,84,NULL,NULL),(93,2,85,NULL,NULL),(94,2,86,NULL,NULL),(95,2,87,NULL,NULL),(96,2,88,NULL,NULL),(97,2,27,NULL,NULL),(98,2,89,NULL,NULL),(99,2,90,NULL,NULL),(100,2,91,NULL,NULL),(101,2,31,NULL,NULL),(102,2,92,NULL,NULL),(103,2,36,NULL,NULL),(104,2,93,NULL,NULL),(105,2,94,NULL,NULL),(106,2,37,NULL,NULL),(107,2,95,NULL,NULL),(108,2,96,NULL,NULL),(109,2,97,NULL,NULL),(110,2,98,NULL,NULL),(111,2,39,NULL,NULL),(112,2,99,NULL,NULL),(113,2,100,NULL,NULL),(114,3,101,NULL,NULL),(115,3,102,NULL,NULL),(116,3,103,NULL,NULL),(117,3,104,NULL,NULL),(118,3,105,NULL,NULL),(119,3,106,NULL,NULL),(120,3,107,NULL,NULL),(121,3,108,NULL,NULL),(122,3,109,NULL,NULL),(123,3,110,NULL,NULL),(124,3,111,NULL,NULL),(125,3,112,NULL,NULL),(126,3,113,NULL,NULL),(127,3,114,NULL,NULL),(128,3,115,NULL,NULL),(129,3,116,NULL,NULL),(130,3,117,NULL,NULL),(131,3,118,NULL,NULL),(132,3,119,NULL,NULL),(133,3,120,NULL,NULL),(134,3,121,NULL,NULL),(135,3,53,NULL,NULL),(136,3,122,NULL,NULL),(137,3,123,NULL,NULL),(138,3,57,NULL,NULL),(139,3,124,NULL,NULL),(140,3,125,NULL,NULL),(141,3,126,NULL,NULL),(142,3,127,NULL,NULL),(143,3,128,NULL,NULL),(144,3,60,NULL,NULL),(145,3,129,NULL,NULL),(146,3,130,NULL,NULL),(147,3,131,NULL,NULL),(148,3,132,NULL,NULL),(149,3,133,NULL,NULL),(150,3,134,NULL,NULL),(151,3,135,NULL,NULL),(152,3,136,NULL,NULL),(153,3,137,NULL,NULL),(154,3,138,NULL,NULL),(155,3,139,NULL,NULL),(156,3,140,NULL,NULL),(157,3,141,NULL,NULL),(158,3,142,NULL,NULL),(159,3,143,NULL,NULL),(160,3,144,NULL,NULL),(161,3,65,NULL,NULL),(162,3,145,NULL,NULL),(163,3,146,NULL,NULL),(164,3,147,NULL,NULL),(165,3,148,NULL,NULL),(166,3,149,NULL,NULL),(167,3,150,NULL,NULL),(168,3,9,NULL,NULL),(169,3,151,NULL,NULL),(170,3,152,NULL,NULL),(171,3,153,NULL,NULL),(172,3,154,NULL,NULL),(173,3,155,NULL,NULL),(174,3,156,NULL,NULL),(175,3,157,NULL,NULL),(176,3,158,NULL,NULL),(177,3,159,NULL,NULL),(178,3,160,NULL,NULL),(179,3,161,NULL,NULL),(180,3,162,NULL,NULL),(181,3,163,NULL,NULL),(182,3,164,NULL,NULL),(183,3,165,NULL,NULL),(184,3,166,NULL,NULL),(185,3,167,NULL,NULL),(186,3,168,NULL,NULL),(187,3,74,NULL,NULL),(188,3,169,NULL,NULL),(189,3,170,NULL,NULL),(190,3,171,NULL,NULL),(191,3,172,NULL,NULL),(192,3,173,NULL,NULL),(193,3,174,NULL,NULL),(194,3,175,NULL,NULL),(195,3,176,NULL,NULL),(196,3,177,NULL,NULL),(197,3,178,NULL,NULL),(198,3,179,NULL,NULL),(199,3,180,NULL,NULL),(200,3,181,NULL,NULL),(201,3,182,NULL,NULL),(202,3,183,NULL,NULL),(203,3,184,NULL,NULL),(204,3,185,NULL,NULL),(205,3,186,NULL,NULL),(206,3,187,NULL,NULL),(207,3,76,NULL,NULL),(208,3,188,NULL,NULL),(209,3,189,NULL,NULL),(210,3,190,NULL,NULL),(211,3,191,NULL,NULL),(212,3,192,NULL,NULL),(213,3,193,NULL,NULL),(214,3,194,NULL,NULL),(215,3,195,NULL,NULL),(216,3,196,NULL,NULL),(217,3,197,NULL,NULL),(218,3,198,NULL,NULL),(219,3,199,NULL,NULL),(220,3,200,NULL,NULL),(221,3,20,NULL,NULL),(222,3,201,NULL,NULL),(223,3,202,NULL,NULL),(224,3,203,NULL,NULL),(225,3,204,NULL,NULL),(226,3,205,NULL,NULL),(227,3,206,NULL,NULL),(228,3,207,NULL,NULL),(229,3,208,NULL,NULL),(230,3,209,NULL,NULL),(231,3,210,NULL,NULL),(232,3,211,NULL,NULL),(233,3,212,NULL,NULL),(234,3,213,NULL,NULL),(235,3,214,NULL,NULL),(236,3,215,NULL,NULL),(237,3,216,NULL,NULL),(238,3,217,NULL,NULL),(239,3,218,NULL,NULL),(240,3,219,NULL,NULL),(241,3,220,NULL,NULL),(242,3,221,NULL,NULL),(243,3,222,NULL,NULL),(244,3,223,NULL,NULL),(245,3,27,NULL,NULL),(246,3,224,NULL,NULL),(247,3,225,NULL,NULL),(248,3,226,NULL,NULL),(249,3,227,NULL,NULL),(250,3,30,NULL,NULL),(251,3,228,NULL,NULL),(252,3,91,NULL,NULL),(253,3,229,NULL,NULL),(254,3,230,NULL,NULL),(255,3,231,NULL,NULL),(256,3,232,NULL,NULL),(257,3,233,NULL,NULL),(258,3,234,NULL,NULL),(259,3,235,NULL,NULL),(260,3,236,NULL,NULL),(261,3,237,NULL,NULL),(262,3,238,NULL,NULL),(263,3,239,NULL,NULL),(264,3,240,NULL,NULL),(265,3,241,NULL,NULL),(266,3,242,NULL,NULL),(267,3,243,NULL,NULL),(268,3,244,NULL,NULL),(269,3,245,NULL,NULL),(270,3,246,NULL,NULL),(271,3,247,NULL,NULL),(272,3,248,NULL,NULL),(273,3,249,NULL,NULL),(274,3,250,NULL,NULL),(275,3,251,NULL,NULL),(276,3,252,NULL,NULL),(277,3,253,NULL,NULL),(278,3,254,NULL,NULL),(279,3,255,NULL,NULL),(280,3,256,NULL,NULL),(281,3,257,NULL,NULL),(282,3,258,NULL,NULL),(283,3,96,NULL,NULL),(284,3,259,NULL,NULL),(285,3,260,NULL,NULL),(286,3,261,NULL,NULL),(287,3,262,NULL,NULL),(288,3,263,NULL,NULL),(289,3,264,NULL,NULL),(290,3,265,NULL,NULL),(291,3,266,NULL,NULL),(292,3,267,NULL,NULL),(293,3,268,NULL,NULL),(294,3,269,NULL,NULL),(295,3,270,NULL,NULL),(296,3,271,NULL,NULL),(297,3,272,NULL,NULL),(298,3,273,NULL,NULL),(299,3,274,NULL,NULL),(300,3,275,NULL,NULL),(301,3,276,NULL,NULL),(302,3,277,NULL,NULL),(303,3,278,NULL,NULL),(304,3,279,NULL,NULL),(305,3,280,NULL,NULL),(306,3,281,NULL,NULL),(307,3,282,NULL,NULL),(308,3,283,NULL,NULL),(309,3,284,NULL,NULL),(310,4,285,NULL,NULL),(311,4,286,NULL,NULL),(312,4,215,NULL,NULL),(313,4,230,NULL,NULL),(314,4,37,NULL,NULL),(315,4,287,NULL,NULL),(316,4,288,NULL,NULL),(317,4,281,NULL,NULL),(318,4,289,NULL,NULL),(319,4,290,NULL,NULL),(320,5,53,NULL,NULL),(321,5,59,NULL,NULL),(322,5,11,NULL,NULL),(323,5,13,NULL,NULL),(324,5,15,NULL,NULL),(325,5,16,NULL,NULL),(326,5,78,NULL,NULL),(327,5,291,NULL,NULL),(328,5,222,NULL,NULL),(329,5,292,NULL,NULL),(330,5,28,NULL,NULL),(331,5,230,NULL,NULL),(332,5,34,NULL,NULL),(333,5,36,NULL,NULL),(334,5,293,NULL,NULL),(335,5,294,NULL,NULL),(336,5,37,NULL,NULL),(337,5,39,NULL,NULL),(338,5,41,NULL,NULL),(339,5,44,NULL,NULL),(340,5,288,NULL,NULL),(341,5,295,NULL,NULL),(342,5,296,NULL,NULL),(343,5,48,NULL,NULL),(344,5,297,NULL,NULL),(345,5,298,NULL,NULL),(346,6,299,NULL,NULL),(347,6,91,NULL,NULL),(348,6,300,NULL,NULL),(349,6,301,NULL,NULL),(350,6,302,NULL,NULL),(351,6,303,NULL,NULL),(352,7,304,NULL,NULL),(353,7,104,NULL,NULL),(354,7,305,NULL,NULL),(355,7,306,NULL,NULL),(356,7,307,NULL,NULL),(357,7,121,NULL,NULL),(358,7,129,NULL,NULL),(359,7,4,NULL,NULL),(360,7,138,NULL,NULL),(361,7,152,NULL,NULL),(362,7,308,NULL,NULL),(363,7,309,NULL,NULL),(364,7,310,NULL,NULL),(365,7,311,NULL,NULL),(366,7,36,NULL,NULL),(367,7,238,NULL,NULL),(368,7,312,NULL,NULL),(369,7,278,NULL,NULL),(370,7,313,NULL,NULL),(371,8,306,NULL,NULL),(372,8,54,NULL,NULL),(373,8,57,NULL,NULL),(374,8,314,NULL,NULL),(375,8,315,NULL,NULL),(376,8,316,NULL,NULL),(377,8,174,NULL,NULL),(378,8,22,NULL,NULL),(379,8,317,NULL,NULL),(380,8,318,NULL,NULL),(381,8,319,NULL,NULL),(382,8,36,NULL,NULL),(383,8,93,NULL,NULL),(384,8,300,NULL,NULL),(385,8,39,NULL,NULL),(386,9,320,NULL,NULL),(387,9,321,NULL,NULL),(388,9,322,NULL,NULL),(389,9,323,NULL,NULL),(390,9,324,NULL,NULL),(391,9,325,NULL,NULL),(392,10,326,NULL,NULL),(393,10,4,NULL,NULL),(394,10,315,NULL,NULL),(395,10,63,NULL,NULL),(396,10,327,NULL,NULL),(397,10,12,NULL,NULL),(398,10,328,NULL,NULL),(399,10,329,NULL,NULL),(400,10,15,NULL,NULL),(401,10,74,NULL,NULL),(402,10,330,NULL,NULL),(403,10,331,NULL,NULL),(404,10,332,NULL,NULL),(405,10,333,NULL,NULL),(406,10,334,NULL,NULL),(407,10,24,NULL,NULL),(408,10,335,NULL,NULL),(409,10,87,NULL,NULL),(410,10,336,NULL,NULL),(411,10,32,NULL,NULL),(412,10,337,NULL,NULL),(413,10,338,NULL,NULL),(414,10,93,NULL,NULL),(415,10,339,NULL,NULL),(416,10,340,NULL,NULL),(417,10,341,NULL,NULL),(418,10,250,NULL,NULL),(419,10,342,NULL,NULL),(420,10,343,NULL,NULL),(421,10,261,NULL,NULL),(422,10,344,NULL,NULL),(423,10,345,NULL,NULL),(424,10,346,NULL,NULL),(425,10,39,NULL,NULL),(426,10,347,NULL,NULL),(427,10,348,NULL,NULL),(428,10,288,NULL,NULL),(429,11,349,NULL,NULL),(430,11,350,NULL,NULL),(431,11,321,NULL,NULL),(432,11,351,NULL,NULL),(433,11,352,NULL,NULL),(434,11,353,NULL,NULL),(435,11,354,NULL,NULL),(436,11,355,NULL,NULL),(437,11,356,NULL,NULL),(438,11,210,NULL,NULL),(439,11,357,NULL,NULL),(440,11,358,NULL,NULL),(441,11,359,NULL,NULL),(442,11,360,NULL,NULL),(443,11,361,NULL,NULL),(444,11,362,NULL,NULL),(445,11,267,NULL,NULL),(446,11,363,NULL,NULL);

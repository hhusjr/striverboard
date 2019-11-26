-- MySQL dump 10.13  Distrib 8.0.16, for osx10.14 (x86_64)
--
-- Host: localhost    Database: striverboard
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `striverboard_comments`
--

DROP TABLE IF EXISTS `striverboard_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_comments` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `post_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `mid_index` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_comments`
--

LOCK TABLES `striverboard_comments` WRITE;
/*!40000 ALTER TABLE `striverboard_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `striverboard_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_fields`
--

DROP TABLE IF EXISTS `striverboard_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_fields` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_fields`
--

LOCK TABLES `striverboard_fields` WRITE;
/*!40000 ALTER TABLE `striverboard_fields` DISABLE KEYS */;
INSERT INTO `striverboard_fields` VALUES (3,'信息技术'),(6,'化学'),(5,'化学工业'),(2,'新能源技术'),(16,'服务业'),(14,'材料工业'),(13,'材料科学'),(8,'林业'),(4,'水利工程'),(9,'渔业'),(10,'电器'),(12,'电器工业'),(7,'畜牧业'),(1,'种植业'),(11,'食品'),(15,'食品工业');
/*!40000 ALTER TABLE `striverboard_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_greats`
--

DROP TABLE IF EXISTS `striverboard_greats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_greats` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(42) NOT NULL,
  `intro` varchar(42) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  PRIMARY KEY (`gid`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_greats`
--

LOCK TABLES `striverboard_greats` WRITE;
/*!40000 ALTER TABLE `striverboard_greats` DISABLE KEYS */;
INSERT INTO `striverboard_greats` VALUES (1,'一分钟的中国','奋斗造福中国','http://player.youku.com/embed/XNDAxNDQ5OTk0NA==','view/default/static/imgs/video_thumbnails/v1.jpg'),(2,'王继才夫妇的故事','守岛30年','http://player.youku.com/embed/XMzgzMTI0Mjc1Mg==','view/default/static/imgs/video_thumbnails/v2.jpg'),(3,'卢仁峰与他的“牙咬焊帽”','大国工匠的炼成','http://player.youku.com/embed/XMzg0MDk4NjA5Mg==','view/default/static/imgs/video_thumbnails/v3.jpg'),(4,'阿里的奋斗故事','创新创业中的奋斗','http://player.youku.com/embed/XMTYyMDQzMzg0NA==','view/default/static/imgs/video_thumbnails/v4.jpg'),(5,'“最美奋斗者”郑守仁','用生命守护水利工程','http://player.youku.com/embed/XNDM4MTcwNzkxMg==','view/default/static/imgs/video_thumbnails/v5.jpg'),(6,'19国庆大阅兵之幕后','钢铁是怎样炼成的','http://player.youku.com/embed/XNDM3NDU4NzgxNg==','view/default/static/imgs/video_thumbnails/v6.jpg'),(7,'丹顶鹤守护者','用生命守护丹顶鹤43年','http://player.youku.com/embed/XMzkzMTI1NDE4MA==','view/default/static/imgs/video_thumbnails/v7.jpg'),(8,'华为的成长历程','奋斗铸就科技强国','http://player.youku.com/embed/XNDQzNDQ0NDc0OA==','/view/default/static/imgs/video_thumbnails/v8.jpg');
/*!40000 ALTER TABLE `striverboard_greats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_mission_words`
--

DROP TABLE IF EXISTS `striverboard_mission_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_mission_words` (
  `word` varchar(24) NOT NULL,
  `times` int(10) unsigned NOT NULL,
  `idf` double unsigned NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words`
--

LOCK TABLES `striverboard_mission_words` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words` VALUES ('使命',1,7.96578345636),('内容',1,5.13428337493),('初心',1,13.2075304714),('地方',1,4.41589243433),('填写',1,8.91707103027),('测试',1,7.14723973338),('这个',1,3.56732510451);
/*!40000 ALTER TABLE `striverboard_mission_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_mission_words_index`
--

DROP TABLE IF EXISTS `striverboard_mission_words_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_mission_words_index` (
  `uid` int(10) unsigned NOT NULL,
  `word` varchar(24) NOT NULL,
  `tf_idf` double NOT NULL,
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words_index`
--

LOCK TABLES `striverboard_mission_words_index` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words_index` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words_index` VALUES (1,'初心',1.8867900673429),(1,'填写',1.2738672900386),(1,'使命',1.1379690651943),(1,'测试',1.0210342476257),(1,'内容',0.73346905356143),(1,'地方',0.63084177633286),(1,'这个',0.50961787207286);
/*!40000 ALTER TABLE `striverboard_mission_words_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_moments`
--

DROP TABLE IF EXISTS `striverboard_moments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_moments` (
  `mid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `location_lng` double NOT NULL,
  `location_lat` double NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `visibility` enum('private','public') NOT NULL,
  `achieved` tinyint(4) unsigned NOT NULL,
  `significant` tinyint(3) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `index_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments`
--

LOCK TABLES `striverboard_moments` WRITE;
/*!40000 ALTER TABLE `striverboard_moments` DISABLE KEYS */;
INSERT INTO `striverboard_moments` VALUES (1,'内容内容内容内容ABC',118.78422291083,31.919147594682,1574602023,1,'public',1,0,3),(2,'我参加了一次志愿活动。为国家做出了自己的一点贡献。。。。。。。。。',116.2,39.56,1574603659,1,'public',1,0,16),(3,'这次志愿活动中我的收获非常大，让我对国家有了更深刻的认识和体会，我坚信自己会继续成长，为祖国做出自己的贡献。',118.78422226517,31.919147396143,1574603702,1,'public',1,0,3);
/*!40000 ALTER TABLE `striverboard_moments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_moments_photos`
--

DROP TABLE IF EXISTS `striverboard_moments_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_moments_photos` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments_photos`
--

LOCK TABLES `striverboard_moments_photos` WRITE;
/*!40000 ALTER TABLE `striverboard_moments_photos` DISABLE KEYS */;
INSERT INTO `striverboard_moments_photos` VALUES (1,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_02_47.png'),(2,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_13_26.png'),(3,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-14%20%E4%B8%8B%E5%8D%881_51_34%201.png');
/*!40000 ALTER TABLE `striverboard_moments_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_moments_words`
--

DROP TABLE IF EXISTS `striverboard_moments_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_moments_words` (
  `word` varchar(24) NOT NULL,
  `times` int(10) unsigned NOT NULL,
  `idf` double unsigned NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments_words`
--

LOCK TABLES `striverboard_moments_words` WRITE;
/*!40000 ALTER TABLE `striverboard_moments_words` DISABLE KEYS */;
INSERT INTO `striverboard_moments_words` VALUES ('。。。。。。。。。',1,11.9547675029),('ABC',1,11.9547675029),('一次',1,4.66466953325),('一点',1,4.86350089901),('体会',1,7.8093677699),('做出',2,6.15740795115),('内容',1,5.13428337493),('参加',1,5.0710122193),('国家',2,4.00044539216),('坚信',1,8.61241062128),('志愿',2,9.04864738806),('成长',1,6.10092433369),('收获',1,7.35102690974),('活动',2,4.71207177215),('深刻',1,6.75864107727),('祖国',1,7.45020722983),('继续',1,4.26742525829),('自己',2,3.52303883354),('认识',1,5.67946755805),('贡献',2,6.04203699635),('这次',1,5.48043598664),('非常',1,4.90328300634);
/*!40000 ALTER TABLE `striverboard_moments_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_msgverification_codes`
--

DROP TABLE IF EXISTS `striverboard_msgverification_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_msgverification_codes` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` char(11) DEFAULT NULL,
  `code` char(32) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `phone_action_index` (`phone`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_msgverification_codes`
--

LOCK TABLES `striverboard_msgverification_codes` WRITE;
/*!40000 ALTER TABLE `striverboard_msgverification_codes` DISABLE KEYS */;
INSERT INTO `striverboard_msgverification_codes` VALUES (2,'13809073869','3f3c1af70e1a330897107a6eb5cb421d','userRegister',1574601943);
/*!40000 ALTER TABLE `striverboard_msgverification_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_options`
--

DROP TABLE IF EXISTS `striverboard_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_options` (
  `name` varchar(28) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_options`
--

LOCK TABLES `striverboard_options` WRITE;
/*!40000 ALTER TABLE `striverboard_options` DISABLE KEYS */;
INSERT INTO `striverboard_options` VALUES ('site.name','奋斗墙'),('site.slogan','不忘初心，牢记使命'),('site.uri','http://127.0.0.1'),('striverboard.photoLimit','20');
/*!40000 ALTER TABLE `striverboard_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_users`
--

DROP TABLE IF EXISTS `striverboard_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `real_name` varchar(15) NOT NULL,
  `password` char(32) NOT NULL,
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `moments_visibility` enum('private','public') NOT NULL DEFAULT 'public',
  `phone` char(11) NOT NULL,
  `mission` varchar(202) NOT NULL,
  `fid` int(11) unsigned NOT NULL,
  `institution` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `admin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `phone_UNIQUE` (`phone`),
  KEY `idx_striverboard_users_realname` (`real_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_users`
--

LOCK TABLES `striverboard_users` WRITE;
/*!40000 ALTER TABLE `striverboard_users` DISABLE KEYS */;
INSERT INTO `striverboard_users` VALUES (1,'沈俊儒','516bfc5e2597ac0ac3860dd36ae63974',0,'public','13809073869','测试内容，这是我的初心与使命，填写在这个地方！',3,'河海大学','',0);
/*!40000 ALTER TABLE `striverboard_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-26 13:01:14

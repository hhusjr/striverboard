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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `description` text NOT NULL,
  PRIMARY KEY (`gid`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_greats`
--

LOCK TABLES `striverboard_greats` WRITE;
/*!40000 ALTER TABLE `striverboard_greats` DISABLE KEYS */;
INSERT INTO `striverboard_greats` VALUES (1,'一分钟的中国','奋斗造福中国','https://player.youku.com/embed/XNDAxNDQ5OTk0NA==','view/default/static/imgs/video_thumbnails/v1.jpg','《中国一分钟》，给予我们每一个人的，绝不仅仅是震撼和骄傲，更是责任与信心。新时代、新征程，实现“两个百年”目标的中国强国梦，需要我们在每一分钟里奋斗，只要惜时如金、只争朝夕，只要努力奋斗、开拓进取，就会在每一分钟里都有所作为。 '),(2,'王继才夫妇的故事','守岛30年','https://player.youku.com/embed/XMzgzMTI0Mjc1Mg==','view/default/static/imgs/video_thumbnails/v2.jpg','自1986年7月起，王继才和妻子王仕花2人克服常人难以想象的困难，守卫孤岛整整32个年头（截止2018年）。他在艰苦卓绝的困难面前不低头，努力奋斗，在邪恶势力面前更表现出了一位守岛卫士的凛然正气。'),(3,'卢仁峰与他的“牙咬焊帽”','大国工匠的炼成','https://player.youku.com/embed/XMzg0MDk4NjA5Mg==','view/default/static/imgs/video_thumbnails/v3.jpg','在一次意外事故中一只手功能严重损失，却仍然努力奋斗，奋战在焊接坦克第一线。第9届全国技术能手中焊接界唯一一位“中华技能大奖”获奖者，几十年如一日，用一只手执着追求焊接技术革新、被誉为“独手焊侠”'),(4,'阿里的奋斗故事','创新创业中的奋斗','https://player.youku.com/embed/XMTYyMDQzMzg0NA==','view/default/static/imgs/video_thumbnails/v4.jpg','1999年2月，在杭州湖畔家园马云的家中召开第一次全体会议，18位创业成员或坐或站，神情肃穆地围绕着慷慨激昂的马云，马云快速而疯狂地发表激情洋溢的演讲“黑暗中一起摸索，一起喊，我喊叫着往前冲的时候，你们都不会慌了。你们拿着大刀，一直往前冲，十几个人往前冲，有什么好慌的?”'),(5,'“最美奋斗者”郑守仁','用生命守护水利工程','https://player.youku.com/embed/XNDM4MTcwNzkxMg==','view/default/static/imgs/video_thumbnails/v5.jpg','几十年来，他长驻施工现场，带动广大技术人员深入实际，解决各种技术问题，为确保隔河岩工程质量优良、提前一年发电和三峡大江截流及导流明渠截流、三峡二期围堰和三期碾压混凝土围堰设计等工程建设作出突出贡献，为我国水利水电建设和促进科学技术进步作出重要贡献。'),(6,'19国庆大阅兵之幕后','钢铁是怎样炼成的','https://player.youku.com/embed/XNDM3NDU4NzgxNg==','view/default/static/imgs/video_thumbnails/v6.jpg','　　你看，他们的军姿多么标准，步伐一致，均匀、刚劲、有力，每一个动作都精准得误差只有几厘米。行走时，这千万个人如同一个人一样，个个神情庄严，意气风发，斗志昂扬。这源于他们在台下数月的坚持训练，努力奋斗。'),(7,'丹顶鹤守护者','用生命守护丹顶鹤43年','https://player.youku.com/embed/XMzkzMTI1NDE4MA==','view/default/static/imgs/video_thumbnails/v7.jpg','有一个女孩，她从小爱养丹顶鹤，在她大学毕业以后，她仍回到她养鹤的地方，可是有一天，她为了救一只受伤的丹顶鹤，滑进了沼泽地，就再也没有上来，走过那条小河，你可曾听说，有一位女孩，她曾经来过，走过这片芦苇坡，你可曾听说，有一位女孩，她留下一首歌....'),(8,'华为的成长历程','奋斗铸就科技强国','https://player.youku.com/embed/XNDQzNDQ0NDc0OA==','/view/default/static/imgs/video_thumbnails/v8.jpg','任正非说：“我们不管身处何处，我们要看着太平洋的海啸，要盯着大西洋的风暴，理解上甘岭的艰难。要跟着奔腾的万里长江水，一同去远方，去战场，去胜利。”');
/*!40000 ALTER TABLE `striverboard_greats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_likes`
--

DROP TABLE IF EXISTS `striverboard_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_likes` (
  `uid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL,
  UNIQUE KEY `index_mid_uid` (`mid`,`uid`),
  KEY `index_uid` (`uid`),
  KEY `index_mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_likes`
--

LOCK TABLES `striverboard_likes` WRITE;
/*!40000 ALTER TABLE `striverboard_likes` DISABLE KEYS */;
INSERT INTO `striverboard_likes` VALUES (1,1),(1,2),(1,12),(1,15),(1,16),(1,17),(1,19),(1,20),(1,21),(1,22),(1,23),(1,25),(1,26),(1,27),(1,28),(1,30),(1,31),(1,33),(1,34),(1,35),(1,37),(5,12),(5,14),(5,19),(5,20),(5,22),(5,23),(5,24),(5,25),(5,26),(5,27),(5,28),(5,30),(5,33);
/*!40000 ALTER TABLE `striverboard_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_messages`
--

DROP TABLE IF EXISTS `striverboard_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_messages` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `msg_type` varchar(45) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `is_read` tinyint(3) unsigned NOT NULL,
  `msg_params` text NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_messages`
--

LOCK TABLES `striverboard_messages` WRITE;
/*!40000 ALTER TABLE `striverboard_messages` DISABLE KEYS */;
INSERT INTO `striverboard_messages` VALUES (1,1,'newFollower',1574864822,1,'{\"uid\":1}'),(2,1,'newLike',1574864899,1,'{\"uid\":2,\"mid\":2}'),(3,1,'newMoment',1574864876,1,'{\"uid\":2,\"mid\":2}'),(4,1,'newFollower',1574864876,1,'{\"uid\":1}'),(5,1,'newLike',1574935737,1,'{\"mid\":28,\"uid\":1}'),(6,1,'newLike',1574936100,1,'{\"mid\":28,\"uid\":5}'),(7,1,'newLike',1574936102,1,'{\"mid\":25,\"uid\":5}'),(8,1,'newLike',1574936103,1,'{\"mid\":24,\"uid\":5}'),(9,1,'newLike',1574936105,1,'{\"mid\":22,\"uid\":5}'),(10,1,'newLike',1574936106,1,'{\"mid\":23,\"uid\":5}'),(11,1,'newLike',1574936107,1,'{\"mid\":20,\"uid\":5}'),(12,1,'newLike',1574936293,1,'{\"mid\":12,\"uid\":5}'),(13,1,'newLike',1574936295,1,'{\"mid\":14,\"uid\":5}'),(14,1,'newLike',1574936297,1,'{\"mid\":19,\"uid\":5}'),(15,1,'newLike',1574937317,1,'{\"mid\":26,\"uid\":5}'),(16,1,'newLike',1574937320,1,'{\"mid\":27,\"uid\":5}'),(17,5,'newLike',1574937368,1,'{\"mid\":33,\"uid\":1}'),(18,5,'newLike',1574937369,1,'{\"mid\":31,\"uid\":1}'),(19,5,'newLike',1574937370,1,'{\"mid\":30,\"uid\":1}');
/*!40000 ALTER TABLE `striverboard_messages` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words`
--

LOCK TABLES `striverboard_mission_words` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words` VALUES ('作出贡献',1,9.38981814546),('使命',2,7.96578345636),('公司',1,3.50346994358),('内容',2,5.13428337493),('初心',2,13.2075304714),('吉里',1,11.8212361103),('地方',1,4.41589243433),('填写',1,8.91707103027),('奋斗',1,8.23771717184),('我要',1,11.9547675029),('格式',1,8.44535653662),('测试',4,7.14723973338),('祖国',1,7.45020722983),('科技',1,5.83227469341),('空间',1,5.2778639787),('辣椒',1,8.1641053545),('这个',1,3.56732510451),('鲁昆',1,11.9547675029);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words_index`
--

LOCK TABLES `striverboard_mission_words_index` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words_index` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words_index` VALUES (1,'初心',1.8867900673429),(1,'填写',1.2738672900386),(1,'使命',1.1379690651943),(1,'测试',1.0210342476257),(1,'内容',0.73346905356143),(1,'地方',0.63084177633286),(1,'这个',0.50961787207286),(2,'测试',7.14723973338),(3,'测试',7.14723973338),(4,'初心',1.8867900673429),(4,'我要',1.7078239289857),(4,'作出贡献',1.3414025922086),(4,'使命',1.1379690651943),(4,'祖国',1.0643153185471),(4,'测试',1.0210342476257),(4,'内容',0.73346905356143),(6,'奋斗',2.471315151552),(6,'鲁昆',1.19547675029),(6,'吉里',1.18212361103),(6,'格式',0.844535653662),(6,'辣椒',0.81641053545),(6,'科技',0.583227469341),(6,'空间',0.52778639787),(6,'公司',0.350346994358);
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments`
--

LOCK TABLES `striverboard_moments` WRITE;
/*!40000 ALTER TABLE `striverboard_moments` DISABLE KEYS */;
INSERT INTO `striverboard_moments` VALUES (1,'内容内容内容内容ABC',118.78422291083,31.919147594682,1574602023,1,'public',1,0,3),(2,'我参加了一次志愿活动。为国家做出了自己的一点贡献。。。。。。。。。',116.2,39.56,1574603659,1,'public',1,0,16),(3,'这次志愿活动中我的收获非常大，让我对国家有了更深刻的认识和体会，我坚信自己会继续成长，为祖国做出自己的贡献。',118.78422226517,31.919147396143,1574603702,1,'public',1,0,3),(4,'dgffg',118.78286830292,31.916205177202,1574751289,1,'public',1,0,3),(5,'dsfdsfdfsd',118.78275602088,31.917174476881,1574751328,1,'public',1,0,3),(6,'dfdfgdfg',118.78275602088,31.917174476881,1574751370,1,'public',1,0,3),(7,'gggg',118.78190646518,31.916443951724,1574751409,1,'public',1,0,3),(8,'safafsaf',118.78218301936,31.916689496017,1574751430,1,'public',1,0,3),(9,'bbb',118.78218301936,31.916689496017,1574751528,1,'public',1,0,3),(10,'thrtrh',118.78222762376,31.917742269664,1574751567,1,'public',1,0,3),(11,'bbbb',118.78220212674,31.916682859511,1574751708,1,'public',1,0,3),(12,'ddd',118.7820379393,31.917319084352,1574751777,1,'public',1,0,3),(13,'testtest',118.78195021764,31.918021425475,1574751837,1,'public',1,0,3),(14,'test',118.78300421256,31.916167599866,1574751874,1,'public',1,0,3),(15,'fsdfsd',118.78195274252,31.918043653087,1574752040,1,'public',1,0,3),(16,'sdgdssdg',118.781976814,31.916948271863,1574752063,1,'public',1,0,3),(17,'fassafsafsafsasasafasf',118.78326041474,31.91663284897,1574752181,1,'public',1,0,3),(18,'dsfdsfdsfdfs',118.78339377502,31.916594312251,1574752237,1,'public',1,0,3),(19,'dsfdfsdsfd',118.782027737,31.917405689325,1574752270,1,'public',1,0,3),(20,'啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的',360,360,1574801225,1,'public',1,0,3),(21,' 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嗷嗷锕锕风飒的',360,360,1574801315,1,'public',1,0,3),(22,'dsaggadsdgsadgsa',360,360,1574839194,1,'public',1,0,3),(23,'rwar',360,360,1574839202,1,'public',1,0,3),(24,'asfasdfsasdsdfa',360,360,1574839223,1,'public',1,0,3),(25,'sadsadsadsad',360,360,1574839229,1,'public',1,0,3),(26,'asfdfsadsad',360,360,1574839242,1,'public',1,0,3),(27,'asdfsadfadfsadfadfsa',360,360,1574839252,1,'public',1,0,3),(28,'dfgdsdfgdfgdfgsdfg对方 v 个电饭锅电饭锅烧豆腐歌功颂德奋斗奉公守法上的歌功颂德奋斗发广告的防风固沙的',118.78429627815,31.919147341679,1574858382,1,'public',0,0,3),(29,'测试测试',118.78426558345,31.919145265674,1574936727,5,'private',0,0,3),(30,'公开内容',118.78426558345,31.919145265674,1574936870,5,'public',1,0,3),(31,'gsdgdsgdsgdsgds',118.78426531329,31.919145110521,1574937222,5,'public',1,0,3),(32,'test',118.78425415334,31.919153485521,1574937294,5,'private',1,0,3),(33,'asffasfsasfa',118.78425415334,31.919153485521,1574937303,5,'public',1,0,3),(34,'aaa',118.78425414207,31.919153485381,1574942789,1,'public',1,0,3),(35,'asdggasdsg',360,360,1574953051,1,'public',1,0,3),(36,'啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊',118.7842951,31.919142987762,1574999128,1,'public',1,0,3),(37,' 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊  啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊 ',118.7842951,31.919142987762,1574999159,1,'public',1,0,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments_photos`
--

LOCK TABLES `striverboard_moments_photos` WRITE;
/*!40000 ALTER TABLE `striverboard_moments_photos` DISABLE KEYS */;
INSERT INTO `striverboard_moments_photos` VALUES (1,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_02_47.png'),(2,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_13_26.png'),(3,1,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-14%20%E4%B8%8B%E5%8D%881_51_34%201.png'),(4,4,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_13_26.png'),(5,4,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-14%20%E4%B8%8B%E5%8D%881_51_34%201.png'),(6,5,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-31%20%E4%B8%8B%E5%8D%888_13_26.png'),(7,5,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-14%20%E4%B8%8B%E5%8D%881_51_34%201.png'),(8,6,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-07%20%E4%B8%8B%E5%8D%888_22_21.png'),(9,7,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-07%20%E4%B8%8B%E5%8D%888_22_21.png'),(10,8,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-07%20%E4%B8%8B%E5%8D%888_22_21.png'),(11,9,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-10%20%E4%B8%8A%E5%8D%8811_40_04.png'),(12,11,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-19%20%E4%B8%8B%E5%8D%881_20_55.png'),(13,12,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/8b13632762d0f7031ae03f570bfa513d2797c5ef.jpg'),(14,13,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/8b13632762d0f7031ae03f570bfa513d2797c5ef.jpg'),(15,14,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/timg-1.jpg'),(16,19,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-19%20%E4%B8%8B%E5%8D%882_59_37(1).png'),(17,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/8b13632762d0f7031ae03f570bfa513d2797c5ef.jpg'),(18,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-10-25%20%E4%B8%8B%E5%8D%884_35_24.png'),(19,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-18%20%E4%B8%8B%E5%8D%886_22_15.png'),(20,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-19%20%E4%B8%8B%E5%8D%881_20_55.png'),(21,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-19%20%E4%B8%8B%E5%8D%882_59_37.png'),(22,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-11-19%20%E4%B8%8B%E5%8D%882_59_37(1).png'),(23,34,'http://127.0.0.1/data/uploads/356a192b7913b04c54574d18c28d46e6395428ab/images/timg-1.jpg');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments_words`
--

LOCK TABLES `striverboard_moments_words` WRITE;
/*!40000 ALTER TABLE `striverboard_moments_words` DISABLE KEYS */;
INSERT INTO `striverboard_moments_words` VALUES ('。。。。。。。。。',1,11.9547675029),('aaa',1,11.9547675029),('ABC',1,11.9547675029),('asdggasdsg',1,11.9547675029),('asfdfsadsad',1,11.9547675029),('bbb',1,11.9547675029),('bbbb',1,11.9547675029),('ddd',1,11.9547675029),('dfdfgdfg',1,11.9547675029),('dgffg',1,11.9547675029),('dsfdfsdsfd',1,11.9547675029),('dsfdsfdfsd',1,11.9547675029),('fsdfsd',1,11.9547675029),('gggg',1,11.9547675029),('rwar',1,11.9547675029),('safafsaf',1,11.9547675029),('sdgdssdg',1,11.9547675029),('test',2,11.9547675029),('testtest',1,11.9547675029),('thrtrh',1,11.9547675029),('一次',1,4.66466953325),('一点',1,4.86350089901),('体会',1,7.8093677699),('做出',2,6.15740795115),('公开',1,5.61440819919),('内容',2,5.13428337493),('参加',1,5.0710122193),('啊啊啊',4,12.8020653633),('嗷嗷',2,10.0720362555),('国家',2,4.00044539216),('坚信',1,8.61241062128),('奉公守法',1,12.1089181827),('奋斗',1,8.23771717184),('对方',1,6.10379730919),('广告',1,7.37271973435),('志愿',2,9.04864738806),('成长',1,6.10092433369),('收获',1,7.35102690974),('歌功颂德',1,10.1394775363),('活动',2,4.71207177215),('测试',1,7.14723973338),('深刻',1,6.75864107727),('电饭锅',1,11.9547675029),('祖国',1,7.45020722983),('继续',1,4.26742525829),('自己',2,3.52303883354),('认识',1,5.67946755805),('豆腐',1,7.86280673205),('贡献',2,6.04203699635),('这次',1,5.48043598664),('防风固沙',1,11.0103058941),('非常',1,4.90328300634),('风飒',2,11.9547675029);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_msgverification_codes`
--

LOCK TABLES `striverboard_msgverification_codes` WRITE;
/*!40000 ALTER TABLE `striverboard_msgverification_codes` DISABLE KEYS */;
INSERT INTO `striverboard_msgverification_codes` VALUES (6,'13809073869','519555cd6d6b52fd000469a371b30acc','userLogin',1574839961);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_users`
--

LOCK TABLES `striverboard_users` WRITE;
/*!40000 ALTER TABLE `striverboard_users` DISABLE KEYS */;
INSERT INTO `striverboard_users` VALUES (1,'沈俊儒','516bfc5e2597ac0ac3860dd36ae63974',0,'public','13809073869','测试内容，这是我的初心与使命，填写在这个地方！',3,'河海大学','',0),(2,'测试用户','4d55298ee8c2729930732063c557a9e2',0,'public','13770613967','测试测试测试',3,'河海大学','',0),(3,'eeee','ef58972e07acadcdc7f1e8666b1d9d17',0,'public','13222345654','测试测试测试测试测试测试',3,'河海大学','',0),(4,'撒风','d97268c470243e4aac06e65b85e78e2d',0,'public','13433333333','测试内容，这是我的初心与使命，我要为祖国作出贡献！',3,'test','',0),(5,'test1','ae57b7b101b2d8c2df563fe0c21514f1',0,'public','13373737373','gsadsadggsadgsad',3,'dgsagads','',0),(6,'lala','aec46e8995bf0a1066ec292bb3dd0146',0,'public','13818181818','格式的空间里奋斗过；辣椒奋斗过；鲁昆吉里；奋斗科技公司；1格式的空间里奋斗过；辣椒奋斗过；鲁昆吉里；奋斗科技公司；1格式的空间里奋斗过；辣椒奋斗过；鲁昆吉里；奋斗科技公司；1格式的空间里奋斗过；辣椒奋斗过；鲁昆吉里；奋斗科技公司；1格式的空间里奋斗过；辣椒奋斗过；鲁昆吉里；奋斗科技公司；1',3,'aaa','',0);
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

-- Dump completed on 2019-11-29 13:03:12

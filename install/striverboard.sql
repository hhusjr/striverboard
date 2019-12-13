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
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `name` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `striverboard_likes` VALUES (12,12),(12,13),(12,16);
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
  `msg_type` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `is_read` tinyint(3) unsigned NOT NULL,
  `msg_params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_messages`
--

LOCK TABLES `striverboard_messages` WRITE;
/*!40000 ALTER TABLE `striverboard_messages` DISABLE KEYS */;
INSERT INTO `striverboard_messages` VALUES (1,11,'newLike',1576141688,0,'{\"mid\":16,\"uid\":12}'),(2,11,'newLike',1576141689,0,'{\"mid\":12,\"uid\":12}'),(3,11,'newLike',1576141716,0,'{\"mid\":13,\"uid\":12}');
/*!40000 ALTER TABLE `striverboard_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_mission_keywords`
--

DROP TABLE IF EXISTS `striverboard_mission_keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_mission_keywords` (
  `uid` int(10) unsigned NOT NULL,
  `word` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tf_idf` double NOT NULL,
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_keywords`
--

LOCK TABLES `striverboard_mission_keywords` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_keywords` DISABLE KEYS */;
INSERT INTO `striverboard_mission_keywords` VALUES (1,'数学考试',2.3167796086667),(1,'数学',2.2027801586),(1,'好好学',2.01815303045),(1,'满分',1.7061860009667),(1,'作出贡献',1.56496969091),(2,'作出贡献',4.69490907273),(2,'数学',3.3041702379),(3,'数学',1.65208511895),(3,'好好学',1.5136147728375),(3,'高分',1.3124350337875),(3,'很强',0.9426379729125),(3,'考试',0.9293166159675),(3,'学习',0.72213997711375),(3,'能力',0.61691788477125),(4,'很强',1.885275945825),(4,'数学',1.65208511895),(4,'学习',1.4442799542275),(4,'能力',1.2338357695425),(5,'计算机领域',1.6002581704125),(5,'计算机相关',1.4943459378625),(5,'考好',1.4943459378625),(5,'努力学习',1.3762882367625),(5,'考试',0.9293166159675),(5,'计算机',0.85059805386),(5,'知识',0.80610692693125),(5,'贡献',0.75525462454375),(6,'计算机领域',2.56041307266),(6,'计算机科学',1.951508585116),(6,'作出贡献',1.877963629092),(6,'学习',1.155423963382),(6,'技术',0.943891435714),(7,'高等数学',5.6308101612),(7,'努力',3.01145065935),(8,'高等数学',4.50464812896),(8,'学习',2.310847926764),(8,'快乐',1.485048987054),(9,'太空',8.53470163695),(10,'高等数学',5.6308101612),(10,'努力',3.01145065935),(11,'太空',8.53470163695),(12,'河海大学',3.128595822725),(12,'高等数学',2.8154050806),(12,'奇迹',1.9385870985775),(12,'创造',1.45885311077),(13,'fsasafafs',11.9547675029),(14,'fsasafafs',11.9547675029);
/*!40000 ALTER TABLE `striverboard_mission_keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_mission_words`
--

DROP TABLE IF EXISTS `striverboard_mission_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_mission_words` (
  `word` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `striverboard_mission_words` VALUES ('fsasafafs',2,11.9547675029),('作出贡献',3,9.38981814546),('创造',1,5.83541244308),('努力',2,6.0229013187),('努力学习',1,11.0103058941),('太空',2,8.53470163695),('奇迹',1,7.75434839431),('好好学',2,12.1089181827),('学习',4,5.77711981691),('很强',2,7.5411037833),('快乐',1,7.42524493527),('技术',1,4.71945717857),('数学',4,6.6083404758),('数学考试',1,13.900677652),('河海大学',1,12.5143832909),('满分',1,10.2371160058),('知识',1,6.44885541545),('考好',1,11.9547675029),('考试',2,7.43453292774),('能力',2,4.93534307817),('计算机',1,6.80478443088),('计算机相关',1,11.9547675029),('计算机科学',1,9.75754292558),('计算机领域',2,12.8020653633),('贡献',1,6.04203699635),('高分',1,10.4994802703),('高等数学',4,11.2616203224);
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
  `word` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tf_idf` double NOT NULL,
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words_index`
--

LOCK TABLES `striverboard_mission_words_index` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words_index` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words_index` VALUES (1,'数学',1.8022746752182),(1,'数学考试',1.2636979683636),(1,'好好学',1.1008107438818),(1,'满分',0.93064690961818),(1,'作出贡献',0.85361983140545),(1,'好学',0.84061066380182),(1,'考试',0.67586662979455),(1,'好好',0.59108103423273),(1,'贡献',0.54927609057727),(2,'作出贡献',3.12993938182),(2,'数学',2.2027801586),(2,'贡献',2.0140123321167),(3,'数学',1.32166809516),(3,'好好学',1.21089181827),(3,'高分',1.04994802703),(3,'好学',0.924671730182),(3,'很强',0.75411037833),(3,'考试',0.743453292774),(3,'好好',0.650189137656),(3,'学习',0.577711981691),(3,'能力',0.493534307817),(4,'很强',1.885275945825),(4,'数学',1.65208511895),(4,'学习',1.4442799542275),(4,'能力',1.2338357695425),(5,'算机',1.72541735688),(5,'计算机',1.020717664632),(5,'计算',0.839761778565),(5,'计算机领域',0.640103268165),(5,'计算机相关',0.597738375145),(5,'考好',0.597738375145),(5,'努力学习',0.550515294705),(5,'力学',0.3780159174125),(5,'考试',0.371726646387),(5,'知识',0.3224427707725),(5,'贡献',0.3021018498175),(5,'努力',0.301145065935),(5,'学习',0.2888559908455),(5,'相关',0.241785496651),(6,'算机',1.7696588275692),(6,'计算机',1.0468899124431),(6,'计算机领域',0.98477425871538),(6,'计算',0.86129413186154),(6,'计算机科学',0.75058022504462),(6,'作出贡献',0.72229370349692),(6,'贡献',0.46477207664231),(6,'学习',0.44439383207),(6,'科学',0.42904267418385),(6,'技术',0.36303516758231),(7,'高等数学',2.8154050806),(7,'高等',1.93486758257),(7,'数学',1.65208511895),(7,'努力',1.505725329675),(8,'高等数学',2.5025822938667),(8,'高等',1.7198822956178),(8,'数学',1.4685201057333),(8,'学习',1.2838044037578),(8,'快乐',0.82502721503),(9,'太空',8.53470163695),(10,'高等数学',2.8154050806),(10,'高等',1.93486758257),(10,'数学',1.65208511895),(10,'努力',1.505725329675),(11,'太空',8.53470163695),(12,'河海大学',1.3904870323222),(12,'高等数学',1.2512911469333),(12,'海大',1.2364543255222),(12,'河海',1.1825090126667),(12,'奇迹',0.86159426603444),(12,'高等',0.85994114780889),(12,'数学',0.73426005286667),(12,'创造',0.64837916034222),(12,'大学',0.63491258028333),(13,'fsasafafs',11.9547675029),(14,'fsasafafs',11.9547675029);
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
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_lng` double NOT NULL,
  `location_lat` double NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `visibility` enum('private','public') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `achieved` tinyint(4) unsigned NOT NULL,
  `significant` tinyint(3) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `index_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments`
--

LOCK TABLES `striverboard_moments` WRITE;
/*!40000 ALTER TABLE `striverboard_moments` DISABLE KEYS */;
INSERT INTO `striverboard_moments` VALUES (1,'随便坐',115.46097892536,25.921965757224,1576138580,11,'public',1,0,3),(2,'u度点解点解',115.46097892536,25.921965757224,1576138587,11,'public',1,0,3),(3,'福多户杜甫',115.46097892536,25.921965757224,1576138593,11,'public',1,0,3),(4,'海底啥差点',115.46097892536,25.921965757224,1576138600,11,'public',1,0,3),(5,'杜甫草堂镇',115.46097892536,25.921965757224,1576138610,11,'public',1,0,3),(6,'杜甫田螺坑的人。嗯',115.46097892536,25.921965757224,1576138623,11,'public',1,0,3),(7,'中国科学',115.46097892536,25.921965757224,1576138633,11,'public',1,0,3),(8,'中国科学院',115.46097892536,25.921965757224,1576138642,11,'public',1,0,3),(9,'河海大学',115.46097892536,25.921965757224,1576138652,11,'public',1,0,3),(10,'河海大学',115.46097892536,25.921965757224,1576138662,11,'public',1,0,3),(11,'河海大学',115.46097892536,25.921965757224,1576138668,11,'public',1,0,3),(12,'哈哈哈哈哈哈哈',111.77681510387,29.343226364779,1576138726,11,'public',1,0,13),(13,'哦滚哦贵',111.77681510387,29.343226364779,1576138733,11,'public',1,0,13),(14,'次不次',111.77681510387,29.343226364779,1576138741,11,'public',1,0,4),(15,'几佛哦哦哦哦',111.77681510387,29.343226364779,1576138746,11,'public',1,0,4),(16,'一点一点有点贵',106.77381593488,38.211403262864,1576138762,11,'public',1,0,14),(17,'saffsasafsafas',109.98227513726,30.431384868086,1576235853,12,'public',1,0,3),(18,'asdgdgsaadgsgdsagsdasdgag',109.98227513726,30.431384868086,1576235858,12,'public',1,0,3),(19,'saffasaasfsaf',109.98227513726,30.431384868086,1576235905,12,'public',1,0,3),(20,'sadsdasdadsa',108.48056259426,27.615098503278,1576235916,12,'public',1,0,3),(21,'sadfasfasdf',110.64566666225,23.973635917463,1576235929,12,'public',1,0,3),(22,'sdffdssdfsdf',120.53706399698,27.186191494364,1576235957,12,'public',1,0,3),(23,'sadfsad',120.53706399698,27.186191494364,1576235972,12,'public',1,0,3),(24,'sadfadfsdf',119.053599403,34.009171113057,1576235993,12,'public',1,0,3);
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
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments_photos`
--

LOCK TABLES `striverboard_moments_photos` WRITE;
/*!40000 ALTER TABLE `striverboard_moments_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `striverboard_moments_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_moments_words`
--

DROP TABLE IF EXISTS `striverboard_moments_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_moments_words` (
  `word` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `striverboard_moments_words` VALUES ('sadfadfsdf',1,11.9547675029),('sadfasfasdf',1,11.9547675029),('sadfsad',1,11.9547675029),('一点一点',1,9.23723855786),('中国',1,3.02732068666),('中国科学院',1,7.68807155622),('几佛',1,11.9547675029),('哈哈哈',1,9.85762638414),('哈哈哈哈',1,9.69598503258),('哦哦哦',1,12.8020653633),('多户',1,9.69598503258),('差点',1,7.77599426108),('杜甫',3,8.99540287354),('次不次',1,11.9547675029),('河海大学',3,12.5143832909),('海底',1,7.17564400981),('点解',1,12.5143832909),('田螺',1,10.5684731418),('科学',1,5.57755476439),('草堂',1,9.16447920358),('随便',1,6.76578680041);
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
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `phone_action_index` (`phone`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_msgverification_codes`
--

LOCK TABLES `striverboard_msgverification_codes` WRITE;
/*!40000 ALTER TABLE `striverboard_msgverification_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `striverboard_msgverification_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_options`
--

DROP TABLE IF EXISTS `striverboard_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_options` (
  `name` varchar(28) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_options`
--

LOCK TABLES `striverboard_options` WRITE;
/*!40000 ALTER TABLE `striverboard_options` DISABLE KEYS */;
INSERT INTO `striverboard_options` VALUES ('site.name','奋斗墙'),('site.slogan','不忘初心，牢记使命'),('site.uri','http://192.168.1.101'),('striverboard.photoLimit','20');
/*!40000 ALTER TABLE `striverboard_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_user_similarity_cache`
--

DROP TABLE IF EXISTS `striverboard_user_similarity_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_user_similarity_cache` (
  `uid1` int(10) unsigned NOT NULL,
  `uid2` int(10) unsigned NOT NULL,
  `similarity` double unsigned NOT NULL,
  KEY `uid1_uid2_index` (`uid1`,`uid2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_user_similarity_cache`
--

LOCK TABLES `striverboard_user_similarity_cache` WRITE;
/*!40000 ALTER TABLE `striverboard_user_similarity_cache` DISABLE KEYS */;
INSERT INTO `striverboard_user_similarity_cache` VALUES (1,2,0.5822715308199),(1,3,0.6474350519593),(1,4,0.30769826964506),(1,5,0.051767327855114),(1,6,0.10176541213516),(1,7,0.2370498299075),(1,8,0.23235577372663),(1,9,0),(1,10,0.2370498299075),(1,11,0),(1,12,0.14126165681274),(1,13,0),(1,14,0),(2,1,0.5822715308199),(2,3,0.24928302684789),(2,4,0.26753695217468),(2,5,0.053710793916139),(2,6,0.26544843652369),(2,7,0.2061096706203),(2,8,0.20202829087964),(2,9,0),(2,10,0.2061096706203),(2,11,0),(2,12,0.12282393777002),(2,13,0),(2,14,0),(3,1,0.6474350519593),(3,2,0.24928302684789),(3,4,0.59443225497093),(3,5,0.062667020843535),(3,6,0.034143039116618),(3,7,0.19806449604513),(3,8,0.2683295253051),(3,9,0),(3,10,0.19806449604513),(3,11,0),(3,12,0.11802969391724),(3,13,0),(3,14,0),(4,1,0.30769826964506),(4,2,0.26753695217468),(4,3,0.59443225497093),(4,5,0.050642704568918),(4,6,0.073286374437476),(4,7,0.21256790835687),(4,8,0.36759764509289),(4,9,0),(4,10,0.21256790835687),(4,11,0),(4,12,0.12667250143747),(4,13,0),(4,14,0),(5,1,0.051767327855114),(5,2,0.053710793916139),(5,3,0.062667020843535),(5,4,0.050642704568918),(5,6,0.7876146781718),(5,7,0.042405308846424),(5,8,0.038242414613818),(5,9,0),(5,10,0.042405308846424),(5,11,0),(5,12,0),(5,13,0),(5,14,0),(6,1,0.10176541213516),(6,2,0.26544843652369),(6,3,0.034143039116618),(6,4,0.073286374437476),(6,5,0.7876146781718),(6,7,0),(6,8,0.055341592449262),(6,9,0),(6,10,0),(6,11,0),(6,12,0),(6,13,0),(6,14,0),(7,1,0.2370498299075),(7,2,0.2061096706203),(7,3,0.19806449604513),(7,4,0.21256790835687),(7,5,0.042405308846424),(7,6,0),(7,8,0.84686037197661),(7,9,0),(7,10,1),(7,11,0),(7,12,0.51485227724622),(7,13,0),(7,14,0),(8,1,0.23235577372663),(8,2,0.20202829087964),(8,3,0.2683295253051),(8,4,0.36759764509289),(8,5,0.038242414613818),(8,6,0.055341592449262),(8,7,0.84686037197661),(8,9,0),(8,10,0.84686037197661),(8,11,0),(8,12,0.5046571823365),(8,13,0),(8,14,0),(9,1,0),(9,2,0),(9,3,0),(9,4,0),(9,5,0),(9,6,0),(9,7,0),(9,8,0),(9,10,0),(9,11,1),(9,12,0),(9,13,0),(9,14,0),(10,1,0.2370498299075),(10,2,0.2061096706203),(10,3,0.19806449604513),(10,4,0.21256790835687),(10,5,0.042405308846424),(10,6,0),(10,7,1),(10,8,0.84686037197661),(10,9,0),(10,11,0),(10,12,0.51485227724622),(10,13,0),(10,14,0),(11,1,0),(11,2,0),(11,3,0),(11,4,0),(11,5,0),(11,6,0),(11,7,0),(11,8,0),(11,9,1),(11,10,0),(11,12,0),(11,13,0),(11,14,0),(12,1,0.14126165681274),(12,2,0.12282393777002),(12,3,0.11802969391724),(12,4,0.12667250143747),(12,5,0),(12,6,0),(12,7,0.51485227724622),(12,8,0.5046571823365),(12,9,0),(12,10,0.51485227724622),(12,11,0),(12,13,0),(12,14,0),(13,1,0),(13,2,0),(13,3,0),(13,4,0),(13,5,0),(13,6,0),(13,7,0),(13,8,0),(13,9,0),(13,10,0),(13,11,0),(13,12,0),(13,14,1),(14,1,0),(14,2,0),(14,3,0),(14,4,0),(14,5,0),(14,6,0),(14,7,0),(14,8,0),(14,9,0),(14,10,0),(14,11,0),(14,12,0),(14,13,1);
/*!40000 ALTER TABLE `striverboard_user_similarity_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `striverboard_users`
--

DROP TABLE IF EXISTS `striverboard_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `striverboard_users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `real_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `moments_visibility` enum('private','public') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission` varchar(202) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fid` int(11) unsigned NOT NULL,
  `institution` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `phone_UNIQUE` (`phone`),
  KEY `idx_striverboard_users_realname` (`real_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_users`
--

LOCK TABLES `striverboard_users` WRITE;
/*!40000 ALTER TABLE `striverboard_users` DISABLE KEYS */;
INSERT INTO `striverboard_users` VALUES (1,'发发发','adb358b461386a126d5cd0bb9d4df1af',0,'public','13944441111','我要好好学数学，数学考试考满分，并对数学领域作出贡献',3,'河海大学','',0),(2,'发发','159ab7c46e88deba135a6cb23cb64307',0,'public','13944441112','为数学领域作出贡献',3,'河海大学','',0),(3,'iPhone8','0fb47c9ca59503eab511136307f5af56',0,'public','13944441113','我学习数学的能力很强，好好学数学，考试拿高分',3,'河海大学','',0),(4,'iPhone','46b6aa51eb7f9d68c7d51b7a6c432576',0,'public','13944441114','我学习数学的能力很强',3,'河海大学','',0),(5,'iPhon','dd9d2887ca6fe4cdf7543906a2c365dd',0,'public','13944441115','努力学习计算机相关知识 争取为计算机领域做出贡献 计算机考试考好',3,'河海大学','',0),(6,'付费通','9ccb25f3dc413ff98b7ea313d4aa2cc4',0,'public','13944442555','坚持学习计算机科学与技术，为计算机领域作出贡献',3,'河海大学','',0),(7,'付费','a59bd43b69f1a01c076ec58d4fc9225d',0,'public','13944442558','高等数学努力学',3,'河海大学','',0),(8,'日耶耶耶','fe975c4178bc32132c36a5a14bcdb207',0,'public','13944442556','坚持学习高等数学，高等数学让我学习快乐',3,'河海大学','',0),(9,'日耶耶','f0c190a22732a2c0b4549ee398a0d3f1',0,'public','13944442552','我要当太空人',3,'河海大学','',0),(10,'日耶','e99387ae92b4195e7200faeb77c615a6',0,'public','13944442550','我要努力学高等数学',3,'河海大学','',0),(11,'重复','e471bd56abf94c2412e97e4018e1b983',0,'public','13944442596','做太空人',3,'河海大学','',0),(12,'测试','1dc570787fb4ead7e645d47aba00ac85',0,'public','13809073869','高等数学创造河海大学的奇迹。',3,'河海大学','',0),(13,'测试1','1c1c23592fe96a7ca6f16eb833c95e46',0,'public','13809099399','fsasafafs',3,'safsasa','',0),(14,'测试1','9fa3be3f85887a14bc3c0433870ff87b',0,'public','13809092399','fsasafafs',3,'safsasa','',0);
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

-- Dump completed on 2019-12-13 21:30:28

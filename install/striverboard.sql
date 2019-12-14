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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_messages`
--

LOCK TABLES `striverboard_messages` WRITE;
/*!40000 ALTER TABLE `striverboard_messages` DISABLE KEYS */;
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
  UNIQUE KEY `uid_word_unique` (`uid`,`word`),
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_keywords`
--

LOCK TABLES `striverboard_mission_keywords` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_keywords` DISABLE KEYS */;
INSERT INTO `striverboard_mission_keywords` VALUES (1,'严肃',0.26891858585741),(1,'习近平',0.36709976316333),(1,'党内',0.31247577210926),(1,'坚守',0.28664704926963),(1,'坚持原则',0.39012525266667),(1,'始终',0.2284558677663),(1,'弘扬',0.34142764536481),(1,'把握',0.24099256895815),(1,'政治',0.95108211808148),(1,'政治立场',0.40990608547778),(1,'敢抓',0.44276916677407),(1,'敢管',0.41709704897778),(1,'正气',0.32877026411593),(1,'正确',0.24007025071185),(1,'正道',0.35644487159111),(1,'纪律',0.29756331833481),(1,'表率',0.35493294586815),(1,'规矩',0.27210163881296),(1,'遵守',0.28587380538),(1,'高级干部',0.37821474807037),(2,'从严治党',0.45979875011154),(2,'任重道远',0.40647973622308),(2,'八项',0.39181175328077),(2,'惩治腐败',0.45466292731923),(2,'持久战',0.39373523099231),(2,'攻坚战',0.38495605207308),(6,'之战',0.29478107929885),(6,'习近平',0.38121898482346),(6,'从严治党',0.45979875011154),(6,'任重道远',0.40647973622308),(6,'做好',0.24582086099846),(6,'八项',0.39181175328077),(6,'减弱',0.27539070355269),(6,'力度',0.23345594834),(6,'十八',0.30688843201269),(6,'反腐败',0.36807478121885),(6,'坚定不移',0.34802489954077),(6,'容忍',0.33303579372769),(6,'惩治腐败',0.45466292731923),(6,'成效',0.29531159168846),(6,'打赢',0.37350088115192),(6,'持久战',0.39373523099231),(6,'攻坚战',0.38495605207308),(6,'正义',0.30911717216846),(6,'落实',0.26453113714962),(6,'这场',0.25704747001077),(7,'习近平',9.91169360541);
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
INSERT INTO `striverboard_mission_words` VALUES ('严肃',1,7.26080181815),('之战',1,7.66430806177),('习近平',3,9.91169360541),('从严治党',2,11.9547675029),('任重道远',2,10.5684731418),('做好',1,6.39134238596),('党内',1,8.43684584695),('八项',2,10.1871055853),('减弱',1,7.16015829237),('力度',1,6.06985465684),('十八',1,7.97909923233),('反腐败',1,9.56994431169),('坚守',1,7.73947033028),('坚定不移',1,9.04864738806),('坚持原则',1,10.533381822),('始终',1,6.16830842969),('容忍',1,8.65893063692),('弘扬',1,9.21854642485),('惩治腐败',2,11.8212361103),('成效',1,7.6781013839),('打赢',1,9.71102290995),('把握',1,6.50679936187),('持久战',2,10.2371160058),('攻坚战',2,10.0088573539),('政治',1,5.13584343764),('政治立场',1,11.0674643079),('敢抓',1,11.9547675029),('敢管',1,11.2616203224),('正义',1,8.03704647638),('正气',1,8.87679713113),('正确',1,6.48189676922),('正道',1,9.62401153296),('纪律',1,8.03420959504),('落实',1,6.87780956589),('表率',1,9.58318953844),('规矩',1,7.34674424795),('这场',1,6.68323422028),('遵守',1,7.71859274526),('高级干部',1,10.2117981979);
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
  UNIQUE KEY `uid_word_unique` (`uid`,`word`),
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_mission_words_index`
--

LOCK TABLES `striverboard_mission_words_index` WRITE;
/*!40000 ALTER TABLE `striverboard_mission_words_index` DISABLE KEYS */;
INSERT INTO `striverboard_mission_words_index` VALUES (1,'严肃',0.22690005681719),(1,'习近平',0.30974042516906),(1,'党内',0.26365143271719),(1,'原则',0.35748729437375),(1,'坚守',0.24185844782125),(1,'坚持原则',0.3291681819375),(1,'始终',0.19275963842781),(1,'干部',0.19668103502375),(1,'弘扬',0.28807957577656),(1,'把握',0.20333748005844),(1,'政治',0.9629706445575),(1,'政治立场',0.34585825962187),(1,'敢抓',0.37358648446562),(1,'敢管',0.351925635075),(1,'方向',0.16707441789406),(1,'正气',0.27739991034781),(1,'正确',0.20255927403812),(1,'正道',0.300750360405),(1,'生活',0.14480820103344),(1,'立场',0.22511385638469),(1,'纪律',0.251069049845),(1,'表率',0.29947467307625),(1,'规矩',0.22958575774844),(1,'遵守',0.24120602328937),(1,'高级',0.20437305465375),(1,'高级干部',0.31911869368438),(2,'一场',0.16436771080472),(2,'不移',0.28737026640278),(2,'严治',0.38612993477778),(2,'中央',0.14343629352),(2,'之战',0.21289744616028),(2,'习近平',0.2753248223725),(2,'从严治党',0.33207687508056),(2,'任重道远',0.29356869838333),(2,'做好',0.17753728849889),(2,'八项',0.28297515514722),(2,'减弱',0.19889328589917),(2,'力度',0.16860707380111),(2,'十八',0.2216416453425),(2,'反腐',0.27333985115083),(2,'反腐败',0.26583178643583),(2,'坚定',0.20895142967556),(2,'坚定不移',0.251351316335),(2,'容忍',0.24052585102556),(2,'工作',0.11674275950972),(2,'态度',0.16372157795944),(2,'惩治',0.2490612144125),(2,'惩治腐败',0.32836766973056),(2,'成效',0.21328059399722),(2,'打赢',0.2697506363875),(2,'持久',0.21814737424806),(2,'持久战',0.28436433349444),(2,'改变',0.14509941508472),(2,'攻坚',0.27584404828944),(2,'攻坚战',0.27802381538611),(2,'正义',0.22325129101056),(2,'治党',0.38612993477778),(2,'精神',0.15610314587278),(2,'腐败',0.41604774357056),(2,'落实',0.19105026571917),(2,'这场',0.18564539500778),(3,'一场',0.16436771080472),(3,'不移',0.28737026640278),(3,'严治',0.38612993477778),(3,'中央',0.14343629352),(3,'之战',0.21289744616028),(3,'习近平',0.2753248223725),(3,'从严治党',0.33207687508056),(3,'任重道远',0.29356869838333),(3,'做好',0.17753728849889),(3,'八项',0.28297515514722),(3,'减弱',0.19889328589917),(3,'力度',0.16860707380111),(3,'十八',0.2216416453425),(3,'反腐',0.27333985115083),(3,'反腐败',0.26583178643583),(3,'坚定',0.20895142967556),(3,'坚定不移',0.251351316335),(3,'容忍',0.24052585102556),(3,'工作',0.11674275950972),(3,'态度',0.16372157795944),(3,'惩治',0.2490612144125),(3,'惩治腐败',0.32836766973056),(3,'成效',0.21328059399722),(3,'打赢',0.2697506363875),(3,'持久',0.21814737424806),(3,'持久战',0.28436433349444),(3,'改变',0.14509941508472),(3,'攻坚',0.27584404828944),(3,'攻坚战',0.27802381538611),(3,'正义',0.22325129101056),(3,'治党',0.38612993477778),(3,'精神',0.15610314587278),(3,'腐败',0.41604774357056),(3,'落实',0.19105026571917),(3,'这场',0.18564539500778),(4,'一场',0.16436771080472),(4,'不移',0.28737026640278),(4,'严治',0.38612993477778),(4,'中央',0.14343629352),(4,'之战',0.21289744616028),(4,'习近平',0.2753248223725),(4,'从严治党',0.33207687508056),(4,'任重道远',0.29356869838333),(4,'做好',0.17753728849889),(4,'八项',0.28297515514722),(4,'减弱',0.19889328589917),(4,'力度',0.16860707380111),(4,'十八',0.2216416453425),(4,'反腐',0.27333985115083),(4,'反腐败',0.26583178643583),(4,'坚定',0.20895142967556),(4,'坚定不移',0.251351316335),(4,'容忍',0.24052585102556),(4,'工作',0.11674275950972),(4,'态度',0.16372157795944),(4,'惩治',0.2490612144125),(4,'惩治腐败',0.32836766973056),(4,'成效',0.21328059399722),(4,'打赢',0.2697506363875),(4,'持久',0.21814737424806),(4,'持久战',0.28436433349444),(4,'改变',0.14509941508472),(4,'攻坚',0.27584404828944),(4,'攻坚战',0.27802381538611),(4,'正义',0.22325129101056),(4,'治党',0.38612993477778),(4,'精神',0.15610314587278),(4,'腐败',0.41604774357056),(4,'落实',0.19105026571917),(4,'这场',0.18564539500778),(5,'一场',0.16436771080472),(5,'不移',0.28737026640278),(5,'严治',0.38612993477778),(5,'中央',0.14343629352),(5,'之战',0.21289744616028),(5,'习近平',0.2753248223725),(5,'从严治党',0.33207687508056),(5,'任重道远',0.29356869838333),(5,'做好',0.17753728849889),(5,'八项',0.28297515514722),(5,'减弱',0.19889328589917),(5,'力度',0.16860707380111),(5,'十八',0.2216416453425),(5,'反腐',0.27333985115083),(5,'反腐败',0.26583178643583),(5,'坚定',0.20895142967556),(5,'坚定不移',0.251351316335),(5,'容忍',0.24052585102556),(5,'工作',0.11674275950972),(5,'态度',0.16372157795944),(5,'惩治',0.2490612144125),(5,'惩治腐败',0.32836766973056),(5,'成效',0.21328059399722),(5,'打赢',0.2697506363875),(5,'持久',0.21814737424806),(5,'持久战',0.28436433349444),(5,'改变',0.14509941508472),(5,'攻坚',0.27584404828944),(5,'攻坚战',0.27802381538611),(5,'正义',0.22325129101056),(5,'治党',0.38612993477778),(5,'精神',0.15610314587278),(5,'腐败',0.41604774357056),(5,'落实',0.19105026571917),(5,'这场',0.18564539500778),(6,'一场',0.16436771080472),(6,'不移',0.28737026640278),(6,'严治',0.38612993477778),(6,'中央',0.14343629352),(6,'之战',0.21289744616028),(6,'习近平',0.2753248223725),(6,'从严治党',0.33207687508056),(6,'任重道远',0.29356869838333),(6,'做好',0.17753728849889),(6,'八项',0.28297515514722),(6,'减弱',0.19889328589917),(6,'力度',0.16860707380111),(6,'十八',0.2216416453425),(6,'反腐',0.27333985115083),(6,'反腐败',0.26583178643583),(6,'坚定',0.20895142967556),(6,'坚定不移',0.251351316335),(6,'容忍',0.24052585102556),(6,'工作',0.11674275950972),(6,'态度',0.16372157795944),(6,'惩治',0.2490612144125),(6,'惩治腐败',0.32836766973056),(6,'成效',0.21328059399722),(6,'打赢',0.2697506363875),(6,'持久',0.21814737424806),(6,'持久战',0.28436433349444),(6,'改变',0.14509941508472),(6,'攻坚',0.27584404828944),(6,'攻坚战',0.27802381538611),(6,'正义',0.22325129101056),(6,'治党',0.38612993477778),(6,'精神',0.15610314587278),(6,'腐败',0.41604774357056),(6,'落实',0.19105026571917),(6,'这场',0.18564539500778),(7,'习近平',9.91169360541);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_moments`
--

LOCK TABLES `striverboard_moments` WRITE;
/*!40000 ALTER TABLE `striverboard_moments` DISABLE KEYS */;
INSERT INTO `striverboard_moments` VALUES (1,'7月1日上午，庆祝中国共产党成立95周年大会在北京人民大会堂隆重举行。中共中央总书记、国家主席、中央军委主席习近平出席大会并发表重要讲话。讲话中，习近平总书记十提“不忘初心”，他强调，一切向前走，都不能忘记走过的路；走得再远、走到再光辉的未来，也不能忘记走过的过去，不能忘记为什么出发。面向未来，面对挑战，全党同志一定要不忘初心、继续前进。',104.87855663846,24.551336070953,1576299336,7,'public',1,0,3),(2,'7月1日上午，庆祝中国共产党成立95周年大会在北京人民大会堂隆重举行。中共中央总书记、国家主席、中央军委主席习近平出席大会并发表重要讲话。讲话中，习近平总书记十提“不忘初心”，他强调，一切向前走，都不能忘记走过的路；走得再远、走到再光辉的未来，也不能忘记走过的过去，不能忘记为什么出发。面向未来，面对挑战，全党同志一定要不忘初心、继续前进。',104.87855663846,24.551336070953,1576299347,7,'public',1,0,3);
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
INSERT INTO `striverboard_moments_words` VALUES ('95',2,11.9547675029),('不忘',2,9.14708746087),('中央军委',2,8.5440913773),('主席',2,5.77890023281),('习近平',2,9.91169360541),('光辉',2,8.14810501315),('全党同志',2,12.8020653633),('初心',2,13.2075304714),('北京人民大会堂',2,10.765183436),('十提',2,11.9547675029),('向前走',2,8.87023973058),('大会',2,6.16262535429),('庆祝',2,8.24119543622),('忘记',2,6.84364067028),('总书记',2,8.1417758781),('继续前进',2,9.30555780184),('走过',2,7.14957618304),('重要讲话',2,8.90346537821),('隆重举行',2,10.0505300503),('面向未来',2,10.765183436);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_msgverification_codes`
--

LOCK TABLES `striverboard_msgverification_codes` WRITE;
/*!40000 ALTER TABLE `striverboard_msgverification_codes` DISABLE KEYS */;
INSERT INTO `striverboard_msgverification_codes` VALUES (1,'13809073869','bfbe5e554b7f34aad0bd8ce59e7eef7e','userRegister',1576298770);
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
  UNIQUE KEY `uid1_uid2_unique` (`uid1`,`uid2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_user_similarity_cache`
--

LOCK TABLES `striverboard_user_similarity_cache` WRITE;
/*!40000 ALTER TABLE `striverboard_user_similarity_cache` DISABLE KEYS */;
INSERT INTO `striverboard_user_similarity_cache` VALUES (1,2,0.03448237662217),(1,3,0.03448237662217),(1,4,0.03448237662217),(1,5,0.03448237662217),(1,6,0.03448237662217),(1,7,0.18721292495323),(2,1,0.03448237662217),(2,3,1),(2,4,1),(2,5,1),(2,6,1),(2,7,0.18418801282436),(3,1,0.03448237662217),(3,2,1),(3,4,1),(3,5,1),(3,6,1),(3,7,0.18418801282436),(4,1,0.03448237662217),(4,2,1),(4,3,1),(4,5,1),(4,6,1),(4,7,0.18418801282436),(5,1,0.03448237662217),(5,2,1),(5,3,1),(5,4,1),(5,6,1),(5,7,0.18418801282436),(6,1,0.03448237662217),(6,2,1),(6,3,1),(6,4,1),(6,5,1),(6,7,0.18418801282436),(7,1,0.18721292495323),(7,2,0.18418801282436),(7,3,0.18418801282436),(7,4,0.18418801282436),(7,5,0.18418801282436),(7,6,0.18418801282436);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `striverboard_users`
--

LOCK TABLES `striverboard_users` WRITE;
/*!40000 ALTER TABLE `striverboard_users` DISABLE KEYS */;
INSERT INTO `striverboard_users` VALUES (1,'沈俊儒','516bfc5e2597ac0ac3860dd36ae63974',0,'public','13809073869','习近平强调，党的高级干部要做严肃党内政治生活的表率，始终把握正确政治方向，坚持政治立场和政治原则，遵守政治纪律和政治规矩，坚守正道、弘扬正气，坚持原则、敢抓敢管。',3,'hehai','',0),(2,'沈俊儒','4d55298ee8c2729930732063c557a9e2',0,'public','13809073868','习近平强调，党的十八大以来，全面从严治党取得显著成效，但仍然任重道远。落实中央八项规定精神是一场攻坚战、持久战，要坚定不移做好工作。要做到惩治腐败力度决不减弱、零容忍态度决不改变，坚决打赢反腐败这场正义之战。',3,'hehai','',0),(3,'沈俊儒','ef58972e07acadcdc7f1e8666b1d9d17',0,'public','13809073867','习近平强调，党的十八大以来，全面从严治党取得显著成效，但仍然任重道远。落实中央八项规定精神是一场攻坚战、持久战，要坚定不移做好工作。要做到惩治腐败力度决不减弱、零容忍态度决不改变，坚决打赢反腐败这场正义之战。',3,'hehai','',0),(4,'沈俊儒','69382d08600bfcace02f1ddfb38c3107',0,'public','13809073866','习近平强调，党的十八大以来，全面从严治党取得显著成效，但仍然任重道远。落实中央八项规定精神是一场攻坚战、持久战，要坚定不移做好工作。要做到惩治腐败力度决不减弱、零容忍态度决不改变，坚决打赢反腐败这场正义之战。',3,'hehai','',0),(5,'沈俊儒','ae57b7b101b2d8c2df563fe0c21514f1',0,'public','13809073865','习近平强调，党的十八大以来，全面从严治党取得显著成效，但仍然任重道远。落实中央八项规定精神是一场攻坚战、持久战，要坚定不移做好工作。要做到惩治腐败力度决不减弱、零容忍态度决不改变，坚决打赢反腐败这场正义之战。',3,'hehai','',0),(6,'沈俊儒','2abd8f9afcfa5ee90c57aecf6d23bfda',0,'public','13809073864','习近平强调，党的十八大以来，全面从严治党取得显著成效，但仍然任重道远。落实中央八项规定精神是一场攻坚战、持久战，要坚定不移做好工作。要做到惩治腐败力度决不减弱、零容忍态度决不改变，坚决打赢反腐败这场正义之战。',3,'hehai','',0),(7,'saffsa','9b755d87448dec61429cd3e6750ebdee',0,'public','13929292929','习近平',3,'河海大学','',0);
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

-- Dump completed on 2019-12-14 12:58:09

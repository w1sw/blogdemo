-- MySQL dump 10.13  Distrib 5.6.22, for osx10.8 (x86_64)
--
-- Host: localhost    Database: blogdemo
-- ------------------------------------------------------
-- Server version	5.6.23

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
-- Table structure for table `adminuser`
--

DROP TABLE IF EXISTS `adminuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminuser` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `profile` longtext,
  `password_hash` varchar(128) DEFAULT NULL,
  `password_reset_token` varchar(128) DEFAULT NULL,
  `auth_key` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminuser`
--

LOCK TABLES `adminuser` WRITE;
/*!40000 ALTER TABLE `adminuser` DISABLE KEYS */;
INSERT INTO `adminuser` VALUES (1,'邓程夫','dcf','123456','123@132.com','123','$2y$13$WP.nK8cDlMbFI96yEj.JgeuPTtEnoGz44K5h1Ct.u4TE19b4iHuN.',NULL,NULL),(2,'小王','xiaow','123456','xiao@133.com','123','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,NULL),(3,'小张','xiaoz','123456','xiaozhang@163.com','123','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,NULL),(4,'admin','admin','*','sadas@163.com','dasd','$2y$13$ilBTFNQcpuQg6W.zLjxTOO3CnRRQsmEOsP/9aERc/OGQd6xii6vfe',NULL,'nR257COOIts_Vkln23QsOvKP0ZTfKFU6'),(6,'小周','xiaozhou','*','asd@136.com','1234','$2y$13$k0QMoxtnAgrzLxYtNnAEhep3g1gUVmqbW1JxQ9rvx3LtZo9ut.ety',NULL,'1KJZ3GZJ7fvxYLgvFTm_tRsfbgESOUu8'),(7,'测试账户','test','*','asddsad@136.com','asda','$2y$13$2ost7zMXHYkBbQcS02QCyOdvPZkwYkHhDSFkTEQX3FU1f6yCn4Bvy',NULL,'9feUDp0f-rPgmJQtITWy7UNwXCf_SZKf');
/*!40000 ALTER TABLE `adminuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','1',1489647023),('commentAuditor','1',1489647023),('commentAuditor','4',1489031728),('commentAuditor','7',1489672695),('postAdmin','1',1489647023),('postAdmin','2',1489031728),('postOperator','1',1489647023),('postOperator','3',1489031728),('root','1',1489647023);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,'系统管理员',NULL,NULL,1489031728,1489031728),('approveComment',2,'审核评论',NULL,NULL,1489031728,1489031728),('commentAuditor',1,'审核评论员',NULL,NULL,1489031728,1489031728),('createPost',2,'新增文章',NULL,NULL,1489031728,1489031728),('deletePost',2,'删除文章',NULL,NULL,1489031728,1489567876),('postAdmin',1,'文章管理员',NULL,NULL,1489031728,1489031728),('postOperator',1,'文章操作员',NULL,NULL,1489031728,1489031728),('root',1,'超级管理员',NULL,NULL,1489576700,1489576700),('seeAdmininfo',2,'查看管理员信息',NULL,NULL,1489567686,1489567914),('updatePost',2,'修改文章',NULL,NULL,1489031728,1489031728);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('commentAuditor','approveComment'),('admin','commentAuditor'),('postAdmin','createPost'),('postAdmin','deletePost'),('postOperator','deletePost'),('admin','postAdmin'),('root','seeAdmininfo'),('postAdmin','updatePost');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `comment_status_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_post` (`post_id`),
  KEY `comment_status` (`comment_status_id`),
  KEY `comment_user` (`userid`),
  CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  CONSTRAINT `comment_status` FOREIGN KEY (`comment_status_id`) REFERENCES `commentstatus` (`comment_status_id`),
  CONSTRAINT `comment_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,'1111111111111111111111111111',2,143888092,1,'123@','dsada',1),(2,'2222222222222',2,143888092,1,'213','asd',2),(3,'33333333333333333333333333333333',2,143888092,1,'231','dasad',1),(4,'123',2,1489547845,1,'w1sw@qq.com',NULL,3),(5,'123',2,1489548191,1,'w1sw@qq.com',NULL,3),(6,'123',2,1489548202,1,'w1sw@qq.com',NULL,3),(7,'123dasdsa',2,1489548519,1,'w1sw@qq.com',NULL,3),(8,'123dasdsa',2,1489548524,1,'w1sw@qq.com',NULL,3),(9,'hhhh',2,1489548529,1,'w1sw@qq.com',NULL,3),(10,'hhhh',2,1489548662,1,'w1sw@qq.com',NULL,3),(11,'12312ssss',2,1489548746,1,'w1sw@qq.com',NULL,3),(12,'12312ssss',2,1489549082,1,'w1sw@qq.com',NULL,3),(13,'讲的挺好',2,1489672647,3,'w3sw@qq.com',NULL,7);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentstatus`
--

DROP TABLE IF EXISTS `commentstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentstatus` (
  `comment_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`comment_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentstatus`
--

LOCK TABLES `commentstatus` WRITE;
/*!40000 ALTER TABLE `commentstatus` DISABLE KEYS */;
INSERT INTO `commentstatus` VALUES (1,'待审核',NULL),(2,'已审核',NULL);
/*!40000 ALTER TABLE `commentstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1488459279),('m130524_201442_init',1488459285),('m140506_102106_rbac_init',1489025340);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `content` longtext,
  `tags` longtext,
  `post_status_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_status` (`post_status_id`),
  KEY `post_author` (`author_id`),
  CONSTRAINT `post_author` FOREIGN KEY (`author_id`) REFERENCES `adminuser` (`author_id`),
  CONSTRAINT `post_status` FOREIGN KEY (`post_status_id`) REFERENCES `poststatus` (`post_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'测试内容','测试内容1add1','1',1,1488786045,143808983,1),(2,'123','321','213',1,1488786200,1488786200,NULL),(3,'123add','321','213',1,1488786322,1488786296,1),(4,'asdsadas','dsadsa','a,b,c',1,1488789110,1488789110,1),(5,'sa','sa的','大',1,1488855201,1488855201,2),(6,'啊','敖德萨多阿达','阿达',2,1488855214,1488855214,3),(7,'阿萨德','阿萨德','阿萨德',2,1488855226,1488855226,2);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poststatus`
--

DROP TABLE IF EXISTS `poststatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poststatus` (
  `post_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `poistion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`post_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poststatus`
--

LOCK TABLES `poststatus` WRITE;
/*!40000 ALTER TABLE `poststatus` DISABLE KEYS */;
INSERT INTO `poststatus` VALUES (1,'草稿',NULL),(2,'已发布',NULL),(3,'已归档',NULL);
/*!40000 ALTER TABLE `poststatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'a',1),(2,'b',1),(3,'c',1),(4,'大',1),(5,'阿达',1),(6,'阿萨德',1);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'w1sw','9iq7WBPwE3ZDEq9B-pxd7i9Qqdr2FUrZ','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,'w1sw@qq.com',10,1488459553,1488957818),(2,'w2sw','9iq7WBPwE3ZHEq9B-pxd7i9Qqdr2FUrZ','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,'w2sw@qq.com',2,1488459553,1488957818),(3,'w3sw','9iq7WBPwE3ZDGq9B-pxd7i9Qqdr2FUrZ','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,'w3sw@qq.com',10,1488459553,1488957818),(4,'w4sw','9iq7WBPwE3ZDEq9C-pxd7i9Qqdr2FUrZ','$2y$13$EbPhBiKjcgXPEFUQp1MRp.nf64QY8rUVBRoCRlcQC.j1GlbPSMssq',NULL,'w4sw@qq.com',10,1488459553,1488957818);
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

-- Dump completed on 2017-07-05 15:56:32

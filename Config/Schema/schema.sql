-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: olc_drugs
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` binary(36) NOT NULL,
  `member_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) DEFAULT NULL,
  `aco_id` int(11) DEFAULT NULL,
  `_create` int(2) DEFAULT NULL,
  `_read` int(2) DEFAULT NULL,
  `_update` int(2) DEFAULT NULL,
  `_delete` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` binary(36) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_published` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articles_links`
--

DROP TABLE IF EXISTS `articles_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_links` (
  `id` binary(36) NOT NULL,
  `article_id` binary(36) NOT NULL,
  `model` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_id` binary(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`,`model`,`foreign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` binary(36) NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` binary(36) NOT NULL,
  `member_id` int(10) NOT NULL,
  `dirname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternative` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主索引',
  `parent_id` int(10) NOT NULL COMMENT '父分類',
  `code` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '分類代碼',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '原文名稱',
  `name_chinese` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '中文名稱',
  `lft` int(10) NOT NULL COMMENT '左索引',
  `rght` int(10) NOT NULL COMMENT '右索引',
  `count_daily` int(11) NOT NULL DEFAULT '0',
  `count_all` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`),
  KEY `count_daily` (`count_daily`),
  KEY `count_all` (`count_all`)
) ENGINE=InnoDB AUTO_INCREMENT=4044 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_licenses`
--

DROP TABLE IF EXISTS `categories_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_licenses` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `category_id` int(10) NOT NULL COMMENT '分類索引',
  `license_id` binary(36) NOT NULL COMMENT '藥證索引',
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分類類型',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `license_id` binary(36) NOT NULL COMMENT '藥證索引',
  `vendor_id` binary(36) DEFAULT NULL COMMENT '申請商編號',
  `manufacturer_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '製程',
  PRIMARY KEY (`id`),
  KEY `license_uuid` (`license_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_permissions`
--

DROP TABLE IF EXISTS `group_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `id` binary(36) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_licenses` int(11) NOT NULL,
  `count_daily` int(11) NOT NULL DEFAULT '0',
  `count_all` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `count_daily` (`count_daily`),
  KEY `count_all` (`count_all`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingredients_licenses`
--

DROP TABLE IF EXISTS `ingredients_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients_licenses` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `license_id` binary(36) NOT NULL COMMENT '藥證索引',
  `ingredient_id` binary(36) NOT NULL,
  `remark` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '處方標示',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '成分名稱',
  `dosage_text` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '含量描述',
  `dosage` decimal(20,8) NOT NULL COMMENT '含量',
  `unit` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '含量單位',
  PRIMARY KEY (`id`),
  KEY `drug_id` (`license_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `license_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '藥證編號',
  `code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nhi_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '健保代碼(逗點分隔)',
  `shape` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '形狀',
  `s_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '特殊劑型',
  `color` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '顏色',
  `odor` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '特殊氣味',
  `abrasion` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '刻痕',
  `size` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '外觀尺寸',
  `note_1` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '標註一',
  `note_2` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '標註二',
  `image` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `cancel_status` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '註銷狀態',
  `cancel_date` date DEFAULT NULL COMMENT '註銷日期',
  `cancel_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '註銷理由',
  `expired_date` date NOT NULL COMMENT '有效日期',
  `license_date` date NOT NULL COMMENT '發證日期',
  `license_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '許可證種類',
  `old_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '舊證字號',
  `document_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '通關簽審文件編號',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '中文品名',
  `name_english` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '英文品名',
  `disease` text COLLATE utf8mb4_unicode_ci COMMENT '適應症',
  `formulation` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '劑型',
  `package` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '包裝',
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '藥品類別',
  `class` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管制藥品分類級別',
  `ingredient` text COLLATE utf8mb4_unicode_ci COMMENT '主成分略述',
  `vendor_id` binary(36) DEFAULT NULL COMMENT '申請商編號',
  `submitted` date NOT NULL COMMENT '異動日期',
  `usage` text COLLATE utf8mb4_unicode_ci COMMENT '用法用量',
  `package_note` text COLLATE utf8mb4_unicode_ci COMMENT '包裝',
  `barcode` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '國際條碼',
  `count_daily` int(11) NOT NULL DEFAULT '0',
  `count_all` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `count_daily` (`count_daily`),
  KEY `count_all` (`count_all`),
  KEY `submitted` (`submitted`),
  KEY `license_id` (`license_id`),
  KEY `name` (`name`),
  KEY `name_english` (`name_english`),
  KEY `nhi_id` (`nhi_id`),
  KEY `expired_date` (`expired_date`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `license_id` binary(36) NOT NULL COMMENT '藥證索引',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '連結標題',
  `type` tinyint(3) NOT NULL COMMENT '類型',
  `sort` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` binary(36) NOT NULL,
  `license_id` binary(36) NOT NULL,
  `member_id` int(10) NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notices` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `side_effects` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `interactions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_lines`
--

DROP TABLE IF EXISTS `order_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_lines` (
  `id` binary(36) NOT NULL,
  `order_id` binary(36) NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT '0',
  `model` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foreign_id` binary(36) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` binary(36) NOT NULL,
  `account_id` binary(36) NOT NULL,
  `nhi_area` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '健保署服務單位',
  `point_id` binary(36) DEFAULT NULL,
  `point` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '醫事機構',
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` date NOT NULL COMMENT '就醫日期',
  `note_date` date DEFAULT NULL COMMENT '交付調劑、檢查或復健治療日期',
  `nhi_year` year(4) NOT NULL,
  `nhi_sn` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '健保卡就醫序號',
  `nhi_sort` tinyint(2) DEFAULT NULL COMMENT '健保卡就醫序號排序',
  `disease_code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '疾病分類碼',
  `disease` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '疾病分類名稱',
  `process_code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '處置碼',
  `process` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '處置名稱',
  `money_order` int(10) DEFAULT NULL COMMENT '部分負擔金額',
  `money_register` int(10) DEFAULT NULL COMMENT '掛號費',
  `nhi_points` int(10) DEFAULT NULL COMMENT '健保支付點數',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `points` (
  `id` binary(36) NOT NULL,
  `nhi_id` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nhi_end` date DEFAULT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biz_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `town` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nhi_id` (`nhi_id`),
  KEY `longitude` (`longitude`,`latitude`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` binary(36) NOT NULL,
  `license_id` binary(36) NOT NULL,
  `nhi_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '健保代碼',
  `nhi_dosage` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用量',
  `nhi_unit` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用量單位',
  `date_begin` date NOT NULL COMMENT '開始日期',
  `date_end` date NOT NULL COMMENT '結束日期',
  `nhi_price` decimal(10,2) NOT NULL COMMENT '健保價格',
  PRIMARY KEY (`id`),
  KEY `drug_id` (`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendors` (
  `id` binary(36) NOT NULL COMMENT '主索引',
  `tax_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '統一編號',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '名稱',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `address_office` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '辦公室地址',
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '國家',
  `count_daily` int(11) NOT NULL DEFAULT '0',
  `count_all` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `count_daily` (`count_daily`),
  KEY `count_all` (`count_all`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-17 14:05:48

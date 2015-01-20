-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: kiang_drug
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`)
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
  PRIMARY KEY (`id`)
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
  `license_uuid` binary(36) NOT NULL COMMENT '藥證索引',
  `license_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '許可證字號',
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造商名稱',
  `manufacturer_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠廠址',
  `manufacturer_office` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠公司地址',
  `manufacturer_country` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠國別',
  `manufacturer_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '製程',
  PRIMARY KEY (`id`),
  KEY `license_uuid` (`license_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
  PRIMARY KEY (`id`)
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
  KEY `drug_id` (`license_id`)
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
  `vendor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商名稱',
  `vendor_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商地址',
  `vendor_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商統一編號',
  `submitted` date NOT NULL COMMENT '異動日期',
  `usage` text COLLATE utf8mb4_unicode_ci COMMENT '用法用量',
  `package_note` text COLLATE utf8mb4_unicode_ci COMMENT '包裝',
  `barcode` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '國際條碼',
  PRIMARY KEY (`id`)
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-20 22:53:14

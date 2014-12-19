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
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` binary(36) NOT NULL,
  `active_id` binary(36) DEFAULT NULL,
  `linked_id` binary(36) DEFAULT NULL,
  `license_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '許可證字號',
  `cancel_status` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '註銷狀態',
  `cancel_date` date DEFAULT NULL COMMENT '註銷日期',
  `cancel_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '註銷理由',
  `expired_date` date NOT NULL COMMENT '有效日期',
  `license_date` date NOT NULL COMMENT '發證日期',
  `license_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '許可證種類',
  `old_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '舊證字號',
  `document_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '通關簽審文件編號',
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '中文品名',
  `name_english` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '英文品名',
  `disease` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '適應症',
  `formulation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '劑型',
  `package` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '包裝',
  `type` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '藥品類別',
  `class` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管制藥品分類級別',
  `ingredient` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '主成分略述',
  `vendor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商名稱',
  `vendor_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商地址',
  `vendor_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申請商統一編號',
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造商名稱',
  `manufacturer_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠廠址',
  `manufacturer_office` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠公司地址',
  `manufacturer_country` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '製造廠國別',
  `manufacturer_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '製程',
  `submitted` date NOT NULL COMMENT '異動日期',
  `usage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '用法用量',
  `package_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '包裝',
  `barcode` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '國際條碼',
  `md5` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `nhi_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shape` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `odor` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abrasion` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_1` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` binary(36) NOT NULL,
  `drug_id` binary(36) NOT NULL,
  `nhi_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nhi_dosage` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nhi_unit` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_begin` date NOT NULL,
  `date_end` date NOT NULL,
  `nhi_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drug_id` (`drug_id`)
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

-- Dump completed on 2014-12-19 21:15:24

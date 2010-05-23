/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.1.43-community : Database - adspace
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`adspace` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `adspace`;

/*Table structure for table `log_show` */

DROP TABLE IF EXISTS `log_show`;

CREATE TABLE `log_show` (
  `id` varchar(40) NOT NULL,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `real_locas` varchar(200) NOT NULL DEFAULT '',
  `uv_id` varchar(100) NOT NULL DEFAULT '',
  `referer` varchar(1000) NOT NULL DEFAULT '',
  `page_path` varchar(255) NOT NULL DEFAULT '',
  `from_site` varchar(255) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `ua` varchar(500) NOT NULL DEFAULT '',
  `search_key` varchar(100) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ad_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_click` (`aff_id`,`site_id`,`place_id`,`adv_id`,`creative_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `log_show` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

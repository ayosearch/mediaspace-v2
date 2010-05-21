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

/*Table structure for table `fin_advprofit_day_total` */

DROP TABLE IF EXISTS `fin_advprofit_day_total`;

CREATE TABLE `fin_advprofit_day_total` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `income_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `income_count` int(10) unsigned NOT NULL DEFAULT '0',
  `out_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `out_count` int(10) unsigned NOT NULL DEFAULT '0',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_mid_sid_day` (`mer_id`,`adv_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_advprofit_day_total` */

/*Table structure for table `fin_affbill_cycle` */

DROP TABLE IF EXISTS `fin_affbill_cycle`;

CREATE TABLE `fin_affbill_cycle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `need_count` int(10) unsigned NOT NULL DEFAULT '0',
  `need_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `pay_count` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `pay_start` varchar(20) NOT NULL DEFAULT '',
  `pay_end` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `audit_user` varchar(30) NOT NULL DEFAULT '',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `pay_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_affbill_cycle` */

/*Table structure for table `fin_affbill_day` */

DROP TABLE IF EXISTS `fin_affbill_day`;

CREATE TABLE `fin_affbill_day` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_count` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `kill_count` int(10) unsigned NOT NULL DEFAULT '0',
  `kill_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `real_count` int(10) unsigned NOT NULL DEFAULT '0',
  `real_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  `cycle_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aid_aid_day` (`aff_id`,`adv_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_affbill_day` */

/*Table structure for table `fin_affpayment` */

DROP TABLE IF EXISTS `fin_affpayment`;

CREATE TABLE `fin_affpayment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fin_no` varchar(100) NOT NULL DEFAULT '',
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0',
  `pay_cycle` tinyint(1) NOT NULL DEFAULT '0',
  `pay_start` varchar(20) NOT NULL DEFAULT '',
  `pay_end` varchar(20) NOT NULL DEFAULT '',
  `bill_ids` varchar(300) NOT NULL DEFAULT '',
  `real_money` decimal(8,2) NOT NULL,
  `need_money` decimal(8,2) NOT NULL,
  `tax` decimal(8,2) NOT NULL,
  `balance` decimal(8,2) NOT NULL,
  `is_pay` tinyint(1) NOT NULL DEFAULT '0',
  `audit_id` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `payinfo_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aff_id` (`aff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_affpayment` */

/*Table structure for table `fin_affprofit_day_total` */

DROP TABLE IF EXISTS `fin_affprofit_day_total`;

CREATE TABLE `fin_affprofit_day_total` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `income_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `income_count` int(10) unsigned NOT NULL DEFAULT '0',
  `out_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `out_count` int(10) unsigned NOT NULL DEFAULT '0',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_aid_sid_day` (`aff_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_affprofit_day_total` */

/*Table structure for table `fin_affsiteprofit_day_total` */

DROP TABLE IF EXISTS `fin_affsiteprofit_day_total`;

CREATE TABLE `fin_affsiteprofit_day_total` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `income_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `income_count` int(10) unsigned NOT NULL DEFAULT '0',
  `out_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `out_count` int(10) unsigned NOT NULL DEFAULT '0',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_aid_sid_day` (`aff_id`,`site_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_affsiteprofit_day_total` */

/*Table structure for table `fin_merbill_day` */

DROP TABLE IF EXISTS `fin_merbill_day`;

CREATE TABLE `fin_merbill_day` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `need_count` int(10) unsigned NOT NULL DEFAULT '0',
  `need_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `audit_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `audit_user` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_mid_day` (`mer_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_merbill_day` */

/*Table structure for table `fin_merprofit_day_total` */

DROP TABLE IF EXISTS `fin_merprofit_day_total`;

CREATE TABLE `fin_merprofit_day_total` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `income_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `income_count` int(10) unsigned NOT NULL DEFAULT '0',
  `out_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `out_count` int(10) unsigned NOT NULL DEFAULT '0',
  `profit_rate` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_mid_sid_day` (`mer_id`,`iday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fin_merprofit_day_total` */

/*Table structure for table `log_click` */

DROP TABLE IF EXISTS `log_click`;

CREATE TABLE `log_click` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `real_locas` varchar(20) NOT NULL DEFAULT '',
  `uv_id` varchar(100) NOT NULL DEFAULT '',
  `referer` varchar(1000) NOT NULL DEFAULT '',
  `page_path` varchar(255) NOT NULL DEFAULT '',
  `from_site` varchar(255) NOT NULL DEFAULT '',
  `search_key` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `ua` varchar(500) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ad_url` varchar(255) NOT NULL DEFAULT '',
  `show_id` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_click` (`aff_id`,`site_id`,`place_id`,`adv_id`,`creative_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `log_click` */

/*Table structure for table `log_effectlog` */

DROP TABLE IF EXISTS `log_effectlog`;

CREATE TABLE `log_effectlog` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `trans_code` varchar(50) NOT NULL DEFAULT '',
  `order_no` varchar(100) NOT NULL DEFAULT '',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `send_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `leaveword` varchar(500) NOT NULL DEFAULT '',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `param` varchar(200) NOT NULL DEFAULT '',
  `mobile` int(11) NOT NULL DEFAULT '0',
  `ua` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `real_locas` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `log_effectlog` */

/*Table structure for table `log_effectsub` */

DROP TABLE IF EXISTS `log_effectsub`;

CREATE TABLE `log_effectsub` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `trans_code` varchar(50) NOT NULL DEFAULT '',
  `reckey` varchar(200) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `fee_code` varchar(50) NOT NULL DEFAULT '',
  `start_time` varchar(20) NOT NULL DEFAULT '',
  `end_time` varchar(20) NOT NULL DEFAULT '',
  `order_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `send_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `leaveword` varchar(500) NOT NULL DEFAULT '',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `kill_down` tinyint(1) NOT NULL DEFAULT '0',
  `fee_type` tinyint(1) NOT NULL DEFAULT '0',
  `sub_date` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `param` varchar(200) NOT NULL DEFAULT '',
  `ua` varchar(255) NOT NULL DEFAULT '',
  `mobile` int(11) NOT NULL DEFAULT '0',
  `real_locas` varchar(255) NOT NULL DEFAULT '',
  `order_no` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `log_effectsub` */

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

/*Table structure for table `pm_advaccess` */

DROP TABLE IF EXISTS `pm_advaccess`;

CREATE TABLE `pm_advaccess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `memo` varchar(2000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advaccess` */

/*Table structure for table `pm_advbuyaffplaces` */

DROP TABLE IF EXISTS `pm_advbuyaffplaces`;

CREATE TABLE `pm_advbuyaffplaces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `audit_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `audit_user` varchar(200) NOT NULL DEFAULT '',
  `buy_time` smallint(5) unsigned NOT NULL DEFAULT '0',
  `buy_type` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advbuyaffplaces` */

/*Table structure for table `pm_advcreative` */

DROP TABLE IF EXISTS `pm_advcreative`;

CREATE TABLE `pm_advcreative` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `content_type` tinyint(1) NOT NULL DEFAULT '0',
  `res_content` varchar(2000) NOT NULL DEFAULT '',
  `adformat` smallint(6) unsigned NOT NULL DEFAULT '0',
  `adsize` smallint(6) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creator_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `creator_user` varchar(50) NOT NULL DEFAULT '',
  `sysaudit_id` int(10) NOT NULL DEFAULT '0',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `audit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advcreative` */

/*Table structure for table `pm_advertise` */

DROP TABLE IF EXISTS `pm_advertise`;

CREATE TABLE `pm_advertise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `contract_id` int(10) unsigned NOT NULL DEFAULT '0',
  `advtype` varchar(100) NOT NULL DEFAULT '0',
  `aff_count` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `spread` varchar(100) NOT NULL DEFAULT '0',
  `money_state` int(10) unsigned NOT NULL DEFAULT '0',
  `day_maxmoney` decimal(8,2) NOT NULL DEFAULT '0.00',
  `pay_cycle` tinyint(1) NOT NULL DEFAULT '0',
  `audit` tinyint(1) NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sitetype_ids` varchar(2000) NOT NULL DEFAULT '',
  `sel_sitetype` tinyint(1) NOT NULL DEFAULT '0',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `bill_url` varchar(255) NOT NULL DEFAULT '',
  `sys_correct` tinyint(1) NOT NULL DEFAULT '0',
  `use_gateway` tinyint(1) NOT NULL DEFAULT '0',
  `fee_type` tinyint(1) NOT NULL DEFAULT '0',
  `max_crt` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rec_cookie` tinyint(1) NOT NULL DEFAULT '0',
  `filter_likeip` tinyint(1) NOT NULL DEFAULT '0',
  `filter_agentip` tinyint(1) NOT NULL DEFAULT '0',
  `filter_foreignip` tinyint(1) NOT NULL DEFAULT '0',
  `is_view` tinyint(1) NOT NULL DEFAULT '0',
  `is_click` tinyint(1) NOT NULL DEFAULT '0',
  `is_rolling` tinyint(1) NOT NULL DEFAULT '0',
  `mer_onlyfee` tinyint(1) NOT NULL DEFAULT '0',
  `is_weal` tinyint(1) NOT NULL DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `logo` varchar(200) NOT NULL DEFAULT '',
  `area_list` varchar(200) NOT NULL DEFAULT '',
  `site_level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `append_icon` tinyint(1) NOT NULL DEFAULT '0',
  `deduct` decimal(8,2) NOT NULL DEFAULT '0.00',
  `is_selector` tinyint(1) NOT NULL DEFAULT '0',
  `log_flag` varchar(3) NOT NULL DEFAULT 'X',
  `eff_singleip` tinyint(1) NOT NULL DEFAULT '0',
  `eff_likeip` tinyint(1) NOT NULL DEFAULT '0',
  `eff_codelike` int(10) NOT NULL DEFAULT '0',
  `eff_recodenum` int(10) NOT NULL DEFAULT '0',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `aff_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(20) NOT NULL DEFAULT '',
  `aff_unit` varchar(20) NOT NULL DEFAULT '',
  `log_v_created` tinyint(1) NOT NULL DEFAULT '0',
  `log_c_created` tinyint(1) NOT NULL DEFAULT '0',
  `site_count` int(10) NOT NULL DEFAULT '0',
  `audit_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `sysaudit_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `pm_advertise` */

insert  into `pm_advertise`(`id`,`mer_id`,`name`,`memo`,`contract_id`,`advtype`,`aff_count`,`status`,`spread`,`money_state`,`day_maxmoney`,`pay_cycle`,`audit`,`level`,`sitetype_ids`,`sel_sitetype`,`start_time`,`end_time`,`creative_count`,`create_time`,`bill_url`,`sys_correct`,`use_gateway`,`fee_type`,`max_crt`,`rec_cookie`,`filter_likeip`,`filter_agentip`,`filter_foreignip`,`is_view`,`is_click`,`is_rolling`,`mer_onlyfee`,`is_weal`,`page_id`,`logo`,`area_list`,`site_level`,`append_icon`,`deduct`,`is_selector`,`log_flag`,`eff_singleip`,`eff_likeip`,`eff_codelike`,`eff_recodenum`,`price`,`aff_price`,`unit`,`aff_unit`,`log_v_created`,`log_c_created`,`site_count`,`audit_time`,`update_time`,`sysaudit_id`) values (1,2,'酷派亮衣促销','',5,'服装/饰品',0,0,'0',0,'0.00',0,0,0,'',0,2010,2011,0,1274109935,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','',0,0,'0.00',0,'X',0,0,0,0,'0.00','0.00','0','0',0,0,0,0,0,0),(2,2,'酷派亮衣促销2','',5,'服装/饰品',0,0,'0',0,'0.00',0,0,0,'',0,2010,2011,0,1274110059,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','',0,0,'0.00',0,'X',0,0,0,0,'20.00','10.00','0','0',0,0,0,0,0,0),(3,2,'酷派亮衣促销3','',5,'服装/饰品',0,1,'0',0,'100.00',0,1,100,'',0,1275436800,1306972800,0,1274111119,'',0,0,1,2,0,0,0,0,0,0,0,0,0,0,'upload/vcm_s_kf_m160_106x160.jpg','',0,0,'0.00',0,'X',0,0,0,0,'20.00','18.00','元/KIP','元/KIP',1,1,0,1274203478,0,19);

/*Table structure for table `pm_advpages` */

DROP TABLE IF EXISTS `pm_advpages`;

CREATE TABLE `pm_advpages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(200) NOT NULL DEFAULT '',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `start_hour` int(10) unsigned NOT NULL DEFAULT '0',
  `end_hour` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_trace` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` varchar(20) NOT NULL DEFAULT '',
  `end_date` varchar(20) NOT NULL DEFAULT '',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`adv_id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `pm_advpages` */

insert  into `pm_advpages`(`id`,`mer_id`,`adv_id`,`name`,`url`,`code`,`memo`,`create_time`,`start_hour`,`end_hour`,`status`,`is_trace`,`start_date`,`end_date`,`update_time`,`is_del`) values (8,2,3,'夏季系列上衣页面2','http://www.sina.com.cn/cloth','','',1274379028,0,0,1,0,'2010-6-18','2010-7-24',0,0),(7,2,3,'夏季系列上衣页面','http://www.sina.com.cn','','',1274378826,0,0,0,0,'2010-6-4','2010-6-25',0,0);

/*Table structure for table `pm_advrolldetail` */

DROP TABLE IF EXISTS `pm_advrolldetail`;

CREATE TABLE `pm_advrolldetail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `roll_id` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` varchar(30) NOT NULL DEFAULT '',
  `end_time` varchar(30) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`mer_id`),
  KEY `idx_mer_id` (`mer_id`),
  KEY `idx_cti_id` (`creative_id`),
  KEY `idx_roll_id` (`roll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advrolldetail` */

/*Table structure for table `pm_advrollplan` */

DROP TABLE IF EXISTS `pm_advrollplan`;

CREATE TABLE `pm_advrollplan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL DEFAULT '',
  `is_cpc` tinyint(1) NOT NULL DEFAULT '0',
  `is_cpm` tinyint(1) NOT NULL DEFAULT '0',
  `is_cpa` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `is_all` tinyint(1) NOT NULL DEFAULT '0',
  `is_auto` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advrollplan` */

/*Table structure for table `pm_advselector` */

DROP TABLE IF EXISTS `pm_advselector`;

CREATE TABLE `pm_advselector` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('site_kind','area','domain','keyword') NOT NULL DEFAULT 'site_kind',
  `content` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_filter` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_adv_id` (`adv_id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_advselector` */

/*Table structure for table `pm_affadvapply` */

DROP TABLE IF EXISTS `pm_affadvapply`;

CREATE TABLE `pm_affadvapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `audit_user` varchar(30) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `memo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_affadvapply` */

/*Table structure for table `pm_affadvplace` */

DROP TABLE IF EXISTS `pm_affadvplace`;

CREATE TABLE `pm_affadvplace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(100) NOT NULL DEFAULT '',
  `demo_url` varchar(255) NOT NULL DEFAULT '',
  `adsize` varchar(100) NOT NULL DEFAULT '0',
  `memo` varchar(300) NOT NULL DEFAULT '',
  `change_apply` tinyint(1) NOT NULL DEFAULT '0',
  `check_status` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `audit` tinyint(1) NOT NULL DEFAULT '0',
  `mod_right` tinyint(1) NOT NULL DEFAULT '0',
  `week_price` decimal(8,2) NOT NULL,
  `click_price` decimal(8,2) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sysaudit_id` int(10) NOT NULL DEFAULT '0',
  `audit_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_affid_siteid` (`aff_id`,`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_affadvplace` */

/*Table structure for table `pm_affcheatpunishment` */

DROP TABLE IF EXISTS `pm_affcheatpunishment`;

CREATE TABLE `pm_affcheatpunishment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ori_num` int(10) unsigned NOT NULL DEFAULT '0',
  `ori_fee` decimal(8,2) NOT NULL,
  `deduct_num` int(10) unsigned NOT NULL DEFAULT '0',
  `deduct_fee` decimal(8,2) NOT NULL,
  `memo` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `punish_date` int(10) unsigned NOT NULL DEFAULT '0',
  `punish_id` int(10) unsigned NOT NULL DEFAULT '0',
  `punish_user` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_affcheatpunishment` */

/*Table structure for table `pm_affiliate` */

DROP TABLE IF EXISTS `pm_affiliate`;

CREATE TABLE `pm_affiliate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(30) NOT NULL DEFAULT '',
  `login_pwd` varchar(30) NOT NULL DEFAULT '',
  `biz_type` tinyint(1) NOT NULL DEFAULT '0',
  `biz_name` varchar(255) NOT NULL DEFAULT '',
  `biz_code` varchar(200) NOT NULL DEFAULT '',
  `biz_file` varchar(255) NOT NULL DEFAULT '',
  `linkman` varchar(50) NOT NULL DEFAULT '',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `telephone` varchar(20) NOT NULL DEFAULT '',
  `ext` varchar(10) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `cert_type` tinyint(1) NOT NULL DEFAULT '0',
  `cert_code` varchar(20) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `fax` varchar(15) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `province_id` int(6) NOT NULL DEFAULT '0',
  `city_id` int(6) NOT NULL DEFAULT '0',
  `pay_limit` int(10) unsigned NOT NULL DEFAULT '0',
  `tax_rate` decimal(8,2) NOT NULL,
  `pay_cycle` tinyint(1) NOT NULL DEFAULT '0',
  `commend_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sysaudit_id` int(10) unsigned NOT NULL DEFAULT '0',
  `service_id` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `point` int(10) unsigned NOT NULL DEFAULT '0',
  `total_point` int(10) unsigned NOT NULL DEFAULT '0',
  `source` tinyint(1) NOT NULL DEFAULT '0',
  `union_flag` tinyint(1) NOT NULL DEFAULT '0',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `deduct` decimal(8,2) NOT NULL DEFAULT '0.00',
  `login_srcpwd` varchar(30) NOT NULL DEFAULT '',
  `service_name` varchar(30) NOT NULL DEFAULT '',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `pm_affiliate` */

insert  into `pm_affiliate`(`id`,`login_name`,`login_pwd`,`biz_type`,`biz_name`,`biz_code`,`biz_file`,`linkman`,`gender`,`telephone`,`ext`,`mobile`,`qq`,`msn`,`email`,`cert_type`,`cert_code`,`zip`,`fax`,`address`,`province_id`,`city_id`,`pay_limit`,`tax_rate`,`pay_cycle`,`commend_id`,`sysaudit_id`,`service_id`,`audit_time`,`create_time`,`update_time`,`credit`,`point`,`total_point`,`source`,`union_flag`,`pay_type`,`status`,`is_active`,`memo`,`balance`,`total_money`,`deduct`,`login_srcpwd`,`service_name`,`is_del`) values (1,'hyzzq','085afef0e8f0c541311fd90f4f7458',0,'','','','李文琴',0,'0352-8653675','','','285786979','','hyzzq@126.com',0,'142125196906170085','','','',22,285,100,'0.00',0,0,0,7,0,0,0,100,0,0,0,0,0,2,0,'','0.00','0.00','0.00','hyzzq','admin',0),(2,'wwjob','d49627642901645e02ca2db0247956',0,'','','','杜双运',0,'','','13531828140','254808385','','anhuei007@163.com',0,'442000198505156116','','','',5,57,100,'0.00',0,0,0,7,0,1273167107,0,10,0,0,0,0,0,0,0,'','0.00','0.00','0.00','wwjob','admin',0),(3,'gaofa','e970b7b139305806fff874a8337188',0,'','','','高建忠',0,'0352-8197483','','15834247357','82736326','','gaofajianzhong@yeah.net',0,'14022719850328055X','','','',22,285,100,'0.00',0,0,0,7,0,1273167244,0,100,0,0,0,0,0,0,0,'','0.00','0.00','0.00','gaofa','admin',0),(4,'googlewz002','5531928078c4b5bb14f974eb918ff8',0,'','','','陆小锋',0,'','','13787221367','80955988','','luluyanglu@163.com',0,'430923198109290815','','','',13,143,50,'0.00',0,0,0,7,0,1273167752,0,100,0,0,0,0,0,0,0,'','0.00','0.00','0.00','googlewz002','admin',0),(5,'yingying8','3db82f9d3a6b0be2d45e026b6ce660',0,'','','','孔营',0,'0531-82360766','','13853124400','942466951','','hmilymamm@126.com',0,'370724198604062958','','','',21,397,100,'0.00',0,0,0,7,0,1273167921,0,0,0,0,0,0,0,2,0,'','0.00','0.00','0.00','yingying8','admin',0),(6,'jinyuwang7758','5a2066dfd2d5a55b50bc57d80357de',0,'','','','王冠达',0,'','','','545861874','','fangzhihuahua@126.com',0,'239005198811202511','','','',12,165,0,'0.00',0,0,4,7,0,1273764287,0,0,0,0,1,0,0,1,0,'','0.00','0.00','0.00','jinyuwang7758','admin',0),(7,'ulgu','0a5e1479ef54532afe51b01187ef64',0,'','','','黄聪',0,'','','','302732790','','yakao_o@yahoo.com.cn',0,'430923198409073214','','','',5,159,0,'0.00',0,0,4,7,0,1273764337,0,0,0,0,1,0,0,1,0,'','0.00','0.00','0.00','ulgu','admin',0),(8,'heiseyouyuy','87901ae6886a85ade9fc86fe44975f',0,'','','','尹成春',0,'','','','66866860','','heiseyouyuy@126.com',0,'142601196105231315','','','',1,145,100,'0.00',0,0,3,7,0,1273928024,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','heiseyouyuy','admin',0),(9,'392152287','d47ba3c326ed75315d2da59a11f8af',0,'','','','李唐庆',0,'','','','312123823','','zhihuilife@yeah.net',0,'522401198908010013','','','',7,390,100,'0.00',0,0,2,7,0,1273928147,1274375452,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','392152287','admin',0),(10,'wyt25','6b9685e64776acd2462dbb66b3449e',0,'','','','吴拥涛',0,'','','15920316753','931251411','','wuyongtao25@163.com',0,'441424198405052231','','','',5,159,100,'0.00',0,0,4,7,0,1273928203,0,100,0,0,1,0,0,4,0,'','0.00','0.00','0.00','wyt25','admin',0),(11,'3d986','de42fbaac9a556398192f27d98ab30',0,'','','','陈建',0,'','','','289920800','','rgjkc@126.com',0,'320682198510107475','','','',15,168,0,'0.00',0,0,7,7,1274017319,1274015260,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','3d986','admin',0),(12,'ankalau','02dddf5bfcadc6e26695cf1da7a0ff',0,'','','','刘康',0,'','','','75197800','','ankalau@163.com',0,'37232819850717331X','','','',5,406,50,'0.00',0,0,7,7,1274017319,1274015317,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','ankalau','admin',0),(13,'mmlang','7a325c6ec8edf4f3ac40708c09da99',0,'','','','刘明',0,'','','','10833189','','shuxunliuming@163.com',0,'220111197602273610','','','',14,269,50,'0.00',0,0,7,7,1274017319,1274015372,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','mmlang','admin',0),(14,'zhixin','82a3487a499be69ddacfc7af20cfa7',0,'','','','肖智信',0,'','','','80421711','','80421711@qq.com',0,'372301198707261410','','','',21,111,50,'0.00',0,0,7,7,1274017319,1274015416,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','zhixin','admin',0),(15,'caocf','f7b6d549f9af37ee9e2fd690c60ca6',0,'','','','曹传锋',0,'','','','544414641','','544414641@qq.com',0,'230604197705130618','','','',12,56,50,'0.00',0,0,7,7,1274017319,1274015461,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','caocf','admin',0),(16,'mlsmc','8f809680c2d13dd719c9e1a6c6e3de',0,'','','','刘喜军',1,'','','','523048172','','lianglin001@163.com',0,'410603811108051','','','',11,24,0,'50.00',0,0,6,7,1274016012,1274015566,1274374601,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','mlsmc','admin',0),(17,'zhifu3158','cad3428e0caa6c420ed06a0b6b5c60',0,'','','','王凯',1,'','','','815009714','','zhifu3158@163.com',0,'37142719900103311X','','','',21,170,50,'0.00',0,0,6,7,1274016012,1274015611,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','zhifu3158','admin',0),(18,'syx88','24eb47f0f3f1f67369801e06f5df73',0,'','','','杨伟',1,'','','','36003334','','ywei521@tom.com',0,'410305198312030518','','','',11,14,100,'0.00',0,0,6,7,1274016012,1274015676,0,50,0,0,1,0,0,1,0,'','0.00','0.00','0.00','syx88','admin',0),(19,'killfrom','e5aa19b799f523d8c62687e230afe5',0,'','','','梁峰',0,'','','','283992696','','qhmywllf@163.com',0,'430802196402060668','','','',31,330,100,'0.00',0,0,5,7,1274015989,1274015736,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','killfrom','admin',0),(20,'ms001','3b09236fe15cae44ad520708721294',0,'','','','黄聪',1,'','','','302732790','','yakao_o@yahoo.com.cn',0,'430923198409073214','','','',1,145,100,'0.00',0,0,5,7,1274015989,1274015794,0,100,0,0,1,0,0,1,0,'','0.00','0.00','0.00','ms001','admin',0);

/*Table structure for table `pm_affpayinfo` */

DROP TABLE IF EXISTS `pm_affpayinfo`;

CREATE TABLE `pm_affpayinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_method` varchar(200) NOT NULL DEFAULT '',
  `open_name` varchar(40) NOT NULL DEFAULT '',
  `open_address` varchar(255) NOT NULL DEFAULT '',
  `acc_type` tinyint(1) NOT NULL DEFAULT '0',
  `account` varchar(100) NOT NULL DEFAULT '',
  `acc_contract` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `aff_id` (`aff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `pm_affpayinfo` */

insert  into `pm_affpayinfo`(`id`,`aff_id`,`pay_method`,`open_name`,`open_address`,`acc_type`,`account`,`acc_contract`) values (8,8,'中国工商银行','工商银行山西省大同市浑源县支行','',0,'9558820504000194602','李文琴'),(9,2,'中国农业银行','山东省济南市农业银行商河县支行','',0,'6228480250411574610','李方超');

/*Table structure for table `pm_affwebsite` */

DROP TABLE IF EXISTS `pm_affwebsite`;

CREATE TABLE `pm_affwebsite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sitetype` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `tags` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(100) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  `ip` varchar(100) NOT NULL DEFAULT '',
  `day_pv` int(10) unsigned NOT NULL DEFAULT '0',
  `day_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `icp_code` varchar(100) NOT NULL DEFAULT '',
  `ad_used` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `enable_cpc` tinyint(1) NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `enable_roll` tinyint(1) NOT NULL DEFAULT '0',
  `sysaudit_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aid_uid` (`aff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `pm_affwebsite` */

insert  into `pm_affwebsite`(`id`,`aff_id`,`sitetype`,`name`,`url`,`tags`,`keyword`,`memo`,`ip`,`day_pv`,`day_ip`,`icp_code`,`ad_used`,`create_time`,`audit_time`,`update_time`,`enable_cpc`,`is_del`,`status`,`enable_roll`,`sysaudit_id`) values (4,1,'IT 网络','华北红客技术联盟','http://www.hongke58.com','','','','210.51.44.139',0,0,'',0,1274015039,1274017812,0,1,0,1,1,10),(2,4,'爱情交友','交友屋','http://www.jiaoyouwu.cn/','','','','',0,0,'',1,1274011358,1274017812,0,1,0,1,0,10),(3,3,'影视宽带','文杨影院','http://www.f4vod.cn','','电影','','222.186.191.118',0,0,'湘ICP备08001472',1,1274012431,1274017841,0,1,0,1,0,11),(5,19,'小说文学','智慧人生','http://www.zhihuilife.cn','','','我的智慧我选择','59.32.232.207',0,0,'',0,1274017445,1274017841,0,1,0,1,1,11),(6,20,'爱情交友','约我齐齐哈尔交友中心','http://qi.yuewo.com','','','交友','',0,0,'',0,1274017495,1274017841,0,1,0,1,1,11),(7,12,'文学艺术','起点小说','http://www.qdstory.cn','','','','',0,0,'',0,1274017922,0,0,1,0,0,1,0);

/*Table structure for table `pm_affwebsitetags` */

DROP TABLE IF EXISTS `pm_affwebsitetags`;

CREATE TABLE `pm_affwebsitetags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_affwebsitetags` */

/*Table structure for table `pm_baseadvformat` */

DROP TABLE IF EXISTS `pm_baseadvformat`;

CREATE TABLE `pm_baseadvformat` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `format` varchar(50) NOT NULL DEFAULT '',
  `memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_advformat` (`format`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `pm_baseadvformat` */

insert  into `pm_baseadvformat`(`id`,`format`,`memo`) values (4,'通栏',NULL),(3,'固定',NULL),(7,'按钮',NULL),(8,'全频道',NULL);

/*Table structure for table `pm_baseadvsize` */

DROP TABLE IF EXISTS `pm_baseadvsize`;

CREATE TABLE `pm_baseadvsize` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `width` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `height` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_advsize` (`width`,`height`)
) ENGINE=MyISAM AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

/*Data for the table `pm_baseadvsize` */

insert  into `pm_baseadvsize`(`id`,`width`,`height`,`memo`) values (120,120,120,NULL),(121,255,90,NULL),(166,240,60,'240x60'),(167,255,100,NULL),(168,250,60,NULL),(169,255,60,NULL),(119,255,255,NULL),(122,215,60,NULL),(123,225,28,NULL),(124,255,30,NULL),(171,255,80,NULL),(127,255,160,NULL),(128,255,180,NULL),(131,255,120,NULL),(132,150,170,NULL),(133,255,170,NULL),(134,180,200,NULL),(135,255,145,NULL),(137,120,255,NULL),(143,110,60,NULL),(145,90,90,NULL),(146,160,255,NULL),(147,120,100,NULL),(148,240,210,NULL),(151,100,255,NULL),(159,255,61,NULL),(170,255,70,'960x70'),(2,80,80,'80x80'),(4,200,130,'200x130 '),(5,255,249,'359x249'),(7,178,80,'178x80 '),(9,170,70,'170x70'),(10,200,60,'200x60'),(13,255,50,'350x50'),(14,255,159,'259x159'),(16,170,100,'170x100'),(17,255,155,'255x155'),(18,255,65,' 540x65 '),(160,170,255,NULL),(1,100,100,'100x100'),(28,13,14,'小型图标'),(29,40,40,'中型图标'),(30,80,250,NULL),(31,80,255,NULL),(33,90,255,NULL),(34,100,40,NULL),(35,110,255,NULL),(37,120,60,NULL),(41,130,255,NULL),(42,150,255,NULL),(43,155,255,NULL),(44,160,250,NULL),(46,168,255,NULL),(47,180,240,NULL),(48,180,245,NULL),(49,180,255,NULL),(50,200,200,NULL),(51,200,255,NULL),(52,215,255,NULL),(53,250,220,NULL),(54,255,200,NULL),(157,180,100,NULL),(57,255,85,NULL),(58,255,22,NULL),(158,133,255,NULL),(62,255,192,NULL),(64,255,75,NULL),(72,255,123,NULL),(73,255,250,NULL),(86,255,138,NULL),(98,154,255,NULL),(101,178,255,NULL),(103,200,162,NULL),(104,200,180,NULL),(105,200,222,NULL),(107,210,150,NULL),(108,220,255,NULL),(109,230,140,NULL),(110,250,80,NULL),(111,250,140,NULL),(112,255,150,NULL),(118,255,190,NULL),(165,176,208,NULL);

/*Table structure for table `pm_baseagentip` */

DROP TABLE IF EXISTS `pm_baseagentip`;

CREATE TABLE `pm_baseagentip` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_agentip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_baseagentip` */

/*Table structure for table `pm_basearea` */

DROP TABLE IF EXISTS `pm_basearea`;

CREATE TABLE `pm_basearea` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_area` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `pm_basearea` */

insert  into `pm_basearea`(`id`,`name`,`is_del`) values (2,'华南地区',0),(3,'华北地区',0),(4,'西南地区',0),(5,'华东地区',0),(6,'华中地区',0),(7,'东北地区',0),(8,'东南地区',0),(9,'西北地区',0);

/*Table structure for table `pm_basecity` */

DROP TABLE IF EXISTS `pm_basecity`;

CREATE TABLE `pm_basecity` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `zip` varchar(20) DEFAULT '',
  `code` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`zip`),
  KEY `idx_province_id` (`province_id`)
) ENGINE=MyISAM AUTO_INCREMENT=415 DEFAULT CHARSET=utf8;

/*Data for the table `pm_basecity` */

insert  into `pm_basecity`(`id`,`province_id`,`name`,`zip`,`code`) values (331,12,'大兴安岭',NULL,'457'),(332,20,'海东',NULL,'972'),(333,9,'武汉',NULL,'27'),(334,27,'拉萨',NULL,'891'),(335,4,'平凉',NULL,'933'),(336,6,'柳州',NULL,'772'),(337,24,'南充',NULL,'817'),(338,16,'九江',NULL,'792'),(339,9,'鄂州',NULL,'711'),(340,13,'湘潭',NULL,'732'),(341,24,'广安',NULL,'826'),(342,28,'库尔勒',NULL,'996'),(343,16,'赣州',NULL,'797'),(344,28,'克拉玛依',NULL,'990'),(345,5,'佛山',NULL,'757'),(346,23,'西安',NULL,'29'),(347,6,'百色',NULL,'776'),(348,18,'海拉尔',NULL,'470'),(349,11,'新乡',NULL,'373'),(350,28,'博尔塔拉',NULL,'909'),(351,24,'广元',NULL,'839'),(352,15,'苏州',NULL,'512'),(353,25,'安庆',NULL,'556'),(354,11,'漯河',NULL,'395'),(355,14,'珲春',NULL,'440'),(356,4,'金昌',NULL,'935'),(357,28,'阿克苏',NULL,'997'),(358,28,'吐鲁番',NULL,'995'),(359,22,'晋中',NULL,'354'),(360,13,'郴州',NULL,'735'),(361,12,'黑河',NULL,'456'),(362,9,'宜昌',NULL,'717'),(363,24,'泸州',NULL,'830'),(364,23,'榆林',NULL,'912'),(365,16,'萍乡',NULL,'799'),(366,9,'黄石',NULL,'714'),(367,11,'信阳',NULL,'376'),(368,7,'黔南州',NULL,'854'),(369,11,'安阳',NULL,'372'),(370,24,'成都',NULL,'28'),(371,30,'舟山',NULL,'580'),(372,20,'西宁',NULL,'971'),(373,18,'锡林浩特',NULL,'479'),(374,10,'邢台',NULL,'319'),(375,12,'绥化',NULL,'458'),(376,20,'黄南州',NULL,'973'),(377,22,'阳泉',NULL,'353'),(378,22,'运城',NULL,'359'),(379,24,'宜宾',NULL,'831'),(380,5,'茂名',NULL,'668'),(381,9,'襄樊',NULL,'710'),(382,18,'阿盟',NULL,'483'),(384,15,'镇江',NULL,'511'),(385,29,'玉溪',NULL,'877'),(386,13,'株洲',NULL,'733'),(387,19,'石嘴山',NULL,'952'),(388,30,'台州',NULL,'576'),(389,22,'长治',NULL,'355'),(390,7,'毕节',NULL,'857'),(391,4,'酒泉',NULL,'937'),(392,23,'汉中',NULL,'916'),(393,15,'盐城',NULL,'515'),(394,6,'钦州',NULL,'777'),(395,20,'玉树州',NULL,'976'),(396,18,'通辽',NULL,'475'),(397,21,'济南',NULL,'531'),(398,18,'乌兰查布盟',NULL,'474'),(399,24,'阿坝',NULL,'837'),(400,5,'河源',NULL,'762'),(401,4,'张掖',NULL,'936'),(1,15,'张家港',NULL,'512'),(2,9,'神农架',NULL,'719'),(3,29,'迪庆',NULL,'887'),(4,24,'达州',NULL,'818'),(5,17,'锦州',NULL,'416'),(6,12,'七台河',NULL,'464'),(7,10,'秦皇岛',NULL,'335'),(8,11,'平顶山',NULL,'375'),(9,29,'红河',NULL,'873'),(10,11,'潢川',NULL,'397'),(11,28,'博乐',NULL,'909'),(13,22,'朔州',NULL,'349'),(14,11,'洛阳',NULL,'379'),(15,21,'潍坊',NULL,'536'),(16,14,'通化',NULL,'435'),(17,21,'聊城',NULL,'635'),(18,3,'莆田','351100','594'),(19,15,'丹阳',NULL,'511'),(20,14,'四平',NULL,'434'),(21,24,'甘孜',NULL,'836'),(22,30,'绍兴',NULL,'575'),(23,6,'贺州',NULL,'774'),(24,11,'鹤壁',NULL,'392'),(25,3,'南平','353000','599'),(26,25,'淮南',NULL,'554'),(27,10,'石家庄',NULL,'311'),(28,15,'溧阳',NULL,'519'),(29,17,'鞍山',NULL,'412'),(30,5,'云浮',NULL,'766'),(31,25,'滁州',NULL,'550'),(32,28,'克州',NULL,'908'),(33,22,'吕梁',NULL,'358'),(34,5,'揭阳',NULL,'663'),(35,13,'岳阳',NULL,'730'),(36,6,'梧州',NULL,'774'),(37,6,'桂林',NULL,'773'),(38,25,'宣城',NULL,'563'),(39,7,'黔东南州',NULL,'855'),(40,7,'兴义',NULL,'859'),(41,25,'毫州',NULL,'558'),(42,27,'那曲',NULL,'896'),(43,29,'思茅',NULL,'879'),(44,17,'阜新',NULL,'418'),(45,30,'衢州',NULL,'570'),(46,30,'宁波',NULL,'574'),(47,20,'海西州',NULL,'977'),(48,25,'宣州',NULL,'563'),(49,22,'晋城',NULL,'356'),(50,13,'张家界',NULL,'744'),(51,27,'昌都',NULL,'895'),(52,28,'塔城',NULL,'901'),(53,11,'三门峡',NULL,'398'),(54,20,'格尔木',NULL,'979'),(55,5,'清远',NULL,'763'),(56,12,'大庆',NULL,'459'),(57,5,'中山',NULL,'760'),(58,6,'来宾',NULL,'772'),(59,23,'铜川',NULL,'919'),(60,13,'怀化',NULL,'745'),(61,12,'丹东',NULL,'457'),(62,21,'莱芜',NULL,'634'),(63,7,'六盘水',NULL,'858'),(64,3,'泉州',NULL,'595'),(65,12,'双鸭山',NULL,'469'),(66,30,'丽水',NULL,'578'),(67,24,'巴中',NULL,'827'),(68,10,'承德',NULL,'314'),(69,29,'临沧',NULL,'883'),(70,16,'景德镇',NULL,'798'),(71,5,'珠海',NULL,'756'),(72,21,'青岛',NULL,'532'),(73,4,'陇南',NULL,'939'),(74,2,'上海','201100','21'),(75,27,'日喀则',NULL,'892'),(76,4,'天水',NULL,'938'),(77,25,'阜阳',NULL,'558'),(78,13,'邵阳',NULL,'739'),(79,17,'营口',NULL,'417'),(80,24,'马尔康',NULL,'837'),(81,3,'福州',NULL,'591'),(82,9,'十堰',NULL,'719'),(83,18,'东胜',NULL,'477'),(84,28,'伊犁',NULL,'999'),(85,18,'呼盟',NULL,'470'),(86,5,'江门',NULL,'750'),(87,25,'淮北',NULL,'561'),(88,28,'哈密',NULL,'902'),(89,25,'亳州',NULL,'558'),(90,24,'遂宁',NULL,'825'),(91,24,'资阳',NULL,'832'),(92,4,'白银',NULL,'943'),(93,24,'德阳',NULL,'838'),(94,13,'株州',NULL,'733'),(95,17,'朝阳',NULL,'421'),(96,5,'潮阳',NULL,'661'),(97,19,'中卫',NULL,'955'),(98,24,'自贡',NULL,'813'),(99,16,'上饶',NULL,'793'),(100,7,'凯里',NULL,'855'),(101,6,'河池',NULL,'778'),(102,5,'从化',NULL,'20'),(103,20,'海东地区',NULL,'972'),(104,10,'廊坊',NULL,'316'),(105,5,'东莞',NULL,'769'),(106,9,'孝感',NULL,'712'),(107,15,'连云港',NULL,'518'),(108,18,'阿拉善盟',NULL,'483'),(109,20,'共和',NULL,'974'),(110,4,'甘南州',NULL,'941'),(111,21,'滨州',NULL,'543'),(112,24,'乐山',NULL,'833'),(113,10,'衡水',NULL,'318'),(114,26,'天津',NULL,'22'),(115,25,'合肥',NULL,'551'),(116,28,'和田',NULL,'903'),(117,18,'乌兰浩特',NULL,'482'),(118,31,'黔江',NULL,'23'),(119,21,'济宁',NULL,'537'),(120,25,'巢湖',NULL,'565'),(121,23,'安康',NULL,'915'),(122,23,'渭南',NULL,'913'),(123,25,'宿州',NULL,'557'),(124,14,'梅河口',NULL,'448'),(125,13,'吉首',NULL,'743'),(126,19,'银川',NULL,'951'),(127,7,'都匀',NULL,'854'),(128,5,'潮州',NULL,'768'),(129,17,'铁岭',NULL,'410'),(130,25,'马鞍山',NULL,'555'),(131,15,'太仓',NULL,'512'),(132,5,'汕头',NULL,'754'),(133,4,'嘉峪关',NULL,'937'),(134,17,'葫芦岛',NULL,'429'),(135,20,'果洛州',NULL,'975'),(136,5,'阳江',NULL,'662'),(137,6,'南宁',NULL,'771'),(138,9,'天门',NULL,'728'),(139,5,'梅州',NULL,'753'),(140,15,'句容',NULL,'511'),(141,18,'鄂尔多斯',NULL,'477'),(142,7,'贵阳',NULL,'851'),(143,13,'长沙',NULL,'731'),(144,9,'江汉',NULL,'728'),(145,1,'北京','100000','10'),(146,6,'北海',NULL,'779'),(147,15,'启东',NULL,'513'),(148,29,'昆明',NULL,'871'),(149,14,'吉林',NULL,'432'),(150,9,'咸宁',NULL,'715'),(151,3,'漳州',NULL,'596'),(152,15,'昆山',NULL,'512'),(153,18,'锡盟',NULL,'479'),(154,29,'版纳',NULL,'691'),(155,5,'湛江',NULL,'759'),(156,18,'赤峰',NULL,'476'),(157,6,'贵港',NULL,'775'),(158,25,'铜陵',NULL,'562'),(159,5,'广州',NULL,'20'),(160,4,'临夏',NULL,'930'),(161,21,'威海',NULL,'631'),(162,17,'盘锦',NULL,'427'),(163,14,'白山',NULL,'439'),(164,25,'芜湖',NULL,'553'),(165,12,'哈尔滨',NULL,'451'),(166,30,'金华',NULL,'579'),(167,15,'金坛',NULL,'519'),(168,15,'南通',NULL,'513'),(169,28,'阿勒泰',NULL,'906'),(170,21,'德州',NULL,'534'),(171,16,'南昌',NULL,'791'),(172,15,'淮安',NULL,'517'),(173,5,'肇庆',NULL,'758'),(174,11,'焦作',NULL,'391'),(175,4,'庆阳',NULL,'934'),(176,3,'宁德',NULL,'593'),(177,30,'湖州',NULL,'572'),(178,20,'海北州',NULL,'970'),(179,24,'西昌',NULL,'834'),(180,15,'常熟',NULL,'512'),(181,3,'厦门',NULL,'592'),(182,16,'鹰潭',NULL,'701'),(183,11,'商丘',NULL,'370'),(184,12,'齐齐哈尔',NULL,'452'),(185,12,'伊春',NULL,'458'),(186,15,'淮阴',NULL,'517'),(187,15,'宜兴',NULL,'510'),(188,11,'郑州',NULL,'371'),(189,9,'恩施',NULL,'718'),(190,4,'武威',NULL,'935'),(191,30,'温州',NULL,'577'),(192,5,'三水',NULL,'757'),(193,5,'汕尾',NULL,'660'),(194,7,'安顺',NULL,'853'),(195,29,'德宏',NULL,'692'),(196,24,'绵阳',NULL,'816'),(197,6,'玉林',NULL,'775'),(198,15,'扬州',NULL,'514'),(199,15,'无锡',NULL,'510'),(200,18,'乌海',NULL,'473'),(201,11,'南阳',NULL,'377'),(202,11,'濮阳',NULL,'393'),(203,23,'宝鸡',NULL,'917'),(204,3,'龙岩',NULL,'597'),(205,21,'东营',NULL,'546'),(206,22,'太原',NULL,'351'),(207,17,'辽阳',NULL,'419'),(208,10,'沧州',NULL,'317'),(209,13,'湘西',NULL,'743'),(210,21,'日照',NULL,'633'),(211,28,'昌吉',NULL,'994'),(212,12,'牡丹江',NULL,'453'),(213,24,'眉山',NULL,'833'),(214,12,'佳木斯',NULL,'454'),(215,27,'林芝',NULL,'894'),(216,5,'高明',NULL,'757'),(217,10,'保定',NULL,'312'),(218,5,'增城',NULL,'20'),(219,20,'海南州',NULL,'974'),(220,20,'海南',NULL,'974'),(221,21,'烟台',NULL,'535'),(222,29,'丽江',NULL,'888'),(223,27,'阿里',NULL,'897'),(224,29,'文山',NULL,'876'),(225,28,'奎屯',NULL,'992'),(226,21,'淄博',NULL,'533'),(227,29,'曲靖',NULL,'874'),(228,21,'枣庄',NULL,'632'),(229,5,'惠州',NULL,'752'),(230,24,'攀枝花',NULL,'812'),(231,27,'山南',NULL,'893'),(232,17,'丹东',NULL,'415'),(233,16,'宜春',NULL,'795'),(234,28,'乌鲁木齐',NULL,'991'),(235,18,'临河',NULL,'478'),(236,10,'邯郸',NULL,'310'),(237,10,'唐山',NULL,'315'),(238,18,'锡林郭勒盟',NULL,'479'),(239,20,'格尔木市',NULL,'979'),(240,24,'雅安',NULL,'835'),(241,14,'延边',NULL,'433'),(242,18,'乌兰察布盟',NULL,'474'),(243,14,'延吉',NULL,'433'),(244,15,'泰州',NULL,'523'),(245,14,'辽源',NULL,'437'),(246,29,'大理',NULL,'872'),(247,15,'江阴',NULL,'510'),(248,21,'菏泽',NULL,'530'),(249,20,'玉树',NULL,'976'),(250,13,'永州',NULL,'746'),(251,5,'顺德',NULL,'765'),(252,20,'果洛',NULL,'975'),(253,4,'定西',NULL,'932'),(254,10,'张家口',NULL,'313'),(255,22,'临汾',NULL,'357'),(256,30,'杭州',NULL,'571'),(257,18,'伊克昭盟',NULL,'477'),(258,18,'集宁',NULL,'474'),(259,24,'康定',NULL,'836'),(260,22,'忻州',NULL,'350'),(261,29,'昭通',NULL,'870'),(262,9,'荆门',NULL,'724'),(263,16,'吉安',NULL,'796'),(264,11,'驻马店',NULL,'396'),(265,25,'池州',NULL,'566'),(266,15,'常州',NULL,'519'),(267,25,'六安',NULL,'564'),(268,9,'荆州',NULL,'716'),(269,14,'长春',NULL,'431'),(270,31,'万县',NULL,'23'),(271,9,'仙桃',NULL,'728'),(272,31,'涪陵',NULL,'23'),(273,18,'包头',NULL,'472'),(274,20,'黄南',NULL,'973'),(275,28,'克孜勒苏柯尔克孜',NULL,'908'),(276,21,'泰安',NULL,'538'),(277,13,'衡阳',NULL,'734'),(278,17,'抚顺',NULL,'413'),(279,25,'黄山',NULL,'559'),(280,24,'凉山',NULL,'834'),(281,23,'咸阳',NULL,'910'),(282,9,'潜江',NULL,'728'),(283,12,'鹤岗',NULL,'468'),(284,8,'海口',NULL,'898'),(285,22,'大同',NULL,'352'),(286,14,'白城',NULL,'436'),(287,16,'新余',NULL,'790'),(288,23,'商洛',NULL,'914'),(289,5,'花都',NULL,'20'),(290,29,'楚雄',NULL,'878'),(291,15,'南京',NULL,'25'),(292,11,'许昌',NULL,'374'),(293,15,'宿迁',NULL,'527'),(294,12,'鸡西',NULL,'467'),(295,18,'呼和浩特',NULL,'471'),(296,17,'大连',NULL,'411'),(297,28,'伊犁哈萨克',NULL,'992'),(298,28,'喀什',NULL,'998'),(299,29,'保山',NULL,'875'),(300,5,'韶关',NULL,'751'),(301,17,'本溪',NULL,'414'),(302,13,'常德',NULL,'736'),(303,17,'沈阳',NULL,'24'),(304,18,'呼伦贝尔',NULL,'470'),(305,14,'松原',NULL,'438'),(306,28,'石河子',NULL,'993'),(307,19,'固原',NULL,'954'),(308,30,'嘉兴',NULL,'573'),(309,11,'周口',NULL,'394'),(310,29,'怒江',NULL,'886'),(311,4,'兰州',NULL,'931'),(402,31,'万州',NULL,'23'),(404,19,'吴忠',NULL,'953'),(405,25,'蚌埠',NULL,'552'),(406,5,'深圳',NULL,'755'),(407,18,'兴安盟',NULL,'482'),(408,13,'娄底',NULL,'738'),(409,18,'巴彦淖尔盟',NULL,'478'),(410,7,'铜仁',NULL,'856'),(411,16,'抚州',NULL,'794'),(412,9,'黄冈',NULL,'713'),(413,13,'益阳',NULL,'737'),(414,15,'徐州',NULL,'516'),(312,15,'吴江',NULL,'512'),(403,28,'巴音郭楞',NULL,'996'),(313,23,'延安',NULL,'911'),(314,18,'巴彦卓尔盟',NULL,'478'),(315,21,'临沂',NULL,'539'),(316,7,'黔西南州',NULL,'859'),(317,12,'绥化',NULL,'455'),(318,5,'南海',NULL,'757'),(319,6,'防城港',NULL,'770'),(320,3,'三明',NULL,'598'),(321,5,'番禺',NULL,'20'),(322,20,'海西',NULL,'977'),(323,15,'通州',NULL,'513'),(324,20,'海晏',NULL,'970'),(325,24,'内江',NULL,'832'),(326,20,'德令哈',NULL,'977'),(327,9,'随州',NULL,'722'),(328,11,'开封',NULL,'378'),(329,7,'遵义',NULL,'852'),(330,31,'重庆',NULL,'23');

/*Table structure for table `pm_baseip` */

DROP TABLE IF EXISTS `pm_baseip`;

CREATE TABLE `pm_baseip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_ip` varchar(20) NOT NULL DEFAULT '',
  `end_ip` varchar(20) NOT NULL DEFAULT '',
  `province` varchar(30) NOT NULL DEFAULT '',
  `city` varchar(30) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_ip` (`start_ip`,`end_ip`,`zip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_baseip` */

/*Table structure for table `pm_baseprovince` */

DROP TABLE IF EXISTS `pm_baseprovince`;

CREATE TABLE `pm_baseprovince` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_province` (`name`),
  KEY `idx_area_id` (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `pm_baseprovince` */

insert  into `pm_baseprovince`(`id`,`area_id`,`name`,`is_del`) values (1,3,'北京',0),(2,5,'上海',0),(3,2,'福建',0),(4,9,'甘肃',0),(5,2,'广东',0),(6,2,'广西',0),(7,4,'贵州',0),(8,8,'海南',0),(9,6,'湖北',0),(10,3,'河北',0),(11,6,'河南',0),(12,7,'黑龙江',0),(13,2,'湖南',0),(14,7,'吉林',0),(15,5,'江苏',0),(16,2,'江西',0),(17,7,'辽宁',0),(18,9,'内蒙古',0),(19,8,'宁夏',0),(20,7,'青海',0),(21,5,'山东',0),(22,3,'山西',0),(23,4,'陕西',0),(24,4,'四川',0),(25,5,'安徽',0),(26,3,'天津',0),(27,9,'西藏',0),(28,9,'新疆',0),(29,4,'云南',0),(30,5,'浙江',0),(31,4,'重庆',0);

/*Table structure for table `pm_basesort` */

DROP TABLE IF EXISTS `pm_basesort`;

CREATE TABLE `pm_basesort` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ikey` enum('channeltype','clientphase','clientsource','companyscale','duty','sitetype','trade','unit','bank','clientlevel','advtype','helpmodule') NOT NULL DEFAULT 'channeltype',
  `val` varchar(100) NOT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_keyval` (`ikey`,`val`)
) ENGINE=MyISAM AUTO_INCREMENT=920 DEFAULT CHARSET=utf8;

/*Data for the table `pm_basesort` */

insert  into `pm_basesort`(`id`,`ikey`,`val`,`is_del`) values (6,'advtype','旅游服务',0),(7,'advtype','在线招聘',0),(8,'advtype','会员资讯',0),(9,'advtype','搜索引擎',0),(20,'advtype','购物门户/百货',0),(11,'advtype','服装/饰品',0),(22,'advtype','化妆品/美容/美体',0),(13,'advtype','健康医疗',0),(14,'advtype','教育培训',0),(15,'advtype','证券财经',0),(16,'advtype','图书/期刊/电子刊物',0),(17,'advtype','IT/网络',0),(18,'advtype','礼品鲜花',0),(19,'advtype','汽车/汽车用品',0),(101,'advtype','收费邮箱',0),(102,'advtype','即时通信',0),(103,'advtype','下载服务',0),(108,'advtype','宽带影院',0),(105,'advtype','在线音乐',0),(106,'advtype','其他网络服务',0),(212,'bank','中国工商银行',0),(211,'bank','中国建设银行',0),(216,'bank','支付宝',0),(213,'bank','中国招商银行',0),(214,'bank','中国农业银行',0),(215,'bank','中国银行',0),(301,'channeltype','美女',0),(302,'channeltype','音乐',0),(303,'channeltype','游戏',0),(304,'channeltype','小说',0),(305,'channeltype','图片',0),(306,'channeltype','电影',0),(307,'channeltype','动漫',0),(308,'channeltype','幽默笑话',0),(309,'channeltype','FLASH',0),(310,'channeltype','论坛',0),(311,'channeltype','旅游',0),(312,'channeltype','时尚',0),(313,'channeltype','桌面',0),(314,'channeltype','体育',0),(315,'channeltype','星座',0),(316,'channeltype','交友',0),(317,'channeltype','聊天',0),(318,'channeltype','BT下载',0),(319,'channeltype','两性',0),(320,'channeltype','人体',0),(321,'channeltype','艺术',0),(322,'channeltype','黑客',0),(323,'channeltype','硬件',0),(324,'channeltype','邮箱',0),(325,'channeltype','软件下载',0),(326,'channeltype','杀毒',0),(327,'channeltype','教程',0),(328,'channeltype','编程',0),(329,'channeltype','QQ 工具',0),(330,'channeltype','军事',0),(331,'channeltype','主页',0),(332,'channeltype','新闻',0),(333,'channeltype','百强网站',0),(334,'channeltype','搜索引擎',0),(335,'channeltype','医疗',0),(336,'channeltype','健康',0),(337,'channeltype','儿童',0),(338,'channeltype','手机',0),(339,'channeltype','美食',0),(340,'channeltype','汽车',0),(341,'channeltype','证券',0),(342,'channeltype','房产',0),(343,'channeltype','彩票',0),(344,'channeltype','减肥',0),(345,'channeltype','婚恋',0),(347,'channeltype','宠物',0),(348,'channeltype','交通',0),(349,'channeltype','银行',0),(350,'channeltype','购物',0),(351,'channeltype','省市',0),(352,'channeltype','政府',0),(353,'channeltype','贺卡',0),(354,'channeltype','美容',0),(355,'channeltype','实用查询',0),(356,'channeltype','摄影',0),(358,'channeltype','书法',0),(359,'channeltype','美术',0),(360,'channeltype','设计',0),(361,'channeltype','心理',0),(362,'channeltype','哲学',0),(363,'channeltype','历史',0),(364,'channeltype','地理',0),(365,'channeltype','生物',0),(366,'channeltype','社会',0),(367,'channeltype','环保',0),(368,'channeltype','经济',0),(369,'channeltype','法律',0),(370,'channeltype','科普',0),(371,'channeltype','考研',0),(372,'channeltype','英语',0),(373,'channeltype','考试',0),(374,'channeltype','大学',0),(375,'channeltype','论文',0),(376,'channeltype','校园',0),(377,'channeltype','教师',0),(378,'channeltype','招聘求职',0),(401,'trade','互联网',0),(402,'trade','互联网·电子商务',0),(404,'trade','广告·会展·公关',0),(405,'trade','房地产开发·建筑与工程',0),(406,'trade','物业管理·商业中心',0),(407,'trade','家居·室内设计·装潢',0),(408,'trade','中介服务(人才·商标专利)',0),(409,'trade','专业服务(咨询·财会·法律等) ',0),(411,'trade','贸易·进出口',0),(412,'trade','媒体·出版·文化传播',0),(413,'trade','印刷·包装·造纸',0),(415,'trade','耐用消费品(服饰·纺织·家具）',0),(416,'trade','家电业 办公设备·用品',0),(417,'trade','旅游·酒店·餐饮服务',0),(418,'trade','批发·零售',0),(419,'trade','交通·运输·物流',0),(420,'trade','娱乐·运动·休闲',0),(421,'trade','制药·生物工程',0),(422,'trade','医疗·保健·美容·卫生服务',0),(423,'trade','医疗设备·器械',0),(424,'trade','环保',0),(425,'trade','石油·化工·采掘·冶炼·原材料',0),(426,'trade','能源（电力·石油）·水利',0),(427,'trade','仪器·仪表·工业自动化·电气',0),(429,'trade','机械制造·机电·重工',0),(431,'trade','服务业',0),(432,'trade','农·林·牧·渔',0),(433,'trade','航空·航天研究与制造',0),(434,'trade','教育·培训·科研·院校',0),(435,'trade','政府·非营利机构',0),(437,'trade','其他',0),(502,'clientsource','销售拓展',0),(503,'clientsource','朋友介绍',0),(504,'clientsource','邮件群发',0),(501,'clientsource','其它联盟',0),(601,'clientphase','开始阶段',0),(602,'clientphase','商谈阶段',0),(603,'clientphase','运营阶段',0),(701,'companyscale','1-49人',0),(702,'companyscale','50-99人',0),(703,'companyscale','100-499人',0),(704,'companyscale','500-999人',0),(705,'companyscale','1000人以上',0),(801,'sitetype','综合门户',0),(802,'sitetype','网上购物',0),(803,'sitetype','汽车交通',0),(804,'sitetype','生活服务',0),(805,'sitetype','两性空间',0),(806,'sitetype','医疗保健',0),(807,'sitetype','贸易商业',0),(808,'sitetype','教育考试',0),(809,'sitetype','文学艺术',0),(810,'sitetype','软件下载',0),(811,'sitetype','金融证券',0),(812,'sitetype','幽默笑话',0),(813,'sitetype','动漫flash',0),(814,'sitetype','星相命理',0),(815,'sitetype','税务保险',0),(816,'sitetype','幼儿/儿童',0),(817,'sitetype','娱乐八卦',0),(818,'sitetype','明星美女',0),(819,'sitetype','房产租房',0),(820,'sitetype','游戏网站',0),(821,'sitetype','彩票信息',0),(822,'sitetype','旅游风光',0),(823,'sitetype','影视宽带',0),(824,'sitetype','体育运动',0),(825,'sitetype','IT 网络',0),(826,'sitetype','爱情交友',0),(827,'sitetype','图片写真',0),(828,'sitetype','广告营销',0),(829,'sitetype','新闻媒体',0),(830,'sitetype','会展商务',0),(831,'sitetype','论坛社区',0),(832,'sitetype','人才招聘',0),(833,'sitetype','网址大全',0),(834,'sitetype','音乐MP3',0),(835,'sitetype','社科文化',0),(836,'sitetype','时尚美容',0),(837,'sitetype','两性生活',0),(838,'sitetype','房产家居',0),(839,'sitetype','贺卡宠物',0),(840,'sitetype','旅游资讯',0),(841,'sitetype','美食天地',0),(842,'sitetype','汽车资讯',0),(843,'sitetype','少年儿童',0),(844,'sitetype','天气气象',0),(845,'sitetype','手机通信',0),(846,'sitetype','编程设计',0),(848,'sitetype','黑客安全',0),(849,'sitetype','电脑网络',0),(850,'sitetype','网页制作',0),(851,'sitetype','硬件资讯',0),(852,'sitetype','留学移民',0),(853,'sitetype','论文写作',0),(854,'sitetype','外语学习',0),(856,'sitetype','电视电台',0),(857,'sitetype','法律站点',0),(858,'sitetype','国防军事',0),(860,'sitetype','小说文学',0),(861,'sitetype','艺术爱好',0),(862,'sitetype','交通地图',0),(865,'sitetype','企业黄页',0),(866,'sitetype','其他类别',0),(902,'unit','元/分钟',0),(903,'unit','元/条',0),(904,'unit','元/用户',0),(905,'unit','元/个',0),(906,'unit','%/订单',0),(901,'unit','元/KIP',0),(907,'bank','北京银行',0),(908,'bank','浦东发展银行',0),(909,'bank','光大银行',0),(910,'bank','中国民生银行',0),(911,'bank','花旗银行',0),(913,'helpmodule','网赚技巧',0),(914,'helpmodule','帐户管理',0),(915,'helpmodule','广告代码',0),(916,'helpmodule','统计分析',0),(917,'helpmodule','结算中心',0),(918,'helpmodule','新手上路',0),(919,'unit','元/天',0);

/*Table structure for table `pm_merappendicons` */

DROP TABLE IF EXISTS `pm_merappendicons`;

CREATE TABLE `pm_merappendicons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `icon_type` tinyint(1) NOT NULL DEFAULT '0',
  `icon_path` varchar(200) NOT NULL DEFAULT '',
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_merappendicons` */

/*Table structure for table `pm_merchance` */

DROP TABLE IF EXISTS `pm_merchance`;

CREATE TABLE `pm_merchance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chance_no` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `require_type` tinyint(1) NOT NULL DEFAULT '0',
  `clientsource` varchar(100) NOT NULL DEFAULT '',
  `phase` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `est_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sign_date` varchar(20) NOT NULL DEFAULT '',
  `seller_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `seller_name` varchar(50) NOT NULL DEFAULT '',
  `creator_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `creator_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_seller_id` (`seller_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `pm_merchance` */

insert  into `pm_merchance`(`id`,`chance_no`,`title`,`nickname`,`require_type`,`clientsource`,`phase`,`status`,`est_money`,`sign_date`,`seller_id`,`seller_name`,`creator_id`,`creator_name`,`create_time`) values (1,'AAYY003-11','盛行网络推广机会','盛行网络',1,'其它联盟','运营阶段',80,'1000.00','2010-5-28',0,'',7,'admin',0),(2,'','盛行网站酷派亮衣品牌推广','',0,'','',0,'0.00','2010-5-20',0,'',0,'',0);

/*Table structure for table `pm_merchant` */

DROP TABLE IF EXISTS `pm_merchant`;

CREATE TABLE `pm_merchant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) NOT NULL DEFAULT '',
  `login_pwd` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(200) NOT NULL DEFAULT '',
  `scale` varchar(50) NOT NULL DEFAULT '0',
  `short_name` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `biz_code` varchar(200) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `ticket_title` varchar(500) NOT NULL DEFAULT '',
  `province_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `city_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `address` varchar(100) NOT NULL DEFAULT '',
  `zip` varchar(20) NOT NULL DEFAULT '',
  `trade` varchar(100) NOT NULL DEFAULT '',
  `client_source` varchar(100) NOT NULL DEFAULT '',
  `seller_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `seller_name` varchar(50) NOT NULL DEFAULT '',
  `phase` varchar(100) NOT NULL DEFAULT '0',
  `client_type` varchar(100) NOT NULL DEFAULT '',
  `client_level` varchar(100) NOT NULL DEFAULT '',
  `credit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `init_store` decimal(8,2) NOT NULL DEFAULT '0.00',
  `current_store` decimal(8,2) NOT NULL DEFAULT '0.00',
  `deposit` decimal(8,2) NOT NULL DEFAULT '0.00',
  `over_draft` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sysaudit_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_sid_sid` (`seller_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `pm_merchant` */

insert  into `pm_merchant`(`id`,`login_name`,`login_pwd`,`company`,`scale`,`short_name`,`logo`,`biz_code`,`url`,`ticket_title`,`province_id`,`city_id`,`address`,`zip`,`trade`,`client_source`,`seller_id`,`seller_name`,`phase`,`client_type`,`client_level`,`credit`,`status`,`create_time`,`audit_time`,`memo`,`init_store`,`current_store`,`deposit`,`over_draft`,`sysaudit_id`) values (1,'haiyan','','广州海岩网络科技有限公司','1-49人','海岩网络','','','www.haiyan.com','广州海岩网络科技有限公司',5,255,'','','物业管理·商业中心','其它联盟',0,'','运营阶段','1','',100,1,1273404764,0,'','0.00','0.00','0.00','0.00',0),(2,'shenxin','','盛行网络','1-49人','盛行网络','','','http://www.urlad.cn/a/testkw5.html','盛行网络',5,159,'','','互联网','0',0,'','商谈阶段','1','',100,1,1273407025,0,'','0.00','0.00','0.00','0.00',0);

/*Table structure for table `pm_mercontract` */

DROP TABLE IF EXISTS `pm_mercontract`;

CREATE TABLE `pm_mercontract` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contract_no` varchar(50) NOT NULL DEFAULT '',
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `paytype` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itype` tinyint(1) NOT NULL DEFAULT '0',
  `chance_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  `fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sign_date` varchar(20) NOT NULL DEFAULT '',
  `file_path` varchar(200) NOT NULL DEFAULT '',
  `start_date` varchar(20) NOT NULL DEFAULT '',
  `end_date` varchar(20) NOT NULL DEFAULT '',
  `seller_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `seller_name` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `creator_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `creator_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `pm_mercontract` */

insert  into `pm_mercontract`(`id`,`contract_no`,`mer_id`,`paytype`,`itype`,`chance_id`,`title`,`memo`,`fee`,`sign_date`,`file_path`,`start_date`,`end_date`,`seller_id`,`seller_name`,`status`,`creator_id`,`creator_name`,`create_time`) values (5,'',2,4,0,2,'盛行网站酷派亮衣品牌推广','','100.00','2010-6-1','','2010-6-17','2011-6-17',0,'',1,0,'',0),(6,'',2,1,0,1,'盛行网站酷派黑裤品牌推广','','100.00','2010-5-6','','2010-5-28','2011-5-20',0,'',0,0,'',0);

/*Table structure for table `pm_merdeposit` */

DROP TABLE IF EXISTS `pm_merdeposit`;

CREATE TABLE `pm_merdeposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `use_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `current_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `use_type` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_merdeposit` */

/*Table structure for table `pm_merlinkman` */

DROP TABLE IF EXISTS `pm_merlinkman`;

CREATE TABLE `pm_merlinkman` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `idcard_no` varchar(30) NOT NULL DEFAULT '',
  `idcard_path` varchar(200) NOT NULL DEFAULT '',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `department` varchar(50) NOT NULL DEFAULT '',
  `duty` varchar(50) NOT NULL DEFAULT '',
  `function` varchar(100) NOT NULL DEFAULT '',
  `work_tel` varchar(50) NOT NULL DEFAULT '',
  `ext` varchar(20) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(50) NOT NULL DEFAULT '',
  `family_tel` varchar(30) NOT NULL DEFAULT '',
  `family_address` varchar(100) NOT NULL DEFAULT '',
  `birthday` date NOT NULL,
  `favorite` varchar(200) NOT NULL DEFAULT '',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_merlinkman` */

/*Table structure for table `pm_merpayrec` */

DROP TABLE IF EXISTS `pm_merpayrec`;

CREATE TABLE `pm_merpayrec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `contract_id` int(10) unsigned NOT NULL DEFAULT '0',
  `plan_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `real_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `wheel` int(10) unsigned NOT NULL DEFAULT '0',
  `plan_paydate` varchar(20) NOT NULL DEFAULT '',
  `real_paydate` varchar(20) NOT NULL DEFAULT '',
  `creator_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `creator_user` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ticketor_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ticketor_user` varchar(20) NOT NULL DEFAULT '',
  `ticket_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sure_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sure_user` varchar(50) NOT NULL DEFAULT '',
  `fin_no` varchar(30) NOT NULL DEFAULT '',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mer_id` (`mer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_merpayrec` */

/*Table structure for table `pm_sysaudit` */

DROP TABLE IF EXISTS `pm_sysaudit`;

CREATE TABLE `pm_sysaudit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `target_ids` varchar(2000) NOT NULL DEFAULT '',
  `itype` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `level` smallint(6) NOT NULL DEFAULT '0',
  `audit_id` int(10) NOT NULL DEFAULT '0',
  `audit_name` varchar(30) NOT NULL DEFAULT '',
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysaudit` */

insert  into `pm_sysaudit`(`id`,`content`,`target_ids`,`itype`,`parent_id`,`level`,`audit_id`,`audit_name`,`action`,`create_time`) values (2,'内容信息完整，站长情况属实，允许通过！','10,9',0,0,0,7,'admin',1,0),(3,'内容信息完整，站长情况属实，允许通过！','8',0,0,0,7,'admin',1,0),(4,'内容信息完整，站长情况属实，允许通过！','10,7,6',0,0,0,7,'admin',1,0),(5,'内容信息完整，站长情况属实，允许通过！','20,19',0,0,0,7,'admin',1,0),(6,'内容信息完整，站长情况属实，允许通过！','18,17,16',0,0,0,7,'admin',1,0),(7,'内容信息完整，站长情况属实，允许通过！','15,14,13,12,11',0,0,0,7,'admin',1,0),(8,'内容信息完整，站点情况属实，允许通过！','4,2',1,0,0,7,'admin',1,0),(9,'内容信息完整，站点情况属实，允许通过！','4,2',1,0,0,7,'admin',1,0),(10,'内容信息完整，站点情况属实，允许通过！','4,2',1,0,0,7,'admin',0,0),(11,'内容信息完整，站点情况属实，允许通过！','3,5,6',1,0,0,7,'admin',0,0),(12,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(13,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(14,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(15,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(16,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(17,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(18,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0),(19,'广告计划内容信息准确，情况属实，允许通过！','3',4,0,0,7,'admin',0,0);

/*Table structure for table `pm_sysblacklist` */

DROP TABLE IF EXISTS `pm_sysblacklist`;

CREATE TABLE `pm_sysblacklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer') NOT NULL DEFAULT 'aff',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `lock_time` int(10) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `release_id` int(10) NOT NULL DEFAULT '0',
  `release_user` varchar(30) NOT NULL DEFAULT '',
  `release_time` int(10) NOT NULL DEFAULT '0',
  `lock_id` int(10) NOT NULL DEFAULT '0',
  `lock_user` varchar(30) NOT NULL DEFAULT '',
  `release_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysblacklist` */

insert  into `pm_sysblacklist`(`id`,`platform`,`user_id`,`user_name`,`lock_time`,`memo`,`status`,`release_id`,`release_user`,`release_time`,`lock_id`,`lock_user`,`release_desc`) values (15,'aff',10,'wyt25',1273938287,'该站长作弊，暂时屏蔽！',0,0,'',0,7,'admin',''),(16,'aff',9,'392152287',1273938287,'该站长作弊，暂时屏蔽！',1,7,'admin',1274375452,7,'admin','该站长承诺不在作弊，故可释放！');

/*Table structure for table `pm_syscelloperate` */

DROP TABLE IF EXISTS `pm_syscelloperate`;

CREATE TABLE `pm_syscelloperate` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `col_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `op_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_cid_oid` (`col_id`,`op_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_syscelloperate` */

/*Table structure for table `pm_sysconfig` */

DROP TABLE IF EXISTS `pm_sysconfig`;

CREATE TABLE `pm_sysconfig` (
  `key_name` varchar(30) NOT NULL DEFAULT '',
  `key_value` varchar(100) NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysconfig` */

insert  into `pm_sysconfig`(`key_name`,`key_value`) values ('site_audit','0'),('low_cpc_price','0'),('low_cpm_price','0'),('low_cpa_price','0'),('low_cpd_price','0'),('day_low_limit','0'),('domain_audit','0'),('aff_reg','1'),('aff_vcreg','0'),('get_pass','0'),('pass_question',''),('pay_low_price','0'),('pay_tax','0'),('pay_manual_fee','0'),('pay_cycle','1'),('pay_day','3'),('cpc_deduct','0'),('cpm_deduct','0'),('cpa_deduct','0'),('cpd_deduct','0'),('admin_ip_limit','0'),('admin_ip_list','');

/*Table structure for table `pm_syshelp` */

DROP TABLE IF EXISTS `pm_syshelp`;

CREATE TABLE `pm_syshelp` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  `module` varchar(50) NOT NULL DEFAULT '0',
  `itype` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` varchar(2000) NOT NULL DEFAULT '',
  `tags` varchar(100) NOT NULL DEFAULT '',
  `hit_count` int(10) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `pm_syshelp` */

insert  into `pm_syshelp`(`id`,`platform`,`module`,`itype`,`title`,`content`,`tags`,`hit_count`,`create_time`) values (1,'aff','结算中心',0,'我的收款信息需要修改，为何后台修改不了？','　　为了确保网站主会员的佣金安全，所有的网站主收款信息都须由我们的工作人员经过核实后方能修改，故请联系我们的客服人员为您修改。 ','',0,1272869404),(2,'aff','广告代码',0,'我有多个网站，可以同时投放广告吗？','　　本平台是支持一个帐户多个网站的，注册时候可只填写一个域名，其他域名在注册成功后在后台增加即可。只提交顶级域名，二级域名不必提交。在提交域名时请填写网站类别。 ','',0,1272869847),(3,'aff','统计分析',0,'广告统计数据多长时间更新一次（站长）？','　　数据为实时统计更新。即网站主会员可以实时看到当天的广告数据，每天24点汇总一次，可以查看汇总后的历史数据统计、佣金金额、本周佣金统计及历史支付记录。 ','',0,1272869882),(4,'aff','广告代码',0,'广告代码如何获取？','','',0,1272869905),(5,'aff','结算中心',0,'广告费支付的银行手续费由谁来承担？','','',0,1272869942),(6,'aff','统计分析',0,'广告统计数据多长时间更新一次？网站主如何了解自己的收入状况？','　　数据为实时统计更新。即网站主会员在后台可以实时看到当天的广告数据及获得金额，通过查看“本日佣金查询”、“历史佣金查询”、“佣金结算记录”查看汇总后的广告数据统计、佣金金额、本周佣金统计及历史支付记录。通过查看报表，清楚、准确了解自己的收入。 ','',0,1272869969),(17,'aff','新手上路',0,'什么情况下网站主才会获得收入？','　　网站主在自己的网站上投放魔告的广告代码，网站的访客产生了该广告项目中注明的效果（点击/弹出/注册等），网站主即可得到该广告项目相应的广告收入。 ','',0,1272871159),(18,'aff','新手上路',0,'网站主会员审核标准是什么？','　　1. 网站本身及广告不能包含任何违反国家法律的内容。 \r\n\r\n　　2. 网站本身及广告不能含有恶性代码及病毒，不能包含不健康的内容，如成人、性、色情、淫秽、赌博、暴力、反动等等。 \r\n\r\n　　3. 对只有论坛或无实际内容或页面排版不够专业美观的网站一律不予通过。 \r\n　　4. 每个网页的弹出窗口不得超过1个，不得自动弹出一次以上要求设为首页或加入收藏等类似对话框。 \r\n\r\n　　5. 任意流量,任意形式的网站及博客均可加入。\r\n\r\n如网站在通过审核后违反或不再符合以上标准中的任何一条，魔告将保留与其终止合作关系的权力。 ','',0,1272871175),(19,'aff','帐户管理',0,'二级域名上的广告被点击是否有效记费?','如果您注册的网站域名为http://1.abc.com)产生的点击都算是有效点击，都会被计费。','',0,1272871215),(20,'aff','结算中心',0,'对违规、作弊用户如何处理？','　　为了达到良好的广告效果,对作弊将进行非常严格的控制。第一次作弊，情节不严重的，我们将暂时锁定其帐户，并扣除当日佣金并返回给广告主。如再出现作弊情况，则永久锁定其帐户。第一次作弊，情节严重的，则永久锁定其帐户。第一次投放违规，我们会对其进行警告，再次出现，则锁定其帐户。第三次违规则永久锁定其帐户。 ','',0,1272871248),(21,'aff','广告代码',0,'广告投放标准是？','　　1. 正常投放广告，没有使用任何手段的都是魔告允许并推荐的方式；\r\n\r\n　　2. 广告不允许投放在空白，纯广告、注册或广告内容超过全页面内容的50%的页面；\r\n\r\n　　3. 网页元素和广告图片的距离要多于 15 象素，以保证访客不会误点； \r\n\r\n　　4. 广告代码投放要完整并一直显示；\r\n\r\n　　5. 广告代码不允许投放在软件里； \r\n\r\n　　6. 不允许做成浮动、弹窗效果或其他特殊展示效果投放广告代码； \r\n\r\n　　7. 广告代码不能投放在有非法内容的网站中，如病毒站、暴力色情站、赌博站、一切国家明令禁止的内容站点。 \r\n\r\n　　8. 为了增加点击的机率，或是避免未知因素导致某页面无法点击，您可以在多个页面上投放广告代码或在同一个页面投放多个图片/网摘广告代码或者同种尺寸选择多个广告轮播增加点击率。但一个页面最多只允许投放一个弹窗广告（包括我们的纯弹窗、显示弹窗广告和别家的进弹或退弹弹窗广告）。 ','',0,1272871273),(22,'aff','结算中心',0,'给站长付费形式有哪些？','　　目前支持使用最为广泛的中国工商银行、中国招商银行转帐方式，如果没有以上两种卡，请到所在地区办理（在您的支付方式中务必填写银行卡帐号和您的户名以及详细的开户行地址）。 ','',0,1272871305),(23,'aff','结算中心',0,'对站长何时计费及付费？','　　系统会按照活动的支付周期统计您当天的广告总佣金。满100元给予结算。如果您的佣金达到100元，我们即会在第二天通过银行转帐方式付费给您。如佣金低于100元，将累计到下一天一起支付。达到了支付额度，不必提出申请，系统会自动于当天通过银行转帐支付。 ','',0,1272871352);

/*Table structure for table `pm_syshelpmodule` */

DROP TABLE IF EXISTS `pm_syshelpmodule`;

CREATE TABLE `pm_syshelpmodule` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  `name` varchar(50) NOT NULL DEFAULT '',
  `memo` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_syshelpmodule` */

/*Table structure for table `pm_sysipaccess` */

DROP TABLE IF EXISTS `pm_sysipaccess`;

CREATE TABLE `pm_sysipaccess` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysipaccess` */

/*Table structure for table `pm_sysmodule` */

DROP TABLE IF EXISTS `pm_sysmodule`;

CREATE TABLE `pm_sysmodule` (
  `id` varchar(60) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `col_index` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_col_idx` (`col_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysmodule` */

/*Table structure for table `pm_sysmsglog` */

DROP TABLE IF EXISTS `pm_sysmsglog`;

CREATE TABLE `pm_sysmsglog` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer') NOT NULL DEFAULT 'aff',
  `rec_id` smallint(6) NOT NULL DEFAULT '0',
  `send_type` tinyint(1) NOT NULL DEFAULT '0',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `rec_name` varchar(60) DEFAULT '',
  `is_set` tinyint(1) DEFAULT '0',
  `send_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysmsglog` */

insert  into `pm_sysmsglog`(`id`,`platform`,`rec_id`,`send_type`,`is_read`,`title`,`content`,`status`,`create_time`,`rec_name`,`is_set`,`send_time`) values (1,'aff',111,0,0,'111','爱爱爱',0,1272887993,'',0,0),(2,'aff',111,0,0,'爱迪生法撒旦发','奥德赛罚撒旦发撒旦发',0,1272888239,'',0,0),(3,'aff',1,0,0,'阿大赛的啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊','啊啊啊啊啊啊啊啊啊啊',0,1272888481,'',0,0),(4,'aff',1,0,0,'啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊','啊啊啊啊啊啊啊啊啊啊啊啊啊',0,1272888489,'',0,0),(5,'aff',2,0,0,'鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅','鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅',0,1272888496,'',0,0);

/*Table structure for table `pm_sysmsgset` */

DROP TABLE IF EXISTS `pm_sysmsgset`;

CREATE TABLE `pm_sysmsgset` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  `is_all` tinyint(1) NOT NULL DEFAULT '0',
  `rec_id` varchar(2000) DEFAULT '',
  `rec_user` varchar(3000) DEFAULT '',
  `send_type` tinyint(1) NOT NULL DEFAULT '0',
  `msgtype` varchar(200) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` varchar(1000) NOT NULL DEFAULT '',
  `send_aim` varchar(100) NOT NULL DEFAULT '',
  `sys_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sys_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `send_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysmsgset` */

insert  into `pm_sysmsgset`(`id`,`platform`,`is_all`,`rec_id`,`rec_user`,`send_type`,`msgtype`,`title`,`content`,`send_aim`,`sys_id`,`sys_name`,`create_time`,`send_time`) values (5,'aff',1,'','',0,'','奥斯丁法撒旦发萨菲俺的沙发上','奥斯丁法撒旦发奥斯丁法撒旦发按时发生发送','阿的发生地发',7,'admin',1272897297,1273122000),(6,'aff',1,'','',0,'','奥斯丁法撒旦发奥斯丁','奥斯丁法萨芬奥斯飞洒法撒旦发','阿斯顿发是',7,'admin',1272897310,1272787200),(7,'aff',1,'','',0,'','奥斯丁法萨芬阿斯顿发是飞','法撒旦发按时发送发生的','奥斯丁法萨芬',7,'admin',1272897339,1273284000),(8,'aff',1,'','',0,'','奥斯丁法萨芬啊沙发','法萨芬法撒旦发','阿的发生地发',7,'admin',1272897412,1273222800);

/*Table structure for table `pm_sysmsgtpl` */

DROP TABLE IF EXISTS `pm_sysmsgtpl`;

CREATE TABLE `pm_sysmsgtpl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  `send_type` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `content` varchar(2000) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysmsgtpl` */

insert  into `pm_sysmsgtpl`(`id`,`platform`,`send_type`,`name`,`subject`,`content`,`tag`,`create_time`) values (2,'aff',0,'爱迪生法撒旦发','爱的发声的发生地发生法撒旦发','按时的发生发送发送法撒旦发','奥斯丁飞',1272893037),(3,'aff',0,'阿的发生地','奥斯丁法撒旦发','爱的发生法发撒旦发撒旦发撒旦发生的发疯','爱迪生飞',1272893098),(4,'aff',0,'奥斯丁发生的','奥斯丁按时法撒旦发','按时的发送方按时法撒旦发按时发送方','阿东飞',1272893144),(5,'aff',0,'爱迪生法撒旦发','爱的发声 的萨法撒旦发按时法撒旦发','奥斯丁法撒旦发奥斯丁发送方','阿东发',1272893766),(6,'aff',0,'111111111111','111111111111','111111111111','',1272899447),(7,'aff',0,'2222222222222222','2222222222222222','2222222222222222','',1272899452),(8,'aff',0,'33333333333333','33333333333333','33333333333333','',1272899458),(9,'aff',0,'4444444444444444444','4444444444444444444','4444444444444444444','',1272899463),(10,'aff',0,'555555555555555555','555555555555555555','555555555555555555','',1272899469),(11,'aff',0,'66666666666666666666','66666666666666666666','66666666666666666666','',1272899474),(12,'aff',0,'77777777777777777777','77777777777777777777','77777777777777777777','',1272899479),(13,'aff',0,'88888888888888888888','88888888888888888888','88888888888888888888','',1272899485),(14,'aff',0,'99999999999999999999999','99999999999999999999999','99999999999999999999999','',1272899490),(15,'aff',0,'10101010101010101010','10101010101010101010','10101010101010101010','',1272899499),(16,'aff',0,'11-11-11-11-11-11-11-11-11','11-11-11-11-11-11-11-11-11','11-11-11-11-11-11-11-11-11','',1272899515),(17,'aff',0,'12-12-12-12-12-12-12-12-12','12-12-12-12-12-12-12-12-12','12-12-12-12-12-12-12-12-12','',1272899525);

/*Table structure for table `pm_sysnews` */

DROP TABLE IF EXISTS `pm_sysnews`;

CREATE TABLE `pm_sysnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  `title` varchar(200) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `content` varchar(4000) NOT NULL DEFAULT '',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `audit_id` int(10) NOT NULL DEFAULT '0',
  `audit_name` varchar(50) NOT NULL DEFAULT '',
  `audit_time` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_red` tinyint(1) NOT NULL DEFAULT '0',
  `itype` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysnews` */

insert  into `pm_sysnews`(`id`,`platform`,`title`,`create_time`,`content`,`user_id`,`user_name`,`audit_id`,`audit_name`,`audit_time`,`status`,`is_top`,`is_red`,`itype`) values (1,'aff','爱的发声的发生地发',0,'阿的发生地发',0,'',0,'',0,0,0,0,1),(2,'aff','爱的发声',1272652557,'爱的色放',0,'',0,'',0,0,0,0,0),(6,'aff','阿东所发生的发生',1272723085,'阿斯顿说的',0,'',0,'',0,0,0,0,0),(4,'aff','ads爱迪生法撒旦发是',1272686868,'fasdfasdf',0,'',0,'',0,1,1,0,0),(7,'aff','爱迪生法撒旦发',1272723091,'撒的发生的发生的',0,'',0,'',0,0,0,0,0),(8,'aff','阿的发生地发',1272723095,'阿斯顿飞阿斯顿飞',0,'',0,'',0,0,0,0,0),(9,'aff','阿斯顿法撒旦发',1272723099,'撒旦发撒旦',0,'',0,'',0,0,0,0,0),(10,'aff','奥德赛发送方',1272723105,'阿萨德发送发生的发生',0,'',0,'',0,0,0,0,0),(11,'aff','爱迪生发生的',1272723110,'发生发生',0,'',0,'',0,0,0,0,0),(12,'aff','奥德赛',1272723114,'罚是的非打算放',0,'',0,'',0,0,0,0,0),(13,'aff','阿什顿法撒旦发',1272723118,'撒旦发阿什顿发送方',0,'',0,'',0,2,0,0,0),(14,'aff','按时艾瑟顿发生的法撒旦发',1272723125,'艾丝凡',0,'',0,'',0,0,0,0,0),(15,'aff','暗色调法大赛的',1272723129,'奥斯丁 飞洒的飞洒的',0,'',0,'',0,0,0,0,0),(16,'aff','阿东奥斯丁法撒旦发撒的发生的发生的发生的',1272723136,'地方飞奥斯丁法撒旦发',0,'',0,'',0,1,0,0,0),(17,'aff','第三方飞奥斯丁发生的',1272723142,'地方地方',0,'',0,'',0,0,0,0,0),(18,'aff','奥斯丁奥斯丁法撒旦发飞洒的',1272723148,'放奥斯丁法撒旦发',0,'',0,'',0,0,0,0,0),(19,'aff','奥斯丁法撒旦发撒的发生的',1272723274,'东方撒旦发奥斯丁法撒旦发奥斯丁',0,'',0,'',0,0,1,1,1);

/*Table structure for table `pm_sysoperate` */

DROP TABLE IF EXISTS `pm_sysoperate`;

CREATE TABLE `pm_sysoperate` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `op_name` varchar(30) NOT NULL DEFAULT '',
  `op_code` varchar(30) NOT NULL DEFAULT '',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysoperate` */

/*Table structure for table `pm_sysoplog` */

DROP TABLE IF EXISTS `pm_sysoplog`;

CREATE TABLE `pm_sysoplog` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `op_type` tinyint(1) NOT NULL DEFAULT '0',
  `op_name` varchar(200) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `op_content` varchar(500) NOT NULL DEFAULT '',
  `platform` enum('aff','mer','sys') NOT NULL DEFAULT 'aff',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=735 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysoplog` */

insert  into `pm_sysoplog`(`id`,`user_id`,`user_name`,`op_type`,`op_name`,`create_time`,`op_content`,`platform`) values (696,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dAXX9MbJjZg%2bJxTaTbhUJ9w%3d%3d','sys'),(697,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dAXX9MbJjZg%2bJxTaTbhUJ9w%3d%3d','sys'),(698,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fUserManage.aspx%3fColID%3da%2fvYb4Wd7zhTfU6ooiGlhQ%3d%3d','sys'),(699,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dAXX9MbJjZg%2bJxTaTbhUJ9w%3d%3d','sys'),(700,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dAXX9MbJjZg%2bJxTaTbhUJ9w%3d%3d','sys'),(701,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dVtoUUt8QoLOL7FIaHL4PEA%3d%3d','sys'),(702,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fUserManage.aspx%3fColID%3dyOKBDPIxKvN5rBc33hU%2f2w%3d%3d','sys'),(703,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fColumnManage.aspx%3fColID%3dEuwI4YNXq8JW%2bjOa9GDohw%3d%3d','sys'),(704,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fOPRec.aspx%3fColID%3dn%2baQiFn8iMP1Vg7qduB2ZA%3d%3d','sys'),(705,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fColumnManage.aspx%3fColID%3dEuwI4YNXq8JW%2bjOa9GDohw%3d%3d','sys'),(706,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fOPRec.aspx%3fColID%3dn%2baQiFn8iMP1Vg7qduB2ZA%3d%3d','sys'),(707,7,'admin',4,'用户进入页面',1272210335,'用户进入页面%2fadmin%2fSystemManage%2fColumnManage.aspx%3fColID%3dEuwI4YNXq8JW%2bjOa9GDohw%3d%3d','sys'),(708,7,'admin',4,'用户进入页面',0,'用户进入页面%2fadmin%2fSystemManage%2fUserManage.aspx%3fColID%3dyOKBDPIxKvN5rBc33hU%2f2w%3d%3d','sys'),(709,7,'admin',4,'用户进入页面',0,'用户进入页面%2fadmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dVtoUUt8QoLOL7FIaHL4PEA%3d%3d','sys'),(710,7,'admin',4,'用户进入页面',0,'用户进入页面%2fadmin%2fSystemManage%2fRoleLimit.aspx%3faction%3ddis%26curID%3d1%26ColID%3dVtoUUt8QoLOL7FIaHL4PEA%3d%3d%26Page%3d1','sys'),(711,7,'admin',3,'用户登录成功',0,'用户登录IP：127.0.0.1','sys'),(712,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys'),(713,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fUserManage.aspx%3fColID%3dH3GVYdjZ9zcU2O2cVe4EZQ%3d%3d','sys'),(714,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fColumnManage.aspx%3fColID%3deYUoETdhb759DxOxlQ7zFg%3d%3d','sys'),(715,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fOPRec.aspx%3fColID%3dtXoUnKwXqOUPO%2f86f9GZDQ%3d%3d','sys'),(716,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fUserManage.aspx%3fColID%3dH3GVYdjZ9zcU2O2cVe4EZQ%3d%3d','sys'),(717,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys'),(718,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleEdit.aspx%3faction%3dedit%26curID%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d%26Page%3d1','sys'),(719,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleEdit.aspx%3faction%3dedit%26curID%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%253d%253d%26Page%3d1','sys'),(720,7,'admin',1,'用户修改系统角色',0,'修改角色编号：1 Name:系统管理员 Desc:系统管理员','sys'),(721,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fPage%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys'),(722,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleLimit.aspx%3faction%3ddis%26curID%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d%26Page%3d1','sys'),(723,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleLimit.aspx%3faction%3ddis%26curID%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%253d%253d%26Page%3d1','sys'),(724,7,'admin',1,'用户设定角色权限',0,'设定权限单元：10,12,14,15,16,17,18,19,22,23,24,25,26,27,28,8,20,21,36,37,38,39,40,41,42,13,9,43,44,45,46,47,48,49,11,50,51,52,53,54,55,56','sys'),(725,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fPage%3d1%26ColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys'),(726,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fUserManage.aspx%3fColID%3dH3GVYdjZ9zcU2O2cVe4EZQ%3d%3d','sys'),(727,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fColumnManage.aspx%3fColID%3deYUoETdhb759DxOxlQ7zFg%3d%3d','sys'),(728,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fOPRec.aspx%3fColID%3dtXoUnKwXqOUPO%2f86f9GZDQ%3d%3d','sys'),(729,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys'),(730,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fUserManage.aspx%3fColID%3dH3GVYdjZ9zcU2O2cVe4EZQ%3d%3d','sys'),(731,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fColumnManage.aspx%3fColID%3deYUoETdhb759DxOxlQ7zFg%3d%3d','sys'),(732,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fOPRec.aspx%3fColID%3dtXoUnKwXqOUPO%2f86f9GZDQ%3d%3d','sys'),(733,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fUserManage.aspx%3fColID%3dH3GVYdjZ9zcU2O2cVe4EZQ%3d%3d','sys'),(734,7,'admin',4,'用户进入页面',0,'用户进入页面%2fAdmin%2fSystemManage%2fRoleManage.aspx%3fColID%3dTB8kUiFfsKauSBnjWANllQ%3d%3d','sys');

/*Table structure for table `pm_sysrole` */

DROP TABLE IF EXISTS `pm_sysrole`;

CREATE TABLE `pm_sysrole` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `memo` varchar(200) NOT NULL DEFAULT '',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `operate_ids` varchar(2000) NOT NULL DEFAULT '',
  `itype` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysrole` */

insert  into `pm_sysrole`(`id`,`name`,`memo`,`is_del`,`operate_ids`,`itype`) values (1,'系统管理员','最高权限管理员',0,'',0),(2,'广告编辑经理','广告编辑',0,'',2),(3,'广告商务经理','广告商务经理',0,'',3),(4,'客服经理','站长客服人员',0,'',1),(5,'广告发布人员','广告发布人员',0,'',2),(11,'财务人员','负责财务支付对账等事务',0,'',4);

/*Table structure for table `pm_sysuser` */

DROP TABLE IF EXISTS `pm_sysuser`;

CREATE TABLE `pm_sysuser` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(30) NOT NULL DEFAULT '',
  `login_pwd` varchar(100) NOT NULL DEFAULT '',
  `real_name` varchar(30) NOT NULL DEFAULT '',
  `nick_name` varchar(30) NOT NULL DEFAULT '',
  `role_id` varchar(50) NOT NULL DEFAULT '',
  `own_users` varchar(100) NOT NULL DEFAULT '',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `qq` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(100) NOT NULL DEFAULT '',
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `login_srcpwd` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_loginname` (`login_name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `pm_sysuser` */

insert  into `pm_sysuser`(`id`,`login_name`,`login_pwd`,`real_name`,`nick_name`,`role_id`,`own_users`,`is_active`,`qq`,`mobile`,`msn`,`is_del`,`create_time`,`login_srcpwd`) values (7,'admin','f12adeaafe4b867668861fbe96f12ec1','系统管理员','系统管理员','1','',1,'','13463650301','',0,1271691853,'admin'),(11,'test222','606c18a0d32d509ddad5aef6cccfbeb1','test222','test222','1','',0,'test222','15801258111','',0,1272717537,'test222');

/*Table structure for table `rep_affbill_cycle` */

DROP TABLE IF EXISTS `rep_affbill_cycle`;

CREATE TABLE `rep_affbill_cycle` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `need_count` int(10) unsigned NOT NULL DEFAULT '0',
  `need_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `pay_count` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `pay_start` varchar(20) NOT NULL DEFAULT '',
  `pay_end` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `audit_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `audit_user` varchar(30) NOT NULL DEFAULT '',
  `memo` varchar(500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `rep_affbill_cycle` */

/*Table structure for table `rep_affbill_day` */

DROP TABLE IF EXISTS `rep_affbill_day`;

CREATE TABLE `rep_affbill_day` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_count` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `kill_count` int(10) unsigned NOT NULL DEFAULT '0',
  `kill_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `real_count` int(10) unsigned NOT NULL DEFAULT '0',
  `real_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `memo` varchar(1000) NOT NULL DEFAULT '',
  `fee_code` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aid_aid` (`aff_id`,`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `rep_affbill_day` */

/*Table structure for table `rep_affplacecount_day` */

DROP TABLE IF EXISTS `rep_affplacecount_day`;

CREATE TABLE `rep_affplacecount_day` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `aff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `show_num` int(10) unsigned NOT NULL DEFAULT '0',
  `click_num` int(10) unsigned NOT NULL DEFAULT '0',
  `cookie_num` int(10) unsigned NOT NULL DEFAULT '0',
  `order_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `send_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `real_num` int(10) unsigned NOT NULL DEFAULT '0',
  `fake_num` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `fake_totalmoney` decimal(8,2) NOT NULL DEFAULT '0.00',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `rep_affplacecount_day` */

/*Table structure for table `rep_mercount_day` */

DROP TABLE IF EXISTS `rep_mercount_day`;

CREATE TABLE `rep_mercount_day` (
  `id` bigint(30) unsigned NOT NULL DEFAULT '0',
  `mer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `adv_id` int(10) unsigned NOT NULL DEFAULT '0',
  `creative_id` int(10) unsigned NOT NULL DEFAULT '0',
  `show_num` int(10) unsigned NOT NULL DEFAULT '0',
  `click_num` int(10) unsigned NOT NULL DEFAULT '0',
  `cookie_num` int(10) unsigned NOT NULL DEFAULT '0',
  `order_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `send_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `real_num` int(10) unsigned NOT NULL DEFAULT '0',
  `fake_num` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `fake_totalmoney` decimal(8,2) NOT NULL DEFAULT '0.00',
  `iday` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_money` decimal(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `rep_mercount_day` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

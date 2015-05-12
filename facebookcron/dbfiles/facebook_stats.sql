/*
SQLyog Ultimate v8.82 
MySQL - 5.5.8-log : Database - contentio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cio_facebook_stats` */

DROP TABLE IF EXISTS `cio_facebook_stats`;

CREATE TABLE `cio_facebook_stats` (
  `facebook_stats_id` int(22) NOT NULL AUTO_INCREMENT,
  `facebook_stats_like` int(18) DEFAULT NULL,
  `facebook_stats_reach` int(18) DEFAULT NULL,
  `facebook_stats_comment` int(18) DEFAULT NULL,
  `facebook_stats_post` int(18) DEFAULT NULL,
  `facebook_stats_post_like` int(18) DEFAULT NULL,
  `facebook_user_id` int(22) DEFAULT NULL,
  `facebook_stats_add_date` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`facebook_stats_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

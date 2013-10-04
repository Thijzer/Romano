# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29-log)
# Database: thijzer
# Generation Time: 2013-10-01 20:34:15 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table comments
# ------------------------------------------------------------

CREATE TABLE `comments` (
  `cid` int(6) NOT NULL AUTO_INCREMENT,
  `pid` int(6) NOT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  `body` varchar(128) NOT NULL DEFAULT '',
  `active` smallint(2) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table gallery
# ------------------------------------------------------------

CREATE TABLE `gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `description` tinytext,
  `keycode` varchar(25) DEFAULT NULL,
  `guestcode` varchar(15) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `public` tinyint(11) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `cover` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table messages
# ------------------------------------------------------------

CREATE TABLE `messages` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `usergroup` varchar(40) DEFAULT NULL,
  `message` text,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pics
# ------------------------------------------------------------

CREATE TABLE `pics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `cust_select` tinyint(1) DEFAULT '1',
  `active` tinyint(1) DEFAULT '1',
  `title` varchar(128) DEFAULT NULL,
  `filename` varchar(70) DEFAULT NULL,
  `path` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table posts
# ------------------------------------------------------------

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(60) NOT NULL DEFAULT '',
  `tag` varchar(60) DEFAULT NULL,
  `type` varchar(16) NOT NULL DEFAULT '',
  `head` varchar(128) DEFAULT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `active` smallint(2) NOT NULL DEFAULT '1',
  `public` smallint(2) NOT NULL DEFAULT '0',
  `views` int(6) DEFAULT '0',
  `meter` int(6) DEFAULT '0',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `post_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tags
# ------------------------------------------------------------

CREATE TABLE `tags` (
  `tag_id` int(6) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(20) DEFAULT NULL,
  `tag_count` int(6) DEFAULT '0',
  `tag_meter` int(6) DEFAULT NULL,
  `tag_parent_id` varchar(60) DEFAULT NULL,
  `tag_date_added` datetime DEFAULT NULL,
  `tag_date_acces` datetime DEFAULT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `uid` int(6) NOT NULL AUTO_INCREMENT,
  `key` int(11) DEFAULT NULL,
  `email` varchar(70) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` blob,
  `active` smallint(1) NOT NULL DEFAULT '0',
  `reset` varchar(20) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(40) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `language` varchar(25) DEFAULT NULL,
  `level` tinyint(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*
Navicat MySQL Data Transfer

Source Server         : site1
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-07-24 07:10:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for about
-- ----------------------------
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for email_edit
-- ----------------------------
DROP TABLE IF EXISTS `email_edit`;
CREATE TABLE `email_edit` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `account_id` mediumint(9) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `username` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for password_recovery
-- ----------------------------
DROP TABLE IF EXISTS `password_recovery`;
CREATE TABLE `password_recovery` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `account_id` mediumint(9) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `product_name` tinytext NOT NULL,
  `short_description` tinytext NOT NULL,
  `description` text NOT NULL,
  `count` mediumint(9) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for promocodes
-- ----------------------------
DROP TABLE IF EXISTS `promocodes`;
CREATE TABLE `promocodes` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `amount` mediumint(9) NOT NULL,
  `promocode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for purchases
-- ----------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `surname` tinytext NOT NULL,
  `company` tinytext,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `region` text,
  `index` tinytext,
  `country` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `balance` mediumint(9) NOT NULL DEFAULT '0',
  `activation` varchar(255) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;

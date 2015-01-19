/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : likevery

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-01-19 18:12:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `access`
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of access
-- ----------------------------

-- ----------------------------
-- Table structure for `cvupload`
-- ----------------------------
DROP TABLE IF EXISTS `cvupload`;
CREATE TABLE `cvupload` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `path` varchar(200) NOT NULL COMMENT '简历路径',
  `filename` varchar(200) NOT NULL COMMENT '文件名',
  `status` varchar(2) NOT NULL COMMENT '简历状态\r\n00-未处理\r\n01-已分配\r\n02-审核通过\r\n03-审核不通过\r\n06-删除',
  `createdate` datetime DEFAULT NULL COMMENT '简历上传日期',
  `assignerid` int(10) DEFAULT NULL COMMENT '分配人id',
  `assignername` varchar(200) DEFAULT NULL COMMENT '分配人姓名',
  `assigndate` datetime DEFAULT NULL COMMENT '分配日期',
  `operatorid` int(10) DEFAULT NULL COMMENT '操作人id',
  `operatorname` varchar(200) DEFAULT NULL COMMENT '操作人姓名',
  `operadate` datetime DEFAULT NULL COMMENT '操作日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cvupload
-- ----------------------------
INSERT INTO `cvupload` VALUES ('1', 'CV/uncheck/2015-01-19/54bcd7fb3950b.doc', '新建文本文档.doc', '00', '2015-01-19 18:10:03', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `group`
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group
-- ----------------------------

-- ----------------------------
-- Table structure for `node`
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of node
-- ----------------------------

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ename` varchar(5) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`ename`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_user
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `bind_account` varchar(50) NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0',
  `verify` varchar(32) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `type_id` tinyint(2) unsigned DEFAULT '0',
  `info` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

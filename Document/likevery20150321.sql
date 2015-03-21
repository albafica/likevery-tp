/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : likevery

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-03-21 16:51:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cvupload`
-- ----------------------------
DROP TABLE IF EXISTS `cvupload`;
CREATE TABLE `cvupload` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `path` varchar(200) NOT NULL COMMENT '����·��',
  `filename` varchar(200) NOT NULL COMMENT '��������',
  `status` varchar(2) NOT NULL DEFAULT '0' COMMENT '�������״̬',
  `createdate` datetime DEFAULT NULL COMMENT '��������',
  `isassigned` varchar(2) NOT NULL DEFAULT '0' COMMENT '是否被分配',
  `assignerid` int(10) DEFAULT NULL COMMENT '������id',
  `assignername` varchar(200) DEFAULT NULL COMMENT '����������',
  `assigndate` datetime DEFAULT NULL COMMENT '��������',
  `operatorid` int(10) DEFAULT NULL COMMENT '������id',
  `operatorname` varchar(200) DEFAULT NULL COMMENT '����������',
  `operadate` datetime DEFAULT NULL COMMENT '��������',
  `cname` varchar(20) DEFAULT NULL COMMENT '求职者姓名',
  `mobilephone` varchar(20) DEFAULT NULL COMMENT '求职者手机',
  `email` varchar(50) DEFAULT NULL COMMENT '求职者邮箱',
  `jobtype` varchar(2) NOT NULL COMMENT '求职意向 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cvupload
-- ----------------------------
INSERT INTO `cvupload` VALUES ('1', 'CV/uncheck/2015-03-21/550d1d747406a.docx', '新建 Microsoft Word 文档.docx', '01', '2015-01-22 10:11:57', '1', '1', 'admin', '2015-03-21 14:19:18', '1', '超级管理员', '2015-03-21 15:27:48', 'sdas', '13795302916', 'sdasda@qq.com', '');
INSERT INTO `cvupload` VALUES ('2', 'CV/uncheck/2015-01-22/54c05c728def6.docx', 'redis官方集群.docx', '06', '2015-01-22 10:12:02', '1', '1', 'admin', '2015-01-22 11:17:56', '1', 'admin', '2015-01-22 14:51:37', null, null, null, '');
INSERT INTO `cvupload` VALUES ('3', 'CV/uncheck/2015-03-21/550d0bf946d7f.docx', 'redis官方集群 (1) - 副本.docx', '01', '2015-01-22 10:12:47', '1', '1', 'admin', '2015-03-21 14:12:11', '1', '超级管理员', '2015-03-21 14:13:13', 'sdas', '13636599143', '', '');
INSERT INTO `cvupload` VALUES ('4', 'CV/uncheck/2015-01-22/54c05ca3cf5a1.docx', 'redis官方集群.docx', '06', '2015-01-22 10:12:51', '1', '1', 'admin', '2015-02-04 10:40:58', '1', 'admin', '2015-02-04 10:41:03', null, null, null, '');
INSERT INTO `cvupload` VALUES ('5', 'CV/uncheck/2015-01-22/54c05ca827a3b.docx', 'redis安装.docx', '03', '2015-01-22 10:12:56', '1', '1', 'admin', '2015-02-27 10:36:42', '1', '超级管理员', '2015-03-04 20:21:02', '测试账号', '11111111111111111111', 'sdasda@qq.com', '');
INSERT INTO `cvupload` VALUES ('6', 'CV/uncheck/2015-01-22/54c05caca756d.docx', 'redis安装.docx', '01', '2015-01-22 10:13:00', '0', null, null, null, '1', '超级管理员', '2015-02-04 15:55:02', 'sdas', '+08613636599140', '', '');
INSERT INTO `cvupload` VALUES ('7', 'CV/uncheck/2015-03-21/550d0c1275629.docx', '软件用模板.docx', '01', '2015-01-22 10:13:05', '1', '1', 'admin', '2015-03-21 14:12:43', '1', '超级管理员', '2015-03-21 14:13:38', 'sdas', '+08613636599140', 'sdasda', '');
INSERT INTO `cvupload` VALUES ('8', 'CV/uncheck/2015-01-22/54c05cb59d992.docx', 'redis安装.docx', '00', '2015-01-22 10:13:09', '1', '1', 'admin', '2015-02-04 15:57:36', null, null, null, null, null, null, '');
INSERT INTO `cvupload` VALUES ('9', 'CV/uncheck/2015-01-22/54c05cba7fd3b.docx', 'redis安装.docx', '00', '2015-01-22 10:13:14', '0', null, null, null, null, null, null, null, null, null, '');
INSERT INTO `cvupload` VALUES ('10', 'CV/uncheck/2015-01-22/54c05cbee3736.docx', 'redis官方集群.docx', '00', '2015-01-22 10:13:18', '0', null, null, null, null, null, null, null, null, null, '');
INSERT INTO `cvupload` VALUES ('11', 'CV/uncheck/2015-01-22/54c05cc3d4d13.docx', 'redis官方集群.docx', '00', '2015-01-22 10:13:23', '0', null, null, null, null, null, null, null, null, null, '');
INSERT INTO `cvupload` VALUES ('12', 'CV/uncheck/2015-01-22/54c05cc8f1271.docx', 'redis安装.docx', '06', '2015-01-22 10:13:29', '1', '1', 'admin', '2015-01-22 14:17:16', '1', 'admin', '2015-01-22 14:52:22', null, null, null, '');
INSERT INTO `cvupload` VALUES ('13', 'CV/uncheck/2015-01-22/54c089fd83c4d.docx', 'redis安装.docx', '00', '2015-01-22 13:26:22', '0', null, null, null, null, null, null, null, null, null, '');
INSERT INTO `cvupload` VALUES ('14', 'CV/uncheck/2015-03-19/550a86bf4541b.docx', '软件用模板.docx', '02', '2015-03-19 16:20:15', '1', '1', 'admin', '2015-03-19 16:23:20', '1', '超级管理员', '2015-03-19 16:24:00', 'sdasa', '13636590000', 'albaficaw@gmail.com', '2');

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `managerid` int(4) NOT NULL COMMENT '求职者id',
  `status` varchar(2) NOT NULL DEFAULT '00' COMMENT '状态',
  `startdate` date NOT NULL COMMENT '开始时间',
  `enddate` date NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('3', '5', '03', '2015-03-21', '2015-04-06');
INSERT INTO `employee` VALUES ('5', '8', '02', '2015-03-21', '2015-04-06');

-- ----------------------------
-- Table structure for `manager`
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `jobtype` int(5) NOT NULL DEFAULT '4' COMMENT '求职者职位类型',
  `cname` varchar(50) NOT NULL COMMENT '求职者姓名',
  `ename` varchar(50) DEFAULT NULL COMMENT '求职者英文名',
  `email` varchar(50) DEFAULT NULL COMMENT '求职者邮箱',
  `mobilephone` varchar(20) DEFAULT NULL COMMENT '手机',
  `tel` varchar(20) DEFAULT NULL COMMENT '座机',
  `gender` varchar(2) DEFAULT NULL COMMENT '性别',
  `brithday` date DEFAULT NULL COMMENT '生日',
  `homepage` varchar(100) DEFAULT NULL COMMENT '个人主页',
  `targetposition` varchar(100) DEFAULT NULL COMMENT '期望职位',
  `getjobtime` varchar(100) DEFAULT NULL COMMENT '到岗时间',
  `area` varchar(100) DEFAULT NULL COMMENT '用户居住城市',
  `targetarea` varchar(100) DEFAULT NULL COMMENT '用户目标城市',
  `edulevel` int(5) DEFAULT NULL COMMENT '学历',
  `workyear` int(5) DEFAULT NULL COMMENT '工作年限',
  `salary` int(5) DEFAULT NULL COMMENT '当前年薪',
  `targetsalary` int(5) DEFAULT NULL COMMENT '目标年薪',
  `tag` varchar(500) DEFAULT NULL COMMENT '标签',
  `selfintroduce` text COMMENT '自我评价',
  `memo` text COMMENT '备注信息',
  `createdate` date DEFAULT NULL COMMENT '创建日期',
  `updatedate` date DEFAULT NULL COMMENT '更新日期',
  `cvid` int(11) DEFAULT NULL COMMENT '简历id',
  `refuseemail` int(1) DEFAULT NULL COMMENT '拒绝接受邮件',
  `status` varchar(2) DEFAULT NULL COMMENT '简历状态',
  `releasestatus` varchar(2) DEFAULT '00' COMMENT '发布状态',
  `question1` text COMMENT '问题1',
  `answear1` text COMMENT '回答1',
  `question2` text COMMENT '问题2',
  `answear2` text COMMENT '回答2',
  `question3` text COMMENT '问题3',
  `answear3` text COMMENT '回答3',
  `question4` text COMMENT '问题4',
  `answear4` text COMMENT '回答4',
  `question5` text COMMENT '问题5',
  `answear5` text COMMENT '回答5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('4', '4', '测试账号', '', 'sdasda@qq.com', '13636590000', '', '0', '0000-00-00', '', '都杀掉', '', '', '', '0', '0', '0', '0', '四大四大', '', '', '2015-03-04', null, '5', null, '01', '00', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `manager` VALUES ('5', '4', 'sdas', 'ename', 'sdasda@qq.com', '+08613636599140', '13526062811', '2', '2015-02-05', 'yahoo', '苏打水sd', '四大四大', '111', '111', '7', '4', '2222', '11111', 'tag tag2', '请假sdfdsfsdf', '辈出dfsdfsdf', '2015-03-04', null, '1', null, '01', '00', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `manager` VALUES ('6', '4', '测试账号', '', 'sdasda@qq.com', '13636599143', '', '0', '0000-00-00', '', 'sdasda', '', '', '', '0', '0', '0', '0', 'sdasadas', '', '', '2015-03-04', null, '5', null, '01', '00', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `manager` VALUES ('8', '4', 'sdas', '', 'sdasda@qq.com', '+08613636599140', '', '0', '0000-00-00', '', 'sdadads', '', '', '', '0', '0', '0', '0', 'dasdadsad', '', '', '2015-03-04', null, '7', null, '01', '01', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `manager` VALUES ('9', '2', 'sdasa', '', 'albaficaw@gmail.com', '13636590000', '', '0', '0000-00-00', '', '四大四大', '', '', '', '0', '0', '0', '0', 'php', '', '', '2015-03-19', null, '14', null, '01', '00', null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `rolename` varchar(50) NOT NULL COMMENT '角色名',
  `isadmin` varchar(2) NOT NULL DEFAULT '0' COMMENT '是否超级管理员分组',
  `rights` varchar(10) NOT NULL DEFAULT '0' COMMENT '角色权限',
  `status` varchar(2) NOT NULL DEFAULT '1' COMMENT '角色状态',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '1', '0', '01', '超级管理员分组');
INSERT INTO `role` VALUES ('6', '一般管理员', '0', '1', '01', '这是一般管理员角色');
INSERT INTO `role` VALUES ('7', '游客角色', '0', '0', '01', '什么权限都没有');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `username` varchar(20) NOT NULL COMMENT '��¼��',
  `password` varchar(50) NOT NULL COMMENT '��½����',
  `roleid` int(4) DEFAULT NULL,
  `cname` varchar(50) NOT NULL COMMENT '����',
  `issys` varchar(2) NOT NULL DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL COMMENT '����',
  `createdate` datetime DEFAULT NULL COMMENT '��������',
  `status` varchar(2) NOT NULL DEFAULT '01' COMMENT '״̬',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '86f3059b228c8acf99e69734b6bb32cc', '1', '超级管理员', '1', '备注信息', 'albafica.wang@51job.com', '2015-01-21 16:22:48', '01');
INSERT INTO `user` VALUES ('6', 'test', 'f06e10e44f4ab328415f83baefc2edd3', '6', '测试账号', '0', '这是测试账号', '993597626@qq.com', '2015-01-27 14:44:06', '01');
INSERT INTO `user` VALUES ('7', 'test1', 'ef95c38bb9dbe33772445b1fb39f3dfd', '6', '测试账号1', '0', '这是测试账号1', '13636599143@163.com', '2015-01-27 14:44:34', '01');
INSERT INTO `user` VALUES ('8', 'demo', '629313c380e0defefbd6267651c72a9d', '7', '游客', '0', '游客，无操作权限', 'demo@qq.com', '2015-02-03 10:06:40', '01');

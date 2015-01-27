 /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';
CREATE USER spy@'%' IDENTIFIED BY 'spy';
SET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');
SET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');
GRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';
GRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/

Create Database If Not Exists likevery;
USE likevery;

/**************表名：user  表描述:后台用户表  字段数量:10    生成时间:2015/1/27 17:12:03***********/
drop table if exists user;
CREATE TABLE user( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,username varchar(20) NOT NULL comment '登录名'
,password varchar(50) NOT NULL comment '登陆密码'
,roleid int(4) NOT NULL comment '角色id'
,cname varchar(50) NOT NULL comment '姓名'
,issys varchar(2) NOT NULL Default '0' comment '是否系统账号'
,email varchar(100) NOT NULL comment '邮箱'
,createdate datetime comment '创建日期'
,status varchar(2) NOT NULL Default '01' comment '状态'
,memo varchar(255) comment '备注'
) ;



/**************表名：cvupload  表描述:简历上传表  字段数量:11    生成时间:2015/1/27 17:12:03***********/
drop table if exists cvupload;
CREATE TABLE cvupload( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,path varchar(200) NOT NULL comment '简历路径'
,filename varchar(200) NOT NULL comment '简历名称'
,status varchar(2) NOT NULL Default '00' comment '简历审核状态'
,createdate datetime comment '创建日期'
,assignerid int(10) comment '分配人id'
,assignername varchar(200) comment '分配人姓名'
,assigndate datetime comment '分配日期'
,operatorid int(10) comment '操作人id'
,operatorname varchar(200) comment '操作人姓名'
,operadate datetime comment '操作日期'
) ;



/**************表名：role  表描述:角色表  字段数量:6    生成时间:2015/1/27 17:12:03***********/
drop table if exists role;
CREATE TABLE role( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,rolename varchar(50) NOT NULL comment '角色名'
,isadmin varchar(2) NOT NULL Default '0' comment '是否超级管理员分组'
,rights varchar(10) NOT NULL Default '0000000000' comment '角色权限'
,status varchar(2) NOT NULL Default '01' comment '角色状态'
,memo varchar(255) comment '备注'
) ;



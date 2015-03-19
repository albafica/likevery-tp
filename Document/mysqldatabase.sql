 /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';
CREATE USER spy@'%' IDENTIFIED BY 'spy';
SET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');
SET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');
GRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';
GRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/

Create Database If Not Exists likevery;
USE likevery;

/**************表名：user  表描述:后台用户表  字段数量:10    生成时间:2015/3/19 16:16:06***********/
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



/**************表名：cvupload  表描述:简历上传表  字段数量:16    生成时间:2015/3/19 16:16:06***********/
drop table if exists cvupload;
CREATE TABLE cvupload( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,path varchar(200) NOT NULL comment '简历路径'
,filename varchar(200) NOT NULL comment '简历名称'
,status varchar(2) NOT NULL Default '00' comment '简历审核状态'
,createdate datetime comment '创建日期'
,isassigned varchar(2) Default '0' comment '是否被分配'
,assignerid int(10) comment '分配人id'
,assignername varchar(200) comment '分配人姓名'
,assigndate datetime comment '分配日期'
,operatorid int(10) comment '操作人id'
,operatorname varchar(200) comment '操作人姓名'
,operadate datetime comment '操作日期'
,cname varchar(20) comment '求职者姓名'
,mobilephone varchar(20) comment '求职者手机'
,email varchar(50) comment '求职者邮箱'
,jobtype varchar(2) NOT NULL comment '求职意向'
) ;



/**************表名：role  表描述:角色表  字段数量:6    生成时间:2015/3/19 16:16:06***********/
drop table if exists role;
CREATE TABLE role( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,rolename varchar(50) NOT NULL comment '角色名'
,isadmin varchar(2) NOT NULL Default '0' comment '是否超级管理员分组'
,rights varchar(10) NOT NULL Default '0000000000' comment '角色权限'
,status varchar(2) NOT NULL Default '01' comment '角色状态'
,memo varchar(255) comment '备注'
) ;



/**************表名：manager  表描述:求职者表  字段数量:36    生成时间:2015/3/19 16:16:06***********/
drop table if exists manager;
CREATE TABLE manager( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '主键id'
,jobtype int(5) NOT NULL Default 4 comment '求职者职位类型'
,cname varchar(50) NOT NULL comment '求职者姓名'
,ename varchar(50) comment '英文名'
,email varchar(50) comment '求职者邮箱'
,mobilephone varchar(20) comment '手机'
,tel varchar(20) comment '座机'
,gender varchar(2) comment '性别'
,brithday date comment '生日'
,homepage varchar(100) comment '个人主页'
,targetposition varchar(100) comment '期望职位'
,getjobtime varchar(100) comment '到岗时间'
,area varchar(100) comment '用户居住城市'
,targetarea varchar(100) comment '用户目标城市'
,edulevel int(5) comment '学历'
,workyear int(5) comment '工作年限'
,salary int(5) comment '当前年薪'
,targetsalary int(5) comment '目标年薪'
,tag varchar(500) comment '标签'
,selfintroduce text comment '自我评价'
,memo text comment '备注信息'
,createdate date comment '创建日期'
,updatedate date comment '更新日期'
,cvid int comment '简历id'
,refuseemail int(1) comment '拒绝接受邮件'
,status varchar(2) comment '简历状态'
,question1 text comment '问题1'
,answear1 text comment '回答1'
,question2 text comment '问题2'
,answear2 text comment '回答2'
,question3 text comment '问题3'
,answear3 text comment '回答3'
,question4 text comment '问题4'
,answear4 text comment '回答4'
,question5 text comment '问题5'
,answear5 text comment '回答5'
) ;



Insert into user(id,username,password,roleid,issys,email,createdate,status,memo) values ( '1','admin','86f3059b228c8acf99e69734b6bb32cc','1','0','albafica.wang@51job.com',null,'01',null) ;



Insert into role(id,rolename,isadmin,rights,status,memo) values ( '1','超级管理员','1','0000000000','01','超级管理员分组') ;



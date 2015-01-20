Drop database if exists SpyNet;
Create database SpyNet;
USE SpyNet;

/**************表结构：Users  字段数量:14    生成时间:2013-8-23 17:05:00***********/
drop table if exists Users;
CREATE TABLE Users( 
UserID int NOT NULL PRIMARY KEY comment '用户ID'
,Username varchar(50) comment '用户名'
,Password varchar(32) comment '密码'
,Email varchar(80) comment '邮件'
,EmailStatus char(1) Default '0' comment '邮件验证状态'
,Type tinyint comment '类型'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,IsLock tinyint comment '是否锁定'
,LastLoginTime datetime comment '最后登陆时间'
,FailCount int Default 0 comment '登陆错误次数'
,LockTime datetime comment '锁定时间'
,Status char(2) Default '01' comment '状态'
,IPAddress varchar(50) Default '' comment '上次登录的IP地址'
) ;



/**************表结构：Spy  字段数量:32    生成时间:2013-8-23 17:05:00***********/
drop table if exists Spy;
CREATE TABLE Spy( 
SpyID int NOT NULL PRIMARY KEY comment '猎头ID'
,Cname varchar(20) comment '中文名'
,EFirstName varchar(50) comment '英文名'
,Ename varchar(50) comment '英文姓'
,NickName varchar(50) comment '昵称'
,Sex char(1) comment '性别'
,IDTYPE char(1) comment '证件类型'
,IDCard varchar(25) comment '身份证'
,MobilePhone varchar(20) comment '手机'
,CreateDate datetime comment '创建日期'
,UpdateDate datetime comment '更新日期'
,Status char(2) Default '01' comment '状态'
,BIRTHDAY date comment '生日'
,HOMEPAGE varchar(200) comment '主页'
,COUNTRY varchar(3) Default '001' comment '国家'
,CADDRESS varchar(150) comment '中文地址'
,EADDRESS varchar(150) comment '英文地址'
,ZIPCODE varchar(10) comment '邮编'
,HOMEPHONE varchar(40) comment '家庭电话'
,AREA varchar(6) comment '所在地区'
,WorkYear varchar(1) comment '工作年限'
,CSELFINTRO varchar(1000) comment '中文简介'
,ESELFINTRO varchar(1000) comment '英文简介'
,WORKINDUSTRY varchar(2) comment '行业'
,WORKFUNC varchar(4) comment '职能'
,CCompName varchar(100) comment '公司'
,Cdepartment varchar(100) comment '部门'
,Cposition varchar(100) comment '职位'
,PreferPos varchar(30) comment '擅长职位'
,PreferIndustry varchar(15) comment '擅长行业'
,ServerCompany varchar(500) comment '合作企业'
,AuthStatus varchar(6) Default '000000' comment '认证状态'
) ;



/**************表结构：ShowCase  字段数量:8    生成时间:2013-8-23 17:05:00***********/
drop table if exists ShowCase;
CREATE TABLE ShowCase( 
ShowID int NOT NULL PRIMARY KEY comment '成功案例ID'
,SpyID int comment '猎头ID'
,CoID int comment '公司ID'
,CaseID int comment '案例ID'
,Memo varchar(2000) comment '描述'
,CreateDate datetime comment '创建日期'
,UpdateDate datetime comment '更新日期'
,Status char(2) comment '状态'
) ;



/**************表结构：Cases  字段数量:17    生成时间:2013-8-23 17:05:00***********/
drop table if exists Cases;
CREATE TABLE Cases( 
CaseID int NOT NULL PRIMARY KEY comment '案例ID'
,CaseType tinyint comment 'Case类型'
,SpyID int comment '猎头ID'
,CoID int comment '公司ID'
,HRID int comment 'HR的ID'
,CJobName varchar(100) comment '职位名称'
,SalaryFrom varchar(2) comment '最低薪资'
,SalaryTo varchar(2) comment '最高薪资'
,industrytype varchar(2) comment '行业'
,DivName varchar(200) comment '部门名称'
,Area varchar(6) comment '工作地点'
,IssueDate datetime comment '发布日期'
,ValidDate datetime comment '结束日期'
,CaseInfo text comment '描述'
,CreateDate datetime comment '创建日期'
,UpdateDate datetime comment '更新日期'
,Status char(2) Default '00' comment '状态'
) ;



/**************表结构：Inbox  字段数量:12    生成时间:2013-8-23 17:05:00***********/
drop table if exists Inbox;
CREATE TABLE Inbox( 
InboxID int NOT NULL PRIMARY KEY comment '案例ID'
,InboxType tinyint comment '类型'
,SpyID int comment '猎头ID'
,UserID int comment '经理人ID'
,CoID int comment '公司ID'
,HRID int comment 'HR的ID'
,JobID int comment '职位'
,InboxInfo varchar(2000) comment '信息'
,AttachID varchar(255) comment '附件ID'
,CreateDate datetime comment '创建日期'
,UpdateDate datetime comment '更新日期'
,Status char(2) Default '00' comment '状态'
) ;



/**************表结构：ViewSpy  字段数量:4    生成时间:2013-8-23 17:05:00***********/
drop table if exists ViewSpy;
CREATE TABLE ViewSpy( 
ViewSpyID int NOT NULL PRIMARY KEY comment '查看猎头ID'
,SpyID int comment '猎头ID'
,UserID int comment '经理人ID'
,ViewDate datetime comment '查看日期'
) ;



/**************表结构：ListBuy  字段数量:4    生成时间:2013-8-23 17:05:00***********/
drop table if exists ListBuy;
CREATE TABLE ListBuy( 
ListBuyID int NOT NULL PRIMARY KEY comment 'ListBuyID'
,SpyID int comment '猎头ID'
,ListID int comment 'ListID'
,BuyDate datetime comment '购买日期'
) ;



/**************表结构：ListComment  字段数量:6    生成时间:2013-8-23 17:05:00***********/
drop table if exists ListComment;
CREATE TABLE ListComment( 
CommentID int NOT NULL PRIMARY KEY comment '评论ID'
,SpyID int comment '猎头ID'
,ListID int comment 'ListID'
,CommentDate datetime comment '评论日期'
,Comment varchar(512) comment '评论内容'
,CommentType tinyint comment '评论类型'
) ;



/**************表结构：eAttachs  字段数量:8    生成时间:2013-8-23 17:05:00***********/
drop table if exists eAttachs;
CREATE TABLE eAttachs( 
AttachID int NOT NULL PRIMARY KEY comment '附件ID'
,FileType varchar(10) Default '' comment '文件类型'
,FileName varchar(255) Default '' comment '文件名称'
,FileSize float Default 0 comment '文件大小'
,Contents text comment '文件内容'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Operator varchar(50) Default '' comment '操作员'
) ;



/**************表结构：Role  字段数量:9    生成时间:2013-8-23 17:05:00***********/
drop table if exists Role;
CREATE TABLE Role( 
RoleID int NOT NULL PRIMARY KEY comment '角色ID'
,Cname varchar(50) Default '' comment '中文名'
,Ename varchar(50) Default '' comment '英文名'
,IsAdmin int Default 0 comment '是否系统管理员'
,Memo varchar(200) comment '备注'
,Status char(2) NOT NULL Default '01' comment '状态'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Operator varchar(50) Default '' comment '操作员ID'
) ;



/**************表结构：HRSession  字段数量:5    生成时间:2013-8-23 17:05:00***********/
drop table if exists HRSession;
CREATE TABLE HRSession( 
ID int NOT NULL PRIMARY KEY comment '日志ID'
,UserID int NOT NULL comment '会员'
,LoginTime datetime comment '登录时间'
,ExpireTime datetime comment '过期时间'
,IPAddress varchar(20) comment '登陆地址'
) ;



/**************表结构：OprLog  字段数量:6    生成时间:2013-8-23 17:05:00***********/
drop table if exists OprLog;
CREATE TABLE OprLog( 
ID int NOT NULL PRIMARY KEY comment '日志ID'
,UserID int NOT NULL comment '会员用户ID'
,OprTime datetime Default NULL comment '操作时间'
,Operation varchar(4) Default '' comment '操作'
,ObjID varchar(50) Default '' comment '操作对象'
,Description varchar(500) Default '' comment '操作描述'
) ;



/**************表结构：Operation  字段数量:3    生成时间:2013-8-23 17:05:00***********/
drop table if exists Operation;
CREATE TABLE Operation( 
Code varchar(4) NOT NULL PRIMARY KEY Default '' comment '日志ID'
,Cvalue varchar(50) Default '' comment '操作中文名'
,Evalue varchar(50) Default '' comment '操作英文名'
) ;



/**************表结构：Policy  字段数量:10    生成时间:2013-8-23 17:05:00***********/
drop table if exists Policy;
CREATE TABLE Policy( 
PolicyID int NOT NULL PRIMARY KEY comment '接口ID'
,UserID int comment '会员ID'
,MinPassword int Default 0 comment '密码最小长度'
,PasswordFormat int Default 0 comment '密码是否有数字字母'
,ChangeDays int Default 0 comment '密码定期更改天数'
,RepeatTimes int Default 1 comment '不允许重复密码的次数'
,InvalidationTimes int Default 0 comment '帐号锁定登录次数过多'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Operator varchar(50) Default '' comment '操作员ID'
) ;


Insert into ShowCase(ShowID,SpyID,CoID,CaseID,Memo,CreateDate,UpdateDate,Status) values ( '1','1','1','1','的的',null,null,'21') ;
Insert into ShowCase(ShowID,SpyID,CoID,CaseID,Memo,CreateDate,UpdateDate,Status) values ( '2','2','2','2','让人','333','33','34') ;


Drop database if exists AB;
Create database AB;
USE AB;

/**************表结构：List  字段数量:18    生成时间:2013-8-23 17:05:00***********/
drop table if exists List;
CREATE TABLE List( 
ListID int NOT NULL PRIMARY KEY comment 'ListID'
,SpyID int comment '猎头ID'
,Title varchar(50) comment '标题'
,ListInfo varchar(1000) comment '描述'
,Industry varchar(100) comment '行业'
,FromYear int comment '开始年份'
,ToYear int comment '结束年份'
,SizeType varchar(1) comment '简历数量'
,MobileFinish varchar(1) comment '手机完整度'
,EmailFinish varchar(1) comment 'Email完整度'
,CityFinish varchar(1) comment '地区完整度'
,Price int comment '价格'
,ViewCount int comment '查看次数'
,BuyCount int comment '购买次数'
,BlackCount int comment '投诉次数'
,CreateDate datetime comment '创建日期'
,UpdateDate datetime comment '更新日期'
,Status char(2) comment '状态'
) ;


Drop database if exists Aab;
Create database Aab;
USE Aab;

/**************表结构：Resume  字段数量:22    生成时间:2013-8-23 17:05:00***********/
drop table if exists Resume;
CREATE TABLE Resume( 
ResumeID int NOT NULL PRIMARY KEY comment '简历ID'
,UserID int comment '用户ID'
,Cname varchar(20) Default '' comment '中文名称'
,Ename varchar(20) Default '' comment '英文名称'
,Status char(2) Default '01' comment '状态'
,Gender varchar(20) comment '性别'
,Marriage varchar(10) comment '婚姻状况'
,IDCard varchar(50) Default '' comment '身份证'
,Birthday datetime comment '生日'
,Party varchar(50) comment '政治面貌'
,HuKou varchar(50) comment '户口'
,Area varchar(50) comment '籍贯'
,City varchar(50) Default '' comment '所在城市'
,School varchar(100) Default '' comment '学校'
,Degree varchar(20) comment '学历'
,Major varchar(50) Default '' comment '专业'
,GradDate datetime comment '毕业日期'
,Address varchar(255) Default '' comment '地址'
,ZipCode varchar(6) Default '' comment '邮政编码'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Photo varchar(255) Default '' comment '照片'
) ;



/**************表结构：DBConf  字段数量:16    生成时间:2013-8-23 17:05:00***********/
drop table if exists DBConf;
CREATE TABLE DBConf( 
DBID int NOT NULL PRIMARY KEY comment '数据库ID'
,DBName varchar(100) Default '' comment '显示名称'
,DBServer varchar(100) Default '' comment '数据库服务器地址'
,ServerName varchar(100) comment '服务器地址'
,InstanceName varchar(50) comment '数据库名称'
,ScaleType varchar(2) comment '数据库大小'
,DBType int Default 1 comment '数据库类型'
,MaxCtm int Default 0 comment '最大客户数'
,CurCtm int Default 0 comment '当前用户数'
,Status char(2) Default '01' comment '状态'
,ListIndex int Default 0 comment '排列顺序'
,IsShare int Default 1 comment '是否共享'
,Memo varchar(500) Default '' comment '备注'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Operator varchar(50) Default '' comment '操作员'
) ;


Drop database if exists AAb;
Create database AAb;
USE AAb;

/**************表结构：DD_Table  字段数量:6    生成时间:2013-8-23 17:05:00***********/
drop table if exists DD_Table;
CREATE TABLE DD_Table( 
ID int NOT NULL PRIMARY KEY comment '组织ID'
,Code varchar(50) NOT NULL Default '' comment '编码'
,Cname varchar(100) NOT NULL Default '' comment '中文名称'
,Ename varchar(100) Default '' comment '英文名称'
,DD_TableName varchar(50) NOT NULL Default '' comment '表名'
,Status char(2) NOT NULL Default 01 comment '状态'
) ;


Drop database if exists Ehire;
Create database Ehire;
USE Ehire;

/**************表结构：Operator  字段数量:19    生成时间:2013-8-23 17:05:00***********/
drop table if exists Operator;
CREATE TABLE Operator( 
OprID int NOT NULL PRIMARY KEY comment '用户ID'
,RoleID int comment '角色'
,Cname varchar(50) Default '' comment '中文名'
,Ename varchar(50) Default '' comment '英文名'
,Email varchar(100) comment '邮件'
,Tel varchar(50) comment '电话'
,Mobile varchar(30) comment '手机'
,UserName varchar(50) comment '登录名'
,ExpireDate datetime comment '过期日期'
,Password varchar(50) comment '密码'
,LastLoginDate datetime comment '最后登陆日期'
,FailTimes int Default 0 comment '登陆失败次数'
,IsLock int Default 0 comment '是否锁定帐号'
,Status char(2) NOT NULL Default '01' comment '状态'
,CreateDate datetime comment '生成日期'
,UpdateDate datetime comment '更新日期'
,Operator varchar(50) Default '' comment '操作员ID'
,Memo varchar(400) comment '备注'
,IPAddress varchar(50) Default '' comment '上次登录的IP地址'
) ;


Insert into Operator(OprID,RoleID,Cname,Ename,Email,Tel,Mobile,UserName,Password,LastLoginDate,FailTimes,IsLock,Status,CreateDate,UpdateDate,Operator,Memo,IPAddress) values ( '1','1','admin','admin',null,'61601888','1331234556','admin','123456',null,'0','0','01',null,null,null,null,null) ;



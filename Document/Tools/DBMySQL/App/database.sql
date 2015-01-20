Drop database if exists SpyNet;
Create database SpyNet;
USE SpyNet;

/**************��ṹ��Users  �ֶ�����:14    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Users;
CREATE TABLE Users( 
UserID int NOT NULL PRIMARY KEY comment '�û�ID'
,Username varchar(50) comment '�û���'
,Password varchar(32) comment '����'
,Email varchar(80) comment '�ʼ�'
,EmailStatus char(1) Default '0' comment '�ʼ���֤״̬'
,Type tinyint comment '����'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,IsLock tinyint comment '�Ƿ�����'
,LastLoginTime datetime comment '����½ʱ��'
,FailCount int Default 0 comment '��½�������'
,LockTime datetime comment '����ʱ��'
,Status char(2) Default '01' comment '״̬'
,IPAddress varchar(50) Default '' comment '�ϴε�¼��IP��ַ'
) ;



/**************��ṹ��Spy  �ֶ�����:32    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Spy;
CREATE TABLE Spy( 
SpyID int NOT NULL PRIMARY KEY comment '��ͷID'
,Cname varchar(20) comment '������'
,EFirstName varchar(50) comment 'Ӣ����'
,Ename varchar(50) comment 'Ӣ����'
,NickName varchar(50) comment '�ǳ�'
,Sex char(1) comment '�Ա�'
,IDTYPE char(1) comment '֤������'
,IDCard varchar(25) comment '���֤'
,MobilePhone varchar(20) comment '�ֻ�'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Status char(2) Default '01' comment '״̬'
,BIRTHDAY date comment '����'
,HOMEPAGE varchar(200) comment '��ҳ'
,COUNTRY varchar(3) Default '001' comment '����'
,CADDRESS varchar(150) comment '���ĵ�ַ'
,EADDRESS varchar(150) comment 'Ӣ�ĵ�ַ'
,ZIPCODE varchar(10) comment '�ʱ�'
,HOMEPHONE varchar(40) comment '��ͥ�绰'
,AREA varchar(6) comment '���ڵ���'
,WorkYear varchar(1) comment '��������'
,CSELFINTRO varchar(1000) comment '���ļ��'
,ESELFINTRO varchar(1000) comment 'Ӣ�ļ��'
,WORKINDUSTRY varchar(2) comment '��ҵ'
,WORKFUNC varchar(4) comment 'ְ��'
,CCompName varchar(100) comment '��˾'
,Cdepartment varchar(100) comment '����'
,Cposition varchar(100) comment 'ְλ'
,PreferPos varchar(30) comment '�ó�ְλ'
,PreferIndustry varchar(15) comment '�ó���ҵ'
,ServerCompany varchar(500) comment '������ҵ'
,AuthStatus varchar(6) Default '000000' comment '��֤״̬'
) ;



/**************��ṹ��ShowCase  �ֶ�����:8    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists ShowCase;
CREATE TABLE ShowCase( 
ShowID int NOT NULL PRIMARY KEY comment '�ɹ�����ID'
,SpyID int comment '��ͷID'
,CoID int comment '��˾ID'
,CaseID int comment '����ID'
,Memo varchar(2000) comment '����'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Status char(2) comment '״̬'
) ;



/**************��ṹ��Cases  �ֶ�����:17    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Cases;
CREATE TABLE Cases( 
CaseID int NOT NULL PRIMARY KEY comment '����ID'
,CaseType tinyint comment 'Case����'
,SpyID int comment '��ͷID'
,CoID int comment '��˾ID'
,HRID int comment 'HR��ID'
,CJobName varchar(100) comment 'ְλ����'
,SalaryFrom varchar(2) comment '���н��'
,SalaryTo varchar(2) comment '���н��'
,industrytype varchar(2) comment '��ҵ'
,DivName varchar(200) comment '��������'
,Area varchar(6) comment '�����ص�'
,IssueDate datetime comment '��������'
,ValidDate datetime comment '��������'
,CaseInfo text comment '����'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Status char(2) Default '00' comment '״̬'
) ;



/**************��ṹ��Inbox  �ֶ�����:12    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Inbox;
CREATE TABLE Inbox( 
InboxID int NOT NULL PRIMARY KEY comment '����ID'
,InboxType tinyint comment '����'
,SpyID int comment '��ͷID'
,UserID int comment '������ID'
,CoID int comment '��˾ID'
,HRID int comment 'HR��ID'
,JobID int comment 'ְλ'
,InboxInfo varchar(2000) comment '��Ϣ'
,AttachID varchar(255) comment '����ID'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Status char(2) Default '00' comment '״̬'
) ;



/**************��ṹ��ViewSpy  �ֶ�����:4    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists ViewSpy;
CREATE TABLE ViewSpy( 
ViewSpyID int NOT NULL PRIMARY KEY comment '�鿴��ͷID'
,SpyID int comment '��ͷID'
,UserID int comment '������ID'
,ViewDate datetime comment '�鿴����'
) ;



/**************��ṹ��ListBuy  �ֶ�����:4    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists ListBuy;
CREATE TABLE ListBuy( 
ListBuyID int NOT NULL PRIMARY KEY comment 'ListBuyID'
,SpyID int comment '��ͷID'
,ListID int comment 'ListID'
,BuyDate datetime comment '��������'
) ;



/**************��ṹ��ListComment  �ֶ�����:6    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists ListComment;
CREATE TABLE ListComment( 
CommentID int NOT NULL PRIMARY KEY comment '����ID'
,SpyID int comment '��ͷID'
,ListID int comment 'ListID'
,CommentDate datetime comment '��������'
,Comment varchar(512) comment '��������'
,CommentType tinyint comment '��������'
) ;



/**************��ṹ��eAttachs  �ֶ�����:8    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists eAttachs;
CREATE TABLE eAttachs( 
AttachID int NOT NULL PRIMARY KEY comment '����ID'
,FileType varchar(10) Default '' comment '�ļ�����'
,FileName varchar(255) Default '' comment '�ļ�����'
,FileSize float Default 0 comment '�ļ���С'
,Contents text comment '�ļ�����'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Operator varchar(50) Default '' comment '����Ա'
) ;



/**************��ṹ��Role  �ֶ�����:9    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Role;
CREATE TABLE Role( 
RoleID int NOT NULL PRIMARY KEY comment '��ɫID'
,Cname varchar(50) Default '' comment '������'
,Ename varchar(50) Default '' comment 'Ӣ����'
,IsAdmin int Default 0 comment '�Ƿ�ϵͳ����Ա'
,Memo varchar(200) comment '��ע'
,Status char(2) NOT NULL Default '01' comment '״̬'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Operator varchar(50) Default '' comment '����ԱID'
) ;



/**************��ṹ��HRSession  �ֶ�����:5    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists HRSession;
CREATE TABLE HRSession( 
ID int NOT NULL PRIMARY KEY comment '��־ID'
,UserID int NOT NULL comment '��Ա'
,LoginTime datetime comment '��¼ʱ��'
,ExpireTime datetime comment '����ʱ��'
,IPAddress varchar(20) comment '��½��ַ'
) ;



/**************��ṹ��OprLog  �ֶ�����:6    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists OprLog;
CREATE TABLE OprLog( 
ID int NOT NULL PRIMARY KEY comment '��־ID'
,UserID int NOT NULL comment '��Ա�û�ID'
,OprTime datetime Default NULL comment '����ʱ��'
,Operation varchar(4) Default '' comment '����'
,ObjID varchar(50) Default '' comment '��������'
,Description varchar(500) Default '' comment '��������'
) ;



/**************��ṹ��Operation  �ֶ�����:3    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Operation;
CREATE TABLE Operation( 
Code varchar(4) NOT NULL PRIMARY KEY Default '' comment '��־ID'
,Cvalue varchar(50) Default '' comment '����������'
,Evalue varchar(50) Default '' comment '����Ӣ����'
) ;



/**************��ṹ��Policy  �ֶ�����:10    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Policy;
CREATE TABLE Policy( 
PolicyID int NOT NULL PRIMARY KEY comment '�ӿ�ID'
,UserID int comment '��ԱID'
,MinPassword int Default 0 comment '������С����'
,PasswordFormat int Default 0 comment '�����Ƿ���������ĸ'
,ChangeDays int Default 0 comment '���붨�ڸ�������'
,RepeatTimes int Default 1 comment '�������ظ�����Ĵ���'
,InvalidationTimes int Default 0 comment '�ʺ�������¼��������'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Operator varchar(50) Default '' comment '����ԱID'
) ;


Insert into ShowCase(ShowID,SpyID,CoID,CaseID,Memo,CreateDate,UpdateDate,Status) values ( '1','1','1','1','�ĵ�',null,null,'21') ;
Insert into ShowCase(ShowID,SpyID,CoID,CaseID,Memo,CreateDate,UpdateDate,Status) values ( '2','2','2','2','����','333','33','34') ;


Drop database if exists AB;
Create database AB;
USE AB;

/**************��ṹ��List  �ֶ�����:18    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists List;
CREATE TABLE List( 
ListID int NOT NULL PRIMARY KEY comment 'ListID'
,SpyID int comment '��ͷID'
,Title varchar(50) comment '����'
,ListInfo varchar(1000) comment '����'
,Industry varchar(100) comment '��ҵ'
,FromYear int comment '��ʼ���'
,ToYear int comment '�������'
,SizeType varchar(1) comment '��������'
,MobileFinish varchar(1) comment '�ֻ�������'
,EmailFinish varchar(1) comment 'Email������'
,CityFinish varchar(1) comment '����������'
,Price int comment '�۸�'
,ViewCount int comment '�鿴����'
,BuyCount int comment '�������'
,BlackCount int comment 'Ͷ�ߴ���'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Status char(2) comment '״̬'
) ;


Drop database if exists Aab;
Create database Aab;
USE Aab;

/**************��ṹ��Resume  �ֶ�����:22    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Resume;
CREATE TABLE Resume( 
ResumeID int NOT NULL PRIMARY KEY comment '����ID'
,UserID int comment '�û�ID'
,Cname varchar(20) Default '' comment '��������'
,Ename varchar(20) Default '' comment 'Ӣ������'
,Status char(2) Default '01' comment '״̬'
,Gender varchar(20) comment '�Ա�'
,Marriage varchar(10) comment '����״��'
,IDCard varchar(50) Default '' comment '���֤'
,Birthday datetime comment '����'
,Party varchar(50) comment '������ò'
,HuKou varchar(50) comment '����'
,Area varchar(50) comment '����'
,City varchar(50) Default '' comment '���ڳ���'
,School varchar(100) Default '' comment 'ѧУ'
,Degree varchar(20) comment 'ѧ��'
,Major varchar(50) Default '' comment 'רҵ'
,GradDate datetime comment '��ҵ����'
,Address varchar(255) Default '' comment '��ַ'
,ZipCode varchar(6) Default '' comment '��������'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Photo varchar(255) Default '' comment '��Ƭ'
) ;



/**************��ṹ��DBConf  �ֶ�����:16    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists DBConf;
CREATE TABLE DBConf( 
DBID int NOT NULL PRIMARY KEY comment '���ݿ�ID'
,DBName varchar(100) Default '' comment '��ʾ����'
,DBServer varchar(100) Default '' comment '���ݿ��������ַ'
,ServerName varchar(100) comment '��������ַ'
,InstanceName varchar(50) comment '���ݿ�����'
,ScaleType varchar(2) comment '���ݿ��С'
,DBType int Default 1 comment '���ݿ�����'
,MaxCtm int Default 0 comment '���ͻ���'
,CurCtm int Default 0 comment '��ǰ�û���'
,Status char(2) Default '01' comment '״̬'
,ListIndex int Default 0 comment '����˳��'
,IsShare int Default 1 comment '�Ƿ���'
,Memo varchar(500) Default '' comment '��ע'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Operator varchar(50) Default '' comment '����Ա'
) ;


Drop database if exists AAb;
Create database AAb;
USE AAb;

/**************��ṹ��DD_Table  �ֶ�����:6    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists DD_Table;
CREATE TABLE DD_Table( 
ID int NOT NULL PRIMARY KEY comment '��֯ID'
,Code varchar(50) NOT NULL Default '' comment '����'
,Cname varchar(100) NOT NULL Default '' comment '��������'
,Ename varchar(100) Default '' comment 'Ӣ������'
,DD_TableName varchar(50) NOT NULL Default '' comment '����'
,Status char(2) NOT NULL Default 01 comment '״̬'
) ;


Drop database if exists Ehire;
Create database Ehire;
USE Ehire;

/**************��ṹ��Operator  �ֶ�����:19    ����ʱ��:2013-8-23 17:05:00***********/
drop table if exists Operator;
CREATE TABLE Operator( 
OprID int NOT NULL PRIMARY KEY comment '�û�ID'
,RoleID int comment '��ɫ'
,Cname varchar(50) Default '' comment '������'
,Ename varchar(50) Default '' comment 'Ӣ����'
,Email varchar(100) comment '�ʼ�'
,Tel varchar(50) comment '�绰'
,Mobile varchar(30) comment '�ֻ�'
,UserName varchar(50) comment '��¼��'
,ExpireDate datetime comment '��������'
,Password varchar(50) comment '����'
,LastLoginDate datetime comment '����½����'
,FailTimes int Default 0 comment '��½ʧ�ܴ���'
,IsLock int Default 0 comment '�Ƿ������ʺ�'
,Status char(2) NOT NULL Default '01' comment '״̬'
,CreateDate datetime comment '��������'
,UpdateDate datetime comment '��������'
,Operator varchar(50) Default '' comment '����ԱID'
,Memo varchar(400) comment '��ע'
,IPAddress varchar(50) Default '' comment '�ϴε�¼��IP��ַ'
) ;


Insert into Operator(OprID,RoleID,Cname,Ename,Email,Tel,Mobile,UserName,Password,LastLoginDate,FailTimes,IsLock,Status,CreateDate,UpdateDate,Operator,Memo,IPAddress) values ( '1','1','admin','admin',null,'61601888','1331234556','admin','123456',null,'0','0','01',null,null,null,null,null) ;



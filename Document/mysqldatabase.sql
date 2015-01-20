 /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';
CREATE USER spy@'%' IDENTIFIED BY 'spy';
SET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');
SET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');
GRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';
GRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/

Create Database If Not Exists likevery;
USE likevery;

/**************������user  ������:��̨�û���  �ֶ�����:7    ����ʱ��:2015/1/20 16:41:20***********/
drop table if exists user;
CREATE TABLE user( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,username varchar(20) NOT NULL comment '��¼��'
,password varchar(50) NOT NULL comment '��½����'
,cname varchar(50) NOT NULL comment '����'
,email varchar(100) NOT NULL comment '����'
,createdate datetime comment '��������'
,status varchar(2) NOT NULL Default 01 comment '״̬'
) ;



/**************������cvupload  ������:�����ϴ���  �ֶ�����:11    ����ʱ��:2015/1/20 16:41:20***********/
drop table if exists cvupload;
CREATE TABLE cvupload( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,path varchar(200) NOT NULL comment '����·��'
,filename varchar(200) NOT NULL comment '��������'
,status varchar(2) NOT NULL Default 00 comment '�������״̬'
,createdate datetime comment '��������'
,assignerid int(10) comment '������id'
,assignername varchar(200) comment '����������'
,assigndate datetime comment '��������'
,operatorid int(10) comment '������id'
,operatorname varchar(200) comment '����������'
,operadate datetime comment '��������'
) ;



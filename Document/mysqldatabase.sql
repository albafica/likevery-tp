 /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';
CREATE USER spy@'%' IDENTIFIED BY 'spy';
SET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');
SET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');
GRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';
GRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/

Create Database If Not Exists likevery;
USE likevery;

/**************������user  ������:��̨�û���  �ֶ�����:10    ����ʱ��:2015/1/27 17:12:03***********/
drop table if exists user;
CREATE TABLE user( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,username varchar(20) NOT NULL comment '��¼��'
,password varchar(50) NOT NULL comment '��½����'
,roleid int(4) NOT NULL comment '��ɫid'
,cname varchar(50) NOT NULL comment '����'
,issys varchar(2) NOT NULL Default '0' comment '�Ƿ�ϵͳ�˺�'
,email varchar(100) NOT NULL comment '����'
,createdate datetime comment '��������'
,status varchar(2) NOT NULL Default '01' comment '״̬'
,memo varchar(255) comment '��ע'
) ;



/**************������cvupload  ������:�����ϴ���  �ֶ�����:11    ����ʱ��:2015/1/27 17:12:03***********/
drop table if exists cvupload;
CREATE TABLE cvupload( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,path varchar(200) NOT NULL comment '����·��'
,filename varchar(200) NOT NULL comment '��������'
,status varchar(2) NOT NULL Default '00' comment '�������״̬'
,createdate datetime comment '��������'
,assignerid int(10) comment '������id'
,assignername varchar(200) comment '����������'
,assigndate datetime comment '��������'
,operatorid int(10) comment '������id'
,operatorname varchar(200) comment '����������'
,operadate datetime comment '��������'
) ;



/**************������role  ������:��ɫ��  �ֶ�����:6    ����ʱ��:2015/1/27 17:12:03***********/
drop table if exists role;
CREATE TABLE role( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,rolename varchar(50) NOT NULL comment '��ɫ��'
,isadmin varchar(2) NOT NULL Default '0' comment '�Ƿ񳬼�����Ա����'
,rights varchar(10) NOT NULL Default '0000000000' comment '��ɫȨ��'
,status varchar(2) NOT NULL Default '01' comment '��ɫ״̬'
,memo varchar(255) comment '��ע'
) ;



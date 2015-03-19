 /* CREATE USER spy@'localhost' IDENTIFIED BY 'spy';
CREATE USER spy@'%' IDENTIFIED BY 'spy';
SET PASSWORD FOR 'spy'@'localhost' = PASSWORD('spy');
SET PASSWORD FOR 'spy'@'%' = PASSWORD('spy');
GRANT ALL PRIVILEGES ON spy.* TO spy@'localhost';
GRANT ALL PRIVILEGES ON spy.* TO spy@'%';*/

Create Database If Not Exists likevery;
USE likevery;

/**************������user  ������:��̨�û���  �ֶ�����:10    ����ʱ��:2015/3/19 16:16:06***********/
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



/**************������cvupload  ������:�����ϴ���  �ֶ�����:16    ����ʱ��:2015/3/19 16:16:06***********/
drop table if exists cvupload;
CREATE TABLE cvupload( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,path varchar(200) NOT NULL comment '����·��'
,filename varchar(200) NOT NULL comment '��������'
,status varchar(2) NOT NULL Default '00' comment '�������״̬'
,createdate datetime comment '��������'
,isassigned varchar(2) Default '0' comment '�Ƿ񱻷���'
,assignerid int(10) comment '������id'
,assignername varchar(200) comment '����������'
,assigndate datetime comment '��������'
,operatorid int(10) comment '������id'
,operatorname varchar(200) comment '����������'
,operadate datetime comment '��������'
,cname varchar(20) comment '��ְ������'
,mobilephone varchar(20) comment '��ְ���ֻ�'
,email varchar(50) comment '��ְ������'
,jobtype varchar(2) NOT NULL comment '��ְ����'
) ;



/**************������role  ������:��ɫ��  �ֶ�����:6    ����ʱ��:2015/3/19 16:16:06***********/
drop table if exists role;
CREATE TABLE role( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,rolename varchar(50) NOT NULL comment '��ɫ��'
,isadmin varchar(2) NOT NULL Default '0' comment '�Ƿ񳬼�����Ա����'
,rights varchar(10) NOT NULL Default '0000000000' comment '��ɫȨ��'
,status varchar(2) NOT NULL Default '01' comment '��ɫ״̬'
,memo varchar(255) comment '��ע'
) ;



/**************������manager  ������:��ְ�߱�  �ֶ�����:36    ����ʱ��:2015/3/19 16:16:06***********/
drop table if exists manager;
CREATE TABLE manager( 
id int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT  comment '����id'
,jobtype int(5) NOT NULL Default 4 comment '��ְ��ְλ����'
,cname varchar(50) NOT NULL comment '��ְ������'
,ename varchar(50) comment 'Ӣ����'
,email varchar(50) comment '��ְ������'
,mobilephone varchar(20) comment '�ֻ�'
,tel varchar(20) comment '����'
,gender varchar(2) comment '�Ա�'
,brithday date comment '����'
,homepage varchar(100) comment '������ҳ'
,targetposition varchar(100) comment '����ְλ'
,getjobtime varchar(100) comment '����ʱ��'
,area varchar(100) comment '�û���ס����'
,targetarea varchar(100) comment '�û�Ŀ�����'
,edulevel int(5) comment 'ѧ��'
,workyear int(5) comment '��������'
,salary int(5) comment '��ǰ��н'
,targetsalary int(5) comment 'Ŀ����н'
,tag varchar(500) comment '��ǩ'
,selfintroduce text comment '��������'
,memo text comment '��ע��Ϣ'
,createdate date comment '��������'
,updatedate date comment '��������'
,cvid int comment '����id'
,refuseemail int(1) comment '�ܾ������ʼ�'
,status varchar(2) comment '����״̬'
,question1 text comment '����1'
,answear1 text comment '�ش�1'
,question2 text comment '����2'
,answear2 text comment '�ش�2'
,question3 text comment '����3'
,answear3 text comment '�ش�3'
,question4 text comment '����4'
,answear4 text comment '�ش�4'
,question5 text comment '����5'
,answear5 text comment '�ش�5'
) ;



Insert into user(id,username,password,roleid,issys,email,createdate,status,memo) values ( '1','admin','86f3059b228c8acf99e69734b6bb32cc','1','0','albafica.wang@51job.com',null,'01',null) ;



Insert into role(id,rolename,isadmin,rights,status,memo) values ( '1','��������Ա','1','0000000000','01','��������Ա����') ;



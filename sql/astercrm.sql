#DROP DATABASE asterisk;

#CREATE DATABASE asterisk;

#GRANT ALL
#  ON asterisk.*
#  TO asteriskuser@localhost
#  IDENTIFIED BY 'asterisk';

#USE asterisk;

DROP TABLE IF EXISTS contact;

CREATE TABLE contact (
  id int(11) NOT NULL auto_increment,
  contact varchar(30) NOT NULL default '',
  gender varchar(10) NOT NULL default 'unknown',	#add 2007-10-5 by solo
  position varchar(100) NOT NULL default '',
  phone varchar(50) NOT NULL default '',
  ext varchar(8) NOT NULL default '',
  phone1 varchar(50) NOT NULL default '',
  ext1 varchar(8) NOT NULL default '',
  phone2 varchar(50) NOT NULL default '',
  ext2 varchar(8) NOT NULL default '',
  mobile varchar(50) NOT NULL default '',
  fax varchar(50) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  creby varchar(50) NOT NULL default '',
  customerid int(11) NOT NULL default '0',
  groupid INT NOT NULL ,
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS customer;

CREATE TABLE customer (
  id int(11) NOT NULL auto_increment,
  customer varchar(120) NOT NULL default '',
  address varchar(200) NOT NULL default '',
  zipcode varchar(10) NOT NULL default '',
  website varchar(100) NOT NULL default '',
  category varchar(20) NOT NULL default '',
  city	varchar(50) NOT NULL default '',	#add 2007-9-30 by solo
  state varchar(50) NOT NULL default '',	#add 2007-9-30 by solo
  phone varchar(50) NOT NULL default '',	#add 2007-9-30 by solo
  fax	varchar(50) NOT NULL default '',	#add 2007-10-24 by solo
  mobile varchar(50) NOT NULL default '',	#add 2007-10-24 by solo
  email varchar(50) NOT NULL default '',	#add 2007-10-24 by solo
  contact varchar(50) NOT NULL default '',	#add 2007-9-30 by solo
  contactgender varchar(10) NOT NULL default 'unknown',	#add 2007-10-5 by solo
  bankname		varchar(100) NOT NULL default '',	#add 2007-10-15 by solo
  bankaccount	varchar(100) NOT NULL default '',	#add 2007-10-15 by solo
  bankzip		varchar(100) NOT NULL default '',	#add 2007-10-26 by solo
  bankaccountname	varchar(100) NOT NULL default '',	#add 2007-10-25 by solo
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  creby varchar(50) NOT NULL default '',
  groupid INT NOT NULL ,
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS events;

CREATE TABLE events (
   id int(10) unsigned NOT NULL auto_increment,
   timestamp datetime NOT NULL default '0000-00-00 00:00:00',
   event LONGTEXT ,
   PRIMARY KEY (`id`)
); 

DROP TABLE IF EXISTS note;

CREATE TABLE note (
  id int(11) NOT NULL auto_increment,
  note text NOT NULL,
  priority int(11) NOT NULL default '0',
  attitude INT NOT NULL DEFAULT '0',	#add 2007-10-26 by solo
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  creby varchar(50) NOT NULL default '',
  customerid int(11) NOT NULL default '0',
  contactid int(11) NOT NULL default '0',
  groupid INT NOT NULL ,
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS account;

CREATE TABLE account (
  id int(11) NOT NULL auto_increment,
  username varchar(30) NOT NULL default '',
  password varchar(30) NOT NULL default '',
  extension varchar(30) NOT NULL default '',
  extensions varchar(200) NOT NULL default '',
  channel	varchar(30) NOT NULL default '',	#add 2007-10-30 by solo
  accountcode	varchar(30) NOT NULL default '',#add 2007-11-12 by solo
  groupid	int NOT NULL default '0',    #add 2007-11-13 by solo
  usertype varchar(20) NOT NULL default '',
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS accountgroup;

CREATE TABLE `accountgroup` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`groupname` VARCHAR( 100 ) NOT NULL ,
`groupid` INT NOT NULL ,
`pdcontext` VARCHAR( 30 ) NOT NULL  ,
`pdextension` VARCHAR( 30 ) NOT NULL  ,
`cretime` datetime NOT NULL default '0000-00-00 00:00:00',
`creby` varchar(50) NOT NULL default '',
UNIQUE (
`groupid` 
)
) ENGINE = MYISAM ;


DROP TABLE IF EXISTS diallist;

#store Predictive dialer phone list
CREATE TABLE diallist (
  id int(11) NOT NULL auto_increment,
  dialnumber varchar(30) NOT NULL default '',
  assign varchar(30) NOT NULL default '',
  groupid INT NOT NULL DEFAULT '0',						#added by solo 2007-12-17
 `campaignid` INT NOT NULL DEFAULT 0,					#added by solo 2008-2-5
  creby	varchar(50) NOT NULL default '',					#added by solo 2008-1-15
  cretime	datetime NOT NULL default '0000-00-00 00:00:00',	#added by solo 2008-1-15
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS dialedlist;

#store dialed number (from diallist table)
CREATE TABLE dialedlist (

  `id` int(11) NOT NULL auto_increment,
  `dialnumber` varchar(30) NOT NULL default '',
  `answertime` datetime NOT NULL default '0000-00-00 00:00:00',	#added by solo 2008-2-1
  `duration` int(11) NOT NULL default '0',						#added by solo 2008-2-1
  `response` varchar(20) NOT NULL default '',					#added by solo 2008-2-1
  `uniqueid` varchar(20) NOT NULL default '',					#added by solo 2008-2-1
  `groupid` INT NOT NULL DEFAULT '0',						#added by solo 2008-2-3
  `campaignid` INT NOT NULL DEFAULT 0,						#added by solo 2008-2-5
  `dialedby` varchar(30) NOT NULL default '',
  `dialedtime` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `id` (`id`)
) ;

DROP TABLE IF EXISTS survey;

#store survey
CREATE TABLE survey (
  id int(11) NOT NULL auto_increment,
  surveyname varchar(50) NOT NULL default '',
  enable int	NOT NULL default '0',	#add 2007-10-15 by solo
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  surveynote varchar(255) NOT NULL, #add 2008-1-11 by solo
  groupid INT NOT NULL DEFAULT '0',		#added by solo 2008-1-15
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS surveyoptions;

#store surveyoptions
CREATE TABLE surveyoptions (
  id int(11) NOT NULL auto_increment,
  surveyoption varchar(50) NOT NULL default '',
  optionnote varchar(255) NOT NULL,	#added by solo 2008-1-14
  surveyid int(11) NOT NULL default '0',
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  creby  varchar(50) NOT NULL default '',
  UNIQUE KEY id (id)
) ;

DROP TABLE IF EXISTS surveyresult;

#store surveyresult
CREATE TABLE surveyresult (
  id int(11) NOT NULL auto_increment,
  customerid int(11) NOT NULL default '0',
  contactid int(11) NOT NULL default '0',
  surveyid  int(11)  NOT NULL default '0',
  surveyoption varchar(50) NOT NULL default '',
  surveynote varchar(255) NOT NULL,
  creby  varchar(50) NOT NULL default '',
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  groupid INT NOT NULL ,
  UNIQUE KEY id (id)
) ;

CREATE TABLE remind (
  id int(11) NOT NULL auto_increment,
  title varchar(100) NOT NULL default '', #����
  content text NOT NULL default '',       #����
  remindtime  datetime NOT NULL default '0000-00-00 00:00:00', #����ʱ��
  remindtype int(10) not null default 0 , #�������0Ϊ�����Լ���1Ϊ��������
  priority int(10) NOT NULL default 0, #�����̶�,5Ϊ��ͨ,10Ϊ���� 
  username varchar(50) not  null default '' , #�û���
  remindabout varchar(255) not  null default '',      #���ѵ��������
  readed  int(10) not null default 0 , #�Ƿ��ȡ��0Ϊδ����1Ϊ�Ѷ�
  touser  varchar(50) not null default '', #����˭
  creby  varchar(50) NOT NULL default '',
  cretime datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY id (id)
) ;

CREATE TABLE `campaign` (	#added by solo 2008-2-5
`id` INT NOT NULL auto_increment,
`groupid` INT NOT NULL DEFAULT 0,
`campaignname` VARCHAR( 60 ) NOT NULL ,
`campaignnote` VARCHAR( 255 ) NOT NULL ,
`cretime` datetime NOT NULL default '0000-00-00 00:00:00',
`creby` varchar(50) NOT NULL default '',
  UNIQUE KEY id (id)
) ENGINE = MYISAM ;


INSERT INTO `account` (
`id` ,
`username` ,
`password` ,
`extension` ,
`extensions` ,
`usertype` 
)
VALUES (
NULL , 'admin', 'admin', '0000', '', 'admin'
);

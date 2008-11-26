############database of astercc0.1-beta update to astercc0.11-beta#############

ALTER TABLE `surveyresult` ADD `surveytitle` VARCHAR( 30 ) NOT NULL AFTER `surveyid` ;
ALTER TABLE `surveyresult` ADD `surveyoptionid` INT NOT NULL AFTER `surveytitle` ;
ALTER TABLE `surveyresult` ADD `itemid` INT NOT NULL AFTER `surveyoption` ;
ALTER TABLE `surveyresult` ADD `itemcontent` VARCHAR( 50 ) NOT NULL AFTER `itemid` ;


## 
## table `surveyoptionitems`
## 
 CREATE TABLE IF NOT EXISTS `surveyoptionitems` (
`id` int(11) NOT NULL AUTO_INCREMENT ,
`optionid` INT NOT NULL ,
`itemtype` ENUM( 'checkbox', 'radio', 'text' ) NOT NULL DEFAULT 'radio',
`itemcontent` VARCHAR( 254 ) NOT NULL ,
`creby` VARCHAR( 30 ) NOT NULL ,
`cretime` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) ,
UNIQUE (`id`)
) ENGINE = MYISAM DEFAULT CHARSET utf8 DEFAULT COLLATE utf8_general_ci;

###############################################################################
alter table queue_agent add `status` varchar(32) not null default '' after `agent_status`;
alter table diallist add `callOrder` int(11) not null default '1';
alter table dialedlist add `callOrder` int(11) not null default '1';
alter table dialedlist change `uniqueid` `uniqueid` varchar(40) not null default '';
alter table monitorrecord change `uniqueid` `uniqueid` varchar(40) not null default '';
alter table`surveyresult` add `uniqueid` varchar(40) not null default '' after `surveynote`;


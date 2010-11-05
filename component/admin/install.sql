CREATE TABLE `#__mstat` (
  `mstat_id` bigint(20) NOT NULL auto_increment,
  `mstat_user` int(11) NOT NULL,
  `mstat_article` int(11) NOT NULL,
  `mstat_cat` int(11) NOT NULL,
  `mstat_session` varchar(60) NOT NULL,
  `mstat_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`mstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
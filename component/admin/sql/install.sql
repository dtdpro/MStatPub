CREATE TABLE IF NOT EXISTS `#__mstat` (
  `mstat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mstat_user` int(11) NOT NULL,
  `mstat_article` int(11) NOT NULL,
  `mstat_cat` int(11) NOT NULL,
  `mstat_session` varchar(60) NOT NULL,
  `mstat_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mstat_ipaddr` varchar(15) NOT NULL,
  PRIMARY KEY (`mstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
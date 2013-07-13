CREATE TABLE `{prefix}_{dirname}_people` (
  `people_id` int(11) unsigned NOT NULL  auto_increment,
  `title` varchar(255) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `posttime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`people_id`)) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `apiconnect` (
 `id` int(6) NOT NULL AUTO_INCREMENT,
 `click` int(200) NOT NULL,
 `impressions` int(100) NOT NULL,
 `conversions` int(25) NOT NULL,
 `geo` varchar(25) NOT NULL,
 `ctr` int(25) NOT NULL,
 `createdtime` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
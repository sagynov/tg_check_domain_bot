-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `ali_domain_commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `command` varchar(200) NOT NULL,
  `action` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `ali_domain_texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `ru` varchar(300) NOT NULL,
  `en` varchar(300) NOT NULL,
  `kz` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `ali_domain_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(300) NOT NULL,
  `lang` varchar(300) NOT NULL,
  `command` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2019-06-07 04:44:16

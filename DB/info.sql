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

INSERT INTO `info` (`id`, `host`, `path_infected`, `key`, `attacked_at`) VALUES
(1,	'http://localheart/ransom/ransom1.php',	'/var/www/html/ransom/kelinci/',	'3361e456a4eaf790b94bdae2e22c10d7',	'2019-02-20 17:04:45');

-- 2019-02-20 10:49:12

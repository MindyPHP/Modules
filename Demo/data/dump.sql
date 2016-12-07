# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.14)
# Database: mindy-demo
# Generation Time: 2015-03-10 15:42:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table core_core_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `core_core_settings`;

CREATE TABLE `core_core_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) DEFAULT NULL,
  `email_owner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `core_core_settings` WRITE;
/*!40000 ALTER TABLE `core_core_settings` DISABLE KEYS */;

INSERT INTO `core_core_settings` (`id`, `sitename`, `email_owner`)
VALUES
	(1,NULL,NULL);

/*!40000 ALTER TABLE `core_core_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table core_migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `core_migration`;

CREATE TABLE `core_migration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table core_user_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `core_user_log`;

CREATE TABLE `core_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `module` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mail_mail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mail_mail`;

CREATE TABLE `mail_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `readed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mail_mail_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mail_mail_template`;

CREATE TABLE `mail_mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mail_subscribe
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mail_subscribe`;

CREATE TABLE `mail_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table menu_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu_menu`;

CREATE TABLE `menu_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table meta_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meta_meta`;

CREATE TABLE `meta_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `url` varchar(255) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pages_block
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages_block`;

CREATE TABLE `pages_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pages_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages_comment`;

CREATE TABLE `pages_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_spam` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pages_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages_page`;

CREATE TABLE `pages_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `content` text,
  `content_short` text,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `view_children` varchar(255) DEFAULT NULL,
  `is_index` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` varchar(255) DEFAULT NULL,
  `enable_comments` tinyint(1) NOT NULL DEFAULT '1',
  `enable_comments_form` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pages_page` WRITE;
/*!40000 ALTER TABLE `pages_page` DISABLE KEYS */;

INSERT INTO `pages_page` (`id`, `parent_id`, `lft`, `rgt`, `level`, `root`, `name`, `url`, `content`, `content_short`, `file`, `created_at`, `updated_at`, `published_at`, `view`, `view_children`, `is_index`, `is_published`, `sorting`, `enable_comments`, `enable_comments_form`)
VALUES
	(1,NULL,1,2,1,1,'Главная','index','','',NULL,'2015-03-10 14:33:21',NULL,'2015-03-10 14:33:21','','',1,1,'',1,1);

/*!40000 ALTER TABLE `pages_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table redirect_redirect
# ------------------------------------------------------------

DROP TABLE IF EXISTS `redirect_redirect`;

CREATE TABLE `redirect_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_url` varchar(255) NOT NULL,
  `to_url` varchar(255) NOT NULL,
  `type` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sites_site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sites_site`;

CREATE TABLE `sites_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `robots` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_group_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group_permission`;

CREATE TABLE `user_group_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_group_user_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group_user_user`;

CREATE TABLE `user_group_user_user` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_key
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_key`;

CREATE TABLE `user_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_permission`;

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bizrule` varchar(255) DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_auto` tinyint(1) NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_global` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_permission_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_permission_object`;

CREATE TABLE `user_permission_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `is_auto` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_permission_object_through
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_permission_object_through`;

CREATE TABLE `user_permission_object_through` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_session`;

CREATE TABLE `user_session` (
  `id` varchar(32) NOT NULL,
  `expire` int(11) NOT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `activation_key` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` int(11) DEFAULT NULL,
  `hash_type` varchar(255) NOT NULL DEFAULT 'mindy',
  `key_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_user` WRITE;
/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;

INSERT INTO `user_user` (`id`, `username`, `email`, `password`, `activation_key`, `is_active`, `is_staff`, `is_superuser`, `last_login`, `hash_type`, `key_id`, `created_at`)
VALUES
	(1,'admin','admin@admin.com','$2a$13$3zMJvyDLht4oBZiiITxPL.TiZGis1usLgx0oM54A5sPhiiAugRkW6','84e6a73c2b',1,1,1,1425983488,'mindy',NULL,'2015-03-10 14:31:24');

/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_user_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_user_permission`;

CREATE TABLE `user_user_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

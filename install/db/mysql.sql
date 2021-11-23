CREATE TABLE `{@}users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `{@}keys` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `user_id` int(11) unsigned DEFAULT NULL,
   `token` varchar(64) DEFAULT NULL,
   `created_at` datetime DEFAULT NULL,
   `valid_at` datetime DEFAULT NULL,
   `deleted_at` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `{@}links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` text CHARACTER SET utf8mb4,
  `short_code` varchar(16) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `{@}options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `{@}options` VALUES (NULL, 'next_id','100000000000');
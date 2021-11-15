CREATE TABLE `tail_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `url` text CHARACTER SET utf8mb4 COMMENT '长链接',
  `short_code` varchar(16) DEFAULT NULL COMMENT '短链接码',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '1，系统生成；2，自定义生成',
  `created_at` datetime DEFAULT NULL COMMENT '生成时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `tail_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `item` varchar(255) DEFAULT NULL COMMENT '项',
  `value` varchar(255) DEFAULT NULL COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `tail_options` VALUES (NULL, 'next_id','100000000000');
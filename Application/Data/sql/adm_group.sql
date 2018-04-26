/**
 * group.sql 结构表
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-13T16:35:26+0800
 */
USE `airele`;

-- ----------------------------
-- Table structure for adm_group
-- ----------------------------
DROP TABLE IF EXISTS `adm_group`;
CREATE TABLE `adm_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT '',
  `sort` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='分组表';

-- ----------------------------
-- Records of adm_group
-- ----------------------------
INSERT INTO `adm_group` VALUES ('1', '网站管理', '1', '0,1,2,3,4,5,6,7,9,10,11,12,13,14,15,16,17,18,19', '99');
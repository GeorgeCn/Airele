/**
 * char.sql 结构表
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-13T16:35:26+0800
 */
USE `airele`;

-- ----------------------------
-- Table structure for adm_char
-- ----------------------------
DROP TABLE IF EXISTS `adm_char`;
CREATE TABLE `adm_char` (
  `id` int(10) NOT NULL DEFAULT '0',
  `chars` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='特殊表';

-- ----------------------------
-- Records of adm_char
-- ----------------------------
INSERT INTO `adm_char` VALUES ('1', '923143925', '0');
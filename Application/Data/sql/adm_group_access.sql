/**
 * group_access.sql 结构表
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-13T16:35:26+0800
 */
USE `airele`;

-- ----------------------------
-- Table structure for adm_group_access
-- ----------------------------
DROP TABLE IF EXISTS `adm_group_access`;
CREATE TABLE `adm_group_access` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户-用户组关联表';

-- ----------------------------
-- Records of adm_group_access
-- ----------------------------
INSERT INTO `adm_group_access` VALUES ('1', '1');
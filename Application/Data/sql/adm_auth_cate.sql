/**
 * auth_cate.sql 结构表
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-13T16:35:26+0800
 */
USE `airele`;

-- ----------------------------
-- Table structure for adm_auth_cate
-- ----------------------------
DROP TABLE IF EXISTS `adm_auth_cate`;
CREATE TABLE `adm_auth_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '规则名称',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '等级',
  `module` varchar(50) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(50) NOT NULL DEFAULT '' COMMENT '控制器',
  `method` varchar(50) NOT NULL DEFAULT '' COMMENT '方法',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则路径',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类',
  `sort` mediumint(8) NOT NULL DEFAULT '0' COMMENT '排序规则',
  `condition` varchar(255) NOT NULL DEFAULT '',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0菜单 1非菜单',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `icon_class` varchar(20) DEFAULT '' COMMENT '图标class',
  PRIMARY KEY (`id`),
  KEY `ind_aauc_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='权限菜单表';

-- ----------------------------
-- Records of adm_auth_cate
-- ----------------------------
INSERT INTO `adm_auth_cate` VALUES ('1', '后台管理', '0', 'Admin', '', '', 'Admin', '0', '88', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('2', '网站配置', '1', 'Admin', 'Config', '', 'Admin/Config', '1', '88', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('3', '系统管理', '1', 'Admin', 'Admin', '', 'Admin/Admin', '1', '20', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('4', '管理员列表', '2', 'Admin', 'Admin', 'user', 'Admin/Admin/user', '3', '100', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('5', '权限管理', '2', 'Admin', 'Admin', 'auth', 'Admin/Admin/auth', '3', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('6', '分组管理', '2', 'Admin', 'Admin', 'group', 'Admin/Admin/group', '3', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('7', '基础配置', '2', 'Admin', 'Config', 'config', 'Admin/Config/config', '2', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('8', '内容管理', '0', 'Content', '', '', 'Content', '0', '60', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('9', '模型管理', '1', 'Admin', 'Model', '', 'Admin/Model', '1', '99', '', '0', '0', '');
INSERT INTO `adm_auth_cate` VALUES ('10', '模型列表', '2', 'Admin', 'Model', 'mysqllist', 'Admin/Model/mysqllist', '14', '99', '', '0', '0', '');
INSERT INTO `adm_auth_cate` VALUES ('11', '文章管理', '1', 'Content', 'Article', '', 'Content/Article', '10', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('12', '分类列表', '2', 'Content', 'Article', 'cate', 'Content/Article/cate', '19', '180', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('13', '新闻', '2', 'Content', 'Article', 'news', 'Content/Article/news', '19', '110', '', '0', '0', '');
INSERT INTO `adm_auth_cate` VALUES ('14', '数据库备份', '2', 'Admin', 'Model', 'backup', 'Admin/Model/backup', '14', '99', '', '0', '0', '');
INSERT INTO `adm_auth_cate` VALUES ('15', '清除非系统数据库', '2', 'Admin', 'Model', 'remove', 'Admin/Model/remove', '14', '99', '', '0', '0', '');
INSERT INTO `adm_auth_cate` VALUES ('16', '文章列表', '2', 'Content', 'Article', 'lists', 'Content/Article/lists', '19', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('17', '编辑文章', '2', 'Content', 'Article', 'articleedit', 'Content/Article/articleedit', '19', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('18', '路由管理', '1', 'Admin', 'Rules', '', 'Admin/Rules', '1', '10', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('19', '规则列表', '2', 'Admin', 'Rules', 'lists', 'Admin/Rules/lists', '28', '99', '', '0', '1', '');
INSERT INTO `adm_auth_cate` VALUES ('20', '控制台', '0', 'Admin', '', '', 'Admin', '0', '99', '', '1', '1', 'icon-dashboard');
INSERT INTO `adm_auth_cate` VALUES ('21', '文字排版', '1', 'Admin', 'Typograpy', 'typography', 'Admin/Typograpy', '20', '99', '', '1', '1', 'icon-dashboard');
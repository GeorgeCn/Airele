/**
 * admin.sql 结构表
 * @Author   George                   <[<923143925@qq.com>]>
 * @DateTime 2018-04-13T16:35:26+0800
 * @return   {sql}
 */
USE `airele`;
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id 自增',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `phone` int(11) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `sort` mediumint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `add_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '添加ip',
  `last_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `name` (`name`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员表';
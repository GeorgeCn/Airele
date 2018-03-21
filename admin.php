<?php
// 应用入口文件
//禁用所有错误报告
//error_reporting(0);
//只报告运行时错误和警告
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

// 检测PHP环境
// 
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义应用目录
define('APP_PATH','./Application/');
//生成目录安全文件
define('BUILD_DIR_SECURE', true);
//定义静态页面路径
define('HTML_PATH','./Html/');
//定义默认模块
define('BIND_MODULE','Home');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
?>
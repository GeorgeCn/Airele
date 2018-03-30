<?php
return array(
	//'配置项'=>'配置值'
	// 默认过滤函数
	'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars',

	// 开启路由
	'URL_ROUTER_ON'   => true, 

	'URL_ROUTE_RULES'=>array(    
			'student/:id\d' => array(__ROOT__.'/Admin/Student/edit/id:1'),    
	),

	//'RONGLIAN_CONFIG'
    'RONGLIAN_ACCOUNT_SID'   => '8a216da85805311d015818586c2b0860', //容联云通讯 主账号 accountSid
    'RONGLIAN_ACCOUNT_TOKEN' => '994895187b114f44b6692103fb1332da', //容联云通讯 主账号token accountToken
    'RONGLIAN_APPID'         => '8a216da85805311d015818586ca50865', //容联云通讯 

    //'MYSQL_RULE'
    'BACKUP_URL' => './Data',           //数据库备份目录
    'OPERATING_PASSWORD' => '923143925', //操作密码
    'SYSTEM_MYSQL_TABLE' => array('admin','auth_cate','char'),//系统保留表,禁止删除,否则报错
);
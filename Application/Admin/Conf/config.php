<?php
return array(
	//'配置项'=>'配置值'
	'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars',

	// 开启路由
	'URL_ROUTER_ON'   => true, 

	'URL_ROUTE_RULES'=>array(    
			'student/:id\d' => array(__ROOT__.'/Admin/Student/edit/id:1'),    
	),

	//'TMPL_FILE_DEPR'=>'_',
	//定义路径
	'TMPL_PARSE_STRING' =>array(
	'__JS__' => '/Public/JS/', // 增加新的JS类库路径替换规则
	'__UPLOAD__' => '__ROOT__/Public/Uploads/', // 增加新的上传路径替换规则
	),

	//'TMPL_FILE_DEPR'=>'_',
     'RONGLIAN_ACCOUNT_SID'   => '8a216da85805311d015818586c2b0860', //容联云通讯 主账号 accountSid
    'RONGLIAN_ACCOUNT_TOKEN' => '994895187b114f44b6692103fb1332da', //容联云通讯 主账号token accountToken
    'RONGLIAN_APPID'         => '8a216da85805311d015818586ca50865', //容联云通讯 

);
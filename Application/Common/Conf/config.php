<?php
return array(
	//'配置项'=>'配置值'

	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'realhome',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号

	// 模板配置
	'TMPL_L_DELIM'=>'<{',
	'TMPL_R_DELIM'=>'}>',

    // 显示页面Trace信息
    'SHOW_PAGE_TRACE' =>true,

    // 模板变量
    'TMPL_PARSE_STRING' =>array(
        '__UPLOAD__' => __ROOT__.'./Uploads', // 增加新的上传路径替换规则
        '__ADMINSTYLE__' => __ROOT__ . '/Public/Admin',
        '__HOMESTYLE__' => __ROOT__ . '/Public/Home',
        '__API__' => __ROOT__ . '/Public/Api',
    ),

    /** 以下为权限管理系统(居家必备之良药)切勿删除 **/
    'AUTH_CONFIG'           => array(
        'AUTH_ON'           => true,  // 认证开关
        'AUTH_TYPE'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'AUTH_GROUP'        => 'a_group', // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'a_group_access', // 用户-用户组关系表
        'AUTH_RULE'         => 'a_auth_cate', // 权限规则表
        'AUTH_USER'         => 'a_admin', // 用户信息表
    ),
    'SHOW_PAGE_TRACE'       => true, //开启调试,上线后删除
    'DATA_CACHE_PREFIX'     =>  'think_auth_',     // 缓存前缀
    //'DATA_CACHE_TYPE'       => '',
    'ADMIN_UID'                   => 'admin_uid',
    'PAGENUM'               => 20, //默认展示条数
    'ADMINISTRATOR'         => 1,
    'USERNAME'              => 'username',
    'APP_SUB_DOMAIN_DEPLOY' => 1, // 开启子域名配置
    'DEFAULTS_MODULE'       => 'Admin',
    'DEFAULT_MODULE'        => 'Admin',

    //邮件配置
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'',//你的邮箱名
    'MAIL_FROM' =>'',//发件人地址
    'MAIL_FROMNAME'=>'',//发件人姓名
    'MAIL_PASSWORD' =>'',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    'CACHE_TIME'          => '600', //缓存时间
);
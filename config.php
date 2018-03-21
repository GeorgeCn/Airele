<?php
$conf=array(
    'DB_DATA' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.27.162.0', // 服务器地址
                     'DB_NAME'               => 'gaodudata', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'gdroot',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       =>false,
                ),
    'DB_IMAGE' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.27.162.0', // 服务器地址
                     'DB_NAME'               => 'gaoduimgs', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'gdroot',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       => false,
                ),
    'DB_ROB' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.26.225.198', // 服务器地址
                     'DB_NAME'               => 'gaodu', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'GaoDu123654',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => false, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       => false,
                ),
	        
    'DB_CALL' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.27.162.0', // 服务器地址
                     'DB_NAME'               => 'gaoducall', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'gdroot',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => false, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       => false,
                ),
    'DB_STORE' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.27.162.0', // 服务器地址
                     'DB_NAME'               => 'gaodustore', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'gdroot',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       =>false,
                ),
    'DB_RECOMMEND' => array(
                     'DB_TYPE'               => 'mysqli',     // 数据库类型
                     'DB_HOST'               => '120.27.162.0', // 服务器地址
                     'DB_NAME'               => 'gaodu_recommend', // 数据库名
                     'DB_USER'               => 'root',      // 用户名
                     'DB_PWD'                => 'gdroot',          // 密码
                     'DB_PORT'               => 3306,        // 端口
                     'DB_PREFIX'             => '',    // 数据库表前缀
                     'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
                     'DB_FIELDS_CACHE'       =>false,
                ),
);
$mainConf = array(
    //--------------------数据库配置------------------------
     'DB_TYPE'               => 'mysqli',     // 数据库类型
     'DB_HOST'               => '120.27.162.0', // 服务器地址
     'DB_NAME'               => 'gaodu', // 数据库名
     'DB_USER'               => 'root',      // 用户名
     'DB_PWD'                => 'gdroot', // 密码
     'DB_PORT'               => 3306,        // 端口
     'DB_PREFIX'             => '',    // 数据库表前缀
     'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
     'DB_FIELDS_CACHE'       =>false,

    'DEFAULT_MODULE'        => 'Index', //默认模块
    'URL_MODEL'             => '2', //URL模式(rewrite 伪静态)
    'SESSION_AUTO_START'    => true, //是否开启session
    'URL_ROUTER_ON'         => true, // 开启路由
    'DEFAULT_CHARSET'       =>'utf-8', // 默认输出编码
    'DATA_CACHE_TIME'       =>'1',
  
    'IMG_SERVICE_URL'=>'http://120.27.162.0/imgtest/imgapi/',
    'IMG_ROB_URL'=>'http://120.26.225.198/imgapi/',
    'API_SERVICE_URL'=>'http://120.27.162.0/testapi/',
   /* 'COUCHBASE_ADDRESS'                 =>'couchbase://120.26.225.198:8091/',//测试:couchbase://120.26.225.198:8091 正式环境:couchbase://10.117.35.181
    'COUCHBASE_BUCKET_ADMIN'             =>'gaoduadmin',//哪个Bucket
    'COUCHBASE_BUCKET_GAODU'             =>'gaodu',//哪个Bucket
    'COUCHBASE_BUCKET_GAODUDATA'             =>'gaodudata',
    'COUCHBASE_BUCKET_ADMIN_SECRET'      =>'CouchBasezhou5195',//Bucket的密钥
    'IS_COUCH_CACHE'       =>false,//是否缓存*/
    'IS_CACHE'=>true,
    'CITY_CODE'=>'001009001',//上海
    'CITY_NO'=>1,//上海
    'CITY_PREX'=>'SH',//房源编号头
	'CALL_RECORD_URL'=>'http://121.43.117.95/recording',//录音地址
    'HOUST_SHANGHAI_URL'=>"http://120.26.225.198/admin/Welcome/welcome.html",
    'HOUST_BEIJING_URL'=>"http://120.26.225.198/adminbj/Welcome/welcome.html",
	'HOUST_HANGZHOU_URL'=>"http://120.26.225.198/adminhz/Welcome/welcome.html",
    'HOUST_GUAGNZHOU_URL'=>"http://120.26.225.198/admingz/Welcome/welcome.html",
    'HOUST_SHENZHENG_URL'=>"http://120.26.225.198/adminsz/Welcome/welcome.html",
    'HOUSE_API_URL'=>"http://121.40.30.216:8090/HouseData/",
    'TEL_DISPLAY'  =>false,//是否开启400电话 
    'TEL_URL'      =>'http://120.26.225.198/gaoduopenapi/call/getcall.html',//地址
    'REDIS_ADDRESS_MASTER'              =>'120.27.162.0',
    'REDIS_ADDRESS_SLAVE'               =>'120.27.162.0',
    'REDIS_PORT'                        =>6379,
    'REDIS_SECRET'                      =>'hizhuredis123qwe',    
    'IS_REDIS_CACHE'                    =>true,//是否用REDIS 缓存    
    'VOD_IMG_URL'  =>'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_IMG/',    
    'VOD_VIDEO_URL'=>'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_MP4_HD/',
    'VOD_H5VIDEO_URL'=>'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_MP4_DLD/',
    'HOST_URL'=>'http://120.27.162.0/admin',);
    return array_merge($conf,$mainConf);
?>
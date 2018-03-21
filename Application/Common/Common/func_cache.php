<?php

/*设置缓存的KEY*/
function set_cache_key($str)
{
	$result=$str;
	$len=strlen($str);
	if($len>50)
	{
		$result=md5($str);
	}
	return $result;
}
/*设置缓存的KEY*/
function set_apicache_key($str)
{
	$str="api-".strtolower($str);
	$result=$str;
	$len=strlen($str);
	if($len>50)
	{
		$result=md5($str);
	}
	return $result;
}
/*设置缓存的KEY*/
function set_cache_public_key($str)
{
	$str=strtolower($str);
	$result=$str;
	$len=strlen($str);
	if($len>50)
	{
		$result=md5($str);
	}
	return $result;
}

/*设置缓存-分布式缓存*/
function set_cache_admin($bucket_name,$cache_name,$cache_data,$expire_date=3600)
{
	$result=false;
	if(C("IS_CACHE")){
		if(C("IS_REDIS_CACHE")){
			$result=set_couchebase_admin($bucket_name,$cache_name,$cache_data,$expire_date);
		}else{
			$result=set_cache($cache_name,$cache_data,$expire_date);
		}
	}
	return $result;
}

/*获取缓存-分布式缓存data*/
function get_cache_admin($bucket_name,$cache_name)
{
	$result="";
	if(C("IS_CACHE")){
		if(C("IS_REDIS_CACHE")){
			$result=get_couchbase_admin($bucket_name,$cache_name);
		}else{
			$result=get_cache($cache_name);
		}
	}	
	return $result;
}

/*移除缓存-分布式缓存data*/
function del_cache_admin($bucket_name,$cache_name)
{
	$result=false;
	if(C("IS_CACHE")){
		if(C("IS_REDIS_CACHE")){
			$result=del_couchbase_admin($bucket_name,$cache_name);
		}
	}
	return $result;
}


/*****************************哪种缓存方式-start******************************************************/
/*设置缓存-thinkphp 原生缓存*/
function set_cache($cache_name,$cache_data,$expire_date=3600)
{
	if(C("IS_CACHE")){
		S($cache_name,$cache_data,$expire_date);
		return true;
	}
	return false;
}

/*获取缓存*/
function get_cache($cache_name)
{
	$result="";
	if(C("IS_CACHE")){
		$result=S($cache_name);
	}
	return $result;
}


/*设置缓存-分布式缓存*/
function set_couchebase_admin($bucket_name,$cache_name,$cache_data,$expire_date=3600)
{
	return set_redis_data($cache_name,$cache_data,$expire_date);
}
/*获取缓存-分布式缓存data*/
function get_couchbase_admin($bucket_name,$cache_name)
{
	return get_redis_data($cache_name);
}

/*设置缓存-分布式缓存*/
function set_couchebase_data($bucket_name,$cache_name,$cache_data,$expire_date=3600)
{
	return set_redis_data($cache_name,$cache_data,$expire_date);
}
/*获取缓存-分布式缓存data*/
function get_couchbase_data($bucket_name,$cache_name)
{
	return get_redis_data($cache_name);
}


function del_couchbase_admin($bucket_name,$cache_name)
{
	return delete_redis_data($cache_name);
}

/*获取缓存-分布式缓存data*/
function get_cache_data($bucket_name,$cache_name)
{
	$result="";
	if(C("IS_CACHE")){
		if(C("IS_REDIS_CACHE")){
			$result=get_couchbase_data($bucket_name,$cache_name);
		}else{
			$result=get_cache($cache_name);
		}
	}
	return $result;
}
/*设置缓存-分布式缓存*/
function set_cache_data($bucket_name,$cache_name,$cache_data,$expire_date=3600)
{
	$result=false;
	if(C("IS_CACHE")){
		if(C("IS_REDIS_CACHE")){
			$result=set_couchebase_data($bucket_name,$cache_name,$cache_data,$expire_date);
		}else{
			$result=set_cache($cache_name,$cache_data,$expire_date);
		}
	}
	return $result;
}

/*****************************哪种缓存方式-end******************************************************/



/*redis 主库
  redis 写缓存
*/
function set_redis_data($cache_name,$cache_data,$expire_date=3600)
{	
	 try
	 {
	 	 $cache_data=json_encode($cache_data);
		 $redis = new Redis();
		 $redis->pconnect(C("REDIS_ADDRESS_MASTER"),C("REDIS_PORT"),2);
		 $redis->auth(C("REDIS_SECRET"));
		 if($expire_date==0){
		 	$redis->set($cache_name,$cache_data);
		 }else{
		 	$redis->setex($cache_name,$expire_date,$cache_data);
		 }
		 return true;
	 } catch (Exception $e) {
    	return false;
     }

}
/*redis 从库
  redis 读缓存
 */
function get_redis_data($cache_name)
{
	 try{
		 $redis = new Redis();
		 $redis->pconnect(C("REDIS_ADDRESS_SLAVE"), C("REDIS_PORT"),2);
		 $redis->auth(C("REDIS_SECRET"));
	     $result=$redis->get($cache_name);
	     //file_put_contents("cache-log.txt", date('Y-m-d H:i:s')."：redis获取成功".$cache_name."\r\n", FILE_APPEND);
	     return json_decode($result,true);
	 } catch (Exception $e) {
	 	file_put_contents("cache-log.txt", date('Y-m-d H:i:s')."：redis获取错误".$cache_name."\r\n", FILE_APPEND);
    	return null;
     }
}
/*redis 主库库
  redis 删除缓存
 */
function delete_redis_data($cache_name)
{
	 try{
		 $redis = new Redis();
		 $redis->pconnect(C("REDIS_ADDRESS_MASTER"),C("REDIS_PORT"),2);
		 $redis->auth(C("REDIS_SECRET"));
	     $redis->delete($cache_name);
	     //file_put_contents("cache-log.txt", date('Y-m-d H:i:s')."：redis删除成功".$cache_name."\r\n", FILE_APPEND);
	     return true;
	 } catch (Exception $e) {
	 	file_put_contents("cache-log.txt", date('Y-m-d H:i:s')."：redis删除错误".$cache_name."\r\n", FILE_APPEND);
    	return false;
     }
}

/*获取登录人信息*/
function getLoginName(){
	return cookie("admin_user_name");
}

?>

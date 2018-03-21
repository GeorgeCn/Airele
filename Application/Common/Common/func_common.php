<?php
/*唯一编号,数值型 */
function microtime_pk_id()
{
    $time_array = explode(" ", microtime());
    return substr($time_array[1], 1).substr($time_array[0], 2,5).rand(1000,9999);
}
	/*	返回GUID	*/
	function guid() {
		mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
		$charid = strtolower( md5 ( uniqid ( rand (), true ) ) );
		$hyphen = chr ( 45 ); 
		$uuid = 		
		substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 ); 
		return $uuid;
	}

	/*	返回GUID,不带下划线_ */
	function getGuidWithoutLine() {
		mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
		$charid = strtolower ( md5 ( uniqid ( rand (), true ) ) );
		$hyphen = chr ( 45 ); 
		$uuid = 		
		substr ( $charid, 0, 8 ) . substr ( $charid, 8, 4 ) . substr ( $charid, 12, 4 ) . substr ( $charid, 16, 4 ) . substr ( $charid, 20, 12 ); 
		return $uuid;
	}
	 /* 获取当前页面完整URL地址 */
	 function get_url() {
	    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	 }
	/* 提交请求
	* @param $host array 需要配置的域名 array("Host: act.qzone.qq.com");
	* @param $data string 需要提交的数据 'user=xxx&qq=xxx&id=xxx&post=xxx'....
	* @param $url string 要提交的url 'http://192.168.1.12/xxx/xxx/api/';
	*/
 	function curl_post($host,$data,$url)
    {
       $ch = curl_init();
       $res= curl_setopt ($ch, CURLOPT_URL,$url);

       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt ($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch,CURLOPT_HTTPHEADER,$host);
       $result = curl_exec ($ch);
       curl_close($ch);
       if ($result == NULL) {
           return 0;
       }
       return $result;
    }
    //get or post request 
    function curl_url($url,$data=null){
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL,$url);
	   curl_setopt($ch, CURLOPT_HEADER, 0);
	   if($data!=null){
	      curl_setopt($ch, CURLOPT_POST, 1);
	      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	   }
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   $result = curl_exec ($ch);
	   curl_close($ch);
	   if ($result == NULL) {
	       return 0;
	   }
	   return $result;
	}
	/*生成数字随机数*/	
	function rand_number($min, $max) {
		return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
	 }
	
	//日志记录
    function writeLog($log_content)
    {
        file_put_contents("log.txt", date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
    }
    // 打印log
	function  log_result($file,$word) 
	{
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".strftime("%Y-%m-%d %H:%M:%S",time())."\n".$word."\r\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
	//房间名称（不同房源对应）
	function getRoomNamelistByType($type,$room_type=''){
		if($room_type=='0204' || $room_type=='0205'){
			return '<option value="整套">整套</option>';
		}
		$list='<option value="主卧">主卧</option><option value="次卧A">次卧A</option><option value="次卧B">次卧B</option><option value="次卧C">次卧C</option>
<option value="次卧D">次卧D</option><option value="次卧E">次卧E</option><option value="次卧F">次卧F</option><option value="次卧G">次卧G</option><option value="次卧H">次卧H</option><option value="次卧I">次卧I</option>
		<option value="客厅">客厅</option><option value="整套">整套</option><option value="床位">床位</option>';
		switch ($type) {
			case '1501':
				if($room_type!=''){
					$list='<option value="主卧">主卧</option><option value="次卧A">次卧A</option><option value="次卧B">次卧B</option><option value="次卧C">次卧C</option><option value="次卧D">次卧D</option><option value="次卧E">次卧E</option><option value="次卧F">次卧F</option><option value="次卧G">次卧G</option><option value="次卧H">次卧H</option><option value="次卧I">次卧I</option><option value="客厅">客厅</option><option value="床位">床位</option>';
				}
				break;
			case '1502':
				$list='<option value="主卧">主卧</option><option value="次卧">次卧</option><option value="床位">床位</option>';
				//$list='<option value="套间">套间</option><option value="双床套">双床套</option><option value="复式套">复式套</option><option value="高低铺">高低铺</option><option value="三人间">三人间</option><option value="平房小院">平房小院</option><option value="床位">床位</option>';
				break;
			case '1503':
				$list='<option value="主卧">主卧</option><option value="次卧">次卧</option><option value="床位">床位</option>';
				//$list='<option value="大床房">大床房</option><option value="双床房">双床房</option><option value="三床房">三床房</option><option value="床位">床位</option>';
				break;
			default:
				break;
		}
		return $list;
	}
	function getRoomNameArrays(){
		return $arrayName = array('0' => '主卧','1' => '次卧A','2' => '次卧B','3' => '次卧C','4' => '次卧D','5' => '次卧E','6' => '次卧F','7' => '次卧G','8' => '次卧H','9' => '次卧I' );
	}
	function getRoomTypelistByType($type){
		return $list='<option value="0201">合租原房</option><option value="0202">合租N+1</option><option value="0203">合租隔断房</option><option value="0204">整租单间</option><option value="0205">整租套间</option>';
		switch ($type) {
			case '1501':
				break;
			case '1502':
				$list='<option value="0204">整租单间</option><option value="0205">整租套间</option>';
				break;
			case '1503':
				$list='<option value="0204">整租单间</option><option value="0205">整租套间</option>';
				break;
			default:
				break;
		}
		return $list;
	}
	function getHouseInfoResourcelist(){
		$list='<option value="空">空</option><option value="58">58</option><option value="赶集">赶集</option><option value="豆瓣">豆瓣</option><option value="搜房">搜房</option><option value="百姓">百姓</option><option value="安居客">安居客</option><option value="BD">BD</option><option value="个人发布">个人发布</option><option value="品牌公寓">品牌公寓</option><option value="OPEN-API">OPEN-API</option><option value="房利帮">房利帮</option><option value="链家网">链家网</option><option value="房东版发布">房东版发布</option>';
		return $list;
	}
	function replaceHousePlatformName($desc){
		return str_replace(array('58同城','搜房网','百姓网','赶集网','搜房','赶集','百姓','豆瓣','安居客','房天下' ), '嗨住', $desc);
	}
	/*分期状态 */
	function getStagStatusArray(){
		return array('1'=>'申请中','2'=>'已退件','3'=>'暂停/终止','4'=>'已完成','6'=>'审核中','7'=>'等待放款','8'=>'放款待确认','10'=>'还款中');
	}
	/*电话状态 */
	function getPhoneStatusArray(){
		return array('0'=>'成功','1'=>'忙','2'=>'无应答','3'=>'客户提前挂机','11'=>'客户主动放弃','201'=>'无效分机号','555'=>'黑名单','777'=>'回呼外线失败','1000'=>'非工作时间','1002'=>'欠费','-1'=>'未知');
	}
	//二维数组排序
	function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
		if(is_array($multi_array)){ 
			foreach ($multi_array as $row_array){ 
				if(is_array($row_array)){ 
					$key_array[] = $row_array[$sort_key]; 
				}else{ 
					return false; 
				} 
			} 
		}else{ 
			return false; 
		} 
		array_multisort($key_array,$sort,$multi_array); 
		return $multi_array; 
	} 
	//一级来源(爬取/OPEN-API/个人发布/房东版发布/BD)
	function getOneInforesource(){
		return array(''=>'','1'=>'爬取','2'=>'OPEN-API','3'=>'个人发布','4'=>'房东版发布','5'=>'BD');
	}
	//二级来源
	function getTwoInforesource($one=0){
		$two_array=array();
		switch ($one) {
			case 1:
				$two_array=array('58'=>'58','赶集'=>'赶集','搜房'=>'搜房','豆瓣'=>'豆瓣','百姓'=>'百姓','安居客'=>'安居客','房利帮'=>'房利帮','链家网'=>'链家网','贞一'=>'贞一','爱屋吉屋'=>'爱屋吉屋','我爱我家'=>'我爱我家','中原地产'=>'中原地产','品牌公寓'=>'品牌公寓');
				break;
			case 2:
				$two_array=array('爱上租'=>'爱上租','水滴管家'=>'水滴管家');
				break;
			case 3:
				$two_array=array('个人发布'=>'个人发布');
				break;
			case 4:
				$two_array=array('房东版发布'=>'房东版发布');
				break;
			case 5:
				$two_array=array('BD'=>'BD');
				break;
			default:
				break;
		}
		return $two_array;
	}
	//下载权限
	function getDownloadLimit(){
		return array('admin','xiaqingning','lijiaojiao','chenyuchao','wanghui','sunqi','xujin','tianzhen','zhouyifan','yaoxiufei','wangjiankang','chenying','lidan','wuzhonghe','shenjiannan','wangxin','suhongye','haotongrui','wufan','yantaojie','daikui','lutaotao','maolizheng','sunwenpei','daisuxia','yujiali','lushanshan','liuyue','longying','dingyuanxue');
	}
	//选择不同城市公寓品牌
	function getFlatListByCity($city){
		$list = '';
		switch ($city) {
			case '001009001':
				$list='<option value="58">58</option><option value="自如">自如</option><option value="青客">青客</option><option value="寓见">寓见</option><option value="蛋壳">蛋壳</option><option value="爱上租">爱上租</option><option value="中原地产">中原地产</option><option value="我爱我家">我爱我家</option><option value="爱屋吉屋">爱屋吉屋</option><option value="贞一">贞一</option>';
				break;
			case '001011001':
				$list='<option value="58">58</option><option value="爱上租">爱上租</option><option value="优客逸家">优客逸家</option><option value="米果家">米果家</option><option value="自如">自如</option><option value="我爱我家">我爱我家</option>';
				break;
			case '001010001':
				$list='<option value="58">58</option><option value="爱上租">爱上租</option><option value="银城千万间">银城千万间</option><option value="和租吧">和租吧</option><option value="365淘房">365淘房</option><option value="我爱我家">我爱我家</option><option value="自如">自如</option><option value="中原地产">中原地产</option>';
				break;
			case '001001':
				$list='<option value="58">58</option><option value="自如">自如</option><option value="蛋壳">蛋壳</option><option value="优客逸家">优客逸家</option><option value="包租婆">包租婆</option><option value="美丽屋">美丽屋</option>';
				break;	
			case '001019002':
				$list='<option value="58">58</option><option value="自如">自如</option><option value="蛋壳">蛋壳</option><option value="小螺趣租">小螺趣租</option><option value="偶寓">偶寓</option>';
				break;
			default:
				break;
		}
		return $list;
	}
	function getCityList(){
		return array('001009001'=>'上海','001001'=>'北京','001011001'=>'杭州','001010001'=>'南京','001019002'=>'深圳');
	}

?>
<?php
	function sendPhoneContent($sendArr){
		$modelRsa=new \Home\Model\rsakeys();
		$keyArr=$modelRsa->getModel("web");
		$ser_pri_key='';
		$md5sign='';
		$platform='Android';
		$clientver='1.0.1';
		$md5platform=strtolower($platform);
		if($keyArr != null && $keyArr != false)
		{
			$ser_pri_key=$keyArr['private_key'];
			$md5sign=md5($ser_pri_key.$clientver.$md5platform);
		}
		$headers['ScreenSize'] = '560x960'; 
		$headers['Platform'] =$platform;
		$headers['Udid'] = get_client_ip();
		$headers['DeviceId'] = '654321';
		$headers['ClientVer'] =$clientver;
		$headers['Md5'] =$md5sign;
		$headers['Session'] = 'webapp';
		
		$phone_num=$sendArr['phonenumber'];
		$sms_type=$sendArr['smstype'];
		$req_timestamp=$sendArr['timestamp'];
		$req_name=$sendArr['name'];
		$req_money=$sendArr['money'];
		$req_order=$sendArr['orderid'];
		
		$headerArr = array(); 
		foreach( $headers as $n => $v ) { 
    		$headerArr[] = $n .':' . $v;  
		}
		
		$data = '{"phoneNumber":"'.$phone_num.'","sms_type":"'.$sms_type.'","timestamp":"'.$req_timestamp.'","name":"'.$req_name.'","money":"'.$req_money.'","orderid":"'.$req_order.'"}';
		$url = C('API_SERVICE_URL').'common/sendcontent.html';
	    $output=curl_post($headerArr,$data,$url);
		//log_result("msglog.txt",'短信返回信息：'.$output); 
	}
	//预约短信
	function sendMessage_yuyue($sendArr){
		$modelRsa=new \Home\Model\rsakeys();
		$keyArr=$modelRsa->getModel("web");
		$ser_pri_key='';
		$md5sign='';
		$platform='Android';
		$clientver='1.0.1';
		$md5platform=strtolower($platform);
		if($keyArr != null && $keyArr != false)
		{
			$ser_pri_key=$keyArr['private_key'];
			$md5sign=md5($ser_pri_key.$clientver.$md5platform);
		}
		$headers['ScreenSize'] = '560x960'; 
		$headers['Platform'] =$platform;
		$headers['Udid'] = get_client_ip();
		$headers['DeviceId'] = '654321';
		$headers['ClientVer'] =$clientver;
		$headers['Md5'] =$md5sign;
		$headers['Session'] = 'webapp';
		
		$headerArr = array(); 
		foreach( $headers as $n => $v ) { 
    		$headerArr[] = $n .':' . $v;  
		}
	    $output=curl_post($headerArr,json_encode($sendArr),C('API_SERVICE_URL').'common/smssendreserve.html');
	}
    function sendPhoneRandom($udid,$phone,$content){
		$modelRsa=new \Home\Model\rsakeys();
		$keyArr=$modelRsa->getModel("web");
		$ser_pri_key='';
		$md5sign='';
		$platform='Android';
		$clientver='1.0.1';
		$md5platform=strtolower($platform);
		if($keyArr != null && $keyArr != false)
		{
			$ser_pri_key=$keyArr['private_key'];
			$md5sign=md5($ser_pri_key.$clientver.$md5platform);
		}
		$headers['ScreenSize'] = '560x960'; 
		$headers['Platform'] =$platform;
		$headers['Udid'] = $udid;
		$headers['DeviceId'] = '654321';
		$headers['ClientVer'] =$clientver;
		$headers['Md5'] =$md5sign;
		$headers['Session'] = 'adminpushsms';
		
		
		$headerArr = array(); 
		foreach( $headers as $n => $v ) { 
    		$headerArr[] = $n .':' . $v;  
		}
		
		$data = '{"phone_number":"'.$phone.'","phone_msg":"'.$content.'"}';
		$url = C('API_SERVICE_URL').'common/sendnolimit.html';
	    $output=curl_post($headerArr,$data,$url);
	}

	
?>
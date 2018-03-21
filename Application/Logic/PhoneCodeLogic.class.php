<?php
namespace Logic;
class PhoneCodeLogic{

	 /*获取400分机号码*/
	 public function get400Code($data_array)
	 {
	 	  $callUrl=C("TEL_URL");
	 	  $urlArr = parse_url($callUrl);
	 	  $url=$urlArr['path'];
	      $httpMethod="POST";
	      $consumerKey="ACD40066-87A5-42C4-B11A-F6EA262122E4";
	      $consumerSecret="C387EBE7-5731-4A92-8D04-3FC1DD0AA6BD";
	      $nonce="123456789";
	      $timeStamp=time();
	      $version="v2.0";
	      $mobile=$data_array['mobile'];
	      if($mobile=="")
	      {
	      	return $mobile;
	      }
	      /*if(!$this->is_phone($mobile))
		  {
		  	$mobile=$this->getFullTel($mobile);
		  }*/
	      $dataArr['tel_no']=$mobile;
	      $dataArr['room_id']=$data_array['room_id'];
	      $dataArr['room_no']=$data_array['room_no'];
	      $dataArr['city_id']=$data_array['city_id'];
	      $dataArr['info_resource']=$data_array['info_resource'];

	      $is_auth=0;
		  $handOAuthLogic = new \Logic\OAuthLogic();
	   	  $is_auth= $handOAuthLogic->GenerateSignature2($url, $httpMethod, $consumerKey, $consumerSecret, $nonce, $timeStamp, $version);

	   	  $urlparam="auth_method=".$httpMethod."&auth_key=".$consumerKey."&auth_nonce=".$nonce."&auth_timestamp=".$timeStamp."&auth_version=".$version."&auth_signature=".$is_auth;

	      $url = $callUrl.'?'.$urlparam;
	      $output=curl_url($url,$dataArr);
	      $print_content='';
	      foreach ($dataArr as $key => $value) {
	      	$print_content.=$key.":".$value.",";
	      }
	      file_put_contents('400code-log.txt', date('Y-m-d H:i:s')."参数：".$print_content.",返回：".$output,FILE_APPEND);
	      $json_array=json_decode($output, true);
	      $tel_400="";
	      if($json_array['status']=="200")
	      {
	     	 $tel_400=$json_array['data']['big_code'].','.$json_array['data']['ext_code'];
	      }
	     return $tel_400;
	}
	private function  is_phone($phone)
	{
	   if(strlen($phone) != 11)
		{ 
			return false;
		}
	   if(preg_match("/1[134578]{1}\d{9}$/",$phone)){  
	    	return true;
		}
		return false;  
		
	}
    /*没有区号自动添加区号*/
    private function getFullTel($tel_no)
    {
    	 $City_Code=C("CITY_CODE");
    	 $handleCity=new \Logic\Citys();
    	 $modelCity=$handleCity->modelGetByCache($City_Code);
    	 if($modelCity!=null&&$modelCity!=false)
    	 {
	    	 $qu_hao=trim($modelCity['areaId']);
	    	 if(strpos($tel_no,$qu_hao)===0)
	    	 {
	    	 }
	    	 else
	    	 {
	    	 	if(strpos($tel_no,"400")===0)
		    	{
		    	}
		    	else
		    	{
	    	 		$tel_no= $qu_hao.$tel_no;
	    	 	}
	    	 }
    	 }
    	 return $tel_no;
    }

}
?>
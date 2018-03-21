<?php
namespace Logic;
class HouseReserveCallLogic{
	//新增
	public function addCallLogModel($data){
	  	$model=new \Home\Model\housereservecall();
	  	return $model->addCallLogModel($data);
	}
	public function addHousereservecallModel($data){
	  	$model=new \Home\Model\housereservecall();
	  	return $model->addHousereservecallModel($data);
	}
	#新增看房日程
	public function addHousereserve($data){
	  	$model=new \Home\Model\housereservecall();
	  	return $model->addHousereserve($data);
	}
	#读取房间详情
	public function getAllinfoByRoomid($room_id){
	  	$model=new \Home\Model\houseroom();
	  	return $model->getAllinfoByRoomid($room_id);
	}
	#update
	public function updateCallModel($data){
		$model=new \Home\Model\housereservecall();
	  	return $model->updateCallModel($data);
	}
	public function getConditionString($condition){
	     $conditionString="";
	     #提交时间
	     if(isset($condition['startTime']) && !empty($condition['startTime'])){
	        $conditionString.=" and a.create_time>=".strtotime(trim($condition['startTime']));
	     }
	     if(isset($condition['endTime']) && !empty($condition['endTime'])){
	        $endTime=strtotime(trim($condition['endTime']))+60*60*24;
	        $conditionString.=" and a.create_time<=".$endTime;
	     }
	      #看房时间
	     if(isset($condition['startTime_look']) && !empty($condition['startTime_look'])){
	        $conditionString.=" and a.look_time>=".strtotime(trim($condition['startTime_look']));
	     }
	     if(isset($condition['endTime_look']) && !empty($condition['endTime_look'])){
	        $endTime=strtotime(trim($condition['endTime_look']))+60*60*24;
	        $conditionString.=" and a.look_time<=".$endTime;
	     }
	     #预约人手机
	     if(isset($condition['mobile']) && !empty($condition['mobile'])){
	        $conditionString.=" and a.customer_mobile = '".$condition['mobile']."'";
	     }
	     #房东手机
	     if(isset($condition['clientPhone']) && !empty($condition['clientPhone'])){
	        $conditionString.=" and a.owner_mobile = '".$condition['clientPhone']."'";
	     }
	     #房间编号
	     if(isset($condition['roomNo']) && !empty($condition['roomNo'])){
	        $conditionString.=" and a.room_no = '".$condition['roomNo']."'";
	     }
	      #处理时间
	     if(isset($condition['startHandle']) && !empty($condition['startHandle'])){
	        $conditionString.=" and a.handle_time>=".strtotime(trim($condition['startHandle']));
	     }
	     if(isset($condition['endHandle']) && !empty($condition['endHandle'])){
	        $endTime=strtotime(trim($condition['endHandle']))+60*60*24;
	        $conditionString.=" and a.handle_time<=".$endTime;
	     }
	     #处理人
	     if(isset($condition['create_man']) && !empty($condition['create_man'])){
	        $conditionString.=" and a.handle_man = '".$condition['create_man']."'";
	     }
	     if(isset($condition['handle_reason']) && !empty($condition['handle_reason'])){
	        $conditionString.=" and a.handle_reason = '".$condition['handle_reason']."'";
	     }
	     #状态
	     if(isset($condition['status']) && $condition['status']!=""){
	        $conditionString.=" and a.status =".$condition['status'];
	     }
	     #内部人员，外部人员
	     if(isset($condition['is_my'])){
	     	if(empty($condition['is_my'])){
	     		$conditionString.=" and a.is_my = 0 ";
	     	}else if($condition['is_my']=='1'){
	     		$conditionString.=" and a.is_my = 1 ";
	     	}
	     }
        //租金
        if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
           if(is_numeric($condition['moneyMin'])){
             $conditionString.=" and a.room_money>=".$condition['moneyMin'];
           }
        }
        if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
           if(is_numeric($condition['moneyMax'])){
             $conditionString.=" and a.room_money<=".$condition['moneyMax'];
           }
        }
	     #来源
	     if(isset($condition['gaodu_platform']) && $condition['gaodu_platform']!=""){
	        $conditionString.=" and a.gaodu_platform =".$condition['gaodu_platform'];
	     }
	     
	     //房间相关条件
	    if(isset($condition['info_resource_type']) && $condition['info_resource_type']!=""){
	        $conditionString.=" and a.info_resource_type=".$condition['info_resource_type'];
	    }
		if(isset($condition['info_resource']) && $condition['info_resource']!=""){
	        $conditionString.=" and a.info_resource='".$condition['info_resource']."'";
	    }
	    if(isset($condition['is_commission']) && $condition['is_commission']!=''){
          $conditionString.=" and a.is_commission=".$condition['is_commission'];
        }
        if(isset($condition['isMonth']) && $condition['isMonth']!=''){
          $conditionString.=" and a.is_monthly=".$condition['isMonth'];
        }
	    //品牌公寓
        if(isset($condition['brand_type']) && $condition['brand_type']!=""){
          if($condition['brand_type']=='none'){
             $conditionString.=" and a.brand_type=0";
          }else if($condition['brand_type']=='all'){
             $conditionString.=" and a.brand_type>0";
          }else{
             $conditionString.=" and a.brand_type=".$condition['brand_type'];
          }
        }
     $conditionString=$conditionString." and a.city_code='".C('CITY_CODE')."'";
     return $conditionString.' ';
  }
	#list
	public function getModelListCount($condition){
		
	  $conditionString=$this->getConditionString($condition);
	  $model=new \Home\Model\housereservecall();
	  return $model->getModelListCount($conditionString);
	}
	public function getModelList($condition,$limit_start,$limit_end,$orderby=' create_time desc '){

	  $conditionString=$this->getConditionString($condition);
	  $model=new \Home\Model\housereservecall();
	  return $model->getModelList($conditionString,$limit_start,$limit_end,$orderby);
	}
	#下载预约数据
	public function getExeclList($condition,$orderby=' create_time desc '){
	  $conditionString=$this->getConditionString($condition);
	  $sql="select a.customer_name,a.customer_mobile,a.resource_no,a.room_no,a.owner_mobile,a.owner_name,a.create_time,a.handle_time,a.handle_man,a.status,a.look_time,a.handle_reason,a.gaodu_platform,a.info_resource,a.brand_type,is_commission,is_monthly,region_name,scope_name,room_money from gaodu.housereservecall a  where a.record_status=1 ".$conditionString." order by $orderby limit 5000";
	  $model=new \Home\Model\housereservecall();
	  return $model->getExeclList($sql);
	}
	public function getExeclListMorefield($condition,$orderby=' create_time desc '){
	  $conditionString=$this->getConditionString($condition);
	  $sql="select a.customer_name,a.customer_mobile,a.resource_no,a.room_no,a.owner_mobile,a.owner_name,a.create_time,a.handle_time,a.handle_man,a.status,a.look_time,a.handle_reason,a.gaodu_platform,a.info_resource,a.brand_type,is_commission,is_monthly,region_name,scope_name,room_money,room_type,estate_name,owner_id from gaodu.housereservecall a  where a.record_status=1 ".$conditionString." order by $orderby limit 2000";
	  $model=new \Home\Model\housereservecall();
	  return $model->getExeclList($sql);
	}
	public function getCallModelById($id){
		$model=new \Home\Model\housereservecall();
		return $model->getCallModelById($id);
	}
	#历史预约
	public function getModelListByCustomerId($customer_id){
	  $model=new \Home\Model\housereservecall();
	  return $model->getModelListByCustomerId($customer_id);
	}
	public function getNotHandleCount(){
	  $model=new \Home\Model\housereservecall();
	  return $model->getNotHandleCount();
	}
	#获得用户的最大反馈码
	public function getMaxRebackno($phone){
	  $model=new \Home\Model\housereservecall();
	  return $model->getMaxRebackno($phone);
	}
	#获得房间对应的 PC端分机号
	public function getPcExtcodeByRoomid($room_id,$resouce){
	  $big_code='4008151000';
	  if($resouce==3){
	  	$big_code='4008150013';
	  }
	  $model=new \Home\Model\telphoneallot();
	  return $model->getPcExtcodeByRoomid($room_id,$big_code);
	}
	//缓存 读取预约顾问 列表
	public function getAppointHandleList(){
		$city_prex=C('CITY_PREX');
	   $modelDal=new \Home\Model\housereservecall();
	   $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."appoint_handle_men");
	   if(empty($data)){
	      $data = $modelDal->getAppointHandleList();
	      set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."appoint_handle_men",$data,60*60*2);
	   }
	   return $data;
	}
	//操作更多
	#检查
	public function getHadcountByMoreids($array_ids){
		$model=new \Home\Model\housereservecall();
		return $model->getHadcountByMoreids($array_ids);
	}
	#更新
	public function UpdateHandleByMoreids($array_ids,$handle_man,$handle_time,$status){
		$model=new \Home\Model\housereservecall();
		return $model->UpdateHandleByMoreids($array_ids,$handle_man,$handle_time,$status);
	}
	public function UpdateMoreForone($mobile,$handle_man,$handle_time,$status){
		$model=new \Home\Model\housereservecall();
		return $model->UpdateMoreForone($mobile,$handle_man,$handle_time,$status);
	}

	/*帮我找房 */
	public function getfindListCount($condition){
	$conditionString="";
     if(isset($condition['startTime']) && !empty($condition['startTime'])){
        $conditionString.=" and create_time>=".strtotime(trim($condition['startTime']));
     }
     if(isset($condition['endTime']) && !empty($condition['endTime'])){
        $endTime=strtotime(trim($condition['endTime']))+60*60*24;
        $conditionString.=" and create_time<=".$endTime;
     }
     if(isset($condition['mobile']) && !empty($condition['mobile'])){
        $conditionString.=" and user_mobile = '".str_replace("'", "", trim($condition['mobile']))."'";
     }
	  $model=new \Home\Model\housereservecall();
	  return $model->getfindListCount($conditionString);
	}
	public function getfindList($condition,$limit_start,$limit_end){
	 $conditionString="";
     if(isset($condition['startTime']) && !empty($condition['startTime'])){
        $conditionString.=" and create_time>=".strtotime(trim($condition['startTime']));
     }
     if(isset($condition['endTime']) && !empty($condition['endTime'])){
        $endTime=strtotime(trim($condition['endTime']))+60*60*24;
        $conditionString.=" and create_time<=".$endTime;
     }
     if(isset($condition['mobile']) && !empty($condition['mobile'])){
        $conditionString.=" and user_mobile = '".str_replace("'", "", trim($condition['mobile']))."'";
     }
	  $model=new \Home\Model\housereservecall();
	  return $model->getfindList($conditionString,$limit_start,$limit_end);
	}
	public function handlefindhouse($id){
		$model=new \Home\Model\housereservecall();
		$data['id']=$id;
		$data['status']=2;
		$data['handle_time']=time();
		return $model->updatefindhouse($data);
	}
		/*百度寻客 */
		public function getXunkeListCount($condition){
		$conditionString="";
	     if(isset($condition['startTime']) && !empty($condition['startTime'])){
	        $conditionString.=" and querytime>=".strtotime(trim($condition['startTime']));
	     }
	     if(isset($condition['endTime']) && !empty($condition['endTime'])){
	        $endTime=strtotime(trim($condition['endTime']))+60*60*24;
	        $conditionString.=" and querytime<=".$endTime;
	     }
	     if(isset($condition['mobile']) && !empty($condition['mobile'])){
	        $conditionString.=" and mobile = '".str_replace("'", "", trim($condition['mobile']))."'";
	     }
		  $model=new \Home\Model\housereservecall();
		  return $model->getXunkeListCount($conditionString);
		}
		public function getXunkeList($condition,$limit_start,$limit_end){
		 $conditionString="";
	     if(isset($condition['startTime']) && !empty($condition['startTime'])){
	        $conditionString.=" and querytime>=".strtotime(trim($condition['startTime']));
	     }
	     if(isset($condition['endTime']) && !empty($condition['endTime'])){
	        $endTime=strtotime(trim($condition['endTime']))+60*60*24;
	        $conditionString.=" and querytime<=".$endTime;
	     }
	     if(isset($condition['mobile']) && !empty($condition['mobile'])){
	        $conditionString.=" and mobile = '".str_replace("'", "", trim($condition['mobile']))."'";
	     }
		  $model=new \Home\Model\housereservecall();
		  return $model->getXunkeList($conditionString,$limit_start,$limit_end);
		}
		public function handleXunke($id){
			$model=new \Home\Model\housereservecall();
			$data['id']=$id;
			$data['status']=2;
			$data['handle_time']=time();
			return $model->updateXunke($data);
		}

		//发送成功短信
		public function sendmsg_success($name,$mobile,$estate_name,$money,$look_time,$address,$reback_no,$client_mobile,$fourcode_phone=''){
		    #租客短信
		    $sendArr['phoneNumber']=$mobile;
		    $sendArr['sms_type']='YUYUE01';
		    $sendArr['name']=''; 
		    $sendArr['money']=$money;
		    $sendArr['estatename']=str_replace('公寓', 'gongyu', $estate_name);
		    $sendArr['address']=str_replace('公寓', 'gongyu', $address);
		    $sendArr['code']='QX'.$reback_no;
		    $sendArr['infomobile']=$fourcode_phone==''?$client_mobile:$fourcode_phone;
		    $sendArr['timestamp']=$look_time;
		    sendMessage_yuyue($sendArr);
		    #房东短信
		    $sendArray['phoneNumber']=$client_mobile;
		    $sendArray['sms_type']='YUYUE03';
		    $sendArray['name']=str_replace('公寓', 'gongyu', $name);
		    $sendArray['money']=$money;
		    $sendArray['estatename']=str_replace('公寓', 'gongyu', $estate_name);
		    $sendArray['address']=str_replace('公寓', 'gongyu', $address);
		    $sendArray['code']='QX'.$reback_no;
		    $sendArray['infomobile']=$mobile;
		    $sendArray['timestamp']=$look_time;
		    sendMessage_yuyue($sendArray);
		}

		//预约成功，第二次短信待发送数据
		public function getTwoSendMessageData(){
			$date_now=strtotime(date('Y-m-d'));
			$date_b=$date_now+3600*24;
			$date_bb=$date_now+3600*24*2;
			$model=new \Home\Model\housereservecall();
			return $model->getListByWhere("customer_name,customer_mobile,owner_mobile,owner_id,estate_name,room_money,look_time,reback_no,estate_id",
				"look_time >=$date_b and  look_time<$date_bb  and status=2 and record_status=1 and reback_no>0 and handle_time<$date_now limit 200");
		}
}
?>
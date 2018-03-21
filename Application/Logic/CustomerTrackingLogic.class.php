<?php
namespace Logic;
/*租客追踪 */
class CustomerTrackingLogic{
	
	public function getCustomerTrackingById($id){
		$modelDal=new \Home\Model\customertracking();
		return $modelDal->getModelById($id);
	}
	
	#list
	public function getModelListCount($condition){
	  $conditionString=$this->getConditionString($condition);
	  if(!empty($conditionString)){
	  	$conditionString=' where '.substr(trim($conditionString), 3);
	  }
	  $model=new \Home\Model\customertracking();
	  return $model->getModelListCount($conditionString);
	}
	public function getModelList($condition,$limit_start,$limit_end){
	  $conditionString=$this->getConditionString($condition);
	  if(!empty($conditionString)){
	  	$conditionString=' where '.substr(trim($conditionString), 3);
	  }	
	  $model=new \Home\Model\customertracking();
	  return $model->getModelList($conditionString,$limit_start,$limit_end);
	}
	private function getConditionString($condition)
	{
		$conditionString="";
		if (isset($condition['mobile']) && !empty($condition['mobile'])) {
			$conditionString.=" and mobile='".$condition['mobile']."'";
		}
		if (isset($condition['status']) && !empty($condition['status'])) {
			$conditionString.=" and renter_status='".$condition['status']."'";
		}
		if (isset($condition['is_monthly']) && $condition['is_monthly']!="") {
			if(!is_numeric($condition['is_monthly'])){
				return " and 1=0 ";
			}
			$conditionString.=" and is_monthly=".$condition['is_monthly'];
		}
		if (isset($condition['is_commission']) && $condition['is_commission']!="") {
			if(!is_numeric($condition['is_commission'])){
				return " and 1=0 ";
			}
			$conditionString.=" and is_commission=".$condition['is_commission'];
		}
		if (isset($condition['is_look']) && $condition['is_look']!="") {
			if(!is_numeric($condition['is_look'])){
				return " and 1=0 ";
			}
			$conditionString.=" and is_look=".$condition['is_look'];
		}
		if (isset($condition['is_getcommission']) && $condition['is_getcommission']!="") {
			if(!is_numeric($condition['is_getcommission'])){
				return " and 1=0 ";
			}
			$conditionString.=" and is_getcommission=".$condition['is_getcommission'];
		}
		if (isset($condition['is_satisfied']) && $condition['is_satisfied']!="") {
			if(!is_numeric($condition['is_satisfied']))return " and 1=0 ";
			$conditionString.=" and is_satisfied=".$condition['is_satisfied'];
		}
		if (isset($condition['is_recommend']) && $condition['is_recommend']!="") {
			if(!is_numeric($condition['is_recommend']))return " and 1=0 ";
			$conditionString.=" and is_recommend=".$condition['is_recommend'];
		}
		//申请返现
		if (isset($condition['applyback_status']) && $condition['applyback_status']!="") {
			if(!is_numeric($condition['applyback_status']))return " and 1=0 ";
			$conditionString.=" and applyback_status=".$condition['applyback_status'];
		}
		//申请返现时间
		if(isset($condition['startTime_applyback']) && trim($condition['startTime_applyback'])!=''){
	        $conditionString.=" and applyback_time>=".strtotime(trim($condition['startTime_applyback']));
	    }
	    if(isset($condition['endTime_applyback']) && trim($condition['endTime_applyback'])!=''){
	        $endTime=strtotime(trim($condition['endTime_applyback']));
	        $endTime=$endTime+60*60*24;
	        $conditionString.=" and applyback_time<=".$endTime;
	    }
	    //二次回访
		if (isset($condition['second_visit']) && $condition['second_visit']!="") {
			if(!is_numeric($condition['second_visit']))return " and 1=0 ";
			$conditionString.=" and second_visit=".$condition['second_visit'];
		}
		//回访来源
		if (isset($condition['visit_source']) && $condition['visit_source']!="") {
			if(!is_numeric($condition['visit_source']))return " and 1=0 ";
			$conditionString.=" and visit_source=".$condition['visit_source'];
		}
	     //注册时间
	     if(isset($condition['startTime_register']) && trim($condition['startTime_register'])!=''){
	        $conditionString.=" and register_time>=".strtotime(trim($condition['startTime_register']));
	     }
	     if(isset($condition['endTime_register']) && trim($condition['endTime_register'])!=''){
	        $endTime=strtotime(trim($condition['endTime_register']));
	        $endTime=$endTime+60*60*24;
	        $conditionString.=" and register_time<=".$endTime;
	     }
	     if(isset($condition['is_tracking'])){
	     	if($condition['is_tracking']=="1"){
	     		$conditionString.=" and update_time>=1 ";
	     	}else if($condition['is_tracking']=="2"){
	     		$conditionString.=" and update_time=0 ";
	     	}
	     }
	     if(isset($condition['city_code']) && trim($condition['city_code'])!=''){
	        $conditionString.=" and city_code='".trim($condition['city_code'])."' ";
	     }
	     if(isset($condition['renter_sourcetype']) && trim($condition['renter_sourcetype'])!=''){
	        $conditionString.=" and renter_sourcetype=".$condition['renter_sourcetype'];
	     }
	      if(isset($condition['renter_source']) && trim($condition['renter_source'])!=''){
	        $conditionString.=" and renter_source='".str_replace("'", "", trim($condition['renter_source']))."' ";
	     }
	     //回访时间
	      $tracking_time="";
	      if(isset($condition['startTime_tracking']) && trim($condition['startTime_tracking'])!=''){
	      	$time_stamp=strtotime(trim($condition['startTime_tracking']));
	      	if($time_stamp===false)
	      		return " and 1=0 ";
	         $tracking_time.=" and create_time>=".$time_stamp;
	      }
	      if(isset($condition['endTime_tracking']) && trim($condition['endTime_tracking'])!=''){
	         $time_stamp=strtotime(trim($condition['endTime_tracking']));
	         if($time_stamp===false)
	      		return " and 1=0 ";
	         $tracking_time.=" and create_time<=".($time_stamp+3600*24);
	      }
	      if(!empty($tracking_time)){
	      	$conditionString.=" and exists(select 1 from customertrackinglog where tracking_id=a.id $tracking_time)";
	      }
	     
	     if (isset($condition['handleType']) && $condition['handleType']=="outer") {
	     		//并集
	     		if(isset($condition['is_appoint']) && $condition['is_appoint']=="1" && isset($condition['is_contact']) && $condition['is_contact']=="1"){
	     			$conditionString.=" and (appoint_count>=1 or contact_count>=1) ";
	     		}else if(!empty($condition['startTime_appoint']) && !empty($condition['endTime_appoint']) && !empty($condition['startTime_contact']) && !empty($condition['endTime_contact']) ){
			     	$appointtime=" and create_time>=".strtotime($condition['startTime_appoint']);
			     	$appointtime.=" and create_time<=".(strtotime($condition['endTime_appoint'])+3600*24);
			     	$contacttime=" and big_code <>'4008108756' and is_marketing=0 and create_time>=".strtotime($condition['startTime_contact']);
			     	$contacttime.=" and create_time<=".(strtotime($condition['endTime_contact'])+3600*24);
			     	if(isset($condition['unknown']) && (strtolower($condition['unknown'])=='on' || $condition['unknown']=='1')){
			     	  $contacttime.=" and status_code>=0";
			     	}
			     	if(isset($condition['abandon']) && (strtolower($condition['abandon'])=='on' || $condition['abandon']=='1')){
			     	  $contacttime.=" and status_code<>11";
			     	}
			     	$conditionString.=" and (exists(select 1 from housereservecall hc where hc.customer_mobile=a.mobile $appointtime) or exists(select 1 from houserentercall hc where hc.mobile=a.mobile $contacttime))";
			    }
	     }else if(isset($condition['handleType']) && $condition['handleType']=="inner"){
	     		//交集
	     		if(isset($condition['is_appoint']) && $condition['is_appoint']=="1" && isset($condition['is_contact']) && $condition['is_contact']=="1"){
	     			$conditionString.=" and appoint_count>=1 and contact_count>=1 ";
	     		}else if(!empty($condition['startTime_appoint']) && !empty($condition['endTime_appoint']) && !empty($condition['startTime_contact']) && !empty($condition['endTime_contact']) ){
			     	$appointtime=" and create_time>=".strtotime($condition['startTime_appoint']);
			     	$appointtime.=" and create_time<=".(strtotime($condition['endTime_appoint'])+3600*24);
			     	$contacttime=" and big_code <>'4008108756' and is_marketing=0 and create_time>=".strtotime($condition['startTime_contact']);
			     	$contacttime.=" and create_time<=".(strtotime($condition['endTime_contact'])+3600*24);
			     	if(isset($condition['unknown']) && (strtolower($condition['unknown'])=='on' || $condition['unknown']=='1')){
     		     	  $contacttime.=" and status_code>=0";
     		     	}
     		     	if(isset($condition['abandon']) && (strtolower($condition['abandon'])=='on' || $condition['abandon']=='1')){
     		     	  $contacttime.=" and status_code<>11";
     		     	}
			     	$conditionString.=" and appoint_count>=1 and contact_count>=1 and exists(select 1 from housereservecall hc where hc.customer_mobile=a.mobile $appointtime) and exists(select 1 from houserentercall hc where hc.mobile=a.mobile $contacttime)";
			    }
	     }else{
	     	if(isset($condition['is_appoint'])){
	     		if($condition['is_appoint']=="1"){
	     			$conditionString.=" and appoint_count>=1 ";
	     		}else if($condition['is_appoint']=="2"){
	     			$conditionString.=" and appoint_count=0 ";
	     		}
	     	}
	     	if(isset($condition['is_contact'])){
	     		if($condition['is_contact']=="1"){
	     			$conditionString.=" and contact_count>=1 ";
	     		}else if($condition['is_contact']=="2"){
	     			$conditionString.=" and contact_count=0 ";
	     		}
	     	}
		     $time_stamp=0;
		     //看房时间
		     $looktime="";
		     if(isset($condition['startTime_look']) && trim($condition['startTime_look'])!=''){
		     	$time_stamp=strtotime(trim($condition['startTime_look']));
		     	if($time_stamp===false)return " and 1=0 ";
		        $looktime.=" and view_time>=".$time_stamp;
		     }
		     if(isset($condition['endTime_look']) && trim($condition['endTime_look'])!=''){
		     	$time_stamp=strtotime(trim($condition['endTime_look']));
		     	if($time_stamp===false)return " and 1=0 ";
		        $looktime.=" and view_time<=".($time_stamp+3600*24);
		     }
		     if(!empty($looktime)){
		     	$conditionString.=" and exists(select 1 from housereserve where customer_id=a.customer_id and record_status=1 $looktime)";
		     }else{
		     	//预约时间
			     $appointtime="";
			     if(isset($condition['startTime_appoint']) && trim($condition['startTime_appoint'])!=''){
			     	$time_stamp=strtotime(trim($condition['startTime_appoint']));
			     	if($time_stamp===false)return " and 1=0 ";
			        $appointtime.=" and create_time>=".$time_stamp;
			     }
			     if(isset($condition['endTime_appoint']) && trim($condition['endTime_appoint'])!=''){
			     	$time_stamp=strtotime(trim($condition['endTime_appoint']));
			     	if($time_stamp===false)return " and 1=0 ";
			        $appointtime.=" and create_time<=".($time_stamp+3600*24);
			     }
			     if(!empty($appointtime)){
			     	$conditionString.=" and appoint_count>=1 and exists(select 1 from housereservecall hc where hc.customer_mobile=a.mobile $appointtime)";
			     }else{
	     	     	 //联系时间
	     		     $contacttime="";
	     		     if(isset($condition['startTime_contact']) && trim($condition['startTime_contact'])!=''){
	     		     	$time_stamp=strtotime(trim($condition['startTime_contact']));
	     		     	if($time_stamp===false)return " and 1=0 ";
	     		        $contacttime.=" and create_time>=".$time_stamp;
	     		     }
	     		     if(isset($condition['endTime_contact']) && trim($condition['endTime_contact'])!=''){
	     		     	$time_stamp=strtotime(trim($condition['endTime_contact']));
	     		     	if($time_stamp===false)return " and 1=0 ";
	     		        $contacttime.=" and create_time<=".($time_stamp+3600*24);
	     		     }
	     		     if(!empty($contacttime)){
	     		     	$contacttime.=" and big_code <>'4008108756' and is_marketing=0 ";
	     		     	if(isset($condition['unknown']) && (strtolower($condition['unknown'])=='on' || $condition['unknown']=='1')){
	     		     	  $contacttime.=" and status_code>=0";
	     		     	}
	     		     	if(isset($condition['abandon']) && (strtolower($condition['abandon'])=='on' || $condition['abandon']=='1')){
	     		     	  $contacttime.=" and status_code<>11";
	     		     	}
	     		     	$conditionString.=" and contact_count>=1 and exists(select 1 from houserentercall hc where hc.mobile=a.mobile $contacttime)";
	     		     }
			     }
		     }
	    }
		return $conditionString;
	}
	#update
	public function updateCustomerTracking($data){
		if(!is_array($data)){
			return false;
		}
		if($data['renter_room']!=''){
			$roomDal=new \Home\Model\houseroom();
			$roomResult=$roomDal->getResultByWhere("id,info_resource"," where room_no='".$data['renter_room']."' ");
			if($roomResult!=null && count($roomResult)>0){
				$data['renter_source']=$roomResult[0]['info_resource'];
			}
		}
		$modelDal=new \Home\Model\customertracking();
		$result = $modelDal->updateModel($data);
		if($result){
			//新增日志
			$log['tracking_id']=$data['id'];
			$log['renter_status']=$data['renter_status'];
			$log['renter_room']=$data['renter_room'];
			$log['renter_time']=$data['renter_time'];
			$log['renter_sourcetype']=$data['renter_sourcetype'];
			$log['renter_source']=$data['renter_source'];
			$log['bakinfo']=$data['bakinfo'];
			$log['is_service']=$data['is_service'];
			$log['is_look']=$data['is_look'];
			$log['is_satisfied']=$data['is_satisfied'];
			$log['is_recommend']=$data['is_recommend'];
			$log['create_time']=$data['update_time'];
			$log['create_man']=$data['update_man'];
			$log['is_cashback']=$data['is_cashback'];
			$log['visit_source'] = $data['visit_source'];
			$log['second_visit'] = $data['second_visit'];
			return $modelDal->addLogModel($log);
		}
		return false;
	}
	//获取联系记录
	public function getContactsByMobile($mobile)
	{
		$modelDal=new \Home\Model\customertracking();
		$list = $modelDal->getContactsByMobile($mobile);
		$list_new=array();
		if($list!=null && count($list)>0){
			foreach ($list as $key => $value) {
				$is_commission=$value['is_commission']=='1'?'是':'否';
				$is_monthly=$value['is_monthly']=='1'?'是':'否';
				array_push($list_new, array('room_no'=>$value['room_no'],'region_name'=>$value['region_name'],'scope_name'=>$value['scope_name'],'estate_name'=>$value['estate_name'],
					'room_money'=>$value['room_money'],'call_time'=>$value['create_time'],'info_resource'=>$value['info_resource'],'is_commission'=>$is_commission,'is_monthly'=>$is_monthly));
			}
		}
		return $list_new;
	}
	//获取预约记录
	public function getAppointsByMobile($mobile)
	{
		$modelDal=new \Home\Model\customertracking();
		$list = $modelDal->getAppointsByMobile($mobile);
		$list_new=array();
		if($list!=null && count($list)>0){
			foreach ($list as $key => $value) {
				$is_commission=$value['is_commission']=='1'?'是':'否';
				$is_monthly=$value['is_monthly']=='1'?'是':'否';
				array_push($list_new, array('status'=>$value['status'],'room_no'=>$value['room_no'],'region_name'=>$value['region_name'],'scope_name'=>$value['scope_name'],
					'estate_name'=>$value['estate_name'],'room_money'=>$value['room_money'],'create_time'=>$value['create_time'],'info_resource'=>$value['info_resource'],
					'is_commission'=>$is_commission,'is_monthly'=>$is_monthly,'look_time'=>$value['look_time']));
			}
		}
		return $list_new;
	}
	//获取看房日程记录
	public function getLookHouseinfoByCustomerid($customer_id)
	{
		$modelDal=new \Home\Model\customertracking();
		$list = $modelDal->getLookHouseinfoByCustomerid($customer_id);
		$list_new=array();
		if($list!==false && $list!==null && count($list)>0){
			foreach ($list as $key => $value) {
				if(empty($value['room_id'])){
					array_push($list_new, array('room_no'=>$value['room_no'],'region_name'=>$value['region_name'],'scope_name'=>$value['scope_name'],'estate_name'=>$value['estate_name'],
						'room_money'=>$value['room_money'],'is_commission'=>'','is_monthly'=>'','view_time'=>$value['view_time'],'is_view'=>$value['is_view']));
					continue;
				}
				//查询佣金，包月
				$is_commission='否';
				$is_monthly='否';
				$roomData=$modelDal->getHouseRoomById($value['room_id']);
				if($roomData!=null && count($roomData)>0){
					if($roomData[0]['is_commission']=='1'){
						$is_commission='是';
					}
					if($roomData[0]['is_monthly']=='1'){
						$is_monthly='是';
					}
				}
				array_push($list_new, array('room_no'=>$value['room_no'],'region_name'=>$value['region_name'],'scope_name'=>$value['scope_name'],'estate_name'=>$value['estate_name'],
					'room_money'=>$value['room_money'],'is_commission'=>$is_commission,'is_monthly'=>$is_monthly,'view_time'=>$value['view_time'],'is_view'=>$value['is_view']));
			}
		}
		return $list_new;
	}
	//回访记录
   public function getTrackingsById($tracking_id){
      $modelDal=new \Home\Model\customertracking();
	  return $modelDal->getTrackingsById($tracking_id);
	}
	//根据customer_id获取申请返现记录
	public function getCouponCashInfo ($mobile)
	{
		$modelDal = new \Home\Model\customertracking();
		$fields = "room_id,price,create_time";
		$where['mobile'] = $mobile; 
	  	$data = $modelDal->modelGetCouponCash($fields,$where);
	  	return $data;
	}
	//根据customer_id查找申请返现状态
	public function findCouponCashStatus ($mobile)
	{
		$modelDal = new \Home\Model\customertracking();
		$fields = "status_code";
		$where['mobile'] = $mobile; 
	  	$data = $modelDal->modelFindCouponCash($fields,$where);
	  	return $data;
	}
	//根据resource_id查找区域、小区
	public function findHouseResourceInfo ($rid)
	{
		if(empty($rid)) return null;
		$modelDal = new \Home\Model\customertracking();
		$fields = "region_name,scope_name,info_resource_type";
		$where['id'] = $rid; 
	  	$data = $modelDal->modelFindHouseResource($fields,$where);
	  	return $data;
	}
	//room_id查找resource_id
	public function findHouseRoomInfo ($roomid)
	{
		if(empty($roomid)) return null;
		$modelDal = new \Home\Model\customertracking();
		$fields = "resource_id,room_no,room_money";
		$where['id'] = $roomid; 
	  	$data = $modelDal->modelGetHouseRoom($fields,$where);
	  	return $data;
	}
	//根据customer_id修改最近的申请
	public function updateCouponCash ($data)
	{
		if(empty($data['customer_id'])) return false;
		$modelDal = new \Home\Model\customertracking();
		$where['customer_id'] = $data['customer_id']; 
		$info['status_code'] = $data['status_code'];
		$info['confirm_time'] = time();
	  	$result = $modelDal->modelUpdateCouponCash($where,$info);
	  	return $result;
	}
	//根据customer_id查找coupon_id
	public function findCouponCash ($data)
	{
		if(empty($data['customer_id'])) return false;
		$modelDal = new \Home\Model\customertracking();
		$fields = "coupon_id,id";
		$where['customer_id'] = $data['customer_id']; 
	  	$result = $modelDal->modelFindCouponCash($fields,$where);
	  	return $result;
	}
	//根据coupon_id修改customercoupon中status_code
	public function updateCustomerCoupon ($data)
	{
		if(empty($data['coupon_id'])) return false;
		$modelDal = new \Home\Model\customertracking();
		$where['id'] = $data['coupon_id']; 
		if($data['status_code'] == 4) {
			$info['flag'] = 1;
		}
		$info['status_code'] = $data['status_code'];
	  	$result = $modelDal->modelUpdateCustomerCoupon($where,$info);
	  	return $result;
	}
	//根据coupon_id修改couponstatus中status_code
	public function updateCouponStatus ($data)
	{
		if(empty($data['coupon_id'])) return false;
		$modelDal = new \Home\Model\customertracking();
		$where['coupon_id'] = $data['coupon_id']; 
		$info['status_code'] = $data['status_code'];
	  	$result = $modelDal->modelUpdateCouponStatus($where,$info);
	  	return $result;
	}
	//根据邮箱发送返现邮件
	public function sendCashBackEmail ($data)
	{
		if(empty($data['customer_id'])) return false;
		$modelDal = new \Home\Model\customertracking();
		switch ($data['city_code']) {
			case '001009001':
				$city = '上海';
				break;
			case '001001':
				$city = '北京';
				break;
			case '001011001':
				$city = '杭州';
				break;
			case '001010001':
				$city = '南京';
				break;
			case '001019002':
				$city = '深圳';
				break;
			default:
				break;
		}
		$info['id'] = guid();
		$info['customer_id'] = $data['customer_id'];
		$info['mail_to'] = "zhangjiaying@hizhu.com;xiaqingning@hizhu.com;xilifang@hizhu.com";
		$info['mail_to_name'] = "张佳颖;夏青宁;奚丽芳";
		$info['mail_subject'] = "【".$city."】返现打款";
		$info['mail_content'] = "租客".$data['customer_mobile']."提交的返现申请已通过，请点击<a href='http://120.26.119.103/admin/CashBack/cashBackList.html?no=7&leftno=185&mobile=".$data['customer_mobile']."'>http://120.26.119.103/admin/CashBack/cashBackList.html?no=7&leftno=185&mobile=".$data['customer_mobile']."<a>进行操作";
		$info['mail_type'] = 0;
		$info['create_time'] = time();
		$result = $modelDal->modelAddCustomerEmail($info); 
	  	return $result;
	}
	//根据手机号查找customer_id
	public function findCustomerID ($mobile)
	{
		if(empty($mobile)) return false;
		$modelDal = new \Home\Model\customertracking();
		$fields = "id";
		$where['mobile'] = $mobile; 
	  	$result = $modelDal->modelFindCustomer($fields,$where);
	  	return $result;
	}
	//根据customer_id查找principal_man和统计在架数量
	public function findCustomerInfo ($cid,$type)
	{
		if(empty($cid)) return null;
		$modelDal = new \Home\Model\customertracking();
		$fields = "principal_man";
		$where['customer_id'] = $cid; 
	  	$result = $modelDal->modelFindCustomerInfo($fields,$where);
	  	$info['principal_man'] = $result['principal_man'];
	  	$whereTwo['customer_id'] = $cid;
	  	$whereTwo['status'] = 2;
	  	$rooms = $modelDal->modelCountHouseRoom($whereTwo);
	  	if($type == 5) {
		  	$whereOne['customer_id'] = $cid; 
		  	$whereOne['is_my'] = 0;
		  	$whereOne['status_code'] = 3;
		  	$whereOne['record_status'] = 1;
		  	$offers = $modelDal->modelCountHouseOffer($whereOne);
	  		$info['limit_count'] = $rooms+$offers;
	  	} else {
	  		$info['limit_count'] = $rooms;
	  	}	
	  	return $info;
	}
}
?>
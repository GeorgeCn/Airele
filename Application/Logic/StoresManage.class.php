<?php
namespace Logic;
use Think\Controller;
class StoresManage 
{
	//新建店铺信息
	public function createStoreInfo ($data)
	{
		$modelDal = new \Home\Model\stores();
		unset($data['mobile']);
		$data['id'] = guid();
		$data['city_code']=C('CITY_CODE');
		$data['create_time'] = time();
		$login_name=trim(getLoginName());
		$data['create_man_id'] = $login_name;
		$data['man_count'] = 1;
		$modelDal->modelAddStore($data);
		$result['store_id'] = $data['id'];
		$result['store_name'] = $data['name'];
		$result['city_code'] = $data['city_code'];
		return $result;
	}
	//根据store_id修改店铺title
	public function modifyStoreTitle ($data)
	{
		$modelDal = new \Home\Model\stores();
		$result = $modelDal->modelModifyStore($data);
		return $result;
	}
	//根据store_id查找店铺title
	public function findStoreTitle ($sid)
	{
		if(empty($sid)) return null;
		$modelDal = new \Home\Model\stores();
		$fields = 'name'; 
		$where['id'] = $sid;
		$result = $modelDal->modelFindStore($fields,$where);
		return $result;
	}
	//根据name查找店铺id
	public function findStoreIdByName ($name)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'id'; 
		$where['name'] = $name;
		$where['record_status'] = 1;
		$result = $modelDal->modelFindStore($fields,$where);
		return $result;
	}
	//根据store_id修改店铺Type
	public function modifyStoreType ($data)
	{
		$modelDal = new \Home\Model\stores();
		unset($data['type']);
		$data['update_time'] = time();
		$login_name=trim(getLoginName());
		$data['update_man'] = $login_name;
		$result = $modelDal->modelModifyStore($data);
		return $result;
	}
	//根据customer_id查找storemembers中store_id
	public function findStoreId ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'store_id'; 
		$where['customer_id'] = $cid;
		$result = $modelDal->modelFindStoreMem($fields,$where);
		return $result;
	}
	//查找storemembers中的store_name
	public function findStoreName ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$where = "customer_id= '{$cid}' and title_id=300 and record_status=1 and store_name<>'我的房源'";
		$fields = 'store_name'; 
		$result = $modelDal->modelFindStoreMem($fields,$where);
		return $result;
	}
	//修改店铺成员职位
	public function modifyStoreMemTitle ($data)
	{
		$where['store_id'] = $data['store_id'];
		$where['customer_id'] = $data['customer_id'];
		$title['title_id'] = $data['title_id']; 
		$modelDal = new \Home\Model\stores();
		$result = $modelDal->modelUpdateStoreMem($where,$title);
		return $result;
	}
	//新建店铺成员信息
	public function createStoreMem ($data)
	{
		$modelDal = new \Home\Model\stores();
		$data['id'] = guid();
		$data['create_time'] = time();
		$data['city_code']=C('CITY_CODE');
		$result = $modelDal->modelAddStoreMem($data);
		return $result;
	}
	//店铺成员自增+1
	public function UpdateStoreMan ($id)
	{
		$modelDal = new \Home\Model\stores();
		$where = array();
		$where['id'] = $id;
		$field = 'man_count';
		$num = 1;
		$result = $modelDal->modelUpdateStore($where,$field,$num);
		return $result;
	}
	//新建成员权限
	public function createStoreMemLimit ($data)
	{
		$modelDal = new \Home\Model\stores();
		$info = array();
		for($i=1;$i<5;$i++) {
			$info['id'] = guid();
			$info['customer_id'] = $data['customer_id'];
			$info['store_id'] = $data['store_id'];
			$info['create_time'] = time();
			$info['limit_id']=$i;
			$modelDal->modelAddStoreMemLimit($info);
		} 
	}
	//根据store_id获取店长customer_id
	public function getCustomerId ($sid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'customer_id';
		$where['store_id'] = $sid;
		$where['title_id'] = 300; 
		$where['record_status'] = 1;
		$result = $modelDal->modelFindStoreMem($fields,$where);
		return $result;
	}
	//根据store_id获取customer_id
	public function getAllCustomerId ($sid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'customer_id,title_id';
		$where['store_id'] = $sid;
		$where['record_status'] = 1;
		$result = $modelDal->modelGetStoreMem($fields,$where);
		return $result;
	}
	//根据customer_id获取用户信息
	public function getCustomerInfo ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'mobile,true_name';
		$where['id'] = $cid;
		$where['record_status'] = 1;
		$result = $modelDal->modelFindCustomer($fields,$where);
		return $result;
	}
	//根据customer_id获取用户手机号码
	public function getCustomerMobile ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'mobile';
		$where['id'] = $cid;
		$where['record_status'] = 1;
		$result = $modelDal->modelFindCustomer($fields,$where);
		return $result['mobile'];
	}
	//根据store_id获取房间数量
	public function countRoomNum ($sid)
	{
		$modelDal = new \Home\Model\stores();
		if ($sid == '') {
			$result = 0;
		} else {
		$where['store_id'] = $sid;
		$where['record_status'] = 1;
		$result = $modelDal->modelCountRoom($where);		
		}
		return $result;
	}
	//根据mobile查找store_id
	public function getStoreId ($mobile)
	{
		$modelDal = new \Home\Model\stores();
		$field = 'id';
		$cid = $modelDal->modelFindCustomer($field,$mobile);
		$char = 'store_id';
		$condition['customer_id'] = $cid['id'];
		$condition['record_status'] = 1;
		$store_id = $modelDal->modelFindStoreMem($char,$condition);
		$sid = $store_id['store_id'];
		return $sid;
	}
	//根据mobile获取store_id
	public function getStoreIdByMobile ($mobile)
	{
		$modelDal = new \Home\Model\stores();
		$field = 'id';
		$cid = $modelDal->modelFindCustomer($field,$mobile);
		$char = 'store_id';
		$condition['customer_id'] = $cid['id'];
		$condition['city_code'] = C('CITY_CODE');
		$condition['record_status'] = 1;
		$store_id = $modelDal->modelGetStoreMem($char,$condition);
		return $store_id;
	}
	//根据mobile获取我的房源store_id
	public function getMyHouseStoreIdByMobile ($mobile)
	{
		$modelDal = new \Home\Model\stores();
		$field = 'id';
		$cid = $modelDal->modelFindCustomer($field,$mobile);
		$char = 'store_id';
		$condition['customer_id'] = $cid['id'];
		$condition['is_special'] = 1;
		$condition['record_status'] = 1;
		$sid = $modelDal->modelGetStoreMem($char,$condition);
		return $sid[0]['store_id'];
	}
	//根据mobile查找customer_id
	public function findCustomerId ($mobile)
	{
		if(empty($mobile)) return null;
		$modelDal = new \Home\Model\stores();
		$fields = 'id';
		$where['mobile'] = $mobile; 
		$where['record_status'] = 1;
		$result = $modelDal->modelFindCustomer($fields,$where);
		return $result;
	}
	//根据customer_id获取store_id
	public function getRoomStoreId ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'resource_id,store_id';
		$where['customer_id'] = $cid;
		$where['record_status'] = 1;
		$result = $modelDal->modelGetRoomInfo('','',$fields,$where);
		return $result;
	}
	//根据customer_id获取room_no
	public function getHouseRoomInfo ($cid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'resource_id,room_no';
		$where['customer_id'] = $cid;
		$where['record_status'] = 1;
		$result = $modelDal->modelGetRoomInfo('','',$fields,$where);
		return $result;
	}
	//根据room_no查找resource_id
	public function findResourceId ($room)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'id,resource_id,customer_id,store_id,record_status';
		$where['room_no'] = $room;
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result;
	}
	//根据room_no查找room_money
	public function findRoomMoney ($room)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'room_money';
		$where['room_no'] = $room;
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result;
	} 
	//根据room_no查找is_commission、is_monthly
	public function findCommission ($room)
	{
		if(empty($room)) return null;
		$modelDal = new \Home\Model\stores();
		$fields = 'is_commission,is_monthly';
		$where['room_no'] = $room;
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result;
	}                                    
	//根据room_no修改houseroom中customer_id和store_id
	public function modifyHouseRoom ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['room_no'] = $data['room_no'];
		$info['customer_id'] = $data['customer_id'];
		$info['store_id'] = $data['store_id'];
		$result = $modelDal->modelUpdateHouseRoom($where,$info);
		return $result;
	}
	//根据customer_id修改houseroom中store_id
	public function modifyRoomStoreId ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['room_no'] = $data['room_no'];
		$info['store_id'] = $data['store_id'];
		$result = $modelDal->modelUpdateHouseRoom($where,$info);
		return $result;
	}
	//根据resource_id修改houseresource中customer_id和store_id
	public function modifyHouseResource ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['resource_id'];
		$info['customer_id'] = $data['customer_id'];
		$info['store_id'] = $data['store_id'];
		$temp = $this->getCustomerInfo($data['customer_id']);
		$info['client_phone'] = $temp['mobile']; 
		$result = $modelDal->modelUpdateHouseResource($where,$info);
		return $result;
	}
	//根据resource_id修改houseresource中store_id
	public function modifyHouseStoreId ($data)
	{
		$modelDal = new \Home\Model\stores();
		$result = $this->findResourceId($data['room_no']);
		$where['id'] = $result['resource_id'];
		$info['store_id'] = $data['store_id'];
		$result = $modelDal->modelUpdateHouseResource($where,$info);
		return $result;
	}
	//根据resource_id修改houseselect中store_id
	public function modifyHouseSelectStoreId ($data)
	{
		$modelDal = new \Home\Model\stores();
		$resourceId = $this->findResourceId($data['room_no']); 
		$where['resource_id'] = $resourceId['resource_id'];
		$info['store_id'] = $data['store_id'];
		$result = $modelDal->modelUpdateHouseSelect($where,$info);
		return $result;
	}
	//根据room_id修改storehouses中的customer_id和store_id
	public function modifyStoreHouses ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['house_id'] = $data['resource_id'];
		$info['customer_id'] = $data['customer_id'];
		$info['store_id'] = $data['store_id'];
		$result = $modelDal->modelUpdateStoreHouses($where,$info);
		return $result;
	}
	//新建房源移动记录
	public function createStoreOperDetail ($data)
	{
		$modelDal = new \Home\Model\stores();
		$info['id'] = guid();
		$info['customer_id'] = $data['customer_id_old'];
		$info['store_id'] = $data['store_id_old'];
		$info['oper_type'] = 7;
		$info['room_id'] = $data['room_id'];
		$info['house_id'] = $data['house_id'];
		$info['create_time'] = time();
		$info['customer_id_new'] = $data['customer_id'];
		$info['store_id_new'] = $data['store_id'];
		$result = $modelDal->modelAddStoreOperDetail($info);
		return $result;
	}
	//根据id删除反馈信息和成交信息
	public function deleteHouseFback ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['id'];
		$info['record_status'] = '0';
		$info['update_man'] = $data['update_man'];
		$fields = 'room_id,is_deal';
		$data = $modelDal->modelFindFback($fields,$where);
		if($data['is_deal'] == 1) {
			$condition['room_id'] = $data['room_id']; 
			$modelDal->modelDeleteDeal($condition,$info);
			$result = $modelDal->modelDeleteFback($where,$info);
		} else {
			$result = $modelDal->modelDeleteFback($where,$info);
		}
		return $result;
	}
	//根据id删除房源信息
	public function deleteHouseRoom ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['id'];
		$info['record_status'] = '0';
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$result = $modelDal->modelDeleteHouseRoom($where,$info);
		return $result;
	}
	//根据store_id下架置顶房源
	public function downStickyRoom ($sid)
	{
		$modelDal = new \Home\Model\stores();
		$where['store_id'] = $sid;
		$where['top_type'] = 4;
		$where['top_resource'] = 1;
		$result = $modelDal->modelDeleteHouseSelect($where);
		return $result;
	}
	//根据store_id查找房间反馈信息
	public function findHouseFback ($sid)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'is_true_deal,room_no,store_id';
		$where['id'] = $sid;
		$result = $modelDal->modelFindFback($fields,$where);
		return $result;
	}
	//根据room_no查找房间反馈信息
	public function findHouseFbackInfo ($room)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'id';
		$where['room_no'] = $room;
		$where['city_code'] = C('CITY_CODE');
		$where['is_true_deal'] = 1;
		$result = $modelDal->modelFindFback($fields,$where);
		return $result;
	}
	//根据store_id修改房间反馈信息is_true_deal
	public function modifyHouseFback ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['id'];
		$info['is_true_deal'] = $data['is_true_deal'];
		$result = $modelDal->modelUpdateFback($where,$info);
		return $result;
	}
	//根据store_id修改房间反馈信息is_true_show
	public function modifyHouseFbackIsShow ($data)
	{
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['id'];
		$info['is_true_show'] = $data['is_true_show'];
		$result = $modelDal->modelUpdateFback($where,$info);
		return $result;
	}
	//根据store_id创建店铺信用分
	public function createStoreCreditDetail ($data)
	{
		//我的房源店铺不加信用分
		$title = $this->findStoreTitle($data['id']);
		if($title == '我的房源') return ;
		$modelDal = new \Home\Model\stores();
		$info = array();
		if($data['sign'] == '-') {
			$info['score_num'] = intval($data['sign'].$data['score_num']); 
		} else {
			$info['score_num'] = intval($data['score_num']);
		}
		$info['score_type'] = $data['score_type'];
		$login_name=trim(getLoginName());
		$info['oper_man_id'] = '';
		$info['oper_man_name'] = $login_name;
		$info['store_id'] = $data['id'];
		$info['msg_txt'] = $data['msg_txt'];
		$info['memo'] = $data['room_no'];
		$strParam = json_encode($info);
  	    $modelRsa=new \Home\Model\rsakeys();
  	    $keyArr=$modelRsa->getModel("web");
  	    $ser_pri_key=$keyArr['private_key'];
  	    $platform='iPhone';
  	    $clientver='1.0.1';
  	    $md5platform=strtolower($platform);
  	    if($keyArr!=null && $keyArr!=false)
  	    {
  	        $md5sign=md5($ser_pri_key.$clientver.$md5platform);
  	    }
		// $info['now_score'] = $data['now_score'];
		$headers['ScreenSize'] = '560x960'; 
  	    $headers['Platform'] = $platform;
  	    $headers['Udid'] = guid();
  	    $headers['DeviceId'] = '';
  	    $headers['ClientVer'] =$clientver;
  	    $headers['Md5'] =$md5sign;
  	    $headers['Session'] = $data['customer_id'];
  	    $headers['Project'] = 'backstage';
  	    $headerArr = array(); 
  	    foreach( $headers as $n => $v ) { 
  	        $headerArr[] = $n .':' . $v;  
  	    }
		$url = C('API_SERVICE_URL').'common/store/credit.html';
        $result = curl_post($headerArr,$strParam,$url);
		return $result;
	}
	//根据store_id更改店铺信用分
	public function modifyStoreCreScore ($data)
	{
		$info['id'] = $data['id'];
		$info['credit_score'] = $data['credit_score'];
		$modelDal = new \Home\Model\stores();
		$result = $modelDal->modelModifyStore($info);
		return $result;
	}
	//根据store_id创建店铺保证金记录
	public function createEarnestMoney ($data) 
	{
		$modelDal = new \Home\Model\stores();
		$info['id'] = guid();
		$info['store_id'] = $data['id'];
		$info['price'] = $data['earnestmoney'];
		$cid = $this->findCustomerId($data['mobile']);
		if($cid == false||$cid == null) {
			return false;
		}
        $info['oper_man_id'] = $cid['id'];
        $login_name=trim(getLoginName());
        $info['oper_man_name'] = $login_name;
		$info['create_time'] = time();
		$info['remark'] = $data['remark'];
		$result = $modelDal->modelAddEarnestMoney($info);
		return $result;
	}
	//根据store_id更改店铺保证金
	public function modifyEarnestMoney ($data)
	{
		$modelDal = new \Home\Model\stores();
		$info['id'] = $data['id'];
		$info['earnestmoney'] = $data['earnestmoney'];
		$result = $modelDal->modelModifyStore($info);
		return $result;
	}
	//根据customer_id推送通知
	public function pushNotice ($data)
	{
		$modelDal = new \Home\Model\stores();
		$info['id'] = guid();
		$temp = $this->getCustomerId($data['id']);
		$info['customer_id'] = $temp['customer_id'];
		$info['notify_type'] = 1008;
		$info['title'] = '保证金';
		$info['content'] = "店铺[".$data['title']."]因".$data['remark']."保证金更改为".$data['earnestmoney']."元";
		$info['create_time'] = time();
		$result = $modelDal->modelAddCustomerNotify($info);
		if($result && C("IS_REDIS_CACHE")){
			#消息推送，红点
			$cache_message_no="store_".strtolower($info['customer_id'])."_message_no";
			$cache_message_no=set_cache_public_key($cache_message_no);
			$message_no_count=get_cache_data(C("COUCHBASE_BUCKET_GAODUDATA"),$cache_message_no);
			$message_no_count=$message_no_count==null?0:$message_no_count;
			$message_no_count= $message_no_count+1;
		    set_cache_data(C("COUCHBASE_BUCKET_GAODUDATA"),$cache_message_no,$message_no_count,0);
		}
		return $result; 
	}
	//修改housedeal是否成交
	public function modifyHouseDeal ($data)
	{
		if(empty($data['id'])) return false;
		$modelDal = new \Home\Model\stores();
		$where['id'] = $data['id'];
		$info['is_deal'] = $data['is_deal'];
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$result = $modelDal->modelUpdateHouseDeal($where,$info);
		return $result;
	}
	//查找成交详情
	public function findHouseDeal ($id)
	{
		if(empty($id)) return null;
		$modelDal = new \Home\Model\stores();
		$fields = 'store_id,room_no';
		$where['id'] = $id;
		$result = $modelDal->modelFindHouseDeal($fields,$where);
		return $result;
	}
	//根据customer_id计算佣金金额
	public function assessCommission ($price,$cid)
	{
		if(empty($price)||empty($cid)) return null;
		$data = array();
		$modelDal = new \Home\Model\stores();
		$commissionFields = 'id,is_open';
		$commissionWhere['customer_id'] = array('eq',$cid);
		$commissionWhere['contracttime_end'] = array('gt',time());
		$commissionResult = $modelDal->modelFindHouseCommissionManage($commissionFields,$commissionWhere);
		if($commissionResult['is_open'] == 1) {
			//查找佣金细节
			if(empty($commissionResult['id'])) {
				$data['commission'] = '无';
				$data['commssion_price'] = '无';
			}
			$detailFields = 'commission_type,commission_money';
			$detaiWhere['commission_id'] = $commissionResult['id'];
			$detailResult = $modelDal->modelFindHouseCommissionDetail($detailFields,$detailWhere);
			if($detailResult['commission_type'] == 1) {
				$data['commission'] = 'CPS-百分比-'.$detailResult['commission_money'].'%';
				$data['commission_price'] = $price*$detailResult['commission_money']/100;
			} elseif($detailResult['commission_type'] == 2) {
				$data['commission'] = 'CPS-金额-'.$detailResult['commission_money'];
				$data['commission_price'] = $detailResult['commission_money'];
			}
		} else {
			$data['commssion'] = '无';
			$data['commssion_price'] = '无';
		}
		$monthlyFields = 'is_open';
		$monthlyWhere['customer_id'] = array('eq',$cid);
		$monthlyWhere['monthly_end'] = array('gt',time());
		$monthlyResult = $modelDal->modelFindCommissionMonthly($monthlyFields,$monthlyWhere);
		if($monthlyResult['is_open'] == 1) {
			$data['monthly'] = '是';
		} elseif ($monthlyResult['is_open'] == 0) {
			$data['monthly'] = '否';
		} 
		return $data;
	}
	//根据id查找中奖信息
	public function findHouseDealLottery ($id)
	{
		if(empty($id)) return null;
		$modelDal = new \Home\Model\stores();
		$fields = 'price,is_send';
		$where['deal_id'] = $id;
		$result = $modelDal->modelFindHouseDealLottery($fields,$where);
		return $result;
	}
	//修改housedeallottery发送短信状态
	public function modifyHouseDealLottery ($data)
	{
		if(empty($data['id'])) return false;
		$modelDal = new \Home\Model\stores();
		$where['deal_id'] = $data['id'];
		$info['is_send'] = $data['is_send'];
		$result = $modelDal->modelUpdateHouseDealLottery($where,$info);
		return $result;
	}
	//计算签约租期
	public function  calculateTime ($startTime = 0,$endTime = 0)
	{
		if($startTime > $endTime) return null;
		$days = ceil(($endTime - $startTime)/3600/24);
		if($days <= 30) {
			return $days.'天';
		} else {
			$months = round($days/30);
			return $months.'月';
		}
	}
}
?>
<?php
namespace Logic;
/*联系房东记录--推送短链 */
class HouserentercallLogic{
	
	//add
	public function addIncludShorturl($data){
		if(empty($data['room_no'])){
			return false;
		}
		$roomDal=new \Home\Model\houseroom();
		$roomModel=$roomDal->getResultByWhere("id,room_no,resource_id,city_code,room_money,is_commission,is_monthly","where room_no='".$data['room_no']."'","");
		if($roomModel===false || $roomModel===null){
			return false;
		}else if(count($roomModel)==0){
			return false;
		}
		$resourceDal=new \Home\Model\houseresource();
		$resourceModel=$resourceDal->getModelById($roomModel[0]['resource_id']);
		if($resourceModel===false || $resourceModel===null){
			return false;
		}
		$modelDal=new \Home\Model\houserentercallshort();
		$shortData['id']=guid();
		$shortData['resource_id']=$roomModel[0]['resource_id'];
		$shortData['room_id']=$roomModel[0]['id'];
		$shortData['city_id']=$roomModel[0]['city_code'];
		$shortData['room_money']=$roomModel[0]['room_money'];
		$shortData['region_id']=$resourceModel['region_id'];
		$shortData['region_name']=$resourceModel['region_name'];
		$shortData['scope_id']=$resourceModel['scope_id'];
		$shortData['scope_name']=$resourceModel['scope_name'];
		$shortData['client_phone']=$resourceModel['client_phone'];

		$shortData['contact_time']=time();
		$shortData['renter_source']=$data['renter_source'];
		$shortData['renter_phone']=$data['renter_phone'];
		$shortData['update_man']=$data['update_man'];
		$shortData['update_time']=time();
		$shortData['create_man']=$shortData['update_man'];
		$shortData['create_time']=$shortData['update_time'];
		$shortData['push_status']=1;
		$shortData['bak_content']='非付费';
		if($roomModel[0]['is_monthly']==1){
			$shortData['bak_content']='包月';
		}else if($roomModel[0]['is_commission']==1){
			$shortData['bak_content']='佣金';
		}
		switch ($roomModel[0]['city_code']) {
			case '001009001':
				$uri='http://m.hizhu.com/shanghai/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001009001&city_name=shanghai#c=sh';
				break;
			case '001001':
				$uri='http://m.hizhu.com/beijing/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001001&city_name=beijing#c=bj';
				break;
			case '001011001':
				$uri='http://m.hizhu.com/hangzhou/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001011001&city_name=hangzhou#c=hz';
				break;
			case '001010001':
				$uri='http://m.hizhu.com/nanjing/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001010001&city_name=nanjing#c=nj';
				break;
			case '001019002':
				$uri='http://m.hizhu.com/shenzhen/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001019002&city_name=shenzhen#c=sz';
				break;
			default:
				$uri='http://m.hizhu.com/shanghai/roomDetail.html?room_id='.$roomModel[0]['id'].'&city_code=001009001&city_name=shanghai#c=sh';
				break;
		}
		$uri=$uri.'&duanlian=sms';
		$handleLogic=new \Logic\SmssendLogic();
		$shortData['short_url']=$handleLogic->getShorturl($uri);//生成短链
		$shortData['record_status']=1;
		$result = $modelDal->addModel($shortData);
		if($result){
			//获取房东对应400号码
			$handleCode=new \Logic\PhoneCodeLogic();
			$code=$handleCode->get400Code(array('mobile'=>$resourceModel['client_phone'],'room_id'=>$roomModel[0]['id'],'room_no'=>$roomModel[0]['room_no'],'city_id'=>$resourceModel['city_code'],'info_resource'=>$resourceModel['info_resource']));
			return array('clientPhone'=>$code,'shortUrl'=>$shortData['short_url']);
		}
		return false;
	}
	//获取房源信息
	public function getHouseInfoByRoomid($room_id){
		if(empty($room_id)){
			return false;
		}
		$roomDal=new \Home\Model\houseroom();
		$roomModel=$roomDal->getModelById($room_id);
		if($roomModel===false || $roomModel===null){
			return false;
		}
		$resourceDal=new \Home\Model\houseresource();
		$resourceModel=$resourceDal->getModelById($roomModel['resource_id']);
		if($resourceModel===false || $resourceModel===null){
			return false;
		}
		$shortData['resource_id']=$roomModel['resource_id'];
		$shortData['room_id']=$roomModel['id'];
		$shortData['city_id']=$roomModel['city_code'];
		$shortData['room_money']=$roomModel['room_money'];
		$shortData['region_id']=$resourceModel['region_id'];
		$shortData['region_name']=$resourceModel['region_name'];
		$shortData['scope_id']=$resourceModel['scope_id'];
		$shortData['scope_name']=$resourceModel['scope_name'];
		$shortData['client_phone']=$resourceModel['client_phone'];
		return $shortData;
	}
	public function addNotShorturl($data){
		$modelDal=new \Home\Model\houserentercallshort();
		$shortData['id']=guid();
		$shortData['city_id']=$data['city_code'];
		$shortData['contact_phone']=$data['contact_phone'];
		$shortData['contact_time']=$data['contact_time'];
		$shortData['renter_phone']=$data['renter_phone'];
		$shortData['update_man']=$data['update_man'];
		$shortData['update_time']=time();
		$shortData['create_man']=$shortData['update_man'];
		$shortData['create_time']=$shortData['update_time'];
		$shortData['push_status']=0;
		$shortData['bak_content']=$data['bak_content'];
		$shortData['record_status']=1;
		return $modelDal->addModel($shortData);
	}
	public function updateShortModel($data){
		$model=new \Home\Model\houserentercallshort();
	    return $model->updateModel($data);
	}
	public function getShortModelById($id){
		$model=new \Home\Model\houserentercallshort();
	    return $model->getModelById($id);
	}
	#list
	public function getShortHistoryCount($condition){
	  $conditionString=$this->getShorturlCondition($condition);
	  if(!empty($conditionString)){
	  	$conditionString=' where '.substr(trim($conditionString), 3);
	  }
	  $model=new \Home\Model\houserentercallshort();
	  return $model->getListCount($conditionString);
	}
	public function getShortHistoryList($condition,$limit_start,$limit_end){
	  $conditionString=$this->getShorturlCondition($condition);
	  if(!empty($conditionString)){
	  	$conditionString=' where '.substr(trim($conditionString), 3);
	  }	
	  $model=new \Home\Model\houserentercallshort();
	  return $model->getList($conditionString,$limit_start,$limit_end);
	}
	private function getShorturlCondition($condition)
    {
        $conditionString=" and record_status=1";
        if (isset($condition['mobile']) && !empty($condition['mobile'])) {
            $conditionString.=" and renter_phone='".str_replace("'", "", $condition['mobile'])."'";
        }
         //联系时间
         if(isset($condition['startTime']) && trim($condition['startTime'])!=''){
            $conditionString.=" and contact_time>=".strtotime(trim($condition['startTime']));
         }
         if(isset($condition['endTime']) && trim($condition['endTime'])!=''){
            $endTime=strtotime(trim($condition['endTime']));
            $endTime=$endTime+60*60*24;
            $conditionString.=" and contact_time<=".$endTime;
         }

        if (isset($condition['status']) && $condition['status']!="") {
            $conditionString.=" and push_status=".$condition['status'];
        }
        if(isset($condition['city_id']) && $condition['city_id']!=""){
            $conditionString.=" and city_id=".$condition['city_id'];
        }
        if(isset($condition['handle_man']) && $condition['handle_man']!=""){
            $conditionString.=" and update_man='".str_replace("'", "", $condition['handle_man'])."'";
        }
        if(isset($condition['rentsource']) && $condition['rentsource']!=""){
            $conditionString.=" and renter_source=".$condition['rentsource'];
        }
        return $conditionString;
    }

}
?>
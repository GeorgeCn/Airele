<?php
namespace Logic;
/*佣金管理 */
class CommissionLogic{
	#add
	public function addCommission($data){
		$output=false;
		if(!is_array($data)){
			return false;
		}
		if(!isset($data['room_no']) || empty($data['room_no'])){
			return false;
		}
		$no_array=explode(',', str_replace('，', ',', $data['room_no']));
		if(count($no_array)>1000){
			return false;
		}
		$no_array=array_unique($no_array);
		$modelDal=new \Home\Model\commission();
		$city_code=C('CITY_CODE');
		foreach ($no_array as $key => $value) {
			if(empty($value)){
				continue;
			}
			$value=trim($value);
			//判断此房源是否已存在这个合同时间的启用的佣金规则
			$comm_list=$modelDal->getModelByNo($value);
			$chong=false;
			if($comm_list!==null && $comm_list!==false){
				$count=count($comm_list);
				for ($i=0; $i < $count; $i++) { 
					if($data['contracttime_start']==$comm_list[$i]['contracttime_start'] || $data['contracttime_end']==$comm_list[$i]['contracttime_end']){
						$chong=true;break;
					}
					if($data['contracttime_start']>$comm_list[$i]['contracttime_start'] && $data['contracttime_start']<$comm_list[$i]['contracttime_end']){
						$chong=true;break;
					}
					if($data['contracttime_end']>$comm_list[$i]['contracttime_start'] && $data['contracttime_end']<$comm_list[$i]['contracttime_end']){
						$chong=true;break;
					}
				}
			}
			if($chong){
				continue;
			}
			$roomModel=$modelDal->getHouseRoomByNo($value);
			if($roomModel===null || $roomModel===false || count($roomModel)==0){
				continue;
			}
			$resourceModel=$modelDal->getHouseResourceById($roomModel[0]['resource_id']);
			if($resourceModel===null || $resourceModel===false || count($resourceModel)==0){
				continue;
			}
			//添加主信息
			$savedata['city_code']=$city_code;
			$savedata['room_no']=$value;
			$savedata['room_id']=$roomModel[0]['id'];
			$savedata['room_status']=$roomModel[0]['status'];
			$savedata['room_money']=$roomModel[0]['room_money'];
			$savedata['client_phone']=$resourceModel[0]['client_phone'];
			$savedata['client_name']=$resourceModel[0]['client_name'];
			$savedata['estate_name']=$resourceModel[0]['estate_name'];
			$savedata['contracttime_start']=$data['contracttime_start'];
			$savedata['contracttime_end']=$data['contracttime_end'];
			$savedata['is_open']=1;
			$savedata['create_time']=$data['create_time'];
			$savedata['create_man']=$data['create_man'];
			$savedata['update_time']=$data['update_time'];
			$savedata['update_man']=$data['update_man'];
			$pk_id=$modelDal->addModel($savedata);
			if($pk_id>0){
				//更新定金优惠金额
				$modelDal->updateRoomCommission($savedata['room_id'],1);
				//添加明细信息
				$detail['commission_id']=$pk_id;
				$detail['commission_type']=$data['commission_type'];
				$detail['commission_money']=$data['commission_money'];
				$detail['commission_base']=$data['commission_base'];
				$detail['is_online']=$data['is_online'];
				$detail['settlement_method']=$data['settlement_method'];
				$detail['create_time']=$data['create_time'];
				$detail['create_man']=$data['create_man'];
				$detail['start_time']=strtotime($data['start_time']);
				$modelDal->addDetail($detail);
				$output=true;
			}
			
		}
		return $output;
	}
	#update
	public function updateCommission($data){
		if(!is_array($data)){
			return false;
		}
		$startTime=strtotime($data['start_time']);
		if($startTime<time()-3600*24){
			return false;
		}
		$modelDal=new \Home\Model\commission();
		$result=$modelDal->getMaxStarttimeByid($data['id']);
		if($result===null || $result===false || count($result)==0){
			return false;
		}
		if($startTime<=$result[0]['start_time']){
			return false;
		}
		//修改主信息
		$modelDal->updateModel(array('id'=>$data['id'],'update_man'=>$data['update_man'],'update_time'=>$data['update_time']));
		//添加明细信息
		$detail['commission_id']=$data['id'];
		$detail['commission_type']=$data['commission_type'];
		$detail['commission_money']=$data['commission_money'];
		$detail['commission_base']=$data['commission_base'];
		$detail['is_online']=$data['is_online'];
		$detail['settlement_method']=$data['settlement_method'];
		$detail['create_time']=$data['update_time'];
		$detail['create_man']=$data['update_man'];
		$detail['start_time']=$startTime;
		$output=$modelDal->addDetail($detail);
		//修改上一个明细
		$modelDal->updateDetail(array('id' => $result[0]['id'],'end_time'=>$startTime ));
		return $output;
	}
	public function getCommissionById($id){
		if(!is_numeric($id)){
			return false;
		}
		$modelDal=new \Home\Model\commission();
		return $modelDal->getModelById($id);
	}
	//停用
	public function updateCommissionStop($commission_id,$update_man){
		if(!is_numeric($commission_id)){
			return false;
		}
		$modelDal=new \Home\Model\commission();
		$commissionModel=$modelDal->getModelById($commission_id);
		if($commissionModel===null || $commissionModel===false){
			return false;
		}
		$result=$modelDal->getMaxStarttimeByid($commission_id);
		if($result===null || $result===false || count($result)==0){
			return false;
		}
		$output=$modelDal->updateModel(array('id'=>$commission_id,'is_open'=>0,'update_man'=>$update_man,'update_time'=>time()));
		if($output){
			$modelDal->updateDetail(array('id' => $result[0]['id'],'end_time'=>time() ));
			//更新定金优惠金额
			$modelDal->updateRoomCommission($commissionModel['room_id'],0);
			return true;
		}
		return false;
	}
	#list
	public function getCommissionListCount($condition){
	  $conditionString=$this->getConditionString($condition);
	  $model=new \Home\Model\commission();
	  return $model->getModelListCount($conditionString);
	}
	public function getCommissionList($condition,$limit_start,$limit_end){
	  $conditionString=$this->getConditionString($condition);	
	  $model=new \Home\Model\commission();
	  return $model->getModelList($conditionString,$limit_start,$limit_end);
	}
	private function getConditionString($condition)
	{
	    $conditionString=" and city_code='".C('CITY_CODE')."'";
		if(is_array($condition)){
			foreach ($condition as $key => $value) {
				$condition[$key]=str_replace("'", "", $value);
			}
		}else{
			return "";
		}
		if (isset($condition['room_no']) && !empty($condition['room_no'])) {
			$conditionString.=" and room_no='".trim($condition['room_no'])."'";
		}
	     //修改时间
	     if(isset($condition['updatetime_start']) && !empty($condition['updatetime_start'])){
	        $conditionString.=" and update_time>=".strtotime(trim($condition['updatetime_start']));
	     }
	     if(isset($condition['updatetime_end']) && !empty($condition['updatetime_end'])){
	        $endTime=strtotime(trim($condition['updatetime_end']));
	        $endTime=$endTime+60*60*24;
	        $conditionString.=" and update_time<=".$endTime;
	     }
	    if (isset($condition['is_open']) && $condition['is_open']!="") {
			$conditionString.=" and is_open='".$condition['is_open']."'";
		}
		if (isset($condition['is_online']) && $condition['is_online']!="") {
			$conditionString.=" and is_online='".$condition['is_online']."'";
		}
	    if (isset($condition['settlement_method']) && $condition['settlement_method']!="") {
			$conditionString.=" and settlement_method='".$condition['settlement_method']."'";
		}
		if (isset($condition['client_phone']) && !empty($condition['client_phone'])) {
			$conditionString.=" and client_phone='".trim($condition['client_phone'])."'";
		}
		if (isset($condition['client_name']) && !empty($condition['client_name'])) {
			$conditionString.=" and client_name='".trim($condition['client_name'])."'";
		}
		if (isset($condition['estate_name']) && !empty($condition['estate_name'])) {
			$conditionString.=" and estate_name like '".trim($condition['estate_name'])."%'";
		}
		return $conditionString;
	}
   public function getDetailsByCommissionId($id){
   		if(!is_numeric($id)){
			return null;
		}
    	$modelDal=new \Home\Model\commission();
    	return $modelDal->getDetailsByCommissionId($id);
   }
	//读取房间信息
   public function getHouseRoomByNo($room_no){
     $modelDal=new \Home\Model\commission();
     return $modelDal->getHouseRoomByNo($room_no);
   }
   //读取房东下面的所有房间
   public function getRoomInfoByClientphone($client_phone){
   	$client_phone=str_replace("'", "", trim($client_phone));
     $modelDal=new \Home\Model\commission();
     return $modelDal->getRoomInfoByClientphone($client_phone);
   }
   /*佣金房东 */
   public function getCommissionfdByPhone($client_phone){
	  $client_phone=str_replace("'", "", trim($client_phone));
	  $modelDal=new \Home\Model\commissionfd();
	  return $modelDal->getModelListByWhere(" where client_phone='$client_phone'");
   }
   public function addCommissionfd($data){
   		$data['client_phone']=str_replace("'","", $data['client_phone']);
	   	$modelDal=new \Home\Model\commissionfd();
   		//判断此房源是否已存在这个合同时间的启用的佣金规则
   		$comm_list=$modelDal->getModelListByWhere(" where client_phone='".$data['client_phone']."' and is_open=1");
   		$chong=false;$count=0;
   		if($comm_list!==null && $comm_list!==false){
   			$count=count($comm_list);
   			for ($i=0; $i < $count; $i++) { 
   				if($data['contracttime_start']==$comm_list[$i]['contracttime_start'] || $data['contracttime_end']==$comm_list[$i]['contracttime_end']){
   					$chong=true;break;
   				}
   				if($data['contracttime_start']>$comm_list[$i]['contracttime_start'] && $data['contracttime_start']<$comm_list[$i]['contracttime_end']){
   					$chong=true;break;
   				}
   				if($data['contracttime_end']>$comm_list[$i]['contracttime_start'] && $data['contracttime_end']<$comm_list[$i]['contracttime_end']){
   					$chong=true;break;
   				}
   			}
   		}
   		if($chong){
   			return false;
   		}
   		$customerModel=$modelDal->getCustomerByWhere(" where mobile='".$data['client_phone']."'");
   		if($customerModel===null || $customerModel===false || count($customerModel)==0){
   			return false;
   		}
   		//添加主信息
   		$savedata['city_code']=$customerModel[0]['city_code'];
   		if(empty($savedata['city_code'])){
   			$savedata['city_code']=C('CITY_CODE');
   		}
   		$savedata['client_phone']=$data['client_phone'];
   		$savedata['client_name']=$customerModel[0]['true_name'];
   		$savedata['customer_id']=$customerModel[0]['id'];
   		$savedata['contracttime_start']=$data['contracttime_start'];
   		$savedata['contracttime_end']=$data['contracttime_end'];
   		$savedata['is_open']=1;
   		$savedata['create_time']=$data['create_time'];
   		$savedata['create_man']=$data['create_man'];
   		$savedata['update_time']=$data['update_time'];
   		$savedata['update_man']=$data['update_man'];
   		$pk_id=$modelDal->addModel($savedata);
   		if($pk_id>0){
   			//添加明细信息
   			$detail['commission_id']=$pk_id;
   			$detail['commission_type']=$data['commission_type'];
   			$detail['commission_money']=$data['commission_money'];
   			$detail['commission_base']=$data['commission_base'];
   			$detail['is_online']=$data['is_online'];
   			$detail['settlement_method']=$data['settlement_method'];
   			$detail['create_time']=$data['create_time'];
   			$detail['create_man']=$data['create_man'];
   			$detail['start_time']=strtotime($data['start_time']);
   			$modelDal->addDetail($detail);
   			if($count==0){
   				//修改房东信息，更新为佣金房东
   				$customerDal=new \Home\Model\customer();
   				$result=$customerDal->updateModel(array('id'=>$savedata['customer_id'],'is_commission'=>1,'update_time'=>$savedata['update_time'],'update_man'=>$savedata['update_man']));
				if($result){
				    //更新 APP端用户缓存
				    $customerModelnew=$customerModel[0];
				    $customerModelnew['is_commission']=1;
				    $customerLogic=new \Logic\CustomerLogic();
	    	    	$customerLogic->updateCustomerCache($customerModelnew);
				}
   			}
   			if(strtolower($data['check_update'])=='on'){
   				//更新定金优惠金额
   				$modelDal->updateRoomCommission($savedata['customer_id'],1);
   				//更新下面的佣金房间
   				$data['customer_id']=$savedata['customer_id'];
   				$data['client_name']=$savedata['client_name'];
   				$data['city_code']=$savedata['city_code'];
   				$this->handleCommissionRoomForfd($data);
   			}
   			return true;
   		}
   		return false;
   }
   /*操作佣金房东，更新下面的佣金房源 */
   private function handleCommissionRoomForfd($data){
   		$modelDal=new \Home\Model\commission();
   		$roomid_array=$modelDal->getHouseRoomByWhere("where customer_id='".$data['customer_id']."'",2000);
   		if($roomid_array!=null && $roomid_array!=false){
   			foreach ($roomid_array as $key => $value) {
   				//判断此房源是否已存在这个合同时间的启用的佣金规则
   				$comm_list=$modelDal->getModelByWhere("where room_id='".$value['id']."' and is_open=1");
   				$chong=false;
   				if($comm_list!==null && $comm_list!==false){
   					$count=count($comm_list);
   					for ($i=0; $i < $count; $i++) { 
   						if($data['contracttime_start']==$comm_list[$i]['contracttime_start'] || $data['contracttime_end']==$comm_list[$i]['contracttime_end']){
   							$chong=true;break;
   						}
   						if($data['contracttime_start']>$comm_list[$i]['contracttime_start'] && $data['contracttime_start']<$comm_list[$i]['contracttime_end']){
   							$chong=true;break;
   						}
   						if($data['contracttime_end']>$comm_list[$i]['contracttime_start'] && $data['contracttime_end']<$comm_list[$i]['contracttime_end']){
   							$chong=true;break;
   						}
   					}
   				}
   				if($chong){
   					//删除
   					$modelDal->deleteModelByWhere("room_id='".$value['id']."'");
   				}
   				//添加主信息
   				$savedata['city_code']=$data['city_code'];
   				$savedata['room_no']=$value['room_no'];
   				$savedata['room_id']=$value['id'];
   				$savedata['room_status']=$value['status'];
   				$savedata['room_money']=$value['room_money'];
   				$savedata['client_phone']=$data['client_phone'];
   				$savedata['client_name']=$data['client_name'];
   				//$savedata['estate_name']='';
   				$savedata['contracttime_start']=$data['contracttime_start'];
   				$savedata['contracttime_end']=$data['contracttime_end'];
   				$savedata['is_open']=1;
   				$savedata['create_time']=$data['create_time'];
   				$savedata['create_man']=$data['create_man'];
   				$savedata['update_time']=$data['update_time'];
   				$savedata['update_man']=$data['update_man'];
   				$pk_id=$modelDal->addModel($savedata);
   				if($pk_id>0){
   					//添加明细信息
   					$detail['commission_id']=$pk_id;
   					$detail['commission_type']=$data['commission_type'];
   					$detail['commission_money']=$data['commission_money'];
   					$detail['commission_base']=$data['commission_base'];
   					$detail['is_online']=$data['is_online'];
   					$detail['settlement_method']=$data['settlement_method'];
   					$detail['create_time']=$data['create_time'];
   					$detail['create_man']=$data['create_man'];
   					$detail['start_time']=strtotime($data['start_time']);
   					$modelDal->addDetail($detail);
   				}
   				
   			}
   		}
   }
   public function getCommissionfdById($id){
	   	if(!is_numeric($id)){
	   		return false;
	   	}
	   	$modelDal=new \Home\Model\commissionfd();
	   	return $modelDal->getModelById($id);
   }
    public function getDetailsfdByCommissionId($id){
  		if(!is_numeric($id)){
			return null;
		}
	   	$modelDal=new \Home\Model\commissionfd();
	   	return $modelDal->getDetailsByCommissionId($id);
    }
    #update
    public function updateCommissionfd($data){
    	if(!is_array($data)){
    		return false;
    	}
    	$startTime=strtotime($data['start_time']);
    	if($startTime<time()-3600*24){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$result=$modelDal->getMaxStarttimeByid($data['id']);
    	if($result===null || $result===false || count($result)==0){
    		return false;
    	}
    	/*if($startTime<=$result[0]['start_time']){
    		return false;
    	}*/
    	//修改主信息
    	$modelDal->updateModel(array('id'=>$data['id'],'update_man'=>$data['update_man'],'update_time'=>$data['update_time']));
    	//添加明细信息
    	$detail['commission_id']=$data['id'];
    	$detail['commission_type']=$data['commission_type'];
    	$detail['commission_money']=$data['commission_money'];
    	$detail['commission_base']=$data['commission_base'];
    	$detail['is_online']=$data['is_online'];
    	$detail['settlement_method']=$data['settlement_method'];
    	$detail['create_time']=$data['update_time'];
    	$detail['create_man']=$data['update_man'];
    	$detail['start_time']=$startTime;
    	$modelDal->addDetail($detail);
    	//修改上一个明细
    	$modelDal->updateDetail(array('id' => $result[0]['id'],'end_time'=>$startTime ));
    	if(strtolower($data['check_update'])=='on'){
    		//更新下面的房间佣金
    		$ids='';
    		if($data['contracttime_start']<0 && $data['contracttime_end']==99){
    			$modelDal->updateCommissionRoom("client_phone='".$data['client_phone']."'",array('contracttime_start'=>'-99','contracttime_end'=>'99','update_time'=>$data['update_time'],'update_man'=>$data['update_man']));
    			$commissionList=$modelDal->getCommissionRoomByWhere(" where client_phone='".$data['client_phone']."'");
    		}else{
    			$commissionList=$modelDal->getCommissionRoomByWhere(" where client_phone='".$data['client_phone']."' and contracttime_start=".$data['contracttime_start']." and contracttime_end=".$data['contracttime_end']);
    		}
    		if($commissionList!==null && $commissionList!==false){
    			foreach ($commissionList as $key => $value) {
    				$ids[]=$value['id'];
    			}
    		}
    		if($ids!=''){
    			$modelDal->updateCommissiondetailRoom(array('commission_id'=>array('in',$ids)),array('commission_type'=>$data['commission_type'],'commission_money'=>$data['commission_money'],'commission_base'=>$data['commission_base'],
    				'is_online'=>$data['is_online'],'settlement_method'=>$data['settlement_method'],'start_time'=>$detail['start_time'],'end_time'=>'0'));
    		}
    		
    	}
    	return true;
    }
    //停用
    public function updateCommissionStopfd($commission_id,$update_man){
    	if(!is_numeric($commission_id)){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$commissionModel=$modelDal->getModelById($commission_id);
    	if($commissionModel===null || $commissionModel===false){
    		return false;
    	}
    	$currentTime=time();
    	$customerDal=new \Home\Model\customer();
    	//合同规则
    	if($commissionModel['contracttime_start']<0 && $commissionModel['contracttime_end']==99){
    		$output=$modelDal->updateModel(array('id'=>$commission_id,'is_open'=>0,'update_man'=>$update_man,'update_time'=>$currentTime));
    		if($output){
    			//更新明细下的结束时间
    			$modelDal->updateDetailByWhere("commission_id='$commission_id' and end_time=0",array('end_time'=>time()));
    			//停用下面的所有佣金房源规则
    			$output=$modelDal->updateCommissionRoom("client_phone='".$commissionModel['client_phone']."'",array('is_open'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
    			if($output){
    				$modelDal->updateMoreEndtimeForRoom(" and client_phone='".$commissionModel['client_phone']."'");
    			}  	
    			//更新房间佣金标识
    			$modelDal->updateRoomCommission($commissionModel['customer_id'],0);
    			//修改房东信息，更新非佣金房东
    			$result=$customerDal->updateModel(array('id'=>$commissionModel['customer_id'],'is_commission'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
				if($result){
				    //更新 APP端用户缓存
				    $customerModel=$customerDal->getModelById($commissionModel['customer_id']);
				    $customerLogic=new \Logic\CustomerLogic();
	    	    	$customerLogic->updateCustomerCache($customerModel);
				}
    		}
    	}else{
    		$count_result=$modelDal->getCommissionByWhere(" where client_phone='".$commissionModel['client_phone']."' and is_open=1");
    		if($count_result===null || $count_result===false || count($count_result)==0){
    			return false;
    		}
    		//开启的规则次数
    		if(count($count_result)==1){
    			$output=$modelDal->updateModel(array('id'=>$commission_id,'is_open'=>0,'update_man'=>$update_man,'update_time'=>$currentTime));
    			if($output){
    				//更新明细下的结束时间
    				$modelDal->updateDetailByWhere("commission_id='$commission_id' and end_time=0",array('end_time'=>time()));
    				//停用下面的所有佣金房源规则
    				$output=$modelDal->updateCommissionRoom("client_phone='".$commissionModel['client_phone']."'",array('is_open'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
    				if($output){
	    				$modelDal->updateMoreEndtimeForRoom(" and client_phone='".$commissionModel['client_phone']."'");
	    			}  	
    				//更新房间佣金标识
    				$modelDal->updateRoomCommission($commissionModel['customer_id'],0);
    				//修改房东信息，更新非佣金房东
    				$result=$customerDal->updateModel(array('id'=>$commissionModel['customer_id'],'is_commission'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
					if($result){
					    //更新 APP端用户缓存
					    $customerModel=$customerDal->getModelById($commissionModel['customer_id']);
					    $customerLogic=new \Logic\CustomerLogic();
		    	    	$customerLogic->updateCustomerCache($customerModel);
					}
    			}
    		}else{
    			$output=$modelDal->updateModel(array('id'=>$commission_id,'is_open'=>0,'update_man'=>$update_man,'update_time'=>$currentTime));
    			if($output){
    				//更新明细下的结束时间
    				$modelDal->updateDetailByWhere("commission_id='$commission_id' and end_time=0",array('end_time'=>time()));
    				//停用相同规则佣金房源
    				$output=$modelDal->updateCommissionRoom("client_phone='".$commissionModel['client_phone']."' and contracttime_start=".$commissionModel['contracttime_start']." and contracttime_end=".$commissionModel['contracttime_end'],array('is_open'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
    				if($output){
    					$modelDal->updateMoreEndtimeForRoom(" and client_phone='".$commissionModel['client_phone']."' and contracttime_start=".$commissionModel['contracttime_start']." and contracttime_end=".$commissionModel['contracttime_end']);
    				} 
    			}
    		}
    		
    	}
    	return true;
    }
    public function getCommissionSelectlist($client_phone){
    	if(empty($client_phone)){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$result=$modelDal->getCommissionByWhere(" where client_phone='$client_phone' and is_open=1");
    	if($result===false || $result===null || count($result)==0){
    		return false;
    	}
    	if(count($result)>10){
    		return false;
    	}
    	$selectList=array();
    	foreach ($result as $key => $value) {
    		$detail=$modelDal->getDetailsByCommissionId($value['id']);
    		if($detail!==null && $detail!==false && count($detail)>0){
    			array_push($selectList,array('commmission_id'=>$value['id'],'contracttime_start'=>$value['contracttime_start'],'contracttime_end'=>$value['contracttime_end'],
    				'commission_type'=>$detail[0]['commission_type'],'commission_base'=>$detail[0]['commission_base'],'commission_money'=>$detail[0]['commission_money'],
    				'is_online'=>$detail[0]['is_online'],'settlement_method'=>$detail[0]['settlement_method']));
    		}
    	}
    	return $selectList;

    }
    //获取最新佣金房东信息
     public function getCommissionfdNewOne($client_phone){
    	if(empty($client_phone)){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$result=$modelDal->getCommissionByWhere(" where client_phone='$client_phone' and is_open=1 order by id desc limit 1");
    	if($result===false || $result===null || count($result)==0){
    		return false;
    	}
    	$new_one=false;
		$detail=$modelDal->getDetailsByCommissionId($result[0]['id']);
		if($detail!==null && $detail!==false && count($detail)>0){
			$new_one = array('commission_money'=>$detail[0]['commission_money'],'commission_type'=>$detail[0]['commission_type']);
		}
    	return $new_one;
    }

    /*包月房东 */
    public function addCommissionmonthly($data,$is_stopcomm=0){
    	if(!is_array($data)){
    		return false;
    	}
    	if($data['monthly_money']=='' || $data['monthly_start']=='' || $data['customer_id']==''){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$customerData=$modelDal->getCustomerByWhere(" where id='".$data['customer_id']."'");
    	if($customerData==null || $customerData==false || count($customerData)==0){
    		return false;
    	}
   		//判断是否已存在这个时间的启用的佣金规则
   		$comm_list=$modelDal->getCommissionmonthlyByWhere(" customer_id='".$data['customer_id']."' and is_open=1","limit 10");
   		$chong=false;
   		if($comm_list!=null && $comm_list!=false){
   			$count=count($comm_list);
   			for ($i=0; $i < $count; $i++) { 
   				if($data['monthly_start']>=$comm_list[$i]['monthly_start'] && $data['monthly_start']<$comm_list[$i]['monthly_end']){
   					$chong=true;break;
   				}
   				if($data['monthly_end']>=$comm_list[$i]['monthly_start'] && $data['monthly_end']<=$comm_list[$i]['monthly_end']){
   					$chong=true;break;
   				}
   				//不能在到期日期后跳跃添加
   				if($comm_list[$i]['monthly_end']>time() && intval($data['monthly_start'])-intval($comm_list[$i]['monthly_end'])>=3600*24*5){
   					$chong=true;break;
   				}
   			}
   		}
   		if($chong){
   			return false;
   		}
   		//添加包月信息
   		$result=$modelDal->addCommissionmonthly($data);
   		$incrementID = $result;
   		if($result){

			//修改用户数据，更新包月信息
			$customerDal=new \Home\Model\customer();
			$result=$customerDal->updateModel(array('id'=>$data['customer_id'],'is_monthly'=>1,'monthly_start'=>$data['monthly_start'],'monthly_end'=>$data['monthly_end'],'update_time'=>$data['update_time'],'update_man'=>$data['update_man'],'memo'=>$customerData[0]['memo'].'|'.date('Y-m-d H:i:s').'新增包月'));
			//更新房间信息
			$dal=new \Home\Model\houseroom();
			$dal->updateModelByWhere(array('is_monthly'=>1),"customer_id='".$data['customer_id']."'");
			if($result){
				/*是否停用佣金规则： */
				if($is_stopcomm==1 && $customerData[0]['is_commission']==1){
					$this->removeMonthlyComm($data['customer_id']);
				}
			    //更新 APP端用户缓存
			    $customerModel=$customerDal->getModelById($data['customer_id']);
			    $customerLogic=new \Logic\CustomerLogic();
    	    	$customerLogic->updateCustomerCache($customerModel);
			}
   		}
   		return $incrementID;
   }

   /*去掉佣金规则 */
   public function removeMonthlyComm($customer_id){
   		if(empty($customer_id)){
   			return false;
   		}
   		//更新佣金房东规则
	   	$customerDal=new \Home\Model\customer();
	   	$customerDal->updateModel(array('id'=>$customer_id,'is_commission'=>0));

   		$commissionfdDal=new \Home\Model\commissionfd();
   		$commissionfdDal->updateModelByWhere(array('is_open'=>0,'update_time'=>time(),'update_man'=>'system'),"customer_id='$customer_id' and is_open=1");
   		
   		$houseDal=new \Home\Model\houseroom();
   		$roomData=$houseDal->getFieldsByWhere('id,status,record_status,is_commission',"customer_id='$customer_id'");
   		if($roomData!=null){
   			//更新佣金房源
   			$selectDal=new \Home\Model\houseselect();
   			$commDal=new \Home\Model\commission();
   			foreach ($roomData as $key => $room_row) {
   				if($room_row['status']=='2' && $room_row['record_status']=='1'){
   					$selectDal->updateModelByWhere(array('is_commission'=>0),"room_id='".$room_row['id']."'");
   				}
   				if($room_row['is_commission']=='1'){
   					$commDal->deleteModelByWhere("room_id='".$room_row['id']."'");
   				}
   			}
   		}
   		$houseDal->updateModelByWhere(array('is_commission'=>0),"customer_id='$customer_id'");
  		return true;
   }


    public function getCommissionmonthlyByCustid($customer_id){
    	if(empty($customer_id)){
    		return null;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	$list=$modelDal->getCommissionmonthlyByWhere("customer_id='$customer_id'","order by id asc limit 10");
    	return $list;
    }
    //根据id包月延期
    public function updateCommissionMonDelay ($data)
    {
    	if(empty($data['id'])) return null ; 
    	$modelDal = new \Home\Model\commissionfd();
    	$where['id'] = $data['id'];
    	$info['monthly_days'] = intval($data['monthly_delay']+$data['monthly_days']);
    	$info['monthly_end'] = $data['monthly_end']+intval($data['monthly_delay'])*3600*24;
    	$info['is_delay'] = 1;
    	$result = $modelDal->modelUpdateCommissionMon($where,$info);
    	return $result;
    }
    //根据customer_id更改customer包月时间
    public function updateCustomerMonth ($data)
    {
    	if(empty($data['customer_id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$where['id'] = $data['customer_id'];
    	$info['monthly_start'] = strtotime($data['monthly_start']);
    	$info['monthly_end'] = strtotime($data['monthly_start'])+intval($data['monthly_days'])*3600*24;
    	$result = $modelDal->modelUpdateCustomer($where,$info);
    	//更新APP端用户缓存
    	$customerDal=new \Home\Model\customer();
    	$customerModel=$customerDal->getModelById($data['customer_id']);
    	$customerLogic=new \Logic\CustomerLogic();
    	$customerLogic->updateCustomerCache($customerModel);
    	return $result;
    }
    //根据customer_id更改customer包月起始时间
    public function updateCustomerMonEnd ($data)
    {
    	if(empty($data['customer_id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$where['id'] = $data['customer_id'];
    	$info['monthly_end'] = $data['monthly_end']+intval($data['monthly_delay'])*3600*24;
    	$result = $modelDal->modelUpdateCustomer($where,$info);
    	return $result;
    }
    //创建包月历史记录
    public function createCommissionMonLog ($data)
    {
    	if(empty($data['id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$info['relation_id'] = $data['id'];
    	$info['is_open'] = 1;
    	$info['create_time'] = time();
    	$login_name=trim(getLoginName());
    	$info['create_man'] = $login_name;
    	$info['bak_info'] = $data['monthly_bak'];
    	$result = $modelDal->modelAddCommissionMonLog($info);
    	return $result;
    }
    //创建延期包月历史记录
    public function createDelayCommissionMonLog ($data)
    {
    	if(empty($data['id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$info['relation_id'] = $data['id'];
    	$info['is_open'] = 1;
    	$info['is_delay'] = 1;
    	$info['create_time'] = time();
    	$login_name=trim(getLoginName());
    	$info['create_man'] = $login_name;
    	$info['bak_info'] = $data['monthly_bak_delay'];
    	$result = $modelDal->modelAddCommissionMonLog($info);
    	return $result;
    }
    //创建停用包月历史记录
    public function createStopCommissionMonLog ($data)
    {
    	if(empty($data['id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$info['relation_id'] = $data['id'];
    	$info['is_open'] = 0;
    	$info['is_delay'] = 0;
    	$info['create_time'] = time();
    	$login_name=trim(getLoginName());
    	$info['create_man'] = $login_name;
    	$info['bak_info'] = '包月合同,手动停用';
    	$result = $modelDal->modelAddCommissionMonLog($info);
    	return $result;
    }
    //根据relation_id查找包月合同历史记录
    public function getContractHistoryLog ($data)
    {
    	if(empty($data['relation_id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$where['relation_id'] = $data['relation_id'];
    	$fields = 'is_open,is_delay,create_time,create_man,bak_info';
    	$result = $modelDal->modelGetCommissionMonLog('','',$fields,$where);
    	return $result;
    }
    //根据id查找包月合同
    public function findContractInfo ($data)
    {
    	if(empty($data['id'])) return null;
    	$modelDal = new \Home\Model\commissionfd();
    	$where['id'] = $data['id'];
    	$fields = 'id,customer_id,monthly_days,monthly_money,contract_type,monthly_start,monthly_end,monthly_bak';
    	$result = $modelDal->modelFindCommissionMonthly($fields,$where);
    	return $result;
    }
    //根据id修改包月合同信息
    public function modifyContractInfo ($data)
    {
    	if(empty($data['id'])||empty($data['customer_id'])||empty($data['monthly_days'])||empty($data['monthly_money'])||empty($data['monthly_start'])) return false;
    	$modelDal = new \Home\Model\commissionfd();
    	$where['id'] = $data['id'];
    	$info['monthly_days'] = trim($data['monthly_days']);
    	$info['monthly_money'] = trim($data['monthly_money']);
    	$info['monthly_start'] = strtotime($data['monthly_start']);
    	$info['monthly_end'] = strtotime($data['monthly_start'])+intval($data['monthly_days'])*3600*24;
    	$info['monthly_bak'] = trim($data['monthly_bak']);
    	$info['contract_type'] = trim($data['contract_type']);
    	$login_name = trim(getLoginName());
    	$info['update_man'] = $login_name;
    	$info['update_time'] = time();
    	$result = $modelDal->modelUpdateCommissionMon($where,$info);
    	//更新APP端用户缓存
    	$customerDal=new \Home\Model\customer();
    	$customerModel=$customerDal->getModelById($data['customer_id']);
    	$customerLogic=new \Logic\CustomerLogic();
    	$customerLogic->updateCustomerCache($customerModel);
    	return $result;
    }
    //根据customer_id查找用户手机号
    public function findCustomerMobile ($data)
    {
    	if(empty($data['customer_id'])) return false;
    	$modelDal = new \Home\Model\commissionfd();
    	$fields = "mobile";
    	$where['id'] = $data['customer_id'];
    	$result = $modelDal->modelFindCustomer($fields,$where);
    	return $result;
    }
    //停用包月
    public function stopCommissionmonthly($commission_id,$customer_id,$update_man){
    	if(!is_numeric($commission_id) || empty($customer_id)){
    		return false;
    	}
    	$modelDal=new \Home\Model\commissionfd();
    	//获取房东下面的所有启用包月规则
    	$comm_list=$modelDal->getCommissionmonthlyByWhere(" customer_id='$customer_id' and is_open=1"," order by id desc limit 10");
    	if($comm_list==null || $comm_list==false){
    		return false;
    	}
    	$count=count($comm_list);
    	if($count==0){
    		return false;
    	}
    	$currentTime=time();
    	$customerDal=new \Home\Model\customer();
    	if($count==1){
    		//只有一条规则，停用
    		$result=$modelDal->updateCommissionmonthly("id=$commission_id",array('is_open'=>0,'update_man'=>$update_man,'update_time'=>$currentTime));
    		if($result){
    			//修改用户数据，更新包月信息
    			$result=$customerDal->updateModel(array('id'=>$customer_id,'is_monthly'=>0,'update_time'=>$currentTime,'update_man'=>$update_man));
    			//更新房间信息
    			$dal=new \Home\Model\houseroom();
    			$dal->updateModelByWhere(array('is_monthly'=>0),"customer_id='$customer_id'");
    		}
    	}else{
    		$monthly_start=0;
    		$monthly_end=0;
    		for ($i=0; $i < $count; $i++) { 
    			if($comm_list[$i]['id']==$commission_id){
    				continue;
    			}
    			$monthly_start=$comm_list[$i]['monthly_start'];
    			$monthly_end=$comm_list[$i]['monthly_end'];
    		}
    		$result=$modelDal->updateCommissionmonthly("id=$commission_id",array('is_open'=>0,'update_man'=>$update_man,'update_time'=>$currentTime));
    		if($result){
    			//修改用户数据，更新包月信息
    			$result=$customerDal->updateModel(array('id'=>$customer_id,'update_time'=>$currentTime,'update_man'=>$update_man,'monthly_start'=>$monthly_start,'monthly_end'=>$monthly_end));
    		}
    	}
    	if($result){
    	    //更新 APP端用户缓存
    	    $customerModel=$customerDal->getModelById($customer_id);
    	    $customerLogic=new \Logic\CustomerLogic();
    	    $customerLogic->updateCustomerCache($customerModel);
    	}
    	return $result;
    }

    /*包月数据（系统自动处理）*/

    //发送对应负责人邮件提醒（剩3天）
    public function monthlySendEmail(){
    	$modelDal=new \Home\Model\customer();
    	$list=$modelDal->getListByWhere("is_monthly=1 AND is_black=0 AND monthly_end>(UNIX_TIMESTAMP()+3600*24*2) AND monthly_end<(UNIX_TIMESTAMP()+3600*24*3)","limit 100");
    	if($list!=null && count($list)>0){
    		$housecustomerinfo = new \Logic\CustomerInfo();
    		$houseadmin = new \Logic\AdminLogin();
    		$modelemail=new \Home\Model\customeremail();
    		foreach ($list as $key => $value) {
		      	$customerinfo=$housecustomerinfo->modelFind(array('customer_id'=>$value['id']));
		      	if($customerinfo!=null && $customerinfo['principal_man']!=""){
	    	        $adminarr=$houseadmin->modelAdminFind(array('user_name'=>$customerinfo['principal_man']));
	    	        if($adminarr!=null && $adminarr['email']!=""){
	    	            $data['id']=create_guid();;
	    	            $data['customer_id']="";
	    	            switch ($value['city_code']) {
	    	            	case '001009001':
	    	            		$data['mail_to']=$adminarr['email'].";suhongye@hizhu.com;xuwenhua@hizhu.com";
	    	            		break;
	    	            	case '001001':
	    	            		$data['mail_to']=$adminarr['email'].";suhongye@hizhu.com;haotongrui@hizhu.com";
	    	            		break;
	    	            	case '001011001':
	    	            		$data['mail_to']=$adminarr['email'].";yantaojie@hizhu.com";
	    	            		break;
	    	            	case '001019002':
	    	            		$data['mail_to']=$adminarr['email'].";yantaojie@hizhu.com";
	    	            		break;
	    	            	case '001010001':
	    	            		$data['mail_to']=$adminarr['email'].";xujin@hizhu.com;chenqi@hizhu.com";
	    	            		break;
	    	            	default:
	    	            		$data['mail_to']=$adminarr['email'];
	    	            		break;
	    	            }
	    	        
	    	            $data['mail_to_name']=$adminarr['user_name'];
	    	            $data['mail_subject']="包月服务通知";
	    	            $hours=intval((intval($value['monthly_end'])-time())/3600);
	    	            $data['mail_content']="房东".$value['mobile']."(".$value['true_name'].")的帐号包月服务还有".$hours."小时过期，请及时处理。";
	    	            $data['mail_type']=0;
	    	            $modelemail->modelAdd($data);
	    	            log_result("monthly-log.txt","负责人邮件提醒：".$data['mail_content']);
	    	        }
	    	    }
    		}
    	}
    }
    //发送对应负责人邮件提醒（剩1天）
    public function monthlySendEmail_append(){
    	$modelDal=new \Home\Model\customer();
    	$list=$modelDal->getListByWhere("is_monthly=1 AND is_black=0 AND monthly_end>UNIX_TIMESTAMP() AND monthly_end<(UNIX_TIMESTAMP()+3600*24)","limit 100");
    	if($list!=null && count($list)>0){
    		$housecustomerinfo = new \Logic\CustomerInfo();
    		$houseadmin = new \Logic\AdminLogin();
    		$modelemail=new \Home\Model\customeremail();
    		foreach ($list as $key => $value) {
		      	$customerinfo=$housecustomerinfo->modelFind(array('customer_id'=>$value['id']));
		      	if($customerinfo!=null && $customerinfo['principal_man']!=""){
	    	        $adminarr=$houseadmin->modelAdminFind(array('user_name'=>$customerinfo['principal_man']));
	    	        if($adminarr!=null && $adminarr['email']!=""){
	    	            $data['id']=create_guid();;
	    	            $data['customer_id']="";
	    	            
	    	            switch ($value['city_code']) {
	    	            	case '001009001':
	    	            		$data['mail_to']=$adminarr['email'].";suhongye@hizhu.com;xuwenhua@hizhu.com";
	    	            		break;
	    	            	case '001001':
	    	            		$data['mail_to']=$adminarr['email'].";suhongye@hizhu.com;haotongrui@hizhu.com";
	    	            		break;
	    	            	case '001011001':
	    	            		$data['mail_to']=$adminarr['email'].";yantaojie@hizhu.com";
	    	            		break;
	    	            	case '001019002':
	    	            		$data['mail_to']=$adminarr['email'].";yantaojie@hizhu.com";
	    	            		break;
	    	            	case '001010001':
	    	            		$data['mail_to']=$adminarr['email'].";xujin@hizhu.com;chenqi@hizhu.com";
	    	            		break;
	    	            	default:
	    	            		$data['mail_to']=$adminarr['email'];
	    	            		break;
	    	            }
	    	            $data['mail_to_name']=$adminarr['user_name'];
	    	            $data['mail_subject']="包月服务通知";
	    	            $hours=intval((intval($value['monthly_end'])-time())/3600);
	    	            $data['mail_content']="房东".$value['mobile']."(".$value['true_name'].")的帐号包月服务还有".$hours."小时过期，请及时处理。";
	    	            $data['mail_type']=0;
	    	            $modelemail->modelAdd($data);
	    	            log_result("monthly-log.txt","负责人邮件提醒：".$data['mail_content']);
	    	        }
	    	    }
    		}
    	}
    }
    //发送房东短信提醒
    public function monthlySendMessage(){
    	$modelDal=new \Home\Model\customer();
    	$list=$modelDal->getListByWhere("is_monthly=1 AND is_black=0 AND monthly_end>(UNIX_TIMESTAMP()+3600*24) AND monthly_end<(UNIX_TIMESTAMP()+3600*24*2)","limit 100");
    	if($list!=null && count($list)>0){
    		foreach ($list as $key => $value) {
      			$sendArr['phonenumber']=$value['mobile'];
      			$sendArr['smstype']='FHS012';
      			$sendArr['timestamp']=time();
      			$sendArr['name']='400-8786-999转8005';
      			$sendArr['money']='xxx';
      			$sendArr['orderid']='xxx';
      			sendPhoneContent($sendArr);
      			log_result("monthly-log.txt","房东短信提醒：".$value['mobile']);
    		}
    	}
    }
    //拉黑到期房东房源
    public function monthlyAddBlack(){
    	$modelDal=new \Home\Model\customer();
    	$handleRoom=new \Home\Model\houseroom();
    	$list=$modelDal->getListByWhere("is_monthly=1 AND is_black=0 AND monthly_end>(UNIX_TIMESTAMP()-3600*24) AND monthly_end<UNIX_TIMESTAMP()","limit 100");
    	if($list!=null && count($list)>0){
    		foreach ($list as $key => $value) {
    			//更新包月房源标识
    			$handleRoom->updateModelByWhere(array('is_monthly'=>0),"customer_id='".$value['id']."'");
      			$data['mobile']=$value['mobile'];
      			$data['customer_id']=$value['id'];
      			$data['bak_type']=3;
      			$data['bak_info']='包月过期拉黑';
      			$data['no_login']=1;
      			$data['no_post_replay']=1;
      			$data['no_call']=1;
      			$data['out_house']=1;
      			$data['is_sendmessage']=0;
      			$data['update_man']='system';
      			$data['update_time']=time();
      			$blacklistLogic=new \Logic\BlackListLogic();
      			$blacklistLogic->addMobileForBlack($data);
      			log_result("monthly-log.txt","房东到期拉黑：".$value['mobile']);
    		}
    	}
    }
    //根据customer_id查找room_id
    public function getHouseRoomInfo ($cid)
	{
		if(empty($cid)) return null;
		$modelDal = new \Home\Model\commissionfd();
		$fields = 'id,resource_id';
		$where['customer_id'] = $cid;
		$where['record_status'] = 1;
		$where['is_regroup'] = 1;
		$result = $modelDal->modelGetRoomInfo('','',$fields,$where);
		return $result;
	}
	//根据room_id给报价人推送消息
	public function pushHouseOfferNotice ($roomID,$resourceID)
	{
		if(empty($roomID) || empty($resourceID)) return false;
		$modelDal = new \Home\Model\commissionfd();
		$fields = 'region_name,room_num';
		$where['id'] = $resourceID;
		$result = $modelDal->modelFindResourceInfo($fields,$where);
		$fieldsOne = 'room_money';
		$whereOne['id'] = $roomID;
		$resultOne = $modelDal->modelFindRoomInfo($fieldsOne,$whereOne);
		//根据room_id查找报价人
		$fieldsTwo = 'customer_id';
		$whereTwo['room_id'] = $roomID; 
		$whereTwo['record_status'] = 1;
		$offerMans = $modelDal->modelGetHouseOffer($fieldsTwo,$whereTwo);
		foreach ($offerMans as $value) {
			$modelDalOne = new \Home\Model\stores();
			$info['id'] = guid();
			$info['customer_id'] = $value['customer_id'];
			$info['notify_type'] = 1009;
			$info['title'] = '房源报价';
			$info['content'] = "您对【".$result['region_name']."小区-".$result['room_num']."室-价格".$resultOne['room_money']."元/月】房源的报价已被删除，原因是房东删除该房源";
			$info['create_time'] = time();
			$return = $modelDalOne->modelAddCustomerNotify($info);
			if($return && C("IS_REDIS_CACHE")){
				#消息推送，红点
				$cache_message_no="store_".strtolower($info['customer_id'])."_message_no";
				$cache_message_no=set_cache_public_key($cache_message_no);
				$message_no_count=get_cache_data(C("COUCHBASE_BUCKET_GAODUDATA"),$cache_message_no);
				$message_no_count=$message_no_count==null?0:$message_no_count;
				$message_no_count= $message_no_count+1;
			    set_cache_data(C("COUCHBASE_BUCKET_GAODUDATA"),$cache_message_no,$message_no_count,0);
			}
		}	
		return true; 
	}
}
?>
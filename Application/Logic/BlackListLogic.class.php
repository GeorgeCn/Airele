<?php
namespace Logic;
class BlackListLogic{
	public function addModel($data){
		$dataModel=new \Home\Model\blacklist();
		return $dataModel->addModel($data);
	}
	//新增记录日志
	public function addBlacklog($data){
		$dataModel=new \Home\Model\blacklist();
		return $dataModel->addBlacklog($data);
	}
	public function deleteModel($id,$phone=''){
      	$dataModel=new \Home\Model\blacklist();
		return $dataModel->deleteModel($id);
    }
	public function updateModel($data){
		$dataModel=new \Home\Model\blacklist();
		return $dataModel->updateModel($data);
	}
	//统计数量
	public function getModelCount($condition){
		$dataModel=new \Home\Model\blacklist();
		if(isset($condition['removeBlack']) && $condition['removeBlack']=='1'){
			//撤销拉黑记录
			$where=" handle_type=1 ";
			if(isset($condition['startTime']) && $condition['startTime']!=''){
				$where.=" and update_time>=".strtotime($condition['startTime']);
			}
			if(isset($condition['endTime']) && $condition['endTime']!=''){
				$where.=" and update_time<".(strtotime($condition['endTime'])+3600*24);
			}
			$data= $dataModel->getBlacklogData("count(1) as cnt",$where);
			if($data!=null && count($data)>0){
				return $data[0]['cnt'];
			}
			return 0;
		}else{
			//黑名单列表
			$where='';
			if(isset($condition['startTime']) && $condition['startTime']!=''){
				$where.=" where update_time>=".strtotime($condition['startTime']);
			}
			if(isset($condition['endTime']) && $condition['endTime']!=''){
				if($where==''){
					$where.=" where update_time<".(strtotime($condition['endTime'])+3600*24);
				}else{
					$where.=" and update_time<".(strtotime($condition['endTime'])+3600*24);
				}
			}
			if(isset($condition['bak_type']) && $condition['bak_type']!=''){
				if($where==''){
					$where.=" where bak_type=".$condition['bak_type'];
				}else{
					$where.=" and bak_type=".$condition['bak_type'];
				}
			}
			$data= $dataModel->getModelCount($where);
			if($data!=null && count($data)>0){
				return $data[0]['cnt'];
			}
			return 0;
		}
	}
	//展示列表
	public function getModelList($condition,$limit_start,$limit_end){
		$dataModel=new \Home\Model\blacklist();
		if(isset($condition['mobile']) && $condition['mobile']!=''){
			//先查黑名单，没有再查日志纪录
			$list= $dataModel->getModelList(" where mobile='".$condition['mobile']."'",$limit_start,$limit_end);
			if($list!=null && count($list)>0){
				return $list;
			}
			return $dataModel->getBlacklogData("id,mobile,no_login,no_post_replay,no_call,out_house,update_time,oper_name,bak_info,bak_type,handle_type",
				" mobile='".$condition['mobile']."' order by update_time desc limit 10");
		}
		/*查询设备号 */
		if(isset($condition['mobileTwo']) && $condition['mobileTwo']!=''){
			$customerData=$dataModel->getCustomerData("id"," where mobile='".$condition['mobileTwo']."' limit 1");
			if($customerData!=null && count($customerData)>0){
				if($condition['appType']=='1'){
					//房东版
					$customerdevData=$dataModel->getCustomerdevshipClient("distinct udid"," where customer_id='".$customerData[0]['id']."' limit 10");
				}else{
					$customerdevData=$dataModel->getCustomerdevshipRenter("distinct udid"," where customer_id='".$customerData[0]['id']."' limit 10");
				}
				if($customerdevData!=null && count($customerdevData)>0){
					$udid_str='';
					foreach ($customerdevData as $key => $value) {
						if(empty($value['udid'])){
							continue;
						}
						$udid_str.="'".$value['udid']."',";
					}
					if($udid_str==''){
						return null;
					}
					$udid_str=trim($udid_str,',');
					return $dataModel->getModelList(" where customer_udid in ($udid_str)",0,20);
				}
				return null;
			}
			return null;
		}
		if(isset($condition['removeBlack']) && $condition['removeBlack']=='1'){
			//撤销拉黑记录
			$where=" handle_type=1 ";
			if(isset($condition['startTime']) && $condition['startTime']!=''){
				$where.=" and update_time>=".strtotime($condition['startTime']);
			}
			if(isset($condition['endTime']) && $condition['endTime']!=''){
				$where.=" and update_time<".(strtotime($condition['endTime'])+3600*24);
			}
			return $dataModel->getBlacklogData("id,mobile,no_login,no_post_replay,no_call,out_house,update_time,oper_name,bak_info,bak_type,handle_type",
				" $where order by update_time desc limit $limit_start,$limit_end");
		}else{
			//黑名单列表
			$where='';
			if(isset($condition['startTime']) && $condition['startTime']!=''){
				$where.=" where update_time>=".strtotime($condition['startTime']);
			}
			if(isset($condition['endTime']) && $condition['endTime']!=''){
				if($where==''){
					$where.=" where update_time<".(strtotime($condition['endTime'])+3600*24);
				}else{
					$where.=" and update_time<".(strtotime($condition['endTime'])+3600*24);
				}
			}
			if(isset($condition['bak_type']) && $condition['bak_type']!=''){
				if($where==''){
					$where.=" where bak_type=".$condition['bak_type'];
				}else{
					$where.=" and bak_type=".$condition['bak_type'];
				}
			}
			return $dataModel->getModelList($where,$limit_start,$limit_end);
		}
	}
	//获取用户信息
	public function getCustomerInfoByMobile($mobile){
      $dataModel=new \Home\Model\customer();
	  return $dataModel->getResourceClientByPhone($mobile);
    }
    public function getModelByMobile($mobile){
      $dataModel=new \Home\Model\blacklist();
	  return $dataModel->getModelByMobile($mobile);
  	}

  	public function getModelResource($where){
  		 $dataModel=new \Home\Model\blacklist();
	    return $dataModel->getModelResource($where);

  	}
  	public function getModelRoom($where){
  		$dataModel=new \Home\Model\blacklist();
	    return $dataModel->getModelRoom($where);
  	}
  	public function modelFind($where){
  		$dataModel=new \Home\Model\blacklist();
	    return $dataModel->modelFind($where);
  	}
  	//拉黑电话
  	public function addMobileForBlack($data){
	    if(empty($data['mobile'])){
	    	return false;
	    }
	    //检查白名单
	    $is_white=$this->checkIsWhite($data['mobile']);
	    if($is_white){
	    	return false;
	    }
	    /*if(isset($data['without_man']) && $data['without_man']==1){
	    	//判断是否内部启用员工
	    	$adminDal=new \Home\Model\adminlogin();
	    	$adminResult=$adminDal->getListByWhere("mobile='".$data['mobile']."' and record_status=1 limit 1");
	    	if($adminResult!=null && count($adminResult)>0){
	    		return false;
	    	}
	    }*/
	    $saveModel['bak_type']=$data['bak_type'];
	    $saveModel['bak_info']=$data['bak_info'];
	    $saveModel['no_login']=$data['no_login'];
	    $saveModel['no_post_replay']=$data['no_post_replay'];
	    $saveModel['no_call']=$data['no_call'];
	    $saveModel['out_house']=$data['out_house'];
	    if(empty($saveModel['out_house'])){
	      $saveModel['out_house']=0;
	    }
	    $devices=false;
	    $customer_id=$data['customer_id'];
	    $customerDal=new \Home\Model\customer();
	    if(empty($customer_id)){
	    	$customerModel=$customerDal->getResourceClientByPhone($data['mobile']);
	    	if($customerModel!=null && $customerModel!=false){
	    		$customer_id=$customerModel['id'];
	    	}
	    }
	    if(!empty($customer_id)){
	        $saveModel['customer_id']=$customer_id;
	        //更新用户数据
	        $customerDal->updateModel(array('id'=>$customer_id,'update_time'=>$data['update_time'],'update_man'=>$data['update_man'],'is_black'=>1));
	        if($saveModel['no_login']){
	        	//退出登录
	           $this->app_loginout("xxxx",$customer_id);
	           $this->store_loginout("xx",$customer_id);
	           if($data['is_sendmessage']){
	              //拉黑短信通知   
	              $handleSms = new \Logic\Commonsms();
	              $smsendarr['renter_phone']=$data['mobile'];
	              $smsendarr['create_time']=$data['update_time'];
	              $smsendarr['renter_name']="xx";
	              $smsendarr['price_cnt']="00";
	              $smsendarr['id']="00";
	              $handleSms->sendSms($smsendarr,$saveModel['bak_type']=='3'?'FHS011':'FHS009');
	           }
	        }
	        $roomLogic=new \Logic\HouseRoomLogic();
	        if($saveModel['out_house']=='1'){
	           $roomids_array=$roomLogic->getRoomidsByCustomerid($customer_id);
	           if($roomids_array!==false){
	              foreach ($roomids_array as $key => $value) {
	              	  //下架房源
	                  $roomLogic->offloadingByid($value['id'],$data['update_man']);
	              }
	           }
	        }else if($saveModel['out_house']=='2'){
	            $roomDal=new \Home\Model\houseroom();
	            $roomids_array=$roomDal->getListByWhere("where customer_id='$customer_id' and record_status=1 ");
	            if($roomids_array!=null){
	               foreach ($roomids_array as $key => $value) {
	               		//删除房源
	                   $roomLogic->deleteRoomByRoomid(array('room_id'=>$value['id'],'resource_id'=>$value['resource_id'],'handle_man'=>$data['update_man'],'delete_type'=>$saveModel['bak_type']=='2'?'6':$saveModel['bak_type'],'delete_text'=>$saveModel['bak_info']));
	               }
	            }
	        }  
	        $handleDevices=new \Home\Model\customerdevices();   
	        $devices=$handleDevices->getUseModel($customer_id);   
	    }
	    if($devices){
	        $saveModel['customer_udid']=$devices['udid'];
	    }
	    $saveModel['id']=guid();
	    $saveModel['mobile']=$data['mobile'];
	    $saveModel['create_time']=$data['update_time'];
	    $saveModel['update_time']=$data['update_time'];
	    $saveModel['oper_name']=$data['update_man'];
	    //新增黑名单
	    $blacklistDal=new \Home\Model\blacklist();
	    $result= $blacklistDal->addModel($saveModel);
	    if($result){
	    	$blacklistDal->addBlacklog(array('mobile'=>$saveModel['mobile'],'no_login'=>$saveModel['no_login'],'no_post_replay'=>$saveModel['no_post_replay'],'no_call'=>$saveModel['no_call'],'out_house'=>$saveModel['out_house'],
	    	  'update_time'=>$saveModel['update_time'],'oper_name'=>$saveModel['oper_name'],'bak_info'=>$saveModel['bak_info'],'bak_type'=>$saveModel['bak_type'],'handle_type'=>0));
	    }
	    return $result;
  	}
  	/*APP租客版退出登录 */
  	public function app_loginout($udid,$customerId){
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
  	    $headers['ScreenSize'] = '560x960'; 
  	    $headers['Platform'] =$platform;
  	    $headers['Udid'] = $udid;
  	    $headers['DeviceId'] = '';
  	    $headers['ClientVer'] =$clientver;
  	    $headers['Md5'] =$md5sign;
  	    $headers['Session'] = $customerId;
  	    $headerArr = array(); 
  	    foreach( $headers as $n => $v ) { 
  	        $headerArr[] = $n .':' . $v;  
  	    }
  	    $url=C("API_SERVICE_URL").'customer/logout.html';
  	    $aa=curl_post($headerArr,null,$url);
  	    log_result("app_loginout.txt","租客版退出返回信息：".$aa."customer_id:".$customerId);
  	}
  	/*APP房东版退出登录 */
  	public function store_loginout($udid,$customerId){
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
  	    $headers['ScreenSize'] = '560x960'; 
  	    $headers['Platform'] =$platform;
  	    $headers['Udid'] = $udid;
  	    $headers['DeviceId'] = '';
  	    $headers['ClientVer'] =$clientver;
  	    $headers['Md5'] =$md5sign;
  	    $headers['Session'] = $customerId;
  	    $headerArr = array(); 
  	    foreach( $headers as $n => $v ) { 
  	        $headerArr[] = $n .':' . $v;  
  	    }
  	    $url=C("STOREAPI_SERVICE_URL").'customer/logout.html';
  	    $aa=curl_post($headerArr,null,$url);
  	    log_result("app_loginout.txt","房东版退出返回信息：".$aa."customer_id:".$customerId);
  	}

  	//白名单
  	public function getWhiteuserCount($condition=''){
  		$handleDal=new \Home\Model\blacklist();
  		$data= $handleDal->getWhiteuserData("count(1) as cnt","");
  		if($data!=null && count($data)>0){
  			return $data[0]['cnt'];
  		}
  		return 0;
  	}
  	public function getWhiteuserList($condition,$limit_start,$limit_end){
  		if(isset($condition['mobile']) && $condition['mobile']!=''){
  			$where=" where mobile='".$condition['mobile']."' limit 1";
  		}else{
  			$where=" order by create_time desc limit $limit_start,$limit_end";
  		}
  		$handleDal=new \Home\Model\blacklist();
  		$data= $handleDal->getWhiteuserData("mobile,create_time,create_man,bak_info",$where);
  		return $data;
  	}
  	public function addWhiteUser($data){
  		if(!is_array($data)){
  			return false;
  		}
	  	$handleDal=new \Home\Model\blacklist();
	  	return $handleDal->addWhiteUser($data);
  	}
  	public function deleteWhiteOne($mobile){
  		if($mobile==''){
  			return false;
  		}
	  	$handleDal=new \Home\Model\blacklist();
	  	return $handleDal->deleteWhiteuser("mobile='$mobile'");
  	}
  	//判断是否白名单用户
  	public function checkIsWhite($mobile){
  		if(empty($mobile)){
  			return false;
  		}
  		$handleDal=new \Home\Model\blacklist();
  		$data= $handleDal->getWhiteuserData("mobile,create_time,create_man,bak_info"," where mobile='$mobile' limit 1");
  		if($data!=null && count($data)>0){
  			return true;
  		}
  		return false;
  	}
  	//隐藏帖子和回复
  	public function hideCirclepostData($customer_id){
  		if(empty($customer_id)){
  			return false;
  		}
  		$handleDal=new \Home\Model\blacklist();
  		$handleDal->updateCirclepost("customer_id='$customer_id'",array('is_display'=>0));
  		$handleDal->updateCirclepostreplay("customer_id='$customer_id'",array('is_display'=>0));
  		return true;
  	}
  	//删除中介报价
  	public function deleteHouseOffer ($cid) 
  	{
  		if(empty($cid)) return false;
  		$handleDal = new \Home\Model\blacklist();
  		$where['customer_id'] = $cid;
  		$info['record_status'] = 0;
  		$result = $handleDal->modelDeleteHouseOffer($where,$info);
  		return $result; 
  	}
  	//删除中介房间报价
  	public function deleteHouseRoomOffer ($room) 
  	{
  		if(empty($room)) return false;
  		$handleDal = new \Home\Model\blacklist();
  		$where['room_id'] = $room;
  		$info['record_status'] = 0;
  		$result = $handleDal->modelDeleteHouseOffer($where,$info);
  		return $result; 
  	}
  	//修改房间聚合属性
  	public function updateHouseRoom ($room) 
  	{
  		if(empty($room)) return false;
  		$handleDal = new \Home\Model\blacklist();
  		$where['id'] = $room;
  		$info['is_regroup'] = 0;
  		$result = $handleDal->modelUpdateHouseRoom($where,$info);
  		return $result; 
  	}
}


?>
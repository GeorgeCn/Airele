<?php
namespace Logic;
class HouseRoomLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->addModel($data);
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->updateModel($data);
   }
   //修改 by resource_id
   public function updateModelByResourceid($data){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->updateModelByResourceid($data);
   }
    //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->deleteModelById($id);
   }
   public function deleteModelByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->deleteModelByResourceId($resource_id);
   }
    public function deleteModelByWhere($data,$where){
       if(is_array($data) && count($data)>0 && $where!=''){
          $modelDal=new \Home\Model\houseroom();
          return $modelDal->updateModelByWhere($data,$where);
       }
       return false;
    }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelById($id);
   }
   public function getModelByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelByResourceId($resource_id);
   }
     //根据房源ID查询房间列表
   public function getModelListByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelListByResourceId($resourceId);
   }
    //列表总条数
   public function getModelListCount($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelListCount($conditionString);
   }
    //房间查询列表
   public function getModelList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelList($conditionString,$limit_start,$limit_end);
   }
    //房间查询列表（特殊查询，例如-房间编号）
   public function getModelListByCondition($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getModelListByCondition($conditionString);
   }
   public function getDownloadList($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->getDownloadList($conditionString);
   }
   
  public function getConditionString($condition){
     $conditionString="";
     if(trim($condition['startTime'])!=''){
        $conditionString.=" and r.update_time>=".strtotime(trim($condition['startTime']));
     }
     if(trim($condition['endTime'])!=''){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and r.update_time<=".$endTime;
     }
     //创建时间
     if(trim($condition['startTime_create'])!=''){
        $conditionString.=" and r.create_time>=".strtotime(trim($condition['startTime_create']));
     }
     if(trim($condition['endTime_create'])!=''){
        $endTime=strtotime(trim($condition['endTime_create']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and r.create_time<=".$endTime;
     }
     if(isset($condition['estateName']) && $condition['estateName']!=''){
        $conditionString.=" and h.estate_name like '".str_replace("Slash", "/", $condition['estateName'])."%' ";
     }
     if($condition['roomStatus']!=''){
        //出租状态，删除状态
        if($condition['roomStatus']=="del"){
          $conditionString.=" and r.record_status=0 ";
        }else{
          //$conditionString.=" and h.record_status=1 and r.record_status=1 ";
          $conditionString.=" and r.status=".$condition['roomStatus'];
        }
     }
     if(isset($condition['delState']) && $condition['delState']!=""){
        $conditionString.=" and r.record_status=".$condition['delState'];
     }
     //租金
     if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
        if(is_numeric($condition['moneyMin'])){
          $conditionString.=" and r.room_money>=".$condition['moneyMin'];
        }
     }
     if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
        if(is_numeric($condition['moneyMax'])){
          $conditionString.=" and r.room_money<=".$condition['moneyMax'];
        }
     }
     #佣金
     if(isset($condition['is_commission']) && $condition['is_commission']!=""){
        $conditionString.=" and r.is_commission=".$condition['is_commission'];
     }
     //包月条件
     if(isset($condition['isMonth']) && $condition['isMonth']!=''){
        $conditionString.=" and r.is_monthly=".$condition['isMonth'];
     }
     if(isset($condition['isVedio']) && $condition['isVedio']!=''){
        $conditionString.=" and r.had_vedio=".$condition['isVedio'];
     }
     //中介
     if(isset($condition['isGroup']) && $condition['isGroup']!=''){
        $conditionString.=" and r.is_regroup=".$condition['isGroup'];
     }
	   if(isset($condition['isRental']) && $condition['isRental']!=''){
        $conditionString.=" and h.rental_type=".$condition['isRental'];
  	 }
     //是否付费
     if(isset($condition['isFee']) && $condition['isFee']!=''){
        if($condition['isFee']==1){
          $conditionString.=" and (r.is_monthly=1 or r.is_commission=1)";
        }else if($condition['isFee']==0){
          $conditionString.=" and r.is_monthly=0 and r.is_commission=0";
        }
     }
     //面积
     if(isset($condition['houseareaMin']) && $condition['houseareaMin']!=""){
        if(is_numeric($condition['houseareaMin'])){
          $conditionString.=" and h.area>=".$condition['houseareaMin'];
        }
     }
     if(isset($condition['houseareaMax']) && $condition['houseareaMax']!=""){
        if(is_numeric($condition['houseareaMax'])){
          $conditionString.=" and h.area<=".$condition['houseareaMax'];
        }
     }
     if(isset($condition['roomareaMin']) && $condition['roomareaMin']!=""){
        if(is_numeric($condition['roomareaMin'])){
          $conditionString.=" and r.room_area>=".$condition['roomareaMin'];
        }
     }
     if(isset($condition['roomareaMax']) && $condition['roomareaMax']!=""){
        if(is_numeric($condition['roomareaMax'])){
          $conditionString.=" and r.room_area<=".$condition['roomareaMax'];
        }
     }
     if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
     }
     if(isset($condition['third_no']) && trim($condition['third_no'])!=''){
        $conditionString.=" and r.third_no='".str_replace("'", "", trim($condition['third_no']))."' ";
     }
     if(isset($condition['business_type']) && trim($condition['business_type'])!=''){
        $conditionString.=" and h.business_type='".trim($condition['business_type'])."' ";
     }
     if(trim($condition['clientPhone'])!=''){
        $conditionString.=" and h.client_phone='".str_replace("'", "", trim($condition['clientPhone']))."' ";
     }
     if(isset($condition['create_man']) && trim($condition['create_man'])!=''){
        $conditionString.=" and r.create_man='".str_replace("'", "", trim($condition['create_man']))."' ";
     }
     if(isset($condition['update_man']) && $condition['update_man']!=''){
        $conditionString.=" and r.update_man='".$condition['update_man']."' ";
     }
     if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
        $conditionString.=" and h.info_resource_type=".$condition['info_resource_type'];
     }
     if(trim($condition['info_resource'])!=''){
        if($condition['info_resource']=="空"){
          $conditionString.=" and h.info_resource='' ";
        }else{
          $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
        }
     }
     if(isset($condition['brand_type']) && $condition['brand_type']!=''){
        if($condition['brand_type']=='none'){
           $conditionString.=" and h.brand_type=''";
        }else if($condition['brand_type']=='all'){
           $conditionString.=" and h.brand_type<>''";
        }else{
            $conditionString.=" and h.brand_type='".$condition['brand_type']."' ";
        }
     }
     if(isset($condition['region']) && $condition['region']!=''){
        $conditionString.=" and h.region_id=".$condition['region'];
     }
     if(isset($condition['scope']) && $condition['scope']!=''){
        $conditionString.=" and h.scope_id=".$condition['scope'];
     }
     #职业房东房源
     if(isset($condition['is_owner']) && $condition['is_owner']!=''){
        $conditionString.=" and h.is_owner='".trim($condition['is_owner'])."' ";   
     }
     #联系房东和帮我预约设置
     if(isset($condition['callclient']) && $condition['callclient']!=""){
      $conditionString.=" and r.show_call_bar=".$condition['callclient'];
     }
     if(isset($condition['appoint']) && $condition['appoint']!=""){
      $conditionString.=" and r.show_reserve_bar=".$condition['appoint'];
     }
     if(isset($condition['kefu']) && $condition['kefu']!=""){
      $conditionString.=" and r.show_kefu_bar=".$condition['kefu'];
     }
     #房东负责人
     if(isset($condition['principal_man']) && $condition['principal_man']!=""){
      $conditionString.=" and r.principal_man='".str_replace("'", "", trim($condition['principal_man']))."'";
     }
     #户型和房间类型
     if(isset($condition['room_num']) && $condition['room_num']!=""){
        if($condition['room_num']=='2+'){
            $conditionString.=" and h.room_num>=2";
        }else if($condition['room_num']=='3+'){
            $conditionString.=" and h.room_num>=3";
        }else if($condition['room_num']=='4+'){
            $conditionString.=" and h.room_num>=4";
        }else{
            $conditionString.=" and h.room_num=".$condition['room_num'];
        }
     }
     if(isset($condition['rent_type']) && $condition['rent_type']!=""){
        $conditionString.=" and h.rent_type=".$condition['rent_type'];
     }
     #带看人
     if(isset($condition['takelook_man']) && $condition['takelook_man']!=""){
        $conditionString.=" and r.takelook_man='".$condition['takelook_man']."'";
     }
     if(isset($condition['houseNo']) && $condition['houseNo']!=""){
        $conditionString.=" and h.house_no='".$condition['houseNo']."'";
     }
     return $conditionString.' ';
  }

  /*生成房间编号*/
  public function createRoomno($city_code='')
  {
    switch ($city_code) {
      case '':
        $no=C('CITY_PREX').date("Ymd",time())."03".rand(10000, 99999);
        break;
      case '001009001':
        $no='SH'.date("Ymd",time())."03".rand(10000, 99999);
        break;
      case '001001':
        $no='BJ'.date("Ymd",time())."03".rand(10000, 99999);
        break;
      case '001011001':
        $no='HZ'.date("Ymd",time())."03".rand(10000, 99999);
        break;
      case '001010001':
        $no='NJ'.date("Ymd",time())."03".rand(10000, 99999);
        break;
      case '001019002':
        $no='SZ'.date("Ymd",time())."03".rand(10000, 99999);
        break;
      default:
        break;
    }
    
    $dal=new \Home\Model\houseroom();
    $count=$dal->getCountByRoomno($no);
    if($count>=1)
    {
      return $this->createRoomno($city_code);
    }
    else
    {
      return $no;
    }
  }
  //查询新增房间列表
  public function getAddRoomListByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroom();
     $result = $modelDal->getAddRoomListByResourceId($resourceId);
     return $result;
  }
  //查询房源下的最大房间序号
  public function getMaxRoomIndexByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroom();
     $result = $modelDal->getMaxRoomIndexByResourceId($resourceId);
     return $result;
  }
  //根据room_id查询房源信息
  public function getResourceInfoByRoomid($room_id){
     $modelDal=new \Home\Model\houseroom();
     $result = $modelDal->getResourceInfoByRoomid($room_id);
     return $result;
  }
  public function getRoomIdsByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroom();
     $result = $modelDal->getRoomIdsByResourceId($resource_id);
     return $result;
  }
  //更新房间负责人 by 房源ID 
  public function updateCreatemanByResourceid($resourceId,$create_man){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->updateCreatemanByResourceid($resourceId,$create_man);
  }
  /*置顶房间*/
  public function getTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getTopRoomById($room_id);
  }
  public function getTopRoomByRoomno($room_no){
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getTopRoomByRoomno($room_no);
  }
  public function setTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->setTopRoomById($room_id);
  }
  public function cancelTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->cancelTopRoomById($room_id); 
  }
  //置顶列表
  public function getTopRoomCount($condition){
    $conditionString='';
    if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
    }
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getTopRoomCount($conditionString);
  }
  public function getTopRoomList($condition,$limit_start,$limit_end){
    $conditionString='';
    if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
    }
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getTopRoomList($conditionString,$limit_start,$limit_end);
  }
  public function modifyTopRoomSort($room_id,$sort_index,$room_idTwo,$sort_indexTwo){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->modifyTopRoomSort($room_id,$sort_index,$room_idTwo,$sort_indexTwo);
  }
  public function updateTopRoomSorts($sort_index){
     $modelDal=new \Home\Model\houseroom();
     return $modelDal->updateTopRoomSorts($sort_index);
  }
  #联系房东和帮我预约设置
  public function setAppointmentShow($type,$room_ids,$is_show){
    $is_show=$is_show=="1"?1:0;
     $modelDal=new \Home\Model\houseroom();
     if($type=="call"){
      return $modelDal->setCallClientShow($room_ids,$is_show);
     }else if($type=="appoint"){
      return $modelDal->setAppointmentShow($room_ids,$is_show);
     }else if($type=="kefu"){
      return $modelDal->setKefuShow($room_ids,$is_show);
     }
     return false;
  }
  public function getSetAppointListCount($condition){
    $conditionString=$this->getConditionString($condition);
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getSetAppointListCount($conditionString);
  }
  public function getSetAppointList($condition,$limit_start,$limit_end){
    $conditionString=$this->getConditionString($condition);
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getSetAppointList($conditionString,$limit_start,$limit_end);
  }
  //刷新房东房源
  public function refreshRoomForOwner($customer_id,$update_time,$update_man){
    if(empty($customer_id)){
      return false;
    }
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->updateModelByWhere(array('update_time'=>$update_time,'update_man'=>$update_man),array('customer_id'=>$customer_id,'status'=>2,'record_status'=>1));
  }
  //获取房东下面的房间id
  public function getRoomidsByCustomerid($customer_id){
    if(empty($customer_id)){
      return false;
    }
    $modelDal=new \Home\Model\houseroom();
    return $modelDal->getListByWhere("where customer_id='$customer_id' and status=2 and record_status=1 ");
  }

  //下架（待维护）
  public function offloadingByid($room_id,$handle_man=''){
    if(empty($room_id)){
      return false;
    }
    $now_time=time();
    if($handle_man==''){
      $handle_man=trim(getLoginName());
    }
    if(empty($handle_man)){
      return false;
    }
    $modelDal=new \Home\Model\houseroom();
    $updateResult=$modelDal->updateModelByWhere(array('status'=>4,'update_time'=>$now_time,'update_man'=>$handle_man),array('id'=>$room_id));
    if($updateResult){
        //操作房间查询表
        $modelDal=new \Home\Model\houseselect();
        $modelDal->deleteModelByRoomid($room_id);
         //记录日志
         $modelDal=new \Home\Model\houseupdatelog();
         $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'下架'));
         //清除缓存
         $cache_key=set_cache_public_key('room_model_get'.$room_id);
         del_cache_admin('',$cache_key);
      }
     return $updateResult;
  }

  //下架房间（发送邮件）
  public function downroomByid($room_id){
    if(empty($room_id)){
      return false;
    }
    $now_time=time();
    $handle_man=trim(getLoginName());
    if(empty($handle_man)){
      return false;
    }
    $modelDal=new \Home\Model\houseroom();
    $updateResult=$modelDal->updateModelByWhere(array('status'=>3,'up_count'=>0,'update_time'=>$now_time,'update_man'=>$handle_man),array('id'=>$room_id));
    if($updateResult){
      //发送邮件
      $pushemaillogic=new \Logic\PushemailLogic();
      $pushemaillogic->housepushemail($room_id);
        //操作房间查询表
        $modelDal=new \Home\Model\houseselect();
        $modelDal->deleteModelByRoomid($room_id);
         
         //删除58、百姓、搜房等API发布
         //$modelDal=new \Home\Model\openapipush();
         //$modelDal->updateModelByWhere(array('record_status'=>0,'update_time'=>$now_time,'update_man'=>$handle_man),array('room_id'=>$room_id));

         //记录日志
         $modelDal=new \Home\Model\houseupdatelog();
         $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'已出租'));
         //清除缓存
         $cache_key=set_cache_public_key('room_model_get'.$room_id);
         del_cache_admin('',$cache_key);
      }
     return $updateResult;
  }
  //删除房间
  public function deleteRoomByRoomid($data){
      if(!is_array($data)){
          return false;
      }
      $login_name=$data['handle_man'];
      $room_id=$data['room_id'];
      $delete_type=$data['delete_type'];
      $delete_text=$data['delete_text'];
      $resource_id=isset($data['resource_id'])?$data['resource_id']:'';
      
      if(empty($login_name) || empty($room_id) || empty($delete_type)){
          return false;
      }
      $handleRoom=new \Home\Model\houseroom();
      if(empty($delete_text)){
        $result2=$handleRoom->updateModelByWhere(array('record_status'=>0,'update_man'=>$login_name,'update_time'=>time(),'delete_type'=>$delete_type),"id='$room_id'");
      }else{
        $result2=$handleRoom->updateModelByWhere(array('record_status'=>0,'update_man'=>$login_name,'update_time'=>time(),'delete_type'=>$delete_type,'ext_examineinfo'=>$delete_text),"id='$room_id'");
      }
      if($result2){
        $this->updateHouseroomCache(array('id'=>$room_id,'room_money'=>1),10);//清除缓存
        //操作房间查询表
        $handleSelect=new \Home\Model\houseselect();
        $handleSelect->deleteModelByRoomid($room_id);
 
        //删除店铺房源
        $handleModel=new \Home\Model\storehouses();
        $handleModel->deleteStorehouses("room_id='$room_id'");
        if($resource_id!=''){
          //删除房源数据
          $handleModel=new \Home\Model\houseresource();
          $handleModel->updateModel(array('id'=>$resource_id,'record_status'=>0,'update_time'=>time(),'update_man'=>$login_name));
        }
        //记录日志
        $recordHandle=new \Home\Model\houseupdatelog();
        $recordData['id']=guid();
        $recordData['house_id']=$room_id;
        $recordData['house_type']=2;
        $recordData['update_man']=$login_name;
        $recordData['update_time']=time();
        $recordData['operate_type']='删除房间';
        return $recordHandle->addModel($recordData);
      }
      return $result2;
  }

  //下架房间（公共类使用）
  public function downroomByidForCommon($room_id,$handle_man){
    if(empty($room_id)){
      return false;
    }else if(empty($handle_man)){
      return false;
    }
    $modelDal=new \Home\Model\houseroom();
    $now_time=time();
    $updateResult=$modelDal->updateModelByWhere(array('status'=>3,'up_count'=>0,'update_time'=>$now_time,'update_man'=>$handle_man),array('id'=>$room_id));
    if($updateResult){
        //操作房间查询表
        $modelDal=new \Home\Model\houseselect();
        $modelDal->deleteModelByRoomid($room_id);

        //记录日志
         $modelDal=new \Home\Model\houseupdatelog();
         $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'已出租'));
         //清除缓存
         $cache_key=set_cache_public_key('room_model_get'.$room_id);
         del_cache_admin('',$cache_key);
      }
     return $updateResult;
  }
  //重新上架（公共类使用）
  public function reuproomByidForCommon($room_id,$handle_man){
    if(empty($room_id)){
      return false;
    }else if(empty($handle_man)){
      return false;
    }
    $now_time=time();
    $modelDal=new \Home\Model\houseroom();
    $updateResult=$modelDal->updateModelByWhere(array('status'=>2,'up_count'=>1,'update_time'=>$now_time,'update_man'=>$handle_man),array('id'=>$room_id,'status'=>3));
    if($updateResult){
        //操作房间查询表
        $modelDal=new \Home\Model\houseselect();
        $modelDal->addModelByRoomid($room_id);
         //记录日志
         $modelDal=new \Home\Model\houseupdatelog();
         $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'上架'));
      }
     return $updateResult;
  }

  //更新房源缓存
  public function updateHouseresourceCache($data){
      if(!is_array($data)){
        return false;
      }
      if($data['id']=='' || $data['estate_name']==''){
        return false;
      }
      if(!C('IS_REDIS_CACHE')){
        return false;
      }
      $cache_key="resource_model_get".$data['id'];
      $cache_key=set_cache_public_key($cache_key);
      set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$cache_key,$data,1200);
      return true;
  }
  //更新房间缓存
  public function updateHouseroomCache($data,$expire_time=1200){
      if(!is_array($data)){
        return false;
      }
      if(empty($data['id']) || empty($data['room_money'])){
        return false;
      }
      if(!C('IS_REDIS_CACHE')){
        return false;
      }
      $cache_key="room_model_get".$data['id'];
      $cache_key=set_cache_public_key($cache_key);
      if($expire_time<100){
        $result=set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$cache_key,'',$expire_time);
      }else{
        $result=set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$cache_key,$data,$expire_time);
      }
      
      //file_put_contents("cache-log.txt", date('Y-m-d H:i:s')."：更新房间缓存,key->".$cache_key.",roomStatus->".$data['status'].",result->".$result."\r\n", FILE_APPEND);
      return true;
  }
  //获取房源房间相关数据
  public function getHouseinfoByRoomid($room_id){
    if(empty($room_id)){
      return null;
    }
    $modelDal=new \Home\Model\houseroom();
    $data=$modelDal->getFieldsByWhere("customer_id,room_money,status,record_status,info_resource,info_resource_url","id='$room_id' limit 1");
    if($data==null || count($data)==0){
      return null;
    }
    $roomModel=$data[0];
    if($roomModel['customer_id']=='' || $roomModel['info_resource']=='58' || $roomModel['info_resource']=='赶集'){
      return array('room_id'=>$room_id,'room_money'=>$roomModel['room_money'],'room_money_new'=>$roomModel['room_money'],'room_status'=>$roomModel['status'],'record_status'=>$roomModel['record_status'],'owner_phone'=>'','owner_phone_new'=>'','url'=>$roomModel['info_resource_url']);
    }
     $modelDal=new \Home\Model\customer();
     $ownerData=$modelDal->getListByWhere("id='".$roomModel['customer_id']."'","limit 1");
     if($ownerData==null || count($ownerData)==0){
        return array('room_id'=>$room_id,'room_money'=>$roomModel['room_money'],'room_money_new'=>$roomModel['room_money'],'room_status'=>$roomModel['status'],'record_status'=>$roomModel['record_status'],'owner_phone'=>'','owner_phone_new'=>'','url'=>$roomModel['info_resource_url']);
     }
     return array('room_id'=>$room_id,'room_money'=>$roomModel['room_money'],'room_money_new'=>$roomModel['room_money'],'room_status'=>$roomModel['status'],'record_status'=>$roomModel['record_status'],'owner_phone'=>$ownerData[0]['mobile'],'owner_phone_new'=>$ownerData[0]['mobile'],'url'=>$roomModel['info_resource_url']);
  }
  //更新房源房间相关数据
  public function updateHouseinfo($data){
    if(!is_array($data)){
      return false;
    }
    if(empty($data['room_id'])){
      return false;
    }

    $roomDal=new \Home\Model\houseroom();
    $now_time=time();
    $handle_man=isset($data['update_man'])?$data['update_man']:'system';
    $log_bak='';$updateUrl=false;
    //修改租金
    if($data['room_money']!=$data['room_money_new'] && $data['room_money_new']>0){
      $update_array=array('id'=>$data['room_id'],'room_money'=>$data['room_money_new'],'low_price'=>$data['room_money_new'],'update_time'=>$now_time,'update_man'=>$handle_man);
      if(!$updateUrl && $data['url']!=''){
        $update_array['info_resource_url']=$data['url'];
        $updateUrl=true;
      }
      $roomDal->updateModel($update_array);
      $log_bak='更新租金';
      $modelDal=new \Home\Model\houseselect();
      $modelDal->updateModelByWhere(array('room_money'=>$data['room_money_new'],'low_price'=>$data['room_money_new']),"room_id='".$data['room_id']."'");//更新检索表
    }
    //修改房东联系电话
    if($data['owner_phone']!=$data['owner_phone_new'] && $data['owner_phone_new']!=''){
      $roomModel=$roomDal->getModelById($data['room_id']);
      if($roomModel==null || $roomModel==false){
        return false;
      }
      $customerDal=new \Home\Model\customer();
      $ownerModel=$customerDal->getResourceClientByPhone($data['owner_phone_new']);
      if($ownerModel==null || $ownerModel==false){
        //新注册房东类型用户
        $owner_id=guid();
        $owner_mobile=$data['owner_phone_new'];
        $owner_name='';
        $result=$customerDal->addModel(array('id'=>$owner_id,'mobile'=>$owner_mobile,'is_owner'=>3,'is_renter'=>0,'create_time'=>time(),'gaodu_platform'=>3));
        if(!$result){
          return false;
        }
      }else{
        $owner_id=$ownerModel['id'];
        $owner_mobile=$ownerModel['mobile'];
        $owner_name=$ownerModel['true_name'];
      }
      $update_array=array('id'=>$data['room_id'],'customer_id'=>$owner_id,'update_time'=>$now_time,'update_man'=>$handle_man);
      if(!$updateUrl && $data['url']!=''){
        $update_array['info_resource_url']=$data['url'];
        $updateUrl=true;
      }
      $roomDal->updateModel($update_array);
      if($log_bak==''){
        $log_bak='更新房东电话';
      }else{
        $log_bak='更新租金和房东电话';
      }
      
      $modelDal=new \Home\Model\houseresource();
      $modelDal->updateModel(array('id'=>$roomModel['resource_id'],'customer_id'=>$owner_id,'client_name'=>$owner_name,'client_phone'=>$owner_mobile));//更新房源表
    }
    //修改 URL
    if(!$updateUrl && $data['url']!=''){
      $roomDal->updateModel(array('id'=>$data['room_id'],'info_resource_url'=>$data['url']));
    }
    if($log_bak!='' && $log_bak!='更新房东电话'){
      //记录日志
      $modelDal=new \Home\Model\houseupdatelog();
      $modelDal->addModel(array('id'=>guid(),'house_id'=>$data['room_id'],'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>$log_bak));
    }
    return true;
  }

  /*中介房源下架 */
  public function agentHouseDown($rob_id,$handle_man){
    if($rob_id==''){
      return false;
    }
    $now_time=time();
    $handleOffer=new \Home\Model\houseoffer();
    $houseData=$handleOffer->getHouseofferData("room_id,is_my","rob_id='$rob_id' limit 3");//有报价，有房源
    if($houseData!=null && count($houseData)>0){
      $room1_id='';$room2_id='';
      foreach ($houseData as $key => $value) {
        $room1_id=$value['room_id'];
        if($value['is_my']==1){
          $room2_id=$value['room_id'];
        }
      }
      $room_id=$room2_id==''?$room1_id:$room2_id;
      $modelDal=new \Home\Model\houseroom();
      $houseData=$modelDal->getFieldsByWhere("status,record_status","id='$room_id' limit 1");
      if($houseData!=null && count($houseData)>0){
        $handleOffer->updateHouserobinfo(array('room_status'=>1,'update_man'=>$handle_man,'update_time'=>$now_time),"id='$rob_id'");
        $handleOffer->updateHouseoffer(array('status_code'=>4,'handle_time'=>time(),'handle_man'=>$handle_man),"rob_id='$rob_id'");
        if($houseData[0]['status']!=2 || $houseData[0]['record_status']!=1){
          //已经下架或删除
          return true;
        }else{
          return $this->downroomByidForCommon($room_id,$handle_man);
        }
      }else{
        return false;
      }
    }else{
      //没有发布到线上，更新抓取库
      $handleOffer->updateHouserobinfo(array('room_status'=>1,'update_man'=>$handle_man,'update_time'=>$now_time),"id='$rob_id'");
      $handleOffer->updateRoomimgSimilar(array('record_status'=>0,'update_man'=>$handle_man,'update_time'=>$now_time),"room1_id='$rob_id' or room2_id='$rob_id'");
      return true;
    }
  }
  /*中介房源信息更新，租金和电话 */
  public function agentHouseUpdate($rob_id,$room_money,$phone,$handle_man,$agency_name=''){
    if($rob_id==''){
      return '{"status":"401","message":"参数为空"}';
    }
    $now_time=time();
    $handleOffer=new \Home\Model\houseoffer();
    $rob_data=$handleOffer->getHouserobinfo("agency_phone,room_money,info_resource,city_code","id='$rob_id'");
    $update_money=false;$update_phone=false;
    if($rob_data==null || count($rob_data)==0){
      return '{"status":"401","message":"数据读取失败"}';
    }
    if($phone!='' && $phone!=$rob_data[0]['agency_phone']){
      //验证号码
      if(!preg_match('/^(\d+\,{0,1}\d*){8,20}$/', $phone)){
        return '{"status":"401","message":"电话格式错误"}';
      }
      $update_phone=true;
    }
    if($room_money!='' && $room_money>100 && $room_money!=$rob_data[0]['room_money']){
      $update_money=true;
    }
    if($update_money==false && $update_phone==false){
      return '{"status":"200","message":"无需更新"}';
    }
    //报价表数据
    $offerData=$handleOffer->getHouseofferData("room_id,customer_id,id,commission_type,commission_price,commission_money","rob_id='$rob_id' limit 2");
    if($offerData!=null && count($offerData)>0){
      $offerModel=$offerData[0];
      if(count($offerData)==2 && $offerModel['room_id']==$rob_id){
        $offerModel=$offerData[1];
      }
      $room_id=$offerModel['room_id'];
      $roomDal=new \Home\Model\houseroom();
      $houseData=$roomDal->getFieldsByWhere("status,record_status,customer_id,resource_id,is_regroup,low_price","id='$room_id' limit 1");
      if($houseData!=null && count($houseData)>0){
        if($houseData[0]['status']!=2 || $houseData[0]['record_status']!=1){
          //已经下架或删除
          return '{"status":"201","message":"已经下架或删除"}';
        }else{
          $selectDal=new \Home\Model\houseselect();
          
          if($update_money){
            //更新租金报价
            $commission_money=$offerModel['commission_money'];
            if($offerModel['commission_type']==0){
              $commission_money=intval($offerModel['commission_price'])/10000*$room_money;
            }
            $handleOffer->updateHouseoffer(array('commission_money'=>intval($commission_money),'room_price'=>$room_money,'handle_man'=>$handle_man,'handle_time'=>$now_time),"id='".$offerModel['id']."'");
            
            if($houseData[0]['is_regroup']==1){
              //聚合房源
              $low_price=0;
              //获取房间下面的所有报价
              $data=$handleOffer->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id',"room_id='$room_id' and record_status=1 and status_code=3 limit 20");
              foreach ($data as $key => $value) {
                 if($low_price==0 || intval($value['room_price'])<$low_price){
                    $low_price=intval($value['room_price']);
                 }
              }
              if($low_price>0 && $low_price!=$houseData[0]['low_price']){
                //更新房间、搜索表 数据
                $roomDal->updateModel(array('id'=>$room_id,'low_price'=>$low_price));
                $selectDal->updateModelByWhere(array('low_price'=>$low_price),"room_id='$room_id'");
              }
            }else{
              //非聚合房源
              $roomDal->updateModel(array('id'=>$room_id,'room_money'=>$room_money,'low_price'=>$room_money,'update_man'=>$handle_man,'update_time'=>$now_time));
              $selectDal->updateModelByWhere(array('room_money'=>$room_money,'low_price'=>$room_money),"room_id='$room_id'");
            }
             //记录日志
            $modelDal=new \Home\Model\houseupdatelog();
            $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'更新租金'));
    
          }
          
          if($update_phone){
            //更新电话
            $city_code=$rob_data[0]['city_code'];
            $handleCustomer=new \Home\Model\customer();
            $customerData=$handleCustomer->getListByWhere("mobile='$phone'"," limit 1");
            if($customerData!=null && count($customerData)>0){
              $customer_id=$customerData[0]['id'];
            }else{
              $company_id='';
              $companyData=$handleOffer->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$rob_data[0]['info_resource']."' and city_code='$city_code' and record_status=1 limit 1");
              if($companyData!=null && count($companyData)>0){
                $company_id=$companyData[0]['id'];
              }
              $customer_id=guid();
              $result=$handleCustomer->addModel(array('id'=>$customer_id,'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$phone,
                'true_name'=>$agency_name,'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'','agent_company_id'=>$company_id,'agent_company_name'=>$rob_data[0]['info_resource']));
              if(!$result){
                return '{"status":"401","message":"用户注册失败"}';
              }
            }
            if($houseData[0]['is_regroup']==1){
              //聚合房源
              $handleOffer->updateHouseoffer(array('customer_id'=>$customer_id,'handle_man'=>$handle_man,'handle_time'=>$now_time),"id='".$offerModel['id']."'");
            }else{
              //非聚合房源
              $handleOffer->updateHouseoffer(array('customer_id'=>$customer_id,'handle_man'=>$handle_man,'handle_time'=>$now_time),"id='".$offerModel['id']."'");
              $roomDal->updateModel(array('id'=>$room_id,'customer_id'=>$customer_id,'update_man'=>$handle_man,'update_time'=>$now_time));
              $roomDal=new \Home\Model\houseresource();
              $roomDal->updateModel(array('id'=>$houseData[0]['resource_id'],'customer_id'=>$customer_id,'client_phone'=>$phone,'update_man'=>$handle_man,'update_time'=>$now_time));
              $selectDal->updateModelByWhere(array('customer_id'=>$customer_id),"room_id='$room_id'");
            }
             //记录日志
            $modelDal=new \Home\Model\houseupdatelog();
            $modelDal->addModel(array('id'=>guid(),'house_id'=>$room_id,'house_type'=>2,'update_time'=>$now_time,'update_man'=>$handle_man,'operate_type'=>'更新房东电话'));
          }
        }
      }else{
        return '{"status":"401","message":"房间读取失败"}';
      }
    }
      //更新抓取库
      $updateRobArr['update_man']=$handle_man;
      $updateRobArr['update_time']=$now_time;
      $updateBasicArr['update_man']=$handle_man;
      $updateBasicArr['update_time']=$now_time;
      if($update_money){
        $updateRobArr['room_money']=$room_money;
        $updateBasicArr['room_money']=$room_money;
      }
      if($update_phone){
        $updateRobArr['agency_phone']=$phone;
        $updateBasicArr['client_phone']=$phone;
      }
      $handleOffer->updateHouserobinfo($updateRobArr,"id='$rob_id'");
      $handleOffer->updateCalculateBasic($updateBasicArr,"room_id='$rob_id'");
      return '{"status":"200","message":"更新成功"}';
    
  }
}
?>
<?php
namespace Logic;
class HouseofferLogic{
 /*报价审核 start*/
	
   //待审核数量
   public function getHouseofferAuditCount($condition){
      $modelDal=new \Home\Model\houseoffer();
      $where=" record_status=1 and city_code='".C('CITY_CODE')."' ";
      if(isset($condition['status_code']) && $condition['status_code']!='' && $condition['status_code']!='all'){
        $where.=" and status_code=".$condition['status_code'];
        if($condition['status_code']=='0'){
          $where.=" and is_my=0";
        }
      }
      if(isset($condition['mobile']) && $condition['mobile']!=''){
         $customerDal=new \Home\Model\customer();
         $customerModel=$customerDal->getResourceClientByPhone($condition['mobile']);
         if($customerModel==null || $customerModel==false){
            $where.=" and 1=0 ";
         }else{
            $where.=" and customer_id='".$customerModel['id']."' ";
         }
      }
      $data= $modelDal->getHouseofferData('count(1) as cnt',$where);   
      if($data!=null && count($data)>0){
         return $data[0]['cnt'];
      }
      return 0;
   }
  //待审核列表
  public function getHouseofferAuditList($condition,$limit_start,$limit_end){
     $modelDal=new \Home\Model\houseoffer();
     $where=" record_status=1 and city_code='".C('CITY_CODE')."' ";
     if(isset($condition['status_code']) && $condition['status_code']!='' && $condition['status_code']!='all'){
       $where.=" and status_code=".$condition['status_code'];
       if($condition['status_code']=='0'){
          $where.=" and is_my=0";
        }
     }
     if(isset($condition['mobile']) && $condition['mobile']!=''){
        $customerDal=new \Home\Model\customer();
        $customerModel=$customerDal->getResourceClientByPhone($condition['mobile']);
        if($customerModel==null || $customerModel==false){
           $where.=" and 1=0 ";
        }else{
           $where.=" and customer_id='".$customerModel['id']."' ";
        }
     }
     $data= $modelDal->getHouseofferData('id,customer_id,house_id,room_id,commission_type,commission_price,create_time,room_price,status_code',$where." order by create_time desc limit $limit_start,$limit_end");   
     return $data;
  }
  //根据ID获取报价
  public function getHouseofferById($id){
     if(empty($id)){
        return null;
     }
     $modelDal=new \Home\Model\houseoffer();
     $data= $modelDal->getHouseofferData('*',"id='$id' limit 1");
     if($data!=null && count($data)>0){
        return $data[0];
     }
     return null;
  }
  //根据room_id获取报价
  public function getHouseofferByRoomid($room_id,$is_all=0){
     if(empty($room_id)){
        return null;
     }
     $modelDal=new \Home\Model\houseoffer();
     if($is_all==0){
        //有效报价
        $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id',"room_id='$room_id' and record_status=1 and status_code=3 limit 20");
     }else{
        $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,record_status,status_code',"room_id='$room_id' limit 20");
     }
     return $data;
  }
  //审核成功
  public function offerAuditSuccess($id,$handle_man,$room_id,$room_price,$offer_cuid=''){
     if(empty($id) || empty($handle_man)){
        return array('status'=>'400','message'=>'参数为空','customer_id'=>'','room_money'=>'');
     }
     if($room_id=='' || !is_numeric($room_price)){
         return array('status'=>'400','message'=>'参数为空','customer_id'=>'','room_money'=>'');
     }
     //房间信息
     $handleRoom = new \Home\Model\houseroom();
     $roomModel=$handleRoom->getModelById($room_id);
     if($roomModel==null || $roomModel==false){
        return array('status'=>'400','message'=>'房间数据读取失败','customer_id'=>'','room_money'=>'');
     }
     $offer_custfee=false;
     /*$offerList=null;
     if($roomModel['info_resource_type']!=3){
        $offerList=$this->getHouseofferByRoomid($room_id);#获取房源下所有有效报价
     }*/
     $customer_id=$roomModel['customer_id'];
     $modelDal=new \Home\Model\houseoffer();
     //更新报价状态
     $result= $modelDal->updateHouseoffer(array('status_code'=>3,'handle_man'=>$handle_man,'handle_time'=>time()),"id='$id'");
     if($result){
      /*$agent_company='';
        if($offer_cuid!='' && $roomModel['info_resource_type']!=3){
          #查询是否付费客户 
          $handleCustomer=new \Home\Model\customer();
          $offer_custmodel=$handleCustomer->getModelById($offer_cuid);
          if($offer_custmodel!=null&&$offer_custmodel!=false){
            if($offer_custmodel['is_commission']==1 || ($offer_custmodel['is_monthly']==1&&$offer_custmodel['monthly_end']>time())){
              $offer_custfee=true;
              $agent_company=$offer_custmodel['agent_company_id'];
            }
          }
        }*/
        $low_price=intval($roomModel['low_price']);
        if(intval($room_price) < $low_price){
          $low_price=$room_price;
        } 
        /*if($offer_custfee){
          if($offerList!=null&&count($offerList)>0){
            foreach ($offerList as $key => $value) {
               $custmodel=$handleCustomer->getModelById($value['customer_id']);
               if($custmodel!=null&&$custmodel!=false){
                 if($custmodel['is_commission']==1 || ($custmodel['is_monthly']==1&&$custmodel['monthly_end']>time())){
                 }elseif($custmodel['agent_company_id']==$agent_company){
                   #删除非付费客户
                   $modelDal->updateHouseoffer(array('record_status'=>0,'handle_man'=>$handle_man,'handle_time'=>time()),"id='".$value['id']."'");
                 }
               }
            }
            //从新计算最低价
            $low_price=$room_price;
            $data=$this->getHouseofferByRoomid($room_id);
            foreach ($data as $key => $value) {
               if(intval($value['room_price'])<$low_price){
                  $low_price=intval($value['room_price']);
               }
            }
          }
        }    */    
        //更新房间、搜索表 数据
        #删除非个人发布房源及报价
        if($roomModel['is_agent_fee']==1 || $offer_custfee==true){
          $modelDal->updateHouseoffer(array('is_my'=>0),"room_id='$room_id'");
           //todo;中介聚合，虚拟帐号
           $handleRoom->updateModel(array('id'=>$room_id,'is_regroup'=>1,'store_id'=>'','is_agent_fee'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price));
           //清除缓存
           $roomLogic=new \Logic\HouseRoomLogic();
           $roomLogic->updateHouseroomCache($roomModel,10);

           $handleRoom = new \Home\Model\houseresource();
           $handleRoom->updateModel(array('id'=>$roomModel['resource_id'],'store_id'=>'','client_name'=>'','client_phone'=>'','customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A'));
           if($roomModel['status']==2 && $roomModel['record_status']==1){
              $handleRoom = new \Home\Model\houseselect();
              $handleRoom->updateModelByWhere(array('is_regroup'=>1,'store_id'=>'','is_agent_fee'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price),"room_id='$room_id'");
           }
        }else{
          //个人房源，查询是否已经有了报价信息
          $data= $modelDal->getHouseofferData('id,commission_type,commission_price',"room_id='$room_id' and customer_id='$customer_id' and record_status=1 limit 1");
          if($data==null || count($data)==0){
            $this->addHouseoffer($customer_id,$room_id,$roomModel['resource_id'],$roomModel['room_money'],0,$handle_man,1,'','');
          }
          $handleRoom->updateModel(array('id'=>$room_id,'is_regroup'=>1,'low_price'=>$low_price));
          if($roomModel['status']==2 && $roomModel['record_status']==1){
             $handleRoom = new \Home\Model\houseselect();
             $handleRoom->updateModelByWhere(array('is_regroup'=>1,'low_price'=>$low_price),"room_id='$room_id'");
          }
        }
        return array('status'=>'200','message'=>'审核成功','customer_id'=>$customer_id,'room_money'=>$roomModel['room_money']);
     }
     return array('status'=>'400','message'=>'更新状态失败','customer_id'=>'','room_money'=>''); 
  }
   //审核失败
  public function offerAuditFail($id,$handle_man,$reason){
     if(empty($id) || empty($handle_man)){
        return array('status'=>'400','message'=>'参数为空','customer_id'=>'','room_money'=>'');
     }
     if($reason==''){
        return array('status'=>'400','message'=>'理由为空','customer_id'=>'','room_money'=>'');
     }
     $modelDal=new \Home\Model\houseoffer();
     $result = $modelDal->updateHouseoffer(array('status_code'=>1,'handle_result'=>$reason,'handle_man'=>$handle_man,'handle_time'=>time()),"id='$id'");
     if($result){
        return array('status'=>'200','message'=>'审核成功','customer_id'=>'','room_money'=>'');
     }
     return array('status'=>'400','message'=>'操作失败','customer_id'=>'','room_money'=>'');
  }
  //新增报价
  public function addHouseoffer($customer_id,$room_id,$resource_id,$room_price,$agent_fee,$handle_man,$is_my=1,$city_code='',$rob_id=''){
    $addModel['id']=guid();
    $addModel['customer_id']=$customer_id;
    $addModel['room_id']=$room_id;
    $addModel['house_id']=$resource_id;
    $addModel['commission_type']=0;
    $addModel['commission_price']=$agent_fee*100;
    $addModel['commission_money']=intval($room_price*$agent_fee/100);
    $addModel['create_time']=time();
    $addModel['handle_time']=$addModel['create_time'];
    $addModel['handle_man']=$handle_man;
    $addModel['record_status']=1;
    $addModel['status_code']=3;
    $addModel['is_my']=$is_my;
    $addModel['room_price']=$room_price;
    $addModel['city_code']=$city_code==''?C('CITY_CODE'):$city_code;
    $addModel['rob_id']=$rob_id;
    $modelDal=new \Home\Model\houseoffer();
    return $modelDal->addHouseoffer($addModel);
  }
  //更新报价
  public function updateHouseoffer($id,$room_price,$agent_fee,$handle_man){
    $modifyData['commission_type']=0;
    $modifyData['commission_price']=$agent_fee*100;
    $modifyData['commission_money']=intval($room_price*$agent_fee/100);
    $modifyData['handle_time']=time();
    $modifyData['handle_man']=$handle_man;
    $modifyData['room_price']=$room_price;
    $modelDal=new \Home\Model\houseoffer();
    return $modelDal->updateHouseoffer($modifyData,"id='$id'");
  }
  //删除报价
  public function deleteHouseoffer($id,$handle_man){
    $modifyData['handle_time']=time();
    $modifyData['handle_man']=$handle_man;
    $modifyData['record_status']=0;
    $modelDal=new \Home\Model\houseoffer();
    return $modelDal->updateHouseoffer($modifyData,"id='$id'");
  }
 /*报价审核 end*/
 
 /*中介公司 start*/
   public function getAgentCompanyList(){
       $modelDal=new \Home\Model\houseoffer();
       $city_prex=C('CITY_PREX');
       $data=get_cache_admin('',$city_prex."agent_companys");
       if(empty($data)){
          $data = $modelDal->getAgentcompany("id,company_name"," record_status=1 and company_type=1 and pid='' and city_code='".C('CITY_CODE')."'");
          set_cache_admin('',$city_prex."agent_companys",$data,3600);
       }
       return $data;
   }

 /*中介公司 end*/

 /*聚合确认 start */
  //确认列表
  public function getAggregatAuditCount($condition){
     $modelDal=new \Home\Model\houseoffer();
     $where=" if_repetition_confim=0 and record_status=1 and city_code='".C('CITY_CODE')."' ";
     if(isset($condition['startTime']) && !empty($condition['startTime'])){
        $where.=" and create_time>=".strtotime(trim($condition['startTime']));
     }
     if(isset($condition['endTime']) && !empty($condition['endTime'])){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $where.=" and create_time<=".$endTime;
     }
     $data= $modelDal->getRoomimgSimilar('count(distinct room1_id,room2_id) as cnt',$where);   
     if($data!=null && count($data)>0){
        return $data[0]['cnt'];
     }
     return 0;
  }
 public function getAggregatAuditList($limit_start,$limit_end,$condition){
    $modelDal=new \Home\Model\houseoffer();
    $where=" if_repetition_confim=0 and record_status=1 and city_code='".C('CITY_CODE')."' ";
    if(isset($condition['startTime']) && !empty($condition['startTime'])){
       $where.=" and create_time>=".strtotime(trim($condition['startTime']));
    }
    if(isset($condition['endTime']) && !empty($condition['endTime'])){
       $endTime=strtotime(trim($condition['endTime']));
       $endTime=$endTime+60*60*24;
       $where.=" and create_time<=".$endTime;
    }
    $data= $modelDal->getRoomimgSimilar('room1_id,room2_id,estate_name1,house_type1,room_num1,hall_num1,id,create_time',$where." group by room1_id,room2_id order by create_time desc limit $limit_start,$limit_end");   
    return $data;
 }
  public function getAggregatAuditByid($id){
    if(empty($id)){
      return null;
    }
    $modelDal=new \Home\Model\houseoffer();
    $data= $modelDal->getRoomimgSimilar('id,room1_id,room2_id,estate_name1,house_type1,room_num1,hall_num1,if_repetition_confim,record_status,city_code,create_time,repetition_id,mid_img_id'," id=$id limit 1");   
    if($data!=null && count($data)>0){
      return $data[0];
    }
    return null;
  }
 //基本信息
 public function getCalculateBasicByRoomid($room_id){
    if(empty($room_id)){
      return null;
    }
    $modelDal=new \Home\Model\houseoffer();
    $data= $modelDal->getCalculateBasic("estate_name,area,room_money,room_num,hall_num,wei_num,info_resource,info_resource_url,client_name,client_phone,room_id,online_status","room_id='$room_id' limit 1");
    if($data!=null && count($data)>0){
      return $data[0];
    }
    return null;
 }
 //图片
 public function getAggregationImgByRoomid($room_id){
    if(empty($room_id)){
      return null;
    }
    $modelDal=new \Home\Model\houseoffer();
    $data= $modelDal->getAggregationImage("img_path,img_name,img_ext","room_id='$room_id' limit 20");
    return $data;
 }
 //更新聚合抓取房源电话
 public function updateAggregatMobile($room_id,$mobile){
    if($room_id=='' || $mobile==''){
       return false;
    }
    $modelDal=new \Home\Model\houseoffer();
    $modelDal->updateCalculateBasic(array('client_phone'=>$mobile),"room_id='$room_id'");
    $modelDal->updateHouserobinfo(array('agency_phone'=>$mobile),"id='$room_id'");
    return true;
 }
 //新增房源、聚合数据
 public function addHouseAndOfferdata($main_roomid,$room1_id,$room2_id,$img_array,$main_img,$handle_man){
    $response_arr['status']='400';
    $response_arr['message']='操作失败';
    if($main_roomid=='' || $room1_id==''){
      $response_arr['message']='房间参数异常';
      return $response_arr;
    }elseif(count($img_array)==0 || $main_img==''){
      $response_arr['message']='图片数据异常';
      return $response_arr;
    }
    $two_roomid=$room1_id;
    if($main_roomid==$room1_id){
      $two_roomid=$room2_id;
    }
    //基础数据
    $modelDal=new \Home\Model\houseoffer();
    $basicList= $modelDal->getHouserobinfo("*","id='$main_roomid' limit 1");
    if($basicList==null || count($basicList)==0){
      $response_arr['message']='聚合数据读取失败';
      return $response_arr;
    }
    $basicList2= $modelDal->getHouserobinfo("*","id='$two_roomid' limit 1");
    if($basicList2==null || count($basicList2)==0){
      $response_arr['message']='聚合数据读取失败2';
      return $response_arr;
    }
    $basicData=$basicList[0];
    $city_code=$basicData['city_code'];
    if(empty($city_code)){
      $city_code=C('CITY_CODE');
    }
    //验证号码
    if(!preg_match('/^(\d+\,{0,1}\d*){11,20}$/', $basicData['agency_phone'])){
      $response_arr['message']='联系号码格式错误';
      return $response_arr;
    }elseif(!preg_match('/^(\d+\,{0,1}\d*){11,20}$/',$basicList2[0]['agency_phone'])){
      $response_arr['message']='联系号码格式错误';
      return $response_arr;
    }
    //上传图片
    $roomData['main_img_id']='';
    $roomData['main_img_path']='';
    foreach ($img_array as $k=>$img_url) {
      ob_clean();
      ob_start();
      readfile('http://120.26.204.164/imgrob/'.$img_url);
      $img_room_data = ob_get_contents();
      ob_end_clean();
      $imgSort=1;
      if($img_url==$main_img){
         //封面图片
        $imgSort=0;
      }
      $img_url_arr=explode('/', $img_url);
      $result = $this->uploadImageToServer($main_roomid,$img_url_arr[count($img_url_arr)-1],base64_encode($img_room_data),strlen($img_room_data),$imgSort,$city_code);
      $upload_success =json_decode($result,true);
      if($upload_success['status']=="200"){
        if($imgSort==0){
          $roomData['main_img_id']=$upload_success['data']['imgId'];
          $roomData['main_img_path']=$upload_success['data']['imgUrl'];
        }
      }
    }
    if($roomData['main_img_id']==''){
      $response_arr['message']='图片上传失败';
      return $response_arr;
    }
    //中介公司收佣比例
    $agent_fee1=0;$agent_fee2=0;
    $company_id1='';$company_id2='';
    $companyData=$modelDal->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$basicData['info_resource']."' and city_code='$city_code' and record_status=1 and company_type=1 and pid='' limit 1");
    if($companyData!=null && count($companyData)>0){
      $agent_fee1=$companyData[0]['commission_fee'];
      $company_id1=$companyData[0]['id'];
    }
    $companyData=$modelDal->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$basicList2[0]['info_resource']."' and city_code='$city_code' and record_status=1 and company_type=1 and pid='' limit 1");
    if($companyData!=null && count($companyData)>0){
      $agent_fee2=$companyData[0]['commission_fee'];
      $company_id2=$companyData[0]['id'];
    }
    //中介信息
    $handleCustomer=new \Home\Model\customer();
    $customerData=$handleCustomer->getListByWhere("mobile='".$basicData['agency_phone']."'"," limit 1");
    if($customerData!=null && count($customerData)>0){
      //判断是否职业房东
      if($customerData[0]['is_owner']==4){
        $response_arr['message']='职业房东房源不能参与聚合';
        return $response_arr;
      }
      $resourceData['customer_id']=$customerData[0]['id'];
      $resourceData['client_name']=$customerData[0]['true_name'];
      $resourceData['client_phone']=$customerData[0]['mobile'];
      if($customerData[0]['agent_company_id']==''){
        $handleCustomer->updateModel(array('id'=>$resourceData['customer_id'],'agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
      }
    }else{
      $resourceData['customer_id']=guid();
      $resourceData['client_name']=$basicData['agency_name'];
      $resourceData['client_phone']=$basicData['agency_phone'];
      $result=$handleCustomer->addModel(array('id'=>$resourceData['customer_id'],'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$resourceData['client_phone'],
        'true_name'=>$resourceData['client_name'],'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'聚合产生','agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
      if(!$result){
        $response_arr['message']='用户注册失败';
        return $response_arr;
      }
    }
    $customerData=$handleCustomer->getListByWhere("mobile='".$basicList2[0]['agency_phone']."'"," limit 1");
    if($customerData!=null && count($customerData)>0){
      //判断是否职业房东
      if($customerData[0]['is_owner']==4){
        $response_arr['message']='职业房东房源不能参与聚合';
        return $response_arr;
      }
      $customer_id2=$customerData[0]['id'];
      if($customerData[0]['agent_company_id']==''){
        $handleCustomer->updateModel(array('id'=>$customer_id2,'agent_company_id'=>$company_id2,'agent_company_name'=>$basicList2[0]['info_resource']));
      }
    }else{
      $customer_id2=guid();
      $result=$handleCustomer->addModel(array('id'=>$customer_id2,'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$basicList2[0]['agency_phone'],
        'true_name'=>$basicList2[0]['agency_name'],'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'聚合产生','agent_company_id'=>$company_id2,'agent_company_name'=>$basicList2[0]['info_resource']));
      if(!$result){
        $response_arr['message']='用户注册失败';
        return $response_arr;
      }
    }
    $resourceData['id']=guid();
    $resourceData['region_id']=$basicData['region_id'];
    $resourceData['region_name']=$basicData['region_name'];
    $resourceData['scope_id']=$basicData['scope_id'];
    $resourceData['scope_name']=$basicData['scope_name'];
    $resourceData['estate_id']=$basicData['estate_id'];
    $resourceData['estate_name']=$basicData['estate_name'];
    $resourceData['business_type']='1501';
    //$resourceData['house_type']=$basicData['house_type'];
    //$resourceData['public_equipment']='';
    $resourceData['floor_total']=$basicData['floor_total'];
    $resourceData['floor']=$basicData['floor'];
    $resourceData['room_num']=$basicData['room_num'];
    $resourceData['room_count']=$resourceData['room_num'];
    $resourceData['hall_num']=$basicData['hall_num'];
    $resourceData['wei_num']=$basicData['wei_num'];
    $resourceData['house_direction']=$this->convertDirectionV($basicData['house_direction_name']);
    $resourceData['decoration']=$this->convertDecorationV($basicData['decoration_name']);
    $resourceData['pay_method']=$this->convertPaymethodV($basicData['pay_method_name']);
    $resourceData['info_resource']=$basicData['info_resource'];
    $resourceData['info_resource_url']=$basicData['info_resource_url'];
    $resourceData['info_resource_type']=1;
    $resourceData['room_type']='0205';
    $resourceData['rent_type']=2;
    $resourceData['is_owner']=5;
    $resourceData['rental_type']=2;
    $resourceData['area']=$basicData['house_area'];
    $resourceData['create_time']=time();
    $resourceData['update_time']=$resourceData['create_time'];
    $resourceData['create_man']=$handle_man;
    $resourceData['update_man']=$handle_man;
    $resourceData['city_code']=$city_code;
     $handleResource=new \Logic\HouseResourceLogic();
    $resourceData['house_no']=$handleResource->createHouseno($city_code);
    $main_cuid=$resourceData['customer_id'];
    $resourceData['client_name']='';
    $resourceData['client_phone']='';
    $resourceData['customer_id']='08F796E4-84B9-0ECF-EA8B-C107427FBF4A';//todo;中介聚合，虚拟帐号
    //新增房源数据
    $result=$handleResource->addModel($resourceData);
    if(!$result){
      $response_arr['message']='新增房源数据失败';
      return $response_arr;
    }
    
    $roomData['id']=$main_roomid;
    $roomData['resource_id']=$resourceData['id'];
    $roomData['room_name']='整套';
    $roomData['room_area']=$basicData['house_area'];
    $roomData['room_money']=$basicData['room_money'];
    $roomData['room_direction']=$resourceData['house_direction'];
    $roomData['create_time']=$resourceData['create_time'];
    $roomData['update_time']=$resourceData['update_time'];
    $roomData['create_man']=$handle_man;
    $roomData['update_man']=$handle_man;
    $roomData['status']=2;
    $roomData['total_count']=1;
    $roomData['up_count']=1;
    $roomData['info_resource']=$resourceData['info_resource'];
    $roomData['info_resource_url']=$resourceData['info_resource_url'];
    $roomData['info_resource_type']=$resourceData['info_resource_type'];
    $roomData['customer_id']=$resourceData['customer_id'];
    $roomData['show_reserve_bar']=0;
    $roomData['room_description']=$basicData['room_description'];
    //$roomData['room_equipment']='';
    $roomData['third_no']=$basicData['third_no'];
    $roomData['third_id']=$basicData['third_id'];
    $roomData['gaodu_platform']=4;
    $roomData['is_regroup']=1;
    $roomData['is_agent_fee']=$agent_fee1>0?1:0;
    $roomData['low_price']=$roomData['room_money'];
    if ($basicList2[0]['room_money']>0 && intval($roomData['low_price'])>intval($basicList2[0]['room_money'])) {
      $roomData['low_price']=$basicList2[0]['room_money'];
    }
    
     $handleRoom=new \Logic\HouseRoomLogic();
     $roomData['city_code']=$city_code;
    $roomData['room_no']=$handleRoom->createRoomno($city_code);
    //新增房间数据
    $result=$handleRoom->addModel($roomData);
    if(!$result){
      $response_arr['message']='新增房间数据失败';
      return $response_arr;
    }
    //报价 1 2
    $this->addHouseoffer($main_cuid,$roomData['id'],$roomData['resource_id'],$roomData['room_money'],$agent_fee1,$handle_man,1,$city_code,$basicData['id']);
    $this->addHouseoffer($customer_id2,$roomData['id'],$roomData['resource_id'],$basicList2[0]['room_money'],$agent_fee2,$handle_man,0,$city_code,$basicList2[0]['id']);

    //操作房间查询表
    $handleSelect=new \Logic\HouseSelectLogic();
    $handleSelect->addModel($roomData['id'],0);
    //更新聚合库
    $repetition_id=guid();
    $modelDal->updateRoomimgSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateRoomtxtSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateSimilarmidTab(array('similar_stauts'=>1,'repetition_id'=>$repetition_id,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
$modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$main_roomid'");
$modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$two_roomid'");
    $response_arr['status']='200';
    $response_arr['message']='操作成功';
    return $response_arr;

 }
 //新增聚合报价
 public function addAggregationOffer($roomModel,$offer_roomid,$room1_id,$room2_id,$handle_man,$repetition_id){
    $response_arr['status']='400';
    $response_arr['message']='操作失败';
    if($offer_roomid=='' || $room1_id==''){
      $response_arr['message']='数据异常';
      return $response_arr;
    }
   /* if($roomModel['status']!=2 || $roomModel['record_status']!=1){
       $response_arr['message']='在线聚合房源不可租';
      return $response_arr;
    }*/
    //基础数据
    $modelDal=new \Home\Model\houseoffer();
    $basicList= $modelDal->getHouserobinfo("*","id='$offer_roomid' limit 1");
    if($basicList==null || count($basicList)==0){
      $response_arr['message']='聚合数据读取失败';
      return $response_arr;
    }
    $basicData=$basicList[0];
    $city_code=$basicData['city_code'];
    if(empty($city_code)){
       $city_code=C('CITY_CODE');
    }
   
    //验证号码
    if(!preg_match('/^(\d+\,{0,1}\d*){11,20}$/', $basicData['agency_phone'])){
      $response_arr['message']='联系号码格式错误';
      return $response_arr;
    }elseif(intval($basicData['room_money'])<=0){
      $response_arr['message']='报价金额异常';
      return $response_arr;
    }
    //中介公司收佣比例
    $agent_fee1=0;
    $company_id1='';
    $companyData=$modelDal->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$basicData['info_resource']."' and city_code='$city_code' and record_status=1 and company_type=1 and pid='' limit 1");
    if($companyData!=null && count($companyData)>0){
      $agent_fee1=$companyData[0]['commission_fee'];
      $company_id1=$companyData[0]['id'];
    }
    //中介信息
    $customer_id='';
    $handleCustomer=new \Home\Model\customer();
    $customerData=$handleCustomer->getListByWhere("mobile='".$basicData['agency_phone']."'"," limit 1");
    if($customerData!=null && count($customerData)>0){
      //判断是否职业房东
      if($customerData[0]['is_owner']==4){
        $response_arr['message']='职业房东房源不能参与聚合';
        return $response_arr;
      }
      $customer_id=$customerData[0]['id'];
      if($customerData[0]['agent_company_id']==''){
        $handleCustomer->updateModel(array('id'=>$customer_id,'agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
      }
    }else{
      $customer_id=guid();
      $result=$handleCustomer->addModel(array('id'=>$customer_id,'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$basicData['agency_phone'],
        'true_name'=>$basicData['agency_name'],'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'聚合产生','agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
      if(!$result){
        $response_arr['message']='用户注册失败';
        return $response_arr;
      }
    }
    //新增报价
    $result=$this->addHouseoffer($customer_id,$roomModel['id'],$roomModel['resource_id'],$basicData['room_money'],$agent_fee1,$handle_man,0,$city_code,$offer_roomid);
    if(!$result){
      $response_arr['message']='新增报价失败';
      return $response_arr;
    }
    $low_price=intval($roomModel['low_price']);
    if($low_price>intval($basicData['room_money'])){
      $low_price=$basicData['room_money'];
    }
    //更新房间、搜索表 数据
    if($roomModel['is_agent_fee']==1){
       //todo;中介聚合，虚拟帐号
       $handleRoom = new \Home\Model\houseresource();
       $handleRoom->updateModel(array('id'=>$roomModel['resource_id'],'client_name'=>'','client_phone'=>'','customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A'));
       $handleRoom = new \Home\Model\houseroom();
       $handleRoom->updateModel(array('id'=>$roomModel['id'],'is_regroup'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price));
       if($roomModel['status']==2 && $roomModel['record_status']==1){
          $handleRoom = new \Home\Model\houseselect();
          $handleRoom->updateModelByWhere(array('is_regroup'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price),"room_id='".$roomModel['id']."'");
       }
    }else{
      //个人房东
      $data= $modelDal->getHouseofferData('id,commission_type,commission_price',"room_id='".$roomModel['id']."' and customer_id='".$roomModel['customer_id']."' and record_status=1 limit 1");
      if($data==null || count($data)==0){
        $this->addHouseoffer($roomModel['customer_id'],$roomModel['id'],$roomModel['resource_id'],$roomModel['room_money'],0,$handle_man,1,$city_code,'');
      }
      $handleRoom = new \Home\Model\houseroom();
      $handleRoom->updateModel(array('id'=>$roomModel['id'],'is_regroup'=>1,'low_price'=>$low_price));
      if($roomModel['status']==2 && $roomModel['record_status']==1){
         $handleRoom = new \Home\Model\houseselect();
         $handleRoom->updateModelByWhere(array('is_regroup'=>1,'low_price'=>$low_price),"room_id='".$roomModel['id']."'");
      }
    }
    //更新聚合库
    if(empty($repetition_id)){
      $repetition_id=guid();
    }
    $modelDal->updateRoomimgSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateRoomtxtSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateSimilarmidTab(array('similar_stauts'=>1,'repetition_id'=>$repetition_id,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room1_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room2_id'");
    $response_arr['status']='200';
    $response_arr['message']='操作成功';
    return $response_arr;

 }
 //都是线上已有房源，新增报价 删除房源
 public function aggregatOnlineHouse($roomModel,$offer_roomid,$room1_id,$room2_id,$handle_man,$repetition_id,$offer_model){
    $response_arr['status']='400';
    $response_arr['message']='操作失败';
    if($offer_roomid=='' || $room1_id==''){
      $response_arr['message']='数据异常';
      return $response_arr;
    }
    if($offer_model==null){
      $response_arr['message']='线上房源聚合操作失败';
      return $response_arr;
    }
    $modelDal=new \Home\Model\houseoffer();
    $room_money=intval($offer_model['room_price']);
    //主房源，已有报价数据
    $offer_cuids[]='';
    $offerdata = $modelDal->getHouseofferData('id,customer_id',"room_id='".$roomModel['id']."' limit 10");
    if($offerdata!=null){
      foreach ($offerdata as $key => $value) {
        $offer_cuids[]=$value['customer_id'];
      }
    }
    $result=false;
    if($offer_model['customer_id']=='moreOffer'){
      //转移报价
      $offerdata = $modelDal->getHouseofferData('*',"room_id='$offer_roomid' and record_status=1 limit 5");
      if($offerdata!=null){
        foreach ($offerdata as $key => $value) {
          $result=true;
          if(!in_array($value['customer_id'], $offer_cuids)){
            //排除重复报价
            $moveOffer['id']=guid();
            $moveOffer['customer_id']=$value['customer_id'];
            $moveOffer['room_id']=$roomModel['id'];
            $moveOffer['house_id']=$roomModel['resource_id'];
            $moveOffer['commission_type']=$value['commission_type'];
            $moveOffer['commission_price']=$value['commission_price'];
            $moveOffer['commission_money']=$value['commission_money'];
            $moveOffer['create_time']=time();
            $moveOffer['record_status']=$value['record_status'];
            $moveOffer['status_code']=$value['status_code'];
            $moveOffer['room_price']=$value['room_price'];
            $moveOffer['city_code']=$value['city_code'];
            $moveOffer['handle_time']=time();
            $moveOffer['handle_man']='sys';
            $moveOffer['is_my']=0;
            $moveOffer['handle_result']=$value['handle_result'];
            $moveOffer['owner_mobile']=$value['owner_mobile'];
            $moveOffer['rob_id']=$value['rob_id'];
            $modelDal->addHouseoffer($moveOffer);
          }
        }
      }
    }else{
      $agent_fee1=intval($offer_model['commission_price'])/100;
      $customer_id=$offer_model['customer_id'];
      $result=true;
      if(!in_array($customer_id, $offer_cuids)){
        //新增报价
        $result=$this->addHouseoffer($customer_id,$roomModel['id'],$roomModel['resource_id'],$room_money,$agent_fee1,$handle_man,0,$roomModel['city_code'],$offer_model['rob_id']);
      }
    }
    if(!$result){
      $response_arr['message']='新增报价失败';
      return $response_arr;
    }
    //删除房源
    $handleRoom=new \Home\Model\houseroom();
    $result=$handleRoom->updateModelByWhere(array('record_status'=>0,'update_man'=>$handle_man,'update_time'=>time(),'delete_type'=>6,'ext_examineinfo'=>'聚合删除'),"id='$offer_roomid'");
    if(!$result){
      $response_arr['message']='删除房源失败';
      return $response_arr;
    }
    //操作房间查询表
    $handleSelect=new \Home\Model\houseselect();
    $handleSelect->deleteModelByRoomid($offer_roomid);
    //记录日志
    $handleSelect=new \Home\Model\houseupdatelog();
    $handleSelect->addModel(array('id'=>guid(),'house_id'=>$offer_roomid,'house_type'=>2,'update_man'=>$handle_man,'update_time'=>time(),'city_code'=>$roomModel['city_code'],'operate_type'=>'聚合删除'));
    $low_price=intval($roomModel['low_price']);
    if($low_price>$room_money){
      $low_price=$room_money;
    }
    //更新房间、搜索表 数据
    if($roomModel['is_agent_fee']==1){
       //todo;中介聚合，虚拟帐号
       $handleRoom = new \Home\Model\houseresource();
       $handleRoom->updateModel(array('id'=>$roomModel['resource_id'],'client_name'=>'','client_phone'=>'','customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A'));
       $handleRoom = new \Home\Model\houseroom();
       $handleRoom->updateModel(array('id'=>$roomModel['id'],'is_regroup'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price));
       if($roomModel['status']==2 && $roomModel['record_status']==1){
          $handleRoom = new \Home\Model\houseselect();
          $handleRoom->updateModelByWhere(array('is_regroup'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price),"room_id='".$roomModel['id']."'");
       }
    }else{
      //个人房东
      $data= $modelDal->getHouseofferData('id,commission_type,commission_price',"room_id='".$roomModel['id']."' and customer_id='".$roomModel['customer_id']."' and record_status=1 limit 1");
      if($data==null || count($data)==0){
        $this->addHouseoffer($roomModel['customer_id'],$roomModel['id'],$roomModel['resource_id'],$roomModel['room_money'],0,$handle_man,1,$roomModel['city_code'],'');
      }
      $handleRoom = new \Home\Model\houseroom();
      $handleRoom->updateModel(array('id'=>$roomModel['id'],'is_regroup'=>1,'low_price'=>$low_price));
      if($roomModel['status']==2 && $roomModel['record_status']==1){
         $handleRoom = new \Home\Model\houseselect();
         $handleRoom->updateModelByWhere(array('is_regroup'=>1,'low_price'=>$low_price),"room_id='".$roomModel['id']."'");
      }
    }
    //更新聚合库
    if(empty($repetition_id)){
      $repetition_id=guid();
    }
    $modelDal->updateRoomimgSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateRoomtxtSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateSimilarmidTab(array('similar_stauts'=>1,'repetition_id'=>$repetition_id,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room1_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room2_id'");
    $response_arr['status']='200';
    $response_arr['message']='操作成功';
    return $response_arr;
 }
  /*合并报价、删除房源 */
 public function aggregatMergeOffer($room1_id,$room2_id,$handle_man,$repetition_id,$roomModel1=null,$roomModel2=null){
    $response_arr['status']='400';
    $response_arr['message']='操作失败';
    if($room2_id=='' || $room1_id==''){
      $response_arr['message']='数据异常';
      return $response_arr;
    }
    $merge_flag=false;$city_code='';
    $modelDal=new \Home\Model\houseoffer();
    $handleRoom=new \Home\Model\houseroom();
    if($roomModel1!=null && $roomModel2!=null){
      $merge_flag=true;//都是房源信息
      $city_code=$roomModel1['city_code'];
    }else{
      //都是报价信息
      $data1= $modelDal->getHouseofferData('id,commission_type,commission_price,room_id,house_id',"rob_id='$room1_id' and room_id<>'$room1_id' and status_code=3 and record_status=1 limit 1");
      if($data1!=null&&count($data1)>0){
        $data2= $modelDal->getHouseofferData('id,commission_type,commission_price,room_id,house_id',"rob_id='$room2_id' and room_id<>'$room2_id' and status_code=3 and record_status=1 limit 1");
        if($data2!=null&&count($data2)>0){
          if($data1[0]['room_id']!=$data2[0]['room_id']){
            $merge_flag=true;
          }
        }
      }
      if($merge_flag){
        $roomModel1=$handleRoom->getModelById($data1[0]['room_id']);
        if($roomModel1==null || $roomModel1==false){
          $response_arr['message']='房间数据读取失败';
          return $response_arr;
        }
        $city_code=$roomModel1['city_code'];
        $roomModel2=$handleRoom->getModelById($data2[0]['room_id']);
        if($roomModel2==null || $roomModel2==false){
          $response_arr['message']='房间数据读取失败';
          return $response_arr;
        }
      }
    }
    if($merge_flag){
      $low_price=$roomModel2['low_price'];
      $room_id=$roomModel2['id'];
      $resource_id=$roomModel2['resource_id'];
      $low_price_delete=$roomModel1['low_price'];
      $offer_roomid=$roomModel1['id'];//默认roomModel1作为被删除的那个
      if($roomModel1['is_agent_fee']==0){
        //是个人房东，为主房源
        $low_price=$roomModel1['low_price'];
        $room_id=$roomModel1['id'];
        $resource_id=$roomModel1['resource_id'];
        $low_price_delete=$roomModel2['low_price'];
        $offer_roomid=$roomModel2['id'];
      }
      //转移报价
      $offer_cuids[]='';
      $offerdata = $modelDal->getHouseofferData('id,customer_id',"room_id='$room_id' limit 10");
      if($offerdata!=null){
        foreach ($offerdata as $key => $value) {
          $offer_cuids[]=$value['customer_id'];
        }
      }
      $result=false;
      $offerdata = $modelDal->getHouseofferData('*',"room_id='$offer_roomid' and record_status=1 limit 5");
      if($offerdata!=null){
        foreach ($offerdata as $key => $value) {
          $result=true;
          if(!in_array($value['customer_id'], $offer_cuids)){
            //排除重复报价
            $moveOffer['id']=guid();
            $moveOffer['customer_id']=$value['customer_id'];
            $moveOffer['room_id']=$room_id;
            $moveOffer['house_id']=$resource_id;
            $moveOffer['commission_type']=$value['commission_type'];
            $moveOffer['commission_price']=$value['commission_price'];
            $moveOffer['commission_money']=$value['commission_money'];
            $moveOffer['create_time']=time();
            $moveOffer['record_status']=$value['record_status'];
            $moveOffer['status_code']=$value['status_code'];
            $moveOffer['room_price']=$value['room_price'];
            $moveOffer['city_code']=$value['city_code'];
            $moveOffer['handle_time']=time();
            $moveOffer['handle_man']='sys';
            $moveOffer['is_my']=0;
            $moveOffer['handle_result']=$value['handle_result'];
            $moveOffer['owner_mobile']=$value['owner_mobile'];
            $moveOffer['rob_id']=$value['rob_id'];
            $modelDal->addHouseoffer($moveOffer);
          }
        }
      }
      if(!$result){
        $response_arr['message']='新增报价失败';
        return $response_arr;
      }
      //删除房源
      $result=$handleRoom->updateModelByWhere(array('record_status'=>0,'update_man'=>$handle_man,'update_time'=>time(),'delete_type'=>6,'ext_examineinfo'=>'聚合删除'),"id='$offer_roomid'");
      if(!$result){
        $response_arr['message']='删除房源失败';
        return $response_arr;
      }
      //操作房间查询表
      $handleSelect=new \Home\Model\houseselect();
      $handleSelect->deleteModelByRoomid($offer_roomid);
      //记录日志
      $handleLog=new \Home\Model\houseupdatelog();
      $handleLog->addModel(array('id'=>guid(),'house_id'=>$offer_roomid,'house_type'=>2,'update_man'=>$handle_man,'update_time'=>time(),'city_code'=>$city_code,'operate_type'=>'聚合删除'));
      if(intval($low_price)>intval($low_price_delete)){
        //更新最低价
        $handleRoom->updateModelByWhere(array('low_price'=>$low_price_delete),"id='$room_id'");
        $handleSelect->updateModelByWhere(array('low_price'=>$low_price_delete),"room_id='$room_id'");
      }
    }
    //更新聚合库
    if(empty($repetition_id)){
      $repetition_id=guid();
    }
    $modelDal->updateRoomimgSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateRoomtxtSimilar(array('repetition_id'=>$repetition_id,'if_fabu_online'=>1,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateSimilarmidTab(array('similar_stauts'=>1,'repetition_id'=>$repetition_id,'if_repetition_confim'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room1_id'");
    $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>1,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$room2_id'");
    $response_arr['status']='200';
    $response_arr['message']='操作成功';
    return $response_arr;
 }

 //聚合抓取房源，独立发布
 public function independentOnline($main_roomid,$room1_id,$room2_id,$handle_man){

      if($main_roomid=='' || $room1_id==''){
        return '参数为空';
      }
      //线上房源判断
      $handleRoom=new \Logic\HouseRoomLogic();
      $roomModel=$handleRoom->getModelById($main_roomid);
      if($roomModel!=null && $roomModel!=false){
        return '线上房源已存在';
      }
        //基础数据
        $modelDal=new \Home\Model\houseoffer();
        $basicList= $modelDal->getHouserobinfo("*","id='$main_roomid' limit 1");
        if($basicList==null || count($basicList)==0){
          return '抓取数据读取失败';
        }
        $basicData=$basicList[0];
        $city_code=$basicData['city_code'];
        if(empty($city_code)){
          $city_code=C('CITY_CODE');
        }
        //验证号码
        if(!preg_match('/^(\d+\,{0,1}\d*){11,20}$/', $basicData['agency_phone'])){
          return '联系电话格式错误';
        }
        //上传图片
        $roomData['main_img_id']='';
        $roomData['main_img_path']='';
        $imgData= $modelDal->getAggregationImage("img_path,img_name,img_ext","room_id='$main_roomid' limit 9");
        if($imgData!=null){
          $imgSort=0;
          foreach ($imgData as $key => $value) {
            $img_url='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
            ob_clean();
            ob_start();
            readfile($img_url);
            $img_room_data = ob_get_contents();
            ob_end_clean();
            $img_url_arr=explode('/', $img_url);
            $result = $this->uploadImageToServer($main_roomid,$value['img_name'].'.'.$value['img_ext'],base64_encode($img_room_data),strlen($img_room_data),$imgSort,$city_code);
            $upload_success =json_decode($result,true);
            if($upload_success['status']=="200"){
              if($imgSort==0){
                $imgSort=1;
                $roomData['main_img_id']=$upload_success['data']['imgId'];
                $roomData['main_img_path']=$upload_success['data']['imgUrl'];
              }
            }
          }
        }
        if($roomData['main_img_id']==''){
          return '图片上传失败';
        }
        //中介公司收佣比例
        $agent_fee1=0;
        $company_id1='';
        $companyData=$modelDal->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$basicData['info_resource']."' and city_code='$city_code' and record_status=1 and company_type=1 and pid='' limit 1");
        if($companyData!=null && count($companyData)>0){
          $agent_fee1=$companyData[0]['commission_fee'];
          $company_id1=$companyData[0]['id'];
        }
        //中介信息
        $handleCustomer=new \Home\Model\customer();
        $customerData=$handleCustomer->getListByWhere("mobile='".$basicData['agency_phone']."'"," limit 1");
        if($customerData!=null && count($customerData)>0){
          $resourceData['customer_id']=$customerData[0]['id'];
          $resourceData['client_name']=$customerData[0]['true_name'];
          $resourceData['client_phone']=$customerData[0]['mobile'];
          if($customerData[0]['agent_company_id']==''){
            $handleCustomer->updateModel(array('id'=>$resourceData['customer_id'],'agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
          }
        }else{
          $resourceData['customer_id']=guid();
          $resourceData['client_name']=$basicData['agency_name'];
          $resourceData['client_phone']=$basicData['agency_phone'];
          $result=$handleCustomer->addModel(array('id'=>$resourceData['customer_id'],'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$resourceData['client_phone'],
            'true_name'=>$resourceData['client_name'],'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'聚合产生','agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
          if(!$result){
            return '用户注册失败';
          }
        }
        $resourceData['id']=guid();
        $resourceData['region_id']=$basicData['region_id'];
        $resourceData['region_name']=$basicData['region_name'];
        $resourceData['scope_id']=$basicData['scope_id'];
        $resourceData['scope_name']=$basicData['scope_name'];
        $resourceData['estate_id']=$basicData['estate_id'];
        $resourceData['estate_name']=$basicData['estate_name'];
        $resourceData['business_type']='1501';
        //$resourceData['house_type']=$basicData['house_type'];
        //$resourceData['public_equipment']='';
        $resourceData['floor_total']=$basicData['floor_total'];
        $resourceData['floor']=$basicData['floor'];
        $resourceData['room_num']=$basicData['room_num'];
        $resourceData['room_count']=$resourceData['room_num'];
        $resourceData['hall_num']=$basicData['hall_num'];
        $resourceData['wei_num']=$basicData['wei_num'];
        $resourceData['house_direction']=$this->convertDirectionV($basicData['house_direction_name']);
        $resourceData['decoration']=$this->convertDecorationV($basicData['decoration_name']);
        $resourceData['pay_method']=$this->convertPaymethodV($basicData['pay_method_name']);
        $resourceData['info_resource']=$basicData['info_resource'];
        $resourceData['info_resource_url']=$basicData['info_resource_url'];
        $resourceData['info_resource_type']=1;
        $resourceData['room_type']='0205';
        $resourceData['rent_type']=2;
        $resourceData['is_owner']=5;
        $resourceData['rental_type']=2;
        $resourceData['area']=$basicData['house_area'];
        $resourceData['create_time']=time();
        $resourceData['update_time']=$resourceData['create_time'];
        $resourceData['create_man']=$handle_man;
        $resourceData['update_man']=$handle_man;
        $resourceData['city_code']=$city_code;
         $handleResource=new \Logic\HouseResourceLogic();
        $resourceData['house_no']=$handleResource->createHouseno($city_code);
        //新增房源数据
        $result=$handleResource->addModel($resourceData);
        if(!$result){
          return '新增房源数据失败';
        }
        
        $roomData['id']=$main_roomid;
        $roomData['resource_id']=$resourceData['id'];
        $roomData['room_name']='整套';
        $roomData['room_area']=$basicData['house_area'];
        $roomData['room_money']=$basicData['room_money'];
        $roomData['room_direction']=$resourceData['house_direction'];
        $roomData['create_time']=$resourceData['create_time'];
        $roomData['update_time']=$resourceData['update_time'];
        $roomData['create_man']=$handle_man;
         $roomData['update_man']=$handle_man;
        $roomData['status']=2;
        $roomData['total_count']=1;
        $roomData['up_count']=1;
        $roomData['info_resource']=$resourceData['info_resource'];
        $roomData['info_resource_url']=$resourceData['info_resource_url'];
        $roomData['info_resource_type']=$resourceData['info_resource_type'];
        $roomData['customer_id']=$resourceData['customer_id'];
        $roomData['show_reserve_bar']=0;
        $roomData['room_description']=$basicData['room_description'];
        //$roomData['room_equipment']='';
        $roomData['third_no']=$basicData['third_no'];
        $roomData['third_id']=$basicData['third_id'];
        $roomData['gaodu_platform']=4;
        $roomData['is_regroup']=0;
        $roomData['is_agent_fee']=$agent_fee1>0?1:0;
        $roomData['low_price']=$roomData['room_money'];
        $roomData['city_code']=$city_code;
        $roomData['room_no']=$handleRoom->createRoomno($city_code);
        //新增房间数据
        $result=$handleRoom->addModel($roomData);
        if(!$result){
          return '新增房间数据失败';
        }
        //报价 1 
        $this->addHouseoffer($roomData['customer_id'],$roomData['id'],$roomData['resource_id'],$roomData['room_money'],$agent_fee1,$handle_man,1,$city_code,$main_roomid);
 
        //操作房间查询表
        $handleSelect=new \Logic\HouseSelectLogic();
        $handleSelect->addModel($roomData['id'],0);
        //更新聚合库
        $modelDal->updateRoomimgSimilar(array('if_fabu_online'=>1,'if_repetition_confim'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
        $modelDal->updateRoomtxtSimilar(array('if_fabu_online'=>1,'if_repetition_confim'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
        $modelDal->updateSimilarmidTab(array('similar_stauts'=>2,'if_repetition_confim'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
      $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$main_roomid'");
      return '200';

 }
 //给灵山调用
  public function independentOnline_ls($main_roomid,$handle_man){

      if($main_roomid==''){
        log_result("agentHouseUp-log.txt","ID为空");
        return false;
      }
       $modelDal=new \Home\Model\houseoffer();
      //线上房源判断
      $handleRoom=new \Logic\HouseRoomLogic();
      $roomModel=$handleRoom->getModelById($main_roomid);
      if($roomModel!=null && $roomModel!=false){
        $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$main_roomid'");
        log_result("agentHouseUp-log.txt","房源已经在线上");
        return false;
      }
        //基础数据
       
        $basicList= $modelDal->getHouserobinfo("*","id='$main_roomid' limit 1");
        if($basicList==null || count($basicList)==0){
          log_result("agentHouseUp-log.txt","基础数据读取失败");
          return false;
        }
        $basicData=$basicList[0];
        $city_code=$basicData['city_code'];
        //验证号码
        if(!preg_match('/^(\d+\,{0,1}\d*){11,20}$/', $basicData['agency_phone'])){
          log_result("agentHouseUp-log.txt","电话格式错误");
          return false;
        }
        //上传图片
        $roomData['main_img_id']='';
        $roomData['main_img_path']='';
        $imgData= $modelDal->getAggregationImage("img_path,img_name,img_ext","room_id='$main_roomid' limit 9");
        if($imgData!=null){
          $imgSort=0;
          foreach ($imgData as $key => $value) {
            $img_url='http://10.117.31.65/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
            ob_clean();
            ob_start();
            readfile($img_url);
            $img_room_data = ob_get_contents();
            ob_end_clean();
            $img_url_arr=explode('/', $img_url);
            $result = $this->uploadImageToServer($main_roomid,$value['img_name'].'.'.$value['img_ext'],base64_encode($img_room_data),strlen($img_room_data),$imgSort,$city_code);
            $upload_success =json_decode($result,true);
            if($upload_success['status']=="200"){
              if($imgSort==0){
                $imgSort=1;
                $roomData['main_img_id']=$upload_success['data']['imgId'];
                $roomData['main_img_path']=$upload_success['data']['imgUrl'];
              }
            }
          }
        }
        if($roomData['main_img_id']==''){
          log_result("agentHouseUp-log.txt","图片上传失败");
          return false;
        }
        //中介公司收佣比例
        $agent_fee1=0;
        $company_id1='';
        $companyData=$modelDal->getAgentcompany("id,company_name,commission_type,commission_fee","company_name='".$basicData['info_resource']."' and city_code='$city_code' and record_status=1 and company_type=1 and pid='' limit 1");
        if($companyData!=null && count($companyData)>0){
          $agent_fee1=$companyData[0]['commission_fee'];
          $company_id1=$companyData[0]['id'];
        }
        //中介信息
        $handleCustomer=new \Home\Model\customer();
        $customerData=$handleCustomer->getListByWhere("mobile='".$basicData['agency_phone']."'"," limit 1");
        if($customerData!=null && count($customerData)>0){
          $resourceData['customer_id']=$customerData[0]['id'];
          $resourceData['client_name']=$customerData[0]['true_name'];
          $resourceData['client_phone']=$customerData[0]['mobile'];
          if($customerData[0]['agent_company_id']==''){
            $handleCustomer->updateModel(array('id'=>$resourceData['customer_id'],'agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
          }
        }else{
          $resourceData['customer_id']=guid();
          $resourceData['client_name']=$basicData['agency_name'];
          $resourceData['client_phone']=$basicData['agency_phone'];
          $result=$handleCustomer->addModel(array('id'=>$resourceData['customer_id'],'is_owner'=>5,'is_renter'=>0,'create_time'=>time(),'mobile'=>$resourceData['client_phone'],
            'true_name'=>$resourceData['client_name'],'city_code'=>$city_code,'gaodu_platform'=>3,'channel'=>'聚合产生','agent_company_id'=>$company_id1,'agent_company_name'=>$basicData['info_resource']));
          if(!$result){
            log_result("agentHouseUp-log.txt","房东信息注册失败");
            return false;
          }
        }
        $resourceData['id']=guid();
        $resourceData['region_id']=$basicData['region_id'];
        $resourceData['region_name']=$basicData['region_name'];
        $resourceData['scope_id']=$basicData['scope_id'];
        $resourceData['scope_name']=$basicData['scope_name'];
        $resourceData['estate_id']=$basicData['estate_id'];
        $resourceData['estate_name']=$basicData['estate_name'];
        $resourceData['business_type']='1501';
        //$resourceData['house_type']=$basicData['house_type'];
        //$resourceData['public_equipment']='';
        $resourceData['floor_total']=$basicData['floor_total'];
        $resourceData['floor']=$basicData['floor'];
        $resourceData['room_num']=$basicData['room_num'];
        $resourceData['room_count']=$resourceData['room_num'];
        $resourceData['hall_num']=$basicData['hall_num'];
        $resourceData['wei_num']=$basicData['wei_num'];
        $resourceData['house_direction']=$this->convertDirectionV($basicData['house_direction_name']);
        $resourceData['decoration']=$this->convertDecorationV($basicData['decoration_name']);
        $resourceData['pay_method']=$this->convertPaymethodV($basicData['pay_method_name']);
        $resourceData['info_resource']=$basicData['info_resource'];
        $resourceData['info_resource_url']=$basicData['info_resource_url'];
        $resourceData['info_resource_type']=1;
        $resourceData['room_type']='0205';
        $resourceData['rent_type']=2;
        $resourceData['is_owner']=5;
        $resourceData['rental_type']=2;
        $resourceData['area']=$basicData['house_area'];
        $resourceData['create_time']=time();
        $resourceData['update_time']=$resourceData['create_time'];
        $resourceData['create_man']=$handle_man;
        $resourceData['update_man']=$handle_man;
        $resourceData['city_code']=$city_code;
         $handleResource=new \Logic\HouseResourceLogic();
        $resourceData['house_no']=$handleResource->createHouseno($city_code);
        //新增房源数据
        $result=$handleResource->addModel($resourceData);
        if(!$result){
          log_result("agentHouseUp-log.txt","房源信息新增失败");
          return false;
        }
        
        $roomData['id']=$main_roomid;
        $roomData['resource_id']=$resourceData['id'];
        $roomData['room_name']='整套';
        $roomData['room_area']=$basicData['house_area'];
        $roomData['room_money']=$basicData['room_money'];
        $roomData['room_direction']=$resourceData['house_direction'];
        $roomData['create_time']=$resourceData['create_time'];
        $roomData['update_time']=$resourceData['update_time'];
        $roomData['create_man']=$handle_man;
         $roomData['update_man']=$handle_man;
        $roomData['status']=2;
        $roomData['total_count']=1;
        $roomData['up_count']=1;
        $roomData['info_resource']=$resourceData['info_resource'];
        $roomData['info_resource_url']=$resourceData['info_resource_url'];
        $roomData['info_resource_type']=$resourceData['info_resource_type'];
        $roomData['customer_id']=$resourceData['customer_id'];
        $roomData['show_reserve_bar']=0;
        $roomData['room_description']=$basicData['room_description'];
        //$roomData['room_equipment']='';
        $roomData['third_no']=$basicData['third_no'];
        $roomData['third_id']=$basicData['third_id'];
        $roomData['gaodu_platform']=4;
        $roomData['is_regroup']=0;
        $roomData['is_agent_fee']=$agent_fee1>0?1:0;
        $roomData['low_price']=$roomData['room_money'];
         $roomData['city_code']=$city_code;
        $roomData['room_no']=$handleRoom->createRoomno($city_code);
        //新增房间数据
        $result=$handleRoom->addModel($roomData);
        if(!$result){
          log_result("agentHouseUp-log.txt","房间信息新增失败");
          return false;
        }
        //报价 1 
        $this->addHouseoffer($roomData['customer_id'],$roomData['id'],$roomData['resource_id'],$roomData['room_money'],$agent_fee1,$handle_man,1,$city_code,$main_roomid);
 
        //操作房间查询表
        $handleSelect=new \Logic\HouseSelectLogic();
        $handleSelect->addModel($roomData['id'],0);
      $modelDal->updateCalculateBasic(array('online_status'=>1,'room_similar_status'=>2,'update_time'=>time(),'update_man'=>$handle_man),"room_id='$main_roomid'");
     log_result("agentHouseUp-log.txt","上房成功");
      return true;

 }
 //上传图片到服务器
 public function uploadImageToServer($room_id,$fileName,$imgData,$fileSize,$imgSort=1,$city_code=''){
     // post提交
     $post_data = array ();
     $post_data ['relationId'] = $room_id;
     $post_data ['fileName'] = $fileName;
     $post_data ['data']=$imgData;
     $post_data ['fileSize'] = $fileSize;
     $post_data['sortIndex']=$imgSort;
     switch ($city_code) {
       case '':
         $url =C("IMG_SERVICE_URL").'house/web/upload';
         break;
       case '001009001':
         $url ='http://10.168.169.223/imageservice/house/web/upload';
         break;
        case '001001':
         $url ='http://10.168.169.223/imageservicebj/house/web/upload';
         break;
        case '001011001':
         $url ='http://10.168.169.223/imageservicehz/house/web/upload';
         break;
        case '001010001':
         $url ='http://10.168.169.223/imageservicenj/house/web/upload';
         break;
        case '001019002':
         $url ='http://10.168.169.223/imageservicesz/house/web/upload';
         break;
       default:
         break;
     }
     
     $o = "";
     foreach ( $post_data as $k => $v ) {
       $o .= "$k=" . urlencode ( $v ) . "&";
     }
     $post_data = substr ( $o, 0, - 1 );
     $ch = curl_init ();
     curl_setopt ( $ch, CURLOPT_POST, 1 );
     curl_setopt ( $ch, CURLOPT_HEADER, 0 );
     curl_setopt ( $ch, CURLOPT_URL, $url );
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
     curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
     curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
     $data = curl_exec ( $ch );
     curl_close($ch);
     return $data;
 }
 public function convertDecorationV($name){
    switch (trim($name)) {
      case '毛坯':
        return '0001';
      case '普通装修':
        return '0002';
      case '简单装修':
        return '0002';
      case '精装修':
        return '0003';
      case '豪华装修':
        return '0004';
      default:
        return '';
    }
 }
  public function convertPaymethodV($name){
    $name=trim($name);
    if(strpos($name,'押')===0){
      $name=mb_substr($name, 2,2,'utf-8').mb_substr($name, 0,2,'utf-8');
    }
    switch ($name) {
      case '付三押一':
        return '0101';
      case '付二押一':
        return '0102';
      case '付一押一':
        return '0103';
      case '付三押二':
        return '0104';
      case '付二押二':
        return '0105';
      case '付一押二':
        return '0106';
      case '付一押零':
        return '0109';
      case '半年付':
        return '0107';
      case '整年付':
        return '0108';
      default:
        return '';
    }
 }
  public function convertDirectionV($name){
    switch (trim($name)) {
      case '南北':
        return '1001';
      case '东西':
        return '1002';
      case '东北':
        return '1003';
      case '东南':
        return '1004';
      case '西北':
        return '1005';
      case '西南':
        return '1006';
      case '东':
        return '1007';
      case '西':
        return '1008';
      case '南':
        return '1009';
      case '北':
        return '1010';
      default:
        return '';
    }
  }

/*聚合确认 end */
//更改电话，发布上线
  public function pushHouseOnline ($data,$handleMan)
  {
      if(empty($data['id'])||empty($handleMan)) {
        echo '{"code":"401","message":"参数不完整！"}';return;
      }
      $modelDal=new \Home\Model\houseoffer();
      $where['id'] = $data['id'];
      $info['agency_phone'] = $data['agency_phone'];
      $result = $modelDal->modelModifyHouseAggregationInfo($where,$info);
      if($result) {
        $resultOne = $this->independentOnline_ls($data['id'],$handleMan);
        if ($resultOne === false) {
          echo '{"code":"201","message":"房源上线失败！"}';return; 
        } else {
          $whereOne['id'] = $data['id'];
          $infoOne['is_clear'] = 1;
          $resultTwo = $modelDal->modelModifyHouseAggregationInfo($whereOne,$infoOne);
          if($resultTwo) {
              echo '{"code":"200","message":"修改号码成功！"}';return;
          } else {
              echo '{"code":"201","message":"修改号码失败！"}';return;
          }
        }
      } else {
        echo '{"code":"201","message":"修改号码失败！"}';return;
      }
  }

  //聚合房源举报
   public function getAggregatreportCount($condition){
      $modelDal=new \Home\Model\houseoffer();
      $where=" record_status=1 and city_code='".C('CITY_CODE')."' ";
      if(isset($condition['startTime']) && !empty($condition['startTime'])){
        $where.=" and create_time>=".strtotime(trim($condition['startTime']));
      }
      if(isset($condition['endTime']) && !empty($condition['endTime'])){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $where.=" and create_time<=".$endTime;
      }
      if(isset($condition['handle_status']) && $condition['handle_status']!=''){
        $where.=" and handle_status=".$condition['handle_status'];
      }
      $data= $modelDal->getHousefeederrorData('count(1) as cnt',$where);   
      if($data!=null && count($data)>0){
         return $data[0]['cnt'];
      }
      return 0;
   }
   public function getAggregatreportList($condition,$limit_start,$limit_end){
      $modelDal=new \Home\Model\houseoffer();
      $where=" record_status=1 and city_code='".C('CITY_CODE')."' ";
      if(isset($condition['startTime']) && !empty($condition['startTime'])){
        $where.=" and create_time>=".strtotime(trim($condition['startTime']));
      }
      if(isset($condition['endTime']) && !empty($condition['endTime'])){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $where.=" and create_time<=".$endTime;
      }
      if(isset($condition['handle_status']) && $condition['handle_status']!=''){
        $where.=" and handle_status=".$condition['handle_status'];
      }
      $data= $modelDal->getHousefeederrorData('id,room_id,room_no,feedback_desc,create_time,handle_status,handle_result,handle_time,handle_man',$where." order by create_time desc limit $limit_start,$limit_end");   
      return $data;
   }

}
?>
<?php
namespace Logic;
class CustomerInfo{
    //统计总条数
	 public function modelCustomerinfoCount($where){
    	$modelDal=new \Home\Model\customerinfo();
      $conditionString=$this->getConditionString($where);
    	$list = $modelDal->modelCustomerinfoCount($conditionString);
      if($list!=null && count($list)>0){
         return $list[0]['cnt'];
      }
      return 0;
    }
    //获取分页数据（区分城市）
    public function modelCustomerinfoList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\customerinfo();
      $conditionString=$this->getConditionString($where);
      return $modelDal->modelCustomerinfoList($firstrow,$listrows,$conditionString);  
    }
    //所有用户，不区分城市
    public function getCustomerinfoListByWhere($where){
      $modelDal=new \Home\Model\customerinfo();
      $conditionString=$this->getConditionString($where);
      return $modelDal->getCustomerinfoListByWhere($conditionString);  
    }

    //查询条件
    private function getConditionString($condition){
       $conditionString="";
       //创建时间
       if(isset($condition['startTime']) && $condition['startTime']!=''){
          $conditionString.=" and b.create_time>=".strtotime($condition['startTime']);
       }
       if(isset($condition['endTime']) && $condition['endTime']!=''){
          $conditionString.=" and b.create_time<=".(strtotime($condition['endTime'])+3600*24);
       }
       //保证金
       if(isset($condition['marginMin']) && $condition['marginMin']!=""){
          if(is_numeric($condition['marginMin'])){
            $conditionString.=" and b.margin>=".$condition['marginMin'];
          }
       }
       if(isset($condition['marginMax']) && $condition['marginMax']!=""){
          if(is_numeric($condition['marginMax'])){
            $conditionString.=" and b.margin<=".$condition['marginMax'];
          }
       }
       if(isset($condition['update_man']) && $condition['update_man']!=''){
          $conditionString.=" and b.update_man='".$condition['update_man']."'";
       }
       //负责人
       if(isset($condition['principal_man']) && $condition['principal_man']!=''){
          $conditionString.=" and b.principal_man='".$condition['principal_man']."'";
       }
      if(isset($condition['principalFlag']) && $condition['principalFlag']=='all'){
          $conditionString.=" and b.principal_man<>''";
       }
       if(isset($condition['name']) && $condition['name']!=''){
          $conditionString.=" and a.true_name='".$condition['name']."'";
       }
       if(isset($condition['mobile']) && $condition['mobile']!=''){
          $conditionString.=" and a.mobile='".$condition['mobile']."'";
       }
       if(isset($condition['is_commission']) && $condition['is_commission']!=''){
          $conditionString.=" and a.is_commission=".$condition['is_commission'];
       }
       if(isset($condition['is_black']) && $condition['is_black']!=''){
          $conditionString.=" and a.is_black=".$condition['is_black'];
       }
       //负责区域
       if(isset($condition['region_id']) && $condition['region_id']!=''){
          $conditionString.=" and b.region_id=".$condition['region_id'];
       }
       if(isset($condition['source']) && $condition['source']!=''){
          if($condition['source']=='empty'){
            $conditionString.=" and b.source=''";
          }else{
            $conditionString.=" and b.source='".$condition['source']."'";
          }
       }
       if(isset($condition['signed']) && $condition['signed']!=''){
          $conditionString.=" and b.signed=".$condition['signed'];
       }
       if(isset($condition['status']) && $condition['status']!=''){
          $conditionString.=" and b.status=".$condition['status'];
       }
       //包月条件
       if(isset($condition['isMonth']) && $condition['isMonth']!=''){
          $conditionString.=" and a.is_monthly=".$condition['isMonth'];
       }
       //是否付费
       if(isset($condition['isFee']) && $condition['isFee']!=''){
          if($condition['isFee']==1){
            $conditionString.=" and (a.is_monthly=1 or a.is_commission=1)";
          }else if($condition['isFee']==0){
            $conditionString.=" and (a.is_monthly=0 and a.is_commission=0)";
          }
       }
       if(isset($condition['monthStart']) && $condition['monthStart']!=''){
          $conditionString.=" and a.monthly_start>=".strtotime($condition['monthStart']);
       }
       if(isset($condition['monthEnd']) && $condition['monthEnd']!=''){
          $conditionString.=" and a.monthly_start<=".(strtotime($condition['monthEnd'])+3600*24);
       }
       return $conditionString.' ';
    }
    public function modelCustomerCount($where){
        $modelDal=new \Home\Model\customerinfo();
        return $modelDal->modelCustomerCount($where);
    }
    public function modelCustomerList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\customerinfo();
        return $modelDal->modelCustomerList($firstrow,$listrows,$where);
    }

    public function modelFind($where){
        $modelDal=new \Home\Model\customerinfo();
        return $modelDal->modelFind($where);
    }
    public function modelUpdate($data){
        $modelDal=new \Home\Model\customerinfo();
        return $modelDal->modelUpdate($data);
    }
    public function mobileAdd($data){
        $modelDal=new \Home\Model\customerinfo();
        return $modelDal->mobileAdd($data);
    }
    
    //获取房东下面的可租房间数量
   public function getOnlineRoomcountByCustomerid($customer_id){
      if(empty($customer_id)){
        return false;
      }
      $customer_id=str_replace("'", "", trim($customer_id));
      $modelDal=new \Home\Model\customerinfo();
      return $modelDal->getRoomcountByCustomerid(" where status=2 and record_status=1 and customer_id='$customer_id'");
   }
   //新增疑似二房东
   public function addConfirmCustomerinfo($mobile,$update_man,$source){
      $customerDal = new \Home\Model\customer();
      $customerModel=$customerDal->getResourceClientByPhone($mobile);
      if($customerModel!=null && $customerModel['is_owner']==4){
        return false;
      }
      $data['id']=guid();
      $data['mobile']=$mobile;
      $data['source']=$source;
      $data['update_time']=time();
      $data['update_man']=$update_man;
      $data['create_time']=$data['update_time'];
      $data['create_man']=$data['update_man'];
      $data['city_code']=C('CITY_CODE');
      $data['record_status']=1;
      $data['status']=0;
      $dal = new \Home\Model\customerinfo();
      return $dal->addConfirmModel($data);
   }
   //获取房东负责人、保证金等信息
   public function getPrincipalByCustomerid($customer_id){
      if(empty($customer_id)){
        return false;
      }
      $dal = new \Home\Model\customerinfo();
      $data = $dal->modelFindByWhere("where customer_id='$customer_id'");
      if($data===null || $data===false || count($data)==0){
        return false;
      }
      return array('principal_man'=>$data[0]['principal_man'],'margin'=>$data[0]['margin']);
   }
   //更新房间表里面的房东负责人
   public function updateRoomPrincipal($customer_id,$principal_man){
      if(empty($customer_id) || empty($principal_man)){
        return false;
      }
      $modelDal=new \Home\Model\houseroom();
      return $modelDal->updateModelByWhere(array('principal_man'=>$principal_man),array('customer_id'=>$customer_id));
   }
   //房东免审核认证
   public function modelAttestationCount($where){
      $modelDal=new \Home\Model\customerinfo();
      return $modelDal->modelAttestationCount($where);
   }
    public function modelAttestationList($firstrow,$listrows,$where){
      $modelDal=new \Home\Model\customerinfo();
      return $modelDal->modelAttestationList($firstrow,$listrows,$where);
   }
    public function modelDelete($where){
      $modelDal=new \Home\Model\customerinfo();
      return $modelDal->modelDelete($where);
    }
    //删除customerinfocheck
    public function modelDeleteCustomerCheck($where){
      $modelDal=new \Home\Model\customerinfo();
      return $modelDal->modelDeleteCustomerCheck($where);
    }

    /*职业房东跟进提交数据 */
    public function jobownerfollowSubmit($data){
        $handleCustomerinfo= new \Home\Model\customerinfo();
        if($data['principal_man']!=""){
            $result=$handleCustomerinfo->modelPrincipalFind($data['principal_man']);
            if(!$result){
              return "该负责人不存在";
            }
        }
        $customerinfoData['status']=$data['status'];
        $customerinfoData['update_time']=$data['update_time'];
        $customerinfoData['update_man']=$data['update_man'];
        $customerinfoData['owner_remark']=$data['remark'];
        if($data['status']==2){
            //已签约
            $customerinfoData['signed']=1;
            $customerinfoData['sign_way']=$data['sign_way'];
            $customerinfoData['principal_man']=$data['principal_man'];
            $customerinfoData['margin']=$data['margin'];
        } else if($data['status'] == 3) {
            $customerinfoData['principal_man']=$data['principal_man'];
        } else if($data['status']==1){
            //非职业房东，更新用户信息
            $handleCustomer=new \Home\Model\customer();
            $update_result=$handleCustomer->updateModel(array('id'=>$data['customer_id'],'is_owner'=>3,'update_time'=>$data['update_time'],'update_man'=>$data['update_man']));
            if($update_result){
                //更新房源下的职业房东标识
                $resourceDal=new \Home\Model\houseresource();
                $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$data['customer_id'],'is_owner'=>3));
            }
            //删除职业房东数据
            $handleCustomerinfo->modelDelete(array('customer_id'=>$data['customer_id']));
            //新增跟进记录
            $handleCustomerinfo->addCustomerinfolog(array('customer_id'=>$data['customer_id'],'status'=>$data['status'],'create_time'=>$data['update_time'],'create_man'=>$data['update_man'],'remark'=>$data['remark']));
            return '操作成功'; 
        }
        //更新职业房东信息
        $result=$handleCustomerinfo->modelUpdateWhere(array('customer_id'=>$data['customer_id']),$customerinfoData);
        if($result){
          //更新房间表：房东负责人
          if($data['principal_man']!=""){
            $this->updateRoomPrincipal($data['customer_id'],$data['principal_man']);
          }
          //新增跟进记录
          $handleCustomerinfo->addCustomerinfolog(array('customer_id'=>$data['customer_id'],'status'=>$data['status'],'create_time'=>$data['update_time'],'create_man'=>$data['update_man'],'remark'=>$data['remark']));
          if($data['commissiontype']==1 || $data['commissiontype']==2){
              //新增房东佣金，获取手机号
             $handleCustomer=new \Home\Model\customer();
             $customerModel=$handleCustomer->getModelById($data['customer_id']);
             if($customerModel==null || $customerModel==false){
                return '房东佣金新增失败';
             }
              $model['client_phone']=$customerModel['mobile'];
              $model['contracttime_start']=-99;
              $model['contracttime_end']=99;
              $model['commission_type']=$data['commissiontype'];
              $model['commission_base']=1;
              if($model['commission_type']=="2"){
                  $model['commission_base']=0;
              }
              $model['commission_money']=$data['commissionmoney'];
              $model['is_online']=0;
              $model['settlement_method']=isset($data['settlement_method'])?$data['settlement_method']:1;
              $model['start_time']=date("Y-m-d H:m:s",$data['update_time']);
              $model['update_time']=$data['update_time'];
              $model['update_man']=$data['update_man'];
              $model['create_man']=$data['update_man'];
              $model['create_time']=$data['update_time'];
              $model['check_update']="on";
              $handleLogic=new \Logic\CommissionLogic();
              $handleLogic->addCommissionfd($model);
          }else if($data['commissiontype']==3){
              //包月
              $model['customer_id']=$data['customer_id'];
              $model['monthly_days']=$data['monthly_days'];
              $model['monthly_money']=$data['commissionmoney'];
              $model['monthly_start']=$data['monthly_start'];
              $model['monthly_bak']=$data['remark'];
              $model['monthly_start']=strtotime($model['monthly_start']);
              $model['monthly_end']=intval($model['monthly_start'])+3600*24*intval($model['monthly_days']);
              $model['update_time']=$data['update_time'];
              $model['update_man']=$data['update_man'];
              $model['create_man']=$model['update_man'];
              $model['create_time']=$model['update_time'];
              $model['is_open']=1;
              $model['city_code']=C('CITY_CODE');
              $handleLogic=new \Logic\CommissionLogic();
              $handleLogic->addCommissionmonthly($model);
          }
          return '操作成功'; 
        }
        return '操作失败';
    }

    /*新增职业房东 */
    public function addOwnerForCustomerinfo($data){
       $customer_id='';
       $resourceDal=new \Home\Model\houseresource();
       $handleCustomer=new \Home\Model\customer();
       if(!empty($data['customer_id'])){
          $customer_id=$data['customer_id'];
          //已经注册的用户
          $customerModel=$handleCustomer->getModelById($customer_id);
          if($customerModel==null || $customerModel==false){
            return false;
          }else if($customerModel['is_owner']==4){
            return false;
          }
          //更新用户信息
          $city_code=$customerModel['city_code']==''?C("CITY_CODE"):$customerModel['city_code'];
          $result=$handleCustomer->updateModel(array('id'=>$customer_id,'city_code'=>$city_code,'update_time'=>$data['update_time'],'update_man'=>$data['update_man'],'is_owner'=>4,'memo'=>$customerModel['memo'].'|'.date('Y-m-d H:i:s').'新增职业房东'));
          if($result){
              //更新房源下的职业房东标识
              $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customer_id,'is_owner'=>4));
               //负责区域
              if(isset($data['region_id']) && isset($data['region_name'])){
                $data1['region_id']=$data['region_id'];
                $data1['region_name']=$data['region_name'];
              }else{
                $resourcelist=$resourceDal->getListByWhere(" customer_id='$customer_id' and record_status=1 ","limit 1");
                if($resourcelist!=null && count($resourcelist)>0){
                  $data1['region_id']=$resourcelist[0]['region_id'];
                  $data1['region_name']=$resourcelist[0]['region_name'];
                }
              }
              
              //新增职业房东数据
              $data1['id']=guid();
              $data1['customer_id']=$customer_id;
              $data1['source']=$data['source'];
              $data1['create_time']=$data['update_time'];
              $data1['update_time']=$data['update_time'];
              $data1['update_man']=$data['update_man'];
              $data1['status']=0;
              $customerinfoDal=new \Home\Model\customerinfo();
              $customerinfoDal->mobileAdd($data1);
          }
          return $result;
       }else{
          if(empty($data['mobile'])){
            return false;
          }
          $customerModel=$handleCustomer->getResourceClientByPhone($data['mobile']);
          if($customerModel==null || $customerModel==false){
            //注册用户
            $customerData['id']=guid();
            $customerData['create_time']=$data['update_time'];
            $customerData['update_time']=$data['update_time'];
            $customerData['update_man']=$data['update_man'];
            $customerData['memo']="新增职业房东注册";
            $customerData['is_owner']=4;
            $customerData['city_code']=C("CITY_CODE");
            $customerData['mobile']=$data['mobile'];
            $result=$handleCustomer->addModel($customerData);
            $customer_id=$customerData['id'];
          }else if($customerModel['is_owner']==4){
            return false;
          }else{
            $customer_id=$customerModel['id'];
            //更新用户信息
            $city_code=$customerModel['city_code']==''?C("CITY_CODE"):$customerModel['city_code'];
            $result=$handleCustomer->updateModel(array('id'=>$customer_id,'city_code'=>$city_code,'update_time'=>$data['update_time'],'update_man'=>$data['update_man'],'is_owner'=>4,'memo'=>$customerModel['memo'].'|'.date('Y-m-d H:i:s').'新增职业房东'));
            if($result){
                //更新房源下的职业房东标识
                $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customer_id,'is_owner'=>4));
            }
          }
          if($result){
             //负责区域
            if(isset($data['region_id']) && isset($data['region_name'])){
              $data1['region_id']=$data['region_id'];
              $data1['region_name']=$data['region_name'];
            }else{
              $resourcelist=$resourceDal->getListByWhere(" customer_id='$customer_id' and record_status=1 ","limit 1");
              if($resourcelist!=null && count($resourcelist)>0){
                $data1['region_id']=$resourcelist[0]['region_id'];
                $data1['region_name']=$resourcelist[0]['region_name'];
              }
            }
              //新增职业房东数据
              $data1['id']=guid();
              $data1['customer_id']=$customer_id;
              $data1['source']=$data['source'];
              $data1['create_time']=$data['update_time'];
              $data1['update_time']=$data['update_time'];
              $data1['update_man']=$data['update_man'];
              $data1['status']=0;
              $customerinfoDal=new \Home\Model\customerinfo();
              $customerinfoDal->mobileAdd($data1);
          }
          return $result;
       }
    }

}
?>
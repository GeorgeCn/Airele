<?php
namespace Logic;
class CustomerLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->updateModel($data);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->getModelById($id);
     return $result;
   }
    //获取房源的房东信息 ById
    public function getResourceClientById($customerId){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->getResourceClientById($customerId);
     return $result;
   }
   //获取房源的房东信息 ByPhone
  public function getResourceClientByPhone($phone){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->getResourceClientByPhone($phone);
     return $result;
   }
   //统计认证房东
   public function getCustomerPageCount($where){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->modelCustomerPageCount($where);
     return $result;
   }
   //获取所有认证房东信息
   public function getCustomerList($firstrow,$listrows,$where){
      $modelDal=new \Home\Model\customer();
      $result = $modelDal->getCustomerList($firstrow,$listrows,$where);
      return $result;
   }
   public function getCustomerInfoByIds($ids){
      $modelDal=new \Home\Model\customer();
      $result = $modelDal->getCustomerInfoByIds($ids);
      return $result;
   }
   //新增房东银行卡
   public function addBankNumber($data){
      $modelDal=new \Home\Model\customer();
      $result = $modelDal->modeladdBankNumber($data);
      return $result;
   }
    //查询银行卡
   public function getBankById($id){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->modelBankById($id);
     return $result;
   } 
   //修改银行卡信息
   public function upBankById($data){
      $modelDal=new \Home\Model\customer();
     $result = $modelDal->modelUpBankById($data);
     return $result;

   }
   public function getBankType($customer_id,$type){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->modelBankType($customer_id,$type);
     return $result;

   }
   //修改房源良心房东状态
   public function upLandlordAuth($customer){
     $modelDal=new \Home\Model\customer();
     $result = $modelDal->modelUpLandlordAuth($customer);
     return $result;
   }
   public function getAllCustomer($firstrow,$listrows,$where){
      $modelDal=new \Home\Model\customer();
      $result = $modelDal->modelAllCustomer($firstrow,$listrows,$where);
      return $result;
   }
  //更新房源下的良心房东字段、& 搜索表
  public function updateAuthByCustomerid($customer_id,$is_auth){
      $modelDal=new \Home\Model\houseresource();
      return $modelDal->updateAuthByCustomerid($customer_id,$is_auth);
  }
  //更新用户缓存
  public function updateCustomerCache($data){
      if(!is_array($data)){
        return false;
      }
      if(empty($data['id']) || empty($data['mobile'])){
        return false;
      }
      if(!C('IS_REDIS_CACHE')){
        return false;
      }
      $cache_key="customer_model_get".$data['id'];
      $cache_key=set_cache_public_key($cache_key);
      set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$cache_key,$data,0);
      return true;
  }
  //根据id查找职业房东信息
  public function findCustomerCheckInfo ($id)
  {
      $modelDal = new \Home\Model\customer();
      $fields = 'id,customer_id,true_name,mobile';
      $where['id'] = $id;
      $result = $modelDal->modelFindCustomerCheck($fileds,$where);
      return $result;
  }
  //根据id修改职业房东审核通过状态
  public function modifyCustomerCheck ($data)
  {
      $modelDal = new \Home\Model\customer();
      $info['id'] = $data['id'];
      $info['refuse_status'] = $data['refuse_status']; 
      $info['pay_type'] = $data['pay_type'];
      $login_name=trim(getLoginName());
      $info['oper_man_name'] = $login_name;
      $result = $modelDal->modelModifyCustomerCheck($info);
      return $result;
  }
  //根据id修改职业房东审核拒绝状态
  public function modifyCustomerCheckRefuse ($data)
  {
      $modelDal = new \Home\Model\customer();
      $info['id'] = $data['id'];
      $info['refuse_status'] = $data['refuse_status']; 
      $info['refuse_memo'] = $data['refuse_memo'];
      $login_name=trim(getLoginName());
      $info['oper_man_name'] = $login_name;
      $result = $modelDal->modelModifyCustomerCheck($info);
      return $result;
  }
  //根据id修改职业房东城市归属
  public function modifyCustomerCheckCity ($data)
  {
      $modelDal = new \Home\Model\customer();
      $info['id'] = $data['id'];
      $info['city_code'] = $data['city_code']; 
      $result = $modelDal->modelModifyCustomerCheck($info);
      return $result;
  }
  //根据id修改用户city_code
  public function modifyCustomerCity ($data)
  {
      $modelDal = new \Home\Model\customer();
      $where['id'] = $data['customer_id'];
      $info['city_code'] = $data['city_code']; 
      $result = $modelDal->updateModelByWhere($where,$info);
      return $result;
  }
  //根据customer_id获取房间编号
  public function getHouseRoomID ($data)
  {
      if(empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $fields = 'id';
      $where['customer_id'] = $data['customer_id'];
      $where['city_code'] = C('CITY_CODE');
      $result = $modelDal->modelGetHouseRoom($fields,$where);
      return $result;
  }
  //根据customer_id查找中介公司、收佣比例
  public function findCustomerInfo ($cid)
  {
      if(empty($cid)) return null;
      $data = array();
      $modelDal = new \Home\Model\customer();
      $fields = 'agent_company_name,agent_commission_type,agent_commission_price';
      $where['id'] = $cid;
      $result = $modelDal->modelFindCustomer($fields,$where);
      if($result['agent_commission_type'] == 0) {
        $data['agent_company_name'] = $result['agent_company_name'];
        $data['agent_commission_price'] = ($result['agent_commission_price']/100).'%';
      } elseif($result['agent_commission_type'] == 1) {
        $data['agent_company_name'] = $result['agent_company_name'];
        $data['agent_commission_price'] = $result['agent_commission_price'].'元';
      }
      return $data;
  }
  //根据公司名称匹配中介公司
  public function findAgentCompany ($company)
  {
      if(empty($company)) return null;
      $modelDal = new \Home\Model\customer();
      $fields = 'id';
      $where['company_name'] = $company;
      $where['city_code'] = C('CITY_CODE');
      $where['record_status'] = 1;
      $result = $modelDal->modelFindAgentCompany($fileds,$where);
      return $result;
  }
  //根据customer_id查找端口
  public function findCustomerService ($cid)
  {
      if(empty($cid)) return null;
      $modelDal = new \Home\Model\customer();
      $fields = 'id';
      $where['customer_id'] = $cid;
      $where['city_code'] = C('CITY_CODE');
      $where['service_end'] = array('gt',time()); 
      $result = $modelDal->modelGetCustomerService($fields,$where);
      if(!empty($result)) {
          return 1;
      } else {
          return 0;
      }
  }
  //增加职业房东信息
  public function addOwnersInfo ($data)
  {
    if(empty($data['mobile'])||empty($data['true_name'])) return false;
    $info['id'] = guid();
    $info['true_name'] = $data['true_name'];
    $info['mobile'] = $data['mobile'];
    $info['city_code'] = $data['city_code'];
    $info['create_time'] = time();
    $login_name = trim(getLoginName());
    $info['update_man'] = $login_name;
    $info['is_owner'] = 4;
    $info['gaodu_platform'] = 3;
    $info['channel'] = '后台新增';
    $info['is_renter'] = 0;
    $info['house_limit'] = $data['house_limit'];
    $modelDal = new \Home\Model\agents();
    $result = $modelDal->modelAddCustomer($info);
    if($result) {
      $infoOne['id'] = guid();
      $infoOne['customer_id'] = $info['id'];
      $infoOne['source'] = '系统添加';
      $infoOne['region_id'] = $data['region_id'];
      $infoOne['region_name'] = $data['region_name'];
      $infoOne['principal_man'] = $data['principal_man'];
      $infoOne['owner_remark'] = $data['owner_remark'];
      $infoOne['status'] = 0;
      $infoOne['create_time'] = time();
      $login_name = trim(getLoginName());
      $infoOne['update_man'] = $login_name;
      $resultOne = $modelDal->modelAddCustomerInfo($infoOne);
      return $resultOne;
    } else {
      return false;
    } 
  }
  //根据customer_id更改用户信息
  public function modifyOwnersInfo ($id,$data)
  {
    if(empty($id)) return false;
    $where['id'] = $id;
    $info['true_name'] = $data['true_name'];
    $info['city_code'] = C('CITY_CODE');
    $info['create_time'] = time();
    $login_name = trim(getLoginName());
    $info['update_man'] = $login_name;
    $info['is_owner'] = 5;
    $info['house_limit'] = $data['house_limit'];
    $modelDal = new \Home\Model\agents();
    $result = $modelDal->modelUpdateCustomer($where,$info);
    if($result) {
      $whereOne['customer_id'] = $id;
      $infoOne['source'] = '系统添加';
      $infoOne['region_id'] = $data['region_id'];
      $infoOne['region_name'] = $data['region_name'];
      $infoOne['principal_man'] = $data['principal_man'];
      $infoOne['owner_remark'] = $data['owner_remark'];
      $infoOne['status'] = 0;
      $infoOne['create_time'] = time();
      $login_name = trim(getLoginName());
      $infoOne['update_man'] = $login_name;
      $resultOne = $modelDal->modelUpdateCustomerInfo($whereOne,$infoOne);
      return $resultOne;
    } else {
      return false;
    }
  }
  //根据id查找个人信息
  public function findOwnerInfo ($id)
  {
      if(empty($id)) return false;
      $fields = 'id,true_name,mobile,is_owner,city_code,owner_verify,agent_company_id,agent_company_name,company_store_id,company_store_name,im_open';
      $where['id'] = $id;
      $modelDal = new \Home\Model\customer();
      $result = $modelDal->modelFindCustomer($fields,$where);
      $fieldsOne = 'principal_man,status,margin,region_id,region_name,owner_remark';
      $whereOne['customer_id'] = $id;
      $resultOne = $modelDal->modelFindCustomerInfo($fieldsOne,$whereOne);
      $result['principal_man'] = $resultOne['principal_man'];
      $result['status'] = $resultOne['status'];
      $result['margin'] = $resultOne['margin'];
      $result['region_id'] = $resultOne['region_id'];
      $result['region_name'] = $resultOne['region_name'];
      $result['owner_remark'] = $resultOne['owner_remark'];
      return $result;
  }
  //根据id查找个人核心信息
  public function findOwnerCoreInfo ($id)
  {
      if(empty($id)) return false;
      $fields = 'id,true_name,mobile,is_owner,owner_verify,im_open,house_limit';
      $where['id'] = $id;
      $modelDal = new \Home\Model\customer();
      $result = $modelDal->modelFindCustomer($fields,$where);
      $fieldsOne = 'principal_man,owner_remark';
      $whereOne['customer_id'] = $id;
      $resultOne = $modelDal->modelFindCustomerInfo($fieldsOne,$whereOne);
      $result['principal_man'] = $resultOne['principal_man'];
      $result['owner_remark'] = $resultOne['owner_remark'];
      return $result;
  }
  //根据id查找基本信息
  public function findBasicInfo ($id)
  {
      if(empty($id)) return false;
      $data = $temp = array();
      $modelDal = new \Home\Model\customer();
      $fields = 'id,customer_id,service_start,service_end,city_code,links_num,create_time,memo';
      $where['customer_id'] = $id;
      $where['city_code'] = C('CITY_CODE');
      $result = $modelDal->modelFindCustomerService($fields,$where);
      $data[0] = $result;
      $fieldsOne = 'id,customer_id,monthly_money,monthly_start,monthly_end,monthly_bak,is_open,create_time,create_man';
      $resultOne = $modelDal->modelFindCommissionMonthly($fieldsOne,$where);
      $data[1] = $resultOne;
      $fieldsTwo = 'id,customer_id,use_time,stop_time,is_open,create_time,create_man,contract_type,contract_money,contract_base,pay_method,memo';
      $resultTwo = $modelDal->modelFindCommissionDetail($fieldsTwo,$where);
      $data[2] = $resultTwo;
      $fieldsThree = 'room_id,top_type,region_name,scope_name,subwayline_name,subway_name,create_man,toproom_createtime';
      $whereThree['customer_id'] = $id;
      $whereThree['top_type'] = array('gt',0);
      $whereThree['subwayline_id'] = array('eq',0);
      $resultThree = $modelDal->modelGetHouseSelect($fieldsThree,$whereThree);
      if(!empty($resultThree)) {
          foreach ($resultThree as $value) {
            $modelStore = new \Home\Model\stores();
            $whereTemp['id'] = $value['room_id'];
            $roomNO = $modelStore->modelFindHouseRoom("room_no",$whereTemp);
            $value['room_no'] = $roomNO['room_no'];
            $temp[] = $value;
          }
      }
      $data[3] = $temp;
      // $fieldsFour = 'renter_num,contact_num,reserve_num,im_num,total_numim';
      // $resultFour = $modelDal->modelFindCustomerLinks($fieldsFour,$where);
      // if(!empty($resultFour)) {
      //   $where['status'] = 2;
      //   $where['record_status'] = 1;
      //   $rooms = $modelDal->modelCountHouseRoom($where);
      //   $resultFour['limit_count'] = $rooms;
      // } else {
      //   $resultFour['renter_num'] = 0;
      //   $resultFour['contact_num'] = 0;
      //   $resultFour['reserve_num'] = 0;
      //   $resultFour['im_num'] = 0;
      //   $resultFour['total_numim'] = 0;
      //   $resultFour['limit_count'] = $rooms;
      // }
      // $data[4] = $resultFour;
      return $data;
  }
  //新增端口时间
  public function addServiceData ($data)
  {
      if(empty($data['service_start']) || empty($data['service_time']) || empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $fieldsPort = 'id';
      $wherePort['customer_id'] = $data['customer_id'];
      $wherePort['city_code'] = C('CITY_CODE');
      $portContract = $modelDal->modelFindCustomerService($fieldsPort,$wherePort);
      $info = $dataHouse = array();
      if(empty($portContract)) {
          $info['id'] = guid();
          $info['customer_id'] = $data['customer_id'];
          $info['service_start'] = strtotime($data['service_start']);
          if($data['service_type'] == 0) {
              $info['service_end'] = strtotime($data['service_start'])+$data['service_time']*3600*24;
          } elseif ($data['service_type'] == 1) {    
             $info['service_end'] = strtotime("+".$data['service_time']." months", strtotime($data['service_start']));;
          }
          $info['city_code'] = C("CITY_CODE");
          $info['links_num'] = $data['links_num'];
          $info['is_deal_end'] = 0;
          $info['create_time'] = time();
          $info['memo'] = $data['memo'];
          $result = $modelDal->modelAddServiceData($info);
          if($result) {
              unset($info['id']);unset($info['is_deal_end']); 
              $info['service_type'] = 0;
              $info['create_man'] = getLoginName(); 
              $info['price'] = $data['price'];
              $info['house_limit'] = $data['house_limit'];
              $info['time_type'] = $data['service_type'];
              $info['gaodu_platform'] = 20;
              $resultTwo = $modelDal->modelAddServiceDetail($info);
              //修改上架房源数量
              $whereHouse['id'] = $data['customer_id'];
              $dataHouse['house_limit'] = $data['house_limit'];
              $modelDal->updateModelByWhere($whereHouse,$dataHouse);
              //修改用户is_port,im_open
              $modelDal->updateModel(array('id'=>$data['customer_id'],'is_port'=>1,'im_open'=>1));
              return $resultTwo;
          } else {
              return false;
          }
      } else {
          $where['customer_id'] = $data['customer_id'];
          $where['city_code'] = C('CITY_CODE');
          $info['service_start'] = strtotime($data['service_start']);
          if($data['service_type'] == 0) {
              $info['service_end'] = strtotime($data['service_start'])+$data['service_time']*3600*24;
          } elseif ($data['service_type'] == 1) {    
             $info['service_end'] = strtotime("+".$data['service_time']."months", strtotime($data['service_start']));;
          }
          $info['city_code'] = C("CITY_CODE");
          $info['links_num'] = $data['links_num'];
          $info['is_deal_end'] = 0;
          $info['create_time'] = time();
          $info['memo'] = $data['memo'];
          $result = $modelDal->modelUpdateServiceData($where,$info);
          if($result) {
              unset($info['is_deal_end']);
              $info['customer_id'] = $data['customer_id'];
              $info['service_type'] = 0;
              $info['create_man'] = getLoginName(); 
              $info['price'] = $data['price'];
              $info['house_limit'] = $data['house_limit'];
              $info['time_type'] = $data['service_type'];
              $info['gaodu_platform'] = 20;
              $resultTwo = $modelDal->modelAddServiceDetail($info);
              //修改上架房源数量
              $whereHouse['id'] = $data['customer_id'];
              $dataHouse['house_limit'] = $data['house_limit'];
              $modelDal->updateModelByWhere($whereHouse,$dataHouse);
              //修改用户is_port
              // $modelDal->updateModel(array('id'=>$data['customer_id'],'is_port'=>1));
              return $resultTwo;
          } else {
              return false;
          }
      }
  }
  //停用端口
  public function stopOwnerPort ($data)
  {
      if(empty($data['id']) || empty($data['customer_id'])) return false;
      $info = array();
      $modelDal = new \Home\Model\customer();
      $where['id'] = $data['id'];
      $info['service_end'] = time()+30;
      $info['update_time'] = time();
      $info['update_man'] = getLoginName();
      $info['memo'] = "后台停用";
      $result = $modelDal->modelUpdateServiceData($where,$info);
      if($result) {
          $info['customer_id'] = $data['customer_id'];
          $info['service_start'] = $data['service_start'];
          $info['service_type'] = 2;
          $info['city_code'] = C("CITY_CODE");
          $info['create_time'] = time();
          $info['create_man'] = getLoginName(); 
          $info['gaodu_platform'] = 20;
          $resultTwo = $modelDal->modelAddServiceDetail($info);
          //修改用户is_port
          // $modelDal->updateModel(array('id'=>$data['customer_id'],'is_port'=>0));
          return $resultTwo;
      } else {
          return false;
      }
  }
  //端口延期
   public function delayOwnerPort ($data)
  {
      if(empty($data['id'])) return false;
      $info = $dataHouse = array();
      $modelDal = new \Home\Model\customer();
      $fields = "id,service_start,service_end";
      $where['id'] = $data['id'];
      $result = $modelDal->modelFindCustomerService($fields,$where);
      if($data['service_type'] == 0) {
          $info['service_end'] = $result['service_end']+$data['service_time']*3600*24;
      } elseif ($data['service_type'] == 1) {    
         $info['service_end'] = strtotime("+".$data['service_time']." months", strtotime($result['service_end']));
      }
      $info['links_num'] = $data['links_num'];
      $info['memo'] = $data['memo'];
      $info['update_time'] = time();
      $info['update_man'] = getLoginName();
      $return = $modelDal->modelUpdateServiceData($where,$info);
      if($return) {
          $info['customer_id'] = $data['customer_id'];
          $info['price'] = $data['price'];
          $info['house_limit'] = $data['house_limit'];
          $info['service_start'] = $result['service_start'];
          $info['service_type'] = 1;
          $info['city_code'] = C("CITY_CODE");
          $info['create_time'] = time();
          $info['create_man'] = getLoginName(); 
          $info['gaodu_platform'] = 20;
          $resultTwo = $modelDal->modelAddServiceDetail($info);
          //修改上架房源数量
          $whereHouse['id'] = $data['customer_id'];
          $dataHouse['house_limit'] = $data['house_limit'];
          $modelDal->updateModelByWhere($whereHouse,$dataHouse);
          return $resultTwo;
      } else {
          return false;
      }
  }
  //新增包月
  public function addCommissionMonthly ($data)
  {
      if(empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $info['id'] = guid();
      $info['customer_id'] = $data['customer_id'];
      $info['monthly_money'] = $data['monthly_money'];
      $info['monthly_start'] = strtotime(date("Y-m-d"),time());
      $info['monthly_bak'] = $data['monthly_bak'];
      $info['is_open'] = 1 ;
      $info['create_time'] = time();
      $info['create_man'] = getLoginName(); 
      $info['city_code'] = C('CITY_CODE');
      $return = $modelDal->modelAddCommissionMonthly($info);
      if($return) {
          //修改用户数据，更新包月信息
          $modelDal->updateModel(array('id'=>$info['customer_id'],'is_monthly'=>1,'monthly_start'=>strtotime(date("Y-m-d"),time()),'update_time'=>$info['update_time'],'update_man'=>$info['update_man']));
          //更新房间信息
          $dal = new \Home\Model\houseroom();
          $dal->updateModelByWhere(array('is_monthly'=>1),"customer_id='".$info['customer_id']."'");
          return true;
      } else {
          return false;
      }
  }
  //停用包月
  public function stopOwnerMonthly ($data)
  {
      if(empty($data['id']) || empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $where['id'] = $data['id'];
      $data['monthly_end'] = strtotime(date("Y-m-d"),time());
      $data['is_open'] = 0;
      $data['update_time'] = time();
      $data['update_man'] = getLoginName();
      $data['monthly_bak'] = "后台停用";
      $return = $modelDal->modelUpdateCommissionMonthly($where,$data);
      if($return) {
          //修改用户数据，更新包月信息
          $modelDal->updateModel(array('id'=>$data['customer_id'],'is_monthly'=>0,'monthly_end'=>strtotime(date("Y-m-d"),time()),'update_time'=>$data['update_time'],'update_man'=>$data['update_man']));
          //更新房间信息
          $dal = new \Home\Model\houseroom();
          $dal->updateModelByWhere(array('is_monthly'=>0),"customer_id='".$data['customer_id']."'");
          return true;
      } else {
          return false;
      }
  }
  //新增佣金
  public function addCommissionDetail ($data)
  {
      if(empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $info['id'] = guid();
      $info['customer_id'] = $data['customer_id'];
      $info['use_time'] = strtotime(date("Y-m-d"),time());
      $info['contract_type'] = $data['contract_type'];
      $info['contract_money'] = $data['contract_money'];
      $info['contract_base'] = $data['contract_base'];
      $info['pay_method'] = $data['pay_method'];
      $info['memo'] = $data['memo'];
      $info['is_open'] = 1;
      $info['create_time'] = time();
      $info['create_man'] = getLoginName(); 
      $info['city_code'] = C('CITY_CODE');
      $return = $modelDal->modelAddCommissionDetail($info);
      if($return) {
          //修改用户数据，更新包月信息
          $modelDal->updateModel(array('id'=>$info['customer_id'],'is_commission'=>1,'update_time'=>$info['create_time'],'update_man'=>$info['create_man']));
          //更新房间信息
          $dal = new \Home\Model\houseroom();
          $dal->updateModelByWhere(array('is_commission'=>1),"customer_id='".$info['customer_id']."'");
          return true;
      } else {
          return false;
      }
  }
  //停用佣金
  public function stopOwnerCommission ($data)
  {
      if(empty($data['id']) || empty($data['customer_id'])) return false;
      $modelDal = new \Home\Model\customer();
      $where['id'] = $data['id'];
      $data['stop_time'] = strtotime(date("Y-m-d"),time());
      $data['is_open'] = 0;
      $data['update_time'] = time();
      $data['update_man'] = getLoginName();
      $data['memo'] = "后台停用";
      $return = $modelDal->modelUpdateCommissionDetail($where,$data);
      if($return) {
          //修改用户数据，更新包月信息
          $modelDal->updateModel(array('id'=>$data['customer_id'],'is_commission'=>0,'update_time'=>$data['create_time'],'update_man'=>$data['create_man']));
          //更新房间信息
          $dal = new \Home\Model\houseroom();
          $dal->updateModelByWhere(array('is_commission'=>0),"customer_id='".$data['customer_id']."'");
          return true;
      } else {
          return false;
      }
  }
  //获取下载数据
  public function findDownloadData ($cid)
  {
      if(empty($cid)) return false;
      $data = array();
      $modelDal = new \Home\Model\customer();
      $fieldsInfo = 'principal_man';
      $whereInfo['customer_id'] = $cid;
      $principal = $modelDal->modelFindCustomerInfo($fieldsInfo,$whereInfo);
      $data['principal_man'] = $principal['principal_man']; 
      return $data;
  }
  /*获取房东 IM连接数，总连接数 */
  public function getIMConnectData($owner_id,$total_count,$start_time=0,$end_time=0){
  if(empty($owner_id)){
    return array('total_count'=>$total_count,'im_count'=>0);
  }
  $customerDal=new \Home\Model\customer();
  if($total_count==0){
    if($start_time==0 && $end_time==0){
      $im_data=$customerDal->getIMConnectData("count(DISTINCT customer_mobile,room_id) as cnt","owner_id='$owner_id' ");
    }else{
      $im_data=$customerDal->getIMConnectData("count(DISTINCT customer_mobile,room_id) as cnt","owner_id='$owner_id' AND create_time BETWEEN $start_time AND $end_time");
    }
    if($im_data!=null&&count($im_data)>0){
      $im_cnt=intval($im_data[0]['cnt']);
      if($im_cnt>0){
        return array('total_count'=>$im_cnt/2,'im_count'=>$im_cnt/2);
      }
    }
  }else{
    //有联系房东、预约连接数
    if($start_time==0 && $end_time==0){
      $im_data=$customerDal->getIMConnectData("DISTINCT customer_mobile,room_id","owner_id='$owner_id' ");
    }else{
      $im_data=$customerDal->getIMConnectData("DISTINCT customer_mobile,room_id","owner_id='$owner_id' AND create_time BETWEEN $start_time AND $end_time");
    }
    $im_cnt=count($im_data);
    $chong_cnt=0;
    if($im_data!=null&&$im_cnt>0){
      //先读取到IM 连接记录
      if($start_time==0 && $end_time==0){
        $connect_data=$customerDal->getSummaryConnectData("DISTINCT renter_mobile,room_id","owner_id='$owner_id' ");
      }else{
        $connect_data=$customerDal->getSummaryConnectData("DISTINCT renter_mobile,room_id","owner_id='$owner_id' AND create_time BETWEEN $start_time AND $end_time");
      }
      if($connect_data!=null&&count($connect_data)>0){
        foreach ($im_data as $key_im => $value_im) {
          foreach ($connect_data as $key_c => $value_c) {
            if($value_im['customer_mobile']==$value_c['renter_mobile'] && $value_im['room_id']==$value_c['room_id']){
              $chong_cnt+=1;
              break;
            }
          }
        }
        $im_count=($im_cnt-$chong_cnt)/2;
        return array('total_count'=>$total_count+$im_count,'im_count'=>$im_count);
      }
    }
    
  }
  return array('total_count'=>$total_count,'im_count'=>0);
}

}
?>
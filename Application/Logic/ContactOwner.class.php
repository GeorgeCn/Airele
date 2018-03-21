<?php
namespace Logic;
class ContactOwner {
	   //统计总条数
     public function getContactOwnerCount($where){
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->modelContactOwnerCount($where);
    }
    //获取分页数据
    public function getContactOwnerList($firstrow,$listrows,$where,$count=10){
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->modelContactOwnerList($firstrow,$listrows,$where,$count); 
    }
    //已听录音列表
     public function getHaveheardCount($condition){
        $where=$this->getContactCondition($condition);
        if(!empty($where)){
          $where=" where ".substr(trim($where), 3);
        }
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->getHaveheardCount($where);
    }
    public function getHaveheardList($firstrow,$listrows,$condition){
        $where=$this->getContactCondition($condition);
        if(!empty($where)){
          $where=" where ".substr(trim($where), 3);
        }
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->getHaveheardList($firstrow,$listrows,$where); 
    }
    //下载字段
    public function getAllContactDownload($firstrow,$listrows,$condition){
        $where=$this->getContactCondition($condition);
        if(!empty($where)){
          $where=" where ".substr(trim($where), 3);
        }
        $modelDal=new \Home\Model\contactowner();
        $columns='region_name,scope_name,estate_name,room_type,room_num,room_id,room_money,info_resource,is_commission,mobile,big_code,ext_code,agent_company_name,owner_mobile,owner_name,gaodu_platform,charge_man,principal_man,status_code,caller_length,called_length,call_time,brand_type,is_monthly,is_owner';
      
        return $modelDal->getAllContactList($firstrow,$listrows,$where,$columns); 
    }
    //所有联系记录
     public function getAllContactCount($condition){
        $where=$this->getContactCondition($condition);
        if(!empty($where)){
          $where=" where ".substr(trim($where), 3);
        }
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->getAllContactCount($where);
    }
    public function getAllContactList($firstrow,$listrows,$condition){
        $where=$this->getContactCondition($condition);
        if(!empty($where)){
          $where=" where ".substr(trim($where), 3);
        }
        $modelDal=new \Home\Model\contactowner();
        return $modelDal->getAllContactList($firstrow,$listrows,$where); 
    }
    private function getContactCondition($condition){
      $conditionString="";
      //拨打时间
       if(isset($condition['startTime']) && !empty($condition['startTime'])){
          $conditionString.=" and call_time>=".strtotime(trim($condition['startTime']));
       }
       if(isset($condition['endTime']) && !empty($condition['endTime'])){
          $endTime=strtotime(trim($condition['endTime']));
          $endTime=$endTime+60*60*24;
          $conditionString.=" and call_time<=".$endTime;
       }
       if(isset($condition['big_code'])){
         if($condition['big_code']!=""){
           $conditionString.=" and big_code='".str_replace("'", "", trim($condition['big_code']))."'";
         }else{
           $conditionString.=" and big_code<>'4008108756' and is_marketing=0 ";
         }
       }
       //电话状态
       if(isset($condition['status_code']) && $condition['status_code']!=""){
          if($condition['status_code']=='9999'){
            $conditionString.=" and status_code=-1";
          }else{
            $conditionString.=" and status_code=".$condition['status_code'];
          }
       }else{
          if(isset($condition['unknown']) && (strtolower($condition['unknown'])=='on' || $condition['unknown']=='1')){
            $conditionString.=" and status_code>=0";
          }
          if(isset($condition['abandon']) && (strtolower($condition['abandon'])=='on' || $condition['abandon']=='1')){
            $conditionString.=" and status_code<>11";
          }
       }
       if(isset($condition['is_read']) && $condition['is_read']!=""){
         $conditionString.=" and is_read=".$condition['is_read'];
       }
       $conditionString.=" and city_id='".C('CITY_CODE')."'";
       if (isset($condition['loginphone']) && $condition['loginphone']!="") {
          $conditionString.=" and mobile='".str_replace("'", "", trim($condition['loginphone']))."'";
       }
       if (isset($condition['ownerphone']) && $condition['ownerphone']!="") {
          $conditionString.=" and owner_mobile='".str_replace("'", "", trim($condition['ownerphone']))."'";
       }
       if (isset($condition['makcall']) && $condition['makcall']!="") {
          $conditionString.=" and is_my=".$condition['makcall'];
       }
        if (isset($condition['handleman']) && $condition['handleman']!="") {
          $conditionString.=" and updata_man='".str_replace("'", "", trim($condition['handleman']))."'";
        }  
        if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
           $conditionString.=" and info_resource_type=".$condition['info_resource_type'];
        }
        if (isset($condition['info_resource']) && $condition['info_resource']!="") {
          if($condition['info_resource']=="空"){
              $conditionString.=" and info_resource=''";
          }else{
              $conditionString.=" and info_resource='".$condition['info_resource']."'";
          }
        } 
        if(isset($condition['platform']) && $condition['platform']!=""){
           $conditionString.=" and gaodu_platform=".$condition['platform'];
        }
        //区域板块
        if(isset($condition['region']) && $condition['region']!=""){
           $conditionString.=" and region_id=".$condition['region'];
        }
        if(isset($condition['scope']) && $condition['scope']!=""){
           $conditionString.=" and scope_id=".$condition['scope'];
        }
        if(isset($condition['is_commission']) && $condition['is_commission']!=""){
           $conditionString.=" and is_commission=".$condition['is_commission'];
        }
        if(isset($condition['is_monthly']) && $condition['is_monthly']!=""){
           $conditionString.=" and is_monthly=".$condition['is_monthly'];
        }
        //租金
        if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
           if(is_numeric($condition['moneyMin'])){
             $conditionString.=" and room_money>=".$condition['moneyMin'];
           }
        }
        if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
           if(is_numeric($condition['moneyMax'])){
             $conditionString.=" and room_money<=".$condition['moneyMax'];
           }
        }
        //房源负责人
        if(isset($condition['charge_man']) && $condition['charge_man']!=""){
           $conditionString.=" and charge_man='".str_replace("'", "", trim($condition['charge_man']))."'";
        }
         //房东负责人
        if(isset($condition['principal_man']) && $condition['principal_man']!=""){
           $conditionString.=" and principal_man='".str_replace("'", "", trim($condition['principal_man']))."'";
        }
        //品牌公寓
        if(isset($condition['brand_type']) && $condition['brand_type']!=""){
          if($condition['brand_type']=='none'){
             $conditionString.=" and brand_type=''";
          }else if($condition['brand_type']=='all'){
             $conditionString.=" and brand_type<>''";
          }else{
             $conditionString.=" and brand_type='".$condition['brand_type']."'";
          }
        }
        //房间编号
        if(isset($condition['room_no']) && $condition['room_no']!=""){
           $conditionString.=" and room_id='".str_replace("'", "", trim($condition['room_no']))."'";
        }
        #户型和房间类型
       if(isset($condition['room_num']) && $condition['room_num']!=""){
          if($condition['room_num']=='2+'){
              $conditionString.=" and room_num>=2";
          }else if($condition['room_num']=='3+'){
              $conditionString.=" and room_num>=3";
          }else if($condition['room_num']=='4+'){
              $conditionString.=" and room_num>=4";
          }else{
              $conditionString.=" and room_num=".$condition['room_num'];
          }
       }
       if(isset($condition['room_type']) && $condition['room_type']!=""){
          $conditionString.=" and room_type='".$condition['room_type']."' ";
       }
        //是否是中介
        if(isset($condition['is_owner']) && $condition['is_owner']!=""){
          if($condition['is_owner']==5){
           $conditionString.=" and is_owner=".str_replace("'", "", trim($condition['is_owner']))."";
          }elseif($condition['is_owner']==999){
            $conditionString.=" and is_owner<>5";
          }
        }
        if(isset($condition['agentCompany']) && $condition['agentCompany']!=""){
           $conditionString.=" and agent_company_id='".$condition['agentCompany']."'";
        }
        return $conditionString;
    }
    public function modelYetRecordCount($where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelYetRecordCount($where);
        return $result;
    }
    //获取分页数据
    public function modelYetRecordList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelYetRecordList($firstrow,$listrows,$where);
        return $result;     
    }
    public function modelDistinctRoomCount($where,$codestr){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelDistinctRoomCount($where,$codestr);
        return $result;
    }
    
    public function modelFind($where){
          $modelDal=new \Home\Model\contactowner();
          $result=$modelDal->modelFind($where);
          return $result; 
    }

     public function updateallcall($where){
          $modelDal=new \Home\Model\contactowner();
          $result=$modelDal->updateallcall($where);
          return $result; 
     }


    public function modelUpdate($data){
          $modelDal=new \Home\Model\contactowner();
          $result=$modelDal->modelUpdate($data);
          return $result; 
    }
    public function modelHouseRoomFind($where){
          $modelDal=new \Home\Model\contactowner();
          $result=$modelDal->modelHouseRoomFind($where);
          return $result; 
    }

    public function modelHouseRoomUpdate($data){
          $modelDal=new \Home\Model\contactowner();
          $result=$modelDal->modelHouseRoomUpdate($data);
          return $result; 
    }

    public function getHouseRoom($where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelHouseRoom($where);
        return $result;     
    }
    public function modelGetHouseResource($room_no){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelGetHouseResource($room_no);
        return $result;     
    }
    //获取房东姓名
    public function getLandlordName($mobile){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelLandlordName($mobile);
        return $result;     
    }
    public function modelGetHouseRoom($where){
         $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelGetHouseRoom($where);
        return $result;
    }
    public function getLandlordNameCache($mobile){
      $city_prex=C('CITY_PREX');
        if(!is_array(get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'call_model_get'.$mobile))){
            $result=$this->getLandlordName($mobile);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'call_model_get'.$mobile,$result,3600);
        }else{
            $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'call_model_get'.$mobile);
       
        }
        return $result;

    }

    //下载联系房东
    public function getAllContactOwner($where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelAllContactOwner($where);
        return $result; 
    }
    
    //拨打记录按天统计
    public function modelOwnerCount($where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelOwnerCount($where);
        return $result;
    }

    public function modelOwnerCountList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelOwnerCountList($firstrow,$listrows,$where);
        return $result;
    }

    public function modelAjaxPhoneCount($datetime,$platform){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelAjaxPhoneCount($datetime,$platform);
        return $result;
    }

    public function modelAjaxCount($datetime){
         $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelAjaxCount($datetime);
        return $result;
    }
    public function modelManCount($datetime){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelManCount($datetime);
        return $result;
    }
    public function modelRoomCount($datetime){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelRoomCount($datetime);
        return $result;
    }
    public function modelRoomArray($datetime){
        $modelDal=new \Home\Model\contactowner();
        $result=$modelDal->modelRoomArray($datetime);
        return $result;
    }

     public function getHouseRoomCache($where){
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'housre_room_no_get'.$where['room_no']);
        if(empty($result)){
            $result=$this->modelGetHouseRoom($where);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'housre_room_no_get'.$where['room_no'],$result,3600);
        }
        return $result;
    }

     public function getResourceCache($room_no){
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'resource_roomno_get'.$room_no);
        if(empty($result)){
            $result=$this->modelGetHouseResource($room_no);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'resource_roomno_get'.$room_no,$result,3600);
        }
        return $result;
    }
     public function getCacheHouseRoom($room_id){
         $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_house_room'.$room_id);
          if(empty($result)){ 
               $result=$this->getHouseRoom($room_id);
               set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_house_room'.$room_id,$result,7000);
          }
          return $result;
    }
 /*短链推送 */
   public function getShorturlList($condition){
     $conditionString=$this->getShorturlCondition($condition);
      if(!empty($conditionString)){
        $conditionString=' where '.substr(trim($conditionString), 3);
      }
       $modelDal=new \Home\Model\contactowner();
       return $modelDal->getShorturlList($conditionString);
   }
   public function getShorturlDownloadList($condition){
     $conditionString=$this->getShorturlCondition($condition);
      if(!empty($conditionString)){
        $conditionString=' where '.substr(trim($conditionString), 3);
      }
       $modelDal=new \Home\Model\contactowner();
       return $modelDal->getShorturlDownloadList($conditionString);
   }
   private function getShorturlCondition($condition)
    {
        $conditionString="";
        if (isset($condition['mobile']) && !empty($condition['mobile'])) {
            $conditionString.=" and mobile='".str_replace("'", "", $condition['mobile'])."'";
        }
         //联系时间
         if(isset($condition['startTime']) && trim($condition['startTime'])!=''){
            $conditionString.=" and call_time>=".strtotime(trim($condition['startTime']));
         }
         if(isset($condition['endTime']) && trim($condition['endTime'])!=''){
            $endTime=strtotime(trim($condition['endTime']));
            $endTime=$endTime+60*60*24;
            $conditionString.=" and call_time<=".$endTime;
         }

        if (isset($condition['status']) && $condition['status']!="") {
            $conditionString.=" and shorturl_issend=".$condition['status'];
        }
        if(isset($condition['bigcode']) && $condition['bigcode']!=""){
            $conditionString.=" and big_code='".$condition['bigcode']."'";
        }else{
           $conditionString.=" and big_code in ('4008180555','4008150019','4008170019')";
        }
        if(isset($condition['handle_man']) && $condition['handle_man']!=""){
            $conditionString.=" and shorturl_handleman='".str_replace("'", "", $condition['handle_man'])."'";
        }
        return $conditionString;
    }

    //推送用户社会化信息
    public function sendSocializeInfo ($requestData = array()) 
    {
        $modelDal=new \Home\Model\contactowner();
        $strParam = $modelDal->createStr($requestData);  
        $url = 'http://120.27.162.0:9080/monkey/recommend/UserSocialize.action';
        $result = $modelDal->requestPost($url,$strParam);
        return $result;
    }
    //根据mobile获取用户社会信息
    public function getSocializeInfo ($mobile)
    {
        $modelDal=new \Home\Model\contactowner();
        $requestData = array();
        $requestData['mobile'] = $mobile;
        $requestData['actionType'] = 1;
        // $fields = 'sex,if_cut_off,if_bathroom,if_kitchen,look_room,if_reject_landlord';
        // $where['mobile'] = $mobile;
        // $result = $modelDal->findSocializeInfo($fields,$where);
        $strParam = $modelDal->createStr($requestData);
        $url = 'http://120.27.162.0:9080/monkey/recommend/UserSocialize.action';
        $result = curl_url($url,$strParam);
        return $result;
    }
    //根据mobile获取用户city_code
    public function getCustomerCityCode ($mobile)
    {
        $modelDal = new \Home\Model\contactowner();
        $fields = 'city_code';
        $where = array();
        $where['mobile'] = $mobile;
        $code = $modelDal->findCustomerInfo($fields,$where);
        if($code['city_code'] != null) {
          $result = $code['city_code'];
        } else {
          $result = C('CITY_CODE');
        }
        return $result;
    }
    //根据room_no查找store_id
    public function findHouseRoom ($data)
    {
        if(empty($data['room_no'])) return null;
        $modelDal = new \Home\Model\contactowner();
        $fields = 'store_id';
        $where['room_no'] = trim($data['room_no']);
        $result = $modelDal->modelFindHouseRoom($fields,$where);
        return $result; 
    }
}
?>
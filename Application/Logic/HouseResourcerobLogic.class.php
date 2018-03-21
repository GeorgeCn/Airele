<?php
namespace Logic;
class HouseResourcerobLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->updateModel($data);
     return $result;
   }
    //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->deleteModelById($id);
     return $result;
   }
   //更新房源房间总数
   public function updateRoomCountById($id,$update_count){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->updateRoomCountById($id,$update_count);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getModelById($id);
     return $result;
   } 
   //列表
   public function getModelList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getModelList($conditionString,$limit_start,$limit_end);
     return $result;
   }
   public function getExcelList($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getExcelList($conditionString);
     return $result;
   }
    //列表总？条数
   public function getModelListCount($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getModelListCount($conditionString);
     return $result;
   }
   public function getConditionString($condition){
     $conditionString="";
     if(trim($condition['startTime'])!=''){
        $conditionString.=" and h.create_time>=".strtotime(trim($condition['startTime']));
     }
     if(trim($condition['endTime'])!=''){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and h.create_time<=".$endTime;
     }
     //上房类型
     if(isset($condition['upType']) && $condition['upType']!=''){
        $conditionString.=" and h.uproom_type=".$condition['upType'];
     }
     if(isset($condition['phoneStatus']) && $condition['phoneStatus']!=''){
        $conditionString.=" and h.phone_status=".$condition['phoneStatus'];
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
     if(isset($condition['estateName']) && $condition['estateName']!=''){
        $conditionString.=" and h.estate_name like '%".$condition['estateName']."%' ";
     }
     if(isset($condition['clientPhone']) && $condition['clientPhone']!=''){
        $conditionString.=" and h.client_phone like '".$condition['clientPhone']."%' ";
     }
     if(trim($condition['region'])!=''){
        $conditionString.=" and h.region_id='".trim($condition['region'])."' ";
     }
     if(trim($condition['scope'])!=''){
        $conditionString.=" and h.scope_id='".trim($condition['scope'])."' ";
     }
     if(trim($condition['info_resource'])!=''){
        if($condition['info_resource']=="空"){
          $conditionString.=" and h.info_resource='' ";
        }else{
          $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
        }
     }
     //房间类型
     if(isset($condition['room_type']) && $condition['room_type']!=''){
        $conditionString.=" and h.room_type='".$condition['room_type']."' ";
     }
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
     return $conditionString;
   }
   //检索小区名称
  public function getEstateNameByKeyword($key){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getEstateNameByKeyword($key);
     return $result;
  }
  public function getEstateNameByKeywordV2($key,$type){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getEstateNameByKeywordV2($key,$type);
     return $result;
  }
  //检查(小区名称是否存在),返回信息结果
  public function getEstateModelByName($estate_name){ 
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getEstateModelByName($estate_name);
     return $result;
  }
  public function getEstateModelByNameV2($estate_name,$type){ 
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getEstateModelByNameV2($estate_name,$type);
     return $result;
  }
 //检查(房源信息是否存在),返回数量结果
  public function getHouseCountByHouseinfo($estate_name,$unit_no,$room_no){ 
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getHouseCountByHouseinfo($estate_name,$unit_no,$room_no);
     return $result;
  }

  //获得房源配置参数
  public function getResourceParameters(){
     $modelDal=new \Home\Model\houseresourcerob();
      $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_parameter");
     if(empty($data)){
        $data = $modelDal->getResourceParameters();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_parameter",$data,60*60*2);
     }
     return $data;
  }
  //缓存 读取区域板块
  public function getRegionScopeList(){
     $modelDal=new \Home\Model\houseresourcerob();
    $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_scope_data");
     if(empty($data)){
        $data = $modelDal->getRegionScopeList();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_scope_data",$data,60*60*4);
     }
     return $data;
  }
  public function getRegionList(){
     $modelDal=new \Home\Model\houseresourcerob();
      $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_data");
     if(empty($data)){
        $data = $modelDal->getRegionList();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_data",$data,60*60*4);
     }
     return $data;
  }
  //缓存 读取房源操作人 列表
  public function getHouseHandleList(){
     $modelDal=new \Home\Model\houseresourcerob();
     $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_handle_men");
     if(empty($data)){
        $data = $modelDal->getHouseHandleList();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_handle_men",$data,60*60*2);
     }
     return $data;
  }
  /*生成房源编号*/
  public function createHouseno()
  {
    $house_no=date("Ymd",time())."02".rand(10000, 99999);
    $dal=new \Home\Model\houseresourcerob();
    $count=$dal->getCountByHouseno($house_no);
    if($count>=1)
    {
      return $this->createHouseno();
    }
    else
    {
      return $house_no;
    }
  }
   //查询区域、板块名称
  public function getRegionScopeName($region_id,$scope_id){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getRegionScopeName($region_id,$scope_id);
     return $result;
  }
  //根据ID获得房源地址信息
   public function getAddressInfoById($id){
     $modelDal=new \Home\Model\houseresourcerob();
     $result = $modelDal->getAddressInfoById($id);
     return $result;
   }
   //更新房源负责人
  public function updateResourceCreateman($id,$create_man){
     $modelDal=new \Home\Model\houseresourcerob();
     return $modelDal->updateResourceCreateman($id,$create_man);
  }
  /*更新房源里的房东信息 by customer_id */
  public function updateHouseClientByCustomerid($data){
     $modelDal=new \Home\Model\houseresourcerob();
     return $modelDal->updateHouseClientByCustomerid($data);
  }
}
?>
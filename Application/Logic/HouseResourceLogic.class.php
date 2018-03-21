<?php
namespace Logic;
class HouseResourceLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->updateModel($data);
     return $result;
   }
    //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->deleteModelById($id);
     return $result;
   }
   //更新房源房间总数
   public function updateRoomCountById($id,$update_count){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->updateRoomCountById($id,$update_count);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getModelById($id);
     return $result;
   }
   //列表
   public function getModelList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getModelList($conditionString,$limit_start,$limit_end);
     return $result;
   }
   public function getExcelList($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getExcelList($conditionString);
     return $result;
   }
    //列表总？条数
   public function getModelListCount($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getModelListCount($conditionString);
     return $result;
   }
   public function getConditionString($condition){
     $conditionString="";
     if(isset($condition['startTime']) && trim($condition['startTime'])!=''){
        $conditionString.=" and h.update_time>=".strtotime(trim($condition['startTime']));
     }
     if(isset($condition['endTime']) && trim($condition['endTime'])!=''){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and h.update_time<=".$endTime;
     }
     //创建时间
     if(isset($condition['startTime_create']) && trim($condition['startTime_create'])!=''){
        $conditionString.=" and h.create_time>=".strtotime(trim($condition['startTime_create']));
     }
     if(isset($condition['endTime_create']) && trim($condition['endTime_create'])!=''){
        $endTime=strtotime(trim($condition['endTime_create']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and h.create_time<=".$endTime;
     }
     if(isset($condition['estateName']) && trim($condition['estateName'])!=''){
        $conditionString.=" and h.estate_name like '".str_replace("'", "", trim($condition['estateName']))."%' ";
     }
     if(isset($condition['clientName']) && trim($condition['clientName'])!=''){
        $conditionString.=" and h.client_name like '".str_replace("'", "", trim($condition['clientName']))."%' ";
     }
     if(isset($condition['clientPhone']) && trim($condition['clientPhone'])!=''){
        $conditionString.=" and h.client_phone='".str_replace("'", "", trim($condition['clientPhone']))."' ";
     }
     if(isset($condition['houseNo']) && trim($condition['houseNo'])!=''){
        $conditionString.=" and h.house_no='".str_replace("'", "", trim($condition['houseNo']))."' ";
     }
     if(isset($condition['business_type']) && trim($condition['business_type'])!=''){
        $conditionString.=" and h.business_type='".trim($condition['business_type'])."' ";
     }
     if(isset($condition['create_man']) && trim($condition['create_man'])!=''){
        $conditionString.=" and h.create_man='".str_replace("'", "", trim($condition['create_man']))."' ";
     }
     if(isset($condition['region']) && trim($condition['region'])!=''){
        $conditionString.=" and h.region_id='".trim($condition['region'])."' ";
     }
     if(isset($condition['scope']) && trim($condition['scope'])!=''){
        $conditionString.=" and h.scope_id='".trim($condition['scope'])."' ";
     }
     if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
        $conditionString.=" and h.info_resource_type=".$condition['info_resource_type'];
     }
     if(isset($condition['info_resource']) && trim($condition['info_resource'])!=''){
        if($condition['info_resource']=="空"){
          $conditionString.=" and h.info_resource='' ";
        }else{
          $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
        }
     }
     return $conditionString;
   }
   //检索小区名称
  public function getEstateNameByKeyword($key){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getEstateNameByKeyword($key);
     return $result;
  }
  public function getEstateNameByKeywordV2($key,$type){
     $modelDal=new \Home\Model\houseresource();
     $list = $modelDal->getEstateNameByKeywordV2($key,$type);
     $listNew=array();
     if($list!=null){
        foreach ($list as $key => $value) {
          switch ($value['business_type']) {
            case '1501':
              $value['business_typename']='小区住宅';
              break;
            case '1502':
              $value['business_typename']='集中公寓';
              break;
            case '1503':
              $value['business_typename']='酒店长租';
              break;
            default:
              break;
          }
          $listNew[]=$value;
        }
     }
     return $listNew;
  }
  //检查(小区名称是否存在),返回信息结果
  public function getEstateModelByName($estate_name){ 
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getEstateModelByName($estate_name);
     return $result;
  }
  public function getEstateModelByNameV2($estate_name,$type){ 
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getEstateModelByNameV2($estate_name,$type);
     return $result;
  }
 //检查(房源信息是否存在),返回数量结果
  public function getHouseCountByHouseinfo($estate_name,$unit_no,$room_no){ 
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getHouseCountByHouseinfo($estate_name,$unit_no,$room_no);
     return $result;
  }

  //获得房源配置参数
  public function getResourceParameters(){
     $modelDal=new \Home\Model\houseresource();
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
     $modelDal=new \Home\Model\houseresource();
    $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_scope_data");
     if(empty($data)){
        $data = $modelDal->getRegionScopeList();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."region_scope_data",$data,60*60*4);
     }
     return $data;
  }
  public function getRegionList(){
     $modelDal=new \Home\Model\houseresource();
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
     $modelDal=new \Home\Model\houseresource();
     $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_handle_men");
     if(empty($data)){
        $data = $modelDal->getHouseHandleList();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."house_handle_men",$data,60*60*2);
     }
     return $data;
  }
  //查询房源负责人
  public function getHouseHandleListBykey($key){
     $key=str_replace("'", "", trim($key));
     $modelDal=new \Home\Model\houseresource();
     return $modelDal->getHouseHandleListBykey($key);
  }
  /*生成房源编号*/
  public function createHouseno($city_code='')
  {
    switch ($city_code) {
      case '':
        $house_no=C('CITY_PREX').date("Ymd",time())."02".rand(10000, 99999);
        break;
      case '001009001':
        $house_no='SH'.date("Ymd",time())."02".rand(10000, 99999);
        break;
      case '001001':
        $house_no='BJ'.date("Ymd",time())."02".rand(10000, 99999);
        break;
      case '001011001':
        $house_no='HZ'.date("Ymd",time())."02".rand(10000, 99999);
        break;
      case '001010001':
        $house_no='NJ'.date("Ymd",time())."02".rand(10000, 99999);
        break;
      case '001019002':
        $house_no='SZ'.date("Ymd",time())."02".rand(10000, 99999);
        break;
      default:
        break;
    }
    
    $dal=new \Home\Model\houseresource();
    $count=$dal->getCountByHouseno($house_no);
    if($count>=1)
    {
      return $this->createHouseno($city_code);
    }
    else
    {
      return $house_no;
    }
  }
   //查询区域、板块名称
  public function getRegionScopeName($region_id,$scope_id){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getRegionScopeName($region_id,$scope_id);
     return $result;
  }
  //根据ID获得房源地址信息
   public function getAddressInfoById($id){
     $modelDal=new \Home\Model\houseresource();
     $result = $modelDal->getAddressInfoById($id);
     return $result;
   }
   //更新房源负责人
  public function updateResourceCreateman($id,$create_man){
     $modelDal=new \Home\Model\houseresource();
     return $modelDal->updateResourceCreateman($id,$create_man);
  }
  /*更新房源里的房东信息 by customer_id */
  public function updateHouseClientByCustomerid($data){
     $modelDal=new \Home\Model\houseresource();
     return $modelDal->updateHouseClientByCustomerid($data);
  }

   /*待审核房源列表 */
  public function getExamineCount($condition){
    $where=$this->getExamineCondition($condition);
    $modelDal=new \Home\Model\houseresource();
    return $modelDal->getExamineCount($where);
  }
  public function getExamineList($condition,$limit_start,$limit_end){
    $where=$this->getExamineCondition($condition);
    $modelDal=new \Home\Model\houseresource();
    return $modelDal->getExamineList($where,$limit_start,$limit_end);
  }
  private function getExamineCondition($condition){
    $where="";
    if(isset($condition['client_phone']) && !empty($condition['client_phone'])){
      $where.=" and h.client_phone='".str_replace("'", "", trim($condition['client_phone']))."'";
    }
    if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
      $where.=" and h.info_resource_type=".$condition['info_resource_type'];
    }
    if(isset($condition['info_resource']) && !empty($condition['info_resource'])){
      $where.=" and h.info_resource='".str_replace("'", "", trim($condition['info_resource']))."'";
    }
    return $where;
  }
  //房源审核不通过
  public function examineResourceFail($resource_id,$exam_content){
      $modelDal=new \Home\Model\houseroom();
     return $modelDal->examineResourceFail($resource_id,$exam_content);
  }
  /*房东手机号下面的房源数量*/
  public function getHouseCountByClientPhone($client_phone){
    $modelDal=new \Home\Model\houseresource();
     return $modelDal->getHouseCountByClientPhone($client_phone);
  }
}
?>
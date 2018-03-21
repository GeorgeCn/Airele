<?php
namespace Logic;
class HouseRoomrobLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->updateModel($data);
     return $result;
   }
    //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->deleteModelById($id);
     return $result;
   }
   public function deleteModelByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->deleteModelByResourceId($resource_id);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseroomrob();
     return $modelDal->getModelById($id);
   }
   public function getModelByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroomrob();
     return $modelDal->getModelByResourceId($resource_id);
   }
     //根据房源ID查询房间列表
   public function getModelListByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getModelListByResourceId($resourceId);
     return $result;
   }
    //所有房间的查询列表
   public function getModelList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getModelList($conditionString,$limit_start,$limit_end);
     return $result;
   }
   public function getDownloadList($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getDownloadList($conditionString);
     return $result;
   }
    //列表总？条数
   public function getModelListCount($condition){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getModelListCount($conditionString);
     return $result;
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
     if(trim($condition['estateName'])!=''){
        $conditionString.=" and h.estate_name like '%".str_replace("'", "", trim($condition['estateName']))."%' ";
     }
     if(trim($condition['roomStatus'])!=''){
        $conditionString.=" and r.status=".trim($condition['roomStatus']);
     }
     if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
     }
     if(trim($condition['business_type'])!=''){
        $conditionString.=" and h.business_type='".trim($condition['business_type'])."' ";
     }
     if(trim($condition['clientPhone'])!=''){
        $conditionString.=" and h.client_phone='".str_replace("'", "", trim($condition['clientPhone']))."' ";
     }
     if(trim($condition['create_man'])!=''){
        $conditionString.=" and r.create_man='".str_replace("'", "", trim($condition['create_man']))."' ";
     }
     if(trim($condition['info_resource'])!=''){
        if($condition['info_resource']=="空"){
          $conditionString.=" and h.info_resource='' ";
        }else{
          $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
        }
     }
     if(trim($condition['brand_type'])!=''){
        $conditionString.=" and h.brand_type='".trim($condition['brand_type'])."' ";
     }
     if(trim($condition['region'])!=''){
        $conditionString.=" and h.region_id='".trim($condition['region'])."' ";
     }
     if(trim($condition['scope'])!=''){
        $conditionString.=" and h.scope_id='".trim($condition['scope'])."' ";
     }
     return $conditionString;
  }
  /* //获得房间配置参数
  public function getRoomParameters(){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getRoomParameters();
     return $result;
  }*/
  /*生成房间编号*/
  public function createRoomno()
  {
    $no=date("Ymd",time())."03".rand(10000, 99999);
    $dal=new \Home\Model\houseroomrob();
    $count=$dal->getCountByRoomno($no);
    if($count>=1)
    {
      return $this->createRoomno();
    }
    else
    {
      return $no;
    }
  }
  //查询新增房间列表
  public function getAddRoomListByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getAddRoomListByResourceId($resourceId);
     return $result;
  }
  //查询房源下的最大房间序号
  public function getMaxRoomIndexByResourceId($resourceId){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getMaxRoomIndexByResourceId($resourceId);
     return $result;
  }
  //根据room_id查询房源信息
  public function getResourceInfoByRoomid($room_id){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getResourceInfoByRoomid($room_id);
     return $result;
  }
  public function getRoomIdsByResourceId($resource_id){
     $modelDal=new \Home\Model\houseroomrob();
     $result = $modelDal->getRoomIdsByResourceId($resource_id);
     return $result;
  }
  //更新房间负责人 by 房源ID 
  public function updateCreatemanByResourceid($resourceId,$create_man){
     $modelDal=new \Home\Model\houseroomrob();
     return $modelDal->updateCreatemanByResourceid($resourceId,$create_man);
  }
  /*置顶房间*/
  public function getTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->getTopRoomById($room_id);
  }
  public function getTopRoomByRoomno($room_no){
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->getTopRoomByRoomno($room_no);
  }
  public function setTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->setTopRoomById($room_id);
  }
  public function cancelTopRoomById($room_id){
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->cancelTopRoomById($room_id); 
  }
  //置顶列表
  public function getTopRoomCount($condition){
    $conditionString='';
    if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
    }
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->getTopRoomCount($conditionString);
  }
  public function getTopRoomList($condition,$limit_start,$limit_end){
    $conditionString='';
    if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
    }
    $modelDal=new \Home\Model\houseroomrob();
    return $modelDal->getTopRoomList($conditionString,$limit_start,$limit_end);
  }
  public function modifyTopRoomSort($room_id,$sort_index){
     $modelDal=new \Home\Model\houseroomrob();
     return $modelDal->modifyTopRoomSort($room_id,$sort_index);
  }
  public function updateTopRoomSorts($sort_index){
     $modelDal=new \Home\Model\houseroomrob();
     return $modelDal->updateTopRoomSorts($sort_index);
  }
}
?>
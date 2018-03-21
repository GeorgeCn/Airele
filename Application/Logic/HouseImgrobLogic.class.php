<?php
namespace Logic;
class HouseImgrobLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->updateModel($data);
     return $result;
   }
   //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->deleteModelById($id);
     return $result;
   }
   public function deleteModelByRoomId($room_id){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->deleteModelByRoomId($room_id);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->getModelById($id);
     return $result;
   }
   //根据房源ID查询
   public function getModelByResourceId($resourceId){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->getModelByResourceId($resourceId);
     return $result;
   }
   //根据房间ID查询
   public function getModelByRoomId($roomId){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->getModelByRoomId($roomId);
     return $result;
   }
   //更新房间图片房源ID
   public function updateHouseidByRoomIds($house_id,$room_ids){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->updateHouseidByRoomIds($house_id,$room_ids);
     return $result;
   }
    //切换主图
   public function updateSortindexByid($id,$room_id){
     $modelDal=new \Home\Model\houseimgrob();
     $result = $modelDal->updateSortindexByid($id,$room_id);
     return $result;
   }
}
?>
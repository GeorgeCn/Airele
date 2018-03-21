<?php
namespace Logic;
class HouseImgLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->updateModel($data);
     return $result;
   }
   //逻辑删除
   public function deleteModelById($id){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->deleteModelById($id);
     return $result;
   }
   public function deleteModelByRoomId($room_id){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->deleteModelByRoomId($room_id);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->getModelById($id);
     return $result;
   }
   //根据房源ID查询
   public function getModelByResourceId($resourceId){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->getModelByResourceId($resourceId);
     return $result;
   }
   //根据房间ID查询
   public function getModelByRoomId($roomId){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->getModelByRoomId($roomId);
     return $result;
   }
   //查询房间下面的图片数量
   public function getImgCountByRoomId($roomId){
     $modelDal=new \Home\Model\houseimg();
     return $modelDal->getImgCountByRoomId($roomId);
   }
   //更新房间图片房源ID
   public function updateHouseidByRoomIds($house_id,$room_ids){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->updateHouseidByRoomIds($house_id,$room_ids);
     return $result;
   }
    //切换主图
   public function updateSortindexByid($id,$room_id){
     $modelDal=new \Home\Model\houseimg();
     $result = $modelDal->updateSortindexByid($id,$room_id);
     return $result;
   }
   public function updateMainimg($id){
     $modelDal=new \Home\Model\houseimg();
     return $modelDal->updateMainimg($id);
   }
}
?>
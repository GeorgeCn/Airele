<?php
namespace Logic;
class HouseRoomRenterrobLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseroomrenterrob();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseroomrenterrob();
     $result = $modelDal->updateModel($data);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseroomrenterrob();
     $result = $modelDal->getModelById($id);
     return $result;
   }
   //根据房间ID查询当前租客信息
   public function getModelByRoomId($roomId){
     $modelDal=new \Home\Model\houseroomrenterrob();
     $result = $modelDal->getModelByRoomId($roomId);
     return $result;
   }
   //房间重新出租，解绑租客信息
   public function updateStatusByRoomId($roomId){
     $modelDal=new \Home\Model\houseroomrenterrob();
     $result = $modelDal->updateStatusByRoomId($roomId);
     return $result;
   }
 
}
?>
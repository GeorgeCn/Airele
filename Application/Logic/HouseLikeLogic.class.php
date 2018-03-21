<?php
namespace Logic;
class HouseLikeLogic{
   //更新（收藏房源）
   public function updateModelByRoomid($data){
     	$modelDal=new \Home\Model\houselike();
     	return $modelDal->updateModelByRoomid($data);
   }
   public function updateModelByResourceid($data){
      $modelDal=new \Home\Model\houselike();
      return $modelDal->updateModelByResourceid($data);
   }
   //更新（看房日程）
   public function updateReserveByRoomid($data){
     	$modelDal=new \Home\Model\houselike();
     	return $modelDal->updateReserveByRoomid($data);
   }
   public function updateReserveByResourceid($data){
      $modelDal=new \Home\Model\houselike();
      return $modelDal->updateReserveByResourceid($data);
   }
}
?>
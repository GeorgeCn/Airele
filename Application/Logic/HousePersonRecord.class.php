<?php
namespace Logic;
class HousePersonRecord{
  
    //查询
   public function getRecordByResourceid($resource_id){
      $modelDal=new \Home\Model\housepersonrecord();
      return $modelDal->getRecordByResourceid($resource_id);
   }
   //新增
   public function addModel($data){
      $modelDal=new \Home\Model\housepersonrecord();
      return $modelDal->addModel($data);
   }
}
?>
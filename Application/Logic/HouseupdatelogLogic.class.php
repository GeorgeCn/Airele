<?php
namespace Logic;
class HouseupdatelogLogic{
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseupdatelog();
     return $modelDal->addModel($data);
   }
   //查询
   public function getListByHouseId($house_id,$house_type){
     $modelDal=new \Home\Model\houseupdatelog();
     return $modelDal->getListByHouseId($house_id,$house_type);
   }
}
?>
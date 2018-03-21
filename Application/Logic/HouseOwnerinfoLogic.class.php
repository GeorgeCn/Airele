<?php
namespace Logic;
class HouseOwnerinfoLogic{
	
   //新增
   public function addModel($data){
     $modelDal=new \Home\Model\houseownerinfo();
     $result = $modelDal->addModel($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $modelDal=new \Home\Model\houseownerinfo();
     $result = $modelDal->updateModel($data);
     return $result;
   }
   //查询
   public function getModelById($id){
     $modelDal=new \Home\Model\houseownerinfo();
     $result = $modelDal->getModelById($id);
     return $result;
   }
   public function getModelByCustomerId($customerId){
     $modelDal=new \Home\Model\houseownerinfo();
     $result = $modelDal->getModelByCustomerId($customerId);
     return $result;
   }
 
}
?>
<?php
namespace Logic;
class ParamSetLogic{
   /*首页入口设置 */
   public function addappindex($data){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->addModel($data);
   }
   public function deleteappindex($id){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->deleteModel($id);
   }
   public function updateappindex($data){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->updateModel($data);
   }
   public function getappindexlist($where){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->getList($where);
   }
   
   public function modelfind($where){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->modelfind($where);
   }
   public function deleteAppindexBymid($where){
     $modelDal=new \Home\Model\appindex();
     return $modelDal->deleteAppindexBymid($where);
   }
}

?>
<?php
namespace Logic;
use Think\Controller;
class ServiceOrderStatus extends Controller{
    public function modelServiceFind($where){
        $modelDal=new \Home\Model\serviceorderstatus();
        $result=$modelDal->modelServiceFind($where);
        return $result;  
    }
    public function modelServiceAdd($data){
        $modelDal=new \Home\Model\serviceorderstatus();
        $result=$modelDal->modelServiceAdd($data);
        return $result; 
    }
}
?>
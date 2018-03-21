<?php
namespace Logic;
use Think\Controller;
class ServiceInfo extends Controller{
    public function modelServiceFind($where){
        $modelDal=new \Home\Model\serviceinfo();
        $result=$modelDal->modelServiceFind($where);
        return $result;  
    }
 
}
?>
<?php
namespace Logic;
use Think\Controller;
class ServiceOptions extends Controller{
    public function modelServiceFind($where){
        $modelDal=new \Home\Model\serviceoptions();
        $result=$modelDal->modelServiceFind($where);
        return $result;  
    }
 
}
?>
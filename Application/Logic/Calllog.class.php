<?php
namespace Logic;
use Think\Controller;
class Calllog extends Controller{
	 public function modelGetFind($where){
    	$modelDal=new \Home\Model\calllog();
    	$result=$modelDal->modelGetFind($where);
    	return $result;
    }

    public function modelUpdate($data){
    	$modelDal=new \Home\Model\calllog();
    	$result=$modelDal->modelUpdate($data);
    	return $result;
    }
    
    public function modelVirtualFind($where){
        $modelDal=new \Home\Model\calllog();
        $result=$modelDal->modelVirtualFind($where);
        return $result;
    }

    public function modelVirtualUpdate($data){
        $modelDal=new \Home\Model\calllog();
        $result=$modelDal->modelVirtualUpdate($data);
        return $result;
    }
}
?>
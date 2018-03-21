<?php
namespace Logic;
use Think\Controller;
class AdminCityLogin extends Controller{
	//加入管家统计
    public function modelGet($where){
    	$modelDal=new \Home\Model\admincity();
    	$result=$modelDal->modelGet($where);
    	return $result;
    }

      public function modelFind($where){
    	$modelDal=new \Home\Model\admincity();
    	$result=$modelDal->modelFind($where);
    	return $result;
    }
}
?>
<?php
namespace Logic;
use Think\Controller;
class AdminLogin extends Controller{
	//加入管家统计
    public function AdminLogin($name,$pwd){
    	$modelDal=new \Home\Model\adminlogin();
    	$result=$modelDal->modelAdminLogin($name,$pwd);
    	return $result;
    }

      public function modelAdminFind($where){
    	$modelDal=new \Home\Model\adminlogin();
    	$result=$modelDal->modelAdminFind($where);
    	return $result;
    }
}
?>
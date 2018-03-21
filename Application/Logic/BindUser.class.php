<?php
namespace Logic;
use Think\Controller;
class BindUser{
     public function getBindUserCount($where){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelBindUserCount($where);
        return $result;
    }
	//活动信息列表
	 public function getBindUserList($firstRow,$listRows,$where){
    	$modelDal=new \Home\Model\binduser();
    	$result=$modelDal->modelBindUserList($firstRow,$listRows,$where);
    	return $result;
    }
     //活动用户
    public function getAccounts($where){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelAccounts($where);
        return $result;
    }
    //活动信息列表
    public function getCoupon($where){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelCoupon($where);
        return $result;
    }
    public function getBindUser($where){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelBindUser($where);
        return $result;
    }
    public function upBindUser($data){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelUpBindUser($data);
        return $result;
    }

    //删除优惠用户
    public function delBindUser($where){
    	$modelDal=new \Home\Model\binduser();
    	$result=$modelDal->modeldelBindUser($where);
    	return $result;
    }
    public function getCouponList(){
        $modelDal=new \Home\Model\binduser();
        $result=$modelDal->modelCouponList();
        return $result;
    }

}
?>
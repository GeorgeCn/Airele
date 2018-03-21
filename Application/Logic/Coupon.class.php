<?php
namespace Logic;
use Think\Controller;
class Coupon extends Controller{
	 //获取优惠订单
	 public function GetcOrdersCoupon($order_id){
    	$modelDal=new \Home\Model\coupon();
    	$result=$modelDal->modelGetcOrdersCoupon($order_id);
    	return $result;
    }
     //获取优惠用户
     public function GetCustomerAccounts($customer_id){
    	$modelDal=new \Home\Model\coupon();
    	$result=$modelDal->modelGetCustomerAccounts($customer_id);
    	return $result;
    }
    //修改优惠状态
     public function UpOrdersCoupon($order_id){
    	$modelDal=new \Home\Model\coupon();
    	$result=$modelDal->modelUpOrdersCoupon($order_id);
    	return $result;
    }
     //修改用户优惠金额
     public function UpCustomerAccounts($where){
    	$modelDal=new \Home\Model\coupon();
    	$result=$modelDal->modelUpCustomerAccounts($where);
    	return $result;
    }
}
?>
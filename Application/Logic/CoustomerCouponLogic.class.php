<?php
namespace Logic;
use Think\Controller;
class CoustomerCouponLogic extends Controller{
   
    public function CustomerCouponFind($where){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelCustomerCoupon($where);
        return $result;
    }

    public function AddCustomerCoupon($data){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelAddCustomerCoupon($data);
        return $result; 
    }

     public function GetCustomerCoupon($where){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelGetCustomerCoupon($where);
        return $result; 
    }
    public function GetCustomerCouponCount($where){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelCustomerCouponCount($where);
        return $result; 
    }
      public function GetCustomerCouponList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelCustomerCouponList($firstrow,$listrows,$where);
        return $result; 
    }
     public function modelUpdate($data){
        $modelDal=new \Home\Model\customercoupon();
        $result=$modelDal->modelUpdate($data);
        return $result; 
    }
    
}
?>
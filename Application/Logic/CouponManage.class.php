<?php
namespace Logic;
use Think\Controller;
class CouponManage{
	//活动信息列表
	 public function getCouponManageList($where,$firstRow,$listRows){
    	$modelDal=new \Home\Model\couponmanage();
    	$result=$modelDal->modelCouponManageList($where,$firstRow,$listRows);
    	return $result;
    }

    public function getCouponManageCount($where){
        $modelDal=new \Home\Model\couponmanage();
        $result=$modelDal->modelCouponManageCount($where);
        return $result;
    }

    public function getCouponManage($where){
    	$modelDal=new \Home\Model\couponmanage();
    	$result=$modelDal->modelCouponManage($where);
    	return $result;
    }
    //添加活动
    public function addCouponManage($data){
    	$modelDal=new \Home\Model\couponmanage();
    	$result=$modelDal->modelAddCouponManage($data);
    	return $result;
    }
    //删除活动
    public function delCouponManage($where){
    	$modelDal=new \Home\Model\couponmanage();
    	$result=$modelDal->modeldelCouponManage($where);
    	return $result;
    }
    //修改活动
    public function upCouponManage($data){
    	$modelDal=new \Home\Model\couponmanage();
    	$result=$modelDal->modelUpCouponManage($data);
    	return $result;
    }
    public function getCouponCount($activity_id){
        $modelDal=new \Home\Model\couponmanage();
        $result=$modelDal->modelCouponCount($activity_id);
        return $result;
    }
     public function getCouponEmployCount($activity_id){
        $modelDal=new \Home\Model\couponmanage();
        $result=$modelDal->modelCouponEmployCount($activity_id);
        return $result;
    }

    public function getCacheCouponManage($num){
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'cache_coupon_manage'.$num);
          if(empty($result)){ 
               $result=$this->getCouponManage($num);
               set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'cache_coupon_manage'.$num,$result,10000);
          }
          return $result;
    }
    public function getModelFind($where){
        $modelDal=new \Home\Model\couponmanage();
        $result=$modelDal->modelGetFind($where);
        return $result;
    }

}
?>
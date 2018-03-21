<?php
namespace Home\Controller;
use Think\Controller;
class CouponController extends Controller {

    public function couponlist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }

        $city_code=I('get.citycode');
        if($city_code!=""){
          $where['city_code']=array('eq',$city_code);
        }
        $modelreceivecoupon=new \Home\Model\receivecoupon();
        $list=$modelreceivecoupon->modelSelect($where);
    	$this->assign("list",$list);
		$this->display();
    }
    //免费搬家
    public function movehouselist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $modelmovehouse=new \Home\Model\movehouse();
        if(I('get.citycode')!=""){
             $where['city_code']=I('get.citycode');
        }
        if(I('get.platform')!=""){
            $where['gaodu_platform']=I('get.platform');
        }
        $list=$modelmovehouse->modelSelect($where);
        $this->assign("list",$list);
        $this->display();
    }
}
?>
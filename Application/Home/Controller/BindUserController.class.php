<?php
namespace Home\Controller;
use Think\Controller;
class BindUserController extends Controller {
	//用户列表
  public function couponUserList(){
   	   $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
     $handleMenu = new\Logic\AdminMenuListLimit();
     $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),77);
     $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),77);
      $handleMenu->jurisdiction();
     $mobile=$_POST['mobile'];
     $where['customeraccounts.record_status']=array('eq',1);
     if($mobile!=""){
           $where['customer.mobile']=array('eq',$mobile);
     }
     $handleBindUser = new \Logic\BindUser();
     $count=$handleBindUser->getBindUserCount($where);
     $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val) {
          $Page->parameter[$key]=urlencode($val);
      }
 	   $couponlist=$handleBindUser->getBindUserList($Page->firstRow,$Page->listRows,$where);
   	 $this->assign("show",$Page->show());
     $this->assign("pagecount",$count);
     $this->assign("list",$couponlist);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }

   //绑定活动
   public function bindCoupon(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),77);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),77);
      $where['customer_id']=$_GET['paid'];
      $handleBindUser = new \Logic\BindUser();
      $accountsarr=$handleBindUser->getAccounts($where);
      $cuid['id']=$accountsarr['code_type'];
      $couponarr=$handleBindUser->getCoupon($cuid);
      if($couponarr['end_date']>time()){
         $this->success('已有未结束活动',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
      }else{
         $endtime['end_date']=array('gt',time());
         $rearr=$handleBindUser->getCouponList($endtime);
         $userarr=$handleBindUser->getAccounts($where);
         $couponlist=$handleBindUser->getBindUserList();
         $this->assign("userarr",$userarr);
         $this->assign("relist",$rearr);
         $this->assign("list",$couponlist);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display("couponUserList");
      }
   }
   public function subBindCoupon(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
       $coupon=$_POST['coupon'];
       $code_id=$_POST['code_id'];
       $customer_id=$_POST['customer_id'];
       $handleBindUser = new \Logic\BindUser();
       $where['customer_code']=$coupon;
       $recoupon=$handleBindUser->getAccounts($where);
       if($recoupon['customer_id']!=$customer_id){
          $this->success('优惠码已存在！',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
       }else{
          $code['customer_id']=$customer_id;
          $accouts=$handleBindUser->getAccounts($code);
          $accouts['customer_code']=$coupon;
          $accouts['code_type']=$code_id;
          $result=$handleBindUser->upBindUser($accouts);
          if($result){
            $this->success('修改成功！',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
          }else{
            $this->success('修改失败！',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
          }
       }
   }

   //删除
   public function delCoupon(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $deid=$_GET['deid'];
      $handleBindUser = new \Logic\BindUser();
      $result=$handleBindUser->delBindUser($deid);
      if($result){
         $this->success('删除成功！',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
       }else{
         $this->success('删除失败！',U('BindUser/couponUserList',array('no'=>1,'leftno'=>43)),0);
       }
   }
} 
?>
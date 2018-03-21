<?php
namespace Home\Controller;
use Think\Controller;
class PullCouponController extends Controller {
	//活动信息列表
   public function pulllist(){
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
     $handleCouponManage = new \Logic\CouponManage();
     $where['record_status']=1;
    if(I('get.coupon_type')!=""){
         $where['coupon_type']=I('get.coupon_type');
     }
     if(I('get.name')!=""){
         $where['name']=array('like','%'.I('get.name').'%');
     }
     if(I('get.hdid')!=""){
         $where['id']=I('get.hdid');
     }
     if(I('get.total_count')!=""){
        $where['total_count']=I('get.total_count');
     }
     if(I('get.price')!=""){
        $where['price']=I('get.price');
     }
     if(I('get.owner_mobile')!=""){
        $where['relation_id']=I('get.owner_mobile');
     }
     $count=$handleCouponManage->getCouponManageCount($where);
      $Page= new \Think\Page($count,20);         
       // foreach($where as $key=>$val){
       //      $Page->parameter[$key]=urlencode($val); 
       // }
 	   $couponlist=$handleCouponManage->getCouponManageList($where,$Page->firstRow,$Page->listRows);

     $this->assign("show",$Page->show());
     $this->assign("pagecount",$count);
 	   $this->assign("list",$couponlist);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }
   //领取详细
   public function pulldetail(){
   	  $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
     $switchcity=$handleCommonCache->cityauthority();
     $this->assign("switchcity",$switchcity);
     $handleMenu = new \Logic\AdminMenuListLimit();
     $handleCoustomerCoupon = new \Logic\CoustomerCouponLogic();
     $handleCustomer = new \Logic\CustomerLogic();
     $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),77);
     $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),77);
     $where['activity_id']=$_GET['delid'];
     $where['record_status']=1;
     $count=$handleCoustomerCoupon->GetCustomerCouponCount($where);
       $Page= new \Think\Page($count,20);         
       foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val); 
       }
    $listarr=$handleCoustomerCoupon->GetCustomerCouponList($Page->firstRow,$Page->listRows,$where);
     foreach ($listarr as $key => $value){
        $customer=$handleCustomer->getModelById($value['customer_id']);
        $value['true_name']=$customer['true_name'];
        $value['mobile']=$customer['mobile'];
        $list[]=$value;
     }
     $this->assign("list",$list);
     $this->assign("pagecount",$count);
     $this->assign("show",$Page->show());
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }

   public function getCouponCount(){
       $handleCouponManage = new \Logic\CouponManage();
       $result=$handleCouponManage->getCouponCount($_GET['activity_id']);
       $resultarr=array('activity_id' =>$_GET['activity_id'],'count'=>$result);
       echo json_encode($resultarr);
   }
   //优惠劵使用总数
  public function getCouponEmployCount(){
       $handleCouponManage = new \Logic\CouponManage();
       $result=$handleCouponManage->getCouponEmployCount($_GET['activity_id']);
       $resultarr=array('activity_id' =>$_GET['activity_id'],'count'=>$result);
       echo json_encode($resultarr);
   }
}
?>
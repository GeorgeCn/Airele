<?php
namespace Home\Controller;
use Think\Controller;
class CouponOrdinaryController extends Controller {
	//活动信息列表
   public function couponList(){
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
     $where['coupon_type']=array('eq',1);
     if(I('get.coupon_type')!=""){
         $where['coupon_type']=I('get.coupon_type');
     }
     if(I('get.name')!=""){
         $where['name']=I('get.name');
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
 	   $couponlist=$handleCouponManage->getCouponManageList($where,$Page->firstRow,$Page->listRows);
     $this->assign("show",$Page->show());
     $this->assign("pagecount",$count);
 	   $this->assign("list",$couponlist);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }
   //新增活动
   public function addCouponManage(){
   	   $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $data['id']=I('post.hdid');
      $data['name']=I('post.cname');
      $data['start_date']=strtotime(I('post.startTime'));
      $data['end_date']=strtotime(I('post.endTime'))+86399;
      $data['price']=I('post.cmoney');
      $data['effective_type']=I('post.typestatus');
      $times=strtotime(I('post.times'))+86399;
      $days=I('post.days');
      $data['coupon_type']=1;
      $data['total_count']=I('post.total_count');
      $data['create_time']=time();
       if($data['effective_type']==0){
      	$data['effective_date']=$times;	
      }elseif($data['effective_type']==1){
      	$data['effective_date']=$days;
      }
      $data['limit_txt']=I('post.limit_txt');
      $data['use_type']=I('post.dj');
      $handleCouponManage = new \Logic\CouponManage();
      $recoup=$handleCouponManage->getCouponManage($data['id']);
      if($recoup){
      	 $this->success('活动编号已存在！','addnewtemp.html?no=1&leftno=42');
      }else{
		     $result=$handleCouponManage->addCouponManage($data);
	   	   if($result){
	       	 $this->success('提交成功！','couponList.html?no=77&leftno=83');
	       }else{
	       	 $this->success('提交失败！','couponList.html?no=77&leftno=83');
	       }
	    }
   }

   //修改活动
   public function upCouponManage(){
   	 $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $data['id']=I('post.hdid');
      $data['name']=I('post.cname');
      $data['start_date']=strtotime(I('post.startTime'));
      $data['end_date']=strtotime(I('post.endTime'))+86399;
      $data['price']=I('post.cmoney');
      $data['effective_type']=I('post.typestatus');
      $times=strtotime(I('post.times'))+86399;
      $days=I('post.days');
      $data['coupon_type']=1;
      $data['total_count']=I('post.total_count');
       if($data['effective_type']==0){
        $data['effective_date']=$times; 
      }elseif($data['effective_type']==1){
        $data['effective_date']=$days;
      }
      $data['limit_txt']=I('post.limit_txt');
      $data['use_type']=I('post.dj');
      if(I('post.hdid')>999){
          $handleCouponManage = new \Logic\CouponManage();
          $result=$handleCouponManage->upCouponManage($data);
          if($result){
              $this->success('修改成功！','couponList.html?no=77&leftno=83');
           }else{
               $this->success('修改失败！','couponList.html?no=77&leftno=83');
         }
      }
    }
    //删除活动
   public function delCouponManage(){
	   $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $id=$_GET['delid'];
      $handleCouponManage = new \Logic\CouponManage();
      if($id>999){
          $result=$handleCouponManage->delCouponManage($id);
          if($result){
          	 $this->success('删除成功！','couponList.html?no=77&leftno=83');
          }else{
          	 $this->success('删除失败！','couponList.html?no=77&leftno=83');
          }
      }

   }
   public function getCouponCount(){
       $handleCouponManage = new \Logic\CouponManage();
       $result=$handleCouponManage->getCouponCount($_GET['activity_id']);
       $resultarr=array('activity_id' =>$_GET['activity_id'],'count'=>$result);
       echo json_encode($resultarr);
   }

   public function addnewtemp(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new\Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),77);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),77);
       
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $this->display();
   }
   public function upnewtemp(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new\Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),77);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),77);
       $handleCouponManage = new \Logic\CouponManage();
       $result=$handleCouponManage->getCouponManage(I('get.upid'));
       $this->assign("uparr",$result);
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $this->display();

   }
}
?>
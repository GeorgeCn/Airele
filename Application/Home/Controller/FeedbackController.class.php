<?php
namespace Home\Controller;
use Think\Controller;
class FeedbackController extends Controller{

   public function feedbacklist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
       $handleMenu->jurisdiction();
      $handleFeedback = new \Logic\Feedback();
       $startTime=strtotime(I('get.startTime'));
       $endTime=strtotime(I('get.endTime'));
      $platform=I('get.platform');
      $cityid=I('get.cityid');
      $where['record_status']=array('eq',1);
      if($startTime!=""&&$endTime==""){
          $where['create_time']=array('gt',$startTime);
      }
         if($endTime!=""&&$startTime==""){
             $where['create_time']=array('lt',$endTime+86400);
         }
         if($startTime!=""&&$endTime!=""){
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }

        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($platform!=""){
         $where['gaodu_platform']=array('eq',$platform);
      }
      if($cityid!=""){
         $where['city_code']=array('eq',$cityid);
      }
      $count=$handleFeedback->modelFeedbackCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
           $Page->parameter[$key]=urlencode($val);
      }
      $list=$handleFeedback->modelFeedbackList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }

   public function getcustomer(){
      $handleCustomer = new \Logic\CustomerLogic();
      $result=$handleCustomer->getModelById(I('get.customer_id'));
      echo json_encode($result);
   
   }
}
?>
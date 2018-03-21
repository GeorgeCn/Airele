<?php
namespace Home\Controller;
use Think\Controller;
class SmssendController extends Controller {
    //验证码列表
    public function smssendlist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
      $handleMenu->jurisdiction();
      $mobile=I('get.mobile');
      if($mobile!=""){
            $where['mobile']=array('eq',$mobile);
      }
       $where['record_status']=array('eq',1);
       $where['send_type']=array('eq',1);
       $where['status']=array('eq',1);
      $handleSmssendLogic = new \Logic\SmssendLogic();
      $count=$handleSmssendLogic->modelSmssendCount($where);
      $Page= new \Think\Page($count,15);
      $list=$handleSmssendLogic->modelSmssendList($where,$Page->firstRow,$Page->listRows);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$list);
		  $this->display();
    }
}
?>
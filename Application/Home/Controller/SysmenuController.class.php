<?php
namespace Home\Controller;
use Think\Controller;
class SysmenuController extends Controller {
    //
    public function sysmenuList(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
       $handleMenu->jurisdiction();
      $level_id=$_GET['level_id'];
      $handleSysmenu = new \Logic\Sysmenu();
      $list=$handleSysmenu->getCacheSysmenuList($level_id);
      $this->assign("list",$list);
      $this->assign("mid",$level_id);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
    }
    //增加菜单
    public function addSysmenu(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         } 
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
          $handleMenu = new\Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
          $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         if($_POST['addtype']=="add"){
            $data['name']=$_POST['mname'];
            $data['url']=$_POST['murl'];
            $data['parent_id']=$_POST['parent_id'];
            $data['create_time']=time();
            $data['record_status']=1;
            $data['index_no']=$_POST['index_no'];
            $handleSysmenu = new \Logic\Sysmenu();
            $result=$handleSysmenu->addSysmenu($data);
            if($result){
                $this->success('提交成功！',U('Sysmenu/sysmenuList'),0);
            }else{
                $this->success('提交失败！',U('Sysmenu/sysmenuList'),0);
            }
         }
         if($_POST['uptype']=="up"){
            $data['id']=$_POST['id'];
            $data['name']=$_POST['mname'];
            $data['url']=$_POST['murl'];
            $data['parent_id']=$_POST['parent_id'];
            $data['record_status']=1;
            $data['index_no']=$_POST['index_no'];
            $handleSysmenu = new \Logic\Sysmenu();
            $result=$handleSysmenu->upSysmenuMenu($data);
            if($result){
                $this->success('修改成功！',U('Sysmenu/sysmenuList'),0);
            }else{
                $this->success('修改失败！',U('Sysmenu/sysmenuList'),0);
            }
         }
       if($_GET['type']=='add'){
          $handleSysmenu = new \Logic\Sysmenu();
          $level_id=$_GET['mid'];
          $list=$handleSysmenu->getSysmenuMenuList($level_id);
          $this->assign("list",$list);
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->display();
        }
    }
    //修改菜单
    public function upSysmenu(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
           $handleMenu = new\Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
          $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
          $handleSysmenu = new \Logic\Sysmenu();
          $upid=$_GET['upid'];
          $mid=$_GET['mid'];
          $list=$handleSysmenu->getPreviousMenu($mid);
          
          $resultup=$handleSysmenu->getSysmenuMenu($upid);
          $this->assign("list",$list);
          $this->assign("updata",$resultup);
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->display();
    }
    //删除菜单
    public function delSysmenu(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
        }
        $del_id=$_GET['delid'];
        $handleSysmenu = new \Logic\Sysmenu();
        $result=$handleSysmenu->delSysmenuMenu($del_id);
        if($result){
            $this->success('删除成功！',U('Sysmenu/sysmenuList'),0);
        }else{
            $this->success('删除失败！',U('Sysmenu/sysmenuList'),0);
        }
    }
}
?> 
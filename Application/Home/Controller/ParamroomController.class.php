<?php
namespace Home\Controller;
use Think\Controller;
class ParamroomController extends Controller {
    //房源参数列表
    public function paramRoomList(){
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
        $keyword=I('get.keyword');
        $handleParamroom = new \Logic\Paramroom();
        $list=$handleParamroom->getCacheSysmenuList($keyword);
    	$this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }

    //房间参数提交
    public function addParamRoom(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         if(I('post.type')==1){
             $data['id']=I('post.upid');
            // $data['type_no']=$_POST['type_no'];
             $data['info_type']=I('post.info_type');
             $data['name']=I('post.name');
             $data['index_no']=I('post.index_no');
             $data['is_display']=I('post.is_display');
             $handleParamroom=new \Logic\Paramroom();
             $result=$handleParamroom->upParamRoom($data);
             if($result){
                 $this->success('修改成功！',"paramRoomList.html?no=1&leftno=23");
             }else{
                 $this->success('未修改任何数据！',"paramRoomList.html?no=1&leftno=23");
             }
         }else{
             $data['id']=create_guid();
             $data['type_no']=I('post.type_no');
             $data['info_type']=I('post.info_type');
             $data['name']=I('post.name');
             $data['index_no']=I('post.index_no');
             $data['is_display']=I('post.is_display');
             $data['create_time']=time();
             $handleParamhouse=new \Logic\Paramhouse();
             $where['type_no']=$data['type_no'];
             $selresult=$handleParamhouse->SelectTypeNo($where);
             if($selresult){
                $this->success('类型编号不能重复！',"paramRoomList.html?no=1&leftno=23");
             }else{
                 $result=$handleParamhouse->addParamHouse($data);
                 if($result){
                    $this->success('提交成功！',"paramRoomList.html?no=1&leftno=23");
                 }
             }
         }
    }
    //修改房源参数
     public function upParamRoom(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $paid=$_GET['paid'];
         $handleParamroom = new \Logic\Paramroom();
         $infotypearr=$handleParamroom->getParamRoom($paid);
         $this->assign("infotypearr",$infotypearr);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display('upParamRoom');
     }

     //删除房源参数
     public function delParamRoom(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $paid=$_GET['paid'];
         $handleParamroom=new \Logic\Paramroom();
         $result=$handleParamroom->delParamRoom($paid);
         if($result){
             $this->success('删除成功！',"paramRoomList.html?no=1&leftno=23");
         }
     }

     public function addroomtemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");

         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
     }
}
?>
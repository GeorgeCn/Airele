<?php
namespace Home\Controller;
use Think\Controller;
class ParamhouseController extends Controller {
    //房源参数列表
    public function paramHouseList(){
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
        $keyword=$_GET['keyword'];
        $handleParamhouse = new \Logic\Paramhouse();
        $list=$handleParamhouse->getParamHouseList($keyword);
    	$this->assign("list",$list);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }

    //房源参数提交
    public function addParamHouse(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         if(I('post.type')=="1"){
             $data['id']=I('post.upid');
            //$data['type_no']=I('post.type_no');
             $data['info_type']=I('post.info_type');
             $data['name']=I('post.name');
             $data['index_no']=I('post.index_no');
             $data['is_display']=I('post.is_display');
             $handleParamhouse=new \Logic\Paramhouse();
             $result=$handleParamhouse->upParamHouse($data);
             if($result){
                 $this->success('修改成功！',"paramHouseList.html?no=1&leftno=22");
              }else{
                $this->success('未修改任何数据！',"paramHouseList.html?no=1&leftno=22");
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
             $where['record_status']=1;
             $selresult=$handleParamhouse->SelectTypeNo($where);
             if($selresult){
                 $this->success('类型编号不能重复！',"paramHouseList.html?no=1&leftno=22");
             }else{
                 $result=$handleParamhouse->addParamHouse($data);
                 if($result){
                    $this->success('提交成功！',"paramHouseList.html?no=1&leftno=22");
                 }
             }
         }
        
    }
    //修改房源参数
     public function upParamHouse(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $paid=I('get.paid');
         $type=I('get.type');
         $handleParamhouse = new \Logic\Paramhouse();
         $infotypearr=$handleParamhouse->getParamHouse($paid);
         $this->assign("infotypearr",$infotypearr);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display('updatehouse');
     }

     //删除房源参数
     public function delParamHouse(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $paid=$_GET['paid'];
         $handleParamhouse=new \Logic\Paramhouse();
         $result=$handleParamhouse->delParamHouse($paid);
         if($result){
             $this->success('删除成功！',U('Paramhouse/paramHouseList'),0);
         }
     }

     public function addhousetemp(){
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
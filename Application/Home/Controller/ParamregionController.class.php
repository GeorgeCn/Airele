<?php
namespace Home\Controller;
use Think\Controller;
class ParamregionController extends Controller {
    //房源参数列表
    public function paramRegionList(){
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
       $region_id=$_GET['region_id'];
       if($region_id!=""){
         $condition['parent_id']=$region_id;
       }else{
         $condition['parent_id']=0;
       }
       $handleParamregion = new \Logic\Paramregion();
        $list=$handleParamregion->getParamRegionList($condition);
        $region_list=$handleParamregion->getParamRegionList();
      	$this->assign("list",$list);
        $this->assign("region_list",$region_list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		    $this->display();
    }

    //房源参数提交
    public function addParamRegion(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $handleParamregion=new \Logic\Paramregion();
         $type=I('post.type');
         $region_id=I('post.region_id');
         if($type=="update"){
               $data['id']=$region_id;
               $data['cname']=I('post.cname');
               $data['parent_id']=I('post.parent_id');
               $data['full_py']=I('post.full_py');
               $data['first_py']=I('post.first_py');
               $data['order_index']=I('post.order_index');
               $data['update_time']=time();
               $data['is_display']=I('post.is_display');
               $data['lpt_x']=I('post.lpt_x');
               $data['lpt_y']=I('post.lpt_y');
               $result=$handleParamregion->upParamRegion($data);
              if($result){
                  $this->success('修改成功！',"paramRegionList.html?no=1&leftno=24");
              }else{
                  $this->success('修改失败！',"paramRegionList.html?no=1&leftno=24");
              }
         }elseif($type=="add"){
            if(I('post.addtype')==1){
                $parent_id=0;
            }elseif(I('post.addtype')==2){
                $parent_id=I('post.parent_id');
            }
             $maxid=$handleParamregion->maxParamRegion();
             $data['id']=$maxid+1;
             $data['cname']=I('post.cname');
             $data['parent_id']=$parent_id;
             $data['full_py']=I('post.full_py');
             $data['first_py']=I('post.first_py');
             $data['order_index']=I('post.order_index');
             $data['create_time']=time();
             $data['is_display']=I('post.is_display');
             $data['lpt_x']=I('post.lpt_x');
             $data['lpt_y']=I('post.lpt_y');
             $data['city_code']=C('CITY_CODE');
             $result=$handleParamregion->addParamRegion($data);
             if($result){
                $this->success('提交成功！',U('Paramregion/paramRegionList'),0);
             }else{
                $this->success('提交失败！',U('Paramregion/paramRegionList'),0);
             }
         }
    }
    //修改区域板块参数
     public function updateregion(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
          if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
          }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $upid=I('get.upid');
         $parent_id=I('get.parent_id');
         $handleParamregion = new \Logic\Paramregion();
         $uparr=$handleParamregion->getParamRegion($upid);
         $region_list=$handleParamregion->getParamRegionList();
         $this->assign("region_list",$region_list);
         $this->assign("regionup",$uparr);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
     }

     //删除房源参数
     public function addtemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
          $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $handleParamregion = new \Logic\Paramregion();
         $condition['parent_id']=0;
         $region_list=$handleParamregion->getParamRegionList($condition);
         $this->assign("region_list",$region_list);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
     }
}
?>
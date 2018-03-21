<?php
namespace Home\Controller;
use Think\Controller;
class FiltrateController extends Controller {
    /*首页入口设置 */
    public function filtratelist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"1");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"1");
        $handleMenu->jurisdiction();

        $handleinfotype= new\Home\Model\paramhouse();
        $resourcetype=I('get.resourcetype');
        $infotype=I('get.infotype');
        if($resourcetype==0){
            $where['resource_type']=0;
            if($infotype==1){
                $where['info_type']=6;
            }elseif($infotype==2){
                $where['info_type']=16;
            }
        }
        if($resourcetype==1){
            if($infotype==1){
                $where['resource_type']=1;
                $where['info_type']=19;
            }elseif($infotype==2){
                $where['resource_type']=0;
                $where['info_type']=16;
            }
        }
        if($resourcetype==""&&$infotype==""){
            $where['resource_type']=0;
            $where['info_type']=6;
        }
        $where['record_status']=1;
        $list=$handleinfotype->modelSelect($where);
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
  	  	$this->display();
    }
    #delete
    public function filtratedelete(){
         $id=I('post.pid');
        if($id==""){
           echo '{"status":"500","msg":"参数错误"}';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $handleinfotype= new\Home\Model\paramhouse();
        $result=$handleinfotype->modeldelParamHouse($id);
        if($result){
             echo '{"status":"200","msg":"操作成功"}';
        }else{
             echo '{"status":"400","msg":"操作失败"}';
        }
    }
    //提交信息
    public function addfiltrate(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         if(I('post.type')=="1"){
             $data['id']=I('post.upid');
             //$data['type_no']=I('post.type_no');
             //$data['info_type']=I('post.info_type');
             if(I('post.info_type')!=16){
                $data['name']=I('post.name');
                $data['index_no']=I('post.index_no');
             }
             $data['is_display']=I('post.is_display');
             $handleParamhouse=new \Logic\Paramhouse();
             $result=$handleParamhouse->upParamHouse($data);
             if($result){
                 $this->success('修改成功！',"filtratelist.html?no=1&leftno=140");
              }else{
                $this->success('未修改任何数据！',"filtratelist.html?no=1&leftno=140");
              }
         }else{
             $data['id']=create_guid();
             $data['type_no']=I('post.type_no');
             if(I('post.resource_type')==0&&I('post.info_type')==19){
                 $data['info_type']=6;
             }else{
                $data['info_type']=I('post.info_type');
             }
             $data['name']=I('post.name');
             $data['index_no']=I('post.index_no');
             $data['is_display']=I('post.is_display');
             $data['resource_type']=I('post.resource_type');
             $data['create_time']=time();
             $handleParamhouse=new \Logic\Paramhouse();
             $where['type_no']=$data['type_no'];
             $where['record_status']=1;
             $selresult=$handleParamhouse->SelectTypeNo($where);
             if($selresult){
                 $this->success('类型编号不能重复！',"filtratelist.html?no=1&leftno=140");
             }else{
                 $result=$handleParamhouse->addParamHouse($data);
                 if($result){
                    $this->success('提交成功！',"filtratelist.html?no=1&leftno=140");
                 }
             }
         }
    }
    public function updatefiltrate(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
        
         $handleinfotype= new\Home\Model\paramhouse();
         $id=I('get.upid');
         $infotype=$handleinfotype->modelParamHouse($id);
         $this->assign("infotypearr",$infotype);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
    }

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
  
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
    }
}
?>
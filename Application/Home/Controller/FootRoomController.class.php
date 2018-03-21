<?php
namespace Home\Controller;
use Think\Controller;
class FootRoomController extends Controller {
      //未回复列表
       public function footroomlist(){
            $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
            $handleMenu->jurisdiction();
            $refresh=new \Home\Model\customerlimitrefresh();
            $mobile=I('get.mobile');
             if($mobile!=""){
                 $where['mobile']=array('eq',$mobile);
             }
             $count=$refresh->modelRefreshCount($where);
             $Page= new \Think\Page($count,10);
             $list=$refresh->modelRefreshList($Page->firstRow,$Page->listRows,$where);
            $this->assign("list",$list);
            $this->assign("pagecount",$count);
            $this->assign("show",$Page->show());
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
       }
      public function addtemp(){
            $handleMenu = new \Logic\AdminMenuListLimit();
            $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
      }
     public function submit(){
          $mobile=I('post.mobile');
          $memo=I('post.memo');
          $refresh=new \Home\Model\customerlimitrefresh();
          $where['mobile']=$mobile;
          $rel=$refresh->modelFind($where);
          if($rel){
               $this->success('该号码已存在',"addtemp.html?no=3&leftno=154");
          }else{
              $customer=new \Home\Model\customer();
              $customerarr=$customer->getResourceClientByPhone($mobile);
              if($customerarr){
                  $adminlogin=new \Home\Model\adminlogin();
                  $admin['user_name']=cookie("admin_user_name");
                  $adminarr=$adminlogin->modelAdminFind($admin);
                  $data['id']=create_guid();
                  $data['customer_id']=$customerarr['id'];
                  $data['mobile']=$mobile;
                  $data['create_time']=time();
                  $data['oper_man_id']=$adminarr['id'];
                  $data['oper_man_name']=cookie("admin_user_name");
                  $data['memo']=$memo;
                  $return=$refresh->modelAdd($data);
                  if($return){
                      $this->success('新增成功',"footroomlist.html?no=3&leftno=154");
                  }
              }else{
                  $this->success('该号码还不是注册用户',"footroomlist.html?no=3&leftno=154");
              }
              
          }
     }

     public function deletebyid(){
          $refresh=new \Home\Model\customerlimitrefresh();
          $id=I('get.id');
          if($id!=""){
              $where['id']=$id;
              $ret=$refresh->modelDelete($where);
              if($ret){
                echo '{"status":"200","message":"请求成功！","data": {}}';
              }
          }

     }
}
?>
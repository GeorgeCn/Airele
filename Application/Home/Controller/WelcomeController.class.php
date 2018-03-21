<?php
namespace Home\Controller;
use Think\Controller;
class WelcomeController extends Controller {
   public function welcome(){
      $handleMenu = new \Logic\AdminMenuListLimit();
      $handleCommonCache=new \Logic\CommonCacheLogic();
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),'');
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),'');
      $handleAdminLogin=new \Logic\AdminLogin();
      $cookiename=cookie("admin_user_name");
      $where['user_name']=$cookiename;
      $where['record_status']=1;
      $adminarr=$handleAdminLogin->modelAdminFind($where);

      //$cachename=get_couchbase_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id']);
      $cachename=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id']);
      if($cookiename==""){
          $this->success('重新登录',U('index/index'),0);
          return;
      }
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }

   public function upPasswordPage(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
     $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),'');
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),'');
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
  }

 //修改密码
  public function upPassword(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $user_name=$_POST['user_name'];
      $oldpwd=$_POST['oldpwd'];
      $newpwd=$_POST['newpwd'];
      $newpwds=$_POST['newpwds'];
      $usertype=$_POST['usertype'];
      $handleAccount = new \Logic\Account();
      $where['user_name']=$user_name;
      $userarr=$handleAccount->getAccount($where);
      if($userarr){
          if($usertype=="admin"){
              if($newpwd!=$newpwds){
                $this->success('两次输入新密码不一致！',U('Welcome/upPasswordPage'),0);
              }else{
                $userarr['user_pwd']=md5($newpwds);
                $userarr['update_time']=time();
                $result=$handleAccount->upPassword($userarr);
                if($result){
                  $this->success('密码修改成功！',U('Welcome/upPasswordPage'),0);
                }else{
                  $this->success('密码修改失败！',U('Welcome/upPasswordPage'),0);
                 }

              }
          }else{
             if($userarr['user_pwd']!=md5($oldpwd)){
                $this->success('原密码不正确！',U('Welcome/upPasswordPage'),0);
             }elseif($newpwd!=$newpwds){
                $this->success('两次输入新密码不一致！',U('Welcome/upPasswordPage'),0);
             }else{
               $userarr['user_pwd']=md5($newpwds);
               $userarr['update_time']=time();
               $result=$handleAccount->upPassword($userarr);
               if($result){
                  $this->success('密码修改成功！',U('Welcome/upPasswordPage'),0);
               }else{
                  $this->success('密码修改失败！',U('Welcome/upPasswordPage'),0);
               }
             }

        }
      }else{
         $this->success('该账号不存在！',U('Welcome/upPasswordPage'),0);
      }
  }
   public function upaccount(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
        $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
     $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),'');
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),'');
      $handleAccount = new \Logic\Account();
      if(cookie("admin_user_name")!=""){
           $where['user_name']=cookie("admin_user_name");
           $result=$handleAccount->getAccount($where);
           $this->assign("data",$result);
      }
  
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
   }

  public function subaccount(){
        $handleAccount = new \Logic\Account();
        $number=I('get.number');
        $name=I('get.name');
        $mobile=I('get.mobile');
        $email=I('get.email');
        $city_code=I('get.city_code');
         if(cookie("admin_user_name")!=""){
              $where['user_name']=cookie("admin_user_name");
              $data=$handleAccount->getAccount($where);
              if($data){
                   $data['staffid']=$number;
                   $data['real_name']=$name;
                   $data['mobile']=$mobile;
                   $data['email']=$email;
                   //$data['city_code']=$city_code;
                   $result=$handleAccount->upUser($data);
                   if($result){
                      echo "{\"status\":\"200\",\"msg\":\"修改成功\"}";
                   }else{
                      echo "{\"status\":\"201\",\"msg\":\"未做任何修改\"}";
                   }
              }
         }
  }

}
?>
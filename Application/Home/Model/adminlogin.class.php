<?php
namespace Home\Model;
use Think\Model;
class adminlogin{
    //获取委托分页数据
   public function modelAdminLogin($name,$pwd){
     $User = M("admin_user");
     $condition['user_name']=$name;
     $condition['user_pwd']=$pwd;
     return $User->where($condition)->select();
   }
  public function modelAdminFind($where){
     $User = M("admin_user");
     return $User->where($where)->find();
  }
  //获取内部人员信息
  public function getListByWhere($where){
      $User=new Model();
      return $User->query("select id,user_name,real_name,mobile from admin_user where ".$where);
  }
}
?> 
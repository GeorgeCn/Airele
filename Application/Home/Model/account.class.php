<?php
namespace Home\Model;
use Think\Model;
class account{
   //获取账户信息
   public function modelAccountList($condition){
      $ModelTable = M("admin_user");
      $result = $ModelTable->where($condition)->order('create_time asc')->select();
     return $result;
   }
   public function modelAccount($condition){
      $ModelTable = M("admin_user");
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //增加用户
    public function modelAddUser($data){
      $ModelTable = M("admin_user");
      $result = $ModelTable->data($data)->add();
     return $result;
   }
   //修改密码
    public function modelUpPassword($data){
      $ModelTable = M("admin_user");
      $condition['id']=$data['id'];
      $condition['user_name']=$data['user_name'];
      $result=$ModelTable->where($condition)->save($data);
      return $result;
   }
   //获取菜单
    public function modelMenuId($where){
      $ModelTable = M("adminmenulist");
      $result = $ModelTable->where($where)->select();
     return $result;
   }
   public function modelMenuIdFind($where){
      $ModelTable = M("adminmenulist");
      $result = $ModelTable->where($where)->find();
     return $result;
   }
   //添加用户权限
   public function modelAddSysmenuMenu($data){
     $ModelTable = M("adminmenulistlimit");
     $result=$ModelTable->data($data)->add();
     return $result;
   }
    //获取权限
    public function modelGetSysmenuMenu($where){
      $ModelTable = M("adminmenulistlimit");
      $result = $ModelTable->where($where)->select();
     return $result;
   }
   //删除账户权限
   public function modeldelSysMenu($where){
    $ModelTable = M("adminmenulistlimit");
    $result = $ModelTable->where($where)->delete();
    return $result;
   }
   //修改账户
    public function modelUpUser($data){
      $ModelTable = M("admin_user");
      $condition['id']=$data['id'];
      $condition['user_name']=$data['user_name'];
      $result=$ModelTable->where($condition)->save($data);
      return $result;
   }
}
?> 
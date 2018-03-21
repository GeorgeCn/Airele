<?php
namespace Home\Model;
use Think\Model;
class sysmenu{
    //获取房源参数列表
   public function modelSysmenuMenuList($menu_id){
      $ModelTable = M("adminmenulist");
      $condition['record_status']=1;
       if($menu_id){
        $condition['parent_id']=$menu_id;
      }else{
         $condition['parent_id']=0;
      }
      $result = $ModelTable->where($condition)->order('id asc')->select();
     return $result;
   }
   public function modelSysmenuMenu($where){
      $ModelTable = M("adminmenulist");
      $condition['id']=$where;
      $condition['record_status']=1;
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //添加菜单
   public function modelAddSysmenuMenu($data){
     $ModelTable = M("adminmenulist");
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   //删除菜单
   public function modeldelSysmenuMenu($where){
      $ModelTable = M("adminmenulist");
      $data['record_status']=0;
      $condition['id']=$where;
      $result=$ModelTable->where($condition)->save($data); 
      return $result;
   }
   //修改菜单
    public function modelUpSysmenuMenu($data){
      $ModelTable = M("adminmenulist");
      $condition['id']=$data['id'];
      $result=$ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelPreviousMenu($mid){
      $ModelTable = M("adminmenulist");
      $condition['record_status']=1;
      $condition['id']=$mid;
      $result = $ModelTable->where($condition)->find();
      $where['record_status']=1;
      $where['parent_id']=$result['parent_id'];
      $resultarr = $ModelTable->where($where)->order('id asc')->select();
      return $resultarr;
   }
}
?> 
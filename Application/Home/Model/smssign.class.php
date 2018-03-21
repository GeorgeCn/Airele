<?php
namespace Home\Model;
use Think\Model;
class smssign{
   public function modelPageCount($where){
      $ModelTable = M("smssign");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("smssign");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

   public function modelFind($where){
     $ModelTable=M('smssign');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('smssign');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('smssign');
      $result = $ModelTable->add($data);
      return $result;
   }

}
?> 
<?php
namespace Home\Model;
use Think\Model;
class adindex{

   public function modelCount($where){
     $ModelTable = M("adindex");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelList($firstrow,$listrows,$where){
      $ModelTable = M("adindex");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   public function modelAdd($data){
      $ModelTable = M("adindex");
      $result = $ModelTable->data($data)->add();
      return $result;
   }
   public function modelFind($where){
      $ModelTable = M("adindex");
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelUpdate($data){
      $ModelTable = M("adindex");
      $where['id']=$data['id'];
      $result=$ModelTable->where($where)->save($data); 
      return $result;
   }
}
?> 
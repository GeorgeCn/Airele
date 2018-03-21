<?php
namespace Home\Model;
use Think\Model;
class roomadindex{

   public function modelCount($where){
     $ModelTable = M("roomadindex");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelList($firstrow,$listrows,$where){
      $ModelTable = M("roomadindex");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   public function modelAdd($data){
      $ModelTable = M("roomadindex");
      $result = $ModelTable->data($data)->add();
      return $result;
   }
   public function modelFind($where){
      $ModelTable = M("roomadindex");
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelUpdate($data){
      $ModelTable = M("roomadindex");
      $where['id']=$data['id'];
      $result=$ModelTable->where($where)->save($data); 
      return $result;
   }
}
?> 
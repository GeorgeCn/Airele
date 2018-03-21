<?php
namespace Home\Model;
use Think\Model;
class housecontract{
   public function modelPageCount($where){
      $ModelTable = M("housecontract");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("housecontract");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
    //获取分页数据
   public function modelGet($where){
      $ModelTable=M('housecontract');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('housecontract');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('housecontract');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('housecontract');
      $result = $ModelTable->add($data);
      return $result;
   }

}
?> 
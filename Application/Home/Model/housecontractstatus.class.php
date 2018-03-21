<?php
namespace Home\Model;
use Think\Model;
class housecontractstatus{
   public function modelGet($where){
      $ModelTable=M('housecontractstatus');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('housecontractstatus');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelAdd($data){
     $ModelTable=M('housecontractstatus');
     $result = $ModelTable->add($data);
     return $result;
   }
  
}
?> 
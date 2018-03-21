<?php
namespace Home\Model;
use Think\Model;
class circletags{

   public function modelFind($where){
      $ModelTable = M("circletags");
      $result = $ModelTable->where($where)->find();
      return $result;
   }

 public function modelSelect($where){
      $ModelTable = M("circletags");
      $result = $ModelTable->where($where)->select();
      return $result;
   }
   
}
?> 
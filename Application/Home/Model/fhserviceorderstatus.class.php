<?php
namespace Home\Model;
use Think\Model;
class fhserviceorderstatus{

   public function modelGet($where){
      $ModelTable=M('fhserviceorderstatus');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('fhserviceorderstatus');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('fhserviceorderstatus');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('fhserviceorderstatus');
      $result = $ModelTable->add($data);
      return $result;
   }
  
}
?> 
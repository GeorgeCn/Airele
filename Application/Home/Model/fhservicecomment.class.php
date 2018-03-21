<?php
namespace Home\Model;
use Think\Model;
class fhservicecomment{
   
   public function modelPageCount($where){
      $ModelTable = M("fhservicecomment");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("fhservicecomment");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

   public function modelGet($where){
      $ModelTable=M('fhservicecomment');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('fhservicecomment');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('fhservicecomment');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('fhservicecomment');
      $result = $ModelTable->add($data);
      return $result;
   }
  
}
?> 
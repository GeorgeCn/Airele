<?php
namespace Home\Model;
use Think\Model;
class serviceorderstatus{

   public function modelServiceFind($where){
     $ModelTable = M("serviceorderstatus");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelServiceAdd($data){
      $ModelTable = M("serviceorderstatus");
      $result = $ModelTable->add($data);
      return $result;
   }
  
}
?> 
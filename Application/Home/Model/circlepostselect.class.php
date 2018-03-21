<?php
namespace Home\Model;
use Think\Model;
class circlepostselect{
   public function modelDelete($where){
      $ModelTable = M("circlepostselect");
      $result = $ModelTable->where($where)->delete();
      return $result;
   }

   public function modelAdd($data){
      $ModelTable = M("circlepostselect");
      $result = $ModelTable->data($data)->add();
      return $result;
   }

}
?> 
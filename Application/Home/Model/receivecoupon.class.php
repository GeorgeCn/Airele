<?php
namespace Home\Model;
use Think\Model;
class receivecoupon{
  
   public function modelSelect($where){
      $ModelTable = M("receivecoupon");
      $datalist = $ModelTable->where($where)->order('create_time desc')->select();
     return $datalist;
   }

   
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class movehouse{    

   public function modelSelect($where){
      $ModelTable=M('movehouse');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
      return $result;
   }

}
?> 
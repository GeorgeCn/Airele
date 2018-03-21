<?php
namespace Home\Model;
use Think\Model;
class otherallimg{
     const connection_img = 'DB_IMAGE';

   public function modelSelect($where){
      $ModelTable = M("otherallimg","",self::connection_img);
      $datalist = $ModelTable->where($where)->limit(2)->order('create_time desc')->select();
     return $datalist;
   }
   public function modelFind($where){
     $ModelTable = M("otherallimg","",self::connection_img);
     $result = $ModelTable->where($where)->find();
     return $result;
   }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class circleimg{
     const connection_img = 'DB_IMAGE';

   public function modelSelect($where){
      $ModelTable = M("circleimg","",self::connection_img);
      $datalist = $ModelTable->where($where)->order('create_time desc')->select();
     return $datalist;
   }
   public function modelFind($where){
     $ModelTable = M("circleimg","",self::connection_img);
     $result = $ModelTable->where($where)->find();
     return $result;
   }
}
?> 
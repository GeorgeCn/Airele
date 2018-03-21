<?php
namespace Home\Model;
use Think\Model;
class customernotify{
   const connecdata = 'DB_DATA';
   public function modelGet($where){
     $ModelTable=M('customernotify','',self::connecdata);
     $result = $ModelTable->where($where)->select();
     return $result;
   }
   public function modelAdd($data){
     $ModelTable=M('customernotify','',self::connecdata);
     $result = $ModelTable->data($data)->add();
     return $result;
   }

}
?> 
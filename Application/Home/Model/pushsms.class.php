<?php
namespace Home\Model;
use Think\Model;
class pushsms{
   public function modelPageCount($where){
      $ModelTable = M("pushsms");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("pushsms");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   public function modelAdd($data){
      $ModelTable=M('pushsms');
      $result = $ModelTable->add($data);
      return $result;
   }

}
?> 
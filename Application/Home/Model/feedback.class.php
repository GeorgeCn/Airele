<?php
namespace Home\Model;
use Think\Model;
class feedback{
   public function modelFeedbackCount($where){
     $ModelTable = M("feedback");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
 
   public function modelFeedbackList($firstrow,$listrows,$where){
      $ModelTable = M("feedback");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
}
?> 
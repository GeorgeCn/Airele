<?php
namespace Home\Model;
use Think\Model;
class serviceman{
    public function modelServicePageCount($where){
     $ModelTable = M("serviceman");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   public function modelServiceList($firstrow,$listrows,$where){
      $ModelTable = M("serviceman");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
    
   public function modelServiceFind($where){
     $ModelTable = M("serviceman");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelServiceUpdate($data){
      $ModelTable = M("serviceman");
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelServiceAdd($data){
   	  $ModelTable = M("serviceman");
      $result = $ModelTable->add($data);
      return $result;
   }

}
?> 
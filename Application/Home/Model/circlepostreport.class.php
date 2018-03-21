<?php
namespace Home\Model;
use Think\Model;
class circlepostreport{
   public function modelPageCount($where){
      $ModelTable = M("circlepostreport");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("circlepostreport");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

   public function modelFind($where){
     $ModelTable=M('circlepostreport');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('circlepostreport');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('circlepostreport');
      $result = $ModelTable->add($data);
      return $result;
   }

   public function modelCount($where){
      $ModelTable=M('circlepostreport');
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPostUpdate($where){
      $ModelTable=M('circlepost');
      $data['is_display']=0;
      $result = $ModelTable->where($where)->save($data);
      return $result;
   }
   public function modelPostSelect($where){
      $ModelTable=M('circlepost');
      $result = $ModelTable->where($where)->select();
      return $result;
   }

}
?> 
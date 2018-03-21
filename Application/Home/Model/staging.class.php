<?php
namespace Home\Model;
use Think\Model;
class staging{
    //获取委托分页数据
   public function modelStagingPageCount($where){
     $ModelTable = M("orderpayinstallment");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelStagingList($firstrow,$listrows,$where){
      $ModelTable = M("orderpayinstallment");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
    
   public function modelByIdFind($where){
     $ModelTable = M("orderpayinstallment");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable = M("orderpayinstallment");
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }

}
?> 
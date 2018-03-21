<?php
namespace Home\Model;
use Think\Model;
class serviceorder{

   public function modelServicePageCount($where){
     $ModelTable = M("serviceorder");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   public function modelServiceList($firstrow,$listrows,$where){
      $ModelTable = M("serviceorder");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
    
   public function modelServiceFind($where){
     $ModelTable = M("serviceorder");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelServiceUpdate($data){
      $ModelTable = M("serviceorder");
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelCount($where){
      $ModelTable = M("serviceorder");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelServiceFinanPageCount($where){
     $ModelTable = M("serviceorder");
     if(isset($where['order_status'])){
         $result = $ModelTable->where($where)->count();
      }else{
        $result = $ModelTable->where($where)->where('order_status=4 or order_status=6 or order_status=7')->count();
      }
     return $result;
   }
   public function modelServiceFinanList($firstrow,$listrows,$where){
      $ModelTable = M("serviceorder");
      if(isset($where['order_status'])){
          $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
      }else{
          $datalist = $ModelTable->where($where)->where('order_status=4 or order_status=6 or order_status=7')->order('create_time desc')->limit($firstrow,$listrows)->select();
      }
     return $datalist;
   }
}
?> 
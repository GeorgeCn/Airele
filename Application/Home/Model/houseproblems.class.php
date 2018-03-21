<?php
namespace Home\Model;
use Think\Model;
class houseproblems{

   public function modelProblemsCount($where){
     $ModelTable = M("houseproblems");
     return $ModelTable->where($where)->count();
    
   }

   public function modelProblemsList($firstrow,$listrows,$where){
      $ModelTable = M("houseproblems");
      return $ModelTable->where($where)->order('update_time desc')->limit($firstrow,$listrows)->select();

   }

   public function modelUpdata($data){
      $ModelTable = M("houseproblems");
      $where['id']=$data['id'];
      return $ModelTable->where($where)->save($data);
   }

   public function modelFind($where){
      $ModelTable = M("houseproblems");
      return $ModelTable->where($where)->find();
   }

  public function getRoomIdsByCustomerId($owner_id){
      $model = new Model();
      return $model->query("select id from houseroom where status=2 and customer_id='$owner_id'");
  }

}
?>
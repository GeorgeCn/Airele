<?php
namespace Home\Model;
use Think\Model;
class fhserviceman{
   
   public function modelPageCount($where){
      $ModelTable = M("fhserviceman");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("fhserviceman");
      $datalist = $ModelTable->where($where)->order('sort_index desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

   public function modelGet($where){
      $ModelTable=M('fhserviceman');
      $result = $ModelTable->where($where)->order('sort_index desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('fhserviceman');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('fhserviceman');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('fhserviceman');
      $result = $ModelTable->add($data);
      return $result;
   }

  //上，下移动
  public function modifyTopManSort($manid,$sort_index,$manidTwo,$sort_indexTwo){
     $model = new Model();
     $result = $model->execute("update fhserviceman set sort_index='$sort_index' where id='$manid'");
     $result = $model->execute("update fhserviceman set sort_index='$sort_indexTwo' where id='$manidTwo'");
     return $result;
  }
  
}
?> 
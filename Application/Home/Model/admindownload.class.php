<?php
namespace Home\Model;
use Think\Model;
class admindownload{

  public function modelGet($where){
     $model = M("admindownload");
     $result = $model->where($where)->select();
     return $result;
  }
  public function modelFind($where){
     $model = M("admindownload");
     $result = $model->where($where)->find();
     return $result;
  }
   //新增
   public function addModel($data){
     $model = M("admindownload");
     $result = $model->add($data);
     return $result;
   }
}
?> 
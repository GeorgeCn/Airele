<?php
namespace Home\Model;
use Think\Model;
class houseownerinfo{
   /*房东扩展信息表*/
   //新增
   public function addModel($data){
     $model = M("houseownerinfo");
     $result = $model->add($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $model = M("houseownerinfo");
     $condition['id']=$data['id'];
     $result = $model->where($condition)->save($data);
     return $result;
   }
   //查询
   public function getModelById($id){
     $model = M("houseownerinfo");
     $condition['id']=$id;
     $result = $model->where($condition)->find();
     return $result;
   }
   
   public function getModelByCustomerId($customerId){
     $model = M("houseownerinfo");
     $condition['customer_id']=$customerId;
     $condition['record_status']=1;
     $result = $model->where($condition)->find();
     return $result;
   }
}
?> 
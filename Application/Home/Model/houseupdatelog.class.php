<?php
namespace Home\Model;
use Think\Model;
class houseupdatelog{
   /*房屋信息更新记录表*/
   //新增
   public function addModel($data){
     $model = M("houseupdatelog");
     if(!isset($data['city_code']) || $data['city_code']==''){
       $data['city_code']=C('CITY_CODE');
     }
     return $model->add($data);
   }
   //查询
   public function getListByHouseId($house_id,$house_type){
     $model = M("houseupdatelog");
     $condition['house_id']=$house_id;
     $condition['house_type']=$house_type;
     return $model->field("update_man,update_time,operate_type,operate_bak")->where($condition)->order('update_time desc')->limit(40)->select();
   }
}
?> 
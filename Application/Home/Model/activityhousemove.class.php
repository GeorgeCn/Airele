<?php
namespace Home\Model;
use Think\Model;
class activityhousemove{
  /*6元搬家活动 */
   public function getModelByMobile($mobile){
     $ModelTable=M('serviceorder');
     return $ModelTable->where(array('customer_mobile'=>$mobile,'info_id'=>'sixyuanbanjia'))->find();
   }
   public function getModelByNo($order_no){
     $ModelTable=M('serviceorder');
     return $ModelTable->where(array('id'=>$order_no))->find();
   }
   public function updateModel($data){
      $ModelTable=M('serviceorder');
      $condition['id']=$data['id'];
      return $ModelTable->where($condition)->save($data);
   }
   public function addModel($data){
      $ModelTable=M('serviceorder');
      return $ModelTable->add($data);
   }
   #list
   public function getModelListCount($condition){
     $model = M("serviceorder");
     return $model->where("record_status=1 and info_id='sixyuanbanjia'".$condition)->count();
   }
   public function getModelList($condition,$limit_start,$limit_end){
     $model = M("serviceorder");
     return $model->field("id,customer_mobile,address,price_cnt,order_status,platform,create_time,coupon_code,fail_reason,update_time")->where("record_status=1 and info_id='sixyuanbanjia'".$condition)->order("update_time desc")->limit($limit_start,$limit_end)->select();
   }
   //操作记录
   public function addLog($data){
      $ModelTable=M('serviceorderstatus');
      return $ModelTable->add($data);
   }
   public function getLogsByOrderid($order_no){
      $ModelTable=M('serviceorderstatus');
      return $ModelTable->where(array('order_id'=>$order_no))->order("create_time desc")->select();
   }
   //房屋改造 列表
   public function getHouseReformList($condition,$limit_start,$limit_end){
     $model = M("serviceorder");
     return $model->field("id,customer_mobile,address,price_cnt,order_status,platform,create_time,coupon_code,fail_reason,update_time")->where("record_status=1 and info_id='housereform'".$condition)->order("update_time desc")->limit($limit_start,$limit_end)->select();
   }
}
?> 
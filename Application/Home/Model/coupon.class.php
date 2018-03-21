<?php
namespace Home\Model;
use Think\Model;
class coupon{
    const connecdata = 'DB_DATA';
    //获取优惠订单
   public function modelGetcOrdersCoupon($order_id){
     $ModelTable = M("orderscoupon");
     $condition['order_id']=$order_id;
     $condition['record_status']=1;
     $result = $ModelTable->where($condition)->find();
     return $result;
   }
    //获取优惠用户
   public function modelGetCustomerAccounts($customer_id){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $condition['customer_id']=$customer_id;
      $condition['record_status']=1;
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //修改优惠状态
    public function modelUpOrdersCoupon($order_id){
     $ModelTable = M("orderscoupon");
     $condition['order_id']=$order_id;
     $data['record_status']=0;
     $result = $ModelTable->where($condition)->save($data);
     return $result;
   }
   //修改用户优惠金额
  public function modelUpCustomerAccounts($where){
     
      $condition['customer_id']=$where['customer_id'];
      $data['account_money']=$where['account_money'];
      $ModelTable=M('customeraccounts','',self::connecdata);
      $result = $ModelTable->where($condition)->save($data);
     return $result;
   }



}
?> 
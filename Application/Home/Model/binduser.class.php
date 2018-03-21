<?php
namespace Home\Model;
use Think\Model;
class binduser{
      const connecdata = 'DB_DATA';
    public function modelBindUserCount($where){
     $ModelTable=M('customeraccounts','',self::connecdata);
     $result = $ModelTable->join('INNER JOIN customer on customeraccounts.customer_id=customer.id')->where($where)->count();
     return $result;
   }
    //获取活动信息列表
   public function modelBindUserList($firstRow,$listRows,$condition){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $datalist = $ModelTable->field('customeraccounts.customer_id,customeraccounts.account_money,customeraccounts.customer_code,customeraccounts.code_type,customer.true_name,customer.mobile')->join('INNER JOIN customer on customeraccounts.customer_id=customer.id')->where($condition)->order('customeraccounts.create_time')->limit($firstRow,$listRows)->select();
      return $datalist;
   }
    //获取活动
   public function modelAccounts($condition){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $condition['record_status']=1;
      $datalist = $ModelTable->where($condition)->find();
      return $datalist;
   }
    //获取活动
   public function modelCoupon($condition){
      $ModelTable=M('couponmanage','',self::connecdata);
      $condition['record_status']=1;
      $datalist = $ModelTable->where($condition)->find();
      return $datalist;
   }
   public function modelBindUser($where){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $condition['customer_id']=$where;
      $condition['record_status']=1;
      $result = $ModelTable->where($condition)->find();
      return $result;
   }
   //删除活动信息
   public function modeldelBindUser($where){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $data['record_status']=0;
      $condition['customer_id']=$where;
      $result=$ModelTable->where($condition)->save($data); 
      return $result;
   }
   //修改活动信息
    public function modelUpBindUser($data){
      $ModelTable=M('customeraccounts','',self::connecdata);
      $condition['customer_id']=$data['customer_id'];
      $result=$ModelTable->where($condition)->save($data); ;
      return $result;
   }
   public function modelCouponList(){
      $ModelTable=M('couponmanage','',self::connecdata);
      $condition['record_status']=1;
      $datalist = $ModelTable->query("select * from couponmanage where not exists(select * from customeraccounts where couponmanage.id=customeraccounts.code_type) and couponmanage.end_date >unix_timestamp()");
      return $datalist;
   }

}
?> 
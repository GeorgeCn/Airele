<?php
namespace Home\Model;
use Think\Model;
class couponmanage{
      const connecdata = 'DB_DATA';
    //获取活动信息列表
   public function modelCouponManageList($where,$firstRow,$listRows){
      $ModelTable=M('couponmanage','',self::connecdata);
      $where['record_status']=1;
      $result = $ModelTable->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
     return $result;
   }
   public function modelCouponManageCount($where){
     $ModelTable=M('couponmanage','',self::connecdata);
     $where['record_status']=1;
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   public function modelCouponManage($where){
      $ModelTable=M('couponmanage','',self::connecdata);
      $condition['id']=$where;
      $condition['record_status']=1;
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //添加活动信息
   public function modelAddCouponManage($data){
     $ModelTable=M('couponmanage','',self::connecdata);
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   //删除活动信息
   public function modeldelCouponManage($where){
      $ModelTable=M('couponmanage','',self::connecdata);
      $condition['id']=$where;
      $result=$ModelTable->where($condition)->delete(); 
      return $result;
   }
   //修改活动信息
    public function modelUpCouponManage($data){
      $ModelTable=M('couponmanage','',self::connecdata);
      $condition['id']=$data['id'];
      $result=$ModelTable->where($condition)->save($data); ;
      return $result;
   }
   //ajax获取优惠劵总数
   public function modelCouponCount($activity_id){
      $ModelTable=M('customercoupon','',self::connecdata);
      $condition['record_status']=1;
      $condition['activity_id']=$activity_id;
      $result = $ModelTable->where($condition)->count();
      return $result;
   }
   public function modelGetFind($where){
      $ModelTable=M('couponmanage','',self::connecdata);
      $result=$ModelTable->where($where)->select(); ;
      return $result;
   }
    //ajax获取优惠劵使用总数
   public function modelCouponEmployCount($activity_id){
      $ModelTable=M('customercoupon','',self::connecdata);
      $condition['record_status']=1;
      $condition['flag']=1;
      $condition['activity_id']=$activity_id;
      $result = $ModelTable->where($condition)->count();
      return $result;
   }
}
?> 
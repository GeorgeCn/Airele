<?php
namespace Home\Model;
use Think\Model;
class customercoupon{
   const connection_data = 'DB_DATA';
   public function modelCustomerCoupon($where){
      $ModelTable = M("customercoupon","",self::connection_data);
      $result = $ModelTable->where($where)->find();
     return $result;
   }
   //添加房源参数
   public function modelAddCustomerCoupon($data){
     $ModelTable = M("customercoupon","",self::connection_data);
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   public function modelGetCustomerCoupon($where){
    $ModelTable = M("customercoupon","",self::connection_data);
     $result=$ModelTable->where($where)->select();
     return $result;
   }
   public function modelCustomerCouponCount($where){
       $ModelTable = M("customercoupon","",self::connection_data);
     $result=$ModelTable->where($where)->count();
     return $result;
   }

    public function modelCustomerCouponList($firstrow,$listrows,$where){
         $ModelTable = M("customercoupon","",self::connection_data);
       $result = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
        return $result;     
    }
    public function modelUpdate($data){
       $ModelTable = M("customercoupon","",self::connection_data);
       $where['coupon_type']=$data['coupon_type'];
       $where['activity_id']=$data['activity_id'];
       $where['flag']=0;
       $where['record_status']=1;
       $result=$ModelTable->where($where)->save($data);
       return $result;
    }
}
?> 
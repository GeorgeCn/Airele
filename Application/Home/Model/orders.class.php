<?php
namespace Home\Model;
use Think\Model;
class orders{
    const connection = 'DB_IMAGE';
    const connecdata = 'DB_DATA';
    //获取委托分页数据
   public function modelOrderPageCount($where){
     $ModelTable = M("orders");
    /// if(array_key_exists('view_order_owner.name', $where)){
      // $result = $ModelTable->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->count();
    // }else{
       $result = $ModelTable->where($where)->count();
   //  }
     return $result;
   }
    //获取分页数据
   public function modelOrderDataList($firstrow,$listrows,$where){
     $ModelTable = M("orders");
     //if(array_key_exists('view_order_owner.name', $where)){
       //$datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orders.order_status,orders.order_pirce_cnt,orders.create_time')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->order('orders.create_time desc')->limit($firstrow,$listrows)->select();
     //}else{
       $datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orders.order_status,orders.order_pirce_cnt,orders.create_time')->where($where)->order('orders.create_time desc')->limit($firstrow,$listrows)->select();
     //}
     return $datalist;
   }

   //获取订单信息 
   public function modelOrderDetails($orderid){
      $ModelTable = M("orders");
      $condition['id'] =$orderid;
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //业主信息
   public function modelClient($orderid){
      $ModelTable=M('customerclient','',self::connecdata);
      $condition['order_id'] =$orderid;
      $result = $ModelTable->where($condition)->find();
      return $result;
   }

   //获取合同照，工牌
    public function modelBargainPicture($orderid){
      $ModelTable=M('orderimg','',self::connection);
      $condition['order_id'] =$orderid;
      $result = $ModelTable->where($condition)->select();
     return $result;
   }
   //支付方式
   public function modelpayManner($orderid){
      $ModelTable=M('customertrading','',self::connecdata);
      $condition['order_id'] =$orderid;
      $condition['is_access'] =1;
      $result = $ModelTable->where($condition)->find();
      return $result;
    }
    //获取订单状态
    public function modelOrderStatus($orderid){
       $ModelTable=M('orders');
      $condition['id'] =$orderid;
      $result = $ModelTable->where($condition)->find();
      return $result;
    }
    //修改订单状态
    public function modelUpOrderStatus($orderid,$status){
      $ModelTable=M('orders');
      $condition['id'] =$orderid;
      $data['order_status']=$status;
      $result = $ModelTable->where($condition)->save($data);
      return $result;
    }
      //修改订单状态,拒绝原因
    public function modelUpOrderReason($orderid,$status,$reason){
      $ModelTable=M('orders');
      $condition['id'] =$orderid;
      $data['order_status']=$status;
      $data['verify_memo']=$reason;
      $result = $ModelTable->where($condition)->save($data);
      return $result;
    }
    //插入订单状态
    public function modelAddOrderStatus($order_id,$status,$memo,$oper_id,$desc){
       $ModelTable=M('orderstatus');
       $data['id']=create_guid();
       $data['order_id']=$order_id;
       $data['order_status']=$status;
       $data['create_time']=time();
       $data['memo']=$memo;
       $data['oper_id']=$oper_id;
       $data['desc']=$desc;
       $result = $ModelTable->data($data)->add();
      return $result;
    }

    //退回红包
    public function modelUpCoupon($customer_id,$orderid){
      $ModelTable=M('customercoupon','',self::connecdata);
      $condition['customer_id'] =$customer_id;
      $condition['order_id'] =$orderid;
      $data['flag']=0;
      $data['order_id']="";
      $result = $ModelTable->where($condition)->save($data);
      return $result;
    }

    //获取用户优惠金额
   public function modelTenantCoupon($order_id){
      $ModelTable=M('customercoupon','',self::connecdata);
      $ModelTable1=M('orderscoupon');
      $condition['order_id'] =$order_id;
      $result = $ModelTable->field('order_id,SUM(coupon_money)')->where($condition)->where('record_status=1 AND flag=1')->find();
      $result1=$ModelTable1->field('order_id,SUM(coupon_money)')->where($condition)->where('record_status=1')->find();
      if(!empty($result)&&empty($result1)){
         return $result;
       }elseif(!empty($result1)&&empty($result)){
         return $result1;
       }elseif(!empty($result) && !empty($result1)){
             if($result['order_id']!=""){
                $rearr['order_id']=$result['order_id'];
             }else{
                $rearr['order_id']=$result1['order_id'];
             }
             $rearr['coupon_money']=$result1['SUM(coupon_money)']+$result['SUM(coupon_money)'];
           return $rearr;
       }
   }

       //获取用户优惠金额
   public function modelSumCoupon($order_id){
      $ModelTable=M('customercoupon','',self::connecdata);
      $condition['order_id'] =$order_id;
      $result = $ModelTable->field('order_id,SUM(coupon_money)')->where($condition)->where('record_status=1 AND flag=1')->find();
      $rearr=$result['SUM(coupon_money)'];
       return $rearr;
      
   }
   //获取操作人
   public function modelOrderOperator($order_id){
      $ModelTable=M('orderstatus');
      $condition['order_id'] =$order_id;
      $result = $ModelTable->field('order_id,create_time,oper_id')->where($condition)->order('create_time DESC')->limit(1)->find();
      return $result;
   }
     //获取操作人列表
   public function modelOrderStatusList($order_id){
      $ModelTable=M('orderstatus');
      $condition['order_id'] =$order_id;
      $result = $ModelTable->where($condition)->order('create_time ASC')->select();
      return $result;
   }
   //导出excel
   public function modelOrderExcel($where){
     $ModelTable = M("orders");
      $datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orderscoupon.coupon_money,orders.order_pirce_cnt,orders.order_status,orders.create_time')->join('LEFT JOIN orderscoupon on orders.id=orderscoupon.order_id')->where($where)->order('orders.create_time desc')->select();
     return $datalist;
   }
   //房租金额统计
   public function modelCountHouseMoney($where){
     $ModelTable = M("orders");
    if(array_key_exists('view_order_owner.name', $where)){
        $datalist = $ModelTable->field('sum(orders.price_cnt) as sumprice_cunt,sum(orders.order_pirce_cnt) as sumorder_pirce_cnt')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->order('orders.create_time desc')->find();
    }else{
        $datalist = $ModelTable->field('sum(orders.price_cnt) as sumprice_cunt,sum(orders.order_pirce_cnt) as sumorder_pirce_cnt')->where($where)->order('orders.create_time desc')->find();
    }
     return $datalist;
   }

   public function modelGetCoupon($where){
        $ModelTable=M('customercoupon','',self::connecdata);
        $result=$ModelTable->where($where)->select();
        return $result;
   }
   //获取商家优惠金额
   public function modelMerchantCoupon($where){
      $ModelTable=M('customercoupon','',self::connecdata);
      $result=$ModelTable->field('SUM(coupon_money)')->where($where)->find();
       $rearr=$result['SUM(coupon_money)'];
      return $rearr;
   }
  //修改备注
  public function modelUpdateMemo($data){
      $ModelTable=M('orderstatus');
      $condition['order_id'] =$data['order_id'];
      $condition['order_status'] =$data['order_status'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   //修改order备注verify_memo
  public function modelUpOrderDesc($orderid,$memo){
      $ModelTable=M('orders');
      $condition['id'] =$orderid;
      $data['verify_memo']=$memo;
      $result = $ModelTable->where($condition)->save($data);
      return $result;
    } 

}
?> 
<?php
namespace Home\Model;
use Think\Model;
class refund{
    //获取委托分页数据
   public function modelRefundPageCount($where){
     $ModelTable = M("orders");
     $result = $ModelTable->join('orderstatus on orders.id=orderstatus.order_id')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->where('orderstatus.order_status=6 and orders.order_status=6')->count();
     return $result;
   }
    //获取分页数据
   public function modelRefundDataList($firstrow,$listrows,$where){
      $ModelTable = M("orders");
        $datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orders.order_status,orders.order_pirce_cnt,orderstatus.create_time,orderstatus.oper_id')->join('orderstatus on orders.id=orderstatus.order_id')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->where('orderstatus.order_status=6 and orders.order_status=6')->order('orderstatus.create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   //获取金额统计
   public function modelCountHouseMoney($where){
     $ModelTable = M("orders");
        $datalist = $ModelTable->field('SUM(orders.price_cnt) AS sum_price_cunt,SUM(orders.order_pirce_cnt) AS sum_order_pirce_cnt')->join('orderstatus on orders.id=orderstatus.order_id')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->where('orderstatus.order_status=6 and orders.order_status=6')->find();
     return $datalist;
   }

}
?> 
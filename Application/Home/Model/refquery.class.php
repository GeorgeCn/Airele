<?php
namespace Home\Model;
use Think\Model;
class refquery{
    //获取委托分页数据
   public function modelRefqueryPageCount($where){
     $ModelTable = M("orders");
     $result = $ModelTable->join('orderstatus on orders.id=orderstatus.order_id')->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelRefqueryDataList($firstrow,$listrows,$where){
      $ModelTable = M("orders");
      $datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orders.order_status,orders.order_pirce_cnt,orderstatus.create_time,orderstatus.oper_id')->join('orderstatus on orders.id=orderstatus.order_id')->where($where)->order('orderstatus.create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }


}
?> 
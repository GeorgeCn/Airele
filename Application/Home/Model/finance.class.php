<?php
namespace Home\Model;
use Think\Model;
class finance{
    const connecdata = 'DB_DATA';
    //获取委托分页数据
   public function modelFinancePageCount($where){
     $ModelTable = M("orders");
     $result = $ModelTable->where($where)->where('orders.order_status=4')->count();
     return $result;
   }
    //获取分页数据
   public function modelFinanceDataList($firstrow,$listrows,$where){
      $ModelTable = M("orders");
        $datalist = $ModelTable->field('orders.id,orders.renter_name,orders.renter_phone,orders.price_cnt,orders.order_status,orders.order_pirce_cnt,orderstatus.oper_id')->join('orderstatus on orders.id=orderstatus.order_id')->join('view_order_owner ON orders.id = view_order_owner.id')->where($where)->where('orderstatus.order_status=4 and orders.order_status=4')->order('orderstatus.create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
}
?> 
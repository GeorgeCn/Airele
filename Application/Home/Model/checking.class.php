<?php
namespace Home\Model;
use Think\Model;
class checking{
 const connection_data = 'DB_DATA';
  //进账
   public function modelreceipts($starttime,$endtime){
      $ModelTable = M("orders");
      $sql="select a.id ,a.renter_name,c.name,a.price_cnt,a.order_pirce_cnt-a.price_cnt as coupon,a.order_pirce_cnt,
(case b.pay_platform when 0 then '微信' when 1 then '银联' when 2 then '支付宝' else ' ' end ) as payway,
(case a.order_status when 0 then '待审核' when 1 then '已取消' when 2 then '待付款' when 3 then '审核未通过' when 4 then '已付款' when 6 then '机构已经打款' when 7 then '直接已退款' when 8 then '打款失败已退款' else ' ' end  ) as order_status,
from_unixtime(b.create_time) as paytime from gaodu.orders a 
inner join gaodudata.customertrading b on a.id=b.order_id inner join gaodudata.customerclient c on a.id=c.order_id 
where b.is_access=1 and b.create_time>=unix_timestamp('".$starttime."') and b.create_time<=unix_timestamp('".$endtime."')
order by b.pay_platform,b.create_time";
      $result = $ModelTable->query($sql);
      return $result;
   }
   //出账
    public function modelenter($starttime,$endtime){
      $ModelTable = M("orders");
      $sql="select a.id,a.renter_name,c.name,a.price_cnt,a.order_pirce_cnt-a.price_cnt as coupon,a.order_pirce_cnt,
(case b.pay_platform when 0 then '微信' when 1 then '银联' when 2 then '支付宝' else ' ' end ) as payway,
(case a.order_status when 0 then '待审核' when 1 then '已取消' when 2 then '待付款' when 3 then '审核未通过' when 4 then '已付款' when 6 then '机构已经打款' when 7 then '直接已退款' when 8 then '打款失败已退款' else ' ' end  )as order_status,
from_unixtime(s.create_time) as paytime,a.verify_memo as remark from gaodu.orders a 
inner join gaodudata.customertrading b on a.id=b.order_id inner join gaodudata.customerclient c on a.id=c.order_id inner join gaodu.orderstatus s on a.id=s.order_id 
where  b.is_access=1 and s.order_status=6 and s.create_time>=unix_timestamp('".$starttime."') and s.create_time<=unix_timestamp('".$endtime."') and a.order_status not in (7,8)
order by b.pay_platform,s.create_time";
      $result = $ModelTable->query($sql);
      return $result;
   }
   //出账
    public function modelreimburse($starttime,$endtime){
      $ModelTable = M("orders");
      $sql="select a.id,a.renter_name,c.name,a.price_cnt,a.order_pirce_cnt-a.price_cnt as coupon,a.order_pirce_cnt,a.price_cnt,
(case b.pay_platform when 0 then '微信' when 1 then '银联' when 2 then '支付宝' else ' ' end ) as payway,
(case a.order_status when 0 then '待审核' when 1 then '已取消' when 2 then '待付款' when 3 then '审核未通过' when 4 then '已付款' when 6 then '机构已经打款' when 7 then '直接已退款' when 8 then '打款失败已退款' else ' ' end  )as order_status,
from_unixtime(s.create_time) as refund_time from gaodu.orders a 
inner join gaodudata.customertrading b on a.id=b.order_id inner join gaodudata.customerclient c on a.id=c.order_id inner join gaodu.orderstatus s on a.id=s.order_id 
where  b.is_access=1 and s.order_status in (7,8) and s.create_time>=unix_timestamp('".$starttime."') and s.create_time<=unix_timestamp('".$endtime."')
order by b.pay_platform,s.create_time";
      $result = $ModelTable->query($sql);
      return $result;
   }

}
?> 
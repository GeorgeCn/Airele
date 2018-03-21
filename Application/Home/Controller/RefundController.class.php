<?php
namespace Home\Controller;
use Think\Controller;
class RefundController extends Controller {
    //审核订单
    public function refundList(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
        $handleMenu->jurisdiction();
    	 $startTime=strtotime($_GET['startTime']);
    	 $endTime=strtotime($_GET['endTime']);
    	 $mobile=$_GET['mobile'];
         $pay_platform=$_GET['pay_platform'];
    	 $orderid=$_GET['orderid'];
         $orderstatus=$_GET['orderstatus'];
         $ownername=$_GET['ownername'];
         $where['orders.record_status']=array('eq',1);
    	 if($startTime!=""&&$endTime==""){
            $where['orderstatus.create_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
             $where['orderstatus.create_time']=array('lt',$endTime+86400);
         }
         if($startTime!=""&&$endTime!=""){
            $where['orderstatus.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }

        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['orderstatus.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
    	 if($mobile!=""){
             $where['orders.renter_phone']=array('eq',$mobile);
    	 }
    	 if($orderid!=""){
             $where['orders.id']=array('eq',$orderid);
    	 }
         if($ownername!=""){
             $where['view_order_owner.name']=array('eq',$ownername);
            
         }
        
        $handleOrders = new \Logic\Orders();
        $handleRefund = new \Logic\Refund();
        $count=$handleRefund->getRefundPageCount($where);
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        $list=$handleRefund->getRefundDataList($Page->firstRow,$Page->listRows,$where);
         foreach ($list as $key => $value) {
            $paymanner=$handleOrders->payManner($value['id']);
            $value['pay_platform']=$paymanner['pay_platform'];
            $cwhere['order_id']=$value['id'];
            $cwhere['record_status']=1;
            $cwhere['coupon_type']=2;
            $couponarr =$handleOrders->modelGetCoupon($cwhere);
            if($couponarr){
              $couponmoney="";
              foreach ($couponarr as $key1 => $value1) {
                   $couponmoney+=$value1['coupon_money'];
              }
             $value['order_pirce_cnt']=$value['order_pirce_cnt']-$couponmoney;
            }
            $lists[]=$value;
        }
        $sumorders=$handleRefund->getCountHouseMoney($where);
        $this->assign("sumorders",$sumorders);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$lists);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }
    //订单详情
    public function refundDetailed(){
            $handleCommonCache=new \Logic\CommonCacheLogic();
           if(!$handleCommonCache->checkcache()){
                 $this->error('非法操作',U('Index/index'),1);
            }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new\Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
            $orderid=$_GET['oid'];
            $handleOrders = new \Logic\Orders();
            $ordersDetails=$handleOrders->getOrderDetails($orderid);
            $client=$handleOrders->getClient($orderid);
            $paymanner=$handleOrders->payManner($orderid);
            $statuslist=$handleOrders->getOrderStatusList($orderid);
            $handleCustomer = new \Logic\CustomerLogic();
            $authentication=$handleCustomer->getResourceClientByPhone($client['mobile']);

            $cwhere['order_id']=$orderid;
            $cwhere['record_status']=1;
            $cwhere['coupon_type']=2;
            $couponarr =$handleOrders->modelGetCoupon($cwhere);
            if($couponarr){
              $couponmoney="";
              foreach ($couponarr as $key => $value) {
                   $couponmoney+=$value['coupon_money'];
              }
             $ordersDetails['order_pirce_cnt']=$ordersDetails['order_pirce_cnt']-$couponmoney;
            }
            $this->assign("authentication",$authentication);
            $this->assign("statuslist",$statuslist);
            $this->assign("paymanner",$paymanner);
            $this->assign("client",$client);
            $this->assign("ordersdetails",$ordersDetails);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    //订单状态更新
     public function updateRefundStatus(){
                 $handleCommonCache=new \Logic\CommonCacheLogic();
                  if(!$handleCommonCache->checkcache()){
                     $this->error('非法操作',U('Index/index'),1);
                 }
                $orderstatus=$_POST['orderid'];
                $desc=$_POST['remark'];
                $handleOrders = new \Logic\Orders();
                $paytime=$handleOrders->payManner($orderstatus);
                $statusarr=$handleOrders->getOrderStatus($orderstatus);
                if($statusarr['order_status']==6){
                    $status=8;//机构已退款
                    $memo="机构已退款";
                }
                $handleCoupon = new \Logic\Coupon();
                $coupresult=$handleCoupon->GetcOrdersCoupon($statusarr['id']);
                if($coupresult){
                  $handleCoupon->UpOrdersCoupon($coupresult['order_id']);//修改订单优惠金额为删除状态
                }
                $custresult=$handleCoupon->GetCustomerAccounts($statusarr['customer_id']);
                $sumcoupon=$handleOrders->getSumCoupon($statusarr['id']);
                $where['customer_id']=$custresult['customer_id'];
                $where['account_money']=$statusarr['order_pirce_cnt']-$statusarr['price_cnt']-$sumcoupon;
                $handleCoupon->UpCustomerAccounts($where);//修改用户优惠金额

                $statusarr['create_time']=$paytime['create_time'];
                $oper_id=cookie("admin_user_name");
                $handleOrders->upOrderReason($statusarr['id'],$status,$desc);
                $handleOrders->upCoupon($statusarr['customer_id'],$statusarr['id']);
                $handleOrders->upOrderStatus($statusarr['id'],$status);
                $addresult=$handleOrders->addOrderStatus($statusarr['id'],$status,$memo,$oper_id,$desc);
                if($addresult){
                    $handleSms = new \Logic\Commonsms();
                     if($statusarr['platform']==0){
                         $handleSms->sendSms($statusarr,'EFW006');//租客通知
                      }elseif($statusarr['platform']==1||$statusarr['platform']==2){
                         $handleSms->sendSms($statusarr,'EFA006');//租客通知
                      }
                    $handleOrders->upCoupon($statusarr['customer_id'],$statusarr['id']);//退回优惠券
                    $this->success('退款成功！',U('Refund/refundList'),0);
                }
     }

     //修改打款备注
     public function updatememo(){
            $handleOrders = new \Logic\Orders();
            $orderid=I('get.orderid');
            $desc=I('get.desc');
            $data['order_id']= $orderid;
            $data['order_status']=6;
            $data['desc']=$desc;
            $handleOrders->modelUpdateMemo($data);
            $result=$handleOrders->modelUpOrderDesc($orderid,$desc);
            if($result){
                echo "{\"status\":\"200\",\"msg\":\"\"}";
            }
     }


}
?>
<?php
namespace Home\Controller;
use Think\Controller;
class FinanceController extends Controller {
    //审核订单
    public function financeList(){
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
    	 $duestart=$_GET['duestart'];
    	 $dueend=$_GET['dueend'];
       $pay_platform=$_GET['pay_platform'];
    	 $orderid=$_GET['orderid'];
       $where['orders.record_status']=array('eq',1);
       $ownername=$_GET['ownername'];
       if($startTime!=""&&$endTime==""){
            $where['orderstatus.create_time']=array('gt',$startTime);
       }
       if($endTime!=""&&$startTime==""){
             $where['orderstatus.create_time']=array('lt',$endTime);
       }
         if($startTime!=""&&$endTime!=""){
            $where['orderstatus.create_time']=array(array('gt',$startTime),array('lt',$endTime));
         }
    	 if($mobile!=""){
         $where['orders.renter_phone']=array('eq',$mobile);
    	 }
    	 if($duestart!=""){
          $where['orders.price_cnt']=array('egt',$duestart);
    	 } 
    	 if($dueend!=""){
          $where['orders.price_cnt']=array('elt',$dueend);
    	 }
    	 if($orderid!=""){
			   $where['orders.id']=array('eq',$orderid);
    	 }
       if($ownername!=""){
             $where['view_order_owner.name']=array('eq',$ownername);
            
         }
        $handleOrders = new \Logic\Orders();
      	$handleFinance = new \Logic\Finance();
        $count=$handleFinance->getFinancePageCount($where);
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        $list=$handleFinance->getFinanceDataList($Page->firstRow,$Page->listRows,$where);
        foreach ($list as $key => $value) {
            $paymanner=$handleOrders->getCachepayMannerArr($value['id']);
            $value['pay_platform']=$paymanner['pay_platform'];
            $value['create_time1']=$paymanner['update_time'];
            $crtime[]=$paymanner['update_time'];
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
        array_multisort($crtime,SORT_DESC,$lists);  
         $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$lists);
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }
    //订单详情
    public function financeDetailed(){
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
            $paymanner=$handleOrders->getCachepayMannerArr($orderid);
            $statuslist=$handleOrders->getOrderStatusList($orderid);
            
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
             $couwhere['order_id']=$orderid;
            $couwhere['record_status']=1;
            $couponall =$handleOrders->modelGetCoupon($couwhere);
            $this->assign("couponarr",$couponall);
            $this->assign("statuslist",$statuslist);
            $this->assign("paymanner",$paymanner);
            $this->assign("client",$client);
            $this->assign("ordersdetails",$ordersDetails);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    //订单状态更新
     public function updateFinanceStatus(){
                $handleCommonCache=new \Logic\CommonCacheLogic();
                if(!$handleCommonCache->checkcache()){
                    $this->error('非法操作',U('Index/index'),1);
                 }
                 
                $formtype=$_POST['formtype'];
                $orderstatus=$_POST['orderid'];
                $desc=$_POST['remark'];
                $handleOrders = new \Logic\Orders();
                $paytime=$handleOrders->getCachepayMannerArr($orderstatus);
                $statusarr=$handleOrders->getOrderStatus($orderstatus);
                if($statusarr['order_status']==6||$statusarr['order_status']==7){
                     $this->error('该订单已审核',U('Finance/financeList'),2);
                }
                if($statusarr['order_status']==4){
                  if($formtype=="remit"){
                     $status=6;//机构已打款
                     $memo="机构已打款";
                  }elseif($formtype=="reimburse"){
                     $status=7;//机构已打款
                     $memo="机构打款失败";
                  }
                }
                $statusarr['create_time']=$paytime['create_time'];
                $oper_id=cookie("admin_user_name");
                $client=$handleOrders->getClient($orderstatus);
                $client['order_pirce_cnt']=$statusarr['order_pirce_cnt'];
                $client['renter_name']=$statusarr['renter_name'];
                $handleOrders->upOrderReason($statusarr['id'],$status,$desc);
                //$upresult=$handleOrders->upOrderStatus($statusarr['id'],$status);
                $addresult=$handleOrders->addOrderStatus($statusarr['id'],$status,$memo,$oper_id,$desc);
                if($addresult){
                  $handleSms = new \Logic\Commonsms();
                  if($formtype=="remit"){
                     if($statusarr['platform']==0){
                        $handleSms->sendSms($client,'EFW008');//业主通知
                        $handleSms->sendSms($statusarr,'EFW007');//租客通知
                    }elseif($statusarr['platform']==1||$statusarr['platform']==2){
                        $handleSms->sendSms($client,'EFA008');//业主通知
                        $handleSms->sendSms($statusarr,'EFA007');//租客通知
                    }
                    $this->success('打款成功！',U('Finance/financeList'),0);
                  }elseif($formtype=="reimburse"){
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
                      $handleOrders->upCoupon($statusarr['customer_id'],$statusarr['id']);//退回优惠券 

                      if($statusarr['platform']==0){
                         $handleSms->sendSms($statusarr,'EFW006');//租客通知
                      }elseif($statusarr['platform']==1||$statusarr['platform']==2){
                         $handleSms->sendSms($statusarr,'EFA006');//租客通知
                      }
                     
                    $this->success('退款成功！',U('Finance/financeList'),0);
                  }
                  
              }            
     }
      //获取房东姓名
     public function orderLandlord(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $handleFinance = new \Logic\Finance();
        $result=$handleFinance->getorderLandlord($_GET['order_id']);
        $this->assign("result",$result);
        $this->display();
     }
}
?>
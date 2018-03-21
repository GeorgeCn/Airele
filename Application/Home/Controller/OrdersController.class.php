<?php
namespace Home\Controller;
use Think\Controller;
class OrdersController extends Controller {
    //审核订单
    public function auditHouseOrders(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"4");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"4");
        $handleMenu->jurisdiction();
         $startTime="";
         $endTime="";
         $orderStatus="";
         $mobile="";
         $orderid="";
         $landmobile="";
         $landlord="";
         $tenant="";
         $source="";
    	 $startTime=strtotime($_GET['startTime']);
    	 $endTime=strtotime($_GET['endTime']);
    	 $orderStatus=$_GET['orderStatus'];
    	 $mobile=$_GET['mobile'];
    	 $orderid=$_GET['orderid'];
         $landmobile=$_GET['landmobile'];
         $landlord=$_GET['landlord'];
         $tenant=$_GET['tenant'];
         $source=$_GET['source'];
         $where['orders.record_status']=array('eq',1);
    	 if($startTime!=""&&$endTime==""){
            $where['orders.create_time']=array('gt',$startTime);
    	 }
    	 if($endTime!=""&&$startTime==""){
             $where['orders.create_time']=array('lt',$endTime+86400);
    	 }
         if($startTime!=""&&$endTime!=""){
            $where['orders.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
         if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
            $where['orders.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
    	 if($orderStatus!=""){
            $where['orders.order_status']=array('eq',$orderStatus);
    	 }
    	 if($mobile!=""){
             $where['orders.renter_phone']=array('eq',$mobile);
    	 }
    	 if($orderid!=""){
            $where['orders.id']=array('eq',$orderid);
    	 }
         if($landmobile!=""){
            $where['orders.owner_phone']=array('eq',$landmobile);
         }
         if($landlord!=""){
            $where['view_order_owner.name']=array('eq',$landlord);
         }
         if($tenant!=""){
            $where['orders.renter_name']=array('eq',$tenant);
         }
         if($source!=""){
            $where['orders.platform']=array('eq',$source);
         }
    	$handleOrders = new \Logic\Orders();
        $count=$handleOrders->getOrderPageCount($where);
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        $list=$handleOrders->getOrderDataList($Page->firstRow,$Page->listRows,$where);
        $sumorders=$handleOrders->getCountHouseMoney($where);
        $where1['coupon_type']=2;
        $where1['flag']=1;
        $couponcount=$handleOrders->modelMerchantCoupon($where1);
        $this->assign("couponcount",$couponcount);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$list);
        $this->assign("sumorders",$sumorders);
		$this->display();
    }
    //订单详情
    public function ordersDetails(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
            $pactimg="";
            $cardimg="";
            $handleMenu = new\Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"4");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"4");
            $orderid=$_GET['oid'];
            $handleOrders = new \Logic\Orders();
            $ordersDetails=$handleOrders->getOrderDetails($orderid);
            $orderimg=$handleOrders->getBargainPicture($orderid);
            foreach ($orderimg as $key => $value){
                if($value['img_type']=="pact"){
                    $value['img_path']=C('IMG_SERVICE_URL').$value['img_path'].$value['img_name'].".".$value['img_ext'];
                    $pactimg[]=$value;
                }elseif($value['img_type']=="card"){
                    $value['img_path']=C('IMG_SERVICE_URL').$value['img_path'].$value['img_name'].".".$value['img_ext'];
                    $cardimg[]=$value;
                }
            }
            $client=$handleOrders->getClient($orderid);
            $paymanner=$handleOrders->payManner($orderid);
            $statusarr=$handleOrders->getOrderStatus($orderid);
            $coupon =$handleOrders->getOrderCoupon($orderid);
            $statuslist=$handleOrders->getOrderStatusList($orderid);
            $handleCustomer = new \Logic\CustomerLogic();
            $authentication=$handleCustomer->getResourceClientByPhone($client['mobile']);
            $cwhere['order_id']=$orderid;
            $cwhere['record_status']=1;
            $couponarr =$handleOrders->modelGetCoupon($cwhere);
            $this->assign("couponarr",$couponarr);
            $this->assign("authentication",$authentication);
            $this->assign("statuslist",$statuslist);
            $this->assign("coupon",$coupon);
            $this->assign("order_status",$statusarr['order_status']);
            $this->assign("paymanner",$paymanner);
            $this->assign("client",$client);
            $this->assign("pactimg",$pactimg);
            $this->assign("cardimg",$cardimg);
            $this->assign("ordersdetails",$ordersDetails);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    //订单状态更新
     public function updateOrderStatus(){
           $handleCommonCache=new \Logic\CommonCacheLogic();
           if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
           }
            if($_GET['type']=="rej"){
                 $orderstatus=$_POST['orderid'];
                 $reject=$_POST['reject'];
                 $ma_reject=$_POST['ma_reject'];
                 $handleOrders = new \Logic\Orders();
                 $statusarr=$handleOrders->getOrderStatus($orderstatus);
                if($statusarr['order_status']==2||$statusarr['order_status']==3){
                    $this->error('该订单已审核',U('Orders/auditHouseOrders'),2);
                 }
                if($statusarr['order_status']==0){
                    $status=3;//审核未通过
                    $memo="审核未通过";
                }else{
                    $this->error('订单处理异常',U('Orders/auditHouseOrders'),2);
                }
                $oper_id=cookie("admin_user_name");
                if($reject=="manual"){
                    $desc=$ma_reject;
                }else{
                    $desc=$reject;
                } 
                $handleCoupon = new \Logic\Coupon();
                $coupresult=$handleCoupon->GetcOrdersCoupon($statusarr['id']);
                if($coupresult){
                  $handleCoupon->UpOrdersCoupon($coupresult['order_id']);//修改订单优惠金额为删除状态
                  // $custresult=$handleCoupon->GetCustomerAccounts($statusarr['customer_id']);
                  // $where['customer_id']=$custresult['customer_id'];
                  // $where['account_money']=$custresult['account_money']+$coupresult['coupon_money'];
                }
                $custresult=$handleCoupon->GetCustomerAccounts($statusarr['customer_id']);
                $sumcoupon=$handleOrders->getSumCoupon($statusarr['id']);
                $where['customer_id']=$custresult['customer_id'];
                $where['account_money']=$statusarr['order_pirce_cnt']-$statusarr['price_cnt']-$sumcoupon;
                $handleCoupon->UpCustomerAccounts($where);//修改用户优惠金额
                $handleOrders->upOrderReason($statusarr['id'],$status,$desc);
                $handleOrders->upCoupon($statusarr['customer_id'],$statusarr['id']);//退回优惠
                $addresult=$handleOrders->addOrderStatus($statusarr['id'],$status,$memo,$oper_id,$desc);
                if($addresult){
                        $handleSms = new \Logic\Commonsms();
                        if($statusarr['platform']==0){
                            $handleSms->sendSms($statusarr,'EFW003');
                        }elseif($statusarr['platform']==1||$statusarr['platform']==2){
                            $handleSms->sendSms($statusarr,'EFA003');
                        }    
                        $this->success('已拒绝该订单',U('Orders/auditHouseOrders'),0);
                }

             }else{
                $orderstatus=$_GET['oid'];
                $handleOrders = new \Logic\Orders();
                $statusarr=$handleOrders->getOrderStatus($orderstatus);
                if($statusarr['order_status']==2||$statusarr['order_status']==3){
                    $this->error('该订单已审核',U('Orders/auditHouseOrders'),2);
                 }
                if($statusarr['order_status']==0){
                    $status=2;//待付款
                    $memo="待付款";
                }else{
                    $this->error('订单处理异常',U('Orders/auditHouseOrders'),2);
                }
                $oper_id=cookie("admin_user_name");
                $upresult=$handleOrders->upOrderStatus($statusarr['id'],$status);
                $addresult=$handleOrders->addOrderStatus($statusarr['id'],$status,$memo,$oper_id);
                if($addresult){
                        $handleSms = new \Logic\Commonsms();
                        if($statusarr['platform']==0){
                            $handleSms->sendSms($statusarr,'EFW002');
                        }elseif($statusarr['platform']==1||$statusarr['platform']==2){
                            $handleSms->sendSms($statusarr,'EFA002');
                        }
                        $this->success('审核成功！',U('Orders/auditHouseOrders'),0);
                }
           }
     }

    //获取租客优惠金额
     public function tenantCoupon(){
        $handleOrders = new \Logic\Orders();
        $result=$handleOrders->getTenantCoupon($_GET['order_id']);
        $this->assign("result",$result);
        $this->display();
     }
    //获取操作人
    public function orderOperator(){
     $handleOrders = new \Logic\Orders();
        $result=$handleOrders->getOrderOperator($_GET['order_id']);
        $this->assign("result",$result);
        $this->display('tenantCoupon');

    }

    //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $startTime=strtotime($_GET['startTime']);
         $endTime=strtotime($_GET['endTime']);
         $orderStatus=$_GET['orderStatus'];
         $mobile=$_GET['mobile'];
         $duestart=$_GET['duestart'];
         $dueend=$_GET['dueend'];
         $orderid=$_GET['orderid'];
         $where['orders.record_status']=array('eq',1);
         if($startTime!=""&&$endTime==""){
            $where['orders.create_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
             $where['orders.create_time']=array('lt',$endTime);
         }
         if($startTime!=""&&$endTime!=""){
            $where['orders.create_time']=array(array('gt',$startTime),array('lt',$endTime));
         }
         if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
            $where['orders.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
         if($orderStatus!=""){
            $where['orders.order_status']=array('eq',$orderStatus);
         }
         if($mobile!=""){
             $where['orders.renter_phone']=array('eq',$mobile);
         }
         if($duestart!=""&&$dueend==""){
            $where['orders.price_cnt']=array('egt',$duestart);
         } 
         if($dueend!=""&&$duestart==""){
            $where['orders.price_cnt']=array('elt',$dueend);
         }
        if($duestart!=""&&$dueend!=""){
            $where['orders.create_time']=array(array('gt',$startTime),array('lt',$endTime));
         }
         if($orderid!=""){
            $where['orders.id']=array('eq',$orderid);
         }
         $handleOrders = new \Logic\Orders();
         $rearr=$handleOrders->getOrderExcel($where);
           $handleDownLog= new\Logic\DownLog();
          $handleDownLog->downloadlog($startTime,$endTime,count($rearr));
         $title=array(
                id=>'订单编号',
                renter_name=>'租客姓名',
                renter_phone=>'租客手机',
                price_cnt=>'租客总金额(元)',
                coupon_money=>'优惠(元)',
                order_pirce_cnt=>'租客付款金额(元)',
                order_status=>'状态',
                create_time=>'提交时间'
            );
         $exarr[]=$title;
         foreach ($rearr as $key => $value) {
                if($value['order_status']==0){
                    $value['order_status']="待审核";
                }elseif($value['order_status']==1){
                    $value['order_status']="已取消";
                }elseif($value['order_status']==2){
                    $value['order_status']="待付款";
                }elseif($value['order_status']==3){
                    $value['order_status']="审核未通过";
                }elseif($value['order_status']==4){
                    $value['order_status']="已付款";
                }elseif($value['order_status']==6){
                    $value['order_status']="机构已经打款";
                }elseif($value['order_status']==7){
                    $value['order_status']="直接已退款";
                }elseif($value['order_status']==8){
                    $value['order_status']="打款失败已退款";
                }
                $value['create_time']=date("Y-m-d H:i:s",$value['create_time']); 

                $exarr[]=$value;
         }
            Vendor('phpexcel.phpexcel');
            $xls = new \Excel_XML('UTF-8', false, '订单列表');
            $xls->addArray($exarr);
            $xls->generateXML('订单'.date("YmdHis"));

        // exportexcel($exarr,array('订单编号','租客姓名','租客手机','租客总金额(元)','优惠(元)','租客付款金额(元)','状态','提交时间'),'订单'.date("YmdHis"));
     
    }

}
?>
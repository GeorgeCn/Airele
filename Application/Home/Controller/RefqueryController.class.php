<?php
namespace Home\Controller;
use Think\Controller;
class RefqueryController extends Controller {
    //审核订单
    public function refqueryList(){
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
         $orderstatus=$_GET['orderstatus'];
         $where['record_status']=array('eq',1);
         if($orderstatus==""){
            $where['orders.order_status']=array(array('eq',7),array('eq',8),'or');
            $where['orderstatus.order_status']=array(array('eq',7),array('eq',8),'or');
         }
         if($orderstatus==8){
            $where['orders.order_status']=array('eq',8);
            $where['orderstatus.order_status']=array('eq',8);
         }
         if($orderstatus==7){
            $where['orders.order_status']=array('eq',7);
             $where['orderstatus.order_status']=array('eq',7);
         }
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
    	 if($duestart!=""&&$dueend==""){
            $where['orders.price_cnt']=array('egt',$duestart);
         } 
         if($dueend!=""&&$duestart==""){
            $where['orders.price_cnt']=array('elt',$dueend);
         }
        if($duestart!=""&&$dueend!=""){
            $where['orders.price_cnt']=array(array('gt',$startTime),array('lt',$endTime));
         }
    	 if($orderid!=""){
             $where['orders.id']=array('eq',$orderid);
    	 }
        $handleOrders = new \Logic\Orders();
    	$handleRefquery = new \Logic\Refquery();
        $handleRefund = new \Logic\Refund();
        $count=$handleRefquery->getRefqueryPageCount($where);
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        $list=$handleRefquery->getRefqueryDataList($Page->firstRow,$Page->listRows,$where);
         foreach ($list as $key => $value) {
            $paymanner=$handleOrders->payManner($value['id']);
            $value['pay_platform']=$paymanner['pay_platform'];
            $lists[]=$value;
        }
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$lists);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }
    //订单详情
    public function refqueryDetailed(){
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
            $this->assign("statuslist",$statuslist);
            $this->assign("paymanner",$paymanner);
            $this->assign("client",$client);
            $this->assign("ordersdetails",$ordersDetails);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }

}
?>
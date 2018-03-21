<?php
namespace Home\Controller;
use Think\Controller;
class EarnestController extends Controller {

    public function earnestlist(){
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
    	 $startTime=strtotime(I('get.startTime'));
    	 $endTime=strtotime(I('get.endTime'));
         $mobile=I('get.mobile');
         $ownermobile=I('get.ownermobile');
         $orderid=I('get.orderid');
         $orderstatus=I('get.orderstatus');
         $roomno=I('get.roomno');
         $commission=I('get.commission');
         $city_code=I('get.citycode');
         $where['record_status']=array('eq',1);
    	 if($startTime!=""&&$endTime==""){
            $where['create_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
             $where['create_time']=array('lt',$endTime+86400);
         }
         if($startTime!=""&&$endTime!=""){
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }

        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
    	if($mobile!=""){
             $where['customer_mobile']=array('eq',$mobile);
    	 }
        if($ownermobile!=""){
             $where['owner_mobile']=array('eq',$ownermobile);
         }
         if($orderstatus!=""){
             $where['order_status']=array('eq',$orderstatus);
         }
    	 if($orderid!=""){
             $where['id']=array('eq',$orderid);
    	 }
        if($roomno!=""){
             $where['room_no']=array('eq',$roomno);
         }
         if($commission!=""){
             $where['is_commission']=array('eq',$commission);
         }
         if($city_code!=""){
            $where['city_code']=array('eq',$city_code);
         }
        $modelEarnestOrder=new \Home\Model\earnestorder();
        $modelOrderStatus=new \Home\Model\earnestorderstatus();
        $count=$modelEarnestOrder->modelPageCount($where);
        $Page= new \Think\Page($count,15);
        $list=$modelEarnestOrder->modelPageList($Page->firstRow,$Page->listRows,$where);

        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }

    //所有订金单详情
    public function earnestdetails(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
    
         $modelEarnestOrder=new \Home\Model\earnestorder();
         $modelOrderStatus=new \Home\Model\earnestorderstatus();
         $handleOrders = new \Logic\Orders();
         $handleHouseResourceLogic = new \Logic\HouseResourceLogic();
         $orderid=I('get.oid');
         $where['id']=$orderid;
         $data=$modelEarnestOrder->modelFind($where);
         $paymanner=$handleOrders->payManner($orderid);
         $resource=$handleHouseResourceLogic->getModelById($data['resource_id']);
         $statuswhere['order_id']=$orderid;
         $orderstatus=$modelOrderStatus->modelGet($statuswhere);
         $this->assign("orderstatus",$orderstatus);
         $this->assign("resource",$resource);
         $this->assign("paymanner",$paymanner);
         $this->assign("data",$data);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
    }
    //客服备注
    public function servicedesc(){
           $modelEarnestOrder=new \Home\Model\earnestorder();
          $modelOrderStatus=new \Home\Model\earnestorderstatus();
          $orderid=I('get.orderid');
          $where1['id']=$orderid;
          $data=$modelEarnestOrder->modelFind($where1);
          if($data){
            $data['service_desc']=I('get.desc');
            $data['update_man']=cookie("admin_user_name");
            $data['update_time']=time();
            $re=$modelEarnestOrder->modelUpdate($data);
            if($re){
                echo "{\"status\":\"200\",\"msg\":\" \"}";
            }
          }
    }
    //待打款
    public function remitlist(){
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
         $startTime=strtotime(I('get.startTime'));
         $endTime=strtotime(I('get.endTime'));
         $mobile=I('get.mobile');
         $ownermobile=I('get.ownermobile');
         $orderid=I('get.orderid');
         $roomno=I('get.roomno');
         $city_code=I('get.citycode');
         $where['order_status']=array('eq',2);
         $where['record_status']=array('eq',1);
         $where['signed_time']=array('lt',time()-(3600*24));
         if($startTime!=""&&$endTime==""){
            $where['create_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
             $where['create_time']=array('lt',$endTime+86400);
         }
         if($startTime!=""&&$endTime!=""){
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }

        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
        if($mobile!=""){
             $where['customer_mobile']=array('eq',$mobile);
         }
        if($ownermobile!=""){
             $where['owner_mobile']=array('eq',$ownermobile);
         }
         if($orderstatus!=""){
             $where['order_status']=array('eq',$orderstatus);
         }
         if($orderid!=""){
             $where['id']=array('eq',$orderid);
         }
        if($roomno!=""){
             $where['room_no']=array('eq',$roomno);
         }
         if($commission!=""){
             $where['is_commission']=array('eq',$commission);
         }
         if($city_code!=""){
            $where['city_code']=$city_code;
         }
        $modelEarnestOrder=new \Home\Model\earnestorder();
        $modelOrderStatus=new \Home\Model\earnestorderstatus();
        $count=$modelEarnestOrder->modelPageCount($where);
        $Page= new \Think\Page($count,15);
        $list=$modelEarnestOrder->modelPageList($Page->firstRow,$Page->listRows,$where);

        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }

     //待打款详情
    public function remitdetails(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");

         $modelEarnestOrder=new \Home\Model\earnestorder();
         $modelOrderStatus=new \Home\Model\earnestorderstatus();
         $handleOrders = new \Logic\Orders();
         $handleHouseResourceLogic = new \Logic\HouseResourceLogic();
         $orderid=I('get.oid');
         $where['id']=$orderid;
         $data=$modelEarnestOrder->modelFind($where);
         $paymanner=$handleOrders->payManner($orderid);
          $resource=$handleHouseResourceLogic->getModelById($data['resource_id']);
         $this->assign("resource",$resource);
          $this->assign("paymanner",$paymanner);
         $this->assign("data",$data);
         $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }

    //确认打款
    public function remitpay(){
          $modelEarnestOrder=new \Home\Model\earnestorder();
          $modelOrderStatus=new \Home\Model\earnestorderstatus();
          $handleSms = new \Logic\Commonsms();
          $orderid=I('get.orderid');
          $where1['id']=$orderid;
          $where1['order_status']=2;
          $result=$modelEarnestOrder->modelFind($where1);
          if($result){
            $where['id']=$orderid;
            $data=$modelEarnestOrder->modelFind($where);
            $data['order_status']=6;
            $data['update_man']=cookie("admin_user_name");
            $data['update_time']=time();
            $re=$modelEarnestOrder->modelUpdate($data);
            $datastatus['id']=create_guid();
            $datastatus['order_id']=$orderid;
            $datastatus['order_status']=6;
            $datastatus['create_time']=time();
            $datastatus['memo']="已打款";
            $datastatus['oper_id']=cookie("admin_user_name");
            $modelOrderStatus->modelAdd($datastatus);
            if($re){
                    $smsendarr['renter_phone']=$data['customer_mobile'];
                    $smsendarr['create_time']=$data['create_time'];
                    $smsendarr['renter_name']=$data['customer_name'];
                    $smsendarr['price_cnt']=$data['earnest_money'];
                    $smsendarr['id']=$data['id'];

                    $handleSms->sendSms($smsendarr,'DJ006');
                    $smsownerarr['renter_phone']=$data['owner_mobile'];
                    $smsownerarr['create_time']=$data['create_time'];
                    $smsownerarr['renter_name']=$data['customer_name']."(".$data['customer_mobile'].")";
                    $smsownerarr['price_cnt']=$data['earnest_money'];
                    $smsownerarr['id']=$data['id'];
                    $handleSms->sendSms($smsownerarr,'DJ007');
                echo "{\"status\":\"200\",\"msg\":\"已打款 \"}";
            }
          }

    }

    //待退款
    public function refundlist(){
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
         $startTime=strtotime(I('get.startTime'));
         $endTime=strtotime(I('get.endTime'));
         $mobile=I('get.mobile');
         $ownermobile=I('get.ownermobile');
         $orderid=I('get.orderid');
         $roomno=I('get.roomno');
          $city_code=I('get.citycode');
         $where['order_status']=array('eq',4);
         $where['record_status']=array('eq',1);
         if($startTime!=""&&$endTime==""){
            $where['create_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
             $where['create_time']=array('lt',$endTime+86400);
         }
         if($startTime!=""&&$endTime!=""){
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }

        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
        if($mobile!=""){
             $where['customer_mobile']=array('eq',$mobile);
         }
        if($ownermobile!=""){
             $where['owner_mobile']=array('eq',$ownermobile);
         }
         if($orderstatus!=""){
             $where['order_status']=array('eq',$orderstatus);
         }
         if($orderid!=""){
             $where['id']=array('eq',$orderid);
         }
        if($roomno!=""){
             $where['room_no']=array('eq',$roomno);
         }
         if($commission!=""){
             $where['is_commission']=array('eq',$commission);
         }
         if($city_code!=""){
            $where['city_code']=$city_code;
         }
        $modelEarnestOrder=new \Home\Model\earnestorder();
        $modelOrderStatus=new \Home\Model\earnestorderstatus();
        $count=$modelEarnestOrder->modelPageCount($where);
        $Page= new \Think\Page($count,15);
        $list=$modelEarnestOrder->modelPageList($Page->firstRow,$Page->listRows,$where);

        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();

    }

        //退款申请详情
    public function refunddetails(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
    
         $modelEarnestOrder=new \Home\Model\earnestorder();
         $modelOrderStatus=new \Home\Model\earnestorderstatus();
         $handleOrders = new \Logic\Orders();
          $handleHouseResourceLogic = new \Logic\HouseResourceLogic();
         $orderid=I('get.oid');
         $where['id']=$orderid;
         $data=$modelEarnestOrder->modelFind($where);
         $paymanner=$handleOrders->payManner($orderid);
          $resource=$handleHouseResourceLogic->getModelById($data['resource_id']);
         $this->assign("resource",$resource);
          $this->assign("paymanner",$paymanner);
         $this->assign("data",$data);
         $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }
   //退款
   public function refundpay(){
          $modelEarnestOrder=new \Home\Model\earnestorder();
          $modelOrderStatus=new \Home\Model\earnestorderstatus();
          $handleSms = new \Logic\Commonsms();
          $modelTracking=new \Home\Model\customertracking();
          $orderid=I('get.orderid');
          $paytype=I('get.paytype');
          $desc=I('get.desc');
          $where1['id']=$orderid;
          $result=$modelEarnestOrder->modelFind($where1);
          if($result){
            $where['id']=$orderid;
            $data=$modelEarnestOrder->modelFind($where);
            if($paytype==1){
                $data['order_status']=5;
            }else if($paytype==2){
                $data['order_status']=6;
            }
            
            $data['update_man']=cookie("admin_user_name");
            $data['update_time']=time();
            $re=$modelEarnestOrder->modelUpdate($data);
            $datastatus['id']=create_guid();
            $datastatus['order_id']=$orderid;
            if($paytype==1){
              $datastatus['order_status']=5;
              $datastatus['memo']="已退款";
            }elseif($paytype==2){
              $datastatus['order_status']=6;
              $datastatus['memo']="已打款";
            }
            $datastatus['create_time']=time();
            $datastatus['oper_id']=cookie("admin_user_name");
            $datastatus['desc']=$desc;
            $modelOrderStatus->modelAdd($datastatus);
            //更新租客跟踪
            if($paytype==2){
                 $twhere['customer_id']=$data['customer_id'];
                 $trackingarr=$modelTracking->getModelByCondition($twhere);
                  if($trackingarr){
                      $trackingarr['update_time']=time();
                      $trackingarr['update_man']=cookie("admin_user_name");
                      $trackingarr['bakinfo']="支付定金";
                      $modelTracking->updateModel($trackingarr);
                      $trackdata['tracking_id']=$trackingarr['id'];
                      $trackdata['renter_status']=$trackingarr['renter_status'];
                      $trackdata['renter_room']=$trackingarr['renter_room'];
                      $trackdata['renter_time']=$trackingarr['renter_time'];
                      $trackdata['bakinfo']="支付定金";
                      $trackdata['renter_source']=$trackingarr['renter_source'];
                      $trackdata['is_service']=$trackingarr['is_service'];
                      $trackdata['create_time']=time();
                      $trackdata['create_man']=cookie("admin_user_name");
                      $trackdata['is_look']=$trackingarr['is_look'];
                      $trackdata['is_satisfied']=$trackingarr['is_satisfied'];
                      $trackdata['is_recommend']=$trackingarr['is_recommend'];
                      $modelTracking->addLogModel($trackdata);
                  }
            }
            if($re){
                if($paytype==1){
                    $smsendarr['renter_phone']=$data['customer_mobile'];
                    $smsendarr['create_time']=$data['create_time'];
                    $smsendarr['renter_name']=$data['customer_name'];
                    $smsendarr['price_cnt']=$data['earnest_money'];
                    $smsendarr['id']=$data['id'];
                    $handleSms->sendSms($smsendarr,'DJ004');
                    $smsownerarr['renter_phone']=$data['owner_mobile'];
                    $smsownerarr['create_time']=$data['create_time'];
                    $smsownerarr['renter_name']=$data['customer_name']."(".$data['customer_mobile'].")";
                    $smsownerarr['price_cnt']=$data['earnest_money'];
                    $smsownerarr['id']=$data['id'];
                    $handleSms->sendSms($smsownerarr,'DJ005');
                }else if($paytype==2){
                    $smsendarr['renter_phone']=$data['customer_mobile'];
                    $smsendarr['create_time']=$data['create_time'];
                    $smsendarr['renter_name']=$data['customer_name'];
                    $smsendarr['price_cnt']=$data['earnest_money'];
                    $smsendarr['id']=$data['id'];
                    $handleSms->sendSms($smsendarr,'DJ006');
                    $smsownerarr['renter_phone']=$data['owner_mobile'];
                    $smsownerarr['create_time']=$data['create_time'];
                    $smsownerarr['renter_name']=$data['customer_name']."(".$data['customer_mobile'].")";
                    $smsownerarr['price_cnt']=$data['earnest_money'];
                    $smsownerarr['id']=$data['id'];
                    $handleSms->sendSms($smsownerarr,'DJ007');
                }
                
                echo "{\"status\":\"200\",\"msg\":\"已打款 \"}";
            }
          }


   }
}
?>
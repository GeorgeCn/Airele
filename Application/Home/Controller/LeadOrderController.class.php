<?php
namespace Home\Controller;
use Think\Controller;
class LeadOrderController extends Controller{

   public function leadorderlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),7);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),7);
       $handleMenu->jurisdiction();
      $modelServiceOrder=new \Home\Model\fhserviceorder();
      $handleRegion = new \Logic\Paramregion();
      $handleOrders = new \Logic\Orders();
       $handleCustomerLogic = new \Logic\CustomerLogic();

       $where1['parent_id']=0;
       $region=$handleRegion->getParamRegionList($where1);
       $region_id=I('get.regionid');
       $mobile=I('get.mobile');
       $name=I('get.name');
       $orderstatus=I('get.orderstatus');
       $orderid=I('get.orderid');
       $citycode=I('get.citycode');
       $cumobile=I('get.cumobile');
       if($region_id!=""){
          $where['fhserviceman.region_id']=array('eq',$region_id);
       }
       if($mobile!=""){
          $where['fhserviceman.mobile']=array('eq',$mobile);
       }
       if($name!=""){
          $where['fhserviceman.name']=array('eq',$name);
       }
       if($orderstatus!=""){
          $where['fhserviceorder.order_status']=array('eq',$orderstatus);
       }
       if($orderstatus==""){
          $where['fhserviceorder.order_status']=array('gt',1);
      }
      if($orderid!=""){
          $where['fhserviceorder.id']=array('eq',$orderid);
      }
      if($citycode!=""){
         $where['fhserviceorder.city_code']=array('eq',$citycode);
       }
      if($cumobile!=""){
          $customerarr=$handleCustomerLogic->getResourceClientByPhone($cumobile);
          $where['fhserviceorder.customer_id']=array('eq',$customerarr['id']);
     }
      $count=$modelServiceOrder->modelOrderCount($where);
      $Page= new \Think\Page($count,15);
      $listarr=$modelServiceOrder->modelOrderSelect($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
           if($value['city_code']=='001009001'){
               $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001009001';
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }elseif($value['city_code']=='001001'){
              $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001001';
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }elseif($value['city_code']=='001011001'){
              $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001011001';
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }
          $value['region_name']=$regionarr['cname'];
          $paymanner=$handleOrders->payManner($value['id']);
          $value['pay_platform']=$paymanner['pay_platform'];
          $customer=$handleCustomerLogic->getModelById($value['customer_id']);
          $value['customer_mobile']=$customer['mobile'];
          $list[]=$value;
      }
      $this->assign("region",$region);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }


   public function refundlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),7);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),7);
       $handleMenu->jurisdiction();
      $modelServiceOrder=new \Home\Model\fhserviceorder();
      $handleRegion = new \Logic\Paramregion();
      $handleOrders = new \Logic\Orders();
       $handleCustomer = new \Logic\CustomerLogic();
       $where1['parent_id']=0;
       $region=$handleRegion->getParamRegionList($where1);
        $region_id=I('get.regionid');
       $mobile=I('get.mobile');
       $name=I('get.name');
        $orderid=I('get.orderid');
         $citycode=I('get.citycode');
       if($region_id!=""){
          $where['fhserviceman.region_id']=array('eq',$region_id);
       }
      if($mobile!=""){
          $where['fhserviceman.mobile']=array('eq',$mobile);
      }
      if($name!=""){
          $where['fhserviceman.name']=array('eq',$name);
      }
      if($orderid!=""){
          $where['fhserviceorder.id']=array('eq',$orderid);
      }
       if($citycode!=""){
         $where['fhserviceorder.city_code']=array('eq',$citycode);
       }
      $where['fhserviceorder.order_status']=3;
      $count=$modelServiceOrder->modelOrderCount($where);
      $Page= new \Think\Page($count,15);
      $listarr=$modelServiceOrder->modelOrderSelect($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
         if($value['city_code']=='001009001'){
               $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001009001';
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }elseif($value['city_code']=='001001'){
              $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001001';
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }elseif($value['city_code']=='001011001'){
              $rewhere['id']=$value['region_id'];
               $rewhere['city_code']='001011001';
       
              $regionarr=$modelServiceOrder->getParamRegion($rewhere);
         }
        
          $value['region_name']=$regionarr['cname'];
          $paymanner=$handleOrders->payManner($value['id']);
          $value['pay_platform']=$paymanner['pay_platform'];
          $cumobile=$handleCustomer->getModelById($value['customer_id']);
          $value['cumobile']=$cumobile['mobile'];
          $list[]=$value;
      }

      $this->assign("region",$region);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }

   public function refundoperation(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
                 $this->error('非法操作',U('Index/index'),1);
          }
          $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
          $handleMenu = new \Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),7);
          $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),7);
          $modelServiceOrder=new \Home\Model\fhserviceorder();
          $modelServiceMan=new \Home\Model\fhserviceman();
          $modelServiceComment=new \Home\Model\fhservicecomment();
          $handleRegion = new \Logic\Paramregion();
          $handleOrders = new \Logic\Orders();
          $handleCustomerLogic = new \Logic\CustomerLogic();
          $orderid=I('get.orderid');
          $whereorder['id']=$orderid;
          $orderarr=$modelServiceOrder->modelFind($whereorder);//获取订单信息
          $wherecomment['customer_id']=$orderarr['customer_id'];
          $wherecomment['owner_id']=$orderarr['owner_id'];
          $wherecomment['order_id']=$orderid;
          $comment=$modelServiceComment->modelFind($wherecomment);//获取评价信息

          $paymanner=$handleOrders->payManner($orderid);//支付方式

          $wherebd['id']=$orderarr['owner_id'];
          $manarr=$modelServiceMan->modelFind($wherebd);//获取bd信息
          
          $region=$handleRegion->getParamRegion($manarr['region_id']);//获取板块

          $customer=$handleCustomerLogic->getModelById($orderarr['customer_id']);//租客信息
          $this->assign("customer",$customer);
          $this->assign("region",$region);
          $this->assign("orderarr",$orderarr);
          $this->assign("comment",$comment);
          $this->assign("paymanner",$paymanner);
          $this->assign("manarr",$manarr);
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->display();
   }

   //退款
   public function refundpay(){
         $modelServiceOrder=new \Home\Model\fhserviceorder();
         $modelServiceStatus=new \Home\Model\fhserviceorderstatus();
         $orderid=I('get.orderid');
         $paytype=I('get.paytype');
         $desc=I('get.desc');
         if($paytype==1){
            $where['id']=$orderid;
            $orderarr=$modelServiceOrder->modelFind($where);
            $orderarr['order_status']=4;
            $result=$modelServiceOrder->modelUpdate($orderarr);
            if($result){
                $data['id']=create_guid();
                $data['order_id']=$orderarr['id'];
                $data['order_status']=4;
                $data['create_time']=time();
                $data['memo']="已退款";
                $data['oper_id']=cookie("admin_user_name");
                $data['desc']=$desc;
                $result=$modelServiceStatus->modelAdd($data);
                if($result){
                    $handleSms = new \Logic\Commonsms();
                    $handleCustomerLogic = new \Logic\CustomerLogic();
                    $customer=$handleCustomerLogic->getModelById($orderarr['customer_id']);//租客信息
                    $smsownerarr['renter_phone']=$customer['mobile'];
                    $smsownerarr['create_time']=time();
                    $smsownerarr['renter_name']=$customer['true_name'];
                    $smsownerarr['price_cnt']="0";
                    $smsownerarr['id']="xx";
                    $handleSms->sendSms($smsownerarr,'FHS005');
                    echo "{\"status\":\"200\",\"msg\":\"\"}";
                }
            }
         }
   }
     //订单列表退款
     public function orderrefund(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
                 $this->error('非法操作',U('Index/index'),1);
          }
          $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
          $handleMenu = new \Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),7);
          $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),7);
          $modelServiceOrder=new \Home\Model\fhserviceorder();
          $modelServiceMan=new \Home\Model\fhserviceman();
          $modelServiceComment=new \Home\Model\fhservicecomment();
          $handleRegion = new \Logic\Paramregion();
          $handleOrders = new \Logic\Orders();
          $handleCustomerLogic = new \Logic\CustomerLogic();
          $modelServiceStatus=new \Home\Model\fhserviceorderstatus();
          $orderid=I('get.orderid');
          $whereorder['id']=$orderid;
          $orderarr=$modelServiceOrder->modelFind($whereorder);//获取订单信息
          $wherecomment['customer_id']=$orderarr['customer_id'];
          $wherecomment['owner_id']=$orderarr['owner_id'];
          $wherecomment['order_id']=$orderid;
          $comment=$modelServiceComment->modelFind($wherecomment);//获取评价信息

          $paymanner=$handleOrders->payManner($orderid);//支付方式

          $wherebd['id']=$orderarr['owner_id'];
          $manarr=$modelServiceMan->modelFind($wherebd);//获取bd信息
          
          $region=$handleRegion->getParamRegion($manarr['region_id']);//获取板块

          $customer=$handleCustomerLogic->getModelById($orderarr['customer_id']);//租客信息
          $wherestatus['order_id']=$orderid;
          $wherestatus['order_status']=4;
          $statusarr=$modelServiceStatus->modelFind($wherestatus);//获取备注
          $this->assign("statusarr",$statusarr);
          $this->assign("customer",$customer);
          $this->assign("region",$region);
          $this->assign("orderarr",$orderarr);
          $this->assign("comment",$comment);
          $this->assign("paymanner",$paymanner);
          $this->assign("manarr",$manarr);
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->display();
     }

     public function pftime(){
         $modelServiceStatus=new \Home\Model\fhserviceorderstatus();
         $orderid=I('get.orderid');
         $where['order_id']=$orderid;
         $where['order_status']=1;
         $startime=$modelServiceStatus->modelFind($where);
         $where1['order_id']=$orderid;
         $where1['order_status']=4;
         $fcount1=$modelServiceStatus->modelFind($where1);
         $where1['order_id']=$orderid;
         $where1['order_status']=5;
         $fcount2=$modelServiceStatus->modelFind($where1);
         if($fcount1){
          $endtime=$fcount1['create_time'];
         }elseif($fcount2){
            $endtime=$fcount2['create_time'];
         }
             $startimedate="";
             $endtimedate="";
              if($startime['create_time']!=0&&$startime['create_time']!=""){
                $startimedate=date("Y-m-d H:i:s",$startime['create_time']);
              }
              if($endtime!=0&&$endtime!=""){
                $endtimedate=date("Y-m-d H:i:s",$endtime);
              }
            $array=array('status'=>'200','startime'=>$startimedate,'endtime'=>$endtimedate);
            echo json_encode($array);
         
     }



    //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $modelServiceOrder=new \Home\Model\fhserviceorder();
       $handleOrders = new \Logic\Orders();
       $handleCustomerLogic = new \Logic\CustomerLogic();
       $where['fhserviceorder.order_status']=array('gt',1);
      $listarr=$modelServiceOrder->modelOrderSelect(0,9999999,$where);
      foreach ($listarr as $key => $value) {
          $value1['id']=$value['id'];
          $customer=$handleCustomerLogic->getModelById($value['customer_id']);
          $value1['customer_mobile']=$customer['mobile'];
          $value1['start_time']=$value['start_time'];
          $value1['end_time']=$value['end_time'];
          $value1['price']=$value['price'];

          $paymanner=$handleOrders->payManner($value['id']);
          $value1['pay_platform']=$paymanner['pay_platform'];
           $value1['order_status']=$value['order_status'];
          $list[]=$value1;
      }


        $title=array(
            'room_no'=>'订单号','customer_mobile'=>'租客手机','start_time'=>'付款时间','end_time'=>'结束时间 ','price'=>'付款金额','pay_platform'=>'付款方式',
            'order_status'=>'状态');
        $excel[]=$title;
        foreach ($list as $key => $value) {
           
           if($value['pay_platform']==0){
            $value['pay_platform']="微信";
           }elseif($value['pay_platform']==1){
            $value['pay_platform']=" 银联";
           }elseif($value['pay_platform']==2){
               $value['pay_platform']="支付宝";
           }
           if($value['order_status']==2){
            $value['order_status']="服务中";
           }elseif($value['order_status']==3){
            $value['order_status']=" 退款中";
           }elseif($value['order_status']==4){
               $value['order_status']="已退款";
           }elseif($value['order_status']==5){
              $value['order_status']="已完成";
           }
            $value['start_time']=$value['start_time']>0?date("Y-m-d H:i",$value['start_time']):""; 
            $value['end_time']=$value['end_time']>0?date("Y-m-d H:i",$value['end_time']):"";
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '短信问房');
        $xls->addArray($excel);
        $xls->generateXML('短信问房'.date("YmdHis"));
     }
}
?>
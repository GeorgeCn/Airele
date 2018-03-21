<?php
namespace Home\Controller;
use Think\Controller;
class CheckingController extends Controller {
    public function receipts(){
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
        $Page= new \Think\Page($count,15);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }

      //下载进出账
    public function dowChecking(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $dowtype=I('get.dowtype');
        $startTime=strtotime(I('get.startime'));
         $endTime=strtotime(I('get.endtime'))+86400;
         $gaptime=$endTime-$startTime;
         $handleChecking=new \Logic\Checking();
         $handleOrders = new \Logic\Orders();
         Vendor('phpexcel.phpexcel');
         //进账
         if($dowtype==1){
             $rearr=$handleChecking->modelreceipts(date("Y-m-d H:i:s",$startTime),date('Y-m-d H:i:s',$endTime));
              $title=array(
                    room_id=>'订单编号',
                    mobile=>'租客姓名',
                    owner_mobile=>'房东姓名',
                    gaodu_platform=>'租客付款金额',
                    create_time=>'优惠金额',
                    true_name=>'需打款金额',
                    resource=>'支付方式',
                    order_status=>'状态',
                    create_man=>'付款时间',
             );
              $exarr[]= $title;
             foreach ($rearr as $key => $value){
                 $cwhere['order_id']=$value['id'];
                 $cwhere['record_status']=1;
                 $cwhere['coupon_type']=2;
                 $couponarr =$handleOrders->modelGetCoupon($cwhere);
                 if($couponarr){
                    $value['order_pirce_cnt']=$value['price_cnt'];
                 }
                $exarr[]=$value;
             }
         
                $xls = new \Excel_XML('UTF-8', false, '进账');
                $xls->addArray($exarr);
                $xls->generateXML(''.date("YmdHis"));
            
        }
        //出账
     if($dowtype==2){
       $enterarr=$handleChecking->modelenter(date("Y-m-d H:i:s",$startTime),date('Y-m-d H:i:s',$endTime));
         $title1=array(
                room_id=>'订单编号',
                mobile=>'租客姓名',
                owner_mobile=>'房东姓名',
                gaodu_platform=>'租客付款金额',
                create_time=>'优惠金额',
                true_name=>'需打款金额',
                resource=>'支付方式',
                order_status=>'状态',
                create_man=>'付款时间',
                beizhu=>'备注',
         );
         $exarr1[]= $title1;
         foreach ($enterarr as $key => $value) {
             $cwhere['order_id']=$value['id'];
             $cwhere['record_status']=1;
             $cwhere['coupon_type']=2;
             $couponarr =$handleOrders->modelGetCoupon($cwhere);
             if($couponarr){
                $value['order_pirce_cnt']=$value['price_cnt'];
             }
            $exarr1[]=$value;
         }
            $xls = new \Excel_XML('UTF-8', false, '出账');
            $xls->addArray($exarr1);
            $xls->generateXML(''.date("YmdHis"));
        
     }
        //退款
        if($dowtype==3){
           $reimbursearr=$handleChecking->modelreimburse(date("Y-m-d H:i:s",$startTime),date('Y-m-d H:i:s',$endTime));
             $title2=array(
                    room_id=>'订单编号',
                    mobile=>'租客姓名',
                    owner_mobile=>'房东姓名',
                    gaodu_platform=>'租客付款金额',
                    create_time=>'优惠金额',
                    true_name=>'需打款金额',
                    resource=>'支付方式',
                    order_status=>'状态',
                    create_man=>'退款时间',
             );
             $exarr2[]= $title2;
             foreach ($reimbursearr as $key => $value) {
                 $cwhere['order_id']=$value['id'];
                 $cwhere['record_status']=1;
                 $cwhere['coupon_type']=2;
                 $couponarr =$handleOrders->modelGetCoupon($cwhere);
                 if($couponarr){
                    $value['order_pirce_cnt']=$value['price_cnt'];
                 }
                $exarr2[]=$value;
             }
                $xls = new \Excel_XML('UTF-8', false, '退款');
                $xls->addArray($exarr2);
                $xls->generateXML(''.date("YmdHis"));
              
            }
      }

}
?>
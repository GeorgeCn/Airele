<?php
namespace Home\Controller;
use Think\Controller;
class ReportController extends Controller{

   public function reportlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
       $handleMenu->jurisdiction();
      $handleReport = new \Logic\ReportLogic();
       $startTime=strtotime(I('get.startTime'));
       $endTime=strtotime(I('get.endTime'));
      $room_no=I('get.roomno');
      $owner_mobile=I('get.ownermobile');
      $customer_mobile=I('get.customermobile');
      $deal_flag=I('get.dealflag');
      $report_type=I('get.reporttype');
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
      if($room_no!=""){
         $where['room_no']=array('eq',$room_no);
      }
      if($owner_mobile!=""){
         $where['owner_mobile']=array('eq',$owner_mobile);
      }
      if($customer_mobile!=""){
         $where['customer_mobile']=array('eq',$customer_mobile);
      }
      if($deal_flag!=""){
         $where['deal_flag']=array('eq',$deal_flag);
      }
      if($report_type!=""){
         $where['report_type']=array('eq',$report_type);
      }
      $count=$handleReport->getReportPageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
           $Page->parameter[$key]=urlencode($val);
      }
      $list=$handleReport->getReportDataList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }

   public function reportaudit(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $handleReport = new \Logic\ReportLogic();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
      $report_id=$_GET['pid'];
      $where['id']=$report_id;
      $result=$handleReport->getReportFind($where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("data",$result);
      $this->display();
   }
   public function disposeaudit(){
    $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
      $handleReport = new \Logic\ReportLogic();
      $handleCustomerNotify = new \Logic\CustomerNotifyLogic();
      $handleHouseRoom = new \Logic\HouseRoomLogic();
      $handleHouseResource = new \Logic\HouseResourceLogic();
      $handleCouponManage = new \Logic\CouponManage();
      $handleCoustomerCoupon = new \Logic\CoustomerCouponLogic();
      $report_id=$_GET['pid'];
      $customer_id=$_GET['cid'];
      $type=$_GET['type'];
      $deal_content=$_GET['deal_content'];
      $pr_where['id']=$report_id;
      $admin['user_name']=cookie("admin_user_name");
      $reportarr=$handleReport->getReportFind($pr_where);
      $admin_user=$handleReport->modelGetAdmin($admin);
      if($type==1){
          $reportarr['deal_flag']=1;
      }else{
          $reportarr['deal_flag']=2;
          $reportarr['deal_content']=$deal_content;
      }
      $reportarr['deal_time']=time();
      $reportarr['oper_id']=$admin_user['id'];
      $reportarr['oper_name']=cookie("admin_user_name");
      $result=$handleReport->modelUpdate($reportarr);
      if($result){
           if($reportarr['report_type']==1){
               $report_type="房间已出租";
           }elseif($reportarr['report_type']==2){
              $report_type="房东不接电话";
           }elseif($reportarr['report_type']==3){
              $report_type="房东是中介";
           }
           if($reportarr['report_content']==""){
              $report_content=$report_type;
           }else{
              $report_content=$reportarr['report_content'];
           }
          
           $roomarr=$handleHouseRoom->getModelById($reportarr['room_id']);
           $resourarr=$handleHouseResource->getModelById($reportarr['resource_id']);
           $data['id']=create_guid();
           $data['customer_id']=$reportarr['customer_id'];
           $data['title']="举报反馈";
           if($type==1){ 
              $couponarr=$handleCouponManage->getCouponManage('999');
               if($couponarr['end_date'] < time()){
                    $this->success('活动已结束！', 'reportlist.html?no=3&leftno=62');
                      return;
                }
              
              if($couponarr['effective_type']==0){
                  $deadline=$couponarr['effective_date'];
              }elseif($couponarr['effective_type']==1){
                  $deadline=time()+($couponarr['effective_date']*86400);
              }
              $coupondata['id']=create_guid();
              $coupondata['customer_id']=$reportarr['customer_id'];
              $coupondata['coupon_money']=$couponarr['price'];
              $coupondata['coupon_type']=1;
              $coupondata['activity_id']=$couponarr['id'];
              $coupondata['activity_name']=$couponarr['name'];
              $coupondata['effectivedate']=$deadline;
              $coupondata['coupon_from']=$couponarr['name'];
              $coupondata['create_time']=time();
              $handleCoustomerCoupon->AddCustomerCoupon($coupondata);
              $data['content']="<font color='#666666'>你对房源</font><font color='#444444'> [ ".$resourarr['estate_name']."-".$roomarr['room_name']."-".$roomarr['room_area']."平 ] </font><font color='#666666'>的举报“".$report_content."”已经审核通过了，您可以在“我的优惠券”页面查看举报奖励。</font>";
           }else{
              $data['content']="<font color='#666666'>你对房源</font><font color='#444444'> [ ".$resourarr['estate_name']."-".$roomarr['room_name']."-".$roomarr['room_area']."平 ] </font><font color='#666666'>的举报“".$report_content."”经过确认，".$deal_content."。</font>";
           }
           $data['create_time']=time();
           $handleCustomerNotify->modelAdd($data);
           if(C('IS_CACHE')){
               $cache_report_no=$reportarr['customer_id']."report_no";
               $report_no_key=  set_cache_public_key($cache_report_no);
               $report_no_value=get_couchbase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$report_no_key);
               $report_no_value=$report_no_value+1;
               set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$report_no_key,$report_no_value,0);
            }
           $this->success('审核成功！', 'reportlist.html?no=3&leftno=62');
      }
   }

   //获取房间来源
   public function gethousesource(){
      $handleHouseRoom = new \Logic\HouseRoomLogic();
      $room_id=I('get.room_id');
      if($room_id!=""){
          $roomarr=$handleHouseRoom->getModelById($room_id);
          $array=array('info_resource'=>$roomarr['info_resource'],'create_man'=>$roomarr['create_man']);
          echo json_encode($array);
      }
   }
    //导出excel
    public function downloadExcel(){
         $handleReport = new \Logic\ReportLogic();
         $handleHouseRoom = new \Logic\HouseRoomLogic();
         $startTime=strtotime(I('get.startTime'));
         $endTime=strtotime(I('get.endTime'));
          $room_no=I('get.roomno');
          $owner_mobile=I('get.ownermobile');
          $customer_mobile=I('get.customermobile');
          $deal_flag=I('get.dealflag');
          $report_type=I('get.reporttype');
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
          if($room_no!=""){
             $where['room_no']=array('eq',$room_no);
          }
          if($owner_mobile!=""){
             $where['owner_mobile']=array('eq',$owner_mobile);
          }
          if($customer_mobile!=""){
             $where['customer_mobile']=array('eq',$customer_mobile);
          }
          if($deal_flag!=""){
             $where['deal_flag']=array('eq',$deal_flag);
          }
          if($report_type!=""){
             $where['report_type']=array('eq',$report_type);
          }
          $list=$handleReport->getReportDataList(0,9999999999,$where);
          $handleDownLog= new\Logic\DownLog();
          $handleDownLog->downloadlog($startTime,$endTime,count($list));
          foreach ($list as $key => $value) {
                  $roomarr=$handleHouseRoom->getModelById($value['room_id']);
                  $value['info_resource']=$roomarr['info_resource'];
                  $value['create_man']=$roomarr['create_man'];
                  $result[]=$value;
          }
         $newarr = array();
         foreach ($result as $key1 => $value1) {
              foreach ($value1 as $key2 => $value2) {
                  if($key2=='resource_no'){
                    $value['resource_no']=$value2;
                  }elseif($key2=='room_no'){
                    $value['room_no']=$value2;
                  }elseif($key2=='info_resource'){
                    $value['info_resource']=$value2;
                  }elseif($key2=='create_man'){
                    $value['create_man']=$value2;
                  }elseif($key2=='owner_mobile'){
                    $value['owner_mobile']=$value2;
                  }elseif($key2=='customer_mobile'){
                    $value['customer_mobile']=$value2;
                  }elseif($key2=='report_type'){
                    $value['report_type']=$value2;
                  }elseif($key2=='report_content'){
                    $value['report_content']=$value2;
                  }elseif($key2=='create_time'){
                    $value['create_time']=$value2;
                  }elseif($key2=='deal_time'){
                    $value['deal_time']=$value2;
                  }elseif($key2=='deal_flag'){
                    $value['deal_flag']=$value2;
                  }elseif($key2=='oper_name'){
                    $value['oper_name']=$value2;
                  }
               }
               $newarr[]=$value;
         }
         $title=array(
                resource_no=>'房源编号',
                room_no=>'房间编号',
                info_resource=>'房间来源',
                create_man=>'负责人',
                owner_mobile=>'房东电话',
                customer_mobile=>'举报人电话',
                report_type=>'举报类型',
                report_content=>'举报内容',
                create_time=>'举报时间',
                deal_time=>'处理时间',
                deal_flag=>'状态',
                oper_name=>'操作人',
            );
         $exarr[]=$title;
         foreach ($newarr as $key3 => $value3) {
                $value4['resource_no']=$value3['resource_no'];
                $value4['room_no']=$value3['room_no'];  
                $value4['info_resource']=$value3['info_resource'];
                $value4['create_man']=$value3['create_man'];
                $value4['owner_mobile']=$value3['owner_mobile'];
                $value4['customer_mobile']=$value3['customer_mobile'];
                if($value3['report_type']==1){
                    $value4['report_type']="房间已出租";
                }elseif($value3['report_type']==2){
                    $value4['report_type']="房东不接电话";
                }elseif($value3['report_type']==3){
                    $value4['report_type']="房东是中介";
                }elseif($value3['report_type']==4){
                    $value4['report_type']="其他";
                }elseif($value3['report_type']==5){
                    $value4['report_type']="房间地址错误";
                }elseif($value3['report_type']==6){
                    $value4['report_type']="房间信息错误";
                }
                $value4['report_content']=$value3['report_content'];   
                $value4['create_time']=date("Y-m-d H:i:s",$value3['create_time']);
                $value4['deal_time']=date("Y-m-d H:i:s",$value3['deal_time']); 
                if($value3['deal_flag']==0){
                    $value4['deal_flag']="待审核";
                }elseif($value3['deal_flag']==1){
                    $value4['deal_flag']="已通过";
                }elseif($value3['deal_flag']==2){
                    $value4['deal_flag']="已拒绝";
                }
                $value4['oper_name']=$value3['oper_name'];   
                $exarr[]=$value4;
         }
         if($gaptime>3600*24*7 || empty($where)){
            $this->success('下载数据不能超过一个星期！','reportlist.html?no=6&leftno=34');
         }else{
            Vendor('phpexcel.phpexcel');
            $xls = new \Excel_XML('UTF-8', false, '举报审核');
            $xls->addArray($exarr);
            $xls->generateXML('举报审核'.date("YmdHis"));     
         }
    }
    //根据房间编号查找店铺
    public function findStoreID ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)) {
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');//room_no
        $handleHouseRoom = new \Logic\ReportLogic();
        $storeID = $handleHouseRoom->findHouseRoom($data);
        $json['code'] = 200;
        $json['message'] = '';
        $json['id'] = $storeID;
        $json['no'] = $data; 
        if(!empty($storeID['store_id'])) {
          echo json_encode($json);return;
        } else {
          echo '{"code":"201","message":"店铺为空"}';return;
        }
    }
}
?>
<?php
namespace Home\Controller;
use Think\Controller;
class HouseEventController extends Controller{

   public function eventlist(){
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
      $handleHouseEvent = new \Logic\HouseEventLogic();
      $startTime=isset($_GET['startTime'])?strtotime($_GET['startTime']):"";
      $endTime=isset($_GET['endTime'])?strtotime($_GET['endTime']):"";
      $room_no=isset($_GET['room_no'])?$_GET['room_no']:"";
      //$act_name=isset($_GET['actnamesys'])?$_GET['actnamesys']:"";
      $line_flag=isset($_GET['lineflag'])?$_GET['lineflag']:"";
      $principal=isset($_GET['principal'])?$_GET['principal']:"";
      $actnamesys=I('get.actnamesys');
      $where['record_status']=array('eq',1);
      //分页条件
      $pageWhere['record_status']=1;
      $pageWhere['startTime']=$startTime;
      $pageWhere['endTime']=$endTime;
      $pageWhere['room_no']=$room_no;
      $pageWhere['actnamesys']=$actnamesys;
      $pageWhere['lineflag']=$line_flag;
      $pageWhere['principal']=$principal;

      if($endTime!=""&&$startTime==""){
         $where['line_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!=""){
         $where['line_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
         $where['line_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($room_no!=""){
         $where['room_no']=array('eq',$room_no);
      }
      /*if($act_name!=""){
         $where['act_name']=array('like','%'.$act_name.'%');
      }*/
      if($line_flag!=""){
         $where['line_flag']=array('eq',$line_flag);
      }
      if($principal!=""){
         $where['principal']=array('eq',$principal);
      }
      if($actnamesys!=""){
        $where['act_name_sys']=array('like','%'.$actnamesys.'%');
      }
      $count=$handleHouseEvent->modelPageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($pageWhere as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
      $list=$handleHouseEvent->modelDataList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->display();
   }

   //新增活动
   public function addevent(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
      $handleCouponManage = new \Logic\CouponManage();
      $where['coupon_type']=2;
      $recoup=$handleCouponManage->getModelFind($where);
      $this->assign("couarr",$recoup);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
   }

   public function subevent(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $handleHouseEvent = new \Logic\HouseEventLogic();
      $handleReport = new \Logic\ReportLogic();
      $admin['user_name']=cookie("admin_user_name");
      $admin_user=$handleReport->modelGetAdmin($admin);
      $handleCouponManage = new \Logic\CouponManage();
     // $recouparr=$handleCouponManage->getCouponManage(I('post.coupon_type'));
      $data['type_id']=create_guid();
      $data['act_name_sys']=$_POST['act_name_sys'];
      //$data['act_tag_name']=$_POST['act_tag_name'];
      $data['act_name']=$_POST['act_name'];
      $data['act_url']=I('post.act_url');
      $data['act_eff_time']=strtotime("+10 year");
      $data['create_time']=time();
      $data['create_man_id']=$admin_user['id'];
      $data['line_flag']=$_POST['line_flag'];
      $data['principal']=cookie("admin_user_name");
      $data['coupon_type']=I('post.activityid');
      $data['coupon_limit']=I('post.couponlimit');
      $data['explain']=I('post.explain');
      $data['city_code']=C("CITY_CODE");
      
      //$data['coupon_id']=I('post.coupon_type');
     // $data['coupon_name']=$recouparr['name'];
      if($_POST['line_flag']==1){
         $data['line_time']=time();
      }
      $room_no=I('post.room_no');
      $strroomno=str_replace('，',',',$room_no);
      $roomno_arr=explode(',',$strroomno); 
      foreach ($roomno_arr as $key => $value) {
         $data['room_no']=trim($value);
         $where['room_no']=trim($value);
         $roomarr=$handleHouseEvent->modelRoomId($where);
         $data['id']=create_guid();
         $data['room_id']=$roomarr['id'];
         $result=$handleHouseEvent->modelAdd($data);
      }
      if($result){
         $this->success('提交成功', 'eventlist.html?no=3&leftno=64');
      }
   }
   public function upevent(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $handleHouseEvent = new \Logic\HouseEventLogic();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
      $where['id']=$_GET['eid'];
      $data=$handleHouseEvent->modelByIdFind($where);
      $roomwhere['type_id']=$data['type_id'];
      $roomno_arr=$handleHouseEvent->modelGet($roomwhere);
      foreach ($roomno_arr as $key => $value) {
        $room_no.=$value['room_no'].",";
      }
      $roomno=substr($room_no,0,-1);
      $handleCouponManage = new \Logic\CouponManage();
      $where1['coupon_type']=2;
      $recoup=$handleCouponManage->getModelFind($where1);
      $this->assign("couarr",$recoup);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("data",$data);
      $this->assign("room_no",$roomno);
      $this->assign("activity_id",$activity_id);
      $this->display();
   }

   public function subupevent(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $handleHouseEvent = new \Logic\HouseEventLogic();
      $handleReport = new \Logic\ReportLogic();
     
             $handleCouponManage = new \Logic\CouponManage();
            // $recouparr=$handleCouponManage->getCouponManage(I('post.coupon_type'));
             $admin['user_name']=cookie("admin_user_name");
             $admin_user=$handleReport->modelGetAdmin($admin);
             //$wheretype['type_id']=I('post.type_id');
            // $principal=$handleHouseEvent->modelByIdFind($wheretype);
             $data['type_id']=create_guid();
             $data['act_name_sys']=$_POST['act_name_sys'];
             //$data['act_tag_name']=$_POST['act_tag_name'];
             $data['act_name']=$_POST['act_name'];
             $data['act_url']=I('post.act_url');
             $data['act_eff_time']=strtotime("+10 year");
             $data['create_time']=time();
             $data['line_flag']=$_POST['line_flag'];
            // $data['principal']=$principal['principal'];
             $data['update_man']=cookie("admin_user_name");
             $data['coupon_type']=I('post.activityid');
             $data['coupon_limit']=I('post.couponlimit');
             $data['explain']=I('post.explain');
            // $data['coupon_id']=I('post.coupon_type');
             //$data['coupon_name']=$recouparr['name'];
             if($_POST['line_flag']==1){
               $data['line_time']=time();
             }
             // else{
             //   $data['line_time']=I('post.line_time');
             // }
             if(I('post.line_flag')==2){
                $data['act_eff_time']=strtotime("+10 year");
             }
             $room_no=$_POST['room_no'];
              $strroomno=str_replace('，',',',$room_no);
             $roomno_arr=explode(',',$strroomno); 
             foreach ($roomno_arr as $key => $value) {
               $data['room_no']=trim($value);
               $where['room_no']=trim($value);
               $roomarr=$handleHouseEvent->modelRoomId($where);
               $data['id']=create_guid();
               $data['room_id']=$roomarr['id'];
               $result=$handleHouseEvent->modelAdd($data);
            }
            if($result){
              $handleHouseEvent->modelUpdataByType($_POST['type_id']);
              $this->success('修改成功', 'eventlist.html?no=3&leftno=64');
           } 
      
   }

     //导出excel
    public function downloadExcel(){
        header ( "Content-type: text/html; charset=utf-8" );
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        $handleHouseEvent = new \Logic\HouseEventLogic();
        $startTime=isset($_GET['startTime'])?strtotime($_GET['startTime']):"";
        $endTime=isset($_GET['endTime'])?strtotime($_GET['endTime']):"";
        $room_no=isset($_GET['room_no'])?$_GET['room_no']:"";
        //$act_name=isset($_GET['actnamesys'])?$_GET['actnamesys']:"";
        $line_flag=isset($_GET['lineflag'])?$_GET['lineflag']:"";
        $principal=isset($_GET['principal'])?$_GET['principal']:"";
        $actnamesys=I('get.actnamesys');
        $where['record_status']=array('eq',1);
        if($endTime!=""&&$startTime==""){
           $where['line_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!=""){
           $where['line_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['line_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
        if($room_no!=""){
           $where['room_no']=array('eq',$room_no);
        }
        if($line_flag!=""){
           $where['line_flag']=array('eq',$line_flag);
        }
        if($principal!=""){
           $where['principal']=array('eq',$principal);
        }
        if($actnamesys!=""){
          $where['act_name_sys']=array('like','%'.$actnamesys.'%');
        }
        $listdata=$handleHouseEvent->modelDataList(0,99999,$where);
        $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($listdata));
        $title=array(
            'act_name_sys'=>'活动名称',
            'room_no'=>'活动房间编号',
            'act_name'=>'活动入口文案',
            'line_time'=>'上线时间',
            'act_eff_time'=>'下线时间',
            'principal'=>'活动负责人',
            'update_man'=>'活动修改人',
        );
        foreach ($listdata as $key => $value) {
           $value1['act_name_sys']=$value['act_name_sys'];
           $value1['room_no']=$value['room_no'];
           $value1['act_name']=$value['act_name'];
           if($value['line_time']==0){
              $value1['line_time']="";
           }else{
              $value1['line_time']=date("Y-m-d H:i:s",$value['line_time']); 
           }
           if($value['act_eff_time']==0){
              $value1['act_eff_time']="";
           }else{
              $value1['act_eff_time']=date("Y-m-d H:i:s",$value['line_time']); 
           }
           if($value['principal']!=""){
              $value1['principal']=$value['principal'];
           }else{
              $value1['principal']="";
           }
           if($value['update_man']!=""){
             $value1['update_man']=$value['update_man'];
           }else{
             $value1['update_man']="";
           }
           $list[]=$value1;
        }

        $excel[]=$title;
        if($list===false || $list===null || count($list)==0){
            return;
        }
        foreach ($list as $key => $value) {
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '活动管理');
        $xls->addArray($excel);
        $xls->generateXML('活动管理'.date("YmdHis"));
    }
}
?>
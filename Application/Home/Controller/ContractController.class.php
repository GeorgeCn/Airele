<?php
namespace Home\Controller;
use Think\Controller;
class ContractController extends Controller {

    public function contractlist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
         $handleMenu->jurisdiction();
    	 $startTime=strtotime(I('get.startTime'));
    	 $endTime=strtotime(I('get.endTime'));
         $mobile=I('get.mobile');
         $orderstatus=I('get.status');
         $record_status=I('get.recordstatus');
         $city_code=I('get.cityid');
         
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
             $where['mobile']=array('eq',$mobile);
    	 }
     
         if($orderstatus!=""){
             $where['status']=array('eq',$orderstatus);
         }
         if($record_status!=""){
            $where['record_status']=array('eq',$record_status);
         }
         if($city_code!=""){
            $where['city_code']=array('eq',$city_code);
         }
        $modelHouseContract=new \Home\Model\housecontract();
        $count=$modelHouseContract->modelPageCount($where);
        $Page= new \Think\Page($count,15);
        $list=$modelHouseContract->modelPageList($Page->firstRow,$Page->listRows,$where);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
    	$this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->display();
    }


    public function contractdetails(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
    
         $modelHouseContract=new \Home\Model\housecontract();
         $roomLogic=new \Logic\HouseRoomLogic();
         $orderid=I('get.oid');
         $where['id']=$orderid;
         $data=$modelHouseContract->modelFind($where);
         if($data['room_id']!=""){
             $roomarr=$roomLogic->getModelById($data['room_id']);
         }
          $this->assign("roomarr",$roomarr);
         $this->assign("data",$data);
         $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }
    //客服备注
    public function servicedesc(){
          $modelHouseContract=new \Home\Model\housecontract();
          $modelStatus=new \Home\Model\housecontractstatus();
          $modelTracking=new \Home\Model\customertracking();
          $handleSms = new \Logic\Commonsms();
          $orderid=I('get.id');
          $status=I('get.status');
          $desc=I('get.desc');
          $where['id']=$orderid;
          $data=$modelHouseContract->modelFind($where);
          if($data){
            $data['status']=$status;
            $data['update_man']=cookie("admin_user_name");
            $data['update_time']=time();
            $data['desc']=$desc;
            $re=$modelHouseContract->modelUpdate($data);
            if($re){
                    $datastatus['id']=create_guid();
                    $datastatus['contract_id']=$orderid;
                    $datastatus['contract_status']=$status;
                    $datastatus['create_time']=time();
                    if($status==3){
                      $datastatus['memo']="已通过";
                      //更新租客跟踪
                      $twhere['customer_id']=$data['customer_id'];
                      $trackingarr=$modelTracking->getModelByCondition($twhere);
                      if($trackingarr){
                          $trackingarr['update_time']=time();
                          $trackingarr['update_man']=cookie("admin_user_name");
                          $trackingarr['bakinfo']="上传保障合同";
                          $modelTracking->updateModel($trackingarr);
                          $trackdata['tracking_id']=$trackingarr['id'];
                          $trackdata['renter_status']=$trackingarr['renter_status'];
                          $trackdata['renter_room']=$trackingarr['renter_room'];
                          $trackdata['renter_time']=$trackingarr['renter_time'];
                          $trackdata['bakinfo']="上传保障合同";
                          $trackdata['renter_source']=$trackingarr['renter_source'];
                          $trackdata['is_service']=$trackingarr['is_service'];
                          $trackdata['create_time']=time();
                          $trackdata['create_man']=cookie("admin_user_name");
                          $trackdata['is_look']=$trackingarr['is_look'];
                          $trackdata['is_satisfied']=$trackingarr['is_satisfied'];
                          $trackdata['is_recommend']=$trackingarr['is_recommend'];
                          $modelTracking->addLogModel($trackdata);
                      }
                    }elseif($status==2){
                      $datastatus['memo']="未通过";
                    }
                    $datastatus['oper_id']=cookie("admin_user_name");
                    $modelStatus->modelAdd($datastatus);
                    $smsownerarr['renter_phone']=$data['mobile'];
                    $smsownerarr['create_time']=$data['create_time'];
                    $smsownerarr['renter_name']="xx";
                    $smsownerarr['price_cnt']="100";
                    $smsownerarr['id']=$data['id'];
                    if($status==3){
                        $handleSms->sendSms($smsownerarr,'BZJ001');
                    }elseif($status==2){
                        $handleSms->sendSms($smsownerarr,'BZJ002');
                    }
                    
                    echo "{\"status\":\"200\",\"msg\":\" \"}";
            }
          }
    }
}
?>
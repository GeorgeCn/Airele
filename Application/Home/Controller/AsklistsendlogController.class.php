<?php
namespace Home\Controller;
use Think\Controller;
class AsklistsendlogController extends Controller {
       //已回复列表
       public function yetreply(){
           $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
            $handleMenu->jurisdiction();
            $handleAsklist = new \Logic\AsklistsendLog();
            $status=I('get.handlestatus');
            $mobile=I('get.mobile');
            $startTime=strtotime(I('get.startTime'));
            $endTime=strtotime(I('get.endTime'));
            $opstatus=I('get.opstatus');
            $sendno=I('get.sendno');
            $pushstartTime=strtotime(I('get.pushstartTime'));
            $pushendTime=strtotime(I('get.pushendTime'));
            $where['city_code']=C('CITY_CODE');
            
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
             if(!isset($where['create_time'])){
                $where['create_time']=array('gt',time()-3600*24*7);//默认时间条件
             }
             if($pushstartTime!=""&&$pushendTime==""){
                $where['send_time']=array('gt',$pushstartTime);
             }
             if($pushendTime!=""&&$pushstartTime==""){
                 $where['send_time']=array('lt',$pushendTime+86400);
             }
             if($pushstartTime!=""&&$pushendTime!=""){
                $where['send_time']=array(array('gt',$pushstartTime),array('lt',$pushendTime+86400));
             }
             if($pushstartTime!=""&&$pushendTime!=""&&$pushstartTime==$pushendTime){
                 $where['send_time']=array(array('gt',$pushstartTime),array('lt',$pushendTime+86400));
             }
             if($mobile!=""){
                 $where['mobile']=array('eq',$mobile);
             }
             if(I('get.content')!=""){
                $where['content']=array('like','%'.I('get.content').'%');
             }
             if($status!=""){
                $where['is_deal']=array('eq',$status);
             }else{
                $where['is_deal']=array('eq',0);
             }
             if($sendno!=""){
                $where['send_no']=array('eq',$sendno);
             }
             if($opstatus!=""){
                if($opstatus==1){
                    $where['is_lease']=array('eq',1);
                }elseif($opstatus==2){
                    $where['is_update']=array('eq',1);
                }
             }
             $count=$handleAsklist->modelAsklistReceiveCount($where);
             $Page= new \Think\Page($count,5);
             $list=$handleAsklist->modelAskListReceive($Page->firstRow,$Page->listRows,$where);
             foreach ($list as $key => $value){
                  $where1['rec_id']=$value['id'];
                  $askreceive=$handleAsklist->modelLogFind($where1);
                  $value['push_mobile']=$askreceive['mobile'];
                  $value['push_time']=$askreceive['create_time'];
                  $value['push_content']=$askreceive['content'];
                  $listarr[]=$value;
            }
            $this->assign("list",$listarr);
            $this->assign("pagecount",$count);
            $this->assign("show",$Page->show());
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
       } 
      //未回复列表
       public function notreply(){
            $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
            $handleMenu->jurisdiction();
            $handleAsklist = new \Logic\AsklistsendLog();
            $status=I('get.handlestatus');
            $mobile=I('get.mobile');
            $startTime=strtotime(I('get.startTime'));
            $endTime=strtotime(I('get.endTime'));
             $opstatus=I('get.opstatus');
            $sendno=I('get.sendno');
            $where['city_code']=C('CITY_CODE');
            
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
             if(I('get.content')!=""){
                $where['content']=array('like','%'.I('get.content').'%');
             }
             if($status!=""){
                $where['is_deal']=array('eq',$status);
             }else{
                $where['is_deal']=array('eq',0);
             }
             if($sendno!=""){
                $where['send_no']=array('eq',$sendno);
             }
             if($opstatus!=""){
                if($opstatus==1){
                    $where['is_lease']=array('eq',1);
                }elseif($opstatus==2){
                    $where['log_update']=array('eq',1);
                }
             }
               $where['rec_id']=array('eq','');
             $count=$handleAsklist->modelAsklistCount($where);
             $Page= new \Think\Page($count,5);
             $list=$handleAsklist->modelAskList($Page->firstRow,$Page->listRows,$where);
        
            $this->assign("list",$list);
            $this->assign("pagecount",$count);
            $this->assign("show",$Page->show());
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
       }
    //获取room信息
    public function jsonhouseroom(){
        $room_id=I('get.room_id');
        $handleContact = new \Logic\HouseRoomLogic();
        $roomarr=$handleContact->getModelById($room_id);
        $roomarr['create_time']=date("Y-m-d H:i:s",$roomarr['create_time']);
        $roomarr['update_time']=date("Y-m-d H:i:s",$roomarr['update_time']);
        echo json_encode($roomarr);
    }
     //已出租，房源更新
      public function uphouserroom(){
        $login_name=trim(getLoginName());
        if(empty($login_name)){
          echo '{"status":"201","msg":"请重新登录"}';return;
        }
        $handleSelect = new \Logic\HouseSelectLogic();
        $roomLogic=new \Logic\HouseRoomLogic();
        $handlAsk=new \Logic\AsklistsendLog();
        $room_id=I('get.roomid');
        $uptype=I('get.uptype');
        $id=I('get.id');
        if($uptype==1){
            $model=$roomLogic->getModelById($room_id);
            if($model==false || $model==null){
              echo '{"status":"202","msg":"房间信息读取失败"}';return;
            }else if($model['status']==3){
              echo '{"status":"203","msg":"房间已经出租了"}';return;
            }
            $updateResult=$roomLogic->downroomByidForCommon($room_id,$login_name);//下架
            if($updateResult){
                $handlAsk->modelUpdate(array('id'=>$id,'is_deal'=>1,'is_lease'=>1,'update_time'=>time()));
                $handlAsk->modelUpdateLog(array('id'=>$id,'is_deal'=>1,'is_lease'=>1,'update_time'=>time()));
                echo '{"status":"200","msg":"操作成功"}';
            }else{
                echo '{"status":"400","msg":"操作失败"}';
            }
            
         }elseif($uptype==2){
              $refresh=new \Home\Model\customerlimitrefresh();
              $roomModel=$roomLogic->getModelById($room_id);
              if($roomModel!=null && $roomModel['status']==3){
                echo '{"status":"204","msg":"房间已经出租了"}';return;
              }
              $curefresh['customer_id']=$roomModel['customer_id'];
              $refresharr=$refresh->modelFind($curefresh);
              if(!$refresharr){
                  $datase['room_id']=$room_id;
                  $datase['update_time']=time();
                  $result=$handleSelect->updateModelByRoomid($datase);
                  $data['id']=$room_id;
                  $data['update_time']=time();
                  $data['update_man']=$login_name;
                  $roomLogic->updateModel($data);
                  //记录房源操作日志
                  $handleupdatelog=new \Home\Model\houseupdatelog();
                  $houselog['id']=guid();
                  $houselog['house_id']=$room_id;
                  $houselog['house_type']=2;
                  $houselog['update_man']=$login_name;
                  $houselog['update_time']=time();
                  $houselog['operate_type']="更新时间";
                  $houselog['operate_bak']="短信问房";
                  $handleupdatelog->addModel($houselog);
              }
              $handlAsk->modelUpdate(array('id'=>$id,'is_update'=>1,'is_deal'=>1,'update_time'=>time()));
              $handlAsk->modelUpdateLog(array('id'=>$id,'log_update'=>1,'is_deal'=>1,'update_time'=>time()));
              echo '{"status":"200","msg":"操作成功"}';
         } elseif($uptype==3) {
              $rooms = $handlAsk->getAskReceiveRoom();
              foreach ($rooms as $value) {
                  $datase['room_id']=$value['room_id'];
                  $datase['update_time']=time();
                  $result=$handleSelect->updateModelByRoomid($datase);
                  $data['id']=$value['room_id'];
                  $data['update_time']=time();
                  $data['update_man']=$login_name;
                  $roomLogic->updateModel($data);
                  //记录房源操作日志
                  $handleupdatelog=new \Home\Model\houseupdatelog();
                  $houselog['id']=guid();
                  $houselog['house_id']=$value['room_id'];
                  $houselog['house_type']=2;
                  $houselog['update_man']=$login_name;
                  $houselog['update_time']=time();
                  $houselog['operate_type']="更新时间";
                  $houselog['operate_bak']="短信问房";
                  $handleupdatelog->addModel($houselog);
                  $handlAsk->modelUpdate(array('id'=>$value['id'],'is_update'=>1,'is_deal'=>1,'update_time'=>time()));
                  $handlAsk->modelUpdateLog(array('id'=>$value['id'],'log_update'=>1,'is_deal'=>1,'update_time'=>time()));
              }
                  echo '{"status":"200","msg":"操作成功"}';
         }
      }
 
    public function uploghouserroom(){
      $login_name=trim(getLoginName());
      if(empty($login_name)){
        echo '{"status":"201","msg":"请重新登录"}';return;
      }
       $room_id=I('get.roomid');
       $id=I('get.id');
       $roomLogic=new \Logic\HouseRoomLogic();
       $result=$roomLogic->updateModel(array('id'=>$room_id,'update_man'=>$login_name,'update_time'=>time()));
       if($result){
          $handleSelect = new \Logic\HouseSelectLogic();
          $handlAsk=new \Logic\AsklistsendLog();
          $handleSelect->updateModelByRoomid(array('room_id'=>$room_id,'update_time'=>time()));
          $handlAsk->modelUpdateLog(array('id'=>$id,'log_update'=>1,'is_deal'=>1));
          echo '{"status":"200","msg":"操作成功"}';
       }else{
          echo '{"status":"400","msg":"操作失败"}';
       }
    } 
    //获取是否是职业房东
    public function professionalowner(){
        $handleCustomer = new \Logic\CustomerLogic();
        $handleCustomerInfo = new \Logic\CustomerInfo();
        $customerinfo=new \Home\Model\customerinfo();
        $ownermobile=I('get.ownermobile');
        $result=$handleCustomer->getResourceClientByPhone($ownermobile);
        $where['mobile']=$ownermobile;
        $where['record_status']=1;
        $result1=$customerinfo->getConfirmModel($where);
        if($result1&&$result1['status']!=2){
          $result['is_owner']=9;
        }
        echo json_encode($result);
    }
    //设置为职业房东
    public function upprowner(){
       $handleCustomerInfo = new \Logic\CustomerInfo();
       $handleCustomer = new \Logic\CustomerLogic();
         $curesult=$handleCustomer->getResourceClientByPhone(I('get.ownermobile'));
         if($curesult['city_code']==""){
          $cudata['city_code']=C('CITY_CODE');
         }
         $cudata['id']=I('get.id');
         $cudata['is_owner']=4;
         $result1= $handleCustomer->updateModel($cudata);//修改customer
         $where['customer_id']=I('get.id');
         $result=$handleCustomerInfo->modelFind($where);
         if(!$result){
           $data['id']=guid();
           $data['customer_id']=I('get.id');
           $data['source']="短信问房";
           $data['update_time']=time();
           $data['update_man']=getLoginName();
           $data['create_time']=time();
           $handleCustomerInfo->mobileAdd($data);//新增customerinfo
         if($result1){
           echo "{\"status\":\"200\",\"msg\":\"\"}";
         }
      }
    }
    /*疑似职业房东 */
    public function setConfirmJobowner(){
       $mobile=I('get.ownermobile');
       if(empty($mobile)){
          echo '参数异常';return ;
       }
       $update_man=trim(getLoginName());
        if(empty($update_man)){
          echo '会话失效，请重新登录';return;
        }
       $data['id']=guid();
       $data['mobile']=$mobile;
       $source=I('get.source');
       if(empty($source)){
          $source='短信问房';
       }
       $handleCustomer = new \Logic\CustomerLogic();
       $customerarr=$handleCustomer->getResourceClientByPhone($mobile);
       if($customerarr!=null && $customerarr['is_owner']==4){
         echo '已经是职业房东';return;
       }
       $customerinfoLogic=new \Logic\CustomerInfo();
       $result=$customerinfoLogic->addOwnerForCustomerinfo(array('mobile'=>$mobile,'customer_id'=>'','source'=>$source,'update_man'=>$update_man,'update_time'=>time()));
       if($result){
          echo '操作成功';
       }else{
          echo '操作失败';
       }
       //判断职业房东确认表是否有数据有就修改成待确认没有就新增
       /*$handleCustomerinfo= new \Home\Model\customerinfo();
       $where['mobile']=$mobile;
       $where['record_status']=1;
       $confirmarr=$handleCustomerinfo->getConfirmModel($where);
       if($confirmarr&&$confirmarr['status']==1){
          $confirmarr['status']=0;
          $upwhere['id']=$confirmarr['id'];
          $handleCustomerinfo->updateConfirm($upwhere,$confirmarr);
          echo '操作成功';
       }elseif(!$confirmarr){
           $data['source']=$source;
           $data['update_time']=time();
           $data['update_man']=$update_man;
           $data['create_time']=$data['update_time'];
           $data['create_man']=$data['update_man'];
           $data['city_code']=C('CITY_CODE');
           $data['record_status']=1;
           $data['status']=0;
           $handleCustomerinfo->addConfirmModel($data);
           echo '操作成功';
       }*/
    }

    //数据监控
    public function monitoring(){
             $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
            //$handleMenu->jurisdiction();
            $askmonitor=new \Home\Model\askmonitor();
            $where['record_status']=1;
            $list=$askmonitor->modelSelect($where);
            $pushcount=$askmonitor->pushcount();//今日发送数
            $replycount=$askmonitor->replycount();//今日发送数
            $this->assign("replycount",$replycount);
            $this->assign("pushcount",$pushcount);
            $this->assign("list",$list);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    public function monitorcount(){
          $askmonitor=new \Home\Model\askmonitor();
          $mobile=I('get.mobile');
          if($mobile!=""){  
               $currentreply=$askmonitor->currentreplycount($mobile);//当前回复数
               $currentpush=$askmonitor->currentpushcount($mobile);//当前发送数
               $currentcountday=$askmonitor->currentreplycountday($mobile);//当日回复数
               $replyrate=0;
               if($currentpush[0]['count']>0){
                  $replyrate=round((float)($currentreply[0]['count']/$currentpush[0]['count'])*100,2);
               }
               
               $array=array('pushcount'=>$currentpush[0]['count'],'replycount'=>$currentreply[0]['count'],'replyrate'=>$replyrate,'currentcountday'=>$currentcountday[0]['count']);
               echo json_encode($array);
          }
    }


    //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $handleAsklist = new \Logic\AsklistsendLog();
        $handleContact = new \Logic\HouseRoomLogic();
        $status=I('get.handlestatus');
        $mobile=I('get.mobile');
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $opstatus=I('get.opstatus');
        $sendno=I('get.sendno');
        $pushstartTime=strtotime(I('get.pushstartTime'));
        $pushendTime=strtotime(I('get.pushendTime'));
        $where['city_code']=C('CITY_CODE');
        
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

         if($pushstartTime!=""&&$pushendTime==""){
                $where['send_time']=array('gt',$pushstartTime);
         }
         if($pushendTime!=""&&$pushstartTime==""){
              $where['send_time']=array('lt',$pushendTime+86400);
          }
          if($pushstartTime!=""&&$pushendTime!=""){
              $where['send_time']=array(array('gt',$pushstartTime),array('lt',$pushendTime+86400));
         }
         if($pushstartTime!=""&&$pushendTime!=""&&$pushstartTime==$pushendTime){
              $where['send_time']=array(array('gt',$pushstartTime),array('lt',$pushendTime+86400));
         }
         if($mobile!=""){
             $where['mobile']=array('eq',$mobile);
         }
         if(I('get.content')!=""){
            $where['content']=array('like','%'.I('get.content').'%');
         }
         if($status!=""){
            $where['is_deal']=array('eq',(int)$status);
         }else{
            $where['is_deal']=array('eq',0);
         }
         if($sendno!=""){
                $where['send_no']=array('eq',$sendno);
          }
         if($opstatus!=""){
            if($opstatus==1){
                $where['is_lease']=array('eq',1);
            }elseif($opstatus==2){
                $where['is_update']=array('eq',1);
            }
         }
         $count=$handleAsklist->modelAsklistReceiveCount($where);
         $Page= new \Think\Page($count,8);
         $list=$handleAsklist->modelAskListReceive(0,99999,$where);
       $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($list));
         foreach ($list as $key => $value){
              $where1['rec_id']=$value['id'];
              $askreceive=$handleAsklist->modelLogFind($where1);
              $roomarr=$handleContact->getModelById($value['room_id']);
              $value1['room_no']=$roomarr['room_no'];
              $value1['room_name']=$roomarr['room_name'];
              $value1['room_money']=$roomarr['room_money'];
              $value1['room_create_time']=$roomarr['create_time'];
              $value1['room_update_time']=$roomarr['update_time'];
              $value1['info_resource']=$roomarr['info_resource'];
              $value1['send_no']=$value['send_no'];
              $value1['mobile']=$value['mobile'];
              $value1['push_content']=$askreceive['content'];
              $value1['content']=$value['content'];
              $value1['push_time']=$askreceive['create_time'];
              $value1['create_time']=$value['create_time'];
              $value1['update_time']=$value['update_time'];
              $listarr[]=$value1;
        }
        $title=array(
            'room_no'=>'房间编号','room_name'=>'房间名称','room_money'=>'价格','room_create_time'=>'创建日期 ','room_update_time'=>'更新日期','info_resource'=>'数据来源',
            'send_no'=>'发送手机','mobile'=>'接收手机','push_content'=>'发送短信','content'=>'收到短信','push_time'=>'发送时间','create_time'=>'回复时间','update_time'=>'操作时间'
        );
        $excel[]=$title;
        foreach ($listarr as $key => $value) {
            $value['room_create_time']=$value['room_create_time']>0?date("Y-m-d H:i",$value['room_create_time']):""; 
            $value['room_update_time']=$value['room_update_time']>0?date("Y-m-d H:i",$value['room_update_time']):"";
            $value['create_time']=$value['create_time']>0?date("Y-m-d H:i",$value['create_time']):"";
            $value['push_time']=$value['push_time']>0?date("Y-m-d H:i",$value['push_time']):"";
            $value['update_time']=$value['update_time']>0?date("Y-m-d H:i",$value['update_time']):"";
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '短信问房');
        $xls->addArray($excel);
        $xls->generateXML('短信问房'.date("YmdHis"));
     }

      public function downloadExcel1(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $handleAsklist = new \Logic\AsklistsendLog();
        $handleContact = new \Logic\HouseRoomLogic();
        $status=I('get.handlestatus');
        $mobile=I('get.mobile');
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $opstatus=I('get.opstatus');
        $sendno=I('get.sendno');
        $where['city_code']=C('CITY_CODE');
        
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
         if(I('get.content')!=""){
            $where['content']=array('like','%'.I('get.content').'%');
         }
         if($status!=""){
            $where['is_deal']=array('eq',$status);
         }else{
            $where['is_deal']=array('eq',0);
         }

         if($sendno!=""){
                $where['send_no']=array('eq',$sendno);
          }
         if($opstatus!=""){
            if($opstatus==1){
                $where['is_lease']=array('eq',1);
            }elseif($opstatus==2){
                $where['is_update']=array('eq',1);
            }
         }
         $count=$handleAsklist->modelAsklistCount($where);
         $Page= new \Think\Page($count,8);
         $list=$handleAsklist->modelAskList(0,99999999999,$where);
          $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($list));
         foreach ($list as $key => $value){
              $roomarr=$handleContact->getModelById($value['room_id']);
              $value1['room_no']=$roomarr['room_no'];
              $value1['room_name']=$roomarr['room_name'];
              $value1['room_money']=$roomarr['room_money'];
              $value1['room_create_time']=$roomarr['create_time'];
              $value1['room_update_time']=$roomarr['update_time'];
              $value1['info_resource']=$roomarr['info_resource'];
              $value1['send_no']=$value['send_no'];
              $value1['mobile']=$value['mobile'];
              $value1['content']=$value['content']; 
              $value1['create_time']=$value['create_time'];
              $listarr[]=$value1;
        }
        $title=array(
            'room_no'=>'房间编号','room_name'=>'房间名称','room_money'=>'价格','room_create_time'=>'创建日期 ','room_update_time'=>'更新日期','info_resource'=>'数据来源',
            'send_no'=>'发送手机','mobile'=>'接收手机','push_content'=>'发送短信','push_time'=>'发送时间'
        );
        $excel[]=$title;
        foreach ($listarr as $key => $value) {
            $value['room_create_time']=$value['room_create_time']>0?date("Y-m-d H:i",$value['room_create_time']):""; 
            $value['room_update_time']=$value['room_update_time']>0?date("Y-m-d H:i",$value['room_update_time']):"";
            $value['create_time']=$value['create_time']>0?date("Y-m-d H:i",$value['create_time']):"";
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '短信问房');
        $xls->addArray($excel);
        $xls->generateXML('短信问房'.date("YmdHis"));
     }
     //暂停
     public function updataiscolse(){
          $askmonitor=new \Home\Model\askmonitor();
          $mobile=I('get.mobile');
          $close=I('get.close');
          if($mobile!=""&&$close!=""){
              $where['mobile']=$mobile;
              $askarr=$askmonitor->modelfind($where);
              $askarr['is_close']=$close;
              $result=$askmonitor->updateModel($askarr);
              if($result){
                 echo "{\"status\":\"200\",\"msg\":\"\"}";
              }
          }
     }

     /*批量操作房源 */
     public function batchhandlehouse(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
          //菜单权限
          $handleMenu = new \Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(getLoginName(),"141");
          $menu_left_html=$handleMenu->menuLeft(getLoginName(),"141");
           $handleMenu->jurisdiction();
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
        $this->display();
     }
     public function batchhandlehouse_submit(){
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '登录失效，请重新登录';return;
        }
        $room_no_data=I('post.room_no');
        $handle_type=I('post.handle_type');
        if(empty($room_no_data) || empty($handle_type)){
            echo '参数不完整';return;
        }
        $no_array=explode(',', str_replace('，', ',', $room_no_data));
        if(count($no_array)>1000){
          echo '操作失败，超过1000条数据';return;
        }
        $no_array=array_unique($no_array);
        $roomno_string="";
        //拼接房间编号
        foreach ($no_array as $k => $room_no) {
            $room_no=trim($room_no);
            if(empty($room_no)){
              continue;
            }
            $roomno_string.="'$room_no',";
        }
        if(empty($roomno_string)){
            echo '参数异常';return;
        }
        $roomno_string=rtrim($roomno_string,',');
        $handleRoom=new \Home\Model\houseroom();
        $handleLogic=new \Logic\HouseRoomLogic();
        $result=false;
        switch ($handle_type) {
          case '1':
            $roomList=$handleRoom->getListByWhere(" where status=2 and record_status=1 and room_no in ($roomno_string)",1000);
            if($roomList!=null && $roomList!=false){
                foreach ($roomList as $key => $value) {
                  $result=true;
                    $handleLogic->downroomByidForCommon($value['id'],$login_name);//下架
                }
            }
            break;
          case '2':
            $delete_type=I('post.delete_type');
            if(empty($delete_type)){
              echo '删除理由不完整';return;
            }
            $roomList=$handleRoom->getListByWhere(" where record_status=1 and room_no in ($roomno_string)",1000);
            if($roomList!=null && $roomList!=false){
                foreach ($roomList as $key => $value) {
                  $result=true;
                    $handleLogic->deleteRoomByRoomid(array('handle_man'=>$login_name,'room_id'=>$value['id'],'delete_type'=>$delete_type,'delete_text'=>''));//删除
                }
            }
            break;
          case '3':
            //刷新
            $result=$handleRoom->updateHouseByNo($roomno_string,array('update_time'=>time(),'update_man'=>$login_name));
            break;
          default:
            break;
        }
         if($result){
            $this->success('操作成功','batchhandlehouse.html?no=141&leftno=159');
         } else {
            $this->error('操作失败','batchhandlehouse.html?no=141&leftno=159');
         }

     }
}
?>
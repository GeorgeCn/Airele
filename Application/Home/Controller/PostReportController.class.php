<?php
namespace Home\Controller;
use Think\Controller;
class PostReportController extends Controller{
   //热门话题列表
   public function postreportlist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
 
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),47);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),47);
       $handleMenu->jurisdiction();
       $modelPostReport=new \Home\Model\circlepostreport();
       $startTime=strtotime(I('get.startTime'));
       $endTime=strtotime(I('get.endTime'));
       $mobile=I('get.mobile');
       $ownermobile=I('get.ownermobile');
       $postid=I('get.postid');
       $handle_status=I('get.status');
       $city_code=I('get.citycode');
       $reporttype=I('get.reporttype');
       
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
       if($postid!=""){
             $where['post_id']=array('eq',$postid);
       }
       if($handle_status!=""){
             $where['handle_status']=array('eq',$handle_status);
       }
       if($city_code!=""){
            $where['city_code']=array('eq',$city_code);
       }
       if($reporttype!=""){
          $where['report_type']=array('eq',$reporttype);
       }else{ 
          $where['report_type']=0;
       }
      $count=$modelPostReport->modelPageCount($where);
      $Page= new \Think\Page($count,15);
      $list=$modelPostReport->modelPageList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->display();
   }


   //帖子详情
   public function reportdetails(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
       }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),47);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),47);
      $modelPostReport=new \Home\Model\circlepostreport();
      $modelCircleimg=new \Home\Model\circleimg();
      $handleCircle = new \Logic\CircleManage();
      $handleLogic=new \Logic\BlackListLogic();
      $handleCustomer = new \Logic\CustomerLogic();
      $reportid=I('get.reportid');
      $where['id']=$reportid;
      $reportarr=$modelPostReport->modelFind($where);

      $imgwhere['relation_id']=$reportarr['post_id'];
      $imgarr=$modelCircleimg->modelSelect($imgwhere);
      foreach ($imgarr as $key => $value) {
        $value['img_path']=C('IMG_SERVICE_URL').$value['img_path'].$value['img_name']."_450_450.".$value['img_ext'];
        $newimg[]=$value;     
       }
       $rewhere['owner_mobile']=$reportarr['owner_mobile'];
      $recount=$modelPostReport->modelCount($rewhere);
      $resorwhere['client_phone']=$reportarr['owner_mobile'];
      $resource=$handleLogic->getModelResource($resorwhere);

      if($reportarr['report_type']==1){
          $reportwhere['id']=$reportarr['post_id'];
          $replayarr=$handleCircle->getPostReplayFind($reportwhere);
          $postarr['describe']=$replayarr['reply_content'];
          $postwhere1['id']=$replayarr['post_id'];
          $postarr1=$handleCircle->getCirclePostFind($postwhere1);
          $postarr['money']=$postarr1['money'];
          $postarr['title']=$postarr1['title'];
      }else{
          $postwhere['id']=$reportarr['post_id'];
          $postarr=$handleCircle->getCirclePostFind($postwhere);
      }

      $ownerarr=$handleCustomer->getModelById($reportarr['owner_id']);
      $this->assign("owner_name",$ownerarr['true_name']);
      $this->assign("resource",$resource);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("reportarr",$reportarr);
      $this->assign("postarr",$postarr);
      $this->assign("recount",$recount);
      $this->assign("imgarr",$newimg);
      $this->display();
   }
    public function handlereport(){
        $login_name=trim(getLoginName());
           $handleCustomerNotify = new \Logic\CustomerNotifyLogic();
           $handleCustomer = new \Logic\CustomerLogic();
           $modelPostReport=new \Home\Model\circlepostreport();
           $handleLogic=new \Logic\BlackListLogic();
           $handlePostselect=new \Home\Model\circlepostselect();
           $handleDevices=new \Home\Model\customerdevices();
           $handleLoginOut=new \Home\Model\customerloginout();
           $handleCircle = new \Logic\CircleManage();
           $status=I('get.status');
           $byinformer=trim(I('get.byinformer'));
           $informer=trim(I('get.informer'));
           $where['id']=I('get.id');
           $reportarr=$modelPostReport->modelFind($where);
           //$customer=$handleCustomer->getResourceClientByPhone($reportarr);
           if($byinformer!=""){
               $data['id']=create_guid();
               $data['customer_id']=$reportarr['owner_id'];
               $data['notify_type']=4;
               $data['title']="举报反馈";
               $data['content']="<font color='#666666'>".$byinformer."</font>";
               $data['create_time']=time();
               $handleCustomerNotify->modelAdd($data);
           }
           if($informer!=""){
               $data['id']=create_guid();
               $data['customer_id']=$reportarr['customer_id'];
               $data['title']="举报反馈";
               $data['content']="<font color='#666666'>".$informer."</font>";
               $data['create_time']=time();
               $handleCustomerNotify->modelAdd($data);
           }
          
          if($status>1){
               $whereblick['customer_id']=$reportarr['owner_id'];
               $blickarr=$handleLogic->modelFind($whereblick);
              
                   if($status==5){
                      $this->deletereport($reportarr['id']);//删除信息
                   }
                   if($status==3){
                      $this->deletereport($reportarr['id']);
                      $blickarr['no_post_time']=time()+(3600*24*3);//禁止发帖三天
                      $blickarr['no_post_create']=1;
                   }
                   if($status==6){
                       $this->deletereport($reportarr['id']);
                       $blickarr['no_post_replay']=1;//禁止回复
                       $blickarr['no_post_create']=1;//禁止发帖
                       $blickarr['no_post_time']=time()+(3600*24*3);//禁止发帖三天
                   }
                   if($status==8){
                       $this->deletereport($reportarr['id']);
                       $postwhere['customer_id']=$reportarr['owner_id'];
                       $modelPostReport->modelPostUpdate($postwhere);
                       $where1['customer_id']=$reportarr['owner_id'];
                       $postarr=$modelPostReport->modelPostSelect($where1);//删除该用户下所有帖子
                        foreach ($postarr as $key => $value) {
                          $selectwhere['post_id']=$value['id'];
                          $handlePostselect->modelDelete($selectwhere);
                        }
                       $blickarr['no_post_replay']=1;//禁止回复
                       $blickarr['no_post_create']=1;//禁止发帖
                       $blickarr['no_post_time']=strtotime("20 year");
                   }
                   if($status==7){
                       $blickarr['no_login']=1;//封号
                        $devices=$handleDevices->getUseModel($reportarr['owner_id']);
                         if($devices){
                             $blickarr['customer_udid']=$devices['udid'];
                             $devdata['id']=create_guid();
                             $devdata['customer_id']=$devices['customer_id'];
                             $devdata['token_id']=$devices['token_id'];
                             $devdata['udid']=$devices['udid'];
                             $devdata['create_time']=time();
                             $devdata['platform']=$devices['platform'];
                             $handleLoginOut->modelAdd($devdata);//强制退出
                         }
                      //拉黑短信通知   
                      $handleSms = new \Logic\Commonsms();
                      $smsendarr['renter_phone']=$reportarr['owner_mobile'];
                      $smsendarr['create_time']=time();
                      $smsendarr['renter_name']="xx";
                      $smsendarr['price_cnt']="00";
                      $smsendarr['id']="00";
                      $handleSms->sendSms($smsendarr,'FHS009');
                      //customer拉黑字段修改
                      $customerarr=$handleCustomer->getModelById($reportarr['owner_id']);
                      if($customerarr){
                        $customerarr['is_black']=1;
                        $handleCustomer->updateModel($customerarr);
                      }
                    }
                    $blickarr['oper_name']=$login_name;
                    $blickarr['bak_info']=$reportarr['content'];
                    $whereblick1['customer_id']=$reportarr['owner_id'];
                    $blickarrs=$handleLogic->modelFind($whereblick1);
                   if($blickarrs){
                      $blickarr['update_time']=time();
                      $handleLogic->updateModel($blickarr);
                   }else{
                      $blickarr['id']=guid();
                      $blickarr['customer_id']=$reportarr['owner_id'];
                      $blickarr['mobile']=$reportarr['owner_mobile'];
                      $blickarr['create_time']=time();
                      $blickarr['update_time']=time();
                      $result=$handleLogic->addModel($blickarr);//新增黑名单数据
                      if($result){
                          $handleLogic->addBlacklog(array('mobile'=>$blickarr['mobile'],'no_login'=>$blickarr['no_login'],'no_post_replay'=>$blickarr['no_post_replay'],'no_call'=>$blickarr['no_call'],'out_house'=>$blickarr['out_house'],
                            'update_time'=>$blickarr['update_time'],'oper_name'=>$blickarr['oper_name'],'bak_info'=>$blickarr['bak_info'],'no_post_create'=>$blickarr['no_post_create'],
                            'no_post_time'=>$blickarr['no_post_time'],'bak_type'=>$blickarr['bak_type'],'handle_type'=>0));
                      }
                   }
          }
          $reportarr['handle_status']=$status;
          $reportarr['update_man']=$login_name;
          $reportarr['update_time']=time();
          $reportarr['byinformer']=$byinformer;
          $reportarr['informer']=$informer;
          $result=$modelPostReport->modelUpdate($reportarr);
          if($result){
             echo '{"status":"200","msg":""}';
          }
   }

   //删除举报信息
   public function deletereport($report_id){
         $modelPostReport=new \Home\Model\circlepostreport();
         $handleCircle = new \Logic\CircleManage();
         $handlePostselect=new \Home\Model\circlepostselect();
         $where['id']=$report_id;
         $reportarr=$modelPostReport->modelFind($where);
         if($reportarr){
              if($reportarr['report_type']==1){
                 $replydata['id']=$reportarr['post_id'];
                 $replydata['is_display']=0;
                 $handleCircle->upReplayState($replydata);
              }else if($reportarr['report_type']==0){
                 $postwhere['id']=$reportarr['post_id'];
                 $postarr=$handleCircle->getCirclePostFind($postwhere);
                 $postarr['is_display']=0;
                 $reuppost=$handleCircle->upCirclePost($postarr);
                 if($reuppost){
                     $selectwhere['post_id']=$postarr['id'];
                     $handlePostselect->modelDelete($selectwhere);
                 }

              }
         }
   }
}
?>
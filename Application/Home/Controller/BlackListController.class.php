<?php
namespace Home\Controller;
use Think\Controller;
class BlackListController extends Controller {

	public function blackuserlist(){
		  $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      //菜单权限
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
       $handleMenu->jurisdiction();
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      
      $handleLogic=new \Logic\BlackListLogic();
      $condition['mobile']=trim(I('get.mobile'));
      $condition['startTime']=trim(I('get.startTime'));
      $condition['endTime']=trim(I('get.endTime'));
      $condition['removeBlack']=trim(I('get.removeBlack'));
      $condition['bak_type']=trim(I('get.bak_type'));
      $condition['appType']=trim(I('get.appType'));
      $condition['mobileTwo']=trim(I('get.mobileTwo'));
      $pageSHow=''; $list=array();
      if($condition['mobile']=='' && $condition['mobileTwo']==''){
      	$totalCount=$handleLogic->getModelCount($condition);
        if($totalCount>0){
           $Page= new \Think\Page($totalCount,20);
           foreach($condition as $key=>$val) {
               $Page->parameter[$key]=urlencode($val);
           }
           $pageSHow=$Page->show();
           $list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }
  	    
      }else{
      	//号码查询
      	$list = $handleLogic->getModelList($condition,0,20);
      	$totalCount=count($list);
      }
      $this->assign("list",$list);
      $this->assign("pageSHow",$pageSHow);
      $this->assign("totalCount",$totalCount);
		 $this->display();
	}
  //历史记录
  public function blackuserlog(){
    $mobile=trim(I('get.mobile'));
    if($mobile==''){
      echo '';return;
    }
    if(trim(getLoginName())==''){
      echo '';return;
    }
    $dataModel=new \Home\Model\blacklist();
    $list=$dataModel->getBlacklogData("id,mobile,no_login,no_post_replay,no_call,out_house,update_time,oper_name,bak_info,bak_type,handle_type",
        " mobile='$mobile' order by update_time desc limit 10");
    $this->assign('list',$list);
    $this->display();
  }
	public function addBlackUser(){
		 $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
	}
  //判断是否职业房东
  public function checkOwnerUser(){
    $mobile=trim(I('get.mobile'));
    if(empty($mobile)){
      echo '{"status":"400","message":"操作失败，数据异常。"}';return;
    }
    $handleLogic=new \Logic\BlackListLogic();
    //判断是否已添加
    $blackModel=$handleLogic->getModelByMobile($mobile);
    if($blackModel!=null && $blackModel!=false){
      echo '{"status":"300","message":"已经在黑名单中"}';return;
    }
    //检查白名单
    $is_white=$handleLogic->checkIsWhite($mobile);
    if($is_white){
      echo '{"status":"300","message":"新增失败，此号码是白名单号码"}';return;
    }
    $handleCustomer=new \Logic\CustomerLogic();
    $customerModel=$handleCustomer->getResourceClientByPhone($mobile);
    if($customerModel!=null && $customerModel['is_owner']==4){
      echo '{"status":"200","message":""}';
    }else{
      echo '{"status":"400","message":""}';  
    }
  }
  //提交保存黑名单
	public function saveBlackUser(){
    header('content-type:html/text;charset=utf-8;');
		 $handle_man=trim(getLoginName());
     if($handle_man==''){
        echo '{"status":"201","message":"请重新登录"}';return;
     }
    $mobile=trim(I('post.mobile'));
    if(empty($mobile)){
    	echo '{"status":"202","message":"新增失败，数据无效"}';return;
    }
    $handleLogic=new \Logic\BlackListLogic();
    //检查白名单
    $is_white=$handleLogic->checkIsWhite($mobile);
    if($is_white){
      echo '{"status":"203","message":"新增失败，此号码是白名单号码"}';return;
    }
    $saveModel['bak_type']=I('post.bak_type');
    $saveModel['bak_info']=trim(I('post.bak_info'));
    $saveModel['no_login']=I('post.no_login')?1:0;
    $saveModel['no_post_replay']=I('post.no_post_replay')?1:0;
    $saveModel['no_call']=I('post.no_call')?1:0;
    $saveModel['out_house']=I('post.soldouthouse');
    if(empty($saveModel['out_house'])){
      $saveModel['out_house']=0;
    }
    
    $devices=false;
    $customerModel=$handleLogic->getCustomerInfoByMobile($mobile);
    if($customerModel!=null && $customerModel!=false){
      //拉黑删除中介报价
      if($customerModel['is_owner'] == 5) {
        $handleLogic->deleteHouseOffer($customerModel['id']);
      }
        //更新用户数据
        $handleCustomer=new \Home\Model\customer();
        $handleCustomer->updateModel(array('id'=>$customerModel['id'],'update_time'=>time(),'update_man'=>$handle_man,'is_black'=>1,'memo'=>$customerModel['memo'].'|'.date('Y-m-d H:i:s').'拉黑用户'));
        $saveModel['customer_id']=$customerModel['id'];
        if($saveModel['no_login']){
          //退出登录
           $handleLogic->app_loginout("xxxx",$customerModel['id']);
           $handleLogic->store_loginout("xx",$customerModel['id']);
           if(I('post.is_sendmessage')){
              //拉黑短信通知   
              $handleSms = new \Logic\Commonsms();
              $smsendarr['renter_phone']=$mobile;
              $smsendarr['create_time']=time();
              $smsendarr['renter_name']="xx";
              $smsendarr['price_cnt']="00";
              $smsendarr['id']="00";
              $handleSms->sendSms($smsendarr,$saveModel['bak_type']=='3'?'FHS011':'FHS009');
           }
           if(I('post.hide_circle')){
              //隐藏帖子和回复   
              $handleLogic->hideCirclepostData($customerModel['id']);
           }
        }
        $roomLogic=new \Logic\HouseRoomLogic();
        if($saveModel['out_house']=='1'){
           $roomids_array=$roomLogic->getRoomidsByCustomerid($customerModel['id']);
           if($roomids_array!==false){
              foreach ($roomids_array as $key => $value) {
                  $roomLogic->offloadingByid($value['id']);//下架房源
              }
           }
        }else if($saveModel['out_house']=='2'){
           //删除房源
            $roomDal=new \Home\Model\houseroom();
            $roomids_array=$roomDal->getListByWhere("where customer_id='".$customerModel['id']."' and record_status=1 ");
            if($roomids_array!=null){
               foreach ($roomids_array as $key => $value) {
                   $roomLogic->deleteRoomByRoomid(array('room_id'=>$value['id'],'resource_id'=>$value['resource_id'],'handle_man'=>$handle_man,'delete_type'=>$saveModel['bak_type']=='2'?'6':$saveModel['bak_type'],'delete_text'=>$saveModel['bak_info']));
               }
            }
        }     
        $handleCustomer=new \Home\Model\customerdevices();
        $devices=$handleCustomer->getUseModel($customerModel['id']);   
    }
    if($devices){
        $saveModel['customer_udid']=$devices['udid'];
    }
    $saveModel['id']=guid();
    $saveModel['mobile']=$mobile;
    $saveModel['create_time']=time();
    $saveModel['update_time']=time();
    $saveModel['oper_name']=$handle_man;
    //新增黑名单
    $result=$handleLogic->addModel($saveModel);
    if($result){
        $handleLogic->addBlacklog(array('mobile'=>$saveModel['mobile'],'no_login'=>$saveModel['no_login'],'no_post_replay'=>$saveModel['no_post_replay'],'no_call'=>$saveModel['no_call'],'out_house'=>$saveModel['out_house'],
          'update_time'=>$saveModel['update_time'],'oper_name'=>$saveModel['oper_name'],'bak_info'=>$saveModel['bak_info'],'bak_type'=>$saveModel['bak_type'],'handle_type'=>0));
    }
    if(I('post.is_owner')){
      //发送邮件
      $pushemaillogic=new \Logic\PushemailLogic();
      $pushemaillogic->addBlackuserPushemail($mobile,$saveModel['oper_name']);
    }
    if(I('post.addType')=='other'){
      //删除已经抓取的房源
      $robDal=new \Home\Model\houseresourcerob();
      $robDal->deleteModelByClientphone($mobile);
      echo '{"status":"200","message":"新增成功"}';
    }else{
      $this->success('新增成功',U('BlackList/blackuserlist?no=6&leftno=71'),1);
    }
    
	}
  /*删除拉黑 */
	public function removeBlackUser(){
		 $handle_man=trim(getLoginName());
     if($handle_man==''){
        echo '{"status":"401","msg":"请重新登录"}';return;
     }
     //$id=trim(I('post.blackId'));
     $phone=trim(I('post.phone'));
     $bak_info=trim(I('post.bak_info'));
     if(empty($phone) || $bak_info==''){
        echo '{"status":"404","msg":"操作失败，数据异常。"}';return;
     }
		 $handleBlack=new \Home\Model\blacklist();
     $result=$handleBlack->deleteModelByWhere("mobile='$phone'");
      if($result){
        //记录日志
        $handleBlack->addBlacklog(array('mobile'=>$phone,'update_time'=>time(),'oper_name'=>$handle_man,'bak_info'=>$bak_info,'handle_type'=>1));
        $handleCustomer=new \Home\Model\customer();
        //更新用户信息
        $handleCustomer->updateModelByWhere("mobile='$phone'",array('update_time'=>time(),'update_man'=>$handle_man,'is_black'=>0));
        echo '{"status":"200","msg":"操作成功"}';
      }else{
        echo '{"status":"402","msg":"操作失败"}';
      }
	}
//下载黑名单记录
  public function downloadBlacklist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      //查询条件
      
      $condition['mobile']=trim(I('get.mobile'));
      $condition['startTime']=trim(I('get.startTime'));
      $condition['endTime']=trim(I('get.endTime'));
      $condition['removeBlack']=trim(I('get.removeBlack'));
      $condition['bak_type']=trim(I('get.bak_type'));
      $handleLogic=new \Logic\BlackListLogic();
      $list = $handleLogic->getModelList($condition,0,5000);
      $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog(strtotime($condition['startTime']),strtotime($condition['endTime']),count($list));
      $excel[]=array('mobile'=>'手机号','bak_type'=>'拉黑原因','bak_info'=>'备注信息','update_time'=>'操作时间','oper_name'=>'操作人','handle_type'=>'操作类型');
      foreach ($list as $k => $v) {
        $value['mobile']=$v['mobile'];
        $value['bak_type']=$v['bak_type'];
        switch ($value['bak_type']) {
          case '1':
            $value['bak_type']='骗子/钓鱼/微商';
            break;
          case '2':
            $value['bak_type']='违规操作';
            break;
          case '3':
            $value['bak_type']='商务需求';
            break;
          case '4':
            $value['bak_type']='中介/托管';
            break;
          case '6':
            $value['bak_type']='其他';
            break;
          default:
            break;
        }
        $value['bak_info']=$v['bak_info'];
        $value['update_time']=$v['update_time']>0?date('Y-m-d H:i:s',$v['update_time']):'';
        $value['oper_name']=$v['oper_name'];
        $value['handle_type']=$v['handle_type']=='1'?'恢复':'拉黑';
        $excel[]=$value;
      }
      Vendor('phpexcel.phpexcel');
      $xls = new \Excel_XML('UTF-8', false, '黑名单');
      $xls->addArray($excel);
      $xls->generateXML('黑名单'.date("YmdHis"));
  }

  //不透传白名单
  public function passthroughlist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $handleMenu->jurisdiction();
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $mobile=I('get.mobile');
        if($mobile!=""){
          $where['mobile']=$mobile;
        }
        $handleWhite=new \Home\Model\whitelist();
        $count=$handleWhite->modelPageCount($where);
        $Page= new \Think\Page($count,10);
        $list=$handleWhite->modelPageList($Page->firstRow,$Page->listRows,$where);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
        $this->display();
  }
  public function apassthroughtemp(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();

  }

  public function addapassthrough(){
        $mobile=I('get.mobile');
        if(empty($mobile)){
          echo '{"status":"201","message":""}';return;
        }
          $handleWhite=new \Home\Model\whitelist();
        //判断是否已添加
        $where['mobile']=$mobile;
        $whitearr=$handleWhite->modelFind($where);
        if($whitearr){
          echo '{"status":"300","message":"已经在不透传白名单中"}';return;
        }
        $saveModel['mobile']=$mobile;
        $saveModel['create_time']=time();
        $saveModel['memo']=I('get.memo');
        $saveModel['oper_man_name']=getLoginName();
        $result=$handleWhite->modelAdd($saveModel);
        if($result){
          echo '{"status":"200","message":""}';
        }else{
          echo '{"status":"400","message":""}';  
        }
  }

  public function deletebymobile(){
        $mobile=I('get.mobile');
        $handleWhite=new \Home\Model\whitelist();
        if($mobile!=""){
          $where['mobile']=$mobile;
          $result=$handleWhite->modelDelete($where);
          if($result){
              echo '{"status":"200","message":""}';
          }else{
              echo '{"status":"400","message":""}';  
          }
        }
  }

  //内部人员列表（白名单）
  public function whiteuserlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      //菜单权限
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
       $handleMenu->jurisdiction();
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      
      $handleLogic=new \Logic\BlackListLogic();
      $condition['mobile']=trim(I('get.mobile'));

      $pageSHow=''; $list=array();
      if($condition['mobile']==''){
        $totalCount=$handleLogic->getWhiteuserCount($condition);
        if($totalCount>0){
           $Page= new \Think\Page($totalCount,20);
           foreach($condition as $key=>$val) {
               $Page->parameter[$key]=urlencode($val);
           }
           $pageSHow=$Page->show();
           $list = $handleLogic->getWhiteuserList($condition,$Page->firstRow,$Page->listRows);
        }
        
      }else{
        //号码查询
        $list = $handleLogic->getWhiteuserList($condition,0,20);
        $totalCount=count($list);
      }
      $this->assign("list",$list);
      $this->assign("pageSHow",$pageSHow);
      $this->assign("totalCount",$totalCount);
     $this->display();
  }
  public function addWhiteSubmit(){
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '{"status":"201","msg":"请重新登录"}';return;
      }
      $mobile=trim(I('post.mobile'));
      $bak_info=trim(I('post.bak_info'));
      if($mobile=='' || $bak_info==''){
        echo '{"status":"202","msg":"操作失败，数据异常。"}';return;
      }
      $handleLogic=new \Logic\BlackListLogic();
      $result=$handleLogic->addWhiteUser(array('mobile'=>$mobile,'bak_info'=>$bak_info,'create_time'=>time(),'create_man'=>$handle_man));
      if($result){
         echo '{"status":"200","msg":"操作成功"}';
      }else{
         echo '{"status":"400","msg":"操作失败，已经存在"}';
      }
  }
   public function removeWhiteuser(){
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '{"status":"201","msg":"请重新登录"}';return;
      }
      $mobile=trim(I('post.mobile'));
      if($mobile==''){
        echo '{"status":"202","msg":"操作失败，数据异常。"}';return;
      }
      $handleLogic=new \Logic\BlackListLogic();
      $result=$handleLogic->deleteWhiteOne($mobile);
      if($result){
         echo '{"status":"200","msg":"操作成功"}';
      }else{
         echo '{"status":"400","msg":"操作失败"}';
      }
  }


    
}

?>	
<?php
namespace Home\Controller;
use Think\Controller;
class ContactOwnerController extends Controller {
    public function contactOwnerList(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
          $handleMenu = new\Logic\AdminMenuListLimit();
          $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
          $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
        $handleMenu->jurisdiction();
    	  $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);

        $condition['startTime']=I('get.startTime');
         $condition['endTime']=I('get.endTime');
         $condition['makcall']=I('get.makcall');
         $condition['loginphone']=trim(I('get.loginphone'));
         $condition['ownerphone']=trim(I('get.ownerphone'));
         $condition['info_resource_type']=I('get.info_resource_type');
         $condition['info_resource']=I('get.info_resource');

         $condition['handleman']=trim(I('get.handleman'));
         $condition['platform']=I('get.platform');
         $condition['status_code']=I('get.status_code');
         $condition['charge_man']=trim(I('get.charge_man'));
         $condition['brand_type']=I('get.brand_type');
         $condition['pagecnt']=I('get.pagecnt');
         $condition['roomcnt']=I('get.roomcnt');
         $condition['rentercnt']=I('get.rentercnt');
         $condition['ownercnt']=I('get.ownercnt');
         $condition['region']=I('get.region');
         $condition['scope']=I('get.scope');
         $condition['big_code']=trim(I('get.big_code'));
         $condition['room_no']=trim(I('get.room_no'));
         $condition['is_commission']=I('get.is_commission');
         $condition['principal_man']=trim(I('get.principal_man'));
         $condition['agentCompany']=trim(I('get.agentCompany'));
         $condition['unknown']= '1';
         $condition['abandon']= '1';
         if(I('get.temp')=='q'){
            $condition['unknown']= I('get.unknown');
            $condition['abandon']= I('get.abandon');
         }
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
        $condition['room_type']=I('get.room_type');
         $condition['room_num']=I('get.room_num');
         $condition['is_monthly']=I('get.is_monthly');
         $is_owner=I('get.is_owner');
         if($is_owner==5){
               $condition['is_owner']=$is_owner;
         }elseif($is_owner==999){
               $condition['is_owner']=999;
         }
        $handleContact = new \Logic\ContactOwner();
        if(I('get.p')=="" && I('get.temp')=='q'){
            //汇总
            $countModel=$handleContact->getAllContactCount($condition);
            if($countModel!==null && $countModel!==false && count($countModel)>0){
                $condition['pagecnt']=$countModel[0]['cnt'];
                $condition['roomcnt']=$countModel[0]['room_cnt'];
                $condition['rentercnt']=$countModel[0]['renter_cnt'];
                $condition['ownercnt']=$countModel[0]['owner_cnt'];
            }
        }
        $list=array();$show="";$listarr=array();
        if($condition['pagecnt']>0){
            $Page= new \Think\Page($condition['pagecnt'],8);
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $list=$handleContact->getAllContactList($Page->firstRow,$Page->listRows,$condition);
            $show=$Page->show();
        }
        $handleCalllog=new \Logic\Calllog();
        foreach ($list as $k1 => $v1) {
            if(empty($v1['call_id'])){
                $v1['is_down']='';
                $v1['fail_times']='';
            }else{
                if($v1['source']==10){
                     $recording=$handleCalllog->modelVirtualFind(array('id'=>$v1['call_id']));
                }else{
                    $recording=$handleCalllog->modelGetFind(array('id'=>$v1['call_id']));
                }
                $v1['is_down']=$recording['is_down'];
                $v1['fail_times']=$recording['fail_times'];
            }
            $listarr[]=$v1;
        }
         /*查询条件（品牌）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getResourceParameters();
        $brandString='<option value="none">无</option><option value="all">有</option>';//品牌
        if($result !==null && $result !==false){
            foreach ($result as $key => $value) {
                if($value['info_type']==16){
                    $brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
                }
            }   
        }
        /*查询条件（区域板块）*/
        $regionResult=$handleResource->getRegionList();
        $regionList='';
        if($regionResult!==null && $regionResult!==false){
            foreach ($regionResult as $key => $value) {
                $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
            }   
        }
        $scopeList='<option value=""></option>';
        if(!empty($condition['region'])){
            //查询后，重新加载板块信息
            $scopeResult=$handleResource->getRegionScopeList();
            foreach ($scopeResult as $key => $value) {
                if($condition['region']==$value['parent_id']){
                    $scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
                }
            }
        }
        $this->assign("regionList",$regionList);
        $this->assign("scopeList",$scopeList);
        //中介公司
        $handleOffer=new \Logic\HouseofferLogic();
        $result=$handleOffer->getAgentCompanyList();
        $agentCompanyList='';
        if($result!=null){
            foreach ($result as $key => $value) {
                $agentCompanyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
            }   
        }
        $this->assign("agentCompanyList",$agentCompanyList);
        //电话状态
        $statusCodeArray=getPhoneStatusArray();
        $statusCodeList='';
        foreach ($statusCodeArray as $k => $v) {
             $statusCodeList.='<option value="'.$k.'">'.$v.'</option>';
        }
        $this->assign("statusCodeList",$statusCodeList);
        $this->assign("brandTypeList",$brandString);
        $this->assign("pagecnt",$condition['pagecnt']);
        $this->assign("roomcnt",$condition['roomcnt']);
        $this->assign("rentercnt",$condition['rentercnt']);
        $this->assign("ownercnt",$condition['ownercnt']);
        //数据来源
        $this->bindInforesource($condition['info_resource_type']);
        $this->assign("show",$show);
        $this->assign("list",$listarr);
	    $this->display();
    }
    //绑定数据来源
    public function bindInforesource($type){
        $result=getOneInforesource();
        $infoResourceString='';
        foreach ($result as $key => $value) {
            $infoResourceString.='<option value="'.$key.'">'.$value.'</option>';
        }
        $this->assign("infoResourceTypeList",$infoResourceString);
        $infoResourceString='';
        if(!empty($type)){
            $result=getTwoInforesource($type);
            foreach ($result as $key => $value) {
                $infoResourceString.='<option value="'.$key.'">'.$value.'</option>';
            }
        }
        $this->assign("infoResourceList",$infoResourceString);
    }
    //获取room信息
    public function jsonhouseroom(){
        $room_id=I('get.room_id');
        if(empty($room_id)){
            echo '';return;
        }
        $handleContact = new \Logic\ContactOwner();
        $roomarr=$handleContact->getHouseRoomCache(array('room_no'=>$room_id));
        echo json_encode($roomarr);
    }
    //获取佣金信息
    public function commissionmanage(){
          $room_no=I('get.room_id');
          $modelDal=new \Home\Model\commission();
          $result=$modelDal->getModelByNo($room_no);
          if($result){
              echo "{\"status\":\"200\",\"msg\":\"是\"}";
          }else{
             echo "{\"status\":\"200\",\"msg\":\"否\"}";
          }
    }

   //下载联系房东记录
    public function downAllContact(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $startTime=I('get.startTime');
         $endTime=I('get.endTime');
             
         if(empty($startTime) || empty($endTime)){
            return $this->success('下载数据不能超过1个月！',"contactOwnerList.html?no=3&leftno=28",0);
         }
         $limit_time=strtotime($endTime)-strtotime($startTime);
         if($limit_time>3600*24*30){
            return $this->success('下载数据不能超过1个月！',"contactOwnerList.html?no=3&leftno=28",0);
         }
         $condition['startTime']=$startTime;
         $condition['endTime']=$endTime;
         $condition['makcall']=I('get.makcall');
         $condition['loginphone']=trim(I('get.loginphone'));
         $condition['ownerphone']=trim(I('get.ownerphone'));
         $condition['info_resource_type']=I('get.info_resource_type');
         $condition['info_resource']=I('get.info_resource');
         $condition['handleman']=trim(I('get.handleman'));
         $condition['platform']=I('get.platform');
         $condition['status_code']=I('get.status_code');
         $condition['charge_man']=trim(I('get.charge_man'));
         $condition['brand_type']=I('get.brand_type');
         $condition['region']=I('get.region');
         $condition['scope']=I('get.scope');
         $condition['big_code']=trim(I('get.big_code'));
         $condition['room_no']=trim(I('get.room_no'));
        $condition['unknown']= I('get.unknown');
        $condition['abandon']= I('get.abandon');
        $condition['is_commission']=I('get.is_commission');
        $condition['principal_man']=trim(I('get.principal_man'));
         $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
        $condition['room_type']=I('get.room_type');
         $condition['room_num']=I('get.room_num');
         $condition['is_monthly']=I('get.is_monthly');
         $condition['agentCompany']=trim(I('get.agentCompany'));
         $is_owner=I('get.is_owner');
         if($is_owner==5){
               $condition['is_owner']=$is_owner;
         }elseif($is_owner==999){
               $condition['is_owner']=999;
         }
         
        $handleContact = new \Logic\ContactOwner();
        $list=$handleContact->getAllContactDownload(0,10000,$condition);
        $handleDownLog= new\Logic\DownLog();
       $handleDownLog->downloadlog(strtotime($startTime),strtotime($endTime),count($list));
        $title=array(
                'region_name'=>'区域','scope_name'=>'板块','estate_name'=>'小区名称','room_type'=>'房间类型','room_num'=>'几室','room_id'=>'房间编号','room_money'=>'租金','info_resource'=>'来源','is_commission'=>'是否有佣金','mobile'=>'租客手机','big_code'=>'400号码','ext_code'=>'小号','agent_company_name'=>'中介公司',
                'owner_mobile'=>'房东手机','owner_name'=>'房东姓名','gaodu_platform'=>'电话来源','charge_man'=>'房源负责人','principal_man'=>'房东负责人','status_code'=>'电话状态','caller_length'=>'主叫时长(秒)','called_length'=>'被叫时长(秒)','call_time'=>'拨打时间','brand_type'=>'品牌名称',
                'is_monthly'=>'是否包月','is_owner'=>'是否中介录音');
        $exarr[]=$title;
        $phoneStatusArray=getPhoneStatusArray();
         $downAll=false;
        if(in_array(trim(getLoginName()), getDownloadLimit())){
              $downAll=true;
        }
        //品牌名称
        $brand_list=array(''=>'');
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getResourceParameters();
        if($result!=null){
          foreach ($result as $key => $value) {
            if($value['info_type']==16){
              $brand_list[$value["type_no"]]=$value["name"];
            }
          } 
        }
        foreach ($list as $key => $value) {
            $value['call_time']=$value['call_time']>0?date("Y-m-d H:i",$value['call_time']):""; 
            $value['room_num']=$value['room_num']>=0?$value['room_num']:'';
            switch ($value['is_commission']) {
                case '1':
                    $value['is_commission']="是";
                    break;
                case '2':
                    $value['is_commission']="否";
                    break;
                default:
                    $value['is_commission']="";
                    break;
            }
            switch ($value['is_monthly']) {
                case '1':
                    $value['is_monthly']="是";
                    break;
                case '2':
                    $value['is_monthly']="否";
                    break;
                default:
                    $value['is_monthly']="";
                    break;
            }
            if($value['is_owner'] == 5) {
                $value['is_owner']='是';
            } else {
                $value['is_owner']='否';
            }
            switch ($value['gaodu_platform']) {
                case '1':
                    $value['gaodu_platform']="android";
                    break;
                case '2':
                    $value['gaodu_platform']="iphone";
                    break;
                case '3':
                    $value['gaodu_platform']="400系统";
                    break;
                case '9':
                    $value['gaodu_platform']="百度推广";
                    break;
                case '10':
                    $value['gaodu_platform']="微信";
                    break;
                case '6':
                    $value['gaodu_platform']="h5";
                    break;    
                default:
                    $value['gaodu_platform']="";
                    break;
            }
            if(!$downAll){
                $value['owner_mobile']=substr_replace($value['owner_mobile'], '****', 4,4);
            }
            switch ($value['room_type']) {
                case '1':
                    $value['room_type']='合租';
                    break;
                case '2':
                    $value['room_type']='整租';
                    break;
                default:
                    break;
            }
            if($value['status_code']=='-1'){
                $value['status_code']="未知";
            }else{
                $value['status_code']=$phoneStatusArray[$value['status_code']];
            }
            
            if($value['brand_type']!=''){
              $value['brand_type']=$brand_list[$value['brand_type']];
            }
            $exarr[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '联系房东记录列表');
        $xls->addArray($exarr);
        $xls->generateXML('联系房东'.date("YmdHis"));
    }
     //重新下载录音
    public function anewdowload(){
        $handleCalllog=new \Logic\Calllog();
        $where['id']=I('get.callid');
        if(empty($where['id'])){
            echo '{"status":"400","message":"fail"}';return;
        }
        $data=$handleCalllog->modelGetFind($where);
        $data['fail_times']=0;
        $handleCalllog->modelUpdate($data);
        echo '{"status":"200","message":"success"}';
            
    }
    //中介重新下载录音
    public function virtualanewdowload(){
        $handleCalllog=new \Logic\Calllog();
        $where['id']=I('get.callid');
        if(empty($where['id'])){
            echo '{"status":"400","message":"fail"}';return;
        }
        $data=$handleCalllog->modelVirtualFind($where);
        $data['fail_times']=0;
        $handleCalllog->modelVirtualUpdate($data);
        echo '{"status":"200","message":"success"}';
            
    }
    //未听录音
    public function nothearlist(){
            $handleCommonCache=new \Logic\CommonCacheLogic();
            if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
            }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new\Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
            $handleMenu->jurisdiction();
            
            $makcall=trim(I('get.makcall'));
            $loginphone=trim(I('get.loginphone'));
            $ownerphone=trim(I('get.ownerphone'));
            $statuscode=trim(I('get.statuscode'));
            $bigphone=trim(I('get.bigphone'));
            $gaodu_platform=trim(I('get.platform'));
            $info_resource_type=trim(I('get.info_resource_type'));
            $info_resource=trim(I('get.info_resource'));
            $is_owner=I('get.is_owner');
            $startTime=trim(I('get.startTime'));
            $endTime=trim(I('get.endTime'));
            if($startTime!="" && $endTime!=""){
               $where['call_time']=array(array('gt',strtotime($startTime)),array('lt',strtotime($endTime)+86400));
            }else{
                $where['call_time']=array('gt',strtotime(date("Y-m-d",time()-3600*24*7)));
            }
            /*else if($startTime!=""){
               $where['call_time']=array('gt',strtotime($startTime));
            }else if($endTime!=""){
                $where['call_time']=array('lt',strtotime($endTime)+86400);
             }*/
            
            if($loginphone!=""){
                $where['mobile']=array('eq',$loginphone);
             }
            if($makcall!=""){
              $where['is_my']=array('eq',intval($makcall));
            }
            if($gaodu_platform!=''){
              $where['gaodu_platform']=intval($gaodu_platform);
            }
            if($ownerphone!=""){
              $where['owner_mobile']=array('eq',$ownerphone);
            }
            if($is_owner==5){
                $where['is_owner']=array('eq',$is_owner);
            }elseif($is_owner==999){
               $where['is_owner']=array('neq',5);
            }
          $where['city_id']=C('CITY_CODE');
          $where['is_read']=array('neq',1);
          $where['status_code']=array('eq',0);
            if($bigphone!=""){
              $where['big_code']=array('eq',$bigphone);
            }else{
              $where['big_code']=array('neq','4008108756');
            }
            if($info_resource_type!=''){
                $where['info_resource_type']=array('eq',$info_resource_type);
            }
            if($info_resource!=""){
                if($info_resource=="空"){
                    $where['info_resource']=array('eq',"");
                }else{
                    $where['info_resource']=array('eq',$info_resource);
                }
            }
            $handleContact = new \Logic\ContactOwner();
            $count=$handleContact->getContactOwnerCount($where);
            $Page= new \Think\Page($count,10);
            $listarr='';
            if($count>0){
                $list=$handleContact->getContactOwnerList($Page->firstRow,$Page->listRows,$where,$count);
                 $handleCalllog=new \Logic\Calllog();
                 foreach ($list as $key => $value) {
                     $wherecall['id']=$value['call_id'];
                     if($value['source']==10){
                        $is_down=$handleCalllog->modelVirtualFind($wherecall);
                     }else{
                        $is_down=$handleCalllog->modelGetFind($wherecall);
                     }
                     $value['is_down']=$is_down['is_down'];
                     $value['fail_times']=$is_down['fail_times'];
                     $listarr[]=$value;
                 }
            }
            //数据来源
            $this->bindInforesource($info_resource_type);
            $this->assign("pagecount",$count);
            $this->assign("show",$Page->show());
            $this->assign("list",$listarr);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();

        }
    //显示用户社会信息    
    public function socializeInfoList ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
        echo '{"status":"404","message":"登录失效"}';return;
        }
        $mobile = I('post.mobile');
        if(empty($mobile)) {
            echo '{"status":"400","message":"参数错误","data":{}}';return;
        }
        $handleContact = new \Logic\ContactOwner();
        $result = $handleContact->getSocializeInfo($mobile);
        $return = json_decode($result,true); 
        if($return !== null) {
            $data = $return;
        } else {
            $data['sex'] = '';
            $data['if_cut_off'] = '';
            $data['if_bathroom'] = '';
            $data['if_kitchen'] = '';
            $data['look_room'] = '';
            $data['if_reject_landlord'] = '';
            $data['city_code'] = $handleContact->getCustomerCityCode($mobile);
        }
        echo json_encode($data);
    }
    //添加用户社会化信息
    public function socializeInfo ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
        echo '{"status":"404","message":"登录失效"}';return;
        }
        $data = I('post.');
        if(empty($data['mobile'])) {
            echo '{"status":"400","message":"参数错误","data":{}}';return;
        }
        $data['actionType'] = '2';
        $handleContact = new \Logic\ContactOwner();
        $return = $handleContact->sendSocializeInfo($data);
        echo $return;
    }

       //已听录音
    public function thearlist(){
            $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
             $switchcity=$handleCommonCache->cityauthority();
              $this->assign("switchcity",$switchcity);
              $handleMenu = new\Logic\AdminMenuListLimit();
              $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
              $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
              $handleMenu->jurisdiction();
              $this->assign("menutophtml",$menu_top_html);
              $this->assign("menulefthtml",$menu_left_html);

             $condition['startTime']=I('get.startTime');
             $condition['endTime']=I('get.endTime');
             $condition['makcall']=I('get.makcall');
             $condition['loginphone']=I('get.loginphone');
             $condition['ownerphone']=I('get.ownerphone');
             $condition['info_resource_type']=I('get.info_resource_type');
             $condition['info_resource']=I('get.info_resource');
             $condition['handleman']=I('get.handleman');
             $condition['platform']=I('get.platform');
             $condition['status_code']=0;
             $condition['is_read']=1;
             $condition['charge_man']=I('get.charge_man');
             $condition['brand_type']=I('get.brand_type');
             $condition['pagecnt']=I('get.pagecnt');
             $is_owner=I('get.is_owner');
             if($is_owner==5){
                  $condition['is_owner']=$is_owner;
             }elseif($is_owner==999){
                   $condition['is_owner']=999;
             }
             $handleContact = new \Logic\ContactOwner();
            if(I('get.p')=="" && I('get.temp')=='q'){
                //汇总
                $countModel=$handleContact->getHaveheardCount($condition);
                if($countModel!==null && $countModel!==false && count($countModel)>0){
                    $condition['pagecnt']=$countModel[0]['cnt'];
                }
            }
            $list=array();$show="";
            if($condition['pagecnt']>0){
                $Page= new \Think\Page($condition['pagecnt'],8);
                foreach($condition as $key=>$val) {
                    $Page->parameter[$key]=urlencode($val);
                }
                $list=$handleContact->getHaveheardList($Page->firstRow,$Page->listRows,$condition);
                $show=$Page->show();
            }
            /*查询条件（品牌）*/
            $handleResource=new \Logic\HouseResourceLogic();
            $result=$handleResource->getResourceParameters();
            $brandString='<option value="none">无</option><option value="all">有</option>';//品牌
            if($result !==null && $result !==false){
                foreach ($result as $key => $value) {
                    if($value['info_type']==16){
                        $brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
                    }
                }   
            }
             $this->assign("brandTypeList",$brandString);
             $this->assign("pagecnt",$condition['pagecnt']);
             //数据来源
             $this->bindInforesource($condition['info_resource_type']);
             $this->assign("list",$list);
             $this->assign("show",$show);
             $this->display();
        
      }
      //备注录音内容
      public function remarkscontent(){
           $handleContact = new \Logic\ContactOwner();
            $call_id=I('get.callid');
            $content=I('get.content');
            $where['id']= $call_id;
            $data=$handleContact->modelFind($where);
            if($data['memo']==""&&$data['is_read']!=0){
                 $data['memo']=$content;
                 $data['is_read']=1;
                 $result=$handleContact->modelUpdate($data);
                 if($result){
                     echo "{\"status\":\"200\",\"msg\":\"\"}";
                 }
            }else{
                 echo "{\"status\":\"201\",\"msg\":\"\"}";
            }
      }
      //已出租，房源更新
      public function uphouserroom(){
            $handleContact = new \Logic\ContactOwner();
            $handleSelect = new \Logic\HouseSelectLogic();
            $roomLogic=new \Logic\HouseRoomLogic();
            $room_no=I('get.roomid');
            $uptype=I('get.uptype');
            $where1['id']=I('get.id');
            $data1=$handleContact->modelFind($where1);
            if($data1['is_read']==1){
                  echo "{\"status\":\"201\",\"msg\":\"\"}";
            }else{
               if($room_no!=""){
                    $where['room_no']=$room_no;
                    $data=$handleContact->modelHouseRoomFind($where);
                    $room_id=$data['id'];
                    if($uptype==1){
                         $data1['memo']="已出租";
                         $data1['is_read']=1;
                         $result=$handleContact->modelUpdate($data1);
                        if($result){
                            $roomLogic->downroomByid($room_id);
                            if($data1['rooms_id']!=""){
                                $readwhere['rooms_id']=$data1['rooms_id'];
                                $readwhere['owner_mobile']=$data1['owner_mobile'];
                                $readwhere['is_read']=array('neq',1);
                                $handleContact->updateallcall($readwhere);
                            }
                            //记录房源操作日志
                            /*$handleupdatelog=new \Home\Model\houseupdatelog();
                            $houselog['id']=guid();
                            $houselog['house_id']=$data1['rooms_id'];
                            $houselog['house_type']=2;
                            $houselog['update_man']=cookie("admin_user_name");
                            $houselog['update_time']=time();
                            $houselog['operate_type']="已出租房间";
                            $houselog['operate_bak']="联系房东";
                            $handleupdatelog->addModel($houselog);*/
                            echo '{"status":"200","msg":""}';
                        }
                    }elseif($uptype==2) {
                        $refresh=new \Home\Model\customerlimitrefresh();
                        $curefresh['customer_id']=$data['customer_id'];
                        $refresharr=$refresh->modelFind($curefresh);
                        if(!$refresharr){
                            $data['update_time']=time();
                            $data['update_man']=cookie("admin_user_name");
                            $handleContact->modelHouseRoomUpdate($data);
                            $datase['room_id']=$data['id'];
                            $datase['update_time']=time();
                            $handleSelect->updateModelByRoomid($datase);
                        }
                        $data1['memo']="更新房源";
                        $data1['is_read']=1;
                        $handleContact->modelUpdate($data1);
                        if($data1['rooms_id']!=""){
                            $readwhere['rooms_id']=$data1['rooms_id'];
                            $readwhere['owner_mobile']=$data1['owner_mobile'];
                            $readwhere['is_read']=array('neq',1);
                            $handleContact->updateallcall($readwhere);
                        }
                        //记录房源操作日志
                        $handleupdatelog=new \Home\Model\houseupdatelog();
                        $houselog['id']=guid();
                        $houselog['house_id']=$data1['rooms_id'];
                        $houselog['house_type']=2;
                        $houselog['update_man']=cookie("admin_user_name");
                        $houselog['update_time']=time();
                        $houselog['operate_type']="更新时间";
                        $houselog['operate_bak']="联系房东";
                        $handleupdatelog->addModel($houselog);
                        echo "{\"status\":\"200\",\"msg\":\"\"}";
                        
                    }
                }

            }
      }
    //播放录音更新正在听状态
    public function recordState(){
           $handleContact = new \Logic\ContactOwner();
            $where['id']=I('get.id');
            $data=$handleContact->modelFind($where);
            if($data['is_read']==0){
                $data['is_read']=2;
                $data['updata_man']=cookie("admin_user_name");
                $data['update_time']=time();
                $result=$handleContact->modelUpdate($data);
                if($result){
                     echo "{\"status\":\"200\",\"msg\":\"\"}";
                }
            }else{
                echo "{\"status\":\"201\",\"msg\":\"\"}";
            }
    }
   //房源编号为空时已听操作
   public function alreadylisten(){
            $handleContact = new \Logic\ContactOwner();
            $where['id']=I('get.id');
            $data=$handleContact->modelFind($where);
            if($data['is_read']!=1&&$data['is_read']!=0){
                $data['is_read']=1;
                $result=$handleContact->modelUpdate($data);
                if($result){
                     echo "{\"status\":\"200\",\"msg\":\"\"}";
                }
            }else{
                echo "{\"status\":\"201\",\"msg\":\"\"}";
            }
   }

   //已听录音下载
   public function dowthearlist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $startTime=I('get.startTime');
         $endTime=I('get.endTime');
             
         if(empty($startTime) || empty($endTime)){
            return $this->success('下载数据不能超过一个月！',"thearlist.html?no=3&leftno=98",0);
         }
         $limit_time=strtotime($endTime)-strtotime($startTime);
         if($limit_time>3600*24*30){
            return $this->success('下载数据不能超过一个月！',"thearlist.html?no=3&leftno=98",0);
         }
         $condition['startTime']=I('get.startTime');
         $condition['endTime']=I('get.endTime');
         $condition['makcall']=I('get.makcall');
         $condition['loginphone']=I('get.loginphone');
         $condition['ownerphone']=I('get.ownerphone');
         $condition['info_resource_type']=I('get.info_resource_type');
         $condition['info_resource']=I('get.info_resource');
         $condition['handleman']=I('get.handleman');
         $condition['platform']=I('get.platform');
         $condition['status_code']=0;
         $condition['is_read']=1;
         $condition['charge_man']=I('get.charge_man');
         $condition['brand_type']=I('get.brand_type');

        $handleContact = new \Logic\ContactOwner();
        $list=$handleContact->getHaveheardList(0,5000,$condition);

        $handleDownLog= new\Logic\DownLog();
       $handleDownLog->downloadlog(strtotime($startTime),strtotime($endTime),count($list));
         $title=array(
                'room_id'=>'房间编号','info_resource'=>'来源','is_commission'=>'是否有佣金','mobile'=>'租客手机','owner_mobile'=>'房东手机','owner_name'=>'房东姓名','charge_man'=>'房源负责人',
                'status_code'=>'电话状态','called_length'=>'被叫时长(秒)','call_time'=>'拨打时间','updata_man'=>'操作人','update_time'=>'操作时间','memo'=>'录音内容',
                'call_id'=>'','is_owner'=>'','source'=>'','recording_txt'=>''
         );
        $exarr[]=$title;
         $downAll=false;
        if(in_array(trim(getLoginName()), getDownloadLimit())){
              $downAll=true;
        }
        foreach ($list as $key => $value) {
            $value['call_time']=$value['call_time']>0?date("Y-m-d H:i",$value['call_time']):""; 
            $value['update_time']=$value['update_time']>0?date("Y-m-d H:i",$value['update_time']):""; 
            switch ($value['is_commission']) {
                case '1':
                    $value['is_commission']="是";
                    break;
                case '2':
                    $value['is_commission']="否";
                    break;
                default:
                    $value['is_commission']="";
                    break;
            }
            if(!$downAll){
                $value['owner_mobile']=substr_replace($value['owner_mobile'], '****', 4,4);
            }
            $value['status_code']="成功";
            $value['call_id']="";
            $value['recording_txt']="";
            $value['is_owner']="";
            $value['source']="";
            $exarr[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '已听录音列表');
        $xls->addArray($exarr);
        $xls->generateXML('已听录音'.date("YmdHis"));
   }
   //根据房间编号查找店铺
    public function findStoreID ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)) {
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');//room_no
        $handleContact = new \Logic\ContactOwner();
        $storeID = $handleContact->findHouseRoom($data);
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
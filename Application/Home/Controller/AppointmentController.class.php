<?php
namespace Home\Controller;
use Think\Controller;
class AppointmentController extends Controller{
	public function setappointmentshowlist(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        //查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['startTime_create']=isset($_GET['startTime_create'])?$_GET['startTime_create']:"";
        $condition['endTime_create']=isset($_GET['endTime_create'])?$_GET['endTime_create']:"";
        $condition['estateName']=isset($_GET['estateName'])?$_GET['estateName']:"";
        $condition['roomStatus']=isset($_GET['roomStatus'])?$_GET['roomStatus']:"";
        $condition['roomNo']=isset($_GET['roomNo'])?$_GET['roomNo']:"";
        $condition['business_type']=isset($_GET['business_type'])?$_GET['business_type']:"";
        $condition['clientPhone']=isset($_GET['clientPhone'])?$_GET['clientPhone']:"";
        $condition['create_man']=isset($_GET['create_man'])?$_GET['create_man']:"";
        $condition['update_man']=isset($_GET['update_man'])?$_GET['update_man']:"";//操作人
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['brand_type']=isset($_GET['brand_type'])?$_GET['brand_type']:"";
        $condition['region']=isset($_GET['region'])?$_GET['region']:"";
        $condition['scope']=isset($_GET['scope'])?$_GET['scope']:"";

        $condition['callclient']=I('get.callclient');
        $condition['appoint']=I('get.appoint');
        $condition['kefu']=I('get.kefu');
        $condition['moneyMin']=I('get.moneyMin');
        $condition['moneyMax']=I('get.moneyMax');
        $handleLogic=new \Logic\HouseRoomLogic();
        $totalCount =0;
        $list=array();
        $hadCondition=false;$pageSHow='';
        foreach ($condition as $k1 => $v1) {
            if($v1!=''){
                $hadCondition=true;
                break;
            }
        }
        if($hadCondition){
            $totalCountModel = $handleLogic->getSetAppointListCount($condition);//总条数
            if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
                $totalCount=$totalCountModel[0]['totalCount'];
                $Page= new \Think\Page($totalCount,20);//分页
                $pageSHow=$Page->show();
                $list = $handleLogic->getSetAppointList($condition,$Page->firstRow,$Page->listRows);
            }
        }
        
        $this->assign("pageSHow",$pageSHow);
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        /*查询条件（业务类型）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getResourceParameters();
        $typeString='';//业务类型
        $brandString='<option value="none">无</option><option value="all">有</option>';//品牌
		if($result !=null && $result !=false){
			foreach ($result as $key => $value) {
				if($value['info_type']==15){
					$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}else if($value['info_type']==16){
					$brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}
			}	
		}
		$this->assign("businessTypeList",$typeString);
		$this->assign("brandTypeList",$brandString);
        //数据来源
        $this->bindInforesource($condition['info_resource_type']);
		/*查询条件（房间负责人）*/
        $result=$handleResource->getHouseHandleList();
		$createmanString='';
		foreach ($result as $key => $value) {
			$createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
		}	
		$this->assign("createManList",$createmanString);
		
		/*查询条件（区域板块）*/
		$regionResult=$handleResource->getRegionList();
		$regionList='';
		if($regionResult !=null){
			foreach ($regionResult as $key => $value) {
				$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
			}	
		}
		$this->assign("regionList",$regionList);
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
		$this->assign("scopeList",$scopeList);
		$this->display();
	}
	public function setAppointShow(){
		if(isset($_POST['room_ids']) && isset($_POST['type']) && isset($_POST['is_show'])){
			if(empty($_POST['room_ids']) || empty($_POST['type']) || empty($_POST['is_show'])){
				echo '{"status":"500","msg":"参数为空"}';
			}else{
				$handleLogic=new \Logic\HouseRoomLogic();
				$ids_str=rtrim($_POST['room_ids'],',');
				$ids_array=explode(',', $ids_str);
				$ids_str='';
				foreach ($ids_array as $key => $value) {
                    if(!empty($value)){
                        $ids_str.="'".$value."',";
                    }
				}
				if($ids_str==''){
					echo '{"status":"400","msg":"操作失败"}';return;
				}
				$handleLogic->setAppointmentShow($_POST['type'],rtrim($ids_str,','),$_POST['is_show']);
				echo '{"status":"200","msg":"操作成功"}';
			}
		}else{
			echo '{"status":"500","msg":"参数错误"}';
		}
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
	/*预约管理 */
	public function alllist(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"87");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"87");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['status']=I('get.status');
        $condition['gaodu_platform']=I('get.gaodu_platform');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['mobile']=trim(I('get.mobile'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['create_man']=trim(I('get.create_man'));
        $condition['startTime_look']=I('get.startTime_look');
        $condition['endTime_look']=I('get.endTime_look');
        $condition['is_my']=isset($_GET['is_my'])?$_GET['is_my']:"0";
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['brand_type']=I('get.brand_type');
        $condition['is_commission']=I('get.is_commission');
        $condition['isMonth']=I('get.isMonth');
        $condition['startHandle']=I('get.startHandle');
        $condition['endHandle']=I('get.endHandle');
        $condition['handle_reason']=I('get.handle_reason');

        $condition['totalnum']=I('get.totalnum');
        $condition['zuke']=I('get.zuke');
        $condition['fangdong']=I('get.fangdong');
        $condition['roomnum']=I('get.roomnum');
        $handleLogic=new \Logic\HouseReserveCallLogic();

        $list=array();$pageSHow='';
        if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['mobile'])){
            $totalCountModel = $handleLogic->getModelListCount($condition);//总条数
            if($totalCountModel!=null && count($totalCountModel)>=1){
                $condition['totalnum']=$totalCountModel[0]['totalCount'];
                $condition['zuke']=$totalCountModel[0]['zuke'];
                $condition['fangdong']=$totalCountModel[0]['fangdong'];
                $condition['roomnum']=$totalCountModel[0]['roomnum'];
            }
        }
        if($condition['totalnum']>0){
            $Page= new \Think\Page($condition['totalnum'],10);//分页
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $pageSHow=$Page->show();
            $list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
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
        //数据来源
        $this->bindInforesource($condition['info_resource_type']);
        $this->assign("list",$list);
        $this->assign("pageSHow",$pageSHow);
        $this->assign("sumcategory",array('totalnum'=>$condition['totalnum'],'zuke'=>$condition['zuke'],'fangdong'=>$condition['fangdong'],'roomnum'=>$condition['roomnum']));
		$this->display();
	}
    /*我处理的预约 */
    public function myhandlelist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $login_name=trim(getLoginName());
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"87");
        $menu_left_html=$handleMenu->menuLeft($login_name,"87");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        //查询条件
        $condition['flag']=I('get.flag');
        $condition['startHandle']=I('get.startHandle');
        $condition['endHandle']=I('get.endHandle');
        if($condition['flag']!='query'){
            $condition['startHandle']=date("Y-m-d",time()-3600*48);
            $condition['endHandle']=date("Y-m-d");
        }
        $condition['status']=I('get.status');
        $condition['gaodu_platform']=I('get.gaodu_platform');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['mobile']=trim(I('get.mobile'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['create_man']=$login_name;
        $condition['handle_reason']=I('get.handle_reason');
        $condition['is_my']="all";
        $totalCount =0; $list=array();$pageSHow='';
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $totalCountModel = $handleLogic->getModelListCount($condition);//总条数
        if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
            $totalCount=$totalCountModel[0]['totalCount'];
            $Page= new \Think\Page($totalCount,10);//分页
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $pageSHow=$Page->show();
            $list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows,'handle_time desc ');
        }
        $this->assign("pageSHow",$pageSHow);
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->display();
    }
    /*未处理的预约 */
    public function handlelist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $login_name=getLoginName();
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"87");
        $menu_left_html=$handleMenu->menuLeft($login_name,"87");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['startTime_look']=I('get.startTime_look');
        $condition['endTime_look']=I('get.endTime_look');
        $condition['status']="0";
        $condition['gaodu_platform']=I('get.gaodu_platform');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['mobile']=trim(I('get.mobile'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['is_my']=isset($_GET['is_my'])?$_GET['is_my']:"0";
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $totalCount =0;
        $list=array();
        $totalCountModel = $handleLogic->getModelListCount($condition);//总条数
        if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
            $totalCount=$totalCountModel[0]['totalCount'];
            $Page= new \Think\Page($totalCount,8);//分页
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $this->assign("pageSHow",$Page->show());
            $list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }else{
            $this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->display();
    }
    #ajax 获取房间对应的 PC端分机号
    public function getPcExtcodeByRoomid(){
        if(!isset($_GET['room_id']) || empty($_GET['room_id'])){
            echo '';return;
        }
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $result=$handleLogic->getPcExtcodeByRoomid($_GET['room_id'],$_GET['source']);
        if($result!=null && $result!=false){
            echo $result['big_code'].",".$result['ext_code'];
        }else{
            echo '';
        }
    }
    #ajax 获取房间对应的 是否含有佣金
    public function getCommissionByRoomno(){
        if(!isset($_GET['room_no']) || empty($_GET['room_no'])){
            echo '';return;
        }
        $modelDal=new \Home\Model\commission();
        $comm_list=$modelDal->getModelByNo($_GET['room_no']);
        if($comm_list!==null && $comm_list!==false && count($comm_list)>0){
           echo '是';return;
        }
        echo '否';
    }
    #ajax 获取房间对应的 数据来源
    public function getRoominfoByRoomid(){
        $room_id=I('get.room_id');
        if(empty($room_id)){
            echo '{"source":"","commission":"","isMonth":""}';return;
        }
        $modelDal=new \Logic\HouseRoomLogic();
        $result=$modelDal->getModelById($room_id);
        if($result!==null && $result!==false){
            $commission=$result['is_commission']==1?'是':'否';
            $isMonth=$result['is_monthly']==1?'是':'否';
           echo '{"source":"'.$result['info_resource'].'","commission":"'.$commission.'","isMonth":"'.$isMonth.'"}';
        }else{
           echo '{"source":"","commission":"","isMonth":""}';
        }

    }
    #新消息
    public function newmessage(){
        $nowHour=date('H',time());
        if($nowHour>20 || $nowHour<9){
            echo 0;return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            echo 10000;return;
         }
         $handleLogic=new \Logic\HouseReserveCallLogic();
         echo $handleLogic->getNotHandleCount();
    }

	#点击处理
	public function handleappoint(){
		if(!isset($_GET['id']) || empty($_GET['id'])){
			echo "参数错误";return;
		}
		$handleLogic=new \Logic\HouseReserveCallLogic();
		$appointModel=$handleLogic->getCallModelById($_GET['id']);
		if($appointModel===null || $appointModel===false){
			echo "操作失败";return;
		}
		if(in_array($appointModel['status'], array(2,3,5))){
			//echo "已被处理";return;
		}
        $login_name=trim(getLoginName());
        if($appointModel['status']==1 && trim($appointModel['handle_man'])!=$login_name){
            echo "在处理中";return;
        }
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"87");
        $menu_left_html=$handleMenu->menuLeft($login_name,"87");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        if(in_array($appointModel['status'], array(0,4))){
            //更新状态，记录日志
            $appointModel['status']=1;
            $appointModel['handle_man']=$login_name;
            $appointModel['handle_time']=time();
            $handleLogic->updateCallModel($appointModel);
            #update more
            $handleLogic->UpdateMoreForone($appointModel['customer_mobile'],$login_name,time(),1);
            $log['reservecall_id']=$appointModel['id'];
            $log['status']=$appointModel['status'];
            $log['handle_man']=$appointModel['handle_man'];
            $log['handle_time']=$appointModel['handle_time'];
            $handleLogic->addCallLogModel($log);
        }
        //读取历史预约
        $list=$handleLogic->getModelListByCustomerId($appointModel['customer_id']);
        $this->assign("appointModel",$appointModel);
        $this->assign("list",$list);
        $this->display();
	}
    #处理更多
    public function handleMoreAppoint(){
        if(!isset($_POST['ids']) || empty($_POST['ids'])){
           echo '{"status":"500","msg":"参数为空"}';return;
        }
        $array_ids=split(',', rtrim($_POST['ids'],','));
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $count=$handleLogic->getHadcountByMoreids($array_ids);
        if($count>0){
            echo '{"status":"400","msg":"有其他人正在处理中的预约单"}';return ;
        }
        $result=$handleLogic->UpdateHandleByMoreids($array_ids,getLoginName(),time(),1);
        if($result){
            echo '{"status":"200","msg":"操作成功"}';
        }else{
            echo '{"status":"400","msg":"操作失败"}';
        }
    }
    #放弃处理
    public function handleGiveup(){
        if(!isset($_GET['pid']) || empty($_GET['pid'])){
           echo '{"status":"500","msg":"参数为空"}';return;
        }
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $callModel=$handleLogic->getCallModelById($_GET['pid']);
        if($callModel==null || $callModel==false){
            echo '{"status":"400","msg":"预约单读取失败"}';return;
        }
        $callModel['status']=0;
        $callModel['handle_man']="";
        $callModel['handle_time']=0;
        $result=$handleLogic->updateCallModel($callModel);
        if($result){
            echo '{"status":"200","msg":"操作成功"}';
        }else{
            echo '{"status":"400","msg":"操作失败"}';
        }
    }
      #处理转接
    public function handleTransfer(){
        $pid=I('get.pid');
        $transmen=trim(I('get.transmen'));
        if(empty($transmen) || empty($pid)){
           echo '{"status":"500","msg":"参数为空"}';return;
        }
        $handleCustomerinfo= new \Home\Model\customerinfo();
        $result1=$handleCustomerinfo->modelPrincipalFind($transmen);
        if(!$result1){
          echo '{"status":"502","msg":"人员不存在，无法转出"}';
          return;
        }
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $handleResource=new \Logic\HouseResourceLogic();
        $ids=explode(',', $pid);
        $success_count=0;
        foreach ($ids as $key => $value) {
            if(!empty($value)){
                $callModel=$handleLogic->getCallModelById($value);
                if($callModel===null || $callModel===false){
                    continue;
                }
                $callModel['handle_man']=$transmen;
                $result=$handleLogic->updateCallModel($callModel);
                if($result){
                    if($transmen=='yuzongmin'){
                        $resourceModel=$handleResource->getModelById($callModel['resource_id']);
                        $info_resource=$resourceModel!=null?$resourceModel['info_resource']:"";
                        $this->transfer_sendmessage($callModel['customer_mobile'],$callModel['owner_mobile'],$callModel['room_id'],'13122358883',$info_resource);
                    }
                    $success_count+=1;
                }
            }
        }
        echo '{"status":"200","msg":"成功转出'.$success_count.'单"}';
    }
    public function transfer_sendmessage($renter_phone,$client_phone,$room_id,$send_phone,$info_resource=''){
        if(empty($renter_phone) || empty($client_phone) || empty($room_id) || empty($send_phone)){
            return false;
        }
        switch (C('CITY_CODE')) {
            case '001009001':
                $uri='http://m.hizhu.com/shanghai/roomDetail.html?room_id='.$room_id.'&city_code=001009001&city_name=shanghai#c=sh';
                break;
            case '001001':
                $uri='http://m.hizhu.com/beijing/roomDetail.html?room_id='.$room_id.'&city_code=001001&city_name=beijing#c=bj';
                break;
            case '001011001':
                $uri='http://m.hizhu.com/hangzhou/roomDetail.html?room_id='.$room_id.'&city_code=001011001&city_name=hangzhou#c=hz';
                break;
            case '001010001':
                $uri='http://m.hizhu.com/nanjing/roomDetail.html?room_id='.$room_id.'&city_code=001010001&city_name=nanjing#c=nj';
                break;
            case '001019002':
                $uri='http://m.hizhu.com/shenzhen/roomDetail.html?room_id='.$room_id.'&city_code=001019002&city_name=shenzhen#c=sz';
                break;
            default:
                $uri='http://m.hizhu.com/shanghai/roomDetail.html?room_id='.$room_id.'&city_code=001009001&city_name=shanghai#c=sh';
                break;
        }
        $sendArr['money']='url';
        $output=curl_url('http://api.t.sina.com.cn/short_url/shorten.json?source=2859504802&url_long='.$uri);
        if(!empty($output)){
          $result=json_decode($output,true);
          if(count($result)==0 || !isset($result[0]['url_short'])){
            $sendArr['money']='url';
          }else{
            $sendArr['money']=$result[0]['url_short'];
          }
        }
        /*发送短信*/
        $sendArr['smstype']='FHS008';
        $sendArr['name']=$renter_phone;
        $sendArr['phonenumber']=$send_phone;
        $sendArr['timestamp']=time();
        $sendArr['orderid']=$client_phone;
        if($info_resource!=''){
            $sendArr['orderid']=$client_phone.'，来源：'.$info_resource;
        }
        sendPhoneContent($sendArr);
    }
    #处理中
    public function submitHandle(){
        if(isset($_POST['type']) && isset($_POST['info']) && isset($_POST['id'])){
            if(empty($_POST['type']) || empty($_POST['info']) || empty($_POST['id'])){
                echo '{"status":"500","msg":"参数为空"}';
            }else{
                $handleLogic=new \Logic\HouseReserveCallLogic();
                $ids=explode(',', $_POST['id']);
                $success_count=0;
                $login_name=trim(getLoginName());
                //还是‘处理中’状态
                if($_POST['type']=='1'){
                    $bakinfo=trim(I('post.bak'));
                    if($bakinfo!=''){
                        foreach ($ids as $k => $v) {
                            if(empty($v)){
                                continue;
                            }
                            $handleLogic->updateCallModel(array('id'=>$v,'customer_bak'=>$bakinfo));
                        }
                        echo '{"status":"200","msg":"处理成功"}';return;
                    }else{
                        echo '{"status":"500","msg":"处理成功"}';return;
                    }
                   
                }
                foreach ($ids as $key => $value) {
                    if(empty($value)){
                        continue;
                    }
                    $callModel=$handleLogic->getCallModelById($value);
                    if($callModel===null || $callModel===false){
                        continue;
                    }
                    switch ($_POST['type']) {
                        case '2':
                            $houseInfoArray=$handleLogic->getAllinfoByRoomid($callModel['room_id']);
                            if($houseInfoArray===null || $houseInfoArray===false || count($houseInfoArray)==0){
                               continue; 
                            }
                            $houseInfo=$houseInfoArray[0];
                            if($houseInfo['status']!=2 || $houseInfo['record_status']==0){
                               continue;
                            }
                            #更新状态，新增记录
                            $data['id']=$callModel['id'];
                            $data['status']=2;
                            $data['look_time']=strtotime($_POST['info']);
                            if($data['look_time']<time()-1000){
                                continue;
                            }
                            $data['handle_man']=$login_name;
                            $data['handle_time']=time();
                            $data['customer_bak']=isset($_POST['bak'])?$_POST['bak']:"";
                            $max_no=$handleLogic->getMaxRebackno($callModel['customer_mobile']);
                            if($max_no===null || $max_no===false){
                                $data['reback_no']=10;
                            }else{
                                $data['reback_no']=$max_no+1;
                            }
                            $result=$handleLogic->updateCallModel($data);
                            if(!$result){
                                continue;
                            }
                            $log['reservecall_id']=$data['id'];
                            $log['status']=$data['status'];
                            $log['handle_man']=$data['handle_man'];
                            $log['handle_time']=$data['handle_time'];
                            $handleLogic->addCallLogModel($log);
                            #新增看房日程
                            $addReserve['id']=guid();
                            $addReserve['customer_id']=$callModel['customer_id'];
                            $addReserve['room_id']=$callModel['room_id'];
                            $addReserve['owner_id']=$callModel['owner_id'];
                            $addReserve['owner_name']=$callModel['owner_name'];
                            $addReserve['owner_phone']=$callModel['owner_mobile'];
                            $addReserve['view_time']=$data['look_time'];
                            $addReserve['create_time']=time();
                            $addReserve['city_code']=$callModel['city_code'];
                            $addReserve['resource_id']=$callModel['resource_id'];
                            $addReserve['region_id']=$houseInfo['region_id'];
                            $addReserve['region_name']=$houseInfo['region_name'];
                            $addReserve['scope_id']=$houseInfo['scope_id'];
                            $addReserve['scope_name']=$houseInfo['scope_name'];
                            $addReserve['room_name']=$houseInfo['room_name'];
                            $addReserve['room_area']=$houseInfo['room_area'];
                            $addReserve['room_money']=$houseInfo['room_money'];
                            $addReserve['main_img_path']=$houseInfo['main_img_path'];
                            $addReserve['estate_id']=$houseInfo['estate_id'];
                            $addReserve['estate_name']=$houseInfo['estate_name'];
                            $addReserve['estate_address']=$houseInfo['estate_address'];
                            
                            $modelDal=new \Home\Model\customer();
                            $customerModel = $modelDal->getModelById($callModel['owner_id']);
                            $fd_phone=$callModel['owner_mobile'];
                            if($customerModel!==null && $customerModel!==false){
                                $addReserve['telephone']=$customerModel['telephone'];//房东座机号
                                if(strpos($fd_phone, '1')!==0){
                                    $fd_phone=$customerModel['mobile'];
                                }
                            }
                            $addReserve['room_longitude']=$houseInfo['lpt_x'];
                            $addReserve['room_latitude']=$houseInfo['lpt_y'];
                            $addReserve['business_type']=$houseInfo['business_type'];
                            $addReserve['status']=$houseInfo['status'];
                            $addReserve['room_no']=$callModel['room_no'];
                            $result=$handleLogic->addHousereserve($addReserve);
                            if($result){
                                #send message
                                $handleLogic->sendmsg_success($callModel["customer_name"],$callModel["customer_mobile"],$addReserve["estate_name"],$addReserve["room_money"],$data['look_time'],$addReserve["estate_address"],$data["reback_no"],$fd_phone);
                                #消息推送
                                $this->sendappmsg_success($callModel["customer_name"],$callModel["customer_mobile"],$addReserve["estate_name"],$addReserve["room_money"],$data['look_time'],$addReserve["estate_address"],$data["reback_no"],$fd_phone,$callModel['customer_id'],$callModel['owner_id'],$houseInfo['is_owner']);
                
                                $success_count+=1;
                            }
                            break;
                        case '3':
                            # 取消预约
                            $houseInfoArray=$handleLogic->getAllinfoByRoomid($callModel['room_id']);
                            if($houseInfoArray===null || $houseInfoArray===false || count($houseInfoArray)==0){
                                continue;
                            }
                            #更新状态，新增记录
                            $data['id']=$callModel['id'];
                            $data['status']=3;
                            $data['handle_reason']=$_POST['info'];
                            $data['handle_man']=$login_name;
                            $data['handle_time']=time();
                            $data['customer_bak']=isset($_POST['bak'])?$_POST['bak']:"";
                            $result=$handleLogic->updateCallModel($data);
                            if(!$result){
                               continue;
                            }
                            $log['reservecall_id']=$data['id'];
                            $log['status']=$data['status'];
                            $log['handle_man']=$data['handle_man'];
                            $log['handle_time']=$data['handle_time'];
                            $handleLogic->addCallLogModel($log);
                            #send message
                            
                            $this->sendmsg_cancel($callModel["customer_mobile"],$houseInfoArray[0]["estate_name"],$houseInfoArray[0]["room_money"]);
                            
                            $success_count+=1;
                            break;
                        case '4':
                            # 暂停
                            #更新状态，新增记录
                            $data['id']=$callModel['id'];
                            $data['status']=4;
                            $data['handle_reason']=$_POST['info'];
                            $data['handle_man']=$login_name;
                            $data['handle_time']=time();
                            $data['customer_bak']=isset($_POST['bak'])?$_POST['bak']:"";
                            $result=$handleLogic->updateCallModel($data);
                            if(!$result){
                               continue;
                            }
                            $log['reservecall_id']=$data['id'];
                            $log['status']=$data['status'];
                            $log['handle_man']=$data['handle_man'];
                            $log['handle_time']=$data['handle_time'];
                            $handleLogic->addCallLogModel($log);
                            #send message
                            if($_POST['info']=="无法联系到租客"){
                                $this->sendmsg_stop($callModel["customer_mobile"]);
                                #暂停预约12小时后，此预约自动变为已取消，理由为客户主动放弃
                            }
                            $success_count+=1;
                            break;
                        case '5':
                            # 预约失败
                            $houseInfoArray=$handleLogic->getAllinfoByRoomid($callModel['room_id']);
                            if($houseInfoArray===null || $houseInfoArray===false || count($houseInfoArray)==0){
                                continue;
                            }
                            #更新状态，新增记录
                            $data['id']=$callModel['id'];
                            $data['status']=5;
                            $data['handle_reason']=$_POST['info'];
                            $data['handle_man']=$login_name;
                            $data['handle_time']=time();
                            $data['customer_bak']=isset($_POST['bak'])?$_POST['bak']:"";
                            $result=$handleLogic->updateCallModel($data);
                            if(!$result){
                                continue;
                            }
                            $log['reservecall_id']=$data['id'];
                            $log['status']=$data['status'];
                            $log['handle_man']=$data['handle_man'];
                            $log['handle_time']=$data['handle_time'];
                            $handleLogic->addCallLogModel($log);
                            #send message
                            $this->sendmsg_fail($callModel["customer_mobile"],$houseInfoArray[0]["estate_name"],$houseInfoArray[0]["room_money"],$data['handle_reason']);
                            if($data['handle_reason']=='房东联系不上'){
                                $fd_phone=$callModel['owner_mobile'];
                                if(strpos($fd_phone, '1')!==0){
                                    $customerDal=new \Home\Model\customer();
                                    $fd_model = $customerDal->getModelById($callModel['owner_id']);
                                    if($fd_model!==null && $fd_model!==false){
                                        $fd_phone=$fd_model['mobile'];
                                    }
                                }
                                $this->sendmsg_fail_owner($fd_phone);
                            }
                            $success_count+=1;
                            break;
                        case '9':
                            # 已配单
                            $data['id']=$callModel['id'];
                            $data['status']=9;
                            //$data['handle_reason']='';
                            $data['handle_man']=$login_name;
                            $data['handle_time']=time();
                            $data['customer_bak']=I('post.bak');
                            $result=$handleLogic->updateCallModel($data);
                            if(!$result){
                               continue;
                            }
                            $log['reservecall_id']=$data['id'];
                            $log['status']=$data['status'];
                            $log['handle_man']=$data['handle_man'];
                            $log['handle_time']=$data['handle_time'];
                            $handleLogic->addCallLogModel($log);
                           
                            $success_count+=1;
                            break;
                        default:
                            break;
                    }
                }
                echo '{"status":"200","msg":"成功处理'.$success_count.'单"}';
            }
        }else{
            echo '{"status":"500","msg":"参数错误"}';
        }
    }
 
    //预约失败,短信发送
    public function sendmsg_fail($mobile,$estate_name,$money,$handle_reason){
        #租客短信
        $sendArr['phoneNumber']=$mobile;
        $sendArr['sms_type']='YUYUE06';
        $sendArr['name']=''; 
        $sendArr['money']=$money;
        $sendArr['estatename']=str_replace('公寓', 'gongyu', $estate_name);
        $sendArr['address']=$handle_reason;
        $sendArr['code']='';
        $sendArr['infomobile']='';
        $sendArr['timestamp']='';
        sendMessage_yuyue($sendArr);
    }
    //预约失败(房东联系不上)
    public function sendmsg_fail_owner($mobile){
        #房东
        $sendArr['phoneNumber']=$mobile;
        $sendArr['sms_type']='YUYUE09';
        $sendArr['name']=''; 
        $sendArr['money']='';
        $sendArr['estatename']='';
        $sendArr['address']='';
        $sendArr['code']='';
        $sendArr['infomobile']='400-8786-999';
        switch (C('CITY_CODE')) {
            case '001011001':
                $sendArr['infomobile']='0571-62076693';
                break;
            case '001010001':
                $sendArr['infomobile']='025-58802050';
                break;
            case '001019002':
                $sendArr['infomobile']='0571-62076637';
                break;
            default:
                break;
        }
        $sendArr['timestamp']='';
        sendMessage_yuyue($sendArr);
    }

     //预约暂停,无法联系到租客，短信发送
    public function sendmsg_stop($mobile){
        #租客短信
        $sendArr['phoneNumber']=$mobile;
        $sendArr['sms_type']='YUYUE08';
        $sendArr['name']=''; 
        $sendArr['money']='';
        $sendArr['estatename']='';
        $sendArr['address']='';
        $sendArr['code']='';
        $sendArr['infomobile']='';
        $sendArr['timestamp']='';
        sendMessage_yuyue($sendArr);
    }
    //预约取消,短信发送
    public function sendmsg_cancel($mobile,$estate_name,$money){
        #租客短信
        $sendArr['phoneNumber']=$mobile;
        $sendArr['sms_type']='YUYUE05';
        $sendArr['name']=''; 
        $sendArr['money']=$money;
        $sendArr['estatename']=str_replace('公寓', 'gongyu', $estate_name);
        $sendArr['address']='';
        $sendArr['code']='';
        $sendArr['infomobile']='';
        $sendArr['timestamp']='';
        sendMessage_yuyue($sendArr);
    }
    //导出excel
    public function downloadExcel(){
        header ( "Content-type: text/html; charset=utf-8" );
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $login_name=trim(getLoginName());
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['status']=I('get.status');
        $condition['gaodu_platform']=I('get.gaodu_platform');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['mobile']=trim(I('get.mobile'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['create_man']=trim(I('get.create_man'));
        $condition['startTime_look']=I('get.startTime_look');
        $condition['endTime_look']=I('get.endTime_look');
        $condition['is_my']=isset($_GET['is_my'])?$_GET['is_my']:"0";
        if(isset($_GET['type']) && $_GET['type']=="mine"){
            $condition['create_man']=$login_name;
            $condition['is_my']="all";
        }
        $condition['startHandle']=I('get.startHandle');
        $condition['endHandle']=I('get.endHandle');
        $condition['handle_reason']=I('get.handle_reason');
        //来源和佣金
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['brand_type']=I('get.brand_type');
        $condition['is_commission']=I('get.is_commission');
        $condition['isMonth']=I('get.isMonth');
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));

        $handleLogic=new \Logic\HouseReserveCallLogic();
        $list = $handleLogic->getExeclListMorefield($condition);
            $excel[]=array(
                        'customer_name'=>'预约人姓名','customer_mobile'=>'预约人手机','resource_no'=>'预约房源','room_no'=>'预约房间',
                        'owner_mobile'=>'房东手机','owner_name'=>'房东姓名','create_time'=>'提交时间','handle_time'=>'处理时间',
                        'handle_man'=>'处理人','status'=>'处理状态','look_time'=>'看房时间','handle_reason'=>'取消/失败理由','gaodu_platform'=>'来源',
                        'info_resource'=>'房间来源','brand_type'=>'品牌公寓','is_commission'=>'是否佣金','is_monthly'=>'是否包月','region_name'=>'区域','scope_name'=>'板块','room_money'=>'租金',
                        'room_type'=>'房间类型','estate_name'=>'小区名称','owner_id'=>'房东负责人'
                    );
        /*if(in_array($login_name, array('admin','tianzhen','zhouyifan'))){
            
        }else{
            $list = $handleLogic->getExeclList($condition);
            $excel[]=array(
                        'customer_name'=>'预约人姓名','customer_mobile'=>'预约人手机','resource_no'=>'预约房源','room_no'=>'预约房间',
                        'owner_mobile'=>'房东手机','owner_name'=>'房东姓名','create_time'=>'提交时间','handle_time'=>'处理时间',
                        'handle_man'=>'处理人','status'=>'处理状态','look_time'=>'看房时间','handle_reason'=>'取消/失败理由','gaodu_platform'=>'来源',
                        'info_resource'=>'房间来源','brand_type'=>'品牌公寓','is_commission'=>'是否佣金','is_monthly'=>'是否包月','region_name'=>'区域','scope_name'=>'板块','room_money'=>'租金'
                    );
        }*/
        
        //品牌名称
        $brand_list=array('0'=>'');
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getResourceParameters();
        if($result!=null){
          foreach ($result as $key => $value) {
            if($value['info_type']==16){
              $brand_list[$value["type_no"]]=$value["name"];
            }
          } 
        }
        $handleCustomerinfo=new \Home\Model\customerinfo();
        foreach ($list as $key => $value) {
  
            $value['create_time']=date("Y-m-d H:i:s",$value['create_time']); 
            $value['handle_time']=$value['handle_time']>0?date("Y-m-d H:i:s",$value['handle_time']):''; 
            
            $look_time=$value['look_time'];
            $value['look_time']='';
            switch ($value['status']) {
                case '0':
                    $value['status']='未处理';
                    break;
                case '1':
                    $value['status']='处理中';
                    break;
                case '2':
                    $value['status']='成功';$value['handle_reason']='';$value['look_time']=$look_time>0?date("Y-m-d H:i",$look_time):"";
                    break;
                case '3':
                    $value['status']='取消';
                    break;
                case '4':
                    $value['status']='暂停';
                    break;
                case '5':
                    $value['status']='失败';
                    break;
                case '6':
                    $value['status']='房东取消';
                    break;
                case '7':
                    $value['status']='店长取消';
                    break;
                case '9':
                    $value['status']='已配单';
                    break;
                default:
                    break;
            }
            switch ($value['gaodu_platform']) {
                case '0':
                    $value['gaodu_platform']='wap';
                    break;
                case '1':
                    $value['gaodu_platform']='android';
                    break;
                case '2':
                    $value['gaodu_platform']='iphone';
                    break;
                case '3':
                    $value['gaodu_platform']='pc';
                    break;
                case '6':
                    $value['gaodu_platform']='h5';
                    break;
                case '8':
                    $value['gaodu_platform']='小程序';
                    break;
                case '9':
                    $value['gaodu_platform']='百度推广';
                    break;
                case '10':
                    $value['gaodu_platform']='hi租房pro';
                    break;
                case '20':
                    $value['gaodu_platform']='后台添加';
                    break;
                default:
                    break;
            }
            $value['is_commission']=$value['is_commission']==1?'是':'否';
            $value['is_monthly']=$value['is_monthly']==1?'是':'否';
            $value['brand_type']=$brand_list[$value['brand_type']];
            if(isset($value['room_type'])){
                switch ($value['room_type']) {
                    case '0201':
                        $value['room_type']='合租';
                        break;
                    case '0202':
                        $value['room_type']='合租';
                        break;
                    case '0203':
                        $value['room_type']='合租';
                        break;
                    case '0204':
                        $value['room_type']='整租';
                        break;
                    case '0205':
                        $value['room_type']='整租';
                        break;
                    default:
                        break;
                }
                if($value['owner_id']!=''){
                    $custinfoData=$handleCustomerinfo->modelFindByWhere("where customer_id='".$value['owner_id']."'");
                    if($custinfoData!=null && count($custinfoData)>0){
                        $value['owner_id']=$custinfoData[0]['principal_man'];
                    }else{
                        $value['owner_id']='';
                    }
                }
            }
            
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '预约');
        $xls->addArray($excel);
        $xls->generateXML('预约'.date("YmdHis"));
    }

    /*帮我找房 */
    public function findhouselist(){
        //查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['mobile']=isset($_GET['mobile'])?$_GET['mobile']:"";
      
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $totalCount =0;
        $list=array();
        $totalCountModel = $handleLogic->getfindListCount($condition);//总条数
        if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
            $totalCount=$totalCountModel[0]['totalCount'];
            $Page= new \Think\Page($totalCount,20);//分页
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $this->assign("pageSHow",$Page->show());
            $list = $handleLogic->getfindList($condition,$Page->firstRow,$Page->listRows);
        }else{
            $this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->display();
    }
    //处理完成
    public function handleFindhouse(){
        if(!isset($_GET['pid']) || empty($_GET['pid'])){
            echo '{"status":"400","msg":"参数无效"}';return;
        }
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $result=$handleLogic->handlefindhouse($_GET['pid']);
        if($result){
            echo '{"status":"200","msg":"操作成功"}';
        }else{
            echo '{"status":"400","msg":"操作失败"}';
        }
    }
     /*百度寻客 */
    public function xunkelist(){
        //查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['mobile']=isset($_GET['mobile'])?$_GET['mobile']:"";
      
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $totalCount =0;
        $list=array();
        $totalCountModel = $handleLogic->getXunkeListCount($condition);//总条数
        if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
            $totalCount=$totalCountModel[0]['totalCount'];
            $Page= new \Think\Page($totalCount,20);//分页
            foreach($condition as $key=>$val) {
                $Page->parameter[$key]=urlencode($val);
            }
            $this->assign("pageSHow",$Page->show());
            $list = $handleLogic->getXunkeList($condition,$Page->firstRow,$Page->listRows);
        }else{
            $this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->display();
    }
    public function handlexunke(){
        if(!isset($_GET['pid']) || empty($_GET['pid'])){
            echo '{"status":"400","msg":"参数无效"}';return;
        }
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $result=$handleLogic->handleXunke($_GET['pid']);
        if($result){
            echo '{"status":"200","msg":"操作成功"}';
        }else{
            echo '{"status":"400","msg":"操作失败"}';
        }
    }

    /*顾问新增预约 */
    public function appointadd(){
        $this->display();
    }
    public function saveAppointadd(){
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '请重新登录';return;
        }
        $mobile=I('post.mobile');
        if(empty($mobile)){
            echo '参数错误';return;
        }
        //读取租客信息
        $customerDal=new \Home\Model\customer();
        $customerModel=$customerDal->getResourceClientByPhone($mobile);
        if($customerModel===false || $customerModel===null){
            //echo '租客手机号没有注册';return;
            //注册手机
            $customerModel['id']=guid();
            $customerModel['true_name']='';
            $customerModel['mobile']=$mobile;
            $customerModel['create_time']=time();
            $customerModel['is_owner']=0;
            $customerModel['gaodu_platform']=3;
            $customerDal->addModel($customerModel);
        }
        $success_count=0;
        $handleLogic=new \Logic\HouseReserveCallLogic();
        $roomDal=new \Home\Model\houseroom();
        for ($i=1; $i < 4; $i++) { 
            $room_no=I('post.room_no_'.$i);
            $look_date=I('post.look_date_'.$i);
            if(empty($room_no) || empty($look_date)){
                continue;
            }
            $look_time=strtotime($look_date)+intval(I('post.look_hour_'.$i))*3600+intval(I('post.look_minute_'.$i))*60;
            if($look_time<time()-1000){
               continue;// echo '看房时间有误';return;
            }
            //读取房间信息
            $roomModel=$roomDal->getTopRoomByRoomno($room_no);
            if($roomModel===null || $roomModel===false){
               continue;//echo '房间信息读取失败';return;
            }
            if($roomModel['status']!=2 || $roomModel['record_status']==0){
               continue;//echo '房间已经出租或删除';return;
            }
            $resourceDal=new \Home\Model\houseresource();//读取房源信息
            $resourceModel=$resourceDal->getModelById($roomModel['resource_id']);
            if($resourceModel===null || $resourceModel===false){
               continue;
            }
            
            #新增预约单和记录
            $data['id']=guid();
            $data['customer_id']=$customerModel['id'];
            $data['customer_name']=$customerModel['true_name'];
            $data['customer_mobile']=$customerModel['mobile'];
            $data['estate_id']=$resourceModel['estate_id'];
            $data['estate_name']=$resourceModel['estate_name'];
            $data['resource_id']=$resourceModel['id'];
            $data['resource_no']=$resourceModel['house_no'];
            $data['room_id']=$roomModel['id'];
            $data['room_no']=$roomModel['room_no'];
            $data['owner_id']=$resourceModel['customer_id'];
            $data['owner_name']=$resourceModel['client_name'];
            $data['owner_mobile']=$resourceModel['client_phone'];
            $data['create_time']=time();
            $data['city_code']=$resourceModel['city_code'];
            $data['gaodu_platform']=20;//后台添加
            $data['status']=2;
            $data['record_status']=1;
            $data['look_time']=$look_time;
            $data['look_time_end']=$look_time;
            $data['handle_man']=$login_name;
            $data['handle_time']=time();
            $max_no=$handleLogic->getMaxRebackno($mobile);
            if($max_no===null || $max_no===false){
                $data['reback_no']=10;
            }else{
                $data['reback_no']=$max_no+1;
            }
            $data['main_img_path']=$roomModel['main_img_path'];
            $data['room_money']=$roomModel['room_money'];
            $data['room_area']=$roomModel['room_area'];
            $data['room_status']=$roomModel['status'];
            $data['is_auth']=$resourceModel['is_auth'];
            $data['region_id']=$resourceModel['region_id'];
            $data['region_name']=$resourceModel['region_name'];
            $data['scope_id']=$resourceModel['scope_id'];
            $data['scope_name']=$resourceModel['scope_name'];
            $data['room_type']=$resourceModel['room_type'];
            $data['business_type']=$resourceModel['business_type'];
            $data['pay_method']=$resourceModel['pay_method'];
            //预约表新增字段
            $data['is_commission']=$roomModel['is_commission'];
            $data['is_monthly']=$roomModel['is_monthly'];
            $data['info_resource']=$resourceModel['info_resource'];
            $data['info_resource_type']=$resourceModel['info_resource_type'];
            $data['brand_type']=$resourceModel['brand_type'];
            $data['store_id']=$roomModel['store_id'];
            $result=$handleLogic->addHousereservecallModel($data);
            if(!$result){
                continue;
            }
            $log['reservecall_id']=$data['id'];
            $log['status']=$data['status'];
            $log['handle_man']=$data['handle_man'];
            $log['handle_time']=$data['handle_time'];
            $handleLogic->addCallLogModel($log);
            #新增看房日程
            $addReserve['id']=guid();
            $addReserve['customer_id']=$data['customer_id'];
            $addReserve['room_id']=$data['room_id'];
            $addReserve['owner_id']=$data['owner_id'];
            $addReserve['owner_name']=$data['owner_name'];
            $addReserve['owner_phone']=$data['owner_mobile'];
            $addReserve['view_time']=$data['look_time'];
            $addReserve['create_time']=time();
            $addReserve['city_code']=$data['city_code'];
            $addReserve['resource_id']=$data['resource_id'];
            $addReserve['region_id']=$data['region_id'];
            $addReserve['region_name']=$data['region_name'];
            $addReserve['scope_id']=$data['scope_id'];
            $addReserve['scope_name']=$data['scope_name'];
            $addReserve['room_name']=$roomModel['room_name'];
            $addReserve['room_area']=$roomModel['room_area'];
            $addReserve['room_money']=$roomModel['room_money'];
            $addReserve['main_img_path']=$roomModel['main_img_path'];
            $addReserve['estate_id']=$resourceModel['estate_id'];
            $addReserve['estate_name']=$resourceModel['estate_name'];
            if(strpos($resourceModel['client_phone'],'1')!==0){
                $addReserve['telephone']=$resourceModel['client_phone'];//房东座机号
            }
            //小区信息
            $estateDal=new \Home\Model\estate();
            $estateModel=$estateDal->getModelById($resourceModel['estate_id']);
            if($estateModel!==false && $estateModel!==null){
                $addReserve['estate_address']=$estateModel['estate_address'];
                $addReserve['room_longitude']=$estateModel['lpt_x'];
                $addReserve['room_latitude']=$estateModel['lpt_y'];
            }
            $addReserve['business_type']=$resourceModel['business_type'];
            $addReserve['status']=$roomModel['status'];
            $addReserve['room_no']=$roomModel['room_no'];
            $result=$handleLogic->addHousereserve($addReserve);
            if($result){
                $fd_phone=$data['owner_mobile'];
                if(strpos($fd_phone, '1')!==0){
                    $fd_model = $customerDal->getModelById($data['owner_id']);
                    if($fd_model!==null && $fd_model!==false){
                        $fd_phone=$fd_model['mobile'];
                    }
                }
                $clientPhone=$fd_phone;
                if(I('post.moduleType')=='2'){
                    //获取房东对应400号码
                    $handleCode=new \Logic\PhoneCodeLogic();
                    $clientPhone=$handleCode->get400Code(array('mobile'=>$fd_phone,'room_id'=>$data['room_id'],'room_no'=>$roomModel['room_no'],'city_id'=>$data['city_code'],'info_resource'=>$resourceModel['info_resource']));
                }
                #发送短信
                $handleLogic->sendmsg_success($data["customer_name"],$data["customer_mobile"],$addReserve["estate_name"],$addReserve["room_money"],$data['look_time'],$addReserve["estate_address"],$data["reback_no"],$fd_phone,$clientPhone);
                #消息推送
                $this->sendappmsg_success($data["customer_name"],$data["customer_mobile"],$addReserve["estate_name"],$addReserve["room_money"],$data['look_time'],$addReserve["estate_address"],$data["reback_no"],$fd_phone,$data['customer_id'],$data['owner_id'],$resourceModel['is_owner']);
                $success_count+=1;
            }
        }
        return $this->success('成功新增'.$success_count.'个',U('Appointment/myhandlelist?no=87&leftno=91'),1);
    }
    //预约成功,消息推送
    public function sendappmsg_success($name,$mobile,$estate_name,$money,$look_time,$address,$reback_no,$client_mobile,$renter_id,$client_id,$is_owner=0){
        #租客
        $notifyDal=new \Home\Model\customernotify();
        $notifyData['content']='<font color="#666666">尊敬的租客，您对['.$estate_name.']-['.$money.'元/月]房源的预约已成功，看房时间为['.date('Y-m-d H:i',$look_time).']，房屋地址为['.$address.']，房东电话为'.$client_mobile.'。您可以在嗨住APP的日程功能中查看日程信息。</font>';
        $notifyData['id']=guid();
        $notifyData['customer_id']=$renter_id;
        $notifyData['notify_type']=3;
        $notifyData['title']='看房提醒';
        $notifyData['create_time']=time();
        $notifyDal->modelAdd($notifyData);
        if(C('IS_REDIS_CACHE')){
            #红点
            $cache_house_verify_no=$renter_id."house_view_no";
            $house_no_key=set_cache_public_key($cache_house_verify_no);
            $house_no_value=get_couchbase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key);
            $house_no_value=$house_no_value+1;
            set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key,$house_no_value);
        }
        $content_lordland='<font color="#666666">尊敬的房东，租客('.$mobile.')与您约定于('.date('Y-m-d H:i',$look_time).')查看位于['.$estate_name.']的房间，如无法如期看房，请直接联系租客取消。</font>';
            
        if($is_owner==4 || $is_owner==5){
            //房东版推送消息
            $handleNotify=new \Logic\CustomerNotifyLogic();
            $handleNotify->sendCustomerNotify($client_id,1009,'看房提醒',$content_lordland,'您有1条看房提醒信息');
        }else{
            #房东
            $notifyData['content']=$content_lordland;
            $notifyData['id']=guid();
            $notifyData['customer_id']=$client_id;
            $notifyData['notify_type']=3;
            $notifyData['title']='看房提醒';
            $notifyData['create_time']=time();
            $notifyDal->modelAdd($notifyData);
            if(C('IS_REDIS_CACHE')){
                #红点
                $cache_house_verify_no=$client_id."house_view_no";
                $house_no_key=set_cache_public_key($cache_house_verify_no);
                $house_no_value=get_couchbase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key);
                $house_no_value=$house_no_value+1;
                set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key,$house_no_value);
            }
        }
        
    }
    //检索后台人员
    public function searchHandleMen(){
        $keyword=I('get.keyword');
        if(empty($keyword)){
            echo '{"status":"404","msg":"fail"}';return;
        }
        $handle=new \Home\Model\housereservecall();
        $result=$handle->getAppointHandleListBykey($keyword);
        if($result==null || $result==false){
            echo '{"status":"404","msg":"fail"}';
        }else{
            echo '{"status":"200","msg":"success","data":'.json_encode($result).'}';
        }
    }
    /*带看人管理列表　*/
    public function takelookmanage(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['startTime_create']=I('get.startTime_create');
        $condition['endTime_create']=I('get.endTime_create');
        $condition['estateName']=I('get.estateName');
        $condition['roomStatus']=I('get.roomStatus');
        $condition['roomNo']=I('get.roomNo');
        $condition['houseNo']=I('get.houseNo');
        $condition['rent_type']=I('get.rent_type');
        $condition['clientPhone']=I('get.clientPhone');

        $condition['takelook_man']=I('get.takelook_man');
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['moneyMin']=I('get.moneyMin');
        $condition['moneyMax']=I('get.moneyMax'); 
        $condition['totalCount']=I('get.totalCount');
        $totalCount=$condition['totalCount']==''?0:intval($condition['totalCount']);
      
        $list=array();
        $hadCondition=false;
        foreach ($condition as $k1 => $v1) {
            if($v1!=''){
                $hadCondition=true;
                break;
            }
        }
        $pageSHow='';$list=array();
        if($hadCondition){
             $handleLogic=new \Logic\HouseRoomLogic();
             if(I('get.p')=="" || $totalCount==0){
                  $totalCountModel = $handleLogic->getSetAppointListCount($condition);//总条数
                  $totalCount=$totalCountModel !=null?$totalCountModel[0]['totalCount']:0;
             }
                if($totalCount>0){
                    $Page= new \Think\Page($totalCount,50);//分页
                    $condition['totalCount']=$totalCount;
                      foreach($condition as $key=>$val) {
                            $Page->parameter[$key]=urlencode($val);
                        }
                    $pageSHow=$Page->show();
                    $list = $handleLogic->getSetAppointList($condition,$Page->firstRow,$Page->listRows);
                }
        }
         $this->assign("pageSHow",$pageSHow);
        $this->assign("totalCount",$totalCount);
        $this->assign("list",$list);
        $handleResource=new \Logic\HouseResourceLogic();
     
        //数据来源
        $this->bindInforesource($condition['info_resource_type']);
    
        /*查询条件（区域板块）*/
        $regionResult=$handleResource->getRegionList();
        $regionList='';
        if($regionResult!=null){
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
        $this->display();
    }
    /*修改带看人 */
    public function submitLookman(){
        $login_name=getLoginName();
        if(empty($login_name)){
            echo '{"status":"201","message":"请重新登录"}';return;
        }
         $room_ids=I('get.room_ids');
         $takelook_man=I('get.takelook_man');
        if(empty($room_ids) || empty($takelook_man)){
            echo '{"status":"202","message":"参数不能为空"}';return;
        }
       $handleCustomerinfo= new \Home\Model\customerinfo();
       $result=$handleCustomerinfo->modelPrincipalFind($takelook_man);
       if(!$result){
         echo '{"status":"203","message":"人员不存在，无法修改"}'; return;
       }
        $id_arr=explode(',', rtrim($room_ids,','));
        $roomHandle=new \Logic\HouseRoomLogic();
        $recordHandle=new \Logic\HouseupdatelogLogic();
        foreach ($id_arr as $key => $value) {
            if(empty($value)){
                continue;
            }
            $result=$roomHandle->updateModel(array('id'=>$value,'takelook_man'=>$takelook_man));
            if($result){
                $recordData['id']=guid();
                $recordData['house_id']=$value;
                $recordData['house_type']=2;
                $recordData['update_man']=$login_name;
                $recordData['update_time']=time();
                $recordData['operate_type']='修改带看人';
                $recordHandle->addModel($recordData);
            }
        }
        echo '{"status":"200","message":"修改成功"}';
    }

}

?>
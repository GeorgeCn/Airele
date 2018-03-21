<?php
namespace Home\Controller;
use Think\Controller;
/*租客追踪 */
class CustomerTrackingController extends Controller{

	//列表
	public function trackinglist()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"6");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['status']=I('get.status');
        $condition['mobile']=I('get.mobile');
        $condition['startTime_appoint']=I('get.startTime_appoint');
        $condition['endTime_appoint']=I('get.endTime_appoint');
        $condition['startTime_look']=I('get.startTime_look');
        $condition['endTime_look']=I('get.endTime_look');

        $condition['startTime_register']=I('get.startTime_register');
        $condition['endTime_register']=I('get.endTime_register');
        $condition['startTime_contact']=I('get.startTime_contact');
        $condition['endTime_contact']=I('get.endTime_contact');
        $condition['is_appoint']=I('get.is_appoint');
        $condition['is_contact']=I('get.is_contact');
        $condition['city_code']=I('get.city_code');

        $condition['is_tracking']=I('get.is_tracking');
        $condition['startTime_tracking']=I('get.startTime_tracking');
        $condition['endTime_tracking']=I('get.endTime_tracking');
        $condition['is_monthly']=I('get.is_monthly');
        $condition['is_look']=I('get.is_look');
        $condition['is_commission']=I('get.is_commission');
        $condition['is_getcommission']=I('get.is_getcommission');

        $condition['renter_sourcetype']=I('get.renter_sourcetype');
        $condition['renter_source']=I('get.renter_source');
        $condition['totalCount']=I('get.totalCount');
        $condition['handleType']=I('get.handleType');
        $condition['is_satisfied']=I('get.is_satisfied');
        $condition['is_recommend']=I('get.is_recommend');
        $condition['unknown']= I('get.unknown');
        $condition['abandon']= I('get.abandon');

        $condition['applyback_status'] = I('get.applyback_status');
        $condition['startTime_applyback'] = I('get.startTime_applyback');
        $condition['endTime_applyback'] = I('get.endTime_applyback');

        $condition['second_visit'] = I('get.second_visit');
        $condition['visit_source'] = I('get.visit_source');

        $handleLogic=new \Logic\CustomerTrackingLogic();
        $list=array();
        if(empty(I('get.p')) && $condition['handleType']!=""){
          $totalCountModel = $handleLogic->getModelListCount($condition);//总条数
          if($totalCountModel !==null && $totalCountModel !==false){
            $condition['totalCount']=$totalCountModel[0]['totalCount'];
          }
        }
        if($condition['totalCount']>=1 && $condition['handleType']=="search"){
       
	        $Page= new \Think\Page($condition['totalCount'],10);//分页
	        foreach($condition as $key=>$val) {
	            $Page->parameter[$key]=urlencode($val);
	        }
	        $this->assign("pageSHow",$Page->show());
        	$list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }else{
        	$this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$condition['totalCount']);
		$this->display();
	}
    public function trackingedit(){
        if(!isset($_GET['pid']) || empty($_GET['pid'])){
          return $this->error('参数错误',U('CustomerTracking/trackinglist?no=6&leftno=105'),1);
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $handleLogic=new \Logic\CustomerTrackingLogic();
        $model=$handleLogic->getCustomerTrackingById($_GET['pid']);
        $contactlist=array();
        $appointlist=array();
        $trackinglist=array();
        $looklist=array();
        $applybacklist = $flag = array();
        if($model!==false && $model!==null){
            $model['renter_time']=$model['renter_time']>0?date('Y-m-d',$model['renter_time']):"";
            if($model['mobile']!=''){
                $contactlist=$handleLogic->getContactsByMobile($model['mobile']);//联系记录
                $appointlist=$handleLogic->getAppointsByMobile($model['mobile']);//预约记录
                $applybacklist = $handleLogic->getCouponCashInfo($model['mobile']);//返现记录
                $cashStatus = $handleLogic->findCouponCashStatus($model['mobile']);
                if($applybacklist != '') {
                    foreach ($applybacklist as $value) {
                        $tempSecond = $handleLogic->findHouseRoomInfo($value['room_id']);   
                        $temp = $handleLogic->findHouseResourceInfo($tempSecond['resource_id']);
                        if($temp === null) $applybacklist = null;
                        $info['room_id'] = $value['room_id'];
                        $info['price'] = $tempSecond['room_money'];
                        $info['create_time'] = $value['create_time']; 
                        $info['room_no'] = $tempSecond['room_no'];
                        $info['region_name'] = $temp['region_name'];
                        $info['scope_name'] = $temp['scope_name'];
                        $info['info_resource_type'] = $temp['info_resource_type'];
                        $flag[] = $info;
                    }
                }
            }
            if($model['customer_id']!=''){
                $looklist=$handleLogic->getLookHouseinfoByCustomerid($model['customer_id']);//看房日程   
            }
            $trackinglist=$handleLogic->getTrackingsById($model['id']);//回访记录
        }
        $this->assign('contactlist',$contactlist);
        $this->assign('appointlist',$appointlist);
        $this->assign('trackinglist',$trackinglist);
        $this->assign('looklist',$looklist);
        $this->assign('applybacklist',$flag);
        $this->assign('cashstatus',$cashStatus);
        $this->assign('trackModel',$model);
        $this->display();
    }
    public function trackingadd(){
        $loginName=trim(getLoginName());
        if($loginName==''){
            echo '请重新登录';return;
        }
        $this->display();
    }
    public function saveTracking(){
        $data['id']=I('post.id');
        $cashBack['customer_mobile'] = I('post.customer_mobile');
        
        if(empty($data['id'])){
            return $this->error('参数错误',U('CustomerTracking/trackinglist?no=6&leftno=105'),1);
        }
        $data['visit_source']=I('post.visit_source');
        $data['renter_status']=I('post.renter_status');
        $data['renter_source']=I('post.renter_source');
        $data['renter_sourcetype']=I('post.renter_sourcetype');
        $data['renter_room']=trim(I('post.renter_room'));
        $data['renter_time']=I('post.renter_time');
        $data['renter_time']=!empty($data['renter_time'])?strtotime($data['renter_time']):0;
        $data['bakinfo']=trim(I('post.bakinfo'));
        $data['is_service']=I('post.is_service');
        $data['second_visit']=I('post.second_visit');
        if(!is_numeric($data['is_service'])){
            $data['is_service']=0;
        }
        $data['is_look']=I('post.is_look');
        if(!is_numeric($data['is_look'])){
            $data['is_look']=0;
        }
         $data['is_getcommission']=I('post.is_getcommission');
        if(!is_numeric($data['is_getcommission'])){
            $data['is_getcommission']=0;
        }
        $data['is_satisfied']=I('post.is_satisfied');
        if(!is_numeric($data['is_satisfied'])){
            $data['is_satisfied']=0;
        }
        $data['is_recommend']=I('post.is_recommend');
        if(!is_numeric($data['is_recommend'])){
            $data['is_recommend']=0;
        }
        $cashBack['status_code'] = I('post.status_code');
        if($cashBack['status_code'] == 2) {
            $data['is_cashback'] = 1;
        } elseif ($cashBack['status_code'] == 4) {
            $data['is_cashback'] = 2;
        } else {
            $data['is_cashback'] = 0;
        }
        if(!is_numeric($cashBack['status_code'])){
            $cashBack['status_code']=1;
        }
        $cashBack['city_code'] = C('CITY_CODE');
        $data['update_time']=time();
        $data['update_man']=getLoginName();
        $handleLogic=new \Logic\CustomerTrackingLogic();
        $result=$handleLogic->updateCustomerTracking($data);
        $customerID = $handleLogic->findCustomerID($cashBack['customer_mobile']);
        $cashBack['customer_id'] = $customerID['id'];
        if($result){
            if($cashBack['status_code'] !=1) {
                //修改customercouponcash、customercoupon、couponstatus
                $handleLogic->updateCouponCash($cashBack);
                $coupon = $handleLogic->findCouponCash($cashBack);
                $coupon['status_code'] = $cashBack['status_code'];
                $handleLogic->updateCustomerCoupon($coupon);
                $handleLogic->updateCouponStatus($coupon);
                //发送邮件
                if($cashBack['status_code'] == '2') {
                    $cashBack['id'] = $coupon['id'];
                    $handleLogic->sendCashBackEmail($cashBack);   
                }      
            }
            return $this->success('操作成功',U('CustomerTracking/trackinglist?no=6&leftno=105'),1);
        }else{
            return $this->error('操作失败',U('CustomerTracking/trackinglist?no=6&leftno=105'),1);
        }
    }
    public function saveTrackingadd(){
        header ( "Content-type: text/html; charset=utf-8" );
        $loginName=trim(getLoginName());
        if($loginName==''){
            echo '请重新登录';return;
        }
        $data['mobile']=trim(I('post.mobile'));
        if(empty($data['mobile'])){
            echo '参数异常';return;
        }
        $modelDal=new \Home\Model\customertracking();
        $model=$modelDal->getModelByCondition($data);
        if($model!==null && $model!==false){
             echo '手机号已经存在跟踪列表里';return;
        }
        $data['city_code']=I('post.city_code');
        $data['visit_source']=I('post.visit_source');
       $data['renter_status']=I('post.renter_status');
       $data['renter_source']=I('post.renter_source');
       $data['renter_sourcetype']=I('post.renter_sourcetype');
       $data['renter_room']=trim(I('post.renter_room'));
       $data['renter_time']=I('post.renter_time');
       $data['renter_time']=!empty($data['renter_time'])?strtotime($data['renter_time']):0;

        $data['is_service']=I('post.is_service');
        if(!is_numeric($data['is_service'])){
            $data['is_service']=0;
        }
        $data['is_look']=I('post.is_look');
        if(!is_numeric($data['is_look'])){
            $data['is_look']=0;
        }
        $data['second_visit']=I('post.second_visit');
        $data['bakinfo']=trim(I('post.bakinfo'));
        $data['create_time']=time();
        $data['create_man']=$loginName;
        $data['update_time']=$data['create_time'];
        $data['update_man']=$data['create_man'];
        //房间编号
        if($data['renter_room']!=''){
            $roomDal=new \Home\Model\houseroom();
            $roomResult=$roomDal->getResultByWhere("id,info_resource"," where room_no='".$data['renter_room']."' ");
            if($roomResult!=null && count($roomResult)>0){
                $data['renter_source']=$roomResult[0]['info_resource'];
            }
        }
        //判断是否注册用户
        $is_reg=false;
        $customerDal=new \Home\Model\customer();
        $customerModel=$customerDal->getListByWhere("mobile='".$data['mobile']."'","");
        if($customerModel!=null && count($customerModel)>0){
            $is_reg=true;
        }
        if(!$is_reg){
            $data['customer_id']=create_guid();
            $data['register_time']=time();
            $customerDal->addModel(array('id'=>$data['customer_id'],'mobile'=>$data['mobile'],'create_time'=>$data['register_time'],'city_code'=>$data['city_code'],'is_owner'=>0,'is_renter'=>1,'channel'=>'租客跟踪新增','gaodu_platform'=>20));
        }
        $ident_id=$modelDal->addTrackingModel($data);
        if($ident_id){
            //新增日志
            $log['tracking_id']=$ident_id;
            $log['renter_status']=$data['renter_status'];
            $log['renter_room']=$data['renter_room'];
            $log['renter_time']=$data['renter_time'];
            $log['renter_sourcetype']=$data['renter_sourcetype'];
            $log['renter_source']=$data['renter_source'];
            $log['bakinfo']=$data['bakinfo'];
            $log['is_service']=$data['is_service'];
            $log['is_look']=$data['is_look'];
            $log['create_time']=$data['update_time'];
            $log['create_man']=$data['update_man'];

            $log['visit_source']=$data['visit_source'];
            $log['second_visit']=$data['second_visit'];
            $modelDal->addLogModel($log);
            echo '新增成功';
        }else{
            echo '新增失败';
        }
    }
	//导出excel
    public function downloadTracking(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
        $condition['status']=I('get.status');
        $condition['mobile']=I('get.mobile');
        $condition['startTime_appoint']=I('get.startTime_appoint');
        $condition['endTime_appoint']=I('get.endTime_appoint');
        $condition['startTime_look']=I('get.startTime_look');
        $condition['endTime_look']=I('get.endTime_look');

        $condition['startTime_register']=I('get.startTime_register');
        $condition['endTime_register']=I('get.endTime_register');
        $condition['startTime_contact']=I('get.startTime_contact');
        $condition['endTime_contact']=I('get.endTime_contact');
        $condition['is_appoint']=I('get.is_appoint');
        $condition['is_contact']=I('get.is_contact');
        $condition['city_code']=I('get.city_code');

        $condition['is_tracking']=I('get.is_tracking');
        $condition['startTime_tracking']=I('get.startTime_tracking');
        $condition['endTime_tracking']=I('get.endTime_tracking');
        $condition['is_monthly']=I('get.is_monthly');
        $condition['is_look']=I('get.is_look');
        $condition['is_commission']=I('get.is_commission');
        $condition['is_getcommission']=I('get.is_getcommission');

        $condition['renter_sourcetype']=I('get.renter_sourcetype');
        $condition['renter_source']=I('get.renter_source');
        $condition['is_satisfied']=I('get.is_satisfied');
        $condition['is_recommend']=I('get.is_recommend');
        $condition['unknown']= I('get.unknown');
        $condition['abandon']= I('get.abandon');
        
        $condition['applyback_status'] = I('get.applyback_status');
        $condition['startTime_applyback'] = I('get.startTime_applyback');
        $condition['endTime_applyback'] = I('get.endTime_applyback');
        $condition['second_visit'] = I('get.second_visit');
        $condition['visit_source'] = I('get.visit_source');

        $totalCount =0;
        $handleLogic=new \Logic\CustomerTrackingLogic();
        $totalCountModel = $handleLogic->getModelListCount($condition);//总条数
        if($totalCountModel !==null && $totalCountModel !==false && $totalCountModel[0]['totalCount']>=1){
            $totalCount=$totalCountModel[0]['totalCount'];
        }
        if($totalCount==0){
            return $this->error('下载失败，数据为0',U('CustomerTracking/trackinglist?no=6&leftno=105'),3);
        }
        if($totalCount>5000){
            return $this->error('下载失败，不能下载超过5000条的数据',U('CustomerTracking/trackinglist?no=6&leftno=105'),3);
        }
        $list = $handleLogic->getModelList($condition,0,5000);
        $excel[]=array(
            'mobile'=>'手机号', 'register_time'=>'注册时间', 'renter_status'=>'租住状态','renter_sourcetype'=>'租房渠道类型','renter_source'=>'租房渠道','is_service'=>'继续服务',
            'update_man'=>'回访人','update_time'=>'最近回访时间','bakinfo'=>'备注','is_look'=>'是否看房','is_satisfied'=>'是否满意','is_recommend'=>'是否推荐','is_getcommission'=>'是否收到佣金','contact_lasttime'=>'最近联系时间','contact_count'=>'联系次数',
            'appoint_looktime'=>'最近看房时间','appoint_lasttime'=>'最近预约时间','appoint_count'=>'预约次数','appoint_handleman'=>'预约处理人','is_monthly'=>'是否包月','is_commission'=>'是否佣金','report_count'=>'举报次数','city_code'=>'城市','applyback_time'=>'申请返现时间','applyback_status'=>'申请返现','is_cashback'=>'是否符合返现条件','second_visit'=>'二次回访','visit_source'=>'回访来源'
        );
        $city_array=getCityList();
        $city_array['']='';
        foreach ($list as $key => $value) {
            $value['city_code']=$city_array[$value['city_code']];
            switch ($value['renter_status']) {
                case '1':
                    $value['renter_status']='未租到';
                    break;
                case '2':
                    $value['renter_status']='已租到';
                    break;
                case '3':
                    $value['renter_status']='拒绝回访';
                    break;
                case '4':
                    $value['renter_status']='未接听';
                    break;
                case '5':
                    $value['renter_status']='不租了';
                    break;
                default:
                    $value['renter_status']='';
                    break;
            }
            switch ($value['is_service']) {
                case '1':
                    $value['is_service']='是';
                    break;
                case '2':
                    $value['is_service']='否';
                    break;
                default:
                    $value['is_service']='';
                    break;
            }
            switch ($value['is_look']) {
                case '1':
                    $value['is_look']='是';
                    break;
                case '2':
                    $value['is_look']='否';
                    break;
                default:
                    $value['is_look']='';
                    break;
            }
            switch ($value['is_satisfied']) {
                case '1':
                    $value['is_satisfied']='是';
                    break;
                case '2':
                    $value['is_satisfied']='否';
                    break;
                default:
                    $value['is_satisfied']='';
                    break;
            }
            switch ($value['is_recommend']) {
                case '1':
                    $value['is_recommend']='是';
                    break;
                case '2':
                    $value['is_recommend']='否';
                    break;
                default:
                    $value['is_recommend']='';
                    break;
            }
            switch ($value['is_getcommission']) {
                case '1':
                    $value['is_getcommission']='是';
                    break;
                case '2':
                    $value['is_getcommission']='否';
                    break;
                default:
                    $value['is_getcommission']='';
                    break;
            }
            switch ($value['renter_sourcetype']) {
                case '1':
                    $value['renter_sourcetype']='嗨住';
                    break;
                case '2':
                    $value['renter_sourcetype']='其他';
                    break;
                default:
                    $value['renter_sourcetype']='';
                    break;
            }
            switch ($value['applyback_status']) {
                case '0':
                    $value['applyback_status']='否';
                    break;
                case '1':
                    $value['applyback_status']='是';
                    break;
                default:
                    $value['applyback_status']='';
                    break;
            }
            switch ($value['is_cashback']) {
                case '2':
                    $value['is_cashback']='否';
                    break;
                case '1':
                    $value['is_cashback']='是';
                    break;
                default:
                    $value['is_cashback']='';
                    break;
            }
            switch ($value['second_visit']) {
                case '2':
                    $value['second_visit']='不需要';
                    break;
                case '1':
                    $value['second_visit']='需要';
                    break;
                default:
                    $value['second_visit']='';
                    break;
            }
            switch ($value['visit_source']) {
                case '0':
                    $value['visit_source']='';
                    break;
                case '1':
                    $value['visit_source']='电话回访';
                    break;
                case '2':
                    $value['visit_source']='房东反馈';
                    break;
                case '3':
                    $value['visit_source']='保障房源';
                break;
                case '4':
                    $value['visit_source']='短信回访';
                break;
                case '5':
                    $value['visit_source']='返现申请';
                break;   
                default:
                    $value['visit_source']='';
                break;
            }
           $value['update_time']=$value['update_time']>0?date("Y-m-d H:i",$value['update_time']):""; 
           $value['register_time']=$value['register_time']>0?date("Y-m-d H:i",$value['register_time']):""; 
           $value['contact_lasttime']=$value['contact_lasttime']>0?date("Y-m-d H:i",$value['contact_lasttime']):""; 
           $value['appoint_looktime']=$value['appoint_looktime']>0?date("Y-m-d H:i",$value['appoint_looktime']):""; 
           $value['appoint_lasttime']=$value['appoint_lasttime']>0?date("Y-m-d H:i",$value['appoint_lasttime']):""; 
           $value['applyback_time']=$value['applyback_time']>0?date("Y-m-d H:i",$value['applyback_time']):""; 

           $value['is_monthly']=$value['is_monthly']=='1'?'是':'否';
           $value['is_commission']=$value['is_commission']=='1'?'是':'否';
           $value['id']='';
           $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '租客跟踪列表');
        $xls->addArray($excel);
        $xls->generateXML('租客跟踪列表'.date('YmdH'));
    }
    //链接数查询
    public function customerLinksQuery ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
        $handleMenu->jurisdiction();

        $startNum = I('get.startNum');
        $endNum = I('get.endNum');
        $mobile = I('get.customer_mobile');
        $isOwner = I('get.is_owner');
        $period = I('get.period_status');
        $where = $info = array();
        $where['city_code'] = C('CITY_CODE');
        if($startNum!=""&&$endNum=="") {
            $where['total_num']=array('egt',$startNum);
        }
        if($endNum!=""&&$startNum=="") {
            $where['total_num']=array('elt',$endNum);
        }
        if($startNum!=""&&$endNum!="") {
            $where['total_num']=array(array('egt',$startNum),array('elt',$endNum));
        }
        if($startNum!=""&&$endNum!=""&&$startNum==$endNum)
        {
            $where['total_num']=array('eq',$startNum);
        }
        if($mobile != "") {
            $where['customer_mobile']=array('eq',$mobile);
        }
        if($isOwner != "") {
            $where['is_owner']=array('eq',$isOwner);
        }
        if($period != "") {
            $where['period_status']=array('eq',$period);
        }
        $trackingModel = new \Home\Model\customertracking();
        $trackingLogic = new \Logic\CustomerTrackingLogic();
        $count = $trackingModel->modelCountCustomerLinks($where);
        $Page= new \Think\Page($count,5);
        $fields = '*';
        $data = $trackingModel->modelGetCustomerLinks($Page->firstRow,$Page->listRows,$fields,$where);
        if(!empty($data)) {
            foreach ($data as $value) {
                $return = $trackingLogic->findCustomerInfo($value['customer_id'],$value['is_owner']);
                $value['principal_man'] = $return['principal_man'];
                $value['limit_count'] = $return['limit_count'];
                $info[] = $value;
            }
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();  
    }
}
?>	
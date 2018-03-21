<?php
namespace Home\Controller;
use Think\Controller;
/*佣金管理 */
class CommissionController extends Controller{

	//列表
	public function commissionlist()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"107");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"107");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['room_no']=I('get.room_no');
        $condition['client_phone']=I('get.client_phone');
        $condition['client_name']=I('get.client_name');
        $condition['estate_name']=I('get.estate_name');
        $condition['updatetime_start']=I('get.updatetime_start');
        $condition['updatetime_end']=I('get.updatetime_end');
        $condition['is_open']=I('get.is_open');
        $condition['is_online']=I('get.is_online');
        $condition['settlement_method']=I('get.settlement_method');
        $handleLogic=new \Logic\CommissionLogic();
        $totalCount =0;
        $list=array();
        $totalCountModel = $handleLogic->getCommissionListCount($condition);//总条数
        if($totalCountModel !==null && $totalCountModel !==false && $totalCountModel[0]['totalCount']>=1){
        	$totalCount=$totalCountModel[0]['totalCount'];
	        $Page= new \Think\Page($totalCount,10);//分页
	        foreach($condition as $key=>$val) {
	            $Page->parameter[$key]=urlencode($val);
	        }
	        $this->assign("pageSHow",$Page->show());
        	$list = $handleLogic->getCommissionList($condition,$Page->firstRow,$Page->listRows);
        }else{
        	$this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
		$this->display();
	}
    #ajax 获取房间对应，状态和租金
    public function getRoominfoByRoomno(){
        if(!isset($_GET['room_no']) || empty($_GET['room_no'])){
            echo '{"status":"","money":""}';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->getHouseRoomByNo($_GET['room_no']);
        if($result!==null && $result!==false && count($result)>0){
            $status='';
            switch ($result[0]["status"]) {
                case '0':
                    $status='待审核';
                    break;
                case '1':
                    $status='审核未通过';
                    break;
                case '2':
                    $status='未入住';
                    break;
                case '3':
                    $status='已出租';
                    break;
                case '4':
                    $status='待维护';
                    break;
                default:
                    break;
            }
            echo '{"status":"'.$status.'","money":"'.$result[0]["room_money"].'"}';return;
        }else{
            echo '{"status":"","money":""}';return;
        }
    }
    public function stopCommission(){
        if(!isset($_GET['id']) || empty($_GET['id'])){
            echo '{"status":"400","message":"参数错误"}';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->updateCommissionStop($_GET['id'],getLoginName());
        if($result){
            echo '{"status":"200","message":"操作成功"}';
        }else{
            echo '{"status":"400","message":"操作失败"}';
        }
    }
    public function commissionadd(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"107");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"107");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }
    public function commissionedit(){
        if(!isset($_GET['pid']) || empty($_GET['pid'])){
            return $this->error('参数错误',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
        $handleLogic=new \Logic\CommissionLogic();
        $model=$handleLogic->getCommissionById($_GET['pid']);
        if($model===null || $model===false){
            return $this->error('数据读取失败',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"107");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"107");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $list=$handleLogic->getDetailsByCommissionId($model['id']);
        $this->assign('Model',$model);
        $this->assign('list',$list);
        $this->display();
    }
    public function getRoomnoByClientphone(){
        if(!isset($_GET['mobile']) || empty($_GET['mobile'])){
            echo '';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->getRoomInfoByClientphone($_GET['mobile']);
        if($result===null || $result===false){
            echo '';return;
        }
        $room_str='';$i=1;
        foreach ($result as $key => $value) {
            $i++;
            if($i>=1000){
                break;
            }
            $room_str.=$value['room_no'].',';
        }
        if(!empty($room_str)){
            $room_str=trim($room_str,',');
        }
        echo $room_str;
    }
    //保存新增
    public function saveCommissionadd(){
        $handleLogic=new \Logic\CommissionLogic();
        $model['room_no']=I('post.room_no');
        $model['contracttime_start']=I('post.contracttime_start');
        $model['contracttime_end']=I('post.contracttime_end');
        $model['commission_type']=I('post.commission_type');
        $model['commission_base']=I('post.commission_base');
        if($model['commission_type']=="2"){
            $model['commission_base']=0;
        }
        $model['commission_money']=I('post.commission_money');
        $model['is_online']=I('post.is_online');
        $model['settlement_method']=I('post.settlement_method');
        $model['start_time']=I('post.start_time');
        $model['update_time']=time();
        $model['update_man']=getLoginName();
        if(empty($model['room_no']) || empty($model['commission_money']) || empty($model['contracttime_start']) || empty($model['start_time'])){
            return $this->success('数据异常',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
        $model['create_man']=$model['update_man'];
        $model['create_time']=$model['update_time'];
        $result=$handleLogic->addCommission($model);
       
        if($result){
            return $this->success('操作成功',U('Commission/commissionlist?no=107&leftno=109'),1);
        }else{
            return $this->error('操作失败',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
    }
    //保存修改新增
    public function saveCommission(){
        $id=I('post.id');
        if(empty($id)){
            return $this->success('参数异常',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
        $model['id']=$id;
        $model['commission_type']=I('post.commission_type');
        $model['commission_base']=I('post.commission_base');
        if($model['commission_type']=="2"){
            $model['commission_base']=0;
        }
        $model['commission_money']=I('post.commission_money');
        $model['is_online']=I('post.is_online');
        $model['settlement_method']=I('post.settlement_method');
        $model['start_time']=I('post.start_time');
        $model['update_time']=time();
        $model['update_man']=getLoginName();
        if(empty($model['commission_money']) || empty($model['start_time'])){
            return $this->success('数据异常',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->updateCommission($model);
        if($result){
            return $this->success('操作成功',U('Commission/commissionlist?no=107&leftno=109'),1);
        }else{
            return $this->error('操作失败',U('Commission/commissionlist?no=107&leftno=109'),1);
        }
    }
    //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
        $condition['room_no']=I('get.room_no');
        $condition['client_phone']=I('get.client_phone');
        $condition['client_name']=I('get.client_name');
        $condition['estate_name']=I('get.estate_name');
        $condition['updatetime_start']=I('get.updatetime_start');
        $condition['updatetime_end']=I('get.updatetime_end');
        $condition['is_open']=I('get.is_open');
        $condition['is_online']=I('get.is_online');
        $condition['settlement_method']=I('get.settlement_method');

        $handleLogic=new \Logic\CommissionLogic();
        $list = $handleLogic->getCommissionList($condition,0,5000);
        $title=array(
            'room_no'=>'房间编号','estate_name'=>'小区名称','client_phone'=>'房东手机','client_name'=>'房东姓名','room_status'=>'房间状态','room_money'=>'租金',
            'contracttime_start'=>'开始合同时长','contracttime_end'=>'结束合同时长','is_open'=>'状态','create_man'=>'创建人','create_time'=>'创建时间','update_man'=>'修改人','update_time'=>'修改时间'
            
        );
        $excel[]=$title;
        $downAll=false;
       if(in_array(trim(getLoginName()), getDownloadLimit())){
             $downAll=true;
       }
        foreach ($list as $key => $value) {
            $value['create_time']=$value['create_time']>0?date("Y-m-d H:i:s",$value['create_time']):""; 
            $value['update_time']=$value['update_time']>0?date("Y-m-d H:i:s",$value['update_time']):""; 
            switch ($value['room_status']) {
                case '0':
                    $value['room_status']='待审核';
                    break;
                case '1':
                    $value['room_status']='审核不通过';
                    break;
                case '2':
                    $value['room_status']='未入住';
                    break;
                case '3':
                    $value['room_status']='已出租';
                    break;
                case '4':
                    $value['room_status']='待维护';
                    break;
                default:
                    break;
            }
            if(!$downAll){
                $value['client_phone']=substr_replace($value['client_phone'], '****', 4,4);
            }
            
            $value['contracttime_start']=$value['contracttime_start']>0?$value['contracttime_start']:"";
            $value['contracttime_end']=$value['contracttime_end']<99?$value['contracttime_end']:"";
            $value['is_open']=$value['is_open']=="1"?"启用":"停用";
            $value['id']="";$value['city_code']="";$value['room_id']="";
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '佣金');
        $xls->addArray($excel);
        $xls->generateXML('佣金'.date("YmdHis"));
    }

    /*佣金房东 */
    public function commissionlistfd(){
        $client_phone=I('get.mobile');
        if(empty($client_phone)){
            echo '参数异常';return;
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
       
        $handleLogic=new \Logic\CommissionLogic();
        $list = $handleLogic->getCommissionfdByPhone($client_phone);
        $this->assign("list",$list);
        $this->display();
    }
    public function commissionaddfd(){
        $client_phone=I('get.mobile');
        if(empty($client_phone)){
            echo '参数异常';return;
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
        $this->display();
    }
    //保存新增
    public function saveCommissionaddfd(){
        $handleLogic=new \Logic\CommissionLogic();
        $model['client_phone']=I('post.client_phone');
        $model['contracttime_start']=I('post.contracttime_start');
        $model['contracttime_end']=I('post.contracttime_end');
        $model['commission_type']=I('post.commission_type');
        $model['commission_base']=I('post.commission_base');
        if($model['commission_type']=="2"){
            $model['commission_base']=0;
        }
        $model['commission_money']=I('post.commission_money');
        $model['is_online']=I('post.is_online');
        $model['settlement_method']=I('post.settlement_method');
        $model['start_time']=I('post.start_time');
        $model['update_time']=time();
        $model['update_man']=getLoginName();
        if(empty($model['client_phone']) || empty($model['commission_money']) || empty($model['contracttime_start']) || empty($model['start_time'])){
            echo '数据异常';return;
        }
        $model['create_man']=$model['update_man'];
        $model['create_time']=$model['update_time'];
        $model['check_update']=I('post.check_update');
        $result=$handleLogic->addCommissionfd($model);
        //删除房东房间报价、修改聚合属性
        $modelDal=new \Home\Model\commissionfd();
        $customer = $modelDal->getCustomerByWhere(" where mobile='".$model['client_phone']."'");
        if($customer[0]['is_owner'] == 4) {
            $room = $handleLogic->getHouseRoomInfo($customer[0]['id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    //给报价人推送消息
                    $handleLogic->pushHouseOfferNotice($value['id'],$value['resource_id']);
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);
                    $blackListLogic->updateHouseRoom($value['id']);          
                }
            }
        }
        if($result){
            return $this->success('操作成功',U('Commission/commissionlistfd?no=6&leftno=111&mobile='.$model['client_phone']),1);
        }else{
            return $this->error('操作失败',U('Commission/commissionlistfd?no=6&leftno=111&mobile='.$model['client_phone']),1);
        }
    }
    public function commissioneditfd(){
        $commissionId=I('get.pid');
        if(empty($commissionId)){
            echo '参数异常';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $model=$handleLogic->getCommissionfdById($commissionId);
        if($model===null || $model===false){
            echo '数据读取失败';return;
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
        $list=$handleLogic->getDetailsfdByCommissionId($model['id']);
        $this->assign('Model',$model);
        $this->assign('list',$list);
        $this->display();
    }
    //保存修改新增
    public function saveCommissionfd(){
        $model['id']=I('post.id');
        if(empty($model['id'])){
            echo '参数异常';return;
        }
        $model['commission_type']=I('post.commission_type');
        $model['commission_base']=I('post.commission_base');
        if($model['commission_type']=="2"){
            $model['commission_base']=0;
        }
        $model['commission_money']=I('post.commission_money');
        $model['is_online']=I('post.is_online');
        $model['settlement_method']=I('post.settlement_method');
        $model['start_time']=I('post.start_time');
        $model['update_time']=time();
        $model['update_man']=getLoginName();
        if(empty($model['commission_money']) || empty($model['start_time'])){
            echo '数据异常';return;
        }
        $model['check_update']=I('post.check_update');
        $model['client_phone']=I('post.client_phone');
        $model['contracttime_start']=I('post.contracttime_start');
        $model['contracttime_end']=I('post.contracttime_end');
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->updateCommissionfd($model);
        if($result){
            return $this->success('操作成功',U('Commission/commissionlistfd?no=6&leftno=111&mobile='.$model['client_phone']),1);
        }else{
            return $this->error('操作失败',U('Commission/commissionlistfd?no=6&leftno=111&mobile='.$model['client_phone']),1);
        }
    }
    public function stopCommissionfd(){
        $id=I('get.id');
        if(empty($id)){
            echo '参数异常';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->updateCommissionStopfd($id,getLoginName());
        if($result){
            echo '操作成功';
        }else{
            echo '操作失败';
        }
    }

    /*包月佣金管理 */
    public function commissionMonthly(){
        $client_phone=I('get.mobile');
        $customer_id=I('get.customer_id');
        if(empty($client_phone) || empty($customer_id)){
            echo '参数异常';return;
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
       
        $handleLogic=new \Logic\CommissionLogic();
        $list = $handleLogic->getCommissionmonthlyByCustid($customer_id);
        $this->assign("list",$list);
        $this->display();
    }
    public function addMonthlySubmit(){
        $login_name=trim(getLoginName());
        if($login_name==''){
            echo '{"status":"201","message":"请重新登录"}';return;
        }
        
        $model['customer_id']=I('post.customer_id');
        $model['monthly_days']=trim(I('post.monthly_days'));
        $model['monthly_money']=trim(I('post.monthly_money'));
        $model['monthly_start']=trim(I('post.monthly_start'));
        $model['monthly_bak']=trim(I('post.monthly_bak'));
        $model['contract_type']=trim(I('post.contract_type'));
        if(empty($model['monthly_days']) || empty($model['monthly_money']) || empty($model['monthly_start'])){
            echo '{"status":"202","message":"数据不完整"}';return;
        }
        if(!is_numeric($model['monthly_days']) || !is_numeric($model['monthly_money'])){
            echo '{"status":"203","message":"数据异常"}';return;
        }
        $model['monthly_start']=strtotime($model['monthly_start']);
        $model['monthly_end']=intval($model['monthly_start'])+3600*24*intval($model['monthly_days']);
        $model['update_time']=time();
        $model['update_man']=$login_name;
        $model['create_man']=$model['update_man'];
        $model['create_time']=$model['update_time'];
        $model['is_open']=1;
        $model['city_code']=C('CITY_CODE');
  
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->addCommissionmonthly($model,I('post.is_stopcomm'));

        //删除房东房间报价、修改聚合属性
        $modelDal=new \Home\Model\commissionfd();
        $customer = $modelDal->getCustomerByWhere(" where id='".$model['customer_id']."'");
        if($customer[0]['is_owner'] == 4) {
            $room = $handleLogic->getHouseRoomInfo($customer[0]['id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    //给房间报价人推送消息
                    $handleLogic->pushHouseOfferNotice($value['id'],$value['resource_id']);
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);
                    $blackListLogic->updateHouseRoom($value['id']);          
                }
            }
        }
        if($result){
            $model['id'] = $result;
            $handleLogic->createCommissionMonLog($model);
            echo '{"status":"200","message":"新增成功"}';
        }else{
            echo '{"status":"400","message":"新增失败"}';
        }
    }
    public function stopMonthly(){
        $id=I('get.id');
        $data = I('get.');
        $customer_id=I('get.customer_id');
        if(empty($id) || empty($customer_id)){
            echo '参数异常';return;
        }
        $login_name=trim(getLoginName());
        if($login_name==''){
            echo '请重新登录';return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result=$handleLogic->stopCommissionmonthly($id,$customer_id,$login_name);
        if($result){
            $handleLogic->createStopCommissionMonLog($data);
            echo '操作成功';
        }else{
            echo '操作失败';
        }
    }
    //修改延期状态
    public function contractModifyType ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)) {
            echo '{"status":"404","message":"登录失效"}';return;
        }
        $data = I('post.');//id,customer_id,monthly_delay,monthly_bak_delay,monthly_end,monthly_days
        if($data['monthly_end'] < strtotime(date('Y-m-d',time()))) {
            echo '{"status":"400","message":"操作失败:包月合同已到期停用,无法延期"}';
            return;
        }
        if($data['monthly_delay'] == '' || $data['monthly_delay'] ==0) {
            echo '{"status":"400","message":"操作失败:合同延期参数错误"}';
            return;
        }
        $handleLogic=new \Logic\CommissionLogic();
        $result = $handleLogic->updateCommissionMonDelay($data);
        if($result) {
            $handleLogic->createDelayCommissionMonLog($data);
            $handleLogic->updateCustomerMonEnd($data);
            echo '{"status":"200","message":"操作成功"}';
        } else {
            echo '{"status":"400","message":"操作失败"}';
        }
    }
    //包月合同历史记录
    public function  contractCheckHistoryLog ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }   
        $data = I('get.');//relation_id
        $handleLogic = new \Logic\CommissionLogic();
        $list = $handleLogic->getContractHistoryLog($data);
        $this->assign('list',$list);
        $this->display();
    }
    //跳转编辑包月合同
    public function contractEditInfo ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"6");
        $data = I('get.');//id
        $handleLogic = new \Logic\CommissionLogic();
        $list = $handleLogic->findContractInfo($data);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('list',$list); 
        $this->display();
    }
    //修改包月合同信息
    public function contractModifyInfo ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I('post.');//id,customer_id,monthly_days,monthly_money,monthly_start,monthly_type,monthly_bak
        $handleLogic = new \Logic\CommissionLogic();
        $return = $handleLogic->modifyContractInfo($data);
        if($return === false) {
            $this->error("操作失败:参数错误","contractEditInfo.html?no=6&leftno=111&id=".$data['id']); 
        } else {
            $handleLogic->updateCustomerMonth($data);
            $returnSecond = $handleLogic->findCustomerMobile($data);
            $data['mobile'] = $returnSecond['mobile'];
            $this->success("操作成功","commissionMonthly.html?no=6&leftno=111&mobile=".$data['mobile']."&customer_id=".$data['customer_id']);
        }
    }
}

?>	
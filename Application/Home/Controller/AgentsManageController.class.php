<?php
namespace Home\Controller;
use Think\Controller;
class AgentsManageController extends Controller
{
	//中介管理
	public function agentsManageList ()
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

      	$startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $isMonthly = I('get.is_monthly');
        $regionID = I('get.region_id');
        $companyID = I('get.company_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 5;
      	if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            $where['a.mobile']=array('eq',$mobile);
        }
        if($isMonthly != "") {
            $where['a.is_monthly']=array('eq',$isMonthly);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        $agentsModel = new \Home\Model\agents();
        $agentsLogic = new \Logic\AgentsManageLogic();
        $fields = 'a.true_name,a.mobile,a.is_black,a.is_commission,a.is_monthly,a.agent_company_name,b.status,b.create_time,b.principal_man,b.source,b.update_man,b.region_name,b.owner_remark,b.customer_id';
        $count = $agentsModel->modelCountCustomer($where);
        $Page = new \Think\Page($count,10);
        $data = $agentsModel->modelGetCustomer($Page->firstRow,$Page->listRows,$fields,$where);
        /*区域 */
      	$resourceLogic=new \Logic\HouseResourceLogic();
      	$result=$resourceLogic->getRegionList();
      	$regionList='';
      	if($result != null){
        	foreach ($result as $key => $value) {
          	$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        	} 
      	}
        //中介公司
        $companyList = '';
        $fields = 'id,company_name';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
	  	  $this->assign("menutophtml",$menu_top_html);
	  	  $this->assign("menulefthtml",$menu_left_html);
      	$this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
      	$this->assign("pagecount",$count);
      	$this->assign("show",$Page->show());
      	$this->assign("list",$data);
      	$this->display();
	}
	//新增中介信息
	public function agentsAdd ()
	{
		$loginName=trim(getLoginName());
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
       	$switchcity=$handleCommonCache->cityauthority();
       	$this->assign("switchcity",$switchcity);
      	$handleMenu = new \Logic\AdminMenuListLimit();
      	$menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
      	$menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
        /*查询条件（房间负责人）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getHouseHandleList();
        $createmanString='';
        foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
        } 
        $this->assign("createManList",$createmanString);
         /*区域 */
        $result = $handleResource->getRegionList();
        $regionList='';
        if($result !=null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //中介公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name,commission_fee';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'--中介费:'.$value["commission_fee"].'</option>';
          } 
        }
      	$this->assign("menutophtml",$menu_top_html);
	  	$this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
		  $this->display();
	}
	//判断用户身份
	public function agentsProveInfo ()
	{
		$data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->findCustomer($data);
        if(!empty($result)) {
          	if($result['is_owner'] == 4) {
          		echo '{"code":"400","message":"该号码已注册为职业房东"}';return;
          	} elseif ($result['is_owner'] == 5) {
          		echo '{"code":"400","message":"该号码已注册为中介用户"}';return;
          	} elseif ($result['is_owner'] == 1) {
              echo '{"code":"400","message":"该号码已注册为房东"}';return;
            } elseif ($result['is_owner'] == 3) {
          		echo '{"code":"202","message":"该号码已注册为个人房东,继续执行将删除个人房源"}';return;
          	} elseif ($result['is_owner'] == 0) {
              echo '{"code":"202","message":"该号码已注册为租客,是否继续操作"}';return;
            }
        } else {
        	echo '{"code":"200","message":""}';return;
        }
	}
	//新增中介信息
	public function agentsAddInfo ()
	{
		$data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $handleCustomerinfo= new \Home\Model\customerinfo();
   			$resultOne = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
        	if(empty($resultOne)) {
        		return $this->error('该负责人不存在',"agentsManageList.html?no=6&leftno=192");
        	} 
        $result = $agentsLogic->findCustomer($data);
        //删除用户房间报价
        if(!empty($result) && ($result['is_owner'] == 3 || $result['is_owner'] == 0) ) {
          $handleLogic = new \Logic\CommissionLogic();
          $room = $handleLogic->getHouseRoomInfo($result['id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);        
                }
            }
        	$agentsLogic->deleteCustomerHouses($result['id']);//删除用户房源
          //查找customerinfo是否存在，并添加
          $agentsLogic->findCustomerInfoTable($result['id']);
        	$resultTwo = $agentsLogic->modifyAgentsInfo($result['id'],$data);//更新用户信息
        } elseif(empty($result)) { 
        	$resultTwo = $agentsLogic->addAgentsInfo($data);
        } else {
          $resultTwo = false;
        }
    	if($resultTwo) {
            //删除用户缓存
            if(!empty($result['id'])) {
                $cache_key="customer_model_get".$result['id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
            }     
       	    $this->success('提交成功！',"agentsManageList.html?no=6&leftno=192");
    	}else{
    	    $this->error('提交失败！',"agentsManageList.html?no=6&leftno=192");
   	    }
	}
  //新增录音、房源审核中介用户
  public function setAgentsInfo ()
  {
    $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->findCustomer($data);
        //删除用户房间报价
        if(!empty($result) && ($result['is_owner'] == 3 || $result['is_owner'] == 0) ) {
          $handleLogic = new \Logic\CommissionLogic();
          $room = $handleLogic->getHouseRoomInfo($result['id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);        
                }
            }
          $agentsLogic->deleteCustomerHouses($result['id']);//删除用户房源
          //查找customerinfo是否存在，并添加
          $agentsLogic->findCustomerInfoTable($result['id']);
          $resultTwo = $agentsLogic->modifyAgentsInfoThree($result['id'],$data);//更新用户信息
        } elseif(empty($result)) { 
          $resultTwo = $agentsLogic->addAgentsInfoThree($data);
        } else {
           echo '{"code":"201","message":"该号码已注册为职业房东/中介","data":{}}';return;
        }
      if($resultTwo) {
            //删除用户缓存
            if(!empty($result['id'])) {
                $cache_key="customer_model_get".$result['id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
            }     
            echo '{"code":"200","message":"操作成功","data":{}}';
      } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
  }
	//展示修改中介信息
	public function agentsUpdate ()
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
      	$data = I('get.');//id
      	$agentsLogic = new \Logic\AgentsManageLogic();
      	$info = $agentsLogic->findCustomerInfo($data['id']);
        $info['agent_commission_price'] = $info['agent_commission_price']/100;
      	$handleResource=new \Logic\HouseResourceLogic();
 		    /*区域 */
        $result = $handleResource->getRegionList();
        $regionList='';
        if($result !=null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //中介公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name,commission_fee';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'--中介费:'.$value["commission_fee"].'</option>';
          } 
        }
      	$this->assign("menutophtml",$menu_top_html);
      	$this->assign("menulefthtml",$menu_left_html);
      	$this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
    	  $this->assign("customer",$info);
      	$this->display();
	}
	//修改中介信息
	public function agentsModifyInfo ()
	{
  		$data = I('post.');//customer_id,true_name,mobile
  		$login_name=trim(getLoginName());
      if(empty($login_name) || empty($data)){
          echo '{"code":"404","message":"登录失效"}';return;
      } 
      $agentsLogic = new \Logic\AgentsManageLogic();
      $handleCustomerinfo= new \Home\Model\customerinfo();
      $result = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
      if(empty($result)) {
      	return $this->error('该负责人不存在',"agentsManageList.html?no=6&leftno=192");
      } 
      if($data['is_owner'] == 4) {
        $data['agent_company_name'] = $data['agent_company_id'] = $data['agent_commission_price'] = '';
        $resultOne = $agentsLogic->modifyAgentsInfoTwo($data);
        if($resultOne !== false) {
          $handleLogic = new \Logic\CommissionLogic();
          $room = $handleLogic->getHouseRoomInfo($data['customer_id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);        
                }
            }
          $agentsLogic->deleteCustomerHouses($data['customer_id']);//删除用户房源
          $agentsLogic->deleteHouseOffer($data['customer_id']);//删除中介报价
        }
      } elseif($data['is_owner'] == 5) {
        $resultOne = $agentsLogic->modifyAgentsInfoTwo($data);
      }
     	if($resultOne === false) {
          $this->success('修改失败！',"agentsManageList.html?no=6&leftno=192");
      }else{
          //删除用户缓存
          $cache_key="customer_model_get".$data['customer_id'];
          $cache_key=set_cache_public_key($cache_key);           
          set_redis_data($cache_key,"the data is null!",60*20);
          $this->success('修改成功！',"agentsManageList.html?no=6&leftno=192");
      }
	}
  //导出excel
    public function downloadExcel()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }

        //查询条件
        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['a.city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 5;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['b.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['b.is_commission']=array('eq',1);
        }

        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,b.source,b.principal_man,b.status,b.region_name,a.agent_company_name,a.company_store_name,b.create_time,b.update_man,a.is_port,a.is_monthly,a.is_commission,b.owner_remark';
        $data = $jobOwnerModel->modelGetCustomer(0,5000,$fields,$where);

        $title=array(
            'true_name'=>'姓名','mobile'=>'手机号','source'=>'来源','principal_man'=>'房东负责人','status'=>'跟进状态','region_name'=>'主营区域','agent_company_name'=>'公司','company_store_name'=>'门店','create_time'=>'创建时间','update_man'=>'操作人','is_port'=>'端口状态','is_monthly'=>'包月状态','is_commission'=>'佣金状态','owner_remark'=>'备注'
        );
        $excel[]=$title;
        $downAll=false;
            if(in_array(trim(getLoginName()), getDownloadLimit())) {
               $downAll=true;
         }
        foreach ($data as $key => $value) {
            if(!$downAll){
                $value['mobile'] = substr_replace($value['mobile'], '****', 4,4);
            }
            switch ($value['status']) {
                case '0':
                    $value['status']='待跟进';
                    break;
                case '3':
                    $value['status']='跟进中';
                case '5':
                    $value['status']='不合作';
                case '2':
                    $value['status']='已签约';
                case '4':
                    $value['status']='职业房东';
                    break;
                default:
                    $value['status']='';
                    break;
            }
            $value['create_time'] = $value['create_time']>0?date("Y-m-d H:i",$value['create_time']):"";
            switch ($value['is_port']) {
                case '0':
                    $value['is_port']='无';
                    break;
                case '1':
                    $value['is_port']='端口';
                    break;
                default:
                    $value['is_port']='';
                    break;
            }
            switch ($value['is_monthly']) {
                case '0':
                    $value['is_monthly']='无';
                    break;
                case '1':
                    $value['is_monthly']='包月';
                    break;
                default:
                    $value['is_monthly']='';
                    break;
            }
             switch ($value['is_commission']) {
                case '0':
                    $value['is_commission']='无';
                    break;
                case '1':
                    $value['is_commission']='端口';
                    break;
                default:
                    $value['is_commission']='';
                    break;
            }
            $excel[] = $value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '中介经纪人');
        $xls->addArray($excel);
        $xls->generateXML('中介经纪人'.date("YmdHis"));
    }
	//中介公司管理
	public function agentsCompanyList ()
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

      	$startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $name = I('get.company_name');
        $type = I('get.company_type');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
        $where['pid'] = "";
        if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($name != "") {
            $where['company_name']=array('like','%'.$name.'%');
        }
        if($type == "") {
            $where['company_type']=array('eq',1);
        } else {
            $where['company_type']=array('eq',$type);
        }
        $agentsModel = new \Home\Model\agents();
        $agentsLogic = new \Logic\AgentsManageLogic();
        $fields = 'id,company_name,img_url,commission_fee,create_time,company_type';
        $count = $agentsModel->modelCountAgentCompany($where);
        $Page = new \Think\Page($count,10);
        $data = $agentsModel->modelGetAgentCompany($Page->firstRow,$Page->listRows,$fields,$where);
      	$this->assign("menutophtml",$menu_top_html);
	  	  $this->assign("menulefthtml",$menu_left_html);
	  	  $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
	  	  $this->assign("list",$data);
		    $this->display();
	}
	//删除中介公司
    public function agentsCompanyDelete()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","messasge":"登录失效"}';return;
        }
        $data = I('get.');
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->deleteAgentCompany($data);
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
	//新增中介公司
	public function agentsCompanyAdd ()
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
      	$this->assign("menutophtml",$menu_top_html);
	  	$this->assign("menulefthtml",$menu_left_html);
	  	$this->display();
	}
	//新增中介公司信息
  	public function agentsCompanyAddInfo () 
  	{
        $data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $data['company_type'] = 1;
        $data['commission_type'] = 1;
        $result = $agentsLogic->addAgentCompany($data);
        if($result){
            $this->success('提交成功！',"agentsCompanyList.html?no=6&leftno=193");
        }else{
            $this->success('提交失败！',"agentsCompanyList.html?no=6&leftno=193");
        }
    }
	//展示修改中介公司
	public function agentsCompanyUpdate ()
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
      	$data = I('get.');//id
      	$agentsLogic = new \Logic\AgentsManageLogic();
      	$info = $agentsLogic->findAgentCompany($data); 
      	$this->assign("menutophtml",$menu_top_html);
	  	  $this->assign("menulefthtml",$menu_left_html);
	  	  $this->assign("list",$info);
	  	  $this->display();
	}
	//修改中介公司信息
	public function agentsCompanyModifyInfo ()
	{
		    $data = I('post.');
		    $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->modifyAgentCompany($data);
       	if($result){
            $this->success('修改成功！',"agentsManageCompanyList.html?no=6&leftno=193");
        }else{
            $this->success('修改失败！',"agentsManageCompanyList.html?no=6&leftno=193");
        }
	}
	//上传图片
    public function uploadImage() {
        
       if(isset($_GET['act']) && $_GET['act']=='delimg'){
          $filename = $_POST['imagename'];

        }else{
          log_result("roomlog.txt","上传图片:".json_encode($_FILES['mypic']));
            $picname = $_FILES['mypic']['name'];
            $picsize = $_FILES['mypic']['size'];
        
         
          if ($picname != "") {
            //$type = strstr($picname, '.');
            $picname_arr = explode('.', $picname);
            $type=$picname_arr[count($picname_arr)-1];
            if ($type != "gif" && $type != "jpg" && $type != "jpeg" && $type != "png") {
              echo '文件必须是图片格式！';
              exit;
            }
            if ($picsize > 1024000*3) {
              echo '图片大小不能超过3M';
              exit;
            }
            $rand = rand(100, 999);
            $pics = date("YmdHis") . $rand .'.'. $type;
            //上传路径
            $imgData=$this->base64_encode_image($_FILES['mypic']['tmp_name'],$type);
            $result = $this->uploadImageToServer($_POST['room_id'],$pics,$imgData);
            echo $result;
         }
       }
    }

    public function base64_encode_image($filename=string,$filetype=string) {
        if ($filename) {
        	$imgbinary = file_get_contents($filename);
        	return base64_encode($imgbinary);
      	}
  	}

    //上传图片到服务器
    public function uploadImageToServer($room_id,$fileName,$imgData)
    {
		// post提交
		$post_data = array ();
		$post_data ['relationId'] = "xx";
		$post_data ['fileName'] = $fileName;
		$post_data ['data']=$imgData;
		$post_data ['fileSize'] = "10000";
		$url =C("IMG_SERVICE_URL").'appico/web/upload';
		$o = "";
		foreach ( $post_data as $k => $v ) {
		$o .= "$k=" . urlencode ( $v ) . "&";
		}
		$post_data = substr ( $o, 0, - 1 );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		$result = curl_exec ( $ch );
  	}
    //新增公司门店
    public function companyStoreList ()
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
        $data = I('get.');//id
        $agentsLogic = new \Logic\AgentsManageLogic();
        $info = $agentsLogic->findCompanyStores($data); 
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("list",$info);
        $this->assign("company",$data);
        $this->display();
    }
    //新增门店信息
    public function companyStoreAddInfo () 
    {
        $data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->addCompanyStore($data);
        if($result) {
            echo '{"code":"200","message":"新增门店成功","data":{}}';
        } else {
            echo '{"code":"400","message":"新增门店失败","data":{}}';
        }
    }
    //编辑门店信息
    public function companyStoreEditInfo () 
    {
        $data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsModel =  new \Home\Model\agents();
        $result = $agentsModel->modelModifyAgentCompany($data);
        if($result) {
            echo '{"code":"200","message":"编辑门店成功","data":{}}';
        } else {
            echo '{"code":"400","message":"编辑门店失败","data":{}}';
        }
    }
    //ajax返回门店信息
    public function companyStoreAjaxInfo () 
    {
        $data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $result = $agentsLogic->findCompanyStores($data);
        $this->ajaxReturn($result);
    }
    //中介经纪人
    public function middlemansManageList ()
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

        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['a.city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 5;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['b.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['b.is_commission']=array('eq',1);
        }

        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,a.is_commission,a.is_monthly,a.is_port,a.agent_company_name,a.company_store_name,b.status,b.create_time,b.update_man,b.principal_man,b.source,b.region_name,b.customer_id,b.owner_remark';
        $count = $jobOwnerModel->modelCountCustomer($where);
        $Page = new \Think\Page($count,10);
        $data = $jobOwnerModel->modelGetCustomer($Page->firstRow,$Page->listRows,$fields,$where);

        /*区域 */
        $resourceLogic=new \Logic\HouseResourceLogic();
        $result=$resourceLogic->getRegionList();
        $regionList='';
        if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //中介公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['company_type'] = 1;
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
    }
  //中介经纪人详情页
  public function middlemansManageDetail () 
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
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $data = I('get.');//id
        $infoList = $portList = $monthlyList = $commissionList = $stickList = $dataList = array();
        $infoList = $jobOwnerLogic->findOwnerInfo($data['id']);
        $return = $jobOwnerLogic->findBasicInfo($data['id']);
        $portList = $return[0];
        $monthlyList = $return[1];
        $commissionList = $return[2];
        $stickList =  $return[3];
        // $dataList = $return[4];
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('infoList',$infoList);
        $this->assign('portList',$portList);
        $this->assign('monthlyList',$monthlyList);
        $this->assign('commissionList',$commissionList);
        $this->assign('stickList',$stickList);
        // $this->assign('dataList',$dataList);
        $this->display();
  }
  //新增中介经纪人
  public function middlemansAdd ()
  {
        $loginName=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
        /*查询条件（房间负责人）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getHouseHandleList();
        $createmanString='';
        foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
        } 
        $this->assign("createManList",$createmanString);
         /*区域 */
        $result = $handleResource->getRegionList();
        $regionList='';
        if($result !=null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //中介公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name,commission_fee';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['company_type'] = 1;
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->display();
  }
  //新增中介信息
  public function middlemansAddInfo ()
  {
      $data = I('post.');
      $login_name=trim(getLoginName());
      if(empty($login_name) || empty($data)){
          echo '{"code":"404","message":"登录失效"}';return;
      } 
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $agentsLogic = new \Logic\AgentsManageLogic();
      $handleCustomerinfo= new \Home\Model\customerinfo();
      $resultOne = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
        if(empty($resultOne)) {
          return $this->error('该负责人不存在',"middlemansManageList.html?no=6&leftno=192");
        } 
      $result = $agentsLogic->findCustomer($data);
      $data['memo'] = $result['memo'].strtotime(time())."后台新增中介";
      if(!empty($result) && $result['is_owner'] == 3) {
          $handleLogic = new \Logic\CommissionLogic();
          $room = $handleLogic->getHouseRoomInfo($result['id']);
            if(!empty($room)) {
                foreach ($room as $value) {
                    $blackListLogic = new \Logic\BlackListLogic();
                    $blackListLogic->deleteHouseRoomOffer($value['id']);        
                }
            }
          $agentsLogic->deleteCustomerHouses($result['id']);//删除用户房源
        //查找customerinfo是否存在，并添加
        $agentsLogic->findCustomerInfoTable($result['id']);
        $resultTwo = $agentsLogic->modifyAgentsInfo($result['id'],$data);//更新用户信息
      } elseif (!empty($result) && $result['is_owner'] == 0) {
          //查找customerinfo是否存在，并添加
        $agentsLogic->findCustomerInfoTable($result['id']);
        $resultTwo = $agentsLogic->modifyAgentsInfo($result['id'],$data);//更新用户信息
      } elseif(empty($result)) { 
        $resultTwo = $agentsLogic->addAgentsInfo($data);
      } else {
        $resultTwo = false;
      }
      if($resultTwo) {
            //删除用户缓存
            if(!empty($result['id'])) {
                $cache_key="customer_model_get".$result['id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
            }     
            $this->success('提交成功！',"middlemansManageList.html?no=6&leftno=206");
      } else {
          $this->error('提交失败！',"middlemansManageList.html?no=6&leftno=206");
      }
  }
  //编辑中介经纪人信息
  public function middlemansUpdate ()
  {
      $customerID = I('get.id');
      if(empty($customerID)) {
          echo '参数异常';return;
      }
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
       return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      //菜单权限
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
      $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $data = $jobOwnerLogic->findOwnerInfo($customerID);
      /*查询条件（房间负责人）*/
      $handleResource=new \Logic\HouseResourceLogic();
      $result=$handleResource->getHouseHandleList();
      $createmanString='';
      foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
      } 
      $this->assign("createManList",$createmanString);
      /*区域 */
      $result = $handleResource->getRegionList();
      $regionList='';
      if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
      }
      //中介公司
      $agentsModel = new \Home\Model\agents();
      $companyList = '';
      $fields = 'id,company_name,commission_fee';
      $where = array();
      $where['city_code'] = C('CITY_CODE');
      $where['pid'] = "";
      $where['company_type'] = 1;
      $where['record_status'] = 1;
      $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
      if($return !=null){
        foreach ($return as $key => $value) {
          $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
        } 
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("regionList",$regionList);
      $this->assign("companyList",$companyList);
      $this->assign("info",$data);
      $this->display();
  }
  //修改中介经纪人信息
  public function middlemansModifyInfo ()
  {
      $data = I('post.');
      $login_name=trim(getLoginName());
      if(empty($login_name) || empty($data)){
          echo '{"code":"404","message":"登录失效"}';return;
      } 
      $agentsLogic = new \Logic\AgentsManageLogic();
      $handleCustomerinfo= new \Home\Model\customerinfo();
      if(!empty($data['principal_man'])) {
          $result = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
          if(empty($result)) {
            return $this->error('该负责人不存在',"middlemansManageList.html?no=6&leftno=204");
          } 
      }
      $return = $agentsLogic->modifyAgentsInfoTwo($data);
      if($return) {
          //删除用户缓存
          $cache_key="customer_model_get".$data['customer_id'];
          $cache_key=set_cache_public_key($cache_key);           
          set_redis_data($cache_key,"the data is null!",60*20);
          $this->success('修改成功！',"middlemansManageList.html?no=6&leftno=206");
      }else{
          $this->success('修改失败！',"middlemansManageList.html?no=6&leftno=206");
      }
  }
  //新增端口
  public function middlemanPortAdd () 
  {
      $customerID = I('get.id');
      if(empty($customerID)) {
          echo '参数异常';return;
      }
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
       return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      //菜单权限
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
      $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("id",$customerID);
      $this->display();
    }
    //新增端口合同
    public function middlemanPortAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addServiceData($data);
        if($return){
                 //删除用户缓存
                $cache_key="customer_model_get".$data['customer_id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
                $this->success("端口新增成功","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
            } else {
                $this->error("端口新增失败","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        }
    }
    //端口延期
    public function middlemanPortDelay ()
    {
        $customer = I('get.');
        if(empty($customer)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("customer",$customer);
        $this->display();
    }
    //端口延期合同
    public function middlemanPortDelayInfo ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->delayOwnerPort($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            $this->success("端口延期成功","middlemansManageDetail.html?no=6&leftno=204&id={$data['customer_id']}");
        } else {
            $this->error("端口延期失败","middlemansDetail.html?no=6&leftno=204&id={$data['customer_id']}");
        }
    }
    //新增包月
    public function middlemanMonthlyAdd () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("id",$customerID);
        $this->display();
    }
    //新增包月合同
    public function middlemanMonthlyAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addCommissionMonthly($data);
        if($return){
                $this->success("包月新增成功","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
            } else {
                $this->error("包月新增失败","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        }
    }
    //停用包月
    public function middlemanMonthlyStop ()
    {
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->stopOwnerMonthly($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //新增佣金
    public function middlemanCommissionAdd () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("id",$customerID);
        $this->display();
    }
    //新增佣金合同
    public function middlemanCommissionAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addCommissionDetail($data);
        if($return){
            $this->success("佣金新增成功","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        } else {
            $this->error("佣金新增失败","middlemansManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        }
    }
    //停用佣金
    public function middlemanCommissionStop ()
    {
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->stopOwnerCommission($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //核心管理
    public function middlemansCoreManageList ()
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

        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 4;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
         if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['b.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['b.is_commission']=array('eq',1);
        }

        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,a.agent_company_name,a.company_store_name,b.status,b.principal_man,b.source,b.region_name,b.customer_id';
        $count = $jobOwnerModel->modelCountCustomer($where);
        $Page = new \Think\Page($count,10);
        $data = $jobOwnerModel->modelGetCustomer($Page->firstRow,$Page->listRows,$fields,$where);

        /*区域 */
        $resourceLogic=new \Logic\HouseResourceLogic();
        $result=$resourceLogic->getRegionList();
        $regionList='';
        if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //中介公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['record_status'] = 1;
        $where['company_type'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
   }
   //核心信息管理
    public function middlemansCoreInfo () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $data = $jobOwnerLogic->findOwnerCoreInfo($customerID);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("customerinfo",$data);
        $this->display();
    }
    //职业房东核心信息修改
    public function middlemansModifyCoreInfo ()
    {
        $data = I('post.');
        $data['owner_verify'] = 0;
        if(!isset($data['owner_verify'])) {
          $data['owner_verify'] = 0;
        }
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $handleCustomerinfo= new \Home\Model\customerinfo();
        if(!empty($data['principal_man'])) {
            $result = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
            if(empty($result)) {
              return $this->error('该负责人不存在',"middlemansManageList.html?no=6&leftno=204");
            } 
        }
        $return = $agentsLogic->modifyAgentsInfoThree($data['customer_id'],$data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['customer_id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            $this->success('修改成功！',"middlemansCoreManageList.html?no=6&leftno=205");
        }else{
            $this->success('修改失败！',"middlemansCoreManageList.html?no=6&leftno=205");
        }
    }
}
?>
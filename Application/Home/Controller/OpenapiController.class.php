<?php
namespace Home\Controller;
use Think\Controller;
/*58接口对接 */
class OpenapiController extends Controller{

	//发布房间 list 
	public function fabulist(){
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
        $condition['estateName']=trim(I('get.estateName'));
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');

        $condition['isAgent']=I('get.isAgent');
        $condition['isComm']=I('get.isComm');
        $condition['isMonth']=I('get.isMonth');
        $condition['rentType']=I('get.rentType');
        $condition['roomName']=I('get.roomName');
        $condition['totalnum']=I('get.totalnum');
		$hadCondition=false;
        foreach ($condition as $k1 => $v1) {
        	if(!empty($v1)){
        		$hadCondition=true;
        		break;
        	}
        }
        $list=array();$pageSHow='';
        if($hadCondition){
        	$handleLogic=new \Logic\OpenapiLogic();
        	if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['region'])){
        	    $condition['totalnum'] = $handleLogic->getFabuCount($condition);
        	}
        	if($condition['totalnum']>0){
        	    $Page= new \Think\Page($condition['totalnum'],100);//分页
        	    foreach($condition as $key=>$val) {
        	        $Page->parameter[$key]=urlencode($val);
        	    }
        	    $pageSHow=$Page->show();
        	    $list = $handleLogic->getFabuList($condition,$Page->firstRow,$Page->listRows);
        	}
        }
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
		/*查询条件（区域板块）*/
		$handleResource=new \Logic\HouseResourceLogic();
		$regionList='';
		$regionResult=$handleResource->getRegionList();
		if($regionResult !=null){
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
    	$this->assign("list",$list);
    	$this->assign("pageSHow",$pageSHow);
    	$this->assign("totalnum",$condition['totalnum']);
		$this->display();
	}
	public function fabu(){
		if(!isset($_POST['select_ids']) || empty($_POST['select_ids'])){
			return $this->error('非法参数',U('Openapi/fabulist?no=3&leftno=102'),1);
		}
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         //读取对应城市下58帐号
         $handleLogic=new \Logic\OpenapiLogic();
         $accounts=$handleLogic->getWubaAccount();
         if(false===$accounts || null===$accounts || count($accounts)===0){
         	return $this->error('暂无帐号',U('Openapi/fabulist?no=3&leftno=102'),1);
         }
         foreach ($accounts as $key => $value) {
         	$accountOption.='<label><input type="checkbox" name="userid[]" value="'.$value["userid"].'">'.$value["userid"].'</label>&nbsp;&nbsp;';
         }
         $this->assign("accountOption",$accountOption);
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
         
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
  		$this->display();
	}
	public function submitFabu(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		$userid=I('post.account');
		if(empty($select_ids)){
			echo '非法参数';return;
		}
		if(empty($userid)){
			echo '帐号异常';return;
		}
		$handle=new \Logic\OpenapiLogic();
		$data['select_ids']=$select_ids;
		$data['ad_desc']="让你结交心动室友，刷卡支付房租，还能经常获取大量优惠";
		$data['room_desc_start']="";
		$data['room_desc_end']="";
		$data['create_man']=$login_name;
		$count=$handle->addOpenapipushMore($data,explode(",", $userid));
		echo '成功发布'.$count.'套房间';
	}
	//已经发布 list 
		public function hadfabulist(){
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
	        
	        $list = array();
	        $pageSHow='';
	        //查询条件
	        $condition['startTime']=I('get.startTime');
	        $condition['endTime']=I('get.endTime');
	        $condition['startTime_create']=I('get.startTime_create');
	        $condition['endTime_create']=I('get.endTime_create');
	        $condition['roomStatus']=I('get.roomStatus');
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['update_man']=trim(I('get.update_man'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['is_recommend']=I('get.is_recommend');
	        $condition['is_true']=I('get.is_true');
	        $condition['startTime_fabu']=I('get.startTime_fabu');
	        $condition['endTime_fabu']=I('get.endTime_fabu');
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['pagecount']=I('get.pagecount');
	        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);

	        if(isset($_GET['roomNo']) || $totalCount>0){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if(I('get.p')==''){
	        	  $totalCount=$handleLogic->getModelListCount($condition);
	        	} 
	        	if($totalCount>0){
			        $Page= new \Think\Page($totalCount,100);//分页
			        $condition['pagecount']=$totalCount;
			        foreach($condition as $key=>$val) {
			            $Page->parameter[$key]=urlencode($val);
			        }
			        $pageSHow=$Page->show();
		        	$list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
	        $this->assign("list",$list);
	        $this->assign("totalCount",$totalCount);
	        $this->assign("pageSHow",$pageSHow);
			$this->display();
		}
		//删除发布
		public function removeFabu(){
			if(!isset($_POST['select_ids']) || empty($_POST['select_ids'])){
				echo '{"status":"400","msg":"参数为空"}';return;
			}
			$login_name=trim(getLoginName());
			if(empty($login_name)){
				echo '{"status":"400","msg":"请重新登录"}';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->deleteOpenapipush($_POST['select_ids'],$login_name);
			if($result){
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"400","msg":"操作失败"}';
			}
		}
		//刷新发布
		public function reflushFabu(){
			if(!isset($_POST['select_ids']) || empty($_POST['select_ids'])){
				echo '{"status":"400","msg":"参数为空"}';return;
			}
			$login_name=trim(getLoginName());
			if(empty($login_name)){
				echo '{"status":"400","msg":"请重新登录"}';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->reflushOpenapipush($_POST['select_ids'],$login_name);
			if($result){
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"400","msg":"操作失败"}';
			}
		}
		//推送
		public function pushFabu(){
			if(!isset($_POST['select_ids']) || empty($_POST['select_ids'])){
				echo '{"status":"400","msg":"参数为空"}';return;
			}
			$login_name=trim(getLoginName());
			if(empty($login_name)){
				echo '{"status":"400","msg":"请重新登录"}';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->pushOpenapipush($_POST['select_ids'],$login_name);
			if($result){
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"400","msg":"操作失败"}';
			}
		}
		//真实房源
		public function setTrueFabu(){
			if(!isset($_POST['select_ids']) || empty($_POST['select_ids'])){
				echo '{"status":"400","msg":"参数为空"}';return;
			}
			$login_name=trim(getLoginName());
			if(empty($login_name)){
				echo '{"status":"400","msg":"请重新登录"}';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->setTrueOpenapipush($_POST['select_ids'],$login_name);
			if($result){
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"400","msg":"操作失败"}';
			}
		}

	/*百姓接口API */	
	public function fabulistbaixing(){
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
	        
	        $handleLogic=new \Logic\OpenapiLogic();
	        $viewList = array();
	        //查询条件
	        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
	        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
	        $condition['startTime_create']=isset($_GET['startTime_create'])?$_GET['startTime_create']:"";
	        $condition['endTime_create']=isset($_GET['endTime_create'])?$_GET['endTime_create']:"";
	        $condition['estateName']=isset($_GET['estateName'])?$_GET['estateName']:"";
	        $condition['roomNo']=isset($_GET['roomNo'])?$_GET['roomNo']:"";
	        $condition['business_type']=isset($_GET['business_type'])?$_GET['business_type']:"";
	        $condition['clientPhone']=isset($_GET['clientPhone'])?$_GET['clientPhone']:"";
	        $condition['create_man']=isset($_GET['create_man'])?$_GET['create_man']:"";
	        $condition['update_man']=isset($_GET['update_man'])?$_GET['update_man']:"";//操作人
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['moneyMin']=I('get.moneyMin');
	        $condition['moneyMax']=I('get.moneyMax');
	        $condition['brand_type']=isset($_GET['brand_type'])?$_GET['brand_type']:"";

	        $condition['region']=isset($_GET['region'])?$_GET['region']:"";
	        $condition['scope']=isset($_GET['scope'])?$_GET['scope']:"";
	        $condition['isAgent']=I('get.isAgent');
	        $condition['isComm']=I('get.isComm');
	        $condition['isMonth']=I('get.isMonth');
	        $condition['rentType']=I('get.rentType');
	        $condition['roomName']=I('get.roomName');
	        $hadCondition=false;
	        foreach ($condition as $k1 => $v1) {
	        	if(!empty($v1)){
	        		$hadCondition=true;
	        		break;
	        	}
	        }
	        if($hadCondition){
	        	$condition['roomStatus']="2";
	        	$page_count=100;

	        	$list = $handleLogic->getNotfabuList_baixing($condition,0,$page_count);
	        	//整理列表数据
	        	$i=1;
	        	foreach ($list as $key => $value) {
	        		array_push($viewList, array('ident_num' => $i,'room_id' => $value['id'],'info_resource'=>$value['info_resource'],'client_phone' => $value['client_phone'],'house_no' => $value['house_no'],'room_no' => $value['room_no'],'estate_name' => $value['estate_name'],'business_type' => $value['business_type'],'room_name'=>$value['room_name'],'room_area'=>$value['room_area'],'room_money'=>$value['room_money'],
	        			'region_scope' => $value['region_name'].'-'.$value['scope_name'],'unit_no' => $value['unit_no'],'shi_no' => $value['shi_no'],'status'=>$value['status'],'update_time' => date('Y-m-d',$value['update_time']),'update_man' => $value['update_man'],'create_man' => $value['create_man'],'total_count' => $value['total_count'],'up_count' => $value['up_count'],'record_status'=>$value['record_status']));
	        		$i++;
	        	}
	        }
	        
	        /*查询条件（业务类型）*/
	        $handleResource=new \Logic\HouseResourceLogic();
	        $result=$handleResource->getResourceParameters();
		if($result !=null && $result !=false){
			$typeString='';//业务类型
			$brandString='<option value="none">无</option><option value="all">有</option>';//品牌
			foreach ($result as $key => $value) {
				if($value['info_type']==15){
					$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}else if($value['info_type']==16){
					$brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}
			}	
			$this->assign("businessTypeList",$typeString);
			$this->assign("brandTypeList",$brandString);
		}
		/*查询条件（房间负责人）*/
	        $result=$handleResource->getHouseHandleList();
		$createmanString='';
		foreach ($result as $key => $value) {
			$createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
		}	
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
		$this->assign("createManList",$createmanString);
		/*查询条件（区域板块）*/
		$regionResult=$handleResource->getRegionList();
		if($regionResult !=null){
			$regionList='';
			foreach ($regionResult as $key => $value) {
				$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
			}	
			$this->assign("regionList",$regionList);
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
		$this->assign("scopeList",$scopeList);
    	$this->assign("list",$viewList);
		$this->display();
	}
	//读取百姓帐号
	public function getBaixingAccount(){
		if(I('get.handle')=="getcnt"){
			$handleLogic=new \Home\Model\openapipush();
			$accounts=$handleLogic->getBaixingAccount();
			if(false===$accounts || null===$accounts || count($accounts)===0){
				echo '';return;
			}
			$accountOption='';
			foreach ($accounts as $key => $value) {
				$accountOption.='<label style="float:left;width:110px;height:36px;line-height:36px;"><input type="checkbox" name="userid[]" value="'.$value["userid"].'">'.$value["userid"].'</label>';
			}
			echo $accountOption;
		}
		
	}
	//提交发布
	public function submitFabu_baixing(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		$bx_account=I('post.bx_account');
		if(empty($select_ids) || empty($bx_account)){
			echo '参数错误';return;
		}
		$handle=new \Logic\OpenapiLogic();
		$count=$handle->addOpenapipushMore_baixing($select_ids,$login_name,explode(',', $bx_account));
		echo '成功发布'.$count.'套房间';
	}
	//删除发布
	public function removeFabu_baixing(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		if(empty($select_ids)){
			echo '参数错误';return;
		}
		$handleLogic=new \Logic\OpenapiLogic();
		$result=$handleLogic->deleteOpenapipush($select_ids,$login_name,2);
		if($result){
			echo '操作成功';
		}else{
			echo '操作失败';
		}
	}
	//已经发布 list（百姓网）
	public function hadfabulistbaixing(){
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
        
        $list = array();
        $pageSHow='';
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['startTime_create']=I('get.startTime_create');
        $condition['endTime_create']=I('get.endTime_create');
        $condition['roomStatus']=I('get.roomStatus');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['update_man']=trim(I('get.update_man'));
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['is_recommend']=I('get.is_recommend');
        $condition['is_true']=I('get.is_true');
        $condition['startTime_fabu']=I('get.startTime_fabu');
        $condition['endTime_fabu']=I('get.endTime_fabu');
         $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['pagecount']=I('get.pagecount');
        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);

        if(isset($_GET['roomNo']) || $totalCount>0){
        	$handleLogic=new \Logic\OpenapiLogic();
        	if(I('get.p')==''){
        	  $totalCount=$handleLogic->getModelListCount_baixing($condition);
        	} 
        	if($totalCount>0){
		        $Page= new \Think\Page($totalCount,100);//分页
		        $condition['pagecount']=$totalCount;
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $pageSHow=$Page->show();
	        	$list = $handleLogic->getModelList_baixing($condition,$Page->firstRow,$Page->listRows);
        	}
        }
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->assign("pageSHow",$pageSHow);
		$this->display();
	}
			
	/*搜房接口API */	
	public function fabulistsoufang(){
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
        $condition['estateName']=trim(I('get.estateName'));
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['isAgent']=I('get.isAgent');
        $condition['isComm']=I('get.isComm');
        $condition['isMonth']=I('get.isMonth');
        $condition['rentType']=I('get.rentType');
        $condition['roomName']=I('get.roomName');
        $condition['totalnum']=I('get.totalnum');
		$hadCondition=false;
        foreach ($condition as $k1 => $v1) {
        	if(!empty($v1)){
        		$hadCondition=true;
        		break;
        	}
        }
        $list=array();$pageSHow='';
        if($hadCondition){
        	$handleLogic=new \Logic\OpenapiLogic();
        	if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['region'])){
        	    $condition['totalnum'] = $handleLogic->getFabuCount($condition);
        	}
        	if($condition['totalnum']>0){
        	    $Page= new \Think\Page($condition['totalnum'],100);//分页
        	    foreach($condition as $key=>$val) {
        	        $Page->parameter[$key]=urlencode($val);
        	    }
        	    $pageSHow=$Page->show();
        	    $list = $handleLogic->getFabuList($condition,$Page->firstRow,$Page->listRows);
        	}
        }
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
		/*查询条件（区域板块）*/
		$handleResource=new \Logic\HouseResourceLogic();
		$regionList='';
		$regionResult=$handleResource->getRegionList();
		if($regionResult !=null){
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
    	$this->assign("list",$list);
    	$this->assign("pageSHow",$pageSHow);
    	$this->assign("totalnum",$condition['totalnum']);
		$this->display();
	}
	//读取帐号
	public function getSoufangAccount(){
		if(I('get.handle')=="getcnt"){
			$handleLogic=new \Home\Model\openapipush();
			$accounts=$handleLogic->getSoufangAccount();
			if(false===$accounts || null===$accounts || count($accounts)===0){
				echo '';return;
			}
			$accountOption='';
			foreach ($accounts as $key => $value) {
				$accountOption.='<label style="float:left;width:110px;height:36px;line-height:36px;"><input type="checkbox" name="userid[]" value="'.$value["userid"].'">'.$value["userid"].'</label>';
			}
			echo $accountOption;
		}
		
	}
	//提交发布
	public function submitFabu_soufang(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		$account=I('post.account');
		if(empty($select_ids) || empty($account)){
			echo '参数错误';return;
		}
		$handle=new \Logic\OpenapiLogic();
		$count=$handle->addOpenapipushMore_soufang($select_ids,$login_name,explode(',', $account));
		echo '成功发布'.$count.'套房间';
	}
	//删除发布
	public function removeFabu_soufang(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		if(empty($select_ids)){
			echo '参数错误';return;
		}
		$handleLogic=new \Logic\OpenapiLogic();
		$result=$handleLogic->deleteOpenapipush($select_ids,$login_name,3);
		if($result){
			echo '操作成功';
		}else{
			echo '操作失败';
		}
	}
	//已经发布 list 
	public function hadfabulistsoufang(){
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
        
        $list = array();
        $pageSHow='';
        //查询条件
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        $condition['startTime_create']=I('get.startTime_create');
        $condition['endTime_create']=I('get.endTime_create');
        $condition['roomStatus']=I('get.roomStatus');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['update_man']=trim(I('get.update_man'));
        $condition['info_resource_type']=I('get.info_resource_type');
        $condition['info_resource']=I('get.info_resource');
        $condition['is_recommend']=I('get.is_recommend');
        $condition['is_true']=I('get.is_true');
        $condition['startTime_fabu']=I('get.startTime_fabu');
        $condition['endTime_fabu']=I('get.endTime_fabu');
         $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['pagecount']=I('get.pagecount');
        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);

        if(isset($_GET['roomNo']) || $totalCount>0){
        	$handleLogic=new \Logic\OpenapiLogic();
        	if(I('get.p')==''){
        	  $totalCount=$handleLogic->getModelListCount_soufang($condition);
        	} 
        	if($totalCount>0){
		        $Page= new \Think\Page($totalCount,100);//分页
		        $condition['pagecount']=$totalCount;
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $pageSHow=$Page->show();
	        	$list = $handleLogic->getModelList_soufang($condition,$Page->firstRow,$Page->listRows);
        	}
        }
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->assign("pageSHow",$pageSHow);
		$this->display();
	}
/*公共方法 start */
	//读取帐号
	public function getOpenapiAccounts(){
		$third_type=I('get.third_type');
		if(I('get.handle')=="getcnt" && $third_type!=''){
			$handleLogic=new \Home\Model\openapipush();
			$accounts=$handleLogic->getAccountByType($third_type);
			if(false==$accounts || null==$accounts || count($accounts)==0){
				echo '';return;
			}
			$accountOption='';
			foreach ($accounts as $key => $value) {
				$accountOption.='<label style="float:left;width:110px;height:36px;line-height:36px;"><input type="checkbox" name="userid[]" value="'.$value["userid"].'">'.$value["userid"].'</label>';
			}
			echo $accountOption;
		}else{
			echo '';
		}
	}
	//提交发布
	public function submitFabuByType(){
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		$account=I('post.account');
		$third_type=I('post.third_type');
		if(empty($select_ids) || empty($account) || empty($third_type)){
			echo '参数错误';return;
		}
		$handle=new \Logic\OpenapiLogic();
		$count=$handle->addOpenapipushMoreByType($third_type,$select_ids,$login_name,explode(',', $account),'$room_description$',0,'');
		echo '成功发布'.$count.'套房间';
	}
	//删除发布
	public function removeFabuByType(){
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '会话失效，重新登录。';return;
		}
		$select_ids=I('post.select_ids');
		$third_type=I('post.third_type');
		if(empty($select_ids) || empty($third_type)){
			echo '参数错误';return;
		}
		$handleLogic=new \Logic\OpenapiLogic();
		$result=$handleLogic->deleteOpenapipush($select_ids,$login_name,$third_type);
		if($result){
			echo '操作成功';
		}else{
			echo '操作失败';
		}
	}
/*公共方法 end */

		/* 58品牌馆  */	
		public function fabulistWubabrand(){
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
	        
	        $handleLogic=new \Logic\OpenapiLogic();
	        $viewList = array();
	        //查询条件
	        $condition['startTime']=I('get.startTime');
	        $condition['endTime']=I('get.endTime');
	        $condition['startTime_create']=I('get.startTime_create');
	        $condition['endTime_create']=I('get.endTime_create');
	        $condition['estateName']=I('get.estateName');
	        $condition['roomNo']=I('get.roomNo');
	        $condition['business_type']=I('get.business_type');
	        $condition['clientPhone']=I('get.clientPhone');
	        $condition['create_man']=I('get.create_man');
	        $condition['update_man']=I('get.update_man');
	        $condition['info_resource_type']=I('get.info_resource_type');
			$condition['info_resource']=I('get.info_resource');
	        $condition['brand_type']=I('get.brand_type');
	        $condition['region']=I('get.region');
	        $condition['scope']=I('get.scope');
	         $condition['roomareaMin']=I('get.roomareaMin');
        	 $condition['roomareaMax']=I('get.roomareaMax');
        	 $condition['moneyMin']=I('get.moneyMin');
	        $condition['moneyMax']=I('get.moneyMax');
	        $condition['isAgent']=I('get.isAgent');
	        $condition['isComm']=I('get.isComm');
	        $condition['isMonth']=I('get.isMonth');
	        $condition['rentType']=I('get.rentType');
	        $condition['roomName']=I('get.roomName');
	        $hadCondition=false;
	        foreach ($condition as $k1 => $v1) {
	        	if(!empty($v1)){
	        		$hadCondition=true;
	        		break;
	        	}
	        }
	        if($hadCondition){
	        	$condition['roomStatus']="2";

	        	$page_count=100;
	        	
	        	$list = $handleLogic->getNotfabuListByType(4,$condition,0,$page_count);
	        	//整理列表数据
	        	$i=1;
	        	foreach ($list as $key => $value) {
	        		array_push($viewList, array('ident_num' => $i,'room_id' => $value['id'],'info_resource'=>$value['info_resource'],'client_phone' => $value['client_phone'],'house_no' => $value['house_no'],'room_no' => $value['room_no'],'estate_name' => $value['estate_name'],'business_type' => $value['business_type'],'room_name'=>$value['room_name'],'room_area'=>$value['room_area'],'room_money'=>$value['room_money'],
	        			'region_scope' => $value['region_name'].'-'.$value['scope_name'],'unit_no' => $value['unit_no'],'shi_no' => $value['shi_no'],'status'=>$value['status'],'update_time' => date('Y-m-d',$value['update_time']),'update_man' => $value['update_man'],'create_man' => $value['create_man'],'total_count' => $value['total_count'],'up_count' => $value['up_count'],'record_status'=>$value['record_status']));
	        		$i++;
	        	}
	        }
	        
	        /*查询条件（业务类型）*/
	        $handleResource=new \Logic\HouseResourceLogic();
	        $result=$handleResource->getResourceParameters();
			if($result !=null && $result !=false){
				$typeString='';//业务类型
				$brandString='<option value="none">无</option><option value="all">有</option>';//品牌
				foreach ($result as $key => $value) {
					if($value['info_type']==15){
						$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					}else if($value['info_type']==16){
						$brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					}
				}	
				$this->assign("businessTypeList",$typeString);
				$this->assign("brandTypeList",$brandString);
			}
			/*查询条件（房间负责人）*/
		    $result=$handleResource->getHouseHandleList();
			$createmanString='';
			if($result !=null && $result !=false){
				foreach ($result as $key => $value) {
					$createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
				}	
			}
			//数据来源
		$this->bindInforesource($condition['info_resource_type']);
			$this->assign("createManList",$createmanString);
			/*查询条件（区域板块）*/
			$regionList='';
			$regionResult=$handleResource->getRegionList();
			if($regionResult!=null && $regionResult!=false){
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
	    	$this->assign("list",$viewList);
			$this->display();
		}
		
		//提交发布
		public function submitFabu_wubabrand(){
			$login_name=getLoginName();
			if(empty($login_name)){
				echo '会话失效，重新登录。';return;
			}
			$select_ids=I('post.select_ids');
			$account=I('post.account');
			if(empty($select_ids) || empty($account)){
				echo '参数错误';return;
			}
			$handle=new \Logic\OpenapiLogic();
			$count=$handle->addOpenapipushMoreByType(4,$select_ids,$login_name,explode(',', $account),'$room_description$',3,'');
			echo '成功发布'.$count.'套房间';
		}
		//删除发布
		public function removeFabu_wubabrand(){
			$login_name=getLoginName();
			if(empty($login_name)){
				echo '会话失效，重新登录。';return;
			}
			$select_ids=I('post.select_ids');
			if(empty($select_ids)){
				echo '参数错误';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->deleteOpenapipush($select_ids,$login_name,4);
			if($result){
				echo '操作成功';
			}else{
				echo '操作失败';
			}
		}
		//已经发布 list（58品牌馆）
		public function hadfabulistWubabrand(){
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
	        
	        $list = array();
	        $pageSHow='';
	        //查询条件
	        $condition['startTime']=I('get.startTime');
	        $condition['endTime']=I('get.endTime');
	        $condition['startTime_create']=I('get.startTime_create');
	        $condition['endTime_create']=I('get.endTime_create');
	        $condition['roomStatus']=I('get.roomStatus');
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['update_man']=trim(I('get.update_man'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['is_recommend']=I('get.is_recommend');
	        $condition['is_true']=I('get.is_true');
	        $condition['startTime_fabu']=I('get.startTime_fabu');
	        $condition['endTime_fabu']=I('get.endTime_fabu');
	         $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['pagecount']=I('get.pagecount');
	        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);

	        if(isset($_GET['roomNo']) || $totalCount>0){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if(I('get.p')==''){
	        	  $totalCount=$handleLogic->getModelListCountByType(4,$condition);
	        	} 
	        	if($totalCount>0){
			        $Page= new \Think\Page($totalCount,100);//分页
			        $condition['pagecount']=$totalCount;
			        foreach($condition as $key=>$val) {
			            $Page->parameter[$key]=urlencode($val);
			        }
			        $pageSHow=$Page->show();
		        	$list = $handleLogic->getModelListByType(4,$condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
	        $this->assign("list",$list);
	        $this->assign("totalCount",$totalCount);
	        $this->assign("pageSHow",$pageSHow);
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

	/* 淘房365  */	
		public function fabulist365(){
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
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['moneyMin']=trim(I('get.moneyMin'));
	        $condition['moneyMax']=trim(I('get.moneyMax'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['region']=I('get.region');
	        $condition['scope']=I('get.scope');
	        $condition['isAgent']=I('get.isAgent');
	        $condition['isComm']=I('get.isComm');
        $condition['isMonth']=I('get.isMonth');
        $condition['rentType']=I('get.rentType');
        $condition['roomName']=I('get.roomName');
	        $condition['totalnum']=I('get.totalnum');
			$hadCondition=false;
	        foreach ($condition as $k1 => $v1) {
	        	if(!empty($v1)){
	        		$hadCondition=true;
	        		break;
	        	}
	        }
	        $list=array();$pageSHow='';
	        if($hadCondition){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['region'])){
	        	    $condition['totalnum'] = $handleLogic->getFabuCount($condition);
	        	}
	        	if($condition['totalnum']>0){
	        	    $Page= new \Think\Page($condition['totalnum'],100);//分页
	        	    foreach($condition as $key=>$val) {
	        	        $Page->parameter[$key]=urlencode($val);
	        	    }
	        	    $pageSHow=$Page->show();
	        	    $list = $handleLogic->getFabuList($condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
			/*查询条件（区域板块）*/
			$handleResource=new \Logic\HouseResourceLogic();
			$regionList='';
			$regionResult=$handleResource->getRegionList();
			if($regionResult !=null){
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
	    	$this->assign("list",$list);
	    	$this->assign("pageSHow",$pageSHow);
	    	$this->assign("totalnum",$condition['totalnum']);
			$this->display();
		}
		
		//提交发布
		public function submitFabu_365(){
			$login_name=getLoginName();
			if(empty($login_name)){
				echo '会话失效，重新登录。';return;
			}
			$select_ids=I('post.select_ids');
			$account=I('post.account');
			if(empty($select_ids) || empty($account)){
				echo '参数错误';return;
			}
			$handle=new \Logic\OpenapiLogic();
			$count=$handle->addOpenapipushMoreByType(5,$select_ids,$login_name,explode(',', $account),'$room_description$',0,'');
			echo '成功发布'.$count.'套房间';
		}
		//删除发布
		public function removeFabu_365(){
			$login_name=getLoginName();
			if(empty($login_name)){
				echo '会话失效，重新登录。';return;
			}
			$select_ids=I('post.select_ids');
			if(empty($select_ids)){
				echo '参数错误';return;
			}
			$handleLogic=new \Logic\OpenapiLogic();
			$result=$handleLogic->deleteOpenapipush($select_ids,$login_name,5);
			if($result){
				echo '操作成功';
			}else{
				echo '操作失败';
			}
		}
		//已经发布 list
		public function hadfabulist365(){
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
	        $condition['roomStatus']=I('get.roomStatus');
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['update_man']=trim(I('get.update_man'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	
	        $condition['startTime_fabu']=I('get.startTime_fabu');
	        $condition['endTime_fabu']=I('get.endTime_fabu');
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['pagecount']=I('get.pagecount');
	        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);
	        $list = array();
	        $pageSHow='';
	        if(isset($_GET['roomNo']) || $totalCount>0){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if(I('get.p')==''){
	        	  $totalCount=$handleLogic->getModelListCountByType(5,$condition);
	        	} 
	        	if($totalCount>0){
			        $Page= new \Think\Page($totalCount,100);//分页
			        $condition['pagecount']=$totalCount;
			        foreach($condition as $key=>$val) {
			            $Page->parameter[$key]=urlencode($val);
			        }
			        $pageSHow=$Page->show();
		        	$list = $handleLogic->getModelListByType(5,$condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
	        $this->assign("list",$list);
	        $this->assign("totalCount",$totalCount);
	        $this->assign("pageSHow",$pageSHow);
			$this->display();
		}

		/*无线搜房 start */
		public function fabulistsoufangWifi(){
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
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['moneyMin']=trim(I('get.moneyMin'));
	        $condition['moneyMax']=trim(I('get.moneyMax'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['region']=I('get.region');
	        $condition['scope']=I('get.scope');
	        $condition['isAgent']=I('get.isAgent');
	        $condition['isComm']=I('get.isComm');
        $condition['isMonth']=I('get.isMonth');
        $condition['rentType']=I('get.rentType');
        $condition['roomName']=I('get.roomName');
	        $condition['totalnum']=I('get.totalnum');
			$hadCondition=false;
	        foreach ($condition as $k1 => $v1) {
	        	if(!empty($v1)){
	        		$hadCondition=true;
	        		break;
	        	}
	        }
	        $list=array();$pageSHow='';
	        if($hadCondition){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['region'])){
	        	    $condition['totalnum'] = $handleLogic->getFabuCount($condition);
	        	}
	        	if($condition['totalnum']>0){
	        	    $Page= new \Think\Page($condition['totalnum'],100);//分页
	        	    foreach($condition as $key=>$val) {
	        	        $Page->parameter[$key]=urlencode($val);
	        	    }
	        	    $pageSHow=$Page->show();
	        	    $list = $handleLogic->getFabuList($condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
			/*查询条件（区域板块）*/
			$handleResource=new \Logic\HouseResourceLogic();
			$regionList='';
			$regionResult=$handleResource->getRegionList();
			if($regionResult !=null){
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
	    	$this->assign("list",$list);
	    	$this->assign("pageSHow",$pageSHow);
	    	$this->assign("totalnum",$condition['totalnum']);
			$this->display();
		}
		public function hadfabulistsoufangWifi(){
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
	        $condition['roomStatus']=I('get.roomStatus');
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['update_man']=trim(I('get.update_man'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	
	        $condition['startTime_fabu']=I('get.startTime_fabu');
	        $condition['endTime_fabu']=I('get.endTime_fabu');
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['pagecount']=I('get.pagecount');
	        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);
	        $list = array();
	        $pageSHow='';
	        if(isset($_GET['roomNo']) || $totalCount>0){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if(I('get.p')==''){
	        	  $totalCount=$handleLogic->getModelListCountByType(7,$condition);
	        	} 
	        	if($totalCount>0){
			        $Page= new \Think\Page($totalCount,100);//分页
			        $condition['pagecount']=$totalCount;
			        foreach($condition as $key=>$val) {
			            $Page->parameter[$key]=urlencode($val);
			        }
			        $pageSHow=$Page->show();
		        	$list = $handleLogic->getModelListByType(7,$condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
	        $this->assign("list",$list);
	        $this->assign("totalCount",$totalCount);
	        $this->assign("pageSHow",$pageSHow);
			$this->display();
		}
		/*无线搜房 end */


		/*
		* 赶集  
		*/
		public function fabulistganji(){
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
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	        $condition['moneyMin']=trim(I('get.moneyMin'));
	        $condition['moneyMax']=trim(I('get.moneyMax'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['region']=I('get.region');
	        $condition['scope']=I('get.scope');
	        $condition['isAgent']=I('get.isAgent');
	        $condition['isComm']=I('get.isComm');
        $condition['isMonth']=I('get.isMonth');
        $condition['rentType']=I('get.rentType');
        $condition['roomName']=I('get.roomName');
	        $condition['totalnum']=I('get.totalnum');
			$hadCondition=false;
	        foreach ($condition as $k1 => $v1) {
	        	if(!empty($v1)){
	        		$hadCondition=true;
	        		break;
	        	}
	        }
	        $list=array();$pageSHow='';
	        if($hadCondition){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if((I('get.p')=='' || empty($condition['totalnum'])) && isset($_GET['region'])){
	        	    $condition['totalnum'] = $handleLogic->getFabuCount($condition);
	        	}
	        	if($condition['totalnum']>0){
	        	    $Page= new \Think\Page($condition['totalnum'],100);//分页
	        	    foreach($condition as $key=>$val) {
	        	        $Page->parameter[$key]=urlencode($val);
	        	    }
	        	    $pageSHow=$Page->show();
	        	    $list = $handleLogic->getFabuList($condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
			/*查询条件（区域板块）*/
			$handleResource=new \Logic\HouseResourceLogic();
			$regionList='';
			$regionResult=$handleResource->getRegionList();
			if($regionResult !=null){
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
	    	$this->assign("list",$list);
	    	$this->assign("pageSHow",$pageSHow);
	    	$this->assign("totalnum",$condition['totalnum']);
			$this->display();
		}
		public function hadfabulistganji(){
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
	        $condition['roomStatus']=I('get.roomStatus');
	        $condition['roomNo']=trim(I('get.roomNo'));
	        $condition['update_man']=trim(I('get.update_man'));
	        $condition['info_resource_type']=I('get.info_resource_type');
	        $condition['info_resource']=I('get.info_resource');
	
	        $condition['startTime_fabu']=I('get.startTime_fabu');
	        $condition['endTime_fabu']=I('get.endTime_fabu');
	        $condition['estateName']=trim(I('get.estateName'));
	        $condition['clientPhone']=trim(I('get.clientPhone'));
	        $condition['pagecount']=I('get.pagecount');
	        $totalCount=$condition['pagecount']==''?0:intval($condition['pagecount']);
	        $list = array();
	        $pageSHow='';
	        if(isset($_GET['roomNo']) || $totalCount>0){
	        	$handleLogic=new \Logic\OpenapiLogic();
	        	if(I('get.p')==''){
	        	  $totalCount=$handleLogic->getModelListCountByType(9,$condition);
	        	} 
	        	if($totalCount>0){
			        $Page= new \Think\Page($totalCount,100);//分页
			        $condition['pagecount']=$totalCount;
			        foreach($condition as $key=>$val) {
			            $Page->parameter[$key]=urlencode($val);
			        }
			        $pageSHow=$Page->show();
		        	$list = $handleLogic->getModelListByType(9,$condition,$Page->firstRow,$Page->listRows);
	        	}
	        }
			//数据来源
			$this->bindInforesource($condition['info_resource_type']);
	        $this->assign("list",$list);
	        $this->assign("totalCount",$totalCount);
	        $this->assign("pageSHow",$pageSHow);
			$this->display();
		}
	
		
}	
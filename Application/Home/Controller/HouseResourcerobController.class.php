<?php
namespace Home\Controller;
use Think\Controller;
class HouseResourcerobController extends Controller {
	//房源列表
	public function resourcelist(){
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
		
		$handleLogic=new \Logic\HouseResourcerobLogic();
		$viewList = array();
		$totalCount =0;
        //查询条件
		$condition['startTime']=I('get.startTime');
		$condition['endTime']=I('get.endTime');
		$condition['estateName']=trim(I('get.estateName'));
		$condition['clientPhone']=trim(I('get.clientPhone'));
		$condition['info_resource']=I('get.info_resource');

		$condition['region']=I('get.region');
		$condition['scope']=I('get.scope');
		$condition['moneyMin']=trim(I('get.moneyMin'));
		$condition['moneyMax']=trim(I('get.moneyMax'));
		$condition['room_type']=I('get.room_type');
		$condition['room_num']=I('get.room_num');
		if(isset($_GET['phoneStatus'])){
			$condition['phoneStatus']=I('get.phoneStatus');
		}else{
			$condition['phoneStatus']='0';
		}
		
		$condition['upType']='0';
		$totalCountModel = $handleLogic->getModelListCount($condition);
		if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
        	$totalCount=$totalCountModel[0]['totalCount'];//总条数
        	$Page= new \Think\Page($totalCount,7);//分页
        	foreach($condition as $key=>$val) {
        		$Page->parameter[$key]=urlencode($val);
        	}
        	$this->assign("pageSHow",$Page->show());
        	$viewList = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }else{
        	$totalCount=0;
        	$this->assign("pageSHow","");
        }
        /*查询条件（区域板块）*/
        $regionList='';
        $handleproductLogic=new \Logic\HouseResourceLogic();
        $result=$handleproductLogic->getRegionList();
        if($result !=null){
        	foreach ($result as $key => $value) {
        		$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        	}	
        }
        $scopeList='<option value=""></option>';
        if(!empty($condition['region'])){
			//查询后，重新加载板块信息
        	$result=$handleproductLogic->getRegionScopeList();
        	foreach ($result as $key => $value) {
        		if($condition['region']==$value['parent_id']){
        			$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        		}
        	}
        }
		$this->assign("infoResourceList",getHouseInfoResourcelist());//数据来源
		$this->assign("regionList",$regionList);
		$this->assign("scopeList",$scopeList);
		$this->assign("list",$viewList);
		$this->assign("totalcnt",$totalCount);
		$this->display();
	}
	public function modifyClientphone(){
		$loginName=trim(getLoginName());
		if($loginName==''){
			echo '{"status":"400","message":"请重新登录"}';return;
		}
		$resource_id=trim(I('post.resource_id'));
		$client_phone=trim(I('post.client_phone'));
		if($resource_id=='' || $client_phone==''){
			echo '{"status":"400","message":"数据异常"}';return;
		}
		//判断黑名单
		$handle=new \Home\Model\blacklist();
		$blackModel=$handle->getBlacklistrobByMobile($client_phone);
		$handle=new \Home\Model\houseresourcerob();
		if($blackModel!=null && $blackModel!=false){
			$result=$handle->updateModel(array('id'=>$resource_id,'record_status'=>0,'client_phone'=>$client_phone,'phone_status'=>0,'modifyphone_name'=>$loginName,'modifyphone_time'=>time()));
		}else{
			$result=$handle->updateModel(array('id'=>$resource_id,'client_phone'=>$client_phone,'phone_status'=>0,'modifyphone_name'=>$loginName,'modifyphone_time'=>time()));
		}
		if($result){
			echo '{"status":"200","message":"更新成功"}';
		}else{
			echo '{"status":"400","message":"更新失败"}';
		}
	}
	public function resourcelistV2(){
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
		
		$handleLogic=new \Logic\HouseResourcerobLogic();
		$viewList = array();
		$totalCount =0;
        //查询条件
		$condition['startTime']=I('get.startTime');
		$condition['endTime']=I('get.endTime');
		$condition['estateName']=trim(I('get.estateName'));
		$condition['clientPhone']=trim(I('get.clientPhone'));
		$condition['info_resource']=I('get.info_resource');

		$condition['region']=I('get.region');
		$condition['scope']=I('get.scope');
		$condition['moneyMin']=trim(I('get.moneyMin'));
		$condition['moneyMax']=trim(I('get.moneyMax'));
		$condition['room_type']=I('get.room_type');
		$condition['room_num']=I('get.room_num');
		if(isset($_GET['phoneStatus'])){
			$condition['phoneStatus']=I('get.phoneStatus');
		}else{
			$condition['phoneStatus']='0';
		}
		$condition['upType']=1;
		$totalCountModel = $handleLogic->getModelListCount($condition);
		if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
        	$totalCount=$totalCountModel[0]['totalCount'];//总条数
        	$Page= new \Think\Page($totalCount,7);//分页
        	foreach($condition as $key=>$val) {
        		$Page->parameter[$key]=urlencode($val);
        	}
        	$this->assign("pageSHow",$Page->show());
        	$viewList = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }else{
        	$totalCount=0;
        	$this->assign("pageSHow","");
        }
        /*查询条件（区域板块）*/
        $regionList='';
        $handleproductLogic=new \Logic\HouseResourceLogic();
        $result=$handleproductLogic->getRegionList();
        if($result !=null){
        	foreach ($result as $key => $value) {
        		$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        	}	
        }
        $scopeList='<option value=""></option>';
        if(!empty($condition['region'])){
			//查询后，重新加载板块信息
        	$result=$handleproductLogic->getRegionScopeList();
        	foreach ($result as $key => $value) {
        		if($condition['region']==$value['parent_id']){
        			$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        		}
        	}
        }
		$this->assign("infoResourceList",getHouseInfoResourcelist());//数据来源
		$this->assign("regionList",$regionList);
		$this->assign("scopeList",$scopeList);
		$this->assign("list",$viewList);
		$this->assign("totalcnt",$totalCount);
		$this->display();
	}

	//根据区域查找板块列表
	public function getScopes(){
		if(isset($_GET['region_id'])){
			$handleLogic=new \Logic\HouseResourceLogic();
			$result=$handleLogic->getRegionScopeList();
			$scopeList='<option value=""></option>';
			foreach ($result as $key => $value) {
				if($_GET['region_id']==$value['parent_id']){
					$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
				}
			}
			echo $scopeList;
		}else{
			echo '';
		}
	}
	public function getRoomTypelist($type){
		$roomtypeString=getRoomTypelistByType($type);
		echo $roomtypeString;
	}
	/*查找房东下面已有房源数量 */
   public function getHouseCountByPhone(){
   		$mobile=I('get.mobile');
   		if(empty($mobile)){
   			echo '{"id":"","count":"0"}';return;
   		}
   		$dal=new \Home\Model\houseresourcerob();
   		$result=$dal->getHouseCountByPhone($mobile);
   		if($result===false || $result===null){
   			echo '{"id":"","count":"0"}';
   		}else{
   			echo '{"id":"'.$result[0]['cid'].'","count":"'.$result[0]['cnt'].'"}';
   		}
   }
   /*检查是否签约房东 */
   public function checkSignedUser(){
   		$id=I('get.customer_id');
   		if(empty($id)){
   			echo '';return;
   		}
   		$dal=new \Home\Model\houseresourcerob();
   		$result=$dal->getCustomerInfoByCustomerid($id);
   		if($result!==false && $result!==null && count($result)>0 && $result[0]['signed']==1){
   			echo '签约房东';
   		}else{
   			echo '';
   		}
   }
   //检查是否佣金房东 
   public function checkCommissionUser(){
   		$mobile=I('get.mobile');
   		if(empty($mobile)){
   			echo '';return;
   		}
   		$modelDal=new \Home\Model\commissionfd();
   		$result=$modelDal->getCommissionByWhere(" where client_phone='$mobile' and is_open=1");
   		if($result!=null && count($result)>0){
   			echo '是';
   		}else{
   			echo '';
   		}
   }
   /*判断是否有地铁线路 */
   public function checkHadSubway(){
   		$estate_id=I('get.estate_id');
   		if(empty($estate_id)){
   			echo '';return;
   		}
   		$dal=new \Home\Model\subway();
   		$result=$dal->getOneSubwayByEstateid($estate_id);
   		if($result!=null && count($result)>0){
   			echo '有地铁';
   		}else{
   			echo '';
   		}
   }
   /*加入黑名单 */
	public function addBlackList(){
		$mobile=I('get.mobile');
		$resource_id=I('get.resource_id');
		if(empty($mobile) || empty($resource_id)){
			echo '{"status":"400","msg":"参数异常"}';return;
		}
		$handleLogic=new \Logic\BlackListLogic();
		$result=$handleLogic->getModelByMobile($mobile);
		if($result===false || $result===null){
			$blackModel['id']=guid();
			$blackModel['mobile']=$mobile;
			$blackModel['no_login']=1;
			$blackModel['no_post_replay']=1;
			$blackModel['no_call']=1;
			$blackModel['out_house']=1;
			$blackModel['create_time']=time();
			$blackModel['update_time']=time();
			$handleLogic->addModel($blackModel);
		}
		$handleLogic=new \Logic\HouseResourcerobLogic();
		$result=$handleLogic->deleteModelById($resource_id);
		if($result){
			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"400","msg":"操作失败"}';
		}
	}
	/*获取400号码 */
	public function getFourHundredCode(){
		$mobile=I('get.mobile');
		$resource_id=I('get.resource_id');
		if(empty($mobile) || empty($resource_id)){
			echo '参数异常';return;
		}
		if(!C('TEL_DISPLAY')){
			echo '';return;
		}
		$handleLogic=new \Logic\HouseRoomrobLogic();
		$roomModel=$handleLogic->getModelByResourceId($resource_id);
		if($roomModel===false || $roomModel===null){
			echo '数据异常';return;
		}
		$result=true;
		if(empty($roomModel['room_no'])){
			$roomModel['room_no']=$this->createRoomno();
			$result=$handleLogic->updateModel($roomModel);
		}
		if($result){
			$handleCode=new \Logic\PhoneCodeLogic();
			$code=$handleCode->get400Code(array('mobile'=>$mobile,'room_id'=>$roomModel['id'],'room_no'=>$roomModel['room_no'],'city_id'=>C('CITY_CODE'),'info_resource'=>$roomModel['info_resource']));
			echo $code;
		}else{
			echo '获取失败';
		}

	}
	private function createRoomno(){
		$no=C('CITY_PREX').date("Ymd",time());
		$time_array = explode(' ', microtime ());
		$no =$no.substr($time_array[0], 2,4).substr($time_array[1],5);
		return $no;
	}
	//加载房源的配置参数信息
	public function loadResourceParameter(){
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->getResourceParameters();
		if($result !=null){
			$businessTypeString='';//业务类型
			$decorationString='';//装修情况
			$paymethodString='';//付款方式
			$roomtypeString='';//房间类型
			$publicequipmentString='';// 共用设施
			$housetypeString='';//房屋类型
			$clientloveString='';//房东喜欢
			$housedirectionString='';//朝向
			$clientageString='';//年龄段
			$brandtypeString='';//品牌
			$room_equipment='';//房间设施
			foreach ($result as $key => $value) {
				switch ($value['info_type']) {
					case 0:
					$decorationString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 1:
					$paymethodString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 2:
						$roomtypeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 3:
					$publicequipmentString.='<label><input type="checkbox" name="public_equipment[]" value="'.$value["type_no"].'">'.$value["name"].'</label>&nbsp;&nbsp;';
					break;
					case 4:
					$housetypeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 5:
					$clientloveString.='<label><input type="checkbox" name="client_love[]" value="'.$value["type_no"].'">'.$value["name"].'</label>&nbsp;&nbsp;';
					break;
					case 10:
					$housedirectionString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 9:
					$clientageString.='<label><input type="radio" name="client_age" value="'.$value["type_no"].'"/>'.$value["name"].'</label>&nbsp;&nbsp;';
					break;
					case 15:
					$businessTypeString.='<label><input type="radio" name="business_type" value="'.$value["type_no"].'" />'.$value["name"].'</label>&nbsp;&nbsp;';
					break;
					case 16:
					$brandtypeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
					break;
					case 11:
						$room_equipment.='<label><input type="checkbox" name="room_equipment[]" value="'.$value["type_no"].'">'.$value["name"].'</label>&nbsp;&nbsp;';
						break;
					default:
					break;
				}
			}
			$this->assign("businessTypeList",$businessTypeString);
			$this->assign("decorationList",$decorationString);
			$this->assign("payMethodList",$paymethodString);
			$this->assign("roomTypeList",$roomtypeString);
			$this->assign("publicEquipmentList",$publicequipmentString);
			$this->assign("houseTypeList",$housetypeString);
			$this->assign("clientLoveList",$clientloveString);
			$this->assign("houseDirectionList",$housedirectionString);
			$this->assign("clientAgeList",$clientageString);
			$this->assign("brandTypeList",$brandtypeString);
			$this->assign("room_equipment",$room_equipment);
		}
	}
	//检索小区
	public function searchestate(){
		if($_GET['keyword']=='' || $_GET['type']==''){
			echo '{"status":"404","msg":"fail"}';
			return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->getEstateNameByKeywordV2($_GET['keyword'],$_GET['type']);
		if($result==null){
			echo '{"status":"404","msg":"fail"}';
		}else{
			$jsonString=json_encode($result);
			echo '{"status":"200","msg":"success","data":'.$jsonString.'}';
		}
	}
	//检查黑名单用户
	public function checkBlackUser(){
		if(isset($_GET['mobile']) && !empty($_GET['mobile'])){
			$handleLogic=new \Logic\BlackListLogic();
			$result=$handleLogic->getModelByMobile($_GET['mobile']);
			if($result!=null && $result!=false){
				echo '{"status":"404","msg":"此房东是黑名单用户，不能上架黑名单用户房源"}';
			}else{
				echo '{"status":"200","msg":"success"}';
			}
		}else{
			echo '{"status":"200","msg":"success"}';
		}
		
	}
	//提交保存房源（之前检查数据）
	public function checkAddResourceInfo(){
		$estate_name=trim(I('get.estate_name'));
		if(empty($estate_name)){
			echo '{"status":"400","msg":"小区名称不能为空"}';return;
		}
		//检查黑名单用户
		$client_phone=I('get.client_phone');
		if(!empty($client_phone)){
			$handleBlack=new \Logic\BlackListLogic();
			$blackModel=$handleBlack->getModelByMobile($client_phone);
			if($blackModel!=null && $blackModel!=false){
				echo '{"status":"404","msg":"此房东是黑名单用户，不能上架黑名单用户房源"}';return;
			}
		}
		$jsonString='""';
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->getEstateModelByNameV2($estate_name,$_GET['type']);
		if($result==null || $result==false){
			echo '{"status":"400","msg":"楼盘不存在"}';return;
		}
		$estate_id=I('get.estate_id');
		if($estate_id=="" && count($result)>1){
			echo '{"status":"400","msg":"楼盘里面有多个小区名称，请具体选择一个"}';return;
		}
		$change_estate=true;
		foreach ($result as $key => $value) {
			if($value['id']==$estate_id){
				$change_estate=false;break;
			}
		}
		if($change_estate){
			echo '{"status":"400","msg":"小区名称已经改变，请在下拉选择后提交。"}';return;
		}
		$jsonString=json_encode($result);
		echo '{"status":"200","msg":"success","data":'.$jsonString.'}';
		/*$countResult = $handleLogic->getHouseCountByClientPhone($client_phone);
		if($countResult>1){
			//房东手机号下面有多套房源
			echo '{"status":"200","msg":"warn","data":'.$jsonString.'}';
		}else{
			
		}*/
	}
	//上传图片
	public function uploadClientImage(){
		$picname = $_FILES['mypic']['name'];
		$picsize = $_FILES['mypic']['size'];
		if ($picname != "") {
			$picname_arr = explode('.', $picname);
			$type=$picname_arr[count($picname_arr)-1];
			$type_lower=strtolower($type);
			if ($type_lower != "gif" && $type_lower != "jpg" && $type_lower != "jpeg" && $type_lower != "png") {
				echo '文件必须是图片格式！';
				exit;
			}
			if ($picsize > 1024000*5) {
				echo '图片大小不能超过5M';
				exit;
			}
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand .'.'. $type;
			//上传路径
			if($picsize>256000){
				$imgbinary=$this->compressionImage($_FILES['mypic']['tmp_name'],$type);
				$imgData = base64_encode($imgbinary);
			}else{
				$imgbinary = file_get_contents($_FILES['mypic']['tmp_name']);
				$imgData = base64_encode($imgbinary);
			}
			$result = $this->uploadImageToServer("xxx",$pics,$imgData);
			echo $result;
		}
	}
	/*压缩图片*/
	public function compressionImage($file,$pictype){
		$percent = 0.5;  //图片压缩比
		if(strtolower($pictype)=="png"){
			$src_im = imagecreatefrompng($file);
		}else{
			$src_im = imagecreatefromjpeg($file);
		}
		$width = imagesx ( $src_im );
		$height = imagesy ( $src_im ); //获取原图尺寸
		//缩放尺寸
		$newwidth = $width*$percent;
		$newheight = $height*$percent;
		
		$dst_im = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//输出压缩后的图片
		ob_start ();
		if(strtolower($pictype)=="png"){
			imagepng($dst_im);
		}else{
			imagejpeg($dst_im);
		}
		$data = ob_get_contents ();
		ob_end_clean ();
		imagedestroy($dst_im);
		imagedestroy($src_im);
		return $data;
	}
	//上传图片到服务器
	public function uploadImageToServer($relationId,$fileName,$imgData){
	    // post提交
		$post_data = array ();
		$post_data ['relationId'] = $relationId;
		$post_data ['fileName'] = $fileName;
		$post_data ['data']=$imgData;
		$post_data ['fileSize'] = "10000";
		$url =C("IMG_SERVICE_URL").'head/web/upload';
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
		$return_result = curl_exec ( $ch );
	}
	//删除房源
	public function removeResource(){
		$loginName=trim(getLoginName());
		if($loginName==''){
			echo '{"status":"201","msg":"请重新登录"}';return;
		}
		$resource_id=trim(I('get.resource_id'));
		if(empty($resource_id)){
			echo '{"status":"202","msg":"参数异常"}';return;
		}
		$handleLogic=new \Logic\HouseResourcerobLogic();
		//房屋信息
    	$resourceModel=$handleLogic->getModelById($resource_id);
    	if($resourceModel==null || $resourceModel==false){
    		echo '{"status":"203","msg":"房源信息读取失败"}';return;
		}
		if($resourceModel['record_status']==0){
			echo '{"status":"204","msg":"房源已经被删除了"}';return;
		}
		if($resourceModel['update_man']!="" && trim($resourceModel['update_man'])!=$loginName){
			echo '{"status":"205","msg":"房源已经被其他人处理"}';return;
		}
		$result=$handleLogic->deleteModelById($resource_id);
		if($result){
			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"400","msg":"操作失败"}';
		}
	}

	/*简化抓取上房流程（合二为一） */
	public function uprobhouse(){
		header ( "Content-type: text/html; charset=utf-8" );
		$loginName=trim(getLoginName());
		$resourceId=I('get.resource_id');
		if(empty($loginName)){
			echo '非法操作';return;
		}
		if(empty($resourceId)){
			echo '参数错误';return;
		}
		/*房屋信息 */
		$handleLogic=new \Logic\HouseResourcerobLogic();
    	$resourceModel=$handleLogic->getModelById($resourceId);
    	if($resourceModel ===null || $resourceModel ===false){
    		echo '房源信息读取失败';return;
		}
		if($resourceModel['record_status']==0){
			echo '房源已经被删除了';return;
		}
		if($resourceModel['update_man']!="" && trim($resourceModel['update_man'])!=$loginName){
			echo '房源已经被其他人处理';return;
		}
		$roomLogic=new \Logic\HouseRoomrobLogic();
		$roomModel=$roomLogic->getModelByResourceId($resourceId);
		if($roomModel===null || $roomModel===false){
			echo '房间信息读取失败';return;
		}
		//更新处理人
		$resourceModel['update_man']=$loginName;
		$resourceModel['update_time']=time();
		$handleLogic->updateModel($resourceModel);
		$handleCommonCache=new \Logic\CommonCacheLogic();
		$switchcity=$handleCommonCache->cityauthority();
		$this->assign("switchcity",$switchcity);
        //菜单权限
		$handleMenu = new\Logic\AdminMenuListLimit();
		$menu_top_html=$handleMenu->menuTop($loginName,"3");
		$menu_left_html=$handleMenu->menuLeft($loginName,"3");
		$this->assign("menutophtml",$menu_top_html);
		$this->assign("menulefthtml",$menu_left_html);
		//房东信息
		/*$resourceModel['client_sex']='';
		$resourceModel['client_age']='';
		$resourceModel['client_love']='';*/
		if(!empty($resourceModel['client_phone'])){
			$handleCustomer=new \Logic\CustomerLogic();
			$customerModel=$handleCustomer->getResourceClientByPhone($resourceModel['client_phone']);
			if($customerModel !==null && $customerModel!==false){
				$resourceModel['client_phone']=$customerModel['mobile'];
				$resourceModel['client_name']=$customerModel['true_name'];
				//$resourceModel['client_sex']=$customerModel['sex'];
				//$resourceModel['client_age']=$customerModel['age'];
				/*$handleOwnerinfo=new \Logic\HouseOwnerinfoLogic();
				$ownerinfoModel=$handleOwnerinfo->getModelByCustomerId($customerModel['id']);
				if($ownerinfoModel !==null && $ownerinfoModel!==false){
					$resourceModel['client_love']=$ownerinfoModel['owner_love'];
				}*/
			}
		}
		$resourceModel['estate_id']='';
		$this->assign("resourceModel",$resourceModel);
		$this->loadResourceParameter();
		/*房间信息 */
		$this->assign('roomNames',getRoomNamelistByType('1501'));
		//读取图片信息
		$imgString="";
		$handleImg=new \Logic\HouseImgrobLogic();
		$imgList=$handleImg->getModelByRoomId($roomModel['id']);
		if($imgList !==null && $imgList!==false){
			foreach ($imgList as $key => $value) {
				$imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
				//$corp_imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"]."_200_130.".$value["img_ext"];
				$imgString.='<li><img src="'.$imgUrl.'" alt=""><br/><a href="javascript:;" onclick="removePic(\''.$value["id"].'\',this)">删除</a>&nbsp;<a href="'.__CONTROLLER__.'/downloadImage?img_id='.$value["id"].'">下载</a><br/><label><input type="radio" value="'.$value["id"].','.$imgUrl.'" name="main_img">封面</label></li>';
			}
		}
		$this->assign("imgString",$imgString);
		$this->assign("roomModel",$roomModel);
		$this->display();
	}
	//提交
	public function submitUprobhouse(){
		header ( "Content-type: text/html; charset=utf-8" );
		$handleCommonCache=new \Logic\CommonCacheLogic();
		if(!$handleCommonCache->checkcache()){
			return $this->error('非法操作',U('Index/index'),1);
		}
		if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
			return $this->uploadImage();
		}
		if(!isset($_POST['resource_id']) || empty($_POST['resource_id'])){
			return $this->error('房源参数错误',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		if(!isset($_POST['room_id']) || empty($_POST['room_id'])){
			return $this->error('房间参数错误',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		$main_img=I('post.main_img');
		$main_imgnew=I('post.main_imgnew');
		if(empty($main_imgnew) && empty($main_img)){
			return $this->error('房间封面图错误',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		$handleLogic=new \Logic\HouseResourcerobLogic();
		$data=$handleLogic->getModelById($_POST['resource_id']);
		if($data ===null || $data===false || $data['record_status']==0){
			return $this->error('房源信息读取失败',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		$roomrobLogic=new \Logic\HouseRoomrobLogic();
		$room_data=$roomrobLogic->getModelById($_POST['room_id']);
		if($room_data===null || $room_data===false){
			return $this->error('房间信息读取失败',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		#更新图片信息
		$handleImage=new \Logic\HouseImgLogic();
		$had_upload_imgs=$handleImage->getModelByRoomId($room_data['id']);
		if($had_upload_imgs!=null && count($had_upload_imgs)>0){
			//已经下载重新上传，只需切换主图
			if($main_imgnew==''){
				$room_data['main_img_id']=$had_upload_imgs[0]['id'];
				$room_data['main_img_path']=C("IMG_SERVICE_URL").$had_upload_imgs[0]["img_path"].$had_upload_imgs[0]["img_name"].".".$had_upload_imgs[0]["img_ext"];
			}else{
				$main_img_array=explode(",", $main_imgnew);
				$room_data['main_img_id']=$main_img_array[0];
				$room_data['main_img_path']=$main_img_array[1];
			}
			$handleImage->updateMainimg($room_data['main_img_id']);
			
		}else{
			//没有下载重新上传，文件拷贝
			$handleImagerob=new \Logic\HouseImgrobLogic();
			$img_list=$handleImagerob->getModelByRoomId($room_data['id']);
			$main_img_id='';$main_img_path='';
			if($img_list !=null){
				$main_img_array=explode(",", $main_img);
				foreach ($img_list as $key => $value) {
					$imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
					ob_clean();
					ob_start();
					readfile($imgUrl);
					$img_room_data = ob_get_contents();
					ob_end_clean();
				    $result = $this->uploadRoomImage($room_data['id'],$value["img_name"].".".$value["img_ext"],base64_encode($img_room_data));
				    if($main_img_array[0]==$value['id']){
				    	//记录主图
				    	$upload_success =json_decode($result,true);
				    	if($upload_success['status']=="200"){
		    		    	$room_data['main_img_id']=$upload_success['data']['imgId'];
		    			    $room_data['main_img_path']=$upload_success['data']['imgUrl'];
		    			    $main_img_id=$room_data['main_img_id'];
		    			    $main_img_path=$room_data['main_img_path'];
		    			    $handleImage->updateMainimg($room_data['main_img_id']);
				    	}
				    }else if(empty($main_img_id)){
    			    	$upload_success =json_decode($result,true);
    			    	if($upload_success['status']=="200"){
    	    			    $main_img_id=$upload_success['data']['imgId'];
    	    			    $main_img_path=$upload_success['data']['imgUrl'];
    			    	}
				    }
				}
			}
			if($main_img_id!=''){
				//同步上传图片，主图上传失败，取一张作为主图
		    	$room_data['main_img_id']=$main_img_id;
			    $room_data['main_img_path']=$main_img_path;
			    $handleImage->updateMainimg($room_data['main_img_id']);
			}else{
				//没有一张图片提交成功，返回提醒
				return $this->error('图片提交失败',U('HouseResourcerob/resourcelist?no=3&leftno=81'),3);
			}
		}
		//房源信息
		$data['business_type']=I('post.business_type');
		$data['estate_id']=I('post.estate_id');
		$data['estate_name']=trim(I('post.estate_name'));
		$data['region_id']=I('post.region');
		$data['scope_id']=I('post.scope');
		$data['unit_no']=trim(I('post.unit_no'));
		$data['area']=trim(I('post.area'));
		$data['room_no']=trim(I('post.room_no'));
		$data['floor']=trim(I('post.floor'));
		if(empty($data['floor'])){
			$data['floor']=0;
		}
		$data['floor_total']=trim(I('post.floor_total'));
		if(empty($data['floor_total'])){
			$data['floor_total']=0;
		}
		$data['room_num']=trim(I('post.room_num'));
		if(empty($data['room_num'])){
			$data['room_num']=0;
		}
		$data['hall_num']=trim(I('post.hall_num'));
		if(empty($data['hall_num'])){
			$data['hall_num']=0;
		}
		$data['wei_num']=trim(I('post.wei_num'));
		if(empty($data['wei_num'])){
			$data['wei_num']=0;
		}
		//$data['house_type']=I('post.house_type');
		//$data['house_direction']=I('post.house_direction');
		$data['decoration']=I('post.decoration');
		$data['pay_method']=I('post.pay_method');
	
		$data['rent_type']=I('post.rent_type');
		$data['is_cut']=I('post.is_cut');
		if($data['rent_type']==1){
			$data['room_type']='0201';
			if($data['is_cut']==1){
				$data['room_type']='0203';
			}
		}elseif($data['rent_type']==2){
			$data['room_type']='0205';
		}

		$data['brand_type']='';
		$data['public_equipment']=implode(",", I('post.public_equipment'));//共用设施
		//房东信息
		$client_phone=trim(I('post.client_phone'));
		$client_name=trim(I('post.client_name'));

		$data['client_name']=$client_name;
		$data['client_phone']=$client_phone;
		if(empty($data['estate_name']) || empty($data['area']) || empty($data['pay_method']) || empty($data['client_phone'])){
			return $this->error('房源数据不完整',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		//房间信息
		unset($room_data['ext_score']);
		unset($room_data['ext_identity']);
		unset($room_data['original_img_urls']);
		$room_data['room_name']=I('post.room_name');
		$room_data['room_area']=trim(I('post.room_area'));
		$room_data['room_money']=trim(I('post.room_money'));
		$room_data['low_price']=$room_data['room_money'];
		$room_data['room_direction']=I('post.room_direction');
		$room_data['room_equipment']=implode(",", I('post.room_equipment'));
		$room_data['room_description']=replaceHousePlatformName(trim(I('post.room_description')));
		$room_data['room_bak']=trim(I('post.room_bak'));
		$room_data['girl_tag']=I('post.girl_tag');
		$room_data['update_time']=time();
		$room_data['update_man']=getLoginName();
		$room_data['status']=2;
		if($room_data['status']==2){
			$room_data['up_count']=1;
		}
		if(empty($room_data['room_name']) || empty($room_data['room_area']) || empty($room_data['room_money']) || empty($room_data['status'])){
			return $this->error('房间数据不完整',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
		}
		$data['rental_type']=isset($_POST['rental_type'])?$_POST['rental_type']:0;//出租类型
		//城市
		$city_code=C('CITY_CODE');
		$handleCustomerLogic=new \Logic\CustomerLogic();
		$clientModel = $handleCustomerLogic->getResourceClientByPhone($client_phone);
		$isowner_flag=3;
		if($clientModel!==null && $clientModel!==false){
			$isowner_flag=$clientModel['is_owner'];
			//update
			$clientModel['true_name']=$client_name;
			$clientModel['mobile']=$client_phone;
			if($data['rental_type']=='1' && $isowner_flag!=4){
				$clientModel['is_owner']=3;//个人转租
				$clientModel['is_renter']=1;
			}else if($data['rental_type']=='4' && $isowner_flag!=4){
				$clientModel['is_owner']=3;//房东直租
			}
			if($clientModel['city_code']==""){
				$clientModel['city_code']=$city_code;
			}
			$data['is_owner']=$clientModel['is_owner'];
			$handleCustomerLogic->updateModel($clientModel);
			$data['customer_id']=$clientModel['id'] ;
			$data['is_auth']=$clientModel['is_auth'];//是否良心房东
			/*判断是否包月房东 */
			if($clientModel['is_monthly']==1 && $clientModel['monthly_start']<=time() && $clientModel['monthly_end']>=time()){
				$room_data['is_monthly']=1;
			}
		}else{
			//add
			$customerData['id']=guid();
			$customerData['true_name']=$client_name;
			$customerData['mobile']=$client_phone;
			//$customerData['sex']=$client_sex;
			//$customerData['age']=$client_age;
			$customerData['is_renter']=0;
			$customerData['create_time']=time();
			$customerData['is_owner']=3;
			$data['is_owner']=3;
			if($data['rental_type']=='1'){
				$customerData['is_renter']=1;//个人转租
			}
			$customerData['city_code']=$city_code;
			$customerData['gaodu_platform']=3;
			$handleCustomerLogic->addModel($customerData);
			$data['customer_id']=$customerData['id'];
		}
		$data['update_time']=time();
		$data['update_man']=getLoginName();
		//获取区域、板块名称
		$handleproductLogic=new \Logic\HouseResourceLogic();
		$region_scope = $handleproductLogic->getRegionScopeName($data['region_id'],$data['scope_id']);
		if($region_scope!==null && $region_scope!==false){
			foreach ($region_scope as $key => $value) {
				if($data['region_id']==$value['id']){
					$data['region_name']=$value['cname'];
				}else{
					$data['scope_name']=$value['cname'];
				}
			}
		}
		if(!isset($data['house_no']) || empty($data['house_no'])){
			$data['house_no']=$handleproductLogic->createHouseno();
		}
		if(!isset($data['create_man']) || empty($data['create_man'])){
			$data['create_man']=$data['update_man'];
			$data['create_time']=time();
		}
		$customerinfoLogic=new \Logic\CustomerInfo();
		if($data['rental_type']=='3' && $isowner_flag!=4){
			//加入到职业房东
		    $result=$customerinfoLogic->addOwnerForCustomerinfo(array('mobile'=>'','customer_id'=>$data['customer_id'],'source'=>'上房添加','update_man'=>$data['update_man'],'update_time'=>$data['update_time'],'region_id'=>$data['region_id'],'region_name'=>$data['region_name']));
			if($result){
				$data['is_owner']=4;
			}
		}
		#2016/11/9,店铺房源更新
		$handleStoreHouses=new \Home\Model\storehouses();
		$member_array=$handleStoreHouses->getStoremembers("customer_id='".$data['customer_id']."' and is_special=1");
		if($member_array!=null && $member_array!=false && count($member_array)>0){
			$data_store_house['store_id']=$member_array[0]['store_id'];
			$data_store_house['store_name']=$member_array[0]['store_name'];
			$data_store_house['room_id']=$room_data['id'];
			$data_store_house['house_id']=$room_data['resource_id'];
			$data_store_house['customer_id']=$data['customer_id'];
			$handleStoreHouses->addStorehouses($data_store_house);
			$data['store_id']=$data_store_house['store_id'];
			$room_data['store_id']=$data_store_house['store_id'];
		}
		$data['info_resource_type']=1;
		$room_data['info_resource_type']=1;
		unset($data['estate_address']);
		unset($data['uproom_type']);
		unset($data['phone_status']);
		unset($data['modifyphone_name']);
		unset($data['modifyphone_time']);
		$update_result=$handleproductLogic->addModel($data);//生产环境，新增房源数据
		if($update_result){
			$data['record_status']=0;//删除
			unset($data['store_id']);
			$rentType_flag=$data['rent_type'];
			unset($data['rent_type']);
			unset($data['is_cut']);
			unset($data['is_owner']);
			unset($data['info_resource_type']);
			$handleLogic->updateModel($data);
			//更新房间信息
			$roomLogic=new \Logic\HouseRoomLogic();
			if(empty($room_data['room_no'])){
				$room_data['room_no']=$roomLogic->createRoomno();
			}
			if(empty($room_data['create_man'])){
				$room_data['create_man']=$room_data['update_man'];
				$room_data['create_time']=time();
			}
			//佣金处理
			$room_data['is_commission']=0;
			$commissionId_min=0;
			$handleCommissionLogic=new \Logic\CommissionLogic();
			$commissionlist=$handleCommissionLogic->getCommissionSelectlist($data['client_phone']);
			if($commissionlist!=null && count($commissionlist)>0){
				$commissionlist=multi_array_sort($commissionlist,'commission_money');
				if($commissionlist!==false){
					$commissionId_min=$commissionlist[0]['commmission_id'];
				}
			}
			if($commissionId_min>0){
				$room_data['is_commission']=1;
			}
			//新增房间到生产环境
			if($city_code!='001001'){
				$room_data['show_reserve_bar']=1;
			}
			if($city_code=='001009001' && $room_data['room_money']>=5000 && $rentType_flag==2 && !isset($room_data['is_monthly']) && in_array($data['region_id'], array(2,7,14,24,43,108))){
				$room_data['show_call_bar']=0;
			}elseif($city_code=='001009001' && $room_data['room_money']<2000 && !isset($room_data['is_monthly']) && $room_data['is_commission']!=1){
				$room_data['show_call_bar']=1;
				$room_data['show_reserve_bar']=0;
			}
			if($city_code=='001019002' && in_array($data['region_id'], array(1,6,7,8,9,10))){
				$room_data['show_call_bar']=1;
				$room_data['show_reserve_bar']=0;
			}
			$room_data['customer_id']=$data['customer_id'];
			
			//房东负责人
			$customerinfoModel=$customerinfoLogic->getPrincipalByCustomerid($data['customer_id']);
			$is_baozhang=0;
			if($customerinfoModel!==false){
				$room_data['principal_man']=$customerinfoModel['principal_man'];
				if($customerinfoModel['margin']>0){
					$is_baozhang=1;
				}
			}
			$insert_result=$roomLogic->addModel($room_data);//生产环境，新增房间数据
			if($insert_result){
	
				if($room_data['status']==2){
					//操作房间查询表
					$handleSelect=new \Logic\HouseSelectLogic();
					$handleSelect->addModel($room_data['id'],$is_baozhang);
				}
				if($room_data['is_commission']==1){
					//添加佣金
					$commissionDal=new \Home\Model\commission();
					$commissionfdDal=new \Home\Model\commissionfd();
					//$commid_array=$_POST['commissionId'];
					//$commid_count=count($commid_array);
					for ($i=0; $i < 1; $i++) { 
						/*if($i>=10 || empty($commid_array[$i])){
							break;
						}*/
						$is_commission=0;
						$commissionData=$commissionfdDal->getCommissionByWhere(" where id=".$commissionId_min);
						if($commissionData!==null && $commissionData!==false && count($commissionData)>0){
							$commDetails=$commissionfdDal->getDetailsByCommissionId($commissionData[0]['id']);
							if($commDetails!==null && $commDetails!==false && count($commDetails)>0){
								$is_commission=1;
							}
						}
						if($is_commission==0){
							continue;
						}
						$commissionId=$commissionDal->addModel(array('room_id'=>$room_data['id'],'room_no'=>$room_data['room_no'],'room_status'=>$room_data['status'],'room_money'=>$room_data['room_money'],'estate_name'=>$data['estate_name'],'client_phone'=>$data['client_phone'],
							'client_name'=>$data['client_name'],'contracttime_start'=>$commissionData[0]['contracttime_start'],'contracttime_end'=>$commissionData[0]['contracttime_end'],
							'is_open'=>1,'create_time'=>$data['update_time'],'create_man'=>$data['update_man'],'update_time'=>$data['update_time'],'update_man'=>$data['update_man'],'city_code'=>$data['city_code']));
						if($commissionId>0){
							$commissionDal->addDetail(array('commission_id'=>$commissionId,'commission_type'=>$commDetails[0]['commission_type'],
									'commission_money'=>$commDetails[0]['commission_money'],'commission_base'=>$commDetails[0]['commission_base'],
									'is_online'=>$commDetails[0]['is_online'],'settlement_method'=>$commDetails[0]['settlement_method'],
									'start_time'=>$commDetails[0]['start_time'],'create_time'=>$data['update_time'],'create_man'=>$data['update_man']));
						}
					}			
				}
				echo '操作成功';
			}

		}
		
	}
	//上传图片
	public function uploadImage(){
		if(isset($_FILES['mypic'])){
			$imgCount=count($_FILES['mypic']['name']);
			$uploadcount=isset($_POST['uploadcount'])?$_POST['uploadcount']:0;
			if($imgCount+$uploadcount>9){
				echo '最多上传9张图片！';
				exit;
			}
			//已经上传的图片数组
			$upload_array=array();
			for ($i=0; $i < $imgCount; $i++) { 
				$picname = $_FILES['mypic']['name'][$i];
				$picsize = $_FILES['mypic']['size'][$i];
				if ($picname != "") {
					$picname_arr = explode('.', $picname);
					$type=$picname_arr[count($picname_arr)-1];
					$type_lower=strtolower($type);
					if ($type_lower != "gif" && $type_lower != "jpg" && $type_lower != "jpeg" && $type_lower != "png") {
						echo '文件必须是图片格式！';
						exit;
					}
					if ($picsize > 1024000*5 || $picsize < 10000) {
						echo '图片大小不能超过5M和小于10K';
						exit;
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand .'.'. $type;
					//上传路径
					if($picsize>128000){
					    $imgbinary=$this->compressionImage($_FILES['mypic']['tmp_name'][$i],$type);
						$imgData = base64_encode($imgbinary);
					}else{
						$imgbinary = file_get_contents($_FILES['mypic']['tmp_name'][$i]);
			        	$imgData = base64_encode($imgbinary);
					}
				    $result = $this->uploadRoomImage($_POST['room_id'],$pics,$imgData);
					$upload_success =json_decode($result,true);
					if($upload_success['status']=="200"){
						array_push($upload_array, array('imgUrl' => $upload_success['data']['imgUrl'],'imgId' => $upload_success['data']['imgId'] ));
					}
				}
			}
			$return_result='{"data":'.json_encode($upload_array).'}';
			echo $return_result;
		}
		
	}
	//上传图片到服务器
	public function uploadRoomImage($room_id,$fileName,$imgData){
	    // post提交
	    $post_data = array ();
	    $post_data ['relationId'] = $room_id;
	    $post_data ['fileName'] = $fileName;
	    $post_data ['data']=$imgData;
	    $post_data ['fileSize'] = "10000";
	    $url =C("IMG_SERVICE_URL").'house/web/upload';
	    $o = "";
	    foreach ( $post_data as $k => $v ) {
	      $o .= "$k=" . urlencode ( $v ) . "&";
	    }
	    $post_data = substr ( $o, 0, - 1 );
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_POST, 1 );
	    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
	    $data = curl_exec ( $ch );
	    curl_close($ch);
	    return $data;
	}
	//下载图片
	public function downloadImage(){
		if(isset($_GET['img_id'])){
			$handleImg=new \Logic\HouseImgrobLogic();
			$image_model=$handleImg->getModelById($_GET['img_id']);
			if($image_model !=null){
				$img_url=C("IMG_ROB_URL").$image_model["img_path"].$image_model["img_name"].".".$image_model["img_ext"];
				$file_name=$image_model["img_name"].".".$image_model["img_ext"];
				Header( "Content-type:image/jpeg"); 
				Header( "Content-Disposition:attachment;filename=$file_name"); 
				ob_clean();
				ob_start();
				readfile($img_url);
				$img = ob_get_contents();
				ob_end_clean();
				echo $img;
			}
		}	
	}

	//新增中介，加入过滤中介库、删除抓取房源
	public function addAgentOutrob(){
		$loginName=trim(getLoginName());
		if($loginName==''){
			echo '{"status":"400","message":"请重新登录"}';return;
		}
		$mobile=trim(I('post.mobile'));
		if($mobile==''){
			echo '{"status":"400","message":"参数异常"}';return;
		}
		$robDal=new \Home\Model\houseresourcerob();
		$data['id']=guid();
		$data['mobile']=$mobile;
		$data['create_time']=time();
		$data['update_time']=time();
		$data['oper_name']=$loginName;
		$data['bak_info']='抓取上房添加中介';
		$data['bak_type']=4;
		$robDal->addBlacklistrob($data);
		$robDal->deleteModelByClientphone($mobile);
		echo '{"status":"200","message":"操作成功"}';
	}
}

?>
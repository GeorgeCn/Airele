<?php
namespace Home\Controller;
use Think\Controller;
class HouseResourceController extends Controller {
	//房源列表
	public function resourcelist(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
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

        $condition['estateName']=trim(I('get.estateName'));
        $condition['clientName']=trim(I('get.clientName'));
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['houseNo']=trim(I('get.houseNo'));
        $condition['business_type']=I('get.business_type');
		$condition['info_resource_type']=I('get.info_resource_type');
		$condition['info_resource']=I('get.info_resource');

        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['create_man']=trim(I('get.create_man'));
        $condition['house_state']="";
       $condition['totalCount']=I('get.totalCount');
       $totalCount=$condition['totalCount']==''?0:intval($condition['totalCount']);
        $handleLogic=new \Logic\HouseResourceLogic();
        $viewList = array();
        $pageSHow='';
		if(I('get.p')=='' && I('get.handle')=='query'){
           $totalCountModel = $handleLogic->getModelListCount($condition);
           if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
           	  $totalCount=$totalCountModel[0]['totalCount'];//总条数
           }
        } 
        if($totalCount>0){
    	    $Page= new \Think\Page($totalCount,10);//分页
    	    $condition['totalCount']=$totalCount;
    	    foreach($condition as $key=>$val) {
    	        $Page->parameter[$key]=urlencode($val);
    	    }
    	    $pageSHow=$Page->show();
    		$list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
    		$i=1;
    		//整理列表数据
    		foreach ($list as $key => $value) {
    			array_push($viewList, array('id' => $value['id'],'ident_num' => $i,'house_no' => $value['house_no'],'estate_name' => $value['estate_name'],'business_type' => $value['business_type'],
    				'region_scope' => $value['region_name'].'-'.$value['scope_name'],'unit_no' => $value['unit_no'],'room_no' => $value['room_no'],
    				'room_hall_wei' => $value['room_num'].'室'.$value['hall_num'].'厅'.$value['wei_num'].'卫','room_count' => $value['room_count'],'info_resource'=>$value['info_resource'],
    				'client_name' => $value['client_name'],'update_time' => date('Y-m-d',$value['update_time']),'update_man' => $value['update_man'],'create_man' => $value['create_man'],'info_resource_url'=>$value['info_resource_url'] ));
    			$i++;
    		}
        }
        
        /*查询条件（业务类型）*/
        $result=$handleLogic->getResourceParameters();
		if($result!=null){
			$typeString='';//业务类型
			foreach ($result as $key => $value) {
				if($value['info_type']==15){
					$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}
			}	
			$this->assign("businessTypeList",$typeString);
		}
		/*查询条件（区域板块）*/
		$result=$handleLogic->getRegionList();
		if($result !=null){
			$regionList='';
			foreach ($result as $key => $value) {
				$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
			}	
			$this->assign("regionList",$regionList);
		}
		$scopeList='<option value=""></option>';
		if(!empty($condition['region'])){
			//查询后，重新加载板块信息
			$result=$handleLogic->getRegionScopeList();
			foreach ($result as $key => $value) {
				if($condition['region']==$value['parent_id']){
					$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
				}
			}
		}
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
		$this->assign("scopeList",$scopeList);
        $this->assign("list",$viewList);
        $this->assign("totalCount",$totalCount);
        $this->assign("pageSHow",$pageSHow);
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
	//获取二级来源
	public function getInforesourceByType(){
		$type=I('get.type');
		if(empty($type)){
			echo '';return; 
		}
		$result_array=getTwoInforesource($type);
		$info='';
		foreach ($result_array as $key => $value) {
			$info.='<option value="'.$key.'">'.$value.'</option>';
		}
		echo $info;
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
	//添加房源
	public function addresource(){
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
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $resourceModel=null;
        if(isset($_GET['resource_id'])){
        	$handleLogic=new \Logic\HouseResourceLogic();
        	$resourceModel=$handleLogic->getModelById($_GET['resource_id']);//房源信息
        	if($resourceModel !=null){
        		if($resourceModel['record_status']==0){
        			//had delete
        			return $this->error('房源已经被删除了',U('HouseResource/resourcelist'),1);
        		}
 				//房东信息
 				$resourceModel['client_telephone']='';
				$resourceModel['client_sex']='';
				$resourceModel['client_age']='';
				$resourceModel['client_image']='';
				$resourceModel['client_love']='';
 				$handleCustomer=new \Logic\CustomerLogic();
 				$customerModel=$handleCustomer->getResourceClientById($resourceModel['customer_id']);
 				if($customerModel !=null){
 					$resourceModel['client_phone']=$customerModel['mobile'];
 					$resourceModel['client_telephone']=$customerModel['telephone'];
 					$resourceModel['client_name']=$customerModel['true_name'];
 					$resourceModel['client_sex']=$customerModel['sex'];
 					$resourceModel['client_age']=$customerModel['age'];
 					$resourceModel['client_image']=$customerModel['img_path'];
 					$handleOwnerinfo=new \Logic\HouseOwnerinfoLogic();
 					$ownerinfoModel=$handleOwnerinfo->getModelByCustomerId($resourceModel['customer_id']);
 					if($ownerinfoModel !=null){
 						$resourceModel['client_love']=$ownerinfoModel['owner_love'];
 					}
 				}
        	}
        	
        	//数据来源
        	$this->bindInforesource($resourceModel['info_resource_type']);
        }else{
        	
        	$this->assign("infoResourceTypeList",'<option value="5">BD</option>');
        	$this->assign("infoResourceList",'<option value="BD">BD</option>');
        }
        $this->assign("resourceModel",$resourceModel);
		$this->loadResourceParameter();
		
		$this->display();
	}
	public function getRoomTypelist($type){
		echo $roomtypeString=getRoomTypelistByType($type);
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
			$room_equipment='';
			foreach ($result as $key => $value) {
				switch ($value['info_type']) {
					case 0:
						$decorationString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
						break;
					case 1:
						$paymethodString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
						break;
					case 2:
						//$roomtypeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
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
					case 11:
						$room_equipment.='<label><input type="checkbox" name="room_equipment[]" value="'.$value["type_no"].'">'.$value["name"].'</label>&nbsp;&nbsp;';
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
					default:
						break;
				}
			}
			$this->assign("businessTypeList",$businessTypeString);
			$this->assign("decorationList",$decorationString);
			$this->assign("payMethodList",$paymethodString);
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
		$keyword=trim(I('get.keyword'));
		if(empty($keyword)){
			echo '{"status":"404","msg":"fail"}';
			return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->getEstateNameByKeywordV2($keyword,I('get.type'));
		if($result==null){
			echo '{"status":"404","msg":"fail"}';
		}else{
			$jsonString=json_encode($result);
			echo '{"status":"200","msg":"success","data":'.$jsonString.'}';
		}
	}
	//检索负责人
	public function searchHandleMen(){
		if(!isset($_GET['keyword']) || $_GET['keyword']==''){
			echo '{"status":"404","msg":"fail"}';
			return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->getHouseHandleListBykey($_GET['keyword']);
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
	//提交保存房源
	public function submitresource(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
			return $this->uploadClientImage();
		}
		$is_add=true;
		$data['id']=guid();
		$handleLogic=new \Logic\HouseResourceLogic();
		$create_man="";
		$estate_id_flag='';
		if(isset($_POST['resource_id']) && $_POST['resource_id']!=""){
			$is_add=false;
			$data['id']=$_POST['resource_id'];
			$resourceModel=$handleLogic->getModelById($data['id']);//房源信息
			if($resourceModel !=null && $resourceModel['record_status']==0){
				//had delete
				return $this->error('房源已经被删除了',U('HouseResource/resourcelist'),1);
			}
			if($resourceModel!=null && $resourceModel!=false){
				$create_man=$resourceModel['create_man'];
				$data['house_no']=$resourceModel['house_no'];
				$estate_id_flag=$resourceModel['estate_id'];
				$customerId_flag=$resourceModel['customer_id'];
			}
		}
		
		$data['info_resource_type']=I('post.info_resource_type');
		$data['info_resource']=I('post.info_resource');

		$data['business_type']=I('post.business_type');
		$data['estate_id']=I('post.estate_id');
		$data['estate_name']=trim(I('post.estate_name'));
		$data['region_id']=I('post.region');
		$data['scope_id']=I('post.scope');
		$data['unit_no']=trim(I('post.unit_no'));
		$data['area']=I('post.area');
		$data['room_no']=trim(I('post.room_no'));
		$data['floor']=I('post.floor');
		$data['floor_total']=I('post.floor_total');
		$data['room_num']=I('post.room_num');
		$data['hall_num']=I('post.hall_num');
		$data['wei_num']=I('post.wei_num');

		//$data['house_type']=I('post.house_type');
		$data['house_direction']=I('post.house_direction');
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
		$data['room_count']=I('post.room_count');//房间总数
		$data['brand_type']=I('post.brand_type');//品牌
		$data['sole_flag']=isset($_POST['sole_flag'])?1:0;//独家房源
		
		if(isset($_POST['public_equipment'])){
			$data['public_equipment']=implode(",", $_POST['public_equipment']);//共用设施
		}
		//房东信息
		$client_phone=trim(I('post.client_phone'));
		$client_name=trim(I('post.client_name'));
		$client_telephone=trim(I('post.client_telephone'));
		
		$client_sex=I('post.client_sex');
		$client_age=I('post.client_age');//年龄段
		$client_love="";
		if(isset($_POST['client_love'])){
			$client_love=implode(",",$_POST['client_love']);//房东喜欢的租客
		}
		if($data['estate_name']=='' || $data['room_num']=='' || empty($data['rent_type']) ){
			return $this->error('数据异常，请重新操作',U('HouseResource/resourcelist'),1);
		}
		$data['client_name']=$client_name;
		$data['client_phone']=$client_phone;
		//经纪人房源
		$rental_type_agent=isset($_POST['rental_type_agent'])?1:0;
		if($rental_type_agent==1){
			$data['rental_type']=5;
		}
		$client_image=I('post.client_image');
		$handleCustomerLogic=new \Logic\CustomerLogic();
		$clientModel = null;
		if($client_phone!=''){
			$clientModel = $handleCustomerLogic->getResourceClientByPhone($client_phone);
		}
		if($clientModel!=null && $clientModel!=false){
			if($rental_type_agent==1 && $clientModel['is_owner']!=5){
				return $this->error('该号码不是中介，不能直接发布经纪人房源',U('HouseResource/resourcelist'),2);
			}elseif($rental_type_agent==0 && $clientModel['is_owner']==5){
				return $this->error('该号码是中介，不能直接发布房东房源',U('HouseResource/resourcelist'),2);
			}
			//update
			$clientModel['true_name']=$client_name;
			$clientModel['mobile']=$client_phone;
			$clientModel['telephone']=$client_telephone;
			$clientModel['sex']=$client_sex;
			$clientModel['age']=$client_age;
			if(empty($clientModel['city_code'])){
				$clientModel['city_code']=C('CITY_CODE');
			}
			$clientModel['img_path']=$client_image;
			$handleCustomerLogic->updateModel($clientModel);
			$data['customer_id']=$clientModel['id'] ;
			$data['is_auth']=$clientModel['is_auth'];//良心房东
			$data['is_owner']=$clientModel['is_owner'];
		}else if($client_phone!=''){
			//add
			$customerData['id']=guid();
			$customerData['true_name']=$client_name;
			$customerData['mobile']=$client_phone;
			$customerData['telephone']=$client_telephone;
			$customerData['sex']=$client_sex;
			$customerData['age']=$client_age;
			$customerData['create_time']=time();
			$customerData['is_owner']=3;
			$customerData['is_renter']=0;
			if(strtolower($data['info_resource'])=='bd'){
				$customerData['is_owner']=4;
			}
			if($rental_type_agent==1){
				$customerData['is_owner']=5;
			}
			$data['is_owner']=$customerData['is_owner'];
			$customerData['city_code']=C('CITY_CODE');
			$customerData['img_path']=$client_image;
			$customerData['gaodu_platform']=3;
			$handleCustomerLogic->addModel($customerData);
			$data['customer_id']=$customerData['id'];
		}
		if(isset($data['customer_id']) && $data['customer_id']!=''){
			//房东扩展表
			$handleOwnerinfo=new \Logic\HouseOwnerinfoLogic();
			$ownerinfoModel = $handleOwnerinfo->getModelByCustomerId($data['customer_id']);
			if($ownerinfoModel !=null){
				$ownerinfoModel['owner_love']=$client_love;
				$handleOwnerinfo->updateModel($ownerinfoModel);
			}else{
				$ownerinfoAddModel['id']=guid();
				$ownerinfoAddModel['customer_id']=$data['customer_id'];
				$ownerinfoAddModel['owner_love']=$client_love;
				$ownerinfoAddModel['create_time']=time();
				$handleOwnerinfo->addModel($ownerinfoAddModel);
			}
		}
		
		$data['update_time']=time();
		$data['update_man']=getLoginName();
		$data['record_status']=1;//显示
		$data['status']=0;
		
		if(empty($_POST['region_name'])){
			//获取区域、板块名称
			$region_scope = $handleLogic->getRegionScopeName($data['region_id'],$data['scope_id']);
			if($region_scope !=null){
				foreach ($region_scope as $key => $value) {
					if($data['region_id']==$value['id']){
						$data['region_name']=$value['cname'];
					}else{
						$data['scope_name']=$value['cname'];
					}
				}
			}
		}else{
			$data['region_name']=$_POST['region_name'];
			$data['scope_name']=$_POST['scope_name'];
		}
		
		//新增
		if($is_add){
			if(strtolower($data['info_resource'])=='bd' && $rental_type_agent==0){
				if(isset($data['customer_id']) && $data['customer_id']!=''){
					//职业二房东
					$customerinfoDal=new \Home\Model\customerinfo();
					$customerinfoModel=$customerinfoDal->modelFind("customer_id='".$data['customer_id']."'");
					if($customerinfoModel==null || $customerinfoModel==false){
						$customerinfoData['id']=guid();
						$customerinfoData['customer_id']=$data['customer_id'];
						$customerinfoData['source']='BD添加';
						$customerinfoData['principal_man']=$data['update_man'];
						$customerinfoData['update_time']=$data['update_time'];
						$customerinfoData['update_man']=$data['update_man'];
						$customerinfoData['create_time']=$data['update_time'];
						$customerinfoData['status']=4;
						$customerinfoData['region_id']=$data['region_id'];
						$customerinfoData['region_name']=$data['region_name'];
						$customerinfoDal->mobileAdd($customerinfoData);
					}
				}
				
			}
			$data['create_time']=$data['update_time'];
			$data['create_man']=$data['update_man'];
			$data['house_no']=$handleLogic->createHouseno();
			$result=$handleLogic->addModel($data);//新增房源
			if($result){
				//add by 12/28 ,记录日志
				$recordHandle=new \Logic\HouseupdatelogLogic();
				$recordData['id']=guid();
				$recordData['house_id']=$data['id'];
				$recordData['house_type']=1;
				$recordData['create_man']=$data['create_man'];
				$recordData['create_time']=$data['create_time'];
				$recordData['update_man']=$data['create_man'];
				$recordData['update_time']=$data['create_time'];
				$recordData['operate_type']='新增房源';
				$recordHandle->addModel($recordData);
			}
			$this->redirect("Home/HouseRoom/roommanage",array('resource_id' =>$data['id'] ));
		}else{
			if(!isset($data['house_no']) || $data['house_no']==""){
				$data['house_no']=$handleLogic->createHouseno();
				$data['create_time']=time();
			}
			if(empty($create_man)){
				$data['create_man']=$data['update_man'];
			}
			$update_result=$handleLogic->updateModel($data);
			if($update_result){
				$houseroomDal=new \Home\Model\houseroom();
				if(isset($data['customer_id']) && $data['customer_id']!='' && $customerId_flag!=$data['customer_id']){
					$customerinfoDal=new \Home\Model\customerinfo();
					/*修改电话，更新负责人、付费信息 */
					if($clientModel==null || $clientModel==false){
						$houseroomDal->updateModelByWhere(array('principal_man'=>'','is_commission'=>0,'is_monthly'=>0),"resource_id='".$data['id']."'");
						if(strtolower($data['info_resource'])=='bd'){
							//新增职业房东扩展数据
							$customerinfoData['id']=guid();
							$customerinfoData['customer_id']=$data['customer_id'];
							$customerinfoData['source']='BD添加';
							$customerinfoData['update_time']=$data['update_time'];
							$customerinfoData['update_man']=$data['update_man'];
							$customerinfoData['create_time']=$data['update_time'];
							$customerinfoData['status']=4;
							$customerinfoData['region_id']=$data['region_id'];
							$customerinfoData['region_name']=$data['region_name'];
							$customerinfoDal->mobileAdd($customerinfoData);
						}
					}else{
						$updateRoomData['principal_man']='';
						$updateRoomData['is_commission']=$clientModel['is_commission'];
						$updateRoomData['is_monthly']=0;
						if($clientModel['is_monthly']==1 && $clientModel['monthly_start']<=time() && $clientModel['monthly_end']>=time()){
							$updateRoomData['is_monthly']=1;
						}
						
						$customerinfoModel=$customerinfoDal->modelFind("customer_id='".$data['customer_id']."'");
						if($customerinfoModel!=null && $customerinfoModel!=false){
							$updateRoomData['principal_man']=$customerinfoModel['principal_man'];
						}
						$houseroomDal->updateModelByWhere($updateRoomData,"resource_id='".$data['id']."'");
					}
				}
				$handleRoom=new \Logic\HouseRoomLogic();
				$handleRoom->updateHouseresourceCache($data);//更新缓存
				$roomid_result=$houseroomDal->getListByWhere("where resource_id='".$data['id']."'",20);
				$room_ids="";
				if($roomid_result!=null){
					foreach ($roomid_result as $key => $value) {
						$room_ids.="'".$value['id']."',";
					}
				}
				//操作房间查询表
				$handleSelect=new \Home\Model\houseselect();
				$is_cut=$data['room_type']=='0203'?1:0;
				//影响公寓置顶
				//$is_gongyu=$data['business_type']=='1502'?1:0;
				$rent_type=in_array($data['room_type'], array('0201','0202','0203'))?1:2;
				
				$is_pub_kitchen=strpos($data['public_equipment'],'0309')!==false?1:0;
				$is_pub_wc=strpos($data['public_equipment'],'0310')!==false?1:0;
				$is_pub_kuandai=strpos($data['public_equipment'],'0303')!==false?1:0;
				$is_pub_xiyiji=strpos($data['public_equipment'],'0302')!==false?1:0;
				$is_pub_bingxiang=strpos($data['public_equipment'],'0301')!==false?1:0;
				$is_pub_reshuiqi=strpos($data['public_equipment'],'0306')!==false?1:0;
				if($room_ids!=""){
					$room_ids=rtrim($room_ids,",");
					$update_select_field=array('update_time'=>time(),'rental_type'=>$data['rental_type'],'brand_type'=>$data['brand_type'],'is_cut'=>$is_cut,'rent_type'=>$rent_type,'pay_method'=>$data['pay_method'],
						'room_num'=>$data['room_num'],'is_pub_kitchen'=>$is_pub_kitchen,'is_pub_wc'=>$is_pub_wc,'is_pub_kuandai'=>$is_pub_kuandai,'is_pub_xiyiji'=>$is_pub_xiyiji,
						'is_pub_bingxiang'=>$is_pub_bingxiang,'is_pub_reshuiqi'=>$is_pub_reshuiqi);
					if($data['estate_id']!=$estate_id_flag){
						//更新查询表小区信息
						$estateDal=new \Home\Model\estate();
						$estateModel=$estateDal->getModelById($data['estate_id']);
						if($estateModel!=null && $estateModel!=false){
							$update_select_field['estate_id']=$estateModel['id'];
							$update_select_field['estate_name']=$estateModel['estate_name'];
							$update_select_field['estate_address']=$estateModel['estate_address'];
							$update_select_field['estate_full_py']=$estateModel['full_py'];
							$update_select_field['estate_first_py']=$estateModel['first_py'];
							$update_select_field['estate_lpt_x']=$estateModel['lpt_x'];
							$update_select_field['estate_lpt_y']=$estateModel['lpt_y'];
							$update_select_field['region_id']=$estateModel['region'];
							$update_select_field['region_name']=$estateModel['region_name'];
							$update_select_field['scope_id']=$estateModel['scope'];
							$update_select_field['scope_name']=$estateModel['scope_name'];
							$update_select_field['geo_val']=$estateModel['geo_val'];
						}
						//删除查询表小区信息(地铁信息)
						$handleSelect->deleteModelByWhere(" room_id in ($room_ids) and subwayline_id>0 and subway_id>0");
					}
					
					/*$limitRefreshDal=new \Home\Model\customerlimitrefresh();
					$limitRefreshModel=$limitRefreshDal->modelFind(array('customer_id' =>$data['customer_id'] ));
					if($limitRefreshModel!=null && $limitRefreshModel!=false){
					  //无效刷新
						unset($update_select_field['update_time']);
					}*/
					$handleSelect->updateModelByWhere($update_select_field,"room_id in ($room_ids)");
					
				}
				//更新房间下的来源
				$handleRoom->updateModelByResourceid(array('resource_id'=>$data['id'],'info_resource_type'=>$data['info_resource_type'],'info_resource'=>$data['info_resource'],'customer_id'=>$data['customer_id']));
				//add by 12/28 ,记录日志
				$recordHandle=new \Logic\HouseupdatelogLogic();
				$recordData['id']=guid();
				$recordData['house_id']=$data['id'];
				$recordData['house_type']=1;
				$recordData['create_time']=time();
				$recordData['update_man']=$data['update_man'];
				$recordData['update_time']=$data['update_time'];
				$recordData['operate_type']='修改房源';
				$recordHandle->addModel($recordData);
				if(isset($_POST['handletype']) && $_POST['handletype']=='examine'){
					$this->success('房源修改成功！',U("HouseResource/examinelist?no=3&leftno=82"),1);
				}else{
					$this->success('房源修改成功！',U("HouseRoom/roommanage?no=3&leftno=27&resource_id=".$data['id']),1);
				}
			}
		}
		
	}

	//删除房源
	public function removeResource(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '{"status":"201","msg":"请重新登录。"}';return;
		}
		$resource_id=I('post.resource_id');
		$delete_type=I('post.delete_type');
		$delete_text=I('post.delete_text');
		if(empty($resource_id) || empty($delete_type)){
			echo '{"status":"202","msg":"缺少参数"}';return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->deleteModelById($resource_id);
		$handleRoom=new \Logic\HouseRoomLogic();
		if(empty($delete_text)){
			$result=$handleRoom->deleteModelByWhere(array('record_status'=>0,'update_man'=>$login_name,'update_time'=>time(),'delete_type'=>$delete_type),"resource_id='$resource_id'");
		}else{
			$result=$handleRoom->deleteModelByWhere(array('record_status'=>0,'update_man'=>$login_name,'update_time'=>time(),'delete_type'=>$delete_type,'ext_examineinfo'=>$delete_text),"resource_id='$resource_id'");
		}
		if($result){
			//操作房间查询表
			$handleSelect=new \Logic\HouseSelectLogic();
			$handleSelect->deleteModelByResourceid($resource_id);

			//删除店铺房源
			$handleModel=new \Home\Model\storehouses();
			$handleModel->deleteStorehouses("house_id='$resource_id'");

			//add by 12/28 ,记录日志
			$recordHandle=new \Logic\HouseupdatelogLogic();
			$recordData['id']=guid();
			$recordData['house_id']=$resource_id;
			$recordData['house_type']=1;
			$recordData['update_man']=$login_name;
			$recordData['update_time']=time();
			$recordData['operate_type']='删除房源';
			$recordHandle->addModel($recordData);
			//清除房间缓存
			$roomModel=$handleRoom->getModelByResourceId($resource_id);
			if($roomModel!=null && $roomModel!=false){
				$handleRoom->updateHouseroomCache(array('id'=>$roomModel['id'],'room_money'=>1),10);
			}

			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"400","msg":"操作失败，稍后重试"}';
		}
		
	}

	 //导出excel
    public function downloadExcel(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
    	//查询条件
	    $condition['startTime']=I('get.startTime');
	    $condition['endTime']=I('get.endTime');
	    $condition['startTime_create']=I('get.startTime_create');
	    $condition['endTime_create']=I('get.endTime_create');
	    $condition['estateName']=trim(I('get.estateName'));
	    $condition['clientName']=trim(I('get.clientName'));
	    $condition['clientPhone']=trim(I('get.clientPhone'));
	    $condition['houseNo']=trim(I('get.houseNo'));
	    $condition['business_type']=I('get.business_type');
	    $condition['region']=I('get.region');
	    $condition['scope']=I('get.scope');
	    $condition['create_man']=trim(I('get.create_man'));
	    $condition['house_state']="";
    	$condition['info_resource_type']=I('get.info_resource_type');
    	$condition['info_resource']=I('get.info_resource');
    	$hadCondition=false;
    	foreach ($condition as $k1 => $v1) {
    		if(!empty($v1)){
    			$hadCondition=true;
    			break;
    		}
    	}
    	if($hadCondition==false){
    		$this->success('数据太多，请添加筛选条件！',U('HouseResource/resourcelist',array('no'=>'3','leftno'=>'27')),0);
    		return;
    	}
    	$handleLogic=new \Logic\HouseResourceLogic();
    	$list = $handleLogic->getExcelList($condition);
        $title=array(
	        'house_no'=>'房屋编号',
	        'estate_name'=>'小区名称',
	        'region_name'=>'区域',
	        'scope_name'=>'板块',
	        'business_type'=>'业务类型',
	        'unit_no'=>'楼栋/单元号',
	        'room_no'=>'室号',
	        'room_num'=>'室',
	        'hall_num'=>'厅',
	        'wei_num'=>'卫',
	        'room_count'=>'房间数',
	        'client_name'=>'房东姓名',
	        'update_time'=>'更新日期',
	        'update_man'=>'更新操作人',
	        'create_man'=>'创建人',
	        'info_resource'=>'数据来源',
        );
        $excel[]=$title;
        foreach ($list as $key => $value) {
            switch ($value['business_type']) {
            	case '1501':
            		$value['business_type']='小区住宅';
            		break;
            	case '1502':
            		$value['business_type']='品牌公寓';
            		break;
            	case '1503':
            		$value['business_type']='酒店长租';
            		break;
            	default:
            		break;
            }
            $value['update_time']=date("Y-m-d H:i:s",$value['update_time']); 
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '房源信息');
        $xls->addArray($excel);
        $xls->generateXML('房源信息'.date("YmdHis"));
    }
    //房源负责人修改列表
	public function resourceperson(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        
        $handleLogic=new \Logic\HouseResourceLogic();
        $viewList = array();
        $totalCount =0;
        //查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['estateName']=isset($_GET['estateName'])?$_GET['estateName']:"";
        $condition['clientName']=isset($_GET['clientName'])?$_GET['clientName']:"";
        $condition['clientPhone']=isset($_GET['clientPhone'])?$_GET['clientPhone']:"";
        $condition['houseNo']=isset($_GET['houseNo'])?$_GET['houseNo']:"";

    	$condition['info_resource_type']=I('get.info_resource_type');
		$condition['info_resource']=I('get.info_resource');
        $condition['business_type']=isset($_GET['business_type'])?$_GET['business_type']:"";
        $condition['region']=isset($_GET['region'])?$_GET['region']:"";
        $condition['scope']=isset($_GET['scope'])?$_GET['scope']:"";
        $condition['create_man']=isset($_GET['create_man'])?$_GET['create_man']:"";
        $hadCondition=false;$totalCount=0;$pageSHow='';
        foreach ($condition as $k1 => $v1) {
        	if($v1!=''){
        		$hadCondition=true;
        		break;
        	}
        }
        if($hadCondition){
	        $totalCountModel = $handleLogic->getModelListCount($condition);
	        if($totalCountModel !=null && $totalCountModel[0]['totalCount']>=1){
	        	$totalCount=$totalCountModel[0]['totalCount'];//总条数
	        	//分页
		        $Page= new \Think\Page($totalCount,20);
		        $pageSHow=$Page->show();
	        	$list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
	        	//整理列表数据
	        	foreach ($list as $key => $value) {
	        		array_push($viewList, array('id' => $value['id'],'house_no' => $value['house_no'],'estate_name' => $value['estate_name'],'info_resource'=>$value['info_resource'],'business_type' => $value['business_type'],'region_scope' => $value['region_name'].'-'.$value['scope_name'],'create_man' => $value['create_man'],'client_phone'=>$value['client_phone']));
	        	}
	        }
        }
        $this->assign("pageSHow",$pageSHow);
        /*查询条件（业务类型）*/
        $result=$handleLogic->getResourceParameters();
		if($result !=null){
			$typeString='';//业务类型
			foreach ($result as $key => $value) {
				if($value['info_type']==15){
					$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}
			}	
			$this->assign("businessTypeList",$typeString);
		}
		/*查询条件（房源负责人）*/
        $result=$handleLogic->getHouseHandleList();
		$typeString='';
		foreach ($result as $key => $value) {
			$typeString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
		}	
		$this->assign("createManList",$typeString);
		/*查询条件（区域板块）*/
		$result=$handleLogic->getRegionList();
		if($result !=null){
			$regionList='';
			foreach ($result as $key => $value) {
				$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
			}	
			$this->assign("regionList",$regionList);
		}
		$scopeList='<option value=""></option>';
		if(!empty($condition['region'])){
			//查询后，重新加载板块信息
			$result=$handleLogic->getRegionScopeList();
			foreach ($result as $key => $value) {
				if($condition['region']==$value['parent_id']){
					$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
				}
			}
		}
		$this->assign("scopeList",$scopeList);
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
        $this->assign("list",$viewList);
        $this->assign("totalCount",$totalCount);
		$this->display();
	}
	/*确认修改房源负责人 */
	public function editHouseCreateman(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $resource_ids=I('get.resource_ids');
         $create_man=I('get.create_man');
        if(empty($resource_ids) || empty($create_man)){
        	echo '{"status":"201","message":"参数不能为空"}';
        	return;
        }

       $handleCustomerinfo= new \Home\Model\customerinfo();
       $result1=$handleCustomerinfo->modelPrincipalFind($create_man);
       if(!$result1){
         echo '{"status":"202","message":"房源负责人不存在，无法修改"}';
         return;
       }
        
        $resourceId_arr=explode(',', rtrim($resource_ids,','));
        $resourceHandle=new \Logic\HouseResourceLogic();
        $roomHandle=new \Logic\HouseRoomLogic();
        $recordHandle=new \Logic\HousePersonRecord();
        foreach ($resourceId_arr as $key => $value) {
        	if(empty($value)){
        		continue;
        	}
        	$resourceModel=$resourceHandle->getModelById($value);
        	if($resourceModel!=null && $resourceModel!=false){
        		$resourceHandle->updateResourceCreateman($value,$create_man);
        		$roomHandle->updateCreatemanByResourceid($value,$create_man);
        		$recordModel['record_id']=guid();
        		$recordModel['resource_id']=$value;
        		$recordModel['house_no']=$resourceModel['house_no'];
        		$recordModel['person_old']=$resourceModel['create_man'];
        		$recordModel['person_new']=$create_man;
        		$recordModel['create_time']=time();
        		$recordModel['create_man']=getLoginName();
        		$recordHandle->addModel($recordModel);
        	}
        }
        echo '{"status":"200","message":"修改成功"}';
	}
	/*房源负责人修改历史列表 */
	public function resourcepersonrecord(){
		if(!isset($_GET['resource_id']) || $_GET['resource_id']==""){
			return;
		}
		$recordHandle=new \Logic\HousePersonRecord();
		$list = $recordHandle->getRecordByResourceid($_GET['resource_id']);
		$this->assign("list",$list);
		$this->display();
	}
	/*（房源,房间）修改历史列表 */
	public function houseupdatelog(){
		$id=I('get.house_id');
		$type=I('get.house_type');
		if(empty($id) || empty($type)){
			echo '参数异常';return;
		}
		$recordHandle=new \Logic\HouseupdatelogLogic();
		$list = $recordHandle->getListByHouseId($id,$type);
		$this->assign("list",$list);
		$this->display();
	}

	/*审核列表 */
	public function examinelist(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
		if(!$handleCommonCache->checkcache()){
			$this->error('非法操作',U('Index/index'),1);
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
		
		$handleLogic=new \Logic\HouseResourceLogic();
		$viewList = array();
		$condition['client_phone']=I('get.client_phone');
		$condition['info_resource_type']=I('get.info_resource_type');
		$condition['info_resource']=I('get.info_resource');
		$count_result=$handleLogic->getExamineCount($condition);
		$count=0;
		if($count_result!=null && $count_result!=false && count($count_result)>0){
			$count=$count_result[0]['cnt'];
		}
		if($count>0){
	        $Page= new \Think\Page($count,15);
	        $this->assign("pageSHow",$Page->show());
			$list = $handleLogic->getExamineList($condition,$Page->firstRow,$Page->listRows);
	    	$i=1;
	    	//整理列表数据
	    	foreach ($list as $key => $value) {
	    		array_push($viewList, array('id' => $value['id'],'ident_num' => $i,'house_no' => $value['house_no'],'estate_name' => $value['estate_name'],'business_type' => $value['business_type'],'room_id'=>$value['room_id'],
	    			'region_scope' => $value['region_name'].'-'.$value['scope_name'],'unit_no' => $value['unit_no'],'room_no' => $value['room_no'],'room_hall_wei' => $value['room_num'].'室'.$value['hall_num'].'厅'.$value['wei_num'].'卫','room_count' => $value['room_count'],
	    			'client_name' => $value['client_name'],'update_time' => date('Y-m-d H:i',$value['update_time']),'update_man' => $value['update_man'],'create_man' => $value['create_man'],'info_resource_url'=>$value['info_resource_url'],'info_resource'=>$value['info_resource'] ));
	    		$i++;
	    	}
		}else{
			$this->assign("pageSHow","");
		}
		//数据来源
		$this->bindInforesource($condition['info_resource_type']);
		$this->assign("totalcnt",$count);
		$this->assign("list",$viewList);
		$this->display();
	}
	
	//审核房源,合并房间一起审核
	public function examhouse(){
		header ( "Content-type: text/html; charset=utf-8" );
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $resource_id=trim(I('get.resource_id'));
         $room_id=trim(I('get.room_id'));
         if($resource_id=='' || $room_id==''){
			echo '参数异常';return;
         }
   
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $resourceModel=null;
    	$handleLogic=new \Logic\HouseResourceLogic();
    	$resourceModel=$handleLogic->getModelById($resource_id);//房源信息
    	if($resourceModel==null || $resourceModel==false){
    		echo '房源信息读取失败';return;
    	}
		if($resourceModel['record_status']==0){
			echo '房源已经被删除了';return;
		}
	
		//房东信息
		$resourceModel['client_telephone']='';
		$resourceModel['client_sex']='';
		$resourceModel['client_age']='';
		$resourceModel['client_image']='';
		$resourceModel['client_love']='';
		$resourceModel['agent_company_name']='';$resourceModel['agent_fee']='';
		$handleCustomer=new \Logic\CustomerLogic();
		$customerModel=$handleCustomer->getResourceClientById($resourceModel['customer_id']);
		if($customerModel!=null && $customerModel!=false){
			$resourceModel['client_phone']=$customerModel['mobile'];
			$resourceModel['client_telephone']=$customerModel['telephone'];
			if(!empty($customerModel['true_name'])){
				$resourceModel['client_name']=$customerModel['true_name'];
			}
			$resourceModel['client_sex']=$customerModel['sex'];
			$resourceModel['client_age']=$customerModel['age'];
			$resourceModel['client_image']=$customerModel['img_path'];
			$resourceModel['agent_company_name']=$customerModel['agent_company_name'];
			$resourceModel['is_owner']=$customerModel['is_owner'];
			if($resourceModel['is_owner']==5){
				//中介房源
				$handleOffer=new \Home\Model\houseoffer();
				$data= $handleOffer->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id',"room_id='$room_id' and customer_id='".$resourceModel['customer_id']."' limit 1");
     			if($data!=null&&count($data)>0){
     				$this->assign("agentOfferId",$data[0]['id']);
     				$resourceModel['agent_fee']=$data[0]['commission_price'];
     				if($data[0]['commission_type']==0){
     					$resourceModel['agent_fee']=intval($resourceModel['agent_fee']/100).'%';
     				}
     			}
			}
		}
        $this->assign("resourceModel",$resourceModel);
		$this->bindInforesource($resourceModel['info_resource_type']);//来源
		$this->loadResourceParameter();
		/*房间信息 */
        //读取房间信息
		$roomLogic=new \Logic\HouseRoomLogic();
		$roomModel=$roomLogic->getModelById($room_id);
		if($roomModel==null || $roomModel==false){
			echo '房间信息读取失败';return;
		}
		if($roomModel['record_status']==0){
			echo '房间已经被删除了';return;
		}
		if($roomModel['status']!=0){
			echo '已经审核过了，勿重复操作';return;
		}
		$this->assign('roomNames',getRoomNamelistByType('1501'));
		//读取图片信息
		$imgString="";
		$handleImg=new \Logic\HouseImgLogic();
		$imgList=$handleImg->getModelByRoomId($roomModel['id']);
		if($imgList!==null && $imgList!==false){
			foreach ($imgList as $key => $value) {
				if($value['city_code']=='001009001'){
					$value["img_path"]='shanghai/'.$value["img_path"];
				}
				$imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
				$corp_imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"]."_200_130.".$value["img_ext"];
				$imgString.='<li><img src="'.$corp_imgUrl.'" alt=""><br/><a href="javascript:;" onclick="removePic(\''.$value["id"].'\',this)">删除</a>&nbsp;<a href="'.__ROOT__.'/HouseRoom/downloadImage?img_id='.$value["id"].'">下载</a><br/><label><input type="radio" value="'.$value["id"].','.$imgUrl.'" name="main_img">封面</label></li>';
			}
		}
		$this->assign("imgString",$imgString);
		$this->assign("roomModel",$roomModel);
		$this->display();
	}
	//审核通过
	public function examHousePass(){
		header ( "Content-type: text/html; charset=utf-8" );
		$loginName=trim(getLoginName());
		if(empty($loginName)){
			echo '会话失效，请重新登陆。';return;
		}
		if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
		  echo $data = R('HouseRoom/uploadImage'); return;
		}
		$resource_id=I('post.resource_id');
		$room_id=I('post.room_id');
		if(empty($resource_id) || empty($room_id)){
			echo '参数异常';return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$data=$handleLogic->getModelById($resource_id);//房源信息
		if($data==null || $data==false){
			echo "房源信息读取失败";return;
    	}
		if($data['record_status']==0){
			echo "房源已经被删除了";return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$room_data=$roomLogic->getModelById($room_id);//房间信息
		if($room_data==null || $room_data==false){
			echo "房间信息读取失败";return;
		}
		if($room_data['record_status']==0){
			echo "房间已经被删除了";return;
		}
		if($room_data['status']!=0){
			echo "房源已经审核过了。";return;
		}
		$data['info_resource_type']=I('post.info_resource_type');
		$data['info_resource']=I('post.info_resource');
		$data['business_type']=I('post.business_type');
		$data['estate_id']=I('post.estate_id');
		$data['estate_name']=trim(I('post.estate_name'));
		$data['region_id']=I('post.region');
		$data['scope_id']=I('post.scope');
		$data['unit_no']=trim(I('post.unit_no'));
		$data['area']=trim(I('post.area'));
		$data['room_no']=trim(I('post.room_no'));
		$data['floor']=I('post.floor');
		$data['floor_total']=I('post.floor_total');
		$data['room_num']=I('post.room_num');
		$data['hall_num']=I('post.hall_num');
		$data['wei_num']=I('post.wei_num');
		//$data['house_type']=I('post.house_type');
		$data['house_direction']=I('post.house_direction');
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

		$data['client_name']=trim(I('post.client_name'));
		//更新房东信息 by 8.5
		$clientImage=I('post.client_image');
		if(empty($clientImage)){
			//删除房东头像
			$handleCustomerLogic=new \Logic\CustomerLogic();
			$handleCustomerLogic->updateModel(array('id'=>$data['customer_id'],'true_name'=>$data['client_name'],'img_path'=>''));
		}
		$data['room_count']=1;
		$data['brand_type']=I('post.brand_type');//品牌
		if(isset($_POST['public_equipment'])){
			$data['public_equipment']=implode(",", $_POST['public_equipment']);//共用设施
		}
		$data['update_time']=time();
		$data['update_man']=$loginName;
		if(empty($data['region_id']) || empty($data['estate_name']) || empty($data['pay_method'])){
			echo "数据异常";
			return;
		}
		//获取区域、板块名称
		$region_scope = $handleLogic->getRegionScopeName($data['region_id'],$data['scope_id']);
		if($region_scope !=null){
			foreach ($region_scope as $key => $value) {
				if($data['region_id']==$value['id']){
					$data['region_name']=$value['cname'];
				}else{
					$data['scope_name']=$value['cname'];
				}
			}
		}
		if(!isset($data['house_no']) || $data['house_no']==""){
			$data['house_no']=$handleLogic->createHouseno();
			$data['create_time']=time();
		}
		if(empty($data['create_man'])){
			$data['create_man']=$data['client_name'];
		}
		$data['rental_type']=I('post.rental_type');
		if(empty($data['rental_type'])){
			$data['rental_type']=0;
		}
		if($data['is_owner']==5){
			//中介房源
			$handleOffer=new \Home\Model\houseoffer();
			$handleOffer->updateHouseoffer(array('record_status'=>1,'status_code'=>3,'handle_time'=>time(),'handle_man'=>$loginName),"id='".I('post.agentOfferId')."'");
		}elseif($data['rental_type']=='3'){
			//加入到职业房东，方法下面有判断 $isowner_flag!=4
			$customerinfoLogic=new \Logic\CustomerInfo();
		    $result=$customerinfoLogic->addOwnerForCustomerinfo(array('mobile'=>'','customer_id'=>$data['customer_id'],'source'=>'上房添加','update_man'=>$data['update_man'],'update_time'=>$data['update_time'],'region_id'=>$data['region_id'],'region_name'=>$data['region_name']));
			if($result){
				$data['is_owner']=4;
			}
		}
		//更新房源信息
		$update_result=$handleLogic->updateModel($data);
		if(!$update_result){
			echo "房源更新失败";return;
		}
		$roomLogic->updateHouseresourceCache($data);//更新房源缓存
		/*房间信息 */
		$room_data['room_name']=I('post.room_name');
		$room_data['room_area']=I('post.room_area');
		$room_data['room_money']=I('post.room_money');
		$room_data['low_price']=$room_data['room_money'];
		$room_data['total_count']=1;
		$room_data['up_count']=1;
		$room_data['info_resource_type']=$data['info_resource_type'];
		$room_data['info_resource']=$data['info_resource'];
		$room_data['customer_id']=$data['customer_id'];
		$room_data['room_direction']=$_POST['room_direction'];
		if(isset($_POST['room_equipment'])){
			$room_data['room_equipment']=implode(",", $_POST['room_equipment']);
		}
		if(!isset($room_data['room_no']) || $room_data['room_no']==""){
			$room_data['room_no']=$roomLogic->createRoomno();
			$room_data['create_time']=time();
		}
		$room_data['room_description']=replaceHousePlatformName(I('post.room_description'));
		$room_data['girl_tag']=I('post.girl_tag');
		$room_data['update_time']=time();
		$room_data['update_man']=$loginName;
		$room_data['status']=2;
		if(empty($room_data['room_name']) || empty($room_data['room_money']) || empty($room_data['room_area'])){
			echo "数据异常";
			return;
		}
		if(isset($_POST['main_img'])){
			$main_img=explode(",", $_POST['main_img']);
			if($room_data['main_img_id'] != $main_img[0]){
				$room_data['main_img_id']=$main_img[0];
				$room_data['main_img_path']=$main_img[1];
				//切换主图
				$handleImage=new \Logic\HouseImgLogic();
				$handleImage->updateSortindexByid($room_data['main_img_id'],$room_data['id']);
			}
		}
		if(empty($room_data['create_man'])){
			$room_data['create_man']=$data['client_name'];
		}
		$is_baozhang=0;
		if(empty($room_data['principal_man'])){
			//房东负责人
			$handleCustomerinfo=new \Logic\CustomerInfo();
			$customerinfoModel=$handleCustomerinfo->getPrincipalByCustomerid($data['customer_id']);
			if($customerinfoModel!==false){
				$room_data['principal_man']=$customerinfoModel['principal_man'];
				if($customerinfoModel['margin']>0){
					$is_baozhang=1;
				}
			}
		}
		/*判断是否包月房东 */
		$handleCustomerLogic=new \Logic\CustomerLogic();
		$clientModel = $handleCustomerLogic->getModelById($data['customer_id']);
		if($clientModel['is_monthly']==1 && $clientModel['monthly_start']<=time() && $clientModel['monthly_end']>=time()){
			$room_data['is_monthly']=1;
		}
		if($clientModel!=null && $clientModel['is_commission']==1){
			$room_data['is_commission']=1;
		}
		$city_code=C('CITY_CODE');
		if($city_code!='001001'){
			$room_data['show_reserve_bar']=1;
		}
		if($city_code=='001009001' && $room_data['room_money']>=5000 && $data['rent_type']==2 && $room_data['is_monthly']!=1 && in_array($data['region_id'], array(2,7,14,24,43,108))){
			$room_data['show_call_bar']=0;
		}elseif($city_code=='001009001' && $room_data['room_money']<2000 && $room_data['is_monthly']!=1 && $room_data['is_commission']!=1){
			$room_data['show_call_bar']=1;
			$room_data['show_reserve_bar']=0;
		}
		$result=$roomLogic->updateModel($room_data);//更新房间表
		if(!$result){
			echo "房间更新失败";return;
		}
		$roomLogic->updateHouseroomCache($room_data);//更新房间缓存
		//操作房间查询表
		$handleSelect=new \Logic\HouseSelectLogic();
		$handleSelect->deleteModelByRoomid($room_data['id']);
		$handleSelect->addModel($room_data['id'],$is_baozhang);

		//记录日志
		$recordHandle=new \Logic\HouseupdatelogLogic();
		$recordData['id']=guid();
		$recordData['house_id']=$room_data['id'];
		$recordData['house_type']=2;
		$recordData['update_man']=$room_data['update_man'];
		$recordData['update_time']=$room_data['update_time'];
		$recordData['operate_type']='审核通过';
		$recordHandle->addModel($recordData);
		if($room_data['store_id']!=''){
			//增加信用分
			$recordHandle=new \Logic\StoresManage();
			$recordHandle->createStoreCreditDetail(array('id'=>$room_data['store_id'] ,'customer_id'=>$data['customer_id'],'sign'=>'+','score_num'=>1,'score_type'=>1,'msg_txt'=>''));
		}
		
		/*推送消息 */
		$notify_type=1;
		$content='<font color="#666666">你发布的</font><font color="#444444"> [ '.$data["estate_name"].' ] </font><font color="#666666">房源已通过审核，可以在“我出租的房源”中查看</font>';
		if($data['info_resource_type']==4 || $data['is_owner']==5){
			$notify_type=1009;
			$content='<font color="#666666">你发布的</font><font color="#444444"> [ '.$data["estate_name"].' ] </font><font color="#666666">房源已通过审核，可以在“房间管理”中查看</font>';
		}
		$handleNotify=new \Logic\CustomerNotifyLogic();
		$handleNotify->sendCustomerNotify($data['customer_id'],$notify_type,'房源审核',$content,'您有1条房源审核信息');
		echo "审核成功";
		
	}

	//审核不通过
	public function examHouseNopass(){
		$resource_id=I('post.resource_id');
		$room_id=I('post.room_id');
		$ext_bak=trim(I('post.ext_examineinfo'));
		$ext_bak=str_replace("'", "", $ext_bak);
		$customer_id=I('post.customer_id');
		if(empty($resource_id) || empty($ext_bak) || empty($customer_id) || empty($room_id)){
			echo '{"status":"400","message":"参数异常"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$room_data=$roomLogic->getModelById($room_id);//房间信息
		if($room_data===null || $room_data===false){
			echo '{"status":"400","message":"房间信息读取失败"}';
			return;
		}
		if($room_data['record_status']==0){
			echo '{"status":"400","message":"房间已经被删除了"}';
			return;
		}
		if($room_data['status']!=0){
			echo '{"status":"400","message":"房源已经审核过了"}';
			return;
		}
		$handleLogic=new \Logic\HouseResourceLogic();
		$result=$handleLogic->examineResourceFail($room_id,$ext_bak);//更新房间状态
		if(!$result){
			echo '{"status":"400","message":"操作失败"}';return;
		}
		//记录日志
		$recordHandle=new \Logic\HouseupdatelogLogic();
		$recordData['id']=guid();
		$recordData['house_id']=$room_id;
		$recordData['house_type']=2;
		$recordData['update_man']=getLoginName();
		$recordData['update_time']=time();
		$recordData['operate_type']='审核不通过';
		$recordData['operate_bak']=$ext_bak;
		$recordHandle->addModel($recordData);
		$roomLogic->updateHouseroomCache($room_data,10);//清除房间缓存
		//推送审核通知
		$estate_name=I('post.estate_name');
		$content='<font color="#666666">你发布的</font><font color="#444444"> [ '.$estate_name.' ] </font><font color="#666666">房源未通过审核，原因是'.$ext_bak.'，你可以在“我出租的房源”中编辑后重新发布</font>';
		$notify_type=1;
		if(I('post.info_resource_type')==4 || $room_data['is_agent_fee']==1){
			$notify_type=1009;
			$content='<font color="#666666">你发布的</font><font color="#444444"> [ '.$estate_name.' ] </font><font color="#666666">房源未通过审核，原因是'.$ext_bak.'，你可以在“房间管理”中编辑后重新发布</font>';
		}
		$handleNotify=new \Logic\CustomerNotifyLogic();
		$handleNotify->sendCustomerNotify($customer_id,$notify_type,'房源审核',$content,'您有1条房源审核信息');
		echo '{"status":"200","message":"操作成功"}'; 
		
	}
}

?>
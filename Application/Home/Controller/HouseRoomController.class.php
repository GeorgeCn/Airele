<?php
namespace Home\Controller;
use Think\Controller;
class HouseRoomController extends Controller {
	
	/*房间管理*/
	public function roommanage(){
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

		$handleLogic=new \Logic\HouseRoomLogic();
		if(isset($_GET['resource_id'])){
			$resource_id=$_GET['resource_id'];
			//判断房源业务类型
			$handleResource=new \Logic\HouseResourceLogic();
			$houseModel=$handleResource->getModelById($resource_id);
			if($houseModel!=null && $houseModel['business_type']=="1503"){
				$this->assign('housetype',"hotel");
			}
			$list=$handleLogic->getModelListByResourceId($resource_id);	
			$viewList=array();
			if($list!==null && $list!==false){
				$i=1;
				foreach ($list as $key => $value) {
					$is_renter=$value['is_renter']>=1?'是':'否';
					array_push($viewList,  array('room_id' =>$value['id'] ,'ident_num' =>$i, 'room_no' =>$value['room_no'] , 'room_name' =>$value['room_name'] , 'room_area' =>$value['room_area'],'update_man' =>$value['update_man'], 
						'room_money' =>$value['room_money'] , 'status_name' =>$value['status_name'],'is_renter'=>$is_renter, 'update_time' =>date('Y-m-d H:i',$value['update_time']),'info_resource_url'=>$value['info_resource_url'],'sort_index'=>$value['sort_index']));
					$i++;
				}
			}
			$this->assign('list',$viewList);
			//房源地址信息
			$addressModel=$handleResource->getAddressInfoById($resource_id);
			$resource_info='';$room_count='';
			if($addressModel!==null && $addressModel!==false){
				$resource_info=$addressModel['region_name'].$addressModel['scope_name'].",".$addressModel['estate_name'].$addressModel['unit_no']."单元".$addressModel['room_no']."室";
				$room_count=$addressModel['room_count'];
			}
			$this->assign('resource_info',$resource_info);
			$this->assign('roomCount',$room_count);
			$this->assign('resource_id',$resource_id);
			$this->display();
		}else{
			return $this->error('缺少参数',U('HouseResource/resourcelist'),1);
		}			
	}
	//删除房间
	public function removeRoom(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '{"status":"201","msg":"请重新登录。"}';return;
		}
		$room_id=I('post.room_id');
		$delete_type=I('post.delete_type');
		$delete_text=trim(I('post.delete_text'));
		if(empty($room_id) || empty($delete_type)){
			echo '{"status":"202","msg":"缺少参数"}';return;
		}
		$data['handle_man']=$login_name;
		$data['room_id']=$room_id;
		$data['delete_type']=$delete_type;
		$data['delete_text']=$delete_text;

		$handleRoom=new \Logic\HouseRoomLogic();
		$result2=$handleRoom->deleteRoomByRoomid($data);
		if($result2){
			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"400","msg":"操作失败，稍后重试"}';
		}
		
	}
	
	/*新增房间*/
	public function addroom(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '请重新登录。';return;
		}
		$resource_id=I('get.resource_id');
		if(empty($resource_id)){
			echo '参数错误。';return;
		}
        $handleCommonCache=new \Logic\CommonCacheLogic();
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"3");
        $menu_left_html=$handleMenu->menuLeft($login_name,"3");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
		$this->loadRoomParameter();
		
		$this->assign('room_id',guid());
		//判断房源业务类型
		$houseLogic=new \Logic\HouseResourceLogic();
		$houseModel=$houseLogic->getModelById($resource_id);
		if($houseModel==null || $houseModel==false){
			echo '房源信息不存在';return;
		}

		$this->assign('houseModel',$houseModel);
		$this->assign('roomNames',getRoomNamelistByType($houseModel['business_type'],$houseModel['room_type']));
		$companyList='';
		if($houseModel['rental_type']==5){
			//中介公司
			$houseLogic=new \Logic\HouseofferLogic();
			$data=$houseLogic->getAgentCompanyList();
			if($data!=null){
				foreach ($data as $key => $value) {
					$companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
				}
			}
		}
		$this->assign('companyList',$companyList);
		$this->display();
	}
	
	//加载配置参数信息（房间设施和朝向）
	public function loadRoomParameter(){
		$handleLogic=new \Logic\HouseResourceLogic();
		$result2=$handleLogic->getResourceParameters();
		if($result2 !=null){
			$roomDirectionList='';//朝向
			$room_equipment='';//房间设施
			foreach ($result2 as $key => $value) {
				switch ($value['info_type']) {
					case 10:
						$roomDirectionList.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
						break;
					case 11:
						$room_equipment.='<label><input type="checkbox" name="room_equipment[]" value="'.$value["type_no"].'">'.$value["name"].'</label>&nbsp;&nbsp;';
						break;
					default:
						break;
				}
			}
			$this->assign("roomDirectionList",$roomDirectionList);
			$this->assign("room_equipment",$room_equipment);
		}
	}
	//保存新增房间
	public function submitroom(){
		header ( "Content-type: text/html; charset=utf-8" );
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
		if(I('post.submitType')=="upload"){
			echo $this->uploadImage();return;
		}
		$data['id']=I('post.room_id');
		$roomLogic=new \Logic\HouseRoomLogic();
		$data['resource_id']=I('post.resource_id');
		$data['room_no']=$roomLogic->createRoomno();
		$data['room_name']=trim(I('post.room_name'));
		$data['room_area']=I('post.room_area');
		$data['room_money']=I('post.room_money');
		$data['low_price']=$data['room_money'];

		if($data['id']=="" || empty($data['room_money'])){
			echo '数据无效';return;
		}
		$data['total_count']=I('post.total_count');
		$data['room_direction']=trim(I('post.room_direction'));
		if(isset($_POST['room_equipment'])){
			$data['room_equipment']=implode(",", $_POST['room_equipment']);
		}
		$data['room_description']=replaceHousePlatformName(I('post.room_description'));
		$data['feature_tag']=isset($_POST['feature_tag'])?1:0;
		$data['girl_tag']=I('post.girl_tag');
		$data['create_time']=time();
		$data['create_man']=getLoginName();
		$data['update_time']=$data['create_time'];
		$data['update_man']=$data['create_man'];
		$data['status']=I('post.status');
		$data['up_count']=0;
		$data['had_vedio'] = I('post.had_vedio');
		if($data['status']==2){
			$data['up_count']=I('post.up_count');
		}
		if(isset($_POST['main_img'])){
			$main_img=explode(",", $_POST['main_img']);
			$data['main_img_id']=$main_img[0];
			$data['main_img_path']=$main_img[1];
			//切换主图
			$handleImage=new \Logic\HouseImgLogic();
			$handleImage->updateSortindexByid($data['main_img_id'],$data['id']);
		}
		/*房源数据 */
		$houseLogic=new \Logic\HouseResourceLogic();
		$houseModel=$houseLogic->getModelById($data['resource_id']);
		if($houseModel==null || $houseModel==false){
			echo '房源数据不存在';return;
		}
		$data['info_resource_type']=$houseModel['info_resource_type'];
		$data['info_resource']=$houseModel['info_resource'];
		$data['customer_id']=$houseModel['customer_id'];
		/*$client_phone=$houseModel['client_phone'];
		$client_name=$houseModel['client_name'];
		$estate_name=$houseModel['estate_name'];*/
		$handleCustomerLogic=new \Logic\CustomerLogic();
		$handleResource=new \Logic\HouseResourceLogic();
		$clientModel=null;
		if($houseModel['rental_type']==5){
			//$data['is_regroup']=1;
			//维护中介信息
			$agent_fee=I('post.agent_fee');
			if($agent_fee>0){
				$data['is_agent_fee']=1;
			}
			$company_id=I('post.company_id');
			$company_name=trim(I('post.company_name'));
			if($company_name==''){
				echo '中介公司必填项';return;
			}
			$client_name=trim(I('post.client_name'));
			$client_phone=trim(I('post.client_phone'));
			if($agent_fee=='' || $company_id=='' || $client_phone==''){
				echo '中介数据不完整';return;
			}
			if(empty($data['customer_id'])){
				$clientModel = $handleCustomerLogic->getResourceClientByPhone($client_phone);
				if($clientModel!=null && $clientModel!=false){
					if($clientModel['is_owner']!=5){
						echo '该号码不是中介，不能直接发布经纪人房源';return;
					}
					$handleCustomerLogic->updateModel(array('id'=>$clientModel['id'],'agent_company_id'=>$company_id,'agent_company_name'=>$company_name));
				}else{
					//新增中介
					$clientModel=array('id'=>guid(),'agent_company_id'=>$company_id,'agent_company_name'=>$company_name,'true_name'=>$client_name,'mobile'=>$client_phone,'create_time'=>time(),'is_owner'=>5,'is_renter'=>0,'city_code'=>C('CITY_CODE'),'gaodu_platform'=>3);
					$result=$handleCustomerLogic->addModel($clientModel);
					if(!$result){
						echo '中介数据保存失败';return;
					}
				}
				//更新房源表的房东信息
				$handleResource->updateModel(array('id'=>$data['resource_id'],'client_name'=>$clientModel['true_name'],'client_phone'=>$clientModel['mobile'],'customer_id'=>$clientModel['id'],'is_owner'=>5));
				$data['customer_id']=$clientModel['id'];
			}else{
				$handleCustomerLogic->updateModel(array('id'=>$data['customer_id'],'agent_company_id'=>$company_id,'agent_company_name'=>$company_name));
			}
		}
		
		//房东负责人
		$handleCustomerinfo=new \Logic\CustomerInfo();
		$customerinfoModel=$handleCustomerinfo->getPrincipalByCustomerid($data['customer_id']);
		$is_baozhang=0;
		if($customerinfoModel!==false){
			$data['principal_man']=$customerinfoModel['principal_man'];
			if($customerinfoModel['margin']>0){
				$is_baozhang=1;
			}
		}
		#2016/11/9,店铺房源更新
		$handleStoreHouses=new \Home\Model\storehouses();
		$member_array=$handleStoreHouses->getStoremembers("customer_id='".$data['customer_id']."' and is_special=1");
		if($member_array!=null && count($member_array)>0){
			$data_store_house['store_id']=$member_array[0]['store_id'];
			$data_store_house['store_name']=$member_array[0]['store_name'];
			$data_store_house['room_id']=$data['id'];
			$data_store_house['house_id']=$data['resource_id'];
			$data_store_house['customer_id']=$data['customer_id'];
			$handleStoreHouses->addStorehouses($data_store_house);
			$data['store_id']=$data_store_house['store_id'];
			//更新房源信息
			$handleResource->updateModel(array('id'=>$data['resource_id'],'store_id'=>$data['store_id']));
		}
		if(in_array($data['create_man'], array('yuzongmin','wangmenglong','lishiqiang','sunxinbing'))){
			$data['takelook_man']=$data['create_man'];
		}
		/*判断是否包月房东 */
		if($clientModel==null){
			$clientModel = $handleCustomerLogic->getModelById($data['customer_id']);
		}
		if($clientModel['is_monthly']==1 && $clientModel['monthly_start']<=time() && $clientModel['monthly_end']>=time()){
			$data['is_monthly']=1;
		}
		if($clientModel['is_commission']==1){
			$data['is_commission']=1;
		}
		$data['city_code']=C('CITY_CODE');
		if($data['city_code']!='001001'){
			$data['show_reserve_bar']=1;
		}
		if($data['city_code']=='001009001' && $data['room_money']>=5000 && !isset($data['is_monthly'])){
			$data['show_call_bar']=0;
		}
		$result =$roomLogic->addModel($data);
		if($result){
			if($houseModel['rental_type']==5){
				//报价表
				$offerLogic=new \Logic\HouseofferLogic();
				$offerLogic->addHouseoffer($data['customer_id'],$data['id'],$data['resource_id'],$data['room_money'],$agent_fee,$data['create_man']);
			}
			
			//操作房间查询表
			$handleSelect=new \Logic\HouseSelectLogic();
			$handleSelect->addModel($data['id'],$is_baozhang);
			/*if($data['is_commission']==1){
				//添加佣金
				$commissionDal=new \Home\Model\commission();
				$commissionfdDal=new \Home\Model\commissionfd();
				for ($i=0; $i < 1; $i++) { 
					$is_commission=0;
					$commissionData=$commissionfdDal->getCommissionByWhere(" where id=".$commissionId_min);//todo;$commissionId_min
					if($commissionData!==null && $commissionData!==false && count($commissionData)>0){
						$commDetails=$commissionfdDal->getDetailsByCommissionId($commissionData[0]['id']);
						if($commDetails!==null && $commDetails!==false && count($commDetails)>0){
							$is_commission=1;
						}
					}
					if($is_commission==0){
						continue;
					}
					$commissionId=$commissionDal->addModel(array('room_id'=>$data['id'],'room_no'=>$data['room_no'],'room_status'=>$data['status'],'room_money'=>$data['room_money'],'estate_name'=>$estate_name,'client_phone'=>$client_phone,
						'client_name'=>$client_name,'contracttime_start'=>$commissionData[0]['contracttime_start'],'contracttime_end'=>$commissionData[0]['contracttime_end'],
						'is_open'=>1,'create_time'=>$data['create_time'],'create_man'=>$data['create_man'],'update_time'=>$data['update_time'],
						'update_man'=>$data['update_man'],'city_code'=>$data['city_code']));
					if($commissionId>0){
						$commissionDal->addDetail(array('commission_id'=>$commissionId,'commission_type'=>$commDetails[0]['commission_type'],
								'commission_money'=>$commDetails[0]['commission_money'],'commission_base'=>$commDetails[0]['commission_base'],
								'is_online'=>$commDetails[0]['is_online'],'settlement_method'=>$commDetails[0]['settlement_method'],
								'start_time'=>$commDetails[0]['start_time'],'create_time'=>$data['create_time'],'create_man'=>$data['create_man']));
					}
				}
			}*/
			//add by 12/28 ,记录日志
			$recordHandle=new \Logic\HouseupdatelogLogic();
			$recordData['id']=guid();
			$recordData['house_id']=$data['id'];
			$recordData['house_type']=2;
			$recordData['update_man']=$data['update_man'];
			$recordData['update_time']=$data['update_time'];
			$recordData['operate_type']='新增房间';
			$recordHandle->addModel($recordData);

			/*更新视频房间编号*/
			$VodLogic = new \Logic\VODClientLogic();
			$VodLogic->updateHousevideoRoomNo($data);

			$this->redirect("Home/HouseRoom/roommanage",array('resource_id' =>$data['resource_id'] ));
		}else{
			$this->error('操作失败，稍后重试',U('HouseRoom/roommanage',array('resource_id' =>$data['resource_id'] )),1);
		}
		
	}
	/*修改房间*/
	public function modifyroom(){
		$room_id=trim(I('get.room_id'));
		if(empty($room_id)){
			return $this->error('参数有误',U('HouseRoom/searchroom?no=3&leftno=44'),1);
		}
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
        //读取房间信息
		$roomLogic=new \Logic\HouseRoomLogic();
		$roomModel=$roomLogic->getModelById($room_id);
		if($roomModel==null || $roomModel==false){
			return $this->error('操作失败，稍后重试',U('HouseRoom/searchroom?no=3&leftno=44'),1);
		}
		//获取房源信息
		$resourceDal=new \Home\Model\houseresource();
		$houseModel = $resourceDal->getModelById($roomModel['resource_id']);
		$housetype="";$roomtype="";
		if($houseModel!==null && $houseModel!==false){
			$housetype=$houseModel['business_type'];
			//$roomtype=$houseModel['rent_type'];
			$roomtype=$houseModel['room_type'];
			$this->assign('house_area',$houseModel['area']);
		}
		$this->assign('roomNames',getRoomNamelistByType($housetype,$roomtype));
		//读取图片信息
		$handleImg=new \Logic\HouseImgLogic();
		$imgList=$handleImg->getModelByRoomId($room_id);
		$maxSort=0;
		if($imgList !=null){
			$imgString="";
			foreach ($imgList as $key => $value) {
				if($maxSort<$value['sort_index']){
					$maxSort=$value['sort_index'];
				}
				if($value['city_code']=='001009001'){
					$value["img_path"]='shanghai/'.$value["img_path"];
				}
				$imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
				$corp_imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"]."_200_130.".$value["img_ext"];
				$imgString.='<li><img src="'.$corp_imgUrl.'"><br/><a href="javascript:;" onclick="removePic(\''.$value["id"].'\',this)">删除</a>&nbsp;<a href="'.__CONTROLLER__.'/downloadImage?img_id='.$value["id"].'">下载</a><br/><label><input type="radio" value="'.$value["id"].','.$imgUrl.'" name="main_img">封面</label></li>';
			}
			$this->assign("imgString",$imgString);
		}
		//读取视频信息
		$VodLogic = new \Logic\VODClientLogic();
		$videoList = $VodLogic->findHousevideo($roomModel['id']);
		if($videoList['video_img_url'] !=null) {
			$videoImgString = "";
			$videoImgUrl = $videoList['video_img_url'];
			$videoImgString.='<li><img src="'.$videoImgUrl.'" alt=""></br>封面</li>';
			$this->assign("videoImgString",$videoImgString);
		}
		if($videoList['video_url'] !=null) {
			$videoString = "";
			$videoUrl = $videoList['video_url'];
			$videoString.='<li><video class="video-js vjs-default-skin" controls    preload="auto"width="250"height="130"   data-setup="{}">
        		<source src="'.$videoUrl.'" type="video/mp4"> 
      			</video>视频</li>';
			$this->assign("videoString",$videoString);
		}
		$roomModel['maxSort']=$maxSort;
		$this->assign("roomModel",$roomModel);
		$this->loadRoomParameter();
		$this->display();
	}
	//修改房间 提交
	public function submitRoomModify(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
		if(I('post.submitType')=="upload"){
			echo $this->uploadImage();return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$data=$roomLogic->getModelById(I('post.room_id'));
		if($data==null || $data==false){
			return $this->error('房间信息读取失败',U('HouseRoom/searchroom?no=3&leftno=44'),1);
		}
		if($data['status']==0){
			return $this->error('该房间状态是待审核，请在审核列表里面修改。',U('HouseRoom/searchroom?no=3&leftno=44'),2);
		}else if($data['status']==1){
			return $this->error('该房间审核未通过，不能进行修改。',U('HouseRoom/searchroom?no=3&leftno=44'),2);
		}
		$room_money_old=$data['room_money'];
		$data['room_name']=trim(I('post.room_name'));
		$data['room_area']=trim(I('post.room_area'));
		$data['room_money']=trim(I('post.room_money'));
		$data['total_count']=I('post.total_count');
		$data['room_direction']=I('post.room_direction');
		if(empty($data['room_name']) || !is_numeric($data['room_money'])){
			return $this->error('数据有误，修改失败。',U('HouseRoom/searchroom?no=3&leftno=44'),1);
		}
		//聚合房源，最低价
		if($data['is_regroup']==1){
			$low_price=intval($data['room_money']);
			$offer_id='';
			$commission_money=0;
			$handleOffer=new \Home\Model\houseoffer();
			//获取房间下面的所有报价
			$dataOffers=$handleOffer->getHouseofferData('id,commission_type,commission_price,commission_money,create_time,room_price,customer_id',"room_id='".$data['id']."' and record_status=1 and status_code=3 limit 20");
			foreach ($dataOffers as $key => $value) {
				if($value['customer_id']==$data['customer_id']){
					//更新自己报价
					$offer_id=$value['id'];
					$commission_money=$value['commission_money'];
					if($value['commission_type']==0 && $value['commission_price']>0){
						$commission_money=intval($value['commission_price']/10000*$data['room_money']);
					}
				}
			   if(intval($value['room_price'])<$low_price){
			      $low_price=intval($value['room_price']);
			   }
			}
			if($low_price>0){
				$data['low_price']=$low_price;
			}
			if($offer_id!=''){
				$handleOffer->updateHouseoffer(array('room_price'=>$data['room_money'],'commission_money'=>$commission_money),"id='$offer_id'");
			}
		}else{
			//非聚合
			$data['low_price']=$data['room_money'];
		}
		if(isset($_POST['room_equipment'])){
			$data['room_equipment']=implode(",", $_POST['room_equipment']);
		}
		if(!isset($data['room_no']) || $data['room_no']==""){
			$data['room_no']=$roomLogic->createRoomno();
			$data['create_time']=time();
		}
		$data['room_description']=replaceHousePlatformName(I('post.room_description'));
		$data['room_bak']=trim(I('post.room_bak'));
		$data['feature_tag']=isset($_POST['feature_tag'])?1:0;
		$data['girl_tag']=I('post.girl_tag');
		$data['ext_examineinfo']=trim(I('post.ext_examineinfo'));
		$data['update_time']=time();
		$data['update_man']=getLoginName();
		$room_status=$data['status'];
		$data['status']=I('post.status');
		if(isset($_POST['main_img'])){
			$main_img=explode(",", $_POST['main_img']);
			if($data['main_img_id'] != $main_img[0]){
				$data['main_img_id']=$main_img[0];
				$data['main_img_path']=$main_img[1];
				//切换主图
				$handleImage=new \Logic\HouseImgLogic();
				$handleImage->updateSortindexByid($data['main_img_id'],$data['id']);
			}
		}
		if(empty($data['create_man'])){
			$data['create_man']=$data['update_man'];
		}
		$data['up_count']=0;
		if($data['status']==2){
			$data['up_count']=$_POST['up_count'];
		}
		$result=$roomLogic->updateModel($data);
		if($result){
			//更新缓存
			$roomLogic->updateHouseroomCache($data);
			//操作房间查询表
			$handleSelect=new \Logic\HouseSelectLogic();
			if($data['status']==2 && $room_status==2){
				$is_alone_wc=strpos($data['room_equipment'],'1112')!==false?1:0;
				$is_alone_kitchen=strpos($data['room_equipment'],'1113')!==false?1:0;
				$is_alone_yangtai=strpos($data['room_equipment'],'1111')!==false?1:0;
				$is_alone_kongtiao=strpos($data['room_equipment'],'1102')!==false?1:0;
				$is_alone_chuang=strpos($data['room_equipment'],'1104')!==false?1:0;
				$limitRefreshDal=new \Home\Model\customerlimitrefresh();
				$limitRefreshModel=$limitRefreshDal->modelFind(array('customer_id' =>$data['customer_id'] ));
				if($limitRefreshModel!=null && $limitRefreshModel!=false){
				  //无效刷新
				  $handleSelect->updateModelByRoomid(array('room_id'=>$data['id'],'room_area'=>$data['room_area'],'room_money'=>$data['room_money'],'low_price'=>$data['low_price'],'is_alone_wc'=>$is_alone_wc,'is_alone_kitchen'=>$is_alone_kitchen,
				  	'is_limit_girl'=>$data['girl_tag'],'is_alone_yangtai'=>$is_alone_yangtai,'is_alone_kongtiao'=>$is_alone_kongtiao,'is_alone_chuang'=>$is_alone_chuang));
				}else{
					$handleSelect->updateModelByRoomid(array('room_id'=>$data['id'],'room_area'=>$data['room_area'],'room_money'=>$data['room_money'],'low_price'=>$data['low_price'],'is_alone_wc'=>$is_alone_wc,'is_alone_kitchen'=>$is_alone_kitchen,
					'is_limit_girl'=>$data['girl_tag'],'update_time'=>time(),'is_alone_yangtai'=>$is_alone_yangtai,'is_alone_kongtiao'=>$is_alone_kongtiao,'is_alone_chuang'=>$is_alone_chuang));
				}
				
			}else if($data['status']==2 && $room_status!=2){
				//保障金
				$is_baozhang=0;
				$handleCustomerinfo=new \Logic\CustomerInfo();
				$customerinfoModel=$handleCustomerinfo->getPrincipalByCustomerid($data['customer_id']);
				if($customerinfoModel!==false && $customerinfoModel['margin']>0){
					$is_baozhang=1;
				}
				$handleSelect->addModel($data['id'],$is_baozhang);
			}else{
				$handleSelect->deleteModelByRoomid($data['id']);
			}
			//add by 12/28 ,记录日志
			$recordHandle=new \Logic\HouseupdatelogLogic();
			$recordData['id']=guid();
			$recordData['house_id']=$data['id'];
			$recordData['house_type']=2;
			$recordData['update_man']=$data['update_man'];
			$recordData['update_time']=$data['update_time'];
			$recordData['operate_type']='修改房间';
			$recordHandle->addModel($recordData);
			if($room_status==3 && $data['status']!=3){
				//解绑租客信息
				$handleRenter=new \Logic\HouseRoomRenterLogic();
				$handleRenter->updateStatusByRoomId($data['id']);
			}else if($room_status==2 && $data['status']!=2){
				//删除58发布
				$handleLogic=new \Logic\OpenapiLogic();
				$handleLogic->deleteOpenapipush($data['id'],$data['update_man']);
				//发送邮件
				$handleLogic=new \Logic\PushemailLogic();
				$handleLogic->housepushemail($data['id']);
			}
			$handle_type=I('post.handle');
			if($handle_type=="search"){
				$this->success('修改成功',U('HouseRoom/searchroom?no=3&leftno=44'),1);
			}else if($handle_type=="examine"){

			}else{
				$this->success('修改成功',U('HouseRoom/roommanage?no=3&leftno=27&resource_id='.$data['resource_id']),1);
			}
		}else{
			$this->error('操作失败，稍后重试',U('HouseRoom/searchroom?no=3&leftno=44'),1);
		}
	}
	//删除图片
	public function deleteImage(){
		if(isset($_GET['img_id'])){
			$handleImg=new \Logic\HouseImgLogic();
			$result=$handleImg->deleteModelById($_GET['img_id']);
			if($result){
				echo '{"status":"200","msg":"success"}';
			}else{
				echo '{"status":"400","msg":"删除失败"}';
			}
		}else{
			echo '{"status":"400","msg":"删除失败"}';
		}
	}
	//下载图片
	public function downloadImage(){
		if(isset($_GET['img_id'])){
			$handleImg=new \Logic\HouseImgLogic();
			$image_model=$handleImg->getModelById($_GET['img_id']);
			if($image_model !=null){
				if($image_model['city_code']=='001009001'){
					$image_model["img_path"]='shanghai/'.$image_model["img_path"];
				}
				$img_url=C("IMG_SERVICE_URL").$image_model["img_path"].$image_model["img_name"]."_501_501.".$image_model["img_ext"];
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
	/* 得到图片名字，并将其保存在指定位置 */
	public function get_pic_file($img_url,$img_name,$pic_ext) {
		$curl = curl_init($img_url);
		$filename = $img_name.".".$pic_ext;
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$imageData = curl_exec($curl);
		curl_close($curl);
		$tp = @fopen($filename, 'a');
		fwrite($tp, $imageData);
		fclose($tp);
	}
	//删除所有图片
	public function deleteImgs(){
		if(isset($_GET['room_id'])){
			$handleImg=new \Logic\HouseImgLogic();
			$result=$handleImg->deleteModelByRoomId($_GET['room_id']);
			if($result){
				echo '{"status":"200","msg":"success"}';
			}else{
				echo '{"status":"400","msg":"删除失败"}';
			}
		}else{
			echo '{"status":"400","msg":"删除图片失败"}';
		}
	}
	//上传图片
	public function uploadImage(){
		if(isset($_FILES['mypic'])){
			$imgCount=count($_FILES['mypic']['name']);
			$uploadcount=isset($_POST['uploadcount'])?intval($_POST['uploadcount']):0;
			if($imgCount+$uploadcount>9){
				return '最多上传9张图片！';
			}
			$imgSort=I('post.maxSort');
			$imgSort=$imgSort==''?0:intval($imgSort);
			//已经上传的图片数组
			$upload_array=array();
			//echo 'imgCount:'.$imgCount;
			for ($i=0; $i < $imgCount; $i++) { 
				$imgSort++;
				$picname = $_FILES['mypic']['name'][$i];
				$picsize = $_FILES['mypic']['size'][$i];
				//echo 'picname:'.$picname;
				if ($picname != "") {
					$imginfo= getimagesize($_FILES['mypic']['tmp_name'][$i]); 
					$mime=end($imginfo); 
					if(!in_array(strtolower($mime), array('image/gif','image/jpg','image/jpeg','image/png'))){
						return '文件必须是图片格式！';
					}
					$type=explode('/', $mime)[1];
					/*$picname_arr = explode('.', $picname);
					$type=$picname_arr[count($picname_arr)-1];
					$type_lower=strtolower($type);
					if ($type_lower != "gif" && $type_lower != "jpg" && $type_lower != "jpeg" && $type_lower != "png") {
						return '文件必须是图片格式！';
					}*/
					if ($picsize > 1024000*5 || $picsize < 10000) {
						return '图片大小不能超过5M和小于10K';
					}

					$pics = date("YmdHis") . rand(100, 999) .'.'. $type;
					//上传路径
					if($picsize>128000){
					    $imgbinary=$this->compressionImage($_FILES['mypic']['tmp_name'][$i],$type);
						$imgData = base64_encode($imgbinary);
					}else{
						$imgbinary = file_get_contents($_FILES['mypic']['tmp_name'][$i]);
			        	$imgData = base64_encode($imgbinary);
					}
					//echo 'imgData:'.$imgData;
				    $result = $this->uploadImageToServer($_POST['room_id'],$pics,$imgData,$imgSort);
					$upload_success =json_decode($result,true);
				
					if($upload_success['status']=="200"){
						array_push($upload_array, array('imgUrl' => $upload_success['data']['imgUrl'],'imgId' => $upload_success['data']['imgId'],'imgSort'=>$imgSort ));
					}
				}
			}
			return '{"data":'.json_encode($upload_array).'}';
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
	public function uploadImageToServer($room_id,$fileName,$imgData,$imgSort=1){
	    // post提交
	    $post_data = array ();
	    $post_data ['relationId'] = $room_id;
	    $post_data ['fileName'] = $fileName;
	    $post_data ['data']=$imgData;
	    $post_data ['fileSize'] = "10000";
	    $post_data['sortIndex']=$imgSort;
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
	
	//维护租客信息
	public function roomrentermanage(){
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
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);

        if(isset($_GET['resource_id']) && isset($_GET['room_id']) && isset($_GET['room_name'])){
        	//查询当前已有租客信息
			$roomrenterLogic=new \Logic\HouseRoomRenterLogic();
			$renterModel=$roomrenterLogic->getModelByRoomId($_GET['room_id']);
			if($renterModel !=null){
				$this->assign("renterModel",$renterModel);
				$this->assign("handle_type","update");//update
			}else{
				$this->assign("handle_type","add");//add
			}
        	//获取配置信息
        	$handleLogic=new \Logic\HouseResourceLogic();
			$result2=$handleLogic->getResourceParameters();
			if($result2 !=null){
				$age_list='';//年龄范围 
				$num_list='';//人数
				foreach ($result2 as $key => $value) {
					switch ($value['info_type']) {
						case 9:
							$age_list.='<label><input type="radio" name="age" value="'.$value["type_no"].'"/>'.$value["name"].'</label>&nbsp;&nbsp;';
							break;
						case 13:
							$num_list.='<label><input type="radio" name="num" value="'.$value["type_no"].'"/>'.$value["name"].'</label>&nbsp;&nbsp;';
							break;
						default:
							break;
					}
				}
				$this->assign("age_list",$age_list);
				$this->assign("num_list",$num_list);
			}
			$this->assign("resource_id",$_GET['resource_id']);
			$this->assign("room_id",$_GET['room_id']);
			$this->assign("room_name",$_GET['room_name']);
			$this->display();
        }else{
        	$this->error('缺少参数',U('HouseResource/resourcelist'),1);
            return;
        }
		
	}
	//提交租客信息
	public function submitrenter(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
		if(isset($_POST['handle_type']) && isset($_POST['room_id']) && isset($_POST['sex'])){
			$handleRenter=new \Logic\HouseRoomRenterLogic();
			if($_POST['handle_type']=="add"){
				$data['id']=guid();
				$data['room_id']=$_POST['room_id'];
				$data['room_name']=$_POST['room_name'];
				$data['renter_sex']=$_POST['sex'];
				$data['renter_age']=$_POST['age'];
				$data['renter_num']=$_POST['num'];
				$data['create_time']=time();
				$data['create_man']=getLoginName();
				$data['update_time']=$data['create_time'];
				$data['update_man']=$data['create_man'];
				$handleRenter->addModel($data);
			}else{
				$renterModel=$handleRenter->getModelById($_POST['renter_id']);
				if($renterModel !=null){
					$renterModel['renter_sex']=$_POST['sex'];
					$renterModel['renter_age']=$_POST['age'];
					$renterModel['renter_num']=$_POST['num'];
					$renterModel['update_time']=time();
					$renterModel['update_man']=getLoginName();
					$handleRenter->updateModel($renterModel);
				}
			}
			$this->success('租客维护成功！',U('HouseRoom/roommanage?resource_id='.$_POST['resource_id']),1);
		}else{
        	$this->error('缺少参数',U('HouseResource/resourcelist'),1);
            return;
        }
	}
	//刷新房源时间
	public function reflushUpdatetime(){
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '{"status":"201","msg":"请重新登录。"}'; return;
		}
		$room_id=I('get.room_id');
		if(empty($room_id)){
			echo '{"status":"202","msg":"参数错误"}'; return;
		}
    	$roomLogic=new \Logic\HouseRoomLogic();
    	$model=$roomLogic->getModelById($room_id);
    	if($model===false || $model===null){
    		echo '{"status":"400","msg":"房间读取失败"}'; 
    	}else{
    		$limitRefreshDal=new \Home\Model\customerlimitrefresh();
    		$limitRefreshModel=$limitRefreshDal->modelFind(array('customer_id' =>$model['customer_id'] ));
    		if($limitRefreshModel!=null && $limitRefreshModel!=false){
    			//无效刷新
    			echo '{"status":"200","msg":"操作成功"}'; return;
    		}
    		$model['update_time']=time();
			$model['update_man']=$login_name;
			$updateResult=$roomLogic->updateModel($model);
			if($updateResult){
				//操作房间查询表
				$handleSelect=new \Logic\HouseSelectLogic();
				$handleSelect->updateModelByRoomid(array('room_id'=>$room_id,'update_time'=>$model['update_time']));
				//log
				$recordHandle=new \Logic\HouseupdatelogLogic();
				$recordData['id']=guid();
				$recordData['house_id']=$room_id;
				$recordData['house_type']=2;
				$recordData['update_time']=$model['update_time'];
				$recordData['update_man']=$model['update_man'];
				$recordData['operate_type']='刷新时间';
				$recordHandle->addModel($recordData);
				echo '{"status":"200","msg":"操作成功"}'; 
			}else{
				echo '{"status":"400","msg":"操作失败"}'; 
			}
    	}
	    
	}
	//出租（更新状态）
	public function rentupdate(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
        }
        $room_id=I('post.room_id');
        $rentagain=I('post.rentagain');
        if(empty($room_id)){
        	 '{"status":"201","msg":"参数错误"}';
        }
		$roomLogic=new \Logic\HouseRoomLogic();
		$model=$roomLogic->getModelById($room_id);
		if($model==null || $model==false){
			echo '{"status":"202","msg":"房间信息读取失败"}';return;
		}
		if($model['record_status']==0){
			echo '{"status":"203","msg":"房间已经被删除了"}';return;
		}
		if($rentagain=="1"){
			//重新出租
			if($model['status']==2){
				echo '{"status":"204","msg":"房间已经是“未入住”状态"}';return;
			}
			$model['status']=2;
			$model['up_count']=1;
			$model['update_time']=time();
			$model['update_man']=getLoginName();
			$updateResult=$roomLogic->updateModel($model);
			if($updateResult){
				//保障金
				$is_baozhang=0;
				$handleCustomerinfo=new \Logic\CustomerInfo();
				$customerinfoModel=$handleCustomerinfo->getPrincipalByCustomerid($model['customer_id']);
				if($customerinfoModel!==false && $customerinfoModel['margin']>0){
					$is_baozhang=1;
				}
				//操作房间查询表
				$handleSelect=new \Logic\HouseSelectLogic();
				$handleSelect->addModel($room_id,$is_baozhang);
				//更新收藏房源
				$handleLike=new \Logic\HouseLikeLogic();
				$likeData['room_id']=$room_id;
				$likeData['status']=2;
				$handleLike->updateModelByRoomid($likeData);
				//更新看房日程
				$handleLike->updateReserveByRoomid($likeData);
			}
			//add by 12/28 ,记录日志
			$recordHandle=new \Logic\HouseupdatelogLogic();
			$recordData['id']=guid();
			$recordData['house_id']=$room_id;
			$recordData['house_type']=2;
			$recordData['update_man']=$model['update_man'];
			$recordData['update_time']=$model['update_time'];
			$recordData['operate_type']='重新出租房间';
			$recordHandle->addModel($recordData);
			//解绑租客信息
			$handleRenter=new \Logic\HouseRoomRenterLogic();
			$handleRenter->updateStatusByRoomId($room_id);
			echo '{"status":"200","msg":"维护“重新出租”成功！"}';
		}else{
			//出租
			if($model['status']==3){
				echo '{"status":"205","msg":"房间已经是“已出租”状态"}';return;
			}
			$result=$roomLogic->downroomByid($room_id);
			if($result){
				echo '{"status":"200","msg":"维护“已出租”成功！"}';
			}else{
				echo '{"status":"400","msg":"操作失败，稍后重试"}';
			}
		}
	
	}
	//恢复删除
	public function resetDelete(){
		$room_id=I('get.room_id');
		if(empty($room_id)){
			echo '{"status":"401","msg":"缺少参数"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$roomModel=$roomLogic->getModelById($room_id);
		if($roomModel==null || $roomModel==false){
			echo '{"status":"402","msg":"房间读取失败"}';return;
		}
		if($roomModel['record_status']==1){
			echo '{"status":"403","msg":"无需再次恢复"}';return;
		}
		$roomModel['record_status']=1;
		$roomModel['update_time']=time();
		$roomModel['update_man']=getLoginName();
		$updateResult=$roomLogic->updateModel($roomModel);
		if(!$updateResult){
			echo '{"status":"404","msg":"房间操作失败"}';return;
		}
		//更新房源表
		$resourceDal=new \Home\Model\houseresource();
		$updateResult=$resourceDal->updateModel(array('id'=>$roomModel['resource_id'],'record_status'=>$roomModel['record_status'],'update_time'=>$roomModel['update_time'],'update_man'=>$roomModel['update_man']));
		if(!$updateResult){
			echo '{"status":"405","msg":"房源操作失败"}';return;
		}
		if($roomModel['status']==2){
			//添加到搜索表
			$is_baozhang=0;
			$handleCustomerinfo=new \Logic\CustomerInfo();
			$customerinfoModel=$handleCustomerinfo->getPrincipalByCustomerid($roomModel['customer_id']);
			if($customerinfoModel!==false && $customerinfoModel['margin']>0){
				$is_baozhang=1;
			}
			$handleSelect=new \Logic\HouseSelectLogic();
			$handleSelect->addModel($room_id,$is_baozhang);
		}
		//记录日志
		$recordHandle=new \Logic\HouseupdatelogLogic();
		$recordData['id']=guid();
		$recordData['house_id']=$room_id;
		$recordData['house_type']=2;
		$recordData['update_man']=$roomModel['update_man'];
		$recordData['update_time']=$roomModel['update_time'];
		$recordData['operate_type']='恢复删除';
		$recordHandle->addModel($recordData);
		echo '{"status":"200","msg":"操作成功"}';
	}
	/*查询房间（列表）*/
	public function searchroom(){
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
        
        $handleLogic=new \Logic\HouseRoomLogic();
        $viewList = array();
        $condition['totalcnt']=I('get.totalcnt');
        $condition['roomcnt']=I('get.roomcnt');
        $condition['roomupcnt']=I('get.roomupcnt');
        $condition['ownercnt']=I('get.ownercnt');

        $totalCount = $condition['totalcnt']==''?0:$condition['totalcnt'];
        $roomTotalCount = $condition['roomcnt']==''?0:$condition['roomcnt'];
        $roomUpCount = $condition['roomupcnt']==''?0:$condition['roomupcnt'];
        $ownerCount = $condition['ownercnt']==''?0:$condition['ownercnt'];
        //查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['startTime_create']=isset($_GET['startTime_create'])?$_GET['startTime_create']:"";
        $condition['endTime_create']=isset($_GET['endTime_create'])?$_GET['endTime_create']:"";

        $condition['estateName']=trim(I('get.estateName'));
        $condition['estateName']=str_replace('/', 'Slash', $condition['estateName']);//替换特殊字符
        $condition['roomStatus']=isset($_GET['roomStatus'])?$_GET['roomStatus']:"";
        $condition['delState']=I('get.delState');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['business_type']=isset($_GET['business_type'])?$_GET['business_type']:"";
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['create_man']=trim(I('get.create_man'));
        $condition['update_man']=trim(I('get.update_man'));//操作人
        $condition['brand_type']=isset($_GET['brand_type'])?$_GET['brand_type']:"";
        $condition['info_resource_type']=I('get.info_resource_type');
		$condition['info_resource']=I('get.info_resource');

        $condition['region']=isset($_GET['region'])?$_GET['region']:"";
        $condition['scope']=isset($_GET['scope'])?$_GET['scope']:"";
        $condition['is_commission']=isset($_GET['is_commission'])?$_GET['is_commission']:"";
        $condition['third_no']=trim(I('get.third_no'));
        $condition['moneyMin']=trim(I('get.moneyMin'));
        $condition['moneyMax']=trim(I('get.moneyMax'));
         $condition['houseareaMin']=trim(I('get.houseareaMin'));
         $condition['houseareaMax']=trim(I('get.houseareaMax'));
         $condition['roomareaMin']=trim(I('get.roomareaMin'));
         $condition['roomareaMax']=trim(I('get.roomareaMax'));
         $condition['principal_man']=trim(I('get.principal_man'));
         $condition['rent_type']=I('get.rent_type');
         $condition['room_num']=I('get.room_num');
         $condition['is_owner']=I('get.is_owner');
         $condition['isMonth']=I('get.isMonth');
         $condition['isFee']=I('get.isFee');
         $condition['isVedio']=I('get.isVedio');
         $condition['isGroup']=I('get.isGroup');
         $condition['isRental']=I('get.isRental');
        $hadCondition=false;$pageSHow='';
        foreach ($condition as $k1 => $v1) {
        	if($v1!=''){
        		$hadCondition=true;
        		break;
        	}
        }
        if(I('searchtype')=='summary'){
        	//统计全部
        	$totalCountModel = $handleLogic->getModelListCount($condition);
        	if($totalCountModel !==null && $totalCountModel !==false && $totalCountModel[0]['totalCount']>=1){
        		$totalCount=$totalCountModel[0]['totalCount'];//总条数
        		$roomTotalCount=$totalCountModel[0]['roomTotalCount'];
        		$roomUpCount=$totalCountModel[0]['roomUpCount'];
        		$ownerCount=$totalCountModel[0]['ownerCount'];
        	}
        }
        else if($hadCondition!==false){
	        if(trim($condition['roomNo'])!='' || trim($condition['third_no'])!='' || (trim($condition['clientPhone'])!='' && I('searchtype')!='select')){
	            //（特殊查询，例如-房间编号），分开查询结果
	        	$viewList = $handleLogic->getModelListByCondition($condition);
	        	//整理列表数据
	        	$array_phone=array();
	        	foreach ($viewList as $key => $value) {
	        		array_push($array_phone, $value['client_phone']);
	        		$totalCount+=1;
	        		$roomTotalCount+=$value['total_count'];
	        		$roomUpCount+=$value['up_count'];
	        	}
	        	if(count($array_phone)>0){
	        		$ownerCount=count(array_unique($array_phone));
	        	}
	        	if($totalCount>=15){
	        		$totalCount=$totalCount.'+';
	        		$roomTotalCount=$roomTotalCount.'+';
	        		$roomUpCount=$roomUpCount.'+';
	        		$ownerCount=$ownerCount.'+';
	        	}
	        }else{
	        	if(I('get.p')!="" && $totalCount>0){
	        	    //点击分页，不用查询汇总
	        	}else{
	        		$totalCountModel = $handleLogic->getModelListCount($condition);
	        		if($totalCountModel !==null && $totalCountModel !==false && $totalCountModel[0]['totalCount']>=1){
	        			$totalCount=$totalCountModel[0]['totalCount'];//总条数
	        			$roomTotalCount=$totalCountModel[0]['roomTotalCount'];
	        			$roomUpCount=$totalCountModel[0]['roomUpCount'];
	        			$ownerCount=$totalCountModel[0]['ownerCount'];
	        		}
	        	}
	        	$condition['totalcnt']=$totalCount;
	        	$condition['roomcnt']=$roomTotalCount;
	        	$condition['roomupcnt']=$roomUpCount;
	        	$condition['ownercnt']=$ownerCount;
	        	$Page= new \Think\Page($totalCount,8);//分页
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $pageSHow=$Page->show();
	        	$viewList = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
	        }
        }
        /*查询条件（业务类型）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getResourceParameters();
		if($result !=null && $result !=false){
			$typeString='';//业务类型
			$brandString='<option value="none">无</option><option value="all">有</option>';//品牌
			$roomtypeString='';
			foreach ($result as $key => $value) {
				if($value['info_type']==15){
					$typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}else if($value['info_type']==16){
					$brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}else if($value['info_type']==2){
					$roomtypeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
				}
			}	
			$this->assign("businessTypeList",$typeString);
			$this->assign("brandTypeList",$brandString);
			$this->assign("roomTypeList",$roomtypeString);
		}
		/*查询条件（房间负责人）*/
        $result=$handleResource->getHouseHandleList();
		$createmanString='';
		foreach ($result as $key => $value) {
			$createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
		}	
		$this->assign("createManList",$createmanString);
		//数据来源
		$result=getOneInforesource();
		$infoResourceString='';
		foreach ($result as $key => $value) {
			$infoResourceString.='<option value="'.$key.'">'.$value.'</option>';
		}
		$this->assign("infoResourceTypeList",$infoResourceString);
		$infoResourceString='';
		if(!empty($condition['info_resource_type'])){
			
			$result=getTwoInforesource($condition['info_resource_type']);
			foreach ($result as $key => $value) {
				$infoResourceString.='<option value="'.$key.'">'.$value.'</option>';
			}
		}
		$this->assign("infoResourceList",$infoResourceString);
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
        $this->assign("totalcnt",$totalCount);
        $this->assign("roomcnt",$roomTotalCount);
        $this->assign("roomupcnt",$roomUpCount);
        $this->assign("ownercnt",$ownerCount);
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
	//导出excel
    public function downloadExcel(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
    	//查询条件
        $condition['startTime']=isset($_GET['startTime'])?$_GET['startTime']:"";
        $condition['endTime']=isset($_GET['endTime'])?$_GET['endTime']:"";
        $condition['startTime_create']=isset($_GET['startTime_create'])?$_GET['startTime_create']:"";
        $condition['endTime_create']=isset($_GET['endTime_create'])?$_GET['endTime_create']:"";
        
        $condition['estateName']=trim(I('get.estateName'));
        $condition['roomStatus']=isset($_GET['roomStatus'])?$_GET['roomStatus']:"";
        $condition['delState']=I('get.delState');
        $condition['roomNo']=trim(I('get.roomNo'));
        $condition['business_type']=isset($_GET['business_type'])?$_GET['business_type']:"";
        $condition['clientPhone']=trim(I('get.clientPhone'));
        $condition['create_man']=trim(I('get.create_man'));
        $condition['update_man']=trim(I('get.update_man'));//操作人
        $condition['info_resource_type']=I('get.info_resource_type');
		$condition['info_resource']=I('get.info_resource');

        $condition['brand_type']=isset($_GET['brand_type'])?$_GET['brand_type']:"";
        $condition['region']=isset($_GET['region'])?$_GET['region']:"";
        $condition['scope']=isset($_GET['scope'])?$_GET['scope']:"";
        $condition['is_commission']=isset($_GET['is_commission'])?$_GET['is_commission']:"";
        $condition['third_no']=I('get.third_no');
        $condition['moneyMin']=I('get.moneyMin');
        $condition['moneyMax']=I('get.moneyMax');
        $condition['houseareaMin']=I('get.houseareaMin');
        $condition['houseareaMax']=I('get.houseareaMax');
        $condition['roomareaMin']=I('get.roomareaMin');
        $condition['roomareaMax']=I('get.roomareaMax');
        $condition['principal_man']=I('get.principal_man');
        $condition['rent_type']=I('get.rent_type');
        $condition['room_num']=I('get.room_num');
        $condition['is_owner']=I('get.is_owner');
        $condition['isMonth']=I('get.isMonth');
        $condition['isFee']=I('get.isFee');
		$condition['isVedio']=I('get.isVedio');
		$condition['isGroup']=I('get.isGroup');
        $condition['isRental']=I('get.isRental');
        $hadCondition=false;
        foreach ($condition as $k1 => $v1) {
        	if($v1!=''){
        		$hadCondition=true;
        		break;
        	}
        }
        if($hadCondition===false){
        	return $this->error('请添加筛选条件！',U('HouseRoom/searchroom',array('no'=>'3','leftno'=>'41')),0);
        }
    	$handleLogic=new \Logic\HouseRoomLogic();
    	$list = $handleLogic->getDownloadList($condition);
    
        $title=array(
	        'house_no'=>'房源编号',
	        'room_no'=>'房间编号',
	        'is_owner'=>'发布人属性',
	        'info_resource'=>'数据来源',
	        'region_name'=>'区域',
	        'scope_name'=>'板块',
	        'estate_name'=>'小区名称',
	        'brand_type'=>'品牌名称',
	        'business_type'=>'业务类型',
	        'room_num'=>'室','hall_num'=>'厅','wei_num'=>'卫',
	        'rent_type'=>'租赁类型',
	        'rental_type'=>'转租',
	        'area'=>'房源面积',
	        'room_name'=>'单间名称',
	        'room_area'=>'面积（㎡）',
	        'room_money'=>'租金（元）',
	        'client_name'=>'发布人姓名',
	        'client_phone'=>'发布人电话',
	        'status'=>'房间状态',
	        'is_commission'=>'佣金',
	        'is_monthly'=>'包月',
	        'is_fee'=>'付费',
	        'had_vedio'=>'视频',
	        'record_status'=>'删除状态',
	        'create_time'=>'创建日期',
	        'update_time'=>'更新日期',
	        'update_man'=>'最近操作人',
	        'create_man'=>'房间负责人',
	        'principal_man'=>'发布人负责人'
        );
        $excel[]=$title;
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
            $value['create_time']=date("Y-m-d H:i:s",$value['create_time']); 
            $value['update_time']=date("Y-m-d H:i:s",$value['update_time']); 
            switch ($value['business_type']) {
            	case '1501':
            		$value['business_type']='小区住宅';
            		break;
            	case '1502':
            		$value['business_type']='集中公寓';
            		break;
            	case '1503':
            		$value['business_type']='酒店长租';
            		break;
            	default:
            		$value['business_type']='';
            		break;
            }
            switch ($value['rent_type']) {
            	case '1':
            		$value['rent_type']='合租';
            		break;
            	case '2':
            		$value['rent_type']='整租';
            		break;
            	default:
            		$value['rent_type']='';
            		break;
            }
            switch ($value['is_owner']) {
            	case '0':
            		$value['is_owner']='租客';
            	break;
            	case '3':
            		$value['is_owner']='个人房东';
            	break;
            	case '4':
            		$value['is_owner']='职业房东';
            	break;
            	case '5':
            		$value['is_owner']='中介经纪人';
            	break;
            	default:
            		$value['is_owner']='';
            	break;
            }
            switch ($value['rental_type']) {
            	case '1':
            		$value['rental_type']='个人转租';
            	break;
            	case '2':
            		$value['rental_type']='中介';
            	break;
            	case '3':
            		$value['rental_type']='职业房东';
            	break;
            	case '4':
            		$value['rental_type']='房东直租';
            	break;
            	default:
            		$value['rental_type']='';
            	break;
            }
           	if($value['is_commission'] == 0 && $value['is_monthly'] == 0) {
           		$value['is_fee'] = '否';
           	} else {
           		$value['is_fee'] = '是';
           	}
            $value['is_commission']=$value['is_commission']==1?'是':'否';
            $value['is_monthly']=$value['is_monthly']==1?'是':'否';
            if(!$downAll){
            	$value['client_phone']=substr_replace($value['client_phone'], '****', 4,4);
            }
            switch ($value['status']) {
            	case '0':
            		$value['status']='待审核';
            		break;
            	case '1':
            		$value['status']='审核未通过';
            		break;
            	case '2':
            		$value['status']='未入住';
            		break;
            	case '3':
            		$value['status']='已出租';
            		break;
            	case '4':
            		$value['status']='待维护';
            		break;
            	default:
            		$value['status']='';
            		break;
            }
            switch ($value['had_vedio']) {
            	case '0':
            		$value['had_vedio']='否';
            		break;
            	case '1':
            		$value['had_vedio']='是';
            		break;
            	default:
            		$value['had_vedio']='';
            		break;
            }
            if($value['record_status']=="0"){
            	$value['record_status']="已删除";
            }else{
            	$value['record_status']="未删除";
            }
            if($value['brand_type']!=''){
            	$value['brand_type']=$brand_list[$value['brand_type']];
            }
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '查询房间');
        $xls->addArray($excel);
        $xls->generateXML('查询房间'.date("YmdHis"));
    }
	/*置顶房间 V2 */
	public function settopRoomV2(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_GET['room_no'])){
			$handleRoom=new \Logic\HouseRoomLogic();
			$roomModel=$handleRoom->getTopRoomByRoomno($_GET['room_no']);
			//判断房间是否存在
			if($roomModel==null || $roomModel==false){
				echo '{"status":"403","msg":"房间编号不存在"}';
			}else{
				//判断是否已经置顶
				if($roomModel['sort_index']>0){
					echo '{"status":"402","msg":"该房间已经在置顶列表中"}';
				}else{
					$result=$handleRoom->setTopRoomById($roomModel['id']);
					if($result){
						//add by 12/28 ,记录日志
						$recordHandle=new \Logic\HouseupdatelogLogic();
						$recordData['id']=guid();
						$recordData['house_id']=$roomModel['id'];
						$recordData['house_type']=2;
						$recordData['update_man']=getLoginName();
						$recordData['update_time']=time();
						$recordData['operate_type']='置顶房间';
						$recordHandle->addModel($recordData);
						echo '{"status":"200","msg":"置顶成功"}';
					}else{
						echo '{"status":"400","msg":"置顶失败，服务器忙"}';
					}
				}
			}
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	/*取消置顶房间 */
	public function cancelSettopRoom(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_GET['room_id']) && isset($_GET['sort_index'])){
			$handleRoom=new \Logic\HouseRoomLogic();
			$result=$handleRoom->cancelTopRoomById($_GET['room_id']);
			if($result){
				//$handleRoom->updateTopRoomSorts($_GET['sort_index']);
				//add by 12/28 ,记录日志
				$recordHandle=new \Logic\HouseupdatelogLogic();
				$recordData['id']=guid();
				$recordData['house_id']=$_GET['room_id'];
				$recordData['house_type']=2;
				$recordData['update_man']=getLoginName();
				$recordData['update_time']=time();
				$recordData['operate_type']='取消置顶';
				$recordHandle->addModel($recordData);
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"402","msg":"操作失败"}';
			}
			
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	/*刷新置顶房间 */
	public function reflushTopRoom(){
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '{"status":"404","msg":"登录失效"}';return;
		}
		if(isset($_GET['room_id']) && isset($_GET['sort_index'])){
			$handleRoom=new \Home\Model\houseroom();
			$result=$handleRoom->reflushTopRoomById($_GET['room_id']);
			if($result){
				//记录日志
				$recordHandle=new \Logic\HouseupdatelogLogic();
				$recordData['id']=guid();
				$recordData['house_id']=$_GET['room_id'];
				$recordData['house_type']=2;
				$recordData['update_man']=$login_name;
				$recordData['update_time']=time();
				$recordData['operate_type']='刷新置顶';
				$recordHandle->addModel($recordData);
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"402","msg":"操作失败"}';
			}
			
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	/*置顶房间（列表）*/
	public function toproomlist(){
		header ( "Content-type: text/html; charset=utf-8" );
		echo '该页面已经失效，请到另外的权限操作页面.';
	}
		//导出excel（置顶房源列表）
	    public function downloadToprooms(){
			$handleCommonCache=new \Logic\CommonCacheLogic();
	         if(!$handleCommonCache->checkcache()){
	            return $this->error('非法操作',U('Index/index'),1);
	         }
	    	$handleLogic=new \Logic\HouseRoomLogic();
	    	$list = $handleLogic->getTopRoomList(array('roomNo'=>''),0,1000);
	        $title=array(
		        'house_no'=>'房源编号','room_no'=>'房间编号','region_name'=>'区域','scope_name'=>'板块','estate_name'=>'小区名称','room_name'=>'房间名称',
		        'room_area'=>'面积（㎡）','room_money'=>'租金（元）','status'=>'出租状态','create_man'=>'房间负责人', 'sort_index'=>'排序','id'=>''
	        );
	        $excel[]=$title;
	        foreach ($list as $key => $value) {
	            $value['status']='未入住';
	            $value['id']='';
	            $excel[]=$value;
	        }
	        Vendor('phpexcel.phpexcel');
	        $xls = new \Excel_XML('UTF-8', false, '置顶房源列表');
	        $xls->addArray($excel);
	        $xls->generateXML('置顶房源列表'.date("YmdHis"));
	    }

	public function moveUpDownTopRoom(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_GET['room_id']) && isset($_GET['sort_index']) && isset($_GET['room_id2']) && isset($_GET['sort_index2'])){
			$handleRoom=new \Logic\HouseRoomLogic();
			$handleRoom->modifyTopRoomSort($_GET['room_id'],$_GET['sort_index'],$_GET['room_id2'],$_GET['sort_index2']);
		
			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	public function setRoomTopFirst(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_GET['room_id']) && isset($_GET['sort_index']) ){
			$handleRoom=new \Home\Model\houseroom();
			$handleRoom->SetRoomTopFirst($_GET['room_id'],$_GET['sort_index']);
			echo '{"status":"200","msg":"操作成功"}';
		}else{
			echo '{"status":"400","msg":"缺少参数"}';
		}
	}
	
	/*检查房源编号是否生成 */
	public function checkHouseno(){
		if(!isset($_GET['room_id']) || empty($_GET['room_id'])){
			echo '{"status":"404","msg":"fail"}';
			return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$resource_data=$roomLogic->getResourceInfoByRoomid($_GET['room_id']);
		if($resource_data!=null && $resource_data!=false){
			if(empty($resource_data[0]['house_no'])){
				echo '{"status":"404","msg":"fail"}';
			}else{
				echo '{"status":"200","msg":"success"}';
			}
			
		}else{
			echo '{"status":"404","msg":"fail"}';
		}
	}
  //旋转图片上传
  public function rotateupload(){
        $rotate=I('get.rotate');
        $imgurl=I('get.imgurl');
        if($rotate!=""&&$imgurl!=""){
        	   $rotate=$rotate*90;
	          $source = imagecreatefromjpeg($imgurl);
			  $stream = imagerotate($source,$rotate, 0);
			  $result=imagejpeg($stream,$imgurl,100);
			  @imagedestroy($rotate);
			  if($result){
			  	echo '{"status":"200","msg":""}';
			  }else{
			  	echo '{"status":"404","msg":""}';
			  }
         }
		
  }

  /*置顶管理 */
  	public function toproommanage(){
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
  		
  		$condition['room_no']=trim(I('get.room_no'));
  		$condition['rent_type']=I('get.rent_type');
  		if($condition['rent_type']==3){
  			$condition['is_gongyu']=1;
  		}
  		$condition['top_type']=I('get.top_type');
  		$condition['region']=I('get.region');
  		$condition['scope']=I('get.scope');
  		$condition['subwayline_id']=I('get.subwayline_id');
  		$condition['subway_id']=I('get.subway_id');

  		$handleLogic=new \Logic\HouseSelectLogic();
        $viewList = array();$pageSHow='';
        $condition['totalcnt']=I('get.totalcnt');
        $condition['flag']=I('get.flag');
        $totalCount = $condition['totalcnt']==''?0:$condition['totalcnt'];
        if($condition['flag']=='query'){
        	if(I('get.p')=="" || $totalCount==0){
        		//总条数
        	    $totalCount_model = $handleLogic->getTopCount($condition);
        	    if($totalCount_model!=null && count($totalCount_model)>0){
        	    	$totalCount=$totalCount_model[0]['cnt'];
        	    }
        	}
        	if($totalCount>0){
	        	$condition['totalcnt']=$totalCount;
	        	$Page= new \Think\Page($totalCount,15);//分页
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $pageSHow=$Page->show();
	        	$viewList = $handleLogic->getTopList($condition," order by is_top asc ",$Page->firstRow,$Page->listRows);
        	}
        }
		
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
  			$scopeResult=$handleResource->getRegionScopeList();
  			foreach ($scopeResult as $key => $value) {
  				if($condition['region']==$value['parent_id']){
  					$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
  				}
  			}
  		}
  		/*查询条件（地铁）*/
  		$handleSubway = new \Logic\SubwayLogic();
  		$subwaylineList='';$subwayList='<option value=""></option>';
  		$result=$handleSubway->getAllSubwayLine();
  		if($result !=null){
  			foreach ($result as $k => $v) {
  				$subwaylineList.='<option value="'.$v["id"].'">'.$v["subwayline_name"].'</option>';
  			}	
  		}
  		if(!empty($condition['subwayline_id'])){
  			$result=$handleSubway->getSubwayByLine($condition['subwayline_id']);
  			if($result!=null){
  				foreach ($result as $k => $v) {
  					$subwayList.='<option value="'.$v["id"].'">'.$v["subway_name"].'</option>';
  				}
  			}
  		}
  		 $this->assign("subwaylineList",$subwaylineList);
        $this->assign("subwayList",$subwayList);
  		$this->assign("regionList",$regionList);
  		$this->assign("scopeList",$scopeList);
  		 $this->assign("list",$viewList);
        $this->assign("totalcnt",$totalCount);
        $this->assign("pageSHow",$pageSHow);
       
  		$this->display();
  	}
	//导出置顶列表
    public function downloadToplist(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
    	
		$condition['room_no']=trim(I('get.room_no'));
		$condition['rent_type']=I('get.rent_type');
		if($condition['rent_type']==3){
			$condition['is_gongyu']=1;
		}
		$condition['top_type']=I('get.top_type');
		$condition['region']=I('get.region');
		$condition['scope']=I('get.scope');
		$condition['subwayline_id']=I('get.subwayline_id');
		$condition['subway_id']=I('get.subway_id');

		$handleLogic=new \Logic\HouseSelectLogic();
		$list = $handleLogic->getTopList($condition," order by is_top asc ",0,1000);

        $excel[]=array(
	        'room_no'=>'房间编号', 'estate_name'=>'小区名称','rent_type'=>'置顶类型','top_type'=>'置顶位','region_name'=>'行政区','scope_name'=>'商圈',
	       'subwayline_name'=>'地铁线','subway_name'=>'地铁站', 'room_money'=>'租金','create_man'=>'创建人','toproom_createtime'=>'创建时间',
        );
        foreach ($list as $key => $value) {
            $value['toproom_createtime']=$value['toproom_createtime']>0?date("Y-m-d H:i:s",$value['toproom_createtime']):''; 
            $value['region_id']='';$value['scope_id']='';
            $value['subwayline_id']='';$value['subway_id']='';
            $value['id']='';
            $value['is_top']='';
            $value['room_id']='';
            switch ($value['rent_type']) {
            	case '1':
            		$value['rent_type']='合租';
            		break;
            	case '2':
            		$value['rent_type']='整租';
            		break;
            	default:
            		break;
            }
            if($value['is_gongyu']==1){
            	$value['rent_type']='公寓';
            }
            $value['is_gongyu']='';
            switch ($value['top_type']) {
            	case '1':
            		$value['top_type']='首页';
            		$value['region_name']='';
            		$value['scope_name']='';
            		break;
            	case '2':
            		$value['top_type']='全城';
            		$value['region_name']='';
            		$value['scope_name']='';
            		break;
            	case '3':
            		$value['top_type']='行政区';
            		$value['scope_name']='';
            		break;
            	case '4':
            		$value['top_type']='商圈';
            		break;
            	case '5':
            		$value['top_type']='地铁线';
            		$value['subway_name']='';
            		$value['region_name']='';
            		$value['scope_name']='';
            		break;
            	case '5':
            		$value['top_type']='地铁站';
            		$value['region_name']='';
            		$value['scope_name']='';
            		break;
            	default:
            		$value['top_type']='';
            		break;
            }
          
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '置顶列表');
        $xls->addArray($excel);
        $xls->generateXML('置顶列表'.date("YmdHis"));
    }
  	public function toproomedit(){
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
  		
  		$condition['rent_type']=I('get.rent_type');
  		$condition['top_type']=I('get.top_type');
  		$condition['region']=I('get.region');
  		$condition['scope']=I('get.scope');
  		$condition['subwayline_id']=I('get.subwayline_id');
  		$condition['subway_id']=I('get.subway_id');
  		if($condition['rent_type']==3){
  			$condition['is_gongyu']=1;
  		}

  		$top_id=I('get.topid');
  		$handleLogic=new \Logic\HouseSelectLogic();
  		if(!empty($top_id)){
  			//修改置顶
  			$selectModel=$handleLogic->getHouseselectById($top_id);
  			if($selectModel!=null){
  				$condition['rent_type']=$selectModel['rent_type'];
  				$condition['is_gongyu']=$selectModel['is_gongyu'];
  				$condition['top_type']=$selectModel['top_type'];
  				if($condition['top_type']=='3'){
  					$condition['region']=$selectModel['region_id'];
  				}else if($condition['top_type']=='4'){
  					$condition['region']=$selectModel['region_id'];
  					$condition['scope']=$selectModel['scope_id'];
  				}else if($condition['top_type']=='5'){
  					$condition['subwayline_id']=$selectModel['subwayline_id'];
  				}else if($condition['top_type']=='6'){
  					$condition['subwayline_id']=$selectModel['subwayline_id'];
  					$condition['subway_id']=$selectModel['subway_id'];
  				}
  			}
  		}
  		$list=array();
  		if(!empty($condition['top_type'])){
  			if($condition['top_type']=='2' || ($condition['top_type']=='3' && !empty($condition['region'])) || ($condition['top_type']=='4' && !empty($condition['scope']))){
				$list = $handleLogic->getTopList($condition," order by is_top asc ",0,20);
  			}else if(($condition['top_type']=='5' && !empty($condition['subwayline_id'])) || ($condition['top_type']=='6' && !empty($condition['subway_id']))){
  				$list = $handleLogic->getTopList($condition," order by is_top asc ",0,20);
  			}
  		}
  		$this->assign("condition",$condition);
  		$this->assign("list",$list);

  		/*查询条件（区域板块）*/
  		$handleResource=new \Logic\HouseResourceLogic();
  		$regionList='';$scopeList='<option value=""></option>';
  		$regionResult=$handleResource->getRegionList();
  		if($regionResult !=null){
  			foreach ($regionResult as $key => $value) {
  				$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
  			}	
  		}
  		if(!empty($condition['region'])){
  			$scopeResult=$handleResource->getRegionScopeList();
  			foreach ($scopeResult as $key => $value) {
  				if($condition['region']==$value['parent_id']){
  					$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
  				}
  			}
  		}
		/*查询条件（地铁）*/
		$handleSubway = new \Logic\SubwayLogic();
		$subwaylineList='';$subwayList='<option value=""></option>';
		$result=$handleSubway->getAllSubwayLine();
		if($result !=null){
			foreach ($result as $k => $v) {
				$subwaylineList.='<option value="'.$v["id"].'">'.$v["subwayline_name"].'</option>';
			}	
		}
		if(!empty($condition['subwayline_id'])){
			$result=$handleSubway->getSubwayByLine($condition['subwayline_id']);
			if($result!=null){
				foreach ($result as $k => $v) {
					$subwayList.='<option value="'.$v["id"].'">'.$v["subway_name"].'</option>';
				}
			}
		}
		$this->assign("subwaylineList",$subwaylineList);
        $this->assign("subwayList",$subwayList);
  		$this->assign("regionList",$regionList);
  		$this->assign("scopeList",$scopeList);
  		$this->display();
  	}
  	public function addToproom(){
  		$create_man=trim(getLoginName());
  		if($create_man==''){
  			echo '{"status":"400","msg":"请重新登录"}';return;
  		}
  		$room_no=trim(I('post.room_no'));
  		if($room_no==''){
  			echo '{"status":"400","msg":"编号为空"}';return;
  		}
  		$top_type=I('post.top_type');
  		$rent_type=I('post.rent_type');
  		if(empty($top_type)){
  			echo '{"status":"401","msg":"请选择置顶位"}';return;
  		}
  		$roomDal=new \Home\Model\houseroom();
  		$roomResult=$roomDal->getResultByWhere("id,resource_id,status,record_status","where room_no='$room_no'","");
  		if($roomResult==null || count($roomResult)==0){
  			echo '{"status":"402","msg":"房间编号不存在"}';return;
  		}
  		if($roomResult[0]['status']!=2 || $roomResult[0]['record_status']==0){
  			echo '{"status":"403","msg":"房间状态错误或已删除"}';return;
  		}
  		$handleResource=new \Logic\HouseResourceLogic();
  		$resourceModel=$handleResource->getModelById($roomResult[0]['resource_id']);
  		if($resourceModel==null || $resourceModel==false){
  			echo '{"status":"405","msg":"房源信息不存在"}';return;
  		}
  		$is_gongyu=0;
  		if($rent_type==3){
  			$is_gongyu=1;
  			if($resourceModel['business_type']!='1502'){
  				echo '{"status":"406","msg":"此房源不属于公寓类型"}';return;
  			}
  		}else if($resourceModel['rent_type']!=$rent_type){
  			echo '{"status":"406","msg":"合租/整租类型错误"}';return;
  		}
  		$rent_type=$resourceModel['rent_type'];

  		$region=I('post.region');
  		$scope=I('post.scope');
  		$subwayline=I('post.subwayline');
  		$subway=I('post.subway');
  		$subwayline=$subwayline==''?0:$subwayline;
  		$subway=$subway==''?0:$subway;
  		$is_top=1;
  		$handleLogic=new \Logic\HouseSelectLogic();
  		$chongfu=false;
  		switch ($top_type) {
  			case '2':
  				//全城
				$listResult = $handleLogic->getTopList(array('top_type'=>$top_type,'rent_type'=>$rent_type,'is_gongyu'=>$is_gongyu)," order by is_top desc ",0,40);
				if($listResult!=null){
					foreach ($listResult as $key => $value) {
						if($value['room_no']==$room_no){
							$chongfu=true;break;
						}
					}
					if($chongfu){
						echo '{"status":"502","msg":"置顶位已经存在"}';return;
					}
					if(count($listResult)>0){
						$is_top=$listResult[0]['is_top']+1;
					}
					
				}
  				break;
  			case '3':
  				//区域
	  			if($region!=$resourceModel['region_id']){
	  				echo '{"status":"407","msg":"行政区不符"}';return;
	  			}
  				$listResult = $handleLogic->getTopList(array('top_type'=>$top_type,'region'=>$resourceModel['region_id'],'rent_type'=>$rent_type,'is_gongyu'=>$is_gongyu)," order by is_top desc ",0,20);
				if($listResult!=null){
					foreach ($listResult as $key => $value) {
						if($value['room_no']==$room_no){
							$chongfu=true;break;
						}
					}
					if($chongfu){
						echo '{"status":"502","msg":"置顶位已经存在"}';return;
					}
					if(count($listResult)>0){
						$is_top=$listResult[0]['is_top']+1;
					}
				}
  				break;
  			case '4':
  				//板块
	  			if($scope!=$resourceModel['scope_id']){
	  				echo '{"status":"408","msg":"商圈不符"}';return;
	  			}
  				$listResult = $handleLogic->getTopList(array('top_type'=>$top_type,'region'=>$resourceModel['region_id'],'scope'=>$resourceModel['scope_id'],'rent_type'=>$rent_type,'is_gongyu'=>$is_gongyu)," order by is_top desc ",0,20);
				if($listResult!=null){
					foreach ($listResult as $key => $value) {
						if($value['room_no']==$room_no){
							$chongfu=true;break;
						}
					}
					if($chongfu){
						echo '{"status":"502","msg":"置顶位已经存在"}';return;
					}
					if(count($listResult)>0){
						$is_top=$listResult[0]['is_top']+1;
					}
				}
  				break;
  			case '5':
  				//地铁线
  				$subwayDal=new \Home\Model\subway();
  				$subwaylist=$subwayDal->getSubwayestateByWhere(" where estate_id='".$resourceModel['estate_id']."'");
  				$had_subway=false;
  				if($subwaylist!=null){
  					foreach ($subwaylist as $k => $v) {
  						if($v['subwayline_id']==$subwayline){
  							$had_subway=true;break;
  						}
  					}
  				}
	  			if(!$had_subway){
	  				echo '{"status":"407","msg":"地铁线不符"}';return;
	  			}
  				$listResult = $handleLogic->getTopList(array('top_type'=>$top_type,'subwayline_id'=>$subwayline,'rent_type'=>$rent_type,'is_gongyu'=>$is_gongyu)," order by is_top desc ",0,20);
				if($listResult!=null){
					foreach ($listResult as $key => $value) {
						if($value['room_no']==$room_no){
							$chongfu=true;break;
						}
					}
					if($chongfu){
						echo '{"status":"502","msg":"置顶位已经存在"}';return;
					}
					if(count($listResult)>0){
						$is_top=$listResult[0]['is_top']+1;
					}
				}
  				break;
  			case '6':
  				//地铁站
  				$subwayDal=new \Home\Model\subway();
  				$subwaylist=$subwayDal->getSubwayestateByWhere(" where estate_id='".$resourceModel['estate_id']."'"," limit 40");
  				$had_subway=false;
  				if($subwaylist!=null){
  					foreach ($subwaylist as $k => $v) {
  						if($v['subway_id']==$subway){
  							$had_subway=true;break;
  						}
  					}
  				}
	  			if(!$had_subway){
	  				echo '{"status":"407","msg":"地铁站不符"}';return;
	  			}
  				$listResult = $handleLogic->getTopList(array('top_type'=>$top_type,'subwayline_id'=>$subwayline,'subway_id'=>$subway,'rent_type'=>$rent_type,'is_gongyu'=>$is_gongyu)," order by is_top desc ",0,20);
				if($listResult!=null){
					foreach ($listResult as $key => $value) {
						if($value['room_no']==$room_no){
							$chongfu=true;break;
						}
					}
					if($chongfu){
						echo '{"status":"502","msg":"置顶位已经存在"}';return;
					}
					if(count($listResult)>0){
						$is_top=$listResult[0]['is_top']+1;
					}
				}
  				break;
  			default:
  				break;
  		}
  		$result=$handleLogic->addToproom(array('room_id'=>$roomResult[0]['id'],'room_no'=>$room_no,'create_man'=>$create_man,'top_type'=>$top_type,'is_top'=>$is_top),$is_gongyu,$subwayline,$subway);
  		if($result){
  			$roomDal=new \Home\Model\houseselect();
  			if($top_type==2){
  				$roomDal->updateModelByWhere(array('is_city_top'=>1),"room_id='".$roomResult[0]['id']."'");//更新全城置顶标识
  			}else if($top_type==3){
  				//区域置顶，判断之前是否有板块置顶
  				$list=$roomDal->getModelList(" where room_id='".$roomResult[0]['id']."' and top_type=4 "," limit 1");
  				$is_area_top=1;
  				if($list!=null && count($list)>0){
  					$is_area_top=3;
  				}
  				$roomDal->updateModelByWhere(array('is_area_top'=>$is_area_top),"room_id='".$roomResult[0]['id']."'");//更新区域板块置顶标识
  			}else if($top_type==4){
  				//板块置顶，判断之前是否区域有置顶
  				$list=$roomDal->getModelList(" where room_id='".$roomResult[0]['id']."' and top_type=3 "," limit 1");
  				$is_area_top=2;
  				if($list!=null && count($list)>0){
  					$is_area_top=3;
  				}
  				$roomDal->updateModelByWhere(array('is_area_top'=>$is_area_top),"room_id='".$roomResult[0]['id']."'");//更新区域板块置顶标识
  			}else if($top_type==5){
  				//地铁线
  				$list=$roomDal->getModelList(" where room_id='".$roomResult[0]['id']."' and top_type=6 "," limit 1");
  				$is_subway_top=1;
  				if($list!=null && count($list)>0){
  					$is_subway_top=3;
  				}
  				$roomDal->updateModelByWhere(array('is_subway_top'=>$is_subway_top),"room_id='".$roomResult[0]['id']."'");
  			}else if($top_type==6){
  				//地铁站
  				$list=$roomDal->getModelList(" where room_id='".$roomResult[0]['id']."' and top_type=5 "," limit 1");
  				$is_subway_top=2;
  				if($list!=null && count($list)>0){
  					$is_subway_top=3;
  				}
  				$roomDal->updateModelByWhere(array('is_subway_top'=>$is_subway_top),"room_id='".$roomResult[0]['id']."'");
  			}

  			echo '{"status":"200","msg":"操作成功"}';
  		}else{
  			echo '{"status":"500","msg":"操作失败"}';
  		}

  	}
  	//首页置顶列表
  	public function toproomindex(){
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
  		
  		$handleLogic=new \Logic\HouseSelectLogic();
		$list = $handleLogic->getTopList(array('top_type'=>1)," order by is_top ",0,100);
  		
  		$this->assign("list",$list);
  		$this->display();
  	}
  	//首页新增置顶
  	public function addToproomIndex(){
  		$create_man=getLoginName();
  		$room_no=I('post.room_no');
  		if(empty($create_man) || empty($room_no)){
  			echo '{"status":"400","msg":"数据无效"}';return;
  		}
  		$roomDal=new \Home\Model\houseroom();
  		$roomResult=$roomDal->getResultByWhere("id,resource_id,status,record_status","where room_no='$room_no'","");
  		if($roomResult==null || count($roomResult)==0){
  			echo '{"status":"402","msg":"房间编号不存在"}';return;
  		}
  		if($roomResult[0]['status']!=2 || $roomResult[0]['record_status']==0){
  			echo '{"status":"403","msg":"房间状态错误或已删除"}';return;
  		}
  		$is_top=1;
  		$handleLogic=new \Logic\HouseSelectLogic();
  		$chongfu=false;
		//首页
		$listResult = $handleLogic->getTopList(array('top_type'=>1)," order by is_top desc ",0,100);
		if($listResult!=null){
			foreach ($listResult as $key => $value) {
				if($value['room_no']==$room_no){
					$chongfu=true;break;
				}
			}
			if($chongfu){
				echo '{"status":"502","msg":"置顶位已经存在"}';return;
			}
			if(count($listResult)>0){
				$is_top=$listResult[0]['is_top']+1;
			}
		}
  		$result=$handleLogic->addToproom(array('room_id'=>$roomResult[0]['id'],'room_no'=>$room_no,'create_man'=>$create_man,'top_type'=>1,'is_top'=>$is_top));
  		if($result){
  			echo '{"status":"200","msg":"操作成功"}';
  		}else{
  			echo '{"status":"500","msg":"操作失败"}';
  		}

  	}
  	public function moveUpDownTopRoom_v2(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '{"status":"401","msg":"登录失效"}';return;
		}
		$id=I('get.id');
		$idTwo=I('get.id2');
		$sort=I('get.sort_index');
		$sortTwo=I('get.sort_index2');
		if($id!='' && $idTwo!='' && $sort!='' && $sortTwo!=''){
			$handleLogic=new \Logic\HouseSelectLogic();
			$result=$handleLogic->modifyTopRoomSort($id,$sort,$idTwo,$sortTwo);
			if($result){
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"500","msg":"操作失败"}';
			}
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	public function unsetToproom(){
		$login_name=getLoginName();
		if(empty($login_name)){
			echo '{"status":"401","msg":"登录失效"}';return;
		}
		$id=I('get.id');
		$top_type=I('get.top_type');
		$room_id=I('get.room_id');
		if($id!=''){
			$handleLogic=new \Logic\HouseSelectLogic();
			$result=$handleLogic->unsetTopRoomSort($id);
			if($result){
				$roomDal=new \Home\Model\houseselect();
				if($top_type==2){
					$roomDal->updateModelByWhere(array('is_city_top'=>0),"room_id='$room_id'");//更新全城置顶标识
				}else if($top_type==3){
					//区域置顶取消，判断是否还有板块置顶
					$list=$roomDal->getModelList(" where room_id='$room_id' and top_type=4 "," limit 1");
					$is_area_top=0;
					if($list!=null && count($list)>0){
						$is_area_top=2;
					}
					$roomDal->updateModelByWhere(array('is_area_top'=>$is_area_top),"room_id='$room_id'");//更新区域板块置顶标识
				}else if($top_type==4){
					//板块置顶取消，判断是否还有区域置顶
					$list=$roomDal->getModelList(" where room_id='$room_id' and top_type=3 "," limit 1");
					$is_area_top=0;
					if($list!=null && count($list)>0){
						$is_area_top=1;
					}
					$roomDal->updateModelByWhere(array('is_area_top'=>$is_area_top),"room_id='$room_id'");//更新区域板块置顶标识
				}else if($top_type==5){
					//地铁线
					$list=$roomDal->getModelList(" where room_id='$room_id' and top_type=6 "," limit 1");
					$is_subway_top=0;
					if($list!=null && count($list)>0){
						$is_subway_top=2;
					}
					$roomDal->updateModelByWhere(array('is_subway_top'=>$is_subway_top),"room_id='$room_id'");
				}else if($top_type==6){
					//地铁站
					$list=$roomDal->getModelList(" where room_id='$room_id' and top_type=5 "," limit 1");
					$is_subway_top=0;
					if($list!=null && count($list)>0){
						$is_subway_top=1;
					}
					$roomDal->updateModelByWhere(array('is_subway_top'=>$is_subway_top),"room_id='$room_id'");
				}
				echo '{"status":"200","msg":"操作成功"}';
			}else{
				echo '{"status":"500","msg":"操作失败"}';
			}
		}else{
			echo '{"status":"404","msg":"缺少参数"}';
		}
	}
	/*可租查询房间（列表）*/
	public function searchroomV2(){
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
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['is_commission']=I('get.is_commission');
        $condition['moneyMin']=trim(I('get.moneyMin'));
        if($condition['moneyMin']!='' && !is_numeric($condition['moneyMin'])){
        	$condition['moneyMin']='';
        }
        $condition['moneyMax']=trim(I('get.moneyMax'));
        if($condition['moneyMax']!='' && !is_numeric($condition['moneyMax'])){
        	$condition['moneyMax']='';
        }
        $hadCondition=false;$pageSHow='';
        foreach ($condition as $k1 => $v1) {
        	if($v1!=''){
        		$hadCondition=true;
        		break;
        	}
        }
        $handleLogic=new \Logic\HouseSelectLogic();
        $viewList = array();
        $condition['totalcnt']=I('get.totalcnt');
        $totalCount = $condition['totalcnt']==''?0:$condition['totalcnt'];
        if($hadCondition!==false){
        	if(I('get.p')=="" || $totalCount==0){
        		//总条数
        	    $totalCount = $handleLogic->getHouseselectCount($condition);
        	}
        	if($totalCount>0){
	        	$condition['totalcnt']=$totalCount;
	        	$Page= new \Think\Page($totalCount,10);//分页
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $pageSHow=$Page->show();
	        	$viewList = $handleLogic->getHouseselectList($condition,$Page->firstRow,$Page->listRows);
        	}
        }
        $handleResource=new \Logic\HouseResourceLogic();
		/*查询条件（区域板块）*/
		$regionResult=$handleResource->getRegionList();
		$regionList='';
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
        $this->assign("list",$viewList);
        $this->assign("totalcnt",$totalCount);
        $this->assign("pageSHow",$pageSHow);
		$this->display();
	}

}

?>
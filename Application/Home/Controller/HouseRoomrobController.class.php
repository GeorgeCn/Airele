<?php
namespace Home\Controller;
use Think\Controller;
class HouseRoomrobController extends Controller {
	/*房间管理*/
	public function roommanage(){
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

		$handleLogic=new \Logic\HouseRoomrobLogic();
		if(isset($_GET['resource_id'])){
			$resource_id=$_GET['resource_id'];
			//判断房源业务类型
			$handleResource=new \Logic\HouseResourcerobLogic();
			/*$houseModel=$handleResource->getModelById($resource_id);
			if($houseModel !=null && $houseModel['business_type']=="1503"){
				$this->assign('housetype',"hotel");
			}*/
			$list=$handleLogic->getModelListByResourceId($resource_id);	
			$viewList=array();
			if($list !=null){
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
			if($addressModel !=null){
				$resource_info=$addressModel['region_name'].$addressModel['scope_name'].",".$addressModel['estate_name'].$addressModel['unit_no']."单元".$addressModel['room_no']."室";
			}
			$this->assign('resource_info',$resource_info);
			$this->assign('resource_id',$resource_id);
			$this->display();
		}else{
			$this->error('缺少参数',U('HouseResourcerob/resourcelist'),1);
            return;
		}			
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
	/*修改房间*/
	public function modifyroom(){
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

        $room_id=$_GET['room_id'];
        //读取房间信息
		$roomLogic=new \Logic\HouseRoomrobLogic();
		$roomModel=$roomLogic->getModelById($room_id);
		if($roomModel==null){
			$this->error('操作失败，稍后重试',U('HouseResourcerob/resourcelist'),1);
            return;
		}
		//判断房源业务类型
		$houseModel = $roomLogic->getResourceInfoByRoomid($room_id);
		$housetype="";
		if($houseModel !=null){
			$housetype=$houseModel[0]['business_type'];
		}
		$roomNames = getRoomNamelistByType($housetype);
		$this->assign('roomNames',$roomNames);
		//读取图片信息
		$handleImg=new \Logic\HouseImgrobLogic();
		$imgList=$handleImg->getModelByRoomId($room_id);
		if($imgList !=null){
			$imgString="";
			foreach ($imgList as $key => $value) {
				$imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
				$corp_imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"]."_200_130.".$value["img_ext"];
				$imgString.='<li><img src="'.$corp_imgUrl.'" alt=""><br/><a href="javascript:;" onclick="removePic(\''.$value["id"].'\',this)">删除</a>&nbsp;<a href="'.__CONTROLLER__.'/downloadImage?img_id='.$value["id"].'">下载</a><br/><label><input type="radio" value="'.$value["id"].','.$imgUrl.'" name="main_img">封面</label></li>';
			}
			$this->assign("imgString",$imgString);
		}
		$this->assign("roomModel",$roomModel);
		$this->loadRoomParameter();
		$this->display();
	}
	//修改房间 提交
	public function submitRoomModify(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
		if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
			$this->uploadImage();
			return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$roomrobLogic=new \Logic\HouseRoomrobLogic();
		$data=$roomrobLogic->getModelById($_POST['room_id']);
		if($data==null){
			$this->error('操作失败，稍后重试',U('HouseResourcerob/resourcelist'),1);
            return;
		}
		if(!isset($_POST['room_name'])){
			$this->error('操作失败，房间名称不能为空',U('HouseResourcerob/resourcelist'),1);
            return;
		}
		$data['room_name']=$_POST['room_name'];
		$data['room_area']=$_POST['room_area'];
		$data['room_money']=$_POST['room_money'];
		$data['total_count']=$_POST['total_count'];
		
		$data['room_direction']=$_POST['room_direction'];

		if(isset($_POST['room_equipment'])){
			$data['room_equipment']=implode(",", $_POST['room_equipment']);
		}
		if(!isset($data['room_no']) || $data['room_no']==""){
			$data['room_no']=$roomLogic->createRoomno();
			$data['create_time']=time();
		}
		$data['room_description']=replaceHousePlatformName($_POST['room_description']);
		$data['room_bak']=isset($_POST['room_bak'])?$_POST['room_bak']:"";
		$data['feature_tag']=isset($_POST['feature_tag'])?1:0;
		$data['girl_tag']=isset($_POST['girl_tag'])?1:0;
		$data['update_time']=time();
		$data['update_man']=getLoginName();
		$room_status=$data['status'];
		$data['status']=$_POST['status'];
		$handleImage=new \Logic\HouseImgLogic();
		if(isset($_POST['main_img'])){
			$imgcount=$handleImage->getImgCountByRoomId($data['id']);
			if($imgcount==0){
				//没有下载重新上传，文件拷贝
				$handleImagerob=new \Logic\HouseImgrobLogic();
				$img_list=$handleImagerob->getModelByRoomId($data['id']);
				if($img_list !=null){
					$main_img=explode(",", $_POST['main_img']);
					foreach ($img_list as $key => $value) {
						$imgUrl=C("IMG_ROB_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
						ob_clean();
						ob_start();
						readfile($imgUrl);
						$img_data = ob_get_contents();
						ob_end_clean();
					    $result = $this->uploadImageToServer($data['id'],$value["img_name"].".".$value["img_ext"],base64_encode($img_data));
					    
					    if($main_img[0]==$value['id']){
					    	//记录主图
					    	$upload_success =json_decode($result,true);
					    	if($upload_success['status']=="200"){
			    		    	$data['main_img_id']=$upload_success['data']['imgId'];
			    			    $data['main_img_path']=$upload_success['data']['imgUrl'];
			    			
			    			    $handleImage->updateMainimg($data['main_img_id']);
					    	}
					    }
					}
				}
			}else{
				//已经下载重新上传，只需切换主图
				$main_img=explode(",", $_POST['main_img']);
				$data['main_img_id']=$main_img[0];
				$data['main_img_path']=$main_img[1];
				
				$handleImage->updateMainimg($data['main_img_id']);
			}
		}
		if(empty($data['create_man'])){
			$data['create_man']=$data['update_man'];
			
		}
		$data['up_count']=0;
		if($data['status']==2){
			$data['up_count']=$_POST['up_count'];
		}
		$insert_result=$roomLogic->addModel($data);//新增房间到生产环境
		if($insert_result){
			$data['record_status']=0;//删除
			$roomrobLogic->updateModel($data);
			if($data['status']==2){
				//操作房间查询表
				$handleSelect=new \Logic\HouseSelectLogic();
				$handleSelect->addModel($data['id']);
			}
			//add by 12/28 ,记录日志
			$recordHandle=new \Logic\HouseupdatelogLogic();
			$recordData['id']=guid();
			$recordData['house_id']=$data['id'];
			$recordData['house_type']=2;
			$recordData['update_man']=$data['update_man'];
			$recordData['update_time']=$data['update_time'];
			$recordData['operate_type']='新增抓取房间';
			$recordHandle->addModel($recordData);
			/*if($room_status==3 && $data['status']!=3){
				//解绑租客信息
				$handleRenter=new \Logic\HouseRoomrobRenterLogic();
				$handleRenter->updateStatusByRoomId($data['id']);
			}*/
			/*if(isset($_POST['handle']) && $_POST['handle']=="search"){
				$this->success('修改成功',U('HouseRoomrob/searchroom'),1);
			}else{
				$this->success('修改成功',U('HouseRoomrob/roommanage?resource_id='.$data['resource_id']),1);
			}*/
			//$this->success('修改成功',U('HouseResourcerob/resourcelist?no=3&leftno=81'),1);
			$this->success('房间维护成功',U("HouseRoomrob/roommanage?no=3&leftno=81&resource_id=".$data['resource_id']),1);
		}else{
			$this->error('操作失败，稍后重试',U('HouseRoomrob/roommanage?no=3&leftno=81&resource_id='.$data['resource_id']),1);
		}
	}
	//删除图片
	public function deleteImage(){
		if(isset($_GET['img_id'])){
			$handleImg=new \Logic\HouseImgrobLogic();
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
	//删除所有图片
	public function deleteImgs(){
		if(isset($_GET['room_id'])){
			$handleImg=new \Logic\HouseImgrobLogic();
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
				    $result = $this->uploadImageToServer($_POST['room_id'],$pics,$imgData);
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
	public function uploadImageToServer($room_id,$fileName,$imgData){
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

}

?>
<?php
namespace Home\Controller;
use Think\Controller;
/*公共对内操作方法汇总 */
class CommonController extends Controller {
	/*房源下架 */
	public function roomdown(){
		header("content-type:text/html;charset=utf-8");
		$room_id=I('post.room_id');
		$handle_man=I('post.handle_man');
		$room_id=$room_id==''?I('get.room_id'):$room_id;
		$handle_man=$handle_man==''?I('get.handle_man'):$handle_man;
		if(empty($room_id)){
			echo '{"status":"201","message":"room id is null"}';return;
		}
		if(empty($handle_man)){
			echo '{"status":"202","message":"handle man is null"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->downroomByidForCommon($room_id,$handle_man);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}
	
	/*重新上架 */
	public function roomreup(){
		header("content-type:text/html;charset=utf-8");
		$room_id=I('post.room_id');
		$handle_man=I('post.handle_man');
		$room_id=$room_id==''?I('get.room_id'):$room_id;
		$handle_man=$handle_man==''?I('get.handle_man'):$handle_man;
		if(empty($room_id)){
			echo '{"status":"201","message":"room id is null"}';return;
		}
		if(empty($handle_man)){
			echo '{"status":"202","message":"handle man is null"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->reuproomByidForCommon($room_id,$handle_man);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}
	/*删除房间 */
	public function roomremove(){
		header("content-type:text/html;charset=utf-8");
		$room_id=I('post.room_id');
		$handle_man=I('post.handle_man');
		$delete_type=I('post.delete_type');
		$delete_text=I('post.delete_text');
		$room_id=$room_id==''?I('get.room_id'):$room_id;
		$handle_man=$handle_man==''?I('get.handle_man'):$handle_man;
		$delete_type=$delete_type==''?I('get.delete_type'):$delete_type;
		$delete_text=$delete_text==''?I('get.delete_text'):$delete_text;
		if(empty($room_id)){
			echo '{"status":"201","message":"room id is null"}';return;
		}
		if(empty($handle_man)){
			echo '{"status":"202","message":"handle man is null"}';return;
		}
		if(empty($delete_type)){
			echo '{"status":"203","message":"delete reason is null"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->deleteRoomByRoomid(array('room_id'=>$room_id,'handle_man'=>$handle_man,'delete_type'=>$delete_type,'delete_text'=>$delete_text));
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}

	/*生成短链接 */
	public function getShorturl(){
		header("content-type:text/html;charset=utf-8");
		$long_url=I('post.long_url');
		$long_url=$long_url==''?I('get.long_url'):$long_url;
		if(empty($long_url)){
			echo '';return;
		}
		//log_result("shorturl-log.txt","接收：".$long_url); 
		$handleLogic=new \Logic\SmssendLogic();
		echo $short_url=$handleLogic->getShorturl(urldecode($long_url));
	}

	/*包月计划任务 */
	public function monthlyExecute(){
		$handle=I('post.handle');
		$handle=$handle==''?I('get.handle'):$handle;
		if($handle!='auto'){
			return;
		}
		$handleLogic=new \Logic\CommissionLogic();
		$handleLogic->monthlySendEmail();
		$handleLogic->monthlySendEmail_append();
		sleep(30);
		$handleLogic->monthlySendMessage();
		$handleLogic->monthlyAddBlack();
	}
	/*获取房源房间相关数据 */
	public function getHouseInfoById(){
		header("content-type:text/html;charset=utf-8");
		$info=array();
		$room_id=trim(I('get.room_id'));

		if(empty($room_id)){
			echo json_encode($info);return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$info=$roomLogic->getHouseinfoByRoomid($room_id);
		if($info==null){
			echo json_encode(array());
		}else{
			echo json_encode($info);
		}
	}
	/*更新房源房间相关数据 */
	public function modifyHouseInfo(){
		header("content-type:text/html;charset=utf-8");
		$data['room_id']=trim(I('get.room_id'));
		$data['room_money']=intval(I('get.room_money'));
		$data['room_money_new']=intval(I('get.room_money_new'));
		$data['owner_phone']=trim(I('get.owner_phone'));
		$data['owner_phone_new']=trim(I('get.owner_phone_new'));
		if(I('get.handle_man')!=''){
			$data['update_man']=trim(I('get.handle_man'));
		}
		$data['url']=trim(I('get.url'));
		if(empty($data['room_id'])){
			echo '{"status":"201","message":"fail"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->updateHouseinfo($data);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}

	/*拉黑 */
	public function pullBlackUser(){
		header("content-type:text/html;charset=utf-8");
		$data['mobile']=trim(I('get.mobile'));
		$data['update_man']=trim(I('get.oper_id'));
		$data['bak_type']=intval(I('get.bak_type'));
		$data['out_house']=intval(I('get.out_house'));
		$data['bak_info']=trim(I('get.bak_info'));
		if(empty($data['mobile']) || empty($data['update_man']) || empty($data['bak_type'])){
			echo '{"status":"201","message":"Parameter error"}';return;
		}
		//判断是否已添加
		$handleBlack=new \Home\Model\blacklist();
		$blackModel=$handleBlack->getBlacklistrobByMobile($data['mobile']);
		if($blackModel!=null && $blackModel!=false){
		  echo '{"status":"200","message":"success"}';return;
		}
		$data['no_login']=1;
		$data['no_post_replay']=1;
		$data['no_call']=1;
		$data['is_sendmessage']=0;
		$data['update_time']=time();
		$result=$handleBlack->addBlacklistrob($data);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}
	/*注册用户 */
	public function registerUser(){
		header("content-type:text/html;charset=utf-8");
		$data['true_name']=trim(I('get.true_name'));
		$data['mobile']=trim(I('get.mobile'));
		$data['city_code']=trim(I('get.city_code'));
		$data['channel']=trim(I('get.channel'));
		$data['gaodu_platform']=trim(I('get.source'));

		$user_type=trim(I('get.user_type'));//1=租客，2=房东
		if(empty($data['mobile'])){
			$data['true_name']=trim(I('post.true_name'));
			$data['mobile']=trim(I('post.mobile'));
			$data['city_code']=trim(I('post.city_code'));
			$data['channel']=trim(I('post.channel'));
			$data['gaodu_platform']=trim(I('post.source'));
			$user_type=trim(I('post.user_type'));
		}
		if(empty($data['mobile']) || empty($user_type) || !is_numeric($data['gaodu_platform'])){
			echo '{"status":"201","data":"Parameter error"}';return;
		}
		$handle=new \Home\Model\customer();
		$customerData=$handle->getListByWhere("mobile='".$data['mobile']."'"," limit 1");
		if($customerData!=null && count($customerData)>0){
			echo '{"status":"200","data":"'.$customerData[0]['id'].'"}';
		}else{
			$data['id']=guid();
			$data['create_time']=time();
			switch ($user_type) {
				case '1':
					$data['is_renter']=1;
					$data['is_owner']=0;
					break;
				case '2':
					$data['is_renter']=0;
					$data['is_owner']=3;
					break;
				default:
					echo '{"status":"202","data":"Parameter error too"}';
					return;
			}
			$result=$handle->addModel($data);
			if($result){
				echo '{"status":"200","data":"'.$data['id'].'"}';
			}else{
				echo '{"status":"400","data":"fail"}';
			}
		}

	}

	/*预约短信第2次发送计划任务 */
	public function sendReserveMessageTow(){
		$handle=trim(I('post.handle'));
		$handle=$handle==''?trim(I('get.handle')):$handle;
		if($handle!='auto'){
			return;
		}
		$handleLogic=new \Logic\HouseReserveCallLogic();
		$list=$handleLogic->getTwoSendMessageData();
		if($list!=null){
			$customerDal=new \Home\Model\customer();
			$estateDal=new \Home\Model\estate();
			foreach ($list as $key => $value) {
				$estate_address='';
				if($value['estate_id']!=''){
					$estateModel=$estateDal->getModelById($value['estate_id']);
					if($estateModel!=null && $estateModel!=false){
						$estate_address=$estateModel['estate_address'];
					}
				}
				$fd_phone=$value['owner_mobile'];
				if(strpos($fd_phone, '1')!==0){
				    $fd_model = $customerDal->getModelById($value['owner_id']);
				    if($fd_model!==null && $fd_model!==false){
				        $fd_phone=$fd_model['mobile'];
				    }
				}
				$handleLogic->sendmsg_success($value["customer_name"],$value["customer_mobile"],$value["estate_name"],$value["room_money"],$value['look_time'],$estate_address,$value["reback_no"],$fd_phone);
				log_result("yuyue-msgtwo-log.txt","租客：".$value["customer_mobile"]."，房东：".$fd_phone);
			}
		}
		                     
	}

	//中介房源单个发布
	public function agentHouseUp(){
		header("content-type:text/html;charset=utf-8");
		$room_id=I('post.room_id');
		$handle_man=I('post.handle_man');
		$room_id=$room_id==''?I('get.room_id'):$room_id;
		$handle_man=$handle_man==''?I('get.handle_man'):$handle_man;
		if(empty($room_id)){
			echo '{"status":"201","message":"room id is null"}';return;
		}
		if(empty($handle_man)){
			echo '{"status":"202","message":"handle man is null"}';return;
		}
		$handleLogic = new \Logic\HouseofferLogic();
		$result=$handleLogic->independentOnline_ls($room_id,$handle_man);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}
	//中介房源下架 
	public function agentHouseDown(){
		header("content-type:text/html;charset=utf-8");
		$room_id=I('post.room_id');
		$handle_man=I('post.handle_man');
		$room_id=$room_id==''?I('get.room_id'):$room_id;
		$handle_man=$handle_man==''?I('get.handle_man'):$handle_man;
		if(empty($room_id)){
			echo '{"status":"201","message":"room id is null"}';return;
		}
		if(empty($handle_man)){
			echo '{"status":"202","message":"handle man is null"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->agentHouseDown($room_id,$handle_man);
		if($result){
			echo '{"status":"200","message":"success"}';
		}else{
			echo '{"status":"401","message":"fail"}';
		}
	}
	//中介房源数据更新
	public function agentHouseUpdate(){
		header("content-type:text/html;charset=utf-8");
		$data['room_id']=trim(I('get.room_id'));
		$data['room_money']=intval(I('get.room_money'));
		$data['agency_phone']=trim(I('get.agency_phone'));
		$agency_name=trim(I('get.agency_name'));
		$data['handle_man']=trim(I('get.handle_man'));
		if($data['room_id']=='' || $data['handle_man']==''){
			echo '{"status":"401","message":"参数错误"}';return;
		}
		$roomLogic=new \Logic\HouseRoomLogic();
		$result=$roomLogic->agentHouseUpdate($data['room_id'],$data['room_money'],$data['agency_phone'],$data['handle_man'],$agency_name);
		echo $result;
	}

	#获取 IM 连接数
	public function getIMConnect(){
		header("content-type:text/html;charset=utf-8");
		$owner_id=trim(I('get.owner_id'));
		$total_count=intval(I('get.total_count'));
		$start_time=intval(I('get.start_time'));
		$end_time=intval(I('get.end_time'));
		if($owner_id==''){
			echo '{"status":"400","message":"error","total_count":"0","im_count":"0"}';return;
		}
		$handle=new \Logic\CustomerLogic();
		$result=$handle->getIMConnectData($owner_id,$total_count,$start_time,$end_time);
		echo '{"status":"200","message":"success","total_count":"'.$result["total_count"].'","im_count":"'.$result["im_count"].'"}';
	}

}

?>
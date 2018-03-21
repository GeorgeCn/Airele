<?php
namespace Home\Controller;
use Think\Controller;
class PushHousesController extends Controller 
{
	//推送上海房源
	public function pushHouses ()
	{	
		if(I('get.handle')!='push'){
			return;
		}
		$pushHouses = new \Logic\PushHousesApi("HIZHU@20161129");
		$fields = "room_name,room_no,info_resource,room_money,room_area,id rid,room_direction,room_description des,room_equipment,resource_id,'' client_phone,'' region_id,'' estate_name,'' pay_method,'' room_num,'' hall_num,'' area,'' floor_total,'' floor,'' decoration,'' rent_type,'' scope_name,'' wei_num,'' room_count,'' status,'' eid";
		$timestamp_end = strtotime(date('Y-m-d'));
		$timestamp = $timestamp_end-3600*24;
		
		$where="create_time>$timestamp and create_time<$timestamp_end  and status=2 and city_code='001009001' and record_status=1 and info_resource<>'链家网' ";
		$data = $pushHouses->modelGetInfo(0,3000,$fields,$where);
		/* var_dump($data);
		 exit();*/
		$handleCode=new \Logic\PhoneCodeLogic();
		foreach ($data as $value) {
			$resourceModel=$pushHouses->getHouseresourceByid($value['resource_id']);
			if($resourceModel==false || $resourceModel==null){
				continue;
			}else if($resourceModel['record_status']==0){
				continue;
			}
			$value['client_phone']=$resourceModel['client_phone'];
			$value['region_id']=$resourceModel['region_id'];
			$value['estate_name']=$resourceModel['estate_name'];
			$value['pay_method']=$resourceModel['pay_method'];
			$value['room_num']=$resourceModel['room_num'];
			$value['hall_num']=$resourceModel['hall_num'];
			//$value['area']=$resourceModel['area'];
			$value['floor_total']=$resourceModel['floor_total'];
			$value['floor']=$resourceModel['floor'];
			$value['decoration']=$resourceModel['decoration'];
			$value['rent_type']=$resourceModel['rent_type'];
			$value['scope_name']=$resourceModel['scope_name'];
			$value['wei_num']=$resourceModel['wei_num'];
			$value['room_count']=$resourceModel['room_count'];
			$value['status']=$resourceModel['status'];
			$value['eid']=$resourceModel['eid'];

			$four_code=$handleCode->get400Code(array('mobile'=>$value['client_phone'],'room_id'=>$value['rid'],'room_no'=>$value['room_no'],'city_id'=>'001009001','info_resource'=>$value['info_resource']));
			
			$requestData['landlordMobile'] = $four_code;
			$requestData['houseName'] = $value['room_name'];
			$requestData['provinceId'] = 2; 
			$requestData['cityId'] = 370;
			if($value['region_id']=='235') {
				continue;
			} else {
				$requestData['countyId'] = $pushHouses->getCountId($value['region_id']);	
			}	
			$requestData['areaName'] = $value['estate_name'];
			$requestData['address'] = $pushHouses->getAstateAddress($value['eid']);
			$requestData['houseRent'] = $value['room_money'];
			$result = $pushHouses->getPayMethod($value['pay_method']);
			$requestData['payType'] = $result['payType'];
			$requestData['deposit'] = $result['deposit'];
			$requestData['houseFrom'] = "HiZhu";
			$requestData['sourceId'] = $value['rid'];
			$requestData['houseType'] = $pushHouses->getHouseType($value['room_num'],$value['hall_num']);
			$requestData['houseSize'] = $value['room_area'];
			$requestData['orientation'] = $pushHouses->getOrientation($value['room_direction']);
			$requestData['floors'] = $value['floor_total'];
			$requestData['currFloor'] = $value['floor'];
			$requestData['renovation'] = $pushHouses->getRenovation($value['decoration']);
			$requestData['description'] = $value['des'];
			$requestData['leaseType'] = $pushHouses->getRentType($value['rent_type']);
			$requestData['tradingArea'] = $value['scope_name'];
			$requestData['liveRoom'] = $value['hall_num'];
			$requestData['bedRoom'] = $value['room_num'];
			$requestData['toiletRoom'] = $value['wei_num'];
			$requestData['rooms'] = $value['room_count'];
			$equipments = $pushHouses->getEquipments($value['room_equipment']);
			$requestData['bed'] = $equipments['bed'];
			$requestData['soft'] = $equipments['soft'];
			$requestData['board'] = $equipments['board'];
			$requestData['desk'] = $equipments['desk'];
			$requestData['washMachine'] = $equipments['washMachine'];
			$requestData['refrigerator'] = $equipments['refrigerator'];
			$requestData['television'] = $equipments['television'];
			$requestData['airCondition'] = $equipments['airCondition'];
			$requestData['waterHeader'] = $equipments['waterHeader'];
			$requestData['lampblackMachine'] = $equipments['lampblackMachine'];
			$requestData['stove'] = $equipments['stove'];
			$requestData['ambry'] = $equipments['ambry'];
			$requestData['wifi'] = $equipments['wifi'];
			$requestData['microwaveOven'] = $equipments['microwaveOven'];
			$requestData['isRent'] = 0;
			$requestData['status'] = 1;
			$requestData['isAnyTime'] = 1;
			$requestData['housePic'] = $pushHouses->getHousePic($value['rid']);
			$requestData['traffic'] = $pushHouses->getTraffic($value['eid']);
			// var_dump($requestData);
			$content = $pushHouses->sendHouses($requestData);
			$obj = json_decode($content);
			$code = $obj->code;
			if($code==0) {
				$pushHouses->insertRoomId($value['rid'],$four_code);
			}
			$info = $pushHouses->putFile($file="houseLog.txt",$content); 
			if($info){ 
 				echo "信息写入成功。<br/>";
 		    }
 		}
	}
	//下架上海房源
	public function downHouses ()
	{	
		if(I('get.handle')!='down'){
			return;
		}
		$pushHouses = new \Logic\PushHousesApi("HIZHU@20161129");
		$fields = 'room_id,client_phone';
		$option['status'] = 2;  
		$downlist = $pushHouses->getDownHouses(0,1000,$fields,$option);
		foreach ($downlist as $value) {
			$roomModel=$pushHouses->getHouseroomByid($value['room_id']);
			if($roomModel==null || $roomModel==false){
				continue;
			}
			$resourceModel=$pushHouses->getHouseresourceByid($roomModel['resource_id']);
			if($resourceModel==false || $resourceModel==null){
				continue;
			}
			$requestData['landlordMobile'] = $value['client_phone'];
			$requestData['houseName'] = $roomModel['room_name'];
			$requestData['provinceId'] = 2; 
			$requestData['cityId'] = 370;
			if($resourceModel['region_id']=='235') {
				continue;
			} else {
				$requestData['countyId'] = $pushHouses->getCountId($resourceModel['region_id']);	
			}	
			$requestData['areaName'] = $resourceModel['estate_name'];
			$requestData['address'] = $pushHouses->getAstateAddress($resourceModel['eid']);
			$requestData['houseRent'] = $roomModel['room_money'];
			$result = $pushHouses->getPayMethod($resourceModel['pay_method']);
			$requestData['payType'] = $result['payType'];
			$requestData['deposit'] = $result['deposit'];
			$requestData['houseFrom'] = "HiZhu";
			$requestData['sourceId'] = $roomModel['rid'];
			$requestData['houseType'] = $pushHouses->getHouseType($resourceModel['room_num'],$resourceModel['hall_num']);
			$requestData['houseSize'] = $roomModel['room_area'];
			$requestData['orientation'] = $pushHouses->getOrientation($roomModel['room_direction']);
			$requestData['floors'] = $resourceModel['floor_total'];
			$requestData['currFloor'] = $resourceModel['floor'];
			$requestData['renovation'] = $pushHouses->getRenovation($resourceModel['decoration']);
			$requestData['leaseType'] = $pushHouses->getRentType($resourceModel['rent_type']);
			$requestData['isRent'] = 1;
			$requestData['status'] = 0;
			$requestData['isAnyTime'] = 0;
			// var_dump($requestData);
			$content = $pushHouses->sendHouses($requestData);
			$obj = json_decode($content);
			$code = $obj->code;
			if($code==0) {
				$pushHouses->updateRoomStatus($roomModel['rid']);
			}
			$info = $pushHouses->putFile($file="downHouseLog.txt",$content);
			if($info){ 
 				echo "信息写入成功。<br/>";
 		    }
	 		
		}
	}

	//更新电话
	public function updateHouses_phone()
	{	
		if(I('get.handle')!='update'){
			return;
		}
		$pushHouses = new \Logic\PushHousesApi("HIZHU@20161129");
		$fields = 'room_id';
		$option['status'] = 1;  
		$option['client_phone']=array('eq','');
		$downlist = $pushHouses->getDownHouses(0,10000,$fields,$option);
		$handleCode=new \Logic\PhoneCodeLogic();
		foreach ($downlist as $value) {
			$roomModel=$pushHouses->getHouseroomByid($value['room_id']);
			if($roomModel==null || $roomModel==false){
				continue;
			}
			$resourceModel=$pushHouses->getHouseresourceByid($roomModel['resource_id']);
			if($resourceModel==false || $resourceModel==null){
				continue;
			}
			$requestData['houseName'] = $roomModel['room_name'];
			$requestData['provinceId'] = 2; 
			$requestData['cityId'] = 370;
			if($resourceModel['region_id']=='235') {
				continue;
			} else {
				$requestData['countyId'] = $pushHouses->getCountId($resourceModel['region_id']);	
			}	
			$four_code=$handleCode->get400Code(array('mobile'=>$resourceModel['client_phone'],'room_id'=>$value['room_id'],'room_no'=>$roomModel['room_no'],'city_id'=>'001009001','info_resource'=>$resourceModel['info_resource']));
			
			$requestData['landlordMobile'] = $four_code;


			$requestData['areaName'] = $resourceModel['estate_name'];
			$requestData['address'] = $pushHouses->getAstateAddress($resourceModel['eid']);
			$requestData['houseRent'] = $roomModel['room_money'];
			$result = $pushHouses->getPayMethod($resourceModel['pay_method']);
			$requestData['payType'] = $result['payType'];
			$requestData['deposit'] = $result['deposit'];
			$requestData['houseFrom'] = "HiZhu";
			$requestData['sourceId'] = $roomModel['rid'];
			$requestData['houseType'] = $pushHouses->getHouseType($resourceModel['room_num'],$resourceModel['hall_num']);
			$requestData['houseSize'] = $roomModel['room_area'];
			$requestData['orientation'] = $pushHouses->getOrientation($roomModel['room_direction']);
			$requestData['floors'] = $resourceModel['floor_total'];
			$requestData['currFloor'] = $resourceModel['floor'];
			$requestData['renovation'] = $pushHouses->getRenovation($resourceModel['decoration']);
			$requestData['leaseType'] = $pushHouses->getRentType($resourceModel['rent_type']);
			$requestData['isRent'] = 0;
			$requestData['status'] = 1;
			$requestData['isAnyTime'] = 1;
			// var_dump($requestData);
			$content = $pushHouses->sendHouses($requestData);
			$obj = json_decode($content);
			$code = $obj->code;
			
			$pushHouses->updateInnjiapush(array('client_phone'=>$four_code),"room_id='".$value['room_id']."'");
			
			$info = $pushHouses->putFile($file="downHouseLog.txt",$content);
			if($info){ 
 				echo "信息写入成功。<br/>";
 		    }
	 		
		}
	}
}
?>
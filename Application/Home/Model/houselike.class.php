<?php
namespace Home\Model;
use Think\Model;
class houselike{
   //更新（收藏房源）
   public function updateModelByRoomid($data){
     	$ModelTable = M("houselike");
     	$condition['room_id']=$data['room_id'];
      $condition['city_code']=C('CITY_CODE');
     	return $ModelTable->where($condition)->save($data);
   }
   public function updateModelByResourceid($data){
     	$ModelTable = M("houselike");
     	$condition['resource_id']=$data['resource_id'];
      $condition['city_code']=C('CITY_CODE');
     	return $ModelTable->where($condition)->save($data);
   }
    //更新（看房日程）
   public function updateReserveByRoomid($data){
      $ModelTable = M("housereserve");
      $condition['room_id']=$data['room_id'];
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->save($data);
   }
   public function updateReserveByResourceid($data){
      $ModelTable = M("housereserve");
      $condition['resource_id']=$data['resource_id'];
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->save($data);
   }
}
?>
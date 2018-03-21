<?php
namespace Home\Model;
use Think\Model;
class storehouses{
  //删除店铺房源
  public function deleteStorehouses($where){
     $Model = new Model();
     return $Model->execute("delete from gaodustore.storehouses where ".$where);
  }
  //新增店铺房源
  public function addStorehouses($data){
  	 $Model = new Model();
  	 $store_id=$data['store_id'];
  	 $store_name=$data['store_name'];
  	 $room_id=$data['room_id'];
  	 $house_id=$data['house_id'];
  	 $customer_id=$data['customer_id'];
  	 $city_code=C('CITY_CODE');
     return $Model->execute("insert into gaodustore.storehouses(id,store_id,store_name,room_id,house_id,create_time,city_code,customer_id) values(uuid(),'$store_id','$store_name','$room_id','$house_id',unix_timestamp(),'$city_code','$customer_id')");
  }

  //获取店铺信息
  public function getStoremembers($where){
  	 $Model = new Model();
     return $Model->query("select id,store_id,store_name,customer_id from gaodustore.storemembers where ".$where);
  }
  //新增店铺信息
  public function addStoremembers($data){
  	 $Model = new Model();
  	 $store_id=$data['store_id'];
  	 $store_name=$data['store_name'];
  	 $title_id=$data['title_id'];
  	 $customer_id=$data['customer_id'];
  	 $city_code=C('CITY_CODE');
     return $Model->execute("insert into gaodustore.storemembers(id,store_id,store_name,customer_id,create_time,record_status,title_id,city_code) values(uuid(),'$store_id','$store_name','$customer_id',unix_timestamp(),1,'$title_id','$city_code')");
  }

}
?> 
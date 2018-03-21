<?php
namespace Home\Model;
use Think\Model;
class commission{
  /*佣金管理 */
  public function addModel($data){
      $ModelTable=M('commissionmanage');
      return $ModelTable->add($data);
   }
   public function addDetail($data){
      $ModelTable=M('commissiondetail');
      return $ModelTable->add($data);
   }
   public function updateModel($data){
      $ModelTable=M('commissionmanage');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   public function updateDetail($data){
      $ModelTable=M('commissiondetail');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   public function getModelById($id){
      $ModelTable=M('commissionmanage');
      return $ModelTable->where(array('id'=>$id))->find();
   }
   public function getModelListCount($condition){
     $model = new Model();
     $sql="select count(1) as totalCount from commissionmanage where 1=1 ";
     return $model->query($sql.$condition);
   }
   public function getModelList($condition,$limit_start,$limit_end){
     $model = new Model();
     $sql="select room_no,estate_name,client_phone,client_name,room_status,room_money,contracttime_start,contracttime_end,is_open,create_man,create_time,update_man,update_time,id,city_code,room_id from commissionmanage where 1=1 ";
     return $model->query($sql.$condition." order by update_time desc,id asc limit $limit_start,$limit_end");
   }
 //更新房间信息
   public function updateRoomCommission($room_id,$is_commission){
      $model = new Model();
     return $model->execute("update houseroom set is_commission=$is_commission where id='$room_id'");
   }
  //读取房源信息
   public function getHouseResourceById($resource_id){
     $model = new Model();
     return $model->query("select client_phone,client_name,estate_name from houseresource where id='$resource_id'");
   }
   //读取房间信息
   public function getHouseRoomByNo($room_no){
     $model = new Model();
     return $model->query("select resource_id,id,room_no,status,room_money from houseroom where room_no='$room_no'");
   }
   //根据条件获取房间信息
  public function getHouseRoomByWhere($where,$limit=200){
    $model = new Model();
    return $model->query("select id,room_no,status,room_money from houseroom ".$where." limit $limit");
  }
  //删除佣金房源
  public function deleteModelByWhere($where){
    $model=new Model();
    return $model->execute("delete from commissionmanage where ".$where);
  }
   public function getModelByNo($room_no){
     $model =new Model();
     return $model->query("select id,contracttime_start,contracttime_end from commissionmanage where room_no='$room_no' and is_open=1");
   }
   public function getModelByWhere($where,$limit=10){
     $model =new Model();
     return $model->query("select id,contracttime_start,contracttime_end from commissionmanage ".$where." limit $limit");
   }
   
   public function getMaxStarttimeByid($commission_id){
     $model =new Model();
     return $model->query("select id,start_time from commissiondetail where commission_id=$commission_id order by start_time desc limit 1");
   }
   public function getDetailsByCommissionId($commission_id){
     $model =new Model();
     return $model->query("select commission_type,commission_money,commission_base,is_online,settlement_method,start_time,end_time,create_man,create_time from commissiondetail where commission_id=$commission_id order by id asc");
   }
   //读取房东下面的所有房间（没有佣金房源）
   public function getRoomInfoByClientphone($client_phone){
     $model = new Model();
     return $model->query("select r.room_no from houseresource h inner join houseroom r on h.id=r.resource_id where r.record_status=1 and h.client_phone='$client_phone' and not exists(select 1 from `commissionmanage` c where c.`room_id` =r.id and c.is_open=1)");
   }
   //读取一个房东下面的最新有效佣金信息
   public function getCommissionOneByPhone($client_phone){
      $model =new Model();
      return $model->query("select id,contracttime_start,contracttime_end from commissionmanage where client_phone='$client_phone' and is_open=1 order by update_time desc limit 1");
   }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class houseroomrenter{
   /*房间租客信息表*/
   //新增
   public function addModel($data){
     $model = M("houseroomrenter");
     $data['city_code']=C('CITY_CODE');
     return $model->add($data);
   }
   //修改
   public function updateModel($data){
     $model = M("houseroomrenter");
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);
 
   }
   //查询
   public function getModelById($id){
     $model = M("houseroomrenter");
     $condition['id']=$id;
     return $model->where($condition)->find();
 
   }
   //根据房间ID查询当前租客信息
   public function getModelByRoomId($roomId){
     $model = M("houseroomrenter");
     $condition['room_id']=$roomId;
     $condition['record_status']=1;
     return $model->where($condition)->find();
 
   }
   //房间重新出租，解绑租客信息
   public function updateStatusByRoomId($roomId){
     $model = M("houseroomrenter");
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseroomrenter set record_status=0,update_time=$update_time,update_man='$update_man' where room_id='$roomId' and record_status=1 ");
 
   }
}
?> 
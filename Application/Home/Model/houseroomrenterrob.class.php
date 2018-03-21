<?php
namespace Home\Model;
use Think\Model;
class houseroomrenterrob{
   /*房间租客信息表*/
   const conneccity = 'DB_ROB';
   //新增
   public function addModel($data){
     $model = M("houseroomrenter","",self::conneccity);
     $result = $model->add($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $model = M("houseroomrenter","",self::conneccity);
     $condition['id']=$data['id'];
     $result = $model->where($condition)->save($data);
     return $result;
   }
   //查询
   public function getModelById($id){
     $model = M("houseroomrenter","",self::conneccity);
     $condition['id']=$id;
     $result = $model->where($condition)->find();
     return $result;
   }
   //根据房间ID查询当前租客信息
   public function getModelByRoomId($roomId){
     $model = M("houseroomrenter","",self::conneccity);
     $condition['room_id']=$roomId;
     $condition['record_status']=1;
     $result = $model->where($condition)->find();
     return $result;
   }
   //房间重新出租，解绑租客信息
   public function updateStatusByRoomId($roomId){
     $model = M("houseroomrenter","",self::conneccity);
     $update_time=time();
     $update_man=getLoginName();
     $result = $model->execute("update houseroomrenter set record_status=0,update_time=$update_time,update_man='$update_man' where room_id='$roomId' and record_status=1 ");
     return $result;
   }
}
?> 
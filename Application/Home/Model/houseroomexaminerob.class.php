<?php
namespace Home\Model;
use Think\Model;
class houseroomexaminerob{
  const conneccity = 'DB_ROB';
   /*房间信息审核表*/
   //新增
   public function addModel($data){
     $model = M("houseroomexamine","",self::conneccity);
     $result = $model->add($data);
     return $result;
   }
   //查询
   public function getModelByRoomId($roomId){
     $model = M("houseroomexamine","",self::conneccity);
     $condition['room_id']=$roomId;
     $result = $model->where($condition)->find();
     return $result;
   }
}
?> 
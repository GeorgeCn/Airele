<?php
namespace Home\Model;
use Think\Model;
class houseimgrob{
   /*房源、房间图片表*/
   const connection_img = 'DB_ROB';
   //新增
   public function addModel($data){
     $model = M("houseimg","",self::connection_img);
     $result = $model->add($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $model = M("houseimg","",self::connection_img);
     $condition['id']=$data['id'];
     $result = $model->where($condition)->save($data);
     return $result;
   }
    //逻辑删除
   public function deleteModelById($id){
     $model = M("houseimg","",self::connection_img);
     $update_time=time();
     $update_man=getLoginName();
     $result = $model->execute("update houseimg set record_status=0,update_time=$update_time,operator_id='$update_man' where id='$id' ");
     return $result;
   }
    //逻辑删除(删除房间下的所有图片)
   public function deleteModelByRoomId($room_id){
     $model = M("houseimg","",self::connection_img);
     $update_time=time();
     $update_man=getLoginName();
     $result = $model->execute("update houseimg set record_status=0,update_time=$update_time,operator_id='$update_man' where room_id='$room_id' ");
     return $result;
   }
   //查询
   public function getModelById($id){
     $model = M("houseimg","",self::connection_img);
     $condition['id']=$id;
     $result = $model->where($condition)->find();
     return $result;
   }
   //根据房源ID查询
   public function getModelByResourceId($resourceId){
     $model = M("houseimg","",self::connection_img);
     $condition['house_id']=$resourceId;
     $condition['record_status']=1;
     $condition['img_type']=1;
     $result = $model->where($condition)->select();
     return $result;
   }
   //根据房间ID查询
   public function getModelByRoomId($roomId){
     $model = M("houseimg","",self::connection_img);
     $condition['room_id']=$roomId;
     $condition['record_status']=1;
     $condition['img_type']=2;
     $result = $model->field("id,img_name,img_ext,img_path")->where($condition)->select();
     return $result;
   }
    //更新房间图片房源ID
   public function updateHouseidByRoomIds($house_id,$room_ids){
     $sql="update houseimg set house_id='$house_id' where room_id =$room_ids ";
     if(strpos($room_ids, ",")){
        $sql="update houseimg set house_id='$house_id' where room_id in ($room_ids) ";
     }
     $model = M("houseimg","",self::connection_img);
     $result = $model->execute($sql);
     return $result;
   }
    //切换主图
   public function updateSortindexByid($id,$room_id){
     $model = M("houseimg","",self::connection_img);
     $result = $model->execute("update houseimg set sort_index=1 where room_id='$room_id' ");
     $result = $model->execute("update houseimg set sort_index=0 where id='$id' ");
     return $result;
   }
}
?> 
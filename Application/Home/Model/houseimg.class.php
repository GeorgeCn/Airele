<?php
namespace Home\Model;
use Think\Model;
class houseimg{
   /*房源、房间图片表*/
   const connection_img = 'DB_IMAGE';
   //新增
   public function addModel($data){
    $data['city_code']=C('CITY_CODE');
     $model = M("houseimg","",self::connection_img);
     return $model->add($data);
   }
   //修改
   public function updateModel($data){
     $model = M("houseimg","",self::connection_img);
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);
   }
    //逻辑删除
   public function deleteModelById($id){
     $model = M("houseimg","",self::connection_img);
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseimg set record_status=0,update_time=$update_time,operator_id='$update_man' where id='$id' ");
   }
    //逻辑删除(删除房间下的所有图片)
   public function deleteModelByRoomId($room_id){
     $model = M("houseimg","",self::connection_img);
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseimg set record_status=0,update_time=$update_time,operator_id='$update_man' where room_id='$room_id'  ");
   }
   //查询
   public function getModelById($id){
     $model = M("houseimg","",self::connection_img);
     $condition['id']=$id;
     return $model->where($condition)->find();
   }
   //根据房源ID查询
   public function getModelByResourceId($resourceId){
     $model = M("houseimg","",self::connection_img);
     $condition['house_id']=$resourceId;
     $condition['record_status']=1;
     $condition['img_type']=1;
     //$condition['city_code']=C('CITY_CODE');
     return $model->where($condition)->select();
   }
   //根据房间ID查询
   public function getModelByRoomId($roomId){
     $model = M("houseimg","",self::connection_img);
     $condition['room_id']=$roomId;
     $condition['record_status']=1;
     $condition['img_type']=2;
      //$condition['city_code']=C('CITY_CODE');
     return $model->field("id,img_name,img_ext,img_path,city_code,sort_index")->where($condition)->select();
   }
   //查询房间下面的图片数量
   public function getImgCountByRoomId($roomId){
     $model = M("houseimg","",self::connection_img);
     $condition['room_id']=$roomId;
     $condition['record_status']=1;
     $condition['img_type']=2;
     // $condition['city_code']=C('CITY_CODE');
     return $model->where($condition)->count();
   }
    //更新房间图片房源ID
   public function updateHouseidByRoomIds($house_id,$room_ids){
     $sql="update houseimg set house_id='$house_id' where room_id =$room_ids ";
     if(strpos($room_ids, ",")){
        $sql="update houseimg set house_id='$house_id' where room_id in ($room_ids) ";
     }
     $model = M("houseimg","",self::connection_img);
     return $model->execute($sql);
   }
    //切换主图
   public function updateSortindexByid($id,$room_id){
     $model = M("houseimg","",self::connection_img);
     $model->execute("update houseimg set sort_index=1 where room_id='$room_id' and sort_index=0");
     return $model->execute("update houseimg set sort_index=0 where id='$id' ");
   }
   public function updateMainimg($id){
     $model = M("houseimg","",self::connection_img);
     return $model->execute("update houseimg set sort_index=0 where id='$id' ");
   }
}
?> 
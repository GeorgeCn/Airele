<?php
namespace Home\Model;
use Think\Model;
class houseroomrob{
   /*房间信息表*/
   //新增
   const conneccity = 'DB_ROB';
   public function addModel($data){
     $model = M("houseroom","",self::conneccity);
     $result = $model->add($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $model = M("houseroom","",self::conneccity);
     $condition['id']=$data['id'];
     $result = $model->where($condition)->save($data);
     return $result;
   }
   //逻辑删除
   public function deleteModelById($id){
     $model = M("houseroom","",self::conneccity);
     $update_time=time();
     $update_man=getLoginName();
     $result = $model->execute("update houseroom set record_status=0,update_time=$update_time,update_man='$update_man' where id='$id' ");
     return $result;
   }
   public function deleteModelByResourceId($resource_id){
     $model = M("houseroom","",self::conneccity);
     $update_time=time();
     $update_man=getLoginName();
     $result = $model->execute("update houseroom set record_status=0,update_time=$update_time,update_man='$update_man' where resource_id='$resource_id' ");
     return $result;
   }
   //查询
   public function getModelById($id){
     $model = M("houseroom","",self::conneccity);
     $condition['id']=$id;
     return $model->where($condition)->find();
   }
   public function getModelByResourceId($resource_id){
     $model = M("houseroom","",self::conneccity);
     return $model->where(array('resource_id'=>$resource_id))->find();
   }
    //根据房源ID查询房间列表
   public function getModelListByResourceId($resourceId){
     $model = M("houseroom","",self::conneccity);
     $sql="select r.id,r.room_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man, info_resource_url,sort_index,
      '待维护' as status_name,0 as is_renter from houseroom r where r.resource_id='$resourceId' and r.record_status=1 and status=4 ";
     return $model->query($sql);
   }
   public function getCountByResourceId($resourceId){
     $model = M("houseroom","",self::conneccity);
     return $model->where(" resource_id='$resourceId' and record_status=1 ")->count();
   }
    //所有房间的查询列表
   public function getModelList($condition,$limit_start,$limit_end){
     $model = M("houseroom","",self::conneccity);
     $sql="select r.id,r.room_no,h.client_phone,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no as shi_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,r.create_man,
      h.business_type ,r.total_count,r.up_count,h.info_resource,r.status from houseresource h inner join houseroom r on h.id=r.resource_id where h.record_status=1 and r.record_status=1 ";
     $result = $model->query($sql.$condition." order by r.update_time desc limit $limit_start,$limit_end");
     return $result;
   }
   //download
   public function getDownloadList($condition){
     $model = M("houseroom","",self::conneccity);
     $sql="select h.house_no,r.room_no,h.info_resource,h.estate_name,h.region_name,h.scope_name,h.business_type,r.room_name,r.room_area,r.room_money,r.total_count,r.up_count,h.client_phone,r.status,
r.update_time,r.update_man,r.create_man  from houseresource h inner join houseroom r on h.id=r.resource_id where h.record_status=1 and r.record_status=1 ";
     $result = $model->query($sql.$condition." order by r.update_time desc ");
     return $result;
   }
    //列表总？条数
   public function getModelListCount($condition){
     $model = M("houseroom","",self::conneccity);
     $sql="select count(1) as totalCount,sum(r.total_count) as roomTotalCount,sum(r.up_count) as roomUpCount from houseresource h inner join houseroom r on h.id=r.resource_id where h.record_status=1 and r.record_status=1 ";
     $result = $model->query($sql.$condition);
     return $result;
   }
  /*//获得房间配置参数
  public function getRoomParameters(){
    $model = new \Think\Model();
    $result=$model->query("select type_no,info_type,name,index_no from houseroominfotype where record_status=1 order by info_type,index_no");
    return $result;
  }*/
  public function getCountByRoomno($room_no){
       $model = M("houseroom","",self::conneccity);
       $condition['room_no']=$room_no;
       $result = $model->where($condition)->count();
       return $result;
  }
  //查询新增房间列表
  public function getAddRoomListByResourceId($resourceId){
    $model = M("houseroom","",self::conneccity);
    $result=$model->query("select r.id,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,'' as room_direction 
 from houseroom r where r.record_status=1 and r.resource_id='$resourceId' ");
    return $result;
  }
  //查询房源下的最大房间序号
  public function getMaxRoomIndexByResourceId($resourceId){
    $model = M("houseroom","",self::conneccity);
    $result=$model->query("select max(r.room_index) as max_index from houseroom r where r.record_status=1 and r.resource_id='$resourceId' ");
    return $result;
  }
  //根据room_id查询房源信息
  public function getResourceInfoByRoomid($room_id){
    $model = M("houseroom","",self::conneccity);
    $result=$model->query("select id,house_no,business_type from houseresource where id=(select resource_id from houseroom where id='$room_id' limit 1)");
    return $result;
  }
  public function getRoomIdsByResourceId($resource_id){
    $model = M("houseroom","",self::conneccity);
    $result=$model->query("select id from houseroom where resource_id='$resource_id'");
    return $result;
  }
  //更新房间负责人 by 房源ID 
  public function updateCreatemanByResourceid($resourceId,$create_man){
     $model = M("houseroom","",self::conneccity);
     $result = $model->execute("update houseroom set create_man='$create_man' where resource_id='$resourceId' ");
     return $result;
  }
  /*置顶房间*/
  public function getTopRoomById($room_id){
    $model=M("houseroom","",self::conneccity);
    $where['id']=$room_id;
    $where['sort_index']=array('gt',0);
    return $model->where($where)->find();
  }
  public function getTopRoomByRoomno($room_no){
    $model=M("houseroom","",self::conneccity);
    $where['room_no']=$room_no;
    return $model->where($where)->find();
  }
  public function setTopRoomById($room_id){
     $model = M("houseroom","",self::conneccity);
     return $model->execute("update houseroom set sort_index=(select sort_index from (select (max(sort_index)+1) as sort_index from houseroom) as t1) where id='$room_id'");
  }
  public function cancelTopRoomById($room_id){
     $model = M("houseroom","",self::conneccity);
     return $model->execute("update houseroom set sort_index=0 where id='$room_id'");
  }
  //置顶列表
  public function getTopRoomCount($condition){
     $model = M("houseroom","",self::conneccity);
     $sql="select count(*) as totalCount from houseroom as r where record_status=1 and sort_index>=1 ";
     return $model->query($sql.$condition);
  }
  public function getTopRoomList($condition,$limit_start,$limit_end){
     $model = M("houseroom","",self::conneccity);
     $sql="select h.house_no,h.estate_name,r.id,r.room_no,r.room_name,r.room_area,r.room_money,r.create_man,r.status,r.sort_index from houseresource h, houseroom r where h.id=r.resource_id and r.record_status=1 and r.sort_index>=1 ";
     return $model->query($sql.$condition." order by sort_index limit $limit_start,$limit_end");
  }
  public function modifyTopRoomSort($room_id,$sort_index){
     $model = M("houseroom","",self::conneccity);
     return $model->execute("update houseroom set sort_index='$sort_index' where id='$room_id'");
  }
  public function updateTopRoomSorts($sort_index){
     $model = M("houseroom","",self::conneccity);
     return $model->execute("update houseroom set sort_index=sort_index-1 where sort_index>$sort_index");
  }

}
?> 
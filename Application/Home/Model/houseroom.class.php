<?php
namespace Home\Model;
use Think\Model;
class houseroom{
   /*房间信息表*/
   //新增
   public function addModel($data){
     $model = M("houseroom");
     $data['pk_id']=microtime_pk_id();
     if(!isset($data['city_code']) || $data['city_code']==''){
       $data['city_code']=C('CITY_CODE');
     }
     return $model->add($data);
   }
   //修改 by id
   public function updateModel($data){
     $model = M("houseroom");
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);

   }
   //修改 by resource_id
   public function updateModelByResourceid($data){
     $model = M("houseroom");
     return $model->where(array('resource_id'=>$data['resource_id']))->save($data);
   }
   //逻辑删除
   public function deleteModelById($id){
     $model = new Model();
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseroom set record_status=0,update_time=$update_time,update_man='$update_man' where id='$id' ");
   }
   public function deleteModelByResourceId($resource_id){
     $model =new Model();
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseroom set record_status=0,update_time=$update_time,update_man='$update_man' where resource_id='$resource_id' ");
   }
   //查询
   public function getModelById($id){
     $model = M("houseroom");
     $condition['id']=$id;
     return $model->where($condition)->find();
  
   }
   public function getModelByResourceId($resource_id){
     $model = M("houseroom");
     $condition['resource_id']=$resource_id;
     return $model->where($condition)->find();
   }
    //根据房源ID查询房间列表
   public function getModelListByResourceId($resourceId){
     $model = new Model();
     $sql="select r.id,r.room_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man, info_resource_url,sort_index,
(case r.status when 0 then '待审核' when 1 then '审核未通过' when 2 then '未入住' when 3 then '已出租' when 4 then '待维护' else '' end) as status_name,
0 as is_renter from houseroom r where r.resource_id='$resourceId' and r.record_status=1 ";
     return $model->query($sql);
   }
  //查询房间列表-总数量
   public function getModelListCount($condition){
     $model = new Model();
     $sql="select count(*) as totalCount,sum(r.total_count) as roomTotalCount,sum(r.up_count) as roomUpCount,count(distinct h.client_phone) as ownerCount from houseresource h inner join houseroom r on h.id=r.resource_id where h.city_code='".C('CITY_CODE')."' ";
     return $model->query($sql.$condition);
   }
   //查询房间列表
   public function getModelList($condition,$limit_start,$limit_end){
     $model = new Model();
     $sql="select r.id,r.room_no,h.client_name,h.client_phone,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no as shi_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,r.create_man,r.principal_man,r.create_time,
      h.business_type ,h.info_resource,r.status,r.record_status,r.is_commission,r.is_monthly,h.area,h.room_type,h.rent_type,h.room_num,h.hall_num,h.wei_num,r.resource_id,h.customer_id,h.is_owner,h.rental_type,r.had_vedio,h.info_resource_url,r.total_count,r.up_count from houseresource h inner join houseroom r on h.id=r.resource_id where h.city_code='".C('CITY_CODE')."' ";
     return $model->query($sql.$condition." order by r.update_time desc,r.id desc limit $limit_start,$limit_end");
   }
    //房间查询列表（特殊查询，例如-房间编号）
   public function getModelListByCondition($condition){
     $model = new Model();
     $sql="select r.id,r.room_no,h.client_name,h.client_phone,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no as shi_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,r.create_man,r.principal_man,r.create_time,
      h.business_type ,h.info_resource,r.status,r.record_status,r.is_commission,r.is_monthly,h.area,h.room_type,h.rent_type,h.room_num,h.hall_num,h.wei_num,r.resource_id,h.customer_id,h.is_owner,h.rental_type,r.had_vedio,h.info_resource_url,r.total_count,r.up_count from houseresource h inner join houseroom r on h.id=r.resource_id where h.city_code='".C('CITY_CODE')."' ";
      return $model->query($sql.$condition.' limit 15');
   }

   //下载
   public function getDownloadList($condition){
     $model = new Model();
     $sql="select h.house_no,r.room_no,h.is_owner,h.info_resource,h.region_name,h.scope_name,h.estate_name,h.brand_type,h.business_type,h.room_num,h.hall_num,h.wei_num,h.rent_type,h.rental_type,h.area,r.room_name,r.room_area,r.room_money,h.client_name,h.client_phone,r.status,r.is_commission,r.is_monthly,r.is_commission as is_fee,r.had_vedio,r.record_status,r.create_time,r.update_time,r.update_man,r.create_man,r.principal_man from houseresource h inner join houseroom r on h.id=r.resource_id where h.city_code='".C('CITY_CODE')."' ";
     return $model->query($sql.$condition." order by r.update_time desc,r.id desc limit 10000");
   }
  public function getCountByRoomno($room_no){
       $model = M("houseroom");
       $condition['room_no']=$room_no;
       return $model->where($condition)->count();
  }
  public function getResultByWhere($columns,$where,$orderby_limit=''){
    $model = new Model();
    return $model->query("select ".$columns." from houseroom ".$where.$orderby_limit);
  }
  //查询新增房间列表
  public function getAddRoomListByResourceId($resourceId){
    $model = new Model();
    return $model->query("select r.id,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,
(select name from houseinfotype p where p.info_type=10 and p.type_no=r.room_direction limit 1) as room_direction 
 from houseroom r where r.record_status=1 and r.resource_id='$resourceId' ");
  }
  //查询房源下的最大房间序号
  public function getMaxRoomIndexByResourceId($resourceId){
    $model = new Model();
    return $model->query("select max(r.room_index) as max_index from houseroom r where r.record_status=1 and r.resource_id='$resourceId' ");
  }
  //根据room_id查询房源信息
  public function getResourceInfoByRoomid($room_id){
    $model = new Model();
    return $model->query("select id,house_no,business_type,estate_name,customer_id,area from houseresource where id=(select resource_id from houseroom where id='$room_id' limit 1)");
  }
  public function getRoomIdsByResourceId($resource_id){
    $model = new Model();
    return $model->query("select id from houseroom where resource_id='$resource_id'");
  }
  //更新房间负责人 by 房源ID 
  public function updateCreatemanByResourceid($resourceId,$create_man){
     $model = new Model();
     return $model->execute("update houseroom set create_man='$create_man' where resource_id='$resourceId' ");
  }
  /*置顶房间*/
  public function getTopRoomById($room_id){
    $model=M("houseroom");
    $where['id']=$room_id;
    $where['sort_index']=array('gt',0);
    return $model->where($where)->find();
  }
  public function getTopRoomByRoomno($room_no){
    $model=M("houseroom");
    $where['room_no']=$room_no;
    return $model->where($where)->find();
  }
  //置顶
  public function setTopRoomById($room_id){
     $model = new Model();
     /*$data=$model->query("select max(sort_index) as sort_index from houseroom where city_code='".C('CITY_CODE')."'");
     if($data===false||$data===null){
        return false;
     }
     $num=$data[0]['sort_index']+1;*/
     $num=11;
     $model->execute("update houseroom set sort_index=$num where id='$room_id'");
     $model->execute("update houseselect set is_top=$num where room_id='$room_id'");
     /*$model->execute("update houseroom set sort_index=6 where id='$room_id'");
     $model->execute("update houseselect set is_top=6 where room_id='$room_id'");*/
     return true;
  }
  //取消置顶
  public function cancelTopRoomById($room_id){
     $model = new Model();
     $model->execute("update houseroom set sort_index=0 where id='$room_id'");
     $model->execute("update houseselect set is_top=0 where room_id='$room_id'");
      return true;
  }
   //刷新置顶
  public function reflushTopRoomById($room_id){
     $model = new Model();
     $model->execute("update houseroom set update_time=unix_timestamp() where id='$room_id'");
     $model->execute("update houseselect set update_time=unix_timestamp() where room_id='$room_id'");
      return true;
  }
  //置顶列表
  public function getTopRoomCount($condition){
     $model = new Model();
      $condition.=" and city_code='".C('CITY_CODE')."'";
     $sql="select count(*) as totalCount from houseroom as r where sort_index>=1 and record_status=1 ";
     return $model->query($sql.$condition);
  }
  public function getTopRoomList($condition,$limit_start,$limit_end){
     $model = new Model();
      $condition.=" and h.city_code='".C('CITY_CODE')."'";
     $sql="select h.house_no,r.room_no,h.region_name,h.scope_name,h.estate_name,r.room_name,r.room_area,r.room_money,r.status,r.create_man,r.sort_index,r.id from houseresource h, houseroom r where h.id=r.resource_id and r.sort_index>=1 and r.record_status=1 ";
     return $model->query($sql.$condition." order by r.sort_index asc,r.update_time desc limit $limit_start,$limit_end");
  }
  //上，下移动
  public function modifyTopRoomSort($room_id,$sort_index,$room_idTwo,$sort_indexTwo){
     $model = new Model();
     $result = $model->execute("update houseroom set sort_index='$sort_index' where id='$room_id'");
     $result = $model->execute("update houseroom set sort_index='$sort_indexTwo' where id='$room_idTwo'");
     if($result){
        //更新搜索表
        $result=$model->execute("update houseselect set is_top='$sort_index' where room_id='$room_id'");
        $result=$model->execute("update houseselect set is_top='$sort_indexTwo' where room_id='$room_idTwo'");
        return true;
     }
     return $result;
  }
  //置到第一
  public function SetRoomTopFirst($room_id,$sort_index)
  {
     $model = new Model();
     $model->execute("update houseroom set sort_index=sort_index+1 where city_code='".C('CITY_CODE')."' and sort_index>0 and sort_index<$sort_index");
      $model->execute("update houseselect set is_top=is_top+1 where city_code='".C('CITY_CODE')."' and is_top >0 and is_top<$sort_index");
      $model->execute("update houseroom set sort_index=1 where id='$room_id'");
      $model->execute("update houseselect set is_top=1 where room_id='$room_id'");
     return true;
  }
  //取消置顶后，后面的顺序前移一位（弃用）
  public function updateTopRoomSorts($sort_index){
     $model = new Model();
     $result = $model->execute("update houseroom set sort_index=sort_index-1 where city_code='".C('CITY_CODE')."' and sort_index>$sort_index");
     if($result){
        //更新搜索表
        $result=$model->execute("update houseselect set is_top=is_top-1 where city_code='".C('CITY_CODE')."' and is_top>$sort_index");
        return true;
     }
     return $result;
  }
  //房源审核不通过
  public function examineResourceFail($room_id,$exam_content){
     $model = new Model();
     $now=time();
     $handle=getLoginName();
     return $model->execute("update houseroom set status=1,ext_examineinfo='$exam_content',update_time=$now,update_man='$handle' where id='$room_id'");
  }
  #联系房东和帮我预约设置
  public function setCallClientShow($room_ids,$is_show){
    $model = new Model();
    return $model->execute("update houseroom set show_call_bar=$is_show where id in ($room_ids)");
  }
  public function setAppointmentShow($room_ids,$is_show){
    $model = new Model();
    return $model->execute("update houseroom set show_reserve_bar=$is_show where id in ($room_ids)");
  }
  public function setKefuShow($room_ids,$is_show){
    $model = new Model();
    return $model->execute("update houseroom set show_kefu_bar=$is_show where id in ($room_ids)");
  }
  public function getSetAppointListCount($condition){
    $model = new Model();
    $condition.=" and h.city_code='".C('CITY_CODE')."'";
    $sql="select count(1) as totalCount from houseresource h inner join houseroom r on h.id=r.resource_id where h.record_status=1 ";
    return $model->query($sql.$condition);
  }
  public function getSetAppointList($condition,$limit_start,$limit_end){
    $model = new Model();
    $condition.=" and h.city_code='".C('CITY_CODE')."'";
    $sql="select h.house_no,h.info_resource,h.client_phone,h.estate_name,h.region_name,h.scope_name,h.business_type,r.status,r.room_no,r.show_call_bar,r.show_reserve_bar,r.show_kefu_bar,r.id,h.rent_type,r.takelook_man,r.update_time,r.room_money from houseresource h inner join houseroom r on h.id=r.resource_id where h.record_status=1 ";
    return $model->query($sql.$condition." order by r.id desc limit $limit_start,$limit_end");
  }
  #房间详情,看房日程相关信息
  public function getAllinfoByRoomid($room_id){
    $model = new Model();
    $sql="select h.region_id,h.region_name,h.scope_id,h.scope_name,h.is_owner,h.info_resource_type,h.info_resource,r.room_name,r.room_area,r.room_money,r.main_img_path,h.estate_id,h.estate_name,e.estate_address,h.client_phone,h.client_name,e.lpt_x,e.lpt_y,h.business_type,r.status,r.record_status 
    from estate e,houseresource h, houseroom r where h.id=r.resource_id and h.estate_id=e.id and r.id='$room_id' limit 1 ";
    return $model->query($sql);
  }
  //根据条件更新
  public function updateModelByWhere($data,$where){
    $model = M("houseroom");
    return $model->where($where)->save($data);
  }
  //根据条件获取房间信息
  public function getListByWhere($where,$limit=1000){
    $model = new Model();
    return $model->query("select id,resource_id from houseroom ".$where." order by update_time asc,id asc limit $limit");
  }
  public function getFieldsByWhere($columns,$where_limit){
    $model = new Model();
    return $model->query("select $columns from houseroom where ".$where_limit);
  }
  //刷新
  public function updateHouseByNo($room_nos,$data){
    $model = new Model();
    return $model->execute("update `houseroom` a,`houseselect` b set b.update_time=".$data['update_time'].",a.update_time=".$data['update_time'].",a.`update_man`= '".$data['update_man']."' where a.id= b.room_id and a.room_no in($room_nos)");
  }

}
?> 
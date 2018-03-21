<?php
namespace Home\Model;
use Think\Model;
class openapipush{
  /*58对接--发布房源 */
  const connecdata = 'DB_DATA';
  const connecimg = 'DB_IMAGE';
   public function addModel($data){
      $ModelTable=M('openapipush');
      $data['city_code']=C('CITY_CODE');
      return $ModelTable->add($data);
   }
    public function updateModel($data){
      $ModelTable=M('openapipush');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
    public function updateModelByWhere($data,$where){
      $ModelTable=M('openapipush');
      return $ModelTable->where($where)->save($data);
   }

  #删除发布
   public function deleteFabu($room_ids,$data,$third_type=1){
     $ModelTable=M('openapipush');
      return $ModelTable->where(array('room_id'=>array('in',$room_ids),'third_type'=>$third_type))->save($data);
   }
   public function deleteFabuByResourceid($data){
     $ModelTable=M('openapipush');
      return $ModelTable->where(array('resource_id'=>$data['resource_id']))->save($data);
   }
   #读取相关信息
   //已发布房间
   public function getHadfabuByRoomid($room_id,$third_type=1){
     $model =  new Model();
     return $model->query("select room_id from openapipush where room_id='$room_id' and is_delete=0 and third_type=$third_type");
   }
   //房间
   public function getHouseroomByRoomid($room_id){
     $model =  new Model();
     return $model->query("select resource_id,room_direction,room_name,room_description ,room_equipment,girl_tag from houseroom as h where id='$room_id' ");
   }
    //房源
   public function getHouseResourceByResourceid($resource_id){
     $model =  new Model();
     return $model->query("select  public_equipment,estate_name,estate_id,client_phone from houseresource as h where id='$resource_id' ");
   }
   //地铁
   public function getSubwayByEstateid($estate_id){
     $model =  new Model();
     return $model->query("select subwayline_name,subway_distance from subwayestate where estate_id='$estate_id' order by subway_distance asc limit 1");
   }
   //房间对应的优惠活动
   public function getActivityByRoomid($room_id){
     $model = new Model();
     return $model->query("select act_tag_name  from houseactivity where room_id='$room_id' and record_status=1 and line_flag=1 and act_eff_time>unix_timestamp(now()) limit 1");
   }

   //读取对应城市下58帐号
   public function getWubaAccount(){
     $city_code=C("CITY_CODE");
     $model = M("",'',self::connecdata);
     return $model->query("select userid from wubaaccount where city_code='$city_code' and third_id=1");
   }
    public function getBaixingAccount(){
     $model = M("",'',self::connecdata);
     return $model->query("select userid from wubaaccount where third_id=2");
   }
   public function getSoufangAccount(){
      $city_code=C("CITY_CODE");
     $model = M("",'',self::connecdata);
     return $model->query("select userid from wubaaccount where city_code='$city_code' and third_id=3");
   }
    //房间图片
   public function getRoomImageByRoomid($room_id){
     $model = M("",'',self::connecimg);
     return $model->query("select id from houseimg where room_id='$room_id' ");
   }
   /*58品牌馆 & 其他 */
    public function getAccountByType($third_type){
      $city_code=C("CITY_CODE");
     $model = M("",'',self::connecdata);
     return $model->query("select userid from wubaaccount where city_code='$city_code' and third_id=$third_type");
   }
   //未发布列表
   public function getNotfabuListByType($third_type,$condition,$limit_start,$limit_end){
     $condition.="  and h.city_code='".C('CITY_CODE')."' and NOT EXISTS (SELECT 1 from `openapipush` o where o.room_id=r.id and o.is_delete=0 and o.third_type=$third_type) ";
     $model =  new Model();
     $sql="select r.id,r.room_no,h.client_phone,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no as shi_no,r.room_name,r.room_area,r.room_money,r.update_time,r.update_man,r.create_man,
      h.business_type ,r.total_count,r.up_count,h.info_resource,r.status,r.record_status from houseroom r  inner join  houseresource h on h.id=r.resource_id where 1=1 ";
     return $model->query($sql.$condition." order by r.update_time desc,r.id desc limit $limit_start,$limit_end");
   }
   public function getNotfabuData($columns,$condition,$order_limit){
     $model =  new Model();
     return $model->query("select $columns from houseroom r inner join houseresource h on h.id=r.resource_id ".$condition.$order_limit);
   }
   //已发布列表
   public function getModelListCountByType($third_type,$condition){
     $city_code=C('CITY_CODE');
     $model =  new Model();
     $sql="select count(1) as totalCount from houseroom r right join openapipush o on o.room_id=r.id where o.is_fabu=1 and o.is_delete=0 and o.third_type=$third_type and o.city_code='$city_code' ";
     return $model->query($sql.$condition);
   }
   public function getModelListByType($third_type,$condition,$limit_start,$limit_end){
    $city_code=C('CITY_CODE');
     $model =  new Model();
     $sql="select r.id as room_id,r.room_no,r.room_name,r.room_area,r.room_money,r.update_time,r.info_resource,r.status,r.record_status,
     o.html_url_58,o.create_time,o.reflush_time,o.recommend_time,o.estate_name,o.client_phone from houseroom r right join openapipush o on o.room_id=r.id where o.is_fabu=1 and o.is_delete=0 and o.third_type=$third_type and o.city_code='$city_code' ";
     return $model->query($sql.$condition." order by o.create_time desc,o.id desc limit $limit_start,$limit_end");
   }

}
?> 
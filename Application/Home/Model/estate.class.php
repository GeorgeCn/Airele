<?php
namespace Home\Model;
use Think\Model;
class estate{
    //获取委托分页数据
   public function modelEstatePageCount($where){
     $ModelTable = M("estate");
     $where['city_code']=C('CITY_CODE');
     return $ModelTable->where($where)->count();
   }
    //获取分页数据
   public function modelEstateDataList($firstrow,$listrows,$where){
      $ModelTable = M("estate");
      $where['city_code']=C('CITY_CODE');
      return $ModelTable->field('estate_code,estate_name,estate_address,brand_type,lpt_x,lpt_y,region_name,scope_name,business_type,house_type,create_time,create_man,id')->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
   }
   public function modelGetEstateFind($where){
      $ModelTable = M("estate");
      $where['city_code']=C('CITY_CODE');
      return $ModelTable->field('id,estate_name,estate_address')->where($where)->find();
   }
   public function modeEstateByKey($where){
     $ModelTable = M("estate");
      $where['city_code']=C('CITY_CODE');
     return $ModelTable->field('id,estate_name,estate_address')->where($where)->limit(8)->select();
   }
   public function modelAdd($data){
      $ModelTable = M("estate");
      $data['city_code']=C('CITY_CODE');
      return $ModelTable->data($data)->add();
   }
   //get one by id
   public function getModelById($id){
      $ModelTable = M("estate");
      return $ModelTable->where("id='".$id."'")->find();
   }
   public function deleteModel($id){
      $ModelTable = M("estate");
      return $ModelTable->where("id='".$id."'")->delete();
   }
   //update
   public function updateModel($data){
      $ModelTable = M("estate");
      return $ModelTable->where("id='".$data['id']."'")->save($data);
   }
   //获取区域、板块的名称
   public function getRegionScopeName($regionId,$scopeId){
      $ModelTable = new Model();
      $city_code=C('CITY_CODE');
      return $ModelTable->query("select id,cname from region where id=$regionId and city_code='$city_code' union all select id,cname from region where id=$scopeId and city_code='$city_code'");
   }
    //更新房源信息（小区，区域、板块）
   public function updateHouseEstateInfo($houseModel){
      $ModelTable = M("houseresource");
      $where['estate_id']=$houseModel['estate_id'];
      $where['city_code']=C('CITY_CODE');
      $where['record_status']=1;
      return $ModelTable->where($where)->save($houseModel);
   }
   public function updateHouseResource($data,$where){
      $ModelTable = M("houseresource");
      return $ModelTable->where($where)->save($data);
   }
   public function modelcodemaxfind($where){
       $ModelTable = M("estate");
       $where['city_code']=C('CITY_CODE');
       $result=$ModelTable->field('id,estate_code')->where($where)->order('estate_code desc')->limit(1)->select();
       return $result;
   }
   public function getEstateByWhere($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from estate where ".$where_orderby);
   }
}
?> 
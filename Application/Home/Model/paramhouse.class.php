<?php
namespace Home\Model;
use Think\Model;
class paramhouse{
    //获取房源参数列表
   public function modelParamHouseList($keyword){
      $ModelTable = M("houseinfotype");
      $condition['record_status']=1;
      if($keyword!=""){
         $condition['info_type']=$keyword;
      }else{
         $condition['info_type']=0;
      }
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->order('index_no asc')->select();
     return $result;
   }
   public function modelParamHouse($where){
      $ModelTable = M("houseinfotype");
      $condition['id']=$where;
      $condition['record_status']=1;
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //添加房源参数
   public function modelAddParamHouse($data){
     $ModelTable = M("houseinfotype");
     $data['city_code']=C('CITY_CODE');
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   //删除房源参数
   public function modeldelParamHouse($where){
      $ModelTable = M("houseinfotype");
      $data['record_status']=0;
      $condition['id']=$where;
      $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data); 
      return $result;
   }
   //修改房源参数
    public function modelUpParamHouse($data){
      $ModelTable = M("houseinfotype");
      $condition['id']=$data['id'];
      $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data);
      return $result;
   }
    public function modelSelectTypeNo($where){
      $ModelTable = M("houseinfotype");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->select();
     return $result;
   }
   
  public function modelSelect($where){
      $ModelTable = M("houseinfotype");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->select();
     return $result;
   }
   public function modelMax($where){
      $ModelTable = M("houseinfotype");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->max('type_no');
      return $result;
   }

}
?> 
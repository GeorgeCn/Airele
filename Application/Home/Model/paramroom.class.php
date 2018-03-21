<?php
namespace Home\Model;
use Think\Model;
class paramroom{
    //获取房源参数列表
   public function modelParamRoomList($keyword){
      $ModelTable = M("houseinfotype");
      $condition['record_status']=1;
       if($keyword!=""){
        $condition['info_type']=$keyword;
      }else{
         $condition['info_type']=10;
      }
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->order('index_no asc')->select();
   
   }
   public function modelParamRoom($where){
      $ModelTable = M("houseinfotype");
      $condition['id']=$where;
      $condition['record_status']=1;
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->find();

   }
   //添加房源参数
   public function modelAddParamRoom($data){
     $ModelTable = M("houseinfotype");
     $data['city_code']=C('CITY_CODE');
     return $ModelTable->data($data)->add();
    
   }
   //删除房源参数
   public function modeldelParamRoom($where){
      $ModelTable = M("houseinfotype");
      $data['record_status']=0;
      $condition['id']=$where;
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->save($data); 
   
   }
   //修改房源参数
    public function modelUpParamRoom($data){
      $ModelTable = M("houseinfotype");
      $condition['id']=$data['id'];
      $condition['city_code']=C('CITY_CODE');
      return $ModelTable->where($condition)->save($data); ;
     
   }

}
?> 
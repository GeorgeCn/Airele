<?php
namespace Home\Model;
use Think\Model;
class paramappico{

   public function modelParamappicoList($keyword){
      $ModelTable = M("houseappico");
      $condition['record_status']=1;
      if($keyword!=""){
         $condition['info_type']=$keyword;
      }else{
         $condition['info_type']=0;
      }
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->select();
     return $result;
   }
   public function modelParamappico($where){
      $ModelTable = M("houseappico");
      $condition['id']=$where;
      $condition['record_status']=1;
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   public function modelAddParamappico($data){
     $ModelTable = M("houseappico");
     $data['city_code']=C('CITY_CODE');
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   public function modeldelParamappico($where){
      $ModelTable = M("houseappico");
      $data['record_status']=0;
      $condition['id']=$where;
      $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data); 
      return $result;
   }
  public function modelUpParamappico($data){
      $ModelTable = M("houseappico");
      $condition['id']=$data['id'];
      $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data); ;
   return $result;
  }

}
?> 
<?php
namespace Home\Model;
use Think\Model;
class paramregion{
    //获取房源参数列表
   public function modelParamRegionList($condition){
      $ModelTable = M("region");
       $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->select();
     return $result;
   }
   public function modelParamRegion($where){
      $ModelTable = M("region");
      $condition['id']=$where;
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->find();
     return $result;
   }
   //添加区域板块
   public function modelAddParamRegion($data){
     $ModelTable = M("region");
     $result=$ModelTable->data($data)->add();
     return $result;
   }
   //删除房源参数
   public function modeldelParamRegion($where){
      $ModelTable = M("region");
      $data['record_status']=0;
      $condition['id']=$where;
      $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data); 
      return $result;
   }
   //修改房源参数
    public function modelUpParamRegion($data){
      $ModelTable = M("region");
      $condition['id']=$data['id'];
       $condition['city_code']=C('CITY_CODE');
      $result=$ModelTable->where($condition)->save($data); ;
      return $result;
   }
   //获取最大的
    public function modelParamFind(){
       $ModelTable = M("region");
       $condition['city_code']=C('CITY_CODE');
       $maxid = $ModelTable->where($condition)->max('id');
       return $maxid;
    }

}
?> 
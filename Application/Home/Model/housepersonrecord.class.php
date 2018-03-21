<?php
namespace Home\Model;
use Think\Model;
class housepersonrecord{
   //查询
   public function getRecordByResourceid($resource_id){
     $ModelTable = M("housepersonrecord");
     $result = $ModelTable->where("resource_id='".$resource_id."' and city_code=".C('CITY_CODE'))->order('create_time desc')->select();
     return $result;
   }
   //新增
   public function addModel($data){
      $ModelTable = M("housepersonrecord");
      $data['city_code']=C('CITY_CODE');
      $result=$ModelTable->data($data)->add();
      return $result;
   }

}
?> 
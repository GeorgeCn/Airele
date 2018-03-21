<?php
namespace Home\Model;
use Think\Model;
class report{

   public function modelReportPageCount($where){
     $ModelTable = M("housereport");
     $where['city_code']=C('CITY_CODE');
     $result = $ModelTable->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelReportDataList($firstrow,$listrows,$where){
      $ModelTable = M("housereport");
      $where['city_code']=C('CITY_CODE');
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   public function modelGetReporteFind($where){
      $ModelTable = M("housereport");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelUpdate($data){
      $ModelTable = M("housereport");
      $where['id']=$data['id'];
      $result=$ModelTable->where($where)->save($data); 
      return $result;
   }
   public function modelGetAdmin($where){
      $ModelTable = M("admin_user");
      $result=$ModelTable->where($where)->find();
      return $result;
   }
   public function modelFindHouseRoom ($fields,$where)
   {
      $ModelTable = M("houseroom");
      $result = $ModelTable->field($fields)->where($where)->find();
      return $result;   
   }
}
?> 
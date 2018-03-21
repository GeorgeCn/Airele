<?php
namespace Home\Model;
use Think\Model;
class awardcustomer{
   public function modelList($where){
      $ModelTable = M("awardcustomer");
      $datalist = $ModelTable->where($where)->order('create_time desc')->select();
      return $datalist;
   }
   public function modelfind($where){
     $Model = M("awardcustomer");
     $where['city_code']=C('CITY_CODE');
     return $Model->where($where)->find();

   }
   public function modelRoomFind($where){
      $ModelTable=D('view_houseinfo');
    $result=$ModelTable->field('room_id,room_no,status,region_name,scope_name,room_money,main_img_path,city_code,estate_name')->where($where)->find();
    return $result;
  }
}
?> 
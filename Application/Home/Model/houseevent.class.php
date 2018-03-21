<?php
namespace Home\Model;
use Think\Model;
class houseevent{
    //获取委托分页数据
   public function modelPageCount($where){
     $ModelTable = M("houseactivity");
     $where['city_code']=C('CITY_CODE');
     $result = $ModelTable->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelDataList($firstrow,$listrows,$where){
      $ModelTable = M("houseactivity");
      $where['city_code']=C('CITY_CODE');
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   public function modelByIdFind($where){
      $ModelTable = M("houseactivity");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelAdd($data){
      $ModelTable = M("houseactivity");
      $data['city_code']=C('CITY_CODE');
      $result=$ModelTable->data($data)->add();
      return $result;
   }
   public function modelRoomId($where){
      $ModelTable = M("houseroom");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->field('id')->where($where)->find();
      return $result;
   }

   public function modelupdate($data){
      $ModelTable = M("houseactivity");
      $condition['id']=$data['id'];
      $condition['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelGet($where){
      $ModelTable = M("houseactivity");
      $where['city_code']=C('CITY_CODE');
      $result = $ModelTable->where($where)->select();
      return $result;
   }
   public function modelUpdataByType($type_id){
      $ModelTable = M("houseactivity");
      $condition['type_id']=$type_id;
      $condition['city_code']=C('CITY_CODE');
      $datare['record_status']=0;
      $result = $ModelTable->where($condition)->save($datare);
      return $result;
   }
}
?> 
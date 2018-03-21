<?php
namespace Home\Model;
use Think\Model;
class circlehot{
    const connecdata = 'DB_DATA';
    //总条数
   public function modelCircleInfoCount($where){
     $ModelTable = M("circleinfo");
     $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->join('circlemember ON circleinfo.id = circlemember.circle_id')->where($where)->where('circlemember.user_level=1')->count();
     return $result;
   }
   public function modelCircleInfoList($firstrow,$listrows,$where){
       $ModelTable = M("circleinfo");
       $where['city_id']=C('CITY_CODE');
       $datalist = $ModelTable->field('circleinfo.*,circlemember.customer_id,circlemember.user_level')->join('circlemember ON circleinfo.id = circlemember.circle_id')->where($where)->where('circlemember.user_level=1')->order('circleinfo.index_no ASC')->limit($firstrow,$listrows)->select();
       return $datalist;
    }
}
?>
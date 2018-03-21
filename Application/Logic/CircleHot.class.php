<?php
namespace Logic;
use Think\Controller;
class CircleHot{
	 //统计总条数
     public function getCircleInfoCount($where){
        $modelDal=new \Home\Model\circlehot();
        $result=$modelDal->modelCircleInfoCount($where);
        return $result;
    }
    //获取分页数据
    public function getCircleInfoList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\circlehot();
        $result=$modelDal->modelCircleInfoList($firstrow,$listrows,$where);
        return $result;     
    }
  
}
?>
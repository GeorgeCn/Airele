<?php
namespace Logic;
use Think\Controller;
class OrderPayStatus extends Controller{
  
    //获取分页数据
    public function getStagingList($where){
  		$modelDal=new \Home\Model\orderpaystatus();
        $result=$modelDal->modelStagingList($where);
        return $result;     
    }
    public function modelAdd($data){
        $modelDal=new \Home\Model\orderpaystatus();
        $result=$modelDal->modelAdd($data);
        return $result;  
    }
}
?>
<?php
namespace Logic;
use Think\Controller;
class ServiceMan extends Controller{
    //统计总条数
	 public function modelServicePageCount($where){
    	$modelDal=new \Home\Model\serviceman();
    	$result=$modelDal->modelServicePageCount($where);
    	return $result;
    }
    //获取分页数据
    public function modelServiceList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\serviceman();
        $result=$modelDal->modelServiceList($firstrow,$listrows,$where);
        return $result;     
    }
    public function modelServiceFind($where){
        $modelDal=new \Home\Model\serviceman();
        $result=$modelDal->modelServiceFind($where);
        return $result;  
    }
    public function modelServiceUpdate($data){
        $modelDal=new \Home\Model\serviceman();
        $result=$modelDal->modelServiceUpdate($data);
        return $result;  
    }
    public function modelServiceAdd($data){
        $modelDal=new \Home\Model\serviceman();
        $result=$modelDal->modelServiceAdd($data);
        return $result; 
    }
}
?>
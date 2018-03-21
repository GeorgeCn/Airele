<?php
namespace Logic;
use Think\Controller;
class ServiceOrder extends Controller{
    //统计总条数
	 public function modelServicePageCount($where){
    	$modelDal=new \Home\Model\serviceorder();
    	$result=$modelDal->modelServicePageCount($where);
    	return $result;
    }
    //获取分页数据
    public function modelServiceList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelServiceList($firstrow,$listrows,$where);
        return $result;     
    }
    public function modelServiceFind($where){
        $modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelServiceFind($where);
        return $result;  
    }
    public function modelServiceUpdate($data){
        $modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelServiceUpdate($data);
        return $result;  
    }
    public function modelCount($where){
        $modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelCount($where);
        return $result;  
    }
    public function modelServiceFinanPageCount($where){
        $modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelServiceFinanPageCount($where);
        return $result;
    }
    public function modelServiceFinanList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\serviceorder();
        $result=$modelDal->modelServiceFinanList($firstrow,$listrows,$where);
        return $result;
    }
}
?>
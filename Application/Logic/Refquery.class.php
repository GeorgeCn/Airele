<?php
namespace Logic;
use Think\Controller;
class Refquery extends Controller{
    //统计总条数
	 public function getRefqueryPageCount($where){
    	$modelDal=new \Home\Model\refquery();
    	$result=$modelDal->modelRefqueryPageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getRefqueryDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\refquery();
        $result=$modelDal->modelRefqueryDataList($firstrow,$listrows,$where);
        return $result;     
    }
}
?>
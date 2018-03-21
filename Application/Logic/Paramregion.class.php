<?php
namespace Logic;
use Think\Controller;
class Paramregion extends Controller{
	//区域板块列表
	 public function getParamRegionList($region_id){
    	$modelDal=new \Home\Model\paramregion();
    	$result=$modelDal->modelParamRegionList($region_id);
    	return $result;
    }
    public function getParamRegion($where){
    	$modelDal=new \Home\Model\paramregion();
    	$result=$modelDal->modelParamRegion($where);
    	return $result;
    }
    //添加区域板块
    public function addParamRegion($data){
    	$modelDal=new \Home\Model\paramregion();
    	$result=$modelDal->modelAddParamRegion($data);
    	return $result;
    }
    //删除房源参数
    public function delParamRegion($where){
    	$modelDal=new \Home\Model\paramregion();
    	$result=$modelDal->modeldelParamRegion($where);
    	return $result;
    }
    //修改区域板块
    public function upParamRegion($data){
    	$modelDal=new \Home\Model\paramregion();
    	$result=$modelDal->modelUpParamRegion($data);
    	return $result;
    }
    public function maxParamRegion(){
        $modelDal=new \Home\Model\paramregion();
        $result=$modelDal->modelParamFind();
        return $result;
    }
}
?>
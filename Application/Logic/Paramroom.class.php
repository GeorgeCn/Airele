<?php
namespace Logic;
use Think\Controller;
class Paramroom extends Controller{
	//房源参数列表
	 public function getParamRoomList($keyword){
    	$modelDal=new \Home\Model\paramroom();
    	$result=$modelDal->modelParamRoomList($keyword);
    	return $result;
    }
    public function getParamRoom($where){
    	$modelDal=new \Home\Model\paramroom();
    	$result=$modelDal->modelParamRoom($where);
    	return $result;
    }
    //添加房源参数
    public function addParamRoom($data){
    	$modelDal=new \Home\Model\paramroom();
    	$result=$modelDal->modelAddParamRoom($data);
    	return $result;
    }
    //删除房源参数
    public function delParamRoom($where){
    	$modelDal=new \Home\Model\paramroom();
    	$result=$modelDal->modeldelParamRoom($where);
    	return $result;
    }
    //修改房源参数
    public function upParamRoom($data){
    	$modelDal=new \Home\Model\paramroom();
    	$result=$modelDal->modelUpParamRoom($data);
    	return $result;
    }
    public function getCacheSysmenuList($keyword){
        $result=$this->getParamRoomList($keyword);
        return $result;
    }
}
?>
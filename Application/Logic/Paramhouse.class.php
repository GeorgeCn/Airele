<?php
namespace Logic;
use Think\Controller;
class Paramhouse extends Controller{
	//房源参数列表
	 public function getParamHouseList($keyword){
    	$modelDal=new \Home\Model\paramhouse();
    	$result=$modelDal->modelParamHouseList($keyword);
    	return $result;
    }
    public function getParamHouse($where){
    	$modelDal=new \Home\Model\paramhouse();
    	$result=$modelDal->modelParamHouse($where);
    	return $result;
    }
    //添加房源参数
    public function addParamHouse($data){
    	$modelDal=new \Home\Model\paramhouse();
    	$result=$modelDal->modelAddParamHouse($data);
    	return $result;
    }
    //删除房源参数
    public function delParamHouse($where){
    	$modelDal=new \Home\Model\paramhouse();
    	$result=$modelDal->modeldelParamHouse($where);
    	return $result;
    }
    //修改房源参数
    public function upParamHouse($data){
    	$modelDal=new \Home\Model\paramhouse();
    	$result=$modelDal->modelUpParamHouse($data);
    	return $result;
    }

     public function SelectTypeNo($where){
        $modelDal=new \Home\Model\paramhouse();
        $result=$modelDal->modelSelectTypeNo($where);
        return $result;
    }


}
?>
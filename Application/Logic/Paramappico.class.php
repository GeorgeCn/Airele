<?php
namespace Logic;
use Think\Controller;
class Paramappico extends Controller{
	 public function getParamappicoList($keyword){
    	$modelDal=new \Home\Model\paramappico();
    	$result=$modelDal->modelParamappicoList($keyword);
    	return $result;
    }
    public function getParamappico($where){
    	$modelDal=new \Home\Model\paramappico();
    	$result=$modelDal->modelParamappico($where);
    	return $result;
    }
    public function addParamappico($data){
    	$modelDal=new \Home\Model\paramappico();
    	$result=$modelDal->modelAddParamappico($data);
    	return $result;
    }
    public function delParamappico($where){
    	$modelDal=new \Home\Model\paramappico();
    	$result=$modelDal->modeldelParamappico($where);
    	return $result;
    }
    public function upParamappico($data){
    	$modelDal=new \Home\Model\paramappico();
    	$result=$modelDal->modelUpParamappico($data);
    	return $result;
    }
     public function getCacheParamappicoList($keyword){
        $result=$this->getParamappicoList($keyword);
        return $result;
    }
}
?>
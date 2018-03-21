<?php
namespace Logic;
use Think\Controller;
class Present extends Controller {
	//加入管家统计
    public function getKeeperPageCount($where){
    	$modelDal=new \Home\Model\present();
    	$result=$modelDal->modelKeeperPageCount($where);
    	return $result;
    }
    //获取加入管家分页数据
    public function getKeeperDataList($firstrow,$listrows,$where){
    	$modelDal=new \Home\Model\present();
    	$result=$modelDal->modelKeeperDataList($firstrow,$listrows,$where);
    	return $result;   	
    }
    //委托统计
    public function getIntrustPageCount($where){
        $modelDal=new \Home\Model\present();
        $result=$modelDal->modelIntrustPageCount($where);
        return $result;
    }
    //获取委托分页数据
    public function getIntrustDataList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\present();
        $result=$modelDal->modelIntrustDataList($firstrow,$listrows,$where);
        return $result;     
    }

}
?>
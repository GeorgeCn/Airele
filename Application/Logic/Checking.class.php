<?php
namespace Logic;
use Think\Controller;
class Checking extends Controller{
	 public function modelreceipts($starttime,$endtime){
    	$modelDal=new \Home\Model\checking();
    	$result=$modelDal->modelreceipts($starttime,$endtime);
    	return $result;
    }
    public function modelenter($starttime,$endtime){
        $modelDal=new \Home\Model\checking();
        $result=$modelDal->modelenter($starttime,$endtime);
        return $result;
    }
    public function modelreimburse($starttime,$endtime){
        $modelDal=new \Home\Model\checking();
        $result=$modelDal->modelreimburse($starttime,$endtime);
        return $result;
    }
 
}
?>
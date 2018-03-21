<?php
namespace Logic;
use Think\Controller;
class Feedback extends Controller{
	 public function modelFeedbackCount($where){
    	$modelDal=new \Home\Model\feedback();
    	$result=$modelDal->modelFeedbackCount($where);
    	return $result;
    }
    public function modelFeedbackList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\feedback();
        $result=$modelDal->modelFeedbackList($firstrow,$listrows,$where);
        return $result;     
    }
    
}
?>
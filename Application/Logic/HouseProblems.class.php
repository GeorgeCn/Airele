<?php
namespace Logic;
use Think\Controller;
class HouseProblems extends Controller{
     public function modelProblemsCount($where){
        $modelDal=new \Home\Model\houseproblems();
        $result=$modelDal->modelProblemsCount($where);
        return $result;
    }

    public function modelProblemsList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\houseproblems();
        $result=$modelDal->modelProblemsList($firstrow,$listrows,$where);
        return $result;     
    }

    public function modelUpdata($data){
         $modelDal=new \Home\Model\houseproblems();
        $result=$modelDal->modelUpdata($data);
        return $result;
    }
    public function modelFind($where){
         $modelDal=new \Home\Model\houseproblems();
        $result=$modelDal->modelFind($where);
        return $result;
    }
    public function getRoomIdsByCustomerId($owner_id){
         $modelDal=new \Home\Model\houseproblems();
        $result=$modelDal->getRoomIdsByCustomerId($owner_id);
        return $result;
    }

}
?>
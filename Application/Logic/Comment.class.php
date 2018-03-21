<?php
namespace Logic;
use Think\Controller;
class Comment{
	   //统计总条数
     public function getCommentPageCount($where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelCommentPageCount($where);
        return $result;
    }
    //获取分页数据
    public function getCommentList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelCommentList($firstrow,$listrows,$where);
        return $result;     
    }

     public function getDetailedPageCount($where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelDetailedPageCount($where);
        return $result;     
    }
    //获取房东姓名
    public function getDetailedComment($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelDetailedComment($firstrow,$listrows,$where);
        return $result;     
    }
    //删除评论
     public function delComment($delid){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modeldelComment($delid);
        return $result;     
    }
    public function getCustomerById($owner){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelCustomerById($owner);
        return $result;  
    }

    public function getCustomer($where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelCustomer($where);
        return $result;  
    }
    public function modelAdd($data){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelAdd($data);
        return $result;
    }

    public function modelFind($where){
        $modelDal=new \Home\Model\comment();
        $result=$modelDal->modelFind($where);
        return $result;
    }
}
?>
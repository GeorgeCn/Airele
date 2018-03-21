<?php
namespace Logic;
use Think\Controller;
class CircleManage{
	 //统计总条数
     public function getCircleInfoCount($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleInfoCount($where);
        return $result;
    }
    //获取分页数据
    public function getCircleInfoList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleInfoList($firstrow,$listrows,$where);
        return $result;     
    }
    //修改圈子
    public function upCircleInfo($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelupCircleInfo($where);
        return $result;  
    }

    public function getCircleInfoFind($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleInfoFind($where);
        return $result;  
    }
    
    //获取用户信息
    public function getCustomerById($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCustomerById($where);
        return $result;  
    }
    //获取帖子总数
    public function getCirclePostsCount($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCirclePostsCount($where);
        return $result;

    }
    public function getCirclePostsList($firstrow,$listrows,$where){
         $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCirclePostsList($firstrow,$listrows,$where);
        return $result;
    }
    //修改帖子状态
    public function upCirclePost($data){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelupCirclePost($data);
        return $result;  
    }

    public function getCirclePostFind($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCirclePostFind($where);
        return $result;  
    }
  //帖子回复
    public function getCirclePostsReplayCount($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCirclePostsReplayCount($where);
        return $result;
    }
    public function getCirclePostReplay($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCirclePostReplay($firstrow,$listrows,$where);
        return $result;
    }

    public function getPostReplayFind($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelPostReplayFind($where);
        return $result; 
    }
    public function upReplayState($data){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelupReplayState($data);
        return $result;
    }
    //获取成员
    public function getCircleMemberCount($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleMemberCount($where);
        return $result;
    }
    public function getCircleMember($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleMember($firstrow,$listrows,$where);
        return $result;
    }
    public function getCircleMemberFind($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelCircleMemberFind($where);
        return $result;
    }
    public function upCircleMemberState($data){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelupCircleMemberState($data);
        return $result;
    }
    //删除圈子成员
    public function delCircleMember($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modelDelCircleMember($where);
        return $result;
    }
    //ajax获取回复数
    public function AjaxCircleReply($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modeAjaxCircleReply($where);
        return json_encode($result);
    }
    //回复
    public function addCirclePostrePlay($data){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modeAddCirclePostrePlay($data);
        return $result;
    }
    //获取最大楼层
    public function getReplyPositionMax($where){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modeReplyPositionMax($where);
        return $result;
    }
    
      //圈子排序
    public function upSortDispose($data){
        $modelDal=new \Home\Model\circlemanage();
        $result=$modelDal->modeSortDispose($data);
        return $result;
    }
}
?>
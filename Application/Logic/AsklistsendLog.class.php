<?php
namespace Logic;
use Think\Controller;
class AsklistsendLog{

     public function modelAsklistCount($where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAsklistCount($where);
        return $result;
    }

    public function modelAskList($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAskList($firstrow,$listrows,$where);
        return $result;     
    }
    
    public function modelAskListStatusCount(){
         $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAskListStatusCount();
        return $result;
    }
    public function modelAskListStatus($firstrow,$listrows){
         $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAskListStatus($firstrow,$listrows);
        return $result;     
        
    }
    public function modelAsklistReceiveCount($where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAsklistReceiveCount($where);
        return $result; 
    }

    public function modelAskListReceive($firstrow,$listrows,$where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelAskListReceive($firstrow,$listrows,$where);
        return $result; 
    }
  
    public function modelUpdate($data){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelUpdate($data);
        return $result; 
    }
    public function modelUpdateLog($data){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelUpdateLog($data);
        return $result; 
    }
    public function modelFind($where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelFind($where);
        return $result; 

    }
    public function modelLogFind($where){
        $modelDal=new \Home\Model\asklistsendlog();
        $result=$modelDal->modelLogFind($where);
        return $result; 
    }
    //下房、更新时间调用
    public function commonupstate($room_id,$state){
        //$room_id:房间id,$state:状态1=已出租，2=更新房间
        if($room_id!=""&&$state!=""){
            $where['room_id']=$room_id;
            $where['is_deal']=0;
            $asklistreceive=$this->modelFind($where);
            if($asklistreceive){
                $data1['id']=I('get.id');
                $data1['is_update']=1;
                $data1['is_deal']=1;
                $this->modelUpdate($data1);
                $data2['id']=I('get.id');
                $data2['log_update']=1;
                $data2['is_deal']=1;
                $this->modelUpdateLog($data2);
            }
        }
    }
    //查找短信问房更新房间
    public function getAskReceiveRoom ()
    {
        $modelDal = new \Home\Model\asklistsendlog();
        $fields = 'a.id,a.room_id';
        $where['a.create_time'] = array('gt',time()-3600*24*3);
        $where['a.is_deal'] = array('eq',0);
        $where['a.is_lease'] = array('eq',0);
        $where['a.is_update'] = array('eq',0);
        $where['b.status'] = 2;
        $data = $modelDal->modelGetAskReceiver('','',$fields,$where);
        return $data;
    }
}
?>
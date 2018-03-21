<?php
namespace Logic;
use Think\Controller;
class HouseEventLogic extends Controller{
    //统计总条数
	 public function modelPageCount($where){
    	$modelDal=new \Home\Model\houseevent();
    	$result=$modelDal->modelPageCount($where);
    	return $result;
    }
    //获取分页数据
    public function modelDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelDataList($firstrow,$listrows,$where);
        return $result;     
    }
    public function modelByIdFind($where){
        $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelByIdFind($where);
        return $result;
    }
    public function modelAdd($data){
        $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelAdd($data);
        return $result; 
    }
    public function modelRoomId($where){
         $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelRoomId($where);
        return $result; 
    }
    public function modelupdate($data){
        $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelupdate($data);
        return $result; 
    }
    public function modelGet($where){
        $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelGet($where);
        return $result; 
    }
    public function modelUpdataByType($type_id){
        $modelDal=new \Home\Model\houseevent();
        $result=$modelDal->modelUpdataByType($type_id);
        return $result; 
    }
}
?>
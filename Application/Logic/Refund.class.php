<?php
namespace Logic;
use Think\Controller;
class Refund extends Controller{
    //获取打款时间
    public function getOrderOperator($order_id){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderOperator($order_id);
        return $result;
    }

    //统计总条数
	 public function getRefundPageCount($where){
    	$modelDal=new \Home\Model\refund();
    	$result=$modelDal->modelRefundPageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getRefundDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\refund();
        $result=$modelDal->modelRefundDataList($firstrow,$listrows,$where);
        return $result;     
    }
     //获取打款金额统计
    public function getCountHouseMoney($where){
        $modelDal=new \Home\Model\refund();
        $result=$modelDal->modelCountHouseMoney($where);
        return $result;   
    }
}
?>
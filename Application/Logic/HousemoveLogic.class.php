<?php
namespace Logic;
class HousemoveLogic{
	/*6元搬家活动 */
	//获取用户下的订单
	public function getOrderByMobile($mobile){
		$modelDal=new \Home\Model\activityhousemove();
		return $modelDal->getModelByMobile($mobile);
	}
	public function getOrderByNo($order_no){
		$modelDal=new \Home\Model\activityhousemove();
		return $modelDal->getModelByNo($order_no);
	}
	//审核成功
	public function examSuccess($order_no,$coupon_code,$oper_name){
		$modelDal=new \Home\Model\activityhousemove();
		$data['id']=$order_no;
		$data['order_status']=4;
		$data['coupon_code']=$coupon_code;
		$data['update_time']=time();
		$result=$modelDal->updateModel($data);
		if($result){
			//add log
			$log['id']=create_guid();
			$log['order_id']=$order_no;
			$log['order_status']=$data['order_status'];
			$log['create_time']=time();
			$log['oper_id']=$oper_name;
			$modelDal->addLog($log);
		}
		return $result;
	}
	//审核失败，待退款状态
	public function examFail($order_no,$fail_reason,$oper_name){
		$modelDal=new \Home\Model\activityhousemove();
		$data['id']=$order_no;
		$data['order_status']=6;
		$data['fail_reason']=$fail_reason;
		$data['update_time']=time();
		$result = $modelDal->updateModel($data);
		if($result){
			//add log
			$log['id']=create_guid();
			$log['order_id']=$order_no;
			$log['order_status']=$data['order_status'];
			$log['create_time']=time();
			$log['oper_id']=$oper_name;
			$modelDal->addLog($log);
		}
		return $result;
	}
	//已退款状态
	public function refundSuccess($order_no,$oper_name){
		$modelDal=new \Home\Model\activityhousemove();
		$data['id']=$order_no;
		$data['order_status']=7;
		$data['update_time']=time();
		$result = $modelDal->updateModel($data);
		if($result){
			//add log
			$log['id']=create_guid();
			$log['order_id']=$order_no;
			$log['order_status']=$data['order_status'];
			$log['create_time']=time();
			$log['oper_id']=$oper_name;
			$modelDal->addLog($log);
		}
		return $result;
	}
	#list
	public function getModelListCount($condition){
	  $conditionString=$this->getConditionString($condition);
	  $model=new \Home\Model\activityhousemove();
	  return $model->getModelListCount($conditionString);
	}
	public function getModelList($condition,$limit_start,$limit_end){
	  $conditionString=$this->getConditionString($condition);	
	  $model=new \Home\Model\activityhousemove();
	  return $model->getModelList($conditionString,$limit_start,$limit_end);
	}
	private function getConditionString($condition)
	{
		$conditionString="";
		if (isset($condition['mobile']) && !empty($condition['mobile'])) {
			$conditionString.=" and customer_mobile='".$condition['mobile']."'";
		}
		if (isset($condition['status']) && !empty($condition['status'])) {
			$conditionString.=" and order_status='".$condition['status']."'";
		}
		return $conditionString;
	}
	public function getLogsByOrderid($order_id){
	  $model=new \Home\Model\activityhousemove();
	  return $model->getLogsByOrderid($order_id);
	}
}
?>
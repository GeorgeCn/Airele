<?php
namespace Logic;
class CashBackLogic 
{
	//根据room_no查找houseroom
	public function findHouseroom ($roomNO)
	{
		if(empty($roomNO)) return null;
		$modelDal = new \Home\Model\cashback();
		$fields = 'principal_man'; 
		$where['room_no'] = $roomNO;
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result;
	}
	//根据customer_id查找customer
	public function findCustomer ($cid)
	{
		if(empty($cid)) return null;
		$modelDal = new \Home\Model\cashback();
		$fields = 'true_name,mobile'; 
		$where['id'] = $cid;
		$result = $modelDal->modelFindCustomer($fields,$where);
		return $result;
	}
	//根据id查找customercouponcash
	public function findCouponCash ($data)
	{
		if(empty($data['id'])) return null;
		$modelDal = new \Home\Model\cashback();
		$fields = 'id,mobile,name,alipay_acc,coupon_id,id_card,memo'; 
		$where['id'] = trim($data['id']);
		$result = $modelDal->modelFindCouponCash($fields,$where);
		return $result;
	}
	//根据id修改customercouponcash信息
	public function updateCouponCash ($data)
	{
		if(empty($data['id'])||empty($data['name'])||empty($data['alipay_acc'])||empty($data['coupon_id'])) return false;
		$modelDal = new \Home\Model\cashback();
		$info['id'] = trim($data['id']);
		$info['name'] = trim($data['name']);
		$info['alipay_acc'] = trim($data['alipay_acc']);
		$info['status_code'] = $data['status_code'];
		$info['id_card'] = trim($data['id_card']);
		$info['memo'] = trim($data['memo']);
		$info['cashback_time'] = time();
		$result = $modelDal->modelUpdateCouponCash($info);
		return $result;
	}
	//根据coupon_id修改customercoupon状态
	public function updateCustomercoupon ($data)
	{
		$modelDal = new \Home\Model\cashback();
		$info['id'] = trim($data['coupon_id']);
		if($data['status_code'] == 3 || $data['status_code'] == 4) {
			$info['flag'] = 1;
		}
		$info['status_code'] = trim($data['status_code']);
		$result = $modelDal->modelUpdateCustomerCoupon($info);
		return $result;
	}
	//根据coupon_id修改couponstatus状态
	public function updateCouponStatus ($data)
	{
		$modelDal = new \Home\Model\cashback();
		$where['coupon_id'] = trim($data['coupon_id']);
		$info['status_code'] = trim($data['status_code']);
		$result = $modelDal->modelUpdateCouponStatus($where,$info);
		return $result;
	}
}
?>
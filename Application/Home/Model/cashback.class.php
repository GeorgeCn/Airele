<?php
namespace Home\Model;
use Think\Model;
class cashback
{
	const connection = "DB_DATA";
	//获取customercouponcash信息
	public function modelGetCouponCash ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("customercouponcash","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//查找customercouponcash信息
	public function modelFindCouponCash ($fields,$where)
	{
		$ModelTable = M("customercouponcash","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//统计customercouponcash礼券数量
	public function modelCountCouponCash ($where)
	{
		$ModelTable = M("customercouponcash","",self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//查找houseroom的信息
	public function modelFindHouseRoom ($fields,$where)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//查找customer的信息
	public function modelFindCustomer ($fields,$where)
	{
		$ModelTable = M("customer","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//修改customercouponcash礼券信息
	public function modelUpdateCouponCash ($data)
	{
		$ModelTable = M("customercouponcash","",self::connection);
		$result = $ModelTable->data($data)->save();
		return $result;
	}
	//修改customercoupon信息
	public function modelUpdateCustomerCoupon ($data)
	{
		$ModelTable = M("customercoupon","",self::connection);
		$result = $ModelTable->data($data)->save();
		return $result;
	}
	//修改couponstatus信息
	public function modelUpdateCouponStatus ($where,$data)
	{
		$ModelTable = M("couponstatus","",self::connection);
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
}
<?php
namespace Home\Model;
use Think\Model;
class usersocialmsg 
{
	const connection = "DB_RECOMMEND";
	//获取租户信息
	public function modelGetUserMsg ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("user_socialize_msg","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//统计租户数量
	public function modelCountUserMsg ($where)
	{
		$ModelTable = M("user_socialize_msg",'',self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//查找用户信息
	public function modelfindCustomer ($fields,$where)
	{
		$ModelTable = M();
		$result = $ModelTable->table('gaodudata.customer')->field($fields)->where($where)->find();
		return $result;
	}
}
?>
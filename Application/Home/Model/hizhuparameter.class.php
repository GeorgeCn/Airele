<?php
namespace Home\Model;
use Think\Model;
class hizhuparameter
{
	//统计ownerfeecontent数量
	public function modelCountOwnerFee ($where)
	{		
		$ModelTable = M("ownerfeecontent");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取ownerfeecontent信息
	public function modelGetOwnerFee ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("ownerfeecontent");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//新增ownerfeecontent信息
    public function modelAddOwnerFee ($data)
    {
		$ModelTable = M("ownerfeecontent");
		$result = $ModelTable->data($data)->add();
		return $result;
    }
    //修改ownerfeecontent信息
   	public function modelModifyOwnerFee ($data)
	{
		$ModelTable = M("ownerfeecontent");
		$result = $ModelTable->data($data)->save();
		return $result;
	} 
	//统计ownerorder数量
	public function modelCountOwnerOrder ($where)
	{		
		$ModelTable = M("ownerorder");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取ownerorder信息
	public function modelGetOwnerOrder ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("ownerorder");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
}
?>
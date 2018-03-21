<?php
namespace Home\Model;
use Think\Model;
class versioninfo
{
	const connection = "DB_STORE";
	//获取租户版更新信息
	public function modelGetRenter ($firstRow,$listRows,$where)
	{
		$ModelTable = M("clientupdateinfo");
		$result = $ModelTable->where($where)->order('curver desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//获取房东版更新信息
	public function modelGetOwner ($firstRow,$listRows,$where)
	{
		$ModelTable = M("clientupdateinfo",'',self::connection);
		$result = $ModelTable->where($where)->order('curver desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//增加租房版本信息
	public function modelAddRenter ($data)
	{
		$ModelTable = M("clientupdateinfo");
		$result = $ModelTable->data($data)->add();
		return $result; 
	}
	//增加房东版本信息
	public function modelAddOwner ($data)
	{
		$ModelTable = M("clientupdateinfo",'',self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//更新租房版本信息
	public function modelUpdateRenter ($data)
	{
		$ModelTable = M("clientupdateinfo");
		$result = $ModelTable->data($data)->save();
		return $result; 
	}
	//更新房东版本信息
	public function modelUpdateOwner ($data)
	{
		$ModelTable = M("clientupdateinfo",'',self::connection);
		$result = $ModelTable->data($data)->save();
		return $result;
	}
	//统计租户版信息数量
	public function modelCountRenter ($where)
	{
		$ModelTable = M("clientupdateinfo");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//统计房东版信息数量
	public function modelCountOwner ($where)
	{
		$ModelTable = M("clientupdateinfo",'',self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//根据ID删除租客版本信息
	public function modelDeleteRenter ($where)
	{
		$ModelTable = M("clientupdateinfo");
		$result = $ModelTable->where($where)->delete();
		return $result;
	}
	//根据ID删除房东版本信息
	public function modelDeleteOwner ($where)
	{
		$ModelTable = M("clientupdateinfo",'',self::connection);
		$result = $ModelTable->where($where)->delete();
		return $result;
	}
}
?>
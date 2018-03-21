<?php
namespace Home\Model;
use Think\Model;
class vodclient
{
	//创建houseroomvideo视频信息
	public function modelAddHouseVideo ($data)
	{
		$ModelTable = M("houseroomvideo");
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//获取houseroomvideo视频信息
	public function modelGetHouseVideo ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("houseroomvideo");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//查找houseroomvideo的视频信息
	public function modelFindHouseVideo ($fields,$where)
	{
		$ModelTable = M("houseroomvideo");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//统计houseroomvideo视频数量
	public function modelCountHouseVideo ($where)
	{
		$ModelTable = M("houseroomvideo");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//更改视频图片信息
	public function modelUpdateHouseVideo ($where,$data) 
	{
		$ModelTable = M("houseroomvideo");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//删除视频信息
	public function modelDeleteHouseVideo ($where)
	{
		$ModelTable = M("houseroomvideo");
		$result = $ModelTable->where($where)->delete();
		return $result;
	}
	//查找houseroom信息
	public function modelFindHouseRoom ($fields,$where)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//修改houseroom信息
	public function modelUpdateHouseRoom ($where,$data)
	{	
		$ModelTable = M("houseroom");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
}
?>
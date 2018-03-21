<?php
//在模型里单独设置数据库连接信息
namespace Home\Model;
use Think\Model;
class adminmenulist{
    //调用配置文件中的数据库配置1
    
	/*根据设备ID返回一个数组*/
	public function modelGet($id)
	{
		$ModelTable=M('adminmenulist');
		$condition['id'] =$id;
		$condition['record_status'] ="1";
		$result=$ModelTable->where($condition)->find();
		return $result;
	}

	/*添加对象*/
	public function addModel($modelArray)
	{
		$ModelTable=M('adminmenulist');
	    $data['name'] =$modelArray['name'];
	    $data['url'] =$modelArray['url'];
		$data['parent_id'] =$modelArray['parent_id'];
		$data['create_time'] =time();
		$data['record_status'] ="1";
		$result=$ModelTable->data($data)->add();
		return $result;
	}

	/*更新对象*/
	public function updateModel($modelArray)
	{
		$ModelTable=M('adminmenulist');
	    $data['name'] =$modelArray['name'];
	    $data['url'] =$modelArray['url'];
		$data['parent_id'] =$modelArray['parent_id'];
		$data['record_status'] =$modelArray['record_status'];
		$result=$Model->where($condition)->save($data);
		return $result;
	}
	
	/*获取所有数组*/
	public function modelList($parent_id)
	{
		$ModelTable=M('adminmenulist');
		$condition['parent_id'] =$parent_id;
		$condition['record_status'] ="1";
		$result=$ModelTable->where($condition)->order('index_no asc')->select();
		return $result;
	}	
}
?>
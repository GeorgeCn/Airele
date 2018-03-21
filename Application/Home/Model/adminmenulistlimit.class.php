<?php
//在模型里单独设置数据库连接信息
namespace Home\Model;
use Think\Model;
class adminmenulistlimit{
    //调用配置文件中的数据库配置1
    
	/*根据设备ID返回一个数组*/
	public function modelGet($id)
	{
		$ModelTable=M('adminmenulistlimit');
		$condition['id'] =$id;
		$condition['city_auth'] =C('CITY_NO');
		$condition['record_status'] ="1";
		$result=$ModelTable->where($condition)->find();
		return $result;
	}

	/*添加对象*/
	public function addModel($modelArray)
	{
		$ModelTable=M('adminmenulistlimit');
		$data['id'] =$modelArray['id'];
	    $data['user_name'] =$modelArray['user_name'];
	    $data['menu_id'] =$modelArray['menu_id'];
		$data['parent_id'] =$modelArray['parent_id'];
		$data['menu_name'] =$modelArray['menu_name'];
		$data['menu_url'] =$modelArray['menu_url'];
		$data['create_time'] =time();
		$data['record_status'] ="1";
		$data['city_auth'] =C('CITY_NO');
		$result=$ModelTable->data($data)->add();
		return $result;
	}

	/*更新对象*/
	public function updateModel($modelArray)
	{
		$ModelTable=M('adminmenulistlimit');
	    $data['user_name'] =$modelArray['user_name'];
	    $data['menu_id'] =$modelArray['menu_id'];
		$data['parent_id'] =$modelArray['parent_id'];
		$data['menu_name'] =$modelArray['menu_name'];
		$data['menu_url'] =$modelArray['menu_url'];
		$data['record_status'] =$modelArray['record_status'];
		$data['city_auth'] =C('CITY_NO');
		$result=$Model->where($condition)->save($data);
		return $result;
	}
	
	/*获取所有数组*/
	public function modelList($username,$parent_id)
	{
		$ModelTable=M('adminmenulistlimit');
		$condition['parent_id'] =$parent_id;
		$condition['user_name'] =$username;
		$condition['city_auth'] =C('CITY_NO');
		$condition['record_status'] ="1";
		$result=$ModelTable->where($condition)->order('index_no ASC')->select();
		/*foreach($json_array as $key=>$val) {
			file_put_contents("ordersub.txt","key:".$key."  val:".$val."\r\n",FILE_APPEND);
		}*/
		return $result;
	}

	/*通过USERNAME删除*/
	public function modelDeleteByUserName($username,$parent_id)
	{
		$ModelTable=M('adminmenulistlimit');
		$condition['parent_id'] =$parent_id;
		$condition['user_name'] =$username;
		$condition['city_auth'] =C('CITY_NO');
		$result=$ModelTable->where($condition)->delete();
		return $result;
	}

	public function modelMenuList($where){
		$ModelTable=M('adminmenulistlimit');
        $result=$ModelTable->where($where)->select();
		return $result;

	}
   public function modelDelete($where){
   		$ModelTable=M('adminmenulistlimit');
		$result=$ModelTable->where($where)->delete();
		return $result;
   }
}
?>
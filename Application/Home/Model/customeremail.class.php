<?php
//客户端更新信息表
namespace Home\Model;
use Think\Model;
class customeremail {
    
     const connection = 'DB_DATA';
	
	/*根据客户ID返回一个数组*/
	public function modelGet($id)
	{
		$ModelTable=M('customeremail','',self::connection);
		 $condition['id']=$id;
		 
		 
	     $result=$ModelTable->where($condition)->find();
		return $result;
	}
	/*根据客户ID返回一个数组*/
	public function modelGetById($room_id)
	{
		$ModelTable=M('customeremail','',self::connection);
		$condition['line_flag']=1;
		$condition['room_id']=$room_id; 
		$condition['record_status']=1; 
	     $result=$ModelTable->where($condition)->find();
		return $result;
	}

	/*增加*/
	public function modelAdd($modelArray)
	{
			$ModelTable=M('customeremail','',self::connection);
			$data['id']=$modelArray['id'];
			$data['customer_id']=$modelArray['customer_id'];
			$data['mail_to']=$modelArray['mail_to'];
			$data['mail_to_name']=$modelArray['mail_to_name'];
			$data['mail_subject']=$modelArray['mail_subject'];
			$data['mail_content']=$modelArray['mail_content'];
			$data['mail_type']=$modelArray['mail_type'];

			$data['is_send']=0;
			$data['create_time']=time();			
			$result=$ModelTable->data($data)->add();
			return $result;
	}

	/*更新*/
	public function modelUpdate($modelArray)
	{
			$ModelTable=M('customeremail','',self::connection);
			$condition['id']=$modelArray['id'];

			$data['customer_id']=$modelArray['customer_id'];
			$data['mail_to']=$modelArray['mail_to'];
			$data['mail_to_name']=$modelArray['mail_to_name'];
			$data['mail_subject']=$modelArray['mail_subject'];
			$data['mail_content']=$modelArray['mail_content'];
			$data['mail_type']=$modelArray['mail_type'];

			
			$result=$ModelTable->where($condition)->save($data); 
			return $result;
	}

	/*删除*/
	public function modelDelete($id)
	{
		$ModelTable=M('customeremail','',self::connection);
		$condition['id']=$id;
		$result=$ModelTable->where($condition)->delete(); 
		return $result;
	}


	
	/*获取列表*/
	public function modelList($where)
	{
		$ModelTable=M('customeremail','',self::connection);
		
		$result=$ModelTable->where($where)->select();
		return $result;
	}
	
	/// 获得数据列表(分页）
    public function modelListLimit($where,$orderby,$limitcount)
    { 
		$ModelTable=M('customeremail','',self::connection);
		$result=$ModelTable->where($where)->order($orderby)->limit($limitcount)->select();
		return $result;
	}
	
	/*返回总数*/
	public function getRecordCount($where)
	{
		$ModelTable=M('customeremail','',self::connection);
		$result = $ModelTable->where($where)->count();
		return $result;
	}
	
	
	
	
}



?>
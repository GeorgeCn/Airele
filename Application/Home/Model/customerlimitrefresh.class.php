<?php
//客户端更新信息表
namespace Home\Model;
use Think\Model;
class customerlimitrefresh{
    
     const connection = 'DB_DATA';
	
	public function modelRefreshCount($where){
		$ModelTable=M('customerlimitrefresh','',self::connection);
    	$result = $ModelTable->where($where)->count();
	    return $result;
	}
	public function modelRefreshList($firstrow,$listrows,$where){
		$ModelTable=M('customerlimitrefresh','',self::connection);
	    $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
        return $datalist;
	}
	public function modelFind($where)
	{  
		 $ModelTable=M('customerlimitrefresh','',self::connection);
	     $result=$ModelTable->where($where)->find();
	   
		 return $result;
	}

	public function modelUpdate($data){
		  $ModelTable=M('customerlimitrefresh','',self::connection);
	      $where['id']=$data['id'];
	      $result = $ModelTable->where($where)->save($data);
	      return $result;
	}

	public function modelDelete($where){
		  $ModelTable=M('customerlimitrefresh','',self::connection);
	      $result = $ModelTable->where($where)->delete();
	      return $result;
	}

	public function modelAdd($data){
		  $ModelTable=M('customerlimitrefresh','',self::connection);
	      $result = $ModelTable->data($data)->add();
	      return $result;
	}

}
?>
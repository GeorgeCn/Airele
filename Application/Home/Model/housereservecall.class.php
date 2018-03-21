<?php
namespace Home\Model;
use Think\Model;
class housereservecall{
	public function addHousereservecallModel($data){
	  	$ModelTable = M("housereservecall");
	  	return $ModelTable->add($data);
	}
	//新增，日志
	public function addCallLogModel($data){
	  	$ModelTable = M("housereservecalllog");
	  	return $ModelTable->add($data);
	}
	//新增，看房日程
	public function addHousereserve($data){
	  	$ModelTable = M("housereserve");
	  	return $ModelTable->add($data);
	}
	#update
	public function updateCallModel($data){
		$ModelTable = M("housereservecall");
		$where['id']=$data['id'];
	  	return $ModelTable->where($where)->save($data);
	}
	//更新预约表信息 by room_id
	public function updateCallModelByRoomid($data){
		$ModelTable = M("housereservecall");
		$where['room_id']=$data['room_id'];
	  	return $ModelTable->where($where)->save($data);
	}
	//更新预约表信息 by resource_id
	public function updateCallModelByResourceid($data){
		$ModelTable = M("housereservecall");
		$where['resource_id']=$data['resource_id'];
	  	return $ModelTable->where($where)->save($data);
	}
	public function getCallModelById($id){
		$ModelTable = M("housereservecall");
		return $ModelTable->where(array('id'=>$id))->find();
	}
	#list
	public function getModelListCount($condition){
	  $model = new Model();
	  $sql="select count(1) as totalCount,count(distinct customer_mobile) as zuke,count(distinct owner_mobile) as fangdong,count(distinct room_id) as roomnum from housereservecall a where record_status=1 ";
	  return $model->query($sql.$condition);
	}
	public function getModelList($condition,$limit_start,$limit_end,$orderby){
	  $model = new Model();
	  $sql="select id,customer_name,customer_mobile,resource_no,room_no,owner_name,owner_mobile,create_time,status,look_time,handle_time,handle_man,handle_reason,resource_id,room_id,city_code,gaodu_platform,is_my,info_resource,brand_type,is_commission,is_monthly,region_name,scope_name,room_money from housereservecall a where record_status=1 ";
	  return $model->query($sql.$condition." order by ".$orderby." limit $limit_start,$limit_end");
	}
	//条件查询
	public function getListByWhere($columns,$where_orderby){
	  $model = new Model();
	  return $model->query("select $columns from housereservecall where ".$where_orderby);
	}
	#下载
	public function getExeclList($query_sql){
	  $model = new Model();
	  return $model->query($query_sql);
	}
	#所有预约
	public function getModelListByCustomerId($customer_id){
	  $model = new Model();
	  $sql="select id,customer_name,customer_mobile,resource_no,room_no,owner_name,owner_mobile,create_time,status,look_time,look_time_end,handle_time,handle_man,handle_reason,resource_id,room_id,
	  customer_bak,city_code,is_recommend,spec_reqs,spec_req_other,info_resource,brand_type,is_commission,is_monthly,region_name,scope_name,room_money from housereservecall where record_status=1 and customer_id='$customer_id' order by create_time desc limit 20";
	  return $model->query($sql);
	}
	#待处理数量
	public function getNotHandleCount(){
	  $model = M("housereservecall");
	  return $model->where("record_status=1 and status=0")->count();
	}
	#获得用户的最大反馈码
	public function getMaxRebackno($phone){
	  $model = M("housereservecall");
	  return $model->where("record_status=1 and status=2 and customer_mobile='$phone'")->max('reback_no');
	}
	 //预约顾问 列表
	  public function getAppointHandleList(){
	    $model = new \Think\Model();
	    return $model->query("select user_name,real_name from admin_user where department in ('客服','住宿合作') order by department desc,user_name asc");
	  }
	  public function getAppointHandleListBykey($key,$limit=10){
	    $model = new \Think\Model();
	    return $model->query("select user_name,real_name from admin_user where user_name like '$key%' or real_name like '$key%' order by user_name asc limit $limit");
	  }
	  //操作更多
	  #检查
	  public function getHadcountByMoreids($array_ids){
	  	$model = M("housereservecall");
	  	$condition['status']=array('gt',0);
	  	$condition['id'] = array('in' , $array_ids);
	  	return $model->where($condition)->count();
	  }
	  #更新
	  public function UpdateHandleByMoreids($array_ids,$handle_man,$handle_time,$status){
	  	$model = M("housereservecall");
	  	$updateModel['handle_man']=$handle_man;
	  	$updateModel['handle_time']=$handle_time;
	  	$updateModel['status']=$status;
	  	$condition['id'] = array('in' , $array_ids);
	  	return $model->where($condition)->save($updateModel);
	  }
	  #将相同租客手机号下面的所有未处理预约更新給当前预约顾问
	  public function UpdateMoreForone($customer_mobile,$handle_man,$handle_time,$status){
	  	$model = M("housereservecall");
	  	$updateModel['handle_man']=$handle_man;
	  	$updateModel['handle_time']=$handle_time;
	  	$updateModel['status']=$status;
	  	$condition['customer_mobile'] = $customer_mobile;
	  	$condition['status']=0;
	  	return $model->where($condition)->save($updateModel);
	  }

	  #帮我找房
	  public function getfindListCount($condition){
	    $model = new Model();
	    $sql="select count(1) as totalCount from findhouse a where 1=1 ";
	    return $model->query($sql.$condition);
	  }
	  public function getfindList($condition,$limit_start,$limit_end){
	    $model = new Model();
	    $sql="select id,user_name,user_mobile,create_time,status,handle_man,handle_time from findhouse a where 1=1 ";
	    return $model->query($sql.$condition." order by create_time desc limit $limit_start,$limit_end");
	  }
	  public function updatefindhouse($data){
	  	$model=M("findhouse");
	  	return $model->where(array('id'=>$data['id']))->save($data);
	  }
	  #百度寻客
	  public function getXunkeListCount($condition){
	    $model = new Model();
	    $sql="select count(1) as totalCount from adbaiduxunke a where 1=1 ";
	    return $model->query($sql.$condition);
	  }
	  public function getXunkeList($condition,$limit_start,$limit_end){
	    $model = new Model();
	    $sql="select id,query,querytime,cityname,city,area,housetype,mobile,status from adbaiduxunke a where 1=1 ";
	    return $model->query($sql.$condition." order by querytime desc limit $limit_start,$limit_end");
	  }
	  public function updateXunke($data){
	  	$model=M("adbaiduxunke");
	  	return $model->where(array('id'=>$data['id']))->save($data);
	  }
}

?>
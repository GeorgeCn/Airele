<?php
namespace Home\Model;
use Think\Model;
class stores
{
	const connection = "DB_STORE";
	const connections = "DB_DATA";
	//创建店铺信息
   public function modelAddStore ($data)
   {
		$ModelTable = M("stores","",self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
   }
	//获取店铺信息
	public function modelGetStores ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("stores","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//统计店铺数量
	public function modelGetCount ($where)
	{
		$ModelTable = M("stores",'',self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//查找店铺信息
	public function modelFindStore ($fields,$where)
	{
		$ModelTable = M("stores",'',self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//更改店铺信息
	public function modelModifyStore ($data)
	{
		$ModelTable = M("stores",'',self::connection);
		$result = $ModelTable->data($data)->save();
		return $result;
	}
	//获取店铺成员信息
	public function modelGetStoreMem ($fields,$where)
	{
		$ModelTable = M("storemembers",'',self::connection);
		$result = $ModelTable->field($fields)->where($where)->select();
		return $result;
	}
	//查找店铺成员信息
	public function modelFindStoreMem ($fields,$where)
	{
		$ModelTable = M("storemembers",'',self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//添加店铺新成员信息
	public function modelAddStoreMem ($data) 
	{
		$ModelTable = M("storemembers",'',self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//添加成员权限信息
	public function modelAddStoreMemLimit ($data) 
	{
		$ModelTable = M("limitmember",'',self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//更改店铺成员信息
	public function modelUpdateStoreMem ($where,$data) 
	{
		$ModelTable = M("storemembers",'',self::connection);
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//查找customer信息
	public function modelFindCustomer ($fields,$where)
	{
		$ModelTable = M("customer",'',self::connections);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//获得houseroom的房源信息
	public function modelGetRoomInfo ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		// return $ModelTable->getLastSql();
		return $result;
	}
	//统计houseroom的店铺房源数
	public function modelCountRoom ($where)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->where($where)->count();
		return $result;
	}
	//查找hoseroom的房间信息
	public function modelFindHouseRoom ($fields,$where)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//更改houseroom的信息
	public function modelUpdateHouseRoom ($where,$data)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//更改houseresource的信息
	public function modelUpdateHouseResource ($where,$data)
	{
		$ModelTable = M("houseresource");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//更改storehouses的信息
	public function modelUpdateStoreHouses ($where,$data)
	{
		$ModelTable = M("storehouses","",self::connection);
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//添加房源移动记录
	public function modelAddStoreOperDetail ($data) 
	{
		$ModelTable = M("storeoperdetail","",self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//统计反馈记录数量
	public function modelGetFbackCount ($where)
	{

		$ModelTable = M("housefeedback");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取房间反馈信息
	public function modelGetFback ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("housefeedback");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//查找房间反馈信息
	public function modelFindFback ($fields,$where)
	{
		$ModelTable = M("housefeedback");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//修改房间反馈信息
	public function modelUpdateFback ($where,$data)
	{
		$ModelTable = M("housefeedback");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//删除房间反馈信息
	public function modelDeleteFback ($where,$data)
	{
		$ModelTable = M("housefeedback");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//删除成交信息
	public function modelDeleteDeal ($where,$data)
	{
		$ModelTable = M("housedeal");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//删除房源信息
	public function modelDeleteHouseRoom ($where,$data)
	{
		$ModelTable = M("houseroom");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//店铺字段数值自增
	public function modelUpdateStore ($where,$field,$num)
	{
		$ModelTable = M("stores","",self::connection);
		$result = $ModelTable->where($where)->setInc($field,$num);
		return $result;
	}
	//根据store_id,top_type=4,top_resource=1删除信息
	public function modelDeleteHouseSelect ($where)
	{
		$ModelTable = M("houseselect");
		$result = $ModelTable->where($where)->delete();
		return $result;
	}
	//更改houseselect的信息
	public function modelUpdateHouseSelect ($where,$data)
	{
		$ModelTable = M("houseselect");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//统计店铺信用历史数量
	public function modelCountStoreCreditDetail ($where)
	{
		$ModelTable = M("storecreditdetail",'',self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取店铺信用历史信息
	public function modelGetStoreCreditDetail ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("storecreditdetail","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//创建店铺信用分信息
   	public function modelAddStoreCreditDetail ($data)
   	{
		$ModelTable = M("storecreditdetail","",self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
   	}
   	//统计店铺保证金历史数量
	public function modelCountEarnestmoney ($where)
	{
		$ModelTable = M("earnestmoney",'',self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取店铺信用历史信息
	public function modelGetEarnestmoney ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("earnestmoney","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//增加店铺保证金记录
	public function modelAddEarnestMoney ($data)
	{
		$ModelTable = M("earnestmoney","",self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//增加用户推送通知
	public function modelAddCustomerNotify ($data)
	{
		$ModelTable = M("customernotify","",self::connections);
		$result = $ModelTable->data($data)->add();
		return $result;
	}
	//统计成交记录数量
	public function modelCountHouseDeal ($where)
	{
		$ModelTable = M("housedeal");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取成交记录信息
	public function modelGetHouseDeal ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("housedeal");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//查找housedeal反馈成交信息
	public function modelFindHouseDeal ($fields,$where)
	{
		$ModelTable = M("housedeal");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//修改housedeal信息
	public function modelUpdateHouseDeal($where,$data)
	{
		$ModelTable = M("housedeal");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//查找housedeallottery反馈中奖信息
	public function modelFindHouseDealLottery ($fields,$where)
	{
		$ModelTable = M("housedeallottery");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//修改housedeallottery信息
	public function modelUpdateHouseDealLottery($where,$data)
	{
		$ModelTable = M("housedeallottery");
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
	}
	//统计在线签约数量
	public function modelCountContractDetail ($where)
	{
		$ModelTable = M("contractdetail","",self::connection);
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取在线签约信息
	public function modelGetContractDetail ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("contractdetail","",self::connection);
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $result;
	}
	//查找房东佣金信息
	public function modelFindHouseCommissionManage ($fields,$where)
	{
		$ModelTable = M("commissionmanage_fd");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//查找房东佣金细节
	public function modelFindHouseCommissionDetail($fields,$where)
	{
		$ModelTable = M("commissiondetail_fd");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//查找房东包月信息
	public function modelFindCommissionMonthly ($fields,$where)
	{
		$ModelTable = M("commissionmonthly");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//统计housedeal和housedeallottery联查数量
	public function modelCountDealLottery ($where)
	{		
		$ModelTable = M("housedeal");
		$pageCount = $ModelTable->alias('a')->join('gaodu.housedeallottery b ON a.id=b.deal_id')->where($where)->count();
		return $pageCount;
	}
	//获取housedeal和housedeallottery联查信息
	public function modelGetDealLottery ($firstRow,$listRows,$fields,$where)
	{		
		$ModelTable = M("housedeal");
		$data = $ModelTable->alias('a')->join('gaodu.housedeallottery b ON a.id=b.deal_id')->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
		return $data;
	}
	//修改信息
	public function modelUpdateAgentsCompany($data)
	{
		$ModelTable = M("agentcompany");
		$result = $ModelTable->data($data)->save();
		return $result;
	}
}
?>
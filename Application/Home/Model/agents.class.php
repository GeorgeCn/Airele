<?php
namespace Home\Model;
use Think\Model;
class agents
{
	const connection = "DB_DATA";
	//统计中介用户数量
	public function modelCountCustomer ($where)
	{		
		$ModelTable = M("customer",'',self::connection);
		$pageCount = $ModelTable->alias('a')->join('gaodudata.customerinfo b ON a.id=b.customer_id')->where($where)->count();
		return $pageCount;
	}
	//获取中介用户信息
	public function modelGetCustomer ($firstRow,$listRows,$fields,$where)
	{		
		$ModelTable = M("customer",'',self::connection);
		$data = $ModelTable->alias('a')->join('gaodudata.customerinfo b ON a.id=b.customer_id')->field($fields)->where($where)->order('a.create_time desc')->limit($firstRow,$listRows)->select();
		return $data;
	}
	//查找中介用户信息
	public function modelFindCustomer ($fields,$where)
	{		
		$ModelTable = M("customer",'',self::connection);
		$data = $ModelTable->alias('a')->join('gaodudata.customerinfo b ON a.id=b.customer_id')->field($fields)->where($where)->find();
		return $data;
	}
	//统计agentcompany数量
	public function modelCountAgentCompany ($where)
	{		
		$ModelTable = M("agentcompany");
		$pageCount = $ModelTable->where($where)->count();
		return $pageCount;
	}
	//获取agentcompany信息
	public function modelGetAgentCompany ($firstRow,$listRows,$fields,$where)
	{
		$ModelTable = M("agentcompany");
		$result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
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
	//删除houselect信息
	public function modelDeleteHouseSelect ($where)
	{
		$ModelTable = M("houseselect");
		$result = $ModelTable->where($where)->delete();
		return $result;
	}
	//删除房间报价信息
    public function modelDeleteHouseOffer ($where,$data)
    {
      $model = M("houseoffer");
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
	//新增agentcompany信息
    public function modelAddAgentCompany ($data)
    {
		$ModelTable = M("agentcompany");
		$result = $ModelTable->data($data)->add();
		return $result;
    }
   	//修改agentcompany信息
   	public function modelModifyAgentCompany ($data)
	{
		$ModelTable = M("agentcompany");
		$result = $ModelTable->data($data)->save();
		return $result;
	} 
	//查询agentcompany信息
   	public function modelFindAgentCompany ($fields,$where)
	{
		$ModelTable = M("agentcompany");
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	} 
	//查找customer信息
	public function modelFindCustomerInfo ($fields,$where)
	{
		$ModelTable = M("customer",'',self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
	}
	//新增customer信息
    public function modelAddCustomer ($data)
    {
		$ModelTable = M("customer",'',self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
    }
    //查找customerinfo信息
    public function modelFindCustomerInfoTable ($fields,$where)
    {
    	$ModelTable = M("customerinfo",'',self::connection);
		$result = $ModelTable->field($fields)->where($where)->find();
		return $result;
    }
    //新增customerinfo信息
    public function modelAddCustomerInfo ($data)
    {
		$ModelTable = M("customerinfo",'',self::connection);
		$result = $ModelTable->data($data)->add();
		return $result;
    }
    //修改customer信息
    public function modelUpdateCustomer ($where,$data)
    {
		$ModelTable = M("customer",'',self::connection);
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
    }
    //修改customerinfo信息
    public function modelUpdateCustomerInfo ($where,$data)
    {
		$ModelTable = M("customerinfo",'',self::connection);
		$result = $ModelTable->where($where)->data($data)->save();
		return $result;
    }
}
?>
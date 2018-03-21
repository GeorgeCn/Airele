<?php
namespace Logic;
use Think\Controller;
class AgentsManageLogic 
{
	//根据customer_id查找is_owner
	public function findCustomerInfo ($cid)
	{
		if(empty($cid)) return false;
		$modelDal = new \Home\Model\agents();
		$fields = 'a.true_name,a.mobile,a.agent_company_id,a.agent_company_name,a.agent_commission_price,a.house_limit,b.region_id,b.region_name,b.principal_man,b.owner_remark,b.customer_id'; 
		$where['a.id'] = $cid;
		$result = $modelDal->modelFindCustomer($fields,$where);
		return $result;
	}
	//根据customer_id删除用户房源
	public function deleteCustomerHouses ($cid)
	{
		if(empty($cid)) return false;
		$modelDal = new \Home\Model\agents();
		$whereOne['customer_id'] = $cid;
		$infoOne['record_status'] = 0;
		$modelDal->modelUpdateHouseRoom($whereOne,$infoOne);
		$whereTwo['customer_id'] = $cid;
		$infoTwo['record_status'] = 0;
		$modelDal->modelUpdateHouseResource($whereTwo,$infoTwo);
		$whereThree['customer_id'] = $cid;
		$modelDal->modelDeleteHouseSelect($whereThree);
		return true;
	} 
	//删除中介报价
  	public function deleteHouseOffer ($cid) 
  	{
  		if(empty($cid)) return false;
  		$modelDal = new \Home\Model\agents();
  		$where['customer_id'] = $cid;
  		$info['record_status'] = 0;
  		$result = $modelDal->modelDeleteHouseOffer($where,$info);
  		return $result; 
  	}
	//新增中介公司信息
	public function addAgentCompany ($data)
	{
		if(empty($data['company_name'])) return false;
		$data['id'] = guid();
		$data['city_code'] = C('CITY_CODE');
		$data['create_time'] = time();
		$data['pid'] =  "";
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelAddAgentCompany($data);
		return $result;
	}
	//删除中介公司
	public function deleteAgentCompany ($data)
	{
		if(empty($data['id'])) return false;
		$modelDal = new \Home\Model\agents();
		$data['record_status'] = '0';
		$result = $modelDal->modelModifyAgentCompany($data);
		return $result;
	}
	//查询中介公司信息
	public function findAgentCompany ($data)
	{
		if(empty($data['id'])) return null;
		$modelDal = new \Home\Model\agents();
		$fields = 'id,company_name,commission_fee';
		$where['id'] = $data['id'];
		$result = $modelDal->modelFindAgentCompany($fields,$where);
		return $result;
	}
	//根据id查询门店信息
	public function findCompanyStores ($data)
	{
		if(empty($data['id'])) return null;
		$modelDal = new \Home\Model\agents();
		$fields = 'id,company_name,company_store,create_time';
		$where['pid'] = $data['id'];
		$where['city_code'] = C("CITY_CODE");
		$result = $modelDal->modelGetAgentCompany('','',$fields,$where);
		return $result;
	}
	//修改中介公司信息
	public function modifyAgentCompany ($data)
	{
		if(empty($data['company_name'])||empty($data['commission_fee'])) return false;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelModifyAgentCompany($data);
		return $result;
	}
	//根据手机号查找用户
	public function findCustomer ($data)
	{
		if(empty($data['mobile'])) return false;
		$modelDal = new \Home\Model\agents();
		$fields = 'id,is_owner,memo';
		$where['record_status'] = 1;
		$where['mobile'] = $data['mobile'];
		$result = $modelDal->modelFindCustomerInfo($fields,$where);
		return $result;
	}
	//根据customer_id查找customerinfo
	public function findCustomerInfoTable ($cid) 
	{
		if(empty($cid)) return null;
		$modelDal = new \Home\Model\agents();
		$fields = 'id';
		$where['customer_id'] = $cid;
		$result = $modelDal->modelFindCustomerInfoTable($fields,$where);
		if(empty($result['id'])) {
			$info['id'] = guid();
			$info['customer_id'] = $cid;
			$info['create_time'] = time();
			$resultOne = $modelDal->modelAddCustomerInfo($info);
			return $resultOne;
		} else {
			return null;
		}
	}
	//增加中介信息
	public function addAgentsInfo ($data)
	{
		if(empty($data['mobile'])||empty($data['true_name'])) return false;
		$info['id'] = guid();
		$info['true_name'] = $data['true_name'];
		$info['mobile'] = $data['mobile'];
		$info['city_code'] = $data['city_code'];
		$info['create_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$info['is_owner'] = $data['is_owner'];
		$info['memo'] = $data['memo'];
		$info['agent_company_id'] = $data['agent_company_id'];
		$info['agent_company_name'] = $data['agent_company_name'];
		$info['company_store_id'] = $data['company_store_id'];
		$info['company_store_name'] = $data['company_store_name'];
		$info['gaodu_platform'] = 3;
		$info['channel'] = '后台新增';
		$info['is_renter'] = 0;
		$info['house_limit'] = 0;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelAddCustomer($info);
		if($result) {
			$infoOne['id'] = guid();
			$infoOne['customer_id'] = $info['id'];
			$infoOne['source'] = '系统添加';
			$infoOne['margin'] = $data['margin'] == null? 0 : $data['margin'];
			$infoOne['region_id'] = $data['region_id'];
			$infoOne['region_name'] = $data['region_name'];
			$infoOne['principal_man'] = $data['principal_man'];
			$infoOne['owner_remark'] = $data['owner_remark'];
			$infoOne['status'] = 0;
			$infoOne['create_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$resultOne = $modelDal->modelAddCustomerInfo($infoOne);
			return $resultOne;
		} else {
			return false;
		}	
	}
	//根据customer_id更改用户信息
	public function modifyAgentsInfo ($id,$data)
	{
		if(empty($id)) return false;
		$where['id'] = $id;
		$info['true_name'] = $data['true_name'];
		$info['city_code'] = $data['city_code'];
		$info['update_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$info['is_owner'] = $data['is_owner'];
		$info['memo'] = $data['memo'];
		$info['agent_company_id'] = $data['agent_company_id'];
		$info['agent_company_name'] = $data['agent_company_name'];
		$info['company_store_id'] = $data['company_store_id'];
		$info['company_store_name'] = $data['company_store_name'];
		$info['house_limit'] = 0;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelUpdateCustomer($where,$info);
		if($result) {
			$whereOne['customer_id'] = $id;
			$infoOne['source'] = '系统添加';
			$infoOne['margin'] = $data['margin'] == null? 0 : $data['margin'];
			$infoOne['region_id'] = $data['region_id'];
			$infoOne['region_name'] = $data['region_name'];
			$infoOne['principal_man'] = $data['principal_man'];
			$infoOne['owner_remark'] = $data['owner_remark'];
			$infoOne['status'] = 0;
			$infoOne['update_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$resultOne = $modelDal->modelUpdateCustomerInfo($whereOne,$infoOne);
			return $resultOne;
		} else {
			return false;
		}
	}
	//根据customer_id更改用户信息
	public function modifyAgentsInfoTwo ($data)
	{
		if(empty($data['customer_id'])) return false;
		$where['id'] = $data['customer_id'];
		$info['true_name'] = $data['true_name'];
		$info['city_code'] = $data['city_code'];
		$info['update_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$info['agent_company_id'] = $data['agent_company_id'];
		$info['agent_company_name'] = $data['agent_company_name'];
		$info['company_store_id'] = $data['company_store_id'];
		$info['company_store_name'] = $data['company_store_name'];
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelUpdateCustomer($where,$info);
		if($result) {
			$whereOne['customer_id'] = $data['customer_id'];
			$infoOne['status'] = $data['status'];
			$infoOne['margin'] = $data['margin'] == null? 0 : $data['margin'];
			$infoOne['source'] = '系统添加';
			$infoOne['region_id'] = $data['region_id'];
			$infoOne['region_name'] = $data['region_name'];
			if(!empty($data['principal_man'])) {
				$infoOne['principal_man'] = $data['principal_man'];
			}
			$infoOne['owner_remark'] = $data['owner_remark'];
			$infoOne['update_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$resultOne = $modelDal->modelUpdateCustomerInfo($whereOne,$infoOne);
			return $resultOne;
		} else {
			return false;
		}
	}
	//根据customer_id更改用户信息
	public function modifyAgentsInfoThree ($id,$data)
	{
		if(empty($id)) return false;
		$where['id'] = $id;
		$info['owner_verify'] = $data['owner_verify'];
		$info['im_open'] = $data['im_open'];
		$info['house_limit'] = $data['house_limit'];
		$info['update_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelUpdateCustomer($where,$info);
		if($result) {
			$whereOne['customer_id'] = $id;
			$infoOne['principal_man'] = $data['principal_man'];
			$infoOne['update_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$infoOne['owner_remark'] = $data['owner_remark'];
			$resultOne = $modelDal->modelUpdateCustomerInfo($whereOne,$infoOne);
			return $resultOne;
		} else {
			return false;
		}
	}
	//根据customer_id更改个人房东信息
	public function modifyAgentsInfoFour ($id,$data)
	{
		if(empty($id)) return false;
		$where['id'] = $id;
		$info['owner_verify'] = 0 ;
		$info['update_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelUpdateCustomer($where,$info);
		if($result) {
			$whereOne['customer_id'] = $id;
			$infoOne['principal_man'] = '';
			$infoOne['update_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$infoOne['owner_remark'] = $data['owner_remark'];
			$resultOne = $modelDal->modelUpdateCustomerInfo($whereOne,$infoOne);
			return $resultOne;
		} else {
			return false;
		}
	}
	//增加中介信息
	public function addAgentsInfoThree ($data)
	{
		if(empty($data['mobile'])) return false;
		$info['id'] = guid();
		$info['mobile'] = $data['mobile'];
		$info['city_code'] = C('CITY_CODE');
		$info['create_time'] = time();
		$login_name = trim(getLoginName());
		$info['update_man'] = $login_name;
		$info['is_owner'] = 5;
		$info['gaodu_platform'] = 3;
		$info['channel'] = '后台新增';
		$info['is_renter'] = 0;
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelAddCustomer($info);
		if($result) {
			$infoOne['id'] = guid();
			$infoOne['customer_id'] = $info['id'];
			$infoOne['source'] = $data['source'];
			$infoOne['status'] = 0;
			$infoOne['create_time'] = time();
			$login_name = trim(getLoginName());
			$infoOne['update_man'] = $login_name;
			$resultOne = $modelDal->modelAddCustomerInfo($infoOne);
			return $resultOne;
		} else {
			return false;
		}	
	}
	//新增公司门店信息
	public function addCompanyStore ($data)
	{
		if(empty($data['company_name'])) return false;
		$data['id'] = guid();
		$data['city_code'] = C('CITY_CODE');
		$data['create_time'] = time();
		$modelDal = new \Home\Model\agents();
		$result = $modelDal->modelAddAgentCompany($data);
		return $result;
	}
}
?>
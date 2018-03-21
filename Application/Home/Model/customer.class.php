<?php
namespace Home\Model;
use Think\Model;
class customer{
   /*用户信息表*/
   const connection_data = 'DB_DATA';
   //新增
   public function addModel($data){
     $model = M("customer","",self::connection_data);
     $result = $model->add($data);
     return $result;
   }
   //修改
   public function updateModel($data){
     $model = M("customer","",self::connection_data);
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);
   }
    public function updateModelByWhere($where,$data){
       $model = M("customer","",self::connection_data);
       return $model->where($where)->save($data);
    }
   //查询
   public function getModelById($id){
     $model = M("customer","",self::connection_data);
     $condition['id']=$id;
     $result = $model->where($condition)->find();
     return $result;
   }
   //获取房源的房东信息 ById
    public function getResourceClientById($customerId){
     $model = M("customer","",self::connection_data);
     $condition['id']=$customerId;
     $result = $model->field("id,mobile,true_name,sex,age,img_path,telephone,is_owner,agent_company_id,agent_company_name")->where($condition)->find();
     return $result;
   }
   //获取房源的房东信息 ByPhone
    public function getResourceClientByPhone($phone){
     $model = M("customer","",self::connection_data);
     $condition['mobile']=$phone;
     $result = $model->where($condition)->find();
     return $result;
   }
   //统计认证房东数
   public function modelCustomerPageCount($where){
     $model = M("customer","",self::connection_data);
     $result = $model->where($where)->count();
     return $result;
   }
   //获取所有认证房东信息
    public function getCustomerList($firstrow,$listrows,$where){
     $model = M("customer","",self::connection_data);
     $result = $model->where($where)->order('auth_time desc')->limit($firstrow,$listrows)->select();
     return $result;
   }
   public function getCustomerInfoByIds($ids){
      $model = M("customer","",self::connection_data);
      $result = $model->field("id,true_name")->where("id in ($ids)")->select();
      return $result;
   }
   //新增银行卡
    public function modeladdBankNumber($data){
      $model = M("customerbankinfo","",self::connection_data);
      $result = $model->add($data);
      return $result;
   }
    //查询银行卡
   public function modelBankById($id){
     $model = M("customerbankinfo","",self::connection_data);
     $condition['customer_id']=$id;
     $result = $model->where($condition)->select();
     return $result;
   }
    //修改银行卡信息
   public function modelUpBankById($data){
     $model = M("customerbankinfo","",self::connection_data);
     $condition['id']=$data['id'];
     $result = $model->where($condition)->save($data);
     return $result;
   }

   public function modelBankType($customer_id,$type){
     $model = M("customerbankinfo","",self::connection_data);
     $condition['customer_id']=$customer_id;
     $condition['bank_type']=$type;
     $result = $model->where($condition)->find();
     return $result;
   }
   //修改房源良心房东状态
   public function modelUpLandlordAuth($customer){
     $model = M("houseresource");
     $condition['customer_id']=$customer['customer_id'];
     $data['is_auth']=$customer['is_auth'];
     return $model->where($condition)->save($data);
   }

    public function modelAllCustomer($firstrow,$listrows,$where){
     $model = M("customer","",self::connection_data);
     $result = $model->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $result;
   }
    //根据条件获取信息、数量
    public function getListByWhere($where,$order_limit){
       $model = M("","",self::connection_data);
       return $model->query("select id,true_name,mobile,is_owner,is_commission,is_black,monthly_end,city_code,agent_company_id,agent_company_name from customer where ".$where." ".$order_limit);
    }
    public function getFieldListByWhere($field,$where,$orderby,$firstrow,$listrows){
       $model = M("customer","",self::connection_data);
       return $model->field($field)->where($where)->order($orderby)->limit($firstrow,$listrows)->select();
    }
    public function getCountByWhere($where){
       $model = M("","",self::connection_data);
       return $model->query("select count(*) as cnt from customer where ".$where);
    }
    //获取customerinfocheck信息
    public function modelGetCustomerCheck ($firstRow,$listRows,$fields,$where)
    {
        $model = M("customerinfocheck","",self::connection_data);
        $result = $model->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
        return $result;
    }
    //查找customerinfocheck信息
    public function modelFindCustomerCheck ($fields,$where)
    {
        $model = M("customerinfocheck","",self::connection_data);
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
    //获取customerinfocheck的房东数量
    public function modelCountCustomerCheck ($where)
    {
        $model = M("customerinfocheck","",self::connection_data);
        $result = $model->where($where)->count();
        return $result;
    }
    //更改customerinfocheck信息
    public function modelModifyCustomerCheck ($data)
    {
        $model = M("customerinfocheck","",self::connection_data);
        $result = $model->data($data)->save();
        return $result;
    }
    //获取houseroom信息
    public function modelGetHouseRoom ($fields,$where)
    {
        $model = M("houseroom");
        $result = $model->field($fields)->where($where)->select();
        return $result;
    }
    //查找customer信息
    public function modelFindCustomer ($fields,$where)
    {
        $model = M("customer","",self::connection_data);
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
    //查找customerinfo信息
    public function modelFindCustomerInfo ($fields,$where)
    {
        $model = M("customerinfo","",self::connection_data);
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
    //查找agentcompany信息
    public function modelFindAgentCompany($fields,$where)
    {
        $model = M("agentcompany");
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
/*连接数 */
    public function getIMConnectData($columns,$where){
      $model=new Model();
      return $model->query("select $columns from yunxinhouseclick where ".$where);
    }
    public function getSummaryConnectData($columns,$where){
      $model=new Model();
      return $model->query("select $columns from summaryconnect where ".$where);
    }public function modelCountCustomer ($where)
    {   
        $ModelTable = M("customer",'',self::connection_data);
        $pageCount = $ModelTable->alias('a')->join('gaodudata.customerinfo b ON a.id=b.customer_id')->where($where)->count();
        return $pageCount;
    }
    //获取职业房东用户信息
    public function modelGetCustomer ($firstRow,$listRows,$fields,$where)
    {   
        $ModelTable = M("customer",'',self::connection_data);
        $data = $ModelTable->alias('a')->join('gaodudata.customerinfo b ON a.id=b.customer_id')->field($fields)->where($where)->order('a.create_time desc')->limit($firstRow,$listRows)->select();
        return $data;
    }
    //获取用户端口
    public function modelGetCustomerService ($fields,$where)
    {
        $model = M("customerservicedate",'',self::connection_data);
        $result = $model->field($fields)->where($where)->select();
        return $result;
    }
    //查找用户端口
    public function modelFindCustomerService ($fields,$where)
    {
        $model = M("customerservicedate",'',self::connection_data);
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
    //获取用户端口
    public function modelGetServiceDetail ($fields,$where)
    {
        $model = M("customerservicedetail",'',self::connection_data);
        $result = $model->field($fields)->where($where)->order('create_time desc')->limit(0,10)->select();
        return $result;
    }
    //统计端口信息
    public function modelSumServiceDetail ($fields,$where)
    {
      $model = M("customerservicedetail",'',self::connection_data);
      $sum = $model->where($where)->sum($fields);
      return $sum;
    }
    //获取包月信息
    public function modelGetCommissionMonthly ($fields,$where)
    {
        $model = M("commissionmonthly");
        $result = $model->field($fields)->where($where)->order('create_time desc')->select();
        return $result;
    }
    //查找包月信息
    public function modelFindCommissionMonthly ($fields,$where)
    {
        $model = M("commissionmonthly");
        $result = $model->field($fields)->where($where)->order('create_time desc')->find();
        return $result;
    }
    //获取佣金信息
    public function modelGetCommissionDetail ($fields,$where)
    {
        $model = M("commissionmanage_fd");
        $result = $model->field($fields)->where($where)->order('create_time desc')->select();
        return $result;
    }
    //查找佣金信息
    public function modelFindCommissionDetail ($fields,$where)
    {
        $model = M("commissionmanage_fd");
        $result = $model->field($fields)->where($where)->order('create_time desc')->find();
        return $result;
    }
    //获取置顶信息
    public function modelGetHouseSelect ($fields,$where)
    {
        $model = M("houseselect");
        $result = $model->field($fields)->where($where)->order('create_time desc')->limit(0,10)->select();
        return $result;
    }
    //查找用户链接信息
    public function modelFindCustomerLinks ($fields,$where)
    {
        $model = M("customerlinks");
        $result = $model->field($fields)->where($where)->find();
        return $result;
    }
    //统计houseroom数量
    public function modelCountHouseRoom ($where)
    {
      $model = M("houseroom");
      $pageCount = $model->where($where)->count();
      return $pageCount;
    }
    //添加端口主表信息
    public function modelAddServiceData ($data) 
    {
      $model = M("customerservicedate","",self::connection_data);
      $result = $model->data($data)->add();
      return $result;
    }
    //添加端口详情表信息
    public function modelAddServiceDetail ($data) 
    {
      $model = M("customerservicedetail","",self::connection_data);
      $result = $model->data($data)->add();
      return $result;
    }
    //修改端口主表信息
    public function modelUpdateServiceData ($where,$data) 
    {
      $model = M("customerservicedate","",self::connection_data);
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
    //添加包月信息
    public function modelAddCommissionMonthly ($data) 
    {
      $model = M("commissionmonthly");
      $result = $model->data($data)->add();
      return $result;
    }
    //修改包月信息
    public function modelUpdateCommissionMonthly ($where,$data) 
    {
      $model = M("commissionmonthly");
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
    //添加佣金信息
    public function modelAddCommissionDetail ($data) 
    {
      $model = M("commissionmanage_fd");
      $result = $model->data($data)->add();
      return $result;
    }
    //修改佣金信息
    public function modelUpdateCommissionDetail ($where,$data) 
    {
      $model = M("commissionmanage_fd");
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
    //获得付费用户
    public function modelGetPayCustomer ($firstRow,$listRows,$fields,$where)
    {   
        $ModelTable = M("customer",'',self::connection_data);
        $data = $ModelTable->alias('a')->join('gaodudata.customerservicedate b ON a.id=b.customer_id')->field($fields)->where($where)->order('a.create_time desc')->limit($firstRow,$listRows)->select();
        return $data;
    }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class commissionfd{
  /*房东佣金管理 */
  public function addModel($data){
      $ModelTable=M('commissionmanage_fd');
      return $ModelTable->add($data);
   }
   public function addDetail($data){
      $ModelTable=M('commissiondetail_fd');
      return $ModelTable->add($data);
   }
   public function updateModel($data){
      $ModelTable=M('commissionmanage_fd');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   public function updateModelByWhere($data,$where){
      $ModelTable=M('commissionmanage_fd');
      return $ModelTable->where($where)->save($data);
   }
   public function updateDetail($data){
      $ModelTable=M('commissiondetail_fd');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   public function updateDetailByWhere($where,$data){
      $ModelTable=M('commissiondetail_fd');
      return $ModelTable->where($where)->save($data);
   }
   public function getModelById($id){
      $ModelTable=M('commissionmanage_fd');
      return $ModelTable->where(array('id'=>$id))->find();
   }
   public function getModelListByWhere($where){
     $model = new Model();
     $sql="select client_phone,client_name,customer_id,contracttime_start,contracttime_end,is_open,create_man,create_time,update_man,update_time,id,city_code from commissionmanage_fd ";
     return $model->query($sql.$where." order by id asc limit 10");
   }
 
   public function getMaxStarttimeByid($commission_id){
     $model =new Model();
     return $model->query("select id,start_time from commissiondetail_fd where commission_id=$commission_id order by start_time desc limit 1");
   }
   public function getDetailsByCommissionId($commission_id){
     $model =new Model();
     return $model->query("select commission_type,commission_money,commission_base,is_online,settlement_method,start_time,end_time,create_man,create_time from commissiondetail_fd where commission_id=$commission_id order by id asc");
   }
   //获取用户信息
   public function getCustomerByWhere($where){
      $model=M('','','DB_DATA');
      return $model->query("select id,true_name,mobile,is_owner,city_code,memo,is_commission,is_monthly from customer ".$where." limit 1");
   }
   //更新房间佣金
   public function updateCommissionRoom($where,$data){
      $ModelTable=M('commissionmanage');
      return $ModelTable->where($where)->save($data);
   }
   public function updateCommissiondetailRoom($where,$data){
      $ModelTable=M('commissiondetail');
      return $ModelTable->where($where)->save($data);
   }
   //更新房间佣金明细的结束时间
   public function updateMoreEndtimeForRoom($where){
      $model=new Model();
      return $model->execute("update commissionmanage a,commissiondetail b set b.end_time=unix_timestamp() where a.id=b.commission_id and b.end_time=0 ".$where);
   }
   public function getCommissionRoomByWhere($where){
     $model = new Model();
     return $model->query("select id from commissionmanage ".$where." order by id asc");
   }
   //更新房间信息
   public function updateRoomCommission($customer_id,$is_commission){
      $model = new Model();
     return $model->execute("update houseroom set is_commission=$is_commission where customer_id='$customer_id'");
   }
    //查询房东下的启用规则数量
   public function getCommissionByWhere($where){
      $model = new Model();
     return $model->query("select id,contracttime_start,contracttime_end from commissionmanage_fd ".$where);
   }

   /*包月 */
   public function addCommissionmonthly($data){
      $ModelTable=M('commissionmonthly');
      return $ModelTable->add($data);
   }
    public function updateCommissionmonthly($where,$data){
      $ModelTable=M('commissionmonthly');
      return $ModelTable->where($where)->save($data);
   }
   public function getCommissionmonthlyByWhere($where,$order_limit){
     $model = new Model();
     return $model->query("select monthly_days,monthly_money,monthly_start,monthly_end,monthly_bak,is_open,create_man,create_time,update_man,update_time,customer_id,id,is_delay,contract_type from commissionmonthly where ".$where." ".$order_limit);
   }
  //修改commissionmonthly信息
  public function modelUpdateCommissionMon ($where,$data)
  { 
    $ModelTable = M("commissionmonthly");
    $result = $ModelTable->where($where)->data($data)->save();
    return $result;
  }
  //创建commissionmonthlylog历史记录
  public function modelAddCommissionMonLog ($data)
  {
    $ModelTable = M("commissionmonthlylog");
    $result = $ModelTable->data($data)->add();
    return $result;
  }
  //获取commissionmonthlylog信息
  public function modelGetCommissionMonLog ($firstRow,$listRows,$fields,$where)
  {
    $ModelTable = M("commissionmonthlylog");
    $result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
    return $result;
  }
  //修改customer信息
  public function modelUpdateCustomer ($where,$data)
  {
    $result = M()->table("gaodudata.customer")->where($where)->data($data)->save();
    return $result;
  }
  //获取commissionmonthly信息
  public function modelFindCommissionMonthly ($fields,$where)
  {
    $ModelTable = M("commissionmonthly");
    $result = $ModelTable->field($fields)->where($where)->find();
    return $result;
  } 
  //获取customer信息
  public function modelFindCustomer ($fields,$where)
  {
    $result = M()->table("gaodudata.customer")->field($fields)->where($where)->find();
    return $result;
  }
  //获得houseroom的房源信息
  public function modelGetRoomInfo ($firstRow,$listRows,$fields,$where)
  {
    $ModelTable = M("houseroom");
    $result = $ModelTable->field($fields)->where($where)->order('create_time desc')->limit($firstRow,$listRows)->select();
    return $result;
  }
  //查找houseroom的房源信息
  public function modelFindRoomInfo ($fields,$where)
  {
    $ModelTable = M("houseroom");
    $result = $ModelTable->field($fields)->where($where)->find();
    return $result;
  }
  //查找houseresource的房源信息
  public function modelFindResourceInfo ($fields,$where)
  {
    $ModelTable = M("houseresource");
    $result = $ModelTable->field($fields)->where($where)->find();
    return $result;
  }
  //查找houseoffer的报价信息
  public function modelGetHouseOffer ($fields,$where)
  {
    $ModelTable = M("houseoffer");
    $result = $ModelTable->field($fields)->where($where)->select();
    return $result;
  }
}
?> 
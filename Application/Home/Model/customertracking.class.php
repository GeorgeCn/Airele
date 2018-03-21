<?php
namespace Home\Model;
use Think\Model;
class customertracking{
  /*租客追踪统计表 */
  //add log
  public function addLogModel($data){
      $ModelTable=M('customertrackinglog');
      return $ModelTable->add($data);
   }
  public function addTrackingModel($data){
      $ModelTable=M('customertracking');
      return $ModelTable->add($data);
   }
   public function updateModel($data){
      $ModelTable=M('customertracking');
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   public function getModelById($id){
      $ModelTable=M('customertracking');
      return $ModelTable->where(array('id'=>$id))->find();
   }
   public function getModelByCondition($condition){
      $ModelTable=M('customertracking');
      return $ModelTable->where($condition)->find();
   }

   public function getModelListCount($condition){
     $model = new Model();
     $sql="select count(1) as totalCount from customertracking a ";
     return $model->query($sql.$condition);
   }
   public function getModelList($condition,$limit_start,$limit_end){
     $model = new Model();
     $sql="select mobile,register_time,renter_status,renter_sourcetype,renter_source,is_service,update_man,update_time,bakinfo,is_look,is_satisfied,is_recommend,is_getcommission,contact_lasttime,contact_count,appoint_looktime,appoint_lasttime,appoint_count,appoint_handleman,is_monthly,is_commission,report_count,city_code,applyback_time,applyback_status,is_cashback,second_visit,visit_source,id from customertracking a ";
     return $model->query($sql.$condition." order by register_time desc,id desc limit $limit_start,$limit_end");
   }
   //联系记录
   public function getContactsByMobile($mobile){
      $ModelTable=new Model();
      return $ModelTable->query("SELECT room_id as room_no,create_time,city_id,info_resource,is_commission,is_monthly,region_name,scope_name,estate_name,room_money FROM `houserentercall` WHERE `mobile` = '$mobile' AND `big_code`<>'4008108756' and is_marketing=0 ORDER BY create_time DESC LIMIT 10");
   }
   //预约记录
   public function getAppointsByMobile($mobile){
      $ModelTable=new Model();
      return $ModelTable->query("SELECT room_id,room_no,create_time,city_code,status,room_money,region_name,scope_name,estate_name,look_time,info_resource,is_commission,is_monthly FROM `housereservecall` WHERE `customer_mobile` = '$mobile' ORDER BY create_time DESC LIMIT 10");
   }
    //看房日程
   public function getLookHouseinfoByCustomerid($customer_id){
      $ModelTable=new Model();
      return $ModelTable->query("SELECT region_name,scope_name,estate_name,room_money,view_time,is_view,room_id,room_no FROM housereserve WHERE customer_id = '$customer_id' AND record_status=1 ORDER BY create_time DESC LIMIT 10");
   }
   //回访记录
   public function getTrackingsById($tracking_id){
      $ModelTable=new Model();
      return $ModelTable->query("SELECT renter_status,renter_room,renter_time,bakinfo,renter_sourcetype,renter_source,is_service,create_time,create_man,is_look,is_satisfied,is_recommend,is_cashback,visit_source,second_visit FROM `customertrackinglog` WHERE `tracking_id` = $tracking_id ORDER BY create_time DESC LIMIT 10");
   }

   //读取房源信息
   public function getHouseResourceById($resource_id){
     $model = new Model();
     return $model->query("select region_name,scope_name,estate_name,info_resource from houseresource where id='$resource_id'");
   }
   //读取房间信息
   public function getHouseRoomById($room_id){
     $model = new Model();
     return $model->query("select id,resource_id,room_no,status,room_money,commission_money,commission_enddate,info_resource,is_commission,is_monthly from houseroom where id='$room_id'");
   }
   public function getHouseRoomByNo($room_no){
     $model = new Model();
     return $model->query("select id,resource_id,room_no,status,room_money,commission_money,commission_enddate,info_resource,is_commission,is_monthly from houseroom where room_no='$room_no'");
   }
   //读取佣金信息
   public function getCommissionByRoomid($room_id){
     $model = new Model();
     return $model->query("select room_no,estate_name,client_phone,room_money,room_status from commissionmanage where room_id='$room_id' and is_open=1 limit 1");
   }
   public function getCommissionByRoomno($room_no){
     $model = new Model();
     return $model->query("select room_no,estate_name,client_phone,room_money,room_status from commissionmanage where room_no='$room_no' and is_open=1 limit 1");
   }
   //获取customercouponcash信息
   public function modelGetCouponCash ($fields,$where)
   {
      $result = M()->table("gaodudata.customercouponcash")->field($fields)->where($where)->order('create_time desc')->limit(10)->select();
      return $result;
   }
   //查找houseresource信息
   public function modelFindHouseResource ($fields,$where)
   {
      $ModelTable = M("houseresource");
      $result = $ModelTable->field($fields)->where($where)->find();
      return $result;
   }
   //查找houseroom信息
   public function modelGetHouseRoom ($fields,$where)
   {
      $ModelTable = M("houseroom");
      $result = $ModelTable->field($fields)->where($where)->find();
      return $result;
   }
   //修改customercouponcash信息
   public function modelUpdateCouponCash ($where,$data)
   {
      $result = M()->table("gaodudata.customercouponcash")->where($where)->order('create_time desc')->limit(1)->data($data)->save();
      return $result;
   }
   //查找customercouponcash信息
   public function modelFindCouponCash ($fields,$where)
   {
      $result = M()->table("gaodudata.customercouponcash")->field($fields)->where($where)->order('create_time desc')->find();
      return $result;
   }
   //修改customercoupon信息
   public function modelUpdateCustomerCoupon ($where,$data)
   {
      $result = M()->table("gaodudata.customercoupon")->where($where)->data($data)->save();
      return $result;
   }
   //修改couponstatus信息
   public function modelUpdateCouponStatus ($where,$data)
   {
      $result = M()->table("gaodudata.couponstatus")->where($where)->data($data)->save();
      return $result;
   }
   //添加发送邮件信息
    public function modelAddCustomerEmail ($data) 
    {
      $result = M()->table("gaodudata.customeremail")->data($data)->add();
      return $result;
    }
    //查找customer信息
    public function modelFindCustomer ($fields,$where)
    {
      $result = M()->table("gaodudata.customer")->field($fields)->where($where)->find();
      return $result;
    }
    //查找customerinfo信息
    public function modelFindCustomerInfo ($fields,$where)
    {
      $result = M()->table("gaodudata.customerinfo")->field($fields)->where($where)->find();
      return $result;
    }
    //查找customerlinks信息
    public function modelGetCustomerLinks ($firstRow,$listRows,$fields,$where)
    {
      $ModelTable = M("customerlinks");
      $result = $ModelTable->field($fields)->where($where)->limit($firstRow,$listRows)->select();
      return $result;
    }
    //统计customerlinks数量
    public function modelCountCustomerLinks ($where)
    {
      $ModelTable = M("customerlinks");
      $pageCount = $ModelTable->where($where)->count();
      return $pageCount;
    }
    //统计houseroom数量
    public function modelCountHouseRoom ($where)
    {
      $ModelTable = M("houseroom");
      $pageCount = $ModelTable->where($where)->count();
      return $pageCount;
    }
    //统计houseoffer数量
    public function modelCountHouseOffer ($where)
    {
      $ModelTable = M("houseoffer");
      $pageCount = $ModelTable->where($where)->count();
      return $pageCount;
    }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class customerinfo{
   const connection_data = 'DB_DATA';

   public function modelCustomerinfoCount($where){
      $model = new Model("","",self::connection_data);
      $sql="select count(1) as cnt from customer a right join customerinfo b on a.id=b.customer_id where a.record_status=1 and a.is_owner=4 and a.city_code='".C('CITY_CODE')."'".$where;
      return $model->query($sql);
   }
   public function modelCustomerinfoList($firstrow,$listrows,$where){
       $model = new Model("","",self::connection_data);
       $sql="select a.true_name,a.mobile,b.status,b.create_time,b.principal_man,b.source,b.update_man,b.signed,b.margin,b.owner_remark,a.is_black,a.is_commission,a.is_monthly,b.region_name,b.customer_id from customer a right join customerinfo b on a.id=b.customer_id where a.record_status=1 and a.is_owner=4 and a.city_code='".C('CITY_CODE')."'".$where;
       return $model->query($sql." order by b.create_time desc,b.id desc limit $firstrow,$listrows");
   }
   //职业房东列表，特殊查询
    public function getCustomerinfoListByWhere($where){
       $model = new Model("","",self::connection_data);
       $sql="select a.true_name,a.mobile,b.status,b.create_time,b.principal_man,b.source,b.update_man,b.signed,b.margin,b.owner_remark,a.is_black,a.is_commission,a.is_monthly,b.region_name,b.customer_id from customer a right join customerinfo b on a.id=b.customer_id where a.record_status=1 and a.is_owner=4 ".$where;
       return $model->query($sql);
   }
   /*弃用 */
   public function modelCustomerCount($where){
      $model = new Model("","",self::connection_data);
      $sql="select count(1) as cuscount from customer a where is_owner=4 and record_status=1 and city_code='".C('CITY_CODE')."'".$where;
      $result=$model->query($sql);
      return $result[0]['cuscount'];
   }
   public function modelCustomerList($firstrow,$listrows,$where){
         $model = new Model("","",self::connection_data);
        $sql="select id as cuid,true_name,mobile,sex,create_time as cu_time,age,'' as source,'' as update_man,'' as principal_man,'' as signed,'' as margin from customer a where record_status=1 and is_owner=4 and city_code='".C('CITY_CODE')."'".$where;
       return $model->query($sql." order by create_time desc limit $firstrow,$listrows");
   }

   public function modelFind($where){
       $model = M("customerinfo","",self::connection_data);
       return $model->where($where)->find();
   }
   public function modelFindByWhere($where,$limit=1){
       $model = M("","",self::connection_data);
       return $model->query("select id,principal_man,margin from customerinfo ".$where." limit $limit");
   }
   public function modelUpdate($data){
       $model = M("customerinfo","",self::connection_data);
       $where['customer_id']=$data['customer_id'];
       return $model->where($where)->save($data);
   }
   public function modelUpdateWhere($where,$data){
       $model = M("customerinfo","",self::connection_data);
       return $model->where($where)->save($data);
   }
   public function mobileAdd($data){
       $model = M("customerinfo","",self::connection_data);
       return $model->add($data);
   }
   //获取房东下面的房间数量
   public function getRoomcountByCustomerid($where){
      $model = new Model();
      return $model->query("select count(*) as cnt from houseroom ".$where);
   }
   //职业房东确认表
   public function getConfirmCount($where){
      $model = M("","",self::connection_data);
      $sql="select count(*) as cnt from customerinfoconfirm where  record_status=1 and city_code='".C('CITY_CODE')."'".$where;
      return $model->query($sql);
   }
   public function getConfirmList($firstrow,$listrows,$where){
      $model = M("","",self::connection_data);
      $sql="select id,mobile,source,create_time,create_man,status,update_man,update_time,remark from customerinfoconfirm where  record_status=1 and city_code='".C('CITY_CODE')."'".$where;
      return $model->query($sql." order by create_time desc,id desc limit $firstrow,$listrows");
   }
   public function getConfirmModel($where){
       $model = M("customerinfoconfirm","",self::connection_data);
       return $model->where($where)->find();
   }
   public function updateConfirm($where,$data){
       $model = M("customerinfoconfirm","",self::connection_data);
       return $model->where($where)->save($data);
   }
   public function addConfirmModel($data){
       $model = M("customerinfoconfirm","",self::connection_data);
       return $model->add($data);
   }
   //获取跟踪状态
    public function modelConfirmSelect($where){
       $model = M("customerinfoconfirmstatus","",self::connection_data);
       return $model->where($where)->limit(10)->order('create_time desc')->select();
   }
   //新增跟踪状态
    public function modelConfirmAdd($data){
       $model = M("customerinfoconfirmstatus","",self::connection_data);
       return $model->add($data);
   }
   //房东免审核认证
   public function modelAttestationCount($where){
       $model = M("customer","",self::connection_data);
       $result=$model->join('LEFT JOIN customerinfo ON customer.id=customerinfo.customer_id')->where($where)->count();
       return $result;
   }
   public function modelAttestationList($firstrow,$listrows,$where){
       $model = M("customer","",self::connection_data);
       $result=$model->field('customer.id,customer.mobile,customer.true_name,customer.owner_verify,customer.city_code,customerinfo.apply_time,customerinfo.owner_update_man')->join('LEFT JOIN customerinfo ON customer.id=customerinfo.customer_id')->where($where)->order('customerinfo.apply_time desc')->limit($firstrow,$listrows)->select();
       return $result;
   }
   //物理删除customerinfo数据
   public function modelDelete($where){
       $model = M("customerinfo","",self::connection_data);
       $result=$model->where($where)->delete(); 
       return $result;
   }
    //物理删除customerinfocheck数据
   public function modelDeleteCustomerCheck($where){
       $model = M("customerinfocheck","",self::connection_data);
       $result=$model->where($where)->delete(); 
       return $result;
   }
  //房源操作人 列表
  public function modelPrincipalFind($username){
    $model = new \Think\Model();
    $city_no=C('CITY_NO');
    return $model->query("select user_name,real_name from admin_user where  user_name = '$username' ");
  }

  /*跟进记录表 */
    public function getCustomerinfologByWhere($where,$order_limit){
       $model = M("","",self::connection_data);
       return $model->query("select id,customer_id,status,create_man,create_time,remark from customerinfolog where ".$where." ".$order_limit);
    }
    public function addCustomerinfolog($data){
        $model = M("customerinfolog","",self::connection_data);
        return $model->add($data);
    }

}
?>
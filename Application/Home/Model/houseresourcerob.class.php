<?php
namespace Home\Model;
use Think\Model;
class houseresourcerob{
   /*房源信息表*/
   const conneccity = 'DB_ROB';
   const connectdata = 'DB_DATA';
   //新增
   public function addModel($data){
     $model = M("houseresource","",self::conneccity);
     return $model->add($data);
   }
   //修改
   public function updateModel($data){
     $model = M("houseresource","",self::conneccity);
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);
   }
   //逻辑删除
   public function deleteModelById($id){
     $model = M("","",self::conneccity);
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseresource set record_status=0,update_time=$update_time,update_man='$update_man' where id='$id' ");
   }
   public function deleteModelByClientphone($mobile){
     $model = M("","",self::conneccity);
     $update_time=time();
     $update_man=getLoginName();
     //$model->execute("DELETE FROM gaodu_house_clean.`house_data_rob` WHERE fangdong_phone='$mobile' ");
     return $model->execute("update houseresource set record_status=0,update_time=$update_time,update_man='$update_man' where client_phone='$mobile' and record_status=1 ");
   } 
   //新增中介过滤库
   public function addBlacklistrob($data){
     $model = M("blacklistrob","",self::connectdata);
     return $model->add($data);
   }
   //更新房源房间总数
   public function updateRoomCountById($id,$update_count){
     $model = M("","",self::conneccity);
     return $model->execute("update houseresource set room_count=room_count+$update_count where id='$id' ");
   }
   //查询
   public function getModelById($id){
     $model = M("houseresource","",self::conneccity);
     $condition['id']=$id;
     return $model->where($condition)->find();
   }
   //列表总条数
   public function getModelListCount($condition){
     $model = M("","",self::conneccity);
     $city_code=C('CITY_CODE');
     $sql="select count(1) as totalCount from houseresource h,houseroom r where h.id=r.resource_id and h.record_status=1 and h.city_code='$city_code' ";
     return $model->query($sql.$condition);
   }
   //列表
   public function getModelList($condition,$limit_start,$limit_end){
     $model = M("","",self::conneccity);
     $city_code=C('CITY_CODE');
     $sql="select h.id,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no,h.room_num,h.hall_num,h.wei_num,business_type ,room_type,r.ext_score,
      room_count,h.customer_id, client_name,client_phone,h.update_time,h.create_time,h.update_man,h.create_man,h.info_resource,h.info_resource_url,r.room_money,h.estate_id from houseresource h,houseroom r where h.id=r.resource_id and h.record_status=1 and h.city_code='$city_code' ";
     return $model->query($sql.$condition." order by r.ext_score desc,r.id desc limit $limit_start,$limit_end");
   }
   /*查找房东下面已有房源数量 */
   public function getHouseCountByPhone($mobile){
     $model = new Model();
     return $model->query("select count(*) as cnt,max(customer_id) as cid from houseresource where client_phone='$mobile' and record_status=1");
   }
    /*查找职业房东 */
   public function getCustomerInfoByCustomerid($customer_id){
     $model = M("","",self::connectdata);
     return $model->query("select source,signed,margin from customerinfo where customer_id='$customer_id'");
   }
   //导出
   public function getExcelList($condition){
     $model = M("","",self::conneccity);
     $sql="select h.house_no,h.estate_name,h.region_name,h.scope_name,business_type,h.unit_no,h.room_no,h.room_num,h.hall_num,h.wei_num,
  room_count,client_name,h.update_time,h.update_man,h.create_man,h.info_resource from houseresource h where h.record_status=1 ";
     return $model->query($sql.$condition." order by h.id desc ");
   }
    
   //检索小区名称
 	public function getEstateNameByKeyword($key){ 
		//过滤敏感字符
    $housresour=str_replace("'", "", $key);
    $housresour=str_replace("%", "", $housresour);
		if (preg_match ("/^[A-Za-z]/", $housresour)) {
            $houskey=strtolower($housresour);
            $where="first_py like '".$houskey."%' or full_py like '".$houskey."%' limit 10";
         }else{
            $where="estate_name like '%".$housresour."%' limit 10";
         }
		$model = M("","",self::conneccity);
		return $model->query("select id,estate_name,region,scope from estate where ".$where);
	}
  //检索小区名称 V2
  public function getEstateNameByKeywordV2($key,$type){ 
    //过滤敏感字符
    $housresour=str_replace("'", "", $key);
    $housresour=str_replace("%", "", $housresour);
    if (preg_match ("/^[A-Za-z]/", $housresour)){
        $houskey=strtolower($housresour);
        $where="(first_py like '".$houskey."%' or full_py like '".$houskey."%') limit 10";
     }else{
        $where="estate_name like '%".$housresour."%' limit 10";
     }
    $model = M("","",self::conneccity);
    return $model->query("select id,estate_name,region,scope,estate_address from estate where business_type='$type' and ".$where);
  }
  //检查(小区名称是否存在),返回信息结果
  public function getEstateModelByName($estate_name){ 
    $estate_name=str_replace("'", "", $estate_name);
    $model = M("","",self::conneccity);
    return $model->query("select id,estate_name,region,scope from estate where estate_name='$estate_name' limit 1 ");
  }
  public function getEstateModelByNameV2($estate_name,$type){ 
    $estate_name=str_replace("'", "", $estate_name);
    $model = M("","",self::conneccity);
    return $model->query("select id,estate_name,region,scope from estate where estate_name='$estate_name' and business_type='$type' limit 1 ");
  }
 //检查(房源信息是否存在),返回数量结果
  public function getHouseCountByHouseinfo($estate_name,$unit_no,$room_no){ 
    $model = M("houseresource","",self::conneccity);
    $condition['estate_name']=$estate_name;
    $condition['unit_no']=$unit_no;
    $condition['room_no']=$room_no;
    $condition['record_status']=1;
    return $model->where($condition)->count();
  }

	//获得房源配置参数
	public function getResourceParameters(){
		$model = M("");
		return $model->query("select type_no,info_type,name,index_no from houseinfotype where record_status=1 and city_code='".C('CITY_CODE')."' order by info_type,index_no");
	}
	public function getCountByHouseno($house_no){
	     $model = M("houseresource","",self::conneccity);
	     $condition['house_no']=$house_no;
	     return $model->where($condition)->count();
  }
  //查询区域、板块名称
  public function getRegionScopeName($region_id,$scope_id){
    $model = M("","",self::conneccity);
    return $model->query("select id,cname from region where id in ($region_id,$scope_id)");
  }
  //所有区域板块 
  public function getRegionScopeList(){
    $model = M("","",self::conneccity);
    return $model->query("select id,cname,parent_id from region ");
  }
  public function getRegionList(){
    $model = M("","",self::conneccity);
    return $model->query("select id,cname,parent_id from region where parent_id=0");
  }
  //根据ID获得房源地址信息
   public function getAddressInfoById($id){
     $model = M("houseresource","",self::conneccity);
     $condition['id']=$id;
     return $model->field("region_name,scope_name,estate_name,unit_no,room_no")->where($condition)->find();
   }
   //房源操作人 列表
   public function getHouseHandleList(){
    $model = new \Think\Model();
    return $model->query("select user_name,real_name from admin_user where department='住宿合作' order by real_name");
  }
  //更新房源负责人
  public function updateResourceCreateman($id,$create_man){
     $model = M("","",self::conneccity);
     return $model->execute("update houseresource set create_man='$create_man' where id='$id' ");
  }
  /*更新房源里的房东信息 by customer_id */
  public function updateHouseClientByCustomerid($data){
     $model = M("houseresource","",self::conneccity);
     return $model->where(array('customer_id' => $data['customer_id']))->save($data);
  }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class houseresource{
   /*房源信息表*/
   const connection_data = 'DB_DATA';
   //新增
   public function addModel($data){
     $model = M("houseresource");
     $data['pk_id']=microtime_pk_id();
     if(!isset($data['city_code']) || $data['city_code']==''){
        $data['city_code']=C('CITY_CODE');
     }
     
     return $model->add($data);
   }
   //修改
   public function updateModel($data){
     $model = M("houseresource");
     $condition['id']=$data['id'];
     return $model->where($condition)->save($data);
   }
   //逻辑删除
   public function deleteModelById($id){
     $model = new Model();
     $update_time=time();
     $update_man=getLoginName();
     return $model->execute("update houseresource set record_status=0,update_time=$update_time,update_man='$update_man' where id='$id' ");
   }
   //更新房源房间总数
   public function updateRoomCountById($id,$update_count){
     $model = new Model();
     return $model->execute("update houseresource set room_count=room_count+$update_count where id='$id' ");
   }
   //查询
   public function getModelById($id){
     $model = M("houseresource");
     $condition['id']=$id;
     return $model->where($condition)->find();
 
   }
   //列表
   public function getModelList($condition,$limit_start,$limit_end){
     $model = new Model();
     $condition.=" and city_code='".C('CITY_CODE')."'";
     $sql="select h.id,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no,h.room_num,h.hall_num,h.wei_num,business_type ,
  room_count,h.customer_id, client_name,client_phone,h.update_time,h.update_man,h.create_man,h.info_resource,h.info_resource_url from houseresource h where h.record_status=1 ";
     return $model->query($sql.$condition." order by h.update_time desc,h.id desc limit $limit_start,$limit_end");
   }
   //导出
   public function getExcelList($condition){
     $model = new Model();
     $condition.=" and city_code='".C('CITY_CODE')."'";
     $sql="select h.house_no,h.estate_name,h.region_name,h.scope_name,business_type,h.unit_no,h.room_no,h.room_num,h.hall_num,h.wei_num,
  room_count,client_name,h.update_time,h.update_man,h.create_man,h.info_resource from houseresource h where h.record_status=1 ";
     return $model->query($sql.$condition." order by h.update_time desc,h.id desc limit 10000 ");
  
   }
    //列表总？条数
   public function getModelListCount($condition){
     $model = new Model();
     $condition.=" and city_code='".C('CITY_CODE')."'";
     $sql="select count(1) as totalCount from houseresource h where h.record_status=1 ";
     return $model->query($sql.$condition);
   }
   //检索小区名称
 	public function getEstateNameByKeyword($key){ 
		//过滤敏感字符
    $where=" city_code='".C('CITY_CODE')."'";
    $housresour=str_replace("'", "", $key);
    $housresour=str_replace("%", "", $housresour);
		if (preg_match ("/^[A-Za-z]/", $housresour)) {
        $houskey=strtolower($housresour);
        $where.=" and (first_py like '".$houskey."%' or full_py like '".$houskey."%') limit 10";
     }else{
        $where.=" and estate_name like '%".$housresour."%' limit 10";
     }
		$model = new Model();
		return $model->query("select id,estate_name,region,scope from estate where ".$where);
	}
  //检索小区名称 V2
  public function getEstateNameByKeywordV2($key,$type=''){ 
    if(!empty($type)){
      $where=" city_code='".C('CITY_CODE')."' and business_type='$type'";
    }else{
      $where=" city_code='".C('CITY_CODE')."' ";
    }
    //过滤敏感字符
    $housresour=str_replace("'", "", $key);
    $housresour=str_replace("%", "", $housresour);
    if (preg_match ("/^[A-Za-z]/", $housresour)){
        $houskey=strtolower($housresour);
        $where.=" and (first_py like '".$houskey."%' or full_py like '".$houskey."%') limit 10";
     }else{
        $where.=" and estate_name like '%".$housresour."%' limit 10";
     }
    $model = new Model();
    return $model->query("select id,estate_name,region,scope,estate_address,region_name,scope_name,business_type,'' as business_typename from estate where ".$where);
  }
  //检查(小区名称是否存在),返回信息结果
  public function getEstateModelByName($estate_name){ 
    $estate_name=str_replace("'", "", $estate_name);
    $model = new Model();
    return $model->query("select id,estate_name,region,scope from estate where estate_name='$estate_name' and city_code='".C('CITY_CODE')."' limit 1 ");
  }
  public function getEstateModelByNameV2($estate_name,$type){ 
    $estate_name=str_replace("'", "", $estate_name);
    $model = new Model();
    return $model->query("select id,estate_name,region,scope,lpt_x,lpt_y,estate_address,business_type from estate where estate_name='$estate_name' and city_code='".C('CITY_CODE')."' ");
  }
 //检查(房源信息是否存在),返回数量结果
  public function getHouseCountByHouseinfo($estate_name,$unit_no,$room_no){ 
    $model = M("houseresource");
    $condition['estate_name']=$estate_name;
    $condition['unit_no']=$unit_no;
    $condition['room_no']=$room_no;
    $condition['record_status']=1;
    $condition['city_code']=C('CITY_CODE');
    return $model->where($condition)->count();
  }

	//获得房源配置参数
	public function getResourceParameters(){
		$model =new Model();
		return $model->query("select type_no,info_type,name,index_no from houseinfotype where record_status=1 and city_code='".C('CITY_CODE')."' order by info_type,index_no");
	}
	public function getCountByHouseno($house_no){
	     $model = M("houseresource");
	     $condition['house_no']=$house_no;
	     return $model->where($condition)->count();
  }
  //查询区域、板块名称
  public function getRegionScopeName($region_id,$scope_id){
    $model = new Model();
    return $model->query("select id,cname from region where city_code='".C('CITY_CODE')."' and id in ($region_id,$scope_id)");
  }
  //所有区域板块 
  public function getRegionScopeList(){
    $model = new Model();
    return $model->query("select id,cname,parent_id from region where is_display=1 and city_code='".C('CITY_CODE')."'");
  }
  public function getRegionList(){
    $model = new Model();
    return $model->query("select id,cname,parent_id from region where is_display=1 and parent_id=0 and city_code='".C('CITY_CODE')."'");
  }
  //根据ID获得房源地址信息
   public function getAddressInfoById($id){
     $model = M("houseresource");
     $condition['id']=$id;
     return $model->field("region_name,scope_name,estate_name,unit_no,room_no,room_count")->where($condition)->find();
   }
   //房源操作人 列表
  public function getHouseHandleList(){
    $model = new \Think\Model();
    $city_no=C('CITY_NO');
    return $model->query("select user_name,real_name from admin_user where  city_auth like '%$city_no%' order by user_name");
  }
  public function getHouseHandleListBykey($key){
    $model = new \Think\Model();
    $city_no=C('CITY_NO');
    return $model->query("select user_name,real_name from admin_user where  city_auth like '%$city_no%' and (user_name like '$key%' or real_name like '$key%') order by user_name");
  }
  //更新房源负责人
  public function updateResourceCreateman($id,$create_man){
     $model = new Model();
     return $model->execute("update houseresource set create_man='$create_man' where id='$id' ");
  }
  /*更新房源里的房东信息 by customer_id */
  public function updateHouseClientByCustomerid($data){
     $model = M("houseresource");
     return $model->where(array('customer_id' => $data['customer_id']))->save($data);
  }
  /*更新houseselect里的房东信息 by customer_id */
  public function updateHouseSelectByCustomerid($data){
     $model = M("houseselect");
     return $model->where(array('customer_id' => $data['customer_id']))->save($data);
  }

  /*待审核房源列表 */
  public function getExamineCount($where){
       $model = new Model();
       $sql="select count(1) as cnt from houseresource h,houseroom r where h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=0 and r.incomplete=0 and h.city_code='".C('CITY_CODE')."' ".$where;
       return $model->query($sql);
  }
  public function getExamineList($where,$limit_start,$limit_end){
       $model = new Model();
       $sql="select h.id,h.house_no,h.estate_name,h.region_name,h.scope_name,h.unit_no,h.room_no,h.room_num,h.hall_num,h.wei_num,business_type,h.room_count,h.customer_id,r.id as room_id,h.client_name,h.update_time,h.update_man,h.create_man,h.info_resource,h.info_resource_url 
       from houseresource h,houseroom r where h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=0 and r.incomplete=0 and h.city_code='".C('CITY_CODE')."' ".$where." order by h.info_resource_type desc,h.update_time desc limit $limit_start,$limit_end";
       return $model->query($sql);
  }
  //更新房源下的良心房东字段、& 搜索表
  public function updateAuthByCustomerid($customer_id,$is_auth){
    return true;
      //$model = new Model();
      //$sql="update houseresource r,houseselect s set r.is_auth=$is_auth,s.is_auth=$is_auth where r.id=s.resource_id and r.customer_id='$customer_id'";
      //return $model->execute($sql); 
  }
  /*房东手机号下面的房源数量*/
  public function getHouseCountByClientPhone($client_phone){
    $model = M("houseresource");
    return $model->where(array('client_phone'=>$client_phone,'record_status'=>1))->count();
  }

  //根据条件获取信息
   public function getListByWhere($where,$order_limit){
      $model = new Model();
      return $model->query("select customer_id,region_id,region_name,scope_name,estate_name,house_no from houseresource where ".$where." ".$order_limit);
   }

}
?> 
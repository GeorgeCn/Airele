<?php
namespace Home\Model;
use Think\Model;
class houseselect{
   //新增
   public function addModel($data){
     	$ModelTable = M("houseselect");
      $data['city_code']=C('CITY_CODE');
     	return $ModelTable->add($data);
   }
   /*新增房间到数据*/
   public function addModelByRoomid($room_id,$is_baozhang=0,$is_dingjin=1){
     	$ModelTable = new Model();
     	//无地铁
     	$sql="insert into houseselect (id,resource_id,room_id,room_area,room_money,estate_id,estate_name,estate_address,estate_full_py,estate_first_py,estate_lpt_x,estate_lpt_y,region_id,region_name,scope_id,scope_name,subwayline_id,subwayline_name,subway_id,subway_name,
is_cut,is_alone_wc,is_alone_kitchen,is_limit_girl,is_owner,is_top,create_time,update_time,is_auth,brand_type,rent_type,city_code,
pay_method,room_num,is_alone_yangtai,is_alone_kongtiao,is_alone_chuang,is_pub_kitchen,is_pub_wc,is_pub_kuandai,is_pub_xiyiji,is_pub_bingxiang,is_pub_reshuiqi,is_gongyu,is_dingjin,is_baozhang,is_commission,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id)
select  uuid(),r.resource_id,r.id,r.room_area,r.room_money,h.estate_id,h.estate_name,e.estate_address,e.full_py,e.first_py,e.lpt_x,e.lpt_y,h.region_id,h.region_name,h.scope_id,h.scope_name,0,'',0,'',
case when h.room_type='0203' then 1 else 0 end,case when instr(r.room_equipment,'1112')>0 then 1 else 0 end,case when instr(r.room_equipment,'1113') then 1 else 0 end,r.girl_tag,h.is_owner,r.sort_index,r.create_time,r.update_time,h.is_auth,h.brand_type,
case when h.room_type in ('0201','0202','0203') then 1 else 2 end ,h.city_code ,
h.pay_method,h.room_num,case when instr(r.room_equipment,'1111')>0 then 1 else 0 end,case when instr(r.room_equipment,'1102')>0 then 1 else 0 end,case when instr(r.room_equipment,'1104')>0 then 1 else 0 end,
case when instr(h.public_equipment,'0309')>0 then 1 else 0 end,case when instr(h.public_equipment,'0310')>0 then 1 else 0 end,case when instr(h.public_equipment,'0303')>0 then 1 else 0 end,case when instr(h.public_equipment,'0302')>0 then 1 else 0 end,case when instr(h.public_equipment,'0301')>0 then 1 else 0 end,case when instr(h.public_equipment,'0306')>0 then 1 else 0 end, 
case when h.business_type='1502' then 1 else 0 end,$is_dingjin,$is_baozhang,r.is_commission,e.geo_val,h.rental_type,r.store_id,r.is_regroup,r.is_agent_fee,r.low_price,r.customer_id  
from estate e,houseresource h,houseroom r where e.id=h.estate_id and h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=2 and r.id='$room_id'";
     	$result = $ModelTable->execute($sql);
     	if($result){
     		//有地铁
     		$sql="insert into houseselect (id,resource_id,room_id,room_area,room_money,estate_id,estate_name,estate_address,estate_full_py,estate_first_py,estate_lpt_x,estate_lpt_y,region_id,region_name,scope_id,scope_name,subwayline_id,subwayline_name,subway_id,subway_name,
is_cut,is_alone_wc,is_alone_kitchen,is_limit_girl,is_owner,is_top,create_time,update_time,is_auth,brand_type,subway_distance,rent_type,city_code,
pay_method,room_num,is_alone_yangtai,is_alone_kongtiao,is_alone_chuang,is_pub_kitchen,is_pub_wc,is_pub_kuandai,is_pub_xiyiji,is_pub_bingxiang,is_pub_reshuiqi,is_gongyu,is_dingjin,is_baozhang,is_commission,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id)
select uuid(),r.resource_id,r.id,r.room_area,r.room_money,h.estate_id,h.estate_name,e.estate_address,e.full_py,e.first_py,e.lpt_x,e.lpt_y,h.region_id,h.region_name,h.scope_id,h.scope_name,s.subwayline_id,s.subwayline_name,s.subway_id,s.subway_name,
case when h.room_type='0203' then 1 else 0 end,case when instr(r.room_equipment,'1112')>0 then 1 else 0 end,case when instr(r.room_equipment,'1113') then 1 else 0 end,r.girl_tag,h.is_owner,r.sort_index,r.create_time,r.update_time ,h.is_auth,h.brand_type,s.subway_distance,
case when h.room_type in ('0201','0202','0203') then 1 else 2 end,h.city_code ,
h.pay_method,h.room_num,case when instr(r.room_equipment,'1111')>0 then 1 else 0 end,case when instr(r.room_equipment,'1102')>0 then 1 else 0 end,case when instr(r.room_equipment,'1104')>0 then 1 else 0 end,
case when instr(h.public_equipment,'0309')>0 then 1 else 0 end,case when instr(h.public_equipment,'0310')>0 then 1 else 0 end,case when instr(h.public_equipment,'0303')>0 then 1 else 0 end,case when instr(h.public_equipment,'0302')>0 then 1 else 0 end,case when instr(h.public_equipment,'0301')>0 then 1 else 0 end,case when instr(h.public_equipment,'0306')>0 then 1 else 0 end, 
case when h.business_type='1502' then 1 else 0 end,$is_dingjin,$is_baozhang,r.is_commission,e.geo_val,h.rental_type,r.store_id,r.is_regroup,r.is_agent_fee,r.low_price,r.customer_id    
from subwayestate s,estate e,houseresource h,houseroom r where s.estate_id=e.id and e.id=h.estate_id and h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=2 and r.id='$room_id'";
     		$result = $ModelTable->execute($sql);
     	}
     	return $result;
   }
   /*新增房源下的房间*/
   public function addModelByResourceid($resource_id,$is_baozhang=0,$is_dingjin=1){
     	$ModelTable = new Model();
     	//无地铁
     	$sql="insert into houseselect (id,resource_id,room_id,room_area,room_money,estate_id,estate_name,estate_address,estate_full_py,estate_first_py,estate_lpt_x,estate_lpt_y,region_id,region_name,scope_id,scope_name,subwayline_id,subwayline_name,subway_id,subway_name,
is_cut,is_alone_wc,is_alone_kitchen,is_limit_girl,is_owner,is_top,create_time,update_time,is_auth,brand_type,rent_type,city_code,
pay_method,room_num,is_alone_yangtai,is_alone_kongtiao,is_alone_chuang,is_pub_kitchen,is_pub_wc,is_pub_kuandai,is_pub_xiyiji,is_pub_bingxiang,is_pub_reshuiqi,is_gongyu,is_dingjin,is_baozhang,is_commission,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id)
select uuid(),r.resource_id,r.id,r.room_area,r.room_money,h.estate_id,h.estate_name,e.estate_address,e.full_py,e.first_py,e.lpt_x,e.lpt_y,h.region_id,h.region_name,h.scope_id,h.scope_name,0,'',0,'',
case when h.room_type='0203' then 1 else 0 end,case when instr(r.room_equipment,'1112')>0 then 1 else 0 end,case when instr(r.room_equipment,'1113') then 1 else 0 end,r.girl_tag,h.is_owner,r.sort_index,r.create_time,r.update_time ,h.is_auth,h.brand_type,
case when h.room_type in ('0201','0202','0203') then 1 else 2 end,h.city_code,
h.pay_method,h.room_num,case when instr(r.room_equipment,'1111')>0 then 1 else 0 end,case when instr(r.room_equipment,'1102')>0 then 1 else 0 end,case when instr(r.room_equipment,'1104')>0 then 1 else 0 end,
case when instr(h.public_equipment,'0309')>0 then 1 else 0 end,case when instr(h.public_equipment,'0310')>0 then 1 else 0 end,case when instr(h.public_equipment,'0303')>0 then 1 else 0 end,case when instr(h.public_equipment,'0302')>0 then 1 else 0 end,case when instr(h.public_equipment,'0301')>0 then 1 else 0 end,case when instr(h.public_equipment,'0306')>0 then 1 else 0 end, 
case when h.business_type='1502' then 1 else 0 end,$is_dingjin,$is_baozhang,r.is_commission,e.geo_val,h.rental_type,r.store_id,r.is_regroup,r.is_agent_fee,r.low_price,r.customer_id  
from estate e,houseresource h,houseroom r where e.id=h.estate_id and h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=2 and h.id='$resource_id'";
     	$result = $ModelTable->execute($sql);
     	if($result){
     		//有地铁
     		$sql="insert into houseselect (id,resource_id,room_id,room_area,room_money,estate_id,estate_name,estate_address,estate_full_py,estate_first_py,estate_lpt_x,estate_lpt_y,region_id,region_name,scope_id,scope_name,subwayline_id,subwayline_name,subway_id,subway_name,
is_cut,is_alone_wc,is_alone_kitchen,is_limit_girl,is_owner,is_top,create_time,update_time,is_auth,brand_type,subway_distance,rent_type,city_code,
pay_method,room_num,is_alone_yangtai,is_alone_kongtiao,is_alone_chuang,is_pub_kitchen,is_pub_wc,is_pub_kuandai,is_pub_xiyiji,is_pub_bingxiang,is_pub_reshuiqi,is_gongyu,is_dingjin,is_baozhang,is_commission,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id)
select uuid(),r.resource_id,r.id,r.room_area,r.room_money,h.estate_id,h.estate_name,e.estate_address,e.full_py,e.first_py,e.lpt_x,e.lpt_y,h.region_id,h.region_name,h.scope_id,h.scope_name,s.subwayline_id,s.subwayline_name,s.subway_id,s.subway_name,
case when h.room_type='0203' then 1 else 0 end,case when instr(r.room_equipment,'1112')>0 then 1 else 0 end,case when instr(r.room_equipment,'1113') then 1 else 0 end,r.girl_tag,h.is_owner,r.sort_index,r.create_time,r.update_time ,h.is_auth,h.brand_type,s.subway_distance,
case when h.room_type in ('0201','0202','0203') then 1 else 2 end ,h.city_code,
h.pay_method,h.room_num,case when instr(r.room_equipment,'1111')>0 then 1 else 0 end,case when instr(r.room_equipment,'1102')>0 then 1 else 0 end,case when instr(r.room_equipment,'1104')>0 then 1 else 0 end,
case when instr(h.public_equipment,'0309')>0 then 1 else 0 end,case when instr(h.public_equipment,'0310')>0 then 1 else 0 end,case when instr(h.public_equipment,'0303')>0 then 1 else 0 end,case when instr(h.public_equipment,'0302')>0 then 1 else 0 end,case when instr(h.public_equipment,'0301')>0 then 1 else 0 end,case when instr(h.public_equipment,'0306')>0 then 1 else 0 end, 
case when h.business_type='1502' then 1 else 0 end,$is_dingjin,$is_baozhang,r.is_commission,e.geo_val,h.rental_type,r.store_id,r.is_regroup,r.is_agent_fee,r.low_price,r.customer_id    
from subwayestate s,estate e,houseresource h,houseroom r where s.estate_id=e.id and e.id=h.estate_id and h.id=r.resource_id and h.record_status=1 and r.record_status=1 and r.status=2 and h.id='$resource_id'";
     		$result = $ModelTable->execute($sql);
     	}
     	return $result;
   }
   //删除
   public function deleteModelByRoomid($room_id){
   	 	$ModelTable = new Model();
    	return $ModelTable->execute("delete from houseselect where room_id='$room_id'");
   }
   public function deleteModelByResourceid($resource_id){
   	 	$ModelTable = new Model();
    	return $ModelTable->execute("delete from houseselect where resource_id='$resource_id'");
   }
   //更新
   public function updateModelByRoomid($data){
     	$ModelTable = M("houseselect");
     	$condition['room_id']=$data['room_id'];
     	return $ModelTable->where($condition)->save($data);
   }
   public function updateModelByResourceid($data){
     	$ModelTable = M("houseselect");
     	$condition['resource_id']=$data['resource_id'];
     	return $ModelTable->where($condition)->save($data);
   }
   //根据条件更新
  public function updateModelByWhere($data,$where){
    $model = M("houseselect");
    return $model->where($where)->save($data);
  }
   //更新 by 小区
   public function updateModelByEstateid($data){
      $ModelTable = M("houseselect");
      $condition['estate_id']=$data['estate_id'];

      $saveData['estate_name']=$data['estate_name'];
      $saveData['estate_address']=$data['estate_address'];
      $saveData['estate_full_py']=$data['full_py'];
      $saveData['estate_first_py']=$data['first_py'];
      $saveData['estate_lpt_x']=$data['lpt_x'];
      $saveData['estate_lpt_y']=$data['lpt_y'];
      $saveData['region_id']=$data['region'];
      $saveData['region_name']=$data['region_name'];
      $saveData['scope_id']=$data['scope'];
      $saveData['scope_name']=$data['scope_name'];
      $saveData['geo_val']=$data['geo_val'];
      return $ModelTable->where($condition)->save($saveData);
   }
    //删除 by 小区下有地铁
   public function deleteModelByEstateSubway($estate_id){
      $ModelTable = new Model();
      return $ModelTable->execute("delete from houseselect where estate_id='$estate_id' and subwayline_id>0 and subway_id>0");
   }
   public function addModelByEstateSubway($estate_id){
      $ModelTable = new Model();
      return $ModelTable->execute("insert into `houseselect` (`id`,`resource_id`,`room_id`,`room_area`,`room_money`,`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`, `scope_id`,`scope_name`,
                           `subwayline_id`,`subwayline_name`,`subway_id`,`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_top`,`create_time`,`update_time`,`is_auth`,`brand_type`,
                           `subway_distance`,`rent_type`,`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,
                           `is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,`is_gongyu`,`rent_month`,`top_type`,`create_man`,`room_no`,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id)
select uuid(),`resource_id`,`room_id`,`room_area`,`room_money`,a.`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`, `scope_id`,`scope_name`,
                           b.`subwayline_id`,b.`subwayline_name`,b.`subway_id`,b.`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_top`,`create_time`,`update_time`,`is_auth`,`brand_type`,
                           b.`subway_distance`,`rent_type`,a.`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,
                           `is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,`is_gongyu`,`rent_month`,`top_type`,`create_man`,`room_no`,a.geo_val,a.rental_type,a.store_id,a.is_regroup,a.is_agent_fee,a.low_price,a.customer_id  
 from `houseselect` a,`subwayestate` b where a.estate_id=b.estate_id and  a.`subwayline_id`=0 and a.top_type=0 and a.estate_id='$estate_id' ");
   }
   /*置顶 */
   public function getTopCount($where){
      $Model=new Model();
      return $Model->query("select count(1) as cnt,max(is_top) as max_sort from houseselect where ".$where);
   }
   public function getTopList($where,$orderby,$limit_start,$limit_end){
      $Model=new Model();
      return $Model->query("select room_no,estate_name,rent_type,top_type,region_name,scope_name,subwayline_name,subway_name,room_money,create_man,toproom_createtime,id,region_id,scope_id,room_id,is_top,is_gongyu,subwayline_id,subway_id from houseselect where ".$where.$orderby." limit $limit_start,$limit_end");
   }
   //全城、区域、板块、地铁线、地铁站 置顶
   public function addTopModel($data,$is_gongyu=0,$subwayline_id=0,$subway_id=0){
      $Model=new Model();
      if($subway_id>0){
        $result = $Model->execute("insert into `houseselect` (`id`,`resource_id`,`room_id`,`room_area`,`room_money`,`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`,`scope_id`,`scope_name`,`subwayline_id`,`subwayline_name`,`subway_id`,`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_auth`,`brand_type`,`subway_distance`,`rent_type`,`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,`is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,`is_gongyu`,`rent_month`,`top_type`,`create_man`,`room_no`,`is_top`,`create_time`,`update_time`,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id,toproom_createtime) 
          select uuid(),`resource_id`,`room_id`,`room_area`,`room_money`,`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`,`scope_id`,`scope_name`,`subwayline_id`,`subwayline_name`,`subway_id`,`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_auth`,`brand_type`,`subway_distance`,`rent_type`,`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,`is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,$is_gongyu,`rent_month`,".$data['top_type'].",'".$data['create_man']."','".$data['room_no']."',".$data['is_top'].",create_time,update_time,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id,unix_timestamp()  
          from houseselect where room_id='".$data['room_id']."' and subwayline_id=$subwayline_id and subway_id=$subway_id limit 1");
      }else{
        $result = $Model->execute("insert into `houseselect` (`id`,`resource_id`,`room_id`,`room_area`,`room_money`,`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`,`scope_id`,`scope_name`,`subwayline_id`,`subwayline_name`,`subway_id`,`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_auth`,`brand_type`,`subway_distance`,`rent_type`,`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,`is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,`is_gongyu`,`rent_month`,`top_type`,`create_man`,`room_no`,`is_top`,`create_time`,`update_time`,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id,toproom_createtime) 
        select uuid(),`resource_id`,`room_id`,`room_area`,`room_money`,`estate_id`,`estate_name`,`estate_address`,`estate_full_py`,`estate_first_py`,`estate_lpt_x`,`estate_lpt_y`,`region_id`,`region_name`,`scope_id`,`scope_name`,`subwayline_id`,`subwayline_name`,`subway_id`,`subway_name`,`is_cut`,`is_alone_wc`,`is_alone_kitchen`,`is_limit_girl`,`is_owner`,`is_auth`,`brand_type`,`subway_distance`,`rent_type`,`city_code`,`is_commission`,`is_dingjin`,`is_baozhang`,`pay_method`,`room_num`,`is_alone_yangtai`,`is_alone_kongtiao`,`is_alone_chuang`,`is_pub_kitchen`,`is_pub_wc`,`is_pub_kuandai`,`is_pub_xiyiji`,`is_pub_bingxiang`,`is_pub_reshuiqi`,$is_gongyu,`rent_month`,".$data['top_type'].",'".$data['create_man']."','".$data['room_no']."',".$data['is_top'].",create_time,update_time,geo_val,rental_type,store_id,is_regroup,is_agent_fee,low_price,customer_id,unix_timestamp()  
        from houseselect where room_id='".$data['room_id']."' and subwayline_id=$subwayline_id limit 1");
      }
      return $result;
   }

   public function deleteModelByWhere($where){
      $ModelTable = new Model();
      return $ModelTable->execute("delete from houseselect where ".$where);
   }
   public function modifyTopRoomSort($id,$sort_index,$idTwo,$sort_indexTwo){
      $model = new Model();
      $result=$model->execute("update houseselect set is_top='$sort_index' where id='$id'");
      $result=$model->execute("update houseselect set is_top='$sort_indexTwo' where id='$idTwo'");
      return $result;
   }
   //可租列表
   public function getModelListCount($condition){
     $model = new Model();
     return $model->query("select count(id) as totalcnt from houseselect ".$condition);
   }
   public function getModelList($condition,$orderby_limit){
     $model = new Model();
     return $model->query("select estate_name,region_name,scope_name,room_num,rent_type,room_area,room_money,create_time,update_time,is_commission from houseselect ".$condition.$orderby_limit);
   }

}
?>
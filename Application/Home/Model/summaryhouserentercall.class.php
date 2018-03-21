<?php
namespace Home\Model;
use Think\Model;
class summaryhouserentercall{
  /*联系房东统计表 */
   public function getModelListCount($condition){
     $model = new Model();
     $sql="select count(distinct scope_id) as totalCount from summary_houserentercall a ";
     return $model->query($sql.$condition);
   }
   public function getModelList($condition,$limit_start,$limit_end){
     $model = new Model();
     $sql="select region_name,scope_name,sum(contact_count) as contact_count,sum(contact_bd_count) as contact_bd_count,sum(appoint_count) as appoint_count,
     sum(appoint_bd_count) as appoint_bd_count,sum(browse_count) as browse_count,sum(browse_bd_count) as browse_bd_count from summary_houserentercall a ";
     return $model->query($sql.$condition." group by region_name,scope_name order by contact_count desc,id desc limit $limit_start,$limit_end");
   }
 /*置顶房源统计表 */
  public function getToproomCount($condition){
    $model = new Model();
    $sql="select count(distinct room_id) as totalCount from summary_toproom a ";
    return $model->query($sql.$condition);
  }
  public function getToproomList($condition,$limit_start,$limit_end){
    $model = new Model();
    $sql="select room_no,estate_name,region_name,scope_name,rent_type,sum(browse_page_count) as browse_page_count,sum(browse_user_count) as browse_user_count,sum(contact_page_count) as contact_page_count,
    sum(contact_user_count) as contact_user_count,sum(appoint_page_count) as appoint_page_count,sum(appoint_user_count) as appoint_user_count from summary_toproom a ";
    return $model->query($sql.$condition." group by room_id order by contact_page_count desc,id desc limit $limit_start,$limit_end");
  }

  //连接数
  public function getConnectData($owner_id,$start_time,$end_time){
    $model = new Model();
    $sql="SELECT COUNT(DISTINCT renter_mobile) AS renter_cnt,COUNT(DISTINCT renter_mobile,room_id) AS all_cnt,SUM(case when contact_cnt>0 then 1 else 0 end) AS contact_cnt,SUM(case when reserve_cnt>0 then 1 else 0 end) AS reserve_cnt FROM (
SELECT renter_mobile,room_id,SUM(CASE WHEN `type`=1 THEN 1 ELSE 0 END) AS contact_cnt,SUM(CASE WHEN `type`=2 THEN 1 ELSE 0 END) AS reserve_cnt 
FROM gaodu.`summaryconnect` WHERE owner_id='$owner_id' AND create_time>=$start_time AND create_time<=$end_time GROUP BY renter_mobile,room_id,`type`    
) AS tt";
    return $model->query($sql);
  }

}
?> 
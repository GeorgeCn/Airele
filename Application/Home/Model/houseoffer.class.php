<?php
namespace Home\Model;
use Think\Model;
class houseoffer{
   /*报价表 */
   public function getHouseofferData($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from houseoffer where ".$where_orderby);
   }
   public function deleteHouseoffer($where){
      $ModelTable = new Model();
     return $ModelTable->execute("delete from houseoffer where ".$where);
   }
   public function addHouseoffer($data){
     $ModelTable = M('houseoffer');
     return $ModelTable->add($data);
   }
   public function updateHouseoffer($data,$where){
     $ModelTable = M('houseoffer');
     return $ModelTable->where($where)->save($data);
   }
   //更新表数据
   public function executeHouseoffer($sql){
      $ModelTable = new Model();
     return $ModelTable->execute($sql);
   }
    /*聚合问题反馈表 */
   public function getHousefeederrorData($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from housefeederror where ".$where_orderby);
   }
   public function deleteHousefeederror($where){
      $ModelTable = new Model();
     return $ModelTable->execute("delete from housefeederror where ".$where);
   }
   public function addHousefeederror($data){
     $ModelTable = M('housefeederror');
     return $ModelTable->add($data);
   }
   public function updateHousefeederror($data,$where){
     $ModelTable = M('housefeederror');
     return $ModelTable->where($where)->save($data);
   }

    /*中介公司 */
   public function getAgentcompany($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from agentcompany where ".$where_orderby);
   }
   public function deleteAgentcompany($where){
      $ModelTable = new Model();
     return $ModelTable->execute("delete from agentcompany where ".$where);
   }
   public function addAgentcompany($data){
     $ModelTable = M('agentcompany');
     return $ModelTable->add($data);
   }
   public function updateAgentcompany($data,$where){
     $ModelTable = M('agentcompany');
     return $ModelTable->where($where)->save($data);
   }

   /*聚合库 */
   public function getRoomimgSimilar($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from gaodu_similar.room_img_similar where ".$where_orderby);
   }
   public function updateRoomimgSimilar($data,$where){
     $ModelTable = M('gaodu_similar.room_img_similar');
     return $ModelTable->where($where)->save($data);
   }
   public function getCalculateBasic($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from gaodu_similar.room_calculate_basic_data where ".$where_orderby);
   }
   public function updateCalculateBasic($data,$where){
     $ModelTable = M('gaodu_similar.room_calculate_basic_data');
     return $ModelTable->where($where)->save($data);
   }
    public function updateRoomtxtSimilar($data,$where){
     $ModelTable = M('gaodu_similar.room_txt_similar');
     return $ModelTable->where($where)->save($data);
   }
    public function updateSimilarmidTab($data,$where){
     $ModelTable = M('gaodu_similar.room_similar_mid_tab');
     return $ModelTable->where($where)->save($data);
   }
   //图片
   public function getAggregationImage($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from gaodu_house_clean.house_aggregation_img where ".$where_orderby);
   }
   //抓取基数据
   public function getHouserobinfo($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from gaodu_house_clean.house_aggregation_info where ".$where_orderby);
   }
   public function updateHouserobinfo($data,$where){
     $ModelTable = M('gaodu_house_clean.house_aggregation_info');
     return $ModelTable->where($where)->save($data);
   }
   //获取house_aggregation_info信息
  public function modelGetHouseAggregationInfo ($firstRow,$listRows,$fields,$where)
  {
    $ModelTable = M("gaodu_house_clean.house_aggregation_info");
    $result = $ModelTable->field($fields)->where($where)->order('estate_name desc')->limit($firstRow,$listRows)->select();
    return $result;
  }
  //统计house_aggregation_info数量
  public function modelCountHouseAggregationInfo ($where)
  {
    $ModelTable = M("gaodu_house_clean.house_aggregation_info");
    $pageCount = $ModelTable->where($where)->count();
    return $pageCount;
  }
  //修改house_aggregation_info信息
  public function modelModifyHouseAggregationInfo ($where,$data)
  {
    $ModelTable = M("gaodu_house_clean.house_aggregation_info");
    $result = $ModelTable->where($where)->data($data)->save();
    return $result;
  }
}
?> 
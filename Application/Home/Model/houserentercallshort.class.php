<?php
namespace Home\Model;
use Think\Model;

/*租客短链推送记录表 */
class houserentercallshort{

   public function getListCount($where){
      $ModelTable = new Model();
      return $ModelTable->query("select count(1) as totalCount from houserentercallshort ".$where);
   }
   public function getList($where,$firstrow,$listrows){
      $ModelTable = new Model();
      return $ModelTable->query("select city_id,renter_source,renter_phone,contact_time,contact_phone,region_name,scope_name,room_money,client_phone,update_man,push_status,short_url,bak_content,id from houserentercallshort ".$where." order by contact_time desc limit $firstrow,$listrows");
   }
   public function getModelById($id){
      $ModelTable = M("houserentercallshort");
      return $ModelTable->where(array('id'=>$id))->find();
   }
   public function addModel($data){
      $ModelTable = M("houserentercallshort");
      return $ModelTable->add($data);
   }
   public function updateModel($data){
      $ModelTable = M("houserentercallshort");
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }

}
?>  
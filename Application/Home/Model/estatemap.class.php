<?php
namespace Home\Model;
use Think\Model;
/*小区映射表 */
class estatemap{
   public function getModelListCount($where){
      $ModelTable = new Model();
      return $ModelTable->query("select count(*) as totalCount from estatemap where 1=1 ".$where);
   }
   public function getModelList($firstrow,$listrows,$where){
      $ModelTable = new Model();
      return $ModelTable->query("select id,estate_name,estate_name_third,third_name,city_id,update_time,region_third,scope_third,region_name,scope_name from estatemap where 1=1 ".$where." order by update_time desc limit $firstrow,$listrows");
   }
   public function deleteModel($id){
      $ModelTable = new Model();
      return $ModelTable->execute("delete from estatemap where id='$id'");
   }
   public function deleteModelByWhere($where){
      $ModelTable = new Model();
      return $ModelTable->execute("delete from estatemap where ".$where);
   }
   public function getModelById($id){
      $ModelTable = M("estatemap");
      return $ModelTable->where(array('id'=>$id))->find();
   }
   public function addModel($data){
      $ModelTable = M("estatemap");
      return $ModelTable->add($data);
   }
   public function updateModel($data){
      $ModelTable = M("estatemap");
      return $ModelTable->where(array('id'=>$data['id']))->save($data);
   }
   //查询
   public function getDataByWhere($where){
      $ModelTable = new Model();
      return $ModelTable->query("select id,estate_name,estate_id,estate_name_third,third_name from estatemap where ".$where);
   }
   //条件更新
   public function updateModelByWhere($data,$where){
      $ModelTable = M("estatemap");
      return $ModelTable->where($where)->save($data);
   }

}
?> 
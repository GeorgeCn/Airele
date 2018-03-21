<?php
namespace Home\Model;
use Think\Model;
class servicerefresh{
   /*配置服务-刷新房源 */
   public function getRefreshroomData($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from servicerefreshroom where ".$where_orderby);
   }
   public function deleteRefreshroom($where){
      $ModelTable = new Model();
     return $ModelTable->execute("delete from servicerefreshroom where ".$where);
   }
   public function addRefreshroom($data){
     $ModelTable = M('servicerefreshroom');
     return $ModelTable->add($data);
   }
   public function updateRefreshroom($data,$where){
     $ModelTable = M('servicerefreshroom');
     return $ModelTable->where($where)->save($data);
   }

    /*配置服务-刷新房源时间点 */
   public function getRefreshroomtimeData($columns,$where_orderby){
     $ModelTable = new Model();
     return $ModelTable->query("select $columns from servicerefreshroomtime where ".$where_orderby);
   }
   public function deleteRefreshroomtime($where){
      $ModelTable = new Model();
     return $ModelTable->execute("delete from servicerefreshroomtime where ".$where);
   }
   public function addRefreshroomtime($data){
     $ModelTable = M('servicerefreshroomtime');
     return $ModelTable->add($data);
   }
   public function updateRefreshroomtime($data,$where){
     $ModelTable = M('servicerefreshroomtime');
     return $ModelTable->where($where)->save($data);
   }

}
?> 
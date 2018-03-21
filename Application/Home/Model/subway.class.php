<?php
namespace Home\Model;
use Think\Model;
class subway{
   //所有地铁线路
   public function getAllSubwayLine(){
      $ModelTable = M("subwayline");
      return $ModelTable->field('id,subwayline_name')->where("city_code='".C('CITY_CODE')."'")->order('id')->select();
   }
   //根据线路查询所有地铁站
   public function getSubwayByLine($subwayline_id){
     $ModelTable = M("subway");
     return $ModelTable->field('id,subway_name')->where("subwayline_id=$subwayline_id and city_code='".C('CITY_CODE')."' ")->order('sort_index')->select();
   }
   //新增小区地铁
   public function addSubwayestate($data){
      $ModelTable = M("subwayestate");
      $data['city_code']=C('CITY_CODE');
      $data['id']=guid();
      return $ModelTable->data($data)->add();
   }
   //查询小区下面的地铁线路
   public function getSubwayByEstateid($estate_id){
     $ModelTable = M("subwayestate");
     $where="estate_id='".$estate_id."' and city_code='".C('CITY_CODE')."' ";
     return $ModelTable->field('id,subwayline_id,subwayline_name,subway_id,subway_name,subway_distance')->where($where)->order("subwayline_id asc")->select();
   }
   //查询小区下面的一条地铁线路（是否有地铁判断）
   public function getOneSubwayByEstateid($estate_id){
     $ModelTable = new Model();
     return $ModelTable->query("select id,subwayline_id,subwayline_name,subway_id,subway_name,subway_distance from subwayestate where estate_id='$estate_id' limit 1");
   }
   //删除
   public function deleteSubwayByEstateid($estate_id){
     $ModelTable = M("subwayestate");
     $where="estate_id='".$estate_id."' and city_code='".C('CITY_CODE')."' ";
     return $ModelTable->where($where)->delete();
   }

   public function getSubwayestateByWhere($where,$orderby_limit){
     $ModelTable = new Model();
     return $ModelTable->query("select id,subwayline_id,subwayline_name,subway_id,subway_name,subway_distance from subwayestate ".$where.$orderby_limit);
   }

}
?> 
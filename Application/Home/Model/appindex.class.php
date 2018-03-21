<?php
namespace Home\Model;
use Think\Model;
class appindex{
  /*首页入口设置 */
   public function addModel($data){
     $Model = M("appindex");
     $data['city_code']=C('CITY_CODE');
     return $Model->add($data);
   }
   public function deleteModel($id){
     $Model = M("appindex");
     return $Model->where(array('id'=>$id))->delete();
   }
   public function updateModel($data){
     $Model = M("appindex");
     $data['city_code']=C('CITY_CODE');
     return $Model->where(array('id'=>$data['id']))->save($data);
   }
   public function getList($where){
     $Model = M("appindex");
     $where['city_code']=C('CITY_CODE');
     return $Model->where($where)->select();
   }
   public function modelfind($where){
     $Model = M("appindex");
     $where['city_code']=C('CITY_CODE');
     return $Model->where($where)->find();
   }
   public function deleteAppindexBymid($where){
     $Model = M("appindex");
     return $Model->where($where)->delete();
   }
}
?> 
<?php
namespace Home\Model;
use Think\Model;
class fhserviceorder{
   
   public function modelPageCount($where){
      $ModelTable = M("fhserviceorder");
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelPageList($firstrow,$listrows,$where){
      $ModelTable = M("fhserviceorder");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

   public function modelGet($where){
      $ModelTable=M('fhserviceorder');
      $result = $ModelTable->where($where)->order('create_time desc')->select();
     return $result;
   }
    
   public function modelFind($where){
     $ModelTable=M('fhserviceorder');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelUpdate($data){
      $ModelTable=M('fhserviceorder');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   public function modelAdd($data){
      $ModelTable=M('fhserviceorder');
      $result = $ModelTable->add($data);
      return $result;
   }
   public function modelCount($where){
      $ModelTable=M('fhserviceorder');
      $result = $ModelTable->where($where)->count();
      return $result;
   }
   public function modelOrderCount($where){
       $ModelTable = M("fhserviceorder");
      $result=$ModelTable->join('INNER JOIN fhserviceman ON fhserviceman.id=fhserviceorder.owner_id')->where($where)->count();
       return $result;
       
   }
   public function modelOrderSelect($firstrow,$listrows,$where){
       $ModelTable = M("fhserviceorder");
       $result=$ModelTable->field('fhserviceman.id as owner_id,fhserviceman.region_id,fhserviceman.name,fhserviceman.mobile,fhserviceman.service_price,fhserviceorder.order_status,fhserviceorder.id,fhserviceorder.customer_id,fhserviceorder.price,fhserviceorder.city_code,fhserviceorder.start_time,fhserviceorder.end_time')->join('INNER JOIN fhserviceman ON fhserviceman.id=fhserviceorder.owner_id')->where($where)->order('fhserviceorder.create_time desc')->limit($firstrow,$listrows)->select();
       return $result;   
   }

    public function getParamRegion($where){
      $ModelTable = M("region");
      $result = $ModelTable->where($where)->find();
   //   echo$ModelTable->getLastSql();
     return $result;
   }
}
?> 
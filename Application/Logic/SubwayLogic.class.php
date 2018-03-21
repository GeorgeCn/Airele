<?php
namespace Logic;
class SubwayLogic{

    //所有地铁线路(缓存)
   public function getAllSubwayLine(){
     $modelDal=new \Home\Model\subway();
     $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."subwayline_data");
     if(empty($data)){
        $data = $modelDal->getAllSubwayLine();
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."subwayline_data",$data,60*60*3);
     }
     return $data;
   }
   //根据线路查询所有地铁站(缓存)
   public function getSubwayByLine($subwayline_id){
     $modelDal=new \Home\Model\subway();
     $city_prex=C('CITY_PREX');
     $data=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."subway_data_".$subwayline_id);
     if(empty($data)){
        $data = $modelDal->getSubwayByLine($subwayline_id);
        set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex."subway_data_".$subwayline_id,$data,60*60*3);
     }
     return $data;
   }
   //新增小区地铁
   public function addSubwayestate($data){
      $modelDal=new \Home\Model\subway();
      return $modelDal->addSubwayestate($data);
   }

   //查询小区下面的地铁线路
   public function getSubwayByEstateid($estate_id){
      $modelDal=new \Home\Model\subway();
      return $modelDal->getSubwayByEstateid($estate_id);
   }
   public function deleteSubwayByEstateid($estate_id){
      $modelDal=new \Home\Model\subway();
      return $modelDal->deleteSubwayByEstateid($estate_id);
   }
}
?>
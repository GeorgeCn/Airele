<?php
namespace Logic;
use Think\Controller;
class Finance extends Controller{
	//统计总条数
	 public function getFinancePageCount($where){
    	$modelDal=new \Home\Model\finance();
    	$result=$modelDal->modelFinancePageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getFinanceDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\finance();
        $result=$modelDal->modelFinanceDataList($firstrow,$listrows,$where);
        return $result;     
    }
    //获取房东姓名
    public function getorderLandlord($order_id){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelClient($order_id);
        return json_encode($result);
    }

      public function getCacheorderLandlord($order_id){
         $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_order_land_lord'.$order_id);
          if(empty($result)){ 
               $result=$this->getorderLandlord($order_id);
               set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_order_land_lord'.$order_id,$result,3600);
          }
          return $result;
    }
}
?>
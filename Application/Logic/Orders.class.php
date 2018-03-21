<?php
namespace Logic;
use Think\Controller;
class Orders extends Controller{
	//统计总条数
	 public function getOrderPageCount($where){
    	$modelDal=new \Home\Model\orders();
    	$result=$modelDal->modelOrderPageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getOrderDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderDataList($firstrow,$listrows,$where);
        return $result;     
    }
    //获取订单信息
    public function getOrderDetails($orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderDetails($orderid);
        return $result; 

    }
    //业主信息
    public function getClient($orderid){
         $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelClient($orderid);
        return $result; 

    }
    //获取合同照，工牌
    public function getBargainPicture($orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelBargainPicture($orderid);
        return $result; 
        
    }
    //付款方式
    public function payManner($orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelpayManner($orderid);
        return $result; 
    }
    //获取订单状态
    public function getOrderStatus($orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderStatus($orderid);
        return $result; 
    }
    //修改订单状态
    public function upOrderStatus($orderid,$status){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelUpOrderStatus($orderid,$status);
        return $result;
    }
     //修改拒绝状态拒绝原因
    public function upOrderReason($orderid,$status,$reason){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelUpOrderReason($orderid,$status,$reason);
        return $result;
    }
    //插入订单状态
    public function addOrderStatus($order_id,$status,$memo,$oper_id,$desc){
         $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelAddOrderStatus($order_id,$status,$memo,$oper_id,$desc);
        return $result;
    }
    //退回红包
    public function upCoupon($customer_id,$orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelUpCoupon($customer_id,$orderid);
        return $result;
    }
    //优惠总金额
    public function getSumCoupon($orderid){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelSumCoupon($orderid);
        return $result;
        
    }
    //获取用户优惠金额
    public function getTenantCoupon($order_id){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelTenantCoupon($order_id);
        return json_encode($result);
    }
     //获取操作人
    public function getOrderOperator($order_id){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderOperator($order_id);
        return json_encode($result);
    }

    //获取详细优惠金额
     public function getOrderCoupon($order_id){
         $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelTenantCoupon($order_id);
        return $result;
    }
    //获取操作信息列表
    public function getOrderStatusList($order_id){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelOrderStatusList($order_id);
        return $result;
    }
    //导出excel
    public function getOrderExcel($where){
         $modelDal=new \Home\Model\orders();
         $result=$modelDal->modelOrderExcel($where);
         return $result;
    }
    //租房金额统计
    public function getCountHouseMoney($where){
        $modelDal=new \Home\Model\orders();
        $result=$modelDal->modelCountHouseMoney($where);
        return $result;
    }

    public function getCachepayMannerArr($orderid){
         $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_pay_manner'.$orderid);
          if(empty($result)){ 
               $result=$this->payManner($orderid);
               set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'cache_pay_manner'.$orderid,$result,7000);
          }
          return $result;
    }

    public function modelGetCoupon($where){
         $modelDal=new \Home\Model\orders();
         $result=$modelDal->modelGetCoupon($where);
        return $result;
    }

     public function modelMerchantCoupon($where){
         $modelDal=new \Home\Model\orders();
         $result=$modelDal->modelMerchantCoupon($where);
        return $result;
    }

     public function modelUpdateMemo($data){
         $modelDal=new \Home\Model\orders();
         $result=$modelDal->modelUpdateMemo($data);
        return $result;
    }

    public function modelUpOrderDesc($orderid,$memo){
         $modelDal=new \Home\Model\orders();
         $result=$modelDal->modelUpOrderDesc($orderid,$memo);
        return $result;
    }

}
?>
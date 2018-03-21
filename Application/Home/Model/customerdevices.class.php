<?php
namespace Home\Model;
use Think\Model;
class customerdevices{
   const connecdata = 'DB_DATA';
   public function getUseModel($customerId){
     $ModelTable=M('customerdevices','',self::connecdata);
     $where['customer_id']=$customerId;
     $where['is_using']=1;
     return $ModelTable->where($where)->find();
   }

}
?> 
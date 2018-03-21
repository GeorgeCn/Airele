<?php
namespace Home\Model;
use Think\Model;
class orderpaystatus{
    //获取分页数据
   public function modelStagingList($where){
      $ModelTable = M("orderpaystatus");
      $datalist = $ModelTable->where($where)->order('create_time desc')->select();
     return $datalist;
   }
    
   public function modelAdd($data){
      $ModelTable = M("orderpaystatus");
      $result = $ModelTable->data($data)->add();
      return $result;
   }

}
?> 
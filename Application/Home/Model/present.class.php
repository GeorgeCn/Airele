<?php
namespace Home\Model;
use Think\Model;
class present{

//加入管家统计
  public function modelKeeperPageCount($where){
  	return 0;
   }
   //获取加入管家分页数据
   public function modelKeeperDataList($firstrow,$listrows,$where){
      return null;
   }
    //委托统计
  public function modelIntrustPageCount($where){
     return 0;
   }
    //获取委托分页数据
   public function modelIntrustDataList($firstrow,$listrows,$where){
      return null;
   }

}
?> 
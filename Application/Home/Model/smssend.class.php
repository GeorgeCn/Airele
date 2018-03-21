<?php
namespace Home\Model;
use Think\Model;
class smssend{
  //统计
    public function modelSmssendCount($where){
     $ModelTable = M("smssend");
     $result = $ModelTable->where($where)->count();
     return $result;
    }
  //列表
   public function modelSmssendList($where,$firstrow,$listrows){
     $ModelTable = M("smssend");
     $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
}
?> 
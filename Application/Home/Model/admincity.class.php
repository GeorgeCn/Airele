<?php
namespace Home\Model;
use Think\Model;
class admincity{

  public function modelGet($where){
     $User = M("admincity");
     $result = $User->where($where)->select();
     return $result;
  }
  public function modelFind($where){
     $User = M("admincity");
     $result = $User->where($where)->find();
     return $result;
  }
}
?> 
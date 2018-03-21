<?php
namespace Home\Model;
use Think\Model;
class serviceoptions{
   public function modelServiceFind($where){
     $ModelTable = M("serviceoptions");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   

}
?> 
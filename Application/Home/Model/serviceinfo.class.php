<?php
namespace Home\Model;
use Think\Model;
class serviceinfo{
   public function modelServiceFind($where){
     $ModelTable = M("serviceinfo");
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   

}
?> 
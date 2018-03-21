<?php
namespace Home\Model;
use Think\Model;
class customerloginout{
   const connecdata = 'DB_DATA';
   public function modelAdd($data){
     $ModelTable=M('customerloginout','',self::connecdata);
     return $ModelTable->data($data)->add();
   }

}
?> 
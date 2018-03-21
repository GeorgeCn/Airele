<?php
namespace Home\Model;
use Think\Model;
class calllog{
  const conneccity = 'DB_CALL';
 
   public function modelGetFind($where){
      $ModelTable = M("calllog","",self::conneccity);
      $result = $ModelTable->where($where)->find();
      return $result;
   }

   public function modelUpdate($data){
   	  $ModelTable = M("calllog","",self::conneccity);
   	   $where['id']=$data['id'];
       $ModelTable->where($where)->save($data);
   }


   public function modelVirtualFind($where){
      $ModelTable = M("virtualcalllog","",self::conneccity);
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelVirtualUpdate($data){
      $ModelTable = M("virtualcalllog","",self::conneccity);
       $where['id']=$data['id'];
       $ModelTable->where($where)->save($data);
   }
   
}
?> 
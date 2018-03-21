<?php
namespace Home\Model;
use Think\Model;
class whitelist{
  const conneccity = 'DB_CALL';

    public function modelPageCount($where){
      $ModelTable = M("whitelist","",self::conneccity);
      $result = $ModelTable->where($where)->count();
      return $result;
   }

   public function modelPageList($firstrow,$listrows,$where){
       $ModelTable = M("whitelist","",self::conneccity);
       $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
       return $datalist;
   }
   public function modelFind($where){
      $ModelTable = M("whitelist","",self::conneccity);
      $result = $ModelTable->where($where)->find();
      return $result;
   }

   public function modelUpdate($data){
   	   $ModelTable = M("whitelist","",self::conneccity);
   	   $where['id']=$data['id'];
       $result=$ModelTable->where($where)->save($data);
       return $result;
   }
   public function modelAdd($data){
       $ModelTable = M("whitelist","",self::conneccity);
       $result=$ModelTable->data($data)->add();
       return $result;
   }
    public function modelDelete($where){
       $ModelTable = M("whitelist","",self::conneccity);
       $result=$ModelTable->where($where)->delete(); 
       return $result;
   }
}
?> 
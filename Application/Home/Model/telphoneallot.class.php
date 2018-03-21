<?php
namespace Home\Model;
use Think\Model;
class telphoneallot{
  const conneccity = 'DB_CALL';
  public function getPcExtcodeByRoomid($room_id,$big_code){
      $ModelTable = M("telphoneallot","",self::conneccity);
      return $ModelTable->where(array('big_code'=>$big_code,'room_id'=>$room_id))->find();
   }
   
}
?> 
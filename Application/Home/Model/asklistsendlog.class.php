<?php
namespace Home\Model;
use Think\Model;
class asklistsendlog{

   public function modelAsklistCount($where){
     $ModelTable = M("asklistsendlog");
     $result = $ModelTable->where($where)->count();
     return $result;
   }

   public function modelAskList($firstrow,$listrows,$where){
      $ModelTable = M("asklistsendlog");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }

  //垮库查询
   public function modelAskListStatusCount(){
          $city_code=C('CITY_CODE');
        $model = M("asklistsendlog");
        $sql="select count(*) as askcount from gaodu.asklistsendlog as a inner join houseroom b on a.room_id=b.id where a.rec_id='' and a.city_code='".$city_code."' and b.status=2";
        $result=$model->query($sql);
        return $result[0]['askcount'];
   }

   public function modelAskListStatus($limit_start,$limit_end){
         $city_code=C('CITY_CODE');
 
        $model = M("asklistsendlog");
        $sql="select a.*,b.status from gaodu.asklistsendlog as a inner join houseroom b on a.room_id=b.id where a.rec_id='' and a.city_code='".$city_code."' and b.status=2";
        $result=$model->query($sql." order by a.create_time desc limit $limit_start,$limit_end");
        return $result;
   }

  public function modelAsklistReceiveCount($where){
     $ModelTable = M("asklistreceive");
     $result = $ModelTable->where($where)->count();
     return $result;
   }

   public function modelAskListReceive($firstrow,$listrows,$where){
      $ModelTable = M("asklistreceive");
      $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   
   public function modelUpdate($data){
      $ModelTable = M("asklistreceive");
      $where['id']=$data['id'];
      $result = $ModelTable->where($where)->save($data);
      return $result;
   }
   public function modelUpdateLog($data){
      $ModelTable = M("asklistsendlog");
      $where['id']=$data['id'];
      $result = $ModelTable->where($where)->save($data);
      return $result;
   }

   public function modelFind($where){
       $ModelTable = M("asklistreceive");
       $result = $ModelTable->where($where)->find();
       return $result;
   }
   public function modelLogFind($where){ 
       $ModelTable = M("asklistsendlog");
       $result = $ModelTable->where($where)->find(); 
       return $result;
   }
   public function modelGetAskReceiver ($firstRow,$listRows,$fields,$where)
  {   
      $ModelTable = M("asklistreceive");
      $data = $ModelTable->alias('a')->join('gaodu.houseroom b ON a.room_id=b.id')->field($fields)->where($where)->limit($firstRow,$listRows)->select();
      return $data;
  }
 
}
?> 
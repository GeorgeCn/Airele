<?php
namespace Home\Model;
use Think\Model;
class askmonitor{
   public function modelSelect($where){
      $ModelTable = M("askmonitor");
      $datalist = $ModelTable->where($where)->order('create_time desc')->select();
     return $datalist;
   }
    public function modelFind($where){
        $ModelTable = M("askmonitor");
        $datalist = $ModelTable->where($where)->find();
       return $datalist;
    }
    public function updateModel($data){
     $Model = M("askmonitor");
     $where['id']=$data['id'];
     $where['mobile']=$data['mobile'];
     return $Model->where($where)->save($data);
   }
   //今日发送数
   public function pushcount(){
         $model = new Model();
         $result=$model->query("select COUNT(id) as count from asklistsendlog where is_send=1 and city_code=".C('CITY_CODE')." and create_time >".strtotime(date('Y-m-d')));
         return $result;
   }

   //今日回复数
   public function replycount(){
         $model = new Model();
         $result=$model->query("select COUNT(id) as count from asklistreceive where city_code=".C('CITY_CODE')." and create_time >".strtotime(date('Y-m-d')));
        //echo $model->getLastSql();
         return $result;
   }

   //当前回复数
   public function currentreplycount($mobile){
         $model = new Model();
         $result=$model->query("select COUNT(id) as count from asklistreceive where send_no=".$mobile." and city_code=".C('CITY_CODE')." and create_time >".strtotime(date('Y-m-d')));
         return $result;
   }
   //当前发送数
   public function currentpushcount($mobile){
         $model = new Model();
         $result=$model->query("select COUNT(id) as count from asklistsendlog where is_send=1 and send_no=".$mobile." and city_code=".C('CITY_CODE')." and create_time >".strtotime(date('Y-m-d')));
         return $result;
   }
    //当日回复数
   public function currentreplycountday($mobile){
          $model = new Model();
         $result=$model->query("select COUNT(asklistreceive.id) as count from asklistreceive inner join asklistsendlog on asklistsendlog.rec_id=asklistreceive.id where asklistreceive.city_code=".C('CITY_CODE')." and asklistreceive.send_no = ".$mobile." and asklistreceive.create_time >".strtotime(date('Y-m-d'))." and asklistsendlog.create_time >".strtotime(date('Y-m-d')));
         return $result;   
   }

}
?> 
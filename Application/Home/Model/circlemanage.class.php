<?php
namespace Home\Model;
use Think\Model;
class circlemanage{
    const connecdata = 'DB_DATA';
    //总条数
   public function modelCircleInfoCount($where){
     $ModelTable = M("circleinfo");
     $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->join('circlemember ON circleinfo.id = circlemember.circle_id')->where($where)->where('circlemember.user_level=1')->count();
     return $result;
   }
   public function modelCircleInfoList($firstrow,$listrows,$where){
       $ModelTable = M("circleinfo");
       $where['city_id']=C('CITY_CODE');
       $datalist = $ModelTable->field('circleinfo.*,circlemember.customer_id,circlemember.user_level')->join('circlemember ON circleinfo.id = circlemember.circle_id')->where($where)->where('circlemember.user_level=1')->order('circleinfo.create_time desc')->limit($firstrow,$listrows)->select();
       return $datalist;
    }
   public function modelupCircleInfo($data){
     $ModelTable=M('circleinfo');
     $condition['id']=$data['id'];
     $result = $ModelTable->where($condition)->save($data);
     return $result;
   }
   public function modelCircleInfoFind($where){
     $ModelTable=M('circleinfo');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   //获取用户信息
   public function modelCustomerById($where){
     $ModelTable=M('customer','',self::connecdata);
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   //获取帖子总数
   public function modelCirclePostsCount($where){
     $ModelTable = M("circlepost");
     $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   //帖子列表
   public function modelCirclePostsList($firstrow,$listrows,$where){
     $ModelTable = M("circlepost");
     $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->where($where)->limit($firstrow,$listrows)->order('update_time desc')->select();
     return $result;
   }
   //修改帖子状态
   public function modelupCirclePost($data){
     $ModelTable=M('circlepost');
     $condition['id']=$data['id'];
     $result = $ModelTable->where($condition)->save($data);
     return $result;
   }
   public function modelCirclePostFind($where){
     $ModelTable=M('circlepost');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   //回复帖子
   public function modelCirclePostsReplayCount($where){
     $ModelTable = M("circlepostreplay");
     $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   public function modelCirclePostReplay($firstrow,$listrows,$where){
     $ModelTable=M('circlepostreplay');
      $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->where($where)->order("create_time desc")->limit($firstrow,$listrows)->select();
     return $result;
   }
   public function modelPostReplayFind($where){
     $ModelTable=M('circlepostreplay');
      $where['city_id']=C('CITY_CODE');
     $result = $ModelTable->where($where)->find();
     return $result;
   }
   public function modelupReplayState($data){
     $ModelTable=M('circlepostreplay');
     $condition['id']=$data['id'];
     $result = $ModelTable->where($condition)->save($data);
     return $result;
   }
   //获取成员
   public function modelCircleMemberCount($where){
     $ModelTable = M("circlemember");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   public function modelCircleMember($firstrow,$listrows,$where){
      $ModelTable=M('circlemember');
      $result = $ModelTable->where($where)->limit($firstrow,$listrows)->select();
      return $result;
   }
   public function modelCircleMemberFind($where){
      $ModelTable=M('circlemember');
      $result = $ModelTable->where($where)->find();
      return $result;
   }
   public function modelupCircleMemberState($data){
      $ModelTable=M('circlemember');
      $condition['id']=$data['id'];
      $result = $ModelTable->where($condition)->save($data);
      return $result;
   }
   //删除圈子成员
   public function modelDelCircleMember($where){
     $ModelTable=M('circlemember');
     $result=$ModelTable->where($where)->delete(); 
     return $result;
   }
   //ajax获取回复数
   public function modeAjaxCircleReply($where){
      $ModelTable=M('circlepost');
      $condition['city_id']=C('CITY_CODE');
      $condition['circle_id']=$where['circle_id'];
      $result = $ModelTable->field('circle_id,SUM(replay_cnt) as sumreplay_cnt')->where($condition)->find();
      return $result;
   }
   //回复
   public function modeAddCirclePostrePlay($data){
       $ModelTable=M('circlepostreplay');
       $result=$ModelTable->add($data);
       return $result;
   }
   //最大楼层
   public function modeReplyPositionMax($where){
       $ModelTable=M('circlepostreplay');
       $where['city_id']=C('CITY_CODE');
       $result=$ModelTable->where($where)->max('reply_position');
       return $result;
   }
   //圈子排序
   public function modeSortDispose($data){
       $ModelTable=M('circleinfo');
       $condition['id']=$data['id'];
       $condition['city_id']=C('CITY_CODE');
       $result = $ModelTable->where($condition)->save($data);
       return $result;
   }
}
?>
<?php
namespace Home\Model;
use Think\Model;
class searchresult{
   //总搜索次数
   public function searchtotal($daytime){
         $model = new Model();
         $result=$model->query("select count(distinct key_words) as countnum from gaoducollect.searchresult where key_words<>'' and create_time >".$daytime." and create_time <".($daytime+86400));
        // echo $model->getLastSql();
         return $result;
   }

   //有结果的搜索次数
   public function searchresult($daytime){
         $model = new Model();
         $result=$model->query("select count(distinct key_words) as countnum from gaoducollect.searchresult where key_words<>'' and is_reult=1 and create_time >".$daytime." and create_time <".($daytime+86400));
         return $result;
   }

    //热词
   public function searchhotwords($daytime){
         $model = new Model();
         $result=$model->query("select id,customer_id,key_words,is_reult,city_code from gaoducollect.searchresult  where key_words<>'' and gaodu_platform<3 and create_time >".$daytime." and create_time <".($daytime+86400)." group by udid");
         return $result;
   }
     //热词
   public function gethotwords($daytime){
         $model = new Model();
         $result=$model->query("select id,key_words,is_reult,city_code from gaoducollect.searchresult  where key_words<>'' and gaodu_platform<3 and  create_time >".$daytime." and create_time <".($daytime+86400)." group by key_words");
         return $result;
   }
    //热词
   public function modelfind($id){
         $model = new Model();
         $result=$model->query("select room_ids from gaoducollect.searchresult  where key_words<>'' and id='$id'");
         return $result;
   }

   public function modelGetView($roomid){
    $ModelTable=D('view_houseinfo');
    $condition['room_id'] =$roomid;
    $result=$ModelTable->where($condition)->order('create_time desc')->find();
    return $result;
  }
}
?> 
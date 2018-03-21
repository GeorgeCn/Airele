<?php
namespace Home\Model;
use Think\Model;
class blacklist{
   public function addModel($data){
     $model = M("blacklist","","DB_DATA");
     return $model->add($data);
   }
   public function deleteModel($id){
     $model = M("blacklist","","DB_DATA");
     return $model->where(array('id'=>$id))->delete();
   }
   public function deleteModelByWhere($where){
     $model = M("","","DB_DATA");
     return $model->execute("delete from blacklist where ".$where);
   }
   public function deleteRobBlackuser($phone){
     $model = new Model();
     return $model->execute("delete from gaodu_house_clean.agency where phone='$phone'");
   }
   public function updateModel($data){
     $model = M("blacklist","","DB_DATA");
     return $model->where(array('id'=>$data['id']))->save($data);
   }
   public function getModelCount($where){
     $model = M("","","DB_DATA");
     return $model->query("select count(1) as cnt from blacklist ".$where);
   }
  public function getModelList($condition,$limit_start,$limit_end){
     $model = M("","","DB_DATA");
     $sql="select id,customer_id,mobile,no_login,no_post_replay,no_call,out_house,update_time,oper_name,bak_type,bak_info,'2' as handle_type from blacklist";
     return $model->query($sql.$condition." order by update_time desc limit $limit_start,$limit_end");
  }
  public function getModelByMobile($mobile){
     $model = M("blacklist","","DB_DATA");
     return $model->where(array('mobile'=>$mobile))->find();
  }
  public function getModelResource($where){
      $model = M("houseresource");
      return $model->field('id,city_code')->where($where)->select();
  }
  public function getModelRoom($where){
      $model = M("houseroom");
      return $model->field('id')->where($where)->select();
  }
  public function modelFind($where){
     $model = M("blacklist","","DB_DATA");
     return $model->where($where)->find();
  }
  //黑名单记录
  public function addBlacklog($data){
    $model = M("blacklistlog","","DB_DATA");
    return $model->add($data);
  }
  public function getBlacklogData($columns,$where_orderby){
     $model = M("","","DB_DATA");
     return $model->query("select $columns from blacklistlog where ".$where_orderby);
  }
  //抓取中介黑名单
   public function addBlacklistrob($data){
     $model = M("blacklistrob","","DB_DATA");
     return $model->add($data);
   }
   public function getBlacklistrobByMobile($mobile){
      $model = M("blacklistrob","","DB_DATA");
      return $model->where(array('mobile'=>$mobile))->find();
   }

  //白名单
  public function addWhiteUser($data){
    $model = M("whitelist","","DB_DATA");
    return $model->add($data);
  }
  public function deleteWhiteuser($where){
     $model = M("","","DB_DATA");
     return $model->execute("delete from whitelist where ".$where);
  }
  public function getWhiteuserData($columns,$where_orderby){
     $model = M("","","DB_DATA");
     return $model->query("select $columns from whitelist ".$where_orderby);
  }
  //设备号
  public function getCustomerData($columns,$where_orderby){
     $model = new Model();
     return $model->query("select $columns from gaodudata.customer ".$where_orderby);
  }
  public function getCustomerdevshipRenter($columns,$where_orderby){
     $model = new Model();
     return $model->query("select $columns from gaodudata.customerdevicesship ".$where_orderby);
  }
  public function getCustomerdevshipClient($columns,$where_orderby){
     $model = new Model();
     return $model->query("select $columns from gaodustore.customerdevicesship ".$where_orderby);
  }
  //隐藏帖子和回复
  public function updateCirclepost($where,$data){
     $model = M("circlepost");
     return $model->where($where)->save($data);
   }
   public function updateCirclepostreplay($where,$data){
     $model = M("circlepostreplay");
     return $model->where($where)->save($data);
   }
   //删除房间报价信息
    public function modelDeleteHouseOffer ($where,$data)
    {
      $model = M("houseoffer");
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
    //修改房间信息
    public function modelUpdateHouseRoom ($where,$data)
    {
      $model = M("houseroom");
      $result = $model->where($where)->data($data)->save();
      return $result;
    }
}   
?>
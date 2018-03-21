<?php
namespace Logic;
class CommonCacheLogic{
    //验证当前登录状态
    public function checkcache(){

        $modelAdmin=new \Home\Model\adminlogin();
        $value=cookie('admin_user_name');
        if($value==""){
            return false;
        }else{
            $where['user_name']=$value;
            $user_id=cookie("admin_user_name_id");
            $admin_cache=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$user_id);
            if($admin_cache){
              return true;
            }else{
              return false;
            }
        }
    }

    //地区权限
    public function cityauthority(){
        $modelAdmin=new \Home\Model\adminlogin();
        $where['user_name']=cookie('admin_user_name');
        $adminarr=$modelAdmin->modelAdminFind($where);
        $city_auth=explode(',',$adminarr['city_auth']);
         for($i=0;$i<count($city_auth);$i++){
          $value['city_no']=$city_auth[$i];
          $admincity[]=$value;
         } 
        return $admincity; 
    }
}
?>
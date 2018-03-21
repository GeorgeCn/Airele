<?php
namespace Logic;
use Think\Controller;
class DownLog extends Controller{

	 public function downloadlog($start_time="",$end_time="",$limitcount=0){
    	$modeladminuser=new \Home\Model\adminlogin();
        $modeldownload=new \Home\Model\admindownload();
        $modeladminmenulist=new \Home\Model\adminmenulist();
        $user_name=getLoginName();
        $main_menu_id=I('get.no');
        $left_menu_id=I('get.leftno');
        $whereuser['user_name']=$user_name;
        $adminuser=$modeladminuser->modelAdminFind($whereuser);
        if(!$adminuser){
            echo "数据错误";
        }
        if($left_menu_id!=""){
            $left_menu_arr=$modeladminmenulist->modelGet($left_menu_id);
            $left_menu_two_arr=$modeladminmenulist->modelGet($left_menu_arr['parent_id']);
            $main_menu_arr=$modeladminmenulist->modelGet($main_menu_id);
        }
        $data['id']=create_guid();
        $data['user_id']=$adminuser['id'];
        $data['user_name']=$adminuser['user_name'];
        $data['user_mobile']=$adminuser['mobile'];
        $data['user_email']=$adminuser['email'];
        $data['city_code']=C('CITY_CODE');
        $data['main_menu_id']=$main_menu_id;
        $data['left_menu_id']=$left_menu_id;
        $data['main_menu_name']=$main_menu_arr['name'];
        $data['left_menu_name']=$left_menu_arr['name'];
        $data['memo']="账号:".$user_name." 菜单：".$main_menu_arr['name']."->".$left_menu_two_arr['name']."->".$left_menu_arr['name']." 下载时间:".date("Y-m-d H:i:s",time())." 下载条数：".$limitcount;
        $data['create_time']=time();
        $data['start_time']=$start_time;
        $data['end_time']=$end_time;
    	$result=$modeldownload->addModel($data);
    	return $result;
    }
}
?>
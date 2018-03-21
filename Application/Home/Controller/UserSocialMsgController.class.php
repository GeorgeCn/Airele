<?php
namespace Home\Controller;
use Think\Controller;
class  UserSocialMsgController extends Controller
{
	//用户社会化信息列表
	public function userMsgList()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
    	{
        	$this->error('非法操作',U('Index/index'),1);
     	}
        $switchcity=$handleCommonCache->cityauthority();
       	$this->assign("switchcity",$switchcity);
       	$handleMenu = new \Logic\AdminMenuListLimit();
       	$menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
       	$menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $handleMenu->jurisdiction();
        $startTime=strtotime(I('get.startTime'));
      	$endTime=strtotime(I('get.endTime'));
      	$mobile = I('get.mobile');
      	$where = array();
      	$where['city_code'] = C('CITY_CODE');
      	if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
       		$where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime) {
        	$where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($mobile!="") {
        	$where['mobile'] = array('eq',$mobile);
        }
        $usermsg = new \Home\Model\usersocialmsg();
        $count = $usermsg->modelCountUserMsg($where);
        $Page = new \Think\Page($count,10);
        $fields = 'mobile,sex,if_cut_off,if_bathroom,if_kitchen,look_room,if_reject_landlord,create_time';
        $data=$usermsg->modelGetUserMsg($Page->firstRow,$Page->listRows,$fields,$where);
        $info = array();$list = array();
        foreach($data as $v) {
	        $chars = 'true_name';
	        $condition = array();
	        $condition['mobile'] = $v['mobile'];
	        $name = $usermsg->modelfindCustomer($chars,$condition);
	     	$info['name'] = $name['true_name'];
        	$info['mobile'] = $v['mobile'];
        	$info['sex'] = $v['sex'];
        	$info['ifcutoff'] = $v['if_cut_off'];
        	$info['ifbathroom'] = $v['if_bathroom'];
        	$info['ifkitchen'] = $v['if_kitchen'];
        	$info['lookroom'] = $v['look_room'];
        	$info['ifrejectlandlord'] = $v['if_reject_landlord'];
        	$info['create_time'] = $v['create_time'];
        	$list[] = $info;
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
        $this->display();
	}
}
?>
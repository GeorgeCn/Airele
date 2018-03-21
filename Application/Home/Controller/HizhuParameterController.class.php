<?php
namespace Home\Controller;
use Think\Controller;
class HizhuParameterController extends Controller
{
    public function portConfigureList ()
    {
    	$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
       	$switchcity=$handleCommonCache->cityauthority();
       	$this->assign("switchcity",$switchcity);
      	$handleMenu = new \Logic\AdminMenuListLimit();
      	$menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
      	$menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
      	$handleMenu->jurisdiction();

        $type = I('get.is_owner');
        $status = I('get.record_status');
        $where = $data = array();
        $where['city_code'] = C('CITY_CODE');
        if($type != "") {
            $where['is_owner'] = array('eq',$type);
        }
        if($status != "") {
            $where['record_status'] = array('eq',$status);
        }
        $paramModel = new \Home\Model\hizhuparameter();
        $fields = 'id,time_type,timelimit,price,city_code,record_status,create_time,create_man,coupon_title,house_num,is_owner,sort_index';
        $count = $paramModel->modelCountOwnerFee($where);
        $Page = new \Think\Page($count,10);
        $data = $paramModel->modelGetOwnerFee($Page->firstRow,$Page->listRows,$fields,$where);
      	$this->assign("menutophtml",$menu_top_html);
	  	$this->assign("menulefthtml",$menu_left_html);
	  	$this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
	  	$this->assign("list",$data);
		$this->display();
    }
    public function portConfigureAdd ()
    {
    	$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
       	$switchcity=$handleCommonCache->cityauthority();
       	$this->assign("switchcity",$switchcity);
      	$handleMenu = new \Logic\AdminMenuListLimit();
      	$menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
      	$menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
      	$this->assign("menutophtml",$menu_top_html);
	  	$this->assign("menulefthtml",$menu_left_html);
	  	$this->display();
    }
    public function portConfigureAddInfo () 
  	{
        $data = I('post.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $data['id'] = guid();
        $data['city_code'] = C('CITY_CODE');
        $data['create_time'] = time();
        $data['create_man'] =  trim(getLoginName());
        if(!empty($data['coupon_title'])) {
        	$data['is_coupon'] = 1;
        }
        $paramModel = new \Home\Model\hizhuparameter();
        $result = $paramModel->modelAddOwnerFee($data);
        if($result){
            $this->success('提交成功！',"portConfigureList.html?no=1&leftno=209");
        }else{
            $this->success('提交失败！',"portConfigureList.html?no=1&leftno=209");
        }
    }
    public function portConfigureDelete ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","messasge":"登录失效"}';return;
        }
        $data = I('get.');
        // $this->ajaxReturn($data);return;
        $paramModel = new \Home\Model\hizhuparameter();
        $result = $paramModel->modelModifyOwnerFee($data);
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //端口订单
    public function portOrderList ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"4");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"4");
        $handleMenu->jurisdiction();
        
        $paramModel = new \Home\Model\hizhuparameter();
    	$customerModel = new \Home\Model\customer();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $mobile = I('get.mobile');
        $order = I('get.order');
        $city = I('get.city_code');
        $where = $whereCustomer = $whereMobile = $data = $info =array();
        $where['order_status'] = 2; 
        $where['record_status'] = 1;
        if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($mobile != "") {
        	$fields = 'id';
        	$whereCustomer['mobile'] = $mobile;
        	$customerID = $customerModel->modelFindCustomer($fields,$whereCustomer);
        	if(!empty($customerID)) {
	            $where['customer_id']=array('eq',$customerID['id']);    		
        	}
        }
        if($order != "") {
            $where['id']=array('eq',$order);
        }
        if($city != "") {
            $where['city_code']=array('eq',$city);
        } else {
            $where['city_code']=C('CITY_CODE');
        }

        $fields = 'id,customer_id,create_time,city_code,price,pay_type,is_owner,create_man';
        $count = $paramModel->modelCountOwnerOrder($where);
        $Page = new \Think\Page($count,10);
        $data = $paramModel->modelGetOwnerOrder($Page->firstRow,$Page->listRows,$fields,$where);
        if(!empty($data)) {
	        foreach($data as $value) {
	        	$fields = 'mobile';
	        	$whereMobile['id'] = $value['customer_id']; 
	            $customerMobile = $customerModel->modelFindCustomer($fields,$whereMobile);
	            $value['mobile'] = $customerMobile['mobile'];
	            $info[] = $value; 
	        }
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
}
?>
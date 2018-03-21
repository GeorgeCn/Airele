<?php
namespace Home\Controller;
use Think\Controller;
class CashBackController extends Controller
{
	//返现管理
	public function cashBackList ()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
        $handleMenu->jurisdiction();
        $mobile = I('get.mobile');
        $roomNO = I('get.roomNO');
        $statusCode = I('get.status_code');
        $startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $where = array();
        if($mobile != "") {
            $where['mobile'] = array('eq',$mobile);
        }
        if($roomNO != "") {
            $where['room_no']=array('eq',$roomNO);
        }
        if($statusCode != "") {
            $where['status_code']=array('eq',$statusCode);
        } else {
            $where['status_code']=array('in','2,3');
        }
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
        $cashBackModel = new \Home\Model\cashback ();
        $cashBackLogic = new \Logic\CashBackLogic ();
        $count = $cashBackModel->modelCountCouponCash($where);
        $Page = new \Think\Page($count,10);
        $fields = 'id,customer_id,mobile,room_no,name,alipay_acc,price,create_time,status_code,id_card,memo,confirm_time,cashback_time';
        $data = $cashBackModel->modelGetCouponCash($Page->firstRow,$Page->listRows,$fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
	}
	//跳转更改订单状态
	public function cashBackOperation ()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"7");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"7");
        $data = I('get.');
        $cashBackLogic = new \Logic\CashBackLogic ();
        $info = $cashBackLogic->findCouponCash($data);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("list",$info);
        $this->display();
	}
	//更改用户礼券
	public function modifyCouponCash ()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $data = I('post.');//id,mobile,name,alipay_acc,status_code,coupon_id,id_card,memo
        $cashBackLogic = new \Logic\CashBackLogic ();
        $return = $cashBackLogic->updateCouponCash($data);
        if($return === false) {
        	$this->error("操作失败:参数错误","cashBackList.html?no=5&leftno=185"); 
        } else {
        	$cashBackLogic->updateCustomercoupon($data);
        	$cashBackLogic->updateCouponStatus($data);
        	$this->success("操作成功","cashBackList.html?no=5&leftno=185");
        }
	}
    //导出返现记录excel
    public function downloadCashBackExcel() 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
        }
        //查询条件
        $mobile = I('get.mobile');
        $roomNO = I('get.roomNO');
        $statusCode = I('get.status_code');
        $startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $where = $temp = array();
        if($mobile != "") {
            $where['mobile'] = array('eq',$mobile);
        }
        if($roomNO != "") {
            $where['room_no']=array('eq',$roomNO);
        }
        if($statusCode != "") {
            $where['status_code']=array('eq',$statusCode);
        } else {
            $where['status_code']=array('in','2,3');
        }
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
        $cashBackModel = new \Home\Model\cashback ();
        $cashBackLogic = new \Logic\CashBackLogic ();
        $fields = 'room_no,name,mobile,price,alipay_acc,cashback_time';
        $data = $cashBackModel->modelGetCouponCash(0,10000,$fields,$where);
        $title=array(
          'room_no'=>'房间编号','name'=>'租客姓名','mobile'=>'租客手机号','renter_man'=>'房东负责人','price'=>'返现金额','alipay_acc'=>'返现账号','cashback_time'=>'打款时间'
        );
        $excel[]=$title;
        foreach ($data as $key => $value) {
            $temp['room_no'] = $value['room_no'];
            $temp['name'] = $value['name'];
            $temp['mobile'] = $value['mobile'];
            $result = $cashBackLogic->findHouseroom($value['room_no']);
            $temp['renter_man'] = $result['principal_man'];
            $temp['price'] = $value['price'];
            $temp['alipay_acc'] = $value['alipay_acc'];
            $temp['cashback_time'] = $value['cashback_time'] > 0 ? date("Y-m-d H:i",$value['cashback_time']) : ""; 
            $excel[] = $temp;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '返现管理');
        $xls->addArray($excel);
        $xls->generateXML('返现管理'.date("YmdHis"));
    }
}
?>
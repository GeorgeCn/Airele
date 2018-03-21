<?php
namespace Home\Controller;
use Think\Controller;
class HousemoveController extends Controller{
	public function housemovelist()
	{
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"4");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"4");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['status']=isset($_GET['status'])?$_GET['status']:"";
        $condition['mobile']=isset($_GET['mobile'])?$_GET['mobile']:"";
        $handleLogic=new \Logic\HousemoveLogic();
        $totalCount =0;
        $list=array();
        $totalCount = $handleLogic->getModelListCount($condition);//总条数
        if($totalCount>=1){
	        $Page= new \Think\Page($totalCount,15);//分页
	        foreach($condition as $key=>$val) {
	            $Page->parameter[$key]=urlencode($val);
	        }
	        $this->assign("pageSHow",$Page->show());
        	$list = $handleLogic->getModelList($condition,$Page->firstRow,$Page->listRows);
        }else{
        	$this->assign("pageSHow","");
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
		$this->display();
	}
	#点击处理
	public function editmove(){
		if(!isset($_GET['id']) || empty($_GET['id'])){
			echo "参数错误";return;
		}
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"4");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"4");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);

		$handleLogic=new \Logic\HousemoveLogic();
		$order=$handleLogic->getOrderByNo($_GET['id']);
		if($order==null || $order==false){
			echo "操作失败";return;
		}
		//支付平台
		$handleOrders = new \Logic\Orders();
      	$paymanner=$handleOrders->payManner($_GET['id']);
      	$order['pay_platform']='';
      	if($paymanner!==null && $paymanner!==false){
      		$order['pay_platform']=$paymanner['pay_platform'];
      	}
		//logs
		$logs=$handleLogic->getLogsByOrderid($_GET['id']);
		$this->assign("logs",$logs);
		$this->assign("data",$order);
		$this->display();

	}
	#提交处理
	public function submitHandle(){
	    if(isset($_POST['status']) && isset($_POST['id']) && isset($_POST['result'])){
	        if(empty($_POST['status']) || empty($_POST['id']) || empty($_POST['result'])){
	            echo '{"status":"500","msg":"参数为空"}';return;
	        }else{
	        	$handleCommonCache=new \Logic\CommonCacheLogic();
	        	 if(!$handleCommonCache->checkcache()){
	        	    return $this->error('非法操作',U('Index/index'),1);
	        	 }
	            $handleLogic=new \Logic\HousemoveLogic();
	            $order=$handleLogic->getOrderByNo($_POST['id']);
	            if($order==null || $order==false){
	                echo '{"status":"400","msg":"订单读取失败"}';return;
	            }
	            $oper_name=getLoginName();
	            switch ($_POST['status']) {
	            	case '4':
	            		#成功
	            		if($order['order_status']!='3'){
	            			echo '{"status":"400","msg":"操作失败，不能做此状态处理"}';return;
	            		}
	            		$result=$handleLogic->examSuccess($order['id'],$_POST['result'],$oper_name);
	            		if(!$result){
	            			echo '{"status":"400","msg":"操作失败"}';return;
	            		}
	            		echo '{"status":"200","msg":"操作成功"}';
	            		break;
	            	case '6':
	            		#失败
	            		if($order['order_status']!='2' && $order['order_status']!='3'){
	            			echo '{"status":"400","msg":"操作失败，不能做此状态处理"}';return;
	            		}
	            		$result=$handleLogic->examFail($order['id'],$_POST['result'],$oper_name);
	            		if(!$result){
	            			echo '{"status":"400","msg":"操作失败"}';return;
	            		}
	            		echo '{"status":"200","msg":"操作成功"}';
	            		break;
	            	case '7':
	            		#已退款
	            		if($order['order_status']!='6'){
	            			echo '{"status":"400","msg":"操作失败，不能做此状态处理"}';return;
	            		}
	            		$result=$handleLogic->refundSuccess($order['id'],$oper_name);
	            		if(!$result){
	            			echo '{"status":"400","msg":"操作失败"}';return;
	            		}
	            		echo '{"status":"200","msg":"操作成功"}';
	            		break;
	            	default:
	            		echo '{"status":"500","msg":"操作失败"}';
	            		break;
	            }
	        }
	    }else{
	    	echo '{"status":"500","msg":"参数未声明"}';
	    }
	}

	//房屋改造 列表
	public function housereformlist(){
		$handle=new \Home\Model\activityhousemove();
		$list=$handle->getHouseReformList(' and order_status>=2',0,100);
        $this->assign("list",$list);
		$this->display();
	}
}

?>	
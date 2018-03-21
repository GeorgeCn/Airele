<?php 
namespace Home\Controller;
use Think\Controller;
class OrdersController extends HomeController {
    public function index(){
    	$list = $_POST;
     	$this->assign('orders',$list);
        $this->display('Orders/index');
    }

    public function successs(){

    	// uuid  订单编号 
		$chars = md5(uniqid(mt_rand(), true));  
	    $uuid  = substr($chars,0,8) . '-';  
	    $uuid .= substr($chars,8,4) . '-';  
	    $uuid .= substr($chars,12,4) . '-';  
	    $uuid .= substr($chars,16,4) . '-';  
	    $uuid .= substr($chars,20,12);

	    $list = $_POST;

	    // var_dump($list);
	    // exit;
	    $data['gid'] = $list['gid'];
		$data['uid'] = $list['uid'];
		$data['photo'] = $list['photo'];
		$data['amount'] = $list['amount'];
		$data['persons'] = $list['persons'];
		$data['orderNum'] = $uuid;
		$data['time'] = time();
		$data['address'] = $list['address'];
		$data['phone'] = $list['phone'];
		$up['up'] = 1;
		$gid = $list['gid'];

		// var_dump($data);

		// exit;
		$model = M('orders');
		$model->add($data);
		$orders = $model->where(array('orderNum'=>$uuid))->select();
		// $goods = M('goods');
		// $status = $goods->where(array('id'=>$gid))->save($up);
		// dump($model->getLastSql());
		// exit;
		$this->assign('orders',$orders);
		// $this->success('上传成功！',U('Header/upload'));
     	// $this->assign('orders','$orders');
        $this->display('Orders/zhifu');
    }

    public function zhifu(){
     	// $this->assign('title','LOGIN');

     	$list = $_POST;
     	// dump($list);
     	// exit;
     	$data['isPay'] = 2;
     	$uuid = $list['uuid'];
     	$gid = $list['gid'];
     	$up['up'] = 1;
     	// dump($uuid);
     	$list = M('orders');
     	$goods = M('goods');
     	$status = $goods->where(array('id'=>$gid,'up'=>0))->count();
     	if($status == 0){
     		$this->error("支付失败,此房已被其他房客预定");
     		exit;
     	}
     	$orders = $list->where(array('orderNum'=>$uuid))->save($data);
     	$gstatus = $goods->where(array('id'=>$gid))->save($up);
     	// dump($list->getLastSql());
     	// dump($orders);
     	// exit;
     	if($orders){
     		// echo 1;
				$this->success('支付成功！正在前往个人中心!',U('PersonOrders/index'));
			}else{
			// echo 2;
				$this->error("支付失败");
			}
     	// $data = M('orders')->;
     	// $data->create();
     	// $data->isPay = 2;
     	// $data->
     	
        // $this->display('Orders/zhifu');
    }
}
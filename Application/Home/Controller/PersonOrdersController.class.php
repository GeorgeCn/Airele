<?php 
namespace Home\Controller;
use Think\Controller;
class PersonOrdersController extends HomeController 
{
	//我的订单
    public function index()
    {

    	// 查询订单数据
    	$id = $_SESSION['user']['id'];
    	$model= M('orders');

		$list = $model 
		->table("orders o,goodsimg i") 
		->field("o.*,i.filename1") 
		->where("o.uid={$id} and o.gid =i.gid") 
		->order("o.time desc")
		->select();
		
		//判断是否有订单
		if (empty($list)) 
			{
				$this->error('去逛逛吧',U("Index/index"));
			}	
			//分配变量
			$this->assign("list",$list);
        	$this->display('PersonOrders/index');
    }

    //支付
	 public function pay()
    {	
		$id = $_GET['id'];
		$model= M('orders');
    	//判断房子的状态,是否下架
		$list = $model 
		->table("orders o,goods g") 
		->field("o.*,g.up") 
		->where("o.id={$id} and o.gid =g.id") 
		->select();
		$gid=$list['0']['gid'];
		//判断订单中房源是否下架
		if ($list['0']['up'] == '1') 
		{
			$this->error("亲,您下手慢了,房子被租出去了,再去逛逛吧");
			exit;
		}
		
		$data1['isPay'] = '2';
		$ls1 = M('orders')->where("id={$id}")->save($data1);
		$data2['up'] = '1';
		$ls2 = M('goods')->where("id={$gid}")->save($data2);

		if ($ls1 > 0 && $ls2 > 0) {
			
			$this->success('支付成功',U("PersonOrders/index"));
			exit;
		}
		
		$this->error("支付失败");
		
		
	}
	//确认住宿
	 public function stay()
    {	
		//默认支付成功
		$id = $_GET['id'];
		$data['status'] = '3';
		$model= M('orders');
		$model
		->where('id='.$id)
		->save($data);
		$this->success('入住成功',U("PersonOrders/index"));
		
	}
	//退房
	 public function out()
    {	
		$id = $_GET['id'];
		$data['status'] = '4';
		$model= M('orders');
		$model
		->where('id='.$id)
		->save($data);
		// 改变订单状态

		$model= M('orders');
		$ls['up'] = 0;
		$list = $model 
		->table("orders o,goods g") 
		->field("g.up") 
		->where("o.id={$id} and o.gid =g.id") 
		->save($ls);

		$this->success('退房成功',U("PersonOrders/index"));
		
	}
	
	// 加载评论
	public function comment()
	{
		$a = $_GET['id'];
		// V($a);die;
		$data = M('orders')
				->table("orders o,goodsimg i,goods g") 
				->field("o.*,i.filename1,g.name") 
				->where("o.id = $a and o.gid = i.gid and g.id  = o.gid") 
				->find();
        // V($data);die;
        // 向模板分配数据
        $this->assign('vo', $data);
        $this->display('PersonOrders/comment');
	}
	// 向数据库添加评论
	public function doadd()
	{
		$data['id'] = $_GET['id'];
		$data['uid'] = $_GET['uid'];
		$data['gid'] = $_GET['gid'];
		$data['desc'] = $_GET['desc'];
		// V($data);
		// die;
		if (M('comment')->add($data) > 0) {
			$this->success('评论成功',U('Comment/index'));
		} else {
			$this->error("小real也不知道怎么了,请再提交一次吧");
		}
		
	}
	//投诉
	public function complain ()
	{
		if (M('complain')->add($_GET)) {
            $this->success('投诉成功',U('index'));
        } else {
            $this->error('添加失败',U('index'));
        } 
	}

}
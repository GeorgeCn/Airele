<?php 
	namespace Admin\Controller;
	
	//用户管理 控制器
	class OrdersController extends AdminController{

		private $_order = null; //数据库操作类
		private $_user = null; //用户表操作类

		//初始化操作
		public function _initialize(){
			parent::_initialize();
			$this->_order = D('orders');
			$this->_user = D('User');
			$this->_goods = D('Goods');
		}


		//列表详情
		public function index(){
			//查询数据
			$model = $this->_order;
			$list = $model 
			->table("orders o,goods g,yonghu y") 
			->field("o.*,g.name,y.nickname,g.address") 
			->where("o.uid=y.id and o.gid =g.id") 
			->select();
			
			// var_dump($list);exit;
			//分配变量
			$this->assign("list",$list);
			
			//加载模板
			$this->display();
		}

	
		//加载修改页面
		public function details(){
			//查出数据
			$vo = $this->_order->where(array('id'=>array('eq',I('id'))))->find();
			$id = $_GET['id'];
			$model = $this->_order;
			$ls = $model 
			->table("orders o,goods g,yonghu y") 
			->field("o.*,g.name,y.nickname,g.address,g.price,g.desc,g.beds,g.toilets,g.time,y.tel") 
			->where("o.uid=y.id and o.gid =g.id and o.id={$id} ") 
			->select();
			//向模板分配数据
			$list = $ls[0];
			// dump($list);exit;
			

			$this->assign('list',$list);
			//加载模板
			$this->display();
		}
		public function deal()
		{
			$model = $this->_order;
			$list = $model 
			->table("orders o,goods g,yonghu y") 
			->field("o.*,g.name,y.nickname,g.address") 
			->where("o.uid=y.id and o.gid =g.id and o.status= 1 and o.ispay= 2 and cancel=1") 
			->count();

			if($list==0){
				$p = 'a';
				// $this->assign("list",$list);
				$this->assign("a",$p);
				$this->display();

			}else{
				$ls = $model 
				->table("orders o,goods g,yonghu y") 
				->field("o.*,g.name,y.nickname,g.address") 
				->where("o.uid=y.id and o.gid =g.id and o.status= 1 and o.ispay= 2 and cancel=1") 
				->select();
				$p = 'b';
				$this->assign("a",$p);
				$this->assign("list",$ls);
				$this->display();
			}
			
		}
		 public function confirm()
	    {	
			$id = $_GET['id'];
			$model= M('orders');
			//线确认是否支付成功
			$ls=$model
			->where("id={$id} ")
			->select();
			if($ls[0]['ispay'] == 1)
			{
				$this->error("用户还未支付！");	
				exit;
			}

			$data['status'] = '2';
			$model
			->where('id='.$id)
			->save($data);
			$this->success('订单确定',U("Orders/deal"));
			
		}

		public function stay()
		{
			$model = $this->_order;
			$list = $model 
			->table("orders o,goods g,yonghu y") 
			->field("o.*,g.name,y.nickname,g.address") 
			->where("o.uid=y.id and o.gid =g.id and o.status= 2 and o.ispay= 2 and cancel=1") 
			->count();

			if($list==0){
				$p = 'a';
				// $this->assign("list",$list);
				$this->assign("a",$p);
				$this->display();

			}else{
				$ls = $model 
				->table("orders o,goods g,yonghu y") 
				->field("o.*,g.name,y.nickname,g.address") 
				->where("o.uid=y.id and o.gid =g.id  and o.ispay= 2 and o.status= 2 and cancel=1") 
				->select();
				$p = 'b';
				$this->assign("a",$p);
				$this->assign("list",$ls);
				$this->display();
			}
			
		}
		 public function dostay()
	    {	
			$id = $_GET['id'];
			$model= M('orders');
			//线确认是否支付成功
			$ls=$model
			->where("id={$id} ")
			->select();
			if($ls[0]['ispay'] == 1)
			{
				$this->error("用户还未支付！");	
				exit;
			}

			$data['status'] = '3';
			$model
			->where('id='.$id)
			->save($data);
			$this->success('入住成功',U("Orders/stay"));
			
		}
		public function cancle()
	    {	
			$id = $_GET['id'];
			$model= M('orders');
			//线确认是否支付成功
			$ls=$model
			->where("id={$id} ")
			->select();

			$gid = $ls[0]['gid']; 			

			$data1['cancel'] = '2';
			$list1=$model
			->where('id='.$id)
			->save($data1);


			$model1= M('goods');
			$ls['up'] = 0;
			$list2 = $model1 
			->where("id={$gid}") 
			->save($ls);
			
			if ($list1 > 0 && $list2 > 0) 
			{
				$this->success('订单取消成功',U("Orders/stay"));
				
			}else
			{
				$this->error('订单取消失败',U("Orders/stay"));
			}
			
		}


		public function out()
		{
			$model = $this->_order;
			$list = $model 
			->table("orders o,goods g,yonghu y") 
			->field("o.*,g.name,y.nickname,g.address") 
			->where("o.uid=y.id and o.gid =g.id and o.status= 3 and o.ispay= 2 and cancel=1") 
			->count();

			if($list==0){
				$p = 'a';
				// $this->assign("list",$list);
				$this->assign("a",$p);
				$this->display();

			}else{
				$ls = $model 
				->table("orders o,goods g,yonghu y") 
				->field("o.*,g.name,y.nickname,g.address") 
				->where("o.uid=y.id and o.gid =g.id  and o.ispay= 2 and o.status= 3 ") 
				->select();
				$p = 'b';
				$this->assign("a",$p);
				$this->assign("list",$ls);
				$this->display();
			}
			
		}
		 public function checkout()
	    {	
			$id = $_GET['id'];
			$model= M('orders');
			//线确认是否支付成功
			$ls=$model
			->where("id={$id} ")
			->select();
			if($ls[0]['ispay'] == 1)
			{
				$this->error("用户还未支付！");	
			}

			$data['status'] = '4';
			$model
			->where('id='.$id)
			->save($data);
			$this->success('退房成功',U("Orders/deal"));
			
		}

}
		



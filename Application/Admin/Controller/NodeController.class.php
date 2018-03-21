<?php 
	namespace Admin\Controller;
	
	class NodeController extends AdminController{
		private $_model = null; //数据库操作类

		//初始化操作
		public function _initialize(){
			parent::_initialize();
			$this->_model = D('Node');
		}

		//列表详情
		public function index(){
			$node = $this->_model;//实例化node对象
	        $count = $node->count();//查询满足条件的总记录数
	        // V($count);die;
	        $Page = new \Think\Page($count,10);//实例化分页类 传入总数和每页显示数
	        // V($Page);die;
	        // 定制分页样式
	        $Page->setConfig('header','<span class="total">共<b>%TOTAL_ROW%</b>条数据，第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
	        $Page->setConfig('prev','上一页');
	        $Page->setConfig('next','下一页');
	        $Page->setConfig('last','末页');
	        $Page->setConfig('first','首页');
	        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	        $show = $Page->show();//分页显示输出
	        // V($show);die;
	        // 进行分页数据查询 limit方法的参数要使用page类的属性
	        $list = $node
	                ->order('id')
	                ->limit($Page->firstRow.','.$Page->listRows)
	                ->select();
	        // V($list);exit;
	        $this->assign('list', $list);//赋值数据集
	        $this->assign('page',$show);//赋值分页输出
	        $this->display('Node/index');//输出模板

		}

		//执行添加操作
		public function doadd(){

			if(!$this->_model->create()){
				$this->error($this->_model->getError());
				exit;
			}

			if($this->_model->add() > 0){
				$this->success("添加成功！",U('Node/index'));
			}else{
				$this->error("添加失败！");
			}
		}


		//删除操作
		public function del()
		{
			$this->_role_node = M('role_node');
			if($this->_model->delete($_GET['id']) > 0 )
			{
				if ($this->_role_node->where(array('nid'=>array('eq',$_GET['id'])))->delete() >=0) 
				{
				
					$this->success("删除成功！",U('Node/index'));
					exit;
				}
				$this->error("删除失败");
				exit;
			}else
			{
				$this->error("删除失败");
				exit;
			}
		}

		//加载修改页面c 
		public function edit(){
			//查出数据
			$vo = $this->_model->where(array('id'=>array('eq',I('id'))))->find();
			//向模板分配数据
			$this->assign('vo',$vo);
			//加载模板
			$this->display();
		}

		//执行修改操作
		public function save(){
			//初始化
			if(!$this->_model->create()){
				$this->error($this->_model->getError());
				exit;
			}
			//执行修改 
			if($this->_model->save() >= 0){
				$this->success("修改成功！",U('Node/index'));
			}else{
				$this->error("修改失败");
			}
		}

		
	}

 ?>
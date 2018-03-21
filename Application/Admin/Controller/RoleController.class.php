<?php 
namespace Admin\Controller;

class RoleController extends AdminController{
	private $_model = null; //数据库操作类
	private $_node = null; //节点表数据库对象
	private $_role_node = null; //角色——权限表数据库对象
	private $_user_role = null; //用户--角色表数据库对象

	//初始化操作
	public function _initialize(){
		parent::_initialize();
		$this->_model = D('Role');
		$this->_node = D('Node');
		$this->_role_node = D("role_node");
		$this->_user_role = D("user_role");
	}

	//列表详情
	public function index(){
		//查询数据
		$list = $this->_model->select();

		$arr = array();
		//遍历添加上 权限信息
		foreach($list as $v){
			$nodes = $this->_role_node->where(array('rid'=>array('eq',$v['id'])))->select();
			$node = array();
			foreach($nodes as $value){
				$node[] = $this->_node->where(array('id'=>array('eq',$value['nid'])))->getField('name');
			}
			$v['node'] = $node;
			$arr[] = $v;
		}

	
		//分配变量
		$this->assign("list",$arr);
		//加载模板
		$this->display();                                
	}

	//执行添加操作
	public function doadd(){

		if(!$this->_model->create()){
			$this->error($this->_model->getError());
			exit;
		}

		if($this->_model->add() > 0){
			$this->success("添加成功！",U('Role/index'));
		}else{
			$this->error("添加失败！");
		}
	}


	//删除操作
	public function del(){
		if($this->_model->where(array('id'=>array('eq',$_GET['id'])))->delete() > 0 && $this->_user_role->where(array('rid'=>array('eq',$_GET['id'])))->delete() >=0 && $this->_role_node->where(array('rid'=>array('eq',$_GET['id'])))->delete()>=0){
			$this->success("删除成功！",U('Role/index'));
		}else{
			$this->error("删除失败");
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
			$this->success("修改成功！",U('Role/index'));
		}else{
			$this->error("修改失败");
		}
	}


	//为角色分配权限
	public function rolelist(){
		//查找该角色信息
		$role = $this->_model->where(array('id'=>array('eq',I('id'))))->find();
		//查找所有的节点
		$nodes = $this->_node->select();

		//获取该角色的权限
		$ro_node = $this->_role_node->where(array('rid'=>array('eq',$role['id'])))->select();
		$ro_nodes = array();
		//遍历重组数组
		foreach($ro_node as $v){
			$ro_nodes[] = $v['nid'];
		}

		
		

		//向模板分配该用户拥有的权限信息
		$this->assign('ro_nodes',$ro_nodes);
		//向模板分配节点信息
		$this->assign('nodes',$nodes);
		//向模板分配角色信息ec\\
		$this->assign('role',$role);

		//加载模板
		$this->display();


	}


	//为角色添加权限
	public function savenode(){
		if(empty($_POST['node'])){
			$this->error("必须选择一个节点！");
		}

		$rid = $_POST['rid'];

		//删除该 角色的 所有信息--避免重复添加
		$this->_role_node->where(array('rid'=>array('eq',$rid)))->delete();

		//循环添加
		foreach($_POST['node'] as $v){
			$data['nid'] = $v;
			$data['rid'] = $rid;
			//执行添加
			$this->_role_node->data($data)->add();
		}

		$this->success("添加成功！",U('Role/index'));
	}
} 
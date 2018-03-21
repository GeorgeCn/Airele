<?php 
	namespace Admin\Model;
	use Think\Model;
	class NodeModel extends Model{
		//自动验证
		protected $_validate = array(
		  array('name','require','节点名不能为空'), //新增或修改时判断username格式
		  array('mname','require','控制器名不能为空'), //新增或修改时判断username格式
		  array('aname','require','操作名不能为空'), //新增或修改时判断username格
		);
	}
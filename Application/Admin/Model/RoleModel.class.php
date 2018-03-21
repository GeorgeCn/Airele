<?php 
	namespace Admin\Model;
	use Think\Model;
	class RoleModel extends Model{
		//自动验证
		protected $_validate = array(
		  array('name','require','角色名不能为空'), //新增或修改时判断username格式
		  array('name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一

		  array('remark','require','角色说明不能为空'), //新增或修改时判断username格式
		);
	}
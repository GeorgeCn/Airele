<?php 
	namespace Admin\Model;
	use Think\Model;
	class UserModel extends Model{
		//自动完成
		protected $_auto = array ( 
		    array('userpass','md5',1,'function'), 
		    array('userpass','',2,'ignore'), 
		);

		//自动验证
		protected $_validate = array(
		  array('username','require','用户名不能为空',0,'regex',1), 
		  array('username','','帐号名称已经存在！',0,'unique',1), 

		  array('name','require','真实姓名不能为空'), 
		  array('userpass','/^\w{6,12}$/','密码必须是6-12位的shuzi、字母、下划线',0,'regex',1), 
		  array('reuserpass','userpass','确认密码不正确',0,'confirm',1), // 验证确认密码是否和密码一致
		);
	}
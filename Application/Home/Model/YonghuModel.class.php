<?php 
	namespace Home\Model;
	use Think\Model;
	class YonghuModel extends Model{
		//自动完成
		protected $_auto = array ( 
		    array('pwd','md5',1,'function'),  
		);

		//自动验证
		protected $_validate = array(
		  array('nickname','require','用户名不能为空',0,'regex',1), 
		  array('tel','require','手机号不能为空',0,'regex',1), 
		   // /^1[34578]\d{9}/

		  array('tel','','手机号已经存在！',0,'unique',1), 
		  array('tel','/^1[34578]\d{9}/','请输入正确手机号',0,'regex',1),

		  // array('name','require','真实姓名不能为空'), 
		  array('pwd','/^\w{6,12}$/','密码必须是6-12位的数字、字母、下划线',0,'regex',1), 

		  array('repwd','pwd','确认密码不正确',0,'confirm',1), // 验证确认密码是否和密码一致
		);
	}
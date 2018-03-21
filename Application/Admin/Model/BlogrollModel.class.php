<?php 
namespace Admin\Model;
use Think\Model;

class BlogrollModel extends Model
{
	//自动完成
	protected $_auto = array ( 
		
	);

	/*自动验证
	array(
		array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		array(验证字段2,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		...
	)*/
	protected $_validate = array(
	    array('name','require','网址名称不能为空',0,'regex',1), 
	    array('name','','该网址名称已经存在！',0,'unique',1), //在新增的时候验证name字段是否唯一
	    array('italic','require','网址不能为空',0,'regex',1), 
	    array('italic','','该网址已经存在！',0,'unique',1), 
	    array('italic','/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/','请您输入正确的URL网址格式',0,'regex',1), 
	    array('email','/^[A-Za-zd]+([-_.][A-Za-zd]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/','请您输入正确的邮箱格式',2,'regex',1),

	);


	
}
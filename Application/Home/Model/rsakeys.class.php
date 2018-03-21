<?php
//在模型里单独设置数据库连接信息
namespace Home\Model;
use Think\Model;
class rsakeys {

	const connection_data = 'DB_DATA';
	public function getModel($plat)
	{
		$Model=M('rsakeys','',self::connection_data);
		$condition['platform'] = $plat;
		$content = $Model->where($condition)->find();
		return $content;
	}

	
}

?>
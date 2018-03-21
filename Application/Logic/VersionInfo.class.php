<?php
namespace Logic;
use Think\Controller;
class VersionInfo extends Controller
{
	//提交信息验证判断
	public function infoJudge ()
	{
		$data = I('post.');
		foreach($data as $val) {
			if($val == "") {
				$this->error("信息填写不完整",'versioninfolist.html',1);
				return ;
			}
		}
	}
	//修改信息判断
	public function typeJudge($id,$type) 
	{
		$where['id'] = $id;
			if($type == 0) {
				$ModelTable = M("clientupdateinfo");
				$result = $ModelTable->field('create_time,create_man',true)->where($where)->find();
				$this->assign('type',0);
				$this->assign('list',$result);
			} elseif($type == 2) {
				$ModelTable = M("clientupdateinfo");
				$result = $ModelTable->field('create_time,create_man',true)->where($where)->find();
				$this->assign('type',2);
				$this->assign('list',$result);
			} else {
 				$where['id'] = $id;
				$ModelTable = M("clientupdateinfo",'',DB_STORE);
				$result = $ModelTable->field('create_time,create_man',true)->where($where)->find();
				$this->assign('type',1);
				$this->assign('list',$result);
			}	
	}
}
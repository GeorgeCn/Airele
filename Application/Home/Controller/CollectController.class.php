<?php 
namespace Home\Controller;
use Think\Controller;
class CollectController extends HomeController 
{
    public function index()
    {
     	
     	$id = $_SESSION['user']['id'];
     	$model = M('collect');
     	$list = $model
     	->table("goods g,collect c")
     	->field("g.*,c.gid,c.uid")
     	->where("g.id=gid and uid=".$id)
     	->select();

        //判断是否有收藏
		if (empty($list)) 
			{
				$this->error('您还没有收藏,去逛逛吧',U("index/index"));
			}	
			//分配变量
			$this->assign("list",$list);
        	$this->display('Collect/index');
    }
    public function doadd()
    {
        $gid = $_GET['gid'];
        $uid = $_GET['uid'];
        if ($uid == 0) {
            $this->error("你没有登录",U("Public/login"));
        }
        $model= M('collect');
        $num=$model
        ->where('uid='.$uid.' and gid='.$gid)
        ->field("collect.*")
        ->count();

        if ($num >= 0) 
        {
            $this->error("你已经收藏过了");
        }
        

        $data['gid'] = $gid;
        $data['uid'] = $uid;

        $model
        ->where('gid='.$id)
        ->save($data);
        $this->success('收藏成功');
        
    }
    public function del()
    {
        $gid = $_GET['id'];
        $uid = $_SESSION['user']['id'];
        if ($uid == 0) {
            $this->error("你没有登录",U("Public/login"));
        }
        $model= M('collect');
        $num=$model
        ->where('uid='.$uid.' and gid='.$gid)
        ->field("collect.*")
        ->delete();
        if ($num > 0) 
        {
            $this->success('删除成功');
            exit;
        }
        
    }
}
<?php 
namespace Home\Controller;

use \Think\Controller;

class DisplayController extends Controller
{
	public function index()
	{
		$id = $_GET['id'];
		$gid = $_GET['id'];
		$data = M('goodsimg')->field('filename3')->where(array('gid'=>$gid))->select();
		foreach($data as $vo) {
			foreach($vo as $v) {
				$file[] = $v;
			}		
		}
		$info = M('goods')->field('type,price,persons,beds,toilets,desc,address,months,province,city')->where(array('id'=>$id))->select();
		$result = M('category');
		$map['id'] = array(array('eq',$info[0]['province']),array('eq',$info[0]['city']),'or');
		$area = $result->field('name')->where($map)->select();
		$field = $area[0]['name'].$area[1]['name'].$info[0]['address'];
		$info[0]['field'] = $field;
		$maps['face'] = array('eq',0);
		$icon = M('goodsimg')->field('filename1')->where($maps)->limit(4)->select();
		foreach($icon as $vo) {
			foreach($vo as $v) {
				$files[] = $v;
			}		
		}

		//拿评论的内容
		$com = M('comment');
		$c = $com
		->table('__COMMENT__ c ,__YONGHU__ y')
		->field('c.*,y.nickname')
		->where('c.gid ='.$gid.' and y.id = c.uid')
		->select();

		//拿点赞内容
		$dian = M('like');
		$v = $dian
		->table('__LIKE__')
		->where('gid = '.$gid)
		->count();
		if ($c > 0) {
			$d = $dian
			->table('__LIKE__')
			->where('gid = '.$gid)
			->select();
			$this->assign('d',$d);
		}
		// var_dump($d);
		// var_dump($c);
		// var_dump($file);
		// var_dump($files);
		// var_dump($info[0]);
		// var_dump($id);
		$this->assign('c',$c);
		$this->assign('file',$file);
		$this->assign('files',$files);
		$this->assign('info',$info[0]);
		$this->assign('id',$id);
		$this->display('index');
	}

}
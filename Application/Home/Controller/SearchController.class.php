<?php 
	namespace Home\Controller;
	use Think\Controller;
	//用户管理 控制器
	class SearchController extends Controller{

 		public function address ()
    	{
    		$maps['face'] = array('eq',0);
			$icon = M('goodsimg')->field('filename1')->where($maps)->limit(4)->select();
			foreach($icon as $vo) {
				foreach($vo as $v) {
				$file[] = $v;
				}		
			}
			$this->assign('file',$file);
	        //接收查询条件
	        $pid = empty($_GET['pid'])?0:$_GET['pid'];
	        //查询
	        $data = M('category')->where('pid='.$pid)->select();
	        //将结果返回
	        $this->ajaxReturn($data);

    	}

    	public function search(){
    		$maps['face'] = array('eq',0);
			$icon = M('goodsimg')->field('filename1')->where($maps)->limit(4)->select();
			foreach($icon as $vo) {
				foreach($vo as $v) {
				$file[] = $v;
				}		
			}
			$this->assign('file',$file);
    		$list = $_POST;
    		// dump($list);
			$province = $_POST['province'];
			$city = $_POST['city'];
			$bed = $_POST['bed'];
			$model = M('goods');
 			$ss = $model
			->table('__GOODS__ g, __GOODSIMG__ m')
			->field('g.*,m.filename3,m.gid')
			->where('g.up=0 and g.beds='.$bed.' and g.id=m.gid and g.province='.$province.' and g.city='.$city)
			->count();
			// dump($list);
			//如果查不到数据

			if ($ss == 0) {
				$model = M('goods');
     		// 	$goods = $model
    			// ->table('__GOODS__ g, __GOODSIMG__ m')
    			// ->field('g.*,m.filename3,m.gid')
    			// ->where('g.up=0 and g.id=m.gid ')
    			// ->select();
    			$count = $model
    			->table('__GOODS__ g, __GOODSIMG__ m')
    			->field('g.*,m.filename3,m.gid')
    			->where('g.up=0 and g.id=m.gid ')
    			->select();
    			$title = '未找到符合条件的房源,已为你查找其他房源';
				$this->assign('list',$count);// 赋值数据集
				$this->assign('title',$title);
				// $this->assign('page',$show);// 赋值分页输出
				// $this->display(); // 输出模板
    			// $this->assign('list',$list);
    			// dump($show);
    			// dump($list);
    			$this->display('Goods/index');
			}else{
				$list = $_POST;
	    		// dump($list);
				$province = $_POST['province'];
				$city = $_POST['city'];
				$bed = $_POST['bed'];
				$model = M('goods');
	 			$count = $model
				->table('__GOODS__ g, __GOODSIMG__ m')
				->field('g.*,m.filename3,m.gid')
				->where('g.up=0 and g.beds='.$bed.' and g.id=m.gid and g.province='.$province.' and g.city='.$city)
				->select();
				

				// $Page = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数
    			// $show = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				// $list = $model
				// ->table('__GOODS__ g, __GOODSIMG__ m')
				// ->field('g.*,m.filename3,m.gid')
				// ->where('g.up=0 and g.beds='.$bed.' and g.id=m.gid and g.province='.$province.' and g.city='.$city)
    // 			->limit($Page->firstRow.','.$Page->listRows)
    // 			->select();
				$this->assign('list',$count);// 赋值数据集
				// $this->assign('page',$show);// 赋值分页输出
				// $this->display(); // 输出模板
    			// $this->assign('list',$list);
    			// dump($show);
    			// dump($list);
    			$this->display('Goods/index');
			}


    	}

    	public function type() {
    		$maps['face'] = array('eq',0);
			$icon = M('goodsimg')->field('filename1')->where($maps)->limit(4)->select();
			foreach($icon as $vo) {
				foreach($vo as $v) {
				$file[] = $v;
				}		
			}
			$this->assign('file',$file);
    		$province = $_GET['id'];
    		// dump($province);
    		$model = M('goods');
    		$ss = $model
			->table('__GOODS__ g, __GOODSIMG__ m')
			->field('g.*,m.filename3,m.gid')
			->where('g.up=0 and g.id=m.gid and g.province='.$province)
			->select();
			// dump($ss);
			$this->assign('list',$ss);
			$this->display('Goods/index');

    	}

    
}
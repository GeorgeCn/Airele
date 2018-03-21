<?php
namespace Admin\Controller;


class HeaderController extends AdminController {
    
    public function index(){
       	$list = M('himages')->select();
    	$this->assign("list",$list);
    	$this->display();
    }

    //跳转到添加图片页面
	public function upload()
	{
		$this->display();
	}


    //添加图片
	public function doupload()
	{
        $upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 3145728 ;// 设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
		$upload->saveName = array('uniqid','');
		$upload->savePath = ''; // 设置附件上传（子）目录
		// 上传文件
		$info = $upload->upload();
		// dump($info);
		// exit;
		if(!$info) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			
			$list = $_POST;
			// dump($info);
			// dump($list);
			// exit;
			
			$model = M('himages');
			// dump($model);
			// exit;
			// 保存当前数据对象
			$data['name'] = $list['name'];
			// $data['pid'] = $list['pid'];
			// $data['uid'] = $list['uid'];
			// $data['content'] = $list['content'];
			// $data['create_time'] = NOW_TIME;
			$data['image'] = $info['image']['savepath'].$info['image']['savename'];
			// dump($data);
			// exit;
			$model->add($data);
			$this->success('上传成功！',U('Header/upload'));
		}	


    }
    
    public function del()
    {
        //判断有无参数ID
        if (empty($_GET['id'])) {
            $this->error('删除失败!',U('index'));
            exit;
        }
        //接收ID
        // $id = $_GET['id'];
        $id = I('get.id/d');//I()方法 过滤输入的数据
        // echo $id;
        // exit;
        //判断图片是否是最后一张
        $list = M('himages')->select();

        //执行操作 
        if (M('himages')->delete($id) > 0) {
            $this->success('恭喜您!删除成功!',U('index'));
        } else {
            $this->error('删除失败!',U('index'));
        }
    }

    //加载修改页面
	public function edit(){
		//查出数据
		// echo $id=I('id');
		$vo = M('himages')->where(array('id'=>array('eq',I('id'))))->find();
		//向模板分配数据

		// echo M()->getLastSql();
		// exit;
		$this->assign('vo',$vo);
		//加载模板
		$this->display();
	}

	//执行修改操作
	public function save(){
		
		//初始化
		if(!M('himages')->create()){
			$this->error($M('himages')->getError());
			exit;
		}
		//执行修改 
		if(M('himages')->save() >= 0){
			$this->success("修改成功！",U('Header/index'));
		}else{
			$this->error("修改失败");
		}
	}

	//执行状态修改操作
	public function ssave(){

		//如果上架数量小于2张则禁止修改
		$count = M('himages')->where(array('status'=>array('eq','1')))->count();
		// echo $count;
		// exit;
		//如果上架图片少于2张不允许下架
		if ($count == 2) {
			$status = 1;
			$data['status'] = $status;
			if(M('himages')->where(array('id'=>array('eq',I('id'))))->save($data) >= 0){
				$this->redirect('Header/index');
			}else{
				$this->error("修改失败");
			}
		}
		if ($count < 3 ){
			$this->error('修改失败!上架图片不能少于2张!');
		}

		// $vo = M('himages')->where(array('id'=>array('eq',I('id'))))->find();

		$status = I('status');
		if($status == 0){
			$status = 1;
		}else{
			$status = 0;
		} 
		// echo M()->getLastSql();
		// echo $status;
		// exit;
		//执行修改 
		$data['status'] = $status;
		if(M('himages')->where(array('id'=>array('eq',I('id'))))->save($data) >= 0){
			$this->redirect('Header/index');
		}else{
			$this->error("修改失败");
		}
	}

	//删除操作
	public function delete(){

		$count = M('himages')->count();
		// echo $count;
		// exit;
		//如果图片少于2张不允许删除
		if ($count <= 2 ){
			$this->error('删除失败!图片不能少于2张!');
		}
		//把用户角色表中相关的也删除
		if(M('himages')->where(array('id'=>array('eq',I('id'))))->delete() > 0 ){
			$this->success("删除成功！",U('Header/index'));
		}else{
			$this->error("删除失败");
		}
	}

}
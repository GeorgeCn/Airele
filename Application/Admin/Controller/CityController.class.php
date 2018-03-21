<?php
namespace Admin\Controller;


class CityController extends AdminController {

	public function index(){
		$list = M('cimages')->select();
    	$this->assign("list",$list);
    	$this->display();
	}

	public function edit(){
		$vo = M('cimages')->where(array('id'=>array('eq',I('id'))))->find();
		$list = M('category')->where('pid = 0')->select();
    	$this->assign("list",$list);
    	$this->assign('data',$vo);
    	$this->display();
	}

	//执行修改操作
	public function csave(){
		$image = $_FILES;
		$list = $_POST;
		$id = $list['cid'];
		$city = M('category')->where(array('id'=>array('eq',I('post.cid'))))->find();
		$cimage = M('cimages')->where(array('id'=>array('eq',I('post.id'))))->find();
		// dump($city);
		// dump($image);
		// dump($list);
		// dump($cimage);
		// dump("./Public/Uploads/".$cimage['image']);
		// exit;
		if(!empty($image['image']['size'])){
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
				//删除原文件
				unlink("./Public/Uploads/".$cimage['image']);
				// 保存当前数据对象
				$data['cid'] = $list['cid'];
				$data['city'] = $city['name'];
				// $data['uid'] = $list['uid'];
				// $data['content'] = $list['content'];
				// $data['create_time'] = NOW_TIME;
				$data['image'] = $info['image']['savepath'].$info['image']['savename'];
				// dump($data);
				// exit;
				$cimages = M('cimages');
				$cimages->where(array('id'=>array('eq',I('post.id'))))->save($data);
				$this->success('修改成功！',U('City/index'));
		    }


	    }else{
	    	//未上传图片只修改地址
	    	$data['cid'] = $list['cid'];
			$data['city'] = $city['name'];
			$cimages = M('cimages');
			$cimages->where(array('id'=>array('eq',I('post.id'))))->save($data);
			$this->success('修改成功！',U('City/index'));
	    }
    }


}
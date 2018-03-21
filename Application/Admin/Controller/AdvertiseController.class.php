<?php 
	namespace Admin\Controller;
	
	//用户管理 控制器
	class AdvertiseController extends AdminController {
		 // 显示广告链接列表
    public function index(){
    	$data = M('advertise')->select();
    	$this->assign('data',$data);
        // $blogroll = M('blogroll');//实例化blogroll对象
        // $count = $blogroll->count();//查询满足条件的总记录数
        // $Page = new \Think\Page($count,5);//实例化分页类 传入总数和每页显示数
        // // 定制分页样式
        // $Page->setConfig('header','<span class="total">共<b>%TOTAL_ROW%</b>条数据，第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        // $Page->setConfig('prev','上一页');
        // $Page->setConfig('next','下一页');
        // $Page->setConfig('last','末页');
        // $Page->setConfig('first','首页');
        // $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        // $show = $Page->show();//分页显示输出
        // // 进行分页数据查询 limit方法的参数要使用page类的属性
        // $list = $blogroll
        //         ->order('id')
        //         ->limit($Page->firstRow.','.$Page->listRows)
        //         ->select();
        // // V($list);exit;
        // $this->assign('list', $list);//赋值数据集
        // $this->assign('page',$show);//赋值分页输出
        // $this->display('Advertise/index');//输出模板
        $this->display('Advertise/index');
    }


    // 删除广告
    public function delete() {
        if(D('advertise')->delete($_GET['id']) > 0){
            $this->success("恭喜您,删除成功！",U('Advertise/index'));
        }else{
            $this->error("很遗憾删除失败...");
        }     
    }

    // 添加广告
    public function insert() {
    	if(!($_FILES['img']['error']==0)){
    		$this->redirect('GoodsImg/index','', 5, '图片添加失败！');
    	}
    	$gid = $_POST;
        $upload = new \Think\Upload();
        $upload->maxSize = 10000000;
        $upload->exts = array('jpeg','gif','png','jpg');
        $upload->rootPath = './Public/Uploads/';
        $upload->autoSub = true;
        $upload->savename = array('uniqid','');
        $info = $upload->upload()['img'];
        $data = $gid;
        $data['filename'] = $info['savepath'].$info['savename'];
     
        if($info) {
        	$filename = $info['savepath'].$info['savename'];
        	$img = new \Think\Image();
        	// V('./Public/Uploads/'.$filename);
        	$img->open('./Public/Uploads/'.$filename);
        	// V($result);
        	$width = $img->width();
        	$fileinfo = explode('.',$filename);
            $filename2 = $fileinfo[0];
            $mime = $img->mime();
            $ext = explode('/',$mime)[1];
                //判断如果图片宽度大于658则按比例缩放后保存
                $img->open('./Public/Uploads/'.$filename);
                $thimg1= $img->thumb(440,220,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/Uploads/'.$filename2 . '_440.' .$ext);

            $s_width = floor($img->width());
            $s_height = floor($img->height());
            //保存三种尺寸的图片，方便前台遍历
            //宽高192按比例缩放居中剪裁
            $img->open('./Public/Uploads/'.$filename);
            $thimg2 = $img->thumb(192,81,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/Uploads/'.$filename2 . '_192.' .$ext);         
            //如果3种格式的图片全都保存成功，则删除原图片
            $data['filename1'] = $filename2 . '_192.' .$ext;
            $data['filename2'] = $filename2 . '_440.' .$ext;
             if( $thimg1 && $thimg2){
                unlink('./Public/Uploads/'.$filename);
               	if(!D('Advertise')->create()){
                $this->redirect('index','',5,'很遗憾,操作失败!');
                exit;
            	}
	            if(D('Advertise')->add($data) > 0){
	                $this->success("添加成功！",U('Advertise/index'));
	            }else{
	                $this->error("添加失败！");
	            }
            } else {
            	$this->error('很遗憾,图片添加失败2！',U('GoodsImg/index'));
            }
        }
     
           
        
    }

    public function status ()
    {
        $get = $_GET;
        $id = I('get.id/d');
        $get['status'] = ($get['status'] == 0)? 1 : 0;
        // if($get['status'] == 0) {
        //     $get['status'] = 1;
        // } else {
        //     $get['status'] = 0;
        // }
        $data = M('advertise');
        $data->where(array('id'=>$id))->save(array('status'=>$get['status']));
        $this->redirect('index','',0,'恭喜您,操作成功!');
    }
}
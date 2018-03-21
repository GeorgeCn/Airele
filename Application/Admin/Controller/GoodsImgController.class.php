<?php
namespace Admin\Controller;

class GoodsImgController extends AdminController
{
	public function index ()
	{
		$gid = $_GET['gid'];
		if(empty($gid)) {
			$data = M('goodsimg');
			$result = $data->field('filename2')->where(array('face'=>'0'))->group('gid')->select();
		} else {
			$data = M('goodsimg');
			$result = $data->field(array('id','gid','filename2'))->where(array('gid'=>$gid))->select();
		}
		$this->assign('data',$result);
		$this->display('index');
	}

	//图片添加
	public function add ()
	{
		$gid = $_GET['gid'];
		$this->assign('gid',$gid);
		$this->display('GoodsImg/add');
	}
	 //上传房屋图片
    public function insert(){
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
            if($width <= 658){
                //判断如果图片宽度小于等于658则拼接宽度保存;
                $thimg5 = $img->save('./Public/Uploads/'.$filename2 . '_658.' . $ext);
            }else{
                //判断如果图片宽度大于658则按比例缩放后保存
                $img->open('./Public/Uploads/'.$filename);
                $thimg5 = $img->thumb(658,658,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/Uploads/'.$filename2 . '_658.' .$ext);
            }

            $s_width = floor($img->width());
            $s_height = floor($img->height());
            //保存三种尺寸的图片，方便前台遍历
            //宽高192按比例缩放居中剪裁
            $img->open('./Public/Uploads/'.$filename);
            $thimg6 = $img->thumb(192,192,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/Uploads/'.$filename2 . '_192.' .$ext);
            //宽78,高按比例
            $img->open('./Public/Uploads/'.$filename);
            $thimg2 = $img->thumb(78,78,\Think\Image::IMAGE_THUMB_SCALE)->save('./Public/Uploads/'.$filename2 . '_78.' .$ext);           
            //如果3种格式的图片全都保存成功，则删除原图片
            $data['filename1'] = $filename2 . '_78.' .$ext;
            $data['filename2'] = $filename2 . '_192.' .$ext;
            $data['filename3'] = $filename2 . '_658.' .$ext;
 			M('goodsimg')->create($data);
        	M('goodsimg')->add();
             if( $thimg2 && $thimg5 && $thimg6){
                unlink('./Public/Uploads/'.$filename);
                $this->success('恭喜您,图片添加成功！',U('GoodsImg/index'));
            } else {
            	$this->error('很遗憾,图片添加失败2！',U('GoodsImg/index'));
            }
        }
	  
	}

	//删除图片
	public function del ()
	{
		$id = I('get.id/d');//I()方法 过滤输入的数据
        if (M('goodsimg')->delete($id) > 0) {
            $this->success('恭喜您,删除成功!',U('index'));
        } else {
            $this->error('很遗憾,删除失败!',U('index'));
        }

	}

	//封面操作
	public function face ()
	{	
		if(empty($_GET['id'])) {
			$this->redirect('无法执行修改操作');
		}		
		$id = I('get.id/d');
		$gid = I('get.gid/d');
		$data = array('face'=>1);
		$data1 = array('face'=>0);
		$sql = M('goodsimg');
		$sql->where(array('gid'=>$gid))->save($data);
		$sql->where(array('id'=>$id))->save($data1);
		$this->redirect('Goods/index','',3,'恭喜您,设置成功!');
	}
}
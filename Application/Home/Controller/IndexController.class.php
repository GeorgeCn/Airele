<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$imges = M('himages')->where(array('status'=>array('eq','1')))->select();
    	$this->assign('images',$imges);
        $cimage = M('cimages')->select();
        // var_dump($cimage);
        $this->assign('cimage',$cimage);
     	$this->assign('title','LOREM');
        // 初始化加载友情链接
        $data = M('Blogroll')
                ->where(array('status'=>array('eq', '1')))
                ->select();
        // V($data);die;
        $this->assign('Blogroll', $data);
        $this->display();
    }

    public function about()
    {
         
        $this->display();
    }


}
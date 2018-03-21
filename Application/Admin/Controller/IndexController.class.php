<?php
namespace Admin\Controller;


class IndexController extends AdminController {
    
    public function index(){
       $this->display();
    }

    // public function images(){
    // 	$list = M('himages')->select();
    // 	$this->assign("list",$list);
    // 	$this->display();
    // }
    
}
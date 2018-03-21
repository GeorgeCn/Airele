<?php 
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function index(){
     	// $this->assign('title','LOGIN');
        $this->display('Goods/index');
    }
}
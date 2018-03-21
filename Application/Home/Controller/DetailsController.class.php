<?php 
namespace Home\Controller;
use Think\Controller;
class DetailsController extends Controller {
    public function index(){
     	// $this->assign('title','LOGIN');
        $this->display('Details/index');
    }
}
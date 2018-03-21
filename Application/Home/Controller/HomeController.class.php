<?php 
namespace Home\Controller;

use Think\Controller;

//公共的控制器类
class HomeController extends Controller{

    //初始化的方法
    public function _initialize()
    {

        //判断session是否存在
        if(empty($_SESSION['user'])){
            //跳转到 登陆页
            $this->success("你还未登录账户,正在拼命前往登录...", U('Public/login'));
            exit;
        }

    }
}
<?php 
namespace Admin\Controller;

use Think\Controller;

//公共的控制器类
class AdminController extends Controller{

	//初始化的方法
	public function _initialize(){

		//判断session是否存在
		if(empty($_SESSION['admin_user'])){
			//跳转到 登陆页
			$this->redirect("Public/login");
		}

		//V($_SESSION);

		//权限过滤
		$mname = CONTROLLER_NAME; //获取控制器名
		$aname = ACTION_NAME; //获取方法名

		// echo $mname.'/'.$aname;

		$nodelist = $_SESSION['admin_user']['nodelist']; //获取权限列表

		//V($_SESSION);
		//让超级管理员admin拥有所有权限
		if($_SESSION['admin_user']['username'] != 'admin'){
			//验证操作权限
			if(empty($nodelist[$mname]) || !in_array($aname,$nodelist[$mname])){
				
				$this->error("抱歉！没有操作权限！");
				exit;
			}

		}

	}

}
 
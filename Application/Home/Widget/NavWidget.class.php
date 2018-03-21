<?php 
namespace Home\Widget;

use Think\Controller;

class NavWidget extends Controller
{
	public function menu()
	{
	   $navList = array(
            array('name'=>'博客'),
            array('name'=>'社区'),
            array('name'=>'论坛'),
            array('name'=>'商城'),
        );
        $this->assign('navList', $navList);
        $this->display("Nav/menu");
	}
}

 ?>
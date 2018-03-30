<?php 
// +----------------------------------------------------------------------
// | 基于Thinkphp3.2.3开发的一款权限管理系统
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 普罗米修斯 <996674366@qq.com>
// +----------------------------------------------------------------------
// | Maintainer: 乔治 <923143925@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use \Think\Controller;

class PublicController extends Controller
{
	/**
	 * skip 没有条件时跳转地址
	 * @author 普罗米修斯(996674366@qq.com)
	 * @maintainer 乔治 (923143925@qq.com) 
	 **/
	public function skip()
	{
		session(C('ADMIN_UID'), null);
		$this->redirect(C('DEFAULT_MOUDLE') . 'Public/login'); 
	}

	/**
     * success 执行成功返回json格式
     * @param $message 提示字符串
     * @param $url 跳转地址
     * @author 普罗米修斯(996674366@qq.com)
     * @maintainer 乔治 (923143925@qq.com)
     **/
	public function success($message, $url)
	{
		$array = array(
			'statusCode' => 200,
			'message' => $message,
			'url' => $url,
		);
		die(json_encode($array));
	}

	/**
     * error 执行成功返回json格式
     * @param string $message 提示字符串
     * @param string $url 跳转地址
     * @author 普罗米修斯(996674366@qq.com)
     * @maintainer 乔治 (923143925@qq.com)
     **/
    protected function error($message = '')
    {
        $array = array(
            'statusCode' => 300,
            'message'    => $message,
        );
        die(json_encode($array));
    }

    /**
     * login 登录页面
     * @author 普罗米修斯(996674366@qq.com)
     * @maintainer 乔治 (923143925@qq.com)
     **/
    public function login()
    {
    	if(session(C('ADMIN_UID'))) $this->redirect(C('DEFAULT_MOUDLE') . '/Index/Index');
    	$this->display();
    }

	//执行登陆
	public function dologin()
	{	
		// 检查验证码  
		$verify = I('param.verify','');  
		if(!check_verify($verify)){  
		    $this->error("亲，验证码输错了哦！",$this->site_url,3);  
		} 
		//接收用户名和密码
		$username = I('post.username');
		$password = I('post.password');
		//验证
		$user = M('User');
		$data = $user->where(array('username'=>$username))->find();
		if (!$data) {
			$this->error('用户名不存在！');
			exit;
		}
		//验证密码
		if ($data['userpass'] != md5($password)) {
			$this->error('密码不正确');
			exit;
		}
		//把用户信息添加到session
		$_SESSION['admin_user'] = $data;


		//根据用户id获取对应的节点信息
		//$sql = "select n.mname,n.aname from lamp_user u join lamp_user_role ur on u.id=ur.uid join lamp_role_node rn on ur.rid=rn.rid join lamp_node n on rn.nid=n.id where u.id={$users['id']}";
		//$list = M()->query($sql);

		$list = M('node')->field('mname,aname')->where('id in'.M('role_node')->field('nid')->where("rid in ".M('user_role')->field('rid')->where(array('uid'=>array('eq',$data['id'])))->buildSql())->buildSql())->select();

		//控制器名转换为大写
		foreach ($list as $key => $val) {
			$list[$key]['mname'] = ucfirst($val['mname']);
		}

		//查看查询出来的信息
		// V($list); exit;

		$nodelist = array();
		$nodelist['Index'] = array('index');
		//遍历重新拼装
		foreach($list as $v){
			$nodelist[$v['mname']][] = $v['aname'];
			//把修改和执行修改 添加和执行添加 拼装到一起
			if($v['aname']=="edit"){
				$nodelist[$v['mname']][]="save";
			}
			if($v['aname']=="add"){
				$nodelist[$v['mname']][]="doadd";
			}
		}

		//将权限信息放置到session中
		$_SESSION['admin_user']['nodelist'] = $nodelist;

		//重组的信息
		// V($_SESSION);exit;
		
		//跳转到首页
		$this->redirect('Index/index');
	}

	//退出登陆
	public function logout()
	{
		//清空session
		unset($_SESSION['admin_user']);
		//跳转
		$this->redirect('Index/index');
	}

	//跳转到添加图片页面
	// public function upload()
	// {
	// 	$this->redirect('Index/index');
	// }

	//添加图片
	public function doupload()
	{
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
			
			$list = $_POST;
			// dump($info);
			// dump($list);
			// exit;
			
			$model = M('himages');
			// dump($model);
			// exit;
			// 保存当前数据对象
			$data['name'] = $list['name'];
			// $data['pid'] = $list['pid'];
			// $data['uid'] = $list['uid'];
			// $data['content'] = $list['content'];
			// $data['create_time'] = NOW_TIME;
			$data['image'] = $info['image']['savepath'].$info['image']['savename'];
			// dump($data);
			// exit;
			$model->add($data);
			$this->success('上传成功！',U('Public/upload'));
		}	


    }

    /**
	 * 验证码生成 支持数字、英文字母、汉字
	 * @author George <[<923143925@qq.com>]>
	 * @param int $type 验证码类型 1-数字 2-英文字母 3-混合 4-汉字(略) 
	 * @time() 2018-3-30
	 * 
	 */
	public function verify($type = 1){
		$codeArr = ['0123456789', 'abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY'];
        $Verify = new \Think\Verify();
        $Verify->fontSize = 15;  
        $Verify->length = 4;  
        $Verify->useNoise = false;
        switch ($type) {
          	case 1:
          		$Verify->codeSet = $codeArr[0];
          		break;
          		case 2:
          		$Verify->codeSet = $codeArr[1];
          		break;
          		case 3:
          		$Verify->codeSet = $codeArr[2];
          		break;
          	
          	default:
          		$Verify->codeSet = $codeArr[0];
          		break;
          }  
        $Verify->imageW = 110;
        $Verify->imageH = 40;
        $Verify->entry();  
    }

    /**
     * code 检测验证码
     * @author 普罗米修斯
     * @time 2015-3-23
     **/
    public function code()
    {
        code();
    }
}
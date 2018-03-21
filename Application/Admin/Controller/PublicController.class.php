<?php 
namespace Admin\Controller;

use \Think\Controller;

class PublicController extends Controller
{

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
	 * 验证码生成
	 */
	public function verify(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 15;  
        $Verify->length = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 110;
        $Verify->imageH = 40;
        $Verify->entry();  
    }
}
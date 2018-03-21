<?php 
	namespace Admin\Controller;
	
	//用户管理 控制器
	class ProfileController extends AdminController{
		private $code;
		//用户信息
		public function index ()
		{
			$uid = $_SESSION['admin_user']['id'];
			$data = M('user_info')->where(array('uid'=>$uid))->select()[0];

			$data['id'] = $uid;
			$data['username'] = $_SESSION['admin_user']['username'];
			$data['name'] = $_SESSION['admin_user']['name'];
			$this->assign('data',$data);
			$this->display('index');
		}

		//添加用户信息
		public function infoAdd ()
		{
			// V($_SESSION);exit;
			$uid = $_POST['uid'];
			$data = $_POST;
			if(empty($data['myphone'])) {
					if(empty(M('user_info')->where(array('uid'=>$uid))->select())) {
			        // 返回自增ID
			        M('user_info')->create($data);
			        if (M('user_info')->add()) {
			            $this->success('添加成功',U('index'));
			        } else {
			            $this->error('添加失败');
			        }  	
				} else {
			        // 返回自增ID
			        M('user_info')->create($data);
			        M('user_info')->where(array('uid'=>$uid))->save();
			        $this->redirect('index','',3,'恭喜您,操作成功!'); 
				}
			} else {
				if($data['code']==$_SESSION['code']) {
					$this->success('恭喜您,修改成功',U('index'));
				} else {
					$this->error('恭喜您,修改失败');
				}

			}			
		}

		public function reset ()
		{
			$a = rand('10000','99999');
			$_SESSION['code'] = $a;
			send_sms_code('18516051096',$a);
		}
		
	}
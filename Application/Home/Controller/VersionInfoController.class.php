<?php
namespace Home\Controller;
use Think\Controller;
class VersionInfoController extends Controller 
{
	//查询软件更新信息
	public function versioninfolist ()
	{
		//验证当前登录状态
		$handleCommonCache = new \Logic\CommonCacheLogic();
		if(!$handleCommonCache->checkcache()) {
			return $this->error('非法操作',U('Index/index'),1);
		}
		$switchcity = $handleCommonCache->cityauthority();
		$this->assign("switchcity",$switchcity);
		$handleMenu = new \Logic\AdminMenuListLimit();
		$menu_top_html = $handleMenu->menuTop(cookie("admin_user_name"),"1");
		$menu_left_html = $handleMenu->menuLeft(cookie("admin_user_name"),"1");
		$handleMenu->jurisdiction();
		$get = I('get.softtype',0);
		$where = array();
		if( $get == 0 ){
			$where['platform'] = array(array('eq','iphone'),array('eq','android'),'or');
			// $where = 'platform = iphone or platform = android';
			$info = new \Home\Model\versioninfo();
			$count = $info->modelCountRenter($where);
			$Page = new \Think\Page($count,10);
			$list = $info->modelGetRenter($Page->firstRow,$Page->listRows,$where);
			$type = 0;

		} elseif($get == 2) {
			$where['platform'] = 'iphone_hizufang';
			$info = new \Home\Model\versioninfo();
			$count = $info->modelCountRenter($where);
			$Page = new \Think\Page($count,10);
			$list = $info->modelGetRenter($Page->firstRow,$Page->listRows,$where);
			$type = 2;
		} else {
			$info = new \Home\Model\versioninfo();
			$count = $info->modelCountOwner($where);
			$Page = new \Think\Page($count,10);
			$list = $info->modelGetOwner($Page->firstRow,$Page->listRows,$where);
			$type = 1;			
		}
		$this->assign("pagecount",$count);
		$this->assign("list",$list);
		$this->assign("show",$Page->show());
		$this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("type",$type);
		$this->display();
	}

	//新增版本信息
	public function addinfo ()
	{
		//验证当前登录状态
		$handleCommonCache = new \Logic\CommonCacheLogic();
		if(!$handleCommonCache->checkcache()) {
			return $this->error('非法操作',U('Index/index'),1);
		}
		$switchcity = $handleCommonCache->cityauthority();
		$this->assign("switchcity",$switchcity);
		$handleMenu = new \Logic\AdminMenuListLimit();
		$menu_top_html = $handleMenu->menuTop(cookie("admin_user_name"),"1");
		$menu_left_html = $handleMenu->menuLeft(cookie("admin_user_name"),"1");
		$this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
	}
	//提交版本信息
	public function submit ()
	{
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '{"status":"404","msg":"登录失效"}';return;
		}
		$post = I('post.softtype',0);
		$plat = I('post.platform');
		$judge = new \Logic\VersionInfo();
		$judge->infoJudge();
		if( $post == 0 ) {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelAddRenter($data);
			if($return){
				$this->success('数据添加成功','versioninfolist.html?no=1&leftno=158');
			} else {
				$this->error('数据添加失败','versioninfolist.html?no=1&leftno=158');
			}
		} elseif($post == 2) {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelAddRenter($data);
			if($return){
				$this->success('数据添加成功','versioninfolist.html?no=1&leftno=158&softtype=2');
			} else {
				$this->error('数据添加失败','versioninfolist.html?no=1&leftno=158&softtype=2');
			}
		} else {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelAddOwner($data);
			if($return){
				$this->success('数据添加成功','versioninfolist.html?no=1&leftno=158&softtype=1');
			} else {
				$this->error('数据添加失败','versioninfolist.html?no=1&leftno=158&softtype=1');
			}
		}
	}
	//修改版本信息
	public function modifyinfo ()
	{
		//验证当前登录状态
		$handleCommonCache = new \Logic\CommonCacheLogic();
		if(!$handleCommonCache->checkcache()) {
			return $this->error('非法操作',U('Index/index'),1);
		}
		$switchcity = $handleCommonCache->cityauthority();
		$this->assign("switchcity",$switchcity);
		$handleMenu = new \Logic\AdminMenuListLimit();
		$menu_top_html = $handleMenu->menuTop(cookie("admin_user_name"),"1");
		$menu_left_html = $handleMenu->menuLeft(cookie("admin_user_name"),"1");
		$judge = new \Logic\VersionInfo();
		$id = I('get.id');$type = I('get.type');
		$judge->typeJudge($id,$type);
		$this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
	}
	//修改版本信息
	public function modify ()
	{
		$login_name=trim(getLoginName());
		if(empty($login_name)){
			echo '{"status":"404","msg":"登录失效"}';return;
		}
		$post = I('post.softtype',0);
		$plat = I('post.platform');
		$judge = new \Logic\VersionInfo();
		$judge->infoJudge();
		if( $post == 0 ) {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelUpdateRenter($data);
			if($return){
				$this->success('数据修改成功','versioninfolist.html?no=1&leftno=158');
			} else {
				$this->error('数据修改失败','versioninfolist.html?no=1&leftno=158');
			}
		} elseif( $post == 2 ) {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelUpdateRenter($data);
			if($return){
				$this->success('数据修改成功','versioninfolist.html?no=1&leftno=158&softtype=2');
			} else {
				$this->error('数据修改失败','versioninfolist.html?no=1&leftno=158&softtype=2');
			}
		} else {
			$info = new \Home\Model\versioninfo();
			$data = I('post.');
			switch ($plat) {
				case 0: $platform = 'iphone';
				break; 
				case 1: $platform = 'android';
				break; 
				case 2: $platform = 'iphone_hizufang';
				break;
				default:
				break;
			}
			$data['platform'] = $platform;
			$data['create_time'] = time();
			$data['create_man'] = $login_name;
			unset($data['softtype']);
			$return = $info->modelUpdateOwner($data);
			if($return){
				$this->success('数据修改成功','versioninfolist.html?no=1&leftno=158&softtype=1');
			} else {
				$this->error('数据修改失败','versioninfolist.html?no=1&leftno=158&softtype=1');
			}
		}
	}
	//删除版本信息
	public function deletebyid ()
	{
	 	$id = trim(I('get.id'));
	 	$type = trim(I('get.type'));
	 	$where['id'] = $id;
	 	$loginName=trim(getLoginName());
	 	if(empty($loginName) || empty($id)){
	    	echo '参数异常。';return;
	  	}
	  	if($type == 0) {
	  		$info = new \Home\Model\versioninfo();
	  		$result = $info->modelDeleteRenter($where);
	  		if($result){
		        echo '操作成功。';
		    }else{
		    	echo '操作失败。';
		    	}
	  	} else {
	  		$info = new \Home\Model\versioninfo();
	  		$result = $info->modelDeleteOwner($where);
	  		if($result){
		        echo '操作成功。';
		    }else{
		    	echo '操作失败。';
		    	}
	  	}
	}
	//版本启动操作
	public function modifyVersionUsing ()
	{
		$data = I('get.');
		$loginName=trim(getLoginName());
	 	if(empty($loginName) || empty($data)){
	    	echo "{'status':400,'message':'参数错误','data':{}}";return;
	  	}
		$info = new \Home\Model\versioninfo();
		if($data['type'] == 0) {
			$where = array();
			$where['id'] = $data['id'];
			$where['is_using'] = ($data['is_using'] == 0)?1:0;
			$result = $info->modelUpdateRenter($where);
		} else {
			$where = array();
			$where['id'] = $data['id'];
			$where['is_using'] = ($data['is_using'] == 0)?1:0;
			$result = $info->modelUpdateOwner($where);
		}
		if ($result) {
		    echo "{'status':200,'message':'','data':{}}";
		} else {
		    echo "{'status':400,'message':'参数错误','data':{}}";
			}
	}
}
?>
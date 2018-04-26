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

use Think\Auth;

class PrivateController extends PublicController
{
	public $model = null;
    private $auth = null;
    private $group_id = array();

    /**
     * 初始化方法
     * @auth 普罗米修斯 www.php63.cc
     **/
    public function _initialize()
    {
        //获取到当前用户所属所有分组拥有的权限id
        $this->group_id = self::_rules();
        $userName = session(C('USERNAME'));
        //检测后台管理员昵称是否存在，如果不等于空或者0则获取配置文件里定义的name名字并分配给首页
        if (!empty($userName)) {
            $this->assign('userName', session(C('USERNAME')));
        }
        //分配左边菜单
        $this->_left_menu();
        //分配列表上方菜单
        $this->_top_menu();
        //分配网站顶部菜单
        $this->_web_top_menu();
        //检测是否为超级管理员
        if (UID == C('ADMINISTRATOR')) {
            return true;
        }
        //读取缓存名为check_iskey+uid的缓存
        $key = MODULE_NAME.'/'. CONTROLLER_NAME . '/' . ACTION_NAME;
        $where = array(
            'name'   => $key,
            'status' => 1
        );
        $iskey = M('auth_cate')->where($where)->getField('id');
        //检测该规则id是否存在于分组拥有的权限里
        if(!empty($iskey) && !in_array($iskey,$this -> group_id)){
            $this->auth = new Auth();
            if(!$this->auth->check($key, UID)){
                $url = C('DEFAULTS_MODULE').'/Public/login';
                //如果为ajax请求，则返回301，并且跳转到指定页面
                if(IS_AJAX){
                    session('[destroy]');
                    $data = array(
                        'statusCode' => 301,
                        'url'        => $url
                    );
                    die(json_encode($data));
                }
                session('[destroy]');
                $this->redirect($url);
            }
        }
    }

	/**
	 * 查询总条数
	 * @AuthorHTL
	 * @DateTime  2018-04-04T10:51:32+0800
	 * @param     array                    $where 查新的条件
	 * @param     integer                  $type  类型 ：type=1 分页用 type=2 普通查询
	 * @param     string                   $num   单页容纳数量
	 * @return    mixed   
	 * @author 普罗米修斯
	 * @maintainer 乔治                
     */
    protected function _modelCount($where = array(), $type = 1, $num = '')
    {
    	$count = $this->model->total($where);
    	if($type == 1) {
    		if($num = '') {
    			$num = C('PAGENUM');
    		}
    		$page = self::_page($count, $num);

    		return $page;
    	}

    	return $count;
    }

    /**
     * page 分页
     * @param int $count 总条数
     * @param int $num 展示条数
     * @return array 返回组装好的结果
     * @author 普罗米修斯
     * @maintainer 乔治
     **/
    protected function _page($count, $num)
    {
        $showPageNum = 15;
        $totalPage = ceil($count / $num);
        $currentPage = I('post.currentPage', 1, 'intval');
        $searchValue = I('post.searchValue', '');
        if($currentPage > $totalPage) {
        	$currentPage = $totalPage;
        } 
        if($currentPage < 1) {
        	$currentPage = 1;
        }
        $list = array(
        	'pageNum'      => $num,
        	'showPageNum'  => $showPageNum,
        	'currentPage'  => $currentPage,
        	'totalPage'    => $totalPage,
        	'limit'        => ($currentPage - 1) * $num . ',' .$num,
        	'searchValue'  => $searchValue,
        	'pageUrl'      => '',
        );
        
        return $list;
    }

    /**
     * 左边菜单
     * @author 普罗米修斯<www.php63.cc>
     * @time 2015-12-11
     **/
    public function _left_menu()
    {
        $url = S('left_menu');
        if ($url == false) {
            $where = array(
                'status' => 1,
                'level'  => 1,
                'module' => MODULE_NAME
            );
            if (UID != C('ADMINISTRATOR')) {
                $where['id'] = array('in', $this->group_id);
            }
            $model = D('auth_cate');
            $url = $model->where($where)->order('sort DESC')->select();
            foreach ($url as $key => &$value) {
                $where = array(
                    'pid' => $value['id'],
                    'status' => 1,
                    'is_menu' => array('neq',0)
                );
                $info = $model->where($where)->count();
                if($info){
                    array_splice($url, $key,1);
                }else{
                    $urls = $value['name'] . '/index';
                    $value['name'] = U($urls); 
                }
            }
            unset($value);
            S('left_menu' . UID, $url);
        }
        $this->assign('menu_url', $url);
    }
}

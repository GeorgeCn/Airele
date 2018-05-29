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
        phpinfo()
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
     * @author 普罗米修斯
     * @time 2015-12-11
     **/
    public function _left_menu()
    {
        // $url = S('left_menu');
        if ($url == false) {
            $where = array(
                'status' => 1,
                'level'  => array('in','0,1'),
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
            // S('left_menu' . UID, $url);
        }
        dump($url);exit;
        $this->assign('menu_url', $url);
    }
    /**
     * 列表上方菜单
     * @author 普罗米修斯
     * @time 2015-12-11
     **/
    public function _top_menu()
    {
        $module_name = MODULE_NAME;
        $controller  = CONTROLLER_NAME;
        $where = array(
            'status'     => 1,
            'level'      => 2,
            'is_menu'    => 0,
            'module'     => $module_name,
            'controller' => $controller
        );
        if (UID != C('ADMINISTRATOR')) {
            $where['id'] = array('in', $this->group_id);
        }
        $model = D('auth_cate');
        $url = $model->where($where)->field('module,controller,method,title,name')->order('sort DESC')->select(false);
        //检测控制器是不是等于Index
        if ($controller == 'Index') {
            $arr = array(
                'module'     => $module_name,
                'controller' => 'Index',
                'method'     => 'index',
                'title'      => '站点信息',
                'name'       => $module_name . '/Index/index'
            );
            array_unshift($url, $arr);
        }
        $this->assign('top_menu_url', $url);
    }


    /**
     * 网站顶部菜单
     * @author 普罗米修斯
     * @time 2015-12-11
     **/
    public function _web_top_menu()
    {
        $model = M('adm_auth_cate');
        $url = S('web_top_menu' . UID);
        //检测缓存是否存在,如果不存在则生成缓存
        if ($url == false) {
            $where = array(
                'status' => 1,
                'level'  => 0,
            );
            if (UID != C('ADMINISTRATOR')) {
                $where['id'] = array('in', $this->group_id);
            }
            $dataArr = $model->where($where)->select();
            $module = array();
            foreach ($dataArr as $key => $value) {
                $where = array(
                    'pid'    => $value['id'],
                    'status' => 1
                );
                $res = $model->where($where)->getField('id');
                if ($res) {
                    $module[] = $value['id'];
                }
            }
            if (!empty($module)) {
                $where = array(
                    'id'     => array('in', $module),
                    'status' => 1
                );
                $url = $model->where($where)->field('id,title,module')->order('sort DESC')->select();
                foreach ($url as $key => &$value) {
                    $where = array(
                        'pid'    => $value['id'],
                        'status' => 1
                    );
                    $str = $model->where($where)->getField('module');
                    $value['url'] = U($str . '/Index/index', array('module' => MODULE_NAME));
                }
                unset($value);
                //生成缓存
                S('web_top_menu' . UID, $url);
            }
        }
        if (count($url) > 1) {
            $this->assign('web_top_menu_url', $url);
        }
    }


    /**
     * 权限判断 所有一级菜单点击都进入这个方法
     * @author 普罗米修斯
     * @time 2016-06-15
     **/
    public function index()
    {
        $url = MODULE_NAME . '/' . CONTROLLER_NAME;
        $where = array(
            'a.name' => $url,
            'a.level'=> 1,
            'b.status' => 1
        );
        if(UID != C('ADMINISTRATOR')){
            $where['b.id']   = array('in',$this->group_id);
        }
        $info = M()
            -> table('__AUTH_CATE__ a')
            -> join('LEFT JOIN __AUTH_CATE__ b ON a.id=b.pid')
            -> where($where)
            -> order('b.sort DESC')
            -> getField('b.name');
        $this->redirect($info);
    }


    /**
     * 分类列表
     * @param string $model 要操作的表
     * @param string $cache 缓存名称
     * @author 普罗米修斯
     * @time 2016-01-21
     **/
    public function _cateList($model, $title, $sort = '', $cache = '')
    {
       // $list = S($cache . UID);
       // if ($list == false) {
            $this->model = D($model);
            $where = array(
                'status' => 1,
                'type'=>1
            );
            $list = self::_modelSelect($where, $sort);
            if (!$list) {
                $list = array();
            }
            $arr = array(
                'id'       => 0,
                'pid'      => null,
                'title'    => $title,
                'isParent' => true,
                'open'     => true,
            );
         array_unshift($list, $arr);
            $list = json_encode($list);
           // S($cache . UID, $list);
       // }
        $this->assign('list', $list);
    }

    /**
     * 列表右边操作按钮
     * 数组里第二个参数为跳转类型参数
     * type 1弹出层 2删除 3审核 4直接打开
     * @author 普罗米修斯<www.php63.cc>
     **/
    protected function _listBut($data)
    {
        $dataArr = array();
        foreach ($data as $key => $value) {
            if (self::_is_check_url($value[3])) {
                $dataArr[$key]['name'] = $value[0];
                $dataArr[$key]['opt']['title'] = $value[2];
                $dataArr[$key]['opt']['url'] = $value[4];
                switch ($value[1]) {
                    case 1://弹出层
                        $dataArr[$key]['target'] = 'popDialog';
                        break;
                    case 2:
                        $dataArr[$key]['opt']['msg'] = $value[5];
                        $dataArr[$key]['target'] = 'ajaxDel';
                        break;
                    case 3:
                        $dataArr[$key]['opt']['msg'] = $value[5];
                        $dataArr[$key]['target'] = 'ajaxTodo';
                        $dataArr[$key]['opt']['value'] = $value[7];
                        $dataArr[$key]['opt']['type'] = $value[6];
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        return $dataArr;
    }

    /**
     * 删除分类
     * @author 普罗米修斯
     **/
    protected function _delcate($url)
    {
        if (!$this->model) {
            $this->error("表名未定义");
        }
        $res = $this->model->delcate();
        if ($res) {
            $this->success('操作成功', U($url));
        }
        $this->error($this->model->getError());
    }
    
    /**
     *  param 跳转地址
     * author 普罗米修斯
     **/
    protected function urlRedirect($url = '/info'){
        $modules = I('get.module');
        if(!empty($modules)){
            delTemp();
        }
        $this -> redirect(MODULE_NAME.'/'.CONTROLLER_NAME.$url);
    }
}

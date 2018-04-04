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
}

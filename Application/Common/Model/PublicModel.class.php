<?php
namespace Common\Model;

use Think\Model;

class PublicModel extends model
{
	/**
	 * 获取某些指定用户的指定字段
	 * @param string $field 字段名
	 * @param array where 要查询的条件
	 * @param  $type 默认false 单字段模式
	 * @author 普罗米修斯 (996674366@qq.com)
	 * @maintainer 乔治 (923143925@qq.com)
	 **/
	public function getOneField($field, $where = array, $type = false, $order = '')
	{	
		$result = $this->where($where)->order($order)->getField($field, $type);
		return $result;
	}

	/* 查询一条记录
     * @param string $where 查询条件
     * @param string $field 要查询的字段,默认全部
     * @return array 返回查询到的结果
     * @author 刘中胜
     * @maintainer 乔治
     **/
    public function oneInquire($where, $field = '*')
    {
        $info = $this->where($where)->field($field)->find();
        if (!$info) {
            $this->error = '暂无数据';
            return false;
        }
        return $info;
    }

    /**
     * 查询总数 简单模式
     * @param string $where 查询条件
     * @param string $field 要查询的字段,默认全部
     * @return int 总数
     * @author 刘中胜
     * @maintainer 乔治
     **/
    public function total($where)
    {
        $count = $this->where($where)->count();
        return $count;
    }

    /**
     * 查询总数 复杂模式
     * @param string $where 查询条件
     * @param string $limit 分页参数
     * @param string $order 排序方式
     * @param string $field 要查询的字段
     * @author 刘中胜
     * @return array 查询到的结果集
     **/
    public function dataSet($where,$order,$field,$limit='')
    {
        $list = $this -> where($where)->limit($limit)->order($order)->field($field)->select();
        return $list;
    }
}
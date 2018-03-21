<?php 
namespace Home\Controller;

class CommentController extends HomeController
{
    public function index(){
        $id = $_SESSION['user']['id'];
        $comment = M('comment');//实例化comment对象
        $count = $comment->where('uid='.$id)->count();//查询满足条件的总记录数
        $Page = new \Think\Page($count,5);//实例化分页类 传入总数和每页显示数
        // 定制分页样式
        $Page->setConfig('header','<span class="total">共<b>%TOTAL_ROW%</b>条数据，第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $Page->show();//分页显示输出
        $data = $comment
                ->table('comment c,goods g')
                ->field('c.*,g.name')
                ->where("c.uid = $id and g.id = c.gid")
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
        // V($data);die;
        $this->assign('list', $data);
        $this->assign('page', $show);
        $this->display();
    }
}
<?php 
namespace Admin\Controller;

class YonghuController extends AdminController
{
    public function index()
    {
        $yonghu = M('yonghu');//实例化comment对象
        $count = $yonghu->count();//查询满足条件的总记录数
        $Page = new \Think\Page($count,10);//实例化分页类 传入总数和每页显示数
        // 定制分页样式
        $Page->setConfig('header','<span class="total">共<b>%TOTAL_ROW%</b>条数据，第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $Page->show();//分页显示输出
        $data=M("yonghu")
            ->field('id,nickname,sex,tel,email,status')
            ->order('id')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        // V($data);die;
        $this->assign('list', $data);
        $this->assign('page', $show);
        $this->display();
    }

    // 用户状态更改
    public function dostatus()
    {
        $status = I('status');
        // V($status);die;
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        // echo $status;die;
        // 执行修改
        $data['status'] = $status;
        // V($data);die;
        if (M('yonghu')->where(array('id'=>array('eq', I('id'))))->save($data) > 0) {
            $this->redirect('Yonghu/index');
        } else {
            $this->error("状态还没回来...");
        }
    }

    // 用户密码重置(默认密码:000000)
    public function reset()
    {
        $id= I('id');
        // V($id);die;
        // 执行重置修改
        $data['pwd'] = md5('000000');
        if (M('yonghu')->where(array('id'=>array('eq', I('id'))))->save($data) > 0) {
            $this->redirect('Yonghu/index');
        } else {
            $this->error("重置失败,请联系VIP管理员...");
        }
        
    }


}
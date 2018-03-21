<?php
namespace Admin\Controller;

class ComplainController extends AdminController
{
	public function index ()
	{
        $data = M('complain')->where(array('status'=>0))->select();
        $this->assign('data',$data);
        // $this->data = $data;
        $this->display('Complain/index');
	}

	//已完成订单
	public function finish ()
	{
		$data = M('complain')->where(array('status'=>1))->select();
        $this->assign('data',$data);
		$this->display();
	}

	//处理订单
     public function status ()
    {
        $get = $_GET;
        $id = I('get.id/d');
        $get['status'] = ($get['status'] == 0)? 1 : 0;
        // if($get['status'] == 0) {
        //     $get['status'] = 1;
        // } else {
        //     $get['status'] = 0;
        // }
        $data = M('complain');
        $data->where(array('id'=>$id))->save(array('status'=>$get['status']));
        $this->redirect('index','',0,'恭喜您,操作成功!');
    }

    public function more ()
    {
            $id = $_GET['id'];
        //查询数据
            $map['id'] = array('eq',$id);
            $list = M('orders')->where($map)->select();
            //分配变量
            $this->assign("list",$list);
            
            //加载模板
            $this->display('Orders/index');
    }
}
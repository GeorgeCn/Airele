<?php
namespace Admin\Controller;

class GoodsController extends AdminController
{
	public function index ()
	{
        $data = M('goods')->select();
        $this->assign('data',$data);
        // $this->data = $data;
        $this->display('Goods/index');
	}

    //搜索内容
    public function search () 
    {
        $id = I('get.id/d');
        if(empty($id)) {
            $result = $data = M('goods')->select();
        } else {
            $map['id'] = array('eq',$id);
            $map['cid'] = array('eq',$id);
            $map['_logic'] = 'OR';
            $data = M('goods');
            $result = $data->where($map)->select();
        }
        $this->assign('data',$result);
        $this->display('Goods/index');
    }

    //房屋状态
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
        $data = M('goods');
        $data->where(array('id'=>$id))->save(array('status'=>$get['status']));
        $this->redirect('index','',0,'恭喜您,操作成功!');
    }

    //更多详情
    public function more ()
    {
        $id = I('get.id/d');
        $data = M('goods')->field(array('id','up','desc','persons','beds','toilets','address','intotime','outtime'))->where(array('id'=>$id))->select();
        $this->assign('data',$data);
        // $this->data = $data;
        $this->display('Goods/more');
    }

    //上架操作
    public function up ()
    {
        $get = $_GET;
        $id = I('get.id/d');
        $get['up'] = ($get['up'] == 0)? 1 : 0;
        // if($get['up'] == 0) {
        //     $get['up'] = 1;
        // } else {
        //     $get['up'] = 0;
        // }
        $data = M('goods');
        $data->where(array('id'=>$id))->save(array('up'=>$get['up']));
        $this->redirect('index','',0,'恭喜您,操作成功!');
    }

    //编辑操作
    public function edit ()
    {
        $id = $_GET['id'];
        $data = M('goods')->where(['id'=>$id])->select();
        $this->assign('data',$data[0]);
        // $this->data = $data;
        $this->assign('id',$id);
        $this->display('Goods/edit');
    }

    //删除操作
    public function delete ()
    {
        //判断有无参数ID
        if (empty($_GET['id'])) {
            $this->redirect('Goods/index','',3,'很遗憾,删除失败！');
            exit;
        }
        //接收ID
        // $id = $_GET['id'];
        $id = I('get.id/d');//I()方法 过滤输入的数据
        if (M('goods')->delete($id) > 0) {
            $this->success('恭喜您,删除成功!',U('index'));
        } else {
            $this->error('很遗憾,删除失败!',U('index'));
        }
    }

    //更新数据
    public function updata ()
    {
        if (empty($_POST)) {
            $this->error('请填写数据!',U('Goods/add'));
            exit;
        }
        $data = $_POST;
        $data['cid'] = max($data['province'],$data['city'],$data['town']);
        // 返回自增ID
        M('goods')->create($data);
        M('goods')->where(array('id'=>$data['id']))->save();
        $this->redirect('index','',3,'恭喜您,操作成功!');  
    }

	//添加页
    public function add ()
    {
        $this->assign('title','添加用户');
        $this->display('Goods/add');
    }

	// 执行添加
    public function insert ()
    {
        if (empty($_POST)) {
            $this->error('请填写数据!',U('Goods/add'));
            exit;
        }
        // $data = M('goods')->create();//生成数据表数据   data($_POST)
        // var_dump(M('user'));
        $data = $_POST;
        $data['cid'] = max($data['province'],$data['city'],$data['town']);
        // 返回自增ID
        M('goods')->create($data);
        if ($gid=M('goods')->add()) {
            $this->success('添加成功,请上传图片',U('GoodsImg/add',array('gid'=>$gid)));
        } else {
            $this->error('添加失败');
        }  
    }

    public function address ()
    {
        //接收查询条件
        $pid = empty($_GET['pid'])?0:$_GET['pid'];
        //查询
        $data = M('category')->where('pid='.$pid)->select();
        //将结果返回
        echo json_encode($data);
    }

    
}
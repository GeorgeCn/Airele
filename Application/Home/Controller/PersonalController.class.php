<?php 
namespace Home\Controller;

class PersonalController extends HomeController
{
    public function index(){
        $data = M('yonghu')->where(array('id'=>array('eq',$_SESSION['user']['id'])))->find();
        // V($data);die;
        $this->assign('vo', $data);
        $list = M('notice')
                ->where(array('status'=>array('eq',1)))
                ->select();
        $result = M('advertise')->field('filename2')->order('createtime desc')->limit(1)->select()[0];
        $this->assign('result',$result);

        $this->assign('list', $list);
        $this->display();
    }

    // 加载编辑页面
    public function edit(){
        // V($_POST['id']);die;
        $data = M('yonghu')->where(array('id'=>$_POST['id']))->find();
        // V($data);die;
        $this->assign('vo', $data);
        $this->display('Personal/edit');
    }
    // 执行编辑页面
    public function dosave(){
        // V($_POST);
        // die;
        // $data = $_POST;
        // V($data);die;
        if(!D('yonghu')->create()){
            $this->error(D('yonghu')->getError());
            exit;
        }
        // $a=$_POST['tel'];
        // V($a);eixt;
        if(D('yonghu')->save() > 0){
            $this->success("修改成功！",U('Personal/index'));
        }else{
            $this->error("修改失败！");
        }

    }

    public function avatar()
    {

    // 天气接口
        // 初始化
        $curl = curl_init();
        // CURL配置
        // APIkey的配置
        $h = ['apikey:1f637653de539c9663d5bd7a4688ecee'];
        // 添加apikey到header头当中
        curl_setopt($curl, CURLOPT_HTTPHEADER, $h);


        // 设置CURL的URL选项
        curl_setopt($curl, CURLOPT_URL, 'http://apis.baidu.com/txapi/world/world?num=5');

        //将curl_exec()获取的信息，以文档流的形式返回，而不是直接输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

        // 执行CURL
        $data = curl_exec($curl);
        // var_dump($data); //得到结果 json字串

        // 关闭curl
        curl_close($curl);

        // 处理json数据
        $jsonObj = json_decode($data);
        // var_dump($jsonObj);
        // 提取文章信息
        $newslist = $jsonObj->newslist;
        // var_dump($newslist);die;
        $this->assign('newslist', $newslist);
        $this->display('Personal/avatar');

    }

    //添加图片
    public function doupload()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
        $upload->saveName = array('uniqid','');
        $upload->savePath = ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        // dump($info);
        // exit;
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $list = $_POST;
            // dump($info);
            // dump($list);
            // exit;
            $model = M('yonghu');
            // dump($model);
            // exit;
            // 保存当前数据对象
            // $data['name'] = $list['name'];
            // $data['pid'] = $list['pid'];
            // $data['uid'] = $list['uid'];
            // $data['content'] = $list['content'];
            // $data['create_time'] = NOW_TIME;
            $data['icon'] = $info['image']['savepath'].$info['image']['savename'];
            // dump($data);
            // exit;
            // 判断是否有图片,第二次上传删除掉原来的图片
            /*if (empty($data)) {
                $model->where(array('id'=>array('eq',$_SESSION['user']['id'])))->save($data);
            } else {
                $model->where(array('id'=>array('eq',$_SESSION['user']['id'])))->save($data)->unlink();
            }*/
            $model->where(array('id'=>array('eq',$_SESSION['user']['id'])))->save($data);
            
            $this->success('上传成功！',U('Personal/index'));
        }
    }

    // 获取短信验证码
    public function seepwd(){
        session('code',null);
        $code = rand(1000,9999);
        session('code',$code);
        send_sms_code("15895212202", $code);
        // $this->ajaxReturn();
        // exit;
        // echo $code;
    }
    // 修改用户密码
    public function security()
    {
        $this->display();
    }
    // 执行修改密码
    public function doedit()
    {
        $code = $_SESSION['code'];
        // V($code);
        $data = $_POST;
        // V($data);
        // die;
        $opwd = md5($data['opwd']);
        $npwd = md5($data['pwd']);
        $repwd = md5($data['repwd']);
        foreach($data as $v) {
            if(empty($v)) {
                $this->error("表单不能为空");
            }
        }
        $id = $_SESSION['user']['id'];
        // V($id);
        $pw = M('yonghu')
                ->field('pwd')
                ->where('id='.$id)
                ->find();
        $pwd = $pw['pwd'];
        // V($pwd);V($opwd);die;
        if ($pwd != $opwd) {
            $this->error("您输入的密码有误，请重新输入");
        } 
        if ($repwd != $npwd) {
            $this->error("二次密码不一致！");
        }
        if ($opwd == $npwd) {
            $this->error("新密码与原密码相同");
        }
        if ($data['code'] != $code) {
            $this->error("您输入的验证码有误，请重新输入");
        }
        $new['pwd'] = $npwd;
        // 执行修改
        if (M('yonghu')->where('id='.$id)->save($new) >= 0) {
            $this->success("修改成功", U('Public/logout'));
        } else {
            $this->error("修改失败");
        }
        
        
    }



}
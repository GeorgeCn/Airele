<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
      if(cookie("admin_user_name")!=""){
        	cookie("admin_user_name",null);
        }
       $this->display();
    }

    //后台登陆
    public function login(){
      	$name=$_POST['user_name'];
      	$pwd=$_POST['password'];
      	 $code=$_POST['code'];
      	if($name==""||$pwd==""){
      		$this->error('用户名或密码不能为空！');
      		return;
      	}
      	if(!$this->check_verify($code)){
      		$this->error('验证码错误！');
      		return;
      	}
        $handleAccount=new \Logic\Account();
        $where['user_name']=$name;
        $status=$handleAccount->getAccount($where);
        if(!$status){
           $this->error('账号不存在！');
        }elseif($status['record_status']==0){
            $this->error('该账号已被停用！');
        }else{
        	 $handleLogin=new \Logic\AdminLogin();
        	$result=$handleLogin->AdminLogin($name,md5($pwd));
      		if($result!=null&&$result!=false){
            $where['user_name']=$name;
            $adminarr=$handleLogin->modelAdminFind($where);
            //set_couchebase_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id'],$adminarr['id'],43200);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id'],$adminarr['id'],43200);
      			cookie('admin_user_name',$name,43200);
            cookie('admin_user_name_id',$adminarr['id'],43200);
            if($adminarr['user_name']=="admin"){
                $this->success('登陆成功！',U('Welcome/welcome'),0);
            }elseif(strstr($adminarr['city_auth'],"1")){
                $this->success('登陆成功！',C('HOUST_SHANGHAI_URL'));
            }elseif(strstr($adminarr['city_auth'],"2")){
                $this->success('登陆成功！',C('HOUST_BEIJING_URL'));
            }elseif(strstr($adminarr['city_auth'],"3")){
                $this->success('登陆成功！',C('HOUST_HANGZHOU_URL'));
            }elseif(strstr($adminarr['city_auth'],"4")){
                $this->success('登陆成功！',C('HOUST_NANJING_URL'));
            }elseif(strstr($adminarr['city_auth'],"5")){
                $this->success('登陆成功！',C('HOUST_GUANGZHOU_URL'));
            }elseif(strstr($adminarr['city_auth'],"6")){
                $this->success('登陆成功！',C('HOUST_SHENZHENG_URL'));
            }
      			
      		}else{
      			$this->error('登录名或密码错误！');
      		}
      }
    }
    //验证码
    public function verufy(){
 		  ob_clean();
     	$config =    array(
     	'useNoise'	  =>false,//是否添加杂点
     	'useCurve'    =>false,//是否使用混淆曲线
	    'fontSize'    =>10,// 验证码字体大小
	    'length'      =>4, // 验证码位数
	    'imageW'      =>70,//高度
	    'imageH'	  =>26,	//宽度
     );
     $Verify = new \Think\Verify($config);
     $Verify->entry();
    }
    
    //验证输入验证码
    public function check_verify($code,$id=''){
   		 $verify = new \Think\Verify();
     return $verify->check($code,$id);
  }
   //退出登录
   public function outlogin(){
      $handleAdminLogin=new \Logic\AdminLogin();
      $cookiename=cookie('admin_user_name');
      $where['user_name']=$cookiename;
      $where['record_status']=1;
      $adminarr=$handleAdminLogin->modelAdminFind($where);
      //set_couchebase_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id'],"");
       set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),"admin_user_id".$adminarr['id'],"");
   	  cookie('admin_user_name',null);
     	$this->success('退出成功！',U('Index/index'),3);
   }
}

?>
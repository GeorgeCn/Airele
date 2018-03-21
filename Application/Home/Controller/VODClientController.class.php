<?php
namespace Home\Controller;
use Think\Controller;
class VODClientController extends Controller
{
    //显示房源视频列表
    public function VODClientList ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
        $handleMenu->jurisdiction();
        $startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $roomNO = I('get.roomNO');
        $createMan = I('get.createMan');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $storeManage = new \Logic\StoresManage();
        if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($roomNO != "") {
            $where['room_no']=array('eq',$roomNO);
        }
        if($createMan != "") {
            $where['create_man'] = array('eq',$createMan);
        }
        $VodModel = new \Home\Model\vodclient();
        $fields = 'room_id,room_no,video_url,video_img_url,video_myimg_url,video_h5url,create_time,create_man';
        $count=$VodModel->modelCountHouseVideo($where);
        $Page= new \Think\Page($count,10);
        $data=$VodModel->modelGetHouseVideo($Page->firstRow,$Page->listRows,$fields,$where);
        foreach ($data as &$value) {
            $value['video_myimg_url'] = str_replace('.jpg','_200_130.jpg',$value['video_myimg_url']);
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
    }
    //删除视频信息
    public function videoDeleteInfoForever ()
    {   
        $login_name=trim(getLoginName());
        if(empty($login_name)) {
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');//room_id
        $VodLogic = new \Logic\VODClientLogic(); 
        $VodLogic->modifyHouseRoomVideoZero($data['room_id']);
        $VodLogic->deleteHousevideoInfo($data);
        $cache_key="model_get_by_room_id_video".$data['room_id'];
        $cache_key=set_cache_public_key($cache_key);           
        set_redis_data($cache_key,"the data is null!",60*20);
    }
    //创建视频信息
    public function videoCreateInfo ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');
        $VodLogic = new \Logic\VODClientLogic(); 
        $info =  $VodLogic->findHousevideo($data['room_id']);
        if($info['id'] != null) {
            $VodLogic->updateHousevideoImg($data);
        } else {
            $result = $VodLogic->createHousevideo($data);
            $VodLogic->modifyHouseRoomVideo($data['room_id']);  
            $cache_key="model_get_by_room_id_video".$data['room_id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
        }
    }
    //更新房间图片信息
    public function videoUpdateImgInfo ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');
        $VodLogic = new \Logic\VODClientLogic(); 
        $result =  $VodLogic->updateHousevideoImg($data);
        $cache_key="model_get_by_room_id_video".$data['room_id'];
        $cache_key=set_cache_public_key($cache_key);           
        set_redis_data($cache_key,"the data is null!",60*20);
        echo json_encode($result);return;
    }
    //删除视频信息
    public function videoDeleteInfo ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');
        $VodLogic = new \Logic\VODClientLogic(); 
        $result =  $VodLogic->deleteHousevideoInfo($data);
    }
    //统计视频上传次数
    public function videoCountNum ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $VodLogic = new \Logic\VODClientLogic(); 
        $num =  $VodLogic->countHouseVideo();
        echo $num;
    }
}
?>
<?php
namespace Home\Controller;
use Think\Controller;
class StoresController extends Controller
{
    //店铺查询
    public function storesList ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $name = I('get.name');
        $type=I('get.type');
        $downScore = I('get.downScore');
        $upScore = I('get.upScore');
        $storeId = I('get.storeId');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
        $where['is_special'] = 0;
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
        if($name != "") {
            $where['name']=array('like','%'.$name.'%');
        }
        if($type != "") {
            $where['medal_type']=array('eq',$type);
        }
        if($downScore !="" && $upScore =="") {
            $where['credit_score'] = array(array('egt',$downScore),array('elt',500));
        }
        if($upScore !="" && $downScore =="") {
            $where['credit_score'] = array(array('egt',0),array('elt',$upScore));
        }
        if($downScore !="" && $upScore !="") {
            $where['credit_score'] = array(array('egt',$downScore),array('elt',$upScore));
        }
        if($downScore !="" && $upScore !="" && $downScore==$upScore) {
            $where['credit_score'] = array('eq',$downScore);
        }
        if($storeId != "") {
            $where['id']=array('eq',$storeId);
        }
        $stores = new \Home\Model\stores();
        $fields = 'id,name,medal_type,create_time,update_time,credit_score,earnestmoney';
        $count=$stores->modelGetCount($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetStores($Page->firstRow,$Page->listRows,$fields,$where);
        $storeManage = new \Logic\StoresManage();
        foreach($data as $val) {
            $list['id'] = $val['id'];
            $list['title'] = $val['name'];
            $list['type'] = $val['medal_type'];
            $list['time'] = $val['create_time'];
            $list['update_time'] = $val['update_time'];
            $cid = $storeManage->getCustomerId($val['id']);
            $result = $storeManage->getCustomerInfo($cid['customer_id']);
            $list['mobile'] = $result['mobile'];
            $list['name'] = $result['true_name'];
            $list['num'] = $storeManage->countRoomNum($val['id']);
            $list['credit_score'] = $val['credit_score'];
            $list['earnestmoney'] = $val['earnestmoney'];
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //店铺人员查询
    public function storePerson ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $mobile=I('get.mobile');
        $where = array();
        $where['record_status'] = 1;
        if($mobile != "") {
            $where['mobile']=$mobile;
            $storeManage = new \Logic\StoresManage();
            $storeId = $storeManage->getStoreIdByMobile($where);
            foreach($storeId as $v) {
                $condition['id'] = $v['store_id'];
                $stores = new \Home\Model\stores();
                $fields = 'id,name,medal_type,create_time,update_time,credit_score,earnestmoney';
                $result=$stores->modelGetStores('','',$fields,$condition);
                $data[]= $result[0];
                }
            foreach($data as $val) {
                $list['id'] = $val['id'];
                $list['title'] = $val['name'];
                $list['type'] = $val['medal_type'];
                $list['time'] = $val['create_time'];
                $list['update_time'] = $val['update_time'];
                $cid = $storeManage->getCustomerId($val['id']);
                $result = $storeManage->getCustomerInfo($cid['customer_id']);
                $list['mobile'] = $result['mobile'];
                $list['name'] = $result['true_name'];
                $list['num'] = $storeManage->countRoomNum($val['id']);
                $list['credit_score'] = $val['credit_score'];
                $list['earnestmoney'] = $val['earnestmoney'];
                $info[] = $list; 
                } 
        } else {
            $info = array();
        }
        // $count=$stores->modelGetCount($condition);
        // $Page= new \Think\Page($count,10);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        // $this->assign("pagecount",$count);
        // $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //创建店铺信息
    public function storeCreate ()
    {
        //验证当前登录状态
        $handleCommonCache = new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()) {
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity = $handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->display();
    }
    //新增店铺
    public function storeAdd ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $post = I('post.');
        $storeId = $storeManage->findStoreIdByName($post['name']);
        if(isset($storeId)) {
            $this->error("新增失败,该店铺名称已存在！","storeCreate.html?no=162&leftno=164"); 
        }
        $result = $storeManage->findCustomerId($post['mobile']);
        if($result == false||$result == null) {
            $this->error("该手机号不存在,请先在房东版APP端登录注册店长手机号","storeCreate.html?no=162&leftno=164");
        }
        //查找店长店铺名称
        // $cid = $result['id'];
        // $storeName = $storeManage->findStoreName($cid);
        // if(isset($storeName['store_name'])) {
        //     $this->error("新增失败,该店长已拥有店铺，请勿重复添加","storeCreate.html?no=162&leftno=164");
        // }
        //增加店铺店长
        $data = $storeManage->createStoreInfo($post);
        $data['customer_id'] = $result['id'];
        $data['title_id'] = 300;
        $return = $storeManage->createStoreMem($data);
        $storeManage->createStoreMemLimit($data);
        if($return){
                $this->success('店铺新增成功','storesList.html?no=162&leftno=164');
            } else {
                $this->error('店铺新增失败','storesList.html?no=162&leftno=164');
            }
    }
    //店铺详情
    public function storeDetail ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time,credit_score,earnestmoney';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $storeManage = new \Logic\StoresManage();
        $cid = $storeManage->getAllCustomerId($id);
        foreach ($cid as $v) {
            $result = $storeManage->getCustomerInfo($v['customer_id']);
            $data['mobile'] = $result['mobile'];
            $data['name'] = $result['true_name'];
            $data['title'] = $v['title_id'];
            $members[] = $data;
        }
        $condition['store_id'] = $id;
        $condition['record_status'] = 1;
        $fields = 'room_no,room_money,status,create_time,id,customer_id as mobile';
        if($condition['store_id'] == '') {
            $count = 0;
            $data = null;   
        } else {
            $count=$stores->modelCountRoom($condition);
            $Page= new \Think\Page($count,10);
            $data=$stores->modelGetRoomInfo($Page->firstRow,$Page->listRows,$fields,$condition);
            foreach ($data as &$val){
                $val['mobile'] = $storeManage->getCustomerMobile ($val['mobile']);
            }
            unset($val);     
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("detail",$detail);
        $this->assign("members",$members);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
    }
    //显示店铺名称：
    public function storeTitle ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->display();
    }
    //修改店铺名称
    public function modifyStoreTitle ()
    {   
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('post.');
        $storeId = $storeManage->findStoreIdByName($data['name']);
        if(isset($storeId)) {
            $this->error("修改失败,该店铺名称已存在！","storeTitle.html?no=162&leftno=164&id={$data['id']}"); 
        }
        $return = $storeManage->modifyStoreTitle($data);
        if($return){
                $this->success("店铺名称修改成功","storeDetail.html?no=162&leftno=164&id={$data['id']}");
            } else {
                $this->error("店铺名称修改失败","storeDetail.html?no=162&leftno=164&id={$data['id']}");
            }
    }
    //显示店铺类型
    public function storeType ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->display();
    }
    //修改店铺类型
    public function modifyStoreType ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('post.');
        if($data['medal_type'] == $data['type']) {
            $this->error("修改失败,店铺已是当前类型,请勿重复操作","storeDetail.html?no=162&leftno=164&id={$data['id']}");
        }
        if($data['type'] == 1) {
            //金牌店铺下架置顶房源
            $storeManage->downStickyRoom($data['id']);
            $return = $storeManage->modifyStoreType($data);
        } else {
            $return = $storeManage->modifyStoreType($data);
        }
        if($return){
                $this->success("店铺类型修改成功","storeDetail.html?no=162&leftno=164&id={$data['id']}");
            } else {
                $this->error("店铺类型修改失败","storeDetail.html?no=162&leftno=164&id={$data['id']}");
            }
    }
     //显示店铺人员
    public function storeManager ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        //$handleMenu->jurisdiction();
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $storeManage = new \Logic\StoresManage();
        $cid = $storeManage->getAllCustomerId($id);
        foreach ($cid as $v) {
            $result = $storeManage->getCustomerInfo($v['customer_id']);
            $data['mobile'] = $result['mobile'];
            $data['name'] = $result['true_name'];
            $data['title'] = $v['title_id'];
            $members[] = $data;
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->assign('members',$members);
        $this->display();
    }
    //修改店铺店长
    public function modifyStoreManager ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $data = I('post.');
        if ($data['title'] == 300) {
            echo "{'code':400,'message':'当前人员已为店长，请勿重复设置','data':{}}";return;
        }
        $storeManage = new \Logic\StoresManage();
        //检验是否重复操作
        $cid = $storeManage->findCustomerId($data['mobile']);
        $cids = $storeManage->getAllCustomerId($data['id']); 
        foreach ($cids as $val) {
            if($val['title_id'] == 300) {
                if($cid['id'] == $val['customer_id']) {
                    echo "{'code':400,'message':'当前人员已为店长，请勿重复设置','data':{}}";return;
                } else {
                    $condition['store_id'] = $data['id'];
                    $condition['customer_id'] = $val['customer_id'];
                    $condition['title_id'] = 100; 
                    $return = $storeManage->modifyStoreMemTitle($condition);
                }
            }
        }
        $status['store_id'] = $data['id'];
        $status['customer_id'] = $cid['id'];
        $status['title_id'] = 300; 
        $result = $storeManage->modifyStoreMemTitle($status);
        if($result) {
            echo "{'code':200,'message':'店长设置成功','data': {}}";  
        }
    }
    //显示店铺信息
    public function storeHouses ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $storeManage = new \Logic\StoresManage();
        $cid = $storeManage->getAllCustomerId($id);
        foreach ($cid as $v) {
            $result = $storeManage->getCustomerInfo($v['customer_id']);
            $data['mobile'] = $result['mobile'];
            $data['name'] = $result['true_name'];
            $data['title'] = $v['title_id'];
            $members[] = $data;
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->assign('members',$members);
        $this->display();
    }
    //移动房源到店铺
    public function modifyStoreHouses ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('post.');
        if(empty($data['mobile'])) {
            echo "{'code':400,'message':'请先选择房源要转给的店员！','data': {}}";return;
        }
        $cid = $storeManage->findCustomerId($data['mobile']);//new_cid
        $sid = $data['id'];//new_sid
        $string=str_replace("，",",",$data['room_no']);
        $arr = explode(',',$string);
        foreach ($arr as $v) {
            $val = trim($v);
            $result = $storeManage->findResourceId($val);  
            if($result == false||$result == null||$result['resource_id'] == null||$result['record_status'] == 0) {
                echo "{'code':400,'message':'房源(编号错误或已删除),请核对后再试！','data': {}}";return;
            } else {
                $info['customer_id'] = $cid['id'];
                $info['resource_id'] = $result['resource_id'];
                $info['store_id'] = $sid;
                $info['room_no'] = $val; 
                $storeManage->modifyHouseRoom($info);
                $storeManage->modifyHouseResource($info);
                $storeManage->modifyStoreHouses($info);
                $storeManage->modifyHouseSelectStoreId($info);
                //生成房源转移记录
                $info['room_id'] = $result['id'];
                $info['house_id'] = $result['resource_id'];
                $info['customer_id_old'] = $result['customer_id'];
                $info['store_id_old'] = $result['store_id'];
                $storeManage->createStoreOperDetail($info);
            }
        }
        echo "{'code':200,'message':'移动房源操作成功！','data': {}}";  
    }
    //显示新增店员
    public function storeMember ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        //$handleMenu->jurisdiction();
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->display();
    }
    //查询店员手机号是否存在
    public function storeMemMobile ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $post = I('post.');
        $result = $storeManage->findCustomerId($post['mobile']);
        if($result == false||$result == null) {
            echo "{'code':400,'message':'该手机号不存在,请先在APP端登录注册该手机号!','data': {}}";
            return;
        } else {
            $info = $storeManage->getAllCustomerId($post['id']);
            foreach ($info as $val) {
                $arr[] = $val['customer_id'];
            }
            if (in_array($result['id'], $arr)) {
                echo "{'code':400,'message':'该人员已在当前店铺,无需重复添加!','data': {}}";
                return;
            } else {
                $data['store_id'] = $post['id'];
                $name = $storeManage->findStoreTitle($post['id']);
                $data['store_name'] = $name['name'];
                $data['customer_id'] = $result['id'];
                $data['title_id'] = 100;
                $return = $storeManage->createStoreMem($data);
                $storeManage->UpdateStoreMan($post['id']);
                $storeManage->createStoreMemLimit($data);
                if($return) {
                    echo "{'code':200,'message':'新增店员添加成功!','data': {}}";
                }
            }  
        }
    }
    //显示新增店员的房源
    public function storeMemHouses ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $storeId = I('get.id');
        $mobile = I('get.mobile');
        $storeManage = new \Logic\StoresManage();
        $result = $storeManage->findCustomerId($mobile);
        if($result == false||$result == null) {
            $this->success("该手机号不存在,请先在APP端登录注册该手机号!","storeDetail.html?no=162&leftno=164&id={$storeId}");
            return;
        } else {
            $info = $storeManage->getAllCustomerId($storeId);
            foreach ($info as $val) {
                $arr[] = $val['customer_id'];
            }
            if (in_array($result['id'], $arr)) {
                $this->success("该人员已在当前店铺,无需重复添加!","storeDetail.html?no=162&leftno=164&id={$storeId}");
                return;
            }
        }
        $stores = new \Home\Model\stores();  
        $where = array();
        $where['customer_id'] = $result['id'];
        $where['city_code'] = C('city_code');
        $where['record_status'] = 1;
        $fields = 'room_no,room_money,status,create_time,id,customer_id as mobile';
        $count=$stores->modelCountRoom($where);
        $Page= new \Think\Page($count,20);
        $data=$stores->modelGetRoomInfo($Page->firstRow,$Page->listRows,$fields,$where);
        foreach ($data as &$val) {
            $val['mobile'] = $storeManage->getCustomerMobile ($val['mobile']);
        }
        unset($val);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("storeId",$storeId);
        $this->assign("mobile",$mobile);
        $this->assign('list',$data);
        $this->display();
    }
    //移动选中房源
    public function storeMoveHouses ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        // 将选择的房间移动到当前店铺下
        $storeManage = new \Logic\StoresManage();
        $room = I("post.room_no");
        $storeId = I("post.store_id");
        $mobile = I("post.mobile");
        $data['store_id'] = $storeId;
        $name = $storeManage->findStoreTitle($storeId);
        $result = $storeManage->findCustomerId($mobile);
        $data['store_name'] = $name['name'];
        $data['customer_id'] = $result['id'];
        $data['title_id'] = 100;
        $return = $storeManage->createStoreMem($data);
        $storeManage->UpdateStoreMan($post['id']);
        $storeManage->createStoreMemLimit($data);
        if($room != null) {
            $list = explode(",",$room);
            foreach ($list as $v) {
                $param = array();
                $param['store_id'] = $storeId;
                $param['room_no'] = trim($v);
                $storeManage->modifyRoomStoreId($param);
                $storeManage->modifyHouseStoreId($param); 
                $storeManage->modifyHouseSelectStoreId($param);
                //生成房源转移记录
                $temp = $storeManage->findResourceId(trim($v));
                $param['customer_id'] = $result['id'];
                $param['room_id'] = $temp['id'];
                $param['house_id'] = $temp['resource_id'];
                $param['customer_id_old'] = $temp['customer_id'];
                $param['store_id_old'] = $temp['store_id'];
                $storeManage->createStoreOperDetail($param);
            }       
        }
        if($return) {
            echo "{'code':200,'message':'新增店员添加成功!','data': {}}";
        }
    }
    //根据手机号移动房源
    public function storeMobileHouses ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $storeManage = new \Logic\StoresManage();
        $cid = $storeManage->getAllCustomerId($id);
        foreach ($cid as $v) {
            $result = $storeManage->getCustomerInfo($v['customer_id']);
            $data['mobile'] = $result['mobile'];
            $data['name'] = $result['true_name'];
            $data['title'] = $v['title_id'];
            $members[] = $data;
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->assign('members',$members);
        $this->display();
    }
    //修改输入手机号的房源
    public function modifyStoreMobileHouses ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('post.');
        $mobile = $data['mobile'];
        $sid = $data['id'];//new_sid
        $inputMobile = $data['inputMobile'];
        if(empty($mobile)) {
            echo "{'code':400,'message':'请先选择房源要转给的店员！','data': {}}";return;
        }
        $temp = $storeManage->findCustomerId($inputMobile);
        if($temp == false||$temp == null) {
            echo "{'code':400,'message':'该手机号不存在,请先在APP端登录注册该手机号!','data': {}}";return;
        } else {   
            if ($mobile == $inputMobile) {
                echo "{'code':400,'message':'转移手机号不能和选中手机号相同!','data': {}}";return;
            }
        }
        $cid = $storeManage->findCustomerId($mobile);//new_cid 
        $inputCid = $storeManage->findCustomerId($inputMobile);//input_cid
        $rooms = array();
        $rooms = $storeManage->getHouseRoomInfo($inputCid['id']);
        foreach ($rooms as $val) {
            $info['resource_id'] = $val['resource_id'];
            $info['room_no'] = $val['room_no'];      
            $info['customer_id'] = $cid['id'];
            $info['store_id'] = $sid;
            $storeManage->modifyHouseRoom($info);
            $storeManage->modifyHouseResource($info);
            $storeManage->modifyHouseSelectStoreId($info);
            //生成房源转移记录
            $result = $storeManage->findResourceId($val['room_no']);
            $info['room_id'] = $result['id'];
            $info['house_id'] = $result['resource_id'];
            $info['customer_id_old'] = $result['customer_id'];
            $info['store_id_old'] = $result['store_id'];
            $storeManage->createStoreOperDetail($info);
        }
        echo "{'code':200,'message':'移动房源操作成功！','data': {}}";  
    } 
    //显示看房列表信息
    public function houseShowList ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $storeManage = new \Logic\StoresManage();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $mobile = I('get.mobile');
        $name = I('get.name');
        $status = I('get.record_status'); 
        $where = array();
        $where['city_code'] = C('CITY_CODE');
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
        if($mobile != "") {
            //根据手机号查找owner_id
            $owner_id = $storeManage->findCustomerId($mobile);
            $oid = $owner_id['id'];
            $where['owner_id']=array('eq',$oid);
        }
        if($name != "") {
            $where['store_name']=array('like','%'.$name.'%');
        }
        if($status != "") {
            $where['record_status']=array('eq',$status);
        }
        $stores = new \Home\Model\stores();
        $fields = 'id,store_id,store_name,owner_id,is_deal,room_no,room_id,customer_id,create_time,record_status,is_true_deal,is_true_show';
        $count=$stores->modelGetFbackCount($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetFback($Page->firstRow,$Page->listRows,$fields,$where);
        foreach($data as $val) {
            $list['id'] = $val['id'];
            $list['store_id'] = $val['store_id'];
            $list['store_name'] = $val['store_name'];
            $return = $storeManage->getCustomerInfo($val['owner_id']);
            $list['owner_mobile'] = $return['mobile'];
            $list['type'] = $val['is_deal'];
            $list['room_no'] = $val['room_no'];
            $list['room_id'] = $value['room_id'];
            $back = $storeManage->findRoomMoney($val['room_no']);
            $list['room_money'] = $back['room_money']; 
            $return = $storeManage->getCustomerInfo($val['customer_id']);
            $list['customer_mobile'] = $return['mobile'];
            $list['create_time'] = $val['create_time'];
            $list['status'] = $val['record_status'];
            $list['is_true_deal'] = $val['is_true_deal'];
            $list['is_true_show'] = $val['is_true_show'];
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //根据id删除反馈信息
    public function deleteHouseFback ()
    {
        $storeManage = new \Logic\StoresManage();
        $data = I('get.');
        $login_name=trim(getLoginName());
        $data['update_man'] = $login_name;
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $result = $storeManage->deleteHouseFback($data);
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
            }
    }
    //根据id删除房源信息
    public function deleteHouseRoom ()
    {
        $storeManage = new \Logic\StoresManage();
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $result = $storeManage->deleteHouseRoom($data);
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
            }
    }
    //根据id判断主动反馈成交更改信用分
    public function modifyHouseFback ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('get.');
        $info = $storeManage->findHouseFback($data['id']);

        if($data['is_true_deal'] == 1) {
            $temp = array();
            $temp['id'] = $data['id'];
            $temp['is_true_show'] = 1;
            $storeManage->modifyHouseFbackIsShow($temp);
            $commission = $storeManage->findCommission($info['room_no']); 
            if($commission['is_commission'] == 1 || $commission['is_monthly'] == 1) {
                $return = $storeManage->findHouseFbackInfo($info['room_no']);
                if($return) {
                    $data['is_true_deal'] = 0;
                    $result = $storeManage->modifyHouseFback($data);
                } else {
                    $temp['score_type'] = 3;
                    $temp['id'] = $info['store_id'];
                    $temp['msg_txt'] = '';
                    $temp['room_no'] = $info['room_no'];
                    $storeManage->createStoreCreditDetail($temp);
                    $result = $storeManage->modifyHouseFback($data);       
                }
            } else {
            $result = $storeManage->modifyHouseFback($data);              
            }
        } else {
            $result = $storeManage->modifyHouseFback($data);
        }
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //根据id判断主动反馈是否看房
    public function modifyHouseFbackIsShow ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('get.');
        $result = $storeManage->modifyHouseFbackIsShow($data);
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //显示店铺信用分信息
    public function storeCreditScore ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $fields = 'id,name,medal_type,create_time,credit_score,earnestmoney';
        $where = array();
        $where['id'] = $id;
        $chars = 'now_score,score_num,create_time,score_type,oper_man_name,msg_txt,memo';
        $condition = array();
        $condition['store_id'] = $id;
        if($startTime!=""&&$endTime=="") {
            $condition['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $condition['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $condition['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $condition['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        $stores = new \Home\Model\stores();
        $detail = $stores->modelFindStore($fields,$where);
        $count = $stores->modelCountStoreCreditDetail($condition);
        $Page= new \Think\Page($count,10);
        $list = $stores->modelGetStoreCreditDetail($Page->firstRow,$Page->listRows,$chars,$condition);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign('detail',$detail);
        $this->assign('list',$list);
        $this->display();
    }
    //显示更改信用分
    public function storeModifyCreScore ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time,credit_score,earnestmoney';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('detail',$detail);
        $this->display();
    }
    //修改信用分
    public function modifyCreScore ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = array();
        $data = I('post.');
        //更改店铺信用分
        $cid = $storeManage->getCustomerId($data['id']);
        $data['customer_id'] = $cid['customer_id'];
        $return = $storeManage->createStoreCreditDetail($data);
        $info = json_decode($return,true);
        if($info['status'] == 200){
            $this->success('店铺信用分修改成功',"storeCreditScore.html?no=162&leftno=164&id={$data['id']}");
        } else {
            $this->error($info['message'],"storeCreditScore.html?no=162&leftno=164&id={$data['id']}");
        }    
    }
    //显示店铺保证金
    public function storeDeposit()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time,credit_score,earnestmoney';
        $where = array();
        $where['id'] = $id;
        $chars = 'price,oper_man_id,oper_man_name,create_time,remark';
        $condition = array();
        $condition['store_id'] = $id;
        $stores = new \Home\Model\stores();
        $detail = $stores->modelFindStore($fields,$where);
        $count = $stores->modelCountEarnestmoney($condition);
        $Page= new \Think\Page($count,10);
        $result = array();
        $result = $stores->modelGetEarnestmoney($Page->firstRow,$Page->listRows,$chars,$condition);
        $list = array();
        $storeManage = new \Logic\StoresManage();
        foreach($result as $v) {
            $temp['price'] = $v['price'];
            $mobile = $storeManage->getCustomerInfo($v['oper_man_id']);
            $temp['mobile'] = $mobile['mobile'];
            $temp['oper_man_name'] = $v['oper_man_name'];
            $temp['create_time'] = $v['create_time'];
            $temp['remark'] = $v['remark'];
            $list[] = $temp;
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign('detail',$detail);
        $this->assign('list',$list);
        $this->display();
    }
    //创建店铺保证金记录
    public function createEarnestMoney ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = array();
        $data = I('post.');
        $result = $storeManage->createEarnestMoney($data);
        if($result) {
            $return = $storeManage->modifyEarnestMoney($data);
            if($return >=0){
                $storeManage->pushNotice($data);
                
                $this->success('店铺保证金修改成功',"storeDetail.html?no=162&leftno=164&id={$data['id']}");
            } else {
                $this->error('店铺保证金修改失败',"storeDetail.html?no=162&leftno=164&id={$data['id']}");
            } 
        } else {
            $this->error("店铺保证金修改失败","storeDetail.html?no=162&leftno=164&id={$data['id']}");
        }
    }
    //我的房源店铺查询
    public function storeMyHouses ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $mobile = I('get.mobile');
        $storeId = I('get.storeId');
        $where = array();
        $where['record_status'] = 1;
        $where['is_special'] = 1;
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
        if($mobile == "" && $storeId != "") {
            $where['id']=array('eq',$storeId);     
        }
        $storeManage = new \Logic\StoresManage();
        if($mobile != "" && $storeId == "") {
            $condition['mobile']=$mobile;
            $condition['record_status'] = 1;
            $sid = $storeManage->getMyHouseStoreIdByMobile($condition);
            $where['id'] = array('eq',$sid);
        }
        if($mobile != "" && $storeId != "") {
                $where['id'] = array('eq',$storeId); 
        }
        $stores = new \Home\Model\stores();
        $fields = 'id,name,create_time';
        $count=$stores->modelGetCount($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetStores($Page->firstRow,$Page->listRows,$fields,$where);
        foreach($data as $val) {
            $list['id'] = $val['id'];
            $list['title'] = $val['name'];
            $list['time'] = $val['create_time'];
            $cid = $storeManage->getCustomerId($val['id']);
            $result = $storeManage->getCustomerInfo($cid['customer_id']);
            $list['mobile'] = $result['mobile'];
            $list['name'] = $result['true_name'];
            $list['num'] = $storeManage->countRoomNum($val['id']);
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //店铺详情
    public function storeMyHouseDetail ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $id = I('get.id');
        $fields = 'id,name,medal_type,create_time,credit_score,earnestmoney';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $detail=$stores->modelFindStore($fields,$where);
        $storeManage = new \Logic\StoresManage();
        $cid = $storeManage->getAllCustomerId($id);
        foreach ($cid as $v) {
            $result = $storeManage->getCustomerInfo($v['customer_id']);
            $data['mobile'] = $result['mobile'];
            $data['name'] = $result['true_name'];
            $data['title'] = $v['title_id'];
            $members[] = $data;
        }
        $condition['store_id'] = $id;
        $condition['record_status'] = 1;
        $fields = 'city_code,room_no,room_money,status,create_time,id,customer_id';
        $data=$stores->modelGetRoomInfo('','',$fields,$condition);
        if($data == null) {
            $info = array();
        } else {
            $temp = array();
            foreach ($data as $val){
                if($val['city_code'] != C('CITY_CODE')) continue;
                    $temp['room_no'] = $val['room_no'];
                    $temp['room_money'] = $val['room_money'];
                    $temp['status'] = $val['status'];
                    $temp['create_time'] = $val['create_time'];
                    $temp['id'] = $val['id'];
                    $temp['mobile'] = $storeManage->getCustomerMobile($val['customer_id']);       
                    $info[] = $temp;
            }        
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("detail",$detail);
        $this->assign("members",$members);
        $this->assign("list",$info);
        $this->display("storeDetail");
    }
    //成交列表
    public function bargainResultList ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $handleMenu->jurisdiction();
        $storeManage = new \Logic\StoresManage();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $feedbackerMobile = I('get.feedbacker_mobile');
        $customerMobile = I('get.customer_mobile');
        $storeName = I('get.store_name');
        $deal = I('get.is_deal');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['record_status'] = 1;
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
        if($customerMobile != "") {         
            $where['customer_mobile']=array('eq',$customerMobile);
        }
        if($feedbackerMobile != "") {
            $where['feedbacker_mobile']=array('eq',$feedbackerMobile);
        }
        if($storeName != "") {
            $storeID = $storeManage->findStoreIdByName($storeName);
            if($storeID['id'] != "") {
                $where['store_id']=array('eq',$storeID['id']);   
            }
        }
        if($deal != "") {
            $where['is_deal']=array('eq',$deal);
        }
        $stores = new \Home\Model\stores();
        $fields = 'id,feedbacker_mobile,customer_mobile,renter_price,renter_monther,room_no,room_id,create_time,is_deal';
        $count=$stores->modelCountHouseDeal($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetHouseDeal($Page->firstRow,$Page->listRows,$fields,$where);
        foreach($data as $value) {
            $list['id'] = $value['id'];
            $list['store_id'] = $value['store_id'];
            $temp = $storeManage->findStoreTitle($value['store_id']);
            $list['store_name'] = $temp['name'];
            $list['feedbacker_mobile'] = $value['feedbacker_mobile'];
            $list['customer_mobile'] = $value['customer_mobile'];
            $list['renter_price'] = $value['renter_price'];
            $list['renter_monther'] = $value['renter_monther'];
            $list['room_no'] = $value['room_no'];
            $list['room_id'] = $value['room_id'];
            $list['create_time'] = $value['create_time']; 
            $list['is_deal'] = $value['is_deal'];
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //成交列表根据id判断主动反馈成交更改信用分
    public function modifyHouseDeal ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('get.');//id,is_deal
        $info = $storeManage->findHouseDeal($data['id']);
        if($data['is_deal'] == 1) {
            // $commission = $storeManage->findCommission($info['room_no']); 
            // if($commission['is_commission'] == 1 || $commission['is_monthly'] == 1) {
                // $temp = array();
                // $temp['id'] = $data['id'];
                // $temp['room_no'] = $info['room_no'];
                // $temp['score_type'] = 3;
                // $temp['id'] = $info['store_id'];
                // $temp['msg_txt'] = '';
                // $storeManage->createStoreCreditDetail($temp);
                $result = $storeManage->modifyHouseDeal($data);       
            // } else {
                // $result = $storeManage->modifyHouseDeal($data); 
            // }
        } elseif($data['is_deal'] == 2) {
            $result = $storeManage->modifyHouseDeal($data);
        }
        if($result) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //成交详情
    public function bargainResultDetail ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $id = I('get.id');
        $fields = 'store_id,feedbacker_mobile,customer_mobile,owner_id,renter_price,renter_monther,room_no,create_time,update_man';
        $where['id'] = $id;
        $stores = new \Home\Model\stores();
        $storeManage = new \Logic\StoresManage();
        $info = array();
        $data = $stores->modelFindHouseDeal($fields,$where);
        $temp = $storeManage->findStoreTitle($data['store_id']);
        $data['store_name'] = $temp['name'];
        $tempSecond = $storeManage->assessCommission($data['renter_price'],$data['owner_id']);
        $data['commission_price'] = $tempSecond['commission_price'];
        $data['commission'] = $tempSecond['commission'];
        $data['monthly'] = $tempSecond['monthly'];
        $data['commission_discount'] = '无';
        $this->assign("detail",$data);
        $this->display();
    }
    //反馈奖励
    public function feedBackReward ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $storeManage = new \Logic\StoresManage();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $feedbackerMobile = I('get.feedbacker_mobile');
        $storeName = I('get.store_name');
        $cityCode = I('get.city_code');
        $where = array();
        $where['a.is_deal'] = 1;
        $where['a.record_status'] = 1;
        if($startTime!=""&&$endTime=="") {
            $where['a.create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['a.create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['a.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['a.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($feedbackerMobile != "") {
            $where['a.feedbacker_mobile']=array('eq',$feedbackerMobile);
        }
        if($storeName != "") {
            $storeID = $storeManage->findStoreIdByName($storeName);
            if($storeID['id'] != "") {
                $where['a.store_id']=array('eq',$storeID['id']);   
            }
        }
        if($cityCode !="") {
            $where['a.city_code']=array('eq',$cityCode);
        }
        $stores = new \Home\Model\stores();
        $fields = 'a.id,a.store_id,a.feedbacker_mobile,a.renter_price,a.city_code,a.room_no,a.create_time,b.price,b.is_send';
        $count = $stores->modelCountDealLottery($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetDealLottery($Page->firstRow,$Page->listRows,$fields,$where);
        foreach($data as $value) {
            $list['id'] = $value['id'];
            $list['store_id'] = $value['store_id'];
            $temp = $storeManage->findStoreTitle($value['store_id']);
            $list['store_name'] = $temp['name'];
            $list['feedbacker_mobile'] = $value['feedbacker_mobile'];
            $list['renter_price'] = $value['renter_price'];
            $list['city_code'] = $value['city_code'];
            $list['room_no'] = $value['room_no'];
            $list['create_time'] = $value['create_time']; 
            $list['price'] = $value['price'];
            $list['is_send'] = $value['is_send'];
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    public function modifyHouseDealLottery ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","msg":"登录失效"}';return;
        }
        $storeManage = new \Logic\StoresManage();
        $data = I('post.');//id,customer_id,mobile,price,is_send
        $result = $storeManage->modifyHouseDealLottery($data);
        $sendArr['phonenumber']=$data['mobile'];
        $sendArr['smstype']= 'FHS017';
        $sendArr['timestamp']=time();
        $sendArr['name']="反馈奖励";
        $sendArr['money']=$data['price'];
        $sendArr['orderid']="0";
        sendPhoneContent($sendArr);
        if($result === 1 || $result === 0) {
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    } 
    //在线签约
    public function signOnLine ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache())
        {
            $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        $handleMenu->jurisdiction();
        $storeManage = new \Logic\StoresManage();
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $renterMobile = I('get.renter_mobile');
        $customerMobile = I('get.customer_mobile');
        $status = I('get.status_code');
        $where = array();
        $where['record_status'] = 1;
        if($startTime!=""&&$endTime=="") {
            $where['sign_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['sign_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['sign_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['sign_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($renterMobile != "") {
            $where['renter_mobile']=array('eq',$renterMobile);
        }
        if($customerMobile != "") {
            $where['customer_mobile']=array('eq',$customerMobile);
        }
        if($status != "") {
            $where['status_code']=array('eq',$status);
        }
        $stores = new \Home\Model\stores();
        $fields = 'id,customer_mobile,renter_name,renter_mobile,price,pledge_price,star_time,end_time,status_code,sign_time';
        $count=$stores->modelCountContractDetail($where);
        $Page= new \Think\Page($count,10);
        $data=$stores->modelGetContractDetail($Page->firstRow,$Page->listRows,$fields,$where);
        foreach($data as $value) {
            $list['id'] = $value['id'];
            $list['customer_mobile'] = $value['customer_mobile'];
            $list['renter_name'] = $value['renter_name'];
            $list['renter_mobile'] = $value['renter_mobile'];
            $list['price'] = $value['price'];
            $list['pledge_price'] = $value['pledge_price'];
            $list['rent_time'] = $storeManage->calculateTime($value['star_time'],$value['end_time']); 
            $list['status_code'] = $value['status_code'];
            $list['sign_time'] = $value['sign_time']; 
            $info[] = $list; 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$info);
        $this->display();
    }
    //导出在线签约excel
    public function downloadSignOnLineExcel() 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
        }
        //查询条件
        $startTime=strtotime(I('get.startTime'));
        $endTime=strtotime(I('get.endTime'));
        $renterMobile = I('get.renter_mobile');
        $customerMobile = I('get.customer_mobile');
        $status = I('get.status_code');
        $where = array();
        $where['record_status'] = 1;
        if($startTime!=""&&$endTime=="") {
            $where['sign_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['sign_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['sign_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['sign_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($renterMobile != "") {
            $where['renter_mobile']=array('eq',$renterMobile);
        }
        if($customerMobile != "") {
            $where['customer_mobile']=array('eq',$customerMobile);
        }
        if($status != "") {
            $where['status_code']=array('eq',$status);
        }
        $stores = new \Home\Model\stores();
        $storeManage = new \Logic\StoresManage();
        $fields = 'renter_mobile,renter_name,customer_mobile,price,pledge_price,status_code,sign_time,star_time,end_time';
        $data = $stores->modelGetContractDetail(0,10000,$fields,$where);
        $title=array(
            'renter_mobile'=>'租客手机号','renter_name'=>'租客姓名','customer_mobile'=>'房东手机号','price'=>'租金(元/月)','pledge_price'=>'押金(元)','rent_time'=>'租约时长','status_code'=>'合同状态','sign_time'=>'租客签约时间'
        );
        $excel[]=$title;
        foreach ($data as $key => $value) {
            $temp['renter_mobile'] = $value['renter_mobile'];
            $temp['renter_name'] = $value['renter_name'];
            $temp['customer_mobile'] = $value['customer_mobile'];
            $temp['price'] = $value['price'];
            $temp['pledge_price'] = $value['pledge_price'];
            $temp['rent_time'] = $storeManage->calculateTime($value['star_time'],$value['end_time']);
        switch ($value['status_code']) {
            case '0':
                $temp['status_code']='等待签约';
                break;
            case '1':
                $temp['status_code']='签约成功';
                break;
            case '2':
                $temp['status_code']='签约作废';
                break;
            case '3':
                $temp['status_code']='签约失效';
                break;
            case '4':
                $temp['status_code']='签约拒绝';
                break;
            case '5':
                $temp['status_code']='签约删除';
                break;
            default:
                $temp['status_code']='';
                break;
        }
            $temp['sign_time'] = $value['sign_time'] > 0 ? date("Y-m-d H:i",$value['sign_time']) : ""; 
            $excel[]=$temp;
      }
      Vendor('phpexcel.phpexcel');
      $xls = new \Excel_XML('UTF-8', false, '在线签约');
      $xls->addArray($excel);
      $xls->generateXML('在线签约'.date("YmdHis"));
    }
}
?>
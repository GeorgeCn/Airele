<?php
namespace Home\Controller;
use Think\Controller;
class CirclePostController extends Controller{

   //查看帖子列表
   public function circlePostList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),47);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),47);
      $handleMenu->jurisdiction();
      $handleCircle = new \Logic\CircleManage();
      $handleCircletags=new \Home\Model\circletags();
      $handleRegion = new \Logic\Paramregion();
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $circlename=I('get.postsname');
      $creatorphone=I('get.creatorphone');
      $creatorname=I('get.creatorname');
      $poststatus=I('get.poststatus');
      $region_id=I('get.region');
      $scope_id=I('get.scope');
      $nameboard=I('get.nameboard');
      $where['record_status']=array('eq',1);
       if($startTime!=""&&$endTime==""){
            $where['create_time']=array('gt',$startTime);
       }
       if($endTime!=""&&$startTime==""){
           $where['create_time']=array('lt',$endTime+86400);
       }
       if($startTime!=""&&$endTime!=""){
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($circlename!=""){
         $where['title']=array('like','%'.$circlename.'%');
      }
      if($creatorphone!=""||$creatorname!=""){
          if($creatorphone!=""){
            $where1['mobile']=array('eq',$creatorphone);
          }
          if($creatorname!=""){
             $where1['true_name']=array('like','%'.$creatorname.'%');
          }
          $cusarr=$handleCircle->getCustomerById($where1);

          $where['customer_id']=array('eq',strtolower($cusarr['id']));
      }
      if($poststatus!=""){
        if($poststatus!=99){
          $where['is_display']=$poststatus;
        }
      }else{
          $where['is_display']=1;
      }
      //区域板块搜索
      if($scope_id!=""){
          $tagswhere['relation_id']=$scope_id;
          $tagswhere['tag_type']=1;
          $tagswhere['city_code']=C('CITY_CODE');
          $circletags=$handleCircletags->modelFind($tagswhere);
          $where['_string']='FIND_IN_SET('.$circletags['id'].',plate_ids)';
      }
      //地铁站名搜索
      if($nameboard!=""){
          $boardwhere['name']=array('like','%'.$nameboard.'%');
          $boardwhere['tag_type']=0;
          $boardwhere['city_code']=C('CITY_CODE');
          $circleboard=$handleCircletags->modelSelect($boardwhere);
          foreach ($circleboard as $key => $value){
             $stand_ids[]=intval($value['id']);
          }
          //$newstand_ids = substr($stand_ids,0,strlen($stand_ids)-1);
          $where['stand_ids']=array('in',$stand_ids);
      }
      $count=$handleCircle->getCirclePostsCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val);
      }
      $listarr=$handleCircle->getCirclePostsList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
           $cuwhere['id']=$value['customer_id'];
           $customer=$handleCircle->getCustomerById($cuwhere);
           $value['cname']=$customer['true_name'];
           $value['mobile']=$customer['mobile'];
           $tagewhere['id']=$value['circle_id'];

           $plate=explode(',',$value['plate_ids']);
          if($value['plate_ids']!=""){
            for($index=0;$index<count($plate);$index++){
              $where2['id']=$plate[$index];
              $tagarr=$handleCircletags->modelFind($where2);
              $value['tagname'].=$tagarr['name'].",";
            }
          }
           $list[]=$value;
       }
       $where3['tag_type']=1;
       $where3['city_code']=C('CITY_CODE');
       $taglist=$handleCircletags->modelSelect($where3);
       $where4['parent_id']=0;
       $regionarr=$handleRegion->getParamRegionList($where4);

       $scopeList='<option value=""></option>';
      if(!empty($region_id)){
        //查询后，重新加载板块信息
        $handleLogic=new \Logic\HouseResourceLogic();
        $result=$handleLogic->getRegionScopeList();
        foreach ($result as $key => $value) {
          if($region_id==$value['parent_id']){
            if($value["id"]==$scope_id){
              $scopeList.='<option value="'.$value["id"].'" selected>'.$value["cname"].'</option>';
            }else{
              $scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
            }
          }
        }
      }
       $this->assign("scopeList",$scopeList);
       $this->assign("regionarr",$regionarr);
       $this->assign("taglist",$taglist);
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $this->assign("show",$Page->show());
       $this->assign("pagecount",$count);
       $this->assign("list",$list);
       $this->assign("postsid",$postsid);
       $this->display();
   }

   //隐藏显示帖子
   public function upPostsState(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }

     $circle_id=I('get.cid');
     $handleCircle = new \Logic\CircleManage();
     $handlePostselect=new \Home\Model\circlepostselect();
     $where['id']=$circle_id; 
     $data=$handleCircle->getCirclePostFind($where);
     $cirwhere['id']=$data['circle_id'];   
     $circlearr=$handleCircle->getCircleInfoFind($cirwhere);//获取圈子信息 
     if($data['is_display']==1){
        $data['is_display']=0;
        $circlearr['post_cnt']=$circlearr['post_cnt']-1;
        $where1['post_id']=$circle_id;
        $handlePostselect->modelDelete($where1); 
     }else{
        $data['is_display']=1;
        $circlearr['post_cnt']=$circlearr['post_cnt']+1;
        $this->addcirclepostselect($circle_id); 
     }
     $handleCircle->upCircleInfo($circlearr);//更新圈子话题总条数
     $result=$handleCircle->upCirclePost($data);
     if($result){
           $arrayjson=array('status'=>200,'is_display'=>$data['is_display']);
          echo json_encode($arrayjson);
      }
   }
   //帖子详情
   public function circlePostsDetails(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),47);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),47);

      $handleCircle = new \Logic\CircleManage();
      $postsid=$_GET['pid'];
      $replycontent=$_GET['replycontent'];
      $replyphone=$_GET['replyphone'];
      $replyname=$_GET['replyname'];
      $where['post_id']=array('eq',$postsid);
      $where['record_status']=array('eq',1);
      if($replycontent!=""){
         $where['reply_content']=array('like','%'.$replycontent.'%');
      }
      if($replyphone!=""||$replyname!=""){
          if($replyphone!=""){
             $where1['mobile']=array('eq',$replyphone);
          }
          if($replyname!=""){
             $where1['true_name']=array('eq',$replyname);
          }
          $cusarr=$handleCircle->getCustomerById($where1);
          $where['customer_id']=array('eq',$cusarr['id']);
      }
      $count=$handleCircle->getCirclePostsReplayCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val);
      }
      $listarr=$handleCircle->getCirclePostReplay($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value){
           $cuwhere['id']=$value['customer_id'];
           $customer=$handleCircle->getCustomerById($cuwhere);
           $value['cname']=$customer['true_name'];
           $value['mobile']=$customer['mobile'];
           $list[]=$value;
       }
      $postwhere['id']=$postsid;
      $posttitle=$handleCircle->getCirclePostFind($postwhere);
      //帖子图片
       $modelCircleimg=new \Home\Model\circleimg();
       $imgwhere['relation_id']=$postsid;
      $imgarr=$modelCircleimg->modelSelect($imgwhere);
      foreach ($imgarr as $key => $value) {
        $value['img_path']=C('IMG_SERVICE_URL').$value['img_path'].$value['img_name']."_200_200.".$value['img_ext'];
        $newimg[]=$value;     
       }
      $this->assign("imgarr",$newimg);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("posttitle",$posttitle);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("postsid",$postsid);
      $this->display();
   }
   //回复状态
   public function upCircleReplayState(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
     $circle_id=$_GET['cid'];
     $postsid=$_GET['pid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id; 
     $postwhere['id']=$postsid;
     $postarr=$handleCircle->getCirclePostFind($postwhere);
     $data=$handleCircle->getPostReplayFind($where);
     if($data['is_display']==1){
        $data['is_display']=0;
        $postarr['replay_cnt']=$postarr['replay_cnt']-1; 
     }else{
        $data['is_display']=1;
        $postarr['replay_cnt']=$postarr['replay_cnt']+1; 
     }
     $handleCircle->upCirclePost($postarr);
     $result=$handleCircle->upReplayState($data);
     if($result){
          $arrayjson=array('status'=>200,'is_display'=>$data['is_display']);
           echo json_encode($arrayjson);
      }
   }
   //查看成员
   public function circleMember(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),47);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),47);
      $circle_id=$_GET['cid'];
      $circlename=$_GET['circlename'];
      $creatorphone=$_GET['creatorphone'];
      $handleCircle = new \Logic\CircleManage();
      $where['circle_id']=array('eq',$circle_id);
      $where['record_status']=array('eq',1);
      if($circlename!=""||$creatorphone!=""){
          if($creatorphone!=""){
            $where1['mobile']=array('eq',$creatorphone);
          }
          if($circlename!=""){
           $where1['true_name']=array('eq',$circlename);
          }
          $cusarr=$handleCircle->getCustomerById($where1);
          $where['customer_id']=array('eq',$cusarr['id']);
      }
      $count=$handleCircle->getCircleMemberCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val);
      }
      $listarr=$handleCircle->getCircleMember($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
           $cuwhere['id']=$value['customer_id'];
           $customer=$handleCircle->getCustomerById($cuwhere);
           $value['cname']=$customer['true_name'];
           $value['mobile']=$customer['mobile'];
           $list[]=$value;
       }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("postsid",$circle_id);
      $this->display();
   }
   //删除圈子成员
   public function delCircleMemberState(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
     $circle_id=$_GET['cid'];
     $postsid=$_GET['pid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id; 
     $where['circle_id']=$postsid;
     $result=$handleCircle->delCircleMember($where); 
     if($result){
        $this->success('删除成功！',U('CirclePost/circleMember',array('cid'=>$postsid)),0);
      }
   }
   //设为热门话题
   public function postHot(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
       $hot_id=$_GET['hid'];
       $handleCircle = new \Logic\CircleManage();
       $where['id']=$hot_id; 
       $data=$handleCircle->getCirclePostFind($where);
       if($data['is_hot']==0){
          $data['is_hot']=1;
       }else{
          $data['is_hot']=0;
       }
       $result=$handleCircle->upCirclePost($data);
       if($result){
          $this->success('更新成功！',U('CirclePost/circlePostList'),0);
        }
   }

    //回复话题
    public function replyPosts(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $handleCustomer = new \Logic\CustomerLogic();
        $handleCircle = new \Logic\CircleManage();
        $customer=$handleCustomer->getResourceClientByPhone($_POST['mobile']);
        $where['post_id']=$_POST['post_id'];
        $replymax=$handleCircle->getReplyPositionMax($where);
        $data['id']=create_guid();
        $data['post_id']=$_POST['post_id'];
        $data['reply_content']=$_POST['reply_content'];
        $data['customer_id']=$customer['id'];
        $data['reply_position']=$replymax+1;
        $data['create_time']=time();
        $data['record_status']=1;
        $data['is_display']=1;
        $data['is_send']=0;
        $data['parent_id']="";
        $data['parent_customer_id']=$_POST['parent_customer_id'];
        if($customer['id']==""){
           $this->success('该手机号不存在！',U('CirclePost/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
        }else{
            $postwhere['id']=$_POST['post_id'];
            $postarr=$handleCircle->getCirclePostFind($postwhere);
            $data['city_id']=$postarr['city_id'];
            $result=$handleCircle->addCirclePostrePlay($data);
            $postarr['replay_cnt']=$postarr['replay_cnt']+1;
            $postarr['update_time']=time();
            $handleCircle->upCirclePost($postarr);
            if($result){
              $this->success('回复成功！',U('CirclePost/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
            }
       }
    }

     //回复的回复话题
    public function layersReplyPosts(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $handleCustomer = new \Logic\CustomerLogic();
        $handleCircle = new \Logic\CircleManage();
        $customer=$handleCustomer->getResourceClientByPhone($_POST['mobile']);
        $where['post_id']=$_POST['post_id'];
        $replymax=$handleCircle->getReplyPositionMax($where);
        $data['id']=create_guid();
        $data['post_id']=$_POST['post_id'];
        $data['reply_content']=$_POST['reply_content'];
        $data['customer_id']=$customer['id'];
        $data['reply_position']=$replymax+1;
        $data['create_time']=time();
        $data['record_status']=1;
        $data['is_display']=1;
        $data['is_send']=0;
        $data['parent_id']=$_POST['js_parent_id'];
        $data['parent_customer_id']=$_POST['js_parent_customer_id'];
        if($customer['id']==""){
           $this->success('该手机号不存在！',U('CirclePost/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
        }else{
            $postwhere['id']=$_POST['post_id'];
            $postarr=$handleCircle->getCirclePostFind($postwhere);
            $data['city_id']=$postarr['city_id'];
            $result=$handleCircle->addCirclePostrePlay($data);
            $postarr['replay_cnt']=$postarr['replay_cnt']+1;
            $postarr['update_time']=time();
            $handleCircle->upCirclePost($postarr);
            if($result){
              $this->success('回复成功！',U('CirclePost/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
            }
       }
    }
    
   //ajax获取圈子回复数
   public function getAjaxCircleReply(){
       $handleCircle = new \Logic\CircleManage();
       $where['circle_id']=$_GET['id'];
       $result=$handleCircle->AjaxCircleReply($where);
       $this->assign("result",$result);
       $this->display();
   }

   public function addcirclepostselect($postid){
        $handlePostselect=new \Home\Model\circlepostselect();
        $handleCircletags=new \Home\Model\circletags();
        $handleCircle = new \Logic\CircleManage();
        $handleCustomerLogic = new \Logic\CustomerLogic();
        $where['id']=$postid;
        $data=$handleCircle->getCirclePostFind($where);
        $customer=$handleCustomerLogic->getModelById($data['customer_id']);
        if($customer['sex']==""){
           $customer['sex']=2;
        }
        $data1['id']=create_guid();
        $data1['tag_id']=0;
        $data1['post_id']=$postid;
        $data1['money_max']=$data['money_max'];
        $data1['money_min']=$data['money_min'];
        $data1['money']=$data['money'];
        $data1['sex']=$customer['sex'];
        $data1['room_type']=$data['room_type'];
        $data1['city_id']=$data['city_id'];
        $data1['create_time']=time();
        $data1['update_time']=$data['update_time'];
        $data1['owner_update_time']=$data['owner_update_time'];
        $data1['customer_id']=$data['customer_id'];
        $handlePostselect->modelAdd($data1);
        $tags="";
        if($data['stand_ids']!=""&&$data['plate_ids']==""){
           $tags=$data['stand_ids'];
        }elseif($data['stand_ids']==""&&$data['plate_ids']!=""){
           $tags=$data['plate_ids'];
        }elseif($data['stand_ids']!=""&&$data['plate_ids']!=""){
           $tags=$data['stand_ids'].",".$data['plate_ids'];
        }
        $plate=explode(',',$tags);
        if($tags!=""){
            for($index=0;$index<count($plate);$index++){
              $where1['id']=$plate[$index];
              $tagsarr=$handleCircletags->modelFind($where1);
              $dataplate['id']=create_guid();
              $dataplate['tag_id']=$tagsarr['id'];
              $dataplate['tag_name']=$tagsarr['name'];
              $dataplate['post_id']=$postid;
              $dataplate['money_max']=$data['money_max'];
              $dataplate['money_min']=$data['money_min'];
              $dataplate['money']=$data['money'];
              $dataplate['sex']=$customer['sex'];
              $dataplate['room_type']=$data['room_type'];
              $dataplate['city_id']=$data['city_id'];
              $dataplate['create_time']=time();
              $dataplate['update_time']=$data['update_time'];
              $dataplate['owner_update_time']=$data['owner_update_time'];
              $dataplate['customer_id']=$data['customer_id'];
              $handlePostselect->modelAdd($dataplate);
            }
         }
  }
  //添加板块
    public function addcircletags(){
       $handlePost = new \Logic\CircleManage();
       $handlePostselect=new \Home\Model\circlepostselect();
       $postid=I('get.postid');
       $tageid=I('get.tageid');
       $where['id']=$postid;
       $postarr=$handlePost->getCirclePostFind($where);
       if($postarr['plate_ids']==""){
          $postarr['plate_ids']=$tageid;
       }
       $result=$handlePost->upCirclePost($postarr);
       if($result){
          $where1['post_id']=$postid;
          $handlePostselect->modelDelete($where1); 
          $this->addcirclepostselect($postid);
           echo "{\"status\":\"200\",\"msg\":\"\"}"; 
       }
    }
     //获取是否是职业房东
    public function professionalowner(){
        $handleCustomer = new \Logic\CustomerLogic();
        $handleCustomerInfo = new \Logic\CustomerInfo();
        $circlemanage = new \Home\Model\circlemanage();
        $ownermobile=I('get.ownermobile');
        $post_id=I('get.post_id');
        $result=$handleCustomer->getResourceClientByPhone($ownermobile);
        $wherepost['id']=$post_id;
        $postdata=$circlemanage->modelCirclePostFind($wherepost);
        $result['is_deal']=$postdata['is_deal'];
        echo json_encode($result);
    }

    /*疑似职业房东 */
    public function setConfirmJobowner(){
        $mobile=I('get.ownermobile');
       if(empty($mobile)){
          echo '参数异常';return ;
       }
       $update_man=trim(getLoginName());
        if(empty($update_man)){
          echo '会话失效，请重新登录';return;
        }
       $data['id']=guid();
       $data['mobile']=$mobile;
       $source=I('get.source');
       if(empty($source)){
          $source='找室友';
       }
       $handleCustomer = new \Logic\CustomerLogic();
       $customerarr=$handleCustomer->getResourceClientByPhone($mobile);
       if($customerarr!=null && $customerarr['is_owner']==4){
         echo '已经是职业房东';return;
       }
       $customerinfoLogic=new \Logic\CustomerInfo();
       $result=$customerinfoLogic->addOwnerForCustomerinfo(array('mobile'=>$mobile,'customer_id'=>'','source'=>$source,'update_man'=>$update_man,'update_time'=>time()));
       if($result){
          $circlemanage = new \Home\Model\circlemanage();
          $wherepost['id']=I('get.post_id');
          $postdata=$circlemanage->modelCirclePostFind($wherepost);
          $postdata['is_deal']=1;
          $circlemanage->modelupCirclePost($postdata);
          echo '操作成功';
       }else{
          echo '操作失败';
       }
    }


    //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
      $handleCircle = new \Logic\CircleManage();
      $handleCircletags=new \Home\Model\circletags();
      $handleRegion = new \Logic\Paramregion();
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $circlename=I('get.postsname');
      $creatorphone=I('get.creatorphone');
      $creatorname=I('get.creatorname');
      $poststatus=I('get.poststatus');
      $region_id=I('get.region');
      $scope_id=I('get.scope');
      $nameboard=I('get.nameboard');
      $where['record_status']=array('eq',1);
       if($startTime!=""&&$endTime==""){
            $where['create_time']=array('gt',$startTime);
       }
       if($endTime!=""&&$startTime==""){
           $where['create_time']=array('lt',$endTime+86400);
       }
       if($startTime!=""&&$endTime!=""){
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($circlename!=""){
         $where['title']=array('like','%'.$circlename.'%');
      }
      if($creatorphone!=""||$creatorname!=""){
          if($creatorphone!=""){
            $where1['mobile']=array('eq',$creatorphone);
          }
          if($creatorname!=""){
             $where1['true_name']=array('like','%'.$creatorname.'%');
          }
          $cusarr=$handleCircle->getCustomerById($where1);

          $where['customer_id']=array('eq',strtolower($cusarr['id']));
      }
      if($poststatus!=""){
        if($poststatus!=99){
          $where['is_display']=$poststatus;
        }
      }else{
          $where['is_display']=1;
      }
      //区域板块搜索
      if($scope_id!=""){
          $tagswhere['relation_id']=$scope_id;
          $tagswhere['tag_type']=1;
          $tagswhere['city_code']=C('CITY_CODE');
          $circletags=$handleCircletags->modelFind($tagswhere);
          $where['_string']='FIND_IN_SET('.$circletags['id'].',plate_ids)';
      }
      //地铁站名搜索
      if($nameboard!=""){
          $boardwhere['name']=array('like','%'.$nameboard.'%');
          $boardwhere['tag_type']=0;
          $boardwhere['city_code']=C('CITY_CODE');
          $circleboard=$handleCircletags->modelSelect($boardwhere);
          foreach ($circleboard as $key => $value){
             $stand_ids[]=intval($value['id']);
          }
          //$newstand_ids = substr($stand_ids,0,strlen($stand_ids)-1);
          $where['stand_ids']=array('in',$stand_ids);
      }
      $listarr=$handleCircle->getCirclePostsList(0,999999999,$where);
      $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($listarr));
      foreach ($listarr as $key => $value) {
           $cuwhere['id']=$value['customer_id'];
           $customer=$handleCircle->getCustomerById($cuwhere);
           $value['cname']=$customer['true_name'];
           $value['mobile']=$customer['mobile'];
           $tagewhere['id']=$value['circle_id'];

           $plate=explode(',',$value['plate_ids']);
          if($value['plate_ids']!=""){
            for($index=0;$index<count($plate);$index++){
              $where2['id']=$plate[$index];
              $tagarr=$handleCircletags->modelFind($where2);
              $value['tagname'].=$tagarr['name'].",";
            }
          }
           $list[]=$value;
       }

         foreach ($list as $key => $value){
              $value1['tagname']=$value['tagname'];
              $value1['title']=$value['title'];
              $value1['replay_cnt']=$value['replay_cnt'];
              $value1['create_time']=$value['create_time'];
              $value1['cname']=$value['cname'];
              $value1['mobile']=$value['mobile'];
              $listarr1[]=$value1;
        }
        $title=array(
            'tagname'=>'板块与地铁','title'=>'帖子标题','replay_cnt'=>'回复数','create_time'=>'创建时间 ','cname'=>'创建人','mobile'=>'创建人手机'
        );
        $excel[]=$title;
        foreach ($listarr1 as $key => $value2) {
            $value2['create_time']=$value2['create_time']>0?date("Y-m-d H:i",$value2['create_time']):""; 
            $excel[]=$value2;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '帖子列表');
        $xls->addArray($excel);
        $xls->generateXML('帖子列表'.date("YmdHis"));
     }
}
?>
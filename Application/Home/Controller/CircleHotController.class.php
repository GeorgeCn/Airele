<?php
namespace Home\Controller;
use Think\Controller;
class CircleHotController extends Controller{
  //圈子列表
   public function circleHotList(){
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
      $handleCircleHot = new \Logic\CircleHot();
      $circlename=$_GET['circlename'];
      $creatorphone=$_GET['creatorphone'];
      $creatorname=$_GET['creatorname'];

      if($circlename!=""){
         $where['circleinfo.title']=array('like','%'.$circlename.'%');
      }
     
       $where['circleinfo.is_display']=array('eq',1);
       $where['circleinfo.record_status']=array('eq',1);
       $where['circleinfo.is_hot']=array('eq',1);
       if($creatorphone!=""||$creatorname!=""){
            if($creatorphone!=""){
               $where1['mobile']=array('eq',$creatorphone);
            }
            if($creatorname!=""){
               $where1['true_name']=array('like','%'.$creatorname.'%');
            }
          $cusarr=$handleCircle->getCustomerById($where1);
          $where['circlemember.customer_id']=array('eq',$cusarr['id']);
       }
        $count=$handleCircleHot->getCircleInfoCount($where);
       $Page= new \Think\Page($count,15);         
       foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val); 
       }
       $listarr=$handleCircleHot->getCircleInfoList($Page->firstRow,$Page->listRows,$where);
       foreach($listarr as $key => $value){
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
      $this->display();
   }
   //圈子状态
   public function upCircleState(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
     $circle_id=$_GET['hid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id;
     $data=$handleCircle->getCircleInfoFind($where);
     if($data['is_hot']==1){
        $data['is_hot']=0;
     }
     $result=$handleCircle->upCircleInfo($data);
     if($result){
        $this->success('更新成功！', 'circleHotList.html?no=47&leftno=51');
      }
   }
   //查看帖子列表
   public function circlePostsList(){
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
      $circlename=$_GET['postsname'];
      $creatorphone=$_GET['creatorphone'];
      $creatorname=$_GET['creatorname'];
      $postsid=$_GET['pid'];
      $where['circle_id']=array('eq',$postsid);
      $where['record_status']=array('eq',1);
      if($circlename!=""){
         $where['title']=array('like','%'.$circlename.'%');
      }
      if($creatorphone!=""||$creatorname!=""){
          if($creatorphone!=""){
          $where1['mobile']=array('eq',$creatorphone);
          }
          if($creatorname!=""){
             $where1['true_name']=array('eq',$creatorname);
          }
          $cusarr=$handleCircle->getCustomerById($where1);
          $where['customer_id']=array('eq',$cusarr['id']);
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
           $list[]=$value;
       }
       
      $cirtitle['id']=$postsid;
      $cirletitle=$handleCircle->getCircleInfoFind($cirtitle);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
       $this->assign("cirletitle",$cirletitle);
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
     $circle_id=$_GET['cid'];
     $postsid=$_GET['pid'];
     $handleCircle = new \Logic\CircleManage();
     $handlePostselect=new \Home\Model\circlepostselect();
     $where['id']=$circle_id;
     $cirwhere['id']=$postsid; 
     $circlearr=$handleCircle->getCircleInfoFind($cirwhere); 
     $data=$handleCircle->getCirclePostFind($where);
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
        $this->success('更新成功！',U('CircleHot/circlePostsList',array('pid'=>$postsid)),0);
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
       $rewhere['id']=$postsid;
      $post_title=$handleCircle->getCirclePostFind($rewhere);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("post_title",$post_title);
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
        $this->success('更新成功！',U('CircleHot/circlePostsDetails',array('pid'=>$postsid)),0);
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
      $cirtitle['id']=$circle_id;
      $cirletitle=$handleCircle->getCircleInfoFind($cirtitle);

      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("cirletitle",$cirletitle);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("postsid",$circle_id);
      $this->display();
   }
   //成员状态
   public function delCircleMemberState(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
     $circle_id=$_GET['cid'];
     $postsid=$_GET['pid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id; 
     $data=$handleCircle->getCircleMemberFind($where);
     if($data['record_status']==1){
        $data['record_status']=0;
     }
     $result=$handleCircle->upCircleMemberState($data); 
     if($result){
        $this->success('更新成功！',U('CircleHot/circleMember',array('cid'=>$postsid)),0);
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
           $this->success('该手机号不存在！',U('CircleHot/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
        }else{
            $postwhere['id']=$_POST['post_id'];
            $postarr=$handleCircle->getCirclePostFind($postwhere);
            $data['city_id']=$postarr['city_id'];
            $result=$handleCircle->addCirclePostrePlay($data);
            $postarr['replay_cnt']=$postarr['replay_cnt']+1;
            $postarr['update_time']=time();
            $handleCircle->upCirclePost($postarr);
            if($result){
              $this->success('回复成功！',U('CircleHot/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
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
           $this->success('该手机号不存在！',U('CircleHot/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
        }else{
            $postwhere['id']=$_POST['post_id'];
            $postarr=$handleCircle->getCirclePostFind($postwhere);
            $data['city_id']=$postarr['city_id'];
            $result=$handleCircle->addCirclePostrePlay($data);
            $postarr['replay_cnt']=$postarr['replay_cnt']+1;
            $postarr['update_time']=time();
            $handleCircle->upCirclePost($postarr);
            if($result){
              $this->success('回复成功！',U('CircleHot/circlePostsDetails',array('pid'=>$_POST['post_id'])),0);
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

   //排序异步处理
   public function sortDispose(){
      $handleCircle = new \Logic\CircleManage();
      $circle_id=$_POST['circle_id'];
      $val=$_POST['val'];
      $where['id']= $circle_id;
      if($circle_id==""||$val==""){
          echo "{\"status\":\"404\",\"msg\":\"数据错误！\"}";
      }else{
        $data=$handleCircle->getCircleInfoFind($where);
        $data['index_no']=$val;
        $result=$handleCircle->upSortDispose($data);
        if($result){
          echo "{\"status\":\"400\",\"msg\":\"修改成功！\"}";
        }
      }
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
}
?>
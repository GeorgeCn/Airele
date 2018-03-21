<?php
namespace Home\Controller;
use Think\Controller;
class PostHideController extends Controller{
   //隐藏话题列表
   public function postHideList(){
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
      $circlename=$_GET['postsname'];
      $creatorphone=$_GET['creatorphone'];
      $creatorname=$_GET['creatorname'];
      $postsid=$_GET['pid'];
      $where['is_display']=array('eq',0);
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
           $circleinfo['id']=$value['circle_id'];
           $circlearr=$handleCircle->getCircleInfoFind($circleinfo);
           $value['circle_title']=$circlearr['title'];
           $list[]=$value;
       }
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
     $circle_id=$_GET['hid'];
     $postsid=$_GET['pid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id; 
     $data=$handleCircle->getCirclePostFind($where);
     $cirwhere['id']=$data['circle_id'];
     $circlearr=$handleCircle->getCircleInfoFind($cirwhere); 
     if($data['is_display']==1){
        $data['is_display']=0;
     }else{
        $data['is_display']=1;
        $circlearr['post_cnt']=$circlearr['post_cnt']+1; 
     }
     $handleCircle->upCircleInfo($circlearr);//更新圈子话题总条数
     $result=$handleCircle->upCirclePost($data);
     if($result){
        $this->success('更新成功！', 'postHideList.html?no=47&leftno=54');
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
      $posttitle=$handleCircle->getCirclePostFind($rewhere);
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
     $data=$handleCircle->getPostReplayFind($where);
     if($data['is_display']==1){
        $data['is_display']=0;
     }else{
        $data['is_display']=1;
     }
     $result=$handleCircle->upReplayState($data);

     if($result){
        $this->success('更新成功！',U('CircleManage/circlePostsDetails',array('pid'=>$postsid)),0);
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

  
   //ajax获取圈子回复数
   public function getAjaxCircleReply(){
       $handleCircle = new \Logic\CircleManage();
       $where['circle_id']=$_GET['id'];
       $result=$handleCircle->AjaxCircleReply($where);
       $this->assign("result",$result);
       $this->display();
   }
}
?>
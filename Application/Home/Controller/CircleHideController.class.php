<?php
namespace Home\Controller;
use Think\Controller;
class CircleHideController extends Controller{
  //圈子列表
   public function circleHideList(){
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
      $circlename=$_GET['circlename'];
      $creatorphone=$_GET['creatorphone'];
      $creatorname=$_GET['creatorname'];

      if($circlename!=""){
         $where['circleinfo.title']=array('like','%'.$circlename.'%');
      }
     
       $where['circleinfo.is_display']=array('eq',0);
       $where['circleinfo.record_status']=array('eq',1);
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
       $Page= new \Think\Page($count,15);         
       $count=$handleCircle->getCircleInfoCount($where);
       foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val); 
       }
       $listarr=$handleCircle->getCircleInfoList($Page->firstRow,$Page->listRows,$where);
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
   //取消隐藏
   public function upCircleState(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
     $circle_id=$_GET['cid'];
     $handleCircle = new \Logic\CircleManage();
     $where['id']=$circle_id;
     $data=$handleCircle->getCircleInfoFind($where);
     if($data['is_display']==0){
        $data['is_display']=1;
     }
     $result=$handleCircle->upCircleInfo($data);
     if($result){
        $this->success('更新成功！',U('CircleHide/circleHideList'),0);
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
     $where['id']=$circle_id; 
     $data=$handleCircle->getCirclePostFind($where);
     if($data['is_display']==1){
        $data['is_display']=0;
     }else{
        $data['is_display']=1;
     }
     $result=$handleCircle->upCirclePost($data);
     if($result){
        $this->success('更新成功！',U('CircleHide/circlePostsList',array('pid'=>$postsid)),0);
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
      $this->assign("posttitle",$posttitle);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
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
        $this->success('更新成功！',U('CircleHide/circlePostsDetails',array('pid'=>$postsid)),0);
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
        $this->success('更新成功！',U('HideCircle/circleMember',array('cid'=>$postsid)),0);
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
}
?>
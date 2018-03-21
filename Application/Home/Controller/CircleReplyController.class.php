<?php
namespace Home\Controller;
use Think\Controller;
class CircleReplyController extends Controller{
  //圈子列表
   public function replylist(){
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
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $mobile=I('get.mobile');
      $name=I('get.name');
      $title=I('get.title');
      $replycontent=I('get.replycontent');
      $replystatus=I('get.replystatus');
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
       //手机号搜索
      if($mobile!=""){
           $mowhere['mobile']=$mobile;
           $customerarr=$handleCircle->getCustomerById($mowhere);
           $where['customer_id']=array('eq',strtolower($customerarr['id']));
      }
      //姓名搜索
      if($name!=""){
           $namewhere['true_name']=$name;
           $namearr=$handleCircle->getCustomerById($namewhere);
           $where['customer_id']=array('eq',strtolower($namearr['id']));
      }
      //帖子标题搜索
      if($title!=""){
            $titlewhere['title']=array('eq',$title);
            $titlewhere['is_display']=1;
            $titlearr=$handleCircle->getCirclePostFind($titlewhere);
            $where['post_id']=$titlearr['id'];
      }
      if($replycontent!=""){
          $where['reply_content']=array('like','%'.$replycontent.'%');
      }
      if($replystatus!=""){
        if($replystatus!=99){
          $where['is_display']=$replystatus;
        }
      }else{
          $where['is_display']=1;
      }
      $count=$handleCircle->getCirclePostsReplayCount($where);
      $Page= new \Think\Page($count,10);
      /*foreach($where as $key=>$val){
            $Page->parameter[$key]=urlencode($val);
      }*/
      $listarr=$handleCircle->getCirclePostReplay($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value){
           $cuwhere['id']=$value['customer_id'];
           $customer=$handleCircle->getCustomerById($cuwhere);
           $value['cname']=$customer['true_name'];
           $value['mobile']=$customer['mobile'];
           $rewhere['id']=$value['post_id'];
           $post_title=$handleCircle->getCirclePostFind($rewhere);
           $value['post_title']=$post_title['title'];
           $list[]=$value;
       }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("show",$Page->show());
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
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

    //回复的回复话题
    public function layersReplyPosts(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
        }
        $handleCustomer = new \Logic\CustomerLogic();
        $handleCircle = new \Logic\CircleManage();
        $customer=$handleCustomer->getResourceClientByPhone($_POST['mobile']);
        $where['post_id']=$_POST['js_post_id'];
        $replymax=$handleCircle->getReplyPositionMax($where);
        $data['id']=create_guid();
        $data['post_id']=$_POST['js_post_id'];
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
           $this->success('该手机号不存在！',U('CircleReply/replylist'),0);
        }else{
            $postwhere['id']=$_POST['js_post_id'];
            $postarr=$handleCircle->getCirclePostFind($postwhere);
            $data['city_id']=$postarr['city_id'];
            $result=$handleCircle->addCirclePostrePlay($data);
            $postarr['replay_cnt']=$postarr['replay_cnt']+1;
            $postarr['update_time']=time();
            $handleCircle->upCirclePost($postarr);
            if($result){
              $this->success('回复成功！',U('CircleReply/replylist'),0);
            }
       }
    }
    //下载回复数据
    public function downloadReply(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
       }
       $startTime=I('get.startTime');
       $endTime=I('get.endTime');
       if(empty($startTime) || empty($endTime)){
          return $this->error('请选择起止日期！',"replylist.html?no=47&leftno=67",3);
       }
       $limit_time=strtotime($endTime)-strtotime($startTime);
       if($limit_time>3600*24*30){
          //return $this->error('下载数据不能超过1个月！',"replylist.html?no=47&leftno=67",3);
       }
      $where['create_time']=array(array('gt',strtotime($startTime)),array('lt',strtotime($endTime)+3600*24));
      $replystatus=I('get.replystatus');
      if($replystatus!=""){
        if($replystatus!=99){
          $where['is_display']=$replystatus;
        }
      }else{
          $where['is_display']=1;
      }
      $where['record_status']=array('eq',1);
      $handleCircle = new \Logic\CircleManage();
      
      $customerArray=array();//存储已经查询过的用户信息
      $exarr[]=array('reply_content'=>'回复内容','create_time'=>'回复时间','true_name'=>'回复人','mobile'=>'回复人电话');
        $list=$handleCircle->getCirclePostReplay(0,5000,$where);
        foreach ($list as $key => $value) {
          $value_new['reply_content']=$value['reply_content'];
            $value_new['create_time']=$value['create_time']>0?date("Y-m-d H:i:s",$value['create_time']):""; 
            
            if(!isset($customerArray[$value['customer_id']])){
              $customerInfo=$handleCircle->getCustomerById(array('id'=>$value['customer_id']));
              if($customerInfo!=null && $customerInfo!=false){
                 $value_new['true_name']=$customerInfo['true_name'];
                 $value_new['mobile']=$customerInfo['mobile'];
                 $customerArray[$value['customer_id']]=$value_new['mobile'].'^&^'.$value_new['true_name'];
              }else{
                 $value_new['true_name']='';
                 $value_new['mobile']='';
              }
            }else{
              $customerInfo=explode('^&^', $customerArray[$value['customer_id']]);
               $value_new['true_name']=$customerInfo[1];
               $value_new['mobile']=$customerInfo[0];
            }
            $exarr[]=$value_new;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '帖子回复');
        $xls->addArray($exarr);
        $xls->generateXML('帖子回复'.date("YmdHis"));
    }
}
?>
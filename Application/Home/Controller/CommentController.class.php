<?php
namespace Home\Controller;
use Think\Controller;
class CommentController extends Controller {
    //房东评论列表
    public function OwnerCommentList(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
       $handleMenu->jurisdiction();
       $mobile=$_GET['mobile'];
       $name=$_GET['name'];
       $cuswhere['record_status']=array('eq',1);
       if($mobile!=""){
         $cuswhere['mobile']=array('eq',$mobile);
       }
       if($name!=""){
         $cuswhere['true_name']=array('eq',$name);
       }
      $handleCustomer = new \Logic\Comment();

          if($mobile!=""||$name!=""){
            $serarr=$handleCustomer->getCustomer($cuswhere);
            foreach ($serarr as $key => $value) {
                $where['owner_id']=array('eq',$value['id']);
            }
          }
          $where['record_status']=array('eq',1);
          $where['city_id']=C('CITY_CODE');
          $countarr=$handleCustomer->getCommentPageCount($where);
          $count=count($countarr);
          $Page= new \Think\Page($count,15);
          foreach($where as $key=>$val){
              $Page->parameter[$key]=urlencode($val);
          }
          $listarr=$handleCustomer->getCommentList($Page->firstRow,$Page->listRows,$where);
          foreach ($listarr as $key => $value) {
              $cus['id']=$value['owner_id'];
              $cuarr=$handleCustomer->getCustomerById($cus);
              $value['true_name']=$cuarr['true_name'];
              $value['mobile']=$cuarr['mobile'];
              $list[]=$value;
            }
     
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$list);
		  $this->display();
    }

    //评论详情
    public function detailedComment(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
      $handleCustomer = new \Logic\Comment();
      $where['owner_id']=array('eq',$_GET['owid']);
      $where['record_status']=array('eq',1);
      $where['city_id']=C('CITY_CODE');
      $count=$handleCustomer->getDetailedPageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
          $Page->parameter[$key]=urlencode($val);
      }
      $list=$handleCustomer->getDetailedComment($Page->firstRow,$Page->listRows,$where);
      $owner['id']=$_GET['owid'];
      $landlord=$handleCustomer->getCustomerById($owner);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("landlord",$landlord);
      $this->assign("list",$list);
      $this->display();
    }

    //删除评论
    public function delComment(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $delid=$_GET['delid'];
        $owner_id=$_GET['owner_id'];
        $handleCustomer = new \Logic\Comment();
        $result=$handleCustomer->delComment($delid);
         if($result){
              $this->success('删除成功！', 'detailedComment.html?no=3&leftno=45&owid='.$owner_id);
          }
    }

    //所有房东评价
    public function AllCommentList(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
       $handleMenu->jurisdiction();
      $handleCustomer = new \Logic\Comment();
      $mobile=$_GET['mobile'];
      $content=$_GET['content'];
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $where['record_status']=array('eq',1);
      $where['city_id']=C('CITY_CODE');
      if($mobile!=""){
         $cuwhere['mobile']=$mobile;
         $cuarr=$handleCustomer->getCustomerById($cuwhere);
         $where['customer_id']=$cuarr['id'];
      }
      if($content!=""){
         $where['content']=array('like','%'.$content.'%');
      }
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
       
      $count=$handleCustomer->getDetailedPageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
          $Page->parameter[$key]=urlencode($val);
      }
      $listarr=$handleCustomer->getDetailedComment($Page->firstRow,$Page->listRows,$where);

      foreach ($listarr as $key => $value) {
         $custarr=$this->getCustomerById($value['owner_id']);
         $value['owner_name']=$custarr['true_name'];
         $value['owner_mobile']=$custarr['mobile'];
         $value['is_owner']=$custarr['is_owner'];
         
         $cust=$this->getCustomerById($value['customer_id']);
         $value['mobile']=$cust['mobile'];
         $findwhere['parent_id']=$value['id'];
         $result=$handleCustomer->getDetailedComment(0,99,$findwhere);
         if($result){
            $valuenew=array();
            foreach ($result as $key1 => $value1){
               $valuenew[]['reply_content']=$value1['content'];
            }
            $value['new_reply']=$valuenew;
            $value['parent_id']=1;
         }
         $list[]=$value;
      }
      $this->assign("menutophtml",$menu_top_html); 
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("landlord",$landlord);
      $this->assign("list",$list);
      $this->display();

    }
    //获取用户信息
    public function getCustomerById($customer_id){
        $handleCustomer = new \Logic\CustomerLogic();
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'customerid'.$customer_id);
        if(empty($result)){
           $result=$handleCustomer->getModelById($customer_id);
           set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),'customerid'.$customer_id,$result,3600);
        }
        return $result;
    }


      //删除评论
    public function delDirComment(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $delid=$_GET['delid'];
        $owner_id=$_GET['owner_id'];
        $handleCustomer = new \Logic\Comment();
        $result=$handleCustomer->delComment($delid);
         if($result){
              $this->success('删除成功！', 'AllCommentList.html?no=3&leftno=58');
          }
    }
    //房东回复
    public function subreply(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
          $this->error('非法操作',U('Index/index'),1);
        }
        $handleComment = new \Logic\Comment();
        $handleCustomer = new \Logic\CustomerLogic();
        $custarr=$handleCustomer->getResourceClientByPhone($_POST['mobile']);
        $data['id']=create_guid();
        $data['owner_id']=$_POST['js_owner_id'];
        $data['comment_type']=1;
        $data['content']=$_POST['reply_content'];
        $data['customer_id']=$custarr['id'];
        $data['customer_name']=$custarr['true_name'];
        $data['parent_id']=$_POST['js_parent_id'];
        $data['is_anonymous']=1;
        $data['is_anonymous_address']=1;
        $data['create_time']=time();
        $data['is_anonymous_address']=1;
        $data['record_status']=1;
        $data['city_id']=C('CITY_CODE');
        $result=$handleComment->modelAdd($data);
        if($result){
            $handleCustomerNotify = new \Logic\CustomerNotifyLogic();
            $where['id']=I('post.js_parent_id');
            $centenarr=$handleComment->modelFind($where);
            $dataNotify['id']=create_guid();
            $dataNotify['customer_id']=$centenarr['customer_id'];
            $dataNotify['notify_type']=2;
            $dataNotify['title']="房东回复";
            $dataNotify['content']="<font color='#666666'>您评论</font>"."<font color='#444444'>“".$centenarr['content']."”</font>"."<font color='#666666'>的留言，被房东回复</font>"."<font color='#444444'>“".$_POST['reply_content']."”</font>";
            $dataNotify['create_time']=time();
            $array=array('ld_id'=>$centenarr['owner_id'],'room_id'=>$centenarr['room_id'],'room_no'=>$centenarr['room_no'],'estate_name'=>$centenarr['address']);
            $dataNotify['ext_info']=json_encode($array);
            $handleCustomerNotify->modelAdd($dataNotify);
            $this->success('回复成功！', 'AllCommentList.html?no=3&leftno=58');
        }
    }

    public function downloadExcel(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $startTime=strtotime(I('get.startTime'));
         $endTime=strtotime(I('get.endTime'));
             
         if(empty($startTime) || empty($endTime)){
            return $this->success('下载数据不能超过一个月！',"AllCommentList.html?no=3&leftno=58",0);
         }
         $limit_time=strtotime($endTime)-strtotime($startTime);
         if($limit_time>3600*24*30){
            return $this->success('下载数据不能超过一个月！',"AllCommentList.html?no=3&leftno=58",0);
         }
        /***star**/
          $handleCustomer = new \Logic\Comment();
          $mobile=I('get.mobile');
          $content=I('get.content');
          $where['record_status']=array('eq',1);
          $where['city_id']=C('CITY_CODE');
          if($mobile!=""){
             $cuwhere['mobile']=$mobile;
             $cuarr=$handleCustomer->getCustomerById($cuwhere);
             $where['customer_id']=$cuarr['id'];
          }
          if($content!=""){
             $where['content']=array('like','%'.$content.'%');
          }
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
           
          $listarr=$handleCustomer->getDetailedComment(0,999999,$where);
        $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($listarr));
          foreach ($listarr as $key => $value) {
             $custarr=$this->getCustomerById($value['owner_id']);
             $value['owner_name']=$custarr['true_name'];
             $value['owner_mobile']=$custarr['mobile'];
             $value['is_owner']=$custarr['is_owner'];
             
             $cust=$this->getCustomerById($value['customer_id']);
             $value['mobile']=$cust['mobile'];
             $findwhere['parent_id']=$value['id'];
             $result=$handleCustomer->getDetailedComment(0,99,$findwhere);
             $value['new_reply']="";
             if($result){
                foreach ($result as $key1 => $value1){
                    $valuenew.="房东回复：".$value1['content'];
                }
                $value['new_reply']=$valuenew;
             }
             $list1[]=$value;
          }
          foreach ($list1 as $key2 => $value2) {
              $value3['owner_name']=$value2['owner_name'];
              $value3['owner_mobile']=$value2['owner_mobile'];
              $value3['comment_type']=$value2['comment_type'];
              $value3['content']=$value2['content'];
              $value3['new_reply']=$value2['new_reply'];
              $value3['address']=$value2['address'];
              $value3['is_anonymous']=$value2['is_anonymous'];
              $value3['is_anonymous_address']=$value2['is_anonymous_address'];
              $value3['is_owner']=$value2['is_owner'];
              $value3['create_time']=$value2['create_time'];
              $value3['customer_name']=$value2['customer_name'];
              $value3['mobile']=$value2['mobile'];
              $list2[]=$value3;
          }
         /**end*/
         $title=array(
                'room_id'=>'房东姓名','info_resource'=>'房东手机','comment_type'=>'总体评价','is_commission'=>'评价内容','mobile'=>'房东回复','owner_mobile'=>'房间地址','owner_name'=>'是否匿名','charge_man'=>'是否显示地址',
                'status_code'=>'是否职业房','called_length'=>'评论日期','call_time'=>'评论人','updata_man'=>'评论人手机'
                );
         $exarr[]=$title;
         $downAll=false;
        if(in_array(trim(getLoginName()), getDownloadLimit())){
              $downAll=true;
        }
        foreach ($list2 as $key4 => $value4) {
            $value4['create_time']=$value4['create_time']>0?date("Y-m-d H:i",$value4['create_time']):""; 
            switch ($value4['comment_type']) {
                case '1':
                    $value4['comment_type']="值得推荐";
                    break;
                case '2':
                    $value4['comment_type']="有待改善";
                    break;
                case '3':
                    $value4['comment_type']="问题很多";
                    break;
                default:
                    $value4['comment_type']="";
                    break;
            }
            switch ($value4['is_anonymous']) {
                case '1':
                    $value4['is_anonymous']="是";
                    break;
                case '0':
                    $value4['is_anonymous']="否";
                    break;
                default:
                    $value4['is_anonymous']="";
                    break;
            }
            switch ($value4['is_anonymous_address']) {
                case '1':
                    $value4['is_anonymous_address']="否";
                    break;
                case '0':
                    $value4['is_anonymous_address']="是";
                    break;
                default:
                    $value4['is_anonymous_address']="";
                    break;
            }
            switch ($value4['is_owner']) {
                case '4':
                    $value4['is_owner']="是";
                    break;
                default:
                    $value4['is_owner']="否";
                    break;
            }
            if(!$downAll){
                $value4['owner_mobile']=substr_replace($value4['owner_mobile'], '****', 4,4);
                $value4['mobile']=substr_replace($value4['mobile'], '****', 4,4);
            }
            $exarr[]=$value4;
        }
        //print_r($exarr);die;
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '房东评价');
        $xls->addArray($exarr);
        $xls->generateXML('房东评价'.date("YmdHis"));
    }

}
?>
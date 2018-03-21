<?php
namespace Home\Controller;
use Think\Controller;
class LeadPeopleController extends Controller{

   public function leadpeoplelist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
       $handleMenu->jurisdiction();
      $modelFhserviceman=new \Home\Model\fhserviceman();
      $handleRegion = new \Logic\Paramregion();
      $where['city_code']=C('CITY_CODE');
      $count=$modelFhserviceman->modelPageCount($where);
      $Page= new \Think\Page($count,15);
      $listarr=$modelFhserviceman->modelPageList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
          $regionarr=$handleRegion->getParamRegion($value['region_id']);
          $value['region_name']=$regionarr['cname'];
          $list[]=$value;
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }

   public function addleadtemp(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $handleRegion = new \Logic\Paramregion();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
      $where['parent_id']=0;
      $result=$handleRegion->getParamRegionList($where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("data",$result);
      $this->display();
   }
   //新增
   public function addlead(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
           $this->uploadImage();
          return;
         }
          
           $data['region_id']=I('post.region');
           $data['name']=I('post.name');
           $data['mobile']=I('post.mobile');
           $data['avatar']=I('post.photo');
           $data['title']=I('post.servicetitle');
           $data['service_price']=I('post.serviceprice');
           $data['service_desc']=I('post.explain');
           
           $modelServiceMan=new \Home\Model\fhserviceman();
           if(I('post.uptype')==""){
               $data['id']=create_guid();
               $data['city_code']=C('CITY_CODE');
               $data['sort_index']=time();
               $result=$modelServiceMan->modelAdd($data);
               if($result){
                  $this->success('提交成功！',U('LeadPeople/leadpeoplelist'),0);
               }else{
                  $this->success('提交失败！',U('LeadPeople/leadpeoplelist'),0);
               }
           }else{
              $data['id']=I('post.id');
              $result=$modelServiceMan->modelUpdate($data);
              if($result){
                 $this->success('修改成功！',U('LeadPeople/leadpeoplelist'),0);
               }
           }
   }

   //修改temp
   public function updatetemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
         $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity); 
        $handleMenu = new \Logic\AdminMenuListLimit();
         $modelServiceMan=new \Home\Model\fhserviceman();
         $handleRegion = new \Logic\Paramregion();

        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
        $where['id']=I('get.fid');
        $result=$modelServiceMan->modelFind($where);
        $where1['parent_id']=0;
        $result1=$handleRegion->getParamRegionList($where1);
        $this->assign("regionarr",$result1);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("data",$result);
        $this->display();
   }
   //查看
   public function checktenant(){
             $handleCommonCache=new \Logic\CommonCacheLogic();
            if(!$handleCommonCache->checkcache()){
                 $this->error('非法操作',U('Index/index'),1);
            }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity); 
            $handleMenu = new \Logic\AdminMenuListLimit();
            $modelServiceMan=new \Home\Model\fhserviceman();
            $handleRegion = new \Logic\Paramregion();
            $handleCustomerLogic = new \Logic\CustomerLogic();
            $modelServiceOrder=new \Home\Model\fhserviceorder();
            $modelServiceOrderStatus=new \Home\Model\fhserviceorderstatus();
            $modelServiceComment=new \Home\Model\fhservicecomment();
             $handleCustomer = new \Logic\CustomerLogic();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),1);
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),1);
            $where['id']=I('get.fid');
            $manarr=$modelServiceMan->modelFind($where);
            $regionarr=$handleRegion->getParamRegion($manarr['region_id']);

            $where1['owner_id']=I('get.fid');
            $where1['order_status']=array('gt',1);
            $count=$modelServiceOrder->modelPageCount($where1);
            $Page= new \Think\Page($count,15);
            $listarr=$modelServiceOrder->modelPageList($Page->firstRow,$Page->listRows,$where1);
            foreach ($listarr as $key => $value) {
                $whereorder['order_id']=$value['id'];
                $statusarr=$modelServiceOrderStatus->modelGet($whereorder);
                foreach ($statusarr as $key1 => $value1) {
                    if($value1['order_status']==2){
                         $value['pay_time']=$value1['create_time'];
                    }
                    if($value1['order_status']==3){
                        $value['end_time']=$value1['create_time'];
                    }
                    if($value1['order_status']==5){
                        $value['end_time']=$value1['create_time'];
                    }
                }
                $customer=$handleCustomerLogic->getModelById($value['customer_id']);
                $value['customer_mobile']=$customer['mobile'];
                $wherecomment['customer_id']=$value['customer_id'];
                $wherecomment['order_id']=$value['id'];
                $comment=$modelServiceComment->modelFind($wherecomment);
                $value['content']=$comment['content'];
                $value['stat_zhunshi']=$comment['stat_zhunshi'];
                $value['stat_fuwu']=$comment['stat_fuwu'];
                $value['stat_zhiliang']=$comment['stat_zhiliang'];
                $value['stat_price']=$comment['stat_price'];
                $wherereply['parent_id']=$comment['id'];
                $wherereply['record_status']=1;
                $replyarr=$modelServiceComment->modelFind($wherereply);
                $value['reply_content']=$replyarr['content'];
                $value['reply_id']=$replyarr['id'];
                $list[]=$value;
            }
            $this->assign("regionarr",$regionarr);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->assign("data",$manarr);
            $this->assign("pagecount",$count);
            $this->assign("list",$list);
            $this->assign("show", $Page->show());
            $this->display();
   }
     //付款退款人数统计
     public function pfcount(){
         $modelServiceOrder=new \Home\Model\fhserviceorder();
         $id=I('get.owner_id');
         $where['owner_id']=$id;
         $where['order_status']=array('gt',1);
         $where['record_status']=1;
         $pcount=$modelServiceOrder->modelCount($where);
         $where1['owner_id']=$id;
         $where1['order_status']=4;
         $where1['record_status']=1;
         $fcount=$modelServiceOrder->modelCount($where1);
            $array=array('status'=>'200','pcount'=>$pcount,'fcount'=>$fcount);
            echo json_encode($array);
     }
     //排序
     public function moveUpDownTopMan(){
  
          if(isset($_GET['manid']) && isset($_GET['sort_index']) && isset($_GET['manid2']) && isset($_GET['sort_index2'])){
            $modelServiceMan=new \Home\Model\fhserviceman();
            $modelServiceMan->modifyTopManSort($_GET['manid'],$_GET['sort_index'],$_GET['manid2'],$_GET['sort_index2']);
            echo '{"status":"200","msg":"操作成功"}';
          }else{
            echo '{"status":"404","msg":"缺少参数"}';
          }
    }

    //隐藏显示
    public function updatestatus(){
         $modelServiceMan=new \Home\Model\fhserviceman();
         $type=I('get.type');
         $where['id']=I('get.manid');
         $data=$modelServiceMan->modelFind($where);
         if($type==0){
            $data['record_status']=0;
            $result=$modelServiceMan->modelUpdate($data);
         }elseif($type==1){
            $data['record_status']=1;
            $result=$modelServiceMan->modelUpdate($data);
         }
         if($result){
            echo '{"status":"200","msg":""}';
         }
    }

    //找室友设置
    public function updatepost(){
         $modelServiceMan=new \Home\Model\fhserviceman();
         $type=I('get.type');
         $where['id']=I('get.manid');
         $data=$modelServiceMan->modelFind($where);
         if($type==0){
            $data['is_post']=0;
            $result=$modelServiceMan->modelUpdate($data);
         }elseif($type==1){
            if($data['record_status']==0){
                 echo '{"status":"202","msg":""}';
            }else{
                $where1['is_post']=1;
                $where1['city_code']=C('CITY_CODE');
                $result1=$modelServiceMan->modelFind($where1);
                if($result1){
                     echo '{"status":"201","msg":""}';
                }else{
                   $data['is_post']=1;
                   $result=$modelServiceMan->modelUpdate($data);
                }
            }
         }
         if($result){
            echo '{"status":"200","msg":""}';
         }
    }

    //回复评论
      public function postreplycontent(){
             $modelComment=new \Home\Model\fhservicecomment();
             $modeladminlogin=new \Home\Model\adminlogin();
             $order_id=I('get.orderid');
             $reply_content=I('get.reply_content');
             if($order_id!=""&&$reply_content!=""){
                $where['order_id']=$order_id;
                $where['record_status']=1;
                $data=$modelComment->modelFind($where);
                if($data){
                  $adminuser['user_name']=cookie("admin_user_name");
                  $adminuser['record_status']=1;
                  $adminarr=$modeladminlogin->modelAdminFind($adminuser);
                  $data['parent_id']=$data['id'];
                  $data['id']=create_guid();
                  $data['customer_id']=$adminarr['id'];
                  $data['content']=$reply_content;
                  $data['create_time']=time();
                  $data['content']=$reply_content;
                  $result=$modelComment->modelAdd($data);
                  if($result){
                     echo "200";
                  }
                }
            }
      }

      //删除回复
     public function deletereply(){
            $modelComment=new \Home\Model\fhservicecomment();
            $reply_id=I('get.reply_id');
            if($reply_id){
                 $where['id']=$reply_id;
                 $where['record_status']=1;
                 $data=$modelComment->modelFind($where);
                 if($data){
                    $data['record_status']=0;
                    $result=$modelComment->modelUpdate($data);
                    if($result){
                        echo"200";
                    }
                 }
            }
     }

   //上传图片
    public function uploadImage(){
        
       if(isset($_GET['act']) && $_GET['act']=='delimg'){
          $filename = $_POST['imagename'];

        }else{
          log_result("roomlog.txt","上传图片:".json_encode($_FILES['mypic']));
            $picname = $_FILES['mypic']['name'];
            $picsize = $_FILES['mypic']['size'];
        
         
          if ($picname != "") {
            //$type = strstr($picname, '.');
            $picname_arr = explode('.', $picname);
            $type=$picname_arr[count($picname_arr)-1];
            if ($type != "gif" && $type != "jpg" && $type != "jpeg" && $type != "png") {
              echo '文件必须是图片格式！';
              exit;
            }
            if ($picsize > 1024000*3) {
              echo '图片大小不能超过3M';
              exit;
            }
            $rand = rand(100, 999);
            $pics = date("YmdHis") . $rand .'.'. $type;
            //上传路径
            $imgData=$this->base64_encode_image($_FILES['mypic']['tmp_name'],$type);
            $result = $this->uploadImageToServer($_POST['room_id'],$pics,$imgData);
            echo $result;
         }
       }
    }

    public function base64_encode_image($filename=string,$filetype=string) {
      if ($filename) {
          $imgbinary = file_get_contents($filename);
          return base64_encode($imgbinary);
      }
  }

    //上传图片到服务器
  public function uploadImageToServer($room_id,$fileName,$imgData){
      // post提交
      $post_data = array ();
      $post_data ['relationId'] = "xx";
      $post_data ['fileName'] = $fileName;
      $post_data ['data']=$imgData;
      $post_data ['fileSize'] = "10000";
      $url =C("IMG_SERVICE_URL").'appico/web/upload';
      $o = "";
      foreach ( $post_data as $k => $v ) {
        $o .= "$k=" . urlencode ( $v ) . "&";
      }
      $post_data = substr ( $o, 0, - 1 );
      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_POST, 1 );
      curl_setopt ( $ch, CURLOPT_HEADER, 0 );
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
      $result = curl_exec ( $ch );
  }

}
?>
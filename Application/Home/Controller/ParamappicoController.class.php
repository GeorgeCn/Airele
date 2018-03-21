<?php
namespace Home\Controller;
use Think\Controller;
class ParamappicoController extends Controller {
    //上传列表
    public function paramAppIcoList(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
        $handleMenu->jurisdiction();
        $keyid=I('get.keyword'); 
        $handleAppico = new \Logic\Paramappico();
        if($keyid!=""){
            $keyid=$keyid;
        }else{
            $keyid=3;
        }
        $list=$handleAppico->getCacheParamappicoList($keyid);
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
  	  	$this->display();
    }
    //删除
    public function delAppIco(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $id=$_GET['paid'];
         $handleAppico = new \Logic\Paramappico();
         $result=$handleAppico->delParamappico($id);
         if($result){
              $this->success('删除成功！',"paramAppIcoList.html?no=1&leftno=25");
         }else{
              $this->success('删除失败！',"paramAppIcoList.html?no=1&leftno=25");
         }
    }

     //提交信息
     public function addAppico(){
           $handleCommonCache=new \Logic\CommonCacheLogic();
           if(!$handleCommonCache->checkcache()){
              $this->error('非法操作',U('Index/index'),1);
           }
           if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
             $this->uploadImage();
            return;
           }
           $data['type_no']=I('post.type_no');
           $data['info_type']=I('post.info_type');
           $data['name']=I('post.name');
           $data['create_time']=time();
           $data['record_status']=1;
           if(I('post.bright')!=""){
              $data['img_url_bright']=I('post.bright');
           }
           if(I('post.gray')!=""){
              $data['img_url_gray']=I('post.gray');
           }
           $handleAppico = new \Logic\Paramappico();
           if(I('post.type')=="add"){
               $data['id']=create_guid();
               $result=$handleAppico->addParamappico($data);
               if($result){
                  $this->success('提交成功！',"paramAppIcoList.html?no=1&leftno=25");
               }else{
                  $this->success('提交失败！',"paramAppIcoList.html?no=1&leftno=25");
               }
           }else{
              $data['id']=I('post.upid');
              $result=$handleAppico->upParamappico($data);
              if($result){
                 $this->success('修改成功！',"paramAppIcoList.html?no=1&leftno=25");
               }
           }
      }
       //修改
     public function upParamAppico(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $paid=I('get.paid');
         $keyword=I('get.intype');
         $handleParamroom = new \Logic\Paramappico();
         $uparr=$handleParamroom->getParamappico($paid);
         $list=$handleParamroom->getParamappicoList($keyword);

         $this->assign("list",$list);
         $this->assign("uparr",$uparr);
         $this->assign("type",'up');
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
     }
     //新增
     public function addtemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");

         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();


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
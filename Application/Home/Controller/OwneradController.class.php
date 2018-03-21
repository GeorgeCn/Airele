<?php
namespace Home\Controller;
use Think\Controller;
class OwneradController extends Controller {
    /*首页入口设置 */
    public function owneradlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"162");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"162");
        $handleMenu->jurisdiction();

        $handleAdindex= new\Home\Model\adindex();
        $where['city_code']=C('CITY_CODE');
        $where['record_status']=1;
        $where['app_type']=1;
        $list=$handleAdindex->modelList(0,99,$where);
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
  	  	$this->display();
    }
    #delete
    public function removeAdindex(){
         $id=I('post.pid');
        if($id==""){
           echo '{"status":"500","msg":"参数错误"}';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $handleAdindex= new\Home\Model\adindex();
        $where['id']=$id;
        $adindexarr=$handleAdindex->modelFind($where);
        $adindexarr['record_status']=0;
        $result=$handleAdindex->modelUpdate($adindexarr);
        if($result){
             echo '{"status":"200","msg":"操作成功"}';
        }else{
             echo '{"status":"400","msg":"操作失败"}';
        }
    }
    //提交信息
    public function submitAdindex(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
           return $this->uploadImage();
         }
         $data['title']=I('post.title');
         if(I('post.bannername')!=""){
            $data['img_url']=I('post.bannername');
         }
         $data['sort_index']=I('post.sort_index');
         $data['is_display']=I('post.is_display');
         $data['link']=htmlspecialchars_decode(I('post.link'),ENT_QUOTES);
         if(empty($data['link'])){
          return $this->error('提交失败！',"owneradlist.html?no=162&leftno=168");
         }
          $handleAdindex= new\Home\Model\adindex();
         if(I('post.type')=="update"){
            $data['id']=I('post.upid');
            $result=$handleAdindex->modelUpdate($data);
            $result=true;
         }else{
            $data['id']=create_guid();
            $data['create_time']=time();
            $data['city_code']=C('CITY_CODE');
            $data['app_type']=1;
            $result=$handleAdindex->modelAdd($data);
         }
         if($result){
             $this->success('提交成功！',"owneradlist.html?no=162&leftno=168");
         }else{
              $this->error('提交失败！',"owneradlist.html?no=162&leftno=168");
         }
    }
    public function updatetemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
        
         $handleAdindex= new\Home\Model\adindex();
         $id=I('get.upid');
         $where['id']=$id;
         $adindex=$handleAdindex->modelFind($where);
         $this->assign("adindex",$adindex);
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
    }

    public function addtemp(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
         $handleMenu = new\Logic\AdminMenuListLimit();
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"162");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"162");
  
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
    }
   
    //上传图片
    public function uploadImage(){
          $picname = $_FILES['mypic']['name'];
          $picsize = $_FILES['mypic']['size'];
          if ($picname != "") {
            $picname_arr = explode('.', $picname);
            $type=$picname_arr[count($picname_arr)-1];
            if ($type != "gif" && $type != "jpg" && $type != "jpeg" && $type != "png") {
              echo '文件必须是图片格式！';
              exit;
            }
            if ($picsize > 1024000) {
              echo '图片大小不能超过1M';
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
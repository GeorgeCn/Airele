<?php
namespace Home\Controller;
use Think\Controller;
class ParamSetController extends Controller {
    /*首页入口设置 */
    public function appindexview(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"1");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"1");
        $handleMenu->jurisdiction();

        $handle = new \Logic\ParamSetLogic();
        $ver_no=I('get.ver_no');
        $name=I('get.name');
        if($ver_no!=""){
          $where['ver_no']=array('like','%'.$ver_no.'%');
        }
        if($name!=""){
          $where['module_name']=array('like','%'.$name.'%');
        }
        $list=$handle->getappindexlist($where);
        $modelversioninfo=new \Home\Model\versioninfo();
        $curverarr=$modelversioninfo->modelGetRenter(0,99,array('platform'=>'android'));
        $this->assign("curverarr",$curverarr);
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
  	  	$this->display();
    }
    #delete
    public function removeAppindex(){
      if(!isset($_POST['pid']) || empty($_POST['pid'])){
        echo '{"status":"500","msg":"参数错误"}';return;
      }
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $handle = new \Logic\ParamSetLogic();
         $result=$handle->deleteappindex($_POST['pid']);
         if($result){
             echo '{"status":"200","msg":"操作成功"}';
         }else{
             echo '{"status":"400","msg":"操作失败"}';
         }
    }
    //提交信息
    public function submitAppindex(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
           return $this->uploadImage();
         }
         $data['module_name']=I('post.module_name');
         if(I('post.img_url')!=""){
           $data['img_url']=I('post.img_url');
         }else{
           $data['img_url']=I('post.img_url1');
         }
         $data['sort_index']=I('post.sort_index');
         $data['is_display']=I('post.is_display');
         $data['module_url']=htmlspecialchars_decode(I('post.module_url'),ENT_QUOTES);
         $data['mid']=I('post.mid');
         
         if(empty($data['module_name'])){
          return $this->error('提交失败！',"appindexview.html?no=1&leftno=86");
         }
         $handle = new \Logic\ParamSetLogic();
         if(isset($_POST['pid']) && !empty($_POST['pid'])){
                #edit
                $wherev['id']=I('post.pid');
                $appindexarr=$handle->modelfind($wherev);
                //删除大于2的
                 // $dewhere['ver_no']=array('gt','2');
                 $dewhere['mid']=$appindexarr['mid'];
                 $dewhere['city_code']=$appindexarr['city_code'];
                 $handle->deleteAppindexBymid($dewhere);
                 $public_check=I('post.public_check');
                 $arrcount=count($public_check);
                 for($i=0;$i<$arrcount;$i++){
                      $data['ver_no']=$public_check[$i];
                      if($data['ver_no']!=""){
                        $result=$handle->addappindex($data);
                      }
                 }
                $result=true;
         }else{
              $public_check=I('post.public_check');
              $arrcount=count($public_check);
               for($i=0;$i<$arrcount;$i++){
                 $data['ver_no']=$public_check[$i];
                 $result=$handle->addappindex($data);
                 $result=true;
               }
         }
         if($result){
            $this->success('提交成功！',"appindexview.html?no=1&leftno=86");
         }else{
            $this->error('提交失败！',"appindexview.html?no=1&leftno=86");
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
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $id=I('get.id');
         $handleSet = new \Logic\ParamSetLogic();
         $where['id']=$id;
         $appindex=$handleSet->modelfind($where);
         //查询mid相同的
         if($appindex['mid']!=""){
            $wheremid['mid']=$appindex['mid'];
            $appindexarr=$handleSet->getappindexlist($wheremid);
         }
         foreach($appindexarr as $key1 => $value1) {
            $appver_no[]=$value1['ver_no'];
         }
         $modelversioninfo=new \Home\Model\versioninfo();
         $curverarr=$modelversioninfo->modelGetRenter(0,99,array('platform'=>'android'));
         //$vernoarr=explode(',',$appindex['ver_no']);
         foreach ($curverarr as $key => $value) {
            if(in_array($value["curver"],$appver_no)){
                $curverchecked.='<label><input type="checkbox" name="public_check[]" checked="checked" value="'.$value["curver"].'">'.$value["curver"].'</label>&nbsp;&nbsp;';
            }else{
                $curverchecked.='<label><input type="checkbox" name="public_check[]" value="'.$value["curver"].'">'.$value["curver"].'</label>&nbsp;&nbsp;';
            } 
         }

         $this->assign("curverchecked",$curverchecked);
         $this->assign("appindex",$appindex);
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
         $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
         $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
         $modelversioninfo=new \Home\Model\versioninfo();
         $curverarr=$modelversioninfo->modelGetRenter(0,99,array('platform'=>'android'));
         foreach ($curverarr as $key => $value) {
             $curverchecked.='<label><input type="checkbox" name="public_check[]" value="'.$value["curver"].'">'.$value["curver"].'</label>&nbsp;&nbsp;';
         }
         $this->assign("curverchecked",$curverchecked);
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
<?php
namespace Home\Controller;
use Think\Controller;
class PushSmsController extends Controller {
   public function pushSmsContent(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
        return $this->error('非法操作',U('Index/index'),1);
     }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
      $handleMenu->jurisdiction();
      $modelpushsms=new \Home\Model\pushsms();
       $count=$modelpushsms->modelPageCount($where);
      $Page= new \Think\Page($count,15);
      $listarr=$modelpushsms->modelPageList($Page->firstRow,$Page->listRows,$where);
      $this->assign("list",$listarr);
      $this->assign("show",$Page->show());
       $this->assign("pagecount",$count);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
   }
   public function pushLoading(){
        $push_type=I('get.push_type');
        $push_mobile=I('get.push_mobile');
        $modelpushsms=new \Home\Model\pushsms();
        if($push_type!=""&&$push_mobile!=""){
              $sendArr['phonenumber']=$push_mobile;
              $sendArr['smstype']=$push_type;
              $sendArr['timestamp']=time();
              $sendArr['name']="房东推送";
              $sendArr['money']="0";
              $sendArr['orderid']="0";
              sendPhoneContent($sendArr);
              $data['id']=create_guid();
              $data['push_type']=$push_type;
              $data['push_mobile']=$push_mobile;
              $data['create_time']=time();
              $data['push_man']=cookie("admin_user_name");
              $data['city_code']=C('CITY_CODE');
              $modelpushsms->modelAdd($data);
               echo '{"status":"200","message":"发送成功"}';return;
        }
   }
   //短链发送列表
   public function pushshortlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
      }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
       $handleMenu->jurisdiction();
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $condition['mobile']=trim(I('get.mobile'));
       $condition['startTime']=I('get.startTime');
       $condition['endTime']=I('get.endTime');
       $condition['handle_man']=trim(I('get.handle_man'));
       $condition['bigcode']=I('get.bigcode');
       $condition['status']=I('get.status');
       $handleLogic=new \Logic\ContactOwner();
       $list=$handleLogic->getShorturlList($condition);
       $this->assign("list",$list);
       $this->display();
   }
   //短链发送历史记录
   public function pushshorthistory(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
      }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
       $handleMenu->jurisdiction();
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $condition['mobile']=trim(I('get.mobile'));
       $condition['startTime']=I('get.startTime');
       $condition['endTime']=I('get.endTime');
       $condition['handle_man']=trim(I('get.handle_man'));
       $condition['city_id']=I('get.city_id');
       $condition['status']=I('get.status');
       $condition['totalcnt']=I('get.totalcnt');
       $condition['rentsource']=I('get.rentsource');

      $handleLogic=new \Logic\HouserentercallLogic();
      $list=array();
      if(!empty(I('get.p')) && $condition['totalcnt']>0){
          //点击分页，不用查询汇总
      }else{
          $totalCountModel = $handleLogic->getShortHistoryCount($condition);//总条数
          if($totalCountModel !==null && $totalCountModel !==false){
            $condition['totalcnt']=$totalCountModel[0]['totalCount'];
          }
      }
      if($condition['totalcnt']>=1){
        $Page= new \Think\Page($condition['totalcnt'],10);//分页
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        $this->assign("pageSHow",$Page->show());
        $list = $handleLogic->getShortHistoryList($condition,$Page->firstRow,$Page->listRows);
      }else{
        $this->assign("pageSHow","");
      }
      $this->assign("list",$list);
      $this->assign("totalcnt",$condition['totalcnt']);
      $this->display();
   }
/*弃用 */
   public function sendShorturl(){
      echo '{"status":"400","message":"功能已失效"}';return;

      $loginName=trim(getLoginName());
      $id=trim(I('post.contact_id'));
      if(empty($id)){
        echo '{"status":"400","message":"参数异常"}';return;
      }
      $url=trim(I('post.short_url'));
      $bak=trim(I('post.bak_info'));
      if(empty($url) && empty($bak)){
        echo '{"status":"400","message":"数据异常"}';return;
      }
      $handleLogic=new \Logic\ContactOwner();
      $contactModel=$handleLogic->modelFind(array('id'=>$id));
      if($contactModel===false || $contactModel===null){
        echo '{"status":"400","message":"信息读取失败"}';return;
      }
      if(empty($contactModel['mobile'])){
        echo '{"status":"400","message":"空手机号"}';return;
      }
      $renterLogic=new \Logic\HouserentercallLogic();
      //不发短链
      if(empty($url)){
          switch ($contactModel['big_code']) {
            case '4008180555':
              $shortData['city_id']='001009001';
              break;
            case '4008150019':
              $shortData['city_id']='001001';
              break;
            case '4008170019':
              $shortData['city_id']='001011001';
              break;
            default:
              break;
          }
          $shortData['contact_phone']=$contactModel['big_code'];
          $shortData['contact_time']=$contactModel['call_time'];
          $shortData['renter_phone']=$contactModel['mobile'];
          $shortData['update_man']=$loginName;
          $shortData['bak_content']=$bak;
          $result=$renterLogic->addNotShorturl($shortData);
          if($result){
            echo '{"status":"200","message":"success"}';
          }else{
            echo '{"status":"400","message":"操作失败"}';
          }
          return;
      }
      //发送短链
      $uri_array=$this->getSinaOpenapiShorturi($url);
     
      if(!is_array($uri_array)){
        echo $uri_array;return;
      }
      $url_array=explode('/', $url);
      $url_arrayLen=count($url_array);
      $shortData['room_id']=str_replace('.html', '', $url_array[$url_arrayLen-1]);
      $shortData['contact_phone']=$contactModel['big_code'];
      $shortData['contact_time']=$contactModel['call_time'];
      $shortData['renter_phone']=$contactModel['mobile'];
      $shortData['update_man']=$loginName;
      $shortData['bak_content']=$bak;
      $shortData['short_url']=$uri_array['url_short'];
      $result=$renterLogic->addIncludShorturl($shortData);
      if($result===false){
        echo '{"status":"400","message":"操作失败"}';return;
      }
      $contactModel['shorturl_issend']=1;
      $contactModel['shorturl_address']=$uri_array['url_short'];
      $contactModel['shorturl_handleman']=$loginName;
      $handleLogic->modelUpdate($contactModel);
      /*发送短信*/
      $moduleType=I('post.moduleType');
      if($moduleType=='2'){
        $sendArr['smstype']='EZA010';
        $sendArr['name']=$result;
      }else if($moduleType=='3'){
        $sendArr['smstype']='EZA011';
        $sendArr['name']=$result;
      }else{
        $sendArr['smstype']='EZA007';
        $sendArr['name']=$result;
      }
      $sendArr['phonenumber']=$contactModel['mobile'];
      $sendArr['timestamp']=time();
      $sendArr['money']=str_replace('http://', '', $uri_array['url_short']).' ';
      $sendArr['orderid']="0";
      sendPhoneContent($sendArr);
      echo '{"status":"'.$contactModel['shorturl_handleman'].'","message":"'.$contactModel['shorturl_address'].'"}';
   }
   public function removeShorturl(){
      $loginName=trim(getLoginName());
      $id=trim(I('get.pid'));
      if(empty($loginName) || empty($id)){
         echo '参数异常。';return;
      }
      $renterLogic=new \Logic\HouserentercallLogic();
      $result=$renterLogic->updateShortModel(array('id'=>$id,'update_man'=>$loginName,'update_time'=>time(),'record_status'=>0));
      if($result){
        echo '操作成功。';
      }else{
        echo '操作失败。';
      }
   }
   //新增
    public function addShorturl(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '{"status":"400","message":"登录失效。"}';return;
      }
      $shortData['renter_phone']=trim(I('post.renter_phone'));
      $shortData['renter_source']=I('post.renter_source');
      if(empty($shortData['renter_phone']) || empty($shortData['renter_source'])){
        echo '{"status":"400","message":"数据为空"}';return;
      }
      $roomnos=str_replace('，', ',', trim(I('post.room_no')));
      if(empty($roomnos)){
        echo '{"status":"400","message":"房间编号为空"}';return;
      }
      $moduleType=I('post.moduleType');
      $roomno_array=explode(',', $roomnos);
      $renterLogic=new \Logic\HouserentercallLogic();
      $sendCount=0;
      foreach ($roomno_array as $key => $value) {
          if(empty($value)){
            continue;
          }
          $shortData['room_no']=$value;
          $shortData['update_man']=$loginName;
          $result=$renterLogic->addIncludShorturl($shortData);
          if($result===false){
            continue;
          }
          /*发送短信*/
          if($moduleType=='2'){
            $sendArr['smstype']='EZA010';
          }else if($moduleType=='3'){
            $sendArr['smstype']='EZA011';
          }else{
            $sendArr['smstype']='EZA007';
          }
          $sendArr['name']=' '.$result['clientPhone'].' ';
          $sendArr['money']=' http://www.'.$result['shortUrl'].' ';
          $sendArr['phonenumber']=$shortData['renter_phone'];
          $sendArr['timestamp']=time();
          $sendArr['orderid']="0";
          sendPhoneContent($sendArr);
          $sendCount++;
      }
      echo '{"status":"200","message":"成功发送'.$sendCount.'条短信"}';
   }
   //获取短信文案
   public function getMessageContent(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '{"status":"400","message":"登录失效。"}';return;
      }
      $shortData['renter_phone']=trim(I('post.renter_phone'));
      $shortData['renter_source']=I('post.renter_source');
      if(empty($shortData['renter_phone']) || empty($shortData['renter_source'])){
        echo '{"status":"400","message":"数据为空"}';return;
      }
      $roomnos=str_replace('，', ',', trim(I('post.room_no')));
      if(empty($roomnos)){
        echo '{"status":"400","message":"房间编号为空"}';return;
      }
      $moduleType=I('post.moduleType');
      $roomno_array=explode(',', $roomnos);
      $renterLogic=new \Logic\HouserentercallLogic();
      $messageContent='';
      foreach ($roomno_array as $key => $value) {
        if(empty($value)){
          continue;
        }
        $shortData['room_no']=$value;
        $shortData['update_man']=$loginName;
        $result=$renterLogic->addIncludShorturl($shortData);
        if($result===false){
          continue;
        }
        /*短信模版 */
        if($moduleType=='2'){
          $messageContent.='【嗨住网】根据您的租房需求，本房源可供您参考：房东电话是 '.$result['clientPhone'].' ，房源具体信息可点击 http://'.$result['shortUrl'].' 查看，查看更多无中介费房源请下载嗨住app  ';
        }else if($moduleType=='3'){
          $messageContent.='【嗨住网】您咨询房源的管家电话是 '.$result['clientPhone'].' ，房源具体信息可点击 http://'.$result['shortUrl'].' 查看，查看更多无中介费房源请下载嗨住app  ';
        }else{
          $messageContent.='【嗨住网】您咨询房源的房东电话是 '.$result['clientPhone'].' ，房源具体信息可点击 http://'.$result['shortUrl'].' 查看，查看更多无中介费房源请下载嗨住app  ';
        }
      }
      echo '{"status":"200","message":"'.$messageContent.'"}';
   }
    //编辑（弃用）
    public function editShorturl(){
      echo '{"status":"400","message":"功能已失效"}';return;

      $loginName=trim(getLoginName());
      $id=trim(I('post.pid'));
      if(empty($loginName) || empty($id)){
        echo '{"status":"400","message":"登录失效。"}';return;
      }
      $url=trim(I('post.short_url'));
      $bak=trim(I('post.bak_info'));
      if(empty($url) && empty($bak)){
        echo '{"status":"400","message":"数据异常"}';return;
      }
      $renterLogic=new \Logic\HouserentercallLogic();
      //不发短链
      if(empty($url)){
          $result=$renterLogic->updateShortModel(array('id'=>$id,'update_man'=>$loginName,'update_time'=>time(),'bak_content'=>$bak));
          if($result){
            echo '{"status":"200","message":"'.$bak.'"}';
          }else{
            echo '{"status":"400","message":"操作失败"}';
          }
          return;
      }
      //发送短链
      $uri_array=$this->getSinaOpenapiShorturi($url);
      if(!is_array($uri_array)){
        echo $uri_array;return;
      }
      $shortModel=$renterLogic->getShortModelById($id);
      if($shortModel===false || $shortModel===null){
        echo '{"status":"400","message":"数据读取失败"}';return;
      }
      if(strlen($url)>30){
         $url_array=explode('/', $url);
         $url_arrayLen=count($url_array);
         $room_id=str_replace('.html', '', $url_array[$url_arrayLen-1]);
         if($shortModel['push_status']=="1"){
           //重新推送，新增记录
           $shortData['room_id']=$room_id;
           $shortData['update_man']=$loginName;
           $shortData['short_url']=$uri_array['url_short'];
           $shortData['contact_phone']=$shortModel['contact_phone'];
           $shortData['contact_time']=$shortModel['contact_time'];
           $shortData['renter_phone']=$shortModel['renter_phone'];
           $shortData['bak_content']=$bak;
           $result=$renterLogic->addIncludShorturl($shortData);
           if($result===false){
             echo '{"status":"400","message":"操作失败"}';return;
           }
         }else{
           //update
           $shortModel['push_status']=1;
           $shortModel['update_man']=$loginName;
           $shortModel['update_time']=time();
           $shortModel['short_url']=$uri_array['url_short'];
           if(!empty($bak)){
             $shortModel['bak_content']=$bak;
           }
           $house_array=$renterLogic->getHouseInfoByRoomid($room_id);
           if($house_array===false){
             echo '{"status":"400","message":"操作失败"}';return;
           }
           $shortModel['resource_id']=$house_array['resource_id'];
           $shortModel['room_id']=$house_array['room_id'];
           $shortModel['city_id']=$house_array['city_id'];
           $shortModel['room_money']=$house_array['room_money'];
           $shortModel['region_id']=$house_array['region_id'];
           $shortModel['region_name']=$house_array['region_name'];
           $shortModel['scope_id']=$house_array['scope_id'];
           $shortModel['scope_name']=$house_array['scope_name'];
           $shortModel['client_phone']=$house_array['client_phone'];
           $result=$renterLogic->updateShortModel($shortModel);
           if(!$result){
             echo '{"status":"400","message":"操作失败"}';return;
           }
         }
      }
      /*发送短信*/
      $moduleType=I('post.moduleType');
      if($moduleType=='2'){
        $sendArr['smstype']='EZA010';
        $sendArr['name']=$result;
      }else if($moduleType=='3'){
        $sendArr['smstype']='EZA011';
        $sendArr['name']=$result;
      }else{
        $sendArr['smstype']='EZA007';
        $sendArr['name']=$result;
      }
      $sendArr['phonenumber']=$shortModel['renter_phone'];
      $sendArr['timestamp']=time();
      $sendArr['money']=str_replace('http://', '', $uri_array['url_short']).' ';
      $sendArr['orderid']="0";
      sendPhoneContent($sendArr);
      echo '{"status":"300","message":"success"}';
   }
   private function getSinaOpenapiShorturi($uri){
      if(strlen($uri)<10){
        return '{"status":"400","message":"不是长链接地址"}';
      }
      if(strlen($uri)<30){
        return array('url_short'=>$uri);
      }
      $uri=str_replace('http://www.', 'http://m.', $uri);
      $uri=$uri.'?duanlian=sms';

       $handleLogic=new \Logic\SmssendLogic();
       $short_url=$handleLogic->getShorturl($uri);
       return array('url_short'=>$short_url);
   }
   //导出excel
    public function downloadShorturl(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
       $condition['mobile']=I('get.mobile');
       $condition['startTime']=I('get.startTime');
       $condition['endTime']=I('get.endTime');
       $condition['handle_man']=I('get.handle_man');
       $condition['city_id']=I('get.city_id');
       $condition['status']=I('get.status');
       $condition['rentsource']=I('get.rentsource');

       $handleLogic=new \Logic\HouserentercallLogic();
       $list=$handleLogic->getShortHistoryList($condition,0,5000);
       $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog(strtotime($condition['startTime']),strtotime($condition['endTime']),count($list));
        $title=array(
            'city_id'=>'城市','renter_source'=>'租客来源','renter_phone'=>'租客电话','contact_time'=>'联系时间','contact_phone'=>'联系电话',
            'region_name'=>'区域','scope_name'=>'板块','room_money'=>'租金','client_phone'=>'房东电话',
            'update_man'=>'处理人','push_status'=>'推送状态','short_url'=>'推送短链','bak_content'=>'是否付费','id'=>''
        );
        $excel[]=$title;
        $downAll=false;
       if(in_array(trim(getLoginName()), getDownloadLimit())){
             $downAll=true;
       }
       $cityArray=getCityList();
        foreach ($list as $key => $value) {
            $value['contact_time']=$value['contact_time']>0?date("Y-m-d H:i",$value['contact_time']):""; 
            $value['push_status']= $value['push_status']=="1"?"已推送":"未推送";
            $value['city_id']=$cityArray['00'.$value['city_id']];
            if(!$downAll){
                $value['client_phone']=substr_replace($value['client_phone'], '****', 4,4);
            }
            switch ($value['renter_source']) {
              case '1':
                $value['renter_source']='58端口';
                break;
              case '2':
                $value['renter_source']='58品牌馆';
                break;
              case '3':
                $value['renter_source']='搜房';
                break;
              case '4':
                $value['renter_source']='365淘房';
                break;
              case '5':
                $value['renter_source']='app拨打失败';
                break;
              case '8':
                $value['renter_source']='其他';
                break;
              case '6':
                $value['renter_source']='安居客';
                break;
              case '7':
                $value['renter_source']='赶集';
                break;
              default:
                $value['renter_source']='';
                break;
            }
            $value['id']="";
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '短链推送');
        $xls->addArray($excel);
        $xls->generateXML('短链推送'.date("YmdHis"));
    }
    //导出没有推送短链的租客
    public function downloadNotshort(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
       $condition['mobile']=I('get.mobile');
       $condition['startTime']=I('get.startTime');
       $condition['endTime']=I('get.endTime');
       $condition['handle_man']=I('get.handle_man');
       $condition['bigcode']=I('get.bigcode');
       $condition['status']='0';
       $handleLogic=new \Logic\ContactOwner();
       $list=$handleLogic->getShorturlDownloadList($condition);
       $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog(strtotime($condition['startTime']),strtotime($condition['endTime']),count($list));
        $title=array(
            'mobile'=>'租客电话','call_time'=>'联系时间','big_code'=>'联系电话','shorturl_handleman'=>'处理人','shorturl_issend'=>'推送状态',
            'shorturl_address'=>'推送短链','city_id'=>'城市'
        );
        $excel[]=$title;
        foreach ($list as $key => $value) {
            $value['call_time']=$value['call_time']>0?date("Y-m-d H:i",$value['call_time']):""; 
            $value['shorturl_issend']= '未推送';
            switch ($value['big_code']) {
              case '4008180555':
                $value['city_id']='上海';
                break;
              case '4008150019':
                $value['city_id']='北京';
                break;
              case '4008170019':
                $value['city_id']='杭州';
                break;
              default:
                break;
            }
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '短链推送');
        $xls->addArray($excel);
        $xls->generateXML('短链推送'.date("YmdHis"));
    }
}
?>
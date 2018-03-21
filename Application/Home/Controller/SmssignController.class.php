<?php
namespace Home\Controller;
use Think\Controller;
class SmssignController extends Controller {
    //验证码列表
    public function smssignlist(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
      $handleMenu->jurisdiction();
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $ownermobile=I('get.ownermobile');
      $ownername=I('get.ownername');
      $moneytype=I('get.moneytype');
      $update_man=I('get.updateman');
      if($startTime!=""&&$endTime==""){
          $where['check_time']=array('gt',$startTime);
      }
      if($endTime!=""&&$startTime==""){
          $where['check_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!=""){
          $where['check_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }

      if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
          $where['check_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($ownermobile!=""){
          $where['owner_mobile']=array('eq',$ownermobile);
      }
      if($ownername!=""){
          $where['owner_name']=array('like','%'.$ownername.'%');
      }
      if($moneytype!=""){
         $where['money_type']=array('eq',$moneytype);
      }
      if($update_man!=""){
           $where['update_man']=array('eq',$update_man);
      }
      $where['city_code']=C('CITY_CODE');

      $modelSmssign=new \Home\Model\smssign();
      $count=$modelSmssign->modelPageCount($where);
      $Page= new \Think\Page($count,10);
      $list=$modelSmssign->modelPageList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$list);
		  $this->display();
    }

    //发送签约短信
    public function smssigntemp(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
   
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
    }
    public function pushsmssgin(){
        $handleCustomer = new \Logic\CustomerLogic();
        $modelSmssign=new \Home\Model\smssign();
        $handleSms = new \Logic\Commonsms();
        $mobile=I('get.mobile');
        $commission=I('get.commission');
        $money_type=I('get.moneytype');
        $customer=$handleCustomer->getResourceClientByPhone($mobile);
        $where['owner_mobile']=$mobile;
        $sginarr=$modelSmssign->modelFind($where);
        if($sginarr&&$sginarr['sign_time']!=0){
          echo "{\"status\":\"201\",\"msg\":\"\"}";
        }else{ 
            if($sginarr){
              $sginarr['create_time']=time();
              $sginarr['commission']=$commission;
              $sginarr['money_type']=$money_type;
              $result=$modelSmssign->modelUpdate($sginarr);
              $sid=$sginarr['id'];
            }else{
                if($customer){
                  $data['owner_name']=$customer['true_name'];
                }
                $data['id']=create_guid();
                $data['owner_mobile']=$mobile;
                $data['create_time']=time();
                $data['commission']=$commission;
                $data['money_type']=$money_type;
                $data['update_man']=cookie("admin_user_name");
                $data['city_code']=C('CITY_CODE');
                $result=$modelSmssign->modelAdd($data);
                $sid=$data['id'];
            }
            if($result){
                $url="http://s.loulifang.com/smssign.html?sid=".$sid;
                $shorturl=$this->getSinaOpenapiShorturi($url);
                $smsownerarr['renter_phone']=$mobile;
                $smsownerarr['create_time']=time();
                $smsownerarr['renter_name']=$shorturl['url_short'];
                $smsownerarr['price_cnt']="100";
                $smsownerarr['id']="0000000";
                $handleSms->sendSms($smsownerarr,'EZA008');
                echo "{\"status\":\"200\",\"msg\":\"\"}";
            }
        }
    }

   //导出excel
    public function downloadExcel(){
          $modelSmssign=new \Home\Model\smssign();
          $startTime=strtotime(I('get.startTime'));
          $endTime=strtotime(I('get.endTime'));
      $ownermobile=I('get.ownermobile');
      $ownername=I('get.ownername');
      $moneytype=I('get.moneytype');
      $update_man=I('get.updateman');
      if($startTime!=""&&$endTime==""){
          $where['check_time']=array('gt',$startTime);
      }
      if($endTime!=""&&$startTime==""){
          $where['check_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!=""){
          $where['check_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }

      if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
          $where['check_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($ownermobile!=""){
          $where['owner_mobile']=array('eq',$ownermobile);
      }
      if($ownername!=""){
          $where['owner_name']=array('like','%'.$ownername.'%');
      }
      if($moneytype!=""){
         $where['money_type']=array('eq',$moneytype);
      }
      if($update_man!=""){
           $where['update_man']=array('eq',$update_man);
      }
      $where['city_code']=C('CITY_CODE');
      $list=$modelSmssign->modelPageList(0,9999999999,$where);
      $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($list));
         $title=array(
                owner_name=>'房东名字',
                owner_mobile=>'房东手机',
                check_time=>'签约时间',
                create_time=>'短信发送时间',
                update_man=>'发送人',
                commission=>'签约佣金',
            );
         $exarr[]=$title;
         foreach ($list as $key => $value) {
                $value1['owner_name']=$value['owner_name'];
                $value1['owner_mobile']=$value['owner_mobile'];
                $value1['check_time']=$value['check_time']>0?date("Y-m-d H:i",$value['check_time']):""; 
                $value1['create_time']=$value['create_time']>0?date("Y-m-d H:i",$value['create_time']):""; 
                $value1['update_man']=$value['update_man'];
                if($value['money_type']==1){
                  $value1['commission']=$value['commission'];
                }elseif($value['money_type']==0){
                  $value1['commission']=$value['commission']."%";
                }
                $exarr[]=$value1;
         }
         if($gaptime>3600*24*7 || empty($where)){
            $this->success('下载数据不能超过一个星期！','reportlist.html?no=6&leftno=34');
         }else{
            Vendor('phpexcel.phpexcel');
            $xls = new \Excel_XML('UTF-8', false, '举报审核');
            $xls->addArray($exarr);
            $xls->generateXML('举报审核'.date("YmdHis"));     
         }
    }


    public function getSinaOpenapiShorturi($uri){
        if(strlen($uri)<20){
          return '{"status":"400","message":"不是长链接地址"}';
        }
        $handleLogic=new \Logic\SmssendLogic();
         $short_url=$handleLogic->getShorturl($uri);
         return array('url_short'=>$short_url);
       /* $output=curl_url('http://api.t.sina.com.cn/short_url/shorten.json?source=2859504802&url_long='.$uri);
        if(empty($output)){
          return '{"status":"400","message":"生成短链失败"}';
        }
        $result=json_decode($output,true);
        if(count($result)==0 || !isset($result[0]['url_short'])){
          return '{"status":"400","message":"短链获取失败"}';
        }
      return $result[0];*/

   }
}
?>
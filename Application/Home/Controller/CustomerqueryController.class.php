<?php
namespace Home\Controller;
use Think\Controller;
class CustomerqueryController extends Controller {
    //用户查询
    public function queryList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new\Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
       $handleMenu->jurisdiction();
       $startTime=I('get.startTime');
       $endTime=I('get.endTime');
       $mobile=trim(I('get.mobile'));
       $is_owner=I('get.isowner');
       $is_renter=I('get.isrenter');

       $platform=I('get.platform');
       $telephone=trim(I('get.telephone'));
       $name=trim(I('get.name')); 
       $channel=trim(I('get.channel')); 
       $where['record_status']=array('eq',1);
       
       if($startTime!="" && $endTime!=""){
          $where['create_time']=array(array('gt',strtotime($startTime)),array('lt',strtotime($endTime)+86400));
       }else if($startTime!=""){
          $where['create_time']=array('gt',strtotime($startTime));
       }else if($endTime!=""){
          $where['create_time']=array('lt',strtotime($endTime)+86400);
       }
       if($mobile!=""){
         $where['mobile']=array('eq',$mobile);
       }
       if($is_owner!=""){
          $where['is_owner']=array('eq',intval($is_owner));
       }
       if($is_renter!=""){
          $where['is_renter']=array('eq',intval($is_renter));
       }
       if($platform!=""){
          $where['gaodu_platform']=array('eq',intval($platform));
       }
       if($telephone!=''){
         $where['telephone']=array('like',$telephone.'%');
       }
       if($name!=""){
         $where['true_name']=array('like',$name.'%');
       }
       if($channel!=""){
         $where['channel']=array('like',$channel.'%');
       }
       $count=0;
       if(isset($_GET['mobile']) || isset($_GET['p'])){
          $handleCustomer = new \Logic\CustomerLogic();
          $count=$handleCustomer->getCustomerPageCount($where);
       }
      if($count>0){
        $Page= new \Think\Page($count,15);
        $list=$handleCustomer->getAllCustomer($Page->firstRow,$Page->listRows,$where);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
      }else{
        $this->assign("show","");
        $this->assign("list","");
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
		  $this->display();
    }

    //租客认证
    public function renterAuth(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
       $handleCustomer = new \Logic\CustomerLogic();
       $resultarr=$handleCustomer->getModelById($_GET['customer_id']);
         if($_GET['type']==1){
             $resultarr['renter_auth']=0;
         }else{
             $resultarr['renter_auth']=1;
         }
       $result=$handleCustomer->updateModel($resultarr);
       if($result){
         if($_GET['type']==1){
           $this->success('取消成功！', 'renterAuthList.html?no=6&leftno=59');
         }else{
           $this->success('认证成功！', 'renterAuthList.html?no=6&leftno=59');
        }
      }
    }
   //租客认证列表
   public function renterAuthList(){
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
          $startTime=I('get.startTime');
          $endTime=I('get.endTime');
          $mobile=trim(I('get.mobile'));
          $is_owner=I('get.isowner');
          $is_renter=I('get.isrenter');

          $where['record_status']=array('eq',1);
          $where['renter_auth']=array('eq',1);
          if($startTime!="" && $endTime!=""){
             $where['create_time']=array(array('gt',strtotime($startTime)),array('lt',strtotime($endTime)+86400));
          }else if($startTime!=""){
             $where['create_time']=array('gt',strtotime($startTime));
          }else if($endTime!=""){
             $where['create_time']=array('lt',strtotime($endTime)+86400);
          }
          if($mobile!=""){
            $where['mobile']=array('eq',$mobile);
          }
          if($is_owner!=""){
             $where['is_owner']=array('eq',intval($is_owner));
          }
          if($is_renter!=""){
             $where['is_renter']=array('eq',intval($is_renter));
          }
       
          $handleCustomer = new \Logic\CustomerLogic();
          $count=$handleCustomer->getCustomerPageCount($where);
          if($count>0){
            $Page= new \Think\Page($count,15);
            $list=$handleCustomer->getAllCustomer($Page->firstRow,$Page->listRows,$where);
            $this->assign("show",$Page->show());
            $this->assign("list",$list);
          }else{
            $this->assign("show","");
            $this->assign("list",null);
          }
          
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->assign("pagecount",$count);
          $this->display();

   }

    //导出excel
    public function downloadExcel(){
        $startTime=I('get.startTime');
        $endTime=I('get.endTime');
        $mobile=trim(I('get.mobile'));
        $is_owner=I('get.isowner');
        $is_renter=I('get.isrenter');
        $platform=I('get.platform');
        $telephone=trim(I('get.telephone'));
        $name=trim(I('get.name')); 
        $channel=trim(I('get.channel')); 
        $where['record_status']=array('eq',1);
        $gaptime=3600*24*31;
        if($startTime!="" && $endTime!=""){
          $gaptime=strtotime($endTime)-strtotime($startTime);
           $where['create_time']=array(array('gt',strtotime($startTime)),array('lt',strtotime($endTime)+86400));
        }else if($startTime!=""){
          $gaptime=time()-strtotime($startTime);
           $where['create_time']=array('gt',strtotime($startTime));
        }else if($endTime!=""){
           $where['create_time']=array('lt',strtotime($endTime)+86400);
        }
        if($mobile!=""){
          $where['mobile']=array('eq',$mobile);
        }
        if($is_owner!=""){
           $where['is_owner']=array('eq',intval($is_owner));
        }
        if($is_renter!=""){
          $where['is_renter']=array('eq',intval($is_renter));
       }
        if($platform!=""){
           $where['gaodu_platform']=array('eq',intval($platform));
        }
        if($telephone!=''){
          $where['telephone']=array('like',$telephone.'%');
        }
        if($name!=""){
          $where['true_name']=array('like',$name.'%');
        }
        if($channel!=""){
          $where['channel']=array('like',$channel.'%');
        } 
        if($gaptime>3600*24*7){
           return $this->error('下载数据不能超过一个星期！','queryList.html?no=6&leftno=34');
        }

         $handleCustomer = new \Home\Model\customer();
         $userList=$handleCustomer->getFieldListByWhere("mobile,true_name,sex,is_owner,is_renter,gaodu_platform,channel,create_time",$where,"create_time desc",0,9999);
         $exarr[]=array('mobile'=>'注册手机号','true_name'=>'用户姓名','sex'=>'性别','is_owner'=>'房东类型','is_renter'=>'是否租客',
                        'gaodu_platform'=>'注册平台','channel'=>'渠道','create_time'=>'注册时间');
         $downAll=false;
        if(in_array(trim(getLoginName()), getDownloadLimit())){
              $downAll=true;
        }

         $handleDownLog= new\Logic\DownLog();
          $handleDownLog->downloadlog(strtotime($startTime),strtotime($endTime),count($userList));
         foreach ($userList as $key => $value) {
            switch ($value['sex']) {
              case '0':
                $value['sex']="女";
                break;
              case '1':
                $value['sex']="男";
                break;
              default:
                $value['sex']="保密";
                break;
            }
            switch ($value['is_owner']) {
              case '3':
                $value['is_owner']="个人房东";
                break;
              case '4':
                $value['is_owner']="职业房东";
                break;
              case '5':
                $value['is_owner']="中介用户";
                break;
              default:
                $value['is_owner']='';
                break;
            }
            $value['is_renter']=$value['is_renter']==1?'是':'否';
           switch ($value['gaodu_platform']) {
              case '0':
                $value['gaodu_platform']="wap";
                break;
              case '1':
                $value['gaodu_platform']="android";
                break;
              case '2':
                $value['gaodu_platform']="iphone";
                break;
              case '3':
                $value['gaodu_platform']="系统产生";
                break;
              case '4':
                $value['gaodu_platform']="活动";
                break;
              case '6':
                $value['gaodu_platform']="h5";
                break;
              case '11':
                $value['gaodu_platform']="open_api";
                break;
              case '8':
                $value['gaodu_platform']="小程序";
                break;
              case '15':
                $value['gaodu_platform']="房东版android";
                break;
              case '14':
                $value['gaodu_platform']="房东版iphone";
                break;
              default:
                break;
           }
           if(!$downAll){
             $value['mobile']=substr_replace($value['mobile'], '****', 4,4);
           }
            $value['create_time']=date("Y-m-d H:i:s",$value['create_time']); 
            $exarr[]=$value;
         }
          Vendor('phpexcel.phpexcel');
          $xls = new \Excel_XML('UTF-8', false, '用户列表');
          $xls->addArray($exarr);
          $xls->generateXML('用户'.date("YmdHis"));     
         
    }
}
?>
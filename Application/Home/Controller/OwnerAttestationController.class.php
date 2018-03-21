<?php
namespace Home\Controller;
use Think\Controller;
class OwnerAttestationController extends Controller{

   public function attestationlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
      $handleMenu->jurisdiction();
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $mobile=I('get.mobile');
      $name=I('get.name');
      $city_code=I('get.citycode');
      if($startTime!=""&&$endTime==""){
             $where['customerinfo.create_time']=array('gt',$startTime);
      }
      if($endTime!=""&&$startTime==""){
            $where['customerinfo.create_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!=""){
            $where['customerinfo.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
            $where['customerinfo.create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($mobile!=""){
            $where['customer.mobile']=array('eq',$mobile);
      }
      if($name!=""){
           $where['customer.true_name']=array('like','%'.$name.'%');
      }
      if($city_code!=""){
           $where['customer.city_code']=array('like','%'.$city_code.'%');
      }
      $where['customer.owner_verify']=array('gt',0);
      $handleCustomer = new \Logic\CustomerLogic();
      $handleCustomerInfo = new \Logic\CustomerInfo();
      $count=$handleCustomerInfo->modelAttestationCount($where);
      $Page= new \Think\Page($count,8);
      $listarr=$handleCustomerInfo->modelAttestationList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
          $info['customer_id']=$value['id'];
          $infoarr=$handleCustomerInfo->modelFind($info);
          $value['apply_time']=$infoarr['apply_time'];
          $value['owner_update_time']=$infoarr['owner_update_time'];
          $value['owner_update_man']=$infoarr['owner_update_man'];
          $list[]=$value;
      }

      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }

   //详情
    public function ownerdetails(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleCustomer = new \Logic\CustomerLogic();
       $handleCustomerInfo = new \Logic\CustomerInfo();
       $handleOtherallImg=new \Home\Model\otherallimg();
       $customer_id=I('get.cid');
       if($customer_id){
           $customer=$handleCustomer->getModelById($customer_id);
           $infowhere['customer_id']=$customer['id'];
           $infoarr=$handleCustomerInfo->modelFind($infowhere);
           $imgwhere['relation_id']=$customer_id;
           $imgwhere['img_type']="auth";
           $otherallimg=$handleOtherallImg->modelSelect($imgwhere);
           if($otherallimg){
              foreach ($otherallimg as $key => $value) {
                   $value['img_url']="http://img.loulifang.com.cn/".$value['img_path'].$value['img_name'].".".$value['img_ext'];
                   $imgarr[]=$value;
              }
              $this->assign("authimg",$imgarr);
           }
           $this->assign("customer",$customer);
           $this->assign("infoarr",$infoarr);
       }
      
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
    }
    //更新状态
    public function updatestatus(){
         $handleCustomer = new \Logic\CustomerLogic();
         $handleCustomerInfo = new \Logic\CustomerInfo();
         $handleCustomerNotify = new \Logic\CustomerNotifyLogic();
         $handleLoginOut=new \Home\Model\customerloginout();
         $handleDevices=new \Home\Model\customerdevices();
         $customer_id=I('get.customer_id');
         $owner_verify=I('get.status');
         $reason=I('get.reason');
         if($customer_id){
             $customer=$handleCustomer->getModelById($customer_id);
             if($customer){
                $customer['owner_verify']=$owner_verify;
                $handleCustomer->updateModel($customer);
                $where['customer_id']=$customer_id;
                $infoarr=$handleCustomerInfo->modelFind($where);
                if($infoarr){
                    $infoarr['refuse_reason']=$reason;
                    $infoarr['owner_update_time']=time();
                    $infoarr['owner_update_man']=cookie("admin_user_name");
                    $handleCustomerInfo->modelUpdate($infoarr);
                    if($owner_verify==5){
                         $devices=$handleDevices->getUseModel($customer_id);
                         if($devices){
                             $devdata['id']=create_guid();
                             $devdata['customer_id']=$devices['customer_id'];
                             $devdata['token_id']=$devices['token_id'];
                             $devdata['udid']=$devices['udid'];
                             $devdata['create_time']=time();
                             $devdata['platform']=$devices['platform'];
                             $handleLoginOut->modelAdd($devdata);//强制退出
                         }
                          //拉黑短信通知   
                          $handleSms = new \Logic\Commonsms();
                          $smsendarr['renter_phone']=$customer['mobile'];
                          $smsendarr['create_time']=time();
                          $smsendarr['renter_name']="xx";
                          $smsendarr['price_cnt']="00";
                          $smsendarr['id']="00";
                          $handleSms->sendSms($smsendarr,'FHS009');
                    }  
                    echo "200";
                }
             }
        }
    }
    public function ownerupdate(){
           $handleCommonCache=new \Logic\CommonCacheLogic();
            if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
            }
           $handleMenu = new \Logic\AdminMenuListLimit();
           $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
           $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
           $switchcity=$handleCommonCache->cityauthority();
           $this->assign("switchcity",$switchcity);
           $handleCustomer = new \Logic\CustomerLogic();
           $handleCustomerInfo = new \Logic\CustomerInfo();
           $handleOtherallImg=new \Home\Model\otherallimg();
           $customer_id=I('get.cid');
           if($customer_id){
               $customer=$handleCustomer->getModelById($customer_id);
               $infowhere['customer_id']=$customer['id'];
               $infoarr=$handleCustomerInfo->modelFind($infowhere);
               $imgwhere['relation_id']=$customer_id;
               $imgwhere['img_type']="auth";
               $otherallimg=$handleOtherallImg->modelSelect($imgwhere);
               if($otherallimg){
                  foreach ($otherallimg as $key => $value) {
                       $value['img_url']="http://img.loulifang.com.cn/".$value['img_path'].$value['img_name'].".".$value['img_ext'];
                       $imgarr[]=$value;
                  }
                  $this->assign("authimg",$imgarr);
               }
               $this->assign("customer",$customer);
               $this->assign("infoarr",$infoarr);
           }
          
          $this->assign("menutophtml",$menu_top_html);
          $this->assign("menulefthtml",$menu_left_html);
          $this->display();

    } 
}
?>
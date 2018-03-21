<?php
namespace Home\Controller;
use Think\Controller;
class CustomerController extends Controller {
    //房东认证列表
    public function authenticationList(){
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
       $startTime=strtotime(isset($_GET['startTime'])?$_GET['startTime']:"2015-04-01");
       $endTime=strtotime(isset($_GET['endTime'])?$_GET['endTime']:"2025-04-01");
       $mobile=isset($_GET['mobile'])?$_GET['mobile']:"";
       $name=isset($_GET['name'])?$_GET['name']:"";
       $where['is_auth']=array('eq',1);
       if($startTime!=""&&$endTime==""){
         $where['auth_time']=array('gt',$startTime);
       }
       if($endTime!=""&&$startTime==""){
         $where['auth_time']=array('lt',$endTime+86400);
       }
       if($startTime!=""&&$endTime!=""){
         $where['auth_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
         $where['auth_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($mobile!=""){
         $where['mobile']=array('eq',$mobile);
       }
       if($name!=""){
         $where['true_name']=array('eq',$name);
       }
      $handleCustomer = new \Logic\CustomerLogic();
      $count=$handleCustomer->getCustomerPageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
          $Page->parameter[$key]=urlencode($val);
      }
      $list=$handleCustomer->getCustomerList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$list);
		  $this->display();
    }

    //新增认证房东
    public function addAuthentication(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          $this->error('非法操作',U('Index/index'),1);
          return;
       }
      if(isset($_GET['dis']) && strtolower($_GET['dis'])=='opym'){
        //进入新增页面
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
         $this->display();
      }else{
        //提交新增信息
         $auth['mobile']=$_POST['mobile'];
         $auth['true_name']=$_POST['name'];
         $auth['sex']=$_POST['sex'];
         $auth['age']=$_POST['age'];
         $auth['is_auth']=1;
         $auth['auth_time']=time();
         $bankaccount=isset($_POST['bankaccount'])?$_POST['bankaccount']:"";
         $paytreasure=isset($_POST['paytreasure'])?$_POST['paytreasure']:"";
         $companyaccount=isset($_POST['companyaccount'])?$_POST['companyaccount']:"";
         $handleCustomer = new \Logic\CustomerLogic();
         $result=$handleCustomer->getResourceClientByPhone($auth['mobile']);
         if($result){
           $auth['id']=$result['id'];
           if($result['is_owner']==0){
              $auth['is_owner']=2;
           }
           $data['customer_id']=$result['id'];
           $data['is_auth']=1;
           $handleCustomer->upLandlordAuth($data);
           $result1=$handleCustomer->updateModel($auth);
           if($bankaccount!=""){
              $this->subCustomerBank($result['id'],0,$bankaccount);
           }
           if($paytreasure!=""){
              $this->subCustomerBank($result['id'],1,$paytreasure);
           }
           if($companyaccount!=""){
             $this->subCustomerBank($result['id'],2,$companyaccount);
           }
           if($result1){
              $handleCustomer->updateAuthByCustomerid($data['customer_id'],$data['is_auth']);
              $this->success('提交成功！',U('Customer/authenticationList'),0);
           }
         }else{
           $auth['id']=create_guid();
           $auth['is_owner']=3;
           $auth['is_renter']=0;
           $auth['create_time']=time();
           $result=$handleCustomer->addModel($auth);
           if($bankaccount!=""){
              $this->subCustomerBank($auth['id'],0,$bankaccount);
           }
           if($paytreasure!=""){
              $this->subCustomerBank($auth['id'],1,$paytreasure);
           }
           if($companyaccount!=""){
             $this->subCustomerBank($auth['id'],2,$companyaccount);
           }
           if($result){
             $this->success('提交成功！',U('Customer/authenticationList'),0);
           }
         } 
      }
    }
    //认证状态更新
    public function upAuthenStatus(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          $this->error('非法操作',U('Index/index'),1);
       }
       $paid=$_GET['paid'];
       $handleCustomer = new \Logic\CustomerLogic();
       $resultarr=$handleCustomer->getModelById($paid);
       if($resultarr['is_auth']==1){
          $resultarr['is_auth']=0;
       }else{
          $resultarr['is_auth']=1;
       }
        $data['customer_id']=$paid;
        $data['is_auth']=0;
        $handleCustomer->upLandlordAuth($data);
        $result=$handleCustomer->updateModel($resultarr);
        if($result){
          $handleCustomer->updateAuthByCustomerid($data['customer_id'],$data['is_auth']);
          $this->success('更新成功！',U('Customer/authenticationList'),0);
        }
    }
    //修改
    public function upLandlord(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $customer_id=$_GET['uid'];
        $handleCustomer = new \Logic\CustomerLogic();
        $customer=$handleCustomer->getModelById($customer_id);
        $cusbank=$handleCustomer->getBankById($customer_id);
        $bankarr=null;
        if($cusbank!=null){
          foreach ($cusbank as $key => $value) {
            if($value['bank_type']==0){
               $bankarr['b_id']=$value['id'];
               $bankarr['bankaccount']=$value['card_number'];
            }
            if($value['bank_type']==1){
               $bankarr['p_id']=$value['id'];
               $bankarr['paytreasure']=$value['card_number'];
            }
             if($value['bank_type']==2){
               $bankarr['c_id']=$value['id'];
               $bankarr['companyaccount']=$value['card_number'];
            }
          }
        }
         $this->assign("menutophtml",$menu_top_html);
         $this->assign("menulefthtml",$menu_left_html);
        $this->assign("customer",$customer);
        $this->assign("bankarr",$bankarr);
        $this->display();
    }

   //修改提交
   public function upSubLandlord(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
      $auth['mobile']=$_POST['mobile'];
      $auth['true_name']=$_POST['name'];
      $auth['sex']=$_POST['sex'];
      $auth['age']=$_POST['age'];
      $auth['is_auth']=1;
      $auth['auth_time']=time();
      $bankaccount=$_POST['bankaccount'];
      $paytreasure=$_POST['paytreasure'];
      $companyaccount=$_POST['companyaccount'];
      $b_id=$_POST['b_id'];
      $p_id=$_POST['p_id'];
      $c_id=$_POST['c_id'];
      $handleCustomer = new \Logic\CustomerLogic();
      $result=$handleCustomer->getResourceClientByPhone($auth['mobile']);
      if($result){
          $auth['id']=$result['id'];
          $auth['is_owner']=$result['is_owner'];
          $result1=$handleCustomer->updateModel($auth);
          if($bankaccount!=""){
              $bank=$handleCustomer->getBankType($result['id'],0);
              if($bank){
                   $this->upCustomerBank($b_id,$result['id'],0,$bankaccount);
              }else{
                     $this->subCustomerBank($auth['id'],0,$bankaccount);
              }
          }
         if($paytreasure!=""){
              $pay=$handleCustomer->getBankType($result['id'],1);
              if($pay){
                      $this->upCustomerBank($p_id,$result['id'],1,$paytreasure);
              }else{
                     $this->subCustomerBank($auth['id'],1,$paytreasure);
              }
          }
          if($companyaccount!=""){
              $company=$handleCustomer->getBankType($result['id'],2);
              if($company){
                     $this->upCustomerBank($c_id,$result['id'],2,$companyaccount);
              }else{
                     $this->subCustomerBank($auth['id'],2,$companyaccount);
              }
          }
         
          if($result1){
             $this->success('修改成功！',U('Customer/upLandlord',array('uid'=>$auth['id'],'no'=>6,'leftno'=>33)),0);
          }
      }
   }

    public function subCustomerBank($customer_id,$bank_type,$card_number){
          $cusbank['id']=create_guid();
          $cusbank['customer_id']=$customer_id;
          $cusbank['bank_type']=$bank_type;
          $cusbank['card_number']=$card_number;
          $cusbank['create_time']=time();
          $handleCustomer = new \Logic\CustomerLogic();
          $handleCustomer->addBankNumber($cusbank);
    }

    public function upCustomerBank($id,$customer_id,$bank_type,$card_number){
          $cusbank['id']=$id;
          $cusbank['customer_id']=$customer_id;
          $cusbank['bank_type']=$bank_type;
          $cusbank['card_number']=$card_number;
          $cusbank['update_time']=time();
          $handleCustomer = new \Logic\CustomerLogic();
          $handleCustomer->upBankById($cusbank);
    }
}
?>
<?php
namespace Home\Controller;
use Think\Controller;
class ServiceController extends Controller{
  //待处理订单
   public function awaitlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $handleMenu->jurisdiction();
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $handleServiceOptions = new \Logic\ServiceOptions();
      $name=I('get.name');//用户名
      $price_cnt=I('get.price_cnt');//订单金额
      $mobile=I('get.mobile');
      $address=I('get.address');
      $order_status=I('get.orderstatus');
      $orderid=I('get.orderid');
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $where['record_status']=array('eq',1);
      $where['order_status']=array('lt',4);
      $where['info_id']=array('neq',"sixyuanbanjia");
       if($endTime!=""&&$startTime==""){
         $where['service_time']=array('lt',$endTime+86400);
       }
      if($startTime!=""&&$endTime!=""){
        $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($name!=""){
         $where['customer_name']=array('eq',$name);
      }
      if($price_cnt!=""){
         $where['price_cnt']=array('eq',$price_cnt);
      }
      if($address!=""){
         $where['address']=array('like','%'.$address.'%');
      }
      if($mobile!=""){
         $where['customer_mobile']=array('eq',$mobile);
      }
      if($order_status!=""){
         $where['order_status']=array('eq',$order_status);
      }
      if($orderid!=""){
         $where['id']=array('eq',$orderid);
      }
      $count=$handleServiceOrder->modelServicePageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
           $Page->parameter[$key]=urlencode($val);
      }
      $listarr=$handleServiceOrder->modelServiceList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
          $whereinfo['id']=$value['info_id'];
          $serviceinfo=$handleServiceInfo->modelServiceFind($whereinfo);
          $value['class_name']=$serviceinfo['class_name'];
          $whereop['id_no']=$value['option_no'];
          $options=$handleServiceOptions->modelServiceFind($whereop);
          $value['option_name']=$options['name'];
          if($value['serviceman_id']!=""){
             $whereman['id']=$value['serviceman_id'];
             $manarr=$handleServiceMan->modelServiceFind($whereman);
             $value['man_name']=$manarr['name'];
             $value['man_mobile']=$manarr['mobile'];
          }
          $list[]=$value;
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
   }
  //师傅库列表
  public function personnellist(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $handleMenu->jurisdiction();
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceMan = new \Logic\ServiceMan();
      $mobile=I('get.mobile');
      $name=I('get.name');
      $class_id=I('get.class_id');
      $where['record_status']=array('eq',1);
      if($name!=""){
         $where['name']=array('like','%'.$name.'%');
      }
      if($mobile!=""){
         $where['mobile']=array('eq',$mobile);
      }
      if($class_id!=""){
         $where['service_scope']=array('like','%'.$class_id.'%');
      }
      $count=$handleServiceMan->modelServicePageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
           $Page->parameter[$key]=urlencode($val);
      }
     $list=$handleServiceMan->modelServiceList($Page->firstRow,$Page->listRows,$where);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->assign("pagecount",$count);
     $this->assign("show", $Page->show());
     $this->assign("list",$list);
     $this->display();
  }
  //新增师傅页面
  public function addservicemanpage(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
  }
    //提交师傅信息
    public function addserviceman(){
        if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
           $this->uploadImage();
          return;
         }
           $servicename=$_POST['servicename'];
           $arrcount=count($servicename);
           for($i=0;$i<$arrcount;$i++){
              $serviceStr.=$servicename[$i].",";

           }

           $data['id']=create_guid();
           $data['name']=I('post.name');
           $data['mobile']=I('post.mobile');
           $data['sex']=I('post.sex');;
           $data['create_time']=time();
           $data['record_status']=1;
           $data['avatar_url']=I('post.bright');
           $data['service_scope']=substr($serviceStr,0,-1);

           $handleServiceMan = new \Logic\ServiceMan();
           $result=$handleServiceMan->modelServiceAdd($data);
           if($result){
                 $this->success('新增成功！','personnellist.html?no=4&leftno=76');
           }
    }
   //派单
   public function distributed(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $handleServiceMan = new \Logic\ServiceMan();
      $mobile=I('get.mobile');
      $name=I('get.name');
      $class_id=I('get.class_id');
      $where['record_status']=array('eq',1);
      if($name!=""){
         $where['name']=array('like','%'.$name.'%');
      }
      if($mobile!=""){
         $where['mobile']=array('eq',$mobile);
      }
      if($class_id!=""){
         $where['service_scope']=array('like','%'.$class_id.'%');
      }
      $count=$handleServiceMan->modelServicePageCount($where);
      $Page= new \Think\Page($count,15);
      foreach($where as $key=>$val){
           $Page->parameter[$key]=urlencode($val);
      }
      $list=$handleServiceMan->modelServiceList($Page->firstRow,$Page->listRows,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show", $Page->show());
      $this->assign("list",$list);
      $this->display();
   }
   //选择师傅生成订单
   public function subsend(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $man_id=I('get.manid');
      $orderid=I('get.orderid');
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $whereorder['id']= $orderid;
      $orderarr=$handleServiceOrder->modelServiceFind($whereorder);
      $whereman['id']= $man_id;
      $manarr=$handleServiceMan->modelServiceFind($whereman);
      $whereinfo['id']=$orderarr['info_id'];
      $infoarr=$handleServiceInfo->modelServiceFind($whereinfo);
      $this->assign("infoarr",$infoarr);
      $this->assign("manarr",$manarr);
      $this->assign("orderarr",$orderarr);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
   }
   //服务派单提交
    public function subserviceorder(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
         $handleServiceOrder = new \Logic\ServiceOrder();
          $handleOrderStatus=new \Logic\ServiceOrderStatus();
         $man_id=I('get.manid');
         $orderid=I('get.orderid');
         $where['id']= $orderid;
         $data=$handleServiceOrder->modelServiceFind($where);
         $data['serviceman_id']=$man_id;
         $data['order_status']=3;
         $result=$handleServiceOrder->modelServiceUpdate($data);
         if($result){
           $sdata['id']=create_guid();
           $sdata['order_id']= $data['id'];
           $sdata['order_status']=3;
           $sdata['create_time']=time();
           $sdata['memo']="已派单";
           $sdata['oper_id']=cookie("admin_user_name");
           $handleOrderStatus->modelServiceAdd($sdata);
           $this->success('派单成功！', 'awaitlist.html?no=4&leftno=73');
         }
    }
  //服务订单查看
  public function orderinfo(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $orderid=I('get.oid');
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $handleServiceOptions = new \Logic\ServiceOptions();
      $whereorder['id']= $orderid;
      $orderarr=$handleServiceOrder->modelServiceFind($whereorder);
      if($orderarr['serviceman_id']!=""){
        $whereman['id']= $orderarr['serviceman_id'];
        $manarr=$handleServiceMan->modelServiceFind($whereman);
      }
      $whereinfo['id']=$orderarr['info_id'];
      $infoarr=$handleServiceInfo->modelServiceFind($whereinfo);
      $whereop['id_no']=$orderarr['option_no'];
      $options=$handleServiceOptions->modelServiceFind($whereop);
      $handleOrders = new \Logic\Orders();
      $paymanner=$handleOrders->payManner($orderid);
      $this->assign("paymanner",$paymanner);
      $this->assign("options",$options);
      $this->assign("infoarr",$infoarr);
      $this->assign("manarr",$manarr);
      $this->assign("orderarr",$orderarr);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
  }
  //取消订单
   public function ordercancel(){
    $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
        $handleOrderStatus=new \Logic\ServiceOrderStatus();
        $handleServiceOrder = new \Logic\ServiceOrder();
        $orderid=I('get.orderid');
        $where['id']=$orderid;
        $data=$handleServiceOrder->modelServiceFind($where);
        $statusid=$data['order_status'];
        if($data['order_status']==1){
           $data['order_status']=5;
        }elseif($data['order_status']==2||$data['order_status']=3){
          $data['order_status']=6;
        }
        $result=$handleServiceOrder->modelServiceUpdate($data);
        if($result){
            $sdata['id']=create_guid();
            $sdata['order_id']= $data['id'];
            if($statusid==1){
                $sdata['order_status']=5;
                $sdata['memo']="已取消";
            }elseif($statusid==2||$statusid==3){
                 $sdata['order_status']=6;
                 $sdata['memo']="待退款";
            }
            $sdata['create_time']=time();
            $sdata['oper_id']=cookie("admin_user_name");
            $handleOrderStatus->modelServiceAdd($sdata);
            $this->success('订单取消成功！', 'awaitlist.html?no=4&leftno=73');
        }

   }
   //确定完成订单
   public function completeorder(){
    $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $handleOrderStatus=new \Logic\ServiceOrderStatus();
        $handleServiceOrder = new \Logic\ServiceOrder();
        $orderid=I('get.orderid');
        $where['id']=$orderid;
        $data=$handleServiceOrder->modelServiceFind($where);
        if($data['order_status']==3){
          $data['order_status']=4;
        }
        $result=$handleServiceOrder->modelServiceUpdate($data);
        if($result){
            $sdata['id']=create_guid();
            $sdata['order_id']= $data['id'];
            $sdata['order_status']=4;
            $sdata['create_time']=time();
            $sdata['memo']="已完成";
            $sdata['oper_id']=cookie("admin_user_name");
            $handleOrderStatus->modelServiceAdd($sdata);
            $this->success('更新成功！', 'awaitlist.html?no=4&leftno=73');
        }
   }
 //已完成
  public function completelist(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $handleMenu->jurisdiction();
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $handleServiceOptions = new \Logic\ServiceOptions();
      $name=I('get.name');//用户名
      $price_cnt=I('get.price_cnt');//订单金额
      $mobile=I('get.mobile');
      $address=I('get.address');
      $order_status=I('get.order_status');
      $orderid=I('get.orderid');
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $where['record_status']=array('eq',1);
      $where['order_status']=array('gt',3);
      $where['info_id']=array('neq',"sixyuanbanjia");
       if($endTime!=""&&$startTime==""){
          $where['service_time']=array('lt',$endTime+86400);
       }
      if($startTime!=""&&$endTime!=""){
          $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($name!=""){
         $where['customer_name']=array('eq',$name);
      }
      if($price_cnt!=""){
         $where['price_cnt']=array('eq',$price_cnt);
      }
      if($address!=""){
         $where['address']=array('like','%'.$address.'%');
      }
      if($mobile!=""){
         $where['customer_mobile']=array('eq',$mobile);
      }
      if($order_status!=""){
         $where['order_status']=array('eq',$order_status);
      }
      if($orderid!=""){
         $where['id']=array('eq',$orderid);
      }
      $count=$handleServiceOrder->modelServicePageCount($where);
      $Page= new \Think\Page($count,15);
   
      $listarr=$handleServiceOrder->modelServiceList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
          $whereinfo['id']=$value['info_id'];
          $serviceinfo=$handleServiceInfo->modelServiceFind($whereinfo);
          $value['class_name']=$serviceinfo['class_name'];
          $whereop['id_no']=$value['option_no'];
          $options=$handleServiceOptions->modelServiceFind($whereop);
          $value['options_name']=$options['name'];
          if($value['serviceman_id']!=""){
             $whereman['id']=$value['serviceman_id'];
             $manarr=$handleServiceMan->modelServiceFind($whereman);
             $value['man_name']=$manarr['name'];
             $value['man_mobile']=$manarr['mobile'];
          }
          $list[]=$value;
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
      $this->display();
  }
   public function completeinfo(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $orderid=I('get.oid');
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $handleServiceOptions = new \Logic\ServiceOptions();
      $whereorder['id']= $orderid;
      $orderarr=$handleServiceOrder->modelServiceFind($whereorder);
      if($orderarr['serviceman_id']!=""){
        $whereman['id']= $orderarr['serviceman_id'];
        $manarr=$handleServiceMan->modelServiceFind($whereman);
      }
      $whereinfo['id']=$orderarr['info_id'];
      $infoarr=$handleServiceInfo->modelServiceFind($whereinfo);
      $whereop['id_no']=$orderarr['option_no'];
      $options=$handleServiceOptions->modelServiceFind($whereop);
      $this->assign("options",$options);
      $this->assign("infoarr",$infoarr);
      $this->assign("manarr",$manarr);
      $this->assign("orderarr",$orderarr);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
   } 
   //删除师傅
   public function mandedelete(){
       $handleServiceMan = new \Logic\ServiceMan();
       $man_id=I('get.mid');
       $where['id']=$man_id;
       $data=$handleServiceMan->modelServiceFind($where);
       $data['record_status']=0;
       $result=$handleServiceMan->modelServiceUpdate($data);
       if($result){
          $this->success('删除成功！', 'personnellist.html?no=4&leftno=76');
       }
   }
   //修改服务订单temp
   public function orderupdate(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $orderid=I('get.oid');
      $handleServiceOrder = new \Logic\ServiceOrder();
      $where['id']=$orderid;
      $data=$handleServiceOrder->modelServiceFind($where);

      $this->assign("data",$data);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();

   }
   //提交修改服务订单
    public function subuporder(){
          $handleServiceOrder = new \Logic\ServiceOrder();
          $id=I('post.id');
          $where['id']=$id;
          $data=$handleServiceOrder->modelServiceFind($where);
          $data['customer_name']=I('post.customer_name');
          $data['customer_mobile']=I('post.customer_mobile');
          $data['address']=I('post.address');
          $data['service_time']=strtotime(I('post.service_time'));
          $result=$handleServiceOrder->modelServiceUpdate($data);
          if($result){
             $this->success('修改成功！', 'orderupdate.html?oid='.$id.'&no=4&leftno=73');
          }
    }

   //师傅库累计接单次数json
   public function jsonmancount(){
       $handleServiceOrder = new \Logic\ServiceOrder();
       $man_id=I('get.man_id');
       $where['serviceman_id']=$man_id;
       $count=$handleServiceOrder->modelCount($where);
       if($count){
          echo "{\"status\":\"200\",\"man_id\":\"$man_id\",\"count\":\"$count\"}";
       }
   }

   //修改师傅库temp
   public function manupdate(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }

        $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $mid=I('get.mid');
      $where['id']=$mid;
      $handleServiceMan = new \Logic\ServiceMan();
      $data=$handleServiceMan->modelServiceFind($where);

      $this->assign("data",$data);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
   }
  //修改师傅提交
   public function upserviceman(){
          $handleServiceMan = new \Logic\ServiceMan();
         if(isset($_POST['submitType']) && $_POST['submitType']=="upload"){
           $this->uploadImage();
          return;
         }
           $servicename=$_POST['servicename'];
           $arrcount=count($servicename);
           for($i=0;$i<$arrcount;$i++){
              $serviceStr.=$servicename[$i].",";

           }
           $id=I('post.id');
           $where['id']=$id;
           $data=$handleServiceMan->modelServiceFind($where);
           $data['name']=I('post.name');
           $data['mobile']=I('post.mobile');
           $data['sex']=I('post.sex');;
           $data['avatar_url']=I('post.bright');
           $data['service_scope']=substr($serviceStr,0,-1);          
           $result=$handleServiceMan->modelServiceUpdate($data);
           if($result){
             $this->success('修改成功！', 'personnellist.html?no=4&leftno=76');
           }
   }
  //财务明细
   public function financialdetalist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity); 
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $handleMenu->jurisdiction();
      $handleServiceOrder = new \Logic\ServiceOrder();
      $handleServiceInfo = new \Logic\ServiceInfo();
      $handleServiceMan = new \Logic\ServiceMan();
      $handleOrderStatus=new \Logic\ServiceOrderStatus();
       $handleServiceOptions = new \Logic\ServiceOptions();
      $name=I('get.name');//用户名
      $price_cnt=I('get.price_cnt');//订单金额
      $mobile=I('get.mobile');
      $address=I('get.address');
      $order_status=I('get.order_status');
      $orderid=I('get.orderid');
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $where['record_status']=array('eq',1);
       if($endTime!=""&&$startTime==""){
          $where['service_time']=array('lt',$endTime+86400);
       }
      if($startTime!=""&&$endTime!=""){
          $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
           $where['service_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
      if($name!=""){
         $where['customer_name']=array('eq',$name);
      }
      if($price_cnt!=""){
         $where['price_cnt']=array('eq',$price_cnt);
      }
      if($address!=""){
         $where['address']=array('like','%'.$address.'%');
      }
      if($mobile!=""){
         $where['customer_mobile']=array('eq',$mobile);
      }
      if($order_status!=""){
         $where['order_status']=array('eq',$order_status);
      }
      if($orderid!=""){
         $where['id']=array('eq',$orderid);
      }
      $count=$handleServiceOrder->modelServiceFinanPageCount($where);
      $Page= new \Think\Page($count,15);
 
      $listarr=$handleServiceOrder->modelServiceFinanList($Page->firstRow,$Page->listRows,$where);
      foreach ($listarr as $key => $value) {
              $whereinfo['id']=$value['info_id'];
              $serviceinfo=$handleServiceInfo->modelServiceFind($whereinfo);
              $value['class_name']=$serviceinfo['class_name'];
              $whereop['id_no']=$value['option_no'];
              $options=$handleServiceOptions->modelServiceFind($whereop);
              $value['options_name']=$options['name'];
              if($value['serviceman_id']!=""){
                 $whereman['id']=$value['serviceman_id'];
                 $manarr=$handleServiceMan->modelServiceFind($whereman);
                 $value['man_name']=$manarr['name'];
                 $value['man_mobile']=$manarr['mobile'];
              }
              $list[]=$value;
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->assign("show", $Page->show());
       $this->display();
   }
   //财务明细操作temp
   public function reimburse(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
             $this->error('非法操作',U('Index/index'),1);
        }
       $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity); 
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
       $orderid=I('get.oid');
       $handleServiceOrder = new \Logic\ServiceOrder();
       $handleServiceInfo = new \Logic\ServiceInfo();
       $handleServiceMan = new \Logic\ServiceMan();
       $handleOrderStatus=new \Logic\ServiceOrderStatus();
        $handleServiceOptions = new \Logic\ServiceOptions();
       $whereorder['id']= $orderid;
       $orderarr=$handleServiceOrder->modelServiceFind($whereorder);
       if($orderarr['serviceman_id']!=""){
          $whereman['id']= $orderarr['serviceman_id'];
          $manarr=$handleServiceMan->modelServiceFind($whereman);
       }
       $whereinfo['id']=$orderarr['info_id'];
       $infoarr=$handleServiceInfo->modelServiceFind($whereinfo);
       if($orderarr['order_status']==6){
         $wherestatus['order_id']=$orderid;
         $wherestatus['order_status']=6;
         $status=$handleOrderStatus->modelServiceFind($wherestatus);
        }
       $whereop['id_no']=$orderarr['option_no'];
       $options=$handleServiceOptions->modelServiceFind($whereop);
       $this->assign("options",$options);
       $this->assign("status",$status);
       $this->assign("infoarr",$infoarr);
       $this->assign("manarr",$manarr);
       $this->assign("orderarr",$orderarr);
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $this->display();
   }

   //退款操作
   public function updatereimburse(){
        $handleOrderStatus=new \Logic\ServiceOrderStatus();
        $handleServiceOrder = new \Logic\ServiceOrder();
        $orderid=I('post.orderid');
        $where['id']=$orderid;
        $data=$handleServiceOrder->modelServiceFind($where);
        if($data['order_status']==6){
           $data['order_status']=7;
        }
        $result=$handleServiceOrder->modelServiceUpdate($data);
        if($result){
            $sdata['id']=create_guid();
            $sdata['order_id']= $data['id'];
            $sdata['order_status']=7;
            $sdata['create_time']=time();
            $sdata['memo']="已退款";
            $sdata['oper_id']=cookie("admin_user_name");
            $sdata['desc']=I('post.remark');
            $handleOrderStatus->modelServiceAdd($sdata);
            $this->success('退款成功！', 'financialdetalist.html?no=4&leftno=75');
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
      $url =C("IMG_SERVICE_URL").'other/web/upload';
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
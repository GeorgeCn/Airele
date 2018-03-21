<?php
namespace Home\Controller;
use Think\Controller;
class LoanManageController extends Controller{

   //分期列表     
   public function loanlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $handleMenu->jurisdiction();
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);

      $handleStaging = new \Logic\Staging();
      $where['bank_no']=I('get.bank_no');
      $where['loan_status']=I('get.loan_status');
      $where['mobile']=I('get.mobile');
      $where['name']=I('get.name');
      $where['is_financelist']=1;
      $where['owner_name']=I('get.owner_name');
      $where['owner_mobile']=I('get.owner_mobile');
     
      $count=$handleStaging->getStagingPageCount($where);
      $list=array();
      if($count>0){
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val){
              $Page->parameter[$key]=urlencode($val);
        }
        $list=$handleStaging->getStagingList($Page->firstRow,$Page->listRows,$where);
        $this->assign("show",$Page->show());
      }else{
        $this->assign("show",'');
      }
      $this->assign("pagecount",$count);
      $this->assign("list",$list);
      $this->display();
   }
   public function uploanmanage(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),4);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),4);
      $handleStaging = new \Logic\Staging();
      $handleStatus = new \Logic\OrderPayStatus();
      $where['id']=$_GET['sid'];
      $data=$handleStaging->getStagingFind( $where);
      $stwhere['order_id']=$_GET['sid'];
      $stwhere['status_type']=2;
      $status=$handleStatus->getStagingList($stwhere);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("data",$data);
      $this->assign("status",$status);
      $this->display();
   }

   public function subloanmanage(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
          $this->assign("switchcity",$switchcity);
        $handleStaging = new \Logic\Staging();
        $handleStatus = new \Logic\OrderPayStatus();
        $handleReport = new \Logic\ReportLogic();
        $where['id']=$_GET['sid'];
        $data=$handleStaging->getStagingFind($where);

        $data['loan_status']=$_GET['loan_status'];
        $result=$handleStaging->updateStaging($data);    
        if($result){
           $admin['user_name']=cookie("admin_user_name");
           $admin_user=$handleReport->modelGetAdmin($admin); 
           $handle['id']=create_guid();
           $handle['order_id']=$_GET['sid'];
           $handle['order_status']=$_GET['loan_status'];
           $handle['status_type']=2;
           $handle['create_time']=time();
           $handle['customer_id']=$admin_user['id'];
           $handle['name']=cookie("admin_user_name");
           $handleStatus->modelAdd($handle);
           $this->success('更新成功！', 'loanlist.html?&no=4&leftno=69');
        }else{
            $this->success('操作错误！', 'uploanmanage.html?sid='.$_GET['sid'].'&no=4&leftno=69');
        }
  }

   public function dowStaging(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        $handleStaging = new \Logic\Staging();
        $where['bank_no']=I('get.bank_no');
        $where['loan_status']=I('get.loan_status');
        $where['mobile']=I('get.mobile');
        $where['name']=I('get.name');
        $where['is_financelist']=1;
        $where['owner_name']=I('get.owner_name');
        $where['owner_mobile']=I('get.owner_mobile');

         $rearr=$handleStaging->getStagingList(0,1000,$where);
          $handleDownLog= new\Logic\DownLog();
          $handleDownLog->downloadlog("","",count($rearr));
         $title=array(
                'stag_id'=>'分期编号',
                'order_id'=>'订单号',
                'name'=>'租客姓名',
                'mobile'=>'租客电话',
                'city'=>'所在城市',
                'owner_name'=>'房东姓名',
                'owner_mobile'=>'房东电话',
                'bank_no'=>'房东账号',
                'recommend'=>'推荐码',
                'loan_num'=>'放款编号',
                'loan_money'=>'放款金额',
                'loan_status'=>'放款状态',
                'stages_status'=>'申请状态',
                'create_time'=>'申请时间'
         );
         /*分期状态*/
         $stagStatusArray=getStagStatusArray();
         $exarr[]=$title;
         foreach ($rearr as $key => $value) {
                $value1['stag_id']=$value['stag_id'];
                $value1['order_id']=$value['order_id'];
                $value1['name']=$value['name'];
                $value1['mobile']=$value['mobile'];
                $value1['city']=$value['city'];
                $value1['owner_name']=$value['owner_name'];
                $value1['owner_mobile']=$value['owner_mobile'];
                $value1['bank_no']=$value['bank_no'];
                $value1['recommend']=$value['recommend'];
                $value1['loan_num']=$value['loan_num'];
                $value1['loan_money']=$value['loan_money'];
                 switch ($value['loan_status']) {
                  case '1':
                    $value1['loan_status']="么么贷已放款";
                    break;
                  case '2':
                    $value1['loan_status']="嗨住已放款";
                    break;
                  case '3':
                    $value1['loan_status']="打款失败";
                    break;
                  case '4':
                    $value1['loan_status']="打款账号已更新";
                    break;
                  case '5':
                    $value1['loan_status']="已退款";
                    break;
                  default:
                    $value1['loan_status']="";
                    break;
                }
                $value1['stages_status']=$stagStatusArray[$value['stages_status']];
                $value1['create_time']=date("Y-m-d H:i:s",$value['create_time']);
                $exarr[]=$value1;
         }
            Vendor('phpexcel.phpexcel');
            $xls = new \Excel_XML('UTF-8', false, '分期列表');
            $xls->addArray($exarr);
            $xls->generateXML('分期列表'.date("YmdHis"));
    }
}
?>
<?php
namespace Home\Controller;
use Think\Controller;
class IssueOwnerController extends Controller {
    public function issueownerlist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"3");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"3");
        $handleMenu->jurisdiction();
    	  $startTime=strtotime($_GET['startTime']);
    	  $endTime=strtotime($_GET['endTime']);
    	  $ownermobile=I('get.ownermobile');
    	 
         $where['city_code']=C('CITY_CODE');
       if($startTime!=""&&$endTime==""){
            $where['handle_time']=array('gt',$startTime);
       }
       if($endTime!=""&&$startTime==""){
             $where['handle_time']=array('lt',$endTime+86400);
       }
      if($startTime!=""&&$endTime!=""){
            $where['handle_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
            $where['handle_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
       }
       if($ownermobile!=""){
            $where['owner_mobile']=array('eq',$ownermobile);
    	}
      
      	$handleHouseProblems = new \Logic\HouseProblems();
        $count=$handleHouseProblems->modelProblemsCount($where);
        $Page= new \Think\Page($count,15);
        foreach($where as $key=>$val) {
            $Page->parameter[$key]=urlencode($val);
        }
        
        $list=$handleHouseProblems->modelProblemsList($Page->firstRow,$Page->listRows,$where);
        $this->assign("ruleauth",$this->getauthority());
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$list);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
	     $this->display();
    }

    public function getauthority(){
        $handleMenu = new \Logic\AdminMenuListLimit();
        $conurl=strtolower("ContactOwner/contactOwnerList.html");
        $roomurl=strtolower("HouseRoom/searchroom.html");
        $roomwhere['user_name']=cookie("admin_user_name");
        $roomwhere['city_auth']=C('CITY_NO');
        $menuurlarr=$handleMenu->modelMenuList($roomwhere);
          foreach ($menuurlarr as $key => $value) {
              $allmenu[]=strtolower($value['menu_url']);
        }
        if(in_array($roomurl,$allmenu)){
             $resultarr['roomauth']=1;
        }else{
            $resultarr['roomauth']=0;
        }
        if(in_array($conurl,$allmenu)){
            $resultarr['conowner']=1;
        }else{
            $resultarr['conowner']=0;
        }
        return $resultarr;

    }

    //更新状态
    public function upproblemsstatus(){
      $handleHouseProblems = new \Logic\HouseProblems();
      $problemsid=I('get.problems_id');
      $owner_id=I('get.owner_id');
      $type=I('get.type');
      if($type==1){
            $roomLogic=new \Logic\HouseRoomLogic();
            if($owner_id!=""){
              $roomdata=$handleHouseProblems->getRoomIdsByCustomerId($owner_id);
              if($roomdata){
                  foreach ($roomdata as $key => $value) {
                      $roomLogic->downroomByid($value['id']);
                  } 
              }
            }
      }
      $where['id']=$problemsid;
      $data=$handleHouseProblems->modelFind($where);
      if($data['status_code']==0){
          $data['status_code']=1;
          $data['handle_man']=trim(getLoginName());
          $data['handle_time']=time();
          $result=$handleHouseProblems->modelUpdata($data);
          if($result){
              echo "{\"status\":\"200\",\"msg\":\"\"}";
          }
      }else{
           echo "{\"status\":\"201\",\"msg\":\"\"}";
      }
    }

    //是否付费
    public function getownerdata(){
         $handleProblems=new \Home\Model\houseproblems();
         $handleCustomer=new \Home\Model\customer();
         $handleCustomerinfo=new \Home\Model\customerinfo();
         $owner_id=I('get.owner_id');
         $result="";
         $principal_man="";
         if($owner_id!=""){
            $cudata=$handleCustomer->getModelById($owner_id);
            if($cudata){
                if($cudata['is_commission']==1){
                   $result="付费";
                }else if($cudata['is_monthly']==1&&$cudata['monthly_start']< time()&&$cudata['monthly_end']>time()){
                   $result="付费";
                }else{
                   $result="非付费";
                }
            }
             $where['customer_id']=$owner_id;
             $cuinfodata=$handleCustomerinfo->modelFind($where);
             if($cuinfodata){ 
                if($cuinfodata['principal_man']!=""){
                   $principal_man=$cuinfodata['principal_man'];
                }
             }
         }
         $array=array('pay_type'=>$result,'principal_man'=>$principal_man);
        echo json_encode($array);
    }
    //添加备注
    public function addmemodata(){
         $handleProblems=new \Home\Model\houseproblems();
         $problems_id=I('get.problems_id');
         $content=I('get.content');
         if($problems_id!=""&&$content!=""){
              $where['id']=$problems_id;
              $problems=$handleProblems->modelFind($where);
              if($problems){
                   $problems['memo']=$content;
                   $result=$handleProblems->modelUpdata($problems);
                    if($result){
                        echo "{\"status\":\"200\",\"msg\":\"\"}";
                    }else{
                         echo "{\"status\":\"201\",\"msg\":\"\"}";
                    }
              }

         }
    }
      //导出excel
    public function downloadExcel(){
        header ( "Content-type: text/html; charset=utf-8" );
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
        $startTime=strtotime($_GET['startTime']);
        $endTime=strtotime($_GET['endTime']);
        $ownermobile=I('get.ownermobile');
        $where['city_code']=C('CITY_CODE');
         if($startTime!=""&&$endTime==""){
              $where['handle_time']=array('gt',$startTime);
         }
         if($endTime!=""&&$startTime==""){
               $where['handle_time']=array('lt',$endTime+86400);
         }
        if($startTime!=""&&$endTime!=""){
              $where['handle_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
         if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
              $where['handle_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
         }
         if($ownermobile!=""){
              $where['owner_mobile']=array('eq',$ownermobile);
         }
        $handleHouseProblems = new \Logic\HouseProblems();
        $handleCustomer=new \Home\Model\customer();
        $handleCustomerinfo=new \Home\Model\customerinfo();
        $listdata=$handleHouseProblems->modelProblemsList(0,1000,$where);
       $handleDownLog= new\Logic\DownLog();
      $handleDownLog->downloadlog($startTime,$endTime,count($listdata));
        $title=array(
            'owner_mobile'=>'房东手机',
            'big_code'=>'400号码',
            'times'=>'问题次数',
            'pay_type'=>'是否付费',
            'principal_man'=>'房东负责人',
            'status_code'=>'是否处理',
            'memo'=>'备注',
            'handle_man'=>'  处理人',
            'handle_time'=>'处理时间',
        );
        foreach ($listdata as $key => $value) {
          
           $value1['owner_mobile']=$value['owner_mobile'];
           $value1['big_code']=$value['big_code']."-".$value['ext_code'];
           $value1['times']=$value['times'];
            $cudata=$handleCustomer->getModelById($value['owner_id']);
           if($cudata){
                if($cudata['is_commission']==1){
                   $result="付费";
                }else if($cudata['is_monthly']==1&&$cudata['monthly_start']< time()&&$cudata['monthly_end']>time()){
                   $result="付费";
                }else{
                   $result="非付费";
                }
                $value1['pay_type']=$result;
            }
             $where1['customer_id']=$value['owner_id'];
           $cuinfodata=$handleCustomerinfo->modelFind($where1);
           if($cuinfodata){ 
                if($cuinfodata['principal_man']!=""){
                   $value1['principal_man']=$cuinfodata['principal_man'];
                }else{
                   $value1['principal_man']="";
                }
             }
           if($value['status_code']==0){
              $value1['status_code']="未处理";
           }elseif($value['status_code']==1){
              $value1['status_code']="已处理";
           }
           $value1['memo']=$value['memo'];
           $value1['handle_man']=$value['handle_man'];
           if($value1['handle_time']==0){
              $value1['handle_time']="";
           }else{
              $value1['handle_time']=date("Y-m-d H:i:s",$value['handle_time']); 

           }
           $list[]=$value1;
        }

        $excel[]=$title;
        if($list===false || $list===null || count($list)==0){
            return;
        }
        foreach ($list as $key => $value) {
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '问题房东');
        $xls->addArray($excel);
        $xls->generateXML('问题房东'.date("YmdHis"));
    }

}
?>
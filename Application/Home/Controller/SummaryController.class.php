<?php
namespace Home\Controller;
use Think\Controller;
class SummaryController extends Controller {
	//联系房东统计
	public function contactsummary(){
		$handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['startTime']=I('get.startTime');
         $condition['endTime']=I('get.endTime');
         $condition['totalCount']=I('get.totalCount');
	     $handleLogic=new \Logic\SummaryLogic();
         $totalCount =0;$list=array();
        if(empty($condition['startTime']) || empty($condition['endTime'])){
        	/*$condition['startTime']=date('Y-m-d',time()-3600*24*7);
        	$condition['endTime']=date('Y-m-d',time()-3600*24);*/
        }else{
	        if(!empty(I('get.p')) && $condition['totalCount']>0){
	            //点击分页，不用查询汇总
	            $totalCount =$condition['totalCount'];
	        }else{
	            $totalCountModel = $handleLogic->getContactCount($condition);//总条数
	              if($totalCountModel !==null && $totalCountModel !==false){
	                $totalCount=$totalCountModel[0]['totalCount'];
	              }
	        }
	        if($totalCount>=1){
	             $condition['totalCount']=$totalCount;
		        $Page= new \Think\Page($totalCount,25);//分页
		        foreach($condition as $key=>$val) {
		            $Page->parameter[$key]=urlencode($val);
		        }
		        $this->assign("pageSHow",$Page->show());
	        	$list = $handleLogic->getContactList($condition,$Page->firstRow,$Page->listRows);
	        }else{
	        	$this->assign("pageSHow","");
	        }
        }
        /*查询条件（区域板块）*/
        $handleResourceLogic=new \Logic\HouseResourceLogic();
        $result=$handleResourceLogic->getRegionList();
        if($result!==null && $result!==false){
        	$regionList='';
        	foreach ($result as $key => $value) {
        		$regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        	}	
        	$this->assign("regionList",$regionList);
        }
        $scopeList='<option value=""></option>';
        if(!empty($condition['region'])){
        	//查询后，重新加载板块信息
        	$result=$handleResourceLogic->getRegionScopeList();
        	foreach ($result as $key => $value) {
        		if($condition['region']==$value['parent_id']){
        			$scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        		}
        	}
        }
        $this->assign("scopeList",$scopeList);
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
		$this->display();
	}
	//导出excel
    public function downloadContactSummary(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
        $condition['region']=I('get.region');
        $condition['scope']=I('get.scope');
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        if(empty($condition['startTime']) || empty($condition['endTime'])){
        	$condition['startTime']=date('Y-m-d',time()-3600*24*7);
        	$condition['endTime']=date('Y-m-d',time()-3600*24);
        }
        $handleLogic=new \Logic\SummaryLogic();
        $list = $handleLogic->getContactList($condition,0,1000);
        $title=array(
            'region_name'=>'区域', 'scope_name'=>'板块', 'contact_count'=>'联系次数','contact_bd_count'=>'联系来自BD','appoint_count'=>'预约次数',
            'appoint_bd_count'=>'预约来自BD','browse_count'=>'浏览次数','browse_bd_count'=>'浏览来自BD'
        );
        $excel[]=$title;
        foreach ($list as $key => $value) {
           $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '联系房东统计');
        $xls->addArray($excel);
        $xls->generateXML('联系房东统计'.date('YmdH'));
    }

    /*置顶房源统计列表 */
    public function toproomsummary(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"3");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"3");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['room_no']=I('get.room_no');
        $condition['startTime']=I('get.startTime');
         $condition['endTime']=I('get.endTime');
         $condition['totalCount']=I('get.totalCount');
         $handleLogic=new \Logic\SummaryLogic();
         $totalCount =0;$list=array();
        if(!empty($condition['startTime']) && !empty($condition['endTime'])){
            if(!empty(I('get.p')) && $condition['totalCount']>0){
                //点击分页，不用查询汇总
                $totalCount =$condition['totalCount'];
            }else{
                $totalCountModel = $handleLogic->getToproomCount($condition);//总条数
                if($totalCountModel !==null && $totalCountModel !==false){
                    $totalCount=$totalCountModel[0]['totalCount'];
                }
            }
            if($totalCount>=1){
                $condition['totalCount']=$totalCount;
                $Page= new \Think\Page($totalCount,25);//分页
                $this->assign("pageSHow",$Page->show());
                $list = $handleLogic->getToproomList($condition,$Page->firstRow,$Page->listRows);
            }else{
                $this->assign("pageSHow","");
            }
        }
        $this->assign("list",$list);
        $this->assign("totalCount",$totalCount);
        $this->display();
    }
    //下载置顶统计
    public function downloadToproomSummary(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
        $condition['room_no']=I('get.room_no');
        $condition['startTime']=I('get.startTime');
        $condition['endTime']=I('get.endTime');
        if(empty($condition['startTime']) || empty($condition['endTime'])){
            $condition['startTime']=date('Y-m-d',time()-3600*24*7);
            $condition['endTime']=date('Y-m-d',time()-3600*24);
        }
        $handleLogic=new \Logic\SummaryLogic();
        $list = $handleLogic->getToproomList($condition,0,500);
        $title=array(
            'room_no'=>'房间编号','estate_name'=>'小区名称','region_name'=>'行政区', 'scope_name'=>'商圈','rent_type'=>'整租/合租','browse_page_count'=>'浏览次数','browse_user_count'=>'浏览人数', 
            'contact_page_count'=>'联系次数','contact_user_count'=>'联系人数','appoint_page_count'=>'预约次数','appoint_user_count'=>'预约人数'
        );
        $excel[]=$title;
        foreach ($list as $key => $value) {
           switch ($value['rent_type']) {
                case '1':
                    $value['rent_type']='合租';
                    break;
                case '2':
                    $value['rent_type']='整租';
                    break;
                default:
                    break;
            } 
           $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '置顶房源统计');
        $xls->addArray($excel);
        $xls->generateXML('置顶房源统计'.date('YmdH'));
    }


    /*我负责的客户 */
    public function sumlandlord(){
        $login_name=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"6");
        $menu_left_html=$handleMenu->menuLeft($login_name,"6");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['mobile']=trim(I('get.mobile'));
         $condition['principal_man']=trim(I('get.principal_man'));
        $condition['principalFlag']=$condition['principal_man']==''?'all':'';
         //权限控制
        /* if(!in_array($login_name, array('admin','xiaqingning','tianzhen','zhouyifan','suhongye','haotongrui','yantaojie','sunwenpei','dingyuanxue','xujin','zhanglu'))){
            $condition['principal_man']=$login_name;
         }*/
         switch (I('get.fee_type')) {
             case '1':
                 $condition['isMonth']=1;
                 break;
             case '2':
                 $condition['is_commission']=1;
                 break;
            case '3':
                 $condition['isMonth']='0';
                 $condition['is_commission']='0';
                 break;
             default:
                 break;
         }
       $condition['startTime']=trim(I('get.startTime'));
       $condition['endTime']=trim(I('get.endTime'));
        $condition['startTimeSum']=trim(I('get.startTimeSum'));
       $condition['endTimeSum']=trim(I('get.endTimeSum'));
        $handleCustomerInfo=new \Logic\CustomerInfo();
        $showList=array();$pageshow='';
        $condition['pagecount']=I('get.pagecount');
        $count=$condition['pagecount']==''?0:intval($condition['pagecount']);
        if(I('get.p')=='' && I('get.handle')=='query'){
          $count=$handleCustomerInfo->modelCustomerinfoCount($condition);
        } 
        if($count>0){
          $Page= new \Think\Page($count,5);
          $condition['pagecount']=$count;
          foreach($condition as $key=>$val) {
              $Page->parameter[$key]=urlencode($val);
          }
          $pageshow=$Page->show();
          $list=$handleCustomerInfo->modelCustomerinfoList($Page->firstRow,$Page->listRows,$condition);
          if($list!=null){
            $startTime=$condition['startTimeSum'];
            $endTime=$condition['endTimeSum'];
            if($startTime!='' && $endTime!=''){
                $startTime=strtotime($startTime);
                $endTime=strtotime($endTime)+3600*24;
            }
            $handle=new \Home\Model\summaryhouserentercall();
            $handleRoom=new \Home\Model\houseroom();
             foreach ($list as $k => $v) {
                if(empty($v['customer_id']) || empty($startTime)){
                    array_push($showList, array('customer_id'=>$v['customer_id'],'principal_man'=>$v['principal_man'],'true_name'=>$v['true_name'],'mobile'=>$v['mobile'],'is_monthly'=>$v['is_monthly'],'is_commission'=>$v['is_commission'],'create_time'=>$v['create_time'],'is_black'=>$v['is_black'],
                            'renter_cnt'=>'','all_cnt'=>'','contact_cnt'=>'',  'reserve_cnt'=>'','room_cnt'=>''));
                }else{
                    $room_cnt=0;
                    //获取可租房源数量
                    $roomdata=$handleRoom->getResultByWhere("count(1) as cnt"," where customer_id='".$v['customer_id']."' and status=2 and record_status=1");
                    if($roomdata!=null && count($roomdata)>0){
                        $room_cnt=$roomdata[0]['cnt'];
                    }
                    //获取连接数
                    $connectdata=$handle->getConnectData($v['customer_id'],$startTime,$endTime);
                    if($connectdata!=null && count($connectdata)>0){
                        array_push($showList, array('customer_id'=>$v['customer_id'],'principal_man'=>$v['principal_man'],'true_name'=>$v['true_name'],'mobile'=>$v['mobile'],'is_monthly'=>$v['is_monthly'],'is_commission'=>$v['is_commission'],'create_time'=>$v['create_time'],'is_black'=>$v['is_black'],
                            'renter_cnt'=>$connectdata[0]['renter_cnt'],'all_cnt'=>$connectdata[0]['all_cnt'],'contact_cnt'=>$connectdata[0]['contact_cnt']==null?0:$connectdata[0]['contact_cnt'],
                            'reserve_cnt'=>$connectdata[0]['reserve_cnt']==null?0:$connectdata[0]['reserve_cnt'],'room_cnt'=>$room_cnt));
                    }else{
                        array_push($showList, array('customer_id'=>$v['customer_id'],'principal_man'=>$v['principal_man'],'true_name'=>$v['true_name'],'mobile'=>$v['mobile'],'is_monthly'=>$v['is_monthly'],'is_commission'=>$v['is_commission'],'create_time'=>$v['create_time'],'is_black'=>$v['is_black'],
                            'renter_cnt'=>'','all_cnt'=>'','contact_cnt'=>'',  'reserve_cnt'=>'','room_cnt'=>$room_cnt));
                    }
                }
             }
          }
        }
        $this->assign("show",$pageshow);
        $this->assign("list",$showList);
        $this->assign("pagecount",$count);
        $this->display();
    }
    public function downloadSumlandlord(){
         $login_name=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
         $condition['mobile']=trim(I('get.mobile'));
         $condition['principal_man']=trim(I('get.principal_man'));
         $condition['principalFlag']=$condition['principal_man']==''?'all':'';
         //权限控制
        /* if(!in_array($login_name, array('admin','xiaqingning','tianzhen','zhouyifan','suhongye','haotongrui','yantaojie','sunwenpei','dingyuanxue','xujin','zhanglu'))){
            $condition['principal_man']=$login_name;
         }*/
          switch (I('get.fee_type')) {
              case '1':
                  $condition['isMonth']=1;
                  break;
              case '2':
                  $condition['is_commission']=1;
                  break;
             case '3':
                  $condition['isMonth']='0';
                  $condition['is_commission']='0';
                  break;
              default:
                  break;
          }
        $condition['startTime']=trim(I('get.startTime'));
        $condition['endTime']=trim(I('get.endTime'));
        $down_count=300;
        if($login_name=='admin'){
           $down_count=1000;
        }
        $handleCustomerInfo = new \Logic\CustomerInfo();
        $list = $handleCustomerInfo->modelCustomerinfoList(0,$down_count,$condition);
        $excel[]=array(
            'true_name'=>'客户名称','mobile'=>'客户手机号','principal_man'=>'房东负责人','fee_type'=>'合作方式','create_time'=>'创建时间','is_black'=>'是否黑名单',
            'room_cnt'=>'可租房源量','renter_cnt'=>'租客数','contact_cnt'=>'电话连接数','reserve_cnt'=>'预约连接数','all_cnt'=>'总连接数'
        );
      $startTime=trim(I('get.startTimeSum'));
      $endTime=trim(I('get.endTimeSum'));
      if($startTime!='' && $endTime!=''){
          $startTime=strtotime($startTime);
          $endTime=strtotime($endTime)+3600*24;
      }
      $handle=new \Home\Model\summaryhouserentercall();
      $handleRoom=new \Home\Model\houseroom();
        foreach ($list as $k => $v) {
          $value['true_name']=$v['true_name'];
          $value['mobile']=$v['mobile'];
          $value['principal_man']=$v['principal_man'];
          $value['fee_type']='非付费';
          if($v['is_monthly']==1){
            $value['fee_type']='包月';
          }else if($v['is_commission']==1){
            $value['fee_type']='佣金';
          }
          $value['create_time']=$v['create_time']>0?date("Y-m-d H:i",$v['create_time']):""; 
          $value['is_black']=$v['is_black']==1?"是":"否";
          $value['room_cnt']='';
          $value['renter_cnt']='';
          $value['contact_cnt']='';
          $value['reserve_cnt']='';
          $value['all_cnt']='';
          if(!empty($v['customer_id']) && !empty($startTime)){
              //获取可租房源数量
              $roomdata=$handleRoom->getResultByWhere("count(1) as cnt"," where customer_id='".$v['customer_id']."' and status=2 and record_status=1");
              if($roomdata!=null && count($roomdata)>0){
                  $value['room_cnt']=$roomdata[0]['cnt'];
              }
              //获取连接数
              $connectdata=$handle->getConnectData($v['customer_id'],$startTime,$endTime);
              if($connectdata!=null && count($connectdata)>0){
                $value['renter_cnt']=$connectdata[0]['renter_cnt'];
                $value['contact_cnt']=$connectdata[0]['contact_cnt']==null?0:$connectdata[0]['contact_cnt'];
                $value['reserve_cnt']=$connectdata[0]['reserve_cnt']==null?0:$connectdata[0]['reserve_cnt'];
                $value['all_cnt']=$connectdata[0]['all_cnt'];
              }
          }
          $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '我负责的客户');
        $xls->addArray($excel);
        $xls->generateXML('我负责的客户'.date("YmdHis"));
    }
    //跟进记录
    public function getlandlordlog(){
        $customer_id=trim(I('get.customer_id'));
        if($customer_id==''){
            echo '';return;
        }
        $handleCustomerinfo = new \Home\Model\customerinfo();
        $list=$handleCustomerinfo->getCustomerinfologByWhere(" customer_id='$customer_id' "," limit 10");
        $list_html='';
        foreach ($list as $key => $value) {
            $list_html.='<tr><td>'.date('Y-m-d H:i:s',$value['create_time']).'</td><td>'.$value['create_man'].'</td><td>'.$value['remark'].'</td></tr>';
        }
        echo $list_html;
    }
    public function modifyLandlordbak(){
        header ( "Content-type: text/html; charset=utf-8" );
        $bak=trim(I('post.remark'));
        $customer_id=trim(I('post.customer_id'));
        $login_name=trim(getLoginName());
        if($bak=='' || $customer_id=='' || $login_name==''){
            echo '数据异常，操作失败';return;
        }
        $handleCustomerinfo = new \Home\Model\customerinfo();
        $result=$handleCustomerinfo->modelUpdateWhere("customer_id='$customer_id'",array('owner_remark'=>$bak,'update_man'=>$login_name,'update_time'=>time()));
        if($result){
            $handleCustomerinfo->addCustomerinfolog(array('remark'=>$bak,'customer_id'=>$customer_id,'status'=>3,'create_man'=>$login_name,'create_time'=>time()));
            echo '操作成功';
        }else{
            echo '操作失败';
        }
    }
     /*我负责的包月客户 */
    public function sumlandlordmonth(){
        $login_name=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
         }
         $switchcity=$handleCommonCache->cityauthority();
         $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop($login_name,"6");
        $menu_left_html=$handleMenu->menuLeft($login_name,"6");
         $handleMenu->jurisdiction();
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        //查询条件
        $condition['mobile']=trim(I('get.mobile'));
         $condition['principal_man']=trim(I('get.principal_man'));
         $condition['principalFlag']=$condition['principal_man']==''?'all':'';
         //权限控制
        /* if(!in_array($login_name, array('admin','xiaqingning','tianzhen','zhouyifan','suhongye','haotongrui','yantaojie','sunwenpei','dingyuanxue','xujin','zhanglu'))){
            $condition['principal_man']=$login_name;
         }*/
         $condition['isMonth']=1;
       $condition['monthStart']=trim(I('get.monthStart'));
       $condition['monthEnd']=trim(I('get.monthEnd'));
    
        $handleCustomerInfo=new \Logic\CustomerInfo();
        $showList=array();$pageshow='';
        $condition['pagecount']=I('get.pagecount');
        $count=$condition['pagecount']==''?0:intval($condition['pagecount']);
        if(I('get.p')=='' && I('get.handle')=='query'){
          $count=$handleCustomerInfo->modelCustomerinfoCount($condition);
        } 
        if($count>0){
          $Page= new \Think\Page($count,5);
          $condition['pagecount']=$count;
          foreach($condition as $key=>$val) {
              $Page->parameter[$key]=urlencode($val);
          }
          $pageshow=$Page->show();
          $list=$handleCustomerInfo->modelCustomerinfoList($Page->firstRow,$Page->listRows,$condition);
          if($list!=null){
            $handle=new \Home\Model\summaryhouserentercall();
            $modelDal=new \Home\Model\commissionfd();
             foreach ($list as $k => $v) {
                if(empty($v['customer_id'])){
                    continue;
                }
                $item=array('customer_id'=>$v['customer_id'],'principal_man'=>$v['principal_man'],'true_name'=>$v['true_name'],'mobile'=>$v['mobile'],'status'=>'未到期',
                    'monthly_start'=>'','monthly_days'=>'','monthly_money'=>'','online_days'=>'','online_money'=>'','online_price'=>'',
                    'renter_cnt'=>'','all_cnt'=>'','contact_cnt'=>'',  'reserve_cnt'=>'');
                $startTime=0;$endTime=0;
                //获取包月数据
                $monthData=$modelDal->getCommissionmonthlyByWhere("customer_id='".$v['customer_id']."'","order by id desc limit 10");
                if($monthData!=null && count($monthData)>0){
                    $startTime=$monthData[0]['monthly_start'];
                    $item['monthly_start']=date('Y-m-d',$startTime);
                    if($startTime>time()){
                        $startTime=0;//还没开始
                    }
                    $endTime=$monthData[0]['monthly_end'];
                    $currentEnd=time();
                    if($endTime<$currentEnd){
                        $item['status']='到期';
                        $currentEnd=$endTime;
                    }
                    $item['monthly_days']=$monthData[0]['monthly_days'];
                    $item['monthly_money']=$monthData[0]['monthly_money'];
                   if($startTime>0){
                        $item['online_days']=floor(($currentEnd-$startTime)/3600/24);
                        $item['online_money']=round($item['monthly_money']/$item['monthly_days']*$item['online_days']);
                   }
                }
               if($startTime>0){
                  //获取连接数
                  $connectdata=$handle->getConnectData($v['customer_id'],$startTime,$endTime);
                  if($connectdata!=null && count($connectdata)>0){
                      $item['renter_cnt']=$connectdata[0]['renter_cnt'];
                      $item['all_cnt']=$connectdata[0]['all_cnt'];
                      $item['contact_cnt']=$connectdata[0]['contact_cnt']==null?0:$connectdata[0]['contact_cnt'];
                      $item['reserve_cnt']=$connectdata[0]['reserve_cnt']==null?0:$connectdata[0]['reserve_cnt'];
                      if($item['all_cnt']>0){
                         $item['online_price']=round($item['online_money']/$item['all_cnt']);
                      }
                  }
               }
                array_push($showList, $item);
             }
          }
        }
        $this->assign("show",$pageshow);
        $this->assign("list",$showList);
        $this->assign("pagecount",$count);
        $this->display();
    }
    public function downloadSumlandlordmonth(){
        $login_name=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        //查询条件
         $condition['mobile']=trim(I('get.mobile'));
         $condition['principal_man']=trim(I('get.principal_man'));
         $condition['principalFlag']=$condition['principal_man']==''?'all':'';
         //权限控制
         /*if(!in_array($login_name, array('admin','xiaqingning','tianzhen','zhouyifan','suhongye','haotongrui','yantaojie','sunwenpei','dingyuanxue','xujin','zhanglu'))){
            $condition['principal_man']=$login_name;
         }*/
        $condition['isMonth']=1;
       $condition['monthStart']=trim(I('get.monthStart'));
       $condition['monthEnd']=trim(I('get.monthEnd'));

        $handleCustomerInfo = new \Logic\CustomerInfo();
        $list = $handleCustomerInfo->modelCustomerinfoList(0,150,$condition);
        $excel[]=array(
            'true_name'=>'客户名称','mobile'=>'客户手机号','principal_man'=>'房东负责人','status'=>'合作状态','monthly_start'=>'上线日期','monthly_days'=>'合作时长（天）','monthly_money'=>'总金额',
            'renter_cnt'=>'租客数','contact_cnt'=>'电话连接数','reserve_cnt'=>'预约连接数','all_cnt'=>'总连接数',
            'online_days'=>'上线时长','online_money'=>'累计费用','online_price'=>'连接数单价'
        );

      $handle=new \Home\Model\summaryhouserentercall();
      $modelDal=new \Home\Model\commissionfd();
        foreach ($list as $k => $v) {
           if(empty($v['customer_id'])){
               continue;
           }
           $item=array('true_name'=>$v['true_name'],'mobile'=>$v['mobile'],'principal_man'=>$v['principal_man'],'status'=>'未到期',
               'monthly_start'=>'','monthly_days'=>'','monthly_money'=>'','renter_cnt'=>'','contact_cnt'=>'',  
               'reserve_cnt'=>'','all_cnt'=>'','online_days'=>'','online_money'=>'','online_price'=>'');
           $startTime=0;$endTime=0;
           //获取包月数据
           $monthData=$modelDal->getCommissionmonthlyByWhere("customer_id='".$v['customer_id']."'","order by id desc limit 10");
           if($monthData!=null && count($monthData)>0){
               $startTime=$monthData[0]['monthly_start'];
               $item['monthly_start']=date('Y-m-d',$startTime);
               if($startTime>time()){
                   $startTime=0;//还没开始
               }
               $endTime=$monthData[0]['monthly_end'];
               $currentEnd=time();
                if($endTime<$currentEnd){
                    $item['status']='到期';
                    $currentEnd=$endTime;
                }
               $item['monthly_days']=$monthData[0]['monthly_days'];
               $item['monthly_money']=$monthData[0]['monthly_money'];
              if($startTime>0){
                   $item['online_days']=floor(($currentEnd-$startTime)/3600/24);
                   $item['online_money']=round($item['monthly_money']/$item['monthly_days']*$item['online_days']);
              }
           }
          if($startTime>0){
             //获取连接数
             $connectdata=$handle->getConnectData($v['customer_id'],$startTime,$endTime);
             if($connectdata!=null && count($connectdata)>0){
                 $item['renter_cnt']=$connectdata[0]['renter_cnt'];
                 $item['all_cnt']=$connectdata[0]['all_cnt'];
                 $item['contact_cnt']=$connectdata[0]['contact_cnt']==null?0:$connectdata[0]['contact_cnt'];
                 $item['reserve_cnt']=$connectdata[0]['reserve_cnt']==null?0:$connectdata[0]['reserve_cnt'];
                 if($item['all_cnt']>0){
                    $item['online_price']=round($item['online_money']/$item['all_cnt']);
                 }
             }
          }
          $excel[]=$item;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '我负责的包月客户');
        $xls->addArray($excel);
        $xls->generateXML('我负责的包月客户'.date("YmdHis"));
    }

}
?>
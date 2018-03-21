<?php
namespace Home\Controller;
use Think\Controller;
class JobownerController extends Controller{

   public function jobownerlist(){
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
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      
      $handleCustomerInfo = new \Logic\CustomerInfo();
      $condition['name']=trim(I('get.name'));
      $condition['mobile']=trim(I('get.mobile'));
      $condition['source']=I('get.source');
      $condition['update_man']=trim(I('get.update_man'));
      $condition['signed']=I('get.signed');
      $condition['startTime']=I('get.startTime');
      $condition['endTime']=I('get.endTime');
      $condition['principal_man']=trim(I('get.principal_man'));
      $condition['is_commission']=I('get.is_commission');
      $condition['is_black']=I('get.is_black');
      $condition['marginMin']=trim(I('get.marginMin'));
      $condition['marginMax']=trim(I('get.marginMax'));
      $condition['status']=I('get.status');
      $condition['isMonth']=I('get.isMonth');
      $condition['region_id']=I('get.region_id');
      $condition['isFee']=I('get.isFee');
      $condition['monthStart']=I('get.monthStart');
      $condition['monthEnd']=I('get.monthEnd');
      $condition['pagecount']=I('get.pagecount');
      $count=$condition['pagecount']==''?0:intval($condition['pagecount']);
      $list=array();$pageshow='';
      if($condition['mobile']!=''){
         $list=$handleCustomerInfo->getCustomerinfoListByWhere($condition);
         $count=count($list);
      }else{
         if(I('get.p')=='' && I('get.handle')=='query'){
           $count=$handleCustomerInfo->modelCustomerinfoCount($condition);
         } 
         if($count>0){
           $Page= new \Think\Page($count,8);
           $condition['pagecount']=$count;
           foreach($condition as $key=>$val) {
               $Page->parameter[$key]=urlencode($val);
           }
           $pageshow=$Page->show();
           $list=$handleCustomerInfo->modelCustomerinfoList($Page->firstRow,$Page->listRows,$condition);
         }
      }
       /*区域 */
      $resourceLogic=new \Logic\HouseResourceLogic();
      $result=$resourceLogic->getRegionList();
      $regionList='';
      if($result != null){
        foreach ($result as $key => $value) {
          $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        } 
      }
      $this->assign("regionList",$regionList);
      $this->assign("pagecount",$count);
      $this->assign("show",$pageshow);
      $this->assign("list",$list);
      $this->display();
   }
   /*职业房东跟进编辑页面 */
   public function jobownerfollow(){
      $origin = I('get.origin',0);
      $customer_id=trim(I('get.customer_id'));
      if($customer_id==''){
          echo '参数异常，请重新操作。';return;
      }
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
           return $this->error('非法操作',U('Index/index'),1);
       }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
       $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);
       $handleCustomerInfo = new \Logic\CustomerInfo();
       $customerinfoModel=$handleCustomerInfo->modelFind("customer_id='$customer_id'");
       if($customerinfoModel==false || $customerinfoModel==null){
          echo '已经被人处理过了';return;
       }else if(!in_array($customerinfoModel['status'], array(0,3,5))){
          echo '已经被人处理过了';return;
       }
       //查询拥有房间
       $handleHousroom = new \Home\Model\houseroom();
       $roomarr=$handleHousroom->getModelList(" and r.customer_id='$customer_id' and r.record_status=1 ",0,10);
       //查询跟进记录
       $handleCustomerinfo = new \Home\Model\customerinfo();
       $statusarr=$handleCustomerinfo->getCustomerinfologByWhere(" customer_id='$customer_id' "," limit 10 ");
       $this->assign("statusarr",$statusarr);
       $this->assign("roomarr",$roomarr);
       $this->assign("origin",$origin);
       $this->display();
   }
   /*职业房东跟进编辑页面（提交数据） */ 
   public function jobownerfollow_submit(){
      header ( "Content-type: text/html; charset=utf-8" );
       $loginName=trim(getLoginName());
       if($loginName==''){
          return $this->error('请重新登录',U('Index/index'),1);
       }
       $customer_id=trim(I('post.customer_id'));
       if($customer_id==''){
          echo '参数异常，请重新操作。';return;
       }
       $data['commissiontype']=I('post.commissiontype');
       $data['commissionmoney']=trim(I('post.commissionmoney'));
       $data['status']=I('post.trailstatus');
       $data['remark']=trim(I('post.remark'));
       $data['sign_way']=I('post.sign_way');
       $data['principal_man']=trim(I('post.principal_man'));
       $data['margin']=trim(I('post.margin'));
       $data['settlement_method']=I('post.settlement_method');
       $data['update_man']=$loginName;
       $data['update_time']=time();
       $data['customer_id']=$customer_id;
       if($data['commissiontype']!='' && !is_numeric($data['commissionmoney'])){
          echo '佣金数据异常';return;
       }
       if($data['margin']!='' && !is_numeric($data['margin'])){
          echo '保证金数据异常';return;
       }
       $data['monthly_days']=trim(I('post.monthly_days'));
       $data['monthly_start']=trim(I('post.monthly_start'));
       if($data['commissiontype']==3){
          if(empty($data['monthly_days']) || empty($data['monthly_start'])){
            echo '包月数据不完整';return;
          }
          if(!is_numeric($data['monthly_days'])){
            echo '包月数据异常';return;
          }
       }
       $handleCustomerInfo = new \Logic\CustomerInfo();
       $customerinfoModel=$handleCustomerInfo->modelFind("customer_id='$customer_id'");
       if($customerinfoModel==false || $customerinfoModel==null){
          echo '已经被人处理过了';return;
       }else if(!in_array($customerinfoModel['status'], array(0,3,5))){
          echo '已经被人处理过了';return;
       }
       $result=$handleCustomerInfo->jobownerfollowSubmit($data);
       if($result=='操作成功'){
          echo '<script>alert("操作成功");window.close();</script>';
       }else{
          echo $result;
       }
   }
   /*非佣拉黑（获取数量） */
   public function batchblack_count(){
      if(I('get.handle')!='getcount'){
        echo '0';return;
      }
      $customerDal=new \Home\Model\customer();
      $city_code=C('CITY_CODE');
      $result=$customerDal->getCountByWhere(" is_owner=4 and city_code='$city_code' and is_commission=0 and is_black=0 and is_monthly=0 ");
      if($result!=null && count($result)>0){
        echo $result[0]['cnt'];
      }else{
        echo '0';
      }
   }
   /*非佣拉黑（提交） */
   public function batchblack_submit(){
      $loginName=trim(getLoginName());
      if($loginName==''){
         echo '{"status":"201","message":"请重新登录"}';return;
      }
      $customerDal=new \Home\Model\customer();
      $city_code=C('CITY_CODE');
      $list=$customerDal->getListByWhere(" is_owner=4 and city_code='$city_code' and is_commission=0 and is_black=0 and is_monthly=0 "," order by create_time asc limit 1000");
      if($list!=null){
          $blacklistLogic=new \Logic\BlackListLogic();
          $data['bak_type']=3;
          $data['bak_info']='批量处理非佣金职业房东';
          $data['no_login']=1;
          $data['no_post_replay']=1;
          $data['no_call']=1;
          $data['out_house']=1;//下架
          $data['is_sendmessage']=0;
          $data['update_man']=$loginName;
          $data['update_time']=time();
          $data['without_man']=1;
          $count=0;
          foreach ($list as $key => $model) {
              $data['mobile']=$model['mobile'];
              $data['customer_id']=$model['id'];
              $result=$blacklistLogic->addMobileForBlack($data);
              if($result){
                $count++;
              }
          }
          echo '{"status":"200","message":"成功拉黑'.$count.'个用户"}';
      }else{
          echo '{"status":"202","message":"操作失败"}';
      }
   }
   //拉黑一个
   public function pullblack_submit(){
      $loginName=trim(getLoginName());
      if($loginName==''){
         echo '{"status":"201","message":"请重新登录"}';return;
      }
      $mobile=I('get.mobile');
      $customer_id=I('get.customer_id');
      if($mobile==''){
         echo '{"status":"202","message":"参数错误"}';return;
      }
      $data['mobile']=$mobile;
      $data['customer_id']=$customer_id;
      $data['bak_type']=3;
      $data['bak_info']='职业房东拉黑';
      $data['no_login']=1;
      $data['no_post_replay']=1;
      $data['no_call']=1;
      $data['out_house']=1;
      $data['is_sendmessage']=0;
      $data['update_man']=$loginName;
      $data['update_time']=time();
      $blacklistLogic=new \Logic\BlackListLogic();
      $result=$blacklistLogic->addMobileForBlack($data);
      if($result){
          echo '{"status":"200","message":"操作成功"}';
      }else{
          echo '{"status":"400","message":"操作失败"}';
      }
   }
   /*职业房东检测（获取数量） */
   public function checkIsowner_count(){
      if(I('get.handle')!='getcount'){
        echo '0';return;
      }
      $dal=new \Home\Model\houseresource();
      $city_code=C('CITY_CODE');
      $list=$dal->getListByWhere(" city_code='$city_code' AND record_status=1 AND is_owner=3 and brand_type='' GROUP BY customer_id HAVING COUNT(1)>=5 ","");
      if($list!=null){
        echo count($list);
      }else{
        echo '0';
      }
   }
   /*职业房东检测（提交） */
   public function checkIsowner_submit(){
      $loginName=trim(getLoginName());
      if($loginName==''){
         echo '{"status":"201","message":"请重新登录"}';return;
      }
      $dal=new \Home\Model\houseresource();
      $city_code=C('CITY_CODE');
      $list=$dal->getListByWhere(" city_code='$city_code' AND record_status=1 AND is_owner=3 and brand_type='' GROUP BY customer_id HAVING COUNT(1)>=5 ","");
      if($list!=null){
          $handleLogic=new \Logic\CustomerInfo();
          $data['mobile']='';
          $data['source']='房源大于等于5套';
          $data['update_man']=$loginName;
          $data['update_time']=time();
          $count=0;
          foreach ($list as $key => $model) {
            if(strtoupper($model['customer_id'])=='08F796E4-84B9-0ECF-EA8B-C107427FBF4A'){
              continue;//排除聚合虚拟号码
            }
              $data['customer_id']=$model['customer_id'];
              $data['region_id']=$model['region_id'];
              $data['region_name']=$model['region_name'];
              $result=$handleLogic->addOwnerForCustomerinfo($data);
              if($result){
                $count++;
              }
          }
          echo '{"status":"200","message":"成功操作'.$count.'个用户"}';
      }else{
          echo '{"status":"202","message":"操作失败"}';
      }
   }

   public function updatejobowner(){
      $loginName=trim(getLoginName());

        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
         }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $customer=array('id'=>'','true_name'=>'','mobile'=>'','principal_man'=>'','margin'=>'','signed'=>'','sign_way'=>'','owner_remark'=>'','flag_limit'=>0,'region_id'=>0,'region_name'=>'');
        $customer_id=I('get.cuid');
        if(!empty($customer_id)){
          //edit
          $handleCustomer = new \Logic\CustomerLogic();
          $customer=$handleCustomer->getModelById($customer_id);
          if($customer!==null && $customer!==false){
            $handleCustomerInfo = new \Logic\CustomerInfo();
            $customerinfo=$handleCustomerInfo->modelFind(array('customer_id'=>$customer_id));
            if($customerinfo!==null && $customerinfo!==false){
              $customer['principal_man']=$customerinfo['principal_man'];
              $customer['margin']=$customerinfo['margin'];
              $customer['signed']=$customerinfo['signed'];
              $customer['sign_way']=$customerinfo['sign_way'];
              $customer['owner_remark']=$customerinfo['owner_remark'];
              $customer['region_id']=$customerinfo['region_id'];
              $customer['region_name']=$customerinfo['region_name'];
            }
          }
        }
        /*查询条件（房间负责人）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getHouseHandleList();
        $createmanString='';
        foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
        } 
        $this->assign("createManList",$createmanString);
         /*区域 */
        $result=$handleResource->getRegionList();
        $regionList='';
        if($result !=null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        $this->assign("regionList",$regionList);
         //权限控制
         if(in_array($loginName, array('admin','suhongye','haotongrui','xuwenhua','yantaojie','sunwenpei','daisuxia','yujiali','xujin','chenqi','zhanglu','zhouqihao','dingyuanxue'))){
           $customer['flag_limit']=1;
         }
        $this->assign("customer",$customer);
        $this->display();
   }
   //新增 或修改
   public function postupdate(){
    header ( "Content-type: text/html; charset=utf-8" );
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '会话失效，请重新登录';return;
      }
      $region_id=I('post.region_id');
      $region_name=I('post.region_name');
       $principal=trim(I('post.principal_man'));
       $signed=I('post.signed');
       $margin=trim(I('post.margin'));
       $signway=I('post.signway');
       $ownerremark=trim(I('post.ownerremark'));
       $ownertype=I('post.ownertype');
       $customerData['id']=I('post.customer_id');
       $customerData['true_name']=trim(I('post.true_name'));
       $customerData['house_limit'] = I('post.house_limit');
       if(empty($customerData['true_name']) && $ownertype!=3){
          echo '数据异常，请完善数据';return;
       }
       $flag_limit=empty($customerData['id'])?1:0;
       if(!$flag_limit){
         //修改，权限控制
         if(in_array($loginName, array('admin','suhongye','haotongrui','xuwenhua','yantaojie','sunwenpei','daisuxia','yujiali','xujin','chenqi','zhanglu','zhouqihao','dingyuanxue'))){
           $flag_limit=1;
         }
       }
        if($principal!="" && $ownertype!=3 && $flag_limit){
          $handleCustomerinfo= new \Home\Model\customerinfo();
          $result1=$handleCustomerinfo->modelPrincipalFind($principal);
          if(!$result1){
            return $this->error('该负责人不存在',"jobownerlist.html?no=6&leftno=111");
          }
       }
       if(!is_numeric($margin)){
          $margin=0;
       }
       $resourceDal=new \Home\Model\houseresource();
       $handleCustomer = new \Logic\CustomerLogic();
       if(empty($customerData['id'])){
          //add
          $customerData['mobile']=trim(I('post.mobile'));
          if($customerData['mobile']==""){
            echo '手机号异常，请完善数据';return;
          }
          $city_code=C('CITY_CODE');
          $customer=$handleCustomer->getResourceClientByPhone($customerData['mobile']);
          if($customer===null || $customer===false){
              //注册
              $customerData['id']=guid();
              $customerData['create_time']=time();
              $customerData['is_owner']=4;
              $customerData['is_renter']=0;
              $customerData['city_code']=$city_code;
              $handleCustomer->addModel($customerData);
          }else{
              //修改用户信息
              if($customer['is_owner']==4 && $customer['city_code']==$city_code){
                 echo '该手机号已经是职业房东用户';return;
              } elseif ($customer['is_owner']==5 && $customer['city_code']==$city_code) {
                 echo '该手机号已经是中介用户';return;
              }
             $customer['update_time']=time();
             $customer['update_man']=$loginName;
             $customer['true_name']=$customerData['true_name'];
             $customer['house_limit'] = $customerData['house_limit'];
             $customer['is_owner']=4;
             $customer['city_code']=$city_code;
             $update_result=$handleCustomer->updateModel($customer);
             if($update_result){
                  //更新 APP端用户缓存
                  $handleCustomer->updateCustomerCache($customer);
                 //更新房源、houseselect下的职业房东标识
                 $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customer['id'],'is_owner'=>4));
                 $resourceDal->updateHouseSelectByCustomerid(array('customer_id'=>$customer['id'],'is_owner'=>4));
             }
             $customerData['id']=$customer['id'];
          }
       }else{
          //edit
          $customerData['is_owner']=$ownertype;
          $update_result=$handleCustomer->updateModel($customerData);
          if($update_result){
            //更新 APP端用户缓存
              $customerModelCache=$handleCustomer->getModelById($customerData['id']);
              $handleCustomer->updateCustomerCache($customerModelCache);
             //更新房源下的职业房东标识
             $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customerData['id'],'is_owner'=>$ownertype));
             $resourceDal->updateHouseSelectByCustomerid(array('customer_id'=>$customerData['id'],'is_owner'=>$ownertype));
          }
          
       }
       $handleCustomerInfo = new \Logic\CustomerInfo();
       if($ownertype==3){
           $handleLogic=new \Logic\CommissionLogic();
           $handleCommissionfd= new \Home\Model\commissionfd();
           $handleBlackList=new \Logic\BlackListLogic();
           $commissionfdarr=$handleCommissionfd->getCommissionByWhere("where client_phone='".I('post.client_phone')."' and is_open=1");
            foreach ($commissionfdarr as $key => $value) {
              $handleLogic->updateCommissionStopfd($value['id'],$loginName);//删除房东下面的佣金
            }

           // $handleCustomerInfo->modelDelete(array('customer_id'=>$customerData['id']));//删除customerinfo信息
           $handleCustomerInfo->modelDeleteCustomerCheck(array('customer_id'=>$customerData['id']));//删除customerinfocheck信息
           //将该用户踢下线
           $handleBlackList->store_loginout("xx",$customerData['id']);
           return $this->success('操作成功！',"jobownerlist.html?no=6&leftno=111");
       }
       
       $dataInfo=$handleCustomerInfo->modelFind(array('customer_id'=>$customerData['id']));
       if($dataInfo!==null && $dataInfo!==false){
            $temp_man=$dataInfo['principal_man'];
            $dataInfo['signed']=$signed;
            if($flag_limit){
              $dataInfo['principal_man']=$principal;
            }
            $dataInfo['margin']=$margin;
            $dataInfo['region_id']=$region_id;
            $dataInfo['region_name']=$region_name;
            $dataInfo['update_time']=time();
            $dataInfo['update_man']=$loginName;
            $dataInfo['sign_way']=$signway;
            $dataInfo['owner_remark']=$ownerremark;
            $result=$handleCustomerInfo->modelUpdate($dataInfo);
            if($result && $flag_limit){
                //更新房间表里面的房东负责人
                $handleCustomerInfo->updateRoomPrincipal($customerData['id'],$principal);
            }
        }else{
            $data['id']=guid();
            $data['customer_id']=$customerData['id'];
            $data['signed']=$signed;
            if($flag_limit){
              $data['principal_man']=$principal;
            }
            $data['margin']=$margin;
            $data['region_id']=$region_id;
            $data['region_name']=$region_name;
            $data['update_time']=time();
            $data['update_man']=$loginName;
            $data['create_time']=time();
            $data['source']='系统添加';
            $data['sign_way']=$signway;
            $data['owner_remark']=$ownerremark;
            $data['status']=4;
            $result=$handleCustomerInfo->mobileAdd($data);
            if($result && $flag_limit){
                //更新房间表里面的房东负责人
                $handleCustomerInfo->updateRoomPrincipal($customerData['id'],$principal);
            }
        }
        if($result){
           $this->success('操作成功！',"jobownerlist.html?no=6&leftno=111");
        }else{
           $this->error('操作失败！',"jobownerlist.html?no=6&leftno=111");
        }
   }
   //获取customerinfo数据
     public function getcustomerinfo(){
           $handleCustomerInfo = new \Logic\CustomerInfo();
           $where['customer_id']=I('get.customer_id');
           $result=$handleCustomerInfo->modelFind($where);
           if($result===false || $result===null){
              echo '{"principal_man":"","update_man":"","source":"","signed":""}';
           }else{
              echo json_encode($result);
           }
           
     }
     //获取可租数量
     public function getRoomcount(){
           $handleCustomerInfo = new \Logic\CustomerInfo();
           $result=$handleCustomerInfo->getOnlineRoomcountByCustomerid(I('get.customer_id'));
           if($result===false || $result===null){
              echo 0;
           }else{
              echo $result[0]['cnt'];
           }
     }
    //导出excel
    public function downloadExcel() 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }

        //查询条件
        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['a.city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 4;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['b.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['b.is_commission']=array('eq',1);
        }

        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,b.source,b.principal_man,b.status,b.region_name,a.agent_company_name,a.company_store_name,b.create_time,b.update_man,a.is_port,a.is_monthly,a.is_commission,b.owner_remark';
        $data = $jobOwnerModel->modelGetCustomer(0,5000,$fields,$where);

        $title=array(
            'true_name'=>'姓名','mobile'=>'手机号','source'=>'来源','principal_man'=>'房东负责人','status'=>'跟进状态','region_name'=>'主营区域','agent_company_name'=>'公司','company_store_name'=>'门店','create_time'=>'创建时间','update_man'=>'操作人','is_port'=>'端口状态','is_monthly'=>'包月状态','is_commission'=>'佣金状态','owner_remark'=>'备注'
        );
        $excel[]=$title;
        $downAll=false;
            if(in_array(trim(getLoginName()), getDownloadLimit())) {
               $downAll=true;
         }
        foreach ($data as $key => $value) {
            if(!$downAll){
                $value['mobile'] = substr_replace($value['mobile'], '****', 4,4);
            }
            switch ($value['status']) {
                case '0':
                    $value['status']='待跟进';
                    break;
                case '3':
                    $value['status']='跟进中';
                case '5':
                    $value['status']='不合作';
                case '2':
                    $value['status']='已签约';
                case '4':
                    $value['status']='职业房东';
                    break;
                default:
                    $value['status']='';
                    break;
            }
            $value['create_time'] = $value['create_time']>0?date("Y-m-d H:i",$value['create_time']):"";
            switch ($value['is_port']) {
                case '0':
                    $value['is_port']='无';
                    break;
                case '1':
                    $value['is_port']='端口';
                    break;
                default:
                    $value['is_port']='';
                    break;
            }
            switch ($value['is_monthly']) {
                case '0':
                    $value['is_monthly']='无';
                    break;
                case '1':
                    $value['is_monthly']='包月';
                    break;
                default:
                    $value['is_monthly']='';
                    break;
            }
             switch ($value['is_commission']) {
                case '0':
                    $value['is_commission']='无';
                    break;
                case '1':
                    $value['is_commission']='端口';
                    break;
                default:
                    $value['is_commission']='';
                    break;
            }
            $excel[] = $value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '职业房东');
        $xls->addArray($excel);
        $xls->generateXML('职业房东'.date("YmdHis"));
    }
    //职业房东待确认列表
    public function jobownerconfirmlist(){
      echo '页面已经失效，请到职业房东列表操作跟进状态。';return;
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
       $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $handleMenu->jurisdiction();

      $dal = new \Home\Model\customerinfo();
      //查询条件.
      $status=I('get.status');
      if($status!=""){
          $where=' and status='.$status;
      }else{
          $where=' and (status=0 or status=3)';
      }
      if(I('get.source')!=''){
        $where.=" and source='".I('get.source')."'";
      }
      $startTime=I('get.start_time');
      $endTime=I('get.end_time');
      $mobile=trim(I('get.client_phone'));
      if($startTime!=""){
        $where.=" and create_time >=".strtotime($startTime);
      }
      if($endTime!=""){
        $where.=" and create_time <=".(strtotime($endTime)+86400);
      }
      if($mobile!=""){
        $where.=" and mobile='".str_replace("'", "", $mobile)."'";
      }
       $result=$dal->getConfirmCount($where);
       $count=0;
       if($result!==null && $result!==false && $result[0]['cnt']>0){
          $count=$result[0]['cnt'];
          $Page= new \Think\Page($count,10);
          $listarr=$dal->getConfirmList($Page->firstRow,$Page->listRows,$where);
           $this->assign("show", $Page->show());
       }else{
          $listarr=array();
          $this->assign("show", "");
       }

      $this->assign("pagecount",$count);
      $this->assign("list",$listarr);
      $this->display();
   }
   /*待确认职业房东，确认方法 */
     public function updateConfirm(){
        $id=I('get.confirmId');
        $status=I('get.confirmStatus');
        if(empty($id) || empty($status)){
          echo '{"status":"400","message":"参数异常"}';return;
        }
        $update_man=getLoginName();
        if(empty($update_man)){
          echo '{"status":"400","message":"会话失效，请重新登录"}';return;
        }
         $dal = new \Home\Model\customerinfo();
         $confirmModel=$dal->getConfirmModel(array('id'=>$id));
         if($confirmModel===false || $confirmModel===null){
            echo '{"status":"400","message":"数据获取失败"}';
         }else if($confirmModel['status']>0){
            echo '{"status":"400","message":"该房东已经确认过了"}';
         }else{
            if($status==2){
                //确认是职业房东
                $handleCustomerLogic=new \Logic\CustomerLogic();
                $clientModel = $handleCustomerLogic->getResourceClientByPhone($confirmModel['mobile']);
                if($clientModel!==null && $clientModel!==false){
                  $clientModel['is_owner']=4;//职业房东
                  $clientModel['city_code']=C('CITY_CODE');
                  $update_result=$handleCustomerLogic->updateModel($clientModel);
                  if($update_result){
                      //更新房源下的职业房东标识
                      $resourceDal=new \Home\Model\houseresource();
                      $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$clientModel['id'],'is_owner'=>4));
                  }
                }else{
                  //新增房东用户
                  $clientModel['id']=guid();
                  $clientModel['mobile']=$confirmModel['mobile'];
                  $clientModel['create_time']=time();
                  $clientModel['is_owner']=4;//职业房东
                  $clientModel['is_renter']=0;
                  $clientModel['city_code']=C('CITY_CODE');
                  $handleCustomerLogic->addModel($clientModel);
                }
                $CustomerInfo=$dal->modelFind("customer_id='".$clientModel['id']."'");
                if($CustomerInfo===false || $CustomerInfo===null){
                    $data['id']=guid();
                    $data['customer_id']=$clientModel['id'];
                    $data['source']=$confirmModel['source'];
                    $data['update_time']=time();
                    $data['update_man']=$update_man;
                    $data['create_time']=$data['update_time'];
                    $data['signed']=1;
                    $dal->mobileAdd($data);//新增customerinfo
                }else{
                    //更新已签约
                    if(I('is_deal')=="1" && $CustomerInfo['signed']=="0"){
                      $CustomerInfo['signed']=1;
                      $CustomerInfo['update_man']=$update_man;
                      $CustomerInfo['update_time']=time();
                      $dal->modelUpdate($CustomerInfo);
                    }
                }
            }
            $confirmModel['status']=$status;
            $confirmModel['update_man']=$update_man;
            $confirmModel['update_time']=time();
            $result=$dal->updateConfirm(array('id'=>$id),$confirmModel);
            if($result){
              echo '{"status":"200","message":"操作成功"}';
            }else{
              echo '{"status":"400","message":"操作失败"}';
            }
         }
     }
  //刷新房东下面的所有房源
  public function reflushRoomForOwner(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '{"status":"400","message":"操作失败"}'; return;
      }
      $customer_id=I('get.cuid');
      if(empty($customer_id)){
        echo '{"status":"400","message":"参数异常"}'; return;
      }
      $limitRefreshDal=new \Home\Model\customerlimitrefresh();
      $limitRefreshModel=$limitRefreshDal->modelFind(array('customer_id' =>$customer_id ));
      if($limitRefreshModel!=null && $limitRefreshModel!=false){
        //无效刷新
        echo '{"status":"200","message":"操作成功"}'; return;
      }
      $roomLogic=new \Logic\HouseRoomLogic();
      $now_time=time();
      $updateResult=$roomLogic->refreshRoomForOwner($customer_id,$now_time,$loginName);
      $room_list=$roomLogic->getRoomidsByCustomerid($customer_id);
      $handleSelect=new \Logic\HouseSelectLogic();
      if($room_list!==null && $room_list!==false){
        foreach ($room_list as $key => $value) {
          //操作房间查询表
          $handleSelect->updateModelByRoomid(array('room_id'=>$value['id'],'update_time'=>$now_time));
        }
      }
      echo '{"status":"200","message":"操作成功"}'; 
  }

  //职业房东待确认
  public function confirmupdate(){
     header ( "Content-type: text/html; charset=utf-8" );
    echo '页面已经失效，请到职业房东列表操作跟进状态。';return;
    
      $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
       $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
    
      $confirmid=I('get.confirmid');
      $handleCustomerinfo= new \Home\Model\customerinfo();
      $handleHousroom= new \Home\Model\houseroom();
      $handleResource=new \Logic\HouseResourceLogic();
      if($confirmid){
        $where['id']=$confirmid;
        //查询待确认
        $confirm=$handleCustomerinfo->getConfirmModel($where);
        //查询拥有房间
        $roomarr=$handleHousroom->getModelList("and h.client_phone=".$confirm['mobile'],0,10);
        //查询跟进记录
        $wherestatus['confirm_id']=$confirmid;
        $wherestatus['record_status']=1;
        $statusarr=$handleCustomerinfo->modelConfirmSelect($wherestatus);
         /*查询条件（房间负责人）*/
        $result=$handleResource->getHouseHandleList();
        $createmanString='';
        foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
        } 
        $this->assign("createManList",$createmanString);
        $this->assign("statusarr",$statusarr);
        $this->assign("roomarr",$roomarr);
      }
    
      $this->display();
  }
  //新增跟进记录 
  public function addconfirm(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '{"status":"400","message":"操作失败"}'; return;
      }
      $handleCustomerinfo= new \Home\Model\customerinfo();
      $handleCustomerLogic=new \Logic\CustomerLogic();
      $confirmid=I('post.confirmid');
      $status=I('post.trailstatus');
      $remark=I('post.remark');
      $sign_way=I('post.sign_way');
      $principal=I('post.principal');
      $principal_man=I('post.principal_man');
      $margin=I('post.margin');
      if($principal!=""){
          $result=$handleCustomerinfo->modelPrincipalFind($principal);
          if(!$result){
            return $this->error('该负责人不存在',"confirmupdate.html?confirmid=".$confirmid."&no=6&leftno=116");
          }
       }
      if($principal==""&&$principal_man!=""){
         $principal=$principal_man;
      }
      if($confirmid){
          //查询待确认
          $where['id']=$confirmid;
          $confirm=$handleCustomerinfo->getConfirmModel($where);
          $upwhere['id']=$confirm['id'];
          $confirm['status']=$status;
          $confirm['update_time']=time();
          $confirm['update_man']=cookie("admin_user_name");
          $confirm['remark']=$remark;
          $result=$handleCustomerinfo->updateConfirm($upwhere,$confirm);
          if($result){
            $data['id']=guid();
            $data['confirm_id']=$confirm['id'];
            $data['status']=$status;
            $data['create_time']=time();
            $data['update_man']=cookie("admin_user_name");
            $data['remark']=$remark;
            $handleCustomerinfo->modelConfirmAdd($data);
            //跟进状态修改处理
            if($status==2){
               $customerarr=$handleCustomerLogic->getResourceClientByPhone($confirm['mobile']);//获取房东信息
               $customerarr['is_owner']=4;
               $customerarr['update_time']=time();
               $customerarr['update_man']=cookie("admin_user_name");
               $curesult=$handleCustomerLogic->updateModel($customerarr);
               if($curesult){
                    //更新房源下的职业房东标识
                    $resourceDal=new \Home\Model\houseresource();
                    $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customerarr['id'],'is_owner'=>4));
                     $customerinfo=$handleCustomerinfo->modelFind("customer_id='".$customerarr['id']."'");
                     if(!$customerinfo){
                        $data1['id']=guid();
                        $data1['customer_id']=$customerarr['id'];
                        $data1['source']=$confirm['source'];
                        $data1['principal_man']=$principal;
                        $data1['update_time']=time();
                        $data1['update_man']=cookie("admin_user_name");
                        $data1['create_time']=time();
                        $data1['signed']=1;
                        $data1['sign_way']=$sign_way;
                        $data1['margin']=$margin;
                        $handleCustomerinfo->mobileAdd($data1);//新增customerinfo
                      }else{
                            $customerinfo['principal_man']=$principal;
                            $customerinfo['update_time']=time();
                            $customerinfo['update_man']=cookie("admin_user_name");
                            $customerinfo['signed']=1;
                            $customerinfo['sign_way']=$signway;
                            $customerinfo['margin']=$margin;
                            $handleCustomerinfo->modelUpdate($customerinfo);//修改customerinfo
                      }
                       //新增房东佣金
                      if(I('post.commissiontype')!=""){
                          $handleLogic=new \Logic\CommissionLogic();
                          $model['client_phone']=$confirm['mobile'];
                          $model['contracttime_start']=-99;
                          $model['contracttime_end']=99;
                          $model['commission_type']=I('post.commissiontype');
                          $model['commission_base']=1;
                          if($model['commission_type']=="2"){
                              $model['commission_base']=0;
                          }
                          $model['commission_money']=I('post.commissionmoney');
                          $model['is_online']=0;
                          $model['settlement_method']=1;
                          $model['start_time']=date("Y-m-d H:m:s",time());
                          $model['update_time']=time();
                          $model['update_man']=getLoginName();
                          $model['create_man']=getLoginName();
                          $model['create_time']=time();
                          $model['check_update']="on";
                          $handleLogic->addCommissionfd($model);
                      }
               }
            }elseif($status==1){
                     $customerarr=$handleCustomerLogic->getResourceClientByPhone($confirm['mobile']);//获取房东信息
                     if($customerarr['is_owner']==4){
                         $customerarr['is_owner']=3;
                         $customerarr['update_time']=time();
                         $customerarr['update_man']=cookie("admin_user_name");
                         $update_result=$handleCustomerLogic->updateModel($customerarr);//修改房东类型
                         if($update_result){
                             //更新房源下的职业房东标识
                             $resourceDal=new \Home\Model\houseresource();
                             $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$customerarr['id'],'is_owner'=>3));
                         }
                         $customerinfo=$handleCustomerinfo->modelFind("customer_id='".$customerarr['id']."'");
                         if($customerinfo){
                             $infodelete['customer_id']=$customerarr['id'];
                             $handleCustomerInfo->modelDelete($infodelete);//删除职业房东
                         }
                     } 
            }
            $this->success('操作成功！',"jobownerconfirmlist.html?no=6&leftno=116");
          }else{
            $this->error('操作失败！',"jobownerconfirmlist.html?no=6&leftno=116");
          }
      }
  }
  public function getCommissionfdMoney(){
    $client_phone=I('get.client_phone');
    if(empty($client_phone)){
      echo '{"money":""}';return;
    }
    $handleLogic=new \Logic\CommissionLogic();
    $result=$handleLogic->getCommissionfdNewOne($client_phone);
    if($result==false){
      echo '{"money":""}';return;
    }
    if($result['commission_type']=='1'){
       echo '{"money":"'.$result['commission_money'].'%"}';
    }else{
      echo '{"money":"'.$result['commission_money'].'"}';
    }
  }
  private function getDownCommissionfdMoney($is_commission,$client_phone){
    if($is_commission<1 || empty($client_phone)){
      return '';
    }
    $handleLogic=new \Logic\CommissionLogic();
    $result=$handleLogic->getCommissionfdNewOne($client_phone);
    if($result==false){
      return '';
    }
    if($result['commission_type']=='1'){
       return $result['commission_money'].'%';
    }
    return $result['commission_money'];
  }

  //批量修改负责人
  public function principaledit(){
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
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);

     $condition['name']=trim(I('get.name'));
     $condition['mobile']=trim(I('get.mobile'));
     $condition['source']=I('get.source');
     $condition['update_man']=trim(I('get.update_man'));
     $condition['principal_man']=trim(I('get.principal_man'));
     $condition['startTime']=I('get.startTime');
     $condition['endTime']=I('get.endTime');
     $condition['is_commission']=I('get.is_commission');
     $condition['isMonth']=I('get.isMonth');
     $condition['region_id']=I('get.region_id');

     $condition['totalCount']=I('get.totalCount');
     $totalCount=$condition['totalCount']==''?0:intval($condition['totalCount']);

     $list=array();
     $hadCondition=false;
     foreach ($condition as $k1 => $v1) {
         if($v1!=''){
             $hadCondition=true;
             break;
         }
     }
     $pageSHow='';$list=array();
     if($hadCondition){
          $handleCustomerInfo = new \Logic\CustomerInfo();
          if(I('get.p')=="" || $totalCount==0){
               $totalCount = $handleCustomerInfo->modelCustomerinfoCount($condition);//总条数
          }
         if($totalCount>0){
             $Page= new \Think\Page($totalCount,50);//分页
             $condition['totalCount']=$totalCount;
               foreach($condition as $key=>$val) {
                     $Page->parameter[$key]=urlencode($val);
                 }
             $pageSHow=$Page->show();
             $list =$handleCustomerInfo->modelCustomerinfoList($Page->firstRow,$Page->listRows,$condition);
         }
     }
      /*区域 */
     $resourceLogic=new \Logic\HouseResourceLogic();
     $result=$resourceLogic->getRegionList();
     $regionList='';
     if($result !=null){
       foreach ($result as $key => $value) {
         $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
       } 
     }
     $this->assign("regionList",$regionList);
     $this->assign("pageSHow",$pageSHow);
     $this->assign("totalCount",$totalCount);
     $this->assign("list",$list);
     $this->display();
  }
  /*提交修改负责人 */
  public function principaleditSubmit(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        echo '{"status":"201","message":"会话失效,请重新登录"}';return;
      }
       $ids=I('post.ids');
       $principal_man=trim(I('post.principal_man'));
      if(empty($ids) || empty($principal_man)){
        echo '{"status":"202","message":"数据有误"}';
        return;
      }
      //权限控制
      if(!in_array($loginName, array('suhongye','haotongrui','xuwenhua','yantaojie','sunwenpei','daisuxia','yujiali','xujin','chenqi','zhanglu','zhouqihao','dingyuanxue','zhouyifan'))){
        echo '{"status":"202","message":"你没有权限更新负责人，很抱歉"}';return;
      }
     $handleCustomerinfo= new \Home\Model\customerinfo();
     $result1=$handleCustomerinfo->modelPrincipalFind($principal_man);
     if(!$result1){
       echo '{"status":"203","message":"负责人不存在，修改失败"}';
       return;
     }
      $ids_array=explode(',', rtrim($ids,','));
      $roomHandle=new \Home\Model\houseroom();
      foreach ($ids_array as $key => $value) {
        if(empty($value)){
          continue;
        }
        $result=$handleCustomerinfo->modelUpdate(array('customer_id'=>$value,'principal_man'=>$principal_man,'update_man'=>$loginName,'update_time'=>time()));
        if($result){
            $roomHandle->updateModelByWhere(array('principal_man'=>$principal_man),"customer_id='$value'");
        }
      }
      echo '{"status":"200","message":"修改成功"}';
  }
  //职业房东审核
  public function jobownerVerifyList ()
  {
    $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
        return $this->error('非法操作',U('Index/index'),1);
      }
    $switchcity=$handleCommonCache->cityauthority();
    $this->assign("switchcity",$switchcity);
    $handleMenu = new\Logic\AdminMenuListLimit();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $startTime=strtotime(I('get.startTime'));
    $endTime=strtotime(I('get.endTime'));
    $mobile=I('get.mobile');
    $where = array();
    $where['city_code'] = C('CITY_CODE');
    $where['is_owner'] = 4;
    if($startTime!=""&&$endTime=="") {
          $where['create_time']=array('gt',$startTime);
      }
    if($endTime!=""&&$startTime=="") {
          $where['create_time']=array('lt',$endTime+86400);
      }
    if($startTime!=""&&$endTime!="") {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
    if($startTime!=""&&$endTime!=""&&$startTime==$endTime) {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
    if($mobile != "") {
          $where['mobile']=$mobile; 
      }
      $jobOwnerModel = new \Home\Model\customer();
      $count=$jobOwnerModel->modelCountCustomerCheck($where);
      $Page= new \Think\Page($count,10);
      $fields = 'id,customer_id,mobile,true_name,house_type,house_num,pay_type,create_time,oper_man_name,refuse_status';
      $data=$jobOwnerModel->modelGetCustomerCheck($Page->firstRow,$Page->listRows,$fields,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$data);
      $this->display();
  }
  //根据id更改职业房东通过状态
  public function modifyCustomerCheckVerify ()
  {
    $login_name=trim(getLoginName());
    if(empty($login_name)) {
        echo '{"code":"404","msg":"登录失效"}';return;
    }
    $jobOwnerLogic = new \Logic\CustomerLogic();
    $data = I('post.');//id,customer_id,mobile,refuse_status,pay_type
    $result = $jobOwnerLogic->modifyCustomerCheck($data);
    $sendArr['phonenumber']=$data['mobile'];
    $sendArr['smstype']= 'FHS015';
    $sendArr['timestamp']=time();
    $sendArr['name']="职业房东审核";
    $sendArr['money']="0";
    $sendArr['orderid']="0";
    sendPhoneContent($sendArr);
    if($result) {
        echo '{"code":"200","message":"操作成功","data":{}}';
    } else {
        echo '{"code":"400","message":"操作失败","data":{}}';
    }
  }
  //显示拒绝原因
  public function refuseReason ()
  {
    $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
        return $this->error('非法操作',U('Index/index'),1);
      }
    $switchcity=$handleCommonCache->cityauthority();
    $this->assign("switchcity",$switchcity);
    $handleMenu = new\Logic\AdminMenuListLimit();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $data = I('get.'); //id,origin
    $jobOwnerLogic = new \Logic\CustomerLogic();
    $info = $jobOwnerLogic->findCustomerCheckInfo($data['id']);
    $this->assign("list",$info);
    $this->assign("origin",$data['origin']);
    $this->display();
  }
  //根据id更改职业房东拒绝状态、原因
  public function modifyCustomerCheckRefuse ()
  {
    $login_name=trim(getLoginName());
    if(empty($login_name)) {
        echo '{"code":"404","msg":"登录失效"}';return;
    }
    $jobOwnerLogic = new \Logic\CustomerLogic();
    $data = I('post.');//id,customer_id,refuse_status,refuse_memo
    $roomID = $jobOwnerLogic->getHouseRoomID($data);
    $result = $jobOwnerLogic->modifyCustomerCheckRefuse($data);
    $sendArr['phonenumber']=$data['mobile'];
    $sendArr['smstype'] = 'FHS014';
    $sendArr['timestamp']=time();
    $sendArr['name']="职业房东审核";
    $sendArr['money']="0";
    $sendArr['orderid']="0";
    sendPhoneContent($sendArr);
    if($result) {
        //下架房源
        if(!empty($roomID)) {
            foreach ($roomID as $value) {
              $houseRoomLogic = new \Logic\HouseRoomLogic;
              $houseRoomLogic->offloadingByid($value['id'],'');
            }
        }
        echo '{"code":"200","message":"操作成功","data":{}}';
    } else {
        echo '{"code":"400","message":"操作失败","data":{}}';
    }
  }
  //导出职业房东审核excel
  public function downloadJobownerExcel() 
  {
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      //查询条件
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $mobile=I('get.mobile');
      $where = $temp = array();
      $where['city_code'] = C('CITY_CODE');
      $where['is_owner'] = 4;
      if($startTime!=""&&$endTime=="") {
          $where['create_time']=array('gt',$startTime);
      }
      if($endTime!=""&&$startTime=="") {
          $where['create_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!="") {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($startTime!=""&&$endTime!=""&&$startTime==$endTime) {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($mobile != "") {
          $where['mobile']=$mobile; 
      }
      $jobOwnerModel = new \Home\Model\customer();
      $fields = 'true_name,mobile,house_type,house_num,pay_type,create_time,refuse_memo,refuse_status,oper_man_name';
      $data=$jobOwnerModel->modelGetCustomerCheck(0,10000,$fields,$where);
      $title=array(
          'true_name'=>'姓名','mobile'=>'手机号','house_type'=>'房屋类型','house_num'=>'房间数','create_time'=>'提交时间','refuse_status'=>'审核状态','oper_man_name'=>'操作人'
      );
      $excel[]=$title;
      $downAll=false;
      if(in_array(trim(getLoginName()), getDownloadLimit())){
          $downAll=true;
      }
      foreach ($data as $key => $value) {
          $temp['true_name'] = $value['true_name'];
          if(!$downAll){
            $temp['mobile'] = substr_replace($value['mobile'], '****', 4,4);
          } else {
            $temp['mobile'] = $value['mobile'];
          }
      switch ($value['house_type']) {
          case '0':
              $temp['house_type']='无';
              break;
          case '1':
              $temp['house_type']='集中式';
              break;
          case '2':
              $temp['house_type']='分散式';
              break;
          case '1,2':
              $temp['house_type']='集中式-分散式';
              break;
          default:
              $temp['house_type']='';
              break;
      }
          $temp['house_num'] = $value['house_num'];
          $temp['create_time'] = $value['create_time'] > 0 ? date("Y-m-d H:i",$value['create_time']) : ""; 
      switch ($value['refuse_status']) {
          case '0':
              $temp['refuse_status'] = '未操作';
              break;
          case '1':
              $temp['refuse_status'] = '审核通过--';
              switch ($value['pay_type']) {
              case '0':
                  $temp['refuse_status'] .= '试用用户';break;
              case '1':
                  $temp['refuse_status'] .= '付费用户';break;
              case '2':  
                  $temp['refuse_status'] .= '免费用户';break;
              default:
                  $temp['refuse_status'] = '';break;
              }
              break;
          case '2':
              $temp['refuse_status'] = '审核拒绝--'.$value['refuse_memo'];
              break;
          default:
              $temp['refuse_status']='';
              break;
      }
          $temp['oper_man_name'] = $value['oper_man_name'];
          $excel[]=$temp;
      }
      Vendor('phpexcel.phpexcel');
      $xls = new \Excel_XML('UTF-8', false, '职业房东审核');
      $xls->addArray($excel);
      $xls->generateXML('职业房东审核'.date("YmdHis"));
    }
  //城市归属修改列表
  public function jobownerCityList ()
  {
    $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
        return $this->error('非法操作',U('Index/index'),1);
      }
    $switchcity=$handleCommonCache->cityauthority();
    $this->assign("switchcity",$switchcity);
    $handleMenu = new\Logic\AdminMenuListLimit();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $mobile=I('get.mobile');
    $where = array();
    $where['city_code'] = C('CITY_CODE');
    if($mobile != "") {
          $where['mobile']=$mobile; 
      }
      $jobOwnerModel = new \Home\Model\customer();
      $count=$jobOwnerModel->modelCountCustomerCheck($where);
      $Page= new \Think\Page($count,10);
      $fields = 'id,customer_id,is_owner,mobile,true_name,city_code,create_time';
      $data=$jobOwnerModel->modelGetCustomerCheck($Page->firstRow,$Page->listRows,$fields,$where);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("pagecount",$count);
      $this->assign("show",$Page->show());
      $this->assign("list",$data);
      $this->display();
  }
  //修改城市归属
  public function modifyCustomerCity ()
  {
      $login_name=trim(getLoginName());
      if(empty($login_name)) {
        echo '{"code":"404","msg":"登录失效"}';return;
      }
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $data = I('post.');//id,customer_id,city_code
      $result = $jobOwnerLogic->modifyCustomerCheckCity($data);
      $jobOwnerLogic->modifyCustomerCity($data);
      $modelCustomer['city_code'] = $data['city_code'];
      $cache_key="customer_model_get".$data['customer_id'];
      $cache_key=set_cache_public_key($cache_key);           
      set_redis_data($cache_key,$modelCustomer,60*60);
      if($result) {
        echo '{"code":"200","message":"操作成功","data":{}}';
      } else {
        echo '{"code":"400","message":"操作失败","data":{}}';
      }
  }
  //中介用户审核
  public function middlemanVerifyList ()
  {
    $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
        return $this->error('非法操作',U('Index/index'),1);
      }
    $switchcity=$handleCommonCache->cityauthority();
    $this->assign("switchcity",$switchcity);
    $handleMenu = new\Logic\AdminMenuListLimit();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"6");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"6");
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $startTime=strtotime(I('get.startTime'));
    $endTime=strtotime(I('get.endTime'));
    $mobile=I('get.mobile');
    $where = array();
    $where['city_code'] = C('CITY_CODE');
    $where['is_owner'] = 5;
    if($startTime!=""&&$endTime=="") {
          $where['create_time']=array('gt',$startTime);
      }
    if($endTime!=""&&$startTime=="") {
          $where['create_time']=array('lt',$endTime+86400);
      }
    if($startTime!=""&&$endTime!="") {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
    if($startTime!=""&&$endTime!=""&&$startTime==$endTime) {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
    if($mobile != "") {
          $where['mobile']=$mobile; 
      }
    $jobOwnerModel = new \Home\Model\customer();
    $jobOwnerLogic = new \Logic\CustomerLogic();
    $count=$jobOwnerModel->modelCountCustomerCheck($where);
    $Page= new \Think\Page($count,10);
    $fields = 'id,customer_id,mobile,true_name,pay_type,create_time,oper_man_name,refuse_status';
    $data=$jobOwnerModel->modelGetCustomerCheck($Page->firstRow,$Page->listRows,$fields,$where);
    foreach($data as $val) {
      $list['id'] = $val['id'];
      $list['customer_id'] = $val['customer_id'];
      $list['mobile'] = $val['mobile'];
      $temp = $jobOwnerLogic->findCustomerInfo($val['customer_id']);
      $list['agent_company_name'] = $temp['agent_company_name'];
      $list['agent_commission_price'] = $temp['agent_commission_price'];
      $list['true_name'] = $val['true_name'];
      $list['pay_type'] = $val['pay_type'];
      $list['create_time'] = $val['create_time'];
      $list['oper_man_name'] = $val['oper_man_name'];
      $list['refuse_status'] = $val['refuse_status'];
      $info[] = $list; 
      }
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $this->assign("pagecount",$count);
    $this->assign("show",$Page->show());
    $this->assign("list",$info);
    $this->display();
  }
  //匹配中介库
  public function matchAgentCompany ()
  {
      $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"status":"404","message":"登录失效"}';return;
        }
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $data = I('get.');//company
      $result = $jobOwnerLogic->findAgentCompany($data['company']);
      if(!empty($result)) {
          echo '{"status":"200","message":"操作成功!","data":{}}';
      } else {
          echo '{"status":"201","message":"中介公司不在中介库，请添加中介公司后再通过!","data":{}}';
      }
  }
  //导出中介用户审核excel
  public function downloadMiddleManExcel() 
  {
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      //查询条件
      $startTime=strtotime(I('get.startTime'));
      $endTime=strtotime(I('get.endTime'));
      $mobile=I('get.mobile');
      $where = $temp = array();
      $where['city_code'] = C('CITY_CODE');
      $where['is_owner'] = 5;
      if($startTime!=""&&$endTime=="") {
          $where['create_time']=array('gt',$startTime);
      }
      if($endTime!=""&&$startTime=="") {
          $where['create_time']=array('lt',$endTime+86400);
      }
      if($startTime!=""&&$endTime!="") {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($startTime!=""&&$endTime!=""&&$startTime==$endTime) {
          $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
      }
      if($mobile != "") {
          $where['mobile']=$mobile; 
      }
      $jobOwnerModel = new \Home\Model\customer();
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $fields = 'true_name,mobile,pay_type,create_time,refuse_memo,refuse_status,oper_man_name,customer_id';
      $data=$jobOwnerModel->modelGetCustomerCheck(0,10000,$fields,$where);
      $title=array(
          'true_name'=>'姓名','mobile'=>'手机号','agent_company_name'=>'中介公司','agent_commission_price'=>'收佣比','create_time'=>'提交时间','refuse_status'=>'审核状态','oper_man_name'=>'操作人'
      );
      $excel[]=$title;
      $downAll=false;
      if(in_array(trim(getLoginName()), getDownloadLimit())){
          $downAll=true;
      }
      foreach ($data as $key => $value) {
          $temp['true_name'] = $value['true_name'];
          if(!$downAll){
            $temp['mobile'] = substr_replace($value['mobile'], '****', 4,4);
          } else {
            $temp['mobile'] = $value['mobile'];
          }
          $info = $jobOwnerLogic->findCustomerInfo($value['customer_id']);
          $temp['agent_company_name'] = $info['agent_company_name'];
          $temp['agent_commission_price'] = $info['agent_commission_price'];
          $temp['create_time'] = $value['create_time'] > 0 ? date("Y-m-d H:i",$value['create_time']) : ""; 
      switch ($value['refuse_status']) {
          case '0':
              $temp['refuse_status'] = '未操作';
              break;
          case '1':
              $temp['refuse_status'] = '审核通过--';
              switch ($value['pay_type']) {
              case '0':
                  $temp['refuse_status'] .= '试用用户';break;
              case '1':
                  $temp['refuse_status'] .= '付费用户';break;
              case '2':  
                  $temp['refuse_status'] .= '免费用户';break;
              default:
                  $temp['refuse_status'] = '';break;
              }
              break;
          case '2':
              $temp['refuse_status'] = '审核拒绝--'.$value['refuse_memo'];
              break;
          default:
              $temp['refuse_status']='';
              break;
      }
          $temp['oper_man_name'] = $value['oper_man_name'];
          $excel[]=$temp;
      }
      Vendor('phpexcel.phpexcel');
      $xls = new \Excel_XML('UTF-8', false, '中介用户审核');
      $xls->addArray($excel);
      $xls->generateXML('中介用户审核'.date("YmdHis"));
    }

    public function ownersManageList ()
    {
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

        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['a.city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 4;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['a.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['a.is_commission']=array('eq',1);
        }
     
        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,a.is_commission,a.is_monthly,a.is_port,a.agent_company_name,a.company_store_name,b.status,b.create_time,b.update_man,b.principal_man,b.source,b.region_name,b.customer_id,b.owner_remark';
        $count = $jobOwnerModel->modelCountCustomer($where);
        $Page = new \Think\Page($count,10);
        $data = $jobOwnerModel->modelGetCustomer($Page->firstRow,$Page->listRows,$fields,$where);
        /*区域 */
        $resourceLogic=new \Logic\HouseResourceLogic();
        $result=$resourceLogic->getRegionList();
        $regionList='';
        if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //品牌公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['company_type'] = 2;
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
   }
  //职业房东详情页
  public function ownersManageDetail () 
  {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new\Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html=$handleMenu->menuLeft(getLoginName(),"6");
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $data = I('get.');//id
        $infoList = $portList = $monthlyList = $commissionList = $stickList = $dataList = array();
        $infoList = $jobOwnerLogic->findOwnerInfo($data['id']);
        $return = $jobOwnerLogic->findBasicInfo($data['id']);
        $portList = $return[0];
        $monthlyList = $return[1];
        $commissionList = $return[2];
        $stickList =  $return[3];
        // $dataList = $return[4];
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign('infoList',$infoList);
        $this->assign('portList',$portList);
        $this->assign('monthlyList',$monthlyList);
        $this->assign('commissionList',$commissionList);
        $this->assign('stickList',$stickList);
        // $this->assign('dataList',$dataList);
        $this->display();
  }
  //新增职业房东
  public function ownersAdd ()
  {
        $loginName=trim(getLoginName());
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),6);
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),6);
        /*查询条件（房间负责人）*/
        $handleResource=new \Logic\HouseResourceLogic();
        $result=$handleResource->getHouseHandleList();
        $createmanString='';
        foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
        } 
        $this->assign("createManList",$createmanString);
         /*区域 */
        $result = $handleResource->getRegionList();
        $regionList='';
        if($result !=null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //品牌公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name,commission_fee';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['company_type'] = 2;
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->display();
  }
  //新增职业房东信息
  public function ownersAddInfo ()
  {
      $data = I('post.');
      $login_name=trim(getLoginName());
      if(empty($login_name) || empty($data)){
          echo '{"code":"404","message":"登录失效"}';return;
      } 
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $agentsLogic = new \Logic\AgentsManageLogic();
      $handleCustomerinfo= new \Home\Model\customerinfo();
      $resultOne = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
        if(empty($resultOne)) {
          return $this->error('该负责人不存在',"agentsManageList.html?no=6&leftno=192");
        } 
      $result = $agentsLogic->findCustomer($data);
      $data['memo'] = $result['memo'].strtotime(time())."后台新增职业房东";
      if(!empty($result) && ($result['is_owner'] == 3 || $result['is_owner'] == 0)) {
          $resourceDal=new \Home\Model\houseresource();
          $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$result['customer_id'],'is_owner'=>3));
          $resourceDal->updateHouseSelectByCustomerid(array('customer_id'=>$result['customer_id'],'is_owner'=>3));
          //删除房东房间报价、修改聚合属性
          $handleLogic=new \Logic\CommissionLogic();
          $room = $handleLogic->getHouseRoomInfo($result['id']);
          if(!empty($room)) {
              foreach ($room as $value) {
                  //给报价人推送消息
                  $handleLogic->pushHouseOfferNotice($value['id'],$value['resource_id']);
                  $blackListLogic = new \Logic\BlackListLogic();
                  $blackListLogic->deleteHouseRoomOffer($value['id']);
                  $blackListLogic->updateHouseRoom($value['id']);          
              }
          }
        //查找customerinfo是否存在，并添加
        $agentsLogic->findCustomerInfoTable($result['id']);
        $resultTwo = $agentsLogic->modifyAgentsInfo($result['id'],$data);//更新用户信息
      } elseif(empty($result)) { 
        $resultTwo = $agentsLogic->addAgentsInfo($data);
      } else {
        $resultTwo = false;
      }
      if($resultTwo) {
            //删除用户缓存
            if(!empty($result['id'])) {
                $cache_key="customer_model_get".$result['id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
            }     
            $this->success('提交成功！',"ownersManageList.html?no=6&leftno=204");
      } else {
          $this->error('提交失败！',"ownersManageList.html?no=6&leftno=204");
      }
  }
  //编辑职业房东信息
  public function ownersUpdate ()
  {
      $customerID = I('get.id');
      if(empty($customerID)) {
          echo '参数异常';return;
      }
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
       return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      //菜单权限
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
      $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
      $jobOwnerLogic = new \Logic\CustomerLogic();
      $data = $jobOwnerLogic->findOwnerInfo($customerID);
      /*查询条件（房间负责人）*/
      $handleResource=new \Logic\HouseResourceLogic();
      $result=$handleResource->getHouseHandleList();
      $createmanString='';
      foreach ($result as $key => $value) {
          $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
      } 
      $this->assign("createManList",$createmanString);
      /*区域 */
      $result = $handleResource->getRegionList();
      $regionList='';
      if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
      }
      //品牌公司
      $agentsModel = new \Home\Model\agents();
      $companyList = '';
      $fields = 'id,company_name,commission_fee';
      $where = array();
      $where['city_code'] = C('CITY_CODE');
      $where['pid'] = "";
      $where['company_type'] = 2;
      $where['record_status'] = 1;
      $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
      if($return !=null){
        foreach ($return as $key => $value) {
          $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
        } 
      }
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("regionList",$regionList);
      $this->assign("companyList",$companyList);
      $this->assign("info",$data);
      $this->display();
  }
  //修改职业房东信息
  public function ownersModifyInfo ()
  {
      $data = I('post.');
      $login_name=trim(getLoginName());
      if(empty($login_name) || empty($data)){
          echo '{"code":"404","message":"登录失效"}';return;
      } 
      $agentsLogic = new \Logic\AgentsManageLogic();
      $handleCustomerinfo= new \Home\Model\customerinfo();
      if(!empty($data['principal_man'])) {
          $result = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
          if(empty($result)) {
            return $this->error('该负责人不存在',"ownersManageList.html?no=6&leftno=204");
          } 
      }
      $return = $agentsLogic->modifyAgentsInfoTwo($data);
      if($return) {
          //删除用户缓存
          $cache_key="customer_model_get".$data['customer_id'];
          $cache_key=set_cache_public_key($cache_key);           
          set_redis_data($cache_key,"the data is null!",60*20);
          $this->success('修改成功！',"ownersManageList.html?no=6&leftno=204");
      }else{
          $this->success('修改失败！',"ownersManageList.html?no=6&leftno=204");
      }
  }
  //新增端口
  public function ownerPortAdd () 
  {
      $customerID = I('get.id');
      if(empty($customerID)) {
          echo '参数异常';return;
      }
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
       return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      //菜单权限
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
      $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->assign("id",$customerID);
      $this->display();
    }
    //新增端口合同
    public function ownerPortAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addServiceData($data);
        if($return){
               //删除用户缓存
                $cache_key="customer_model_get".$data['customer_id'];
                $cache_key=set_cache_public_key($cache_key);           
                set_redis_data($cache_key,"the data is null!",60*20);
                $this->success("端口新增成功","ownersManageDetail.html?no=6&leftno=204&id={$data['customer_id']}");
            } else {
                $this->error("端口新增失败","ownersManageDetail.html?no=6&leftno=204&id={$data['customer_id']}");
        }
    }
    //端口详情
    public function ownerPortDetail () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $jobOwnerModel = new \Home\Model\customer();
        $fields = "service_type,service_start,service_end,city_code,links_num,create_time,create_man,memo,price,house_limit";
        $where['customer_id'] = $customerID;
        $info = $jobOwnerModel->modelGetServiceDetail($fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("list",$info);
        $this->display();
    }
    //停用端口
    public function ownerPortStop ()
    {
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->stopOwnerPort($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //端口延期
    public function ownerPortDelay ()
    {
        $customer = I('get.');
        if(empty($customer)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("customer",$customer);
        $this->display();
    }
    //端口延期合同
    public function ownerPortDelayInfo ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->delayOwnerPort($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            $this->success("端口延期成功","ownersManageDetail.html?no=6&leftno=204&id={$data['customer_id']}");
        } else {
            $this->error("端口延期失败","ownersManageDetail.html?no=6&leftno=204&id={$data['customer_id']}");
        }
    }
    //新增包月
    public function ownerMonthlyAdd () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("id",$customerID);
        $this->display();
    }
    //新增包月合同
    public function ownerMonthlyAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addCommissionMonthly($data);
        if($return){
                $this->success("包月新增成功","ownersManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
            } else {
                $this->error("包月新增失败","ownersManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        }
    }
    //停用包月
    public function ownerMonthlyStop ()
    {
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->stopOwnerMonthly($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //新增佣金
    public function ownerCommissionAdd () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("id",$customerID);
        $this->display();
    }
    //新增佣金合同
    public function ownerCommissionAddInfo () 
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $data = I("post.");//customer_id
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->addCommissionDetail($data);
        if($return){
            $this->success("佣金新增成功","ownersManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        } else {
            $this->error("佣金新增失败","ownersManageDetail.html?no=6&leftno=111&id={$data['customer_id']}");
        }
    }
    //停用佣金
    public function ownerCommissionStop ()
    {
        $data = I('get.');
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $return = $jobOwnerLogic->stopOwnerCommission($data);
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            echo '{"code":"200","message":"操作成功","data":{}}';
        } else {
            echo '{"code":"400","message":"操作失败","data":{}}';
        }
    }
    //核心管理
    public function ownersCoreManageList ()
    {
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

        $name = I('get.true_name');
        $mobile = I('get.mobile');
        $regionID = I('get.region_id');
        $companyID = I('get.agent_company_id');
        $storeID = I('get.company_store_id');
        $principal = I('get.principal_man');
        $source = I('get.source');
        $status = I('get.status');
        $port = I('get.is_port');
        $monthly = I('get.is_monthly');
        $commission = I('get.is_commission');
        $where = $info = $data = array();
        $where['city_code'] = C('CITY_CODE');
        $where['a.record_status'] = 1;
        $where['a.is_owner'] = 4;
        if($name != "") {
            $where['a.true_name']=array('like','%'.$name.'%');
        }
        if($mobile != "") {
            unset($where['a.city_code']);
            $where['a.mobile']=array('eq',$mobile);
        }
        if($regionID != "") {
            $where['b.region_id']=array('eq',$regionID);
        }
        if($companyID != "") {
            $where['a.agent_company_id']=array('eq',$companyID);
        }
        if($storeID != "") {
            $where['a.company_store_id']=array('eq',$storeID);
        }
        if($principal != "") {
            $where['b.principal_man'] = array('eq',$principal);
        }
        if($source != "") {
            $where['b.source']=array('eq',$source);
        }
        if($status != "") {
            $where['b.status']=array('eq',$status);
        }
        if($port != "") {
            $where['a.is_port']=array('eq',1);
        }
        if($monthly != "") {
            $where['b.is_monthly']=array('eq',1);
        }
        if($commission != "") {
            $where['b.is_commission']=array('eq',1);
        }

        $jobOwnerModel = new \Home\Model\customer();
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $fields = 'a.true_name,a.mobile,a.is_commission,a.is_monthly,a.is_port,a.agent_company_name,a.company_store_name,b.status,b.principal_man,b.source,b.region_name,b.customer_id';
        $count = $jobOwnerModel->modelCountCustomer($where);
        $Page = new \Think\Page($count,10);
        $data = $jobOwnerModel->modelGetCustomer($Page->firstRow,$Page->listRows,$fields,$where);
  
        /*区域 */
        $resourceLogic=new \Logic\HouseResourceLogic();
        $result=$resourceLogic->getRegionList();
        $regionList='';
        if($result != null){
          foreach ($result as $key => $value) {
            $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          } 
        }
        //品牌公司
        $agentsModel = new \Home\Model\agents();
        $companyList = '';
        $fields = 'id,company_name';
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['pid'] = "";
        $where['company_type'] = 2;
        $where['record_status'] = 1;
        $return = $agentsModel->modelGetAgentCompany('','',$fields,$where);
        if($return !=null){
          foreach ($return as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          } 
        }
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("regionList",$regionList);
        $this->assign("companyList",$companyList);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
   }
   //核心信息管理
    public function ownersCoreInfo () 
    {
        $customerID = I('get.id');
        if(empty($customerID)) {
            echo '参数异常';return;
        }
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        //菜单权限
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html = $handleMenu->menuTop(getLoginName(),"6");
        $menu_left_html = $handleMenu->menuLeft(getLoginName(),"6");
        $jobOwnerLogic = new \Logic\CustomerLogic();
        $data = $jobOwnerLogic->findOwnerCoreInfo($customerID);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("customerinfo",$data);
        $this->display();
    }
    //职业房东核心信息修改
    public function ownersModifyCoreInfo ()
    {
        $data = I('post.');
        if(!isset($data['owner_verify'])) {
          $data['owner_verify'] = 0;
        }
        $login_name=trim(getLoginName());
        if(empty($login_name) || empty($data)){
            echo '{"code":"404","message":"登录失效"}';return;
        } 
        $agentsLogic = new \Logic\AgentsManageLogic();
        $handleCustomerinfo= new \Home\Model\customerinfo();
        if(!empty($data['principal_man'])) {
            $result = $handleCustomerinfo->modelPrincipalFind($data['principal_man']);
            if(empty($result)) {
              return $this->error('该负责人不存在',"ownersCoreManageList.html?no=6&leftno=205");
            } 
        }
        if($data['is_owner'] == 4) {
            $return = $agentsLogic->modifyAgentsInfoThree($data['customer_id'],$data);
        } elseif($data['is_owner'] == 3) {
            $return = $agentsLogic->modifyAgentsInfoFour($data['customer_id'],$data);
            //更新房源、houseselect下的职业房东标识
            $resourceDal=new \Home\Model\houseresource();
            $resourceDal->updateHouseClientByCustomerid(array('customer_id'=>$data['customer_id'],'is_owner'=>3));
            $resourceDal->updateHouseSelectByCustomerid(array('customer_id'=>$data['customer_id'],'is_owner'=>3));
        }
        if($return) {
            //删除用户缓存
            $cache_key="customer_model_get".$data['customer_id'];
            $cache_key=set_cache_public_key($cache_key);           
            set_redis_data($cache_key,"the data is null!",60*20);
            $this->success('修改成功！',"ownersCoreManageList.html?no=6&leftno=205");
        }else{
            $this->success('修改失败！',"ownersCoreManageList.html?no=6&leftno=205");
        }
    }
}
?>
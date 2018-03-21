<?php
namespace Home\Controller;
use Think\Controller;
class ServiceRefreshController extends Controller {
   /*配置服务-刷新房源 start*/

   //列表
   public function refreshroomlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()) {
          return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(getLoginName(),141);
      $menu_left_html=$handleMenu->menuLeft(getLoginName(),141);
      $handleMenu->jurisdiction();
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);

      $handleLogic = new \Logic\ServiceRefreshLogic();
      $list = $handleLogic->getRefreshroomList(0,50);
      $this->assign("list",$list);
      $this->display();
   }
   //新增刷新条件页面
   public function addrefreshwhere(){
      $login_name=trim(getLoginName());
      if($login_name==''){
        echo 'please login';return;
      }
      $handleResource=new \Logic\HouseResourceLogic();
      $paramList=$handleResource->getResourceParameters();
      $brandString='';//品牌
      if($paramList!=null){
        foreach ($paramList as $key => $value) {
          if($value['info_type']==16){
            $brandString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
        } 
      }
      $regionResult=$handleResource->getRegionList();
      $regionList='';
      if($regionResult!=null){
        foreach ($regionResult as $key => $value) {
          $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
        } 
      }
      $this->assign("regionList",$regionList);
      $this->assign("brandTypeList",$brandString);
      $this->display();
   }
   //新增刷新条件，提交保存
   public function addrefreshwhereSubmit(){
      header("Content-type:text/html; charset=utf-8");
      $login_name=trim(getLoginName());
      if($login_name==''){
        echo 'please login';return;
      }
      $queryType=I('post.queryType');
      if($queryType=='room'){
        //room表查询
        $condition['moneyMin']=trim(I('post.moneyMin_r'));
        $condition['moneyMax']=trim(I('post.moneyMax_r'));
        $condition['isComm']=trim(I('post.isComm_r'));
        $condition['isAgent']=trim(I('post.isAgent_r'));
        $condition['phone']=trim(I('post.clientPhone_r'));
        $condition['isMonth']=trim(I('post.isMonth'));
        $condition['principalMan']=trim(I('post.principalMan'));
        $hadCondition=false;
        foreach ($condition as $k1 => $v1) {
          if($v1!=''){
            $hadCondition=true;
            break;
          }
        }
        if($hadCondition==false){
          echo '请选择条件';return;
        }
        if($condition['moneyMin']!='' && !is_numeric($condition['moneyMin'])){
          echo '租金条件异常';return;
        }
        if($condition['moneyMax']!='' && !is_numeric($condition['moneyMax'])){
          echo '租金条件异常';return;
        }
        if($condition['phone']!=''){
          $handleModel=new \Home\Model\customer();
          $customerModel=$handleModel->getResourceClientByPhone($condition['phone']);
          if($customerModel==null || $customerModel==false){
            echo '房东电话不存在';return;
          }
          $condition['cuid']=$customerModel['id'];
        }
        $handleLogic=new \Logic\ServiceRefreshLogic();
        $result=$handleLogic->addRefreshroomByroom($condition,$login_name);
        if($result){
          $this->success('新增成功',U('ServiceRefresh/refreshroomlist?no=141&leftno=200'),2);
        }else{
          echo '操作失败';
        }
      }elseif($queryType=='select'){
        //select表查询
        $condition['moneyMin']=trim(I('post.moneyMin_s'));
        $condition['moneyMax']=trim(I('post.moneyMax_s'));
        $condition['isComm']=trim(I('post.isComm_s'));
        $condition['isAgent']=trim(I('post.isAgent_s'));
        $condition['phone']=trim(I('post.clientPhone_s'));
        $condition['room_num']=trim(I('post.room_num'));
        $condition['brandType']=trim(I('post.brandType'));
        $condition['brandName']=trim(I('post.brandName'));
         $condition['region']=trim(I('post.region'));
         $condition['scope']=trim(I('post.scope'));
         $condition['region_name']=trim(I('post.region_name'));
         $condition['scope_name']=trim(I('post.scope_name'));
        $hadCondition=false;
        foreach ($condition as $k1 => $v1) {
          if($v1!=''){
            $hadCondition=true;
            break;
          }
        }
        if($hadCondition==false){
          echo '请选择条件';return;
        }
        if($condition['moneyMin']!='' && !is_numeric($condition['moneyMin'])){
          echo '租金条件异常';return;
        }
        if($condition['moneyMax']!='' && !is_numeric($condition['moneyMax'])){
          echo '租金条件异常';return;
        }
        if($condition['phone']!=''){
          $handleModel=new \Home\Model\customer();
          $customerModel=$handleModel->getResourceClientByPhone($condition['phone']);
          if($customerModel==null || $customerModel==false){
            echo '房东电话不存在';return;
          }
          $condition['cuid']=$customerModel['id'];
        }
        $handleLogic=new \Logic\ServiceRefreshLogic();
        $result=$handleLogic->addRefreshroomByselect($condition,$login_name);
        if($result){
          $this->success('新增成功',U('ServiceRefresh/refreshroomlist?no=141&leftno=200'),2);
        }else{
          echo '操作失败';
        }
      }
   }
   //获取刷新时间点
   public function getRefreshtimes(){
      $rid=trim(I('get.rid'));
      if($rid==''){
        echo '';return;
      }
      $handleLogic=new \Logic\ServiceRefreshLogic();
      $list=$handleLogic->getRefreshtimesByid($rid);
      if($list!=null&&count($list)>0){
        echo json_encode($list);
      }else{
        echo '';
      }
   }
   //刷新时间，提交保存
   public function refreshtimeSubmit(){
      header("Content-type:text/html; charset=utf-8");
      $login_name=trim(getLoginName());
      if($login_name==''){
        echo 'please login';return;
      }
      $rid=trim(I('post.modify_id'));
      if($rid==''){
        echo '数据异常';return;
      }
      $settime_arr=array();
      for ($i=1; $i < 6; $i++){ 
        if($_POST['ddlHour'.$i]!="" && $_POST['ddlMinute'.$i]!=""){
          $settime_arr[]=array('hour'=>$_POST['ddlHour'.$i],'minute'=>$_POST['ddlMinute'.$i]);
        }
      }
      if(count($settime_arr)==0){
        echo '时间设置异常';return;
      }
      $handleLogic=new \Logic\ServiceRefreshLogic();
      $result=$handleLogic->setRefreshtime($rid,$login_name,$settime_arr);
      if($result){
        $this->success('操作成功',U('ServiceRefresh/refreshroomlist?no=141&leftno=200'),1);
      }else{
        echo '操作失败';
      }
   }
   //删除
   public function removeRefresh(){
      $login_name=trim(getLoginName());
      if($login_name==''){
        echo '{"status":"400","message":"please login"}';return;
      }
      $rid=trim(I('post.rid'));
      if($rid==''){
        echo '{"status":"400","message":"数据异常"}';return;
      }
      $handleLogic=new \Logic\ServiceRefreshLogic();
      $result=$handleLogic->deleteRefreshCondition($rid,$login_name);
      if($result){
        echo '{"status":"200","message":"操作成功"}';
      }else{
        echo '{"status":"400","message":"操作失败"}';
      }
   }

   /*配置服务-刷新房源 end */

}
?>
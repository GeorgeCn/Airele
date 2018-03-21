<?php
namespace Home\Controller;
use Think\Controller;
class AccountController extends Controller {
  //账户管理
  public function accountList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
      $handleMenu->jurisdiction();
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
     $handleAccount = new \Logic\Account();
     $staticid=I('get.staticid');
     $username=I('get.username');
      if($staticid!=""){
         $where['record_status']=array('eq',$staticid);
       }
      if($username!=""){
        $where['user_name']=array('eq',$username);
      }
     $list=$handleAccount->getAccountList($where);
     $this->assign("list",$list);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
  }
  //更新账户状态
  public function upAccountStatus(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $uid=I('get.uid');
      $handleAccount = new \Logic\Account();
      $condition['id']=$uid;
      $resultarr=$handleAccount->getAccount($condition);
       if($resultarr['record_status']==1){
          $resultarr['record_status']=0;
       }else{
          $resultarr['record_status']=1;
       }
        $result=$handleAccount->upPassword($resultarr);
        if($result){
          $this->success('更新成功！',U('Account/accountList'),0);
        }else{
          $this->success('更新失败！',U('Account/accountList'),0);
        }
  }

  public function upPasswordPage(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
     $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
     $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
  }
  //修改密码
  public function upPassword(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $user_name=$_POST['user_name'];
      $oldpwd=$_POST['oldpwd'];
      $newpwd=$_POST['newpwd'];
      $newpwds=$_POST['newpwds'];
      $usertype=$_POST['usertype'];
      $handleAccount = new \Logic\Account();
      $where['user_name']=$user_name;
      $userarr=$handleAccount->getAccount($where);
      if($userarr){
          if($usertype=="admin"){
              if($newpwd!=$newpwds){
                $this->success('两次输入新密码不一致！',U('Account/upPasswordPage'),0);
              }else{
                $userarr['user_pwd']=md5($newpwds);
                $userarr['update_time']=time();
                $result=$handleAccount->upPassword($userarr);
                if($result){
                  $this->success('密码修改成功！',U('Account/upPasswordPage'),0);
                }else{
                  $this->success('密码修改失败！',U('Account/upPasswordPage'),0);
                 }

              }
          }else{
             if($userarr['user_pwd']!=md5($oldpwd)){
                $this->success('原密码不正确！',U('Account/upPasswordPage'),0);
             }elseif($newpwd!=$newpwds){
                $this->success('两次输入新密码不一致！',U('Account/upPasswordPage'),0);
             }else{
               $userarr['user_pwd']=md5($newpwds);
               $userarr['update_time']=time();
               $result=$handleAccount->upPassword($userarr);
               if($result){
                  $this->success('密码修改成功！',U('Account/upPasswordPage'),0);
               }else{
                  $this->success('密码修改失败！',U('Account/upPasswordPage'),0);
               }
             }

        }
      }else{
         $this->success('该账号不存在！',U('Account/upPasswordPage'),0);
      }
  }
 //新增账户
  public function addAccountAuth(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
    $handleMenu = new \Logic\AdminMenuListLimit();
    $handleAdminCity = new \Logic\AdminCityLogin();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
    $where['record_status']=1;
    $admincity=$handleAdminCity->modelGet($where);
    $this->assign("admincity",$admincity);
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $this->display();
  }
  //修改账号
  public function upAccountAuth(){
     $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
    $handleMenu = new\Logic\AdminMenuListLimit();
    $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
    $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
    $where['id']=$_GET['upid'];
    $handleAccount = new \Logic\Account();
    $handleAdminCity = new \Logic\AdminCityLogin();
    $result=$handleAccount->getAccount($where);
    $wherecity['record_status']=1;
    $admincity=$handleAdminCity->modelGet($wherecity);
    $this->assign("admincity",$admincity);
    $this->assign("user",$result);
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $this->display();
  }
   //加载菜单配置
  public function loadMenuParameter(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
     $cookiename=cookie("admin_user_name");
     $handleAccount = new \Logic\Account();
     $handleAdminLogin = new \Logic\AdminLogin();
     $where['record_status']=1;
     $result=$handleAccount->getMenuId($where);
     //$whereuser['id']=I('get.uid');
     //$adminuser=$handleAdminLogin->modelAdminFind($whereuser);
     $menuwhere['user_name']=cookie("admin_user_name");
     $menuwhere['city_auth']=I('get.cityno');
     $menuarr=$handleAccount->getSysmenuMenu($menuwhere);
     foreach($menuarr as $key2 => $value2) {
          $menulimit[]=$value2['menu_id'];
     }
     $sysmanagement="";//系统管理
     $parmanagement="";//参数管理
     $housemanagement="";//房源管理
     $ordermanagement="";//订单管理
     $contractmanagement="";//合同管理
     $usermanagement="";//用户管理
     $finmanagement="";//财务管理
     $couponmanage="";//优惠券管理
     $makemanage="";//预约管理
     $commission="";//佣金管理
     $tools="";//工具
     $store="";//店铺
     foreach ($result as $key => $value) {
        switch ($value['parent_id']){
          case 1:
            if($value['parent_id']==1){
              if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $sysmanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
               }
             }
               $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               //print_r($result1);die;
               foreach ($result1 as $key1 => $value1){
                 if($value1['id']==20){
                   if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                     $sysmanagement.='<label><input type="checkbox" name="public_check[]" checked="checked"  value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                   }
                 }else{
                  if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                     $sysmanagement.='<label><input type="checkbox" name="public_check[]"  value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                   }
                 }
               }
            if($value['parent_id']==1){
               $sysmanagement.='</td></tr>';
            }
            break;
          case 2:
             if($value['parent_id']==2){
              if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $parmanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
            }
             $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $parmanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==2){
               $parmanagement.='</td></tr>';
            }
            break;
          case 3:
           if($value['parent_id']==3){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $housemanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
             }
            }
             $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                  if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                    $housemanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                  }
               }
            if($value['parent_id']==3){
               $housemanagement.='</td></tr>';
            }
            break;
          case 4:
            if($value['parent_id']==4){
              if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $ordermanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
            }
               $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                    $ordermanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                  }
               }
            if($value['parent_id']==4){
               $ordermanagement.='</td></tr>';
            }
            break;
          case 5:
            if($value['parent_id']==5){
              if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                 $contractmanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
               }
             }
             $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $contractmanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
              }
            if($value['parent_id']==5){
               $contractmanagement.='</td></tr>';
            }
            break;
          case 6:
           if($value['parent_id']==6){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
              $usermanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
             }
           }
               $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                  if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $usermanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                  }
               }
              
            if($value['parent_id']==6){
               $usermanagement.='</td></tr>';
            }
            break;
          case 7:
           if($value['parent_id']==7){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
              $finmanagement.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
             }
           }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                  if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $finmanagement.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                  }
               }
            if($value['parent_id']==7){
               $finmanagement.='</td></tr>';
            }
            break;
         case 47:
           if($value['parent_id']==47){
              if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
              $circlemanage.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
           }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $circlemanage.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==47){
               $circlemanage.='</td></tr>';
            }
            break;
             case 77:
           if($value['parent_id']==77){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $couponmanage.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
            }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $couponmanage.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==77){
               $couponmanage.='</td></tr>';
            }
            break;
          case 87:
           if($value['parent_id']==87){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $makemanage.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
            }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $makemanage.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==87){
               $makemanage.='</td></tr>';
            }
            break;
           case 107:
           if($value['parent_id']==107){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $commission.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
            }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1) {
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $commission.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==107){
               $commission.='</td></tr>';
            }
            break;
           case 141:
           if($value['parent_id']==141){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $tools.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
             }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1){
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $tools.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==141){
               $tools.='</td></tr>';
            }
            break;
             case 162:
           if($value['parent_id']==162){
             if(in_array($value['id'],$menulimit)||$cookiename=="admin"){
                $store.='<tr><td class="twolevel"><label><input type="checkbox" class="checknone" name="public_check[]" value="'.$value["id"].'">'.$value["name"].'</label></td><td>';
              }
             }
              $where['parent_id']=$value['id'];
               $result1=$handleAccount->getMenuId($where);
               foreach ($result1 as $key1 => $value1){
                 if(in_array($value1['id'],$menulimit)||$cookiename=="admin"){
                   $store.='<label><input type="checkbox" name="public_check[]" value="'.$value1["id"].'">'.$value1["name"].'</label>&nbsp;&nbsp;';
                 }
               }
            if($value['parent_id']==162){
               $store.='</td></tr>';
            }
            break;
          default:
            break;
        }
      }
      $this->assign("sysmanagement",$sysmanagement);
      $this->assign("parmanagement",$parmanagement);
      $this->assign("housemanagement",$housemanagement);
      $this->assign("ordermanagement",$ordermanagement);
      $this->assign("contractmanagement",$contractmanagement);
      $this->assign("usermanagement",$usermanagement);
      $this->assign("finmanagement",$finmanagement);
      $this->assign("circlemanage",$circlemanage);
      $this->assign("couponmanage",$couponmanage);
      $this->assign("makemanage",$makemanage);
      $this->assign("commission",$commission);
      $this->assign("tools",$tools);
      $this->assign("store",$store);
  }
  //添加账户
  public function subAccount(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }

      $admincity=$_POST['admincity'];
           $arrcount=count($admincity);
           for($i=0;$i<$arrcount;$i++){
              $admincityStr.=$admincity[$i].",";

           }
     $user['id']=create_guid();
     $user['user_name']=$_POST['user_name'];
     $user['staffid']=$_POST['staffid'];
     $user['real_name']=$_POST['real_name'];
     $user['mobile']=$_POST['mobile'];
     $user['department']=$_POST['department'];
     $user['user_pwd']=md5($_POST['pwd']);
     $user['create_time']=time();
     $user['record_status']=1;
     $user['city_auth']=substr($admincityStr,0,-1);
     $user['email']=I('post.email');
     $handleAccount = new \Logic\Account();
     $where['user_name']=$user['user_name'];
     $user_result=$handleAccount->getAccount($where);
     if($user_result){
           $this->success('该用户名已存在！','addAccountAuth.html?no=1&leftno=19'); 
     }else{
         $result=$handleAccount->AddUser($user);
         if($result){
              //运营兼职默认权限
            if(I('post.department')=="运营兼职"){
               for($k=0;$k<$arrcount;$k++){
                   $public_check=array(0=>'3',1=>'26',2=>'27',3=>'44',4=>'81');
                   foreach($public_check as $key => $value){
                      $menuwhere['id']=$value;
                      $result1=$handleAccount->getMenuIdFind($menuwhere);
                      if($result1){
                         $data['id']=create_guid();
                         $data['user_name']=I('post.user_name');
                         $data['menu_id']=$result1['id'];
                         $data['parent_id']=$result1['parent_id'];
                         $data['menu_name']=$result1['name'];
                         $data['menu_url']=$result1['url'];
                         $data['create_time']=time();
                         $data['record_status']=1;
                         $data['index_no']=$result1['index_no'];
                         $data['city_auth']=$admincity[$k];
                         $addresult=$handleAccount->addSysmenuMenu($data);
                     }
                  }
               }
             }
             $this->success('用户添加成功！','accountList.html?no=1&leftno=19'); 
         }else{
             $this->success('用户添加失败！','addAccountAuth.html?no=1&leftno=19'); 
        }
     }
   }
  //修改账户后提交
  public function upSubAccount(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }

     $handleAccount = new \Logic\Account();
     $handleAdminMenuListLimit = new \Logic\AdminMenuListLimit();
     $handleAdminCity = new \Logic\AdminCityLogin();
     $where['id']=I('post.user_id');
     $userarr=$handleAccount->getAccount($where);
     $admincity=$_POST['admincity'];
      $arrcount=count($admincity);
        for($i=0;$i<$arrcount;$i++){
           $admincityStr.=$admincity[$i].",";
        }
     $user['id']=$_POST['user_id']; 
     $user['user_name']=$_POST['user_name'];   
     $user['staffid']=$_POST['staffid'];
     $user['real_name']=$_POST['real_name'];
     $user['mobile']=$_POST['mobile'];
     $user['department']=$_POST['department'];
     $user['update_time']=time();
     $user['city_auth']=substr($admincityStr,0,-1);
     $user['email']=I('post.email');
     //密码做了更改
     if(I('post.pwd')!=""){
        $user['user_pwd']=md5(I('post.pwd'));
     }
     //部门做了修改
     if($userarr['department']!=trim(I('post.department'))){
        $wherede['user_name']=I('post.user_name');
        $handleAdminMenuListLimit->modelDelete($wherede);
     }
     $this->admincityauth($_POST['user_name'],$userarr['city_auth'],$user['city_auth']); //城市做了修改
     $result=$handleAccount->upUser($user);   
     if($result){
            //运营兼职默认权限
            if(I('post.department')=="运营兼职"){
               for($k=0;$k<$arrcount;$k++){
                   $public_check=array(0=>'3',1=>'26',2=>'27',3=>'44',4=>'81');
                   foreach($public_check as $key => $value){
                      $menuwhere['id']=$value;
                      $result1=$handleAccount->getMenuIdFind($menuwhere);
                      if($result1){
                         $data['id']=create_guid();
                         $data['user_name']=I('post.user_name');
                         $data['menu_id']=$result1['id'];
                         $data['parent_id']=$result1['parent_id'];
                         $data['menu_name']=$result1['name'];
                         $data['menu_url']=$result1['url'];
                         $data['create_time']=time();
                         $data['record_status']=1;
                         $data['index_no']=$result1['index_no'];
                         $data['city_auth']=$admincity[$k];
                         $menuwhere1['user_name']=I('post.user_name');
                         $menuwhere1['menu_id']=$result1['id'];
                         $menuwhere1['city_auth']=$admincity[$k];
                         $menuarr=$handleAccount->getSysmenuMenu($menuwhere1);
                         if(!$menuarr){
                            $addresult=$handleAccount->addSysmenuMenu($data);
                         }
                     }
                  }
               }
             }
              $this->success('修改成功！','upAccountAuth.html?no=1&leftno=79&upid='.$user['id']); 
       }else{
            $this->success('修改失败！','upAccountAuth.html?no=1&leftno=79&upid='.$user['id']); 
      }
  }


  //修改账户
  public function upaccountList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
      $handleMenu->jurisdiction();
     $handleAccount = new \Logic\Account();
     $staticid=I('get.staticid');
     $username=I('get.username');
     $cityno=I('get.cityno');
     $where['record_status']=1;
      if($staticid!=""){
          $where['record_status']=array('eq',$staticid);
       }
      if($username!=""){
         $where['user_name']=array('eq',$username);
      }
      if($cityno!=""){
          $where['city_auth']=array('like','%'.$cityno.'%');
      }
      if(count($switchcity)<2){
         if($switchcity[0]['city_no']==1){
            $where['city_auth']=array('like','%1%');
         }elseif($switchcity[0]['city_no']==2){
            $where['city_auth']=array('like','%2%');
         }elseif($switchcity[0]['city_no']==3){
            $where['city_auth']=array('like','%3%');
         }elseif($switchcity[0]['city_no']==4){
            $where['city_auth']=array('like','%4%');
         }elseif($switchcity[0]['city_no']==5){
            $where['city_auth']=array('like','%5%');
         }elseif($switchcity[0]['city_no']==6){
            $where['city_auth']=array('like','%6%');
         }
      }
     $list=$handleAccount->getAccountList($where);
     $this->assign("list",$list);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
  }
  //修改权限
  public function upprivilege(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
     if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
      $handleMenu->jurisdiction();
     $handleAccount = new \Logic\Account();
     $staticid=I('get.staticid');
     $username=I('get.username');
     $where['record_status']=1;
      if($staticid!=""){
         $where['record_status']=array('eq',$staticid);
       }
      if($username!=""){
        $where['user_name']=array('eq',$username);
      }
     $list=$handleAccount->getAccountList($where);
     $this->assign("list",$list);
     $this->assign("menutophtml",$menu_top_html);
     $this->assign("menulefthtml",$menu_left_html);
     $this->display();
  }
  public function authoritytemp(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
      }

      if(I('get.cityno')==""){
          $this->error('请添加权限城市','upprivilege.html?no=1&leftno=80');
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new\Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"1");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"1");
      $where['id']=I('get.uid');
      $handleAccount = new \Logic\Account();
      $handleAdminCity = new \Logic\AdminCityLogin();
      $result=$handleAccount->getAccount($where);
      $menuwhere['user_name']=$result['user_name'];
      $menuwhere['city_auth']=I('get.cityno');
      $menuarr=$handleAccount->getSysmenuMenu($menuwhere);
      $city_auth=explode(',',$result['city_auth']);
      for($i=0;$i<count($city_auth);$i++){
          $value['city_no']=$city_auth[$i];
          $admincity[]=$value;
      }
       foreach ($menuarr as $key => $value) {
           $muenlist[]=$value['menu_id'];
      
       }
      $czwhere['user_name']=cookie("admin_user_name");
      $czwhere['city_auth']=I('get.cityno');
      $czmenuarr=$handleAccount->getSysmenuMenu($czwhere);
      foreach ($czmenuarr as $key1 => $value1) {
           if($value1['menu_id']==1){
                $this->assign("tablesystem",1);
            }elseif($value1['menu_id']==2){
                $this->assign("tablepar",2);
            }elseif($value1['menu_id']==3){
                $this->assign("tablehouse",3);
            }elseif($value1['menu_id']==4){
                $this->assign("tableorder",4);
            }elseif($value1['menu_id']==6){
                $this->assign("tableuser",6);
            }elseif($value1['menu_id']==7){
                $this->assign("tablefin",7);
            }elseif($value1['menu_id']==47){
                $this->assign("tablecircle",47);
            }elseif($value1['menu_id']==77){
                $this->assign("tablecoupon",77);
            }elseif($value1['menu_id']==87){
                $this->assign("tablemake",87);
            }elseif($value1['menu_id']==107){
                $this->assign("tablecommission",107);
            }elseif($value1['menu_id']==141){
                $this->assign("tools",141);
            }elseif($value1['menu_id']==162){
                $this->assign("store",162);
            }
      }
      $menustr=implode(',',$muenlist);
      $this->loadMenuParameter();
      $this->assign("admincity",$admincity);
      $this->assign("menustr",$menustr);
      $this->assign("user",$result);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();
  }

   //权限修改提交
   public function subauthority(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
              $this->error('非法操作',U('Index/index'),1);
        }
       $handleAccount = new \Logic\Account();
       $cityno=I('post.cityno');
       $uid=I('post.user_id');
       if(isset($_POST['public_check'])){
         $public_check=$_POST['public_check'];
       }

      //获取登录用户的权限
       $menuwhere1['user_name']=cookie("admin_user_name");
       $menuwhere1['city_auth']=$cityno;
       $menuarr=$handleAccount->getSysmenuMenu($menuwhere1);
       foreach ($menuarr as $key1 => $value1){
          $delmenu['user_name']=I('post.user_name');
          $delmenu['city_auth']=$cityno;
          $delmenu['menu_id']=$value1['menu_id'];
          $handleAccount->delSysMenu($delmenu);
       }
       // $delmenu['user_name']=I('post.user_name');
       // $delmenu['city_auth']=$cityno;
       // $result=$handleAccount->delSysMenu($delmenu);
         foreach($public_check as $key => $value){
             $menuwhere['id']=$value;
             $result1=$handleAccount->getMenuIdFind($menuwhere);
             $city_prex=C('CITY_PREX');
              del_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit'.I('post.user_name').$result1['parent_id']);
              del_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_username'.I('post.user_name').$result1['parent_id']);
              del_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_private'.I('post.user_name'));
             if($result1){
               $data['id']=create_guid();
               $data['user_name']=I('post.user_name');
               $data['menu_id']=$result1['id'];
               $data['parent_id']=$result1['parent_id'];
               $data['menu_name']=$result1['name'];
               $data['menu_url']=$result1['url'];
               $data['create_time']=time();
               $data['record_status']=1;
               $data['index_no']=$result1['index_no'];
               $data['city_auth']=$cityno;
               $addresult=$handleAccount->addSysmenuMenu($data);
            }
         }
         if($addresult){
              $this->success('修改成功！','authoritytemp.html?no=1&leftno=80&uid='.$uid.'&cityno='.$cityno);  
         }else{
            $this->success('修改失败！','authoritytemp.html?no=1&leftno=80&uid='.$uid.'&cityno='.$cityno); 
        }
  }

  //处理城市修改对权限的修改
  public function admincityauth($user_name,$user_city,$post_city){
       $handleAdminMenuListLimit = new \Logic\AdminMenuListLimit();
       $userarr=explode(',',$user_city);
        for($i=0;$i<count($userarr);$i++){
            if(strpos($post_city,$userarr[$i])===false){
              $where['user_name']=$user_name;
              $where['city_auth']=$userarr[$i];
              $handleAdminMenuListLimit->modelDelete($where);
            }
      }
  }

}
?> 
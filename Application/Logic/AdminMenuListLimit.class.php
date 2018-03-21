<?php
namespace Logic;
class AdminMenuListLimit {
	
    /*根据设备ID返回一个数组*/
    public function modelGet($id)
    {
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->modelGet($id);
        return $result;
    }

    /*添加对象*/
    public function addModel($modelArray)
    {
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->addModel($modelArray);
        return $result;
    }
    /*更新对象*/
    public function updateModel($modelArray)
    { 
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->addModel($modelArray);
        return $result;
    }
    
    /*获取所有数组*/
    public function modelList($username,$parent_id)
    {
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->modelList($username,$parent_id);
        return $result;
    }

    /*通过USERNAME删除*/
    public function modelDeleteByUserName($username)
    {
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->modelDeleteByUserName($username);
        return $result;
    }
    //获取该账号的权限
    public function modelMenuList($where){
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->modelMenuList($where);
        return $result;
    }
    //条件删除
    public function modelDelete($where){
        $modelDal=new \Home\Model\adminmenulistlimit();
        $result=$modelDal->modelDelete($where);
        return $result;
    }
    /*************************扩展方法*************************/
     public function modelListByCache($username,$parent_id)
     {
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit'.$username.$parent_id);
        if(empty($result))
        { 
            $result=$this->modelList($username,$parent_id);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit'.$username.$parent_id,$result,3600);
        }
        return $result;
     }
     /*huancun*/
     public function modelListWithUserNameByCache($username,$parent_id)
     {
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_username'.$username.$parent_id);
        if(empty($result))
        { 
            $result=$this->modelList($username,$parent_id);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_username'.$username.$parent_id,$result,3600);
        }
            
        return $result;
     }

      public function modelMenuListByCache($where)
     {
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_private'.$where['user_name']);
        if(empty($result))
        { 
            $result=$this->modelMenuList($where);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'menu_list_limit_private'.$where['user_name'],$result,3600);
        }
        return $result;
     }
     


    /*************************逻辑处理部分*************************/
    /*头部菜单*/
    /*1=系统管理,2=参数管理,3=房源管理,4=订单管理,5=合同管理,6=用户管理,7=财务管理*/
    public function menuTop($username,$selectNo)
    {
        $result="";
        if($username=='admin')
        {
            $handleMenu = new\Logic\AdminMenuList();
            $result=$handleMenu->menuTop($selectNo);
        }
        else
        {
            $result=$this->getCustomerTop($username,$selectNo);
        }
        
        return $result;
    }

    public function getCustomerTop($username,$selectNo)
    {
        $result="";
        $toplist=$this->modelListWithUserNameByCache($username,0);

        if($toplist!=null&&$toplist!=false)
        {
            foreach($toplist as $key=>$val) 
            {
                $menu_no=$val["menu_id"];
                $url_str=$val["menu_url"];
                $name_str=$val["menu_name"];
                $index_no=stripos($url_str,'javascript');
                $classstr="";
                if($selectNo==$menu_no)
                {
                    $classstr='class="cur"';
                }

                if($index_no>-1)
                {
                     $result=$result.'<li '.$classstr.'><a href="javascript:;">'.$name_str.'</a></li>';
                }
                else
                {   if(cookie("admin_user_name")=="jishibang"){
                     $result=$result.'<li '.$classstr.'><a href="/admin/Service/awaitlist.html?no=4&amp;leftno=73">订单管理</a></li>';
                       
                    }else{
                         $url_str=__ROOT__."/".$url_str."?no=".$menu_no;
                        $result=$result.'<li '.$classstr.'><a href="'.$url_str.'">'.$name_str.'</a></li>';
                    }
                }
            }
        }

        return $result;
    }



    /*左侧菜单*/
    public function menuLeft($userNo,$topNo)
    { 
        $result="";
        if($userNo=='admin')
        {
            $handleMenu = new\Logic\AdminMenuList();
            $result=$handleMenu->menuLeft($topNo);
        }
        else
        { 
            $result=$this->getCustomerLeft($userNo,$topNo);
        }
        return $result;
    }

    public function getCustomerLeft($userNo,$topNo)
    {
         $result="";

        $firstlist=$this->modelListByCache($userNo,$topNo);
        if($firstlist!=null&&$firstlist!=false)
        {   
            $int_i=0;
            foreach($firstlist as $key=>$val) 
            {
                $menu_no=$val["menu_id"];
                $url_str=$val["menu_url"];
                $name_str=$val["menu_name"];
                $index_no=stripos($url_str,'javascript');
                $classstr="";
                if($int_i==0)
                {
                    $result=$result.'<div class="subNav currentDd currentDt">'.$name_str.'</div>';
                }else
                {
                    $result=$result.'<div class="subNav ">'.$name_str.'</div>';
                }

                $result=$result.$this->menuLeftNext($int_i,$menu_no,$userNo,$topNo);
                $int_i++;
            }
        }
        return $result;
    }

    /*子菜单*/
    public function menuLeftNext($indexNo,$parentId,$userNo,$topNo)
    {
        $result="";
        
        $firstlist=$this->modelListByCache($userNo,$parentId);
        if($firstlist!=null&&$firstlist!=false)
        {   
            $int_i=0;
            if($indexNo==0&&$int_i==0)
            {    
                $result=$result.'<ul class="navContent " style="display:block">';
            }
            else
            {
                $result=$result.'<ul class="navContent ">';
            }
            foreach($firstlist as $key=>$val) 
            {
                $menu_no=$val["menu_id"];
                $url_str=$val["menu_url"];
                $name_str=$val["menu_name"];
                $index_no=stripos($url_str,'javascript');
                $classstr="";

                if($indexNo==0&&$int_i==0)
                {
                    $classstr='class="show"';
                }
                if($index_no>-1)
                {
                     $result=$result.'<li ref="'.$menu_no.'" '.$classstr.'><a href="javascript:;">'.$name_str.'</a></li>';
                }
                else
                {
                     $url_str=__ROOT__."/".$url_str."?no=".$topNo."&leftno=".$menu_no;
                     $result=$result.'<li ref="'.$menu_no.'" '.$classstr.'><a href="'.$url_str.'">'.$name_str.'</a></li>';
                }

                $int_i++;
            }
            $result=$result.'</ul>';
        }

        return $result;

    }
   
   public function jurisdiction(){
       if(cookie("admin_user_name")!=""){
           $where['city_auth']=C('CITY_NO');
           $where['user_name']=cookie("admin_user_name");
           $menuarr=$this->modelMenuListByCache($where);
       }
       $sysurl=CONTROLLER_NAME.'/'.ACTION_NAME.'.html';
       $geturl=strtolower($sysurl);
       foreach ($menuarr as $key => $value) {
              $allmenu[]=strtolower($value['menu_url']);
       }

       if(cookie("admin_user_name")!="admin"){
           if($geturl!="welcome/welcome.html"){
              if(cookie("admin_user_name")=="jishibang"&&$geturl=="orders/audithouseorders.html"){
                  $url="http://".$_SERVER['HTTP_HOST']."/gaoduadmin/Index/outlogin.html";
                  header("Location: ".$url); 
                }
               if(!in_array($geturl,$allmenu)){
                  $url="http://".$_SERVER['HTTP_HOST']."/gaoduadmin/Index/outlogin.html";
                  header("Location: ".$url); 
               }
          }
      }
   }
}
?>
<?php
namespace Logic;
class AdminMenuList {
	
    /*根据设备ID返回一个数组*/
    public function modelGet($id)
    {
        $modelDal=new \Home\Model\adminmenulist();
        $result=$modelDal->modelGet($id);
        return $result;
    }

    /*添加对象*/
    public function addModel($modelArray)
    {
        $modelDal=new \Home\Model\adminmenulist();
        $result=$modelDal->addModel($modelArray);
        return $result;
    }
    /*更新对象*/
    public function updateModel($modelArray)
    { 
        $modelDal=new \Home\Model\adminmenulist();
        $result=$modelDal->addModel($modelArray);
        return $result;
    }
    
    /*获取所有数组*/
    public function modelList($parent_id)
    {
         $modelDal=new \Home\Model\adminmenulist();
        $result=$modelDal->modelList($parent_id);
        return $result;
    }

    /*************************扩展方法*************************/
     public function modelListByCache($parent_id)
     {
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'admin_menu_list'.$parent_id);
        if(empty($result))
        { 
            $result=$this->modelList($parent_id);
            set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'admin_menu_list'.$parent_id,$result,3600);
        }
        return $result;
     }
     
    /*************************逻辑处理部分*************************/
    /*头部菜单*/
    /*1=系统管理,2=参数管理,3=房源管理,4=订单管理,5=合同管理,6=用户管理,7=财务管理*/
    public function menuTop($selectNo)
    {
        $result="";
        $toplist=$this->modelListByCache(0);
        if($toplist!=null&&$toplist!=false)
        {   
            foreach($toplist as $key=>$val) 
            {
                $menu_no=$val["id"];
                $url_str=$val["url"];
                $name_str=$val["name"];
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
                {
                     $url_str=__ROOT__."/".$url_str."?no=".$menu_no;
                     $result=$result.'<li '.$classstr.'><a href="'.$url_str.'">'.$name_str.'</a></li>';
                }
               
            }
        }
        return $result;
    }

   /*左侧菜单*/
    public function menuLeft($topNo)
    {
        $result="";
        $firstlist=$this->modelListByCache($topNo);
        if($firstlist!=null&&$firstlist!=false)
        {   
            $int_i=0;
            foreach($firstlist as $key=>$val)
            {
                $menu_no=$val["id"];
                $url_str=$val["url"];
                $name_str=$val["name"];
                $index_no=stripos($url_str,'javascript');
                $classstr="";
                if($int_i==0)
                {
                    $result=$result.'<div class="subNav currentDd currentDt">'.$name_str.'</div>';
                }else
                {
                    $result=$result.'<div class="subNav ">'.$name_str.'</div>';
                }

                $result=$result.$this->menuLeftNext($int_i,$menu_no,$topNo);
                $int_i++;
            }
        }

        return $result;
    }

    /*子菜单*/
    public function menuLeftNext($indexNo,$parentId,$topNo)
    {
        $result="";
        
        $firstlist=$this->modelListByCache($parentId);
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
                $menu_no=$val["id"];
                $url_str=$val["url"];
                $name_str=$val["name"];
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




}
?>
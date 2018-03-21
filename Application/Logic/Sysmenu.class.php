<?php
namespace Logic;
use Think\Controller;
class Sysmenu extends Controller{
	//区域板块列表
	 public function getSysmenuMenuList($region_id){
    	$modelDal=new \Home\Model\sysmenu();
    	$result=$modelDal->modelSysmenuMenuList($region_id);
    	return $result;
    }
    public function getSysmenuMenu($where){
    	$modelDal=new \Home\Model\sysmenu();
    	$result=$modelDal->modelSysmenuMenu($where);
    	return $result;
    }
    //添加菜单
    public function addSysmenu($data){
    	$modelDal=new \Home\Model\sysmenu();
    	$result=$modelDal->modelAddSysmenuMenu($data);
    	return $result;
    }
    //删除菜单
    public function delSysmenuMenu($where){
    	$modelDal=new \Home\Model\sysmenu();
    	$result=$modelDal->modeldelSysmenuMenu($where);
    	return $result;
    }
    //修改菜单
    public function upSysmenuMenu($data){
    	$modelDal=new \Home\Model\sysmenu();
    	$result=$modelDal->modelUpSysmenuMenu($data);
    	return $result;
    }

    public function getPreviousMenu($mid){
        $modelDal=new \Home\Model\sysmenu();
        $result=$modelDal->modelPreviousMenu($mid);
        return $result;
    }

    public function getCacheSysmenuList($region_id){
        $city_prex=C('CITY_PREX');
        $result=get_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'cache_sysmenu_list'.$region_id);
        if(empty($result)){ 
           $result=$this->getSysmenuMenuList($region_id);
           set_cache_admin(C('COUCHBASE_BUCKET_ADMIN'),$city_prex.'cache_sysmenu_list'.$region_id,$result,7000);
        }
        return $result;
    }
}
?>
<?php
namespace Logic;
use Think\Controller;
class Account{
    //获取账户
    public function getAccountList($where){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelAccountList($where);
        return $result;
    }

    public function getAccount($where){
    	$modelDal=new \Home\Model\account();
    	$result=$modelDal->modelAccount($where);
    	return $result;
    }
    //增加用户
    public function AddUser($data){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelAddUser($data);
        return $result;
    }
    //修改密码
    public function upPassword($data){
    	$modelDal=new \Home\Model\account();
    	$result=$modelDal->modelUpPassword($data);
    	return $result;
    }
    //获取菜单
    public function getMenuId($where){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelMenuId($where);
        return $result;
    }
    public function getMenuIdFind($where){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelMenuIdFind($where);
        return $result;
    }
    //新增用户权限
    public function addSysmenuMenu($data){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelAddSysmenuMenu($data);
        return $result;
    }
    //获取权限
    public function getSysmenuMenu($where){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelGetSysmenuMenu($where);
        return $result;
    }
     //删除用户权限
    public function delSysMenu($where){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modeldelSysMenu($where);
        return $result;
    }
    //修改账户
     public function upUser($data){
        $modelDal=new \Home\Model\account();
        $result=$modelDal->modelUpUser($data);
        return $result;
    }

}
?>
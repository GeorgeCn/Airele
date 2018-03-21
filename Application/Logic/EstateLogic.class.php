<?php
namespace Logic;
use Think\Controller;
class EstateLogic extends Controller{
    //统计总条数
	 public function getEstatePageCount($where){
    	$modelDal=new \Home\Model\estate();
    	$result=$modelDal->modelEstatePageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getEstateDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\estate();
        $result=$modelDal->modelEstateDataList($firstrow,$listrows,$where);
        return $result;     
    }
    public function getEstateFind($where){
        $modelDal=new \Home\Model\estate();
        $result=$modelDal->modelGetEstateFind($where);
        return $result;
    }

    public function getEstateByKey($keyword){
        $modelDal=new \Home\Model\estate();
        $result=$modelDal->modeEstateByKey($keyword);
        return $result; 
    }
    public function modelAdd($keyword){
        $modelDal=new \Home\Model\estate();
        $result=$modelDal->modelAdd($keyword);
        return $result; 
    }
    public function getModelById($id){
        $modelDal=new \Home\Model\estate();
        return $modelDal->getModelById($id);
    }
   public function updateModel($data){
      $modelDal=new \Home\Model\estate();
      return $modelDal->updateModel($data);
   }
   //获取区域、板块的名称
   public function getRegionScopeName($regionId,$scopeId){
      $modelDal=new \Home\Model\estate();
      return $modelDal->getRegionScopeName($regionId,$scopeId);
   }
    //更新房源信息（小区，区域、板块）
   public function updateHouseEstateInfo($houseModel){
      $modelDal=new \Home\Model\estate();
      return $modelDal->updateHouseEstateInfo($houseModel);
   }

   /*小区映射表操作 */
   public function getEstatemapListCount($condition){
      $modelDal=new \Home\Model\estatemap();
      $where=$this->convertEstatemapCondition($condition);
      return $modelDal->getModelListCount($where);   
   }
   private function convertEstatemapCondition($condition){
      $whereStr=" and city_id='".C('CITY_CODE')."' ";
      if(isset($condition['third_name']) && $condition['third_name']!=''){
        $whereStr.=" and third_name='".$condition['third_name']."'";
      }
      if(isset($condition['estatename']) && $condition['estatename']!=''){
        $whereStr.=" and estate_name_third like '".$condition['estatename']."%'";
      }
      if(isset($condition['type'])){
        if($condition['type']==1){
           $whereStr.=" and estate_id=''";
        }else if ($condition['type'] == 2) {
          $whereStr.=" and estate_id<>''";
        } 
      }
      if(isset($condition['region_third']) && $condition['region_third']!=''){
        $whereStr.=" and region_third like '".$condition['region_third']."%'";
      }
      return $whereStr;
   }
   public function getEstatemapList($condition,$limit_start,$limit_end){
      $modelDal=new \Home\Model\estatemap();
       $where=$this->convertEstatemapCondition($condition); 
      return $modelDal->getModelList($limit_start,$limit_end,$where);   
    }
   public function getEstatemapById($id){
      $modelDal=new \Home\Model\estatemap();
      return $modelDal->getModelById($id);
   }
   public function addEstatemap($data){
      $modelDal=new \Home\Model\estatemap();
      return $modelDal->addModel($data);
   }
   public function updateEstatemap($data){
      $modelDal=new \Home\Model\estatemap();
      return $modelDal->updateModel($data);
   }
  public function deleteEstatemap($id){
      $modelDal=new \Home\Model\estatemap();
      $id=str_replace('or ', '', strtolower($id));
      return $modelDal->deleteModel($id);
   }
   public function modelcodemaxfind($where){
        $modelDal=new \Home\Model\estate();
      return $result=$modelDal->modelcodemaxfind($where);
   }
   //合并楼盘处理
   public function mergeEstate($estate_id,$estate_ids){
      if(empty($estate_id) || !is_array($estate_ids)){
         return false;
      }
      $estateDal=new \Home\Model\estate();
      $estateModel=$estateDal->getModelById($estate_id);
      if($estateModel==null || $estateModel==false){
         return false;
      }
      $selectDal=new \Home\Model\houseselect();
       $estatemapDal=new \Home\Model\estatemap();
      $delete_count=0;

      foreach ($estate_ids as $key => $value) {
        if(empty($value) || $estate_id==$value){
          continue;
        }
        //更新房源表
        $houseModel['estate_id']=$estateModel['id'];
        $houseModel['estate_name']=$estateModel['estate_name'];
        $houseModel['region_id']=$estateModel['region'];
        $houseModel['scope_id']=$estateModel['scope'];
        $houseModel['region_name']=$estateModel['region_name'];
        $houseModel['scope_name']=$estateModel['scope_name'];
        $houseModel['business_type']=$estateModel['business_type'];
        $result=$estateDal->updateHouseResource($houseModel,"estate_id='$value'");
        //更新查询表
        $selectModel['estate_id']=$estateModel['id'];
        $selectModel['estate_name']=$estateModel['estate_name'];
        $selectModel['estate_address']=$estateModel['estate_address'];
        $selectModel['estate_full_py']=$estateModel['full_py'];
        $selectModel['estate_first_py']=$estateModel['first_py'];
        $selectModel['estate_lpt_x']=$estateModel['lpt_x'];
        $selectModel['estate_lpt_y']=$estateModel['lpt_y'];
        $selectModel['region_id']=$estateModel['region'];
        $selectModel['region_name']=$estateModel['region_name'];
        $selectModel['scope_id']=$estateModel['scope'];
        $selectModel['scope_name']=$estateModel['scope_name'];
        $selectDal->updateModelByWhere($selectModel,"estate_id='$value'");
        //delete
        $estateDal->deleteModel($value);
        $estatemapDal->deleteModelByWhere("estate_id='$value'");
        $delete_count++;
      }
      return $delete_count;
   } 
}
?>
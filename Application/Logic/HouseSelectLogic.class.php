<?php
namespace Logic;
class HouseSelectLogic{
	//新增
   public function addModel($data,$is_baozhang=0){
     	$modelDal=new \Home\Model\houseselect();
     	if(is_array($data)){
     		return $modelDal->addModel($data);
     	}
     	return $modelDal->addModelByRoomid($data,$is_baozhang);
   }
   public function addModelByResourceid($resource_id,$is_baozhang=0){
      $modelDal=new \Home\Model\houseselect();
      return $modelDal->addModelByResourceid($resource_id,$is_baozhang);
   }
   //删除
   public function deleteModelByRoomid($room_id){
   	 	$modelDal=new \Home\Model\houseselect();
     	return $modelDal->deleteModelByRoomid($room_id);
   }
   public function deleteModelByResourceid($resource_id){
   	 	$modelDal=new \Home\Model\houseselect();
     	return $modelDal->deleteModelByResourceid($resource_id);
   }
   //更新
   public function updateModelByRoomid($data){
     	$modelDal=new \Home\Model\houseselect();
     	if(isset($data['room_id']) && !empty($data['room_id'])){
     		return $modelDal->updateModelByRoomid($data);
     	}
     	return $modelDal->updateModelByResourceid($data);
   }
   //更新 by 小区
   public function updateModelByEstateid($data){
      $modelDal=new \Home\Model\houseselect();
      return $modelDal->updateModelByEstateid($data);
   }
    //删除 by 小区下有地铁
   public function deleteModelByEstateSubway($estate_id){
      $modelDal=new \Home\Model\houseselect();
      return $modelDal->deleteModelByEstateSubway($estate_id);
   }
    /*新增小区下的房间信息，有地铁 */
    /*public function addModelByEstateSubway($estate_id){
      $modelDal=new \Home\Model\houseselect();
      return $modelDal->addModelByEstateSubway($estate_id);
    }*/
    
    /*置顶 */
    public function getTopCount($condition){
      $conditionString=$this->getTopListCondition($condition);
      $model=new \Home\Model\houseselect();
      return $model->getTopCount($conditionString);
    }
    public function getTopList($condition,$orderby,$limit_start,$limit_end){
      $conditionString=$this->getTopListCondition($condition);
      $model=new \Home\Model\houseselect();
      return $model->getTopList($conditionString,$orderby,$limit_start,$limit_end);
    }
    private function getTopListCondition($condition){
        $where=" city_code='".C('CITY_CODE')."' and is_top>0 ";
        if(isset($condition['room_no']) && !empty($condition['room_no'])){
          $where.=" and room_no='".$condition['room_no']."'";
        }
        if(isset($condition['is_gongyu']) && $condition['is_gongyu']==1){
           $where.=" and is_gongyu=1 ";
        }else{
          if(isset($condition['rent_type']) && !empty($condition['rent_type'])){
            $where.=" and is_gongyu=0 and rent_type=".$condition['rent_type'];
          }
        }
        
        if(isset($condition['top_type']) && !empty($condition['top_type'])){
          $where.=" and top_type=".$condition['top_type'];
        }else{
          //排除首页置顶
          $where.=" and top_type>1";
        }
        if(isset($condition['region']) && !empty($condition['region'])){
          $where.=" and region_id=".$condition['region'];
        }
        if(isset($condition['scope']) && !empty($condition['scope'])){
          $where.=" and scope_id=".$condition['scope'];
        }
        //地铁
        if(isset($condition['subwayline_id']) && !empty($condition['subwayline_id'])){
          $where.=" and subwayline_id=".$condition['subwayline_id'];
        }
        if(isset($condition['subway_id']) && !empty($condition['subway_id'])){
          $where.=" and subway_id=".$condition['subway_id'];
        }
        return $where;
    }
    public function addToproom($data,$is_gongyu=0,$subwayline_id=0,$subway_id=0){
      if(!is_array($data)){
        return false;
      }
      if(empty($data['room_id']) || empty($data['is_top'])){
        return false;
      }
      $model=new \Home\Model\houseselect();
      return $model->addTopModel($data,$is_gongyu,$subwayline_id,$subway_id);
    }
    //置顶上下排序
    public function modifyTopRoomSort($id,$sort,$idTwo,$sortTwo){
      if(empty($id) || empty($sort)){
        return false;
      }
      $model=new \Home\Model\houseselect();
      return $model->modifyTopRoomSort($id,$sort,$idTwo,$sortTwo);
    }
    //取消置顶
    public function unsetTopRoomSort($id){
      if(empty($id)){
        return false;
      }
      $model=new \Home\Model\houseselect();
      return $model->deleteModelByWhere("id='$id'");
    }  
    //根据id获取
    public function getHouseselectById($id){
        if(empty($id)){
          return null;
        }
        $model=new \Home\Model\houseselect();
        $list = $model->getTopList(" id='$id' ","",0,1);
        if($list!=null && count($list)>0){
          return $list[0];
        }
        return null;
    }
    /*可租房间列表 */
    public function getHouseselectCount($condition){
      $conditionString=$this->getHouseselectCondition($condition);
      $model=new \Home\Model\houseselect();
      $list= $model->getModelListCount(" where city_code='".C('CITY_CODE')."' and subwayline_id=0 and top_type=0 ".$conditionString);
      if($list!=null && count($list)>0){
          return $list[0]['totalcnt'];
      }
      return 0;
    }
    public function getHouseselectList($condition,$limit_start,$limit_end){
      $conditionString=$this->getHouseselectCondition($condition);
      $model=new \Home\Model\houseselect();
      return $model->getModelList(" where city_code='".C('CITY_CODE')."' and subwayline_id=0 and top_type=0 ".$conditionString," order by room_money asc limit $limit_start,$limit_end");
    }
    private function getHouseselectCondition($condition){
        $where="";
        if(isset($condition['estateName']) && !empty($condition['estateName'])){
          $where.=" and estate_name like '".$condition['estateName']."%'";
        }
        if(isset($condition['region']) && !empty($condition['region'])){
          $where.=" and region_id=".$condition['region'];
        }
        if(isset($condition['scope']) && !empty($condition['scope'])){
          $where.=" and scope_id=".$condition['scope'];
        }
        if(isset($condition['moneyMin']) && !empty($condition['moneyMin'])){
          $where.=" and room_money>=".$condition['moneyMin'];
        }
        if(isset($condition['moneyMax']) && !empty($condition['moneyMax'])){
          $where.=" and room_money<=".$condition['moneyMax'];
        }
        if(isset($condition['is_commission']) && $condition['is_commission']!=''){
          $where.=" and is_commission=".$condition['is_commission'];
        }
        return $where;
    }
}
?>
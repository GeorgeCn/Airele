<?php
namespace Logic;
/*统计管理 */
class SummaryLogic{
	#联系房东记录
	public function getContactCount($condition){
	  $conditionString=$this->getContactConditionString($condition);
	  $conditionString=' where '.substr(trim($conditionString), 3);
	  $model=new \Home\Model\summaryhouserentercall();
	  return $model->getModelListCount($conditionString);
	}
	public function getContactList($condition,$limit_start,$limit_end){
	  $conditionString=$this->getContactConditionString($condition);
	  $conditionString=' where '.substr(trim($conditionString), 3);	
	  $model=new \Home\Model\summaryhouserentercall();
	  return $model->getModelList($conditionString,$limit_start,$limit_end);
	}
	private function getContactConditionString($condition)
	{
	    $conditionString=" and city_id=".intval(C('CITY_CODE'));
		if(is_array($condition)){
			foreach ($condition as $key => $value) {
				$condition[$key]=str_replace("'", "", $value);
			}
		}else{
			return " and 1=0";
		}
	     if(isset($condition['startTime']) && !empty($condition['startTime'])){
	        $conditionString.=" and summary_date>='".$condition['startTime']."'";
	     }
	     if(isset($condition['endTime']) && !empty($condition['endTime'])){
	        $conditionString.=" and summary_date<='".$condition['endTime']."'";
	     }
	    if(isset($condition['region']) && trim($condition['region'])!=''){
        	$conditionString.=" and region_id=".trim($condition['region']);
	     }
	     if(isset($condition['scope']) && trim($condition['scope'])!=''){
	        $conditionString.=" and scope_id=".trim($condition['scope']);
	     }
	     if(isset($condition['room_no']) && trim($condition['room_no'])!=''){
	        $conditionString.=" and room_no='".trim($condition['room_no'])."'";
	     }
		return $conditionString;
	}
		#置顶房源统计
		public function getToproomCount($condition){
		  $conditionString=$this->getContactConditionString($condition);
		  $conditionString=' where '.substr(trim($conditionString), 3);
		  $model=new \Home\Model\summaryhouserentercall();
		  return $model->getToproomCount($conditionString);
		}
		public function getToproomList($condition,$limit_start,$limit_end){
		  $conditionString=$this->getContactConditionString($condition);
		  $conditionString=' where '.substr(trim($conditionString), 3);	
		  $model=new \Home\Model\summaryhouserentercall();
		  return $model->getToproomList($conditionString,$limit_start,$limit_end);
		}
	
}

?>
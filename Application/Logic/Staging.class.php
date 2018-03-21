<?php
namespace Logic;
use Think\Controller;
class Staging extends Controller{
    //统计总条数
	 public function getStagingPageCount($where){
        $conditionString=$this->getConditionString($where);
    	$modelDal=new \Home\Model\staging();
    	return $modelDal->modelStagingPageCount($conditionString);
    }
    //获取分页数据
    public function getStagingList($firstrow,$listrows,$where){
        $conditionString=$this->getConditionString($where);
  		$modelDal=new \Home\Model\staging();
        return $modelDal->modelStagingList($firstrow,$listrows,$conditionString);
    }
    public function getStagingFind($where){
        $modelDal=new \Home\Model\staging();
        return $modelDal->modelByIdFind($where);
    }
    public function updateStaging($data){
        $modelDal=new \Home\Model\staging();
        return $modelDal->modelUpdate($data);
    }
    //搜索条件
    private function getConditionString($condition)
    {
        if(is_array($condition)){
            foreach ($condition as $key => $value) {
                $condition[$key]=str_replace("'", "", $value);
            }
        }else{
            return "";
        }
        $conditionString="1=1";
        //提交时间
         if(isset($condition['startTime']) && trim($condition['startTime'])!=''){
            $conditionString.=" and create_time>=".strtotime(trim($condition['startTime']));
         }
         if(isset($condition['endTime']) && trim($condition['endTime'])!=''){
            $endTime=strtotime(trim($condition['endTime']));
            $endTime=$endTime+60*60*24;
            $conditionString.=" and create_time<=".$endTime;
         }
        if (isset($condition['mobile']) && !empty($condition['mobile'])) {
            $conditionString.=" and mobile='".$condition['mobile']."'";
        }
        if(isset($condition['name']) && trim($condition['name'])!=''){
            $conditionString.=" and name like '%".trim($condition['name'])."%' ";
         }
        if (isset($condition['stages_status']) && !empty($condition['stages_status'])) {
            $conditionString.=" and stages_status='".$condition['stages_status']."'";
        }
          if(isset($condition['owner_mobile']) && trim($condition['owner_mobile'])!=''){
            $conditionString.=" and owner_mobile='".trim($condition['owner_mobile'])."' ";
         }
          if(isset($condition['owner_name']) && trim($condition['owner_name'])!=''){
            $conditionString.=" and owner_name like '%".trim($condition['owner_name'])."%' ";
         }
          if(isset($condition['owner_mobile']) && trim($condition['owner_mobile'])!=''){
            $conditionString.=" and owner_mobile='".trim($condition['owner_mobile'])."' ";
         }
          if(isset($condition['owner_mobile']) && trim($condition['owner_mobile'])!=''){
            $conditionString.=" and owner_mobile='".trim($condition['owner_mobile'])."' ";
         }
         //财务操作列表
          if(isset($condition['is_financelist']) && $condition['is_financelist']==1){
            $conditionString.=" and loan_status>=1 and stages_status in (4,10)";
         }
         if(isset($condition['bank_no']) && trim($condition['bank_no'])!=''){
            $conditionString.=" and bank_no='".trim($condition['bank_no'])."' ";
         }
         if(isset($condition['loan_status']) && trim($condition['loan_status'])!=''){
            $conditionString.=" and loan_status='".trim($condition['loan_status'])."' ";
         }
        return $conditionString;
    }
}
?>
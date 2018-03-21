<?php
namespace Logic;
use Think\Controller;
class ReportLogic extends Controller{
    //统计总条数
	 public function getReportPageCount($where){
    	$modelDal=new \Home\Model\report();
    	$result=$modelDal->modelReportPageCount($where);
    	return $result;
    }
    //获取分页数据
    public function getReportDataList($firstrow,$listrows,$where){
  		$modelDal=new \Home\Model\report();
        $result=$modelDal->modelReportDataList($firstrow,$listrows,$where);
        return $result;     
    }
    public function getReportFind($where){
        $modelDal=new \Home\Model\report();
        $result=$modelDal->modelGetReporteFind($where);
        return $result;
    }
    public function modelUpdate($data){
        $modelDal=new \Home\Model\report();
        $result=$modelDal->modelUpdate($data);
        return $result; 
    }
    
    public function modelGetAdmin($where){
        $modelDal=new \Home\Model\report();
        $result=$modelDal->modelGetAdmin($where);
        return $result; 
    }
    //根据room_no查找store_id
    public function findHouseRoom ($data)
    {
        if(empty($data['room_no'])) return null;
        $modelDal = new \Home\Model\report();
        $fields = 'store_id';
        $where['room_no'] = trim($data['room_no']);
        $result = $modelDal->modelFindHouseRoom($fields,$where);
        return $result; 
    }
}
?>
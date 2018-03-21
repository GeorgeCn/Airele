<?php
namespace Home\Controller;
use Think\Controller;
class AwardController extends Controller {

    public function awardlist(){
         $handleCommonCache=new \Logic\CommonCacheLogic();
         if(!$handleCommonCache->checkcache()){
            $this->error('非法操作',U('Index/index'),1);
         }
         $city_code=I('get.citycode');
         if($city_code!=""){
             $where['city_code']=array('eq',$city_code);
         }
        $modelawardcustomer=new \Home\Model\awardcustomer();
        $list=$modelawardcustomer->modelList($where);
        foreach ($list as $key => $value) {
            $roomid_arr=explode(',',$value['room_id']);
            $html=""; 
            foreach($roomid_arr as $value1) {
                if($value1!=""){
                     $whereroom['room_id']=$value1;
                     $roomdata=$modelawardcustomer->modelRoomFind($whereroom);
                     $html.=$roomdata['region_name']."-".$roomdata['scope_name']."-".$roomdata['estate_name']."-".$roomdata['room_money']."元<br>";
                }
            }
            $value['room_id']=$html;
            $list1[]=$value;
        }
    	$this->assign("list",$list1);
        $this->display();
    }
}
?>
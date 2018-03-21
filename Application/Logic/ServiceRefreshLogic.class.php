<?php
namespace Logic;
class ServiceRefreshLogic{
 /*配置服务-刷新房源 start*/
  //数量
   public function getRefreshroomCount(){
      $modelDal=new \Home\Model\servicerefresh();
      $data= $modelDal->getRefreshroomData('count(1) as cnt'," record_status=1 and city_code='".C('CITY_CODE')."'");   
      if($data!=null && count($data)>0){
         return $data[0]['cnt'];
      }
      return 0;
   }
   //列表
  public function getRefreshroomList($limit_start,$limit_end){
     $modelDal=new \Home\Model\servicerefresh();
     $data= $modelDal->getRefreshroomData('id,condition_desc,create_time,create_man'," record_status=1 and city_code='".C('CITY_CODE')."' order by create_time desc limit $limit_start,$limit_end");   
     return $data;
  }
  //新增，select表主信息
  public function addRefreshroomByselect($condition,$handle_man){
    $city_code=C('CITY_CODE');
    $query_sql="select room_id from gaodu.houseselect where subwayline_id =0 and top_type =0 and city_code='$city_code'";
    $desc='';
    if(isset($condition['region']) && $condition['region']!=''){
      $desc.=$condition['region_name'].',';
      $query_sql.=' and region_id='.$condition['region'];
    }
    if(isset($condition['scope']) && $condition['scope']!=''){
      $desc.=$condition['scope_name'].',';
      $query_sql.=' and scope_id='.$condition['scope'];
    }
    if(isset($condition['moneyMin']) && $condition['moneyMin']!=''){
      $desc.='租金≥'.$condition['moneyMin'].',';
      $query_sql.=' and room_money>='.$condition['moneyMin'];
    }
    if(isset($condition['moneyMax']) && $condition['moneyMax']!=''){
      $desc.='租金≤'.$condition['moneyMax'].',';
      $query_sql.=' and room_money<='.$condition['moneyMax'];
    }
    #户型，室
    if(isset($condition['room_num']) && $condition['room_num']!=""){
        if($condition['room_num']=='2+'){
          $desc.='2室及以上,';
          $query_sql.=" and room_num>=2";
        }else if($condition['room_num']=='3+'){
          $desc.='3室及以上,';
          $query_sql.=" and room_num>=3";
        }else if($condition['room_num']=='4+'){
          $desc.='4室及以上,';
          $query_sql.=" and room_num>=4";
        }else{
          $desc.=$condition['room_num'].'室,';
          $query_sql.=" and room_num=".$condition['room_num'];
        }
    }
    if(isset($condition['isComm']) && $condition['isComm']=='1'){
      $desc.='有佣金,';
      $query_sql.=' and is_commission=1';
    }
    if(isset($condition['brandType']) && $condition['brandType']!=''){
      $desc.=$condition['brandName'].',';
      $query_sql.=" and brand_type='".$condition['brandType']."'";
    }
    #是否中介
    if(isset($condition['isAgent']) && $condition['isAgent']!=''){
      if($condition['isAgent']=='1'){
        $desc.='中介,';
        $query_sql.=' and is_agent_fee=1';
      }else{
        $desc.='非中介,';
        $query_sql.=' and is_agent_fee=0';
      }
    }
    if(isset($condition['cuid']) && $condition['cuid']!=''){
      $desc.=$condition['phone'].',';
      $query_sql.=" and customer_id='".$condition['cuid']."'";
    }
    if($desc==''){
      return false;
    }
    $modelDal=new \Home\Model\servicerefresh();
    $data['id']=guid();
    $data['condition_desc']=$desc;
    $data['condition_sql']=$query_sql;
    $data['record_status']=1;
    $data['create_time']=time();
    $data['create_man']=$handle_man;
    $data['update_time']=time();
    $data['update_man']=$handle_man;
    $data['city_code']=$city_code;
    return $modelDal->addRefreshroom($data);   
  }
  //新增，room表主信息
  public function addRefreshroomByroom($condition,$handle_man){
    $city_code=C('CITY_CODE');
    $query_sql="select id as room_id from gaodu.houseroom where status =2 and record_status=1 and city_code='$city_code'";
    $desc='';
    if(isset($condition['moneyMin']) && $condition['moneyMin']!=''){
      $desc.='租金≥'.$condition['moneyMin'].',';
      $query_sql.=' and room_money>='.$condition['moneyMin'];
    }
    if(isset($condition['moneyMax']) && $condition['moneyMax']!=''){
      $desc.='租金≤'.$condition['moneyMax'].',';
      $query_sql.=' and room_money<='.$condition['moneyMax'];
    }
    #付费房源
    if(isset($condition['isComm']) && $condition['isComm']=='1'){
      $desc.='有佣金,';
      $query_sql.=' and is_commission=1';
    }
    if(isset($condition['isMonth']) && $condition['isMonth']=='1'){
      $desc.='包月,';
      $query_sql.=' and is_monthly=1';
    }
    #是否中介
    if(isset($condition['isAgent']) && $condition['isAgent']!=''){
      if($condition['isAgent']=='1'){
        $desc.='中介,';
        $query_sql.=' and is_agent_fee=1';
      }else{
        $desc.='非中介,';
        $query_sql.=' and is_agent_fee=0';
      }
    }
    if(isset($condition['cuid']) && $condition['cuid']!=''){
      $desc.=$condition['phone'].',';
      $query_sql.=" and customer_id='".$condition['cuid']."'";
    }
    #房东负责人
    if(isset($condition['principalMan']) && $condition['principalMan']!=''){
      $desc.='负责人'.$condition['principalMan'].',';
      $query_sql.=" and principal_man='".$condition['principalMan']."'";
    }
    if($desc==''){
      return false;
    }
    $modelDal=new \Home\Model\servicerefresh();
    $data['id']=guid();
    $data['condition_desc']=$desc;
    $data['condition_sql']=$query_sql;
    $data['record_status']=1;
    $data['create_time']=time();
    $data['create_man']=$handle_man;
    $data['update_time']=time();
    $data['update_man']=$handle_man;
    $data['city_code']=$city_code;
    return $modelDal->addRefreshroom($data);   
  }

  //获取时间点
  public function getRefreshtimesByid($id){
    if($id==''){
      return null;
    }
    $modelDal=new \Home\Model\servicerefresh();
    $data=$modelDal->getRefreshroomtimeData("execute_hour,execute_minute","relation_id='$id' and record_status=1");
    return $data;
  }
  //设置刷新时间点
  public function setRefreshtime($main_id,$handle_man,$time_arr){
    if($main_id=='' || count($time_arr)==0){
      return false;
    }
    $modelDal=new \Home\Model\servicerefresh();
    //先删除已有的
    $result=$modelDal->deleteRefreshroomtime("relation_id='$main_id'");
    foreach ($time_arr as $key => $value) {
      $result=$modelDal->addRefreshroomtime(array('relation_id'=>$main_id,'execute_hour'=>$value['hour'],'execute_minute'=>$value['minute'],'record_status'=>1,'create_time'=>time(),'create_man'=>$handle_man));
    }
    return $result;
  }
  //删除
  public function deleteRefreshCondition($main_id,$handle_man){
    if($main_id==''){
      return false;
    }
    $modelDal=new \Home\Model\servicerefresh();
    $result=$modelDal->updateRefreshroom(array('record_status'=>0,'update_man'=>$handle_man,'update_time'=>time()),"id='$main_id'");
    if($result){
      $modelDal->deleteRefreshroomtime("relation_id='$main_id'");
    }
    return $result;
  }

/*配置服务-刷新房源 end*/


}
?>
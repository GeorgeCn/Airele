<?php
namespace Home\Model;
use Think\Model;
class contactowner{
    const connecdata = 'DB_DATA';
   public function modelContactOwnerCount($where){
     $ModelTable = M("houserentercall");
     $result = $ModelTable->where($where)->count();
  //   echo$ModelTable->getLastSql();
    //$result = $ModelTable->join('houseroom ON houserentercall.room_id = houseroom.room_no' )->join('houseresource ON houseroom.resource_id = houseresource.id')->where($where)->count();
     return $result;
   }
    //获取分页数据
   public function modelContactOwnerList($firstrow,$listrows,$where,$count=10){
      $ModelTable = M("houserentercall");
      if($count<10){
        $datalist = $ModelTable->where($where)->select();
      }else{
        $datalist = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
      }
     // $datalist = $ModelTable->field('houserentercall.*,houseresource.info_resource')->join('houseroom ON houserentercall.room_id = houseroom.room_no' )->join('houseresource ON houseroom.resource_id = houseresource.id')->where($where)->order('houserentercall.create_time desc')->limit($firstrow,$listrows)->select();
     return $datalist;
   }
   //已听录音列表
   public function getHaveheardCount($where){
     $ModelTable = new Model();
     return $ModelTable->query("select count(1) as cnt from houserentercall ".$where);
   }
   public function getHaveheardList($firstrow,$listrows,$where){
      $ModelTable = new Model();
      return $ModelTable->query("select room_id,info_resource,is_commission,mobile,owner_mobile,owner_name,charge_man,status_code,called_length,call_time,updata_man,update_time,memo,call_id,is_owner,source,recording_txt from houserentercall ".$where." order by call_time desc limit $firstrow,$listrows");
   }
   //所有联系记录
   public function getAllContactCount($where){
     $ModelTable = new Model();
     return $ModelTable->query("select count(1) as cnt,count(distinct room_id) as room_cnt,count(distinct mobile) as renter_cnt,count(distinct owner_mobile) as owner_cnt from houserentercall ".$where);
   }
   public function getAllContactList($firstrow,$listrows,$where,$columns=''){
      if($columns==''){
        $columns='region_name,scope_name,estate_name,room_type,room_num,room_id,room_money,info_resource,is_commission,mobile,big_code,ext_code,agent_company_name,owner_mobile,owner_name,gaodu_platform,charge_man,principal_man,status_code,caller_length,called_length,call_time,brand_type,is_monthly,is_owner,call_id,rooms_id,source,recording_txt';
      }
      $ModelTable = new Model();
      return $ModelTable->query("select $columns from houserentercall ".$where." order by call_time desc limit $firstrow,$listrows");
   }
    public function modelYetRecordCount($where){
     $ModelTable = M("houserentercall");
     return $ModelTable->where($where)->count();
   }
    //获取分页数据
   public function modelYetRecordList($firstrow,$listrows,$where){
      $ModelTable = M("houserentercall");
      return $ModelTable->where($where)->order('update_time desc')->limit($firstrow,$listrows)->select();
   }
    //去重统计
    public function modelDistinctRoomCount($where,$codestr){
       $ModelTable = M("houserentercall");
       return $ModelTable->where($where)->count('distinct('.$codestr.')');
   }

   public function modelFind($where){
      $ModelTable = M("houserentercall");
      return $ModelTable->where($where)->find();
   }
  public function modelUpdate($data){
      $ModelTable = M("houserentercall");
      $where['id']=$data['id'];
      return $ModelTable->where($where)->save($data);
   }
    public function modelHouseRoomFind($where){
     $ModelTable = M("houseroom");
     return $ModelTable->where($where)->find();
   
   }
    public function modelHouseRoomUpdate($data){
     $ModelTable = M("houseroom");
     $where['id']=$data['id'];
     return $ModelTable->where($where)->save($data);

   }


   public function modelHouseRoom($where){
     $ModelTable = M("houseroom");
     $condition['id']=$where;
     return $ModelTable->where($condition)->find();
 
   }
   //获取房间信息
   public function modelGetHouseRoom($where){
     $ModelTable = M("houseroom");
     return $ModelTable->field('id,resource_id,room_no,room_money,info_resource,create_man,status,commission_money,commission_enddate,is_commission')->where($where)->find();
 
   }
   //下载联系房东列表
   public function modelAllContactOwner($where){
      $ModelTable = M("houserentercall");
      $datalist = $ModelTable->field('room_id,mobile,owner_mobile,gaodu_platform,create_time,owner_name,big_code,status_code,caller_length,info_resource')->where($where)->order('create_time desc')->select();
     return $datalist;
   }
   //获取房间来源
   public function modelGetHouseResource($room_no){
       $ModelTable = M("houseresource");
       $where['houseroom.room_no']=array('eq',$room_no);
       return $ModelTable->field('houseresource.info_resource,houseresource.update_man,houseresource.create_man')->join('INNER JOIN houseroom ON houseroom.resource_id = houseresource.id')->where($where)->find();
       
   }
   //拨打房东记录按天统计
   public function modelOwnerCount($where1){
       $ModelTable = M("houserentercall");
       $where=$this->handlewhere($where1);
       $resultarr = $ModelTable->query("SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(id) AS callcount FROM houserentercall WHERE ".$where." GROUP BY day");
       $result=count($resultarr);
      return $result;
   }
   public function modelOwnerCountList($firstrow,$listrows,$where1){
       $ModelTable = M("houserentercall");
       $where=$this->handlewhere($where1);
       $result = $ModelTable->query("SELECT FROM_UNIXTIME(create_time,'%Y%m%d') day,COUNT(id) AS callcount FROM houserentercall WHERE ".$where." GROUP BY day order by day desc limit ".$firstrow.",".$listrows);
       return $result;
   }

   //ajax统计拨打记录
   public function modelAjaxPhoneCount($datetime,$platform){
      $ModelTable = M("houserentercall");
      $result = $ModelTable->query("SELECT COUNT(id) AS countnum FROM houserentercall WHERE city_id=".C('CITY_CODE')." AND FROM_UNIXTIME(create_time,'%Y%m%d')=".$datetime." and gaodu_platform=".$platform);
      return $result[0]['countnum'];
   }

   public function modelAjaxCount($datetime){
      $ModelTable = M("houserentercall");
      $result = $ModelTable->query("SELECT COUNT(id) AS countnum FROM houserentercall WHERE city_id=".C('CITY_CODE')." AND FROM_UNIXTIME(create_time,'%Y%m%d')=".$datetime);
      return $result[0]['countnum'];
   }
   public function modelManCount($datetime){
      $ModelTable = M("houserentercall");
      $result = $ModelTable->query("SELECT * FROM houserentercall WHERE  city_id=".C('CITY_CODE')." AND FROM_UNIXTIME(create_time,'%Y%m%d')=".$datetime." GROUP BY customer_id");
      return count($result);
   }
    public function modelRoomCount($datetime){
      $ModelTable = M("houserentercall");
      $result = $ModelTable->query("SELECT * FROM houserentercall WHERE city_id=".C('CITY_CODE')." AND FROM_UNIXTIME(create_time,'%Y%m%d')=".$datetime." GROUP BY room_id");
      return count($result);
   }
   public function modelRoomArray($datetime){
      $ModelTable = M("houserentercall");
      $result = $ModelTable->query("SELECT room_id FROM houserentercall WHERE city_id=".C('CITY_CODE')." AND FROM_UNIXTIME(create_time,'%Y%m%d')=".$datetime);
      return $result;

   }
   
   public function handlewhere($where1){
       $where="";
       foreach($where1 as $key => $value) {
          if($key=="city_id"){
            $where.="city_id=".$value[1];
          }
          if($key=="create_time"){
            echo  $pronum=count($value);
             if($pronum==1){
                if($value[0][0]=="gt"){
                  $where.=" and create_time >".$value[0][1];
                }elseif($value[0][0]=="lt"){
                  $where.=" and create_time <".$value[0][1];
                }
             }elseif($pronum==2){
                $where.=" and create_time >".$value[0][1]." and create_time <".$value[1][1];
             }
          }
       }
       return $where;
   }
   /*短链推送 */
   public function getShorturlList($condition){
      $modelTable=new Model();
      return $modelTable->query('select id,mobile,customer_id,call_time,big_code,shorturl_issend,shorturl_address,shorturl_handleman from houserentercall '.$condition.' order by create_time desc limit 30');
   }
   public function getShorturlDownloadList($condition){
      $modelTable=new Model();
      return $modelTable->query('select mobile,call_time,big_code,shorturl_handleman,shorturl_issend,shorturl_address,city_id from houserentercall '.$condition.' order by create_time desc limit 5000');
   }

   public function updateallcall($where){
        $ModelTable = M("houserentercall");
        $data['is_read']=1;
        $result=$ModelTable->where($where)->save($data);
        return $result;
   }
   /**
    * 生成字符串
    * @param string $data
    */
    public function createStr ($data)
    {
        $str = "";
        foreach($data as $key=>$value) {
            $str .= "&".$key."=".$value;  
        }
        $string = substr($str,1);
        return $string;
    }
   /**
    * 进行curl请求
    * @param string $url
    * @param string $param
    */
    public function requestPost ($url = '', $param = '') 
    {
        if (empty($url) || empty($param)) {
            return false;
        }
        //$key = $this->_appkeys;
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER,0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }
    //获取用户社会信息
    public function findSocializeInfo ($fields,$where)
    {
        $ModelTable = M();
        $result = $ModelTable->field($fields)->table('gaodu_recommend.user_socialize_msg')->where($where)->find();
        return $result;
    } 
    //获取用户信息
    public function findCustomerInfo ($fields,$where)
    {
      $ModelTable = M();
      $result = $ModelTable->field($fields)->table('gaodudata.customer')->where($where)->find();
      return $result;
    }
    public function modelFindHouseRoom ($fields,$where)
    {
      $ModelTable = M("houseroom");
      $result = $ModelTable->field($fields)->where($where)->find();
      return $result;   
    }
}
?>
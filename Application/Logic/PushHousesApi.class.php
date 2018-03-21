<?php
namespace Logic;
//PushHousesApi   这是推送方法  用到curl发送请求
class PushHousesApi 
{
    private $_appkeys = '';
    /**
    * 构造函数 获得key
    * @param string $appkeys
    */
    public function __construct($appkeys = '') 
    {
        $this->_appkeys = $appkeys;
    }
    /**
    * ASCII排序,生成字符串
    * @param string $data
    */
    public function keySort ($data)
    {
        ksort($data);
        $str = "";
        foreach($data as $key=>$value) {
            $str .= "&".$key."=".$value;  
        }
        $sign = substr($str,1);
        return $sign;
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
    /**
    * 推送房源信息
    * @param array $requestData
    */
    public function sendHouses ($requestData = array()) 
    {
        $key = $this->_appkeys;
        $nonce = rand(123456,9999999);
        list($t1, $t2) = explode(' ', microtime());
        $timestamp = (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        ksort($requestData);
        $methodParam = json_encode($requestData);
        $reqParam = array("methodid"=>"1012",
        "methodparam"=>$methodParam,"nonce"=>$nonce, 
        "timestamp"=>$timestamp,"appid"=>"OPENAPI");
        $sign = $this->keySort($reqParam)."&key=".$key;
        // var_dump($sign);exit;
        $hash = strtoupper(md5($sign));
        $strParam = $this->createStr($reqParam);
        $strParams = $strParam."&signature=".$hash;  
        // print_r($strParams);exit;
        $url = 'http://openapi.innjia.com/api/InnjiaUip';
        $result = $this->requestPost($url,$strParams);
        return $result;
    }
    //houseroom查询
    public function modelGetinfo ($offset = 0,$num = 10,$fields='',$where='')
    {
        $ModelTable = M("houseroom");
        $result = $ModelTable->field($fields)->where($where)->limit($offset,$num)->select();
        return $result;
    }
    //根据eid获取
    public function getAstateAddress ($eid)
    {
        $ModelTable = M("estate");
        $where['id'] = $eid;
        $address = $ModelTable->field('estate_address')->where($where)->find();
        $result = $address['estate_address'];
        return $result;
    }
     //获取房源信息
    public function getHouseresourceByid ($id){
        $ModelTable = M("houseresource");
        $data = $ModelTable->field('client_phone,region_id,estate_name,pay_method,room_num,hall_num,area,floor_total,floor,decoration,rent_type,scope_name,wei_num,room_count,status,estate_id eid,record_status')->where("id='$id'")->find();
        return $data;
    }
     //获取房间信息
    public function getHouseroomByid ($id){
        $ModelTable = M("houseroom");
        $data = $ModelTable->field('room_name,room_no,info_resource,room_money,room_area,id rid,room_direction,room_description des,room_equipment,resource_id')->where("id='$id'")->find();
        return $data;
    }
    //键-值对获取地域ID
    public function getCountId ($key)
    {
        $arr = array("14"=>"434","7"=>"435","24"=>"436",
            "43"=>"437","2"=>"438","108"=>"439","140"=>"440","88"=>"441",
            "97"=>"442","147"=>"443","121"=>"444","166"=>"445","177"=>"446",
            "206"=>"447","215"=>"448","53"=>"449","197"=>"451","224"=>"452");
        return $arr[$key];
    }
    //获取支付方式
    public function getPayMethod ($payMethod)
    {
        switch ($payMethod) {
            case '0101' : 
                $requestData['payType'] = 1;
                $requestData['deposit'] = 1;
                break;
            case '0102' : 
                $requestData['payType'] = 4;
                $requestData['deposit'] = 1;
                break;
            case '0103' :
                $requestData['payType'] = 0;
                $requestData['deposit'] = 1; 
                break;
            case '0104' : 
                $requestData['payType'] = 1;
                $requestData['deposit'] = 2;
                break;
            case '0105' :
                $requestData['payType'] = 4;
                $requestData['deposit'] = 2; 
                break;
            case '0106' :
                $requestData['payType'] = 0;
                $requestData['deposit'] = 2; 
                break;
            case '0107' :
                $requestData['payType'] = 2;
                $requestData['deposit'] = 0; 
                break;
            case '0108' :
                $requestData['payType'] = 3;
                $requestData['deposit'] = 0; 
                break;
            case '0109' :
                $requestData['payType'] = 0;
                $requestData['deposit'] = 0; 
                break;
            default : break;
        }
        return $requestData;
    }
    //获取户型
    public function getHouseType ($room,$hall)
    {
        $houseType='';
        $key = $room.$hall;
        $arr = array("11"=>"0","10"=>"1","21"=>"2",
                    "20"=>"3","31"=>"4","30"=>"4");
        if ($hall>1) {
            $houseType = 6;
        } else {
            if ($room>3) {
                $houstType = 5;
            } else {
                $houseType = $arr[$key];
            }
        }
        return $houseType;
    }
    //获取房屋朝向
    public function getOrientation ($direction)
    {
        $arr = array("1001"=>"8","1002"=>"0","1003"=>"6","1004"=>"4",
            "1005"=>"7","1006"=>"5","1007"=>"0","1008"=>"2","1009"=>"1","1010"=>"3");
        return $arr[$direction];
    }
    //获取装修情况
    public function getRenovation ($decoration)
    {
        $arr = array("0001"=>"0","0002"=>"1","0003"=>"3","0004"=>"4");
        return $arr[$decoration];
    }
    //获取出租类型
    public function getRentType ($rentType)
    {
        if($rentType==1){
            return 1;
        }else if($rentType==2){
            return 0;
        }else{
            return '';
        }
    }
    //获取公共设备
    public function getEquipments ($equipment)
    {
        $result = array("bed"=>0,"soft"=>0,"board"=>0,"desk"=>0,"washMachine"=>0,
                "refrigerator"=>0,"television"=>0,"airCondition"=>0,"waterHeader"=>0,
                "lampblackMachine"=>0,"stove"=>0,"ambry"=>0,"wifi"=>0,"microwaveOven"=>0);
        $arr = explode(',',$equipment);
        for($i=0;$i<count($arr);$i++) {
            switch($arr[$i]) {
                case '1103' :
                    $result['bed'] = 1;
                    break;
                case '1104' :
                    $result['bed'] = 1;
                    break;
                case '1110' : 
                    $result['soft'] = 1;  
                    break;
                case '1105' :
                    $result['board'] = 1;
                    break;
                case '1106' :
                    $result['desk'] = 1;
                    break;
                case '1109' :
                    $result['washMachine'] = 1;
                    break;
                case '1108' :
                    $result['refrigerator'] = 1;
                    break;
                case '1101' :
                    $result['television'] = 1;
                    break;
                case '1102' :
                    $result['airCondition'] = 1;
                    break;
                case '1116' :
                    $result['waterHeader'] = 1;
                    break;
                case '1113' :
                    $result['lampblackMachine'] = 1;
                    $result['stove'] = 1;
                    $resutl['microwaveOven'] = 1;
                    break;
                case '1107' :
                    $result['ambry'] = 1;
                    break;
                case '1117' :
                    $result['wifi'] = 1;
                    break;
                default :
                    break;
            }
        }
        return $result;
    }
    //根据rid 获得房源图片数据
    public function getHousePic ($rid)
    {
        $ModelTable = M("houseroom");
        $where['room_id'] = $rid;
        $data = $ModelTable->field('img.img_path,img.img_name,img.img_ext')->table('gaoduimgs.houseimg img')->where($where)->select();
        if($data) {
            foreach($data as $val) {
                //test:http://120.27.162.0/imgtest/imgapi/
                $picPath = 'http://img.loulifang.com.cn/'.$val['img_path'].$val['img_name'].'.'.$val['img_ext'];
                $pic['picPath'] = $picPath;
                $pic['picType'] = 1;
                $pic['sort'] = 0;
                $result[] = $pic;
            }        
        } else {
            return;
        }
        $json = json_decode(json_encode($result));
        return $json;
    }
    //根据eid 获得房源的交通信息
    public function getTraffic ($eid)
    {
        $ModelTable = M("subwayestate");
        $where['estate_id'] = $eid;
        $data = $ModelTable->field('subwayline_id line,subway_name name,subway_distance distance')->where($where)->select();
        if($data) {
            foreach($data as $val) {
                $traffic['trafficLine'] = $val['line'];
                $traffic['stationName'] = $val['name'];
                $traffic['distance'] = $val['distance'];
                $traffic['trafficType'] = 0;
                $result[] = $traffic;
            }
        } else {
            return;
        }
        $json = json_decode(json_encode($result));
        return $json;  
    }
    //推送房源room_id插入innjiapush
    public function insertRoomId ($rid,$phone)
    {
        $ModelTable = M("innjiapush");
        $data['room_id'] = $rid;
        $data['status'] = 1;
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['client_phone']=$phone;
        $result = $ModelTable->data($data)->add();
        return $result;
    }
    //回调信息写入日志
    public function putFile ($file="demo.txt",$content)
    {   
        $contents = "创建日期：".date('Y-m-d H:i:s').$content."\r\n";
        $result = file_put_contents($file, $contents,FILE_APPEND);
        return $result;
    }
    //查找下架房源room_id
    public function getDownHouses ($offset = 0,$num = 10,$fields='',$where='')
    {
        $ModelTable = M("innjiapush");
        $result = $ModelTable->field($fields)->where($where)->limit($offset,$num)->select();
        return $result;
    }
    //更改房源状态
    public function updateRoomStatus ($rid)
    {
        $ModelTable = M("innjiapush");
        $where['room_id'] = $rid;
        $data['status'] = 3;
        $data['update_time'] = time();
        $result = $ModelTable->where($where)->data($data)->save();
        return $result;
    }
    public function updateInnjiapush ($data,$where)
    {
        $ModelTable = M("innjiapush");
        return $ModelTable->where($where)->data($data)->save();
    }
}
?>
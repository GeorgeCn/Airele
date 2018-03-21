<?php
namespace Logic;
class OpenapiLogic{
	/*58接口对接 */
	public function addOpenapipush($data)
	{
		$dal=new \Home\Model\openapipush();
		return $dal->addModel($data);
	}
	//批量新增
	public function addOpenapipushMore($data,$user_array)
	{
		$brand_name='';
        if(C('CITY_CODE')=="001001"){
			$brand_name="";
            $brand_desc="";
		}
		$count=0;
		$dal=new \Home\Model\openapipush();
		$ids_array=explode(',', $data['select_ids']);
		foreach ($ids_array as $key => $value) {
			if(empty($value)){
				continue;
			}
			$model['room_id']=$value;
			$roomModel=$dal->getHouseroomByRoomid($value);//房间
			if($roomModel==null || $roomModel==false || count($roomModel)==0){
				continue;
			}
			$model['resource_id']=$roomModel[0]['resource_id'];
			$resourceModel=$dal->getHouseResourceByResourceid($model['resource_id']);//房源
			if($resourceModel==null || $resourceModel==false || count($resourceModel)==0){
				continue;
			}
			$title_desc=$resourceModel[0]['estate_name'];//标题
        $room_desc='';//描述
        $title_array=array();
        $subway_desc="";
			$subwayModel=$dal->getSubwayByEstateid($resourceModel[0]['estate_id']);//地铁
			if($subwayModel!=null && $subwayModel!=false && count($subwayModel)>0){
                $subwayline=$subwayModel[0]['subwayline_name'];
                $subway_desc="便利的交通&成熟的配套<br>距离地铁".$subwayline.$subwayModel[0]['subway_distance']."米<br>超市，银行，医院，学校，便利店，菜市场，购物广场应有尽有,安全性高、位置安静、靠近花园、采光什么都非常好";
                $title_array[]='温馨可爱的小房间,交通也很便利，格局也很好';
                $title_array[]='精装卧室，小区环境优雅，交通便利';
                $title_array[]='新装卧室距离'.$subwayline.'一公里,家具齐全拎包入住';
                $title_array[]='距离'.$subwayline.'一公里，烫金地段绿化率高';
                $title_array[]='周边生活便捷，地铁'.$subwayline.'精装小屋';
                $title_array[]='真正的拎包入住，精装全配，'.$subwayline.'直达';
                $title_array[]='精品卧室，地铁沿线，全新装修';
			}
      //朝南
            if($roomModel[0]['room_direction']=="1009"){
                $title_array[]='温馨朝南卧室，南北通透阳光充足';
                $title_array[]='朝南房间采光好空间大，小区绿化好';
                $title_array[]='温馨朝南房间，小区安静安全';
                $title_array[]='独立朝南卧室,小区地段超好,阳光房';
                $title_array[]='朝南卧室，格调优雅,即可拎包入住';
                $title_array[]='精装卧室，家电齐全，小区环境也很好';
                $title_array[]='朝南采光好,优质电梯房,随时看房';
            }
      //阳台
			if(strpos($roomModel[0]['room_equipment'], '1111')!==false){
                $title_array[]='带阳台的精装修卧室，阳光充足视野好';
                $title_array[]='宽大温馨主卧,有阳台可晾晒';
                $title_array[]='非常干净舒服的房间,有阳台,冬暖夏凉';
                $title_array[]='房屋配置原房东自住房,家用电器齐全';
                $title_array[]='独立阳台的主卧阳光充足视野开阔';
                $title_array[]='精装大主卧，舒适布局，阳光充沛';
                $title_array[]='花园洋房，景观好，楼层好，市场价，好房不等人';
			}
      //厨房
			if(strpos($resourceModel[0]['public_equipment'], '0309')!==false){
                $title_array[]='可做饭的房间，生活配套齐全,居住环境舒适';
                $title_array[]='可做饭的小屋，干净宽敞舒适，阳光通透';
                $title_array[]='民以食为天，可做饭的精装修卧室出租';
                $title_array[]='精装全配，看房方便，家电全配，拎包入住';
                $title_array[]='高档社区，景观好房，快来电，马上有房';
			}
            if(strpos($roomModel[0]['room_name'], '主卧')!==false){
                $title_array[]='主卧带空调，性价比高，有阳光';
               $title_array[]='好房要淘，好房急租，赶紧来电~~~';
               $title_array[]='温馨舒适采光好，室友超nice!!!';
               $title_array[]='精装大标间 舒适温馨的布局 阳光充沛';
               $title_array[]='精装修 欧洲现代风格 拎包入住';
               $title_array[]='超值装修 拎包入住 省钱省心 交通便利 购物方便';
                $title_array[]='个人出租 优质单间 家具齐全 全新装修';
                $title_array[]='精装全配，喧嚣的城市中属于自己的那一片宁静';
             }
             $title_array[]='换房的好时候到了,主次卧优惠出租,阳光晒满房间温馨';
             $title_array[]='信用入住,品牌保证,品质看得见,入住还有优惠哦 ';
             $title_array[]='畅想浪漫花园洋房生活,交通也超方便';
             $title_array[]='周边配套周边设有丰富的配套设施，充分满足你的生活';
             $title_array[]='高端社区纵享奢华,肆意生活,风景宜人。';
           
            $array_count=count($title_array);
            if($array_count==0){
                $title_desc=$title_desc.'温馨独立房间，小区安静安全';
            }else{
                $title_desc=$title_desc.$title_array[rand(0,$array_count-1)];
            }
          $titleLength=mb_strlen($title_desc,'UTF8');
          if($titleLength>30){
            $title_desc=substr($title_desc,0,30);
          }
    			$model['title_desc']=$title_desc;
    			$model['ad_desc']=$data['ad_desc'];
          switch ($roomModel[0]['girl_tag']) {
            case '1':
              $room_desc='限女生、限女生、限女生';
              break;
            case '2':
              $room_desc='限男生、限男生、限男生';
              break;
            default:
              break;
          }
            if(!empty($roomModel[0]['room_description'])){
                $room_desc=$room_desc.'<br><span style="color:red;">房源描述</span><br>'.$roomModel[0]['room_description'];
            }
            if($subway_desc!=''){
                $room_desc=$room_desc.'<br>'.$subway_desc;
            }
            $room_desc.="<br>便利的交通&成熟的配套<br>
超市，银行，医院，学校，便利店，菜市场，购物广场应有尽有,安全性高、位置安静、靠近花园、采光什么都非常好<br>
装修精致\配套成熟的整租房源<br>
厨房、卫生间、热水器、空调、WIFI,设备齐全，拎包就能入住,还有送车位的哦~<br>
有趣善良的合租室友<br>
那些直播里的萌妹纸、那些陆家嘴的金融GG、那些一身正气的程序员，可能就是你隔壁的室友~那些合租的小伙伴都是素质住户<br>
品质小区<br>
小区都处于繁华地段、房型正、风水佳、环境非常优美、都是一些次新小区";
$room_desc=str_replace(array('独一无二','最便宜','精确','最好','距离','绝无仅有','分钟','最高','最受欢迎','真实房源','中介费','佣金',
  '商住','商改住','商住两用','小产权','学区入学','落户不限购','全款收房','买一层送一层','独立经纪人','可注册','可办公','风水','上风','上水','紫气东来','福地','宝地','黄金地段',
  '首选','投资','升值','潜力','无限','金牌物业 ','品牌地产','拎包入住','地铁房','赠送','涨价','得房率高','办户口','回报','买一送一','得房率拎包'), '**', $room_desc);

			$model['room_desc']=$room_desc;
			$model['create_time']=time();
			$model['create_man']=trim($data['create_man']);
      $model['estate_name']=$resourceModel[0]['estate_name'];
      $model['client_phone']=$resourceModel[0]['client_phone'];
      foreach ($user_array as $user_key => $user_value) {
          if(!empty($user_value)){
              $model['userid']=$user_value;
              if($user_value=='嗨住全国11'){
                $title_zz=array('豪华装修 小区环境优美 修身养性','精装修 热水 沐浴 家具齐全 免费无线网 电梯房','舒适两房 干净整洁 便宜急租 拎包入住','精装大标间 舒适温馨的布局 好楼层',
                  '精装大四房采光好低楼层','交通便利，家电齐全 可整租可合租','朝南大次卧大阳台带电梯 温馨如家 阳光充足 干净卫生 免费看房','小区环境优雅 闹中取静  网球场 游泳池 交通便利',
                  '精装修 欧洲现代风格 拎包入住','南北通透 好格局 好地段 便宜急租','家具家电全齐 拎包即住 低楼层带电梯 新房装修首次出租 先到先得','超低价出租 家具家电齐全 楼层低 价位低 交通便利',
                  '婚房首次出租 全新全套家具家电 温馨舒适','超值精装修 拎包入住 省钱省心 交通便利 购物方便','中间楼层 干净整洁 精装修家具家电齐全 交通便利','双气房 朝南户型 采光非常好 精装修 家具家电齐全 拎包入住',
                  '学区房位置好 家电齐全 拎包入住 绝对精装修 看了就相中','首次出租 全明户型 有钥匙 随时住 双气稀缺两房 家具家电齐全','南北通透 采光好 中心地段 环境优美 交通便利 方便出行');
                $title_zz_cnt=count($title_zz);
                $model['title_desc']=$title_zz[rand(0,$title_zz_cnt-1)];
              }
              $result=$dal->addModel($model);
          }
      }
			$count=$result?($count+1):$count;
		}
		return $count;
	}
	//delete
	public function deleteOpenapipush($ids,$login_name,$third_type=1)
	{
		$dal=new \Home\Model\openapipush();
		$data['record_status']=0;
        $data['update_man']=$login_name;
        $data['update_time']=time();
        $id_array=explode(',', rtrim($ids,','));
        if(count($id_array)==0){
            return false;
        }
		return $dal->deleteFabu($id_array,$data,$third_type);
	}
    //刷新
    public function reflushOpenapipush($ids,$login_name)
    {
        $dal=new \Home\Model\openapipush();
        $data['is_reflush']=1;
        $data['update_man']=$login_name;
        $data['update_time']=time();
        $id_array=explode(',', rtrim($ids,','));
        if(count($id_array)==0){
            return false;
        }
        return $dal->deleteFabu($id_array,$data);
    }
    //推送
    public function pushOpenapipush($ids,$login_name)
    {
        $dal=new \Home\Model\openapipush();
        $data['is_recommend']=1;
        $data['update_man']=$login_name;
        $data['update_time']=time();
        $id_array=explode(',', rtrim($ids,','));
        if(count($id_array)==0){
            return false;
        }
        return $dal->deleteFabu($id_array,$data);
    }
    //真实房源
    public function setTrueOpenapipush($ids,$login_name)
    {
        $dal=new \Home\Model\openapipush();
        $data['is_true']=1;
        $data['update_man']=$login_name;
        $data['update_time']=time();
        $id_array=explode(',', rtrim($ids,','));
        if(count($id_array)==0){
            return false;
        }
        return $dal->deleteFabu($id_array,$data);
    }
	//update
	public function updateOpenapipush($data)
	{
		$dal=new \Home\Model\openapipush();
		return $dal->updateModel($data);
	}
    #未发布 List（58）
    public function getNotfabuList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\openapipush();
     return $modelDal->getNotfabuListByType(1,$conditionString,$limit_start,$limit_end);
   }
	#已经发布 List（58）
	public function getModelListCount($condition){
     $conditionString=$this->getConditionForHadfabu($condition);
     $modelDal=new \Home\Model\openapipush();
     $result = $modelDal->getModelListCountByType(1,$conditionString);
     if($result!=null && count($result)>0){
        return $result[0]['totalCount'];
     }
     return 0;
   }
   public function getModelList($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionForHadfabu($condition);
     $modelDal=new \Home\Model\openapipush();
     return $modelDal->getModelListByType(1,$conditionString,$limit_start,$limit_end);
   }
	#搜索条件（未发布列表）
	private function getConditionString($condition){
     $conditionString="";
     if(trim($condition['startTime'])!=''){
        $conditionString.=" and r.update_time>=".strtotime(trim($condition['startTime']));
     }
     if(trim($condition['endTime'])!=''){
        $endTime=strtotime(trim($condition['endTime']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and r.update_time<=".$endTime;
     }
     //创建时间
     if(trim($condition['startTime_create'])!=''){
        $conditionString.=" and r.create_time>=".strtotime(trim($condition['startTime_create']));
     }
     if(trim($condition['endTime_create'])!=''){
        $endTime=strtotime(trim($condition['endTime_create']));
        $endTime=$endTime+60*60*24;
        $conditionString.=" and r.create_time<=".$endTime;
     }
     if(trim($condition['estateName'])!=''){
        $conditionString.=" and h.estate_name like '".str_replace("'", "", trim($condition['estateName']))."%' ";
     }
     if($condition['roomStatus']!=''){
        //出租状态，删除状态
        if($condition['roomStatus']=="del"){
          $conditionString.=" and r.record_status=0 ";
        }else{
          $conditionString.=" and h.record_status=1 and r.record_status=1 ";
          $conditionString.=" and r.status=".$condition['roomStatus'];
        }
     }
     if(trim($condition['roomNo'])!=''){
        $conditionString.=" and r.room_no='".str_replace("'", "", trim($condition['roomNo']))."' ";
     }
     if(trim($condition['business_type'])!=''){
        $conditionString.=" and h.business_type='".trim($condition['business_type'])."' ";
     }
     if(trim($condition['clientPhone'])!=''){
        $conditionString.=" and h.client_phone='".str_replace("'", "", trim($condition['clientPhone']))."' ";
     }
     if(trim($condition['create_man'])!=''){
        $conditionString.=" and r.create_man='".str_replace("'", "", trim($condition['create_man']))."' ";
     }
     if($condition['update_man']!=''){
        $conditionString.=" and r.update_man='".$condition['update_man']."' ";
     }
     if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
        $conditionString.=" and h.info_resource_type=".$condition['info_resource_type'];
     }
     if(trim($condition['info_resource'])!=''){
        if($condition['info_resource']=="空"){
          $conditionString.=" and h.info_resource='' ";
        }else{
          $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
        }
     }
      //租金
     if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
        if(is_numeric($condition['moneyMin'])){
          $conditionString.=" and r.room_money>=".$condition['moneyMin'];
        }
     }
     if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
        if(is_numeric($condition['moneyMax'])){
          $conditionString.=" and r.room_money<=".$condition['moneyMax'];
        }
     }
    //房间面积
     if(isset($condition['roomareaMin']) && $condition['roomareaMin']!=""){
        if(is_numeric($condition['roomareaMin'])){
          $conditionString.=" and r.room_area>=".$condition['roomareaMin'];
        }
     }
     if(isset($condition['roomareaMax']) && $condition['roomareaMax']!=""){
        if(is_numeric($condition['roomareaMax'])){
          $conditionString.=" and r.room_area<=".$condition['roomareaMax'];
        }
     }
     if(isset($condition['brand_type']) && $condition['brand_type']!=''){
        if($condition['brand_type']=='none'){
           $conditionString.=" and h.brand_type=''";
        }else if($condition['brand_type']=='all'){
           $conditionString.=" and h.brand_type<>''";
        }else{
            $conditionString.=" and h.brand_type='".$condition['brand_type']."' ";
        }
     }
     if(trim($condition['region'])!=''){
        $conditionString.=" and h.region_id='".trim($condition['region'])."' ";
     }
     if(trim($condition['scope'])!=''){
        $conditionString.=" and h.scope_id='".trim($condition['scope'])."' ";
     }
     #联系房东和帮我预约设置
     if(isset($condition['callclient']) && $condition['callclient']!=""){
      $conditionString.=" and r.show_call_bar=".$condition['callclient'];
     }
     if(isset($condition['appoint']) && $condition['appoint']!=""){
      $conditionString.=" and r.show_reserve_bar=".$condition['appoint'];
     }
      if(isset($condition['isAgent']) && $condition['isAgent']!=''){
        if($condition['isAgent']=='1'){
          $conditionString.=" and h.is_owner=5";
        }else{
          $conditionString.=" and h.is_owner<5";
        }
      }
      //佣金包月
      if(isset($condition['isComm']) && $condition['isComm']!=""){
         $conditionString.=" and r.is_commission=".$condition['isComm'];
      }
      if(isset($condition['isMonth']) && $condition['isMonth']!=''){
         $conditionString.=" and r.is_monthly=".$condition['isMonth'];
      }
      if(isset($condition['rentType']) && $condition['rentType']!=""){
          $conditionString.=" and h.rent_type=".$condition['rentType'];
      }
      if(isset($condition['roomName']) && $condition['roomName']!=""){
          $conditionString.=" and r.room_name='".$condition['roomName']."'";
      }
     return $conditionString.' ';
  }
    #搜索条件（已发布列表）
    private function getConditionForHadfabu($condition){
       $conditionString="";
       if(isset($condition['startTime']) && !empty($condition['startTime'])){
          $conditionString.=" and r.update_time>=".strtotime($condition['startTime']);
       }
       if(isset($condition['endTime']) && !empty($condition['endTime'])){
          $endTime=strtotime($condition['endTime'])+60*60*24;
          $conditionString.=" and r.update_time<=".$endTime;
       }
       //创建时间
       if(isset($condition['startTime_create']) && !empty($condition['startTime_create'])){
          $conditionString.=" and r.create_time>=".strtotime(trim($condition['startTime_create']));
       }
       if(isset($condition['endTime_create']) && trim($condition['endTime_create'])!=''){
          $endTime=strtotime(trim($condition['endTime_create']));
          $endTime=$endTime+60*60*24;
          $conditionString.=" and r.create_time<=".$endTime;
       }

       if(isset($condition['roomStatus']) && $condition['roomStatus']!=''){
          //出租状态，删除状态
          if($condition['roomStatus']=="del"){
            $conditionString.=" and r.record_status=0 ";
          }else{
            $conditionString.=" and h.record_status=1 and r.record_status=1 ";
            $conditionString.=" and r.status=".$condition['roomStatus'];
          }
       }
       if(isset($condition['roomNo']) && !empty($condition['roomNo'])){
          $conditionString.=" and r.room_no='".$condition['roomNo']."' ";
       }
     
       if(isset($condition['create_man']) && !empty($condition['create_man'])){
          $conditionString.=" and r.create_man='".$condition['create_man']."' ";
       }
       if(isset($condition['update_man']) && $condition['update_man']!=''){
          $conditionString.=" and r.update_man='".$condition['update_man']."' ";
       }
       if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
          $conditionString.=" and r.info_resource_type=".$condition['info_resource_type'];
       }
       if(isset($condition['info_resource']) && trim($condition['info_resource'])!=''){
          if($condition['info_resource']=="空"){
            $conditionString.=" and r.info_resource='' ";
          }else{
            $conditionString.=" and r.info_resource='".trim($condition['info_resource'])."' ";
          }
       }
        //租金
       if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
          if(is_numeric($condition['moneyMin'])){
            $conditionString.=" and r.room_money>=".$condition['moneyMin'];
          }
       }
       if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
          if(is_numeric($condition['moneyMax'])){
            $conditionString.=" and r.room_money<=".$condition['moneyMax'];
          }
       }
      //房间面积
       if(isset($condition['roomareaMin']) && $condition['roomareaMin']!=""){
          if(is_numeric($condition['roomareaMin'])){
            $conditionString.=" and r.room_area>=".$condition['roomareaMin'];
          }
       }
       if(isset($condition['roomareaMax']) && $condition['roomareaMax']!=""){
          if(is_numeric($condition['roomareaMax'])){
            $conditionString.=" and r.room_area<=".$condition['roomareaMax'];
          }
       }
       if(isset($condition['estateName']) && $condition['estateName']!=''){
          $conditionString.=" and o.estate_name like '".$condition['estateName']."%' ";
       }
       if(isset($condition['clientPhone']) && $condition['clientPhone']!=''){
          $conditionString.=" and o.client_phone = '".$condition['clientPhone']."' ";
       }
       #联系房东和帮我预约设置
       if(isset($condition['callclient']) && $condition['callclient']!=""){
        $conditionString.=" and r.show_call_bar=".$condition['callclient'];
       }
       if(isset($condition['appoint']) && $condition['appoint']!=""){
        $conditionString.=" and r.show_reserve_bar=".$condition['appoint'];
       }
     
       if(isset($condition['is_recommend']) && $condition['is_recommend']!=""){
          if($condition['is_recommend']=="1"){
              $conditionString.=" and o.recommend_time>=(unix_timestamp(now())-3600*72) ";//3天之内就算
          }else if($condition['is_recommend']=="2"){
              $conditionString.=" and o.recommend_time<(unix_timestamp(now())-3600*72) ";
          }
       } 
       if(isset($condition['is_true']) && $condition['is_true']!=""){
          if($condition['is_true']=="1"){
              $conditionString.=" and o.true_time>0 ";
          }else if($condition['is_true']=="2"){
              $conditionString.=" and o.true_time=0 ";
          }
       }
        //发布时间
       if(isset($condition['startTime_fabu']) && trim($condition['startTime_fabu'])!=''){
          $conditionString.=" and o.create_time>=".strtotime(trim($condition['startTime_fabu']));
       }
       if(isset($condition['endTime_fabu']) && trim($condition['endTime_fabu'])!=''){
          $endTime=strtotime(trim($condition['endTime_fabu']));
          $endTime=$endTime+60*60*24;
          $conditionString.=" and o.create_time<=".$endTime;
       }
       return $conditionString.' ';
    }
   //读取对应城市下58帐号
   public function getWubaAccount(){
     $dal=new \Home\Model\openapipush();
     return $dal->getWubaAccount();
   }

   /*百姓API */
    public function getNotfabuList_baixing($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionString($condition);
     $modelDal=new \Home\Model\openapipush();
     return $modelDal->getNotfabuListByType(2,$conditionString,$limit_start,$limit_end);
   }
    public function getModelListCount_baixing($condition){
     $conditionString=$this->getConditionForHadfabu($condition);
     $modelDal=new \Home\Model\openapipush();
     $result = $modelDal->getModelListCountByType(2,$conditionString);
     if($result!=null && count($result)>0){
        return $result[0]['totalCount'];
     }
     return 0;
   }
   public function getModelList_baixing($condition,$limit_start,$limit_end){
     $conditionString=$this->getConditionForHadfabu($condition);
     $modelDal=new \Home\Model\openapipush();
     return $modelDal->getModelListByType(2,$conditionString,$limit_start,$limit_end);
   }
   public function addOpenapipushMore_baixing($ids_string,$login_name,$user_array)
    {
        $brand_name='嗨住租房--';
        $brand_desc='嗨住  ，一款不收中介费，直呼房东，免费预约，并提供各类服务的专业租住APP<br>$room_description$<br>查看此房源详细信息，请复制下面的地址在浏览器中打开：<a href="http://www.hizhu.com/$city_code$/roomDetail/$room_id$.html">http://www.hizhu.com/$city_code$/roomDetail/$room_id$.html</a><br>查看更多最新房源，请访问：http://www.hizhu.com/$city_code$ | 嗨住！愿，你住的好一点';
       
        $count=0;
        $dal=new \Home\Model\openapipush();
        $ids_array=explode(',', $ids_string);
        foreach ($ids_array as $key => $value) {
            if(empty($value)){
                continue;
            }
            $model['room_id']=$value;
            $roomModel=$dal->getHouseroomByRoomid($value);//房间
            if($roomModel===null || $roomModel===false || count($roomModel)==0){
                continue;
            }
            $model['resource_id']=$roomModel[0]['resource_id'];
            $resourceModel=$dal->getHouseResourceByResourceid($model['resource_id']);//房源
            if($resourceModel===null || $resourceModel===false || count($resourceModel)==0){
                continue;
            }
            $title_desc=$brand_name;//标题
            $room_desc=$brand_desc;//描述
            $title_array=array();
            $subwayModel=$dal->getSubwayByEstateid($resourceModel[0]['estate_id']);//地铁
            if($subwayModel!==null && $subwayModel!==false && count($subwayModel)>0){
                $subwayline=$subwayModel[0]['subwayline_name'];
                $title_array[]='温馨可爱的小房间,交通也很便利，格局也很好';
                $title_array[]='精装卧室，小区环境优雅，交通便利';
                $title_array[]='新装卧室步行'.$subwayline.'5分钟,家具齐全拎包入住';
                $title_array[]='步行'.$subwayline.'5分钟，烫金地段绿化率高';
                $title_array[]='周边生活便捷，地铁'.$subwayline.'精装小屋';
                $title_array[]='真正的拎包入住，精装全配，'.$subwayline.'直达';
                $title_array[]='精品卧室，地铁沿线，全新装修';
            }
            if($roomModel[0]['room_direction']=="1009"){
                $title_array[]='温馨朝南卧室，南北通透阳光充足';
                $title_array[]='朝南房间采光好空间大，小区绿化好';
                $title_array[]='温馨朝南房间，小区安静安全';
                $title_array[]='独立朝南卧室,小区地段超好,阳光房';
                $title_array[]='朝南卧室，格调优雅,即可拎包入住';
                $title_array[]='毕业生首选房，家电齐全，小区环境也很好';
                $title_array[]='朝南采光好,优质电梯房,随时看房';
            }
            if(strpos($roomModel[0]['room_equipment'], '1111')!==false){
                $title_array[]='带阳台的精装修卧室，阳光充足视野好';
                $title_array[]='宽大温馨主卧,有阳台可晾晒';
                $title_array[]='非常干净舒服的房间,有阳台,冬暖夏凉';
                $title_array[]='房屋配置原房东自住房,家用电器齐全';
                $title_array[]='独立阳台的主卧阳光充足视野开阔';
                $title_array[]='精装大主卧，舒适布局，黄金楼层';
                $title_array[]='花园洋房，景观好，楼层好，市场价，好房不等人';
            }
            if(strpos($resourceModel[0]['public_equipment'], '0309')!==false){
                $title_array[]='可做饭的房间，生活配套齐全,居住环境舒适';
                $title_array[]='可做饭的小屋，干净宽敞舒适，阳光通透';
                $title_array[]='民以食为天，可做饭的精装修卧室出租';
                $title_array[]='精装全配，看房方便，家电全配，拎包入住';
                $title_array[]='高档社区，景观好房，快来电，马上有房';
            }
            if(strpos($roomModel[0]['room_name'], '主卧')!==false){
                $title_array[]='朝'.$roomModel[0]['room_direction'].'主卧，带空调，性价比高';
               $title_array[]='好房要淘，好房急租，赶紧来电~~~';
               $title_array[]='温馨舒适采光好，室友超nice!!!非常适合应届生！！！';
               $title_array[]='精装大标间 舒适温馨的布局 黄金楼层';
               $title_array[]='精装修 欧洲现代风格 拎包入住';
               $title_array[]='超值装修 拎包入住 省钱省心 交通便利 购物方便';
               $title_array[]='个人出租 优质单间 家具齐全 全新装修';
               $title_array[]='精装全配，喧嚣的城市中属于自己的那一片宁静';
            }
            $title_array[]='【非中介】【即可入住】【宜家装修】【拎包入住】';
            $title_array[]='换房的好时候到了,主次卧优惠出租,阳光晒满房间温馨';
            $title_array[]='信用入住,品牌保证,品质看得见,入住还有优惠哦 ';
            $title_array[]='畅想浪漫花园洋房生活,交通也超方便';
            $title_array[]='周边配套周边设有丰富的配套设施，充分满足你的生活';
            $title_array[]='高端社区纵享奢华,肆意生活,风景宜人。';
        
            $array_count=count($title_array);
            if($array_count==0){
                $title_desc=$title_desc.'温馨独立房间，小区安静安全';
            }else{
                $title_desc=$title_desc.$title_array[rand(0,$array_count-1)];
            }
            $model['title_desc']=$title_desc;
            $model['ad_desc']='';
            if(!empty($roomModel[0]['room_description'])){
                $room_desc=str_replace('$room_description$', '房源简介<br>'.$roomModel[0]['room_description'], $room_desc);
            }else{
                $room_desc=str_replace('$room_description$', '', $room_desc);
            }
            $city_code='shanghai';
            if(C('CITY_CODE')=="001001"){
                $city_code='beijing';
            }else  if(C('CITY_CODE')=="001011001"){
                $city_code='hangzhou';
            }
            $room_desc=str_replace('$city_code$', $city_code, $room_desc);
            $room_desc=str_replace('$room_id$', $model['room_id'], $room_desc);         
            $model['room_desc']=$room_desc;
            $model['create_time']=time();
            $model['create_man']=$login_name;
            $model['third_type']=2;
            $model['estate_name']=$resourceModel[0]['estate_name'];
            $model['client_phone']=$resourceModel[0]['client_phone'];
            foreach ($user_array as $user_key => $user_value) {
                if(!empty($user_value)){
                    $model['userid']=$user_value;
                    $result=$dal->addModel($model);
                }
            }
            $count=$result?($count+1):$count;
        }
        return $count;
    }

     /* 58品牌馆 & 其他 */
     public function getNotfabuListByType($third_type,$condition,$limit_start,$limit_end){
      $conditionString=$this->getConditionString($condition);
      $modelDal=new \Home\Model\openapipush();
      return $modelDal->getNotfabuListByType($third_type,$conditionString,$limit_start,$limit_end);
    }
     public function getModelListCountByType($third_type,$condition){
      $conditionString=$this->getConditionForHadfabu($condition);
      $modelDal=new \Home\Model\openapipush();
      $result = $modelDal->getModelListCountByType($third_type,$conditionString);
      if($result!=null && count($result)>0){
         return $result[0]['totalCount'];
      }
      return 0;
    }
    public function getModelListByType($third_type,$condition,$limit_start,$limit_end){
      $conditionString=$this->getConditionForHadfabu($condition);
      $modelDal=new \Home\Model\openapipush();
      return $modelDal->getModelListByType($third_type,$conditionString,$limit_start,$limit_end);
    }
    public function addOpenapipushMoreByType($third_type,$ids_string,$login_name,$user_array,$brand_desc='$room_description$',$image_limit_min=0,$ad_desc='')
     {
         $brand_name='嗨住租房--';
         $count=0;
         $dal=new \Home\Model\openapipush();
         $ids_array=explode(',', $ids_string);
         foreach ($ids_array as $key => $value) {
             if(empty($value)){
                 continue;
             }
             $model['room_id']=$value;
             $roomModel=$dal->getHouseroomByRoomid($value);//房间
             if($roomModel==null || $roomModel==false || count($roomModel)==0){
                 continue;
             }
             if($image_limit_min>0){
                $imgList=$dal->getRoomImageByRoomid($value);//房间图片
                if($imgList==null || $imgList==false || count($imgList)<$image_limit_min){
                    file_put_contents('openapi-log.txt', date('Y-m-d H:i:s')."：addOpenapipushMoreByType方法，图片限制，room_id=".$value."\r\n",FILE_APPEND);
                    continue;
                }
             }
           
             $model['resource_id']=$roomModel[0]['resource_id'];
             $resourceModel=$dal->getHouseResourceByResourceid($model['resource_id']);//房源
             if($resourceModel==null || $resourceModel==false || count($resourceModel)==0){
                 continue;
             }
             $title_desc=$brand_name;//标题
             $room_desc=$brand_desc;//描述
             $title_array=array();
            if($third_type<5){
               if($roomModel[0]['room_direction']=="1009"){
                   $title_array[]='温馨朝南卧室，南北通透阳光充足';
                   $title_array[]='朝南房间采光好空间大，小区绿化好';
                   $title_array[]='温馨朝南房间，小区安静安全';
                   $title_array[]='独立朝南卧室,小区地段超好,阳光房';
                   $title_array[]='朝南卧室，格调优雅,即可拎包入住';
                   $title_array[]='家电齐全，小区环境也很好';
                   $title_array[]='朝南采光好,优质电梯房,随时看房';
               }
               if(strpos($roomModel[0]['room_equipment'], '1111')!==false){
                   $title_array[]='带阳台的精装修卧室，阳光充足视野好';
                   $title_array[]='宽大温馨主卧,有阳台可晾晒';
                   $title_array[]='非常干净舒服的房间,有阳台,冬暖夏凉';
                   $title_array[]='房屋配置原房东自住房,家用电器齐全';
                   $title_array[]='独立阳台的主卧阳光充足视野开阔';
                   $title_array[]='精装大主卧，舒适布局，阳光充沛';
                   $title_array[]='花园洋房，景观好，楼层好，市场价，好房不等人';
               }
               if(strpos($resourceModel[0]['public_equipment'], '0309')!==false){
                   $title_array[]='可做饭的房间，生活配套齐全,居住环境舒适';
                   $title_array[]='可做饭的小屋，干净宽敞舒适，阳光通透';
                   $title_array[]='民以食为天，可做饭的精装修卧室出租';
                   $title_array[]='精装全配，看房方便，家电全配，拎包入住';
                   $title_array[]='高档社区，景观好房，快来电，马上有房';
               }
               if(strpos($roomModel[0]['room_name'], '主卧')!==false){
                  $title_array[]='朝'.$roomModel[0]['room_direction'].'主卧，带空调，性价比高';
                  $title_array[]='好房要淘，好房急租，赶紧来电~~~';
                  $title_array[]='温馨舒适采光好，室友超nice!!!';
                  $title_array[]='精装大标间 舒适温馨的布局 阳光充沛';
                  $title_array[]='精装修 欧洲现代风格 拎包入住';
                  $title_array[]='超值装修 拎包入住 省钱省心 交通便利 购物方便';
                  $title_array[]='个人出租 优质单间 家具齐全 全新装修';
                  $title_array[]='精装全配，喧嚣的城市中属于自己的那一片宁静';
               }
               $title_array[]='【非中介】【即可入住】【宜家装修】【拎包入住】';
               $title_array[]='换房的好时候到了,主次卧优惠出租,阳光晒满房间温馨';
               $title_array[]='信用入住,品牌保证,品质看得见,入住还有优惠哦 ';
               $title_array[]='畅想浪漫花园洋房生活,交通也超方便';
               $title_array[]='周边配套周边设有丰富的配套设施，充分满足你的生活';
               $title_array[]='高端社区纵享奢华,肆意生活,风景宜人。';
               $array_count=count($title_array);
               if($array_count==0){
                   $title_desc=$title_desc.'温馨独立房间，小区安静安全';
               }else{
                   $title_desc=$title_desc.$title_array[rand(0,$array_count-1)];
               }
            }else{
                $title_array[]='非中介即可入住宜家装修拎包入住';
                $title_array[]='换房的好时候到了主次卧优惠出租阳光晒满房间温馨';
                $title_array[]='信用入住品牌保证品质看得见入住还有优惠哦';
                $title_array[]='畅想浪漫花园洋房生活交通也超方便';
                $title_array[]='周边配套周边设有丰富的配套设施充分满足你的生活';
                $title_array[]='高端社区纵享奢华肆意生活风景宜人';
                $title_array[]='温馨卧室南北通透阳光充足';
                $title_array[]='房间采光好空间大小区绿化好';
                $title_array[]='温馨房间小区安静安全';
                $title_array[]='独立卧室小区地段好阳光房';
                $title_array[]='格调优雅即可拎包入住';
                $title_array[]='毕业生首选房家电齐全小区环境也很好';
                $title_array[]='采光好优质电梯房随时看房';
                $title_array[]='宽大温馨卧室阳光充足视野好';
                $title_array[]='非常干净舒服的房间冬暖夏凉';
                $title_array[]='房屋配置原房东自住房家用电器齐全';
                $title_array[]='精装主卧舒适布局黄金楼层';
                $title_array[]='花园洋房景观好楼层好市场价好房不等人';
                $title_array[]='温馨舒适采光好室友超nice非常适合应届生';
                $title_array[]='大标间舒适温馨的布局黄金楼层';
                $title_array[]='精装修欧洲现代风格拎包入住';
                $title_array[]='超值装修拎包入住省钱省心交通便利购物方便';
                $title_array[]='个人出租优质单间家具齐全全新装修';
                $title_array[]='精装全配喧嚣的城市中属于自己的那一片宁静';
                $array_count=count($title_array);
                $title_desc='嗨住租房'.$title_array[rand(0,$array_count-1)];
            }
             
             $model['title_desc']=$title_desc;
             $model['ad_desc']=$ad_desc;
             if(!empty($roomModel[0]['room_description'])){
                 $room_desc=$roomModel[0]['room_description'];
             }else{
                 $room_desc='让你生活无拘无束无压力，房源常年出租。在这里体现你的个性；在这里邂逅你的生活；在这里邂逅你的生活；在这里实现你的梦想；在这里 你不再寂寞！！！交通方便，周边超市，KTV等生活设施应有尽有';
             }
             //TODO;新增城市
             switch (C('CITY_CODE')) {
               case '001001':
                 $city_code='beijing';
                 break;
               case '001011001':
                 $city_code='hangzhou';
                 break;
               case '001010001':
                 $city_code='nanjing';
                 break;
               case '001019002':
                 $city_code='shenzhen';
                 break;   
               default:
                 $city_code='shanghai';
                 break;
             }
             $room_desc=str_replace('$city_code$', $city_code, $room_desc);
             $room_desc=str_replace('$room_id$', $model['room_id'], $room_desc);         
             $model['room_desc']=$room_desc;
             $desc_length=mb_strlen($room_desc,'UTF8');

             if($desc_length>500){
                file_put_contents('openapi-log.txt', date('Y-m-d H:i:s')."：addOpenapipushMoreByType方法，描述限制，length=".$desc_length."\r\n",FILE_APPEND);
                continue;//描述长度限制
             }
             $model['create_time']=time();
             $model['create_man']=$login_name;
             $model['third_type']=$third_type;
             $model['estate_name']=$resourceModel[0]['estate_name'];
             $model['client_phone']=$resourceModel[0]['client_phone'];
             foreach ($user_array as $user_key => $user_value) {
                 if(!empty($user_value)){
                     $model['userid']=$user_value;
                     $result=$dal->addModel($model);
                 }
             }
             $count=$result?($count+1):$count;
         }
         return $count;
     }

     /*搜房API */
     public function getNotfabuList_soufang($condition,$limit_start,$limit_end){
      $conditionString=$this->getConditionString($condition);
      $modelDal=new \Home\Model\openapipush();
      return $modelDal->getNotfabuListByType(3,$conditionString,$limit_start,$limit_end);
    }
     public function getModelListCount_soufang($condition){
      $conditionString=$this->getConditionForHadfabu($condition);
      $modelDal=new \Home\Model\openapipush();
      $result = $modelDal->getModelListCountByType(3,$conditionString);
      if($result!=null && count($result)>0){
         return $result[0]['totalCount'];
      }
      return 0;
    }
    public function getModelList_soufang($condition,$limit_start,$limit_end){
      $conditionString=$this->getConditionForHadfabu($condition);
      $modelDal=new \Home\Model\openapipush();
      return $modelDal->getModelListByType(3,$conditionString,$limit_start,$limit_end);
    }
    public function addOpenapipushMore_soufang($ids_string,$login_name,$user_array)
     {
         $brand_name='嗨住租房--';
         $brand_desc='嗨住  ，一款不收中介费，直呼房东，免费预约，并提供各类服务的专业租住APP<br>$room_description$<br>查看此房源详细信息，请复制下面的地址在浏览器中打开：<a href="http://www.hizhu.com/$city_code$/roomDetail/$room_id$.html">http://www.hizhu.com/$city_code$/roomDetail/$room_id$.html</a><br>查看更多最新房源，请访问：http://www.hizhu.com/$city_code$ | 嗨住！愿，你住的好一点';
         $count=0;
         $dal=new \Home\Model\openapipush();
         $ids_array=explode(',', $ids_string);
         foreach ($ids_array as $key => $value) {
             if(empty($value)){
                 continue;
             }
             $model['room_id']=$value;
             $roomModel=$dal->getHouseroomByRoomid($value);//房间
             if($roomModel===null || $roomModel===false || count($roomModel)==0){
                 continue;
             }
             $model['resource_id']=$roomModel[0]['resource_id'];
             $resourceModel=$dal->getHouseResourceByResourceid($model['resource_id']);//房源
             if($resourceModel===null || $resourceModel===false || count($resourceModel)==0){
                 continue;
             }
             $title_desc=$brand_name;//标题
             $room_desc=$brand_desc;//描述
             $title_array=array();
             $subwayModel=$dal->getSubwayByEstateid($resourceModel[0]['estate_id']);//地铁
             if($subwayModel!==null && $subwayModel!==false && count($subwayModel)>0){
                 $subwayline=$subwayModel[0]['subwayline_name'];
                 $title_array[]='温馨可爱的小房间,交通也很便利，格局也很好';
                 $title_array[]='精装卧室，小区环境优雅，交通便利';
                 $title_array[]='新装卧室步行'.$subwayline.'5分钟,家具齐全拎包入住';
                 $title_array[]='步行'.$subwayline.'5分钟，烫金地段绿化率高';
                 $title_array[]='周边生活便捷，地铁'.$subwayline.'精装小屋';
                 $title_array[]='真正的拎包入住，精装全配，'.$subwayline.'直达';
                 $title_array[]='精品卧室，地铁沿线，全新装修';
             }
             if($roomModel[0]['room_direction']=="1009"){
                 $title_array[]='温馨朝南卧室，南北通透阳光充足';
                 $title_array[]='朝南房间采光好空间大，小区绿化好';
                 $title_array[]='温馨朝南房间，小区安静安全';
                 $title_array[]='独立朝南卧室,小区地段超好,阳光房';
                 $title_array[]='朝南卧室，格调优雅,即可拎包入住';
                 $title_array[]='毕业生首选房，家电齐全，小区环境也很好';
                 $title_array[]='朝南采光好,优质电梯房,随时看房';
             }
             if(strpos($roomModel[0]['room_equipment'], '1111')!==false){
                 $title_array[]='带阳台的精装修卧室，阳光充足视野好';
                 $title_array[]='宽大温馨主卧,有阳台可晾晒';
                 $title_array[]='非常干净舒服的房间,有阳台,冬暖夏凉';
                 $title_array[]='房屋配置原房东自住房,家用电器齐全';
                 $title_array[]='独立阳台的主卧阳光充足视野开阔';
                 $title_array[]='精装大主卧，舒适布局，黄金楼层';
                 $title_array[]='花园洋房，景观好，楼层好，市场价，好房不等人';
             }
             if(strpos($resourceModel[0]['public_equipment'], '0309')!==false){
                 $title_array[]='可做饭的房间，生活配套齐全,居住环境舒适';
                 $title_array[]='可做饭的小屋，干净宽敞舒适，阳光通透';
                 $title_array[]='民以食为天，可做饭的精装修卧室出租';
                 $title_array[]='精装全配，看房方便，家电全配，拎包入住';
                 $title_array[]='高档社区，景观好房，快来电，马上有房';
             }
             if(strpos($roomModel[0]['room_name'], '主卧')!==false){
                 $title_array[]='朝'.$roomModel[0]['room_direction'].'主卧，带空调，性价比高';
                $title_array[]='好房要淘，好房急租，赶紧来电~~~';
                $title_array[]='温馨舒适采光好，室友超nice!!!非常适合应届生！！！';
                $title_array[]='精装大标间 舒适温馨的布局 黄金楼层';
                $title_array[]='精装修 欧洲现代风格 拎包入住';
                $title_array[]='超值装修 拎包入住 省钱省心 交通便利 购物方便';
                $title_array[]='个人出租 优质单间 家具齐全 全新装修';
                $title_array[]='精装全配，喧嚣的城市中属于自己的那一片宁静';
             }
         $title_array[]='【非中介】【即可入住】【宜家装修】【拎包入住】';
         $title_array[]='换房的好时候到了,主次卧优惠出租,阳光晒满房间温馨';
         $title_array[]='信用入住,品牌保证,品质看得见,入住还有优惠哦 ';
         $title_array[]='畅想浪漫花园洋房生活,交通也超方便';
         $title_array[]='周边配套周边设有丰富的配套设施，充分满足你的生活';
         $title_array[]='高端社区纵享奢华,肆意生活,风景宜人。';
             $array_count=count($title_array);
             if($array_count==0){
                 $title_desc=$title_desc.'温馨独立房间，小区安静安全';
             }else{
                 $title_desc=$title_desc.$title_array[rand(0,$array_count-1)];
             }
             $model['title_desc']=$title_desc;
             $model['ad_desc']='';
             if(!empty($roomModel[0]['room_description'])){
                 $room_desc=str_replace('$room_description$', '房源简介<br>'.$roomModel[0]['room_description'], $room_desc);
             }else{
                 $room_desc=str_replace('$room_description$', '', $room_desc);
             }
             $city_code='shanghai';
             if(C('CITY_CODE')=="001001"){
                 $city_code='beijing';
             }else  if(C('CITY_CODE')=="001011001"){
                 $city_code='hangzhou';
             }
             $room_desc=str_replace('$city_code$', $city_code, $room_desc);
             $room_desc=str_replace('$room_id$', $model['room_id'], $room_desc);         
             $model['room_desc']=$room_desc;
             $model['create_time']=time();
             $model['create_man']=$login_name;
             $model['third_type']=3;
             $model['estate_name']=$resourceModel[0]['estate_name'];
             $model['client_phone']=$resourceModel[0]['client_phone'];
             foreach ($user_array as $user_key => $user_value) {
                 if(!empty($user_value)){
                     $model['userid']=$user_value;
                     $result=$dal->addModel($model);
                 }
             }
             $count=$result?($count+1):$count;
         }
         return $count;
     }


     /*可租列表筛选发布 */
     public function getFabuCount($condition){
        $conditionString=$this->convertFabuCondition($condition);
        $modelDal=new \Home\Model\openapipush();
        $result = $modelDal->getNotfabuData(" count(1) as totalCount ",$conditionString,"");
        if($result!=null && count($result)>0){
           return $result[0]['totalCount'];
        }
        return 0;
     }
     public function getFabuList($condition,$limit_start,$limit_end){
        $conditionString=$this->convertFabuCondition($condition);
        $modelDal=new \Home\Model\openapipush();
        $list = $modelDal->getNotfabuData(" h.house_no,h.info_resource,h.estate_name,h.region_name,h.scope_name,h.client_phone,r.room_no,r.room_name,r.room_area,r.room_money,r.id as room_id ",$conditionString," order by r.update_time desc,r.id desc limit $limit_start,$limit_end");
        return $list;
     }
    private function convertFabuCondition($condition){

        $conditionString=" and h.record_status=1 and r.record_status=1 and r.status=2 and r.city_code='".C('CITY_CODE')."' ";
       
        if(isset($condition['estateName']) && $condition['estateName']!=''){
           $conditionString.=" and h.estate_name like '".$condition['estateName']."%' ";
        }
       
        if(isset($condition['roomNo']) && $condition['roomNo']!=''){
           $conditionString.=" and r.room_no='".$condition['roomNo']."'";
        }
        if(isset($condition['clientPhone']) && $condition['clientPhone']!=''){
           $conditionString.=" and h.client_phone='".$condition['clientPhone']."'";
        }
        if(isset($condition['info_resource_type']) && trim($condition['info_resource_type'])!=''){
           $conditionString.=" and h.info_resource_type=".$condition['info_resource_type'];
        }
        if(trim($condition['info_resource'])!=''){
           if($condition['info_resource']=="空"){
             $conditionString.=" and h.info_resource='' ";
           }else{
             $conditionString.=" and h.info_resource='".trim($condition['info_resource'])."' ";
           }
        }
         //租金
        if(isset($condition['moneyMin']) && $condition['moneyMin']!=""){
           if(is_numeric($condition['moneyMin'])){
             $conditionString.=" and r.room_money>=".$condition['moneyMin'];
           }
        }
        if(isset($condition['moneyMax']) && $condition['moneyMax']!=""){
           if(is_numeric($condition['moneyMax'])){
             $conditionString.=" and r.room_money<=".$condition['moneyMax'];
           }
        }
        if(isset($condition['region']) && $condition['region']!=''){
           $conditionString.=" and h.region_id=".$condition['region'];
        }
        if(isset($condition['scope']) && $condition['scope']!=''){
           $conditionString.=" and h.scope_id=".$condition['scope'];
        }
        if(isset($condition['isAgent']) && $condition['isAgent']!=''){
          if($condition['isAgent']=='1'){
            $conditionString.=" and h.is_owner=5";
          }else{
            $conditionString.=" and h.is_owner<5";
          }
        }
        //佣金包月
        if(isset($condition['isComm']) && $condition['isComm']!=""){
           $conditionString.=" and r.is_commission=".$condition['isComm'];
        }
        if(isset($condition['isMonth']) && $condition['isMonth']!=''){
           $conditionString.=" and r.is_monthly=".$condition['isMonth'];
        }
        if(isset($condition['rentType']) && $condition['rentType']!=""){
            $conditionString.=" and h.rent_type=".$condition['rentType'];
        }
        if(isset($condition['roomName']) && $condition['roomName']!=""){
            $conditionString.=" and r.room_name='".$condition['roomName']."'";
        }
        return $conditionString.' ';
    }

}	
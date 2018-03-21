<?php
namespace Home\Controller;
use Think\Controller;
class HouseOfferController extends Controller {
    /*报价审核 start*/

    //列表
    public function quotationAuditList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()) {
           return $this->error('非法操作',U('Index/index'),1);
       }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(getLoginName(),3);
       $menu_left_html=$handleMenu->menuLeft(getLoginName(),3);
       $handleMenu->jurisdiction();
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);

       $handleLogic = new \Logic\HouseofferLogic();
       $condition['mobile']=trim(I('get.mobile'));
       $condition['status_code']=isset($_GET['status_code'])?$_GET['status_code']:'0';
       $condition['totalCount']=I('get.totalCount');
       if($condition['totalCount']==''){
         $condition['totalCount']=0;
       }
       $list=array();$pageSHow='';
       if(I('get.p')=='' || $condition['totalCount']==0) {
          //总条数
           $condition['totalCount']=$handleLogic->getHouseofferAuditCount($condition);
       }
       if($condition['totalCount']>=1) {
         //分页
           $Page= new \Think\Page($condition['totalCount'],5);
           foreach($condition as $key=>$val){
             $Page->parameter[$key]=urlencode($val);
           }
           $pageSHow=$Page->show();
           $datalist = $handleLogic->getHouseofferAuditList($condition,$Page->firstRow,$Page->listRows);
           if($datalist!=null){
              $handleResource=new \Home\Model\houseresource();
              $handleRoom=new \Home\Model\houseroom();
              foreach ($datalist as $key => $value) {
                if(empty($value['house_id'])){
                  continue;
                }
                $temp_array=$value;
                #房源信息
                $houseData=$handleResource->getListByWhere("id='".$value['house_id']."' "," limit 1");
                if($houseData!=null && count($houseData)>0){
                   $temp_array['estate_name']=$houseData[0]['estate_name'];
                   $temp_array['region_name']=$houseData[0]['region_name'];
                   $temp_array['scope_name']=$houseData[0]['scope_name'];
                   $temp_array['house_no']=$houseData[0]['house_no'];
                }
                #房间信息
                $houseData=$handleRoom->getFieldsByWhere("room_no","id='".$value['room_id']."' limit 1");
                if($houseData!=null && count($houseData)>0){
                   $temp_array['room_no']=$houseData[0]['room_no'];
                }
                $list[]=$temp_array;
              }
           }
       } 
       $this->assign("pageSHow",$pageSHow);
       $this->assign("list",$list);
       $this->assign("totalCount",$condition['totalCount']);
       $this->display();
    }
    //审核页面
    public function quotationAudit(){
      header("Content-type:text/html; charset=utf-8");
      $id=trim(I('get.mid'));
      if($id==''){
        echo '参数异常';return;
      }
      //报价信息
      $handleLogic = new \Logic\HouseofferLogic();
      $offerModel=$handleLogic->getHouseofferById($id);
      if($offerModel==null){
        echo '数据不存在';return;
      }else if($offerModel['record_status']!=1){
        echo '已经删除了';return;
      }else if($offerModel['status_code']!=0){
        echo '已经审核过了';return;
      }
      $comm_price=$offerModel['commission_price'];
      if($offerModel['commission_type']==0){
        $comm_price=(intval($comm_price)/100).'%';
      }
      //房间信息
      $handleRoom = new \Logic\HouseRoomLogic();
      $roomModel=$handleRoom->getModelById($offerModel['room_id']);
      if($roomModel==null || $roomModel==false){
        echo '房间数据不存在';return;
      }
      $offerArray1=array('is_current'=>1,'room_price'=>$offerModel['room_price'],'comm_price'=>$comm_price,'company'=>'','name'=>'','phone'=>'','owner_mobile'=>$offerModel['owner_mobile']);
      $offerArray2=array('is_current'=>0,'room_price'=>$roomModel['room_money'],'comm_price'=>'','company'=>'','name'=>'','phone'=>'','owner_mobile'=>'');
      
      //房东信息，多个
      $handleCustomer=new \Logic\CustomerLogic();
      $customerModel=$handleCustomer->getModelById($offerModel['customer_id']);
      if($customerModel!=null && $customerModel!=false){
        $offerArray1['company']=$customerModel['agent_company_name'];
        $offerArray1['name']=$customerModel['true_name'];
        $offerArray1['phone']=$customerModel['mobile'];
      }
       $customerModel=$handleCustomer->getModelById($roomModel['customer_id']);
      if($customerModel!=null && $customerModel!=false && strtoupper($roomModel['customer_id'])!='08F796E4-84B9-0ECF-EA8B-C107427FBF4A'){
        $offerArray2['company']=$customerModel['agent_company_name'];
        $offerArray2['name']=$customerModel['true_name'];
        $offerArray2['phone']=$customerModel['mobile'];
      }
      $listArray[]=$offerArray1;
      $listArray[]=$offerArray2;
      $this->assign('list',$listArray);
      $this->display();
    }
    //审核提交
    public function quotationAuditSubmit(){
      header("content-type:text/html;charset=utf-8;");
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '请重新登录';return;
      }
      $id=trim(I('post.mid'));
      $type=trim(I('post.htype'));
      if($id==''){
        echo '参数异常';return;
      }
      if($type!=1 && $type!=3){
        echo '参数异常了';return;
      }
      //报价信息
      $handleLogic = new \Logic\HouseofferLogic();
      $offerModel=$handleLogic->getHouseofferById($id);
      if($offerModel==null){
        echo '数据不存在';return;
      }else if($offerModel['record_status']!=1){
        echo '已经删除了';return;
      }else if($offerModel['status_code']!=0){
        echo '已经审核过了';return;
      }
      $fail_reason='';
      if($type==1){
        $fail_reason=trim(I('post.reason'));
        $responseArr=$handleLogic->offerAuditFail($id,$handle_man,$fail_reason);
      }else{
        $responseArr=$handleLogic->offerAuditSuccess($id,$handle_man,$offerModel['room_id'],$offerModel['room_price'],$offerModel['customer_id']);
      }
      if($responseArr['status']=='200'){
        
        $handleLogic = new \Logic\HouseResourceLogic();
        $houseModel=$handleLogic->getModelById($offerModel['house_id']);
        $estate_name='';$room_num='';$room_money=$offerModel['room_price'];
        if($houseModel!=null && $houseModel!=false){
           $estate_name=$houseModel['estate_name'];
           $room_num=$houseModel['room_num'];
        }
        if($estate_name!=''){
          $handleLogic = new \Logic\CustomerNotifyLogic();
           $content='<font color="#666666">你对【'.$estate_name.'-'.$room_num.'室-'.$room_money.'元/月】房源的报价已通过审核，你可以在“报价管理”里查看</font>';
           if($type==1){
              $content='<font color="#666666">你对【'.$estate_name.'-'.$room_num.'室-'.$room_money.'元/月】房源的报价未通过审核，原因是“'.$fail_reason.'”，你可以在“报价管理”里查看</font>';
           }else{
              //给被报价房源房东推送消息
              $room_money=$responseArr['room_money'];
              $content_notice='<font color="#666666">你发布的【'.$estate_name.'-'.$room_num.'室-'.$room_money.'元/月】房源已被聚合，你可以在“报价管理”里查看</font>';
              $handleLogic->sendCustomerNotify($responseArr['customer_id'],1009,'系统消息',$content_notice,'您有1条系统消息');
           }
           //推送审核结果
           $handleLogic->sendCustomerNotify($offerModel['customer_id'],1009,'报价审核',$content,'您有1条报价审核信息');
        }
        echo '操作成功';
      }else{
        echo $responseArr['message'];
      }
    
    }
     /*报价审核 end*/


     /*聚合确认 start */
     //列表
    public function aggregationAuditList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()) {
           return $this->error('非法操作',U('Index/index'),1);
       }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(getLoginName(),3);
       $menu_left_html=$handleMenu->menuLeft(getLoginName(),3);
       $handleMenu->jurisdiction();
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);

       $handleLogic = new \Logic\HouseofferLogic();
      $condition['startTime']=trim(I('get.startTime'));
      $condition['endTime']=trim(I('get.endTime'));
       $condition['totalCount']=I('get.totalCount');
       if($condition['totalCount']==''){
         $condition['totalCount']=0;
       }
       $list=array();$pageSHow='';
       if(I('get.p')=='' || $condition['totalCount']==0) {
          //总条数
           $condition['totalCount']=$handleLogic->getAggregatAuditCount($condition);
       }
       if($condition['totalCount']>=1) {
         //分页
           $Page= new \Think\Page($condition['totalCount'],10);
           foreach($condition as $key=>$val){
             $Page->parameter[$key]=urlencode($val);
           }
           $pageSHow=$Page->show();
           $list = $handleLogic->getAggregatAuditList($Page->firstRow,$Page->listRows,$condition);
       }
       $this->assign("pageSHow",$pageSHow);
       $this->assign("list",$list);
       $this->assign("totalCount",$condition['totalCount']);
       $this->display();
    }
    //删除
    public function deleteAggregatAudit(){
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '请重新登录';return;
      }
      $room1_id=trim(I('post.room1_id'));
      $room2_id=trim(I('post.room2_id'));
      if($room1_id=='' || $room2_id==''){
        echo '参数异常';return;
      }
      $modelDal=new \Home\Model\houseoffer();
      $result=$modelDal->updateRoomimgSimilar(array('record_status'=>0,'update_time'=>time(),'update_man'=>$handle_man),"room1_id='$room1_id' and room2_id='$room2_id'");
      if($result){
        echo '操作成功';
      }else{
        echo '操作失败';
      }
    }
    //审核确认页面
    public function aggregationAudit(){
      header("content-type:text/html;charset=utf-8;");
      $id=trim(I('get.mid'));
      $room1_id=trim(I('get.room1_id'));
      $room2_id=trim(I('get.room2_id'));
      if($id=='' || $room1_id=='' || $room2_id==''){
        echo '参数异常';return;
      }
      $handleLogic = new \Logic\HouseofferLogic();
      $auditModel=$handleLogic->getAggregatAuditByid($id);
      if($auditModel==null){
        echo '数据不存在';return;
      }elseif($auditModel['if_repetition_confim']!=0){
        echo '已经操作过了';return;
      }elseif($auditModel['record_status']==0){
        echo '数据已经删除';return;
      }
      //核心数据
      $basicData1=$handleLogic->getCalculateBasicByRoomid($room1_id);
      if($basicData1==null){
        echo '聚合房源读取失败';return;
      }
      $basicData2=$handleLogic->getCalculateBasicByRoomid($room2_id);
      if($basicData2==null){
        echo '聚合房源读取失败';return;
      }
      /*if($basicData1['online_status']==1 && $basicData2['online_status']==1){
        echo '聚合失败，都是线上已有房源';return;
      }*/
      //聚合中间图
      $aggregatImg='';
      if($auditModel['mid_img_id']!=''){
        $imgDal=new \Home\Model\houseoffer();
        $aggregatImgData=$imgDal->getRoomimgSimilar("mid_img_id","room1_id='$room1_id' and room2_id='$room2_id' limit 6");
        $img_ids='';
        foreach ($aggregatImgData as $key => $value) {
          $img_ids.="'".$value['mid_img_id']."',";
        }
        if($img_ids!=''){
          $img_ids=rtrim($img_ids,',');
          $aggregatImgData= $imgDal->getAggregationImage("img_path,img_name,img_ext","id in ($img_ids) limit 6");
          foreach ($aggregatImgData as $k => $v) {
            $imgUrlsmall='http://120.26.204.164/imgrob/'.$v['img_path'].$v['img_name'].'_200_200.'.$v['img_ext'];
            $imgUrlbig='http://120.26.204.164/imgrob/'.$v['img_path'].$v['img_name'].'.'.$v['img_ext'];
            $aggregatImg.='<li><img src="'.$imgUrlsmall.'" onclick="showBigImage(\''.$imgUrlbig.'\')"></li>';    
          }
        }
      }
      
      $list[]=$basicData1;
      $list[]=$basicData2;
      $had_online=0;$main_id='';$had_online_offer=0;
      $imgList1='';$imgList2='';
      if($basicData1['online_status']==1 && $basicData2['online_status']==1){
        //都是线上已有房源
        $had_online=2;
        if(!in_array($basicData1['info_resource'], array('链家网','贞一','爱屋吉屋','我爱我家','中原地产'))){
          $main_id=$basicData1['room_id'];
        }elseif(!in_array($basicData2['info_resource'], array('链家网','贞一','爱屋吉屋','我爱我家','中原地产'))){
          $main_id=$basicData2['room_id'];
        }
        $handleImg=new \Logic\HouseImgLogic();
        $imgData=$handleImg->getModelByRoomId($room1_id);
        foreach ($imgData as $key => $value) {
          if($value['city_code']=='001009001'){
            $value["img_path"]='shanghai/'.$value["img_path"];
          }
          $imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
          $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
        }
        if($imgList1==''){
           $imgData=$handleLogic->getAggregationImgByRoomid($room1_id);
           foreach ($imgData as $key => $value) {
             $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
             $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
           }
        }
        $imgData=$handleImg->getModelByRoomId($room2_id);
         foreach ($imgData as $key => $value) {
           if($value['city_code']=='001009001'){
             $value["img_path"]='shanghai/'.$value["img_path"];
           }
           $imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
           $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
         }
         if($imgList2==''){
            $imgData=$handleLogic->getAggregationImgByRoomid($room2_id);
            foreach ($imgData as $key => $value) {
              $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
              $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
            }
         }

      }elseif($basicData1['online_status']==1){
        $had_online=1;$main_id=$room1_id;
         //线上房源图片
         $handleImg=new \Logic\HouseImgLogic();
         $imgData=$handleImg->getModelByRoomId($room1_id);
         foreach ($imgData as $key => $value) {
           if($value['city_code']=='001009001'){
             $value["img_path"]='shanghai/'.$value["img_path"];
           }
           $imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
           $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
         }
         if($imgList1==''){
            //线上房源是报价
            $had_online_offer=1;
            $imgData=$handleLogic->getAggregationImgByRoomid($room1_id);
            foreach ($imgData as $key => $value) {
              $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
              $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
            }
         }
         //抓取one
         $imgData=$handleLogic->getAggregationImgByRoomid($room2_id);
         foreach ($imgData as $key => $value) {
           $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
           $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
         }
      }elseif($basicData2['online_status']==1){
        $had_online=1;$main_id=$room2_id;
         //线上房源图片
         $handleImg=new \Logic\HouseImgLogic();
         $imgData=$handleImg->getModelByRoomId($room2_id);
         foreach ($imgData as $key => $value) {
           if($value['city_code']=='001009001'){
             $value["img_path"]='shanghai/'.$value["img_path"];
           }
           $imgUrl=C("IMG_SERVICE_URL").$value["img_path"].$value["img_name"].".".$value["img_ext"];
           $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
         }
         if($imgList2==''){
            //线上房源是报价
            $had_online_offer=1;
            $imgData=$handleLogic->getAggregationImgByRoomid($room2_id);
            foreach ($imgData as $key => $value) {
              $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
              $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
            }
         }
          //抓取one
         $imgData=$handleLogic->getAggregationImgByRoomid($room1_id);
         foreach ($imgData as $key => $value) {
           $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
           $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrl.'\')"></li>';    
         }
      }else{
         //聚合抓取图片数据
         $imgData=$handleLogic->getAggregationImgByRoomid($room1_id);
         if($imgData!=null){
           foreach ($imgData as $key => $value) {
             $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'_200_200.'.$value['img_ext'];
             $imgValue=$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
             $imgUrlbig='http://120.26.204.164/imgrob/'.$imgValue;
             $imgList1.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrlbig.'\')"><br><label><input type="checkbox" name="img_li[]" value="'.$imgValue.'">选中</label>&nbsp;<label><input type="radio" name="main_img" value="'.$imgValue.'">封面</label></li>';    
           }
         }
         $imgData=$handleLogic->getAggregationImgByRoomid($room2_id);
         if($imgData!=null){
           foreach ($imgData as $key => $value) {
             $imgUrl='http://120.26.204.164/imgrob/'.$value['img_path'].$value['img_name'].'_200_200.'.$value['img_ext'];
             $imgValue=$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
             $imgUrlbig='http://120.26.204.164/imgrob/'.$imgValue;
             $imgList2.='<li><img src="'.$imgUrl.'" onclick="showBigImage(\''.$imgUrlbig.'\')"><br><label><input type="checkbox" name="img_li[]" value="'.$imgValue.'">选中</label>&nbsp;<label><input type="radio" name="main_img" value="'.$imgValue.'">封面</label></li>';    
           }
         }
      }
      $this->assign('had_online',$had_online);
      $this->assign('had_online_offer',$had_online_offer);
      $this->assign('main_id',$main_id);
      $this->assign('company1',$basicData1['info_resource']);
      $this->assign('company2',$basicData2['info_resource']);
      $this->assign('imgList1',$imgList1);
      $this->assign('imgList2',$imgList2);
      $this->assign('aggregatImg',$aggregatImg);
      $this->assign('list',$list);
      $this->display();
    }
    //更新电话
    public function modifyPhoneSubmit(){
      $room_id=trim(I('post.room_id'));
      $mobile=trim(I('post.mobile'));
      if($room_id=='' || $mobile==''){
        echo '数据异常';return;
      }
      $handleLogic = new \Logic\HouseofferLogic();
      $result=$handleLogic->updateAggregatMobile($room_id,$mobile);
      if($result){
        echo '操作成功';
      }else{
        echo '操作失败';
      }
    }
    //审核确认提交
    public function aggregationAuditSubmit(){
      header("content-type:text/html;charset=utf-8;");
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '请重新登录';return;
      }
      $id=trim(I('post.mid'));
      if($id==''){
        echo '数据异常';return;
      }
      $had_online=I('post.had_online');
      $main_roomid=trim(I('post.main_roomid'));
      if($had_online==0){
         $img_array=I('post.img_li');
         if(!is_array($img_array) || count($img_array)>9){
           echo '图片必须在9张内';return;
         }
         $main_img=I('post.main_img');
         if($main_img==''){
           echo '必须选择一张封面图片';return;
         }
      }
      $handleLogic = new \Logic\HouseofferLogic();
      $auditModel=$handleLogic->getAggregatAuditByid($id);
      if($auditModel==null){
        echo '数据不存在';return;
      }elseif($auditModel['if_repetition_confim']!=0){
        echo '已经操作过了';return;
      }elseif($auditModel['record_status']==0){
        echo '数据已经删除';return;
      }
      $this->aggregationAuditSubmit_judge($auditModel,$img_array,$main_img,$had_online,$main_roomid,$handle_man);
      
    }
    //系统自动聚合
    public function aggregationAuto(){
      header("content-type:text/html;charset=utf-8;");
      $handle_man=trim(I('get.handle_man'));
      $room1_id=trim(I('get.room1_id'));
      $room2_id=trim(I('get.room2_id'));

      if($room1_id=='' || $room2_id=='' || $handle_man==''){
        echo '参数错误';return;
      }
      //核心数据
      $imgDal=new \Home\Model\houseoffer();
      $aggregatImgData=$imgDal->getRoomimgSimilar("id,room1_id,room2_id,estate_name1,house_type1,room_num1,hall_num1,if_repetition_confim,record_status,city_code,create_time,repetition_id,mid_img_id"
        ,"room1_id='$room1_id' and room2_id='$room2_id' limit 1");

      if($aggregatImgData==null || count($aggregatImgData)==0){
        echo '数据不存在';return;
      }
      $auditModel=$aggregatImgData[0];
      if($auditModel['if_repetition_confim']!=0){
        echo '已经操作过了';return;
      }elseif($auditModel['record_status']==0){
        echo '数据已经删除';return;
      }
      $handleLogic = new \Logic\HouseofferLogic();
      $basicData1=$handleLogic->getCalculateBasicByRoomid($room1_id);
      if($basicData1==null){
        echo '聚合房源读取失败';return;
      }
      $basicData2=$handleLogic->getCalculateBasicByRoomid($room2_id);
      if($basicData2==null){
        echo '聚合房源读取失败';return;
      }
      $had_online=0;
      $main_roomid=$room1_id;
      $img_array=array();
      $main_img='';
      if($basicData1['online_status']==1 && $basicData2['online_status']==1){
        //都是线上已有房源
        $had_online=2;
        if(!in_array($basicData1['info_resource'], array('链家网','贞一','爱屋吉屋','我爱我家','中原地产'))){
          $main_roomid=$basicData1['room_id'];
        }elseif(!in_array($basicData2['info_resource'], array('链家网','贞一','爱屋吉屋','我爱我家','中原地产'))){
          $main_roomid=$basicData2['room_id'];
        }
      }elseif($basicData1['online_status']==1){
        $had_online=1;
      }elseif($basicData2['online_status']==1){
        $had_online=1;
        $main_roomid=$room2_id;
      }else{
         //聚合抓取图片数据
         $imgData=$handleLogic->getAggregationImgByRoomid($room1_id);
         if($imgData!=null){
            foreach ($imgData as $key => $value) {
              if($key<8){
                $main_img=$value['img_path'].$value['img_name'].'.'.$value['img_ext'];
                $img_array[]=$main_img;
              }
            }
         }
      }
      echo $this->aggregationAuditSubmit_judge($auditModel,$img_array,$main_img,$had_online,$main_roomid,$handle_man);
      
    }
    public function aggregationAuditSubmit_judge($auditModel,$img_array,$main_img,$had_online,$main_roomid,$handle_man){
      $handleLogic = new \Logic\HouseofferLogic();
      //线上房源判断
      $handleRoom=new \Logic\HouseRoomLogic();
      $roomModel1=$handleRoom->getModelById($auditModel['room1_id']);
      $roomModel2=$handleRoom->getModelById($auditModel['room2_id']);
      $had_online1=0;$had_online2=0;
      if($roomModel1!=null&&$roomModel1!=false){
         $had_online1=1;
      }
      if($roomModel2!=null&&$roomModel2!=false){
        $had_online2=1;
      }
      $modelDal=new \Home\Model\houseoffer();
      if($had_online1==1 && $had_online2==1){
        //都是线上已有房源
        if($main_roomid==$auditModel['room1_id']){
          $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room2_id']."' and record_status=1  limit 2");
          if($data!=null&&count($data)>1){
            //下面有多个报价信息房源为主信息
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room1_id']."' and record_status=1  limit 2");
            if($data!=null&&count($data)==1){
               $result=$handleLogic->aggregatOnlineHouse($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
               echo $result['message'];
            }elseif(count($data)>1){
              //echo '聚合失败，各自房源下面已经有对应的多个报价信息';
              $result=$handleLogic->aggregatMergeOffer($auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$roomModel2,$roomModel1);
              echo $result['message'];
            }else{
              //个人房源下没有报价信息，将另外2个及以上报价转移过来
              $result=$handleLogic->aggregatOnlineHouse($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],array('customer_id'=>'moreOffer','room_price'=>$roomModel2['low_price']));
              echo $result['message'];
            }
          }elseif(count($data)==1){
            $result=$handleLogic->aggregatOnlineHouse($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
            echo $result['message'];
          }else{
            //个人房东为主
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room1_id']."' and record_status=1  limit 1");
            if($data!=null&&count($data)==1){
               $result=$handleLogic->aggregatOnlineHouse($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],array('customer_id'=>'moreOffer','room_price'=>$roomModel1['low_price']));
               echo $result['message'];
            }else{
              echo '2个个人房东房源不能聚合';
            }
          }
        }elseif($main_roomid==$auditModel['room2_id']){
          $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room1_id']."' and record_status=1  limit 2");
          if($data!=null&&count($data)>1){
            //下面有多个报价信息房源为主信息
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room2_id']."' and record_status=1  limit 2");
            if($data!=null&&count($data)==1){
               $result=$handleLogic->aggregatOnlineHouse($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
               echo $result['message'];
            }elseif(count($data)>1){
              //echo '聚合失败，各自房源下面已经有对应的多个报价信息';
              $result=$handleLogic->aggregatMergeOffer($auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$roomModel1,$roomModel2);
              echo $result['message'];
            }else{
              //个人房源下没有报价信息，将另外2个及以上报价转移过来
              $result=$handleLogic->aggregatOnlineHouse($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],array('customer_id'=>'moreOffer','room_price'=>$roomModel1['low_price']));
              echo $result['message'];
            }
          }elseif(count($data)==1){
            $result=$handleLogic->aggregatOnlineHouse($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
            echo $result['message'];
          }else{
             //个人房东为主
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room2_id']."' and record_status=1  limit 1");
            if($data!=null&&count($data)==1){
               $result=$handleLogic->aggregatOnlineHouse($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],array('customer_id'=>'moreOffer','room_price'=>$roomModel2['low_price']));
               echo $result['message'];
            }else{
              echo '2个个人房东房源不能聚合';
            }
          }
        }

      }elseif($had_online==0){
        //新增聚合房源数据
        $result=$handleLogic->addHouseAndOfferdata($main_roomid,$auditModel['room1_id'],$auditModel['room2_id'],$img_array,$main_img,$handle_man);
        echo $result['message'];
      }else{
        //新增报价
        if($had_online1==1){
          if($roomModel1['is_agent_fee']!=1){
            $result=$handleLogic->addAggregationOffer($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id']);
            echo $result['message'];return;
          }
          $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id,room_id',"rob_id='".$auditModel['room2_id']."' limit 1");
          if($data!=null&&count($data)==1){
            //非线上的那条其实是报价
            $roomModel=$handleRoom->getModelById($data[0]['room_id']);
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room1_id']."' and record_status=1 limit 1");
            $result=$handleLogic->aggregatOnlineHouse($roomModel,$roomModel1['id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
          }else{
            $result=$handleLogic->addAggregationOffer($roomModel1,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id']);
          }
          echo $result['message'];
        }elseif($had_online2==1){
          if($roomModel2['is_agent_fee']!=1){
             $result=$handleLogic->addAggregationOffer($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id']);
            echo $result['message'];return;
          }
          $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id,room_id',"rob_id='".$auditModel['room1_id']."' limit 1");
          if($data!=null&&count($data)==1){
            //非线上的那条其实是报价
            $roomModel=$handleRoom->getModelById($data[0]['room_id']);
            $data= $modelDal->getHouseofferData('id,commission_type,commission_price,create_time,room_price,customer_id,rob_id',"room_id='".$auditModel['room2_id']."' and record_status=1 limit 1");
            $result=$handleLogic->aggregatOnlineHouse($roomModel,$roomModel2['id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id'],$data[0]);
          }else{
             $result=$handleLogic->addAggregationOffer($roomModel2,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$auditModel['repetition_id']);
          }
          echo $result['message'];
        }else{
          //聚合比较，一条房源在线上是报价
          $offer_roomid=$auditModel['room1_id'];
          $data= $modelDal->getRoomimgSimilar('id,room1_id,room2_id,repetition_id'," (room1_id='$offer_roomid' or room2_id='$offer_roomid') and if_fabu_online=1 and if_repetition_confim=1 limit 1");   
          if($data!=null && count($data)>0){
             $rid=$data[0]['room1_id'];
             if($offer_roomid==$rid){
                $rid=$data[0]['room2_id'];
             }
             $roomModel=$handleRoom->getModelById($rid);
             if($roomModel!=null&&$roomModel!=false){
                $result=$handleLogic->addAggregationOffer($roomModel,$auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$data[0]['repetition_id']);
                echo $result['message'];
             }else{
                //都是报价
                $result=$handleLogic->aggregatMergeOffer($auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$data[0]['repetition_id']);
                echo $result['message'];
             }
          }else{
              $offer_roomid=$auditModel['room2_id'];
              $data= $modelDal->getRoomimgSimilar('id,room1_id,room2_id,repetition_id'," (room1_id='$offer_roomid' or room2_id='$offer_roomid') and if_fabu_online=1 and if_repetition_confim=1 limit 1");   
              if($data!=null && count($data)>0){
                 $rid=$data[0]['room1_id'];
                 if($offer_roomid==$rid){
                    $rid=$data[0]['room2_id'];
                 }
                 $roomModel=$handleRoom->getModelById($rid);
                 if($roomModel!=null&&$roomModel!=false){
                    $result=$handleLogic->addAggregationOffer($roomModel,$auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$data[0]['repetition_id']);
                    echo $result['message'];
                 }else{
                    //都是报价
                    $result=$handleLogic->aggregatMergeOffer($auditModel['room1_id'],$auditModel['room2_id'],$handle_man,$data[0]['repetition_id']);
                    echo $result['message'];
                 }
              }
          }
        }
        
      }
    }
     //独立发布
    public function independentSubmit(){
      header("content-type:text/html;charset=utf-8;");
      $handle_man=trim(getLoginName());
      if($handle_man==''){
        echo '请重新登录';return;
      }
      $id=trim(I('post.mid'));
      if($id==''){
        echo '数据异常';return;
      }
      $handleLogic = new \Logic\HouseofferLogic();
      $auditModel=$handleLogic->getAggregatAuditByid($id);
      if($auditModel==null){
        echo '数据不存在';return;
      }elseif($auditModel['if_repetition_confim']!=0){
        echo '已经操作过了';return;
      }elseif($auditModel['record_status']==0){
        echo '数据已经删除';return;
      }

      $rob_id=trim(I('post.rob_id'));
      if($rob_id==''){
        //新增数据
        $result=$handleLogic->independentOnline($auditModel['room1_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man);
        $result2=$handleLogic->independentOnline($auditModel['room2_id'],$auditModel['room1_id'],$auditModel['room2_id'],$handle_man);
      }else{
        $result=$handleLogic->independentOnline($rob_id,$auditModel['room1_id'],$auditModel['room2_id'],$handle_man);
        $result2='';
      }
      
      if($result=='200' || $result2=='200'){
        echo '操作成功';
      }else{
        echo $result.$result2;
      }
    }

/*聚合确认 end */


     /*房间报价管理 start*/
     //房间报价列表
     public function houseroomOfferlist(){
        $room_id=trim(I('get.room_id'));
        $customer_id=trim(I('get.cuid'));
        if($room_id=='' || $customer_id==''){
           echo '参数异常';return;
        }
        $handleLogic = new \Logic\HouseofferLogic();
        $list = $handleLogic->getHouseofferByRoomid($room_id,1);
        $showList=array();
        $handleCustomer=new \Logic\CustomerLogic();
        $customerModel=$handleCustomer->getModelById($customer_id);
        //判断房东属性
        $show_addbutton='';
        if($customerModel!=null && $customerModel['is_owner']!=4){
          $show_addbutton='<button class="btn_a" id="btn_add">新增报价</button>';
        }
        if($list!=null){
           foreach ($list as $key => $value) {
              $comm_price=$value['commission_price'];
              if($value['commission_type']==0){
                $comm_price=intval($comm_price)/100;
              }
              $one=array('company'=>'','name'=>'','phone'=>'','id'=>$value['id'],'room_price'=>$value['room_price'],'comm_price'=>$comm_price,'create_time'=>$value['create_time'],'record_status'=>$value['record_status'],'status_code'=>$value['status_code']);
              //中介信息
              $customerModel=$handleCustomer->getModelById($value['customer_id']);
              if($customerModel!=null && $customerModel!=false){
                $one['company']=$customerModel['agent_company_name'];
                $one['name']=$customerModel['true_name'];
                $one['phone']=$customerModel['mobile'];
              }
              $showList[]=$one;
           }
        }
        //中介公司
        $companyList='';
        $data=$handleLogic->getAgentCompanyList();
        if($data!=null){
          foreach ($data as $key => $value) {
            $companyList.='<option value="'.$value["id"].'">'.$value["company_name"].'</option>';
          }
        }
        $this->assign("show_addbutton",$show_addbutton);
        $this->assign("companyList",$companyList);
        $this->assign("list",$showList);
        $this->display();
     }
     //新增报价
     public function addOfferSubmit(){
        header("content-type:text/html;charset=utf-8;");
        $handle_man=trim(getLoginName());
        if($handle_man==''){
          echo '请重新登录';return;
        }
        $room_id=I('post.room_id');
        $company_id=I('post.company_id');
        $company_name=trim(I('post.company_name'));
        $client_name=trim(I('post.client_name'));
        $client_phone=trim(I('post.client_phone'));
        $agent_fee=trim(I('post.agent_fee'));
        $room_money=trim(I('post.room_money'));
        if($room_id=='' || $client_phone=='' || $room_money==''){
          echo '数据异常';return ;
        }
        $houseroomLogic = new \Logic\HouseRoomLogic();
        $roomModel=$houseroomLogic->getModelById($room_id);
        if($roomModel==null || $roomModel==false){
          echo '房间数据不存在';return;
        }
        $handleCustomerLogic=new \Logic\CustomerLogic();
        $clientModel = $handleCustomerLogic->getResourceClientByPhone($client_phone);
        if($clientModel!=null && $clientModel!=false){
          $handleCustomerLogic->updateModel(array('id'=>$clientModel['id'],'agent_company_id'=>$company_id,'agent_company_name'=>$company_name));
        }else{
          //新增中介
          $clientModel=array('id'=>guid(),'agent_company_id'=>$company_id,'agent_company_name'=>$company_name,'true_name'=>$client_name,'mobile'=>$client_phone,'create_time'=>time(),'is_owner'=>5,'is_renter'=>0,'city_code'=>C('CITY_CODE'),'gaodu_platform'=>3);
          $result=$handleCustomerLogic->addModel($clientModel);
          if(!$result){
            echo '中介数据保存失败';return;
          }
        }
        $handleLogic = new \Logic\HouseofferLogic();
        $result=$handleLogic->addHouseoffer($clientModel['id'],$room_id,$roomModel['resource_id'],$room_money,$agent_fee,$handle_man,0);
        if($result){
            //更新房间、搜索表 数据
            $low_price=intval($roomModel['low_price']);
            if(intval($room_money) < $low_price){
              $low_price=$room_money;
            }
            $modelDal=new \Home\Model\houseoffer();
           if($roomModel['is_agent_fee']==1){
             $modelDal->updateHouseoffer(array('is_my'=>0),"room_id='$room_id'");
              //todo;中介聚合，虚拟帐号
              $handleRoom = new \Home\Model\houseroom();
              $handleRoom->updateModel(array('id'=>$room_id,'is_regroup'=>1,'store_id'=>'','is_agent_fee'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price));
              //清除缓存
              $houseroomLogic->updateHouseroomCache($roomModel,10);

              $handleRoom = new \Home\Model\houseresource();
              $handleRoom->updateModel(array('id'=>$roomModel['resource_id'],'store_id'=>'','client_name'=>'','client_phone'=>'','customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A'));
              if($roomModel['status']==2 && $roomModel['record_status']==1){
                 $handleRoom = new \Home\Model\houseselect();
                 $handleRoom->updateModelByWhere(array('is_regroup'=>1,'store_id'=>'','is_agent_fee'=>1,'customer_id'=>'08F796E4-84B9-0ECF-EA8B-C107427FBF4A','low_price'=>$low_price),"room_id='$room_id'");
              }
           }else{
             //个人房源，查询是否已经有了报价信息
             $customer_id=$roomModel['customer_id'];
             $data= $modelDal->getHouseofferData('id,commission_type,commission_price',"room_id='$room_id' and customer_id='$customer_id' and record_status=1 limit 1");
             if($data==null || count($data)==0){
               $handleLogic->addHouseoffer($customer_id,$room_id,$roomModel['resource_id'],$roomModel['room_money'],0,$handle_man,1,'','');
             }
              $houseroomLogic->updateModel(array('id'=>$room_id,'is_regroup'=>1,'low_price'=>$low_price));
              if($roomModel['status']==2 && $roomModel['record_status']==1){
                 $handleDal = new \Home\Model\houseselect();
                 $handleDal->updateModelByWhere(array('is_regroup'=>1,'low_price'=>$low_price),"room_id='$room_id'");
              }
           }
           echo '操作成功';
        }else{
            echo '操作失败';
        }
     }
     //编辑报价
     public function editOfferSubmit(){
        header("content-type:text/html;charset=utf-8;");
        $handle_man=trim(getLoginName());
        if($handle_man==''){
          echo '请重新登录';return;
        }
        $room_id=I('post.room_id');
        $offer_id=I('post.offer_id');
        $agent_fee=trim(I('post.agent_fee'));
        $room_money=trim(I('post.room_money'));
        if($offer_id=='' || $agent_fee=='' || $room_money==''){
          echo '数据异常';return ;
        }
        $houseroomLogic = new \Logic\HouseRoomLogic();
        $roomModel=$houseroomLogic->getModelById($room_id);
        if($roomModel==null || $roomModel==false){
          echo '房间数据不存在';return;
        }
       
        $handleLogic = new \Logic\HouseofferLogic();
        $result=$handleLogic->updateHouseoffer($offer_id,$room_money,$agent_fee,$handle_man);
        if($result){
            $low_price=0;
            //获取房间下面的所有报价
            $data=$handleLogic->getHouseofferByRoomid($room_id);
            foreach ($data as $key => $value) {
               if($low_price==0 || intval($value['room_price'])<$low_price){
                  $low_price=intval($value['room_price']);
               }
            }
            if($low_price>0 && $low_price!=$roomModel['low_price']){
              //更新房间、搜索表 数据
              $houseroomLogic->updateModel(array('id'=>$room_id,'low_price'=>$low_price));
              if($roomModel['status']==2 && $roomModel['record_status']==1){
                 $handleDal = new \Home\Model\houseselect();
                 $handleDal->updateModelByWhere(array('low_price'=>$low_price),"room_id='$room_id'");
              }
            }
            echo '操作成功';
        }else{
            echo '操作失败';
        }
     }
     //删除报价
     public function removeOffer(){
        header("content-type:text/html;charset=utf-8;");
        $handle_man=trim(getLoginName());
        if($handle_man==''){
          echo '{"status":"201","message":"请重新登录"}';return;
        }
        $room_id=I('post.room_id');
        $offer_id=I('post.offer_id');
        if($offer_id=='' || $room_id==''){
          echo '{"status":"202","message":"数据异常"}';return;
        }
        $houseroomLogic = new \Logic\HouseRoomLogic();
        $roomModel=$houseroomLogic->getModelById($room_id);
        if($roomModel==null || $roomModel==false){
          echo '{"status":"203","message":"房间数据不存在"}';return;
        }
       
        $handleLogic = new \Logic\HouseofferLogic();
        $result=$handleLogic->deleteHouseoffer($offer_id,$handle_man);
        if($result){
            $low_price=intval($roomModel['room_money']);
            $is_regroup=0;
            //获取房间下面的有效报价
            $data=$handleLogic->getHouseofferByRoomid($room_id);
            foreach ($data as $key => $value) {
              $is_regroup=1;
               if(intval($value['room_price'])<$low_price){
                  $low_price=intval($value['room_price']);
               }
            }
            if($is_regroup==0){
              //没有报价，下架房源
              $roomLogic=new \Logic\HouseRoomLogic();
              $roomLogic->downroomByidForCommon($room_id,$handle_man);//下架
            }else{
              //更新房间、搜索表 数据
              $houseroomLogic->updateModel(array('id'=>$room_id,'is_regroup'=>$is_regroup,'low_price'=>$low_price));
              if($roomModel['status']==2 && $roomModel['record_status']==1){
                 $handleDal = new \Home\Model\houseselect();
                 $handleDal->updateModelByWhere(array('is_regroup'=>$is_regroup,'low_price'=>$low_price),"room_id='$room_id'");
              }
            }
            
            echo '{"status":"200","message":"操作成功"}';
        }else{
            echo '{"status":"300","message":"操作失败"}';
        }
     }
      /*房间报价管理 end*/

    //聚合房源举报审核列表
    public function aggregatreportAuditList(){
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()) {
           return $this->error('非法操作',U('Index/index'),1);
       }
       $switchcity=$handleCommonCache->cityauthority();
       $this->assign("switchcity",$switchcity);
       $handleMenu = new \Logic\AdminMenuListLimit();
       $menu_top_html=$handleMenu->menuTop(getLoginName(),3);
       $menu_left_html=$handleMenu->menuLeft(getLoginName(),3);
       $handleMenu->jurisdiction();
       $this->assign("menutophtml",$menu_top_html);
       $this->assign("menulefthtml",$menu_left_html);

       $handleLogic = new \Logic\HouseofferLogic();
       $condition['startTime']=trim(I('get.startTime'));
       $condition['endTime']=trim(I('get.endTime'));
       $condition['handle_status']=trim(I('get.handle_status'));
   
       $condition['totalCount']=I('get.totalCount');
       if($condition['totalCount']==''){
         $condition['totalCount']=0;
       }
       $list=array();$pageSHow='';
       if(I('get.p')=='' || $condition['totalCount']==0) {
          //总条数
           $condition['totalCount']=$handleLogic->getAggregatreportCount($condition);
       }
       if($condition['totalCount']>=1) {
         //分页
           $Page= new \Think\Page($condition['totalCount'],10);
           foreach($condition as $key=>$val){
             $Page->parameter[$key]=urlencode($val);
           }
           $pageSHow=$Page->show();
           $list = $handleLogic->getAggregatreportList($condition,$Page->firstRow,$Page->listRows);
       } 
       $this->assign("pageSHow",$pageSHow);
       $this->assign("list",$list);
       $this->assign("totalCount",$condition['totalCount']);
       $this->display();
    }
    //聚合房源举报审核提交
    public function aggregatreportSubmit(){
      $login_name=trim(getLoginName());
      if($login_name==''){
        echo '{"status":"400","message":"请重新登录"}';return;
      }
      $id=trim(I('post.id'));
      $handle_status=trim(I('post.handle_status'));
      if($id=='' || ($handle_status!=1 && $handle_status!=2)){
        echo '{"status":"400","message":"参数异常"}';return;
      }
      $handle_result=trim(I('post.handle_result'));
      if($handle_result==''){
         echo '{"status":"400","message":"理由为空"}';return;
      }
      $modelDal=new \Home\Model\houseoffer();
      $data= $modelDal->getHousefeederrorData('id,handle_status,room_id,customer_id'," id='$id' limit 1");   
      if($data==null || count($data)==0){
        echo '{"status":"400","message":"举报数据读取失败"}';return;
      }elseif($data[0]['handle_status']!=0){
        echo '{"status":"400","message":"已经审核过了"}';return;
      }
      if($handle_status==1){
        //通过
        $result=$modelDal->updateHousefeederror(array('handle_status'=>1,'handle_time'=>time(),'handle_man'=>$login_name),"id='$id'");
      }else{
        //拒绝
        $result=$modelDal->updateHousefeederror(array('handle_status'=>2,'handle_time'=>time(),'handle_man'=>$login_name,'handle_result'=>$handle_result),"id='$id'");
      }
      if(!$result){
        echo '{"status":"400","message":"操作失败"}';return;
      }
      $estate_name='';$room_num='';$room_money='';
      $handleModel = new \Home\Model\houseroom();
      $houseModel=$handleModel->getModelById($data[0]['room_id']);
      if($houseModel!=null && $houseModel!=false){
         $room_money=$houseModel['room_money'];
          $handleModel = new \Home\Model\houseresource();
         $houseModel=$handleModel->getModelById($houseModel['resource_id']);
         if($houseModel!=null && $houseModel!=false){
            $estate_name=$houseModel['estate_name'];
            $room_num=$houseModel['room_num'];
         }
      }
      if($estate_name!=''){
        $handleLogic = new \Logic\CustomerNotifyLogic();
         $content='<font color="#666666">你对房源【'.$estate_name.'-'.$room_num.'室-'.$room_money.'元/月】的举报已经审核通过了。</font>';
         if($handle_status==2){
             $content='<font color="#666666">你对房源【'.$estate_name.'-'.$room_num.'室-'.$room_money.'元/月】的举报经过确认，'.$handle_result.'</font>';
         }
         $handleLogic->sendCustomerNotify($data[0]['customer_id'],1009,'举报审核',$content,'您有1条举报审核信息');
      }
      echo '{"status":"200","message":"操作成功"}';
    }

    //爱屋吉屋添加手机号码
    public function phoneNumberUpdate ()
    {
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $switchcity=$handleCommonCache->cityauthority();
        $this->assign("switchcity",$switchcity);
        $handleMenu = new \Logic\AdminMenuListLimit();
        $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),3);
        $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),3);
        $handleMenu->jurisdiction();

        $startTime = strtotime(I('get.startTime'));
        $endTime = strtotime(I('get.endTime'));
        $resource = I('get.info_resource');
        $where = array();
        $where['city_code'] = C('CITY_CODE');
        $where['info_resource'] = array('eq','爱屋吉屋');
        $where['is_clear'] = 0;
        if($startTime!=""&&$endTime=="") {
            $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime=="") {
            $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!="") {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime)
        {
            $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        // if($resource != "") {
        //     $where['info_resource']=array('eq',$resource);
        // }
        $houseOfferModel = new \Home\Model\houseoffer();
        $fields = 'id,info_resource,estate_name,agency_phone,create_time,info_resource_url';
        $count = $houseOfferModel->modelCountHouseAggregationInfo($where);
        $Page= new \Think\Page($count,20);
        $data = $houseOfferModel->modelGetHouseAggregationInfo($Page->firstRow,$Page->listRows,$fields,$where);
        $this->assign("menutophtml",$menu_top_html);
        $this->assign("menulefthtml",$menu_left_html);
        $this->assign("pagecount",$count);
        $this->assign("show",$Page->show());
        $this->assign("list",$data);
        $this->display();
    }
    //发布上线
    public function modifyHousePhone ()
    {
        $login_name=trim(getLoginName());
        if(empty($login_name)){
            echo '{"code":"404","message":"登录失效"}';return;
        }
        $houseOfferLogic = new \Logic\HouseofferLogic();
        $data = I('post.');//id
        $houseOfferLogic->pushHouseOnline($data,$login_name);
    }
}
?>
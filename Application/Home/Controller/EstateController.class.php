<?php
namespace Home\Controller;
use Think\Controller;
class EstateController extends Controller
{
    //查看楼盘列表
    public function EstateList () {
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
    $handleEstate = new \Logic\EstateLogic();
    $estate_name=isset($_GET['estate_name'])?$_GET['estate_name']:"";
    $estate_type=isset($_GET['estate_type'])?$_GET['estate_type']:"";
    $business_type=isset($_GET['business_type'])?$_GET['business_type']:"";
    //$where['record_status']=array('eq','1');
    $startTime=strtotime(I('get.starttime'));
    $endTime=strtotime(I('get.endtime'));
    $address=I('get.address');
    $region=I('get.region');
    $scope=I('get.scope');
    $estatecode=I('get.estatecode');
    $housetype=I('get.housetype');
    $brandtype=I('get.brand_type');
    $where=array();
    //$where_page=array();
    if($startTime!=""&&$endTime==""){
    $where['create_time']=array('gt',$startTime);
    }
    if($endTime!=""&&$startTime==""){
    $where['create_time']=array('lt',$endTime+86400);
    }
    if($startTime!=""&&$endTime!=""){
    $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
    }
    if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
    $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
    }
    if($address!=""){
    $where['estate_address']=array('like','%'.$address.'%');
    }
    if($estate_name!=""){
    $where['estate_name']=array('like','%'.$estate_name.'%');
    }
    if($estate_type!=""){
    $where['estate_type']=array('eq',$estate_type);
    }
    if($business_type!=""){
    $where['business_type']=array('eq',$business_type);
    }
    if($region!=""){
    $where['region']=array('eq',$region);
    }
    if($scope!=""){
    $where['scope']=array('eq',$scope);
    }
    if($region!=""&&$scope!=""){
    $where['region']=array('eq',$region);
    $where['scope']=array('eq',$scope);
    }
    if($estatecode!=""){
    $where['estate_code']=array('eq',$estatecode);
    }
    if($housetype!=""){
    $where['house_type']=array('eq',$housetype);
    }
    if($brandtype!=""){
    $where['brand_type']=array('eq',$brandtype);
    }
    $create_man=trim(I('get.create_man'));
    if($create_man!=''){
    $where['create_man']=array('eq',$create_man);
    }
    /*查询条件（业务类型）*/
    $handleLogic=new \Logic\HouseResourceLogic();
    $result=$handleLogic->getResourceParameters();
    $typeString='';
    if($result !=null){
    foreach ($result as $key => $value) {
    if($value['info_type']==15){
    $typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
    }
    if($value['info_type']==4){
    $housetype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
    }
    if($value['info_type']==16){
    $brandtype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
    }
    } 
    }
    $this->assign("housetype",$housetype);
    $this->assign("brandtype",$brandtype);
    $this->assign("businessTypeList",$typeString);
    //负责人
    $handleResource=new \Logic\HouseResourceLogic();
    $result=$handleResource->getHouseHandleList();
    $createmanString='';
    foreach ($result as $key => $value) {
    $createmanString.='<option value="'.$value["user_name"].'">'.$value["real_name"].'</option>';
    } 
    $this->assign("createManList",$createmanString);
    //列表数据
    $count=$handleEstate->getEstatePageCount($where);
    $Page= new \Think\Page($count,10);
    /*foreach($where_page as $key=>$val){
    $Page->parameter[$key]=urlencode($val);
    }*/
    $list=$handleEstate->getEstateDataList($Page->firstRow,$Page->listRows,$where);
    /*查询条件（区域板块）*/
    $result1=$handleResource->getRegionList();
    if($result1!==null && $result1!==false){
    $regionList='';
    foreach ($result1 as $key => $value) {
    $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
    } 
    $this->assign("regionList",$regionList);
    }
    $scopeList='<option value=""></option>';
    if(!empty($region)){
    //查询后，重新加载板块信息
    $result1=$handleResource->getRegionScopeList();
    foreach ($result1 as $key => $value) {
    if($region==$value['parent_id']){
    $scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
    }
    }
    }
    $this->assign("scopeList",$scopeList);
    $this->assign("menutophtml",$menu_top_html);
    $this->assign("menulefthtml",$menu_left_html);
    $this->assign("show",$Page->show());
    $this->assign("pagecount",$count);
    $this->assign("list",$list);
    $this->display();
    }

    //新增楼盘字典
    public function addestate(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $handleRegion = new \Logic\Paramregion();
      $this->assign("menutophtml",$handleMenu->menuTop(cookie("admin_user_name"),3));
      $this->assign("menulefthtml",$handleMenu->menuLeft(cookie("admin_user_name"),3));
      $where['is_display']=array('eq',1);
      $where['parent_id']=array('eq',0);
      $list=$handleRegion->getParamRegionList($where);
      $this->assign("list",$list);
      /* 地铁线路 */
      $handleSubway = new \Logic\SubwayLogic();
      $result=$handleSubway->getAllSubwayLine();
      if($result !=null){
        $subwaylineList='';
        foreach ($result as $key => $value) {
          $subwaylineList.='<option value="'.$value["id"].','.$value["subwayline_name"].'">'.$value["subwayline_name"].'</option>';
        } 
        $this->assign("subwaylineList",$subwaylineList);
      }
      /*（业务类型）*/
      $handleLogic=new \Logic\HouseResourceLogic();
      $result=$handleLogic->getResourceParameters();
      $typeString='';$housetype='';
      if($result !=null){
        foreach ($result as $key => $value) {
          if($value['info_type']==15){
            $typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
          if($value['info_type']==4){
             $housetype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
          if($value['info_type']==16){
            $brandtype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
        } 
      }
      $this->assign("housetype",$housetype);
      $this->assign("businessTypeList",$typeString);
      $this->assign("brandtype",$brandtype);
      $this->display();
    }
    //编辑楼盘字典
    public function editestate(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
       $estate_id=I('get.estate_id');
       if(empty($estate_id)){
          echo '参数异常';return;
       }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $this->assign("menutophtml",$handleMenu->menuTop(cookie("admin_user_name"),3));
      $this->assign("menulefthtml",$handleMenu->menuLeft(cookie("admin_user_name"),3));
      $handleEstate = new \Logic\EstateLogic();
      $estateModel=$handleEstate->getModelById($estate_id);
      if($estateModel==null || $estateModel==false){
        echo '楼盘信息不存在！';return;
      }
      $this->assign("estateModel",$estateModel);//小区对象
      /*（区域板块）*/
      $handleLogic=new \Logic\HouseResourceLogic();
      $result=$handleLogic->getRegionList();
      $regionList='<option value=""></option>';
      foreach ($result as $key => $value) {
        $regionList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
      } 
      $this->assign("regionList",$regionList);//区域
      $scopeList='<option value=""></option>';
      if(!empty($estateModel['region'])){
        $result=$handleLogic->getRegionScopeList();
        foreach ($result as $key => $value) {
          if($estateModel['region']==$value['parent_id']){
            $scopeList.='<option value="'.$value["id"].'">'.$value["cname"].'</option>';
          }
        }
      }
      $this->assign("scopeList",$scopeList);//板块
      /*（业务类型）*/
      $result=$handleLogic->getResourceParameters();
      $typeString='';$housetype='';
      if($result !=null){
        foreach ($result as $key => $value) {
          if($value['info_type']==15){
            $typeString.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
          if($value['info_type']==4){
            $housetype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
          if($value['info_type']==16){
            $brandtype.='<option value="'.$value["type_no"].'">'.$value["name"].'</option>';
          }
        } 
      }
      $this->assign("housetype",$housetype);
      $this->assign("brandtype",$brandtype);
      $this->assign("businessTypeList",$typeString);
      $this->display();
    }
    public function getSubwayByLine(){
      $handleSubway = new \Logic\SubwayLogic();
      if(!isset($_GET['subwayline_id']) || $_GET['subwayline_id']==""){
        echo "";return;
      }
      $line_arr = explode(',', $_GET['subwayline_id']);
      $result=$handleSubway->getSubwayByLine($line_arr[0]);
      if($result !=null){
        $subwayList='';
        foreach ($result as $key => $value) {
          $subwayList.='<option value="'.$value["id"].','.$value["subway_name"].'">'.$value["subway_name"].'</option>';
        } 
        echo $subwayList;
      }
    }
    //动态绑定不同地铁线路
    public function getDifferentSubwayByLine(){
      $handleSubway = new \Logic\SubwayLogic();
      if(!isset($_GET['subwayline_id']) || $_GET['subwayline_id']==""){
        echo "";return;
      }
      $result=$handleSubway->getSubwayByLine($_GET['subwayline_id']);
      if($result !=null){
        $subwayList='';
        foreach ($result as $key => $value) {
          $subwayList.="<option value='".$value['id'].",".$value['subway_name']."'>".$value['subway_name']."</option>";
        } 
        echo '{"sid":"'.$_GET["sid"].'","svalue":"'.$_GET["svalue"].'","contents":"'.$subwayList.'"}'; 
      }
    }
    //实时获取楼盘名
    public function searchestate(){
     $handleEstate = new \Logic\EstateLogic();
     $where['estate_name']=array('like','%'.$_GET['keyword'].'%');
     $result=$handleEstate->getEstateByKey($where);
     if($result==null){
      echo '{"status":"404","msg":"fail"}';
    }else{
      $jsonString=json_encode($result);
      echo '{"status":"200","msg":"success","data":'.$jsonString.'}';
    }
    }
    //ajax获取区域板块
    public function searcheregion(){
      $handleRegion = new \Logic\Paramregion();
      $where['is_display']=array('eq',1);
      $where['parent_id']=array('eq',$_GET['region']);
      $result=$handleRegion->getParamRegionList($where);
     if($result==null){
      echo '{"status":"404","msg":"fail"}';
    }else{
       $jsonRegion=json_encode($result);
      echo '{"status":"200","msg":"success","data":'.$jsonRegion.'}';
    }
    }
    //ajax获取拼音
    public function convert_pinyin(){
     if(!isset($_GET['estate_name']) || empty($_GET['estate_name'])){
       echo '{"full_py":"","first_py":""}';
     }
      $pinyin = new \Logic\pinyin();
      $full_py=$pinyin->getPinyin($_GET['estate_name']);
      $first_py=$pinyin->getFirstChars($_GET['estate_name']);
      echo '{"full_py":"'.$full_py.'","first_py":"'.$first_py.'"}';
    }
    //提交数据
    public function submitestate(){
       header ( "Content-type: text/html; charset=utf-8" );
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
       $data['estate_name']=trim(I('post.estate_name'));
       $data['estate_address']=trim(I('post.estate_address'));
       $data['region']=I('post.region');
       $data['scope']=I('post.scope');
       if($data['estate_name']=='' || $data['region']==''){
         echo '新增失败，数据异常！';return;
       }  
      $handleEstate = new \Logic\EstateLogic();
      //楼盘名称是否重复
      $list=$handleEstate->getEstateByKey(array('estate_name'=>$data['estate_name']));
      if($list!=null && count($list)>0){
        echo '<script>alert("新增失败，楼盘名称已存在！");window.close();</script>';return;
      }
      $maxcode=$handleEstate->modelcodemaxfind('');
      if($maxcode){
          $letter=substr($maxcode[0]['estate_code'],0,4);
          $number=str_pad(substr($maxcode[0]['estate_code'],4)+1,6,0,STR_PAD_LEFT);
          $newcode=$letter.$number;
      }
      $data['id']=strtolower(create_guid());
      $data['region_name']=I('post.region_name');
      $data['scope_name']=I('post.scope_name');
      $data['full_py']=I('post.full_py');
      $data['first_py']=I('post.first_py');
      $data['lpt_x']=I('post.lpt_x');
      $data['lpt_y']=I('post.lpt_y');
      $data['create_time']=time();
      $data['record_status']=1;
      $data['business_type']=I('post.business_type');
      $data['house_type']=I('post.house_type');
      $data['brand_type']=I('post.brand_type');
      $data['create_man']=cookie('admin_user_name');
      $data['estate_code']=$newcode;
     //小区附近标识
      import("Vendor.Lbs.geohash");
      $handleGeohash = new \Geohash();
      $data['geo_val']= $handleGeohash->encode($data['lpt_y'],$data['lpt_x']);

      $result1=$handleEstate->modelAdd($data);
      if($result1){
          //保存地铁路线
          $handleSubway = new \Logic\SubwayLogic();
          for ($i=1; $i < 6; $i++){ 
            if($_POST['subwayline'.$i]!="" && $_POST['subway'.$i]!="" && is_numeric($_POST['subway_distance'.$i])){
              $subwaydata['estate_id']=$data['id'];
              $line_arr = explode(',', $_POST['subwayline'.$i]);
              $subwaydata['subwayline_id']=$line_arr[0];
              $subwaydata['subwayline_name']=$line_arr[1];
              $way_arr = explode(',', $_POST['subway'.$i]);
              $subwaydata['subway_id']=$way_arr[0];
              $subwaydata['subway_name']=$way_arr[1];
              $subwaydata['subway_distance']=$_POST['subway_distance'.$i];
              $handleSubway->addSubwayestate($subwaydata);
            }
          }
          echo '<script>alert("新增成功！");window.close();</script>';
      }else{
          echo '新增失败！';
      }

    }
    //提交编辑数据
    public function submitEditEstate(){
      header ( "Content-type: text/html; charset=utf-8" );
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
       $estate_name=trim(I('post.estate_name'));
       $region=I('post.region');
       $estate_id=I('post.estate_id');
       if($estate_name=='' || $region=='' || empty($estate_id)){
          echo '修改失败,数据异常！';return;
       }  
      $handleEstate = new \Logic\EstateLogic();
      $data=$handleEstate->getModelById($estate_id);
      if($data==null || $data==false){
         echo '修改失败,小区已经删除！';return;
      }
      //楼盘名称是否重复
      $list=$handleEstate->getEstateByKey(array('estate_name'=>$estate_name));
      if($list!=null){
        foreach ($list as $key => $value) {
           if($value['estate_name']==$estate_name && $value['id']!=$estate_id){
              echo '<script>alert("修改失败,楼盘名称已存在！");window.close();</script>';return;
           }
        }
      }
       $data['estate_name']=$estate_name;
       $data['region']=$region;
       $data['estate_address']=trim(I('post.estate_address'));
       $data['scope']=I('post.scope');
       $data['region_name']=I('post.region_name');
       $data['scope_name']=I('post.scope_name');
       $data['full_py']=I('post.full_py');
       $data['first_py']=I('post.first_py');
       $data['lpt_x']=I('post.lpt_x');
       $data['lpt_y']=I('post.lpt_y');
      $data['update_time']=time();
      $data['business_type']=$_POST['business_type'];
      $data['house_type']=I('post.house_type');
      $data['brand_type'] = I('post.brand_type');
      $data['update_man']=cookie('admin_user_name');
      //小区附近标识
       import("Vendor.Lbs.geohash");
       $handleGeohash = new \Geohash();
       $data['geo_val']= $handleGeohash->encode($data['lpt_y'],$data['lpt_x']);

      $result1=$handleEstate->updateModel($data);
      if($result1){
        //更新映射表
        $dal=new \Home\Model\estatemap();
        $dal->updateModelByWhere(array('estate_name'=>$data['estate_name'],'region_id'=>$data['region'],'scope_id'=>$data['scope'],'region_name'=>$data['region_name'],'scope_name'=>$data['scope_name']),"estate_id='$estate_id'");
        $handleSelect=new \Logic\HouseSelectLogic();
        $selectDal=new \Home\Model\houseselect();
          //更新房源信息（小区，区域、板块）
          $houseModel['estate_id']=$data['id'];
          $houseModel['estate_name']=$data['estate_name'];
          $houseModel['region_id']=$data['region'];
          $houseModel['scope_id']=$data['scope'];
          $houseModel['region_name']=$data['region_name'];
          $houseModel['scope_name']=$data['scope_name'];
          $houseModel['business_type']=$data['business_type'];
          $handleEstate->updateHouseEstateInfo($houseModel);
          //操作检索表
          $data['estate_id']=$data['id'];
          $handleSelect->updateModelByEstateid($data);
          
          echo '<script>alert("修改成功！");window.close();</script>';
      }else{
          echo '修改失败！';
      }
    }
    /*小区映射关系 */
    public function EstatemapList()
    {
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
    //列表数据
        $handleEstate = new \Logic\EstateLogic();
        $condition['third_name']=trim(I('get.third_name'));
        
        $condition['estatename']=trim(I('get.estatename'));
        $condition['region_third']=trim(I('get.region_third'));
        $condition['type']=I('get.type');
        if($condition['type']==''){
          $condition['type']=1;
        }
        $condition['totalCount']=I('get.totalCount');
        if($condition['totalCount']==''){
          $condition['totalCount']=0;
        }
        $list=array();$pageSHow='';
        if(I('get.p')=='' || $condition['totalCount']==0) {
            $totalCountModel=$handleEstate->getEstatemapListCount($condition);//总条数
            if($totalCountModel !==null && $totalCountModel !==false){
                $condition['totalCount']=$totalCountModel[0]['totalCount'];
            }
        }
        if($condition['totalCount']>=1) {
          //分页
            $Page= new \Think\Page($condition['totalCount'],20);
            foreach($condition as $key=>$val){
              $Page->parameter[$key]=urlencode($val);
            }
            $pageSHow=$Page->show();
            $list = $handleEstate->getEstatemapList($condition,$Page->firstRow,$Page->listRows);
        } else {
            
        }
        $this->assign("pageSHow",$pageSHow);
        $city = C('CITY_CODE');
        $this->assign("flats",getFlatListByCity($city));
        $this->assign("regionThirdList",$this->getRegionNameDDL($city));
        $this->assign("list",$list);
        $this->assign("totalCount",$condition['totalCount']);
        $this->display();
    }
    public function getRegionNameDDL($city){
      switch ($city) {
        case '001009001':
          return '<option value="静安">静安</option><option value="卢湾">卢湾</option>
<option value="黄浦">黄浦</option><option value="徐汇">徐汇</option><option value="长宁">长宁</option><option value="浦东">浦东</option>
<option value="虹口">虹口</option><option value="杨浦">杨浦</option><option value="普陀">普陀</option><option value="闵行">闵行</option>
<option value="闸北">闸北</option><option value="宝山">宝山</option><option value="嘉定">嘉定</option><option value="松江">松江</option>
<option value="奉贤">奉贤</option><option value="金山">金山</option><option value="青浦">青浦</option><option value="崇明">崇明</option>';
          break;
        case '001001':
          return '<option value="朝阳">朝阳</option>
<option value="海淀">海淀</option>
<option value="丰台">丰台</option>
<option value="东城">东城</option>
<option value="西城">西城</option>
<option value="崇文">崇文</option>
<option value="宣武">宣武</option>
<option value="石景山">石景山</option>
<option value="昌平">昌平</option>
<option value="通州">通州</option>
<option value="大兴">大兴</option>
<option value="顺义">顺义</option>
<option value="怀柔">怀柔</option>
<option value="房山">房山</option>
<option value="门头沟">门头沟</option>
<option value="密云">密云</option>
<option value="平谷">平谷</option>
<option value="延庆">延庆</option>';
          break;
        case '001011001':
          return '<option value="拱墅">拱墅</option>
<option value="江干">江干</option>
<option value="上城">上城</option>
<option value="西湖">西湖</option>
<option value="下城">下城</option>
<option value="滨江">滨江</option>
<option value="萧山">萧山</option>
<option value="余杭">余杭</option>
<option value="临安">临安</option>
<option value="富阳">富阳</option>
<option value="建德">建德</option>
<option value="桐庐">桐庐</option>
<option value="淳安">淳安</option>
<option value="下沙">下沙</option>';
          break;
        case '001010001':
          return '<option value="江宁">江宁</option>
<option value="鼓楼">鼓楼</option>
<option value="白下">白下</option>
<option value="玄武">玄武</option>
<option value="建邺">建邺</option>
<option value="秦淮">秦淮</option>
<option value="下关">下关</option>
<option value="雨花台">雨花台</option>
<option value="浦口">浦口</option>
<option value="栖霞">栖霞</option>
<option value="六合">六合</option>
<option value="溧水">溧水</option>
<option value="高淳">高淳</option>
<option value="大厂">大厂</option>';
          break;
        case '001019002':
          return '<option value="龙岗">龙岗</option>
<option value="南山">南山</option>
<option value="福田">福田</option>
<option value="宝安">宝安</option>
<option value="罗湖">罗湖</option>
<option value="龙华">龙华</option>
<option value="坪山">坪山</option>
<option value="盐田">盐田</option>
<option value="光明新区">光明新区</option>
<option value="大鹏新区">大鹏新区</option>';
          break;
        default:
          return '';
          break;
      }
    }
    /*修改映射 */
    public function editestatemap()
    {
        $id=I('get.id');
        if(empty($id)){
           echo "参数错误";return;
        }
        $handleEstate = new \Logic\EstateLogic();
        $estateModel=$handleEstate->getEstatemapById($id);
        $this->assign("Model",$estateModel);
        $this->display();
    }
    public function saveEstatemap(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        return $this->error('非法操作',U('Index/index'),1);
      }
      $saveData['id']=I('post.id');
      $saveData['estate_id']=I('post.estate_id');
      $saveData['estate_name']=I('post.estate_name');
      $saveData['region_id']=I('post.region_id');
      $saveData['scope_id']=I('post.scope_id');
      $saveData['region_name']=I('post.region_name');
      $saveData['scope_name']=I('post.scope_name');
      if(empty($saveData['id']) || empty($saveData['estate_id']) || empty($saveData['estate_name'])){
        echo '{"status":"400","message":"数据异常"}';return;
      }
      $saveData['update_man']=$loginName;
      $saveData['update_time']=time();
      $handleEstate = new \Logic\EstateLogic();
      $result=$handleEstate->updateEstatemap($saveData);
      if($result){
        echo '{"status":"200","message":"操作成功"}';
      }else{
        echo '{"status":"400","message":"操作失败"}';
      } 
    }
    /*新增映射 */
    public function addestatemap(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        return $this->error('非法操作',U('Index/index'),1);
      }
      $city = C('CITY_CODE');
      $this->assign("flats",getFlatListByCity($city));
      $this->display();
    }
    public function saveEstatemapAdd(){
      $loginName=trim(getLoginName());
      if(empty($loginName)){
        return $this->error('非法操作',U('Index/index'),1);
      }
      $saveData['third_name']=I('post.third_name');
      $saveData['estate_name_third']=trim(I('post.estate_name_third'));
      $saveData['estate_id']=I('post.estate_id');
      $saveData['estate_name']=trim(I('post.estate_name'));
      $saveData['region_id']=I('post.region_id');
      $saveData['scope_id']=I('post.scope_id');
      $saveData['region_name']=I('post.region_name');
      $saveData['scope_name']=I('post.scope_name');
      if(empty($saveData['estate_id']) || empty($saveData['estate_name'] || empty($saveData['estate_name_third']))){
          return $this->error('参数错误',U('Estate/addestatemap'),1);
      }
      $saveData['id']=guid();
      $saveData['city_id']=C('CITY_CODE');
      $saveData['update_man']=$loginName;
      $saveData['update_time']=time();
      $handleEstate = new \Home\Model\estatemap();
      if($saveData['third_name']!='58'){
        $queryData=$handleEstate->getDataByWhere(" third_name='".$saveData['third_name']."' and city_id='".$saveData['city_id']."' and estate_name_third='".$saveData['estate_name_third']."' limit 1");
        if($queryData!=null && count($queryData)>0){
            return $this->error('新增失败，已经存在映射信息！',U('Estate/addestatemap'),2);
        }
      }
      
      $result=$handleEstate->addModel($saveData);
      if($result){
        return $this->success('新增成功！',U('Estate/addestatemap'),1);
      }else{
        return $this->error('新增失败！',U('Estate/addestatemap'),1);
      }
    }
    public function removeEstatemap(){
      $id=I('post.id');
      if(empty($id)){
        echo '{"status":"400","message":"参数异常"}';return;
      }
      $handleEstate = new \Logic\EstateLogic();
      $result=$handleEstate->deleteEstatemap($id);
      if($result){
        echo '{"status":"200","message":"操作成功"}';
      }else{
        echo '{"status":"400","message":"操作失败"}';
      }
    }

       //导出excel
    public function downloadExcel(){
        $handleCommonCache=new \Logic\CommonCacheLogic();
        if(!$handleCommonCache->checkcache()){
            return $this->error('非法操作',U('Index/index'),1);
        }
        $handleEstate = new \Logic\EstateLogic();
        $estate_name=I('get.estate_name');
        $estate_type=I('get.estate_type');
        $business_type=I('get.business_type');
        $startTime=strtotime(I('get.starttime'));
        $endTime=strtotime(I('get.endtime'));
        $address=I('get.address');
        $region=I('get.region');
        $scope=I('get.scope');
        $estatecode=I('get.estatecode');
        $housetype=I('get.housetype');
        $brandtype=I('get.brand_type');
        $principal=I('get.principal');
        $principal_man=I('get.principal_man');
        $where=array();
        $where_page=array();
        if($startTime!=""&&$endTime==""){
           $where['create_time']=array('gt',$startTime);
        }
        if($endTime!=""&&$startTime==""){
           $where['create_time']=array('lt',$endTime+86400);
        }
        if($startTime!=""&&$endTime!=""){
             $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($startTime!=""&&$endTime!=""&&$startTime==$endTime){
             $where['create_time']=array(array('gt',$startTime),array('lt',$endTime+86400));
        }
        if($address!=""){
           $where['estate_address']=array('like','%'.$address.'%');
        }
        if($estate_name!=""){
           $where['estate_name']=array('like','%'.$estate_name.'%');
        }
        if($estate_type!=""){
           $where['estate_type']=array('eq',$estate_type);
        }
        if($business_type!=""){
           $where['business_type']=array('eq',$business_type);
        }
         if($region!=""){
          $where['region']=array('eq',$region);
      }
      if($scope!=""){
          $where['scope']=array('eq',$scope);
      }
      if($region!=""&&$scope!=""){
         $where['region']=array('eq',$region);
         $where['scope']=array('eq',$scope);
      }
      if($estatecode!=""){
           $where['estate_code']=array('eq',$estatecode);
      }
      if($housetype!=""){
           $where['house_type']=array('eq',$housetype);
      }
      if($brandtype!=""){
          $where['brand_type']=array('eq',$brandtype);
      }
      if($principal!=""&&$principal_man==""){
         $where['principal_man']=array('like',$principal.'%');
      }elseif($principal_man!=""&&$principal==""){
         $where['principal_man']=array('like',$principal_man.'%');
      }elseif($principal_man!=""&&$principal!=""){
          $where['principal_man']=array('like',$principal.'%');
      }
        $list=$handleEstate->getEstateDataList(0,1000,$where);
        $title=array(
            'estate_code'=>'楼盘编号','estate_name'=>'楼盘名称','estate_address'=>'楼盘地址','brand_type'=>'品牌','lpt_x'=>'坐标(经度)','lpt_y'=>'坐标(纬度)','region_name'=>'区域','scope_name'=>'商圈',
            'business_type'=>'业务类型','house_type'=>'房屋类型','create_time'=>'创建时间','create_man'=>'创建人','id'=>''
        );
        $handleLogic=new \Logic\HouseResourceLogic();
        $result=$handleLogic->getResourceParameters();
        $businesstype_array=array();//业务类型
        $housetype_array=$brandtype_array=array();//房屋类型
        if($result!=null){
            foreach ($result as $key => $value) {
              switch ($value['info_type']) {
                case 4:
                  $housetype_array[$value["type_no"]]=$value["name"];
                  break;
                case 15:
                  $businesstype_array[$value["type_no"]]=$value["name"];
                  break;
                case 16:
                  $brandtype_array[$value["type_no"]]=$value["name"];
                  break;
              }
            }
        }
        $excel[]=$title;
        foreach ($list as $key => $value) {
            $value['create_time']=$value['create_time']>0?date("Y-m-d H:i",$value['create_time']):""; 
            $value['id']='';
            $value['business_type']=$businesstype_array[$value['business_type']];
            $value['house_type']=$housetype_array[$value['house_type']];
            $value['brand_type']=$brandtype_array[$value['brand_type']];
            $excel[]=$value;
        }
        Vendor('phpexcel.phpexcel');
        $xls = new \Excel_XML('UTF-8', false, '楼盘列表');
        $xls->addArray($excel);
        $xls->generateXML('楼盘列表'.date("YmdHis"));
    }
    //提交合并楼盘信息
    public function mergeEstate(){
        $loginName=getLoginName();
        if(empty($loginName)){
          echo '{"status":"201","message":"登录失效"}';return;
        }
        $ids=I('post.ids');
        $one_id=I('post.one_id');

        if(empty($ids) || empty($one_id)){
          echo '{"status":"202","message":"参数错误"}'; return;
        }
        $ids_array=explode(',', rtrim($ids,','));
        $handleLogic=new \Logic\EstateLogic();
        $result=$handleLogic->mergeEstate($one_id,$ids_array);
        if($result==false){
          echo '{"status":"203","message":"操作失败"}';
        }else{
          echo '{"status":"200","message":"操作成功"}';
        }
        
    }

    //修改地铁交通信息
    public function editsubway(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
      $estate_id=I('get.estate_id');
      if(empty($estate_id)){
        echo '参数错误';return;
      }
      /*地铁线路 */
      $handleSubway = new \Logic\SubwayLogic();
      $result=$handleSubway->getAllSubwayLine();
      $subwaylineList='';
      if($result!=null){
        foreach ($result as $key => $value) {
          $subwaylineList.='<option value="'.$value["id"].','.$value["subwayline_name"].'">'.$value["subwayline_name"].'</option>';
        } 
      }
      $this->assign("subwaylineList",$subwaylineList);
      /*获取地铁线路 */
      $subway_list=$handleSubway->getSubwayByEstateid($estate_id);
      $this->assign("subways_str",json_encode($subway_list));
      $this->assign("subways_list", array('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29'));
      $this->display();
    }
    //修改地铁交通信息，提交数据
    public function editsubwaySubmit(){
       header ( "Content-type: text/html; charset=utf-8" );
       $handleCommonCache=new \Logic\CommonCacheLogic();
       if(!$handleCommonCache->checkcache()){
          return $this->error('非法操作',U('Index/index'),1);
       }
       $estate_id=I('post.estate_id');
       if(empty($estate_id)){
         echo '参数异常';return;
       }
       $handleEstate = new \Logic\EstateLogic();
       $data=$handleEstate->getModelById($estate_id);
       if($data==null || $data==false){
          echo '修改失败,楼盘信息不存在！';return;
       }
       //保存地铁路线
       $handleSubway = new \Logic\SubwayLogic();
       $handleSubway->deleteSubwayByEstateid($data['id']);
       $hadSubway=false;
       for ($i=0; $i < 30; $i++) { 
         if($_POST['subwayline'.$i]!="" && $_POST['subway'.$i]!="" && is_numeric($_POST['subway_distance'.$i])){
           $subwaydata['estate_id']=$data['id'];
           $line_arr = explode(',', $_POST['subwayline'.$i]);
           $subwaydata['subwayline_id']=$line_arr[0];
           $subwaydata['subwayline_name']=$line_arr[1];
           $way_arr = explode(',', $_POST['subway'.$i]);
           $subwaydata['subway_id']=$way_arr[0];
           $subwaydata['subway_name']=$way_arr[1];
           $subwaydata['subway_distance']=$_POST['subway_distance'.$i];
           $handleSubway->addSubwayestate($subwaydata);
           $hadSubway=true;
         }
       }
       //操作检索表
       $handleSelect=new \Logic\HouseSelectLogic();
       $handleSelect->deleteModelByEstateSubway($data['id']);
       if($hadSubway){
         $selectDal=new \Home\Model\houseselect();
         $selectDal->addModelByEstateSubway($data['id']);
       }
       echo '<script>alert("修改成功！");window.close();</script>';
    }

}
?>
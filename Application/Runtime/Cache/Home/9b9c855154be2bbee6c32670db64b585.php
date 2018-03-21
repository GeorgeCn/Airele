<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>审核房源</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
</head>
<body>
 <div class="citySelect"><!-- 城市切换 -->
		<select onchange="cutClick(this.options[this.selectedIndex].value)">
		   <?php if(is_array($switchcity)): $i = 0; $__LIST__ = $switchcity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['city_no'] == 1): ?><option value="1" selected="selected">上海</option><?php endif; ?>
			<?php if($vo['city_no'] == 2): ?><option value="2">北京</option><?php endif; ?>
			<?php if($vo['city_no'] == 3): ?><option value="3">杭州</option><?php endif; ?>
			<?php if($vo['city_no'] == 4): ?><option value="4">南京</option><?php endif; ?>
			<?php if($vo['city_no'] == 5): ?><option value="5">广州</option><?php endif; ?>
			<?php if($vo['city_no'] == 6): ?><option value="6">深圳</option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>

<script type="text/javascript">
	function cutClick(value){
		 if(value==1){
		    window.location.href="http://"+document.domain+"/admin/Welcome/welcome.html";
		 }else if(value==2){
		 	window.location.href="http://"+document.domain+"/adminbj/Welcome/welcome.html";
		 }else if(value==3){
		 	window.location.href="http://"+document.domain+"/adminhz/Welcome/welcome.html";
		 }else if(value==4){
		 	window.location.href="http://"+document.domain+"/adminnj/Welcome/welcome.html";
		 }else if(value==5){
		 	window.location.href="http://"+document.domain+"/admingz/Welcome/welcome.html";
		 }else if(value==6){
		 	window.location.href="http://"+document.domain+"/adminsz/Welcome/welcome.html";
		 }
	}
</script>
    <div class="title cf">
    	<div class="logo fl cf">
			<img src="/hizhu/Public/images/logo.png">
		</div>
		<ul class="cf fl">
		<li><a href="<?php echo U('Welcome/welcome');?>">首页</a></li>
			<?php echo ($menutophtml); ?>
		</ul>
		<div class="cf fr title_right">
			<a class="blue" href="javascript:">欢迎您 <?php echo cookie("admin_user_name");?></a>
			<span>|</span>
			<a href="<?php echo U('/Index/outlogin');?>">退出</a>
		</div>
    </div>
	<div class="main">
		<div class="main_left subNavBox">
		<input type="hidden" id="hdnTemp" value="1">
			<div id="btn" style="position:fixed;top:40%;left:15%;margin-left:-25px;height:50px;width:25px;right:0;z-index:9999;"> 
				<a style="position:relative;width:100%;display:block;">
					<img style="width:100%;height:100%;;display:block;" src="/hizhu/Public/images/jt_l.png">
				</a>
			</div>
			<?php echo ($menulefthtml); ?>
		</div>
		<div class="main_right">
			<div class="common_main">
				<form id="submitForm" action="/hizhu/HouseResource/examHousePass" method="post" enctype="multipart/form-data">
				<input type="hidden" name="agentOfferId" value="<?php echo ($agentOfferId); ?>">
					<div class="roompic">
						<div class="cf photos">
							<p class="fl">房间照（<span id="imgcount">0</span>/9）&nbsp;&nbsp;</p>
							<div class="uploadPhotos fl">
								<span>上传照片</span>
									<input id="fileupload" type="file" name="mypic[]" multiple="multiple" />
								<input type="hidden" id="uploadcount" name="uploadcount" />
							</div>
							
							<p id="upload_warn" style="margin-left:35px;line-heigth:50px;color:red;display:none;">上传中...</p>
						</div>
						<ul class="cf" id="imglist"><?php echo ($imgString); ?></ul>
					</div>
				<!--房源信息 start-->
				<table class="table_one table_two">
					<tr>
						<td class="td_title">房间介绍：</td>
						<td class="td_main"><textarea id="room_description" name="room_description"><?php echo ($roomModel['room_description']); ?></textarea></td>
					</tr>
					<?php if($resourceModel['is_owner']==5){ ?>
						<tr>
							<td colspan="2">中介信息</td>
						</tr>
						<tr>
							<td class="td_title">电话：</td>
							<td class="td_main">
								<a target="_blank" href="/hizhu/HouseRoom/searchroom.html?no=3&leftno=44&clientPhone=<?php echo ($resourceModel['client_phone']); ?>"><?php echo ($resourceModel['client_phone']); ?></a>		
							</td>
							
							
							<input type="hidden" id="client_phone" value="<?php echo ($resourceModel['client_phone']); ?>">
						</tr>
						<tr>
							<td class="td_title">公司：</td>
							<td class="td_main"><?php echo ($resourceModel['agent_company_name']); ?></td>
						</tr>
						<tr>
							<td class="td_title">中介费比率：</td>
							<td class="td_main"><?php echo ($resourceModel['agent_fee']); ?></td>
						</tr>
					<?php }else{ ?>
						<tr>
							<td colspan="2">房东信息</td>
						</tr>
						<tr>
							<td class="td_title">电话：</td>
							<td class="td_main"><a target="_blank" href="/hizhu/HouseRoom/searchroom.html?no=3&leftno=44&clientPhone=<?php echo ($resourceModel['client_phone']); ?>"><?php echo ($resourceModel['client_phone']); ?></a>&nbsp;
								<?php switch($resourceModel['city_code']): case "001009001": ?>&nbsp;&nbsp;<a target="_blank" href="http://sh.58.com/house/?key=<?php echo ($resourceModel['client_phone']); ?>&cmcskey=<?php echo ($resourceModel['client_phone']); ?>&final=1&jump=2&specialtype=gls&searchtype=1">58查询</a>&nbsp;&nbsp;<a target="_blank" href="http://sh.ganji.com/fang1/_<?php echo ($resourceModel['client_phone']); ?>/">赶集查询</a><?php break;?>
									<?php case "001001": ?>&nbsp;&nbsp;<a target="_blank" href="http://bj.58.com/house/?key=<?php echo ($resourceModel['client_phone']); ?>&cmcskey=<?php echo ($resourceModel['client_phone']); ?>&final=1&jump=2&specialtype=gls&searchtype=1">58查询</a>&nbsp;&nbsp;<a target="_blank" href="http://bj.ganji.com/fang1/_<?php echo ($resourceModel['client_phone']); ?>/">赶集查询</a><?php break;?>
									<?php case "001011001": ?>&nbsp;&nbsp;<a target="_blank" href="http://hz.58.com/house/?key=<?php echo ($resourceModel['client_phone']); ?>&cmcskey=<?php echo ($resourceModel['client_phone']); ?>&final=1&jump=2&specialtype=gls&searchtype=1">58查询</a>&nbsp;&nbsp;<a target="_blank" href="http://hz.ganji.com/fang1/_<?php echo ($resourceModel['client_phone']); ?>/">赶集查询</a><?php break;?>
									<?php case "001010001": ?>&nbsp;&nbsp;<a target="_blank" href="http://nj.58.com/house/?key=<?php echo ($resourceModel['client_phone']); ?>&cmcskey=<?php echo ($resourceModel['client_phone']); ?>&final=1&jump=2&specialtype=gls&searchtype=1">58查询</a>&nbsp;&nbsp;<a target="_blank" href="http://nj.ganji.com/fang1/_<?php echo ($resourceModel['client_phone']); ?>/">赶集查询</a><?php break;?>
									<?php case "001019002": ?>&nbsp;&nbsp;<a target="_blank" href="http://sz.58.com/house/?key=<?php echo ($resourceModel['client_phone']); ?>&cmcskey=<?php echo ($resourceModel['client_phone']); ?>&final=1&jump=2&specialtype=gls&searchtype=1">58查询</a>&nbsp;&nbsp;<a target="_blank" href="http://sz.ganji.com/fang1/_<?php echo ($resourceModel['client_phone']); ?>/">赶集查询</a><?php break; endswitch;?>
								
								&nbsp;&nbsp;<a target="_blank" href="https://www.so.com/s?ie=utf-8&shb=1&src=360sou_newhome&q=<?php echo ($resourceModel['client_phone']); ?>">360查询</a>
								&nbsp;&nbsp;<a href="#" onclick="addBlack('<?php echo ($resourceModel["client_phone"]); ?>')">拉黑</a>&nbsp;&nbsp;<a href="#" onclick="addMiddleman('<?php echo ($resourceModel["client_phone"]); ?>')">新增中介</a>
							</td>
							<input type="hidden" id="client_phone" value="<?php echo ($resourceModel['client_phone']); ?>">
						</tr>
					<?php } ?>
					<tr>
						<td class="td_title"><span>*</span>姓名：</td>
						<td class="td_main"><input type="text" name="client_name" value="<?php echo ($resourceModel['client_name']); ?>"></td>
					</tr>
					<tr>
						<td class="td_title">照片：</td>
						<td class="td_main">
							<div id="showImage" class="landlordPic" style="display:none;">
								<img src="" alt="">
								 <a href="javascript:" onclick="removeHeadImage()">删除</a> 
							</div>
							<input type="hidden" id="client_image" name="client_image" value="<?php echo ($resourceModel['client_image']); ?>" />
						</td>
					</tr>
					<tr>
						<td colspan="2">基本信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>数据来源：</td>
						<td class="td_main">
							<select name="info_resource_type" style="width:110px;">
								<?php echo ($infoResourceTypeList); ?>
							</select>
							<select name="info_resource" style="width:110px;">
								<?php echo ($infoResourceList); ?>
							</select>
						</td>
					</tr>
					<input type="hidden" name="business_type" value="<?php echo ($resourceModel['business_type']); ?>">
					<tr>
						<td class="td_title"><span>*</span>小区名称：</td>
						<td class="td_main">
							<input type="hidden" id="resource_id" name="resource_id" value="<?php echo ($resourceModel['id']); ?>" />
							<input type="text" id="estate_name" name="estate_name" value="<?php echo ($resourceModel['estate_name']); ?>" class="plotIpt" style="width:90%;">
							<input type="hidden" id="estate_id" name="estate_id" value="<?php echo ($resourceModel['estate_id']); ?>" />
							<input type="hidden" id="region" name="region" value="<?php echo ($resourceModel['region_id']); ?>" />
							<input type="hidden" id="scope" name="scope" value="<?php echo ($resourceModel['scope_id']); ?>" />
							<div id="estate_div" class="plotbox" style="width:90%;">
								<ul>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span></span>楼栋室号：</td>
						<td><input type="tel" id="unit_no" name="unit_no" value="<?php echo ($resourceModel['unit_no']); ?>" maxlength="5" class="smallwidth">楼栋/单元号&nbsp;&nbsp;<input type="tel" id="room_no" name="room_no" value="<?php echo ($resourceModel['room_no']); ?>" maxlength="5" class="smallwidth">室号</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>面积：</td>
						<td class="td_main"><input type="text" id="area" name="area" value="<?php echo ($resourceModel['area']); ?>" maxlength="4" class="smallwidth">平方米</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼层：</td>
						<td class="td_main"><input type="text" id="floor" name="floor" value="<?php echo ($resourceModel['floor']); ?>" maxlength="3" class="smallwidth">层&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;共&nbsp;&nbsp;<input type="text" id="floor_total" name="floor_total" value="<?php echo ($resourceModel['floor_total']); ?>" maxlength="3" class="smallwidth">层</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>户型：</td>
						<td class="td_main"><input type="text" id="room_num" value="<?php echo ($resourceModel['room_num']); ?>" name="room_num" maxlength="2" class="smallwidth">室&nbsp;&nbsp;<input type="text" id="hall_num" name="hall_num" value="<?php echo ($resourceModel['hall_num']); ?>" maxlength="1" class="smallwidth">厅&nbsp;&nbsp;<input type="text" id="wei_num" name="wei_num" value="<?php echo ($resourceModel['wei_num']); ?>" maxlength="1" class="smallwidth">卫</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房屋朝向：</td>
						<td class="td_main">
							<select id="house_direction" name="house_direction">
								<option value="">请选择</option>
								<?php echo ($houseDirectionList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间类型：</td>
						<td class="td_main">
							<select id="rent_type" name="rent_type">
								<option value="">请选择</option>
								<option value="1"<?php if($resourceModel["rent_type"]==1){echo 'selected';} ?>>合租</option>
								<option value="2"<?php if($resourceModel["rent_type"]==2){echo 'selected';} ?>>整租</option>
							</select>&nbsp;&nbsp;
							<label id="lbl_iscut">是否隔断：<select name="is_cut">
								<option value="0">请选择</option>
								<option value="1" <?php if($resourceModel["is_cut"]==1){echo selected;} ?> >是</option>
							</select></label>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间总数：</td>
						<td class="td_main">
							<select id="room_count" name="room_count">
								<option value="1">1</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">房源详细信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>装修情况：</td>
						<td class="td_main">
							<select id="decoration" name="decoration">
								<option value="">请选择</option>
								<?php echo ($decorationList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>付款方式：</td>
						<td class="td_main">
							<select id="pay_method" name="pay_method">
								<option value="">请选择</option>
								<?php echo ($payMethodList); ?>
							</select>
						</td>
					</tr>
					
					<!-- 新增品牌 -->
					<tr>
						<td class="td_title"><span>&nbsp;</span>品牌：</td>
						<td class="td_main">
							<select id="brand_type" name="brand_type">
								<option value="">请选择</option>
								<?php echo ($brandTypeList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>共用设施：</td>
						<td class="td_main">
							<?php echo ($publicEquipmentList); ?>
						</td>
					</tr>
				
					<tr>
						<td class="td_title">出租类型：</td>
						<td class="td_main">
							<label><input type="radio" name="rental_type" value="0">暂无</label>&nbsp;&nbsp;
							<label><input type="radio" name="rental_type" value="1">个人转租</label>&nbsp;&nbsp;
							<label><input type="radio" name="rental_type" value="3">职业二房东</label>&nbsp;&nbsp;
							<label><input type="radio" name="rental_type" value="4">房东直租</label>&nbsp;&nbsp;
						</td>
					</tr> 
				</table>
				<!--房源信息 end-->
		
				<!--房间信息 start-->
				<input type="hidden" id="room_id" name="room_id" value="<?php echo ($roomModel['id']); ?>">
				<table class="table_one table_two">
					<tr>
						<td colspan="2">房间信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间名称：</td>
						<td class="td_main">
							<select id="room_name" name="room_name">
								<option value="">请选择</option>
								<?php echo ($roomNames); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间面积：</td>
						<td><input type="text" id="room_area" name="room_area" value="<?php echo ($roomModel['room_area']); ?>" maxlength="3" class="smallwidth">平方米</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>租金：</td>
						<td class="td_main"><input type="text" id="room_money" name="room_money" maxlength="5" value="<?php echo ($roomModel['room_money']); ?>" class="smallwidth">元/月</td>
					</tr>
					
					<tr>
						<td class="td_title"><span>*</span>房间朝向：</td>
						<td class="td_main">
							<select id="room_direction" name="room_direction">
								<option value="">请选择</option>
								<?php echo ($houseDirectionList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间设施：</td>
						<td class="td_main">
							<?php echo ($room_equipment); ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">特色标签：</td>
						<td class="td_main">
							<label><input type="radio" name="girl_tag" value="0">无</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="1">限女生</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="2">限男生</label>
						</td>
					</tr>
					
					<tr>
						<td class="td_title"><span></span>不通过原因：</td>
						<td class="td_main">
							<select id="ddl_nopassreason">
								<option value=""></option>
								<option value="请注明是否收取中介费服务费等其他费用">请注明是否收取中介费服务费等其他费用</option>
								<option value="相同图片房源请勿重复提交，请保证房源与图片一致">相同图片房源请勿重复提交，请保证房源与图片一致</option>
								<option value="请按实际情况勾选房间“独用设施”">请按实际情况勾选房间“独用设施”</option>
							</select>
							<br><input type="text" id="ext_examineinfo" style="width:90%"></td>
					</tr>
				</table>
				
				
				<!--房间信息 end-->

				</form>
				<div class="addhouse_last addhouse_last_room">
					<a href="javascript:;" class="btn_a" id="submit_pass">通过</a>
					<a href="javascript:;" class="btn_a" id="submit_nopass">不通过</a></div>
			</div>
		</div>
		<!--浮层(拉黑) -->
		<div id="dialogDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
			<div style="width:700px;height:460px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:40%;margin-top:-135px;border-radius:10px;">
				<table class="table_one">
					<tr>
						<td class="td_title"><span>*</span>联系电话：</td> 
						<td><input type="text" name="mobile" maxlength="20"></td>
					</tr>
					<tr>
						<td class="td_title">限制登录：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_login">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">限制回复：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_post_replay">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">是否隐藏帖子和回复：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="hide_circle">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">限制拨打房东电话：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_call">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">操作房源：</td>
						<td class="td_main">
							<label><input type="radio" name="soldouthouse" value="0">无</label>&nbsp;
							<label><input type="radio" name="soldouthouse" value="1">下架</label>&nbsp;
							<label><input type="radio" name="soldouthouse" value="2" checked="checked">删除</label>
						</td>
					</tr>
					<tr>
							<td class="td_title">是否发送短信：</td>
							<td class="td_main">
								<label><input type="checkbox" name="is_sendmessage">是</label>
							</td>
						</tr>
					<tr>
							<td class="td_title"><span>*</span>拉黑原因：</td> 
							<td>
								<select name="bak_type">
									<option value="0">请选择</option>
									<option value="1">骗子/钓鱼/微商</option>
									<option value="2">违规操作</option>
									<option value="3">商务需求</option>
									<option value="4">中介/托管</option>
									<option value="6">其他</option>
								</select>
							</td>
						</tr>
					<tr>
						<td class="td_title"><span></span>备注信息：</td>
						<td class="td_main">
							<input type="text" name="bak_info" maxlength="50" style="width:100%">
						</td>
					</tr>
				</table>
				<input type="hidden" name="is_owner">
				<div style="margin:20px 0 50px;text-align:center;">
					<a href="javascript:;" class="btn_b" style="margin-right:30px;">取消</a>
					<a href="javascript:;" class="btn_a" id="submit_black">提交</a>
				</div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
/*删除房东头像 */
function removeHeadImage(){
	if(confirm("确定要删除吗？")){
		$("#client_image").val("");
		$("#showImage").hide().find("img").attr("src","");
		//$("#uploadImage").show();
	}
}
var rental_type='<?php echo ($resourceModel["rental_type"]); ?>';
$("input[name=rental_type][value="+rental_type+"]").attr("checked","checked");
	/*绑定数据(1基本信息)*/
	$("select[name='info_resource_type']").val('<?php echo ($resourceModel["info_resource_type"]); ?>');
	$("select[name='info_resource']").val('<?php echo ($resourceModel["info_resource"]); ?>');
	//下拉联动，来源
	$("select[name='info_resource_type']").change(function(){
		if($(this).val()==""){
			$("select[name='info_resource']").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getInforesourceByType",{type:$(this).val()},function(data){
			$("select[name='info_resource']").html(data);
		},"html");
	});

	$("#house_direction").val('<?php echo ($resourceModel["house_direction"]); ?>');
	/*绑定数据(2房源详细)*/
	$("#decoration").val('<?php echo ($resourceModel["decoration"]); ?>');
	$("#pay_method").val('<?php echo ($resourceModel["pay_method"]); ?>');
	//$("#room_type").val('<?php echo ($resourceModel["room_type"]); ?>');
	$("#brand_type").val('<?php echo ($resourceModel["brand_type"]); ?>');
	var public_equipment='<?php echo ($resourceModel["public_equipment"]); ?>';
	if(public_equipment !=''){
		var equipment_array=public_equipment.split(",");
		for (var i = equipment_array.length - 1; i >= 0; i--) {
			$("input[name^=public_equipment][value="+equipment_array[i]+"]").attr("checked","checked");
		};
	}
	//暂无设施，点击事件
	$("input[name^=public_equipment][value='0312']").click(function(){
		if($(this).attr('checked')=='checked'){
			$("input[name^=public_equipment][value!='0312']").removeAttr("checked");
		}
	});
	$("input[name^=room_equipment][value='1114']").click(function(){
		if($(this).attr('checked')=='checked'){
			$("input[name^=room_equipment][value!='1114']").removeAttr("checked");
		}
	});
	/*绑定数据(3房东信息)*/
	var client_image='<?php echo ($resourceModel["client_image"]); ?>';
	if(client_image !=''){
		var point_index=client_image.lastIndexOf(".");
		var corp_img_url=client_image.substring(0,point_index)+"_200_200"+client_image.substring(point_index);
		$("#showImage").show().find("img").attr("src",corp_img_url);
		//$("#uploadImage").hide();
	}
	/*选择小区*/
	function selectEstate(estate_id,estate_name,region,scope,business_type){
		$("#estate_id").val(estate_id);
		$("#estate_name").val(estate_name);
		$("#region").val(region);
		$("#scope").val(scope);
		$("input[name='business_type']").val(business_type);
		$("#estate_div").hide();
	}
	/*检索小区*/
	$("#estate_name").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<2){
			return;
		}
		//var typeValue=$('input:radio[name="business_type"]:checked').val();
		$.get("/hizhu/HouseResource/searchestate",{keyword:key_word,type:''},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#estate_div ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectEstate('"+attr[i].id+"','"+attr[i].estate_name+"','"+attr[i].region+"','"+attr[i].scope+"','"+attr[i].business_type+"')\" >"+attr[i].estate_name+"--"+attr[i].estate_address+"--"+attr[i].business_typename+"--"+attr[i].region_name+"--"+attr[i].scope_name+"</li>");
				};
				if(len>0){
					$("#estate_div").show();
				}else{
					$("#estate_div").hide();
				}
			}
		},"json");
	});
	$("#submit_pass").bind("click",function(){
		submitPass();
	});
	$("#submit_nopass").bind("click",function(){
		submitNopass();
	});
	/*审核通过 */
	function submitPass(){
		/*校验*/
		var inputAll=true;
		$("#submitForm input[type='text']").each(function(){
			if($(this).val()==''&& $(this).attr("id")!="ext_examineinfo"){
				inputAll=false;	return;
			}
		});
		if(inputAll){
			var attr_id='';
			$("#submitForm select").each(function(){
				if($(this).val()==''){
					attr_id=$(this).attr("id");
					if(attr_id!="brand_type" && attr_id!="ddl_nopassreason" && $(this).attr("name")!="is_cut"){
						inputAll=false;	return;
					}
				}
			});
		}
		if(!inputAll){
			alert('带*为必填项');return;
		}
		var floatExp=/^([1-9]\d*\.\d*|0\.\d+|[1-9]\d*|0)$/;
		var area=parseFloat($("#area").val());
		var room_area=parseFloat($("#room_area").val());

		var floorExp=/^\-?\d{1,4}$/;
		if(!floorExp.test($("#floor").val()) || !floorExp.test($("#floor_total").val())){
			alert('楼层须为整数');return;
		}
		if(parseInt($("#floor").val())>parseInt($("#floor_total").val())){
			alert('所在楼层不能超过总楼层');return;
		}
		var numExp=/^\d{1,5}$/;
		if(!numExp.test($("#room_num").val()) || !numExp.test($("#hall_num").val()) || !numExp.test($("#wei_num").val())){
			alert('户型须为整数');return;
		}
		if($("input[name^=public_equipment]:checked").length==0){
			alert('须勾选共用设施');return;
		}
		//房间信息
		if($("#room_name").val()==""){
			alert('请选择房间名称');return;
		}
		if(room_area<5 || isNaN(room_area)){
			alert('房间面积不能<5㎡');return;
		}
		var roomMoney=parseInt($("#room_money").val());
		if(roomMoney<100 || isNaN(roomMoney)){
			alert('租金不能<100元');return;
		}
		if($("#room_direction").val()==""){
			alert('请选择房间朝向');return;
		}
		if($("input[name^=room_equipment]:checked").length==0){
			alert('请勾选房间设施');return;
		}
		var imgsObj=$("#imglist li:visible");
		if(imgsObj.length==0){
			alert('至少上传1张图片');return;
		}
		var mainimg_count=imgsObj.find("input[name=main_img]:checked").length;
		if(mainimg_count==0){
			alert('请设置房间照封面');return;
		}
		/*新增提醒 */
		if($("select[name='rent_type']").val()=='1'){
			if(room_area>=area){
				alert('合租的房间面积不能大于或等于整套面积');return;
			}
			if(room_area>=40){
				if(!confirm('本单间的面积已经≥40㎡，是否确认提交？')){return;}
			}
		}else{
			if(room_area!=area){
				alert('整租的房间面积必须等于整套面积');return;
			}
			var roomNum=parseInt($("input[name='room_num']").val());
			if(roomNum==1 && area>=100){
				if(!confirm('本整租1室的面积已经≥100㎡，是否确认提交？')){return;}
			}else if(roomNum==2 && area>=150){
				if(!confirm('本整租2室的面积已经≥150㎡，是否确认提交？')){return;}
			}else if(roomNum>=3 && area>=250){
				if(!confirm('本整租的面积已经≥250㎡，是否确认提交？')){return;}
			}
		}
		var cityId=$(".citySelect select").val();
		var areaMoney=parseInt(roomMoney/room_area);
		if(cityId==1 || cityId==2) {
			if(areaMoney<=25 || areaMoney>=300){
				if(!confirm('北京/上海的正常房租在[￥25/㎡，￥300/㎡]之间，本房间的租金异常，是否确认提交？')){return;}
			}
		}else if(cityId==3 || cityId==4){
			if(areaMoney<=15 || areaMoney>=200){
				if(!confirm('南京/杭州的正常房租在[￥15/㎡，￥200/㎡]之间，本房间的租金异常，是否确认提交？')){return;}
			}
		}
		sureSubmit();
	}
	function sureSubmit(){
		$("#submit_pass").unbind("click").text("提交中");
		//var typeValue=$('input:radio[name="business_type"]:checked').val();
		$.get("/hizhu/HouseResourcerob/checkAddResourceInfo",{estate_id:$("#estate_id").val(),estate_name:$("#estate_name").val(),type:'',client_phone:$("#client_phone").val()},function(result){
			if(result.status=="200"){
				if($("#estate_id").val()==""){
					var jsonObj=result.data[0];
					$("#estate_id").val(jsonObj.id);
					$("#estate_name").val(jsonObj.estate_name);
					$("#region").val(jsonObj.region);
					$("#scope").val(jsonObj.scope);
					$("input[name='business_type']").val(jsonObj.business_type);
				}
				$("#submitForm").submit();/*提交*/
			}else{
				alert(result.msg);
				$("#submit_pass").bind("click",function(){
					submitPass();
				}).text("通过");
			}
		},"json");
	}
	/*审核不通过 */
	$("#ddl_nopassreason").change(function(){
		var reasonValue=$(this).val();
		$("#ext_examineinfo").val(reasonValue);
	});
	function submitNopass(){
		var exam_bak=$("#ext_examineinfo").val().replace(/\s+/g,'');
		if(exam_bak==""){
			alert("输入不通过原因");$("#ext_examineinfo").focus();return;
		}
		if(exam_bak.length>40){
			alert("原因输入的过长，不超过40个字。");$("#ext_examineinfo").focus();return;
		}
		$("#submit_nopass").unbind("click").text("提交中");
		$.post('/hizhu/HouseResource/examHouseNopass',{info_resource_type:$("select[name='info_resource_type']").val(),ext_examineinfo:exam_bak,room_id:$("#room_id").val(),resource_id:$("#resource_id").val(),customer_id:"<?php echo ($resourceModel['customer_id']); ?>",estate_name:$("#estate_name").val()},function(data){
			alert(data.message);
			if(data.status=="200"){
				window.close();
			}else{
				$("#submit_nopass").bind("click",function(){
					submitNopass();
				}).text("不通过");
			}
		},'json');
	}

</script>
<!--房间信息-->
<script type="text/javascript">
	/*绑定数据 */
	var room_name='<?php echo ($roomModel["room_name"]); ?>';
	if(room_name=='次卧'){
		$("#room_name").val("次卧A");
	}else{
		$("#room_name").val(room_name);
	}
	var room_names='<option value="">请选择</option><option value="主卧">主卧</option><option value="次卧A">次卧A</option><option value="次卧B">次卧B</option><option value="次卧C">次卧C</option><option value="次卧D">次卧D</option><option value="次卧E">次卧E</option><option value="次卧F">次卧F</option><option value="次卧G">次卧G</option><option value="次卧H">次卧H</option><option value="次卧I">次卧I</option><option value="客厅">客厅</option><option value="床位">床位</option>';
	if($("#room_name").val()==''){
		if($("#rent_type").val()=='2'){
			$("#room_name").html('<option value="整套">整套</option>');
		}else{
			var businessType=$("input[name='business_type']").val();
			if(businessType=='1502' || businessType=='1503'){
				$("#room_name").html('<option value="">请选择</option><option value="主卧">主卧</option><option value="次卧">次卧</option><option value="床位">床位</option>');
			}else{
				$("#room_name").html(room_names);
			}
		}
	}
	if($("#rent_type").val()=='2'){
		$("#lbl_iscut").hide();$("select[name='is_cut']").val('0');
	}
	$("#rent_type").change(function(){
		if($(this).val()=='2'){
			$("#room_name").html('<option value="整套">整套</option>');
			$("#lbl_iscut").hide();$("select[name='is_cut']").val('0');
		}else{
			var businessType=$("input[name='business_type']").val();
			if(businessType=='1502' || businessType=='1503'){
				$("#room_name").html('<option value="">请选择</option><option value="主卧">主卧</option><option value="次卧">次卧</option><option value="床位">床位</option>');
			}else{
				$("#room_name").html(room_names);
			}
			$("#lbl_iscut").show();
		}
	});
	$("#room_direction").val('<?php echo ($roomModel["room_direction"]); ?>');
	var room_equipment='<?php echo ($roomModel["room_equipment"]); ?>';
	if(room_equipment !=''){
		var equipment_array=room_equipment.split(",");
		for (var i = equipment_array.length - 1; i >= 0; i--) {
			$("input[name^=room_equipment][value="+equipment_array[i]+"]").attr("checked","checked");
		};
	}
	var girl_tag='<?php echo ($roomModel["girl_tag"]); ?>';
	$("input[name=girl_tag][value="+girl_tag+"]").attr("checked","checked");
	
	var imgcount=$("#imglist li").length;
	$("#imgcount").text(imgcount);
	//主图片绑定
	var main_imgid='<?php echo ($roomModel["main_img_id"]); ?>';
	$("input[name=main_img][value^="+main_imgid+"]").attr("checked","checked");
	/*删除图片*/
	function removePic(img_id,obj){
		var imgsObj=$("#imglist li:visible");
		if(imgsObj.length==1){
			alert('至少保留1张图片');
			return;
		}
		if(confirm("确定要删除吗？")){
			$.get('/hizhu/HouseRoom/deleteImage',{img_id:img_id},function(data){
				if(data.status=="200"){
					$(obj).parent().hide();
					var img_count=parseInt($("#imgcount").text());
					$("#imgcount").text(img_count-1);
					$("#uploadcount").val(imgcount-1);
				}else{
					alert(data.msg);
				}
			},'json');
		}
	}
$(function () {
	/*上传图片*/
    $("#fileupload").change(function(){
    	var imgcount=parseInt($("#imgcount").text());
    	if(imgcount>=9){
    		alert("最多上传9张图片");
    		return;
    	}
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
				$("#upload_warn").html("上传中...").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				var img_data=result.data;
				for (var i = img_data.length - 1; i >= 0; i--) {
					var img_url=img_data[i].imgUrl;
					var point_index=img_url.lastIndexOf(".");
					var corp_img_url=img_url.substring(0,point_index)+"_200_130"+img_url.substring(point_index);
					$("#imglist").append('<li><img src="'+corp_img_url+'" alt=""><br/><a href="javascript:;" onclick="removePic(\''+img_data[i].imgId+'\',this)">删除</a><br/><label><input type="radio" value="'+img_data[i].imgId+','+img_url+'" name="main_img">封面</label></li>');
				};
				$("#imgcount").text(imgcount+img_data.length);
				$("#uploadcount").val(imgcount+img_data.length);
				$("#fileupload").val('');
				$("#upload_warn").hide();
			},
			error:function(xhr){
				$("#upload_warn").hide();
				if(xhr.responseText!=''){
					alert(xhr.responseText);
				}
				
			}
		});
	});
});
</script>
<script type="text/javascript">
	/*拉黑用户 */
	function addBlack(phone){
		$("#dialogDiv").show();
		$("input[name='mobile']").val(phone);
	}
	function addMiddleman(phone){
		if(confirm('确定新增中介吗？')) {
	     	$.get("/hizhu/AgentsManage/setAgentsInfo?mobile="+phone+"&source=房源审核",function(data){
				alert(data.message);
			},"json");
		}
  	}
	$(".btn_b").click(function(){
		$("#dialogDiv").hide();
		$("input[name='mobile']").val('');
		$("select[name='bak_type']").val('0');
		$("input[name='bak_info']").val('');
	});
	$("#submit_black").click(function(){
		submitBlack();
	});
	function submitBlack(){
		var mobile=$("input[name='mobile']").val().replace(/\s+/g,'');
		var isTel=/^[023456789]+\,{0,1}\d*$/;
		var isMobile=/^1[34578]\d{9}$/;
		if(!isTel.test(mobile) && !isMobile.test(mobile)){
			alert("无效的联系电话");return;
		}
		var bak_type=$("select[name='bak_type']").val();
		if(bak_type=='0'){
			alert("请选择拉黑原因");return;
		}
		$("#submit_black").unbind("click").text('提交中');
		$.get('/hizhu/BlackList/checkOwnerUser?mobile='+mobile,function(result){
			if(result.status=="200"){
				if(confirm('此用户是职业房东，确认拉黑吗？')){
					submitBlackPost(mobile,bak_type,1);
				}else{
					$("#submit_black").bind('click',function(){
						submitBlack();
					}).text('提交');
				}
			}else if(result.status=="300"){
				alert(result.message);
				$("#submit_black").bind('click',function(){
					submitBlack();
				}).text('提交');
			}else{
				submitBlackPost(mobile,bak_type,0);
			}
		},'json');
	}
	function submitBlackPost(mobile,bak_type,is_owner){
		var no_login=0;
		var no_post_replay=0;
		var no_call=0;
		var is_sendmessage=0;
		var hide_circle=0;
		if($("input[name='hide_circle']").attr("checked")=="checked"){
			hide_circle=1;
		}
		if($("input[name='no_login']").attr("checked")=="checked"){
			no_login=1;
		}
		if($("input[name='no_post_replay']").attr("checked")=="checked"){
			no_post_replay=1;
		}
		if($("input[name='no_call']").attr("checked")=="checked"){
			no_call=1;
		}
		if($("input[name='is_sendmessage']").attr("checked")=="checked"){
			is_sendmessage=1;
		}
		var soldouthouse=$('input:radio[name="soldouthouse"]:checked').val();
		if(soldouthouse==undefined){
			soldouthouse=0;
		}
		$.post('/hizhu/BlackList/saveBlackUser',{addType:'other',mobile:mobile,bak_type:bak_type,bak_info:$("input[name='bak_info']").val(),is_owner:is_owner,no_login:no_login,no_post_replay:no_post_replay,no_call:no_call,soldouthouse:soldouthouse,is_sendmessage:is_sendmessage,hide_circle:hide_circle},function(data){
			if(data.status=="200"){
				alert('操作成功');
				$("#dialogDiv").hide();
				$("#submit_pass").hide();
				$("#submit_nopass").hide();
			}else{
				alert('操作失败');
			}
		},'json');
	}
</script>
</html>
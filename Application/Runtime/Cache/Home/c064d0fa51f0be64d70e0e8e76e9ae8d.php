<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>添加房源</title>
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
			<div class="common_head progressbar">
				<h2>
					<span class="cur"><em>1</em>发布房源</span><span class="line"></span><span><em>2</em>管理房间</span>
				</h2>
			</div>
			<div class="common_main">
				<form id="submitForm" action="/hizhu/HouseResource/submitresource" method="post" enctype="multipart/form-data">
					<input type="hidden" name="handletype" value="<?php echo isset($_GET['handletype'])?$_GET['handletype']:'';?>" />
				<table class="table_one table_two">
					<tr>
						<td colspan="2">整套信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>数据来源：</td>
						<td class="td_main">
							<select name="info_resource_type" style="width:100px;">
								<?php echo ($infoResourceTypeList); ?>
							</select>
							<select name="info_resource" style="width:100px;">
								<?php echo ($infoResourceList); ?>
							</select>
						</td>
					</tr>
					<!-- <tr>
						<td class="td_title"><span>*</span>业务类型：</td>
						<td class="td_main">
							<?php echo ($businessTypeList); ?>
						</td>
					</tr> -->
					<input type="hidden" name="business_type" value="<?php echo ($resourceModel['business_type']); ?>">
					<tr>
						<td class="td_title"><span>*</span>小区名称：</td>
						<td class="td_main">
							<input type="hidden" id="resource_id" name="resource_id" value="<?php echo ($resourceModel['id']); ?>" />
							<input type="text" id="estate_name" name="estate_name" value="<?php echo ($resourceModel['estate_name']); ?>" class="plotIpt" style="width:90%;">
							<input type="hidden" id="estate_id" name="estate_id" value="<?php echo ($resourceModel['estate_id']); ?>" />
							<input type="hidden" id="region" name="region" value="<?php echo ($resourceModel['region_id']); ?>" />
							<input type="hidden" id="scope" name="scope" value="<?php echo ($resourceModel['scope_id']); ?>" />
							<input type="hidden" name="region_name" value="<?php echo ($resourceModel['region_name']); ?>" />
							<input type="hidden" name="scope_name" value="<?php echo ($resourceModel['scope_name']); ?>" />
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
					<!-- <tr>
						<td class="td_title"><span>*</span>房屋类型：</td>
						<td class="td_main">
							<select id="house_type" name="house_type">
								<option value="">请选择</option>
								<?php echo ($houseTypeList); ?>
							</select>
						</td>
					</tr> -->
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
								<option value="">请选择</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">房源详细信息（<span>可修改</span>）</td>
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
					<!-- 独家房源 -->
					<tr>
						<td class="td_title"><span>&nbsp;</span>是否独家房源：</td>
						<td class="td_main">
							<label><input type="checkbox" id="sole_flag" name="sole_flag[]">是</label>
						</td>
					</tr>
					<!-- 出租类型 -->
					<!-- <tr>
						<td class="td_title"><span>&nbsp;</span>出租类型：</td>
						<td class="td_main">
							<label><input type="radio" name="rental_type" value="0">暂无</label>&nbsp;
							<label><input type="radio" name="rental_type" value="1">个人转租</label>&nbsp;
							<label><input type="radio" name="rental_type" value="3">职业二房东</label>&nbsp;
							<label><input type="radio" name="rental_type" value="4">房东直租</label>&nbsp;
							<label><input type="radio" name="rental_type" value="5">经纪人房源</label>&nbsp;
						</td>
					</tr> -->
					<tr>
						<td colspan="2">房东信息（<span>如果您是二房东，请填写本人信息</span>）</td>
					</tr>
					<tr>
						<td class="td_title"></td>
						<td class="td_main"><label><input type="checkbox" name="rental_type_agent">经纪人房源</label></td>
					</tr>
					<tr>
						<td class="td_title">房东电话：</td>
						<td class="td_main"><input type="tel" id="client_phone" name="client_phone" value="<?php echo ($resourceModel['client_phone']); ?>" maxlength="20">&nbsp;<span style="color:red;" id="warnBlackUser"></span></td>
					</tr>
					
					<tr>
						<td class="td_title">房东姓名：</td>
						<td class="td_main"><input type="tel" id="client_name" name="client_name" value="<?php echo ($resourceModel['client_name']); ?>" maxlength="10"></td>
					</tr>
					<tr>
						<td class="td_title">房东座机：</td>
						<td class="td_main"><input type="tel" id="client_telephone" name="client_telephone" value="<?php echo ($resourceModel['client_telephone']); ?>" maxlength="20">&nbsp;如果填写座机，前台联系房东将拨打座机号</td>
					</tr>
					<tr>
						<td class="td_title">性别：</td>
						<td class="td_main">
							<label><input type="radio" name="client_sex" value="1" checked="checked" />男</label>&nbsp;
							<label><input type="radio" name="client_sex" value="0" />女</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">年龄段：</td>
						<td class="td_main">
							<?php echo ($clientAgeList); ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">房东喜欢的租客：</td>
						<td class="td_main">
							<?php echo ($clientLoveList); ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">房东照片：</td>
						<td class="td_main">
							<div id="uploadImage" class="uploadPhotos fl landlordBtn">
								<span>上传照片</span>
								<input id="fileupload" type="file" name="mypic" />
							</div>
							<div id="showImage" class="landlordPic" style="display:none;">
								<img src="" alt="">
								<a href="javascript:" onclick="removePic()">删除</a>
							</div>
							<input type="hidden" id="client_image" name="client_image" value="<?php echo ($resourceModel['client_image']); ?>" />
						</td>
					</tr>
				</table>
				</form>
				<div class="addhouse_next"><a href="javascript:;" id="submit_a" class="btn_a">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
/*删除图片*/
function removePic(){
	if(confirm("确定要删除吗？")){
		$("#client_image").val("");
		$("#showImage").hide().find("img").attr("src","");
		$("#uploadImage").show();
	}
}
$(function () {
    $("#fileupload").change(function(){
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				var img_url=result.data.imgUrl;
				var point_index=img_url.lastIndexOf(".");
				var corp_img_url=img_url.substring(0,point_index)+"_200_200"+img_url.substring(point_index);
				$("#client_image").val(img_url);
				$("#showImage").show().find("img").attr("src",corp_img_url);
				$("#uploadImage").hide();
				$("#fileupload").val('');
			},
			error:function(xhr){
				if(xhr.responseText!=''){
					alert(xhr.responseText);
				}
			}
		});
	});
});
</script>
<script type="text/javascript">
	var sole_flag='<?php echo ($resourceModel["sole_flag"]); ?>';
	if(sole_flag=="1"){
		$("#sole_flag").attr("checked","checked");
	}
	/*改变 房间类型*/
	if($("#rent_type").val()=='2'){
		$("#lbl_iscut").hide();$("select[name='is_cut']").val('0');
	}
	$("#rent_type").change(function(){
		if($(this).val()=='2'){
			$("#lbl_iscut").hide();$("select[name='is_cut']").val('0');
		}else{
			$("#lbl_iscut").show();
		}
	});
	/*绑定数据(1基本信息)*/
	//来源
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
	$("#room_count").val('<?php echo ($resourceModel["room_count"]); ?>');//房间数量
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
	//出租类型
/*	var rental_type='<?php echo ($resourceModel["rental_type"]); ?>';
	$("input[name=rental_type][value="+rental_type+"]").attr("checked","checked");*/
	if($("#resource_id").val()!=''){
		if("5"=='<?php echo ($resourceModel["rental_type"]); ?>'){
			$("input[name='rental_type_agent']").attr("checked","checked");
		}
		$("input[name='rental_type_agent']").attr("disabled","disabled");
	}
	$("input[name='rental_type_agent']").click(function(){
		console.log($(this).attr("checked"));
		if($(this).attr("checked")=="checked"){
			$(this).parent().parent().parent().nextAll().hide();
		}else{
			$(this).parent().parent().parent().nextAll().show();
		}
	})
	/*绑定数据(3房东信息)*/
	var client_sex='<?php echo ($resourceModel["client_sex"]); ?>';
	var client_age='<?php echo ($resourceModel["client_age"]); ?>';
	var client_love='<?php echo ($resourceModel["client_love"]); ?>';
	if(client_sex=="0"){
		$("input[name=client_sex][value=0]").attr("checked","checked");
	}
	if(client_age==""){
		$("input[name=client_age]:eq(5)").attr("checked","checked");
	}else{
		$("input[name=client_age][value="+client_age+"]").attr("checked","checked");
	}
	if(client_love !=''){
		var love_array=client_love.split(",");
		for (var i = love_array.length - 1; i >= 0; i--) {
			$("input[name^=client_love][value="+love_array[i]+"]").attr("checked","checked");
		};
	}
	var client_image='<?php echo ($resourceModel["client_image"]); ?>';
	if(client_image !=''){
		var point_index=client_image.lastIndexOf(".");
		var corp_img_url=client_image.substring(0,point_index)+"_200_200"+client_image.substring(point_index);
		$("#showImage").show().find("img").attr("src",corp_img_url);
		$("#uploadImage").hide();
	}
	/*选择小区*/
	function selectEstate(estate_id,estate_name,region,scope,business_type){
		$("#estate_id").val(estate_id);
		$("#estate_name").val(estate_name);
		$("#region").val(region);
		$("#scope").val(scope);
		$("input[name='business_type']").val(business_type);
		$("input[name='region_name']").val("");
		$("input[name='scope_name']").val("");
		$("#estate_div").hide();
	}
	/*黑名单*/
	$("#client_phone").blur(function(){
		$.get("/hizhu/HouseResource/checkBlackUser",{mobile:$(this).val()},function(data){
			if(data.status!="200"){
				$("#warnBlackUser").text(data.msg);
			}else{
				$("#warnBlackUser").text("");
			}
		},"json");
	});
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
					obj.append("<li onclick=\"selectEstate('"+attr[i].id+"','"+attr[i].estate_name+"','"+attr[i].region+"','"+attr[i].scope+"','"+attr[i].business_type+"')\" >"+attr[i].estate_name+"--"+attr[i].estate_address+"--"+attr[i].business_typename+"</li>");
				};
				if(len>0){
					$("#estate_div").show();
				}else{
					$("#estate_div").hide();
				}
			}
		},"json");
	});
	/*提交表单*/
	$("#submit_a").bind("click",function(){
		btnSubmit();
	});
	
	function btnSubmit(){
		/*校验*/
		var inputAll=true;
		$("#submitForm input[type='text']").each(function(){
			if($(this).val()==''){
				inputAll=false;	return;
			}
		});
		if(inputAll){
			$("#submitForm select").each(function(){
				if($(this).val()==''){
					if($(this).attr("id")!="brand_type" && $(this).attr("name")!="is_cut"){
						inputAll=false;	return;
					}
				}
			});
		}
		if(!inputAll){
			alert('带*为必填项');return;
		}
		var numExp=/^\d{1,4}$/;
		var floatExp=/^([1-9]\d*\.\d*|0\.\d+|[1-9]\d*|0)$/;
		if(!floatExp.test($("#area").val())){
			alert('面积格式不正确');return;
		}
		var floorExp=/^\-?\d{1,4}$/;
		if(!floorExp.test($("#floor").val()) || !floorExp.test($("#floor_total").val())){
			alert('楼层须为整数');return;
		}
		if(parseInt($("#floor").val())>parseInt($("#floor_total").val())){
			alert('所在楼层不能超过总楼层');return;
		}
		if(!numExp.test($("#room_num").val()) || !numExp.test($("#hall_num").val()) || !numExp.test($("#wei_num").val())){
			alert('户型须为整数');return;
		}
		var equipment_count=$("input[name^=public_equipment]:checked").length;
		if(equipment_count==0){
			alert('须勾选共用设施');return;
		}
		var isTel=/^\d+\,{0,1}\d*$/;
		/*验证经纪人房源 */
		if($("input[name='rental_type_agent']").attr("checked")!="checked"){
			if(!isTel.test($("#client_phone").val())){
				alert('请输入有效的房东电话');return;
			}
			if($("#client_name").val()==''){
				alert('请输入房东姓名');return;
			}
		}
		
        if($("#client_telephone").val() !=""){
        	if(!isTel.test($("#client_telephone").val())){
        		alert('房东座机输入不正确');return;
        	}
        }
		sureSubmit();
	}
	function sureSubmit(){
		/*检查*/
		var phoneOld="<?php echo ($resourceModel['client_phone']); ?>";
		var phoneNew=$("#client_phone").val();
		if(phoneOld!=phoneNew){
			var store_id="<?php echo ($resourceModel['store_id']); ?>";
			if(store_id!=''){
				alert('本房源在某店铺下，禁止直接修改手机号，请到店铺详情里操作修改手机号');return;
			}
		}
		$("#submit_a").unbind("click").text("提交中");
		//var typeValue=$('input:radio[name="business_type"]:checked').val();
		$.get("/hizhu/HouseResourcerob/checkAddResourceInfo",{estate_id:$("#estate_id").val(),estate_name:$("#estate_name").val(),type:'',client_phone:phoneNew},function(result){
			if(result.status=="200"){
				if($("#estate_id").val()==""){
					var jsonObj=result.data[0];
					$("#estate_id").val(jsonObj.id);
					$("#estate_name").val(jsonObj.estate_name);
					$("#region").val(jsonObj.region);
					$("#scope").val(jsonObj.scope);
					$("input[name='business_type']").val(jsonObj.business_type);
				}
				if(result.msg=="success"){
					$("#submitForm").submit();/*提交*/
				}else{
					if(confirm('房东电话下已有房源，是否确定提交？')){
						$("#submitForm").submit();/*提交*/
					}else{
						$("#submit_a").bind("click",function(){
							btnSubmit();
						});
						$("#submit_a").text("提交");
					}
				}
			}else{
				alert(result.msg);
				$("#submit_a").bind("click",function(){
					btnSubmit();
				});
				$("#submit_a").text("提交");
			}
		},"json");
	}
</script>
</html>
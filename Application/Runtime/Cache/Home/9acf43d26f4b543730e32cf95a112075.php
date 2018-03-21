<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title style="color:red;">所有预约</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
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
			<a class="blue" href="javascript:;">欢迎您 <?php echo cookie("admin_user_name");?></a>
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
			<div class="common_head">
				<h2>所有预约</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Appointment/alllist" method="get">
						<input type="hidden" name="no" value="87">
						<input type="hidden" name="leftno" value="89">
						<input type="hidden" id="jump" name="p">
					<input type="hidden" name="totalnum" value="<?php echo ($sumcategory["totalnum"]); ?>">
					<input type="hidden" name="fangdong" value="<?php echo ($sumcategory["fangdong"]); ?>">
					<input type="hidden" name="zuke" value="<?php echo ($sumcategory["zuke"]); ?>">
					<input type="hidden" name="roomnum" value="<?php echo ($sumcategory["roomnum"]); ?>">
						<table class="table_one">
							<tr>
								<td class="td_title">预约提交时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo I('get.startTime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo I('get.endTime'); ?>"></td>
								<td class="td_title">房间编号：</td>
								<td class="td_main"><input type="text" name="roomNo" value="<?php echo I('get.roomNo'); ?>"></td>
								<td class="td_title">预约处理人：</td>
								<td class="td_main">
									<input type="text" name="create_man" value="<?php echo I('get.create_man'); ?>">
								</td>
							</tr>
							<tr>
								<td class="td_title">预约看房时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_look" value="<?php echo I('get.startTime_look'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_look" value="<?php echo I('get.endTime_look'); ?>"></td>
								<td class="td_title">房间来源：</td>
								<td class="td_main">
									<select name="info_resource_type" style="width:100px;">
										<?php echo ($infoResourceTypeList); ?>
									</select>
									<select name="info_resource" style="width:100px;">
										<option value=""></option>
										<?php echo ($infoResourceList); ?>
									</select>
								</td>
								<td class="td_title">处理状态：</td>
								<td class="td_main">
									<select id="status" name="status" style="width:80px">
										<option value="">全部</option>
										<option value="0">未处理</option>
										<option value="1">处理中</option>
										<option value="2">成功</option>
										<option value="3">取消</option>
										<!-- <option value="4">暂停</option>  -->
										<option value="5">失败</option>
										<option value="9">已配单</option>
									</select>&nbsp;<select id="handle_reason" name="handle_reason" style="width:120px"></select>
								</td>

							</tr>
							<tr>
								<td class="td_title">预约人手机：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo I('get.mobile'); ?>"></td>
								<td class="td_title">租金范围：</td>
								<td class="td_main">
									<input type="tel" name="moneyMin" maxlength="6" style="width:80px;" value="<?php echo I('get.moneyMin');?>">
									~
									<input type="tel" name="moneyMax" maxlength="6" style="width:80px;" value="<?php echo I('get.moneyMax');?>">
								</td>
								<td class="td_title">处理时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startHandle" value="<?php echo I('get.startHandle'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endHandle" value="<?php echo I('get.endHandle'); ?>"></td>

							</tr>
							<tr>
								<td class="td_title">预约订单来源：</td>
								<td class="td_main">
									<select id="gaodu_platform" name="gaodu_platform">
										<option value="">全部</option>
										<option value="0">wap</option>
										<option value="1">android</option>
										<option value="2">iphone</option>
										<option value="3">pc</option>
										<option value="6">h5</option>
										<option value="8">小程序</option>
										<option value="9">百度推广</option>
										<option value="10">hi租房pro</option>
										<option value="20">后台添加</option>
									</select>
								</td>
								<td class="td_title">品牌公寓：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
										<option value="">全部</option>
										<?php echo ($brandTypeList); ?>
									</select>
								</td>
								<td class="td_title">内/外部人员：</td>
								<td class="td_main">
									<select id="is_my" name="is_my">
										<option value="all">全部</option>
										<option value="1">内部人员</option>
										<option value="0">外部人员</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">是否佣金：</td>
								<td class="td_main">
									<select name="is_commission">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.is_commission')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.is_commission')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">是否包月：</td>
								<td class="td_main">
									<select name="isMonth">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isMonth')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isMonth')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">房东手机号：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo I('get.clientPhone'); ?>"></td>
								
								
							</tr>
							
						</table>
					</form>
					<p class="head_p">点击搜索查看数据&nbsp;<button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>预约列表<a style="margin-left:50px;" class="btn_a" id="download">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>外部链接</th>
								<th>预约人姓名</th>
								<th>预约人手机</th>
								<th>预约房源</th>
								<th>预约房间</th><th>区域板块</th><th>租金</th>
								<th>房东手机</th>
								<th>房间来源</th><th>品牌公寓</th><th>是否佣金</th><th>是否包月</th>
								<th>房东姓名</th>
								<th>提交时间</th>
								<th>处理时间</th><th>处理人</th><th>状态</th><th>看房时间/理由</th><th>来源</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<?php switch($vo["city_code"]): case "001009001": ?><td><a href="http://www.hizhu.com/shanghai/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break; case "001001": ?><td><a href="http://www.hizhu.com/beijing/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break; case "001011001": ?><td><a href="http://www.hizhu.com/hangzhou/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break; case "001010001": ?><td><a href="http://www.hizhu.com/nanjing/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break; case "001019001": ?><td><a href="http://www.hizhu.com/guangzhou/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break; case "001019002": ?><td><a href="http://www.hizhu.com/shenzhen/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank">外部链接</a></td><?php break;?><default><td></td><td></td></default><?php endswitch;?>
								<td><?php echo ($vo["customer_name"]); ?></td>
								<td><?php echo ($vo["customer_mobile"]); ?></td>
								<td><a href="/hizhu/HouseResource/addresource?resource_id=<?php echo ($vo["resource_id"]); ?>" target="_blank"><?php echo ($vo["resource_no"]); ?></a></td>
								<td><a href="/hizhu/HouseRoom/modifyroom?room_id=<?php echo ($vo["room_id"]); ?>&handle=search" target="_blank"><?php echo ($vo["room_no"]); ?></a></td>
								<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td><td><?php echo ($vo["room_money"]); ?></td>
								<td><?php echo ($vo["owner_mobile"]); ?></td>
								<td><?php echo ($vo["info_resource"]); ?></td><td data-brand="<?php echo ($vo["brand_type"]); ?>"></td>
								
								<td><?php if(($vo["is_commission"] == 1)): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php if(($vo["is_monthly"] == 1)): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php echo ($vo["owner_name"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
								<td><?php if(($vo["handle_time"]) > "0"): echo (date("Y-m-d H:i:s",$vo["handle_time"])); endif; ?></td><td><?php echo ($vo["handle_man"]); ?></td><td><?php switch($vo["status"]): case "0": ?>未处理<?php break; case "1": ?>处理中<?php break; case "2": ?>成功<?php break; case "3": ?>取消<?php break; case "4": ?>暂停<?php break;?>
								<?php case "5": ?>失败<?php break; case "9": ?>已配单<?php break; endswitch;?></td>
								<td><?php if(($vo["status"] == 2)): if(($vo["look_time"]) > "0"): echo (date("Y-m-d H:i",$vo["look_time"])); endif; else: echo ($vo["handle_reason"]); endif; ?>
								</td>
								<td><?php switch($vo["gaodu_platform"]): case "0": ?>wap<?php break; case "1": ?>android<?php break;?>
									<?php case "2": ?>iphone<?php break; case "3": ?>pc<?php break; case "6": ?>h5<?php break; case "20": ?>后台添加<?php break;?>
									<?php case "8": ?>小程序<?php break; case "9": ?>百度推广<?php break; case "10": ?>hi租房pro<?php break; endswitch;?></td>
								<!-- <?php if(in_array(($vo["status"]), explode(',',"0,4"))): ?><td><a href="/hizhu/Appointment/handleappoint?no=87&leftno=89&id=<?php echo ($vo["id"]); ?>&type=all">开始处理</a></td>
								<?php else: ?><td></td><?php endif; ?> -->
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($sumcategory["totalnum"]); ?>条记录，每页10条。租客<?php echo ($sumcategory["zuke"]); ?>，房东<?php echo ($sumcategory["fangdong"]); ?>，房间数<?php echo ($sumcategory["roomnum"]); ?></p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
$("select[name='is_commission']").val('<?php echo I("get.is_commission"); ?>');
$("select[name='isMonth']").val('<?php echo I("get.isMonth"); ?>');
$("select[name='brand_type']").val('<?php echo I("get.brand_type"); ?>');

$("#status").val('<?php echo isset($_GET["status"])?$_GET["status"]:"" ?>');
$("#is_my").val('<?php echo isset($_GET["is_my"])?$_GET["is_my"]:"0"; ?>');
$("#gaodu_platform").val('<?php echo isset($_GET["gaodu_platform"])?$_GET["gaodu_platform"]:"" ?>');
$("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');

//下拉联动，来源
$("select[name='info_resource_type']").change(function(){
	if($(this).val()==""){
		$("select[name='info_resource']").html("");
		return;
	}
	$.get("/hizhu/HouseResource/getInforesourceByType",{type:$(this).val()},function(data){
		$("select[name='info_resource']").html('<option value=""></option>'+data);
	},"html");
});

handleReason($("#status").val());
$("#status").change(function(){
	var status=$(this).val();
	handleReason(status);
});
function handleReason(status){
	if(status==3){
		$("#handle_reason").html('<option value="">全部</option><option value="租客联系不上">租客联系不上</option><option value="租客已联系房东">租客已联系房东</option><option value="租客错误操作">租客错误操作</option><option value="租客已租到房">租客已租到房</option><option value="客户主动放弃">客户主动放弃</option><option value="房东取消">房东取消</option><option value="店长取消">店长取消</option><option value="其他">其他</option>');
	}else if(status==4){
		$("#handle_reason").html('<option value=""></option><option value="无法联系到租客">无法联系到租客</option><option value="无法联系到房东">无法联系到房东</option>');
	}else if(status==5){
		$("#handle_reason").html('<option value="">全部</option><option value="房东联系不上">房东联系不上</option><option value="房东不接受预约">房东不接受预约</option><option value="房间已出租">房间已出租</option><option value="时间无法撮合">时间无法撮合</option><option value="房间不合适">房间不合适</option><option value="其他">其他</option>');
	}else{
		$("#handle_reason").html('');
	}
}
$("#handle_reason").val('<?php echo I("get.handle_reason") ?>');

	$("#dataDiv table tbody tr").each(function(){
		/*键值转换 */
		//品牌公寓
		var td_plat=$(this).children("td:eq(9)");
		var td_plat_name=$("#brand_type option[value="+td_plat.attr('data-brand')+"]").text();
		if(td_plat_name!='全部'){
			td_plat.text(td_plat_name);
		}
		
	});

	//下载
	$("#download").click(function(){
		$(this).unbind('click');
		window.location.href="/hizhu/Appointment/downloadExcel?<?php echo $_SERVER['QUERY_STRING'];?>";
	});
	$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2020,format:"Y-m-d"});
	$("#btnSearch").click(function(){
		$(this).unbind('click').text('搜索中');
		$("#searchForm").submit();
	});
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	
</script>

</html>
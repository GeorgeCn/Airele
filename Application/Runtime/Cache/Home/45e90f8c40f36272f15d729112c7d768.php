<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>置顶管理</title>
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
			<div class="common_head">
				<h2>置顶查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseRoom/toproommanage" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="145">
						<input type="hidden" id="jump" name="p">
						<input type="hidden" name="flag" value="query">
						<table class="table_one">
							<tr>
								<td class="td_title">房间编号</td>
								<td class="td_main"><input type="text" name="room_no" value="<?php echo I('get.room_no'); ?>"></td>
								<td class="td_title">置顶类型</td>
								<td class="td_main">
									<select name="rent_type">
										<option value="">全部</option>
										<option value="1">合租</option>
										<option value="2">整租</option>
										<option value="3">公寓</option>
									</select>
								</td>
								<td class="td_title">置顶位</td>
								<td class="td_main">
									<select name="top_type">
										<option value="">全部</option>
										<option value="2">全城</option>
										<option value="3">行政区</option>
										<option value="4">商圈</option>
										<option value="5">地铁线</option>
										<option value="6">地铁站</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">区/商圈</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px;">
										<option value=""></option>
										<?php echo ($regionList); ?>
									</select>
									&nbsp;<select id="ddl_scope" name="scope" style="width:100px;">
										<?php echo ($scopeList); ?>
									</select>
								</td>
								<td class="td_title">地铁</td>
								<td class="td_main">
									<select id="ddl_subwayline" name="subwayline_id" style="width:100px;">
										<option value=""></option>
										<?php echo ($subwaylineList); ?>
									</select>&nbsp;
									<select id="ddl_subway" name="subway_id" style="width:100px;">
										<?php echo ($subwayList); ?>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>置顶列表<a href="/hizhu/HouseRoom/toproomedit?no=3&leftno=145" class="btn_a">新增置顶</a>&nbsp;<a style="margin-left:150px;" href="/hizhu/HouseRoom/downloadToplist?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>房间编号</th><th>小区名称</th><th>租金</th>
								<th>置顶位</th>
								<th>行政区</th>
								<th>商圈</th>
								<th>地铁线</th><th>地铁站</th>
								<th>创建人</th>
								<th>创建时间</th>
								<th>修改置顶</th>
								<th>取消置顶</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo ($vo["room_no"]); ?></td><td><?php echo ($vo["estate_name"]); ?></td><td><?php echo ($vo["room_money"]); ?></td>
								<td><?php switch($vo["top_type"]): case "1": ?>首页<?php break; case "2": ?>全城<?php break;?>
									<?php case "3": ?>行政区<?php break; case "4": ?>商圈<?php break;?>
								<?php case "5": ?>地铁线<?php break; case "6": ?>地铁站<?php break; endswitch;?></td>
								<td><?php if($vo["top_type"] == 3 or $vo["top_type"] == 4): echo ($vo["region_name"]); endif; ?></td>
								<td><?php if($vo["top_type"] == 4): echo ($vo["scope_name"]); endif; ?></td>
								<td><?php if($vo["top_type"] == 5 or $vo["top_type"] == 6): echo ($vo["subwayline_name"]); endif; ?></td>
								<td><?php if($vo["top_type"] == 6): echo ($vo["subway_name"]); endif; ?></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["toproom_createtime"] > 0)): echo (date("Y-m-d H:i",$vo["toproom_createtime"])); endif; ?></td>
								<td><a href="/hizhu/HouseRoom/toproomedit?no=3&leftno=145&topid=<?php echo ($vo["id"]); ?>">修改置顶</a></td>
								<td><a href="javascript:;" onclick="cancelSettopRoom('<?php echo ($vo["id"]); ?>','<?php echo ($vo["room_id"]); ?>',<?php echo ($vo["top_type"]); ?>,this)">取消置顶</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				<div class="skip cf">
					<p class="fl skip_left">共<span id="lblCnt" style="color:red;"><?php echo ($totalcnt); ?></span>条记录，每页15条</p>
					<p class="fr skip_right">
						<?php echo ($pageSHow); ?>
					</p>
				</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
var topType="<?php echo I('get.top_type'); ?>";
$("select[name='rent_type']").val("<?php echo I('get.rent_type'); ?>");
$("select[name='top_type']").val(topType);
$("#ddl_region").val("<?php echo I('get.region'); ?>");
$("#ddl_scope").val("<?php echo I('get.scope'); ?>");
$("#ddl_subwayline").val("<?php echo I('get.subwayline_id'); ?>");
$("#ddl_subway").val("<?php echo I('get.subway_id'); ?>");

if(topType=='5'){
	$("#ddl_region").attr("disabled",true);
	$("#ddl_scope").attr("disabled",true);
	$("#ddl_subwayline").attr("disabled",false);
	$("#ddl_subway").attr("disabled",true);
}else if(topType=='6'){
	$("#ddl_region").attr("disabled",true);
	$("#ddl_scope").attr("disabled",true);
	$("#ddl_subwayline").attr("disabled",false);
	$("#ddl_subway").attr("disabled",false);
}else if(topType=='3'){
	$("#ddl_region").attr("disabled",false);
	$("#ddl_scope").attr("disabled",true);
	$("#ddl_subwayline").attr("disabled",true);
	$("#ddl_subway").attr("disabled",true);
}else if(topType=='4'){
	$("#ddl_region").attr("disabled",false);
	$("#ddl_scope").attr("disabled",false);
	$("#ddl_subwayline").attr("disabled",true);
	$("#ddl_subway").attr("disabled",true);
}else{
	$("#ddl_region").attr("disabled",true);
	$("#ddl_scope").attr("disabled",true);
	$("#ddl_subwayline").attr("disabled",true);
	$("#ddl_subway").attr("disabled",true);
}

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
	function cancelSettopRoom(pid,roomId,topType,obj){
		if(confirm("确认取消置顶吗？")){
			$.get("/hizhu/HouseRoom/unsetToproom",{id:pid,room_id:roomId,top_type:topType},function(data){
				alert(data.msg);
				if(data.status=="200"){
					var cnt =parseInt($("#lblCnt").text());
					$("#lblCnt").text(cnt-1);
					$(obj).parent().parent().remove();
				}
			},"json");
		}
	}
	//商圈下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()=="" || $("select[name='top_type']").val()==3){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseRoom/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
	//下拉联动(地铁线)
	$("#ddl_subwayline").change(function(){
		if($(this).val()=="" || $("select[name='top_type']").val()==5){
			$("#ddl_subway").html("");
			return;
		}
		$.get("/hizhu/Estate/getSubwayByLine",{subwayline_id:$(this).val()},function(data){
			$("#ddl_subway").html(data);
		},"html");
	});
	$("select[name='top_type']").change(function(){
		var topType=$(this).val();
		if(topType=='3'){
			$("#ddl_region").attr("disabled",false);
			$("#ddl_scope").attr("disabled",true);
			$("#ddl_subwayline").attr("disabled",true);
			$("#ddl_subway").attr("disabled",true);
		}else if(topType=='4'){
			$("#ddl_region").attr("disabled",false);
			$("#ddl_scope").attr("disabled",false);
			$("#ddl_subwayline").attr("disabled",true);
			$("#ddl_subway").attr("disabled",true);
		}else if(topType=='5'){
			$("#ddl_region").attr("disabled",true);
			$("#ddl_scope").attr("disabled",true);
			$("#ddl_subwayline").attr("disabled",false);
			$("#ddl_subway").attr("disabled",true);
		}else if(topType=='6'){
			$("#ddl_region").attr("disabled",true);
			$("#ddl_scope").attr("disabled",true);
			$("#ddl_subwayline").attr("disabled",false);
			$("#ddl_subway").attr("disabled",false);
		}else{
			$("#ddl_region").attr("disabled",true);
			$("#ddl_scope").attr("disabled",true);
			$("#ddl_subwayline").attr("disabled",true);
			$("#ddl_subway").attr("disabled",true);
		}
	});
	
	
</script>

</html>
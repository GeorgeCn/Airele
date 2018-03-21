<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>联系房东统计</title>
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
				<h2>查询条件</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Summary/contactsummary" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="122">
						<input type="hidden" id="jump" name="p">
						<input type="hidden" name="totalCount" value="<?php echo ($totalCount); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">联系日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime"  value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'' ?>"></td>
								<td class="td_title">区域&板块：</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option><option value="0">空</option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:100px">
										<?php echo ($scopeList); ?>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
							
						</table>
					</form>
					<p class="head_p"><button class="btn_a" onclick="search()">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>统计列表<a href="/hizhu/Summary/downloadContactSummary?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>区域</th>
								<th>板块</th>
								<th>联系次数</th>
								<th>联系来自BD</th>
								<th>预约次数</th>
								<th>预约来自BD</th>
								<th>浏览次数</th>
								<th>浏览来自BD</th>
							</tr>
						</thead>
						<tbody>
							<?php $ident_num=1; ?>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo $ident_num++; ?></td>
								<td><?php echo ($vo["region_name"]); ?></td>
								<td><?php echo ($vo["scope_name"]); ?></td>
								
								<td><?php echo ($vo["contact_count"]); ?></td>
								<td><?php echo ($vo["contact_bd_count"]); ?></td>
								<td><?php echo ($vo["appoint_count"]); ?></td>
								<td><?php echo ($vo["appoint_bd_count"]); ?></td>
								<td><?php echo ($vo["browse_count"]); ?></td>
								<td><?php echo ($vo["browse_bd_count"]); ?></td>
								
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录，每页25条</p>
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
	
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');

	$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});
	function search(){
		$("#searchForm").submit();
	}
	
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			return $("#ddl_scope").html("");
		}
		$.get("/hizhu/HouseResource/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});

	
</script>
</html>
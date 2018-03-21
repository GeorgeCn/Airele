<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>审核房源列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
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
				<h2>审核查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseResource/examinelist" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="82"> 
						<table class="table_one">
							
							<tr>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input type="text" name="client_phone" value="<?php echo I('get.client_phone'); ?>"></td>
								<td class="td_title">数据来源：</td>
								<td class="td_main">
									<select name="info_resource_type" style="width:110px;">
										<?php echo ($infoResourceTypeList); ?>
									</select>
									<select name="info_resource" style="width:110px;">
										<option value=""></option>
										<?php echo ($infoResourceList); ?>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" onclick="javascript:$('form').submit();">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>审核列表</h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房屋编号</th>
								<th>小区名称</th>
								<th>区域板块</th>
								<th>业务类型</th>
								<th>楼栋/单元号</th>
								<th>室号</th>
								<th>户型</th>
								<th>房间数</th>
								<th>房东姓名</th>
								<th>更新日期</th>
								<th>更新操作人</th>
								<th>房源负责人</th>
								<th>数据来源</th>
								<th>来源URL</th>
								<th>审核</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list["ident_num"]); ?></td>
								<td><?php echo ($list["house_no"]); ?></td>
								<td><?php echo ($list["estate_name"]); ?></td>
								<td><?php echo ($list["region_scope"]); ?></td>
								<td><?php switch($list["business_type"]): case "1501": ?>小区住宅<?php break; case "1502": ?>集中公寓<?php break; case "1503": ?>酒店长租<?php break; endswitch;?></td>
								<td><?php echo ($list["unit_no"]); ?></td>
								<td><?php echo ($list["room_no"]); ?></td>
								<td><?php echo ($list["room_hall_wei"]); ?></td>
								<td><?php echo ($list["room_count"]); ?></td>
								<td><?php echo ($list["client_name"]); ?></td>
								<td><?php echo ($list["update_time"]); ?></td>
								<td><?php echo ($list["update_man"]); ?></td>
								<td><?php echo ($list["create_man"]); ?></td>
								<td><?php echo ($list["info_resource"]); ?></td>
								<td><?php if(($list["info_resource_url"]) != ""): ?><a target="_blank" href="<?php echo ($list["info_resource_url"]); ?>">地址<?php endif; ?></td>
								<td><a target="_blank" href="/hizhu/HouseResource/examhouse?no=3&leftno=82&resource_id=<?php echo ($list["id"]); ?>&handletype=examine&room_id=<?php echo ($list["room_id"]); ?>">审核</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalcnt); ?>条记录，每页15条。</p>
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
</script>
</html>
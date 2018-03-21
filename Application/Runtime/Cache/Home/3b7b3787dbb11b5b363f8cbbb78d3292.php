<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>中介房源报价审核</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css">
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
				<h2>查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseOffer/quotationAuditList.html" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="196">
						<input type="hidden" name="totalCount" value="<?php echo ($totalCount); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">手机号：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo I('get.mobile'); ?>"></td>
								<td class="td_title">状态：</td>
								<td class="td_main">
									<select name="status_code">
										<option value="all"></option>
										<option value="0">待审核</option>
										<option value="1">拒绝</option>
										<option value="3">通过</option>
										<option value="4">下架</option>
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
				<h2>列表</h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房源信息</th>
								<th>房间信息</th>
								<th>小区名称</th>
								<th>区域</th>
								<th>板块</th>
								<th>状态</th>
								<th>租金</th>
								<th>收佣</th>
								<th>提交时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><a target="_blank" href="/hizhu/HouseResource/addresource?resource_id=<?php echo ($vo["house_id"]); ?>">详情</a></td>
								<td><a target="_blank" href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id=<?php echo ($vo["room_id"]); ?>">详情</a></td>
								<td><?php echo ($vo["estate_name"]); ?></td>
								<td><?php echo ($vo["region_name"]); ?></td>
								<td><?php echo ($vo["scope_name"]); ?></td>
								<td><?php switch($vo["status_code"]): case "0": ?>待审核<?php break; case "1": ?>拒绝<?php break; case "3": ?>通过<?php break; case "4": ?>下架<?php break; endswitch;?></td>
								<td><?php echo ($vo["room_price"]); ?></td>
								<td><?php switch($vo["commission_type"]): case "0": echo ($vo['commission_price']/100); ?>%<?php break; case "1": echo ($vo["commission_price"]); break; endswitch;?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo['create_time'])); endif; ?></td>
						
								<td><?php if(($vo["status_code"] == 0)): ?><a target="_blank" href="/hizhu/HouseOffer/quotationAudit?mid=<?php echo ($vo["id"]); ?>">审核</a><?php endif; ?></td>							
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				<div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($totalCount); ?>条记录，每页6条</p>
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
	var status_code='<?php echo isset($_GET["status_code"])?$_GET["status_code"]:"0"; ?>';
	$("select[name='status_code']").val(status_code);
	
	$('#btnSearch').click(function(){
		$(this).unbind('click').text('搜索中');
		$('form').submit();
	});

</script>
</html>
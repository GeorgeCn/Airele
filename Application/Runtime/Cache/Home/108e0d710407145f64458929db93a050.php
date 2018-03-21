<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房东佣金管理</title>
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
				<h2>职业房东&nbsp;>&nbsp;<?php echo I('get.mobile'); ?>&nbsp;>&nbsp;佣金</h2>
			</div>
			<div class="common_main">
				<h2>列表展示<a href="/hizhu/Commission/commissionaddfd?no=6&leftno=111&mobile=<?php echo I('get.mobile'); ?>" class="btn_a">新增</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>合同时长</th>
								<th>状态</th>
								<th>创建人</th>
								<th>创建时间</th>
								<th>修改人</th>
								<th>修改时间</th>
								<th>查看</th>
								<th>停用</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo ($vo["client_phone"]); ?></td>
								<td><?php echo ($vo["client_name"]); ?></td>
								<td><?php if(($vo["contracttime_start"]) > "0"): echo ($vo["contracttime_start"]); endif; ?>~<?php if(($vo["contracttime_end"]) < "99"): echo ($vo["contracttime_end"]); endif; ?></td>
								<td><?php if(($vo["is_open"] == 1)): ?>启用<?php else: ?>停用<?php endif; ?></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["update_time"])); endif; ?></td>
								<td><a href="/hizhu/Commission/commissioneditfd?no=6&leftno=111&pid=<?php echo ($vo["id"]); ?>">查看</a></td>
								<td><?php if(($vo["is_open"]) == "1"): ?><a href="#" onclick="stopdown(<?php echo ($vo["id"]); ?>)">停用</a><?php endif; ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
	function stopdown(pid){
		if(confirm('停用此规则后，此房东名下使用此规则的房源也将停用此规则，确认停用吗？')){
			$.get('/hizhu/Commission/stopCommissionfd?id='+pid,function(data){
				alert(data);document.location.reload();
			});
		}
	}
	
</script>

</html>
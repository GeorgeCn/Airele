<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>端口信息新增页</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
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
				<h2>端口信息</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/HizhuParameter/portConfigureAddInfo.html">	
				<table class="table_one table_two">	
					<tr>
						<td class="td_title"><span>*</span>类型：</td>
						<td class="td_main">
							<select name="is_owner">
								<option value="4">职业房东</option>
								<option value="5">中介</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>时间长度：</td> 
						<td>
							<div style="margin:10px 20px">
								类型：
								<label><input type="radio" name="time_type" value="1" checked>月</label>
							</div>
							<div style="margin:10px 20px">
								数量：<input type="text" name="timelimit">
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>在架房源数量：</td> 
						<td><input type="text" name="house_num" maxlength="4" style="width:120px;" value="70">&nbsp;条</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>价格：</td> 
						<td><input type="text" name="price" maxlength="6" style="width:120px;">&nbsp;元</td>
					</tr>
					<tr>
						<td class="td_title">排序：</td> 
						<td><input type="text" name="sort_index" maxlength="2" style="width:120px;"></td>
					</tr>
					<tr>
						<td class="td_title">优惠：</td>
						<td class="td_main">
							<label><textarea name="coupon_title" maxlength="6"></textarea></label>
						</td>
					</tr>
				</table>
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:;" class="btn_a">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
	$(".btn_a").click(function(){
		submitData();
	});
	function submitData()
	{
	    if($("input[name='timelimit']").val() == "" || $("input[name='timelimit']").val() > 12) {
	    	return alert("请填写正确的端口时长");
	    } else if($("input[name='house_num']").val() == "") {
	    	return alert("请填写在架房源数量");
	    } else if($("input[name='price']").val() == "") {
	    	return alert("请填写价格");
	    } else {
			$(".btn_a").unbind('click').text('提交中');
			$('form').submit();
		}
	}
</script>
</html>
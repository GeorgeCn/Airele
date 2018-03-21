<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房东佣金管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
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
				<h2>职业房东&nbsp;>&nbsp;<?php echo I('get.mobile'); ?>&nbsp;>&nbsp;佣金&nbsp;>&nbsp;新增佣金</h2>
			</div>
			<div class="common_main">
				<form method="post" action="/hizhu/Commission/saveCommissionaddfd">
				<input type="hidden" name="client_phone" value="<?php echo I('get.mobile'); ?>">
				<table class="table_one table_two">
					<tr>
						<td class="td_title">合同时长：</td>
						<td class="td_main"><select id="contracttime_start" name="contracttime_start"><option value="-99">无</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>~
							<select id="contracttime_end" name="contracttime_end"><option value="99">无</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></td>
					</tr>
					<tr>
						<td class="td_title">计算方式：</td>
						<td class="td_main"><label><input type="radio" name="commission_type" value="1" checked="checked">百分比</label>&nbsp;
							<label><input type="radio" name="commission_type" value="2">金额</label>&nbsp;&nbsp;&nbsp;
							<span id="commission_base" style="color:black;">佣金基数&nbsp;<label><input type="radio" name="commission_base" value="1" checked="checked">1个月</label>&nbsp;
							<label><input type="radio" name="commission_base" value="2">合同金额</label>&nbsp;
							<label><input type="radio" name="commission_base" value="3">1年</label></span>
						</td>
					</tr>
					
					<tr>
						<td class="td_title">佣金：</td>
						<td class="td_main"><input type="text" name="commission_money" style="width:100px;"><label id="commission_money">&nbsp;%</label></td>
					</tr>
					<tr>
						<td class="td_title">在线付租是否扣佣：</td>
						<td class="td_main"><label><input type="radio" name="is_online" value="1" checked="checked">是</label>&nbsp;
							<label><input type="radio" name="is_online" value="0">否</label>&nbsp;</td>
					</tr>
					<tr>
						<td class="td_title">结算方式：</td>
						<td class="td_main"><label><input type="radio" name="settlement_method" value="1" checked="checked">次结</label>&nbsp;
							<label><input type="radio" name="settlement_method" value="2">月结</label>&nbsp;</td>
					</tr>
					<tr>
						<td class="td_title">启用时间：</td>
						<td class="td_main"><input class="inpt_a" type="text" name="start_time" value="<?php echo date('Y-m-d'); ?>"></td>
					</tr>
					<tr>
						<td class="td_title"></td>
						<td class="td_main"><label><input type="checkbox" name="check_update" checked="checked">更新此房东名下佣金房源的规则</label></td>
					</tr>
				</table>
				</form>
			</div>
			<div style="text-align:center;"><a href="javascript:;" class="btn_a">提交</a></div>
		</div>
	</div>
</body>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
 <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2016,yearEnd:2018,format:"Y-m-d"});

$("input[name=commission_type]").change(function() {
	if($(this).val()=="2"){
		$("#commission_base").hide();$("#commission_money").text(" 元");
	}else{
		$("#commission_base").show();$("#commission_money").text(" %");
	}
});

/*提交 */
$('.btn_a').bind('click',function(){
	if(parseInt($('#contracttime_start').val())>parseInt($('#contracttime_end').val())){
		alert("合同时长选择有误");return;
	}
	var regNum=/^[0-9.]{1,5}$/;
	var money=$("input[name='commission_money']").val();
	if(!regNum.test(money)){
		alert("请输入有效佣金");return;
	}
	if($("#commission_money").text()=="%" && parseFloat(money)>100){
		alert("请输入有效佣金");return;
	}
	if($("input[name='start_time']").val()==""){
		alert("请输入启用时间");return;
	}
	$(this).unbind('click').text('提交中');
	$("form").submit();
});
</script>
</html>
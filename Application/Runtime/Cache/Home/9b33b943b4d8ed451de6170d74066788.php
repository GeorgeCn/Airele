<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>编辑包月合同</title>
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
				<h2>编辑包月合同</h2>
			</div>
			<div class="common_main">
				<!-- 表单 -->
				<form action="<?php echo U('Commission/contractModifyInfo');?>" name="regForm" method="post" id="regForm">
					<input type="hidden" name="id" value="<?php echo ($list['id']); ?>">
					<input type="hidden" name="customer_id" value="<?php echo ($list['customer_id']); ?>">
				<table class="table_one table_two">
					<tr>
						<td class="td_title"><span>*</span>合同时长：</td> 
						<td><input type="text" name="monthly_days" value="<?php echo ($list['monthly_days']); ?>" style="width:165px" maxlength="3">&nbsp;天<span id="dtab">&nbsp;* 必填项,请输入时长</span></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>合同金额：</td> 
						<td><input type="text" name="monthly_money" value="<?php echo ($list['monthly_money']); ?>" maxlength="6"><span id="ptab">&nbsp;* 必填项,请输入金额</span></td>
					</tr>
					<tr>
						<td class="td_title">&nbsp;合同类型：</td> 
						<td>
							<select name="contract_type">
								<option value="0" >选择</option>
								<option value="1" <?php echo ($list['contract_type'] == 1?'selected':''); ?>>普通发房</option>
								<option value="2" <?php echo ($list['contract_type'] == 2?'selected':''); ?>>置顶</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>启用时间：</td>
						<td class="td_main"><input class="inpt_a" type="text" name="monthly_start" value="<?php echo (date('Y-m-d',$list['monthly_start'])); ?>" style="width:185px">
						<span id="stab">&nbsp;* 必填项</span></td>
					</tr>
					<tr>
						<td class="td_title">&nbsp;备注信息：</td> 
						<td><input type="text" name="monthly_bak" value="<?php echo ($list['monthly_bak']); ?>"></td>
					</tr>
				</table>
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:window.history.back();" class="btn_b">返回</a>
				<a href="javascript:;" class="btn_a" id="btn_submit">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script>
$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2016,yearEnd:2020,format:"Y-m-d"});
	//验证表单函数
    function check () {
        var monthly_days = $("input[name='monthly_days']").val();
        var monthly_money = $("input[name='monthly_money']").val();
        var monthly_type = $("select").val();
        var monthly_start = $("input[name='monthly_start']").val();
        var monthly_bak = $("input[name='monthly_bak']").val();
        var date = new Date();
        var regular = /^[^0][0-9]+/;
        if (monthly_days == "") {
            // 匹配失败
            $("#dtab").html('* 内容不能为空!');
            $("#dtab").css('color','#f00');
            return false;
        } else if(regular.test(monthly_days) === false) {
        	$("#dtab").html('* 参数错误!');
            $("#dtab").css('color','#f00');
            return false;
        } else {
            $("#dtab").html('* √通过验证!');
            $("#dtab").css('color','#f00');
	        if (monthly_money == "") {
	            // 匹配失败
	            $("#ptab").html('* 内容不能为空!');
	            $("#ptab").css('color','#f00');
	            return false;
	        } else if(regular.test(monthly_money) === false) {
        		$("#ptab").html('* 参数错误!');
            	$("#ptab").css('color','#f00');
            	return false;
	        } else {
	        	$("#ptab").html('* √通过验证!');
            	$("#ptab").css('color','#f00');
	        	monthly_start = monthly_start.replace(/-/g,'/');
	        	var time = new Date(monthly_start);
	        	if(time.getTime()+monthly_days*3600*24*1000 < date.getTime()) {
	        		$("#stab").html('* 违法的启用日期!');
            		$("#stab").css('color','#f00');
            		return false;
	        	} else {
		        	$("#stab").html('* √通过验证!');
	            	$("#stab").css('color','#f00');
	            	return true;	
	        	}
	        }    
        }
    }
	$("#btn_submit").click(function(){
		if(check()) {
		$(this).unbind('click').text('提交中..');
		$("#regForm").submit();
		}
	});
</script>
</html>
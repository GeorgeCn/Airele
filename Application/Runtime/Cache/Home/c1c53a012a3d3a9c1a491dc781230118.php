<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>添加黑名单</title>
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
			<div class="common_head">
				<h2>新增黑名单</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form action="/hizhu/BlackList/saveBlackUser" method="post">
				<table class="table_one table_two">
					<tr>
						<td class="td_title"><span>*</span>联系电话：</td> 
						<td><input type="text" name="mobile" maxlength="20"></td>
					</tr>
					<tr>
						<td class="td_title">限制登录：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_login">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">限制回复：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_post_replay">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">限制拨打房东电话：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="no_call">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">操作房源：</td>
						<td class="td_main">
							<label><input type="radio" name="soldouthouse" value="0">无</label>&nbsp;
							<label><input type="radio" name="soldouthouse" value="1">下架</label>&nbsp;
							<label><input type="radio" name="soldouthouse" value="2" checked="checked">删除</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">是否发送短信：</td>
						<td class="td_main">
							<label><input type="checkbox" name="is_sendmessage">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">是否隐藏帖子和回复：</td>
						<td class="td_main">
							<label><input type="checkbox" checked="checked" name="hide_circle">是</label>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>拉黑原因：</td> 
						<td>
							<select name="bak_type">
								<option value="0">请选择</option>
								<option value="1">骗子/钓鱼/微商</option>
								<option value="2">违规操作</option>
								<option value="3">商务需求</option>
								<option value="4">中介/托管</option>
								<option value="6">其他</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span> </span>备注信息：</td>
						<td class="td_main">
							<input type="text" name="bak_info" maxlength="50" style="width:100%">
						</td>
					</tr>
				</table>
				<input type="hidden" name="is_owner">
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:window.history.back();" class="btn_b">返回</a>
					<a href="javascript:;" class="btn_a">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
	function btnSubmit(){
		var mobile=$("input[name='mobile']").val().replace(/\s+/g,'');
		var isTel=/^[023456789]+\,{0,1}\d*$/;
		var isMobile=/^1[34578]\d{9}$/;
		if(!isTel.test(mobile) && !isMobile.test(mobile)){
			alert("无效的联系电话");return;
		}
		if($("select[name='bak_type']").val()=='0'){
			alert("请选择拉黑原因");return;
		}
		$(".btn_a").unbind("click").text('提交中');
		$.get('/hizhu/BlackList/checkOwnerUser?mobile='+mobile,function(result){
			if(result.status=="200"){
				if(confirm('此用户是职业房东，确认拉黑吗？')){
					$("input[name='is_owner']").val('1');
					$("form").submit();
				}else{
					$(".btn_a").bind("click",function(){
						btnSubmit();
					}).text('提交');
				}
			}else if(result.status=="300"){
				alert(result.message);
				$(".btn_a").bind("click",function(){
					btnSubmit();
				}).text('提交');
			}else{
				$("form").submit();
			}
		},'json');
		
	}
	$(".btn_a").bind("click",function(){
		btnSubmit();
	})
</script>
</html>
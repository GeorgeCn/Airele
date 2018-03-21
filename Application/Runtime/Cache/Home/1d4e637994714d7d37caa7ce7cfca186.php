<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>职业房东核心修改</title>
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
				<h2>职业房东信息</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/Jobowner/ownersModifyCoreInfo.html">	
				<input type="hidden" name="customer_id" value="<?php echo ($customerinfo['id']); ?>">
				<table class="table_one table_two">	
					<tr>
						<td class="td_title">用户身份：</td> 
						<td>
							<select name="is_owner">
								<option value="4">职业房东</option>
								<option value="3">个人房东</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">姓名：</td> 
						<td><?php echo ($customerinfo['true_name']); ?></td>
					</tr>
					<tr>
						<td class="td_title">手机号：</td>
						<td class="td_main">
							<label><input type="tel" name="mobile" maxlength="11" value="<?php echo ($customerinfo['mobile']); ?>"  readonly="readonly"></label>
						</td>
					</tr>
					<tr>
						<td class="td_title">房东负责人：</td>
						<td class="td_main">
							<label>
							    <input type="text" name="principal_man" style="width:140px" value="<?php echo ($customerinfo['principal_man']); ?>">
								<div id="div_principal_man" class="plotbox" style="width:150px;">
									<ul>
									</ul>
								</div>
							</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">免审核权益：</td> 
						<td>
							<lable><input type="radio" name="owner_verify" value="2">是</lable>
							<lable><input type="radio" name="owner_verify" value="0">否</lable>
						</td>			
					</tr>
					<tr>
						<td class="td_title">是否开启IM：</td> 
						<td>
							<select name="im_open" value="<?php echo ($customerinfo['im_open']); ?>">
								<option value="1">是</option>
								<option value="0">否</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">在架房源数量：</td>
						<td class="td_main">
							<input type="text" name="house_limit" value="<?php echo ($customerinfo['house_limit']); ?>">
						</td>
					</tr>
					<tr>
						<td class="td_title">备注：</td>
						<td class="td_main">
							<label><textarea name="owner_remark" maxlength="255"><?php echo ($customerinfo['owner_remark']); ?></textarea></label>
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
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
	$("select[name='is_owner']").val("<?php echo ($customerinfo['is_owner']); ?>");
	var owner_verify = "<?php echo ($customerinfo['owner_verify']); ?>";
	$("input[name='owner_verify'][value="+owner_verify+"]").attr("checked","checked");
	$(".btn_a").click(function(){
		submitData();
	});
	function submitData(){
	    var mobile=$("input[name='mobile']").val();
	    if($("input[name='principal_man']").val() == "") {
	    	return alert("请选择房东负责人");
	    } else {
		    $(".btn_a").unbind('click').text('提交中');
		    $('form').submit();    	
	    }  
	}
	/*房东负责人 */
	$("input[name='principal_man']").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#div_principal_man ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectPrincipal('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#div_principal_man").show();
				}else{
					$("#div_principal_man").hide();
				}
			}
		},"json");
	});
	function selectPrincipal(userName,realName){
		$("input[name='principal_man']").val(userName);
		$("#div_principal_man").hide();
	}
</script>
</html>
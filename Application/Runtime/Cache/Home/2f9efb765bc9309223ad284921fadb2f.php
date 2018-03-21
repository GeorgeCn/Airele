<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>中介用户</title>
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
				<h2>中介信息</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/AgentsManage/agentsAddInfo.html">	
				<table class="table_one table_two">	
					<tr>
						<td class="td_title">中介姓名：</td> 
						<td><input type="text" name="true_name" maxlength="18"></td>
					</tr>
					<tr>
						<td class="td_title">中介手机：</td>
						<td class="td_main">
							<label><input type="tel" name="mobile" maxlength="11"></label>
						</td>
					</tr>
					<tr>
						<td class="td_title">发房/报价条数：</td> 
						<td><input type="text" name="house_limit" maxlength="4" value="70"></td>
					</tr>
					<tr>
						<td class="td_title">主营区域：</td>
						<td class="td_main">
							<input type="hidden" name="region_name">
							<select id="ddl_region" name="region_id" style="width:120px">
								<option value="0"></option>
								<?php echo ($regionList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">负责人：</td>
						<td class="td_main">
							<label>
							    <input type="text" name="principal_man" style="width:140px">
								<div id="div_principal_man" class="plotbox" style="width:150px;">
									<ul>
									</ul>
								</div>
							</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">备注：</td>
						<td class="td_main">
							<label><textarea name="owner_remark" maxlength="255"></textarea></label>
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
	$(".btn_a").click(function(){
		submitData();
	});
	function submitData(){
	    var mobile=$("input[name='mobile']").val();
	    if($("input[name='true_name']").val().replace(/\s+/g,'')==""){
		  	return alert("请输入中介姓名");
	    } else if(isNaN(mobile)||mobile.length<8||mobile.length>11||mobile==""){
            return alert("请输入有效号码");
	    } else if($("input[name='principal_man']").val()==""){
		  	return alert("请输入中介负责人");
	    } else {
	    	$.ajax({
					type:"post",
					url:"<?php echo U('AgentsManage/agentsProveInfo');?>",
					data:{"mobile":mobile},
					dataType:"json",
					success:function (data) {	
						if(data.code == 404) {
			       			alert(data.message);
			       			location.reload(true);
			    		} else if(data.code == 400) {
			        		alert(data.message);
			        		// location.reload(true);
			    		} else if(data.code == 202) {
			    			$(".btn_a").unbind('click').text('提交中');
			    			if(confirm(data.message)) {
			    				$('form').submit();
			    			}
			    		} else if(data.code == 200)	{
			    			$(".btn_a").unbind('click').text('提交中');
			    			$('form').submit();
			    		}
					}
				})
	    }

	   
	}
	//区域
	$("#ddl_region").change(function(){
		var region_id=$(this).val();
		var region_name=$("#ddl_region option[value="+region_id+"]").text();
		$("input[name='region_name']").val(region_name);
	});
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
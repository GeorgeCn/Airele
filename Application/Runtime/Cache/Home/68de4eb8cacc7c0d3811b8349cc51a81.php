<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改楼盘</title>
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
			<div class="common_main">
				<form id="submitForm" action="/hizhu/Estate/submitEditEstate" method="post">
				<input type="hidden" id="estate_id" name="estate_id" value="<?php echo ($estateModel['id']); ?>">
				<table class="table_one table_two">
					<tr>
						<td class="td_title"><span>*</span>楼盘名称：</td>
						<td class="td_main">
							<input type="text" id="estate_name" name="estate_name" value="<?php echo ($estateModel['estate_name']); ?>" class="plotIpt" style="width:50%;">
							
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘地址：</td>
						<td class="td_main"><input type="text" name="estate_address" value="<?php echo ($estateModel['estate_address']); ?>" class="smallwidth" style="width:50%;"></td>
					</tr>
					<tr>
						<td class="td_title">&nbsp;品牌公寓：</td>
						<td class="td_main">
							<select  name="brand_type" id="js_brand_type">
								<option value="">请选择</option>
								<?php echo ($brandtype); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>区域：</td>
						<td>
							<input type="hidden" name="region_name">
							<select name="region" id="js_region"><?php echo ($regionList); ?></select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>板块：</td>
						<td class="td_main">
							<input type="hidden" name="scope_name">
							<select name="scope" id="js_scope"><?php echo ($scopeList); ?></select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘名称全拼：</td>
						<td class="td_main"><input type="text" name="full_py" value="<?php echo ($estateModel['full_py']); ?>" class="smallwidth" style="width:25%;"><span>*  填写小写字母</span></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘首字母：</td>
						<td class="td_main"><input type="text" name="first_py" value="<?php echo ($estateModel['first_py']); ?>" class="smallwidth" style="width:25%;"><span>*  填写大写字母</span></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>坐标（经度）：</td>
						<td class="td_main"><input type="text" name="lpt_x" value="<?php echo ($estateModel['lpt_x']); ?>" class="smallwidth" style="width:25%;"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>坐标（纬度）：</td>
						<td class="td_main"><input type="text" name="lpt_y" value="<?php echo ($estateModel['lpt_y']); ?>" class="smallwidth" style="width:25%;"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>业务类型：</td>
						<td class="td_main">
							<select  name="business_type" id="js_business_type">
								<option value="">请选择</option>
								<?php echo ($businessTypeList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房屋类型：</td>
						<td class="td_main">
							<select  name="house_type" id="js_house_type">
								<option value="">请选择</option>
								<?php echo ($housetype); ?>
							</select>
						</td>
					</tr>
					
				</table>
				</form>
				<div class="addhouse_next"><button class="btn_a">提交</button></div>
				
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">

	$("#js_region").val("<?php echo ($estateModel['region']); ?>");	
	$("#js_scope").val("<?php echo ($estateModel['scope']); ?>");	
	$("#js_business_type").val("<?php echo ($estateModel['business_type']); ?>");
	$("#js_house_type").val("<?php echo ($estateModel['house_type']); ?>");	
	$("#js_brand_type").val("<?php echo ($estateModel['brand_type']); ?>");	


	$("#js_region").change(function(){
		if($(this).val()==""){
			$("#js_scope").html("");
			return;
		}
		$.get("/hizhu/Estate/searcheregion",{region:$("#js_region").val()},function(result){
			if(result.status=="200"){
			var attr=result.data;
			var len=attr.length;
			var obj=$("#js_scope");
			obj.html("");
			for (var i = len-1; i >= 0; i--){
				obj.append("<option value="+attr[i].id+">"+attr[i].cname+"</option>");
			};
			if(len>0){
				$("#js_scope").show();
			}else{
				$("#js_scope").hide();
			}
		}
	    },"json");

	});
	
	$(".btn_a").bind("click",function(){
		check();
	})
 	function check(){
	   var estate_name=$("input[name='estate_name']").val();
	   var estate_address=$("input[name='estate_address']").val();
	   var js_region=$("#js_region").val();
	   var js_scope=$("#js_scope").val();
	   var full_py=$("input[name='full_py']").val();
	   var first_py=$("input[name='first_py']").val();
	   var lpt_x=$("input[name='lpt_x']").val();
	   var lpt_y=$("input[name='lpt_y']").val();
	   var js_business_type=$("#js_business_type").val();
	     var regExp = /[a-z]$/;
	     var regOr = /[A-Z]$/;
	   if(estate_name==""){
		    alert("楼盘名称不能为空");
		    return false;
	   }else if(estate_address==""){
		   alert("楼盘地址不能为空");
		   return false;
	   }else if(js_region==""){
		   alert("区域不能为空");
		   return false;
	   }else if(js_scope==""){
		   alert("板块不能为空");
		   return false;
	   }else if(full_py==""){
		   alert("楼盘名称全拼不能为空");
		   return false;
	   }else if(!regExp.test(full_py)){
		   alert("楼盘名称全拼必须是字母且小写");
		   return false;
	   }else if(first_py==""){
		   alert("楼盘首字母不能为空");
		   return false;
	   }else if(!regOr.test(first_py)){
		   alert("楼盘首字母必须是字母且大写");
		   return false;
	   }else if(lpt_x==""){
		   alert("坐标(经度)不能为空");
		   return false;
	   }else if(lpt_y==""){
		   alert("坐标(纬度)不能为空");
		   return false;
	   }else if(js_business_type==""){
		   alert("业务类型不能为空");
		   return false;
	   }else{
	   	   $(".btn_a").unbind("click").text("提交中");
	   	   var region_name=$("#js_region option[value='"+js_region+"']").text();
	   	   var scope_name=$("#js_scope option[value='"+js_scope+"']").text();
	   	   $("input[name='region_name']").val(region_name);
	   	   $("input[name='scope_name']").val(scope_name);
		   $("#submitForm").submit();
	   } 
   }

</script>
</html>
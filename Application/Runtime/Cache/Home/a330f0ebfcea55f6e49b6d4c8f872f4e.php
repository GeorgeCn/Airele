<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房源负责人修改</title>
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
				<h2>房源负责人修改</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseResource/resourceperson" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="65">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
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
								<td class="td_title">房源负责人：</td>
								<td class="td_main">
									<!--可输入的下拉列表-->
									<input type="text" id="create_man" name="create_man" style="width:120px" value="<?php echo I('get.create_man'); ?>">
									<div id="div_update_man" class="plotbox" style="width:118px;">
										<ul>
										</ul>
									</div>
									<!-- <select id="create_man" name="create_man">
										<option value=""></option>
										<?php echo ($createManList); ?>
									</select> -->
								</td>
								<td class="td_title">区域&板块：</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:100px">
										<?php echo ($scopeList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">业务类型：</td>
								<td class="td_main">
									<select id="business_type" name="business_type">
										<option value=""></option>
										<?php echo ($businessTypeList); ?>
									</select>
								</td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estateName" value="<?php echo isset($_GET['estateName'])?$_GET['estateName']:'' ?>"></td>
								<td class="td_title">房源编号：</td>
								<td class="td_main"><input type="text" name="houseNo" value="<?php echo isset($_GET['houseNo'])?$_GET['houseNo']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo isset($_GET['clientPhone'])?$_GET['clientPhone']:'' ?>"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" onclick="search()">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2><m style="font-weight:normal;">共选中&nbsp;<span id="selectNum">0</span>&nbsp;条，修改负责人为</m>&nbsp;
					<!--可输入的下拉列表-->
					<input style="width:140px;height:28px;" id="handleMan">
					<div id="estate_div" class="plotbox" style="width:130px;margin-left:215px;">
						<ul>
						</ul>
					</div>
					<!-- <select id="person_man" name="person_man" style="width:120px;height:28px;"><option value=""></option><?php echo ($createManList); ?></select>  -->
					<a style="margin-left:300px;" href="#" class="btn_a" id="editman">修改</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th><input type="checkbox" id="checkall"></th>
								<th>房源编号</th>
								<th>数据来源</th>
								<th>业务类型</th>
								<th>区域板块</th>
								<th>小区名称</th>
								<th>房东电话</th>
								<th>房源负责人</th>
								<th>修改历史</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><input type="checkbox" value="<?php echo ($list["id"]); ?>"></td>
								<td><?php echo ($list["house_no"]); ?></td>
								<td><?php echo ($list["info_resource"]); ?></td>
								<td><?php echo ($list["business_type"]); ?></td>
								<td><?php echo ($list["region_scope"]); ?></td>
								<td><?php echo ($list["estate_name"]); ?></td>
								<td><?php echo ($list["client_phone"]); ?></td>
								<td><?php echo ($list["create_man"]); ?></td>
								<td><a target="_blank" href="/hizhu/HouseResource/resourcepersonrecord?resource_id=<?php echo ($list["id"]); ?>">查看</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录，每页20条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	$("#dataDiv table tr").each(function(){
		var td_object=$(this).children("td:eq(3)");
		var b_type_name=$("#business_type option[value="+td_object.text()+"]").text();
		td_object.text(b_type_name);
	});
	$("#business_type").val('<?php echo isset($_GET["business_type"])?$_GET["business_type"]:"" ?>');
	/*$("#create_man").val('<?php echo isset($_GET["create_man"])?$_GET["create_man"]:"" ?>');*/
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
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
	function search(){
		$("#searchForm").submit();
	}
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	$("#dataDiv table tr").each(function(){
		var select_object=$(this).children("td:eq(0)").find("input");
		select_object.bind("click",function(){
			getSelectNum();
		})
	});
	function getSelectNum(){
		var selectNum=0;
		$("#dataDiv table tr").each(function(){
			var select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				selectNum+=1;
			}
		});
		$("#selectNum").text(selectNum);
	}
	$("#checkall").click(function(){
		//console.log(checkall);
		if($(this).attr("checked")=="checked"){
			$("input[type='checkbox']").attr("checked","checked");
		}else{
			$("input[type='checkbox']").removeAttr("checked");
		}
		getSelectNum();
	})
	$("#editman").bind("click",function(){
		submitEdit();
	})
	/*$("#person_man").change(function(){
		$("#handleMan").val($(this).val());
	});*/
/*房间负责人--筛选 */
	$("#create_man").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#div_update_man ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectUpdateman('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#div_update_man").show();
				}else{
					$("#div_update_man").hide();
				}
			}
		},"json");
	});
	function selectUpdateman(userName,realName){
		$("#create_man").val(userName);
		$("#div_update_man").hide();
	}
/*房间负责人 */
$("#handleMan").keyup(function(){
	var key_word=$(this).val();
	if(key_word.length<1){
		return;
	}
	$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
		if(result.status=="200"){
			var attr=result.data;
			var len=attr.length;
			var obj=$("#estate_div ul");
			obj.html("");
			for (var i = len-1; i >= 0; i--) {
				obj.append("<li onclick=\"selectMen('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
			};
			if(len>0){
				$("#estate_div").show();
			}else{
				$("#estate_div").hide();
			}
		}
	},"json");
});
function selectMen(userName,realName){
	$("#handleMan").val(userName);
	$("#estate_div").hide();
}
	function submitEdit(){
		var handleMan=$("#handleMan").val();
		if(handleMan==""){
			alert("先填写修改负责人");return;
		}
		var regName=/^[a-zA-Z0-9]{2,30}$/;
		if(!regName.test(handleMan)){
			alert("修改负责人填写有误");return;
		}
		var resourceIds="";
		$("#dataDiv table tr").each(function(){
			var select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				resourceIds+=select_object.val()+",";
			}
		});
		if(resourceIds==""){
			alert("需勾选修改的项");return;
		}
		$("#editman").unbind("click").text("修改中");
		$.get("/hizhu/HouseResource/editHouseCreateman",{resource_ids:resourceIds,create_man:handleMan},function(data){
			alert(data.message);
			if(data.status=="200"){
				document.location.reload();
			}else{
				$("#editman").bind("click",function(){
					submitEdit();
				}).text("修改");
			}
		},"json");
	}
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
		
	});
</script>
</html>
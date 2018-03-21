<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>联系房东和帮我预约设置</title>
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
				<h2>条件</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Appointment/setappointmentshowlist" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="85">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
								<td class="td_title">更新日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'' ?>"></td>
								<td class="td_title">出租状态</td>
								<td class="td_main">
									<select id="roomStatus" name="roomStatus">
										<option value="">全部</option>
										<option value="2">未入住</option>
										<option value="3">已出租</option>
										<option value="4">待维护</option>
										<option value="0">待审核</option>
										<option value="1">审核未通过</option>
										<!-- <option value="del">已删除</option> -->
									</select>
								</td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estateName" value="<?php echo isset($_GET['estateName'])?$_GET['estateName']:'' ?>"></td>
								
							</tr>
							<tr>
								<td class="td_title">房间编号：</td>
								<td class="td_main"><input type="text" name="roomNo" value="<?php echo isset($_GET['roomNo'])?$_GET['roomNo']:'' ?>"></td>
								<td class="td_title">业务类型：</td>
								<td class="td_main">
									<select id="business_type" name="business_type">
										<option value="">全部</option>
										<?php echo ($businessTypeList); ?>
									</select>
								</td>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo isset($_GET['clientPhone'])?$_GET['clientPhone']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房间负责人：</td>
								<td class="td_main">
									<!--可输入的下拉列表-->
									<input type="text" id="createman_input" style="width:100px">
									<div id="estate_div" class="plotbox" style="width:98px;">
										<ul>
										</ul>
									</div>
									<select id="create_man" name="create_man" style="width:80px">
										<option value=""></option>
										<?php echo ($createManList); ?>
									</select> 
								</td>
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
								<td class="td_title">品牌：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
										<option value="">全部</option>
										<?php echo ($brandTypeList); ?>
									</select>
								</td>
							</tr>
							<tr>
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
								<td class="td_title">联系房东：</td>
								<td class="td_main">
									<select id="callclient" name="callclient">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
								<td class="td_title">帮我预约：</td>
								<td class="td_main">
									<select id="appoint" name="appoint">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">在线客服：</td>
								<td class="td_main">
									<select id="kefu" name="kefu">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
								<td class="td_title">租金：</td>
								<td class="td_main">
									<input type="tel" name="moneyMin" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMin');?>">~
									<input type="tel" name="moneyMax" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMax');?>">
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" onclick="search()">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>共选中 <span id="selectNum">0</span> &nbsp;<button id="show_callclient" class="btn_a">显示联系房东</button>&nbsp;<button id="hide_callclient" class="btn_b">隐藏联系房东</button>&nbsp;<button id="show_appoint" class="btn_a">显示帮我预约</button>&nbsp;<button id="hide_appoint" class="btn_b">隐藏帮我预约</button>&nbsp;<button id="show_kefu" class="btn_a">显示在线客服</button>&nbsp;<button id="hide_kefu" class="btn_b">隐藏在线客服</button></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th><input type="checkbox" id="checkall"></th>
								<th>房源编号</th>
								<th>房间编号</th>
								<th>数据来源</th>
								<th>小区名称</th>
								<th>区域板块</th>
								<th>业务类型</th>
								<th>房东电话</th>
								<th>出租状态</th><th>联系房东</th><th>帮我预约</th><th>在线客服</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><input type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
								<td><?php echo ($vo["house_no"]); ?></td>
								<td><?php echo ($vo["room_no"]); ?></td>
								<td><?php echo ($vo["info_resource"]); ?></td>
								<td><?php echo ($vo["estate_name"]); ?></td>
								<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
								<?php if($vo["business_type"] == '1501'): ?><td>小区住宅</td>
								<?php elseif($vo["business_type"] == '1502'): ?>
									<td>集中公寓</td>
								<?php elseif($vo["business_type"] == '1503'): ?>
									<td>酒店长租</td><?php endif; ?>
								<td><?php echo ($vo["client_phone"]); ?></td>
								<?php if($vo["status"] == '3'): ?><td style="color:green;">已出租</td>
								<?php elseif($vo["status"] == '2'): ?>
									<td style="color:red;">未入住</td>
								<?php elseif($vo["status"] == '0'): ?>
									<td>待审核</td>
								<?php elseif($vo["status"] == '1'): ?>
									<td>审核未通过</td>
								<?php elseif($vo["status"] == '4'): ?>
									<td>待维护</td><?php endif; ?>
								<?php if($vo["show_call_bar"] == '1'): ?><td style="color:red;">已显示</td><?php else: ?><td>已隐藏</td><?php endif; ?>
								<?php if($vo["show_reserve_bar"] == '1'): ?><td style="color:red;">已显示</td><?php else: ?><td>已隐藏</td><?php endif; ?>
								<?php if($vo["show_kefu_bar"] == '1'): ?><td style="color:red;">已显示</td><?php else: ?><td>已隐藏</td><?php endif; ?>
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
	$("#create_man").val('<?php echo isset($_GET["create_man"])?$_GET["create_man"]:"" ?>');
	/*$("#update_man").val('<?php echo isset($_GET["update_man"])?$_GET["update_man"]:"" ?>');*/
	$("#business_type").val('<?php echo isset($_GET["business_type"])?$_GET["business_type"]:"" ?>');
	$("#roomStatus").val('<?php echo isset($_GET["roomStatus"])?$_GET["roomStatus"]:"" ?>');
	$("#brand_type").val('<?php echo isset($_GET["brand_type"])?$_GET["brand_type"]:"" ?>');
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
	$("#callclient").val('<?php echo isset($_GET["callclient"])?$_GET["callclient"]:"" ?>');
	$("#appoint").val('<?php echo isset($_GET["appoint"])?$_GET["appoint"]:"" ?>');
	$("#kefu").val('<?php echo isset($_GET["kefu"])?$_GET["kefu"]:"" ?>');
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

	$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,format:"Y-m-d"});

	function search(){
		$("#searchForm").submit();
	}
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	$("#dataDiv table tbody tr").each(function(){
		var select_object=$(this).children("td:eq(0)").find("input");
		select_object.bind("click",function(){
			getSelectNum();
		})
	});
	function getSelectNum(){
		var selectNum=0;
		$("#dataDiv table tbody tr").each(function(){
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
	});
	$("#show_callclient").bind("click",function(){
		submitEdit(this,'call','1');
	});
	$("#hide_callclient").bind("click",function(){
		submitEdit(this,'call','2');
	});
	$("#show_appoint").bind("click",function(){
		submitEdit(this,'appoint','1');
	});
	$("#hide_appoint").bind("click",function(){
		submitEdit(this,'appoint','2');
	});
	$("#show_kefu").bind("click",function(){
		submitEdit(this,'kefu','1');
	});
	$("#hide_kefu").bind("click",function(){
		submitEdit(this,'kefu','2');
	});
	function submitEdit(obj,type,is_show){
		var ids="";
		$("#dataDiv table tbody tr").each(function(){
			var select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				ids+=select_object.val()+",";
			}
		});
		if(ids==""){
			alert("需勾选修改的项");return;
		}
		$(obj).unbind("click").text("修改中");
		$.post("/hizhu/Appointment/setAppointShow",{room_ids:ids,type:type,is_show:is_show},function(data){
			alert(data.msg);
			document.location.reload();
		},"json");
	}
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseRoom/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
		
	});
	/*检索负责人*/
	$("#createman_input").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word,},function(result){
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
		$("#createman_input").val(realName);
		$("#create_man").val(userName);
		$("#estate_div").hide();
	}
</script>
</html>
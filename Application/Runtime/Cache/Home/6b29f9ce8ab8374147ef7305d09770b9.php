<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房源管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
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
				<h2>发房查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseResource/resourcelist" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="27">
						<input type="hidden" id="jump" name="p">
						<input type="hidden" name="handle"> 
						<input type="hidden" name="totalCount" value="<?php echo I('get.totalCount'); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">更新日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime"  value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'' ?>"></td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estateName" value="<?php echo isset($_GET['estateName'])?$_GET['estateName']:'' ?>"></td>
								<td class="td_title">房东姓名：</td>
								<td class="td_main"><input type="text" name="clientName" value="<?php echo isset($_GET['clientName'])?$_GET['clientName']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo isset($_GET['clientPhone'])?$_GET['clientPhone']:'' ?>"></td>
								<td class="td_title">房源编号：</td>
								<td class="td_main"><input type="text" name="houseNo" value="<?php echo isset($_GET['houseNo'])?$_GET['houseNo']:'' ?>"></td>
								<td class="td_title">业务类型：</td>
								<td class="td_main">
									<select id="business_type" name="business_type">
										<option value=""></option>
										<?php echo ($businessTypeList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">创建人：</td>
								<td class="td_main">
									<input type="text" name="create_man"  value="<?php echo I('get.create_man'); ?>">
								</td>
								<td class="td_title">区域&板块：</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option><option value="0">空</option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:100px">
										<?php echo ($scopeList); ?>
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
							</tr>
							<tr>
								<td class="td_title">创建日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_create" value="<?php echo isset($_GET['startTime_create'])?$_GET['startTime_create']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_create" value="<?php echo isset($_GET['endTime_create'])?$_GET['endTime_create']:'' ?>"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p">点击搜索查看数据&nbsp;<button class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>发房列表<a href="/hizhu/HouseResource/addresource" class="btn_a">新增房源</a>&nbsp;&nbsp;<a style="margin-left:150px;" href="/hizhu/HouseResource/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房源编号</th>
								<th>小区名称</th>
								<th>区域板块</th>
								<th>业务类型</th>
								<th>楼栋/单元号</th>
								<th>室号</th>
								<th>户型</th>
								<th>房间数</th>
								<th>房东姓名</th>
								<th>更新日期</th>
								<th>更新操作人</th>
								<th>创建人</th>
								<th>数据来源</th>
								<th>来源URL</th>
								<th>修改房源</th>
								<th>删除房源</th>
								<th>管理房间</th>
								<th>历史信息</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list["ident_num"]); ?></td>
								<td><?php echo ($list["house_no"]); ?></td>
								<td><?php echo ($list["estate_name"]); ?></td>
								<td><?php echo ($list["region_scope"]); ?></td>
								<td><?php echo ($list["business_type"]); ?></td>
								<td><?php echo ($list["unit_no"]); ?></td>
								<td><?php echo ($list["room_no"]); ?></td>
								<td><?php echo ($list["room_hall_wei"]); ?></td>
								<td><?php echo ($list["room_count"]); ?></td>
								<td><?php echo ($list["client_name"]); ?></td>
								<td><?php echo ($list["update_time"]); ?></td>
								<td><?php echo ($list["update_man"]); ?></td>
								<td><?php echo ($list["create_man"]); ?></td>
								<td><?php echo ($list["info_resource"]); ?></td>
								<?php if($list["info_resource_url"] == ''): ?><td></td>
								<?php else: ?>
									<td><a target="_blank" href="<?php echo ($list["info_resource_url"]); ?>">来源URL</a></td><?php endif; ?>
								<td><a target="_blank" href="/hizhu/HouseResource/addresource?resource_id=<?php echo ($list["id"]); ?>">修改</a></td>
								<td><a href="#" onclick="showDialog('<?php echo ($list["id"]); ?>',this)">删除</a></td>
								<td><a href="/hizhu/HouseRoom/roommanage?resource_id=<?php echo ($list["id"]); ?>">管理房间</a></td>
								<td><a target="_blank" href="/hizhu/HouseResource/houseupdatelog?house_id=<?php echo ($list["id"]); ?>&house_type=1">历史记录</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--遮罩层 -->
	<div id="dialogDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:200px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">删除理由：</label>
				<select id="delete_type" style="width:250px;height:36px;">
					<option value="0"></option>
					<option value="1">骗子/钓鱼/微商</option>
					<option value="2">房源重复</option>
					<option value="3">商务需求</option>
					<option value="4">中介</option>
					<option value="5">图片/地址/电话问题</option>
					<option value="6">其他</option>
				</select>
			</div>
			<div style="margin:20px;height:36px;" class="cf">
				<input type="text" class="fl" id="delete_text" style="width:250px;height:36px;margin-left:100px;display:none;"> 
			</div> 
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
				<input type="hidden" id="remove_id">
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	$("#dataDiv table tr").each(function(){
		var td_object=$(this).children("td:eq(4)");
		var b_type_name=$("#business_type option[value="+td_object.text()+"]").text();
		td_object.text(b_type_name);
	});
	$("#business_type").val('<?php echo I("get.business_type"); ?>');
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
	$("#house_state").val('<?php echo isset($_GET["house_state"])?$_GET["house_state"]:"" ?>');
	$("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
	$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');

	$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});
	
	$("#btn_search").click(function(){
		$("input[name='handle']").val('query');
		$(this).unbind('click').text('正在查询');
		$("#searchForm").submit();
	});
	/*删除操作 */
	$("#btn_cancel").click(function(){
		$("#dialogDiv").hide();
	});
	var delete_obj;
	function showDialog(resource_id,obj){
		delete_obj=obj;
		$("#remove_id").val(resource_id);
		$("#dialogDiv").show();
	}
	$("#delete_type").change(function(){
		if($(this).val()==6){
			$("#delete_text").show();
		}else{
			$("#delete_text").val('').hide();
		}
	});
	$("#btn_submit").click(function(){
		submitDelete();
	});
	function submitDelete(){
		var delete_type=$("#delete_type").val();
		var delete_text=$("#delete_text").val().replace(/\s+/g,'');
		if(delete_type=='0'){
			alert("请选择删除理由");return;
		}
		$("#btn_submit").unbind('click').text('提交中');
		$.post('/hizhu/HouseResource/removeResource',{delete_type:delete_type,delete_text:delete_text,resource_id:$("#remove_id").val()},function(data){
			if(data.status=="200"){
				$(delete_obj).parent().parent().remove();
				$("#dialogDiv").hide();
			}else{
				alert(data.message);
			}
			$("#btn_submit").bind('click',function(){
				submitDelete();
			}).text('提交');
		},'json');
	}
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	//下拉联动，板块
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
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

</script>
</html>
<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>租客追踪修改</title>
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
			
			<div class="common_main">
				<div  style="font-size:16px;margin:20px 0 10px 50px;">租客信息</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>手机号</th>
							<th>用户姓名</th>
							<th>性别</th>
							<th>年龄段</th>
							<th>注册时间</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo ($trackModel['mobile']); ?></td>
							<td><?php echo ($trackModel['true_name']); ?></td>
							<td><?php echo ($trackModel['sex']); ?></td>
							<td><?php echo ($trackModel['age']); ?></td>
							<td><?php if(($trackModel["register_time"] > 0)): echo (date("Y-m-d H:i:s",$trackModel["register_time"])); endif; ?></td>
						</tr>
					</tbody>
				</table>
				<!-- 联系记录 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">联系记录(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>房间编号</th>
							<th>区域板块</th>
							<th>小区</th>
							<th>价格</th>
							<th>拨打时间</th>
							<th>房间来源</th>
							<th>是否有佣金</th>
							<th>是否有包月</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($contactlist)): foreach($contactlist as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
							<td><?php echo ($vo["estate_name"]); ?></td>
							<td><?php echo ($vo["room_money"]); ?></td>
							<td><?php if(($vo["call_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["call_time"])); endif; ?></td>
							<td><?php echo ($vo["info_resource"]); ?></td>
							<td><?php echo ($vo["is_commission"]); ?></td>
							<td><?php echo ($vo["is_monthly"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<!-- 预约记录 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">预约记录(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>房间编号</th>
							<th>区域板块</th>
							<th>小区</th>
							<th>价格</th>
							<th>预约时间</th>
							<th>预约状态</th><th>看房时间</th>
							<th>房间来源</th>
							<th>是否有佣金</th>
							<th>是否有包月</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($appointlist)): foreach($appointlist as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
							<td><?php echo ($vo["estate_name"]); ?></td>
							<td><?php echo ($vo["room_money"]); ?></td>
							<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i",$vo["create_time"])); endif; ?></td>
							<td><?php switch($vo["status"]): case "0": ?>未处理<?php break; case "1": ?>处理中<?php break; case "2": ?>成功<?php break; case "3": ?>取消<?php break; case "4": ?>暂停<?php break; case "5": ?>失败<?php break; endswitch;?></td><td><?php if(($vo["look_time"] > 0)): echo (date("Y-m-d H:i",$vo["look_time"])); endif; ?></td>
							<td><?php echo ($vo["info_resource"]); ?></td>
							<td><?php echo ($vo["is_commission"]); ?></td>
							<td><?php echo ($vo["is_monthly"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<!-- 看房日程 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">看房日程(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>房间编号</th>
							<th>区域板块</th>
							<th>小区</th>
							<th>价格</th>
							<th>看房状态</th>
							<th>看房时间</th>
							<th>是否有佣金</th>
							<th>是否有包月</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($looklist)): foreach($looklist as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
							<td><?php echo ($vo["estate_name"]); ?></td>
							<td><?php echo ($vo["room_money"]); ?></td>
							<td><?php switch($vo["is_view"]): case "0": ?>未看<?php break; case "1": ?>已看<?php break; case "2": ?>取消<?php break; endswitch;?></td><td><?php if(($vo["view_time"] > 0)): echo (date("Y-m-d H:i",$vo["view_time"])); endif; ?></td>
							<td><?php echo ($vo["is_commission"]); ?></td>
							<td><?php echo ($vo["is_monthly"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<!-- 回访记录 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">回访记录(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>回访来源</th>
							<th>租住状态</th>
							<th>租到渠道</th>
							<th>是否看房</th>
							<th>租住房间</th>
							<th>入住时间</th>
							<th>是否继续服务</th>
							<th>二次回访</th>
							<th>是否符合返现条件</th>
							<th>回访时间</th>
							<th>回访人</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($trackinglist)): foreach($trackinglist as $key=>$vo): ?><tr>
							<td><?php switch($vo["visit_source"]): case "1": ?>电话回访<?php break; case "2": ?>房东反馈<?php break; case "3": ?>保障房源<?php break; case "4": ?>短信回访<?php break; case "5": ?>返现申请<?php break; default: endswitch;?></td>
							<td><?php switch($vo["renter_status"]): case "1": ?>未租到<?php break; case "2": ?>已租到<?php break; case "3": ?>拒绝回访<?php break; default: endswitch;?></td>
							<td><?php switch($vo["renter_sourcetype"]): case "1": ?>嗨住<?php break; case "2": ?>其他<?php break; endswitch;?>-<?php echo ($vo["renter_source"]); ?></td>
							<td><?php switch($vo["is_look"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
							<td><?php echo ($vo["renter_room"]); ?></td>
							<td><?php if(($vo["renter_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["renter_time"])); endif; ?></td>
							<td><?php switch($vo["is_service"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
							<td><?php switch($vo["second_visit"]): case "1": ?>需要<?php break; case "2": ?>不需要<?php break; default: endswitch;?></td>
							<td><?php switch($vo["is_cashback"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
							<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
							<td><?php echo ($vo["create_man"]); ?></td>
							<td><?php echo ($vo["bakinfo"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<!-- 申请返现记录 -->
				<?php if(($applybacklist != null)): ?><div  style="font-size:16px;margin:20px 0 10px 50px;">申请返现记录(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>房间编号</th>
							<th>区域板块</th>
							<th>小区</th>
							<th>价格</th>
							<th>申请时间</th>
							<th>房间来源</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($applybacklist)): foreach($applybacklist as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td><?php echo ($vo["region_name"]); ?></td>
							<td><?php echo ($vo["scope_name"]); ?></td>
							<td><?php echo ($vo["price"]); ?></td>
							<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
							<td><?php switch($vo["info_resource_type"]): case "1": ?>爬取<?php break; case "2": ?>OPEN-API<?php break; case "3": ?>个人发布<?php break; case "4": ?>房东版发<?php break; case "5": ?>BD<?php break; endswitch;?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table><?php endif; ?>

				<form method="post" action="/hizhu/CustomerTracking/saveTracking">
				<input type="hidden" name="id" value="<?php echo ($trackModel['id']); ?>">
				<input type="hidden" name="customer_id" value="<?php echo ($trackModel['customer_id']); ?>">
				<input type="hidden" name="customer_mobile" value="<?php echo ($trackModel['mobile']); ?>">
				<div  style="font-size:16px;margin:20px 0 10px 50px;">回访结果</div>
				<table class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;">
					<tr>
						<td class="td_title"><span>*</span>回访来源：</td>
						<td class="td_main">
							<select id="visit_source" name="visit_source">
								<option value="0">请选择</option>
								<option value="1">电话回访</option>
								<option value="2">房东反馈</option>
								<option value="3">保障房源</option>
								<option value="4">短信回访</option>
								<option value="5">返现申请</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>回访结果：</td>
						<td class="td_main">
							<select id="renter_status" name="renter_status">
								<option value="0">请选择</option>
								<option value="1">未租到</option>
								<option value="2">已租到</option>
								<option value="3">拒绝回访</option>
								<option value="4">未接听</option>
								<option value="5">不租了</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">租到渠道：</td>
						<td class="td_main">
							<select id="renter_sourcetype" name="renter_sourcetype" >
								<option value="0">请选择</option>
								<option value="1">嗨住</option>
								<option value="2">其他</option>
							</select>&nbsp;<input type="input" name="renter_source" style="display:none;">
						</td>
					</tr>
					<tr>
						<td class="td_title">是否看房：</td>
						<td class="td_main"><label><input type="radio" name="is_look" value="1">是</label>&nbsp;<label><input type="radio" name="is_look" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr style="display:none">
						<td class="td_title">BD是否收到佣金：</td>
						<td class="td_main"><label><input type="radio" name="is_getcommission" value="1">是</label>&nbsp;<label><input type="radio" name="is_getcommission" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title">房间编号：</td>
						<td class="td_main"><input type="text" name="renter_room" ></td>
					</tr>
					<tr>
						<td class="td_title">入住时间：</td>
						<td class="td_main"><input type="text" name="renter_time"  class="inpt_a" style="width:25%;"></td>
					</tr>
					<tr>
						<td class="td_title">继续服务：</td>
						<td class="td_main"><label><input type="radio" name="is_service" value="1">是</label>&nbsp;<label><input type="radio" name="is_service" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title">二次回访：</td>
						<td class="td_main"><label><input type="radio" name="second_visit" value="1">需要</label>&nbsp;<label><input type="radio" name="second_visit" value="2">不需要</label>&nbsp;
						</td>
					</tr>
					<tr style="display:none">
						<td class="td_title">是否满意：</td>
						<td class="td_main"><label><input type="radio" name="is_satisfied" value="1">是</label>&nbsp;<label><input type="radio" name="is_satisfied" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr style="display:none">
						<td class="td_title">是否推荐：</td>
						<td class="td_main"><label><input type="radio" name="is_recommend" value="1">是</label>&nbsp;<label><input type="radio" name="is_recommend" value="2">否</label>&nbsp;
						</td>
					</tr>
					<?php if(($cashstatus['status_code'] == 1)): ?><tr>
						<td class="td_title">是否符合返现条件：</td>
						<td class="td_main"><label><input type="radio" name="status_code" value="2">是</label>&nbsp;<label><input type="radio" name="status_code" value="4">否</label>&nbsp;
						</td>
					</tr><?php endif; ?>
					<tr>
						<td class="td_title">备注：</td>
						<td class="td_main"><input type="text" name="bakinfo" style="width:98%"></td>
					</tr>
				</table>
				</form>
			</div>
			<div style="margin-left:35%;"><a href="javascript:;" class="btn_a">提交</a></div>
		</div>
	</div>
</body>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
 <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});

$("#renter_status").change(function(){
	var renter_status = $("#renter_status").val();
	if( renter_status == '4' || renter_status == '5') {
		$("#renter_sourcetype").val('');
		$("input[name='is_look']").attr('checked',false);
		$("input[name='renter_room']").val('');
		$("input[name='renter_time']").val('');
		$("input[name='is_service']").attr('checked',false);
		$("input[name='second_visit']").attr('checked',false);
		$("#renter_sourcetype").attr('disabled','disabled');
		$("input[name='is_look']").attr('disabled','disabled');
		$("input[name='renter_room']").attr('disabled','disabled');
		$("input[name='renter_time']").attr('disabled','disabled');
		$("input[name='is_service']").attr('disabled','disabled');
		$("input[name='second_visit']").removeAttr('disabled');
		$("input[name='bakinfo']").removeAttr('disabled');
	} else if(renter_status == '3') {
		$("#renter_sourcetype").val('');
		$("input[name='is_look']").attr('checked',false);
		$("input[name='renter_room']").val('');
		$("input[name='renter_time']").val('');
		$("input[name='is_service']").attr('checked',false);
		$("input[name='second_visit']").attr('checked',false);
		$("#renter_sourcetype").attr('disabled','disabled');
		$("input[name='is_look']").attr('disabled','disabled');
		$("input[name='renter_room']").attr('disabled','disabled');
		$("input[name='renter_time']").attr('disabled','disabled');
		$("input[name='is_service']").attr('disabled','disabled');
		$("input[name='second_visit']").attr('disabled','disabled');
		$("input[name='bakinfo']").removeAttr('disabled');
	} else if(renter_status == '2') {
		$("input[name='second_visit']").attr('checked',false);
		$("#renter_sourcetype").removeAttr('disabled');
		$("input[name='is_look']").removeAttr('disabled');
		$("input[name='renter_room']").removeAttr('disabled');
		$("input[name='renter_time']").removeAttr('disabled');
		$("input[name='is_service']").removeAttr('disabled');
		$("input[name='second_visit']").attr('disabled','disabled');
		$("input[name='bakinfo']").removeAttr('disabled');
	} else if(renter_status == '0') {
		$("#renter_sourcetype").val('');
		$("input[name='is_look']").attr('checked',false);
		$("input[name='renter_room']").val('');
		$("input[name='renter_time']").val('');
		$("input[name='is_service']").attr('checked',false);
		$("input[name='second_visit']").attr('checked',false);
		$("input[name='bakinfo']").val('');
		$("#renter_sourcetype").removeAttr('disabled');
		$("input[name='is_look']").removeAttr('disabled');
		$("input[name='renter_room']").removeAttr('disabled');
		$("input[name='renter_time']").removeAttr('disabled');
		$("input[name='is_service']").removeAttr('disabled');
		$("input[name='second_visit']").removeAttr('disabled');
		$("input[name='bakinfo']").removeAttr('disabled');
	} else if(renter_status == '1') {
		$("#renter_sourcetype").val('');
		$("input[name='renter_room']").val('');
		$("input[name='renter_time']").val('');
		$("#renter_sourcetype").attr('disabled','disabled');
		$("input[name='is_look']").removeAttr('disabled');
		$("input[name='renter_room']").attr('disabled','disabled');
		$("input[name='renter_time']").attr('disabled','disabled');
		$("input[name='is_service']").removeAttr('disabled');
		$("input[name='second_visit']").removeAttr('disabled');
		$("input[name='bakinfo']").removeAttr('disabled');
	}
});

$("#renter_sourcetype").change(function(){
	var renter_status = $("#renter_status").val();
	var type=$(this).val();
	if(type=='2'){
		$("input[name='renter_source']").show();
	}else{
		$("input[name='renter_source']").val('').hide();
	}
	if(type == '1'&& (renter_status== '0' || renter_status == '2')) {
		$("input[name='is_look'][value='1']").attr('checked',true);
	}
	
});
$('.btn_a').bind('click',function(){
	var visit_source = $("#visit_source").val();
	var renter_status = $("#renter_status").val();
	if(visit_source == '0') {
		alert("请选择回访来源");return;
	} else if(renter_status == '0'){
		alert("请选择租住状态");return;
	}
	$(this).unbind('click').text('提交中');
	$("form").submit();
});
</script>
</html>
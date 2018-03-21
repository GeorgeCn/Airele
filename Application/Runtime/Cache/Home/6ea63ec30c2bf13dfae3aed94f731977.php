<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>新增租客追踪</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
</head>
<body>
	<div class="main">
		
		<div class="main_right">
			<div class="common_main">
				<form method="post" action="/hizhu/CustomerTracking/saveTrackingadd">
				<div  style="font-size:16px;margin:20px 0 10px 50px;">回访结果</div>
				<table class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;">
					<tr>
						<td class="td_title">城市：</td>
						<td class="td_main">
							<select name="city_code">
								<option value=""></option>
								<option value="001009001">上海</option>
								<option value="001001">北京</option>
								<option value="001011001">杭州</option>
								<option value="001010001">南京</option>
								<option value="001019002">深圳</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">手机号：</td>
						<td class="td_main">
							<input type="text" name="mobile">
						</td>
					</tr>
					<tr>
						<td class="td_title">租住状态：</td>
						<td class="td_main">
							<select id="renter_status" name="renter_status">
								<option value="0"></option>
								<option value="1">未租到</option>
								<option value="2">已租到</option>
								<option value="3">拒绝回访</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">租到渠道：</td>
						<td class="td_main">
							<select id="renter_sourcetype" name="renter_sourcetype">
								<option value="0">请选择</option>
								<option value="1">嗨住</option>
								<option value="2">其他</option>
							</select>&nbsp;<input type="input" name="renter_source" style="display:none;">
						</td>
					</tr>
					<tr>
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
						<td class="td_title">是否需要继续服务：</td>
						<td class="td_main"><label><input type="radio" name="is_service" value="1">是</label>&nbsp;<label><input type="radio" name="is_service" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title">是否看房：</td>
						<td class="td_main"><label><input type="radio" name="is_look" value="1">是</label>&nbsp;<label><input type="radio" name="is_look" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title">是否满意：</td>
						<td class="td_main"><label><input type="radio" name="is_satisfied" value="1">是</label>&nbsp;<label><input type="radio" name="is_satisfied" value="2">否</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title">是否推荐：</td>
						<td class="td_main"><label><input type="radio" name="is_recommend" value="1">是</label>&nbsp;<label><input type="radio" name="is_recommend" value="2">否</label>&nbsp;
						</td>
					</tr>
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
$("#renter_sourcetype").change(function(){
	var type=$(this).val();
	if(type=='2'){
		$("input[name='renter_source']").show();
	}else{
		$("input[name='renter_source']").val('').hide();
	}
});
$('.btn_a').bind('click',function(){
	var regPhone=/^1[34578]\d{9}$/;
	if(!regPhone.test($("input[name='mobile']").val())){
		alert("请输入有效的手机号");return;
	}
	$(this).unbind('click').text('提交中');
	$("form").submit();
});
</script>
</html>
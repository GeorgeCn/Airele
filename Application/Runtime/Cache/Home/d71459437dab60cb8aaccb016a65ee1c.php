<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>小区映射关系维护</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
</head>
<body>
		<div class="main_right">
			<div class="common_main">
				<table class="table_one" style="width:100%">
					<tr>
						<td class="td_title">店铺名称：</td>
						<td class="td_main"><?php echo ($detail['store_name']); ?></td>
						<td class="td_title">反馈人手机号：</td>
						<td class="td_main"><?php echo ($detail['feedbacker_mobile']); ?></td>
						<td class="td_title">租客手机号：</td>
						<td class="td_main"><?php echo ($detail['customer_mobile']); ?></td>
					</tr>
					<tr>
						<td class="td_title">房间编号：</td>
						<td class="td_main"><?php echo ($detail['room_no']); ?></td>
						<td class="td_title">成交金额(元)：</td>
						<td class="td_main"><?php echo ($detail['renter_price']); ?></td>
						<td class="td_title">佣金金额(元)：</td>
						<td class="td_main"><?php echo ($detail['commission_price']); ?></td>
					</tr>
					<tr>
						<td class="td_title">佣金折扣：</td>
						<td class="td_main"><?php echo ($detail['commission_discount']); ?></td>
						<td class="td_title">付费包月：</td>
						<td class="td_main"><?php echo ($detail['monthly']); ?></td>
						<td class="td_title">付费佣金：</td>
						<td class="td_main"><?php echo ($detail['commission']); ?></td>
					</tr>
					<tr>
						<td class="td_title">入住时间(月)：</td>
						<td class="td_main"><?php echo ($detail['renter_monther']); ?></td>
						<td class="td_title">反馈时间：</td>
						<td class="td_main"><if condition="$detail['create_time'] gt '0'"><?php echo (date("Y-m-d H:i:s",$detail['create_time'])); ?></td>
						<td class="td_title">操作人：</td>
						<td class="td_main"><?php echo ($detail['update_man']); ?></td>
					</tr>
				</table>	
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
</html>
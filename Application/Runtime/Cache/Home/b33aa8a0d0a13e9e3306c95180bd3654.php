<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>端口合同明细</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    
</head>
<body>
	<div class="main">
		<div class="main_right">
			<div class="common_head">
				<h2>端口合同明细</h2>
			</div>
			<div class="common_main">
				<div class="table" id="dataDiv">
					<table width="50%">
						<thead>
							<tr>
								<th>类型</th>
								<th>启用日期</th>
								<th>端口时长(天)</th>
								<th>到期日期</th>
								<th>端口金额</th>
								<th>承诺链接数</th>
								<th>在架房源数量</th>
								<th>支付来源</th>
								<th>操作人</th>
								<th>操作时间</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td>
									<?php switch($vo["service_type"]): case "0": ?>正常<?php break; case "1": ?>延期<?php break; case "2": ?>停用<?php break; endswitch;?>
								</td>
								<td><?php if(($vo["service_start"] > 0)): echo (date("Y-m-d H:i:s",$vo["service_start"])); endif; ?></td>
								<td><?php echo ($vo['service_end']-$vo['service_start'])/86400 ?></td>
								<td><?php if(($vo["service_end"] > 0)): echo (date("Y-m-d H:i:s",$vo["service_end"])); endif; ?></td>
								<td><?php echo ($vo["price"]); ?></td>
								<td><?php echo ($vo["links_num"]); ?></td>
								<td><?php echo ($vo["house_limit"]); ?></td>
								<td>
									<?php switch($vo["pay_type"]): case "0": ?>微信<?php break; case "2": ?>支付宝<?php break; endswitch;?>
								</td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
								<td><?php echo ($vo["memo"]); ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
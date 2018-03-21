<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房屋修改历史记录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    
</head>
<body>
	<div class="main">
		<div class="main_right">
			<div class="common_head">
				<h2>修改历史</h2>
			</div>
			<div class="common_main">
				<div class="table" id="dataDiv">
					<table width="50%">
						<thead>
							<tr>
								<th>更新人</th>
								<th>更新时间</th>
								<th>操作类型</th><th>备注</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo["update_time"])); ?></td>
								<td><?php echo ($vo["operate_type"]); ?></td><td><?php echo ($vo["operate_bak"]); ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
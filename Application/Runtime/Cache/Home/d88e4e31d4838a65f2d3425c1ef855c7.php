<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>包月修改历史记录</title>
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
								<th>修改时间</th>
								<th>操作人</th>
								<th>包月状态</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td>
									<?php if(($vo["is_open"] == 1)): if(($vo["is_delay"]) == "0"): ?>未到期<?php endif; ?>
									<?php if(($vo["is_delay"]) == "1"): ?>延期<?php endif; ?>
									<?php elseif(($vo["is_open"] == 0)): ?>到期<?php endif; ?>
								</td>
								<td><?php echo ($vo["bak_info"]); ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
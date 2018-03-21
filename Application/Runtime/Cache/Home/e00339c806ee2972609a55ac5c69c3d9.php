<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>店铺信用分</title>
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
			<div class="common_head">
				<h2>店铺信息</h2>
				<div class="common_head_main">
					<table class="table_one">
					<input type="hidden" value="<?php echo ($detail['name']); ?>" id="storeTitle">
						<tr>
							<td class="td_title">店铺名称：</td>
							<td class="td_main" ><?php echo ($detail['name']); ?>
							</td>
							<td class="td_title">创建时间：</td>
							<td class="td_main"><?php echo (date("Y-m-d H:i:s",$detail['create_time'])); ?></td>
						</tr>
						<tr>
							<td class="td_title">信用分：</td>
							<td class="td_main" ><?php echo ($detail['credit_score']); ?>分</td>
							<td class="td_title">保证金：</td>
							<td class="td_main" ><?php echo ($detail['earnestmoney']); ?>元</td>
						</tr>
						<tr>
							<td class="td_title">店铺类型：</td>
							<td class="td_main">
								<?php if(strtoupper($detail['medal_type']) == '0'): ?>普通
									<?php elseif(strtoupper($detail['medal_type']) == '1'): ?>
									 金牌
									<?php elseif(strtoupper($detail['medal_type']) == '2'): ?>
									 银牌<?php endif; ?>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>	
						</tr>	
					</table>
				</div>
			</div>
			<div class="common_head">
				<h2>查询条件</h2>
				<div class="common_head_main">
					<form action="<?php echo U('Stores/storeCreditScore');?>" method="get">
						<input type="hidden" name="no" value="162">
						<input type="hidden" name="leftno" value="164">
						<input type="hidden" name="id" value="<?php echo ($detail['id']); ?>">
						<table class="table_one">
							<tr>
								<td class="td_title">变更时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>	
						</table>
						<p class="head_p"><button type="submit" class="btn_a">查询</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>信用分历史</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>信用分</th>
								<th>变动分数</th>
								<th>变更时间</th>
								<th>扣分原因</th>
								<th>变更房源</th>
								<th>操作人</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo['now_score']); ?></td>
								<td><?php echo ($vo['score_num']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td>
									<?php if(($vo['score_type'] == '1')): ?>发布真房源
									<?php elseif(($vo['score_type'] == '2')): ?>
									 确认可租
									<?php elseif(($vo['score_type'] == '3')): ?>
									 主动反馈成交
									<?php elseif(($vo['score_type'] == '4')): ?>
									 一周未接电话超过3次
									<?php elseif(($vo['score_type'] == '5')): ?>
									 平台展示房源的地址误差距离超过1000米
									<?php elseif(($vo['score_type'] == '6')): ?>
									 平台展示房源实际已出租
									<?php elseif(($vo['score_type'] == '7')): ?>
									 平台展示租金与实际租金上浮超过10%
									<?php elseif(($vo['score_type'] == '8')): ?>
									 平台展示房源面积与实际面积下浮超过5㎡
									<?php elseif(($vo['score_type'] == '9')): ?>
									 平台展示的图片与实际情况不符
									<?php elseif(($vo['score_type'] == '10')): ?>
									 将合租写成整租
									<?php elseif(($vo['score_type'] == '11')): ?>
									 夸大平台展示房源的户型
									<?php elseif(($vo['score_type'] == '12')): ?>
									 服务过程中恶意辱骂租客
									<?php elseif(($vo['score_type'] == '13')): ?>
									 任何违反国家法律的行为
									<?php elseif(($vo['score_type'] == '14')): ?>
									 缴纳保证金
									<?php elseif(($vo['score_type'] == '15')): ?>
									 <?php echo ($vo['msg_txt']); endif; ?>
								</td>
								<td><?php echo ($vo['memo']); ?></td>
								<td><?php echo ($vo['oper_man_name']); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
					<div class="addhouse_last addhouse_last_room">
					<a href="<?php echo U('Stores/storeModifyCreScore?no=162&leftno=164',array('id'=>$detail['id']));?>" class="btn_a" style="min-width: 200px;min-height:40px;line-height:40px;margin:20px 20px 20px 40px" >更改信用分</a>
				</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
	<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"}); 
	</script>
</body>
</html>
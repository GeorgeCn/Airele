<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>订单管理</title>
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
				<h2>用户搜索</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Customerquery/renterAuthList');?>" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="59">
					<table class="table_one">
						<tr>
							<td class="td_title">注册日期：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;
								<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
							<td class="td_title">注册手机号：</td>
							<td class="td_main"><input type="text" name="mobile" maxlength="20" value="<?php echo I('get.mobile');?>"></td>
							</td>
							<td class="td_title">房东类型：</td>
							<td class="td_main">
								<select name="isowner">
							        <option value="">=全部=</option>
							    	<option value="3"<?php if(I('get.isowner')==3){echo"selected";}?>>个人房东</option>
							    	<option value="4"<?php if(I('get.isowner')==4){echo"selected";}?>>职业房东</option>
							    </select>
							</td>
						</tr>
						<tr>
							<td class="td_title">是否租客：</td>
							<td class="td_main">
								<select name="isrenter">
							        <option value="">=全部=</option>
							    	<option value="1"<?php if(I('get.isrenter')=='1'){echo"selected";}?>>是</option>
							    	<option value="0"<?php if(I('get.isrenter')=='0'){echo"selected";}?>>否</option>
							    </select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>用户列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>注册手机号</th>
								<th>用户姓名</th>
								<th>性别</th>
								<th>年龄段</th>
								<th>房东类型</th><th>是否租客</th>
								<th>靠谱租客</th>
								<th>注册时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td>
									<?php if(strtoupper($vo['sex']) == '0'): ?>女
									<?php elseif(strtoupper($vo['sex']) == '1'): ?>
									 男
									 <?php elseif(strtoupper($vo['sex']) == '2'): ?>
									 保密<?php endif; ?>
								</td>
								<td>
									<?php if(strtoupper($vo['age']) == '0901'): ?>00后
									<?php elseif(strtoupper($vo['age']) == '0902'): ?>
									  90后
									 <?php elseif(strtoupper($vo['age']) == '0903'): ?>
									 80后
									  <?php elseif(strtoupper($vo['age']) == '0904'): ?>
									  70后
									 <?php elseif(strtoupper($vo['age']) == '0905'): ?>
									  60后<?php endif; ?>
								</td>
								<td>
									<?php if($vo['is_owner'] == '3'): ?>个人房东
									<?php elseif($vo['is_owner'] == '4'): ?>
									 职业房东<?php endif; ?>
							
								</td>
								<td>
									<?php if($vo['is_renter'] == '1'): ?>是
									<?php else: ?>
									 否<?php endif; ?>
								</td>
								<td>
									<?php if(strtoupper($vo['renter_auth']) == '0'): ?>未认证
									<?php elseif(strtoupper($vo['renter_auth']) == '1'): ?>
									  已认证<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><a href="javascript:;" onclick="attestation('<?php echo ($vo['id']); ?>')">取消认证</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页15条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$("#btnSearch").click(function(){
		$(this).unbind('click').text('搜索中');
		$("form").submit();
	});
	function attestation(customer_id){
		if(confirm("是否取消认证该租客！")){
			window.location.href='/hizhu/Customerquery/renterAuth?type=1&customer_id='+customer_id;
		}
	}
</script>
</body>
</html>
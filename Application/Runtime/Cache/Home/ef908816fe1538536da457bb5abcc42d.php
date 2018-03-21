<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>用户管理</title>
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
				<h2>认证房东搜索</h2>
				<div class="common_head_main">
					<form action="<?php echo U('Customer/authenticationList');?>" method="get">
					 <table class="table_one">
						<tr>
							<td class="td_title">认证日期：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo$_GET['startTime']?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo$_GET['endTime']?>"></td>
							<td class="td_title">房东手机号：</td>
							<td class="td_main"><input type="tel" name="mobile" maxlength="11" value="<?php echo$_GET['mobile']?>"></td>
						</tr>
						<tr>
							<td class="td_title">房东姓名：</td>
							<td class="td_main"><input type="text" name="name" value="<?php echo$_GET['name']?>"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>认证房东列表<a href="<?php echo U('Customer/addAuthentication');?>?dis=opym" class="btn_a">新增认证房东</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>性别</th>
								<th>年龄段</th>
								<th>认证状态</th>
								<th>认证时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td>
									<?php if(strtoupper($vo['sex']) == '1'): ?>男
									<?php elseif(strtoupper($vo['sex']) == '0'): ?>
									女
									<?php elseif(strtoupper($vo['sex']) == '2'): ?>
									保密<?php endif; ?>
								</td>
								<td><?php if($vo['age']=='0901'){echo"00后";}elseif($vo['age']=='0902'){echo"90后";}elseif($vo['age']=='0903'){echo"80后";}elseif($vo['age']=='0904'){echo"70后";}elseif($vo['age']=='0905'){echo"60后";}elseif($vo['age']=='0906'){echo"保密";}?></td>
								<td>
								<?php if(strtoupper($vo['is_auth']) == '1'): ?>已认证
								<?php elseif(strtoupper($vo['is_auth']) == '0'): ?>
									已取消认证<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['auth_time'])); ?></td>
								<td>
								<?php if(strtoupper($vo['is_auth']) == '1'): ?><a href="#" onclick="cancel('<?php echo ($vo['id']); ?>')">取消认证</a>
								<?php elseif(strtoupper($vo['is_auth']) == '0'): ?>
									<a href="#" onclick="certification('<?php echo ($vo['id']); ?>')">重新认证</a><?php endif; ?>
								&nbsp&nbsp&nbsp&nbsp
								<a href="<?php echo U('Customer/upLandlord');?>?uid=<?php echo ($vo['id']); ?>">修改</a>
								</td>
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
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	function cancel(resource_id){
		if(confirm("确认取消认证？")){
			var url="/hizhu/Customer/upAuthenStatus.html?paid="+resource_id;
			window.location.href = url;
		}
	}
	function certification(res_id){
		if(confirm("确认重新认证？")){
			var url="/hizhu/Customer/upAuthenStatus.html?paid="+res_id;
			window.location.href = url;
		}
	}
	</script>
</body>
</html>
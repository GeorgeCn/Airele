<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>店铺管理</title>
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
				<h2>店铺人员查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Stores/storePerson');?>" method="get">
						<input type="hidden" name="no" value="162">
						<input type="hidden" name="leftno" value="165">
					<table class="table_one">
						<tr>
							<td class="td_title">人员手机号：</td>
							<td class="td_main"><input type="text" name="mobile" value="<?php echo I('get.mobile');?>" placeholder="该手机所在的店铺"></td>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>	
					</table>
					<p class="head_p"><button type="submit" class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>店铺列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>店铺ID</th>
								<th>店铺名称</th>
								<th>店长手机号</th>
								<th>店长</th>
								<th>店铺类型</th>
								<th>店铺创建时间</th>
								<th>类型修改时间</th>
								<th>房间数</th>
								<th>保证金</th>
								<th>信用分</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['id']); ?></td>
								<td><a href="<?php echo U('stores/storeDetail?no=162&leftno=164',array('id'=>$vo['id']));?>"><?php echo ($vo['title']); ?></a></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['name']); ?></td>
								<td>
									<?php if(strtoupper($vo['type']) == '0'): ?>普通
									<?php elseif(strtoupper($vo['type']) == '1'): ?>
									 金牌
									 <?php elseif(strtoupper($vo['type']) == '2'): ?>
									 银牌<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['time'])); ?></td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i:s",$vo['update_time'])); endif; ?></td>
								<td><?php echo ($vo['num']); ?></td>
								<td><?php echo ($vo['earnestmoney']); ?></td>
								<td><a onclick="select('<?php echo ($vo["id"]); ?>','<?php echo ($vo["title"]); ?>')" style="color:blue" id="aa"><?php echo ($vo['credit_score']); ?></a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<!-- <div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script>
    	function select(id,title)
		{
		   if(title != '我的房源') {
		   	window.location.href = '/hizhu/Stores/storeDetail.html?id='+id;
		   }
		}
    </script>
</body>
</html>
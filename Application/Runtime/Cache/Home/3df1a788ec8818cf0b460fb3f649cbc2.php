<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>待处理订单</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/order_manage_check.css">
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
				<h2>付款订单查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Service/awaitlist');?>" method="get">
				<input type="hidden" name="no" value="4">
				<input type="hidden" name="leftno" value="73">
					<table class="table_one">
						<tr>
							<td class="td_title">用户姓名：</td>
							<td class="td_main"><input type="text" name="name" class="inpt_a" value="<?php echo$_GET['name']?>"></td>
							<td class="td_title">订单类型：</td>
							<td class="td_main">
							     <select name="class_id" style="width:100px;";>
									<option value="">=全部=</option>
									<option value="2">管道疏通</option>
									<option value="1">家电维修</option>
									<option value="1">开锁换锁</option>
								 </select>
							</td>
							<td class="td_title">订单金额：</td>
							<td class="td_main"><input type="text" name="price_cnt" maxlength="11" value="<?php echo$_GET['price_cnt']?>"></td>
						</tr>
						<tr>
							<td class="td_title">用户手机：</td>
							<td class="td_main"><input type="text" class="inpt_a" name="mobile" value="<?php echo$_GET['mobile']?>"></td>
							<td class="td_title">预约上门地址：</td>
							<td class="td_main"><input type="text" class="inpt_a" name="address" value="<?php echo$_GET['address']?>"></td>
							<td class="td_title">订单状态：</td>
							<td class="td_main">
								<select name="orderstatus" style="width:100px;";>
									<option value="" <?php if($_GET['order_status']===""){echo "selected";}?>>=全部=</option>
									<option value="1" <?php if(strlen($_GET['order_status'])==1){echo "selected";}?>>待支付</option>
									<option value="2" <?php if(strlen($_GET['order_status'])==2){echo "selected";}?>>已支付</option>
									<option value="3" <?php if(strlen($_GET['order_status'])==3){echo "selected";}?>>已派单</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="td_title">订单号：</td>
							<td class="td_main"><input class="inpt_a" type="tel" name="orderid" value="<?php echo$_GET['orderid']?>"></td>
							<td class="td_title">预约上门时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo$_GET['startTime']?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo$_GET['endTime']?>"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button type="submit" class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>付款订单列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>订单号</th>
								<th>姓名</th>
								<th>联系方式</th>
								<th>师傅姓名</th>
								<th>师傅联系方式</th>
								<th>上门地址</th>
								<th>上门时间</th>
								<th>订单类型</th>
								<th>服务项目</th>
								<th>订单状态</th>
								<th>支付金额</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['id']); ?></td>
								<td><?php echo ($vo['customer_name']); ?></td>
								<td><?php echo ($vo['customer_mobile']); ?></td>
								<td><?php echo ($vo['man_name']); ?></td>
								<td><?php echo ($vo['man_mobile']); ?></td>
								<td><?php echo ($vo['province_name']); ?>-<?php echo ($vo['city_name']); ?>-<?php echo ($vo['district_name']); ?>-<?php echo ($vo['address']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['service_time'])); ?></td>
								<td><?php echo ($vo['class_name']); ?></td>
								<td><?php echo ($vo['option_name']); ?></td>
								<td>
									<?php if(strtoupper($vo['order_status']) == '1'): ?>待支付
									<?php elseif(strtoupper($vo['order_status']) == '2'): ?>
									已支付
									<?php elseif(strtoupper($vo['order_status']) == '3'): ?>
									已派单
									<?php else: ?>
									——<?php endif; ?>
								</td>
								<td><span><?php echo ($vo['price_cnt']); ?></span></td>
								<td>
								<?php if(($vo['order_status']) == '2'): ?><a href="<?php echo U('Service/distributed');?>?oid=<?php echo ($vo['id']); ?>&no=4&leftno=73">派单</a><?php endif; ?>
								<a href="<?php echo U('Service/orderinfo');?>?oid=<?php echo ($vo['id']); ?>&no=4&leftno=73">查看</a>
								<?php if(($vo['order_status']) < '4'): ?><a href="<?php echo U('Service/orderupdate');?>?oid=<?php echo ($vo['id']); ?>&no=4&leftno=73">修改</a><?php endif; ?>
								<?php if(strtoupper($vo['order_status']) < '4'): ?><a href="javascript:;" data-orderid="<?php echo ($vo['id']); ?>" name="quxiao">取消</a><?php endif; ?>
								</td>
							</tr>
								<input name="order_id" type="hidden" class="order_id" value="<?php echo ($vo['id']); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
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


      $(".table tr").each(function(){
		   $(this).find("a[name='quxiao']").click(function(){
		   		var orderid=$(this).attr("data-orderid");
		   	  if(confirm('确定取消该订单？')){
              	  window.document.location.href="/hizhu/Service/ordercancel.html?orderid="+orderid;
		   	  } 		
		  })
      });
</script>
</body>
</html>
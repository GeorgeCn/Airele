<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>订单管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/order_manage_pay.css">
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
				<h2>订单查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Orders/auditHouseOrders');?>" method="get">
					<table class="table_one">
						<tr>
							<td class="td_title">提交日期：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo$_GET['startTime']?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo$_GET['endTime']?>"></td>
							<td class="td_title">租客手机号：</td>
							<td class="td_main"><input type="text" name="mobile" maxlength="11" value="<?php echo$_GET['mobile']?>"></td>
							<td class="td_title">房东手机号</td>
							<td class="td_main"><input type="text" name="landmobile" maxlength="11" value="<?php echo$_GET['landmobile']?>"></td>
						</tr>
						<tr>
							<td class="td_title">状态：</td>
							<td class="td_main">
								<select name="orderStatus"><?php echo strlen($_GET['orderStatus']);?>
									<option value="" <?php if($_GET['orderStatus']===""){echo "selected";}?>>=全部=</option>
									<option value="0" <?php if(strlen($_GET['orderStatus'])==1){echo "selected";}?>>待审核</option>
									<option value="3" <?php if($_GET['orderStatus']==3){echo "selected";}?>>审核未通过</option>
									<option value="2" <?php if($_GET['orderStatus']==2){echo "selected";}?>>待付款</option>
									<option value="4" <?php if($_GET['orderStatus']==4){echo "selected";}?>>已付款</option>
									<option value="6" <?php if($_GET['orderStatus']==6){echo "selected";}?>>机构已打款</option>
									<option value="7" <?php if($_GET['orderStatus']==7){echo "selected";}?>>直接已退款</option>
									<option value="8" <?php if($_GET['orderStatus']==8){echo "selected";}?>>打款失败已退款</option>
									<option value="1" <?php if($_GET['orderStatus']==1){echo "selected";}?>>已取消</option>
								</select>
							</td>
							<td class="td_title">租客姓名：</td>
							<td class="td_main"><input type="text" name="tenant" value="<?php echo$_GET['tenant']?>"></td>
							<td class="td_title">订单编号：</td>
							<td class="td_main"><input type="text" name="orderid" value="<?php echo$_GET['orderid']?>"></td>
						</tr>
						<tr>
							<td class="td_title">来源：</td>
							<td class="td_main">
								<select name="source">
									<option value="" <?php if($_GET['source']===""){echo "selected";}?>>=全部=</option>
									<option value="0" <?php if(strlen($_GET['source'])==1){echo "selected";}?>>微信</option>
									<option value="1" <?php if($_GET['source']==1){echo "selected";}?>>android</option>
									<option value="2" <?php if($_GET['source']==2){echo "selected";}?>>iphone</option>
								</select>
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
				<h2>订单列表<a href="<?php echo U('Orders/downloadExcel');?>?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>订单编号</th>
								<th>租客姓名</th>
								<th>租客手机</th>
								<th>房租总金额(元)</th>
								<th>优惠(元)</th>
								<th>手续费(元)</th>
								<th>租客付款金额(元)</th>
								<th>状态</th>								
								<th>提交时间</th>
								<th>操作人</th>
								<th>审核</th>
							</tr>
						</thead>
						<tbody id="tb1">
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['id']); ?></td>
								<td><?php echo ($vo['renter_name']); ?></td>
								<td><?php echo ($vo['renter_phone']); ?></td>
								<td class="money"><?php echo ($vo['order_pirce_cnt']); ?></td>
								<td class="money" id="<?php echo ($vo['id']); ?>">0</td>
								<td class="money">0</td>
								<td class="money"><span><?php echo ($vo['price_cnt']); ?></span></td>
								<td class="wait">
									<?php if(strtoupper($vo['order_status']) == '0'): ?>待审核
									<?php elseif(strtoupper($vo['order_status']) == '1'): ?>
									已取消
									<?php elseif(strtoupper($vo['order_status']) == '2'): ?>
									待付款
									<?php elseif(strtoupper($vo['order_status']) == '3'): ?>
									审核未通过
									<?php elseif(strtoupper($vo['order_status']) == '4'): ?>
									已付款
									<?php elseif(strtoupper($vo['order_status']) == '6'): ?>
									机构已打款
									<?php elseif(strtoupper($vo['order_status']) == '7'): ?>
									直接已退款
									<?php elseif(strtoupper($vo['order_status']) == '8'): ?>
									打款失败已退款<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td class="<?php echo ($vo['id']); ?>"></td>
								<td><a href="<?php echo U('Orders/ordersDetails');?>?oid=<?php echo ($vo['id']); ?>">审核</a></td>
								<input name="order_id" type="hidden" class="order_id" value="<?php echo ($vo['id']); ?>">
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页15条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>

					</div>
					<div style="height:30px;line-height:30px;text-align:left;margin-bottom:30px;border-bottom:2px solid #e3e3e3;">&nbsp;&nbsp;
		           租房总金额累计：<?php echo sprintf("%.2f",$sumorders['sumorder_pirce_cnt']);?> 
		           优惠累计：<?php echo sprintf("%.2f",$sumorders['sumorder_pirce_cnt']-$sumorders['sumprice_cunt']);?>
		          手续费累计：0
		          应付总金额累计：<?php echo sprintf("%.2f",$sumorders['sumprice_cunt']);?></div>
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	
	 $.each($("#tb1").find("input.order_id"), function () {
       		OrderCouponList($(this).val());     
       
    });

	$.each($("#tb1").find("input.order_id"), function () {
        
  
             OrderOperator($(this).val());      
      
    });

/*
    $(".order_id").each(function(){  
        OrderCouponList($(this).val());   
             
   });   
   $(".order_id").each(function(){  
      OrderOperator($(this).val());            
   });   
*/
  
</script>
</body>
</html>
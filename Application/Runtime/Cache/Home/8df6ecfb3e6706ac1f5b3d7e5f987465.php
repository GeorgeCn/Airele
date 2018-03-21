<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>打款管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">

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

    <div class="floatDiv">
		<div class="desk"></div>
		<div class="floatDiv_main">
			<table>
				<caption>订单编号:<?php echo ($ordersdetails["id"]); ?></caption>
				<thead>
					<th>序号</th>
					<th>操作</th>
					<th>操作人</th>
					<th>操作时间</th>
					<th>备注</th>
				</thead>
				<tbody>
				  <?php if(is_array($statuslist)): $i = 0; $__LIST__ = $statuslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($i); ?></td>
						<td><?php if($vo['order_status']==0){echo"租客提交订单";}elseif($vo['order_status']==1){echo"租客取消订单";}elseif($vo['order_status']==2){echo"审核通过";}elseif($vo['order_status']==3){echo"审核拒绝";}elseif($vo['order_status']==4){echo"租客付款";}elseif($vo['order_status']==6){echo"机构打款";}elseif($vo['order_status']==7){echo"直接退款";}elseif($vo['order_status']==8){echo"打款失败退款";}?></td>
						<td><?php echo ($vo['oper_id']); ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
						<td><?php echo ($vo['desc']); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr class="out"><td colspan="5"><a href="javascript:">关闭</a></td></tr>
				</tbody>
			</table>
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
				<h2>确认打款</h2><span class="operate">操作记录</span>
			</div>
			<div class="common_main">
				<table class="table_one">
					<tr>
						<td colspan="4"><span>租客信息</span></td>
					</tr>
					<tr>
						<td class="td_title">姓名：</td>
						<td class="td_main"><?php echo ($ordersdetails['renter_name']); ?></td>
						<td class="td_title">支付方式：</td>
						<td>
							<?php if(strtoupper($paymanner['pay_platform']) == '0'): ?>微信
							<?php elseif(strtoupper($paymanner['pay_platform']) == '1'): ?>
							 银联
							<?php elseif(strtoupper($paymanner['pay_platform']) == '2'): ?>
							支付宝<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">手机：</td>
						<td class="td_main"><?php echo ($ordersdetails['renter_phone']); ?></td>
						<td class="td_title">租客付款金额：</td>
						<td class="td_main"><?php echo ($ordersdetails["price_cnt"]); ?>元</td>
					</tr>
					<tr>
						<td class="td_title">租房地址：</td>
						<td class="td_main"><?php echo ($ordersdetails["province_name"]); ?>,<?php echo ($ordersdetails["city_name"]); ?>,<?php echo ($ordersdetails["district_name"]); ?>,<?php echo ($ordersdetails["address"]); ?></td>
						<td class="td_title">订单来源：</td>
						<td class="td_main">
						<?php if(strtoupper($ordersdetails['platform']) == '0'): ?>微信
						<?php elseif(strtoupper($ordersdetails['platform']) == '1'): ?>
					     Android
						<?php elseif(strtoupper($ordersdetails['platform']) == '2'): ?>
						  iPhone<?php endif; ?>
						</td>

					</tr>
					<tr>
						<td colspan="4"><span>房东信息</span></td>
					</tr>
					<tr>
						<td class="td_title">订单编号：</td>
						<td class="td_main"><?php echo ($client['order_id']); ?></td>
						<td class="td_title">打款给：</td>
						<td>
						   <?php if(strtoupper($client['bankcard_type']) == '1'): ?>支付宝账号
							<?php elseif(strtoupper($client['bankcard_type']) == '2'): ?>
					    	私人银行卡
							<?php elseif(strtoupper($client['bankcard_type']) == '3'): ?>
						     微信
						     <?php elseif(strtoupper($client['bankcard_type']) == '4'): ?>
						     对公账号<?php endif; ?>
						</td>
					</tr>
					<tr>
						 <?php if(strtoupper($client['bankcard_type']) == '4'): ?><td class="td_title">收款单位：</td>
				    	<?php else: ?>
					      <td class="td_title">收款人：</td><?php endif; ?>
						<td class="td_main"><?php echo ($client['name']); if(strtoupper($authentication['is_auth']) == '1'): ?>【良心房东】<?php endif; ?></td>
						<?php if(strtoupper($client['bankcard_type']) == '1'): ?><td class="td_title">支付宝账号：</td>
						<?php elseif(strtoupper($client['bankcard_type']) == '2'): ?>
						<td class="td_title">银行卡号：</td>
						<?php elseif(strtoupper($client['bankcard_type']) == '3'): ?>
						<td class="td_title">微信账号：</td>
						<?php elseif(strtoupper($client['bankcard_type']) == '4'): ?>
						<td class="td_title">对公账号：</td><?php endif; ?>
						<td class="td_main"><?php echo ($client['bankcard_no']); ?></td>
					</tr>
					<tr>
						<td class="td_title">手机：</td>
						<td class="td_main"><?php echo ($client['mobile']); ?></td>
						<td class="td_title">需打款金额：</td>
						<td class="td_main red"><?php echo ($ordersdetails["order_pirce_cnt"]); ?>元</td>
					</tr>
				</table>
			</div>
			<!-- <div class="common_bottom cf">
				    <div class="back fl"><a href="<?php echo U('Finance/financeList');?>">返回</a></div>
		     		<form  action="<?php echo U('Finance/updateFinanceStatus');?>" method="post">
					<input name="orderid" type="hidden" value="<?php echo ($ordersdetails["id"]); ?>">
					<div class="remarks fl">
						<label for="">备注：</label>
						<input type="text" name="remark">
					</div>
					<div class="through fl"><button class="buttom jujue">确认打款</button></div>
					</form>
			   </div> -->

			   
				<table class="table_one">
				<!--优惠劵信息-->
					<tr><td colspan="8"><span>优惠劵信息</span></td></tr>
					<?php if(is_array($couponarr)): $i = 0; $__LIST__ = $couponarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr> 
					    <td class="td_title">优惠劵类型：</td>
						<td class="td_main" style="width:auto;">
							<?php if(strtoupper($vo['coupon_type']) == '0'): ?>微信分享
							<?php elseif(strtoupper($vo['coupon_type']) == '1'): ?>			
							 普通优惠劵
							<?php elseif(strtoupper($vo['coupon_type']) == '2'): ?>
							 商家优惠劵<?php endif; ?>
						</td>
						<td class="td_title">优惠劵金额：</td>
						<td class="td_main" style="width:auto;"><?php echo ($vo["coupon_money"]); ?></td>
						<td class="td_title">优惠劵来源：</td>
						<td class="td_main" style="width:auto;"><?php echo ($vo["coupon_from"]); ?></td>
						<td class="td_title">是否叠加：</td>
						<td class="td_main" style="width:auto;">
							<?php if(strtoupper($vo['use_type']) == '0'): ?>不可叠加
							<?php elseif(strtoupper($vo['use_type']) == '1'): ?>
							可以叠加<?php endif; ?>		
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
			</div>
			<div class="common_bottom cf">
				<div class="back fl"></div>
				<div class="common_bottom_right cf fl">
					<div class="tabList1">
						<ul>
							<li class="cur">打款</li>
							<li>直接退款</li>
						</ul>
					</div>
					<div class="tabCon1">
						<div class="module1 cf">
							<form  action="<?php echo U('Finance/updateFinanceStatus');?>" method="post">
							<input name="orderid" type="hidden" value="<?php echo ($ordersdetails["id"]); ?>">
							<input name="formtype" type="hidden" value="remit">
								<div class="remarks fl">
									<label for="">备注：</label>
									<input type="text" name="remark">
								</div>
								<div class="through1 fl"><button class="buttom jujue">确认打款</button></div>
							</form>
						</div>
						<div class="module1 cf" style="display:none;">
						   <form action="<?php echo U('Finance/updateFinanceStatus');?>" method="post">
						   <input name="orderid" type="hidden" value="<?php echo ($ordersdetails["id"]); ?>">
						   <input name="formtype" type="hidden" value="reimburse">
								<div class="remarks fl">
									<label for="">退款原因：</label>
									<input type="text" name="remark">
								</div>
							    <div class="through1 fl"><button class="buttom jujue">确认退款</button></div>
						   </form>
						</div>
					</div>
				</div>
			</div>


		</div>
</body>
    <script src="/hizhu/Public/js/jquery.js"></script>
<script>
	$(function(){
		$(".tabList li").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur");
			$(".module").hide().eq($(".tabList li").index(this)).show();
		});
	})

	$(function(){
		$(".tabList1 li").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur");
			$(".module1").hide().eq($(".tabList1 li").index(this)).show();
		});
	})
</script>
<script>
	$(function(){
		$(".operate").click(function(){
			$(".floatDiv").fadeIn();
		})
		$(".out").click(function(){
			$(".floatDiv").fadeOut();
		})
	})
</script>
</html>
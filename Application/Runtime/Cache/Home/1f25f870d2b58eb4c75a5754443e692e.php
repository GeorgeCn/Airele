<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>职业房东审核</title>
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
				<h2>中介用户查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Jobowner/middlemanVerifyList');?>" method="get" id="searchForm">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="189">
					<table class="table_one">
						<tr>
							<td class="td_title">提交时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
							<td class="td_title">手机号：</td>
							<td class="td_main"><input type="tel" maxlength='11' name="mobile" value="<?php echo I('get.mobile');?>"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					</form>
					<p class="head_p"><button type="submit" class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表展示<a href="/hizhu/Jobowner/downloadMiddleManExcel.html?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a" style="min-width: 100px">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>姓名</th>
								<th>手机号</th>
								<th>中介公司</th>
								<th>收佣比</th>
								<th>提交时间</th>
								<th>审核操作</th>
								<th>操作人</th>
							</tr>
						</thead>
						<tbody>
						  	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<input type="hidden" name="customer" value="<?php echo ($vo['customer_id']); ?>">
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['agent_company_name']); ?></td>
								<td><?php echo ($vo['agent_commission_price']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td>
									<?php if($vo['refuse_status'] == '0'): ?><a href="javascript:;" onclick="IsPass('<?php echo ($vo[id]); ?>','<?php echo ($vo[customer_id]); ?>','<?php echo ($vo[mobile]); ?>',1,'<?php echo ($vo[agent_company_name]); ?>');">通过&nbsp;&nbsp;</a>
									<a href="/hizhu/Jobowner/refuseReason.html?no=6&leftno=189&origin=2&id=<?php echo ($vo["id"]); ?>">&nbsp;&nbsp;拒绝</a>
									<?php elseif($vo['refuse_status'] == '1'): ?>
									通过--<?php if($vo['pay_type'] == '0'): ?>试用用户
										  <?php elseif($vo['pay_type'] == '1'): ?>付费用户
										  <?php elseif($vo['pay_type'] == '2'): ?>免费用户<?php endif; ?>
									<?php elseif($vo['refuse_status'] == '2'): ?>
									<a href="javascript:;" onclick="IsPass('<?php echo ($vo[id]); ?>','<?php echo ($vo[customer_id]); ?>','<?php echo ($vo[mobile]); ?>',1,'<?php echo ($vo[agent_company_name]); ?>');">通过</a>
									--已拒绝<?php endif; ?>
								</td>
								<td><?php echo ($vo['oper_man_name']); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="infoAdd" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:470px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
			<div style="margin:20px;margin-top:150px" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">请选择用户类型：</label>
				<select id="pay_type" style="width:300px;height:36px;">
					<option value="0">试用用户</option>
					<option value="1">付费用户</option>
					<option value="2">免费用户</option>
				</select>
			</div>
			<div  style="text-align:center;margin-top:80px">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
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
	$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中..');
		$("#searchForm").submit();
	});
	function IsPass(id,customer_id,mobile,refuse_status,company){
		$("#infoAdd").show();
		$(".btn_b").click(function(){
			$("#infoAdd").hide();
		});
		$("#btn_submit").click(function(){
			var pay_type = $("#pay_type").val();
			$.get("/hizhu/Jobowner/matchAgentCompany.html",{"company":company},function(data){
				if(data.status == 201 || data.status == 404) {
					alert(data.message);
					location.reload();
				} else if(data.status==200) {
					$.ajax({
				            type:"post",
				            url: "<?php echo U('Jobowner/modifyCustomerCheckVerify');?>",
				            data:{"id":id,"customer_id":customer_id,"mobile":mobile,"refuse_status":refuse_status,"pay_type":pay_type},
				            success:function(data){
				            	var object = eval('('+data+')');
				            	if(object.code == 404) alert(object.message);
					            if(object.code == 400) alert(object.message);
					            if(object.code == 200) alert(object.message);
					            $("#infoAdd").hide();
					            location.reload(true);
							    }, 
					    })
				}
		},"json");
	}) 
}	
	</script>
</body>
</html>
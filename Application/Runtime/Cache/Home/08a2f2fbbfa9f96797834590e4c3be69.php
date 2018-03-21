<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>职业房东审核-拒绝</title>
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
			<div class="common_main">
				<table class="table_one" style="width:100%">
					<input type="hidden" name="id" value="<?php echo ($list['id']); ?>">
					<input type="hidden" name="origin" value="<?php echo ($origin); ?>">
					<input type="hidden" name="customer_id" value="<?php echo ($list['customer_id']); ?>">
					<input type="hidden" name="mobile" value="<?php echo ($list['mobile']); ?>">
					<tr>
						<td class="td_title"><span>*</span>姓名：</td>
						<td class="td_main"><?php echo ($list['true_name']); ?></td>
						<td class="td_title"><span>*</span>手机号：</td>
						<td class="td_main"><?php echo ($list['mobile']); ?></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>拒绝原因：</td>
						<td class="td_main" colspan='3'>
							<input type="text"  name="refuse_memo" placeholder="该原因会展示在APP给用户查看" class="refuse_memo" style="width:99%;">
							<div id="estate_div" class="plotbox" style="width:99%;">
							</div>
						</td>
					</tr>
				</table>	
				<div class="addhouse_next"><button class="btn_a" onclick="window.history.back()" style="margin:0px 20px ">取消</button>&nbsp;<button class="btn_a" id="btn_submit" style="margin:0px 20px 0px 200px">提交</button></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/listdata.js"></script>
<script type="text/javascript">
	$("#btn_submit").click(function () {
		$(this).unbind('click').text('搜索中..');
		var id = $("input[name='id']").val();
		var origin = $("input[name='origin']").val();
		var customer_id = $("input[name='customer_id']").val();
	 	var refuse_memo = $("input[name='refuse_memo']").val();
	 	var mobile = $("input[name='mobile']").val();
		if(refuse_memo == '') {
			alert("拒绝原因不能为空");
		} else {
			$.ajax({
		            type:"post",
		            url: "<?php echo U('Jobowner/modifyCustomerCheckRefuse');?>",
		            data:{"id":id,"customer_id":customer_id,"mobile":mobile,"refuse_status":2,"refuse_memo":refuse_memo},
		            success:function(data){
		            	var object = eval('('+data+')');
		            	if(object.code == 404) alert(object.message);
			            if(object.code == 400) alert(object.message);
			            if(object.code == 200) alert(object.message);
			            if(origin == 1) {
			            	window.location.href = '/hizhu/Jobowner/jobownerVerifyList.html?no=6&leftno=176';
			            } else if(origin == 2) {
			            	window.location.href = '/hizhu/Jobowner/middlemanVerifyList.html?no=6&leftno=189';
			            }
				    }, 
			    })
		}
	});
</script>
</html>
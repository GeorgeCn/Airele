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
				<h2>职业房东查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('Jobowner/jobownerCityList');?>" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="177">
					<table class="table_one">
						<tr>
							<td class="td_title">手机号：</td>
							<td class="td_main"><input type="tel" maxlength='11' name="mobile" value="<?php echo I('get.mobile');?>"></td>
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
				<h2>列表展示</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>姓名</th>
								<th>手机号</th>
								<th>房东属性</th>
								<th>当前归属城市</th>
								<th>提交时间</th>
								<th>修改归属城市</th>
							</tr>
						</thead>
						<tbody>
						  	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<input type="hidden" name="customer" value="<?php echo ($vo['customer_id']); ?>">
								<input type="hidden" name="mycity" value="<?php echo ($vo['city_code']); ?>">
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td>
									<?php if($vo['is_owner'] == '3'): ?>个人房东
									<?php elseif($vo['is_owner'] == '4'): ?>
									 职业房东
									 <?php elseif($vo['is_owner'] == '5'): ?>
									 中介<?php endif; ?>
								</td>
								<td class="city">
									<?php if($vo['city_code'] == '001009001'): ?>上海
									<?php elseif($vo['city_code'] == '001001'): ?>
									 北京
									 <?php elseif($vo['city_code'] == '001010001'): ?>
									 南京
									 <?php elseif($vo['city_code'] == '001011001'): ?>
									 杭州
									 <?php elseif($vo['city_code'] == '001019002'): ?>
									 深圳<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td>
									<a class="city1 btn_a" href="javascript:;" onclick="selectCity('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>','001009001',this);">上海</a>
									<a class="city2 btn_a" href="javascript:;" onclick="selectCity('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>','001001',this);">北京</a>
									<a class="city3 btn_a" href="javascript:;" onclick="selectCity('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>','001010001',this);">南京</a>
									<a class="city4 btn_a" href="javascript:;" onclick="selectCity('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>','001011001',this);">杭州</a>
									<a class="city5 btn_a" href="javascript:;" onclick="selectCity('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>','001019002',this);">深圳</a>
								</td>
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
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"}); 
		var mycity = $("input[name='mycity']").val();
		console.log(mycity);
		switch (mycity) {
			case '001009001':
			$(".city1").hide();
			break;
			case '001001':
			$(".city2").hide();
			break;
			case '001010001':
			$(".city3").hide();
			break;
			case '001011001':
			$(".city4").hide();
			break;
			case '001019002':
			$(".city5").hide();
			break;
		}
	function selectCity (id,customer_id,city_code,obj) {
		var mycity = $("input[name='mycity']").val();
		var city = $(obj).text();
		if(confirm('确定将该用户的归属城市修改成'+city+'吗？')) {
			$.ajax({
		            type:"post",
		            url: "<?php echo U('Jobowner/modifyCustomerCity');?>",
		            data:{"id":id,"customer_id":customer_id,"city_code":city_code},
		            success:function(data){
		            	var object = eval('('+data+')');
		            	if(object.code == 404) alert(object.message);
			            if(object.code == 400) alert(object.message);
			            if(object.code == 200) {alert(object.message);$(obj).parent().prev().prev().text(city);}
					    }, 
					datatype:'json',
			    })

		}
	}
	</script>
</body>
</html>
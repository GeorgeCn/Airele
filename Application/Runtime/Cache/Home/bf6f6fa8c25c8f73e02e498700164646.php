<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>分期订单</title>
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
			<a class="blue" href="javascript:;">欢迎您 <?php echo cookie("admin_user_name");?></a>
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
				<h2>分期查询</h2>
				<div class="common_head_main">
					<form action="<?php echo U('Staging/stagingList');?>" method="get">
					<input type="hidden" name="no" value="4"/>
					<input type="hidden" name="leftno" value="55"/>
						<table class="table_one">
							<tr>
								<td class="td_title">提交日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:''; ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" id="datetimepicker1" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:''; ?>"></td>
								<td class="td_title">租客手机号：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo isset($_GET['mobile'])?$_GET['mobile']:''; ?>"></td>
								<td class="td_title">状态：</td>
								<td class="td_main">
									<select name="stages_status" id="stages_status">
										<option value="">全部</option>
										<?php echo ($stagStagusList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">租客姓名：</td>
								<td class="td_main"><input type="text" name="name" value="<?php echo isset($_GET['name'])?$_GET['name']:''; ?>"></td>
								<td class="td_title">房东姓名：</td>
								<td class="td_main"><input type="text" name="owner_name" value="<?php echo isset($_GET['owner_name'])?$_GET['owner_name']:''; ?>"></td>
								<td class="td_title">房东手机：</td>
								<td class="td_main"><input type="text" name="owner_mobile" value="<?php echo isset($_GET['owner_mobile'])?$_GET['owner_mobile']:''; ?>"></td>
							</tr>
						</table>
						<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>分期列表<a href="javascript:;" id="download" class="btn_a">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>分期编号</th>
								<th>订单号</th>
								<th>租客姓名</th>
								<th>租客手机</th>
								<th>地区</th>
								<th>支付方式</th>
								<th>月租金</th>
								<th>房东姓名</th>
								<th>房东手机</th>
								<th>状态</th>
								<th>分期来源</th>
								<th>提交时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['stag_id']); ?></td>
								<td><?php echo ($vo['order_id']); ?></td>
								<td><?php echo ($vo['name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['city']); ?></td>
								<td><?php echo ($vo['paymanner']); ?></td>
								<td class="red"><?php echo ($vo['rental']); ?></td>
								<td><?php echo ($vo['owner_name']); ?></td>
								<td><?php echo ($vo['owner_mobile']); ?></td>
								<td><?php echo ($vo['stages_status']); ?></td>
								<td>
									<?php if($vo['sub_type'] == '0'): ?>APP
									<?php elseif($vo['sub_type'] == '1'): ?>
									APP
									<?php elseif($vo['sub_type'] == '2'): ?>
									微信
									<?php elseif($vo['sub_type'] == '3'): ?>
									H5
									<?php else: ?>
									——<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><a href="<?php echo U('Staging/upstaging');?>?sid=<?php echo ($vo['id']); ?>&no=4&leftno=55">修改</a></td>
								<input type="hidden" name="js_id" value ="<?php echo ($vo['id']); ?>">
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
    <script type="text/javascript">
		$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	    $('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	    $("table tr").find("a").click(function(){
	       var js_verifi=$(this).siblings("select").val();
           var js_id=$(this).parent().siblings("input").val();
           window.location.href="/hizhu/Staging/upstaging.html?verifi="+js_verifi+"&id="+js_id;
	    })
	    /*分期状态*/
	    $("#stages_status").val('<?php echo isset($_GET["stages_status"])?$_GET["stages_status"]:"" ?>');
	    $(".table table tr").each(function(){
	    	var td_object=$(this).children("td:eq(10)");
	    	var b_type_name=$("#stages_status option[value="+td_object.text()+"]").text();
	    	td_object.text(b_type_name);
	    });
	    $("#download").click(function(){
			var startTime=$("input[name='startTime']").val();
			var endTime=$("input[name='endTime']").val();
			var mobile=$("input[name='mobile']").val();
			var stages_status=$("#stages_status").val();
			var name=$("input[name='name']").val();
			var owner_name=$("input[name='owner_name']").val();
			var owner_mobile=$("input[name='owner_mobile']").val();
        	var url="/hizhu/Staging/dowStaging.html?startTime="+startTime+"&endTime="+endTime+"&mobile="+mobile+"&stages_status="+stages_status+"&name="+name+"&name="+name+"&owner_name="+owner_name+"&owner_mobile="+owner_mobile;
        	window.location.href=url;
    	});
	</script>
</body>
</html>
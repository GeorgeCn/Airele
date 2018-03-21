<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>短信推送</title>
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
				<h2></h2>
				<div class="common_head_main">
					
				</div>
			</div>
			<div class="common_main">
				<h2>列表<a href="#" class="btn_a" id="btn_add">新增</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房东手机</th>
								<th>推送类型</th>
								<th>推送时间</th>
								<th>城市</th>
								<th>推送人</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo["push_mobile"]); ?></td>
								<td>
									<?php if(strtoupper($vo['push_type']) == 'EZA009'): ?>房东推送<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
								<td>
									<?php if(strtoupper($vo['city_code']) == '001009001'): ?>上海
									<?php elseif(strtoupper($vo['city_code']) == '001001'): ?>
									 北京
									 <?php elseif(strtoupper($vo['city_code']) == '001011001'): ?>
									 杭州
									 <?php elseif(strtoupper($vo['city_code']) == '001010001'): ?>
									 南京
									  <?php elseif(strtoupper($vo['city_code']) == '001019001'): ?>
									 广州
									  <?php elseif(strtoupper($vo['city_code']) == '001019002'): ?>
									 深圳<?php endif; ?>
								</td>
								<td><?php echo ($vo["push_man"]); ?></td>
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

	<div id="dialogAdd" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:300px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
		     <div style="margin:30px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">推送类型：</label>
				<select name="push_type" id="push_type" style="height:30px;width:150px;">
					<option value="EZA009">房东推送</option>
				</select>
			</div>
			<div style="margin:30px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">房东手机：</label>
				<input type="tel" maxlength="11" class="fl" id="renterMoblie" style="width:200px;height:36px;">
			</div>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submitadd">提交</button>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	//add
	$("#btn_add").click(function(){
		$("#renterMoblie").val('');
		$("#contactMobile").val('');
		$("#contactTime").val('');$("#shorturlAdd").val('');$("#txtBakadd").val('');
		$("#dialogAdd").show();
	});
	
	$(".btn_b").click(function(){
		$("#dialogDiv").hide();
		$("#dialogAdd").hide();
	});
	$("#btn_submitadd").click(function(){
		 var push_mobile=$("#renterMoblie").val();
		 var push_type=$("#push_type").val();
		  var isMobile=/^1[34578]\d{9}$/;
		if(push_mobile==""){
			alert("请输入房东手机号");
			return false;
		}else if(!isMobile.test(push_mobile)){
			alert("请正确输入房东手机号");
			return false;
		}else{
			$("#btn_submitadd").unbind("click");
			$.get("/hizhu/PushSms/pushLoading.html",{push_mobile:push_mobile,push_type:push_type},function(data){
    	   	 if(data.status==200){
    	   	 	alert("推送成功");
    	   	     location.reload(); 
    	   	 }
	    	},"json");

		}
	});
	
</script>
</html>